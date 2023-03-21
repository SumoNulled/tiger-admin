<!DOCTYPE html>
<html>
<!-- Bootstrap Material Datetime Picker Css -->
<link href="../../../plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

<!-- Bootstrap DatePicker Css -->
<link href="../../../plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
<?php
App\General::class_include('class.Alerts.php');
App\General::class_include('class.Assessments.php');
App\General::class_include('class.Cards.php');
App\General::class_include('class.ACFT.php', 'ACFT');
App\General::class_include('class.Forms.php');
App\General::class_include('class.Tables.php');
App\General::class_include('class.User.php');
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
              function add_cadets($_ARRAY = array(), $error = null, $success = null)
              {
                $card = new Admin\cards;
                $card->set_card_menu(false); // True will show the menu, False will hide it.
                $table = new Admin\Tables;

                $form = new Admin\forms;
                $table->set_table_head(
                  "Scores@6"
                );
                $table->set_table_footer(false);
                $form->add_row($form->add_select_search("id[]", Admin\User::get_users(), NULL, NULL, NULL));
                $table->add_table_row(
                array(
                  $form->add_input_text(12, "height[]", "Height", NULL, NULL, NULL, NULL),
                  $form->add_input_text(12, "weight[]", "Weight", NULL, NULL, NULL, NULL),
                  $form->add_input_text(12, "mdl[]", "MDL", NULL, NULL, TRUE, NULL),
                  $form->add_input_text(12, "spt[]", "SPT", NULL, NULL, TRUE, NULL),
                  $form->add_input_text(12, "hrp[]", "HRP", NULL, NULL, NULL, NULL),
                  $form->add_input_text(12, "sdc[]", "SDC", NULL, NULL, NULL, NULL),
                  $form->add_input_text(12, "plk[]", "PLK", NULL, NULL, NULL, NULL),
                  $form->add_input_text(12, "tmr[]", "2MR", NULL, NULL, NULL, NULL)
                ),
                );

                $assessments = new Admin\Assessments($_ARRAY['id']);
                //$ccfa = new Admin\CCFA($_ARRAY['id']);

                $card->set_card_title("Add a cadet to this assessment log."); // A NULL card title and "false" card menu will hide the card header entirely.
                $form->add_row($table->print());
                $form->add_row(NULL, NULL,
                $form->add_input_submit("add_cadet", "ADD CADET", "bg-brown", 12, NULL)
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
            ?>
            <?php
            function update_assessments($_ARRAY = array(), $error = null, $success = null)
            {
              /* assessments Log Editing */
              $card = new Admin\cards;
              $form = new Admin\forms;
              $table = new Admin\Tables;

              $assessments = new Admin\Assessments($_ARRAY['id']);
              $acft = new Admin\ACFT($_ARRAY['id']);

              $card->set_card_title("Update Assessments Log for ID #" . $assessments->get_id() . " "); // A NULL card title and "false" card menu will hide the card header entirely.
              $card->set_card_sub_title("On this day, <b>{$acft->pass_count()} out of {$acft->personnel_count()} ({$acft->pass_percent()}%)</b> cadets passed the ACFT.");

              $table->set_table_head(
                "Cadet ID,
                Cadet Name,
                Scores@6,
                Pass/Fail,
                Manage"
              );
              $table->set_table_footer(false);
              $user = new Admin\User;
              // Begin building the table body.
              foreach(App\SQL::row("SELECT * FROM personnel_acft_scores AS m JOIN personnel as p ON p.id = m.cadet_id WHERE m.assessment_id = {$_ARRAY['id']} ORDER BY p.last_name") as $row)
              {
                $user->setID($row['cadet_id']);
                $table->add_table_row(
                  array(
                    "<center>" . $row['cadet_id'] . "</center>" . "<input type='hidden' name='id[]' value='{$row['cadet_id']}'/>",
                    $user->print_name(1) . "<br><small>({$user->get_unit()})</small>",
                    $form->add_input_text(12, "mdl[]", "MDL", $row['mdl'], NULL, TRUE, NULL),
                    $form->add_input_text(12, "spt[]", "SPT", $row['spt'], NULL, TRUE, NULL),
                    $form->add_input_text(12, "hrp[]", "HRP", $row['hrp'], NULL, NULL, NULL),
                    $form->add_input_text(12, "sdc[]", "SDC", $row['sdc'], NULL, NULL, NULL),
                    $form->add_input_text(12, "plk[]", "PLK", $row['plk'], NULL, NULL, NULL),
                    $form->add_input_text(12, "tmr[]", "2MR", $row['tmr'], NULL, NULL, NULL),
                    $acft->print_status($row['status']),
                    //$ccfa->print_manage($row['cadet_id'])
                  )
                );
              }
              $form->add_row(NULL, NULL,
              $form->add_input_submit("update_assessments", "UPDATE", "bg-brown", 12, NULL)
              );
              $form->add_row($table->print());
              $form->add_row(NULL, NULL,
              $form->add_input_submit("update_assessments", "UPDATE", "bg-brown", 12, NULL)
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
              $form->set_name("assessments");

              $assessments = new Admin\Assessments($_ARRAY['id']);

              $card->set_card_title("Editing Assessments Log #" . $assessments->get_id()); // A NULL card title and "false" card menu will hide the card header entirely.
              $card->set_card_sub_title("Last altered: <b>" . date("F d, Y @ g:i A", strtotime($_ARRAY['last_edited'])) . "</b>");

              // Input fields are in the form of ("size", "name", "Label", "value", "permission_required")
              $form->add_row("Assessment Information", NULL,
              $form->add_input_text(2, "id", "Assessment ID", $_ARRAY['id'], NULL, TRUE, "assessments_edit_id"),
              $form->add_input_text(2, "description", "Description", $_ARRAY['description'], NULL, NULL, NULL),
              $form->add_select_size(4, "type", array("CCFA%Cadet Command Fitness Assessment"), $_ARRAY['type'], TRUE, NULL, "Type of Assessment"),
              $form->add_select("record", array("1%For Record", "0%Diagnostic"), $_ARRAY['record'], TRUE, NULL, "Mandatory or Optional"),
              );

              $form->add_row("Assessment Leaders", NULL,
              $form->add_select("oic", Admin\User::get_users(), $_ARRAY['oic'], NULL, NULL, "OIC"),
              $form->add_select("ncoic", Admin\User::get_users(), $_ARRAY['ncoic'], NULL, NULL, "NCOIC")
              );

              $form->add_row("Date & Time Information", NULL,
              $form->add_input_date(3, "date", "Date", date("m/d/o", strtotime($_ARRAY['date'])), "Ex. DD/MM/YYYY")
              );

              $form->add_row(NULL, NULL,
              $form->add_input_submit("submit", "UPDATE", "bg-brown", 12, NULL)
              );

              $form->add_row(NULL, NULL,
              $form->add_input_submit("delete", "DELETE", "bg-red", 12, NULL)
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

            App\General::root_include('private/admin/pages/personnel/assessments/acft/includes/backend/edit.php');
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
