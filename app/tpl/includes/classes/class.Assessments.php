<?php
namespace Admin;

use App\General;

class Assessments
{
  private $id;
  private $type;
  private $description;
  private $record;
  private $oic;
  private $ncoic;
  private $date;

  public function __construct($id = NULL)
  {
    $this->id = $id;
  }

  public function get_table()
  {
    return "structure_assessments";
  }

  public function set_id($id)
  {
    $this->id = $id;
  }

  public function get_id()
  {
    return $this->id;
  }

  public function print_manage()
  {
    $edit = "<i class=\"material-icons\">mode_edit</i>";
    $view = "<i class=\"material-icons\">visibility</i>";
    $result = General::anchor(
      $view,
      General::getAdminRoot() . "pages/personnel/assessments/ccfa/read.php?id=" . $this->id
    );
    $result .= General::anchor(
      $edit,
      General::getAdminRoot() . "pages/personnel/assessments/ccfa/edit.php?id=" . $this->id
    );

    return $result;
  }
}
?>
