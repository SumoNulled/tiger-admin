<?php
echo App\General::script(App\General::getAdminRoot() . "plugins/jquery-datatable/jquery.dataTables.js");
echo App\General::script(App\General::getAdminRoot() . "plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js");
echo App\General::script(App\General::getAdminRoot() . "plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js");
echo App\General::script(App\General::getAdminRoot() . "plugins/jquery-datatable/extensions/export/buttons.flash.min.js");
echo App\General::script(App\General::getAdminRoot() . "plugins/jquery-datatable/extensions/export/jszip.min.js");
echo App\General::script(App\General::getAdminRoot() . "plugins/jquery-datatable/extensions/export/pdfmake.min.js");
echo App\General::script(App\General::getAdminRoot() . "plugins/jquery-datatable/extensions/export/vfs_fonts.js");
echo App\General::script(App\General::getAdminRoot() . "plugins/jquery-datatable/extensions/export/buttons.html5.min.js");
echo App\General::script(App\General::getAdminRoot() . "plugins/jquery-datatable/extensions/export/buttons.print.min.js");
echo App\General::script(App\General::getAdminRoot() . "js/pages/tables/jquery-datatable.js");
?>
