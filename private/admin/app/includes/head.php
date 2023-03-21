<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Unit Management System</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <?php
      echo App\General::link(App\General::getAdminRoot() . "plugins/bootstrap/css/bootstrap.css") . "\n";
      echo "\t" . App\General::link(App\General::getAdminRoot() . "plugins/node-waves/waves.css") . "\n";
      echo "\t" . App\General::link(App\General::getAdminRoot() . "plugins/animate-css/animate.css") . "\n";
      echo "\t" . App\General::link(App\General::getAdminRoot() . "plugins/morrisjs/morris.css") . "\n";
      echo "\t" . App\General::link(App\General::getAdminRoot() . "css/style.css") . "\n";
      echo "\t" . App\General::link(App\General::getAdminRoot() . "css/themes/all-themes.css") . "\n";
      echo "\t" . App\General::link(App\General::getAdminRoot() . "plugins/bootstrap-select/css/bootstrap-select.css") . "\n";
    ?>

</head>
