<?php
namespace App;

General::class_include('class.Locations.php');

class Weather
{
    private $id;
    private $location;

    function __construct($id = null, int $location_id = NULL)
    {
      $this->id = $id;
      $this->location = new Locations($location_id);
    }

    public function setID($id)
    {
      $this->id = $id;
    }

    public function getID()
    {
      return $this->id;
    }

    private function get_table()
    {
      return "intelligence_weather_forecasts";
    }

    public function location_name()
    {
      $sql = SQL::fetch("SELECT `location_id` FROM " . $this->get_table() . " WHERE id = ?", $this->getID());
      $result = NULL != $sql ? $sql : "";

      $this->location->setID($result);
      $result = $this->location->name();

      return $result;
    }

    public function temperature()
    {
      $sql = SQL::fetch("SELECT `temperature` FROM " . $this->get_table() . " WHERE id = ?", $this->getID());
      $result = NULL != $sql ? $sql : "";

      return $result;
    }

    public function short_forecast()
    {
      $sql = SQL::fetch("SELECT `short_forecast` FROM " . $this->get_table() . " WHERE id = ?", $this->getID());
      $result = NULL != $sql ? $sql : "";

      return $result;
    }

    public function detailed_forecast()
    {
      $sql = SQL::fetch("SELECT `detailed_forecast` FROM " . $this->get_table() . " WHERE id = ?", $this->getID());
      $result = NULL != $sql ? $sql : "";

      return $result;
    }

    public function wind_speed()
    {
      $sql = SQL::fetch("SELECT `wind_speed` FROM " . $this->get_table() . " WHERE id = ?", $this->getID());
      $result = NULL != $sql ? $sql : "";

      return $result;
    }

    public function wind_direction()
    {
      $sql = SQL::fetch("SELECT `wind_direction` FROM " . $this->get_table() . " WHERE id = ?", $this->getID());
      $result = NULL != $sql ? $sql : "";

      return $result;
    }

    public function timestamp()
    {
      $sql = SQL::fetch("SELECT `timestamp` FROM " . $this->get_table() . " WHERE id = ?", $this->getID());
      $result = NULL != $sql ? $sql : "";

      return $result;
    }
}
?>
