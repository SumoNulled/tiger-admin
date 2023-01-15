<!DOCTYPE html>
<html>
<?php
App\General::class_include('class.Alerts.php');
App\General::class_include('class.Cards.php');
App\General::class_include('class.Forms.php');
?>

<?php App\General::root_include('private/admin/app/includes/head.php'); ?>

<body class="<?php print_r(App\Phrases::get('theme_color')); ?>">
    <?php App\General::root_include('private/admin/app/includes/pageloader.php'); ?>

    <?php App\General::root_include('private/admin/app/includes/topbar.php'); ?>

    <section>
      <?php App\General::root_include('private/admin/app/includes/leftsb.php'); ?>

      <?php App\General::root_include('private/admin/app/includes/rightsb.php'); ?>
    </section>

    <section class="content">
        <div class="container-fluid">
        </div>

        <?php
        function geoSearch($error = null, $success = null)
        {
          // Begin Geolocation Services
          $card = new Admin\Cards;
          $form = new Admin\Forms;

          $card->set_card_title("Geo-Locate Address"); // A NULL card title and "false" card menu will hide the card header entirely.
          $card->set_card_sub_title("Use the geolocation API to retrieve grid coordinates and access weather data and other information.");
          $card->set_card_menu(false); // True will show the menu, False will hide it.

          // Input fields are in the form of ("size", "name", "Label", "value", required?, "permission_required")
          $form->add_row("Please enter descriptive information for this location.", NULL,
          $form->add_input_text(3, "location_name", "Location Name", NULL, NULL, TRUE, NULL),
          $form->add_input_text(3, "location_description", "Location Description", NULL, NULL, FALSE, NULL)
          );

          $form->add_row("Please enter the location's information below.", NULL,
          $form->add_input_text(2, "address", "Address", NULL, NULL, TRUE, NULL),
          $form->add_input_text(2, "city", "City", NULL, NULL, TRUE, NULL),
          $form->add_input_text(2, "state", "State", NULL, NULL, TRUE, NULL)
          );


          $form->add_row(NULL, NULL,
            $form->add_input_submit("search", "SEARCH & ADD")
          );

          $card->set_card_body($error, $success, $form->print());
          $_SESSION['disabled_indexes'] = $form->get_disabled_indexes();

          echo
          // print_row() can take an unlimited amount of parameters of print().
          $card->print_row($card->get_card_body());
        }

        function manualSearch($error = null, $success = null)
        {
          // Begin manual search
          $card = new Admin\Cards;
          $form = new Admin\Forms;

          $card->set_card_title("Manually Add Location"); // A NULL card title and "false" card menu will hide the card header entirely.
          $card->set_card_sub_title("Add a new significant location to the Tiger Battalion database to access weather data and other information.");
          $card->set_card_menu(false); // True will show the menu, False will hide it.

          // Input fields are in the form of ("name", "Label", "value", required?, "permission_required")
          $form->add_row("Please enter descriptive information for this location.", NULL,
          $form->add_input_text(3, "location_name", "Location Name", NULL, NULL, TRUE, NULL),
          $form->add_input_text(3, "location_description", "Location Description", NULL, NULL, FALSE, NULL)
          );

          $form->add_row("Please enter the location's information below.", NULL,
          $form->add_input_text(2, "address", "Address", NULL, NULL, TRUE, NULL),
          $form->add_input_text(2, "city", "City", NULL, NULL, TRUE, NULL),
          $form->add_input_text(2, "state", "State", NULL, NULL, TRUE, NULL),
          $form->add_input_text(2, "zip", "Zip Code", NULL, NULL, TRUE, NULL),
          $form->add_input_text(2, "longitude", "Longitude (X)", NULL, NULL, TRUE, NULL),
          $form->add_input_text(2, "latitude", "Latitude (Y)", NULL, NULL, TRUE, NULL)
          );

          $form->add_row(NULL, NULL,
            $form->add_input_submit("manual")
          );

          $card->set_card_body($error, $success, $form->print());
          $_SESSION['disabled_indexes'] = $form->get_disabled_indexes();

          echo
          // print_row() can take an unlimited amount of parameters of print().
          $card->print_row($card->get_card_body());
        }

        App\General::root_include('private/admin/pages/intelligence/locations/includes/backend/add.php');
        ?>
    </section>

    <?php
    App\General::root_include('private/admin/app/includes/scripts/countdowntimer.php');
    App\General::root_include('private/admin/app/includes/scripts/scripts.php');
    ?>

</body>

</html>
