<!-- Project -->
<div class="container-fluid content kanban-board">

	<!-- Project tasks -->
	<div class="section">
		<div class="text c-gray m-bottom-10">Kanban board</div>

		<div class="kanban-board-row-box">
			<div class="row flex-nowrap kanban-board-row">
				<?php if(count($task_categories) > 0): ?>
					<?php foreach($task_categories as $task_category): ?>
						<div class="col-lg-4 kanban-board-col">
							<div class="box b-white kanban-board-category-box">
								<div class="kanban-board-header p-top-15 p-bottom-15 p-right-30 p-left-30 b-<?php echo $task_category->color; ?>">
									<div class="caption c-white"><?php echo $task_category->title; ?></div>
								</div>

								<div class="kanban-board-body p-left-30 p-right-30 p-top-15 p-bottom-15 b-white" data-kanban-board-category-id="<?php echo $task_category->id; ?>" data-kanban-board-category-color="<?php echo $task_category->color; ?>">
									<?php
										$i = 0;
										$category_project_tasks = array();
										foreach($project_tasks as $project_task) {
											if($project_task->category_id == $task_category->id) {
												array_push($category_project_tasks, $project_task->id);
											}
										}
									?>
									<?php if(count($project_tasks) > 0): ?>
										<?php foreach($project_tasks as $project_task): ?>
											<?php if($project_task->category_id == $task_category->id): ?>
												<div class="box b-white p-all-15 kanban-board-task border-top-<?php echo $task_category->color; ?> <?php echo ($i == (count($category_project_tasks) - 1) ? 'last' : ''); ?>" data-kanban-board-task-id="<?php echo $project_task->id; ?>">
													<div class="kanban-board-task-delete b-gray-secondary text-center">
														<a href="<?php echo URL; ?>projects/kanbandeletetask/<?php echo $project_task->id; ?>"><i class="fe fe-trash c-gray v-middle"></i></a>
													</div>
													<div class="row">
														<div class="col-lg-2 p-right-0">
															<div class="form-checkbox task-checkbox">
																<input type="checkbox" name="status" <?php echo ($project_task->completed == true ? 'checked="checked"' : ''); ?> data-task-id="<?php echo $project_task->id; ?>">
																<span class="b-gray-secondary v-middle text-center">
																	<i class="fe fe-check v-middle c-white"></i>
																</span>
															</div>
														</div>
														<div class="col-lg-10 p-left-0">
															<div class="project-task-title caption c-text"><?php echo $project_task->title; ?></div>
														</div>
													</div>
													<div class="row">
														<div class="col-lg-8">
															<div class="v-middle">
																<?php if($project_task->completed == 1): ?>
																	<div class="text c-gray kanban-board-task-status"><?php echo $projects_model->formatProjectDeadline($project_task->date_completed, 'j F, Y'); ?></div>
																<?php endif; ?>
															</div>
														</div>
														<div class="col-lg-4 text-right">
															<?php if($project_task->worker_id != 0): ?>
																<?php $project_worker_contact = $projects_model->getWorkerContact($project_task->worker_id); ?>
																<div class="project-workers v-middle">
																	<div class="kanban-board-task-workers">
																		<?php if(file_exists('public/application/contacts/' . $project_worker_contact->id . '.png')): ?>
										                <img src="<?php echo URL; ?>public/application/contacts/<?php echo $project_worker_contact->id; ?>.png">
											              <?php else: ?>
											                <img src="<?php echo URL; ?>public/img/account.png">
											              <?php endif; ?>
																	</div>
																</div>
															<?php endif; ?>
														</div>
													</div>
												</div>
												<?php $i++; ?>
											<?php endif; ?>
										<?php endforeach; ?>
										<!-- <?php if(count($category_project_tasks) <= 0): ?>
											<div class="caption c-gray m-bottom-10">This task category has no tasks yet.</div>
										<?php endif; ?> -->
									<?php endif; ?>
								</div>

								<div class="kanban-board-footer b-gray-secondary p-top-15 p-bottom-15 p-right-30 p-left-30" data-kanban-board-category-id="<?php echo $task_category->id; ?>">
									<div class="caption c-gray"><i class="fe fe-plus"></i>&nbsp;&nbsp;Add new task</div>
								</div>
								<div class="kanban-board-footer-onadd-wrapper" data-kanban-board-category-id="<?php echo $task_category->id; ?>">
									<div class="row">
										<div class="col-lg-6 p-right-0 text-left">
											<div class="kanban-board-footer-onadd addcomplete radius-right-0 b-green-secondary p-top-15 p-bottom-15 p-right-30 p-left-30" data-project-id="<?php echo $project->id; ?>" data-kanban-board-category-id="<?php echo $task_category->id; ?>" data-kanban-board-category-color="<?php echo $task_category->color; ?>">
												<div class="caption c-green"><i class="fe fe-plus"></i>&nbsp;&nbsp;Add this task</div>
											</div>
										</div>
										<div class="col-lg-6 p-left-0 text-right">
											<div class="kanban-board-footer-onadd addcancel radius-left-0 b-gray-secondary p-top-15 p-bottom-15 p-right-30 p-left-30" data-kanban-board-category-id="<?php echo $task_category->id; ?>">
												<div class="caption c-gray"><i class="fe fe-close"></i>&nbsp;&nbsp;Cancel</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
					<!-- <div class="col-lg-4 kanban-board-col">
						<div class="box b-white p-all-30">
							<div class="caption c-gray text-center kanban-board-new-board-text">Add a new project task category to add a new board.</div>
						</div>
					</div> -->
				<?php else: ?>
					<!-- NO CATEGORIES -->
				<?php endif; ?>
			</div>
		</div>

	</div>

</div>