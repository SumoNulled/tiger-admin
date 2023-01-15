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
App\General::class_include('class.CCFA.php');
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
            function renderForm($_ARRAY = array(), $error = null, $success = null)
            {
              /* assessments Log Editing */
              $card = new Admin\cards;
              $form = new Admin\forms;
              $table = new Admin\Tables;

              $assessments = new Admin\Assessments($_ARRAY['id']);
              $ccfa = new Admin\CCFA($_ARRAY['id']);

              $card->set_card_title("Update Assessments Log for ID #" . $assessments->get_id() . " "); // A NULL card title and "false" card menu will hide the card header entirely.
              $card->set_card_sub_title("On this day, <b>{$ccfa->record_pass()} out of {$ccfa->personnel_count()} ({$ccfa->record_pass_percent()}%)</b> cadets passed the CCFA.");


              $table->set_table_head(
                "Cadet Name,
                Push Ups,
                Curl Ups,
                One Mile Run,
                Pass/Fail,
                Gender"
              );
              $table->set_table_footer(false);
              $user = new Admin\User;
              $ccfa = new Admin\CCFA;
              // Begin building the table body.
              foreach(App\SQL::row("SELECT * FROM personnel_ccfa_scores AS m JOIN personnel as p ON p.id = m.cadet_id WHERE m.assessment_id = {$_ARRAY['id']} ORDER BY p.last_name") as $row)
              {
                $user->setID($row['cadet_id']);
                $ccfa->set_gender($user->gender());
                $table->add_table_row(
                  array(
                    $user->print_name(1) . "<br><small>({$user->get_unit()})</small>",
                    $row['push_ups'] >= $ccfa->get_pu_min() ? $row['push_ups'] : "<font color='red'>" . $row['push_ups'] . "</font>" . "<br /><small> (Min: {$ccfa->get_pu_min()})</small>",
                    $row['curl_ups'] >= $ccfa->get_cu_min() ? $row['curl_ups'] : "<font color='red'>" . $row['curl_ups'] . "</font>" . "<br /><small> (Min: {$ccfa->get_cu_min()})</small>",
                    $row['one_mile_run'] <= $ccfa->get_omr_min() ? gmdate('i:s', $row['one_mile_run']) : "<font color='red'>" . gmdate('i:s', $row['one_mile_run']) . "</font>" . "<br /><small> (Min: ". gmdate('i:s', $ccfa->get_omr_min()) . ")</small>",
                    $ccfa->print_status($row['status']),
                    $user->gender()
                  )
                );
              }

              $form->add_row($table->print());
              $card->set_card_body(
                $error,
                $success,
                $form->print());

              $_SESSION['disabled_indexes'] = $form->get_disabled_indexes();
              echo
              // print_row() can take an unlimited amount of parameters of print().
              $card->print_row($card->get_card_body());
            }

            App\General::root_include('private/admin/pages/personnel/assessments/ccfa/includes/backend/read.php');
            ?>

        </div>
    </section>

    <?php
    App\General::root_include('private/admin/app/includes/scripts/countdowntimer.php');
    App\General::root_include('private/admin/app/includes/scripts/scripts.php');
    App\General::root_include('private/admin/app/includes/scripts/select.php');
      App\General::root_include('private/admin/app/includes/scripts/jquerydatatable.php');
    ?>
</body>

</html>
