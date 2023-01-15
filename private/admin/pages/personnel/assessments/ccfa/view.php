<!DOCTYPE html>
<html>
<?php
App\General::class_include('class.Assessments.php');
App\General::class_include('class.Cards.php');
App\General::class_include('class.Positions.php');
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

              </div>
            </div>

            <?php
              $card = new Admin\Cards;
              $table = new Admin\Tables;

              $card->set_card_title("View Assessment Records");
              $card->set_card_menu(false);
              $card->set_card_size(12);

              $table->set_table_head(
                "ID,
                Type,
                Description,
                Record,
                OIC,
                NCOIC,
                Date,
                Manage"
              );
              $table->set_table_footer(false);
              // Begin building the table body.
              $assessment = new Admin\Assessments();
              $user = new Admin\User;

              foreach(App\SQL::row('SELECT * FROM structure_assessments') as $row)
              {

                $date = new App\Time($row['date']);

                $assessment->set_id($row['id']);

                $oic = new Admin\User($row['oic']);
                $ncoic = new Admin\User($row['ncoic']);
                $position = new Admin\Positions;

                $table->add_table_row(
                  array(
                    $row['id'],
                    $row['type'],
                    $row['description'],
                    $row['record'],
                    $oic->print_name(1) . "<br /><small>{$position->print($oic->position())}</small>",
                    $ncoic->print_name(1) . "<br /><small>{$position->print($ncoic->position())}</small>",
                    $date->print_date(),
                    "<center>" . $assessment->print_manage() . "</center>"
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
