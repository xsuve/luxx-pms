<!-- Projects -->
<div class="container-fluid content">

	<!-- Projects Stats -->
	<?php if(count($ttotal_completed_tasks) > 0): ?>
		<div class="section projects-stats m-bottom-20 hide-on-search text-center">
			<div class="projects-stats-top text-left">
				<h2 class="c-title m-bottom-0"><?php echo count($ttotal_completed_tasks); ?></h2>
				<div class="text c-gray"><?php echo(count($ttotal_completed_tasks) > 0 ? (count($ttotal_completed_tasks) > 1 ? 'Tasks' : 'Task') : 'Tasks'); ?> done</div>
			</div>

			<?php
				$today = date('Y-m-d');
				$today_m = date('Y-m-d');
				$minus = date('Y-m-d', strtotime('-16 days', strtotime(date('Y-m-d'))));
				$minus_o = $minus;
				$minus_m = date('Y-m-d', strtotime('-16 days', strtotime(date('Y-m-d'))));
				$plus = date('Y-m-d', strtotime('+16 days', strtotime(date('Y-m-d'))));
				$plus_o = $plus;
				$plus_m = date('Y-m-d', strtotime('+16 days', strtotime(date('Y-m-d'))));
				$max = 0;
				while(strtotime($minus_m) <= strtotime($plus_m)) {
					$total_completed_tasks_m = $projects_model->getAccountCompletedTasks($account->id, $minus_m);
					if(count($total_completed_tasks_m) > $max) {
						$max = count($total_completed_tasks_m);
					}
					$minus_m = date('Y-m-d', strtotime('+1 day', strtotime($minus_m)));
				}
			?>
			<?php while(strtotime($minus) < strtotime($today)): ?>
				<?php
					$total_completed_tasks = $projects_model->getAccountCompletedTasks($account->id, $minus);
					$height = (count($total_completed_tasks) > 0 ? ((count($total_completed_tasks) * 100) / $max) : 0);
				?>
				<div class="projects-stats-box m-left-5 m-right-5">
					<div class="projects-stats-box-bar m-bottom-10">
						<div class="projects-stats-box-bar-height b-gray-secondary" style="height: <?php echo $height; ?>%;">
							<div class="projects-stats-box-bar-tooltip box b-white p-all-15 text-left">
								<h5 class="c-title"><?php echo count($total_completed_tasks); ?> <?php echo(count($total_completed_tasks) > 0 ? (count($total_completed_tasks) > 1 ? 'TASKS' : 'TASK') : 'TASKS'); ?> DONE</h5>
								<div class="text c-gray"><?php echo date('j F, Y', strtotime($minus)); ?></div>
							</div>
						</div>
					</div>
					<div class="projects-stats-box-bar-day text c-gray text-center"><?php echo date('j', strtotime($minus)); ?></div>
				</div>
				<?php $minus = date('Y-m-d', strtotime('+1 day', strtotime($minus))); ?>
			<?php endwhile; ?>

			<?php while(strtotime($plus) >= strtotime($today)): ?>
				<?php
					$total_completed_tasks = $projects_model->getAccountCompletedTasks($account->id, $today);
					$height = (count($total_completed_tasks) > 0 ? ((count($total_completed_tasks) * 100) / $max) : 0);
				?>
				<div class="projects-stats-box m-left-5 m-right-5">
					<div class="projects-stats-box-bar m-bottom-10">
						<div class="projects-stats-box-bar-height b-gray-secondary" style="height: <?php echo $height; ?>%;">
							<div class="projects-stats-box-bar-tooltip box b-white p-all-15 text-left">
								<h5 class="c-title"><?php echo count($total_completed_tasks); ?> <?php echo(count($total_completed_tasks) > 0 ? (count($total_completed_tasks) > 1 ? 'TASKS' : 'TASK') : 'TASKS'); ?> DONE</h5>
								<div class="text c-gray"><?php echo date('j F, Y', strtotime($today)); ?></div>
							</div>
						</div>
					</div>
					<div class="projects-stats-box-bar-day text c-gray text-center"><?php echo date('j', strtotime($today)); ?></div>
				</div>
				<?php $today = date('Y-m-d', strtotime('+1 day', strtotime($today))); ?>
			<?php endwhile; ?>

			<div class="row m-bottom-20 m-top-10">
				<div class="col-lg-6 text-left">
					<h5 class="c-text"><?php echo date('F', strtotime($minus_o)); ?></h5>
				</div>
				<div class="col-lg-6 text-right">
					<h5 class="c-text"><?php echo date('F', strtotime($plus_o)); ?></h5>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<!-- Pinned Projects -->
	<?php if(count($pinned_projects) > 0): ?>
		<div class="section m-bottom-20 hide-on-search">
			<div class="text c-gray m-bottom-10">Pinned projects</div>
			<div class="row">
				<?php $i = 0; ?>
				<?php foreach($pinned_projects as $pinned_project): ?>
					<?php
						$pinned_project_category = $categories_model->getCategoryData($pinned_project->category_id);
						$pinned_completed_tasks = $projects_model->getProjectCompletedTasks($pinned_project->id);
						$pinned_total_tasks = $projects_model->getProjectTotalTasks($pinned_project->id);
					?>
					<?php if($i <= 2): ?>
						<div class="col-lg-4">
							<a href="<?php echo URL; ?>projects/view/<?php echo $pinned_project->id; ?>">
								<div class="box b-white">
									<div class="p-all-30">
										<?php if($pinned_project_category): ?>
											<div class="category-dot b-<?php echo $pinned_project_category->color; ?>-secondary m-right-10">
												<div class="b-<?php echo $pinned_project_category->color; ?> v-middle"></div>
											</div>
										<?php else: ?>
											<div class="category-dot b-secondary m-right-10">
												<div class="b-primary v-middle"></div>
											</div>
										<?php endif; ?>
										<h3 class="project-title c-title m-bottom-0"><?php echo (strlen($pinned_project->title) > 22 ? substr($pinned_project->title, 0, 22) . '...' : $pinned_project->title); ?></h3>
									</div>
									<div class="project-info">
										<div class="row">
											<div class="col-lg-4 text-left p-right-0">
												<div class="caption c-gray"><i class="fe fe-list-bullet m-right-10"></i><span class="c-title"><?php echo count($pinned_completed_tasks); ?></span> / <?php echo $pinned_total_tasks; ?></div>
											</div>
											<div class="col-lg-8 text-right">
												<div class="caption c-gray"><i class="fe fe-calendar m-right-10"></i><?php echo $projects_model->formatProjectDeadline($pinned_project->deadline, 'j F, Y'); ?></div>
											</div>
										</div>
									</div>
									<div class="project-progress b-secondary">
										<div class="b-primary" style="width: <?php echo $projects_model->formatProjectProgress(count($pinned_completed_tasks), $pinned_total_tasks); ?>%;"></div>
									</div>
								</div>
							</a>
						</div>
						<?php $i++; ?>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

	<!-- Projects -->
	<div class="section">
		<div class="text c-gray m-bottom-10">Projects</div>
		<div class="row">
			<?php if(count($projects) > 0): ?>
				<?php foreach($projects as $project): ?>
					<?php
						$project_category = $categories_model->getCategoryData($project->category_id);
						$project_tasks = $projects_model->getProjectTasks($project->id);
						$project_workers = $projects_model->getProjectWorkers($project->id);
					?>
					<div class="col-lg-4 box-col">
						<a href="<?php echo URL; ?>projects/view/<?php echo $project->id; ?>">
							<div class="box b-white m-bottom-30" data-search="<?php echo strtolower($project->title); ?> <?php echo strtolower($project_category->title); ?>">
								<div class="p-all-30">
									<?php if($project_category): ?>
										<div class="category b-<?php echo $project_category->color; ?>-secondary c-<?php echo $project_category->color; ?> caption"><?php echo $project_category->title; ?></div>
									<?php else: ?>
										<div class="category b-secondary c-primary caption">Project</div>
									<?php endif; ?>
									<h3 class="project-title c-title m-top-20 d-block"><?php echo (strlen($project->title) > 22 ? substr($project->title, 0, 22) . '...' : $project->title); ?></h3>
									<div class="project-tasks">
										<ul class="project-task-list">
											<?php $j = 0; ?>
											<?php if(count($project_tasks) > 0): ?>
												<?php foreach($project_tasks as $project_task): ?>
													<?php if($j <= 2): ?>
														<li class="text c-text"><?php echo (strlen($project_task->title) > 30 ? substr($project_task->title, 0, 30) . '...' : $project_task->title); ?></li>
														<?php $j++; ?>
													<?php endif; ?>
												<?php endforeach; ?>
											<?php else: ?>
												<div class="m-top-5"></div>
											<?php endif; ?>
										</ul>
									</div>
									<div class="project-workers m-top-20">
										<?php if(count($project_workers) > 0): ?>
											<?php foreach($project_workers as $project_worker): ?>
												<?php $project_worker_contact = $projects_model->getWorkerContact($project_worker->contact_id); ?>
												<div>
													<?php if(file_exists('public/application/contacts/' . $project_worker_contact->id . '.png')): ?>
					                <img src="<?php echo URL; ?>public/application/contacts/<?php echo $project_worker_contact->id; ?>.png">
						              <?php else: ?>
						                <img src="<?php echo URL; ?>public/img/account.png">
						              <?php endif; ?>
												</div>
											<?php endforeach; ?>
										<?php else: ?>
											<div class="no-workers b-gray-secondary c-gray text-center">
												<i class="fe fe-plus v-middle"></i>
											</div>
											<span class="caption c-gray">No workers</span>
										<?php endif; ?>
									</div>
								</div>
								<div class="project-info">
									<div class="caption c-gray"><i class="fe fe-calendar m-right-10"></i>Deadline: <span class="caption c-primary"><?php echo $projects_model->formatProjectDeadline($project->deadline, 'j F, Y'); ?></span></div>
								</div>
							</div>
						</a>
					</div>
				<?php endforeach; ?>
			<?php else: ?>
				<div class="col-lg-12">
					<div class="no-elements-img sections text-center m-top-30">
						<img src="<?php echo URL; ?>public/img/graphic-2.svg">
					</div>
					<h3 class="c-title m-top-30 text-center">No projects!</h3>
					<div class="text c-gray text-center">You don't have any projects yet.</div>
				</div>
			<?php endif; ?>
		</div>
	</div>

</div>