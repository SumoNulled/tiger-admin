<?php
namespace Admin;
use App;

App\General::class_include('class.User.php');

class Teams
{
    private static function get_table()
    {
      return 'structure_teams';
    }

    private static function get_parent()
    {
      return 'squad_id';
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

    public static function get_team_leader($id)
    {
        $row = App\SQL::row("SELECT id FROM personnel WHERE position = ? AND team = ?", array(Positions::ID('Team Leader'), $id));

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
      // Build the array used for selecting ranks. Format: ID%rankName.
      foreach(App\SQL::row("SELECT * FROM " . self::get_table() . "") as $row)
      {
        $array[] = $row['id'] . "%" . self::print($row['id'], 2);
      }

      return $array;
    }

    public static function print_team_leader($squad_id, $case = 0)
    {
        $team_leader = self::get_team_leader($squad_id);
        switch($case)
        {
          case 0:
          $result = implode(",",$team_leader);
          break;

          case 1:
          $result = "<h4 style=\"display: inline\">";
          $result .= "<span class=\"label bg-brown\">";
          $result .= "Team Leader: ";
          if (NULL !== $team_leader && sizeof($team_leader) > 0)
          {
            $user = new User();

            for ($i = 0; $i < sizeof($team_leader); $i++)
            {
              $user->setID($team_leader[$i]);
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
            $result = self::name($id) . " " . "Team";
            break;

            case 1:
            $result = self::name($id) . " " . "(" . self::abbreviation($id) . ")" . " Team";
            break;

            case 2:
            $result = self::name($id) . " " . "Team" . " " . "(" . Squads::print(self::parent($id), 3) . ")";
            break;

            default:
            $result = "Error";
            break;
        }

        return $result;
    }
}
?>
