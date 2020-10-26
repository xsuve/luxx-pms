<div class="container-fluid content">

  <!-- Edit task -->
  <div class="row">
    <div class="col-lg-6">
      <div class="section">
        <div class="text c-gray m-bottom-10">Edit task</div>
        <div class="box b-white p-all-30">
          <h3 class="project-title c-title m-bottom-30">Edit task</h3>
          <form action="<?php echo URL; ?>projects/edittask/<?php echo $task->id; ?>" method="post">
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Title</div>
              <input type="text" name="task_title" placeholder="Enter the task title" class="text c-text" value="<?php echo $task->title; ?>">
            </div>
            <?php if(count($task_categories) > 0): ?>
              <div class="form-input-box">
                <div class="caption c-text m-bottom-5">Category</div>
                <select name="task_category_id" class="text c-text">
                  <option value="0" selected="selected">Select the task category</option>
                    <?php foreach($task_categories as $task_category): ?>
                      <option value="<?php echo $task_category->id; ?>" <?php echo ($task->category_id == $task_category->id ? 'selected="selected"' : ''); ?>><?php echo $task_category->title; ?></option>
                    <?php endforeach; ?>
                </select>
              </div>
            <?php else: ?>
              <input type="hidden" name="task_category_id" value="0">
            <?php endif; ?>
            <?php if(count($project_workers) > 0): ?>
              <div class="form-input-box">
                <div class="caption c-text m-bottom-5">Assigned worker</div>
                <select name="task_worker_id" class="text c-text">
                  <option value="0" selected="selected">Select the project worker</option>
                    <?php foreach($project_workers as $project_worker): ?>
                      <?php $project_worker_contact = $projects_model->getWorkerContact($project_worker->contact_id); ?>
                      <option value="<?php echo $project_worker->id; ?>" <?php echo ($task->worker_id == $project_worker->id ? 'selected="selected"' : ''); ?>><?php echo $project_worker_contact->name; ?></option>
                    <?php endforeach; ?>
                </select>
              </div>
            <?php endif; ?>
            <div class="form-button">
              <button type="submit" name="submit_edit_task" class="btn b-secondary c-primary btn-block">Edit task</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-6"></div>
  </div>

</div>