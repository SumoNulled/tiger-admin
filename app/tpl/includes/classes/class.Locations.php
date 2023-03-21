<?php
namespace App;
General::class_include('class.SQL.php');

class Locations
{
    private $id;

    function __construct($id = null)
    {
      $this->id = $id;
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
      return "intelligence_locations";
    }

    private static function table()
    {
      return "intelligence_locations";
    }

    public function id($location_name)
    {
      $sql = SQL::fetch("SELECT `id` FROM " . $this->get_table() . " WHERE location_name = ?", $location_name);
      $result = NULL != $sql ? $sql : "";

      return $result;
    }

    public function name()
    {
      $sql = SQL::fetch("SELECT `location_name` FROM " . $this->get_table() . " WHERE id = ?", $this->getID());
      $result = NULL != $sql ? $sql : "";

      return $result;
    }

    public function description()
    {
      $sql = SQL::fetch("SELECT `location_description` FROM " . $this->get_table() . " WHERE id = ?", $this->getID());
      $result = NULL != $sql ? $sql : "";

      return $result;
    }

    public function address()
    {
      $sql = SQL::fetch("SELECT `address` FROM " . $this->get_table() . " WHERE id = ?", $this->getID());
      $result = NULL != $sql ? $sql : "";

      return $result;
    }

    public function longitude()
    {
      $sql = SQL::fetch("SELECT `longitude` FROM " . $this->get_table() . " WHERE id = ?", $this->getID());
      $result = NULL != $sql ? $sql : "";

      return $result;
    }

    public function latitude()
    {
      $sql = SQL::fetch("SELECT `latitude` FROM " . $this->get_table() . " WHERE id = ?", $this->getID());
      $result = NULL != $sql ? $sql : "";

      return $result;
    }

    public static function get_select()
    {
      // Build the array used for selecting ranks. Format: ID%locationName.
      foreach(SQL::row("SELECT * FROM " . self::table() . "") as $row)
      {
        $array[] = $row['id'] . "%" . $row['location_name'];
      }

      return $array;
    }
}
?>
