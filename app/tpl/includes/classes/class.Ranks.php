<?php
namespace Admin;
use App;

App\General::class_include('class.SQL.php');

class Ranks
{
    private static function get_table()
    {
        return "structure_ranks";
    }

    public static function name($id)
    {
        $result = App\SQL::fetch("SELECT title FROM " . self::get_table() . " WHERE id = ?", $id);

        return $result;
    }

    public static function grade_level($id)
    {
        $result = App\SQL::fetch("SELECT grade_level FROM " . self::get_table() . " WHERE id = ?", $id);

        return $result;
    }

    public static function abbreviation($id)
    {
        $result = App\SQL::fetch("SELECT abbreviation FROM " . self::get_table() . " WHERE id = ?", $id);

        return $result;
    }

    public static function print($id, int $case = 0)
    {
        switch($case)
        {
          case 0:
          $result = self::name($id) .  " " . "(" . self::grade_level($id) . ")";
          break;

          case 1:
          $result = self::name($id) . " " . "(" . self::abbreviation($id) . ")";
          break;

          case 2:
          $result = self::abbreviation($id) . " " . "(" . self::grade_level($id) . ")";
          break;

          default:
          $result = "Error";
          break;
        }

        return $result;
    }

    public static function get_select()
    {
      // Build the array used for selecting ranks. Format: ID%rankName.
      foreach(App\SQL::row("SELECT * FROM " . self::get_table() . "") as $row)
      {
        $array[] = $row['id'] . "%" . self::print($row['id'], 1);
      }

      return $array;
    }
}
?>
