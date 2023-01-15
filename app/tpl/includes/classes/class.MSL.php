<?php
namespace Admin;
use App;

class MSL
{

  public static function get_table()
  {
    return 'structure_msl';
  }

  public static function get_select()
  {
    // Build the array used for selecting ranks. Format: ID%rankName.
    foreach(App\SQL::row("SELECT * FROM " . self::get_table() . "") as $row)
    {
      $array[] = $row['id'] . "%" . $row['abbreviation'];
    }

    return $array;
  }

  public static function abbreviation($id)
  {
    $abbreviation = App\SQL::fetch("SELECT abbreviation FROM " . self::get_table() . " WHERE id = ?", $id);

    return $abbreviation;
  }
}
?>
