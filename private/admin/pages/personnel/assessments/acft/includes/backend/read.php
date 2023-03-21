<?php
if (isset($_GET['id']) && !(App\SQL::query("SELECT id FROM `structure_assessments` WHERE `id` = ?", $_GET['id'])->num_rows == 0))
{
    $sql = new App\SQL;
    $result = $sql->query("SELECT * FROM `structure_assessments` WHERE id = ?", $_GET['id']);
    $result->execute();
    $row = $result->get_result();

    $_ARRAY = $row->fetch_assoc();

    if(isset($_POST['submit']))
    {

        if (isset($error))
        {
          $error = Admin\Alerts::danger($error, "Error!");
          renderForm($_ARRAY, $error);
        }
        else {
          // Create arrays for the query.
          $_POST['date'] = date('Y-m-d', strtotime($_POST['date']));
          foreach($_POST as $x=>$y)
          {
            switch($x)
            {
              case "submit":
              //Do Nothing
              break;

              default:
              if (!in_array($x, $_SESSION['disabled_indexes']))
              {
                $Fields[] = "`" . $x . "` = ?";
                $Values[] = ($y != NULL) ? $y : NULL;
              }
              break;
            }
          }

          $Fields[] = "`last_edited` = ?";
          $Values[] = date("Y:m:d H:i:s");

          $Fields = implode(",", $Fields);

          $success = NULL;
          if($query = $sql->query("UPDATE `structure_assessments` SET {$Fields} WHERE id = {$_GET['id']}", $Values))
          {
            $result = $sql->query("SELECT * FROM `structure_assessments` WHERE id = ?", $_GET['id']);
            $result->execute();
            $row = $result->get_result();

            $_ARRAY = $row->fetch_assoc();

            $success = "The records for <b>" . $_ARRAY['id'] . " " . "(ID: " . $_ARRAY['id'] .")</b> " . " have been updated. Refreshing in <b><span id=\"countdown\"></span></b> seconds.";
            $success = Admin\Alerts::success($success, "Success!");
            renderForm($_ARRAY, NULL, $success);
          } else {
            echo "Error! Please contact your system administrator.";
          }
        }
    }
    elseif (!isset($_POST['submit']) && !isset($error))
    {
      renderForm($_ARRAY);
    }

}
else
{
  echo Admin\Alerts::danger("An error occured when trying to edit this assessments log. Contact your system administrator for more information.", "Oops!");
}
?>
