<?php
namespace Admin;
use App;

class Platoons
{
    public static function get_table()
    {
      return 'structure_platoons';
    }

    private static function get_parent()
    {
      return 'company_id';
    }

    public static function parent($id)
    {
      $result = App\SQL::fetch("SELECT " . self::get_parent() . " FROM " . self::get_table() . " WHERE id = ?", $id);

      return $result;
    }

    public static function name($id)
    {
      $result = App\SQL::fetch("SELECT name FROM " . self::get_table() . " WHERE id = ?", $id);

      return $result;
    }

    public static function abbreviation($id)
    {
      $result = App\SQL::fetch("SELECT abbreviation FROM " . self::get_table() . " WHERE id = ?", $id);

      return $result;
    }

    public static function motto($id)
    {
      $result = App\SQL::fetch("SELECT motto FROM " . self::get_table() . " WHERE id = ?", $id);

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

    public static function get_platoon_leader($platoon_id)
    {
      $row = App\SQL::row("SELECT id FROM personnel WHERE position = ? AND platoon = ?", array(Positions::ID('Platoon Leader'), $platoon_id));

      $result = array();

      if($row !== false)
      {
          foreach($row as $key)
          {
            $result[] = $key['id'];
          }
      }

      return $result;
    }

    public static function get_platoon_sergeant($platoon_id)
    {
      $row = App\SQL::row("SELECT id FROM personnel WHERE position = ? AND platoon = ?", array(Positions::ID('Platoon Sergeant'), $platoon_id));

      $result = array();

      if($row !== false)
      {
          foreach($row as $key)
          {
            $result[] = $key['id'];
          }
      }

      return $result;
    }

    public static function print_platoon_leader($platoon_id, $case = 0)
    {
      $platoon_leader = self::get_platoon_leader($platoon_id);
      switch($case)
      {
        case 0:
        $result = implode(",",$platoon_leader);
        break;

        case 1:
        $result = "<h4 style=\"display: inline\">";
        $result .= "<span class=\"label bg-brown\">";
        $result .= "Platoon Leader: ";
        if (NULL !== $platoon_leader && sizeof($platoon_leader) > 0)
        {
          $user = new User();

          for ($i = 0; $i < sizeof($platoon_leader); $i++)
          {
            $user->setID($platoon_leader[$i]);
            $result .= $user->print_name();
          }

        } else {
            $result .= "VACANT";
        }
        $result .= "</span> ";
        $result .= "</h4>";
        break;
      }

      return $result;
    }

    public static function print_platoon_sergeant($platoon_id, $case = 0)
    {
      $platoon_sergeant = self::get_platoon_sergeant($platoon_id);
      switch($case)
      {
        case 0:
        $result = implode(",",$platoon_sergeant);
        break;

        case 1:
        $result = "<h4 style=\"display: inline\">";
        $result .= "<span class=\"label bg-brown\">";
        $result .= "Platoon Sergeant: ";
        if (NULL !== $platoon_sergeant && sizeof($platoon_sergeant) > 0)
        {
          $user = new User();

          for ($i = 0; $i < sizeof($platoon_sergeant); $i++)
          {
            $user->setID($platoon_sergeant[$i]);
            $result .= $user->print_name();
          }

        } else {
            $result .= "VACANT";
        }
        $result .= "</span> ";
        $result .= "</h4>";
        break;
      }

      return $result;
    }

    public static function print($id, int $case = 0)
    {
        switch($case)
        {
            case 0:
            $result = self::name($id) . " " . "Platoon";
            break;

            case 1:
            $result = self::abbreviation($id) . " " . "Platoon";
            break;

            case 2:
            $result = self::name($id) . " " . "(" . self::abbreviation($id) . ")" . " Platoon";
            break;

            case 3:
            $result = self::abbreviation($id) . " " . "PLT";
            break;

            default:
            $result = "Error";
            break;
        }

        return $result;
    }
}
?>
