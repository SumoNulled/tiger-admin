<!DOCTYPE html>
<html>
<!-- Bootstrap Material Datetime Picker Css -->
<link href="../../../plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

<!-- Bootstrap DatePicker Css -->
<link href="../../../plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
<?php
App\General::class_include('class.Alerts.php');
App\General::class_include('class.Attendance.php');
App\General::class_include('class.Cards.php');
App\General::class_include('class.Forms.php');
App\General::class_include('class.Tables.php');
App\General::class_include('class.User.php');

use Admin\User as Personnel;
?>
<?php App\General::root_include('private/admin/app/includes/head.php'); ?>
<?php echo App\General::link(App\General::getAdminRoot() . "plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css"); ?>

<body class="<?php print_r(App\Phrases::get('theme_color')); ?>">
    <?php App\General::root_include('private/admin/app/includes/pageloader.php'); ?>

    <?php App\General::root_include('private/admin/app/includes/topbar.php'); ?>

    <section>
      <?php App\General::root_include('private/admin/app/includes/leftsb.php'); ?>

      <?php App\General::root_include('private/admin/app/includes/rightsb.php'); ?>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
              <div class="alert bg-black">
                  To request access to this resource, contact the S-1 shop.
              </div>
            </div>
            <?php
            function update_attendance($_ARRAY = array(), $error = null, $success = null)
            {


              echo "<select name=\"present[]\" class=\"form-control show-tick\" title=\"Select all present personnel\" data-live-search=\"true\" data-selected-text-format=\"count\" tabindex=\"-98\" multiple>";

                    $personnel = new Personnel();
                    foreach(App\SQL::row("SELECT * FROM personnel_attendance AS m JOIN personnel as p ON p.id = m.cadet_id WHERE m.attendance_id = {$_ARRAY['id']} ORDER BY p.last_name") as $row)
                    {
                      $personnel->setID($row['id']);
                      $_values[] = $personnel->getID() . "%" . $personnel->print_name();
                      if ($row['status'] == "PRESENT" || $row['status'] == "EXCUSED" || $row['status'] == "TARDY")
                      {
                        $selected = "selected";
                      } else {
                        $selected = "";
                      }
                      echo "<option {$selected} value='{$personnel->getID()}'>{$personnel->print_name()}</option>";
                    }
                echo "</select>";

              /* Attendance Log Editing */
              $card = new Admin\cards;
              $form = new Admin\forms;
              $table = new Admin\Tables;

              $attendance = new Admin\Attendance($_ARRAY['id']);

              $card->set_card_title("Update Attendance Log for ID #" . $attendance->get_id() . " "); // A NULL card title and "false" card menu will hide the card header entirely.
              $card->set_card_sub_title("On this day, <b>{$attendance->in_attendance()} out of {$attendance->personnel_count()} ({$attendance->in_attendance_percent()}%)</b> cadets were present, tardy, or excused. <br />Last altered: <b>" . date("F d, Y @ g:i A", strtotime($_ARRAY['last_edited'])) . "</b>");


              $table->set_table_head(
                "Cadet ID,
                Cadet Name,
                Status"
              );
              $table->set_table_footer(false);
              $user = new Admin\User;
              // Begin building the table body.
              foreach(App\SQL::row("SELECT * FROM personnel_attendance AS m JOIN personnel as p ON p.id = m.cadet_id WHERE m.attendance_id = {$_ARRAY['id']} ORDER BY p.last_name") as $row)
              {
                $user->setID($row['cadet_id']);
                $table->add_table_row(
                  array(
                    "<center>" . $row['cadet_id'] . "</center>" . "<input type='hidden' name='id[]' value='{$row['cadet_id']}'/>",
                    $user->print_name(1) . "<br><small>({$user->get_unit()})</small>",
                    $form->add_select_size(12, "status[]", array("PRESENT%Present", "TARDY%Tardy", "ABSENT%Absent", "EXCUSED%Excused"), $row['status'], FALSE, NULL)
                  )
                );
              }
              $form->add_row(NULL, NULL,
              $form->add_input_submit("update_attendance", "UPDATE", "bg-brown", 12, "personnel_attendance_submit"),
              );
              $form->add_row($table->print());
              $form->add_row(NULL, NULL,
              $form->add_input_submit("update_attendance", "UPDATE", "bg-brown", 12, "personnel_attendance_submit")
              );
              $card->set_card_body(
                $error,
                $success,
                $form->print());

              $_SESSION['disabled_indexes'] = $form->get_disabled_indexes();
              echo
              // print_row() can take an unlimited amount of parameters of print().
              $card->print_row($card->get_card_body());
            }

            function renderForm($_ARRAY = array(), $error = null, $success = null)
            {
              $card = new Admin\Cards;
              $form = new Admin\Forms;
              $form->set_name("attendance");

              $attendance = new Admin\Attendance($_ARRAY['id']);

              $card->set_card_title("Editing Attendance Log #" . $attendance->get_id()); // A NULL card title and "false" card menu will hide the card header entirely.
              $card->set_card_sub_title("Last altered: <b>" . date("F d, Y @ g:i A", strtotime($_ARRAY['last_edited'])) . "</b>");

              // Input fields are in the form of ("size", "name", "Label", "value", "permission_required")
              $form->add_row("Location Information", NULL,
              $form->add_input_text(2, "id", "Attendance ID", $_ARRAY['id'], NULL, TRUE, "attendance_edit_id"),
              $form->add_select("type", array("PT%Physical Training (PT)", "LAB%Lab", "RECRUITING%Recruiting", "ORIENTATION%Orientation", "FUN%Fun", "OTHER%Other"), $_ARRAY['type'], TRUE, NULL, "Type of Event"),
              $form->add_select("mandatory", array("1%Mandatory", "0%Optional"), $_ARRAY['mandatory'], TRUE, NULL, "Mandatory or Optional"),
              $form->add_select("point_of_contact", Admin\User::get_users(), $_ARRAY['point_of_contact'], NULL, NULL, "Point of Contact")
              );

              $form->add_row("Date & Time Information", NULL,
              $form->add_input_time(4, "accountability_begin", "Accountability Starts", $_ARRAY['accountability_begin'], "Ex. HH:MM", FALSE, NULL),
              $form->add_input_time(4, "accountability_end", "Accountability Ends", $_ARRAY['accountability_end'], "Ex. HH:MM", FALSE, NULL),
              $form->add_input_date(3, "timestamp", "Date", date("m/d/o", strtotime($_ARRAY['timestamp'])), "Ex. DD/MM/YYYY")
              );

              $form->add_row(NULL, NULL,
              $form->add_input_submit("submit", "UPDATE", "bg-brown", 12, "personnel_attendance_submit")
              );

              $form->add_row(NULL, NULL,
              $form->add_input_submit("delete", "DELETE", "bg-red", 12, "personnel_attendance_submit")
              );

              $card->set_card_body(
                $error,
                $success,
                $form->print());

              $_SESSION['disabled_indexes'] = $form->get_disabled_indexes();
              echo
              // print_row() can take an unlimited amount of parameters of print().
              $card->print_row($card->get_card_body());
              }

            App\General::root_include('private/admin/pages/personnel/attendance/includes/backend/edit.php');
            ?>

        </div>
    </section>

    <?php
    App\General::root_include('private/admin/app/includes/scripts/countdowntimer.php');
    App\General::root_include('private/admin/app/includes/scripts/scripts.php');
    App\General::root_include('private/admin/app/includes/scripts/select.php');
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
