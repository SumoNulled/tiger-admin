<?php
namespace App;
General::class_include('class.Positions.php');
General::class_include('class.Session.php');
General::class_include('class.SQL.php');

use Admin\Positions;

class Permissions
{
    public static function check()
    {
        if (strpos($_SERVER['REQUEST_URI'], "admin"))
        {
            if (!Session::active())
            {
                General::redirect('/private/user/login.php');
                die("You don't have permission to be here!");
            }

            if (!(self::admin()))
            {
              session_unset(); // Remove data stored in cookies.
              session_destroy(); // Log the user out, which prevents a redirect loop when sent to login page.
              header('Location: /private/user/login.php'); // Redirect them to the login page
              exit; // Prevent the script from continuing, prevents minor attacks.
              return false;
            }
        }

        else if (strpos($_SERVER['REQUEST_URI'], "login"))
        {
            if (Session::active())
            {
                General::redirect('/private/admin');
            }
        }
    }

    public static function admin($id = null)
    {
      return self::valid('access_admin_panel', $id);
    }

    public static function valid($permission, $id = null)
    {

      $sql = new SQL;
      if ($id == NULL)
      {
        $id = Session::getID();
      }

      // Get an array of the user's primary position and their secondary positions.
      $positions = Positions::get_position_of($id);

      foreach($positions as $x)
      {
        $parameters[] = "?";
      }

      $parameters = implode(",", $parameters);

      foreach($sql->row("SELECT `is_admin` FROM system_permissions WHERE position_id IN ({$parameters})", array(...$positions)) as $row)
      {
        if ($row['is_admin'])
        {
          return true;
        }
      }

      // If a permission does not exist, automatically return false.
      $valid = false;
      //var_dump($positions);
      if (sizeof($sql->row("SHOW COLUMNS FROM `system_permissions` LIKE '{$permission}'")) > 0)
      {
        foreach($sql->row("SELECT `{$permission}` FROM system_permissions WHERE position_id IN ({$parameters})", array(...$positions)) as $row)
        {
          if ($row[$permission])
          {
            $valid = true;
          }
        }
      }

      switch($valid)
      {
        case true:
          return true;
        break;

        default:
          return false;
        break;
      }
    }
}
?>
