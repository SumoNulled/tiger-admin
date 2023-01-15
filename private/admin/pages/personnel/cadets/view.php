<!DOCTYPE html>
<html>
<?php
App\General::class_include('class.Cards.php');
App\General::class_include('class.MSL.php');
App\General::class_include('class.Tables.php');
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
                  Stats here
              </div>
            </div>

            <?php
              $card = new Admin\Cards;
              $table = new Admin\Tables;

              $card->set_card_title("View Cadets");
              $card->set_card_menu(false);
              $card->set_card_size(12);

              $table->set_table_head(
                "Name,
                Email,
                Phone Number,
                Position,
                Age,
                MSL,
                Manage"
              );
              $table->set_table_footer(false);
              $user = new Admin\User;
              // Begin building the table body.
              foreach(App\SQL::row('SELECT * FROM personnel') as $row)
              {
                $user ->setID($row['id']);
                $table->add_table_row(
                  array(
                    $user->print_name(1),
                    $row['email'],
                    App\General::format($row['phone_number'], 'phone_number'),
                    Admin\Positions::name($user->position()),
                    $user->age(),
                    Admin\MSL::abbreviation($row['msl']),
                    "<center>" . $table->add_manage_user($user->getID()) . "</center>"
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
