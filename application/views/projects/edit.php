<div class="container-fluid content">

  <!-- Edit project -->
  <div class="row">
    <div class="col-lg-6">
      <div class="section">
        <div class="text c-gray m-bottom-10">Edit project</div>
        <div class="box b-white p-all-30">
          <h3 class="project-title c-title m-bottom-30">Edit project</h3>
          <form action="<?php echo URL; ?>projects/editproject/<?php echo $project->id; ?>" method="post">
            <?php if(count($project_categories) > 0): ?>
              <div class="form-input-box">
                <div class="caption c-text m-bottom-5">Category (optional)</div>
                <select name="project_category_id" class="text c-text">
                  <option value="0" <?php echo ($project->category_id == 0 ? 'selected="selected"' : ''); ?>>Select the project category</option>
                    <?php foreach($project_categories as $project_category): ?>
                      <option value="<?php echo $project_category->id; ?>" <?php echo ($project->category_id == $project_category->id ? 'selected="selected"' : ''); ?>><?php echo $project_category->title; ?></option>
                    <?php endforeach; ?>
                </select>
              </div>
            <?php else: ?>
              <input type="hidden" name="project_category_id" value="0">
            <?php endif; ?>
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Title</div>
              <input type="text" name="project_title" placeholder="Enter the project title" class="text c-text" value="<?php echo $project->title; ?>">
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">Deadline</div>
                  <input type="text" name="project_deadline" placeholder="Enter the project deadline" class="text c-text" id="addProjectDeadlineDatepicker" value="<?php echo $project->deadline; ?>">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">Income (<?php echo CURRENCY; ?>)</div>
                  <input type="text" name="project_income" placeholder="Enter the project income" class="text c-text" value="<?php echo $project->income; ?>">
                </div>
              </div>
            </div>
            <div class="form-button">
              <button type="submit" name="submit_edit_project" class="btn b-secondary c-primary btn-block">Edit project</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-6"></div>
  </div>

</div>