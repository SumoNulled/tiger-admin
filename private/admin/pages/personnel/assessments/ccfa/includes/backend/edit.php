<?php
if (isset($_GET['id']) && !(App\SQL::query("SELECT id FROM `structure_assessments` WHERE `id` = ?", $_GET['id'])->num_rows == 0))
{
    $sql = new App\SQL;
    $result = $sql->query("SELECT * FROM `structure_assessments` WHERE id = ?", $_GET['id']);
    $result->execute();
    $row = $result->get_result();

    $_ARRAY = $row->fetch_assoc();
    if (isset($_POST['add_cadet']))
    {
      if (is_array($_POST['id']))
      {
        $it = new MultipleIterator();
        $it->attachIterator(new ArrayIterator($_POST['id'])); // 0
        $it->attachIterator(new ArrayIterator($_POST['push_ups'])); // 1
        $it->attachIterator(new ArrayIterator($_POST['curl_ups'])); // 2
        $it->attachIterator(new ArrayIterator($_POST['one_mile_run'])); // 3

        $it->attachIterator(new ArrayIterator($_POST['height'])); // 4
        $it->attachIterator(new ArrayIterator($_POST['weight'])); // 5
      } else {
        $it[] = $_POST['id'];
      }

      $ccfa = new Admin\CCFA($_ARRAY['id']);
      $user = new Admin\User;
      foreach($it as $x)
      {
        $user->setID($x[0]);
        $ccfa->set_gender($user->gender());
        $ccfa->set_push_ups($x[1]);
        $ccfa->set_curl_ups($x[2]);
        $ccfa->set_one_mile_run($x[3]);

        if ($ccfa->pass())
        {
          $status = 1;
        } else {
          $status = 0;
        }

        $query = "INSERT INTO `personnel_ccfa_scores` (cadet_id, assessment_id, push_ups, curl_ups, one_mile_run, status) VALUES (?,?,?,?,?, ?)";
        $result = $sql->query($query, array($x[0], $_GET['id'], $x[1], $x[2], $x[3], $status));
      }

      // If height/weight have values, include into table.
      if(!(empty($x[4]) && empty($x[5])))
      {
        $query = "INSERT INTO `personnel_hw_scores` (cadet_id, assessment_id, height, weight) VALUES (?, ?, ?, ?)";
        $result = $sql->query($query, array($x[0], $_GET['id'], $x[4], $x[5]));
      }

      $success = "You have successfully updated the roster. Refreshing in <span id=\"countdown\"></span>.";
      $success = Admin\Alerts::success($success, "Success!");
      add_cadets($_ARRAY, $success);
    }

    if (isset($_POST['delete']))
    {
        $success = "The records for <b> this log (ID: " . $_ARRAY['id'] .")</b> " . " have been deleted. Refreshing in <b><span id=\"countdown\"></span></b> seconds.";
        $success = Admin\Alerts::success($success, "Success!");
        $result = $sql->query("DELETE FROM `structure_assessments` WHERE id = ?", $_GET['id']);
        $result = $sql->query("DELETE FROM `personnel_ccfa_scores` WHERE assessment_id = ?", $_GET['id']);
        renderForm($_ARRAY, NULL, $success);
    }

    if (isset($_POST['update_assessments']))
    {
          $it = new MultipleIterator();
          $it->attachIterator(new ArrayIterator($_POST['id']));
          $it->attachIterator(new ArrayIterator($_POST['push_ups']));
          $it->attachIterator(new ArrayIterator($_POST['curl_ups']));
          $it->attachIterator(new ArrayIterator($_POST['one_mile_run']));

          $ccfa = new Admin\CCFA($_ARRAY['id']);
          $user = new Admin\User;
          foreach($it as $x)
          {
            $user->setID($x[0]);
            $ccfa->set_gender($user->gender());
            $ccfa->set_push_ups($x[1]);
            $ccfa->set_curl_ups($x[2]);
            $ccfa->set_one_mile_run($x[3]);
            //echo "{$user->print_name()}: Push-Ups: {$ccfa->get_push_ups()}, Curl-Ups: {$ccfa->get_curl_ups()}, 1 Mile Run: {$ccfa->get_one_mile_run()}<br />";
            if ($ccfa->pass())
            {
              $status = 1;
            } else {
              $status = 0;
            }

            $result = $sql->query("UPDATE `personnel_ccfa_scores` SET `push_ups` = ?, `curl_ups` = ?, `one_mile_run` = ?, `status` = ? WHERE `cadet_id` = ? AND `assessment_id` = ?", array($x[1], $x[2], $x[3], $status, $x[0], $_GET['id']));
          }

          $success = "You have successfully updated the roster. Refreshing in <span id=\"countdown\"></span>.";
          $success = Admin\Alerts::success($success, "Success!");
          update_assessments($_ARRAY, $success);
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
          $_POST['date'] = date('Y-m-d', strtotime($_POST['date']));
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
          if($query = $sql->query("UPDATE `structure_assessments` SET {$Fields} WHERE id = {$_GET['id']}", $Values))
          {
            $result = $sql->query("SELECT * FROM `structure_assessments` WHERE id = ?", $_GET['id']);
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
    elseif (!isset($_POST['submit']) && !isset($_POST['delete']) && !isset($_POST['add_cadet']) && !isset($error))
    {
      add_cadets($_ARRAY);
      update_assessments($_ARRAY);
      renderForm($_ARRAY);
    }

}
else
{
  echo Admin\Alerts::danger("An error occured when trying to edit this assessments log. Contact your system administrator for more information.", "Oops!");
}
?>
