<!DOCTYPE html>
<html>
<?php
App\General::class_include('class.Attendance.php');
App\General::class_include('class.Cards.php');
App\General::class_include('class.Tables.php');
App\General::class_include('class.Time.php');
App\General::class_include('class.User.php');
?>


<?php App\General::root_include('private/admin/app/includes/head.php'); ?>
<?php echo App\General::link(App\General::getAdminRoot() . "plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css"); ?>

<body class="<?php print_r(App\Phrases::get('theme_color')); ?>">
    <?php //App\General::root_include('private/admin/app/includes/pageloader.php'); ?>

    <?php App\General::root_include('private/admin/app/includes/topbar.php'); ?>

    <section>
      <?php App\General::root_include('private/admin/app/includes/leftsb.php'); ?>

      <?php App\General::root_include('private/admin/app/includes/rightsb.php'); ?>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
              <div class="alert bg-black">
                <?php
                $attendance = new Admin\Attendance;
                $average_attendance = $attendance->average();
                ?>
                The current overall attendance average is <?php echo "{$average_attendance}%" ;?>. This percentage does not include "OPTIONAL" days.
              </div>
            </div>

            <?php
              $card = new Admin\Cards;
              $table = new Admin\Tables;

              $card->set_card_title("View Attendance Records");
              $card->set_card_menu(false);
              $card->set_card_size(12);

              $table->set_table_head(
                "ID,
                Type,
                Mandatory,
                Point of Contact,
                Accountability Start,
                Accountability End,
                Date,
                Manage"
              );
              $table->set_table_footer(false);
              // Begin building the table body.
              $attendance = new Admin\Attendance();
              $user = new Admin\User;

              foreach(App\SQL::row('SELECT * FROM structure_attendance') as $row)
              {
                $accountability_begin = new App\Time($row['accountability_begin']);
                $accountability_end = new App\Time($row['accountability_end']);
                $date = new App\Time($row['timestamp']);

                $attendance->set_id($row['id']);
                $user->setID($row['point_of_contact']);

                $table->add_table_row(
                  array(
                    $row['id'],
                    $row['type'],
                    $attendance->print_mandatory(),
                    $user->print_name(1),
                    $accountability_begin->print_time(),
                    $accountability_end->print_time(),
                    $date->print_date(),
                    "<center>" . $attendance->print_manage() . "</center>"
                  ));
              }

              echo
              $card->print_row(

                  $table->print()

              );
            ?>
        </div>
    </section>

    <?php
    App\General::root_include('private/admin/app/includes/scripts/scripts.php');
    App\General::root_include('private/admin/app/includes/scripts/jquerydatatable.php');
    ?>
</body>

</html>
