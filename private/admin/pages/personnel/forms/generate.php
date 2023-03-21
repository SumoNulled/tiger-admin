<!DOCTYPE html>
<html>
<?php
App\General::class_include('class.Alerts.php');
App\General::class_include('class.Cards.php');
App\General::class_include('class.Forms.php');
App\General::class_include('class.MSL.php');
App\General::class_include('class.User.php');
App\General::class_include('class.ACFT.php', 'ACFT');
use Admin\User as Personnel;
use Admin\ACFT as ACFT;
?>
<?php App\General::root_include('private/admin/app/includes/head.php'); ?>

<!-- Multi Select Css -->
<link href="/private/admin/plugins/multi-select/css/multi-select.css" rel="stylesheet">

<!-- Bootstrap Select Css -->
<link href="/private/admin/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<!-- Dropzone Css -->
<link href="/private/admin/plugins/dropzone/dropzone.css" rel="stylesheet">

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
                Approved PDF's
                <br />
                <small>PDFs that are not on this list may not work. PDFs must be configured to use the correct form fields.</small>
                <ul>
                  <li>
                    <a href ='https://www.cadetcommand.army.mil/res/files/forms_policies/forms/USACC%20145-1-1%20ROTC%20Scholarship%20PFA%20Form.pdf' target="_blank">CCFA Score Card</a>
                  </li>
                  <li>
                    <a href ='https://tigerbn.com/files/DA_FORM_705.pdf' target="_blank">ACFT Score Card</a>
                  </li>
                </ul>
              </div>
            </div>
                  <?php
                  function renderForm($_ARRAY = array(), $error = null, $success = null)
                  {
                  $card = new Admin\cards;
                  /* */$card->set_card_menu(false); // True will show the menu, False will hide it.
                  /* */$card->set_card_title("Merge PDF"); // A NULL card title and "false" card menu will hide the card header entirely.
                  /* */$card->set_card_sub_title("PDFs uploaded to this form without any cadets selected will return an unlocked/unrestricted blank PDF. This will work for all PDFs, not only the approved ones. Use this functionality to remove PDF restrictions and edit/view form fields.");
                  /* */$card->set_card_size(12); // Setting the card size.

                  $form = new Admin\forms;
                  ///* */$form->set_class('dropzone');
                  /* */$form->set_action('backend\includes\generate');
                  /* */$form->set_enc('multipart/form-data');

                  // Input fields are in the form of ("size", "name", "Label", "value", "permission_required")
                  $form->add_row("<font color='red'>This tool utilizes information stored on TigerAdmin. If an error occurs in information, the S1 may fix it.</font>", NULL, NULL);
                  $form->add_row("Upload File", NULL,
                  $form->add_input_file()
                  );

                  $form->add_row("Select Cadets", NULL,
                  $form->add_select_multiple("id[]", Admin\User::get_users(), NULL, "Select cadets to be autofilled onto this form.")
                  );

                  $form->add_row(NULL, NULL,
                  $form->add_input_submit("add_cadet", "MERGE PDF", "bg-brown", 12, NULL)
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
                  renderForm();
                  ?>
                  </select>
          </div>

          </div>
    </section>

    <?php App\General::root_include('private/admin/app/includes/scripts/scripts.php'); ?>

    <!-- Multi Select Plugin Js -->
    <script src="/private/admin/plugins/multi-select/js/jquery.multi-select.js"></script>

</body>

</html>
