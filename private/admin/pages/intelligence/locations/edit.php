<!DOCTYPE html>
<html>
<?php
App\General::class_include('class.Alerts.php');
App\General::class_include('class.Cards.php');
App\General::class_include('class.Forms.php');
App\General::class_include('class.Locations.php');
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
                  To request access to this resource, contact the S-2 shop.
              </div>
            </div>

            <?php

            function renderForm($_ARRAY = array(), $error = null, $success = null)
            {
              $card = new Admin\Cards;
              $form = new Admin\Forms;

              $location = new App\Locations($_ARRAY['id']);

              $card->set_card_title("Editing Location #" . $location->getID()); // A NULL card title and "false" card menu will hide the card header entirely.
              $card->set_card_sub_title("Last altered: <b>" . date("F d, Y @ g:i A", strtotime($_ARRAY['last_edited'])) . "</b>");

              // Input fields are in the form of ("size", "name", "Label", "value", "permission_required")
              $form->add_row("Location Information", NULL,
              $form->add_input_text(2, "id", "Location ID", $_ARRAY['id'], NULL, TRUE, "locations_edit_id"),
              $form->add_input_text(3, "location_name", "Location Name", $_ARRAY['location_name'], NULL, FALSE, "locations_edit_name"),
              $form->add_input_text(7, "location_description", "Location Description", $_ARRAY['location_description'], NULL, FALSE, "locations_edit_description"),
              $form->add_input_text(4, "address", "Location Address", $_ARRAY['address'], NULL, FALSE, "locations_edit_address"),
              $form->add_input_text(4, "longitude", "Longitude (X)", $_ARRAY['longitude'], NULL, FALSE, "locations_edit_longitude"),
              $form->add_input_text(4, "latitude", "Latitude (Y)", $_ARRAY['latitude'], NULL, FALSE, "locations_edit_latitude")
            );

              $form->add_row(NULL, NULL,
              $form->add_input_submit("submit", "UPDATE", "bg-brown", 12, "locations_edit_submit")
              );

              $form->add_row(NULL, NULL,
              $form->add_input_submit("delete", "DELETE", "bg-red", 12, "locations_edit_delete")
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

            App\General::root_include('private/admin/pages/intelligence/locations/includes/backend/edit.php');
            ?>

        </div>
    </section>

    <?php App\General::root_include('private/admin/app/includes/scripts/countdowntimer.php'); ?>
    <?php App\General::root_include('private/admin/app/includes/scripts/scripts.php'); ?>
    <?php App\General::root_include('private/admin/app/includes/scripts/select.php'); ?>

</body>

</html>
