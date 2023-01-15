<!DOCTYPE html>
<html>
<?php
App\General::class_include('class.Alerts.php');
App\General::class_include('class.Cards.php');
App\General::class_include('class.Forms.php');
App\General::class_include('class.Weather.php');
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

              $weather = new App\Weather($_ARRAY['id']);

              $card->set_card_title("Editing Forecast #" . $weather->getID()); // A NULL card title and "false" card menu will hide the card header entirely.
              $card->set_card_sub_title("Last altered: <b>" . date("F d, Y @ g:i A", strtotime($_ARRAY['last_edited'])) . "</b>");

              // Input fields are in the form of ("size", "name", "Label", "value", "permission_required")
              $form->add_row("Forecast Information", NULL,
              $form->add_input_text(2, "id", "Forecast ID", $_ARRAY['id'], NULL, TRUE, "intelligence_forecasts_edit_id"),
              $form->add_input_text(2, "temperature", "Temperature", $_ARRAY['temperature'], NULL, TRUE, "intelligence_forecasts_edit_temperature"),
              $form->add_input_text(2, "short_forecast", "Forecast Summary", $_ARRAY['short_forecast'], NULL, TRUE, "intelligence_forecasts_edit_short_forecast"),
              $form->add_input_text(2, "wind_speed", "Wind Speed", $_ARRAY['wind_speed'], NULL, TRUE, "intelligence_forecasts_edit_wind_speed"),
              $form->add_input_text(2, "wind_direction", "Wind Direction", $_ARRAY['wind_direction'], NULL, TRUE, "intelligence_forecasts_edit_wind_direction"),
              $form->add_input_text(4, "detailed_forecast", "Detailed Forecast", $_ARRAY['detailed_forecast'], NULL, FALSE, "intelligence_forecasts_edit_detailed_forecast"),
              $form->add_input_text(5, "comments", "Comments", $_ARRAY['comments'], NULL, FALSE, "intelligence_forecasts_edit_comments")
            );

              $form->add_row(NULL, NULL,
              $form->add_input_submit("submit", "UPDATE", "bg-brown", 12, "intelligence_forecasts_edit_submit")
              );

              $form->add_row(NULL, NULL,
              $form->add_input_submit("delete", "DELETE", "bg-red", 12, "intelligence_forecasts_edit_delete")
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

            App\General::root_include('private/admin/pages/intelligence/forecasts/includes/backend/edit.php');
            ?>

        </div>
    </section>

    <?php App\General::root_include('private/admin/app/includes/scripts/countdowntimer.php'); ?>
    <?php App\General::root_include('private/admin/app/includes/scripts/scripts.php'); ?>
    <?php App\General::root_include('private/admin/app/includes/scripts/select.php'); ?>

</body>

</html>
