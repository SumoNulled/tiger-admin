<!DOCTYPE html>
<html>
!-- Bootstrap Material Datetime Picker Css -->
<link href="../../../plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

<!-- Bootstrap DatePicker Css -->
<link href="../../../plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
<?php
App\General::class_include('class.Alerts.php');
App\General::class_include('class.Battalions.php');
App\General::class_include('class.Cards.php');
App\General::class_include('class.Companies.php');
App\General::class_include('class.Forms.php');
App\General::class_include('class.MSL.php');
App\General::class_include('class.Platoons.php');
App\General::class_include('class.Positions.php');
App\General::class_include('class.Ranks.php');
App\General::class_include('class.Squads.php');
App\General::class_include('class.Teams.php');
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
              <div class="alert bg-black">
                  To request access to this resource, contact the S-1 shop.
              </div>
            </div>

            <?php

            function renderForm($_ARRAY = array(), $error = null, $success = null)
            {
              $card = new Admin\Cards;
              $form = new Admin\Forms;

              $generate = new Admin\Forms;
              $generate->set_action("includes/backend/generate.php");
              $generate->set_name("generate");

              $user = new Admin\User($_ARRAY['id']);

              $card->set_card_title("Editing " . $user->print_name()); // A NULL card title and "false" card menu will hide the card header entirely.
              $card->set_card_sub_title("Last altered: <b>" . date("F d, Y @ g:i A", strtotime($_ARRAY['last_edited'])) . "</b>");

              $u = $user->username();
              $p = $user->password();

              $card->set_card_menu(true); // True will show the menu, False will hide it.
              if (empty($u))
              {

                empty($u) ? $u = $generate->add_button("Generate Username", "#", "username", $user->getID()) : $u = "";

                $card->add_card_menu_item(
                  App\General::anchor($u)
                );
              }

              $p = $generate->add_button("Generate Password", "#", "password", $user->getID());
              $card->add_card_menu_item(
                App\General::anchor($p)
              );

              // Input fields are in the form of ("size", "name", "Label", "value", help, field required, "permission_required")
              $form->add_row("Account Information", "cadets_view_account_information",
              $form->add_input_text(1, "id", "ID", $_ARRAY['id'], NULL, TRUE, "cadets_edit_account_information_id"),
              $form->add_input_text(2, "username", "Account Username", $_ARRAY['username'], NULL, FALSE, "cadets_edit_account_information_username"),
              $form->add_input_text(3, "temp_password", "Temporary Password", $_ARRAY['temp_password'], NULL, FALSE, "cadets_edit_account_information_temp"),
              $form->add_input_date(3, "dob", "Date of Birth", date("m/d/Y", strtotime($_ARRAY['dob'])), "Ex. MM/DD/YYYY"),
              $form->add_select("gender", array("M%Male", "F%Female"), $_ARRAY['gender'], FALSE, NULL)
              );

              $form->add_row("Contact Information", "cadets_view_contact_information",
              $form->add_input_text(2, "first_name", "First Name", $_ARRAY['first_name'], NULL, FALSE, "cadets_edit_contact_information_first_name"),
              $form->add_input_text(2, "middle_name", "Middle Name", $_ARRAY['middle_name'], NULL, FALSE, "cadets_edit_contact_information_middle_name"),
              $form->add_input_text(2, "last_name", "Last Name", $_ARRAY['last_name'], NULL, FALSE, "cadets_edit_contact_information_last_name"),
              $form->add_input_text(2, "email", "Email Address", $_ARRAY['email'], NULL, FALSE, "cadets_edit_contact_information_email"),
              $form->add_input_text(2, "phone_number", "Phone Number", $_ARRAY['phone_number'], NULL, FALSE, "cadets_edit_contact_information_phone_number")
              );

              // Select fields are in the form of ("name", values, currently selected, "permission_required")
              $form->add_row("Rank Information", "cadets_view_rank_information",
              $form->add_select("rank", Admin\Ranks::get_select(), $_ARRAY['rank'], FALSE, "cadets_edit_rank_information_rank"),
              $form->add_select("position", Admin\Positions::get_select(), $_ARRAY['position'], FALSE, "cadets_edit_rank_information_position"),
              $form->add_select("msl", Admin\MSL::get_select(), $_ARRAY['msl'], FALSE, "cadets_edit_rank_information_msl")
              );

              $form->add_row("Unit Information", "cadets_view_unit_information",
              $form->add_select("battalion", Admin\Battalions::get_select(), $_ARRAY['battalion'], FALSE, "cadets_edit_unit_information_battalion"),
              $form->add_select("company", Admin\Companies::get_select(), $_ARRAY['company'], FALSE, "cadets_edit_unit_information_company"),
              $form->add_select("platoon", Admin\Platoons::get_select(), $_ARRAY['platoon'], FALSE, "cadets_edit_unit_information_platoon"),
              $form->add_select("squad", Admin\Squads::get_select_manual(), $_ARRAY['squad'], FALSE, "cadets_edit_unit_information_squad")
              );

              $form->add_row(NULL, NULL,
              $form->add_input_submit("submit", "SUBMIT", "bg-brown", 12, "cadets_edit_account_information_submit")
              );

              $form->add_row(NULL, NULL,
              $form->add_input_submit("delete", "DELETE", "bg-red", 12, "personnel_attendance_submit")
              );

              $card->set_card_body(
                $user->print_leadership(),
                $error,
                $success,
                $generate->print(),
                $form->print());
              $_SESSION['disabled_indexes'] = $form->get_disabled_indexes();
              echo
              // print_row() can take an unlimited amount of parameters of print().
              $card->print_row($card->get_card_body());

            }

            App\General::root_include('private/admin/pages/personnel/cadets/includes/backend/edit.php');
            ?>

        </div>
    </section>

    <?php App\General::root_include('private/admin/app/includes/scripts/scripts.php'); ?>
    <?php App\General::root_include('private/admin/app/includes/scripts/select.php'); ?>
    <?php App\General::root_include('private/admin/app/includes/scripts/unitselect.php'); ?>
    <?php App\General::root_include('private/admin/app/includes/scripts/countdowntimer.php'); ?>
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
