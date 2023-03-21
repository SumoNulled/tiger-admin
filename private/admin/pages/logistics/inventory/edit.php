<!DOCTYPE html>
<html>
<?php
App\General::class_include('class.Alerts.php');
//App\General::class_include('class.Inventory.php');
App\General::class_include('class.Cards.php');
App\General::class_include('class.Forms.php');
App\General::class_include('class.Tables.php');
App\General::class_include('class.User.php');
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
                  To request access to this resource, contact the S-4 shop.
              </div>
            </div>

            <?php
            function update_inventory($_ARRAY = array(), $error = null, $success = null)
            {
              /* Inventory Log Editing */
              $card = new Admin\cards;
              $form = new Admin\forms;
              $table = new Admin\Tables;

              //$inventory = new Admin\Inventory($_ARRAY['id']);

              $card->set_card_title("Update Inventory Receipts for " . $_ARRAY['name'] . " "); // A NULL card title and "false" card menu will hide the card header entirely.
              //$card->set_card_sub_title("On this day, <b>{$inventory->in_inventory()} out of {$inventory->personnel_count()} ({$inventory->in_inventory_percent()}%)</b> cadets were present, tardy, or excused. <br />Last altered: <b>" . date("F d, Y @ g:i A", strtotime($_ARRAY['last_edited'])) . "</b>");


              $table->set_table_head(
                "Cadet ID,
                Cadet Name,
                Quantity"
              );
              $table->set_table_footer(false);
              $user = new Admin\User;
              // Begin building the table body.
              foreach(App\SQL::row("SELECT * FROM personnel_inventory AS m JOIN personnel as p ON p.id = m.cadet_id WHERE m.inventory_id = {$_ARRAY['id']} ORDER BY p.last_name") as $row)
              {
                $user->setID($row['cadet_id']);
                $table->add_table_row(
                  array(
                    "<center>" . $row['cadet_id'] . "</center>" . "<input type='hidden' name='id[]' value='{$row['cadet_id']}'/>",
                    $user->print_name(1) . "<br><small>({$user->get_unit()})</small>",
                    $form->add_input_text(12, "quantity[]", "Quantity", $row['quantity'], NULL, FALSE, "inventory_edit_quantity")
                  )
                );
              }
              $form->add_row(NULL, NULL,
              $form->add_input_submit("update_inventory", "UPDATE", "bg-brown", 12, "logistics_inventory_submit")
              );
              $form->add_row($table->print());
              $form->add_row(NULL, NULL,
              $form->add_input_submit("update_inventory", "UPDATE", "bg-brown", 12, "logistics_inventory_submit")
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

            function renderForm($_ARRAY = array(), $error = null, $success = null)
            {
              $card = new Admin\Cards;
              $form = new Admin\Forms;
              $form->set_name("inventory");

              $card->set_card_title("Editing Inventory Log #" . $_ARRAY['id']); // A NULL card title and "false" card menu will hide the card header entirely.
              $card->set_card_sub_title("Last altered: <b>" . date("F d, Y @ g:i A", strtotime($_ARRAY['last_edited'])) . "</b>");

              // Input fields are in the form of ("size", "name", "Label", "value", "permission_required")
              $form->add_row("Inventory Identifying Information", NULL,
              $form->add_input_text(2, "id", "Item ID", $_ARRAY['id'], NULL, TRUE, "inventory_edit_id"),
              $form->add_input_text(2, "name", "Item Name", $_ARRAY['name'], NULL, TRUE, "inventory_edit_name"),
              $form->add_input_text(8, "description", "Item Description", $_ARRAY['description'], NULL, TRUE, "inventory_edit_description"),
              );

              $form->add_row("Inventory Stock Information", NULL,
              $form->add_input_text(3, "nsn", "National Stock Number", $_ARRAY['nsn'], NULL, FALSE, "inventory_edit_nsn"),
              $form->add_input_text(2, "lin", "Line Item Number", $_ARRAY['lin'], NULL, FALSE, "inventory_edit_lin"),
              $form->add_input_text(2, "nslin", "Non-Standard LIN", $_ARRAY['nslin'], NULL, FALSE, "inventory_edit_nslin"),
              $form->add_input_text(2, "class", "Class of Supply", $_ARRAY['class'], NULL, FALSE, "inventory_edit_class"),
              $form->add_input_text(2, "quantity", "Quantity", $_ARRAY['quantity'], NULL, FALSE, "inventory_edit_quantity")
              );

              $form->add_row(NULL, NULL,
              $form->add_input_submit("submit", "UPDATE", "bg-brown", 12, "personnel_inventory_submit")
              );

              $form->add_row(NULL, NULL,
              $form->add_input_submit("delete", "DELETE", "bg-red", 12, "personnel_inventory_submit")
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

            App\General::root_include('private/admin/pages/logistics/inventory/includes/backend/edit.php');
            ?>

        </div>
    </section>

    <?php
    App\General::root_include('private/admin/app/includes/scripts/countdowntimer.php');
    App\General::root_include('private/admin/app/includes/scripts/scripts.php');
    App\General::root_include('private/admin/app/includes/scripts/select.php');
    ?>


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
