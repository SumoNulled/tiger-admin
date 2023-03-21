<?php
if(isset($_POST))
{
    if (isset($_POST['search']))
    {
        App\General::class_include('class.GeoLocation.php', "API");
        $geo = new API\GeoLocation($_POST['address'], $_POST['city'], $_POST['state']);
        $geo->call_api();

        if(!(NULL !== $geo->matches()) || !empty($geo->matches()))
        {
          $_POST['address'] = $geo->street();
          $_POST['city'] = $geo->city();
          $_POST['state'] = $geo->state();
          $_POST['zip'] = $geo->zip();
          $_POST['longitude'] = $geo->longitude();
          $_POST['latitude'] = $geo->latitude();
        } else {
          $error = "There was a fatal error with your address. Please double check all information and try again.";
        }

        if (!(App\SQL::query("SELECT location_name FROM `intelligence_locations` WHERE `location_name` = ?", $_POST['location_name'])->num_rows == 0))
        {
          $error = "The location name <b>{$_POST['location_name']}</b> already exists in the database. You may manage it in the \"Manage Locations\" tab.";
        } else if (!(App\SQL::query("SELECT address FROM `intelligence_locations` WHERE `address` = ?", $_POST['address'])->num_rows == 0)) {
          $error = "The address <b>{$_POST['address']}</b> already exists in the database. You may manage it in the \"Manage Locations\" tab.";
        } else if ($_POST['address'] == "") {
          $error = "Please enter a valid address.";
        } else if ($_POST['city'] == "") {
          $error = "Please enter a valid city.";
        } else if ($_POST['state'] == "") {
          $error = "Please enter a valid state.";
        }

        if (isset($error))
        {
          $error = Admin\Alerts::danger($error, "Error!");
          geoSearch($error);
        } else {
          // Begin processing the location.

          foreach($_POST as $x=>$y)
          {
            switch($x)
            {
              case "search":
              case "manual":
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
          if(App\SQL::query("INSERT INTO intelligence_locations (" . $Fields . ") VALUES (" . $Params . ")", $Values))
          {
            $success = "You have successfully added {$_POST['address']} to the Tiger Battalion databse. Refreshing in <span id=\"countdown\"></span>.";
            $success = Admin\Alerts::success($success, "Success!");
            geoSearch(NULL, $success);
          } else {
            echo "Error! Please contact your system administrator.";
          }
        }
    } else {
      // If the form has not yet been submitted, display the blank form.
      geoSearch();
    }

    // Begin processing a manual add
    if (isset($_POST['manual']))
    {
        if ($_POST['address'] == "") {
          $error = "Please enter a valid address.";
        } else if ($_POST['city'] == "") {
          $error = "Please enter a valid city.";
        } else if ($_POST['state'] == "") {
          $error = "Please enter a valid state.";
        } else if ($_POST['zip'] == "") {
          $error = "Please enter a valid zip code.";
        } else if ($_POST['longitude'] == "") {
          $error = "Please enter a valid longitude value.";
        } else if ($_POST['latitude'] == "") {
          $error = "Please enter a valid latitude value.";
        }

        if (isset($error))
        {
          $error = Admin\Alerts::danger($error, "Error!");
          manualSearch($error);
        } else {
          // Begin processing creation of cadet.
          foreach($_POST as $x=>$y)
          {
            switch($x)
            {
              case "search":
              case "manual":
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
          if(App\SQL::query("INSERT INTO intelligence_locations (" . $Fields . ") VALUES (" . $Params . ")", $Values))
          {
            $success = "You have successfully added {$_POST['address']} to the Tiger Battalion databse. Refreshing in <span id=\"countdown\"></span>.";
            $success = Admin\Alerts::success($success, "Success!");
            manualSearch(NULL, $success);
          } else {
            echo "Error! Please contact your system administrator.";
          }

        }
  } else {
    // If the form has not yet been submitted, display the blank form.
    manualSearch();
  }
}
?>
