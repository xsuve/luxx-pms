<div class="container-fluid content">

  <!-- Add new project -->
  <div class="row">
    <div class="col-lg-6">
      <div class="section">
        <div class="text c-gray m-bottom-10">New project</div>
        <div class="box b-white p-all-30">
          <h3 class="project-title c-title m-bottom-30">Add new project</h3>
          <form action="<?php echo URL; ?>projects/addproject" method="post">
            <?php if(count($project_categories) > 0): ?>
              <div class="form-input-box">
                <div class="caption c-text m-bottom-5">Category (optional)</div>
                <select name="project_category_id" class="text c-text">
                  <option value="0" selected="selected">Select the project category</option>
                    <?php foreach($project_categories as $project_category): ?>
                      <option value="<?php echo $project_category->id; ?>"><?php echo $project_category->title; ?></option>
                    <?php endforeach; ?>
                </select>
              </div>
            <?php else: ?>
              <input type="hidden" name="project_category_id" value="0">
            <?php endif; ?>
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Title</div>
              <input type="text" name="project_title" placeholder="Enter the project title" class="text c-text">
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">Deadline</div>
                  <input type="text" name="project_deadline" placeholder="Enter the project deadline" class="text c-text" id="addProjectDeadlineDatepicker">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">Income (<?php echo CURRENCY; ?>)</div>
                  <input type="text" name="project_income" placeholder="Enter the project income" class="text c-text">
                </div>
              </div>
            </div>
            <div class="form-button">
              <button type="submit" name="submit_add_project" class="btn b-secondary c-primary btn-block">Add project</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-6"></div>
  </div>

</div>