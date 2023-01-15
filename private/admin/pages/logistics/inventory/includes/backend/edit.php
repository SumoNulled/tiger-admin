<?php
if (isset($_GET['id']) && !(App\SQL::query("SELECT id FROM `structure_inventory` WHERE `id` = ?", $_GET['id'])->num_rows == 0))
{
    $sql = new App\SQL;
    $result = $sql->query("SELECT * FROM `structure_inventory` WHERE id = ?", $_GET['id']);
    $result->execute();
    $row = $result->get_result();

    $_ARRAY = $row->fetch_assoc();

    if (isset($_POST['delete']))
    {
        $success = "The records for <b> this log (ID: " . $_ARRAY['id'] .")</b> " . " have been deleted. Refreshing in <b><span id=\"countdown\"></span></b> seconds.";
        $success = Admin\Alerts::success($success, "Success!");
        $result = $sql->query("DELETE FROM `structure_inventory` WHERE id = ?", $_GET['id']);
        $result = $sql->query("DELETE FROM `personnel_inventory` WHERE inventory_id = ?", $_GET['id']);
        renderForm($_ARRAY, NULL, $success);
    }

    if (isset($_POST['update_inventory']))
    {
          $it = new MultipleIterator();
          $it->attachIterator(new ArrayIterator($_POST['id']));
          $it->attachIterator(new ArrayIterator($_POST['quantity']));

          foreach($it as $x)
          {
            $result = $sql->query("UPDATE `personnel_inventory` SET `quantity` = ? WHERE `cadet_id` = ? AND `inventory_id` = ?", array($x[1], $x[0], $_GET['id']));
          }

          $success = "You have successfully updated the inventory log. Refreshing in <span id=\"countdown\"></span>.";
          $success = Admin\Alerts::success($success, "Success!");
          update_inventory($_ARRAY, $success);
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
          if($query = $sql->query("UPDATE `structure_inventory` SET {$Fields} WHERE id = {$_GET['id']}", $Values))
          {
            $result = $sql->query("SELECT * FROM `structure_inventory` WHERE id = ?", $_GET['id']);
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
      update_inventory($_ARRAY);
      renderForm($_ARRAY);
    }

}
else
{
  echo Admin\Alerts::danger("An error occured when trying to edit this inventory log. Contact your system administrator for more information.", "Oops!");
}
?>
