<?php
namespace App;
General::class_include("class.Strings.php");
General::class_include("class.Positions.php");
use Admin\Positions;

class Register
{
  private $id;
  private $username;
  private $password;
  private $confirm_password;
  private $IP;

  private $error;
  private $success;

  function __construct($id = null, $username = null, $password = null, $confirm_password = null, $IP = null, $error = array(), $success = array())
  {
    $this->id = $id;
    $this->username = $username;
    $this->password = $password;
    $this->confirm_password = $confirm_password;
    $this->IP = $IP;

    $this->error = $error;
    $this->success = $success;
  }

  // Retrieve member variables

  public function getID()
  {
    return $this->id;
  }

  public function setID($username)
  {
    $id = SQL::fetch("SELECT id FROM personnel WHERE username = ?", $username);
    $this->id = $id;
  }

  public function getUsername()
  {
    return $this->username;
  }

  public function setUsername($username)
  {
    $this->username = trim(strtolower($username));
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function setPassword($password)
  {
    $this->password = trim($password);
  }

  public function getConfirmPassword()
  {
    return $this->confirm_password;
  }

  public function setConfirmPassword($confirm_password)
  {
    $this->confirm_password = trim($confirm_password);
  }

  public function getIP()
  {
    return $this->IP;
  }

  public function setIP($IP)
  {
    $this->IP = trim($IP);
  }

  public function getError()
  {
    return $this->error;
  }

  public function setError($error)
  {
    if (isset($error))
    {
      array_push($this->error, $error);
    }
  }

  public function print_error()
  {
    foreach($this->error as $x)
    {
      echo $x . '<br />';
    }
  }

  public function getSuccess()
  {
    return $this->success;
  }

  public function setSuccess($success)
  {
    array_push($this->success, $success);
  }

  public function print_success()
  {
    foreach($this->success as $x)
    {
      echo $x . '<br />';
    }
  }

  public function authenticate_session()
  {
    if(!isset($_SESSION["username"])) {
        header("Location: " . getLoginPage());
        exit();
    }
  }

  public function logout()
  {
    $_SESSION = array();

    // Destroy the session.
    session_destroy();

    // Redirect to login page
    header("location: " . $this->getLoginPage());
    exit;
  }

  public function getLoginPage()
  {
    return "login.php";
  }

  // Username Validation

  public function validateUsername()
  {
    if (Strings::empty($this->username))
    {
      return "Your username cannot be empty!";
    }

    else if (!SQL::query("SELECT id FROM personnel WHERE username = ?", $this->getUsername())->num_rows == 0)
    {
      return "This username is unavailable. Please try again.";
    }

    else if (!preg_match('/^[a-zA-Z0-9_]+$/', trim($this->username)))
    {
      return "Usernames can only contain letters, numbers, and underscores.";
    }

    else if(strlen(trim($this->getUsername())) > 8)
    {
      return "Your username must be no longer than 8 characters.";
    }

    else
    {
      return NULL;
    }
  }

  public function validatePassword()
  {
    if (Strings::empty($this->password))
    {
      return "Your password cannot be empty!";
    }

    else if (Strings::empty($this->confirm_password))
    {
      return "Please confirm your password.";
    }

    else if (!Strings::match(array($this->password, $this->confirm_password)))
    {
      return "Your passwords do not match. Please try again.";
    }

    else if(strlen(trim($this->getPassword())) < 6)
    {
      return "Your password must be six (6) or more characters long.";
    }

    else {
      return NULL;
    }
  }

  public function validateLogin()
  {
    if (Strings::empty($this->username))
    {
      return "Your username cannot be empty!";
    }

    else if (Strings::empty($this->password))
    {
      return "Your password cannot be empty!";
    }

    else if(!Permissions::admin($this->getID()))
    {
      return "You do not have authorization to be here. This login attempt (" . $this->getIP() . ") has been logged.";
    }

    else {
      return NULL;
    }
  }
}

?>
