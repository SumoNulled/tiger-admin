<?php
namespace App;
General::class_include('class.SQL.php');

class Phrases
{
    public static function get($phrase)
    {
      $sql = new SQL;
      $phrase = $sql->fetch("SELECT phrase_content FROM system_phrases WHERE phrase_name = ?", array($phrase));

      return $phrase;
    }
}
?>
