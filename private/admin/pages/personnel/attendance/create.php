<!DOCTYPE html>
<html>
<?php
App\General::class_include('class.Alerts.php');
App\General::class_include('class.Cards.php');
App\General::class_include('class.Forms.php');
App\General::class_include('class.MSL.php');
App\General::class_include('class.User.php');
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

          $card->set_card_title("Create Attendance"); // A NULL card title and "false" card menu will hide the card header entirely.
          $card->set_card_sub_title("Add a new attendance record to the Tiger Battalion database.");
          $card->set_card_menu(false); // True will show the menu, False will hide it.

          // Input fields are in the form of ("name", "Label", "value", "helper text", "permission_required")
          $form->add_row("Please enter the details of this attendance log below.", NULL,
          $form->add_select("type", array("PT%Physical Training (PT)", "LAB%Lab", "RECRUITING%Recruiting", "ORIENTATION%Orientation", "FUN%Fun", "OTHER%Other"), NULL, TRUE, NULL, "Type of event"),
          $form->add_select("mandatory", array("1%Mandatory", "0%Optional"), NULL, TRUE, NULL, "Is it mandatory?"),
          $form->add_select("point_of_contact", Admin\User::get_users(), NULL, NULL, NULL, "Point of Contact"),
          $form->add_input_time(4, "accountability_begin", "Accountability Starts", "06:45", "Ex. HH:MM", FALSE, NULL),
          $form->add_input_time(4, "accountability_end", "Accountability Ends", "07:00", "Ex. HH:MM", FALSE, NULL),
          $form->add_input_date(3, "timestamp", "Date", date("m/d/o"), "Ex. DD/MM/YYYY")
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

        App\General::root_include('private/admin/pages/personnel/attendance/includes/backend/create.php');
        ?>
    </section>

    <?php
    App\General::root_include('private/admin/app/includes/scripts/countdowntimer.php');
    App\General::root_include('private/admin/app/includes/scripts/scripts.php');
    ?>

    <!-- Autosize Plugin Js -->
    <script src="../../../plugins/autosize/autosize.js"></script>
    <!-- Moment Plugin Js -->
    <script src="../../../plugins/momentjs/moment.js"></script>
    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="../../../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <!-- Custom Js -->
    <script src="../../../js/pages/forms/basic-form-elements.js"></script>
    <!-- Bootstrap Datepicker Plugin Js -->
    <script src="../../../plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

</body>

</html>
