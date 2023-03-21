<?php
  // Begin register.php backend code.
  App\General::class_include('class.Alerts.php');
  App\General::class_include('class.Register.php');
  App\General::class_include('class.Session.php');
  App\General::class_include('class.SQL.php');
  App\General::class_include('class.User.php');

  // Initialize variables required for registration.

  $Register = new App\Register;
  $SQL = new App\SQL;
  $User = new Admin\User;

  // Begin processing form data.
  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
    if(isset($_POST['submit']))
    {
      $User->setID(App\Session::getID());
      $oldPassword = isset($_POST['old_password']) ? $_POST['old_password'] : "";
      $password = isset($_POST['password']) ? $_POST['password'] : "";
      $confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : "";

      $hashed_password = App\SQL::fetch("SELECT password FROM personnel WHERE id = ?", $User->getID());
      if (!password_verify($oldPassword, $hashed_password))
      {
        $Register->setError(Admin\Alerts::danger("The old password for ID: {$User->getID()} does not match.", "Error!"));
      }
      // Send the password through validation.
      // IF the password has an error, add it to the error array.
      // Else, display no errors.
      $Register->setPassword($password);
      $Register->setConfirmPassword($confirmPassword);
      $Register->setError($Register->validatePassword());

      // Verify that all errors have been resolved.
      if(empty($Register->getError()))
      {
        // Finalize variables for registration.
        $Register->setPassword(password_hash($password, PASSWORD_DEFAULT));

        $query = "UPDATE personnel SET password = ? WHERE id = ?";

        // Insert user data into the database and re-direct them to the log-in page upon completion.
        if($SQL->query($query, array($Register->getPassword(), $User->getID())))
        {
          $query = "UPDATE personnel SET temp_password = NULL";
          $SQL->query($query);
          $Register->setSuccess(Admin\Alerts::success("You have successfully changed your password!", "Success!"));
          //header("location: login.php");
        } else {
          echo "Oops! Something went wrong.";
        }
      }

      // Display any error messages.
      $Register->print_error();

      // Display any success messages.
      $Register->print_success();

      renderForm();

      $query = "SELECT username FROM personnel WHERE id = ?";
      $param_id = "1";
      $Registername = $SQL->fetch($query, $param_id);
      //echo $Registername;
    }
  }
  // If the server request method is not POST (form not submitted), then render blank form.
  else
  {
    renderForm();
  }
?>
