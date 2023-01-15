<!DOCTYPE html>
<html>
<?php
App\General::class_include('class.Cards.php');
App\General::class_include('class.Tables.php');
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
                  Stats here
              </div>
            </div>

            <?php
              $card = new Admin\Cards;
              $table = new Admin\Tables;

              $card->set_card_title("View Forecasts");
              $card->set_card_menu(false);
              $card->set_card_size(12);

              $table->set_table_head(
                "Guideline ID,
                Manage"
              );
              $table->set_table_footer(false);

              // Begin building the table body.
              foreach(App\SQL::row('SELECT * FROM intelligence_weather_guidelines') as $row)
              {
                $table->add_table_row(
                  array(
                      $row['id'],
                    "<a href='edit.php?id={$row['id']}'>Edit</a>"
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
