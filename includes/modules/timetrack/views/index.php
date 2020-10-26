<!-- Timetrack -->
<div class="container-fluid content">

  <!-- Timetrack Stats -->

  <!-- Left -->
  <div class="row">
    <div class="col-lg-7">

      <!-- Currently tracking -->
      <div class="section m-bottom-20">
        <div class="text c-gray m-bottom-10">Currently tracking</div>
        <div class="box b-white p-all-30">
          <?php $i = 0; ?>
          <?php if(count($tracked_times) > 0): ?>
            <?php foreach($tracked_times as $tracked_time): ?>
              <div class="list-element p-bottom-15 p-top-15 <?php echo ($i == 0 ? 'first' : ''); ?> <?php echo ($i == (count($tracked_times) - 1) ? 'last' : ''); ?>">
                <div class="row">
                  <div class="col-lg-6 text-left">
                    <div class="list-element-title caption v-middle"><?php echo $tracked_time->title; ?></div>
                  </div>
                  <div class="col-lg-2">
                    <div class="caption c-gray text-left v-middle"><?php echo date_format(date_create($tracked_time->tracked_time_date), 'j M.'); ?></div>
                  </div>
                  <div class="col-lg-2 text-right">
                    <div class="caption c-gray text-center m-bottom-5 v-middle"><?php echo $tracked_time->tracked_time; ?> h.</div>
                  </div>
                  <div class="col-lg-2 text-right">
                    <div class="list-element-title v-middle">
                      <button class="more-btn p-right-0 caption c-gray" onclick="event.stopPropagation(); this.childNodes[2].style.display = 'block';"><i class="fe fe-elipsis-h"></i>
                        <div class="more-dropdown module-dropdown box b-white p-top-10 p-left-10 p-bottom-10 v-middle caption text-right">
                          <a href="<?php echo URL; ?>modules/edit/timetrack/<?php echo $tracked_time->id; ?>">
                            <div class="m-right-5 b-secondary c-primary text-center">
                              <i class="fe fe-edit v-middle"></i>
                            </div>
                          </a>
                          <a href="<?php echo URL; ?>modules/executemoduleaction/timetrack/deletetrackedtime/<?php echo $tracked_time->id; ?>">
                            <div class="m-left-5 m-right-5 b-red-secondary c-red text-center">
                              <i class="fe fe-trash v-middle"></i>
                            </div>
                          </a>
                          <div class="m-left-5 b-gray-secondary c-gray text-center" onclick="event.stopPropagation(); this.parentElement.style.display = 'none';">
                            <i class="fe fe-close v-middle"></i>
                          </div>
                        </div>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <?php $i++; ?>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="no-elements-img text-center">
              <img src="<?php echo URL; ?>public/img/graphic-1.svg">
            </div>
            <h3 class="c-title m-top-30 text-center">No tracked times!</h3>
            <div class="text c-gray text-center">You don't have any tracked times yet.</div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Tracked times -->
      <div class="section">
        <div class="text c-gray m-bottom-10">Tracked times</div>
        <div class="box b-white p-all-30">
          <?php $i = 0; ?>
          <?php if(count($tracked_times) > 0): ?>
            <?php foreach($tracked_times as $tracked_time): ?>
              <div class="list-element p-bottom-15 p-top-15 <?php echo ($i == 0 ? 'first' : ''); ?> <?php echo ($i == (count($tracked_times) - 1) ? 'last' : ''); ?>">
                <div class="row">
                  <div class="col-lg-6 text-left">
                    <div class="list-element-title caption v-middle"><?php echo $tracked_time->title; ?></div>
                  </div>
                  <div class="col-lg-2">
                    <div class="caption c-gray text-left v-middle"><?php echo date_format(date_create($tracked_time->tracked_time_date), 'j M.'); ?></div>
                  </div>
                  <div class="col-lg-2 text-right">
                    <div class="caption c-gray text-center m-bottom-5 v-middle"><?php echo $tracked_time->tracked_time; ?> h.</div>
                  </div>
                  <div class="col-lg-2 text-right">
                    <div class="list-element-title v-middle">
                      <button class="more-btn p-right-0 caption c-gray" onclick="event.stopPropagation(); this.childNodes[2].style.display = 'block';"><i class="fe fe-elipsis-h"></i>
                        <div class="more-dropdown module-dropdown box b-white p-top-10 p-left-10 p-bottom-10 v-middle caption text-right">
                          <a href="<?php echo URL; ?>modules/edit/timetrack/<?php echo $tracked_time->id; ?>">
                            <div class="m-right-5 b-secondary c-primary text-center">
                              <i class="fe fe-edit v-middle"></i>
                            </div>
                          </a>
                          <a href="<?php echo URL; ?>modules/executemoduleaction/timetrack/deletetrackedtime/<?php echo $tracked_time->id; ?>">
                            <div class="m-left-5 m-right-5 b-red-secondary c-red text-center">
                              <i class="fe fe-trash v-middle"></i>
                            </div>
                          </a>
                          <div class="m-left-5 b-gray-secondary c-gray text-center" onclick="event.stopPropagation(); this.parentElement.style.display = 'none';">
                            <i class="fe fe-close v-middle"></i>
                          </div>
                        </div>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <?php $i++; ?>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="no-elements-img text-center">
              <img src="<?php echo URL; ?>public/img/graphic-1.svg">
            </div>
            <h3 class="c-title m-top-30 text-center">No tracked times!</h3>
            <div class="text c-gray text-center">You don't have any tracked times yet.</div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="section">
        <div class="text c-gray m-bottom-10">Track your time</div>
        <div class="box b-white p-all-30">
          <h3 class="project-title c-title m-bottom-30">Add new entry</h3>
          <form action="<?php echo URL; ?>modules/executemoduleaction/timetrack/startnewtimer" method="post">
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Title</div>
              <input type="text" name="tracked_time_title" placeholder="Enter the tracked time title" class="text c-text">
            </div>
            <?php if(count($projects) > 0): ?>
              <div class="form-input-box">
                <div class="caption c-text m-bottom-5">Project (optional)</div>
                <select name="project_id" class="text c-text">
                  <option value="0" selected="selected">Select the project for the tracked time</option>
                    <?php foreach($projects as $project): ?>
                      <option value="<?php echo $project->id; ?>"><?php echo $project->title; ?></option>
                    <?php endforeach; ?>
                </select>
              </div>
            <?php else: ?>
              <input type="hidden" name="project_id" value="0">
            <?php endif; ?>
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Start from (optional)</div>
              <input type="text" name="start_from" placeholder="Enter the start from time" class="text c-text">
            </div>
            <div class="form-button">
              <button type="submit" name="submit_start_new_timer" class="btn b-secondary c-primary btn-block">Start new timer</button>
            </div>
          </form>
        </div>
      </div>

      <div class="section m-top-30">
        <div class="box module-widget-btn-box b-white p-top-20 p-right-30 p-bottom-20 p-left-30 m-bottom-15">
          <div class="row">
            <div class="col-lg-2">
              <div class="icon-circle b-secondary c-primary v-middle text-center">
                <i class="fe fe-star v-middle"></i>
              </div>
            </div>
            <div class="col-lg-7">
              <div class="caption c-title v-middle">This <?php echo ($pinned_status->pinned == 1 ? 'is' : 'is not'); ?> a pinned module.</div>
            </div>
            <div class="col-lg-3 text-right">
              <div class="v-middle">
                <a href="<?php echo URL; ?>modules/<?php echo ($pinned_status->pinned == 1 ? 'unpinmodule' : 'pinmodule'); ?>/timetrack">
                  <div class="module-widget-btn b-gray-secondary">
                    <div class="module-widget-btn-circle <?php echo ($pinned_status->pinned == 1 ? 'on' : 'off'); ?> v-middle"></div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="box module-widget-btn-box b-white p-top-20 p-right-30 p-bottom-20 p-left-30">
          <div class="row">
            <div class="col-lg-2">
              <div class="icon-circle b-secondary c-primary v-middle text-center">
                <i class="fe fe-tiled v-middle"></i>
              </div>
            </div>
            <div class="col-lg-7">
              <div class="caption c-title v-middle">The widget is turned <?php echo ($widget_status->display_widget == 1 ? 'on' : 'off'); ?>.</div>
            </div>
            <div class="col-lg-3 text-right">
              <div class="v-middle">
                <a href="<?php echo URL; ?>modules/<?php echo ($widget_status->display_widget == 1 ? 'hidewidget' : 'displaywidget'); ?>/timetrack">
                  <div class="module-widget-btn b-gray-secondary">
                    <div class="module-widget-btn-circle <?php echo ($widget_status->display_widget == 1 ? 'on' : 'off'); ?> v-middle"></div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="d-block m-top-30">
          <a href="<?php echo URL; ?>modules/deletemodule/timetrack">
            <button class="btn b-red-secondary c-red btn-block">Delete module</button>
          </a>
        </div>
      </div>
    </div>
  </div>

</div>
