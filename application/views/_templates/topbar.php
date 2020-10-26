<?php

// Notifications
$notifications_model = $this->loadModel('NotificationsModel');
$notifications = $notifications_model->getAccountNotifications($account->id, 5);
$hasNotifications = $notifications_model->hasNotifications($account->id);

// Modules
$modules_model = $this->loadModel('ModulesModel');

?>

<!-- Topbar -->
<div class="topbar b-white">
  <div class="v-middle">
    <div class="row">
      <div class="col-lg-3">
        <div class="topbar-links topbar-add-link-box">
          <a href="#" class="topbar-link topbar-add-link">
            <div class="topbar-link-box text c-gray text-center">
              <i class="topbar-link-box-icon to-change fe fe-plus v-middle"></i>
            </div>
          </a>
        </div>
        <h2 class="topbar-title c-title"></h2>
      </div>
      <div class="col-lg-5 p-left-0">
        <div class="topbar-search v-middle">
          <input type="text" placeholder="&#xf14e;" class="text c-text" id="searchBar">
        </div>
      </div>
      <div class="col-lg-4 text-right">
        <div class="topbar-links">
          <?php if($modules_model->moduleInstalled('timetrack') && $modules_model->moduleInstalledAccount('timetrack', $account->id)): ?>
            <?php $module_model = $this->loadModuleModel('timetrack', 'TimetrackModel'); ?>
            <script type="text/javascript" src="<?php echo URL; ?>includes/modules/timetrack/public/js/script.js"></script>

            <?php if(isset($_SESSION['timetrack']) && $_SESSION['timetrack']): ?>
              <?php $timetrackStarted = true; ?>
              <?php foreach($_SESSION['timetrack'] as $timer_id => $session_tracked_time): ?>
                <script type="text/javascript">
                  addTimerTime(<?php echo $timer_id; ?>);
                </script>
              <?php endforeach; ?>
            <?php else: ?>
              <?php $timetrackStarted = false; ?>
            <?php endif; ?>
            ?>
            <div id="timetrackBtn" class="topbar-link">
              <div class="topbar-link-box dropdown-btn timetrack-btn text c-gray text-center">
                <i class="topbar-link-box-icon dropdown-btn-icon timetrack-btn-icon <?php echo ($timetrackStarted == false ? 'viewed' : ''); ?> fe fe-clock v-middle"></i>
                <div class="dropdown timetrack-dropdown box b-white">
                  <div class="p-all-20">
                    <h2 class="c-title weight-400 m-bottom-10 text-left">Time tracking</h2>

                    <?php if(isset($_SESSION['timetrack']) && count($_SESSION['timetrack']) > 0): ?>
                      <?php $i = 0; ?>
                      <?php foreach($_SESSION['timetrack'] as $timer_id => $session_tracked_time): ?>
                        <div class="list-element p-bottom-10 p-top-10 <?php echo ($i == 0 ? 'first' : ''); ?> <?php echo ($i == (count($_SESSION['timetrack']) - 1) ? 'last' : ''); ?>">
                          <div class="row">
                            <div class="col-lg-7 text-left">
                              <div class="caption c-gray v-middle"><?php echo $session_tracked_time['title']; ?></div>
                            </div>
                            <div class="col-lg-3 text-right">
                              <h4 class="text c-text weight-400 v-middle timetrack-timer" data-timetrack-timer-id="<?php echo $timer_id; ?>" data-timetrack-timer-time="<?php echo ($session_tracked_time['tracked_time'] > 0 ? $session_tracked_time['tracked_time'] : 0); ?>"><?php echo ($session_tracked_time['tracked_time'] > 0 ? $module_model->formatTimerHours($session_tracked_time['tracked_time']) : 0); ?> h.</h4>
                            </div>
                            <div class="col-lg-2 text-right">
                              <a href="#"><button class="more-btn caption c-gray v-middle"><i class="fe fe-close"></i></button></a>
                            </div>
                          </div>
                        </div>
                        <?php $i++; ?>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <div class="caption c-gray text-left">No timer.</div>
                    <?php endif; ?>

                  </div>
                </div>
              </div>
            </div>
          <?php endif; ?>
          <!-- <a href="#" class="topbar-link">
            <div class="topbar-link-box text c-gray text-center">
              <i class="topbar-link-box-icon fe fe-commenting v-middle"></i>
            </div>
          </a> -->
          <div id="notificationsBtn" class="topbar-link">
            <div class="topbar-link-box dropdown-btn notifications-btn text c-gray text-center">
              <i class="topbar-link-box-icon dropdown-btn-icon notifications-btn-icon <?php echo ($hasNotifications == false ? 'viewed' : ''); ?> fe fe-bell v-middle"></i>
              <div class="dropdown notifications-dropdown box b-white">
                <?php if(count($notifications) > 0): ?>
                  <?php $i = 0; ?>
                  <?php foreach($notifications as $notification): ?>
                    <a href="<?php echo URL . $notification->location; ?>" class="p-all-20 notification-element" data-notification-id="<?php echo $notification->id; ?>">
                      <div class="list-element p-bottom-15 p-top-15 <?php echo ($i == 0 ? 'first' : ''); ?> <?php echo ($i == (count($notifications) - 1) ? 'last' : ''); ?>">
                        <div class="row">
                          <div class="col-lg-3 p-right-0 text-left">
                            <div class="icon-circle medium notifications-dropdown-box-icon <?php echo ($notification->viewed == 1 ? 'viewed' : ''); ?> b-secondary c-primary text-center">
                              <i class="fe fe-<?php echo $notification->icon; ?> v-middle"></i>
                            </div>
                          </div>
                          <div class="col-lg-9 p-left-0 text-left">
                            <div class="caption c-text"><?php echo $notification->title; ?></div>
                            <div class="notifications-dropdown-box-time text c-gray"><?php echo $notifications_model->formatNotificationDate($notification->notification_date); ?></div>
                          </div>
                        </div>
                      </div>
                    </a>
                    <?php $i++; ?>
                  <?php endforeach; ?>
                <?php else: ?>
                  <div class="caption c-gray">No notifications.</div>
                <?php endif; ?>
                <div class="dropdown-view-all p-all-5 text-center">
                  <a href="#" class="text c-primary">View all</a>
                </div>
              </div>
            </div>
          </div>
          <a href="<?php echo URL; ?>account" class="topbar-link">
            <div class="topbar-link-box topbar-account-image">
              <?php if(file_exists('public/application/accounts/' . $account->id . '.png')): ?>
                <img src="<?php echo URL; ?>public/application/accounts/<?php echo $account->id; ?>.png" class="v-middle">
              <?php else: ?>
                <img src="<?php echo URL; ?>public/img/account.png" class="v-middle">
              <?php endif; ?>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
