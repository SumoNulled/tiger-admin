<?php
if(isset($_POST))
{
    if (isset($_POST['submit']))
    {
        if ($_POST['first_name'] == "") {
          $error = "Please enter a valid first name.";
        //} else if ($_POST['email'] == "") {
        //  $error = "Please enter a valid e-mail address.";
        //} else if ($_POST['phone_number'] == "") {
        //  $error = "Please enter a valid phone number";
        }

        if (isset($error))
        {
          $error = Admin\Alerts::danger($error, "Error!");
          renderForm($error);
        } else {
          // Begin processing creation of cadet.
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
          if(App\SQL::query("INSERT INTO personnel (" . $Fields . ") VALUES (" . $Params . ")", $Values))
          {
            $success = "You have successfully added {$_POST['first_name']} to the Tiger Battalion databse. Refreshing in <span id=\"countdown\"></span>.";
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
