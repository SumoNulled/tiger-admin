<?php
namespace Admin;

use App\SQL;
use App\General;

class CCFA
{
  private $id;
  private $push_ups;
  private $curl_ups;
  private $one_mile_run;

  private $gender;

  private $pu_min;
  private $cu_min;
  private $omr_min;

  public function __construct($id = null, $push_ups = null, $curl_ups = null, $one_mile_run = null, $gender = NULL)
  {
    $this->id = $id;
    $this->push_ups = $push_ups;
    $this->curl_ups = $curl_ups;
    $this->one_mile_run = $one_mile_run;
    $this->gender = $gender;
  }

  public function set_id($id)
  {
    $this->id = $id;
  }

  public function set_gender($gender)
  {
    $this->gender = $gender;
  }

  public function get_logs_table()
  {
    return "personnel_ccfa_scores";
  }

  public function get_standards_table()
  {
    return "structure_ccfa_standards";
  }

  public function get_structure_table()
  {
    return "structure_assessments";
  }

  public function get_pu_min()
  {
    $result = SQL::Fetch("SELECT `push_ups` FROM {$this->get_standards_table()} WHERE gender = ?", $this->gender);
    return $result;
  }

  public function get_cu_min()
  {
    $result = SQL::fetch("SELECT `curl_ups` FROM {$this->get_standards_table()} WHERE gender = ?", $this->gender);
    return $result;
  }

  public function get_omr_min()
  {
    //$result = SQL::Fetch("SELECT `one_mile_run` FROM {$this->get_standards_table()} WHERE gender = ?", $this->gender);
    $result = SQL::Fetch("SELECT (SUBSTRING_INDEX(one_mile_run,':',1) * 60) + SUBSTRING_INDEX(one_mile_run,':',-1) FROM structure_ccfa_standards WHERE gender = ?", $this->gender);
    return $result;
  }

  public function set_push_ups($push_ups)
  {
    $this->push_ups = $push_ups;
  }

  public function get_push_ups()
  {
    return $this->push_ups;
  }

  public function pass_push_ups()
  {
    if ($this->push_ups >= $this->get_pu_min())
    {
      return true;
    }

    return false;
  }

  public function set_curl_ups($curl_ups)
  {
    $this->curl_ups = $curl_ups;
  }

  public function get_curl_ups()
  {
    return $this->curl_ups;
  }

  public function pass_curl_ups()
  {
    if ($this->curl_ups >= $this->get_cu_min())
    {
      return true;
    }
    return false;
  }

  public function set_one_mile_run($one_mile_run)
  {
    if (str_contains($one_mile_run, ':'))
    {
      $one_mile_run = explode(":", $one_mile_run);
      $seconds = $one_mile_run[0] * 60 ?? 0;
      $seconds += $one_mile_run[1] ?? 0;
      $one_mile_run = $seconds;
    }

    $this->one_mile_run = $one_mile_run;
  }

  public function get_one_mile_run()
  {
    return $this->one_mile_run;
  }

  public function pass_one_mile_run()
  {
    if ($this->one_mile_run <= $this->get_omr_min())
    {
      return true;
    }

    return false;
  }

  public function pass()
  {
    if ($this->pass_push_ups() && $this->pass_curl_ups() && $this->pass_one_mile_run())
    {
      return true;
    }

    return false;
  }

  public function get_for_record()
  {

  }

  public function personnel_count()
  {
    $result = SQL::fetch("SELECT COUNT('id') FROM `{$this->get_logs_table()}` WHERE assessment_id = ?", $this->id);
    return $result;
  }

  public function status_count($status)
  {
    $result = SQL::fetch("SELECT COUNT('id') FROM `{$this->get_logs_table()}` WHERE assessment_id = ? AND status = ?", array($this->id, $status));
    return $result;
  }

  public function record_pass()
  {
    $result = $this->status_count("1");
    return $result;
  }

  public function record_pass_percent()
  {
    if ($this->personnel_count() > 0)
    {
      $result = round($this->record_pass() / $this->personnel_count() * 100);
    } else {
      $result = 0;
    }

    return $result;
  }

  public function record_pass_average()
  {
    foreach(SQL::row("SELECT DISTINCT assessment_id FROM `personnel_ccfa_scores`") as $x)
    {
      $this->set_id($x['assessment_id']);
      $array[] = $this->record_pass_percent();
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

  public function print_status($status)
  {
    switch($status)
    {
      case 1:
      $result = "<b><font color='green'>GO</font>";
      break;

      case 0:
      $result = "<b><font color='red'>NO-GO</font>";
      break;
    }

    return $result;
  }

  public function print_manage($id)
  {
    $delete = "<i class=\"material-icons\">delete</i>";
    $result = General::anchor(
    $delete,
    General::getAdminRoot() . "pages/personnel/assessments/ccfa/includes/backend/delete.php?id=" . $id);

    return $result;
  }
}
?>
