<?php
if (isset($_GET['id']) && !(App\SQL::query("SELECT id FROM `personnel` WHERE `id` = ?", $_GET['id'])->num_rows == 0))
{

    $sql = new App\SQL;
    $result = $sql->query("SELECT * FROM `personnel` WHERE id = ?", $_GET['id']);
    $result->execute();
    $row = $result->get_result();

    $_ARRAY = $row->fetch_assoc();

    // Searching for user's squad in their platoon. Select the appropriate index (1, 2, 3, 4)
    $_ARRAY['squad'] = isset($_ARRAY['squad']) ? array_search($_ARRAY['squad'], Admin\Squads::get_squads($_ARRAY['platoon'])) + 1 : "";

    if (isset($_POST['delete']))
    {
        $success = "The records for <b> this log (ID: " . $_ARRAY['id'] .")</b> " . " have been deleted. Refreshing in <b><span id=\"countdown\"></span></b> seconds.";
        $success = Admin\Alerts::success($success, "Success!");
        $result = $sql->query("DELETE FROM `personnel` WHERE id = ?", $_GET['id']);
        $result = $sql->query("DELETE FROM `personnel_attendance` WHERE cadet_id = ?", $_GET['id']);
        $result = $sql->query("DELETE FROM `personnel_inventory` WHERE cadet_id = ?", $_GET['id']);
        renderForm($_ARRAY, NULL, $success);
    }

    if(isset($_POST['submit']))
    {
        $id = $_GET['id'];
        $position = isset($_POST['position']) ? $_POST['position'] : "";
        $company = isset($_POST['company']) ? $_POST['company'] : "";
        $platoon = isset($_POST['platoon']) ? $_POST['platoon'] : "";
        $squad = isset($_POST['squad']) ? $_POST['squad'] : "";

        // Reassign the squad variable for error checking.
        // Reassign the _POST squad index for database input.
        // Check that the squad is not set to "N/A" before performing calculations.
        // Output correct squad/platoon combination.
        $squad = $_POST['squad'] = !empty($squad) ? Admin\Squads::get_squads($platoon)[$squad - 1] : "";

        if ($id == App\Session::getID() && !App\Permissions::valid('is_admin'))
        {
          $error = "You are not able to use this resource for your own account. Please contact a higher echelon.";
        }
        else if ($_ARRAY['position'] > App\Session::get("position") && !App\Permissions::valid('is_admin'))
        {
          //$error = "You are not able to manage a higher ranking account. Please contact a higher echelon.";
        }
        else if ($position >= App\Session::get("position") && !App\Permissions::valid('is_admin'))
        {
          //$error = "You do not have have the required permissions to add someone to this position. Please contact a higher echelon.";
        }
        else if ($company == 1 && $platoon == NULL && $position != Admin\Positions::ID('Company Commander') && $position != Admin\Positions::ID('Company First Sergeant') && $position != Admin\Positions::ID('Company Executive Officer'))
        {
          $error = "This position and platoon combination are incompatible.";
        }
        else if ($platoon != NULL && Admin\Platoons::parent($platoon) != $company)
        {
          $error = "This company and platoon combination are incompatible.";
        }else if($squad != NULL && Admin\Squads::parent($squad) != $platoon)
        {
          $error = "This squad and platoon combination are incompatible.";
        }

          if (isset($error))
          {
            $error = Admin\Alerts::danger($error, "Error!");
            renderForm($_ARRAY, $error);
          }
          else {
            // Create arrays for the query.
            $_POST['dob'] = date("Y-m-d", strtotime($_POST['dob']));
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
            if($query = $sql->query("UPDATE personnel SET {$Fields} WHERE id = {$_GET['id']}", $Values))
            {
              $result = $sql->query("SELECT * FROM personnel WHERE id = ?", $_GET['id']);
              $result->execute();
              $row = $result->get_result();

              $_ARRAY = $row->fetch_assoc();

              $success = "The records for <b>" . $_ARRAY['first_name'] . " " . $_ARRAY['last_name'] . " " . "(ID: " . $_ARRAY['id'] .")</b> " . " have been updated. Refreshing in <b><span id=\"countdown\"></span></b> seconds.";
              $success = Admin\Alerts::success($success, "Success!");
              renderForm($_ARRAY, NULL, $success);
            } else {
              echo "Error! Please contact your system administrator.";
            }
          }
    }
    else
    {
      renderForm($_ARRAY);
    }

}
else
{
  echo Admin\Alerts::danger("An error occured when trying to edit this cadet. Contact your system administrator for more information.", "Oops!");
}
?>
