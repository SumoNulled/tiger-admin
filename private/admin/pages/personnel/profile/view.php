<!DOCTYPE html>
<html>
<?php
App\General::class_include('class.Forms.php');
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
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-5">
                    <div class="card profile-card">
                        <div class="profile-header">&nbsp;</div>
                        <div class="profile-body">
                          <?php $user = new Admin\User(App\Session::getID()); ?>
                            <div class="image-area">
                                <img src="<?php echo $user->image(); ?>" width="100" height="100" alt="User" />
                            </div>
                            <div class="content-area">
                                <h3><?php echo $user->print_name(); ?></h3>
                                <p><?php echo Admin\Ranks::print($user->rank(), 1); ?></p>
                                <p><?php echo Admin\Positions::print($user->position()); ?></p>
                            </div>
                        </div>
                        <!--<div class="profile-footer">
                          <ul>
                                <li>
                                    <span>Followers</span>
                                    <span>1.234</span>
                                </li>
                                <li>
                                    <span>Following</span>
                                    <span>1.201</span>
                                </li>
                                <li>
                                    <span>Friends</span>
                                    <span>14.252</span>
                                </li>
                            </ul>
                            <button class="btn bg-brown btn-lg waves-effect btn-block">FOLLOW</button>
                        </div>-->
                    </div>

                    <div class="card card-about-me">
                        <div class="header">
                            <h2>ABOUT ME</h2>
                        </div>
                        <div class="body">
                            <ul>
                                <li>
                                    <div class="title">
                                        <i class="material-icons">library_books</i>
                                        Education
                                    </div>
                                    <div class="content">
                                        <?php
                                        echo "Currently enrolled at the University of Memphis.";
                                        ?>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-7">
                    <div class="card">
                        <div class="body">
                            <div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation"><a href="#change_password_settings" aria-controls="settings" role="tab" data-toggle="tab">Change Password</a></li>
                                </ul>

                                <div class="tab-content">


                                    <div role="tabpanel" class="tab-pane fade in active" id="change_password_settings">
                                        <?php
                                        function renderForm()
                                        {
                                        $form = new Admin\Forms;

                                        $form->add_row("Old Password", NULL,
                                        $form->add_input_text(12, "old_password", "Old Password", NULL, NULL, FALSE, NULL),
                                        );

                                        $form->add_row("New Password", NULL,
                                        $form->add_input_text(12, "password", "New Password", NULL, NULL, FALSE, NULL),
                                        );

                                        $form->add_row("New Password Confirm", NULL,
                                        $form->add_input_text(12, "confirm_password", "New Password Confirm", NULL, NULL, FALSE, NULL),
                                        );

                                        $form->add_row(NULL, NULL,
                                        $form->add_input_submit("submit", "CHANGE PASSWORD", "bg-brown", 12, NULL)
                                        );

                                        echo
                                        $form->print();
                                        }

                                        App\General::root_include('private/admin/pages/personnel/profile/includes/backend/passwordchange.php');
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    App\General::root_include('private/admin/app/includes/scripts/countdowntimer.php');
    App\General::root_include('private/admin/app/includes/scripts/scripts.php');
    ?>
    <!-- Custom Js -->
    <script src="../../js/admin.js"></script>
    <script src="../../js/pages/examples/profile.js"></script>

</body>

</html>
