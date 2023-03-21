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

        <?php
        function renderForm($error = null, $success = null)
        {
          // Begin Geolocation Services
          $card = new Admin\Cards;
          $form = new Admin\Forms;

          $card->set_card_title("Add Guidelines"); // A NULL card title and "false" card menu will hide the card header entirely.
          $card->set_card_sub_title("Use this resource to provide standard guidance on which actions should be taken for certain weather conditions.");
          $card->set_card_menu(false); // True will show the menu, False will hide it.

          // Input fields are in the form of ("size", "name", "Label", "value", help, required?, "permission_required")
          $form->add_row(NULL, NULL,
          $form->add_input_text_label(4, "temperature_min", "When temperature is above", "°F", NULL, NULL, NULL, NULL),
          $form->add_input_text_label(3, "temperature_max", "and/or Below", "°F", NULL, NULL, NULL, NULL),
          $form->add_input_text_label(5, "temperature_constraint", "Then", NULL, NULL, "(Eg. Enforce hydration)", NULL, NULL)
          );

          $form->add_row("When forecast is", NULL,
          $form->add_input_text_label(2, "forecast_description", "Above", "°F", NULL, NULL, NULL, NULL),
          $form->add_input_text_label(7, "forecast_constraint", "Then", NULL, NULL, "(Eg. Relocate PT to Garage)", NULL, NULL)
          );


          $form->add_row(NULL, NULL,
            $form->add_input_submit("submit", "ADD GUIDELINE")
          );

          $card->set_card_body($error, $success, $form->print());
          $_SESSION['disabled_indexes'] = $form->get_disabled_indexes();

          echo
          // print_row() can take an unlimited amount of parameters of print().
          $card->print_row($card->get_card_body());
        }

        App\General::root_include('private/admin/pages/intelligence/guidelines/includes/backend/add.php');
        ?>
    </section>


    <?php
    App\General::root_include('private/admin/app/includes/scripts/scripts.php');
    App\General::root_include('private/admin/app/includes/scripts/countdowntimer.php');
    ?>
</body>

</html>
