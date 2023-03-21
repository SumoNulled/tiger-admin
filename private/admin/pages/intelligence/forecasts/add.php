<!DOCTYPE html>
<html>
<!-- Bootstrap Material Datetime Picker Css -->
<link href="../../../plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

<!-- Bootstrap DatePicker Css -->
<link href="../../../plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
<?php
App\General::class_include('class.Alerts.php');
App\General::class_include('class.Cards.php');
App\General::class_include('class.Forms.php');
App\General::class_include('class.Locations.php');
?>

<?php App\General::root_include('private/admin/app/includes/head.php'); ?>

<body class="<?php print_r(App\Phrases::get('theme_color')); ?>">
    <?php// App\General::root_include('private/admin/app/includes/pageloader.php'); ?>

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

          $card->set_card_title("Retrieve Weather Forecast"); // A NULL card title and "false" card menu will hide the card header entirely.
          $card->set_card_sub_title("Use the weather.gov API service to retrieve forecast information for a specific location at a specific time.");
          $card->set_card_menu(false); // True will show the menu, False will hide it.

          // Input fields are in the form of ("size", "name", "Label", "value", required?, "permission_required")
          $form->add_row("Please enter descriptive information for this location.", NULL,
          $form->add_select("location_id", App\Locations::get_select(), NULL, TRUE, NULL),
          $form->add_input_date(3, "date", "Date", date("m/d/o"), "Ex. DD/MM/YYYY"),
          $form->add_input_time(3, "time", "Time", "00:00", "Ex. HH:MM", FALSE, NULL)
          );


          $form->add_row(NULL, NULL,
            $form->add_input_submit("submit", "RETRIEVE FORECAST")
          );

          $card->set_card_body($error, $success, $form->print());
          $_SESSION['disabled_indexes'] = $form->get_disabled_indexes();

          echo
          // print_row() can take an unlimited amount of parameters of print().
          $card->print_row($card->get_card_body());
        }

        function renderPTWeather($error = null, $success = null)
        {
          $card = new Admin\Cards;
          $form = new Admin\Forms;

          $card->set_card_title("Forecast Templates");
          $card->set_card_sub_title("Select from pre-defined forecast templates. To add a new template, contact your system administrator.");

          $form->add_row(NULL, NULL,
            $form->add_input_submit("pt_weather", "PT Weather Forecast (Next 3 PT Days)", "bg-blue", 4)
          );

          $card->set_card_body($error, $success, $form->print());
          $_SESSION['disabled_indexes'] = $form->get_disabled_indexes();

          echo
          // print_row() can take an unlimited amount of parameters of print().
          $card->print_row($card->get_card_body());
        }

        App\General::root_include('private/admin/pages/intelligence/forecasts/includes/backend/add.php');
        ?>
    </section>
    <?php
    App\General::root_include('private/admin/app/includes/scripts/scripts.php');
    App\General::root_include('private/admin/app/includes/scripts/countdowntimer.php');
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
