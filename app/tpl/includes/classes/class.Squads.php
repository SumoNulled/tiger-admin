<?php
namespace Admin;
use App;
use \NumberFormatter;

App\General::class_include('class.User.php');

class Squads
{
    private static function get_table()
    {
      return 'structure_squads';
    }

    private static function get_parent()
    {
      return 'platoon_id';
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

    public static function get_squad_leader($squad_id)
    {
      $row = App\SQL::row("SELECT id FROM personnel WHERE position = ? AND squad = ?", array(Positions::ID('Squad Leader'), $squad_id));

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

    public static function get_select()
    {
      // Build the array used for selecting squads. Format: ID%squadName.
      foreach(App\SQL::row("SELECT * FROM " . self::get_table() . "") as $row)
      {
        $array[] = $row['id'] . "%" . self::print($row['id'], 2);
      }

      return $array;
    }

    public static function get_select_manual()
    {
      // Manually create the array for selecting a squad. Format: ID%squadName
      $formatter = new \NumberFormatter('en-US', \NumberFormatter::SPELLOUT);
      $formatter->setTextAttribute(\NumberFormatter::DEFAULT_RULESET, "%spellout-ordinal");

      $squads = [1,2,3,4];

      foreach($squads as $x)
      {
        $array[] = $x . "%" . ucwords($formatter->format($x) . " " . "Squad");
      }

      return $array;
    }

    public static function get_squads($platoon)
    {
      // Build the array used for selecting squads.
      $array = array();

      foreach(App\SQL::row("SELECT * FROM " . self::get_table() . " WHERE platoon_id = '" . $platoon . "'") as $row)
      {
        $array[] = $row['id'];
      }

      return $array;
    }

    public static function print_squad_leader($squad_id, $case = 0)
    {
      $squad_leader = self::get_squad_leader($squad_id);
      switch($case)
      {
        case 0:
        $result = implode(",",$squad_leader);
        break;

        case 1:
        $result = "<h4 style=\"display: inline\">";
        $result .= "<span class=\"label bg-brown\">";
        $result .= "Squad Leader: ";
        if (NULL !== $squad_leader && sizeof($squad_leader) > 0)
        {
          $user = new User();

          for ($i = 0; $i < sizeof($squad_leader); $i++)
          {
            $user->setID($squad_leader[$i]);
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
            $result = self::name($id) . " " . "Squad";
            break;

            case 1:
            $result = self::name($id) . " " . "(" . self::abbreviation($id) . ")" . " Squad";
            break;

            case 2:
            $result = self::name($id) . " " . "Squad" . " " . "(" . Platoons::print(self::parent($id), 3) . ")";
            break;

            case 3:
            $result = self::abbreviation($id) . " SQD";
            break;

            default:
            $result = "Error";
            break;
        }

        return $result;
    }
}
?>
