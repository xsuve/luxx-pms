<!-- Project -->
<div class="container-fluid content">

	<!-- Project tasks -->
	<div class="row">

		<div class="col-lg-7">
			<div class="section">
				<div class="text c-gray m-bottom-10">Tasks</div>
				<div class="box b-white p-all-30">
					<?php $i = 0; ?>
					<?php if(count($project_tasks) > 0): ?>
						<?php foreach($project_tasks as $project_task): ?>
							<?php
								$task_category = $categories_model->getCategoryData($project_task->category_id);
								$project_worker = $projects_model->getProjectWorkerData($project_task->worker_id);
							?>
							<div class="list-element p-bottom-15 p-top-15 <?php echo ($i == 0 ? 'first' : ''); ?> <?php echo ($i == (count($project_tasks) - 1) ? 'last' : ''); ?>">
								<div class="row">
									<div class="col-lg-7 text-left">
										<div class="form-checkbox task-checkbox m-right-10">
											<input type="checkbox" name="status" <?php echo ($project_task->completed == true ? 'checked="checked"' : ''); ?> data-task-id="<?php echo $project_task->id; ?>">
											<span class="b-gray-secondary v-middle text-center">
												<i class="fe fe-check v-middle c-white"></i>
											</span>
										</div>
										<div class="project-task-title caption <?php echo ($project_task->completed == true ? 'c-gray' : 'c-text'); ?>" data-task-id="<?php echo $project_task->id; ?>"><?php echo (strlen($project_task->title) > 38 ? substr($project_task->title, 0, 38) . '...' : $project_task->title); ?></div>
									</div>
									<div class="col-lg-3 text-right p-right-0">
										<?php if(count($task_categories) > 0): ?>
											<div class="category b-<?php echo $task_category->color; ?>-secondary c-<?php echo $task_category->color; ?> caption"><?php echo $task_category->title; ?></div>
										<?php else: ?>
											<div class="category b-secondary c-primary caption">Task</div>
										<?php endif; ?>
									</div>
									<?php if($project_task->worker_id != 0): ?>
										<div class="col-lg-1 text-right p-right-0">
											<a href="<?php echo URL; ?>contacts/view/<?php echo $project_worker->contact_id; ?>">
												<div class="project-task-worker">
													<?php if(file_exists('public/application/contacts/' . $project_worker->contact_id . '.png')): ?>
									        	<img src="<?php echo URL; ?>public/application/contacts/<?php echo $project_worker->contact_id; ?>.png">
									        <?php else: ?>
									          <img src="<?php echo URL; ?>public/img/account.png">
									        <?php endif; ?>
												</div>
											</a>
										</div>
									<?php endif; ?>
									<div class="<?php echo ($project_task->worker_id != 0 ? 'col-lg-1' : 'col-lg-2'); ?> text-right p-left-0">
										<div class="project-task-info">
											<button class="more-btn p-right-0 caption c-gray" onclick="event.stopPropagation(); this.childNodes[2].style.display = 'block';"><i class="fe fe-elipsis-h"></i>
												<div class="more-dropdown box b-white p-all-10 v-middle caption text-right">
													<a href="<?php echo URL; ?>projects/task/<?php echo $project_task->id; ?>">
														<div class="m-right-5 b-secondary c-primary text-center">
															<i class="fe fe-edit v-middle"></i>
														</div>
													</a>
													<a href="<?php echo URL; ?>projects/deletetask/<?php echo $project_task->id; ?>">
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
							<img src="<?php echo URL; ?>public/img/graphic-4.svg">
						</div>
						<h3 class="c-title m-top-30 text-center">No tasks!</h3>
						<div class="text c-gray text-center">The project has no tasks yet.</div>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<div class="col-lg-5">

			<!-- Add new task -->
			<div class="section m-bottom-20">
				<div class="text c-gray m-bottom-10">New task</div>
				<div class="box b-white p-all-30">
					<h3 class="project-title c-title m-bottom-30">Add new task</h3>
					<?php if($modules_model->moduleInstalled('saas') && $saas_exceeded_tasks == true): ?>
						<div class="text c-gray m-bottom-30">You have exceeded the number of maximum tasks / project.
						<br><br>
						Please consider upgrading your plan to get more features and extend the current plan features.</div>
						<button class="btn b-secondary c-primary">Upgrade plan</button>
					<?php else: ?>
						<form action="<?php echo URL; ?>projects/addtask" method="post">
							<input type="hidden" name="project_id" value="<?php echo $project->id; ?>">
							<div class="form-input-box">
								<div class="caption c-text m-bottom-5">Title</div>
								<input type="text" name="task_title" placeholder="Enter the task title" class="text c-text">
							</div>
							<?php if(count($task_categories) > 0): ?>
								<div class="form-input-box">
									<div class="caption c-text m-bottom-5">Category (optional)</div>
									<select name="task_category_id" class="text c-text">
										<option value="0" selected="selected">Select the task category</option>
											<?php foreach($task_categories as $task_category): ?>
												<option value="<?php echo $task_category->id; ?>"><?php echo $task_category->title; ?></option>
											<?php endforeach; ?>
									</select>
								</div>
							<?php else: ?>
								<input type="hidden" name="task_category_id" value="0">
							<?php endif; ?>
							<?php if(count($project_workers) > 0): ?>
								<div class="form-input-box">
									<div class="caption c-text m-bottom-5">Assigned worker (optional)</div>
									<select name="task_worker_id" class="text c-text">
										<option value="0" selected="selected">Select the project worker</option>
											<?php foreach($project_workers as $project_worker): ?>
												<?php $project_worker_contact = $projects_model->getWorkerContact($project_worker->contact_id); ?>
												<option value="<?php echo $project_worker->id; ?>"><?php echo $project_worker_contact->name; ?></option>
											<?php endforeach; ?>
									</select>
								</div>
							<?php endif; ?>
							<div class="form-button">
								<button type="submit" name="submit_add_task" class="btn b-secondary c-primary btn-block">Add task</button>
							</div>
						</form>
					<?php endif; ?>
				</div>
			</div>

			<!-- Details -->
			<div class="section m-bottom-20">
				<div class="text c-gray m-bottom-10">Details</div>
				<div class="box b-white p-all-30">
					<button class="box-more-btn p-right-0 more-btn caption c-gray" onclick="event.stopPropagation(); this.childNodes[2].style.display = 'block';"><i class="fe fe-elipsis-h"></i>
						<div class="more-dropdown box b-white p-top-5 p-left-5 p-bottom-5 v-middle caption text-right">
							<a href="<?php echo URL; ?>projects/<?php echo ($project->pinned == 1 ? 'unpinproject' : 'pinproject'); ?>/<?php echo $project->id; ?>">
								<div class="m-right-5 b-green-secondary c-green text-center">
									<i class="fe fe-<?php echo ($project->pinned == 1 ? 'minus' : 'plus');	?> v-middle"></i>
								</div>
							</a>
							<a href="<?php echo URL; ?>projects/edit/<?php echo $project->id; ?>">
								<div class="m-left-5 m-right-5 b-secondary c-primary text-center">
									<i class="fe fe-edit v-middle"></i>
								</div>
							</a>
							<a href="<?php echo URL; ?>projects/deleteproject/<?php echo $project->id; ?>">
								<div class="m-left-5 m-right-5 b-red-secondary c-red text-center">
									<i class="fe fe-trash v-middle"></i>
								</div>
							</a>
							<div class="m-left-5 b-gray-secondary c-gray text-center" onclick="event.stopPropagation(); this.parentElement.style.display = 'none';">
								<i class="fe fe-close v-middle"></i>
							</div>
						</div>
					</button>
					<div class="d-block m-bottom-10">
						<?php if($project_category): ?>
							<div class="category m-bottom-10 b-<?php echo $project_category->color; ?>-secondary c-<?php echo $project_category->color; ?> caption"><?php echo $project_category->title; ?></div>
						<?php else: ?>
							<div class="category m-bottom-10 b-secondary c-primary caption">Project</div>
						<?php endif; ?>
					</div>
					<h3 class="project-title c-title m-bottom-30"><?php echo $project->title; ?></h3>
					<div class="row">
						<div class="col-lg-4">
							<div class="caption c-gray m-bottom-10">Total tasks</div>
							<div class="caption c-gray project-view-info"><i class="fe fe-list-bullet m-right-10"></i><span class="c-text"><?php echo count($completed_tasks); ?>/<?php echo $total_tasks; ?></span></div>
						</div>
						<div class="col-lg-4">
							<div class="caption c-gray m-bottom-10">Deadline</div>
							<div class="caption c-gray project-view-info"><i class="fe fe-calendar m-right-10"></i><span class="c-text"><?php echo $projects_model->formatProjectDeadline($project->deadline, 'd/m'); ?></span></div>
						</div>
						<div class="col-lg-4">
							<div class="caption c-gray m-bottom-10">Income</div>
							<div class="caption c-gray project-view-info"><i class="fe fe-wallet m-right-10"></i><span class="c-text"><?php echo CURRENCY_SYMBOL . $project->income; ?></span></div>
						</div>
					</div>
					<div class="project-progress b-secondary m-top-30">
						<div class="b-primary" style="width: <?php echo $projects_model->formatProjectProgress(count($completed_tasks), $total_tasks); ?>%;"></div>
					</div>
					<h4 class="project-view-details-title c-title m-top-30 m-bottom-10">Workers</h4>
					<?php $i = 0; ?>
					<?php if(count($project_workers) > 0): ?>
						<?php foreach($project_workers as $project_worker): ?>
							<?php $project_worker_contact = $projects_model->getWorkerContact($project_worker->contact_id); ?>
							<div class="project-worker list-element p-bottom-15 p-top-15 <?php echo ($i == 0 ? 'first' : ''); ?> <?php echo ($i == (count($project_workers) - 1) ? 'last' : ''); ?>">
	              <div class="row">
	              	<div class="col-lg-2">
	              		<a href="<?php echo URL; ?>contacts/view/<?php echo $project_worker_contact->id; ?>">
		              		<?php if(file_exists('public/application/contacts/' . $project_worker_contact->id . '.png')): ?>
			                <img src="<?php echo URL; ?>public/application/contacts/<?php echo $project_worker_contact->id; ?>.png">
				              <?php else: ?>
				                <img src="<?php echo URL; ?>public/img/account.png">
				              <?php endif; ?>
				            </a>
	              	</div>
	              	<div class="col-lg-4">
			              <div class="caption c-gray project-view-info v-middle"><i class="fe fe-clock m-right-10"></i><span class="c-text"><?php echo $project_worker->work_hours; ?>h</span></div>
			            </div>
			            <div class="col-lg-4">
			              <div class="caption c-gray project-view-info v-middle"><i class="fe fe-wallet m-right-10"></i><span class="c-text"><?php echo CURRENCY_SYMBOL . $project_worker->price_per_hour; ?>/h</span></div>
			            </div>
			            <div class="col-lg-2 text-right">
			              <button class="more-btn p-right-0 caption c-gray v-middle" onclick="event.stopPropagation(); this.childNodes[2].style.display = 'block';"><i class="fe fe-elipsis-h"></i>
											<div class="more-dropdown box b-white p-top-5 p-left-5 p-bottom-5 v-middle caption text-right">
												<a href="<?php echo URL; ?>projects/worker/<?php echo $project_worker->id; ?>">
													<div class="m-right-5 b-secondary c-primary text-center">
														<i class="fe fe-edit v-middle"></i>
													</div>
												</a>
												<a href="<?php echo URL; ?>projects/deleteworker/<?php echo $project_worker->id; ?>">
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
							<?php $i++; ?>
						<?php endforeach; ?>
					<?php else: ?>
						<div class="text c-gray">The project has no workers yet.</div>
					<?php endif; ?>
					<div class="line-divider"></div>
					<a href="<?php echo URL; ?>projects/kanban/<?php echo $project->id; ?>">
						<button class="btn b-secondary c-primary btn-block">Kanban board</button>
					</a>
				</div>
			</div>

			<!-- Attachments -->
			<div class="section m-bottom-20">
				<div class="text c-gray m-bottom-10">Attachments</div>
				<div class="box b-white p-all-30">
					<h3 class="project-title c-title m-bottom-20">Project attachments</h3>
					<?php if(count($attachments) > 0): ?>
						<?php foreach($attachments as $attachment): ?>
							<?php
								$available_extensions = array('sketch', 'docx', 'xlsx', 'pptx', 'psd', 'ai', 'pdf', 'svg', 'html', 'js', 'css', 'php');
								$pathinfo = pathinfo($attachment);
							?>
							<div class="row m-bottom-20">
								<div class="col-lg-3">
									<div class="document-icon <?php echo $pathinfo['extension']; ?> text-center v-middle">
										<img src="<?php echo URL; ?>public/img/attachments/<?php echo (in_array($pathinfo['extension'], $available_extensions) ? $pathinfo['extension'] : 'file'); ?>.svg" class="v-middle">
									</div>
								</div>
								<div class="col-lg-7 p-left-0">
									<a href="<?php echo URL; ?>public/application/projects/<?php echo $project->id; ?>/<?php echo $pathinfo['basename']; ?>" class="text c-text v-middle" download><?php echo $pathinfo['basename']; ?></a>
								</div>
								<div class="col-lg-2 text-right">
									<button class="more-btn p-right-0 caption c-gray v-middle" onclick="event.stopPropagation(); this.childNodes[2].style.display = 'block';"><i class="fe fe-elipsis-h"></i>
										<div class="more-dropdown attachment-dropdown box b-white p-top-5 p-left-5 p-bottom-5 v-middle caption text-right">
											<a href="<?php echo URL; ?>projects/removeattachment/<?php echo $project->id; ?>/<?php echo $pathinfo['basename']; ?>">
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
						<?php endforeach; ?>
					<?php endif; ?>
					<?php if($modules_model->moduleInstalled('saas') && $saas_exceeded_attachments == true): ?>
						<div class="line-divider"></div>
						<div class="text c-gray m-bottom-30">You have exceeded the number of maximum attachments / project.
						<br><br>
						Please consider upgrading your plan to get more features and extend the current plan features.</div>
						<button class="btn b-secondary c-primary">Upgrade plan</button>
					<?php else: ?>
						<form action="<?php echo URL; ?>projects/addattachment" method="post" enctype="multipart/form-data" class="attachment-upload-form">
							<input type="hidden" name="project_id" value="<?php echo $project->id; ?>">
							<div class="row">
								<div class="col-lg-3 p-right-0">
									<div class="icon-circle b-gray-secondary c-gray text-center v-middle">
										<input type="file" name="attachment" class="attachmentInput">
										<i class="fe fe-plus v-middle"></i>
									</div>
								</div>
								<div class="col-lg-6 p-left-0">
									<div class="text c-text v-middle attachmentInputFileName">No file selected.</div>
								</div>
								<div class="col-lg-3 text-right">
									<button type="submit" name="submit_add_attachment" class="icon-circle small attachment-upload-btn b-secondary c-primary text-center v-middle">
										<i class="fe fe-upload d-block"></i>
									</button>
								</div>
							</div>
						</form>
					<?php endif; ?>
				</div>
			</div>

		</div>

	</div>

</div>
