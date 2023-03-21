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
App\General::class_include('class.ACFT.php', 'ACFT');
use Admin\ACFT as ACFT;
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

              $card->set_card_title("Update Assessments Log for ID #" . $assessments->get_id() . " "); // A NULL card title and "false" card menu will hide the card header entirely.
              //$card->set_card_sub_title("On this day, <b>{$ccfa->record_pass()} out of {$ccfa->personnel_count()} ({$ccfa->record_pass_percent()}%)</b> cadets passed the ACFT.");

              /*$table->set_table_head(
                "Cadet Name,
                MDL,
                SPT,
                HRP,
                SDC,
                PLK,
                2MR,
                Ability Group,
                TOTAL,
                PASS/FAIL,
                MSL,
                GENDER"
             );*/
            $table->set_table_head("Cadet Name, 2MR, Ability Group, MSL, Gender");
              $table->set_table_footer(false);
              $user = new Admin\User;
              //$ccfa = new Admin\CCFA;
              // Begin building the table body.
              $acft = new ACFT();
              foreach(App\SQL::row("SELECT * FROM personnel_acft_scores AS m JOIN personnel as p ON p.id = m.cadet_id WHERE m.assessment_id = {$_ARRAY['id']} ORDER BY p.last_name") as $row)
              {
                $user->setID($row['cadet_id']);
                $acft->set_personnel_id($user->getID());
                $acft->set_score_mdl($row['mdl']);
                $acft->set_score_spt($row['spt']);
                $acft->set_score_hrp($row['hrp']);
                $acft->set_score_sdc($row['sdc']);
                $acft->set_score_plk($row['plk']);
                $acft->set_score_tmr($row['tmr']);
                $total = $acft->mdl_score() + $acft->spt_score() + $acft->hrp_score() + $acft->sdc_score() + $acft->plk_score() + $acft->tmr_score();

                $agr = 'C';
                if ($user->gender() == 'M')
                {
                  switch($acft->tmr_score())
                  {
                    case ($acft->tmr_score() <= 100 && $acft->tmr_score() >= 85):
                    $agr = 'A';
                    break;

                    case ($acft->tmr_score() <= 84 && $acft->tmr_score() >= 75):
                    $agr = 'B';
                    break;

                    case ($acft->tmr_score() <= 74 && $acft->tmr_score() >= 60):
                    $agr = 'C';
                    break;

                    case ($acft->tmr_score() < 60):
                    $agr = 'D';
                    break;

                    default:
                    $agr = 'C';
                    break;
                  }
                }

                if ($user->gender() == 'F')
                {
                  switch($acft->tmr_score())
                  {
                    case ($acft->tmr_score() <= 100 && $acft->tmr_score() >= 98):
                    $agr = 'A';
                    break;

                    case ($acft->tmr_score() <= 97 && $acft->tmr_score() >= 90):
                    $agr = 'B';
                    break;

                    case ($acft->tmr_score() <= 89 && $acft->tmr_score() >= 64):
                    $agr = 'C';
                    break;

                    case ($acft->tmr_score() < 64):
                    $agr = 'D';
                    break;

                    default:
                    $agr = 'C';
                    break;
                  }
                }

                $table->add_table_row(
                 array(
                    $user->print_name(1),
                    //$acft->mdl_score(),
                    //$acft->spt_score(),
                    //$acft->hrp_score(),
                    //$acft->sdc_score(),
                    //$acft->plk_score(),
                    $acft->tmr_score() . "\n<small>{$row['tmr']}</small>",
                    $agr,
                    //$total,
                    //$acft->print_status($row['status']),
                    'MS' . $row['msl'],
                    $user->gender()
                  )
//array($user->print_name(1), $row['mdl'], $row['spt'], $row['hrp'], $row['sdc'], $row['plk'], $row['tmr'], $total, $acft->print_status($row['status']), 'MS' . $row['msl'], $user->gender())

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

            App\General::root_include('private/admin/pages/personnel/assessments/acft/includes/backend/read.php');
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
