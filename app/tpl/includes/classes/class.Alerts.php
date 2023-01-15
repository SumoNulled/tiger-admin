<?php
namespace Admin;

class Alerts
{
   public static function info($message, $title = null)
   {
      $result = "<div class=\"alert alert-info\">
          <strong>" . $title . "</strong> " . $message . "
      </div>";

      return $result;
   }

   public static function success($message, $title = null)
   {
     $result = "<div class=\"alert alert-success\">
         <strong>" . $title . "</strong> " . $message . "
     </div>";

     return $result;
   }

   public static function danger($message, $title = null)
   {
     $result = "<div class=\"alert alert-danger\">
         <strong>" . $title . "</strong> " . $message . "
     </div>";

     return $result;
   }

   public static function screen($message)
   {
     $result = "<script>alert('".$message . "');</script>";

     echo $result;
   }

   public static function confirm($message)
   {
     $result = "<script>confirm('" .$message . "');</script>";
   }
}
?>
