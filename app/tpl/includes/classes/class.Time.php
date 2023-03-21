<?php
namespace App;
class Time
{
  private $time;
  private $year;
  private $month;
  private $day;

  private $hours;
  private $minutes;
  private $seconds;
  private $time_of_day;

  public function __construct($time)
  {
    $this->time = strtotime($time);

    $this->year = date('Y', $this->time);
    $this->month = date('m', $this->time);
    $this->day = date('d', $this->time);

    $this->hours = date('H', $this->time);
    $this->minutes = date('i', $this->time);
    $this->seconds = date('s', $this->time);
    $this->time_of_day = date('a', $this->time);
  }

  public function get_time()
  {
    return $this->time;
  }

  public function get_month()
  {
    return $this->month;
  }

  public function get_day()
  {
    return $this->day;
  }

  public function set_hours($hours)
  {
    $this->hours = $hours;
  }

  public function get_hours()
  {
    return $this->hours;
  }

  public function set_minutes($minutes)
  {
    $this->minutes = $minutes;
  }

  public function get_minutes()
  {
    return $this->minutes;
  }

  public function set_seconds($seconds)
  {
    $this->seconds = $seconds;
  }

  public function get_seconds()
  {
    return $this->seconds;
  }

  public function print_time($case = 0)
  {
    switch($case)
    {
      case 0:
      $result = $this->hours . ":" . $this->minutes;
      break;
    }
    return $result;
  }

  public function print_date($case = 0)
  {
    switch($case)
    {
      case 0:
      $result = date('F', $this->get_time()) . " " . date('jS', $this->time) . ", " . $this->year;
      break;
    }

    return $result;
  }
}
?>
