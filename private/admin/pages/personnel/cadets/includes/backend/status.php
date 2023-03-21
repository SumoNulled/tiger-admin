<?php
use Admin\Alerts;
use Admin\User;

// Make sure there is an ID.
if (isset($_GET['id']))
{
  App\General::class_include('class.Alerts.php');
  App\General::class_include('class.User.php');

  $id = $_GET['id'];
  $user = new User($id);

  switch($user->active())
  {
    case 1:
      // If the user is already activated, deactivate their account.
      $user->deactivate();
    break;

    default:
      // If the user is not activated, activate their account.
      $user->activate();
    break;
  }

  App\General::redirect(App\General::getAdminRoot() . "pages/personnel/cadets/view.php");
}
?>
