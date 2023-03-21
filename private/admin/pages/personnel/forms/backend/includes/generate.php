<?php

function download($file_name, $merged_file_path)
{
  header("Pragma: public");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Content-type: application/octet-stream");
  header("Content-Disposition: attachment; filename=\"{$file_name}\"");
  header("Content-Transfer-Encoding: Binary");
  // make sure the file size isn't cached
  clearstatcache();
  header("Content-length: " . @filesize($merged_file_path));
  header("Connection: close");
  // output the file
  readfile("$merged_file_path");
}

function FDF($template)
{
  $template = "%FDF-1.2
  %âãÏÓ
  1 0 obj
  <<
  /FDF
  <<
  /Fields [
  {$template}
  ]
  >>
  >>
  endobj
  trailer

  <<
  /Root 1 0 R
  >>
  %%EOF
  ";

  return $template;
}

$directory = "/var/www/tigerbn/private/admin/pages/personnel/forms/Temp/";

App\General::class_include('class.SQL.php');
App\General::class_include('class.User.php');
App\General::class_include('Pdf.php', 'PDF/vendor/mikehaertl/php-pdftk/src');

use mikehaertl\pdftk\Pdf as PDF;

$user = new Admin\User;

$_FILES["file"]["name"] = isset($_FILES["file"]["name"]) ? substr($_FILES["file"]["name"], 0, strpos($_FILES["file"]["name"], ".")) : '';
$_FILES["file"]["tmp_name"] = isset($_FILES["file"]["tmp_name"]) ? $_FILES["file"]["tmp_name"] : '';

$temp = tempnam(sys_get_temp_dir(), "FOO");
$handle = fopen($temp, "w");
exec("pdftk {$_FILES["file"]["tmp_name"]} cat output " . $temp . '.pdf' . "");
fclose($handle);
// do something here

//unlink($tmpfname);
$pdf = new PDF($_FILES["file"]["tmp_name"]);
$pdf->allow('AllFeatures') // Remove all restrictions from the PDF, allowing you to use any PDF.
    ->flatten()
    ->dropXfa()
    ->dropXmp()
    ->needAppearances();

exec("pdftk {$_FILES["file"]["tmp_name"]} dump_data_fields", $output, $return); // Put the fields from FDF into a variable.

$temp_file = $temp . '.pdf';
// Debugging
function debug() {
  print_r($output);
  echo $return;
  print_r('Name: ' . $_FILES["file"]["name"]);
}

// debug();

if (!empty($temp_file))
{
  $field_names = array();
  $Fields = array();
  $fields = array();
  foreach($output as $value)
  {
    if (str_contains($value, "FieldName:")) {
      //$field_names[] = str_replace(' ', '-', substr($value, strpos($value, ": ")+1));
      $field_names[] = rtrim(ltrim(substr($value, strpos($value, ": ")+1)));
    }
  }

  // If /T() fields from .fdf match pre-set templates from database, extract the code value.
  foreach(App\SQL::row('SELECT * FROM forms_field_templates') as $row)
  {
    if (in_array($row['field_name'], $field_names))
    {
    $Fields[$row['field_name']] = $row['code_value'];
    }

    $alt_field_names = explode(";", $row['alt_field_names']);

    foreach($alt_field_names as $alt)
    {
      if(in_array($alt, $field_names))
      {
        $Fields[$alt] = $row['code_value'];
      }
    }
  }

  if (isset($_POST['id']))
  {
    $it = new MultipleIterator();
    $it->attachIterator(new ArrayIterator($_POST['id'])); // 0

    foreach($it as $x)
    {
      $template = array();
      $user->setID($x[0]);
      // Convert the fields into /T() /V() format to be included in fdf.
      foreach($Fields as $key => $value)
      {
        $template[] = "<<" . " " . "/T ({$key})" . " " . "/V (" . eval("return $value;") . ")" . " " . ">>";
      }

      if (!empty($template) && isset($template))
      {
        $template = isset($template) ? implode("\r\n", $template) : '';
        $fields[$user->getID()][] = FDF($template); // Create an FDF for the current user.
      } else {
        // print "There are no available templates.";
      }

      unset($template);
    }

    array_map( 'unlink', array_filter((array) glob("{$directory}*") ) );

    foreach ($fields as $key=>$value)
    {
        $user->setID($key);
        $FDF = tempnam(sys_get_temp_dir(), 'FDF');
        $status = file_put_contents($FDF.'.fdf', $value[0]);
        //rename($FDF.'.fdf', "/var/www/tigerbn/private/admin/pages/personnel/forms/CCFA_8-29/data.fdf");
        if ($status)
        {
          $path = $FDF.'.fdf';
          $prefix = substr($_FILES["file"]["name"], 0, 3);
          @exec("pdftk {$temp_file} fill_form {$path} output {$directory}{$prefix}-{$user->last_name()}-{$user->first_name()}.pdf;");

          //echo fread($FDF, 1024);
          unlink($FDF);//to delete an empty file that tempnam creates
          unlink($FDF.'.fdf');//to delete your file
        } else {
          return "Failure.";
        }
    }
    @exec("cd {$directory}; pdftk {$prefix}-*.pdf cat output 01A-{$prefix}-MERGED.pdf; zip -Z store -r {$prefix}.zip .");
  }

  if (!empty($fields) || !isset($fields))
  {
    $file_name = "${prefix}-MERGED.pdf";
    $merged_file_path = "{$directory}01A-{$prefix}-MERGED.pdf";
  } else {
    $file_name = "{$_FILES["file"]["name"]}-Unlocked.pdf";
    $merged_file_path = $temp_file;
  }

  download($file_name, $merged_file_path);

  array_map( 'unlink', array_filter((array) glob("{$directory}*") ) );
  unlink($temp);
  unlink($temp_file);
}
?>
