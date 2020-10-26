<!-- Feedback -->
<div class="container-fluid content">


  <!-- Feedbacks -->
  <div class="row">
    <div class="col-lg-7">
      <!-- Announcements -->
      <div class="section m-bottom-20">
        <div class="text c-gray m-bottom-10">Announcements</div>
        <div class="box b-white p-all-30">
          <div class="row">
            <div class="col-lg-2">
              <div class="caption c-gray">19 Jul.</div>
            </div>
            <div class="col-lg-10">
              <div class="caption c-text">The feedback module has been updated.</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Feedbacks -->
      <div class="section">
        <div class="text c-gray m-bottom-10">Feedbacks</div>
        <div class="box b-white p-all-30">
          <?php $i = 0; ?>
          <?php if(count($feedbacks) > 0): ?>
            <?php foreach($feedbacks as $feedback): ?>
              <?php
                switch($feedback->category) {
                  case 'bug':
                    $feedback_icon_color = 'red';
                    $feedback_icon = 'fe fe-bug';
                  break;
                  case 'feature':
                    $feedback_icon_color = 'blue';
                    $feedback_icon = 'fe fe-diamond';
                  break;
                  case 'typo':
                    $feedback_icon_color = 'green';
                    $feedback_icon = 'fe fe-text-size';
                  break;
                  case 'other':
                    $feedback_icon_color = 'gray';
                    $feedback_icon = 'fe fe-wrench';
                  break;
                }
              ?>
              <div class="list-element p-bottom-15 p-top-15 <?php echo ($i == 0 ? 'first' : ''); ?> <?php echo ($i == (count($feedbacks) - 1) ? 'last' : ''); ?>">
                <div class="row">
                  <div class="col-lg-1 p-right-0">
                    <div class="caption c-gray v-middle">#<?php echo $feedback->id; ?></div>
                  </div>
                  <div class="col-lg-6 text-left">
                    <div class="list-element-title feedback-description-preview c-text caption v-middle" data-feedback-id="<?php echo $feedback->id; ?>"><?php echo (strlen($feedback->description) > 35 ? substr($feedback->description, 0, 35) . '...' : $feedback->description); ?></div>
                    <div class="list-element-title feedback-description c-text caption v-middle" data-feedback-id="<?php echo $feedback->id; ?>"><?php echo $feedback->description; ?></div>
                  </div>
                  <div class="col-lg-1 p-right-0 text-right">
                    <div class="icon-circle small b-<?php echo $feedback_icon_color; ?>-secondary c-<?php echo $feedback_icon_color; ?> text-center v-middle" title="<?php echo ucfirst($feedback->category); ?>"><i class="<?php echo $feedback_icon; ?> v-middle"></i></div>
                  </div>
                  <div class="col-lg-2 text-left">
                    <div class="v-middle">
                      <div class="list-element-title text c-gray text-center"><?php echo date_format(date_create($feedback->feedback_date), 'j M.'); ?></div>
                    </div>
                  </div>
                  <div class="col-lg-2 text-right">
                    <div class="category b-blue-secondary c-blue caption v-middle"><?php echo $feedback->status; ?></div>
                  </div>
                </div>
              </div>
              <?php $i++; ?>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="no-elements-img text-center">
              <img src="<?php echo URL; ?>public/img/graphic-1.svg">
            </div>
            <h3 class="c-title m-top-30 text-center">No feedbacks!</h3>
            <div class="text c-gray text-center">There isn't any feedback yet.</div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="section">
        <div class="text c-gray m-bottom-10">New feedback</div>
        <div class="box b-white p-all-30">
          <h3 class="project-title c-title m-bottom-30">Add new feedback</h3>
          <form action="<?php echo URL; ?>modules/executemoduleaction/feedback/addfeedback" method="post">
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Date</div>
              <input type="text" name="feedback_date" placeholder="Enter the feedback date" class="text c-text" id="addFeedbackDateDatepicker" value="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Category</div>
              <select name="feedback_category" class="text c-text">
                <option value="" selected="selected" disabled="disabled">Select the feedback category</option>
                <option value="bug">Bug</option>
                <option value="feature">Feature</option>
                <option value="typo">Typo</option>
                <option value="other">Other</option>
              </select>
            </div>
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Section</div>
              <select name="feedback_section" class="text c-text">
                <option value="" selected="selected" disabled="disabled">Select the feedback section</option>
                <option value="loginsignup">Log in/Sign up</option>
                <option value="dashboard">Dashboard</option>
                <option value="contacts">Contacts</option>
                <option value="projects">Projects</option>
                <option value="invoices">Invoices</option>
                <option value="modules">Modules</option>
                <option value="categories">Categories</option>
                <option value="account">Account</option>
                <option value="other">Other</option>
              </select>
            </div>
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Description</div>
              <textarea type="text" name="feedback_description" placeholder="Enter the feedback description" class="text c-text" style="min-height: 100px;"></textarea>
            </div>
            <div class="form-button">
              <button type="submit" name="submit_add_feedback" class="btn b-secondary c-primary btn-block">Add feedback</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>