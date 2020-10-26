<div class="container-fluid content">

  <!-- Edit worker -->
  <div class="row">
    <div class="col-lg-6">
      <div class="section">
        <div class="text c-gray m-bottom-10">Edit worker</div>
        <div class="box b-white p-all-30">
          <h3 class="project-title c-title m-bottom-30">Edit worker</h3>
          <form action="<?php echo URL; ?>projects/editworker/<?php echo $worker->id; ?>" method="post">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">Work hours</div>
                  <input type="text" name="work_hours" placeholder="Enter the work hours" class="text c-text" value="<?php echo $worker->work_hours; ?>">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">Price per hour (<?php echo CURRENCY; ?>)</div>
                  <input type="text" name="price_per_hour" placeholder="Enter the price per hour" class="text c-text" value="<?php echo $worker->price_per_hour; ?>">
                </div>
              </div>
            </div>
            <div class="form-button">
              <button type="submit" name="submit_edit_worker" class="btn b-secondary c-primary btn-block">Edit worker</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-6"></div>
  </div>

</div>