<?php
namespace Admin;
use App;

App\General::class_include('class.Ranks.php');

class Positions
{
    private static function get_table()
    {
        return "structure_positions";
    }

    public static function get_position_of($user_id)
    {
      $primary_position = App\SQL::fetch("SELECT `position` FROM personnel WHERE id = ?", $user_id);
      $additional_positions = App\SQL::fetch("SELECT `additional_positions` FROM personnel WHERE id = ?", $user_id);
      $positions = [];
      array_push($positions, $primary_position, ...explode(",", $additional_positions));
      return $positions;
    }

    public static function ID($title)
    {
        $result = App\SQL::fetch("SELECT `id` FROM " . self::get_table() . " WHERE title = ?", $title);

        return $result;
    }

    public static function name($id)
    {
        $result = App\SQL::fetch("SELECT `title` FROM " . self::get_table() . " WHERE id = ?", $id);

        return $result;
    }

    public static function abbreviation($id)
    {
        $result = App\SQL::fetch("SELECT `abbreviation` FROM " . self::get_table() . " WHERE id = ?", $id);

        return $result;
    }

    public static function rank($id)
    {
        $result = App\SQL::fetch("SELECT `rank` FROM " . self::get_table() . " WHERE id = ?", $id);

        return $result;
    }

    public static function print($id, int $case = 0)
    {
        switch($case)
        {
          case 0:
          $result = self::name($id) . " " . "(" . self::abbreviation($id) . ")";
          break;

          case 1:
          $result = self::name($id) . " " . "(" . Ranks::name(self::rank($id)) . ")";
          break;

          case 2:
          $result = self::name($id) . " " . "(" . Ranks::abbreviation(self::rank($id)) . ")";
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
        $array[] = $row['id'] . "%" . self::print($row['id']);
      }

      return $array;
    }
}
?>
