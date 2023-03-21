<?php
namespace Admin;
use App;

class Companies
{
    public static function get_table()
    {
      return 'structure_companies';
    }

    private static function get_parent()
    {
      return 'battalion_id';
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

    public static function get_company_commander($company_id, $battalion_id = 1)
    {
      $row = App\SQL::row("SELECT id FROM personnel WHERE position = ? AND battalion = '{$battalion_id}' AND company = ?", array(Positions::ID('Company Commander'), $company_id));

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

    public static function get_company_xo($company_id, $battalion_id = 1)
    {
      $row = App\SQL::row("SELECT id FROM personnel WHERE position = ? AND battalion = '{$battalion_id}' AND company = ?", array(Positions::ID('Company Executive Officer'), $company_id));

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

    public static function get_company_first_sergeant($company_id, $battalion_id = 1)
    {
      $row = App\SQL::row("SELECT id FROM personnel WHERE position = ? AND battalion = {$battalion_id} AND company = ?", array(Positions::ID('Company First Sergeant'), $company_id));

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

    public static function print_company_first_sergeant($squad_id, $case = 0)
    {
      $company_first_sergeant = self::get_company_first_sergeant($squad_id);
      switch($case)
      {
        case 0:
        $result = implode(",",$company_first_sergeant);
        break;

        case 1:
        $result = "<h4 style=\"display: inline\">";
        $result .= "<span class=\"label bg-brown\">";
        $result .= "Company First Sergeant: ";
        if (NULL !== $company_first_sergeant && sizeof($company_first_sergeant) > 0)
        {
          $user = new User();

          for ($i = 0; $i < sizeof($company_first_sergeant); $i++)
          {
            $user->setID($company_first_sergeant[$i]);
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

    public static function print_company_commander($squad_id, $case = 0)
    {
      $company_commander = self::get_company_commander($squad_id);
      switch($case)
      {
        case 0:
        $result = implode(",",$company_commander);
        break;

        case 1:
        $result = "<h4 style=\"display: inline\">";
        $result .= "<span class=\"label bg-brown\">";
        $result .= "Company Commander: ";
        if (NULL !== $company_commander && sizeof($company_commander) > 0)
        {
          $user = new User();

          for ($i = 0; $i < sizeof($company_commander); $i++)
          {
            $user->setID($company_commander[$i]);
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
            $result = self::name($id);
            break;

            case 3:
            $result = self::name($id) . " " . "Company";
            break;

            case 1:
            $result = self::name($id) . " " . "(" . self::abbreviation($id) . ")" . " Company";
            break;

            case 2:
            $result = self::abbreviation($id) . " CO";
            break;

            default:
            $result = "Error";
            break;
        }

        return $result;
    }
}
?>
