<!DOCTYPE html>
<html>
<?php
App\General::class_include('class.Cards.php');
App\General::class_include('class.Positions.php');
App\General::class_include('class.Squads.php');
App\General::class_include('class.Tables.php');
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
        <div class="container-fluid">
            <div class="block-header">
              <!--<h2>BLANK PAGE</h2> -->
            </div>
        </div>
        <?php
          $card = new Admin\Cards;

          $card->set_card_title("<center>HEADQUARTERS & HEADQUARTERS COMPANY</center>");
          $card->set_card_menu(false);
          $card->set_card_size(12);
          $card->set_card_color("bg-black");

          $user = new Admin\User(2);
          $sql = "SELECT personnel.id FROM personnel INNER JOIN structure_positions ON personnel.position = structure_positions.id WHERE structure_positions.structure_type = 5 AND battalion = 1 ORDER BY personnel.position DESC;";
          foreach(App\SQL::row($sql) as $row)
          {
            $user->setID($row['id']);
            $array[] = $user->print_profile();
          }

          $card->set_card_body("<center>" . implode(" ", $array) . "</center>");
          unset($array);
          // $_SESSION['disabled_indexes'] = $form->get_disabled_indexes();
          echo
          // print_row() can take an unlimited amount of parameters of print().
          $card->print_row($card->get_card_body());
        ?>
        <div class="row clearfix">
        <?php
          $card = new Admin\Cards;

          $card->set_card_title("<center>A COMPANY</center>");
          $card->set_card_menu(false);
          $card->set_card_size(6);
          $card->set_card_color("bg-blue");

          $user = new Admin\User(2);
          $sql = "SELECT personnel.id FROM personnel INNER JOIN structure_positions ON personnel.position = structure_positions.id WHERE structure_positions.structure_type = 4 AND company = 1 ORDER BY personnel.position DESC;";
          foreach(App\SQL::row($sql) as $row)
          {
            $user->setID($row['id']);
            $array[] = $user->print_profile();
          }
          $card->set_card_body("<center>" . implode(" ", $array) . "</center>");
          unset($array);
          // $_SESSION['disabled_indexes'] = $form->get_disabled_indexes();
          echo
          // print_row() can take an unlimited amount of parameters of print().
          $card->print($card->get_card_body());
        ?>

        <?php
          $card = new Admin\Cards;

          $card->set_card_title("<center>RANGER COMPANY</center>");
          $card->set_card_menu(false);
          $card->set_card_size(6);
          $card->set_card_color("bg-red");

          $user = new Admin\User;
          $sql = "SELECT personnel.id FROM personnel INNER JOIN structure_positions ON personnel.position = structure_positions.id WHERE structure_positions.structure_type = 4 AND company = 3 ORDER BY personnel.position DESC;";
          foreach(App\SQL::row($sql) as $row)
          {
            $user->setID($row['id']);
            $array[] = $user->print_profile();
          }
          $card->set_card_body("<center>" . implode(" ", $array) . "</center>");
          unset($array);
          // $_SESSION['disabled_indexes'] = $form->get_disabled_indexes();
          echo
          // print_row() can take an unlimited amount of parameters of print().
          $card->print($card->get_card_body());
        ?>
      </div>

      <div class="row clearfix">
      <?php
        $card = new Admin\Cards;
        $table = new Admin\Tables;

        $card->set_card_title("<center>1ST Platoon</center>");
        $card->set_card_menu(false);
        $card->set_card_size(6);
        $card->set_card_color("bg-blue");

        $table->set_table_head(
          "Squad,
          Squad Leader,
          Squad Members@100"
        );
        $table->set_table_footer(false);
        // Begin building the table body.
        $user = new Admin\User;
        foreach(App\SQL::row('SELECT * FROM structure_squads WHERE platoon_id = 1') as $row)
        {
        $sql = "SELECT personnel.id AS 'user_id', structure_squads.id AS 'squad'
        FROM structure_squads
        LEFT JOIN personnel ON personnel.squad = structure_squads.id
        WHERE platoon_id = 1 AND personnel.position < 3 AND personnel.platoon = {$row['platoon_id']} AND personnel.squad = {$row['id']}";

        foreach(App\SQL::row($sql) as $x)
        {
          $user->setID($x['user_id']);
          $array[] = $user->print_name();
          $squad_leader = Admin\Squads::print_squad_leader($x['squad']);
        }

        array_unshift($array, $squad_leader);
        array_unshift($array, $row['abbreviation']);


          $table->add_table_row($array);
            unset($array);
        }

        $user = new Admin\User(2);
        $card->set_card_body($table->print());
        // $_SESSION['disabled_indexes'] = $form->get_disabled_indexes();
        echo
        // print_row() can take an unlimited amount of parameters of print().
        $card->print($card->get_card_body());
      ?>

      <?php
        $card = new Admin\Cards;

        $card->set_card_title("<center>RANGERS</center>");
        $card->set_card_menu(false);
        $card->set_card_size(6);
        $card->set_card_color("bg-red");

        // Begin building the table body.
        $user = new Admin\User;
        foreach(App\SQL::row('SELECT * FROM structure_squads WHERE platoon_id = 1') as $row)
        {
        $sql = "SELECT personnel.id AS 'user_id', structure_squads.id AS 'squad'
        FROM structure_squads
        LEFT JOIN personnel ON personnel.squad = structure_squads.id
        WHERE platoon_id = 1 AND personnel.position < 3 AND personnel.platoon = {$row['platoon_id']} AND personnel.squad = {$row['id']}";

        foreach(App\SQL::row($sql) as $x)
        {
          $user->setID($x['user_id']);
          $array[] = $user->print_name();
          $squad_leader = Admin\Squads::print_squad_leader($x['squad']);
        }

        array_unshift($array, $squad_leader);
        array_unshift($array, $row['abbreviation']);


          $table->add_table_row($array);
            unset($array);
        }
        $card->set_card_body($table->print());
        // $_SESSION['disabled_indexes'] = $form->get_disabled_indexes();
        echo
        // print_row() can take an unlimited amount of parameters of print().
        $card->print($card->get_card_body());
      ?>
    </div>
    <?php
      $card = new Admin\Cards;

      $card->set_card_title("<center>2ND PLATOON</center>");
      $card->set_card_menu(false);
      $card->set_card_size(6);

      $user = new Admin\User(2);
      $card->set_card_body($user->print_profile());
      // $_SESSION['disabled_indexes'] = $form->get_disabled_indexes();
      echo
      // print_row() can take an unlimited amount of parameters of print().
      $card->print_row($card->get_card_body());
    ?>
    </section>

    <?php App\General::root_include('private/admin/app/includes/scripts/scripts.php'); ?>

</body>

</html>
