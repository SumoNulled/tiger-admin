<?php
namespace Admin;
use App;

App\General::class_include('class.SQL.php');
App\General::class_include('class.User.php');
use Admin\User as Personnel;
class ACFT
{
  private $age_range;
  private Personnel $personnel;

  private $score_mdl;
  private $score_spt;
  private $score_hrp;
  private $score_sdc;
  private $score_plk;
  private $score_tmr;

  private $assessment_id;

  public function __construct($assessment_id = NULL)
  {
    $this->assessment_id = $assessment_id;
    $this->personnel = new Personnel;
  }

  public function get_logs_table()
  {
    return "personnel_acft_scores";
  }

  public function set_personnel_id($personnel_id)
  {
    $this->personnel->setID($personnel_id);
  }

  public function get_personnel_id()
  {
    return $this->personnel->getID();
  }

  public function set_score_mdl($score)
  {
    $this->score_mdl = $score;
  }

  public function get_score_mdl()
  {
    return $this->score_mdl ?? 0;
  }

  public function set_score_spt($score)
  {
    $this->score_spt = $score;
  }

  public function get_score_spt()
  {
    return $this->score_spt ?? 0;
  }

  public function set_score_hrp($score)
  {
    $this->score_hrp = $score;
  }

  public function get_score_hrp()
  {
    return $this->score_hrp ?? 0;
  }

  public function set_score_sdc($score)
  {

    // If score is in MM:SS format, convert it down to seconds.
    if (str_contains($score, ':'))
    {
      $score = explode(":", $score);
      $seconds = $score[0] * 60 ?? 0;
      $seconds += $score[1] ?? 0;
      $score = $seconds;
    }

    $this->score_sdc = $score;
  }

  public function get_score_sdc()
  {
    return $this->score_sdc ?? 0;
  }

  public function set_score_plk($score)
  {

    // If score is in MM:SS format, convert it down to seconds.
    if (str_contains($score, ':'))
    {
      $score = explode(":", $score);
      $seconds = $score[0] * 60 ?? 0;
      $seconds += $score[1] ?? 0;
      $score = $seconds;
    }

    $this->score_plk = $score;
  }

  public function get_score_plk()
  {
    return $this->score_plk ?? 0;
  }

  public function set_score_tmr($score)
  {

    // If score is in MM:SS format, convert it down to seconds.
    if (str_contains($score, ':'))
    {
      $score = explode(":", $score);
      $seconds = $score[0] * 60 ?? 0;
      $seconds += $score[1] ?? 0;
      $score = $seconds;
    }

    $this->score_tmr = $score;
  }

  public function get_score_tmr()
  {
    return $this->score_tmr ?? 0;
  }

  public function set_age_range($age_range)
  {
    $this->age_range = $age_range;
  }

  public function get_age_range()
  {
    $this->find_age_range();
    return $this->age_range;
  }

  public function find_age_range()
  {
    // Select the column names from the database relating to the personnel's gender.
    $sql =
    "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE
    TABLE_SCHEMA = 'theoldmountain' AND
    TABLE_NAME = 'structure_acft_standards_mdl' AND
    COLUMN_NAME != 'id' AND
    COLUMN_NAME != 'Points' AND
    COLUMN_NAME LIKE ('%{$this->personnel->gender()}%');";

    // Return an array of lower/upper age ranges and remove the gender quantifier.
    foreach(App\SQL::row($sql) as $row)
    {
      $col = $row['COLUMN_NAME'];
      $age_range[] = explode("_", trim($col, $this->personnel->gender()));
    }

    // Search through the array of lower/upper age ranges and find the personnel's age range.
    foreach($age_range as $age)
    {
      $lower = $age[0];
      $upper = $age[1];

      // Once the age range is found, print it out.
      if ($this->personnel->age() >= $lower && $this->personnel->age() <= $upper)
      {
        // Reconstruct the column name based on the personnel's gender/age range.
        $col = "{$lower}_{$upper}{$this->personnel->gender()}";
      }
    }
    $this->set_age_range($col);
  }

  public function mdl_score()
  {
    $col = $this->get_age_range();
      // Retrieve the personnel's score based on age range.
      $score =
      "SELECT MAX(`points`) FROM structure_acft_standards_mdl WHERE
      `{$col}` <= {$this->get_score_mdl()} AND
      `{$col}` != '---'
      ORDER BY CAST(`{$col}` AS UNSIGNED) DESC;";
      $score = App\SQL::fetch($score);

      // Return the personnel's score. If score is below the minimum score, score is 0.
      return $score ?? 0;
  }

