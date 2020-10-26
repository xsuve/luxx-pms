<!-- Calendar -->
<div class="container-fluid content">

  <!-- Events -->
  <div class="row">
    <div class="col-lg-7">
      <!-- Calendar -->
      <div class="section m-bottom-20">
        <div class="text c-gray m-bottom-10">Calendar</div>
        <div class="box b-white p-all-30">
          <div id="calendarBox"></div>
        </div>
        <script type="text/javascript">
          var events = [
            <?php $i = 0; ?>
            <?php foreach($events as $event): ?>
              {
                id: '<?php echo $event->id; ?>',
                title: '<?php echo $event->title; ?>',
                start: '<?php echo date_format(date_create($event->start_date), "Y-m-d H:i:s"); ?>',
                end: '<?php echo date_format(date_create($event->end_date), "Y-m-d H:i:s"); ?>',
                allDay: <?php echo $event->all_day; ?>,
                className: 'calendar-event b-<?php echo ($event->color != '' ? $event->color : 'blue'); ?>'
              }<?php echo ($i == count($events) - 1 ? '' : ','); ?>
              <?php $i++; ?>
            <?php endforeach; ?>
          ];
        </script>
      </div>

      <!-- Events -->
      <div class="section">
        <div class="text c-gray m-bottom-10">Events</div>
        <div class="box b-white p-all-30">
          <?php $i = 0; ?>
          <?php if(count($events) > 0): ?>
            <?php foreach($events as $event): ?>
              <div class="list-element p-bottom-15 p-top-15 <?php echo ($i == 0 ? 'first' : ''); ?> <?php echo ($i == (count($events) - 1) ? 'last' : ''); ?>">
                <div class="row">
                  <div class="col-lg-6 text-left">
                    <div class="list-element-title caption v-middle"><?php echo $event->title; ?></div>
                  </div>
                  <div class="col-lg-4 text-left">
                    <div class="v-middle">
                      <div class="list-element-title text c-gray text-center"><?php echo date_format(date_create($event->start_date), 'j M.'); ?> - <?php echo date_format(date_create($event->end_date), 'j M.'); ?></div>
                    </div>
                  </div>
                  <div class="col-lg-2 text-right">
                    <div class="list-element-title v-middle">
                      <button class="more-btn p-right-0 caption c-gray" onclick="event.stopPropagation(); this.childNodes[2].style.display = 'block';"><i class="fe fe-elipsis-h"></i>
                        <div class="more-dropdown module-dropdown box b-white p-top-10 p-left-10 p-bottom-10 v-middle caption text-right">
                          <a href="<?php echo URL; ?>modules/edit/calendar/<?php echo $event->id; ?>">
                            <div class="m-right-5 b-secondary c-primary text-center">
                              <i class="fe fe-edit v-middle"></i>
                            </div>
                          </a>
                          <a href="<?php echo URL; ?>modules/executemoduleaction/calendar/deleteevent/<?php echo $event->id; ?>">
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
              <img src="<?php echo URL; ?>public/img/graphic-3.svg">
            </div>
            <h3 class="c-title m-top-30 text-center">No events!</h3>
            <div class="text c-gray text-center">You don't have any events yet.</div>
          <?php endif; ?>
        </div>
      </div>

    </div>

    <div class="col-lg-5">
      <div class="section">
        <div class="text c-gray m-bottom-10">New event</div>
        <div class="box b-white p-all-30">
          <h3 class="project-title c-title m-bottom-30">Add new event</h3>
          <form action="<?php echo URL; ?>modules/executemoduleaction/calendar/addevent" method="post">
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Title</div>
              <input type="text" name="event_title" placeholder="Enter the event title" class="text c-text">
            </div>
            <div class="m-bottom-30">
              <div class="caption c-text d-inline-block m-right-10">All day</div>
              <div class="form-checkbox d-inline-block">
                <input type="checkbox" name="event_all_day" id="addEventAllDayCheckbox">
                <span class="b-gray-secondary v-middle text-center">
                  <i class="fe fe-check v-middle c-white"></i>
                </span>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">Start date</div>
                  <input type="text" name="event_start_date" placeholder="Enter the event start date" class="text c-text" id="addEventStartDateDatepicker">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">End date</div>
                  <input type="text" name="event_end_date" placeholder="Enter the event end date" class="text c-text" id="addEventEndDateDatepicker">
                </div>
              </div>
            </div>
            <div class="caption c-text m-bottom-10">Color</div>
            <div class="add-category-colors m-bottom-30">
              <div class="b-red-secondary m-right-15">
                <input type="radio" name="event_color" value="red" checked="checked">
                <span class="b-red v-middle"></span>
              </div>
              <div class="b-orange-secondary m-right-15">
                <input type="radio" name="event_color" value="orange">
                <span class="b-orange v-middle"></span>
              </div>
              <div class="b-yellow-secondary m-right-15">
                <input type="radio" name="event_color" value="yellow">
                <span class="b-yellow v-middle"></span>
              </div>
              <div class="b-green-secondary m-right-15">
                <input type="radio" name="event_color" value="green">
                <span class="b-green v-middle"></span>
              </div>
              <div class="b-blue-secondary m-right-15">
                <input type="radio" name="event_color" value="blue">
                <span class="b-blue v-middle"></span>
              </div>
              <div class="b-purple-secondary m-right-15">
                <input type="radio" name="event_color" value="purple">
                <span class="b-purple v-middle"></span>
              </div>
              <div class="b-gray-secondary">
                <input type="radio" name="event_color" value="gray">
                <span class="b-gray v-middle"></span>
              </div>
            </div>
            <div class="form-button">
              <button type="submit" name="submit_add_event" class="btn b-secondary c-primary btn-block">Add event</button>
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
                <a href="<?php echo URL; ?>modules/<?php echo ($pinned_status->pinned == 1 ? 'unpinmodule' : 'pinmodule'); ?>/calendar">
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
                <a href="<?php echo URL; ?>modules/<?php echo ($widget_status->display_widget == 1 ? 'hidewidget' : 'displaywidget'); ?>/calendar">
                  <div class="module-widget-btn b-gray-secondary">
                    <div class="module-widget-btn-circle <?php echo ($widget_status->display_widget == 1 ? 'on' : 'off'); ?> v-middle"></div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="d-block m-top-30">
          <a href="<?php echo URL; ?>modules/deletemodule/calendar">
            <button class="btn b-red-secondary c-red btn-block">Delete module</button>
          </a>
        </div>
      </div>
    </div>
  </div>

</div>