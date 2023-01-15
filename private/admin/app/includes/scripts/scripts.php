<?php
// Jquery Core Js
echo App\General::script(App\General::getAdminRoot() . "plugins/jquery/jquery.min.js") . "\n";

// Bootstrap Core Js
echo "\t" . App\General::script(App\General::getAdminRoot() . "plugins/bootstrap/js/bootstrap.js") . "\n";

// Select Plugin Js
echo "\t" . App\General::script(App\General::getAdminRoot() . "plugins/bootstrap-select/js/bootstrap-select.js") . "\n";

// Slimscroll Plugin Js
echo "\t" . App\General::script(App\General::getAdminRoot() . "plugins/jquery-slimscroll/jquery.slimscroll.js") . "\n";

// Waves Effect Plugin
echo "\t" . App\General::script(App\General::getAdminRoot() . "plugins/node-waves/waves.js") . "\n";

// Custom Js
echo "\t" . App\General::script(App\General::getAdminRoot() . "js/admin.js") . "\n";

// Demo Js
echo "\t" . App\General::script(App\General::getAdminRoot() . "js/demo.js") . "\n";
?>
