<?php
App\General::class_include('class.User.php');

if (isset($_POST))
{
  $user = new Admin\User();

  if (isset($_POST['username']))
  {
      $user->setID($_POST['username']);
      $user->generateUsername();

      $id = $user->getID();
      header("Location: http://tigerbn.com/private/admin/pages/personnel/cadets/edit.php?id={$id}");
      exit;
  } elseif (isset($_POST['password']))
  {
      $user->setID($_POST['password']);
      $user->generatePassword();

      $id = $user->getID();
      header("Location: http://tigerbn.com/private/admin/pages/personnel/cadets/edit.php?id={$id}");
      exit;
  }
}
?>
