<?php
namespace Admin;
use App\General;

class Tables
{
  private $tableSize;

  private $tableName;
  private $tableMenu;

  private $tableHead;
  private $tableFooter;

  private $rows;

  function __construct()
  {
    $tableSize = "12";
    $this->tableSize = $tableSize;
    $this->tableHead = array();
    $this->tableFooter = false;
    $this->rows = array();
  }

  public function set_table_size($tableSize)
  {
    $this->tableSize = $tableSize;
  }

  public function get_table_size()
  {
    return $this->tableSize;
  }

  public function set_table_name($tableName)
  {
    $this->tableName = $tableName;
  }

  public function get_table_name()
  {
    return $this->tableName;
  }

  public function set_table_menu($tableMenu)
  {
    $this->tableMenu = $tableMenu;
  }

  public function get_table_menu()
  {
    if ($this->tableMenu)
    {
    return '<ul class="header-dropdown m-r--5">
          <li class="dropdown">
              <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">more_vert</i>
              </a>
              <ul class="dropdown-menu pull-right">
                  <li><a href="javascript:void(0);">Action</a></li>
                  <li><a href="javascript:void(0);">Another action</a></li>
                  <li><a href="javascript:void(0);">Something else here</a></li>
              </ul>
          </li>
      </ul>';
    }
  }

  public function set_table_head($tableHead)
  {
    // Name, Position, Office, Age, Start Date, Salary
    $tableHead = explode(",",$tableHead);
    $this->tableHead = $tableHead;
  }

  public function get_table_head()
  {
    return $this->tableHead;
  }

  public function set_table_footer($tableFooter)
  {
    $this->tableFooter = $tableFooter;
  }

  public function get_table_footer()
  {
    if($this->tableFooter)
    {
      return $this->get_table_head();
    } else {
      return array();
    }
  }

  public function add_table_row($data)
  {
    $row = "";

    if (is_string($data))
    {
      $data = explode(",", $data);
    }

    if (is_array($data))
    {
      for($i = 0; $i < sizeof($data); $i++)
      {
        // Building a string of data cells for the table row.
        $row .= "<td>" . $data[$i] . "</td>";
      }
    }

    // Finalize the table row.
    $row = "<tr>" . $row . "</tr>";

    // Put the row into the array.
    array_push($this->rows, $row);
  }

  public function add_manage_user($id)
  {
    $user = new User;
    $user->setID($id);

    $manage = array();

    $edit = "<i class=\"material-icons\">mode_edit</i>";
    $manage[] = General::anchor($edit, General::getAdminRoot() . "pages/personnel/cadets/edit.php?id=" . $id);

    switch($user->active())
    {
      case 1:
        $status = "<i class=\"material-icons\">delete</i>";
        $confirm = "You are about to deactivate the profile for {$user->print_name()} (ID:{$user->getID()}). You will be able to reactivate it at any time.";
      break;

      default:
        $status = "<i class=\"material-icons\">change_circle</i>";
        $confirm = "Are you sure you want to reactivate the profile for {$user->print_name()} (ID:{$user->getID()})?";
      break;
    }

    $manage[] = General::anchor(
    $status,
    General::getAdminRoot() . "pages/personnel/cadets/includes/backend/status.php?id=" . $id,
    "return confirm(\"". $confirm ."\")");

    $manage = implode("", $manage);

    return $manage;
  }

  public function get_table_rows()
  {
    return $this->rows;
  }

  public function print()
  {
    $result = "";
    $result .='<!-- Exportable Table -->';
    $result .='<div class="table-responsive">';
      $result .='<table class="table table-bordered table-striped table-hover dataTable js-exportable">';

        $result .='<thead>';
        $result .='<tr>';
        for($i = 0; $i < sizeof($this->get_table_head()); $i++)
        {
          if (str_contains($this->get_table_head()[$i], "@"))
          {
            $array = explode("@", $this->get_table_head()[$i]);
            $result .= '<th colspan = ' . $array[1] . '>' . $array[0] . '</th>';
          }
          else {
            $result .='<th>' . $this->get_table_head()[$i] . '</th>';
          }
        }
        $result .='</tr>';
        $result .='</thead>';

        $result .='<tfoot>';
        for($i = 0; $i < sizeof($this->get_table_footer()); $i++)
        {
          $result .='<th>' . $this->get_table_footer()[$i] . '</th>';
        }
        $result .='</tfoot>';

          $result .='<tbody>';
            for($i = 0; $i < sizeof($this->get_table_rows()); $i++)
            {
              $result .= $this->get_table_rows()[$i];
            }
          $result .='</tbody>';

      $result .='</table>';
    $result .='</div>';
    $result .='<!-- #END# Exportable Table -->';

    return $result;
  }
}
?>
