<?php
namespace Admin;
use App;

class Battalions
{
    public static function get_table()
    {
      return 'structure_battalions';
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

    public static function get_battalion_commander($battalion_id)
    {
      $row = App\SQL::row("SELECT id FROM personnel WHERE position = ? AND battalion = ?", array(Positions::ID('Battalion Commander'), $battalion_id));

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

    public static function get_battalion_xo($battalion_id)
    {
      $row = App\SQL::row("SELECT id FROM personnel WHERE position = ? AND battalion = ?", array(Positions::ID('Battalion Executive Officer'), $battalion_id));

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

    public static function get_battalion_csm($battalion_id)
    {
      $row = App\SQL::row("SELECT id FROM personnel WHERE position = ? AND battalion = ?", array(Positions::ID('Command Sergeant Major'), $battalion_id));

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

    public static function print_battalion_csm($battalion_id, $case = 0)
    {
      $battalion_csm = self::get_battalion_csm($battalion_id);
      switch($case)
      {
        case 0:
        $result = implode(",",$battalion_csm);
        break;

        case 1:
        $result = "<h4 style=\"display: inline\">";
        $result .= "<span class=\"label bg-brown\">";
        $result .= "Battalion CSM: ";
        if (NULL !== $battalion_csm && sizeof($battalion_csm) > 0)
        {
          $user = new User();

          for ($i = 0; $i < sizeof($battalion_csm); $i++)
          {
            $user->setID($battalion_csm[$i]);
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

    public static function print_battalion_xo($battalion_id, $case = 0)
    {
      $battalion_xo = self::get_battalion_xo($battalion_id);
      switch($case)
      {
        case 0:
        $result = implode(",",$battalion_xo);
        break;

        case 1:
        $result = "<h4 style=\"display: inline\">";
        $result .= "<span class=\"label bg-brown\">";
        $result .= "Battalion XO: ";
        if (NULL !== $battalion_xo && sizeof($battalion_xo) > 0)
        {
          $user = new User();

          for ($i = 0; $i < sizeof($battalion_xo); $i++)
          {
            $user->setID($battalion_xo[$i]);
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

    public static function print_battalion_commander($battalion_id, $case = 0)
    {
      $battalion_commander = self::get_battalion_commander($battalion_id);
      switch($case)
      {
        case 0:
        $result = implode(",",$battalion_commander);
        break;

        case 1:
        $result = "<h4 style=\"display: inline\">";
        $result .= "<span class=\"label bg-brown\">";
        $result .= "Battalion Commander: ";
        if (NULL !== $battalion_commander && sizeof($battalion_commander) > 0)
        {
          $user = new User();

          for ($i = 0; $i < sizeof($battalion_commander); $i++)
          {
            $user->setID($battalion_commander[$i]);
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
            $result = self::name($id) . " " . "Battalion";
            break;

            case 1:
            $result = self::name($id) . " " . "(" . self::abbreviation($id) . ")" . " Battalion";
            break;

            case 2:
            $result = self::abbreviation($id) . " BN";
            break;

            default:
            $result = "Error";
            break;
        }

        return $result;
    }
}
?>
