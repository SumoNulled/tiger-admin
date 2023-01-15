<?php
if(isset($_POST))
{
    if (isset($_POST['submit']))
    {
        if ($_POST['type'] == "") {
          $error = "Please enter a valid event type.";
        } else if ($_POST['mandatory'] == "") {
          $error = "Please list the event as mandatory or optional.";
        }

        if (isset($error))
        {
          $error = Admin\Alerts::danger($error, "Error!");
          renderForm($error);
        } else {
          // Begin processing creation of the attendance log.
          $_POST['timestamp'] = date("Y-m-d H:i:s", strtotime($_POST['timestamp']));
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
                $Fields[] = "`" . $x . "`";
                $Values[] = ($y != NULL) ? $y : NULL;
                $Params[] = "?";
              }
              break;
            }
          }

          $Fields = implode(",", $Fields);
          $Params = implode(",", $Params);
          if(App\SQL::query("INSERT INTO structure_attendance (" . $Fields . ") VALUES (" . $Params . ")", $Values))
          {

            foreach(App\SQL::row('SELECT id FROM personnel ORDER BY id ASC') as $x=>$y)
            {
              switch($x)
              {
                case "submit":
                //Do Nothing
                break;

                default:
                if (!in_array($x, $_SESSION['disabled_indexes']))
                {
                  $User_Fields[] = "`cadet_id`";
                  $User_Fields[] = "`attendance_id`";

                  $User_Values[] = ($y['id'] != NULL) ? $y['id'] : NULL;
                  $result = App\SQL::fetch("SELECT MAX(id) FROM structure_attendance");
                  $User_Values[] = $result;

                  $User_params[] = "?";
                  $User_params[] = "?";
                }
                break;
              }
              $User_Params[] = "(" . implode(",", $User_params) . ")";
              unset($User_params);
            }

            $User_Fields = "(" . implode(",", array_unique($User_Fields)) . ")";

            $User_Params = implode(",", $User_Params);

            $sql = "INSERT INTO personnel_attendance {$User_Fields} VALUES {$User_Params}";
            App\SQL::query($sql, $User_Values);

            $success = "You have successfully added a new {$_POST['type']} attendance log to the Tiger Battalion databse. Refreshing in <span id=\"countdown\"></span>.";
            $success = Admin\Alerts::success($success, "Success!");
            renderForm(NULL, $success);
          } else {
            echo "Error! Please contact your system administrator.";
          }

        }
  } else {
    // If the form has not yet been submitted, display the blank form.
    renderForm();
  }
}
?>
