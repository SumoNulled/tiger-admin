<?php
namespace App;
use App\SQL;

class Statistics
{
    public static function total($table, $where = NULL)
    {
      switch($where)
      {
        case NULL:
        $result = SQL::fetch("SELECT COUNT(?) FROM " . $table . "", "id");
        break;

        default:
        $result = SQL::fetch("SELECT COUNT(?) FROM " . $table . " WHERE " . $where . "", "id");
        break;
      }

      return $result;
    }
}
?>
