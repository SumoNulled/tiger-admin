<?php
namespace Admin;
use App\SQL;
use App\General;

class Attendance
{
  private $id;
  private $mandatory;

  public function __construct($id = null)
  {
    $this->id = $id;
    if ($sql = SQL::row("SELECT cadet_id FROM personnel_attendance WHERE cadet_id NOT IN (SELECT id FROM personnel)"))
    {
      foreach($sql as $row)
      {
        $stray[] = $row['cadet_id'];
      }

      foreach($stray as $x)
      {
        $parameters[] = "?";
      }

      $parameters = implode(",", $parameters);

      SQL::query("DELETE FROM personnel_attendance WHERE cadet_id IN ({$parameters})", array(...$stray));
    }
  }

  public function get_table()
  {
    return "structure_attendance";
  }

  public function get_logs_table()
  {
    return "personnel_attendance";
  }

  public function set_id($id)
  {
    $this->id = $id;
  }

  public function get_id()
  {
    return $this->id;
  }

  public function get_mandatory()
  {
    $result = SQL::fetch("SELECT `mandatory` FROM " . self::get_table() . " WHERE id = ?", $this->id);

    return $result;
  }

  public function print_mandatory()
  {
    switch($this->get_mandatory())
    {
      case 1:
      $result = "Mandatory";
      break;

      default:
      $result = "Optional";
      break;
    }

    return $result;
  }

  public function personnel_count()
  {
    $result = SQL::fetch("SELECT COUNT('id') FROM " . self::get_logs_table() . " WHERE attendance_id = ?", $this->id);
    return $result;
  }

  public function status_count($status)
  {
    $result = SQL::fetch("SELECT COUNT('id') FROM " . self::get_logs_table() . " WHERE attendance_id = ? AND status = ?", array($this->id, $status));
    return $result;
  }

  public function in_attendance()
  {
    $result = self::status_count("present") + self::status_count("excused") + self::status_count("tardy");
    return $result;
  }

  public function in_attendance_percent()
  {
    $result = round(self::in_attendance() / self::personnel_count() * 100);
    return $result;
  }

  public function average()
  {
    foreach(SQL::row("SELECT DISTINCT attendance_id FROM personnel_attendance") as $x)
    {
      $this->set_id($x['attendance_id']);
      if (self::get_mandatory())
      {
        $array[] = self::in_attendance_percent();
      }
    }

    $array = array_filter($array);
    if (count($array) > 0)
    {
      $result = array_sum($array)/count($array);
    } else {
      $result = 0;
    }

    return $result;
  }

  public function get_present()
  {
    if ($sql = SQL::row("SELECT cadet_id FROM " . self::get_logs_table() . " WHERE attendance_id = ? AND status = 'PRESENT'", $this->id))
    {
      foreach ($sql as $row)
      {
        $result[] = $row['cadet_id'];
      }
    }
    return isset($result) ? $result : array();
  }

  public function get_tardy()
  {
    if ($sql = SQL::row("SELECT cadet_id FROM " . self::get_logs_table() . " WHERE attendance_id = ? AND status = 'TARDY'", $this->id))
    {
      foreach ($sql as $row)
      {
        $result[] = $row['cadet_id'];
      }
    }
    return isset($result) ? $result : array();
  }

  public function get_absent()
  {
    if ($sql = SQL::row("SELECT cadet_id FROM " . self::get_logs_table() . " WHERE attendance_id = ? AND status = 'ABSENT'", $this->id))
    {
      foreach ($sql as $row)
      {
        $result[] = $row['cadet_id'];
      }
    }
    return isset($result) ? $result : array();
  }

  public function print_manage()
  {
    $edit = "<i class=\"material-icons\">mode_edit</i>";
    $result = General::anchor(
    $edit,
    General::getAdminRoot() . "pages/personnel/attendance/edit.php?id=" . $this->id);

    return $result;
  }
}
?>
