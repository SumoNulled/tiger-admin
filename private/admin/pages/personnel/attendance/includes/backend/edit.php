<?php
if (isset($_GET['id']) && !(App\SQL::query("SELECT id FROM `structure_attendance` WHERE `id` = ?", $_GET['id'])->num_rows == 0))
{
    $sql = new App\SQL;
    $result = $sql->query("SELECT * FROM `structure_attendance` WHERE id = ?", $_GET['id']);
    $result->execute();
    $row = $result->get_result();

    $_ARRAY = $row->fetch_assoc();

    if (isset($_POST['delete']))
    {
        $success = "The records for <b> this log (ID: " . $_ARRAY['id'] .")</b> " . " have been deleted. Refreshing in <b><span id=\"countdown\"></span></b> seconds.";
        $success = Admin\Alerts::success($success, "Success!");
        $result = $sql->query("DELETE FROM `structure_attendance` WHERE id = ?", $_GET['id']);
        $result = $sql->query("DELETE FROM `personnel_attendance` WHERE attendance_id = ?", $_GET['id']);
        renderForm($_ARRAY, NULL, $success);
    }

    if (isset($_POST['update_attendance']))
    {
          $it = new MultipleIterator();
          $it->attachIterator(new ArrayIterator($_POST['id']));
          $it->attachIterator(new ArrayIterator($_POST['status']));

          foreach($it as $x)
          {
            $result = $sql->query("UPDATE `personnel_attendance` SET `status` = ? WHERE `cadet_id` = ? AND `attendance_id` = ?", array($x[1], $x[0], $_GET['id']));
          }

          $success = "You have successfully updated the roster. Refreshing in <span id=\"countdown\"></span>.";
          $success = Admin\Alerts::success($success, "Success!");
          update_attendance($_ARRAY, $success);
    }

    if(isset($_POST['submit']))
    {

        if (isset($error))
        {
          $error = Admin\Alerts::danger($error, "Error!");
          renderForm($_ARRAY, $error);
        }
        else {
          // Create arrays for the query.
          $_POST['timestamp'] = date('Y-m-d', strtotime($_POST['timestamp'])) . " " . date('H:i:s', strtotime($_POST['accountability_begin']));
          foreach($_POST as $x=>$y)
          {
            switch($x)
            {
              case "submit":
              //Do Nothing
              break;

              default:
              if (!in_array($x, $_SESSION['disabled_indexes']))
              {
                $Fields[] = "`" . $x . "` = ?";
                $Values[] = ($y != NULL) ? $y : NULL;
              }
              break;
            }
          }

          $Fields[] = "`last_edited` = ?";
          $Values[] = date("Y:m:d H:i:s");

          $Fields = implode(",", $Fields);

          $success = NULL;
          if($query = $sql->query("UPDATE `structure_attendance` SET {$Fields} WHERE id = {$_GET['id']}", $Values))
          {
            $result = $sql->query("SELECT * FROM `structure_attendance` WHERE id = ?", $_GET['id']);
            $result->execute();
            $row = $result->get_result();

            $_ARRAY = $row->fetch_assoc();

            $success = "The records for <b>" . $_ARRAY['id'] . " " . "(ID: " . $_ARRAY['id'] .")</b> " . " have been updated. Refreshing in <b><span id=\"countdown\"></span></b> seconds.";
            $success = Admin\Alerts::success($success, "Success!");
            renderForm($_ARRAY, NULL, $success);
          } else {
            echo "Error! Please contact your system administrator.";
          }
        }
    }
    elseif (!isset($_POST['submit']) && !isset($_POST['delete']) && !isset($error))
    {
      present($_ARRAY); tardy($_ARRAY); absent($_ARRAY);
      update_attendance($_ARRAY);
      renderForm($_ARRAY);
    }

}
else
{
  echo Admin\Alerts::danger("An error occured when trying to edit this attendance log. Contact your system administrator for more information.", "Oops!");
}
?>
