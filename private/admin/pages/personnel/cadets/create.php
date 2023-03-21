<!DOCTYPE html>
<html>
<?php
App\General::class_include('class.Alerts.php');
App\General::class_include('class.Cards.php');
App\General::class_include('class.Forms.php');
App\General::class_include('class.MSL.php');
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
          $card = new Admin\Cards;
          $form = new Admin\Forms;

          $card->set_card_title("Create Cadet"); // A NULL card title and "false" card menu will hide the card header entirely.
          $card->set_card_sub_title("Add a new cadet to the Tiger Battalion database.");
          $card->set_card_menu(false); // True will show the menu, False will hide it.

          // Input fields are in the form of ("name", "Label", "value", "helper text", "permission_required")
          $form->add_row("Please enter the cadet's contact information below.", NULL,
          $form->add_input_text(2, "first_name", "First Name", NULL, NULL, TRUE, NULL),
          $form->add_input_text(2, "middle_name", "Middle Name", NULL, NULL, FALSE, NULL),
          $form->add_input_text(2, "last_name", "Last Name", NULL, NULL, TRUE, NULL),
          $form->add_input_text(2, "email", "Email Address", NULL, NULL, FALSE, NULL),
          $form->add_input_text(2, "phone_number", "Phone Number", NULL, NULL, FALSE, NULL)
          );

          // Select fields are in the form of ("name", values, currently selected, "permission_required")
          $form->add_row("Please enter the cadet's unit information below or leave it blank.", NULL,
          $form->add_input_text(2, "high_school", "High School", NULL, NULL, FALSE, NULL),
          $form->add_select("campus", array("Memphis%University of Memphis", "Rhodes%Rhodes", "CBU%CBU"), NULL, NULL),
          $form->add_select("msl", Admin\MSL::get_select(), NULL, NULL)
          );

          $form->add_row(NULL, NULL,
            $form->add_input_submit()
          );

          $card->set_card_body($error, $success, $form->print());
          $_SESSION['disabled_indexes'] = $form->get_disabled_indexes();

          echo
          // print_row() can take an unlimited amount of parameters of print().
          $card->print_row($card->get_card_body());
        }

        App\General::root_include('private/admin/pages/personnel/cadets/includes/backend/create.php');
        ?>
    </section>

    <?php
    App\General::root_include('private/admin/app/includes/scripts/countdowntimer.php');
    App\General::root_include('private/admin/app/includes/scripts/scripts.php');
    ?>

</body>

</html>
