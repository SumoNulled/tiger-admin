<!-- Left Sidebar -->
<?php
App\General::class_include('class.Positions.php');
App\General::class_include('class.Ranks.php');
App\General::class_include('class.User.php');

use Admin\Positions;
use App\Session;
?>
<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
          <?php $user = new Admin\User(App\Session::getID()); ?>
            <img src="<?php echo $user->image(); ?>" width="100" height="100" alt="User" />
        </div>
        <div class="info-container">
          <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $user->print_name()?></div>
          <div class="email"><?php echo Admin\Ranks::print($user->rank(), 2); ?></div>
          <?php foreach (Positions::get_position_of(Session::getID()) as $position)
          {
            echo "<div class=\"email\">" . Admin\Positions::name($position) . "</div>";
          }
          ?>
          <div class="email"><?php echo $user->get_unit(); ?></div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    <li><a href="<?php echo App\General::getAdminRoot()?>pages/personnel/profile"><i class="material-icons">person</i>Profile</a></li>
                  <!--  <li role="separator" class="divider"></li>
                    <li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>
                    <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
                    <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li>
                    <li role="separator" class="divider"></li>-->
                    <li><a href="/private/user/logout.php"><i class="material-icons">input</i>Sign Out</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
      <?php
      if (App\Permissions::valid('sidebar_view_main'))
      {
      ?>
      <ul class="list">
          <li class="header">MAIN NAVIGATION</li>
          <li>
              <a href="/private/admin/">
                  <i class="material-icons">home</i>
                  <span>Dashboard</span>
              </a>
          </li>
      <?php
      }
      ?>

      <?php
      if (App\Permissions::valid('sidebar_view_s1'))
      {
      ?>

      <li>
          <a href="/private/admin/pages/personnel/forms/generate.php">
              <i class="material-icons">picture_as_pdf</i>
              <span>Mail Merge PDF</span>
          </a>
      </li>
          <li class="header">PERSONNEL (S-1)</li>
          <li>
              <a href="javascript:void(0);" class="menu-toggle">
                  <i class="material-icons">manage_accounts</i>
                  <span>Manage Cadets</span>
              </a>
              <ul class="ml-menu">
                  <li>
                    <a href="/private/admin/pages/personnel/cadets/view.php">
                        <span>View Cadets</span>
                    </a>
                  </li>
                  <li>
                    <a href="/private/admin/pages/personnel/cadets/create.php">
                        <span>Create Cadets</span>
                    </a>
                  </li>
                </ul>
          </li>
          <li>
              <a href="javascript:void(0);" class="menu-toggle">
                  <i class="material-icons">pending_actions</i>
                  <span>Manage Attendance</span>
              </a>
              <ul class="ml-menu">
                  <li>
                    <a href="/private/admin/pages/personnel/attendance/view.php">
                        <span>View Attendance</span>
                    </a>
                  </li>
                  <li>
                    <a href="/private/admin/pages/personnel/attendance/create.php">
                        <span>Create Attendance</span>
                    </a>
                  </li>
                </ul>
          </li>
          <li>
              <a href="javascript:void(0);" class="menu-toggle">
                  <i class="material-icons">timer</i>
                  <span>Manage Assessments</span>
              </a>
              <ul class="ml-menu">
                <li>
                    <a href="/private/admin/pages/personnel/assessments/create.php">
                        <span>Create Assessment</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <span>ACFT</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="/private/admin/pages/personnel/assessments/acft/view.php">
                                <span>View ACFTs</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <span>CCFA</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="/private/admin/pages/personnel/assessments/ccfa/view.php">
                                <span>View CCFAs</span>
                            </a>
                        </li>
                    </ul>
                </li>
                </ul>
          </li>
          <?php
          }
          ?>

          <?php
          if (App\Permissions::valid('sidebar_view_s2'))
          {
          ?>
          <li class="header">INTELLIGENCE (S-2)</li>
          <li>
              <a href="javascript:void(0);" class="menu-toggle">
                  <i class="material-icons">public</i>
                  <span>Manage Locations</span>
              </a>
              <ul class="ml-menu">
                <li>
                  <a href="/private/admin/pages/intelligence/locations/view.php">
                      <span>View Locations</span>
                  </a>
                </li>
                <li>
                  <a href="/private/admin/pages/intelligence/locations/add.php">
                      <span>Add Locations</span>
                  </a>
                </li>
                </ul>
          </li>
          <li>
              <a href="javascript:void(0);" class="menu-toggle">
                  <i class="material-icons">thunderstorm</i>
                  <span>Manage Forecasts</span>
              </a>
              <ul class="ml-menu">
                  <li>
                    <a href="/private/admin/pages/intelligence/forecasts/view.php">
                        <span>View Forecasts</span>
                    </a>
                  </li>
                  <li>
                    <a href="/private/admin/pages/intelligence/forecasts/add.php">
                        <span>Add Forecasts</span>
                    </a>
                  </li>
                </ul>
          </li>
          <li>
              <a href="javascript:void(0);" class="menu-toggle">
                  <i class="material-icons">thermostat</i>
                  <span>Manage Weather Guidelines</span>
              </a>
              <ul class="ml-menu">
                  <li>
                    <a href="/private/admin/pages/intelligence/guidelines/view.php">
                        <span>View Guidelines</span>
                    </a>
                  </li>
                  <li>
                    <a href="/private/admin/pages/intelligence/guidelines/add.php">
                        <span>Add Guidelines</span>
                    </a>
                  </li>
                </ul>
          </li>
          <?php
          }
          ?>

          <?php
          if (App\Permissions::valid('sidebar_view_s3'))
          {
          ?>
          <li class="header">OPERATIONS (S-3)</li>
          <li>
              <a href="javascript:void(0);" class="menu-toggle">
                  <i class="material-icons">assignment</i>
                  <span>Manage Operations</span>
              </a>
              <ul class="ml-menu">
                  <li>
                    <a href="/private/admin/pages/cadets/view.php">
                        <span>View OPORDERS</span>
                    </a>
                  </li>
                </ul>
          </li>
          <?php
          }
          ?>

          <?php
          if (App\Permissions::valid('sidebar_view_s4'))
          {
          ?>
          <li class="header">LOGISTICS (S-4)</li>
          <li>
              <a href="javascript:void(0);" class="menu-toggle">
                  <i class="material-icons">inventory</i>
                  <span>Manage Inventory</span>
              </a>
              <ul class="ml-menu">
                  <li>
                    <a href="/private/admin/pages/logistics/inventory/view.php">
                        <span>View Inventory</span>
                    </a>
                  </li>
                  <li>
                    <a href="/private/admin/pages/logistics/inventory/create.php">
                        <span>Create Inventory</span>
                    </a>
                  </li>
                </ul>
          </li>
          <?php
          }
          ?>

          <?php
          if (App\Permissions::valid('sidebar_view_s5'))
          {
          ?>
          <li class="header">PUBLIC AFFAIRS (S-5)</li>
          <li>
              <a href="javascript:void(0);" class="menu-toggle">
                  <i class="material-icons">share</i>
                  <span>Manage Twitter</span>
              </a>
              <ul class="ml-menu">
                  <li>
                    <a href="/private/admin/pages/cadets/view.php">
                        <span>View OPORDERS</span>
                    </a>
                  </li>
                </ul>
          </li>
          <?php
          }
          ?>

      <?php
      if (App\Permissions::valid('sidebar_view_extra'))
      {
      ?>
            <li class="header">EXTRA</li>
            <li>
                <a href="pages/typography.html">
                    <i class="material-icons">text_fields</i>
                    <span>Typography</span>
                </a>
            </li>
            <li>
                <a href="pages/helper-classes.html">
                    <i class="material-icons">layers</i>
                    <span>Helper Classes</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">widgets</i>
                    <span>Widgets</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <span>Cards</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="pages/widgets/cards/basic.html">Basic</a>
                            </li>
                            <li>
                                <a href="pages/widgets/cards/colored.html">Colored</a>
                            </li>
                            <li>
                                <a href="pages/widgets/cards/no-header.html">No Header</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <span>Infobox</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="pages/widgets/infobox/infobox-1.html">Infobox-1</a>
                            </li>
                            <li>
                                <a href="pages/widgets/infobox/infobox-2.html">Infobox-2</a>
                            </li>
                            <li>
                                <a href="pages/widgets/infobox/infobox-3.html">Infobox-3</a>
                            </li>
                            <li>
                                <a href="pages/widgets/infobox/infobox-4.html">Infobox-4</a>
                            </li>
                            <li>
                                <a href="pages/widgets/infobox/infobox-5.html">Infobox-5</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">swap_calls</i>
                    <span>User Interface (UI)</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="pages/ui/alerts.html">Alerts</a>
                    </li>
                    <li>
                        <a href="pages/ui/animations.html">Animations</a>
                    </li>
                    <li>
                        <a href="pages/ui/badges.html">Badges</a>
                    </li>

                    <li>
                        <a href="pages/ui/breadcrumbs.html">Breadcrumbs</a>
                    </li>
                    <li>
                        <a href="pages/ui/buttons.html">Buttons</a>
                    </li>
                    <li>
                        <a href="pages/ui/collapse.html">Collapse</a>
                    </li>
                    <li>
                        <a href="pages/ui/colors.html">Colors</a>
                    </li>
                    <li>
                        <a href="pages/ui/dialogs.html">Dialogs</a>
                    </li>
                    <li>
                        <a href="pages/ui/icons.html">Icons</a>
                    </li>
                    <li>
                        <a href="pages/ui/labels.html">Labels</a>
                    </li>
                    <li>
                        <a href="pages/ui/list-group.html">List Group</a>
                    </li>
                    <li>
                        <a href="pages/ui/media-object.html">Media Object</a>
                    </li>
                    <li>
                        <a href="pages/ui/modals.html">Modals</a>
                    </li>
                    <li>
                        <a href="pages/ui/notifications.html">Notifications</a>
                    </li>
                    <li>
                        <a href="pages/ui/pagination.html">Pagination</a>
                    </li>
                    <li>
                        <a href="pages/ui/preloaders.html">Preloaders</a>
                    </li>
                    <li>
                        <a href="pages/ui/progressbars.html">Progress Bars</a>
                    </li>
                    <li>
                        <a href="pages/ui/range-sliders.html">Range Sliders</a>
                    </li>
                    <li>
                        <a href="pages/ui/sortable-nestable.html">Sortable & Nestable</a>
                    </li>
                    <li>
                        <a href="pages/ui/tabs.html">Tabs</a>
                    </li>
                    <li>
                        <a href="pages/ui/thumbnails.html">Thumbnails</a>
                    </li>
                    <li>
                        <a href="pages/ui/tooltips-popovers.html">Tooltips & Popovers</a>
                    </li>
                    <li>
                        <a href="pages/ui/waves.html">Waves</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">assignment</i>
                    <span>Forms</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="pages/forms/basic-form-elements.html">Basic Form Elements</a>
                    </li>
                    <li>
                        <a href="pages/forms/advanced-form-elements.html">Advanced Form Elements</a>
                    </li>
                    <li>
                        <a href="pages/forms/form-examples.html">Form Examples</a>
                    </li>
                    <li>
                        <a href="pages/forms/form-validation.html">Form Validation</a>
                    </li>
                    <li>
                        <a href="pages/forms/form-wizard.html">Form Wizard</a>
                    </li>
                    <li>
                        <a href="pages/forms/editors.html">Editors</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">view_list</i>
                    <span>Tables</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="pages/tables/normal-tables.html">Normal Tables</a>
                    </li>
                    <li>
                        <a href="pages/tables/jquery-datatable.html">Jquery Datatables</a>
                    </li>
                    <li>
                        <a href="pages/tables/editable-table.html">Editable Tables</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">perm_media</i>
                    <span>Medias</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="pages/medias/image-gallery.html">Image Gallery</a>
                    </li>
                    <li>
                        <a href="pages/medias/carousel.html">Carousel</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">pie_chart</i>
                    <span>Charts</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="pages/charts/morris.html">Morris</a>
                    </li>
                    <li>
                        <a href="pages/charts/flot.html">Flot</a>
                    </li>
                    <li>
                        <a href="pages/charts/chartjs.html">ChartJS</a>
                    </li>
                    <li>
                        <a href="pages/charts/sparkline.html">Sparkline</a>
                    </li>
                    <li>
                        <a href="pages/charts/jquery-knob.html">Jquery Knob</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">content_copy</i>
                    <span>Example Pages</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="pages/examples/profile.html">Profile</a>
                    </li>
                    <li>
                        <a href="pages/examples/sign-in.html">Sign In</a>
                    </li>
                    <li>
                        <a href="pages/examples/sign-up.html">Sign Up</a>
                    </li>
                    <li>
                        <a href="pages/examples/forgot-password.html">Forgot Password</a>
                    </li>
                    <li>
                        <a href="pages/examples/blank.html">Blank Page</a>
                    </li>
                    <li>
                        <a href="pages/examples/404.html">404 - Not Found</a>
                    </li>
                    <li>
                        <a href="pages/examples/500.html">500 - Server Error</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">map</i>
                    <span>Maps</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="pages/maps/google.html">Google Map</a>
                    </li>
                    <li>
                        <a href="pages/maps/yandex.html">YandexMap</a>
                    </li>
                    <li>
                        <a href="pages/maps/jvectormap.html">jVectorMap</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">trending_down</i>
                    <span>Multi Level Menu</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="javascript:void(0);">
                            <span>Menu Item</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">
                            <span>Menu Item - 2</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <span>Level - 2</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="javascript:void(0);">
                                    <span>Menu Item</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <span>Level - 3</span>
                                </a>
                                <ul class="ml-menu">
                                    <li>
                                        <a href="javascript:void(0);">
                                            <span>Level - 4</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="pages/changelogs.html">
                    <i class="material-icons">update</i>
                    <span>Changelogs</span>
                </a>
            </li>

            <li class="header">LABELS</li>
            <li>
                <a href="javascript:void(0);">
                    <i class="material-icons col-red">donut_large</i>
                    <span>Important</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);">
                    <i class="material-icons col-amber">donut_large</i>
                    <span>Warning</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);">
                    <i class="material-icons col-light-blue">donut_large</i>
                    <span>Information</span>
                </a>
            </li>
            <?php
            }
            ?>
        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
        <div class="copyright">
            &copy; 2022 <a href="javascript:void(0);">System Adminisrator: Damund Clay</a>
        </div>
        <div class="version">
            <b>Version: </b> 0.0.5
        </div>
    </div>
    <!-- #Footer -->
</aside>
<!-- #END# Left Sidebar -->
