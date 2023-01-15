<?php
namespace App;
General::class_include('class.SQL.php');

session_start();

class Session
{
    public static function active()
    {
        if(isset($_SESSION))
        {
            if($_SESSION['loggedin'] ?? 0)
            {
              return true;
            } else {
              return false;
            }
        }
        return false;
    }

    public static function getID()
    {
      return $_SESSION['id'] ?? 0;
    }

    public static function get($row, $id=NULL)
    {
      if ($id == NULL)
      {
        $id = self::getID();
      }
      $sql = new SQL;
      $row = $sql->fetch("SELECT $row FROM personnel WHERE id = ?", $id);

      return $row;
    }
}
?>