  public function spt_score()
  {
    $col = $this->get_age_range();
      // Retrieve the personnel's score based on age range.
      $score =
      "SELECT MAX(`points`) FROM structure_acft_standards_spt WHERE
      `{$col}` <= {$this->get_score_spt()} AND
      `{$col}` != '---'
      ORDER BY CAST(`{$col}` AS FLOAT) DESC;";
      $score = App\SQL::fetch($score);

      // Return the personnel's score. If score is below the minimum score, score is 0.
      return $score ?? 0;
  }

  public function hrp_score()
  {
    $col = $this->get_age_range();
      // Retrieve the personnel's score based on age range.
      $score =
      "SELECT MAX(`points`) FROM structure_acft_standards_hrp WHERE
      `{$col}` <= {$this->get_score_hrp()} AND
      `{$col}` != '---'
      ORDER BY CAST(`{$col}` AS UNSIGNED) DESC;";
      $score = App\SQL::fetch($score);

      // Return the personnel's score. If score is below the minimum score, score is 0.
      return $score ?? 0;
  }

  public function sdc_score()
  {
    $col = $this->get_age_range();
      // Retrieve the personnel's score based on age range.
      $score =
      "SELECT MAX(points)
      FROM structure_acft_standards_sdc
      WHERE (SUBSTRING_INDEX({$col},':',1) * 60) + SUBSTRING_INDEX({$col},':',-1) >= {$this->get_score_sdc()}
      AND `{$col}` != '---'
      ORDER BY CAST(`{$col}` AS UNSIGNED) DESC;";
      $score = App\SQL::fetch($score);

      // Return the personnel's score. If score is below the minimum score, score is 0.
      return $score ?? 0;
  }

  public function plk_score()
  {
    $col = $this->get_age_range();
      // Retrieve the personnel's score based on age range.
      $score =
      "SELECT MAX(points)
      FROM structure_acft_standards_plk
      WHERE (SUBSTRING_INDEX({$col},':',1) * 60) + SUBSTRING_INDEX({$col},':',-1) <= {$this->get_score_plk()}
      AND `{$col}` != '---'
      ORDER BY CAST(`{$col}` AS UNSIGNED) DESC;";
      $score = App\SQL::fetch($score);

      // Return the personnel's score. If score is below the minimum score, score is 0.
      return $score ?? 0;
  }

  public function tmr_score()
  {
    $col = $this->get_age_range();
      // Retrieve the personnel's score based on age range.
      $score =
      "SELECT MAX(points)
      FROM structure_acft_standards_tmr
      WHERE (SUBSTRING_INDEX({$col},':',1) * 60) + SUBSTRING_INDEX({$col},':',-1) >= {$this->get_score_tmr()}
      AND `{$col}` != '---'
      ORDER BY CAST(`{$col}` AS UNSIGNED) DESC;";
      $score = App\SQL::fetch($score);

      // Return the personnel's score. If score is below the minimum score, score is 0.
      return $score ?? 0;
  }

  public function in_age_range()
  {
    $sql =
    "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE
    TABLE_SCHEMA = 'theoldmountain' AND
    TABLE_NAME = 'structure_acft_standards_mdl' AND
    COLUMN_NAME != 'id' AND
    COLUMN_NAME != 'Points' AND
    COLUMN_NAME LIKE ('%{$this->personnel->gender()}%');";

    foreach(App\SQL::row($sql) as $row)
    {
      echo $row['COLUMN_NAME'];
    }
  }

  public function pass()
  {
    if (
      $this->mdl_score() >= 60 &&
      $this->spt_score() >= 60 &&
      $this->hrp_score() >= 60 &&
      $this->sdc_score() >= 60 &&
      $this->plk_score() >= 60 &&
      $this->tmr_score() >= 60
    ) {
      return true;
    } else {
      return false;
    }
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

  public function personnel_count()
  {
    $result = App\SQL::fetch("SELECT COUNT('id') FROM `{$this->get_logs_table()}` WHERE assessment_id = ?", $this->assessment_id);
    return $result;
  }

  public function status_count($status)
  {
    $result = App\SQL::fetch("SELECT COUNT('id') FROM `{$this->get_logs_table()}` WHERE assessment_id = ? AND status = ?", array($this->assessment_id, $status));
    return $result;
  }

  public function pass_count()
  {
    $result = $this->status_count("1");
    return $result;
  }

  public function pass_percent()
  {
    if ($this->personnel_count() > 0)
    {
      $result = round($this->pass_count() / $this->personnel_count() * 100);
    } else {
      $result = 0;
    }

    return $result;
  }

  public function pass_average()
  {
    foreach(SQL::row("SELECT DISTINCT assessment_id FROM `personnel_acft_scores`") as $x)
    {
      $this->set_id($x['assessment_id']);
      $array[] = $this->pass_percent();
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
}
?>
