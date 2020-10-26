<div class="container-fluid content">

	<!-- Edit event -->
	<div class="row">
		<div class="col-lg-6">
			<div class="section">
				<div class="text c-gray m-bottom-10">Edit event</div>
				<div class="box b-white p-all-30">
          <h3 class="project-title c-title m-bottom-30">Edit event</h3>
          <form action="<?php echo URL; ?>modules/executemoduleaction/calendar/editevent/<?php echo $event->id; ?>" method="post">
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Title</div>
              <input type="text" name="event_title" placeholder="Enter the expense title" class="text c-text" value="<?php echo $event->title; ?>">
            </div>
            <div class="m-bottom-30">
              <div class="caption c-text d-inline-block m-right-10">All day</div>
              <div class="form-checkbox d-inline-block">
                <input type="checkbox" name="event_all_day" <?php echo ($event->all_day == true ? 'checked="checked"' : ''); ?> id="addEventAllDayCheckbox">
                <span class="b-gray-secondary v-middle text-center">
                  <i class="fe fe-check v-middle c-white"></i>
                </span>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">Start date</div>
                  <input type="text" name="event_start_date" placeholder="Enter the event start date" class="text c-text" id="addEventStartDateDatepicker" value="<?php echo $event->start_date; ?>">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">End date</div>
                  <input type="text" name="event_end_date" placeholder="Enter the event end date" class="text c-text" id="addEventEndDateDatepicker" value="<?php echo $event->end_date; ?>">
                </div>
              </div>
            </div>
            <div class="caption c-text m-bottom-10">Color</div>
            <div class="add-category-colors m-bottom-30">
              <div class="b-red-secondary m-right-15">
                <input type="radio" name="event_color" value="red" <?php echo ($event->color == 'red' ? 'checked="checked"' : ''); ?>>
                <span class="b-red v-middle"></span>
              </div>
              <div class="b-orange-secondary m-right-15">
                <input type="radio" name="event_color" value="orange" <?php echo ($event->color == 'orange' ? 'checked="checked"' : ''); ?>>
                <span class="b-orange v-middle"></span>
              </div>
              <div class="b-yellow-secondary m-right-15">
                <input type="radio" name="event_color" value="yellow" <?php echo ($event->color == 'yellow' ? 'checked="checked"' : ''); ?>>
                <span class="b-yellow v-middle"></span>
              </div>
              <div class="b-green-secondary m-right-15">
                <input type="radio" name="event_color" value="green" <?php echo ($event->color == 'green' ? 'checked="checked"' : ''); ?>>
                <span class="b-green v-middle"></span>
              </div>
              <div class="b-blue-secondary m-right-15">
                <input type="radio" name="event_color" value="blue" <?php echo ($event->color == 'blue' ? 'checked="checked"' : ''); ?>>
                <span class="b-blue v-middle"></span>
              </div>
              <div class="b-purple-secondary m-right-15">
                <input type="radio" name="event_color" value="purple" <?php echo ($event->color == 'purple' ? 'checked="checked"' : ''); ?>>
                <span class="b-purple v-middle"></span>
              </div>
              <div class="b-gray-secondary">
                <input type="radio" name="event_color" value="gray" <?php echo ($event->color == 'gray' ? 'checked="checked"' : ''); ?>>
                <span class="b-gray v-middle"></span>
              </div>
            </div>
            <div class="form-button">
              <button type="submit" name="submit_edit_event" class="btn b-secondary c-primary btn-block">Edit event</button>
            </div>
          </form>
        </div>
			</div>
		</div>

		<div class="col-lg-6"></div>
	</div>

</div>