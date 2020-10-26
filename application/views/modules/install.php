<div class="container-fluid content">

  <!-- Install new module -->
  <div class="row">
    <div class="col-lg-6">
      <div class="section">
        <div class="text c-gray m-bottom-10">Install module</div>
        <div class="box b-white p-all-30">
          <h3 class="project-title c-title m-bottom-30">Install new module</h3>
          <form action="<?php echo URL; ?>modules/installmodule" method="post" enctype="multipart/form-data">
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Module</div>
              <input type="file" name="module" class="text c-text">
            </div>
            <div class="form-button">
              <button type="submit" name="submit_install_module" class="btn b-secondary c-primary btn-block">Install module</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-6"></div>
  </div>

</div>