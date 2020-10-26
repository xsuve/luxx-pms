<!-- Dashboard -->
<div class="container-fluid content">

	<!-- Dashboard Onboarding -->
	<?php if(count($contacts) <= 0 && count($projects) <= 0 && count($invoices) <= 0): ?>
		<div class="row m-top-50">
			<div class="col-lg-4">
				<div class="no-elements-img dashboard-onboarding text-center">
					<img src="<?php echo URL; ?>public/img/graphic-3.svg">
				</div>
				<h3 class="c-title m-top-30 text-center">Add your first contact</h3>
				<div class="text c-gray text-center">Keep your personal contacts, workers and clients together.</div>
				<div class="text-center m-top-30">
					<a href="<?php echo URL; ?>contacts/add"><button class="btn b-secondary c-primary">Add new contact</button></a>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="no-elements-img dashboard-onboarding text-center">
					<img src="<?php echo URL; ?>public/img/graphic-4.svg">
				</div>
				<h3 class="c-title m-top-30 text-center">Start your first project</h3>
				<div class="text c-gray text-center">Manage your projects, add tasks and workers and check the progress.</div>
				<div class="text-center m-top-30">
					<a href="<?php echo URL; ?>projects/add"><button class="btn b-secondary c-primary">Start new project</button></a>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="no-elements-img dashboard-onboarding text-center">
					<img src="<?php echo URL; ?>public/img/graphic-1.svg">
				</div>
				<h3 class="c-title m-top-30 text-center">Create your first invoice</h3>
				<div class="text c-gray text-center">Deploy invoices for clients, add items, preview and download as PDF.</div>
				<div class="text-center m-top-30">
					<a href="<?php echo URL; ?>invoices/add"><button class="btn b-secondary c-primary">Create new invoice</button></a>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<!-- Overview -->
	<?php if(count($projects) > 0): ?>
		<div class="section m-bottom-20">
			<div class="text c-gray m-bottom-10">Overview</div>
			<div class="row">
				<div class="col-lg-4">
					<div class="box p-all-30 b-white">
						<div class="stats-icon b-primary text-center">
							<i class="fe fe-list-bullet c-white v-middle"></i>
						</div>
						<div class="stats-info m-left-10">
							<h2 class="stats-title c-title"><?php echo $total_tasks; ?><!-- <i class="fe fe-arrow-up c-success m-left-10"></i> --></h2>
							<div class="stats-text text c-gray m-top-5">Project tasks</div>
						</div>
						<!-- <div class="stats-change text c-success">+5.90</div> -->
					</div>
				</div>
				<div class="col-lg-4">
					<div class="box p-all-30 b-white">
						<div class="stats-icon b-orange text-center">
							<i class="fe fe-wallet c-white v-middle"></i>
						</div>
						<div class="stats-info m-left-10">
							<h2 class="stats-title c-title"><?php echo CURRENCY_SYMBOL . ($total_income > 0 ? number_format($total_income) : 0); ?><!-- <i class="fe fe-arrow-up c-success m-left-10"></i> --></h2>
							<div class="stats-text text c-gray m-top-5">Total income</div>
						</div>
						<!-- <div class="stats-change text c-success">+5.90</div> -->
					</div>
				</div>
				<div class="col-lg-4">
					<div class="box p-all-30 b-white">
						<div class="stats-icon b-green text-center">
							<i class="fe fe-layer c-white v-middle"></i>
						</div>
						<div class="stats-info m-left-10">
							<h2 class="stats-title c-title"><?php echo count($projects); ?><!-- <i class="fe fe-arrow-up c-success m-left-10"></i> --></h2>
							<div class="stats-text text c-gray m-top-5">Total projects</div>
						</div>
						<!-- <div class="stats-change text c-success">+5.90</div> -->
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<div class="row">
		<div class="col-lg-8">

			<!-- Projects -->
			<?php if(count($projects) > 0): ?>
				<div class="section m-bottom-20">
					<div class="text c-gray m-bottom-10">Projects</div>
					<div class="row">
						<?php $i = 0; ?>
						<?php if(count($projects) > 0): ?>
							<?php foreach($projects as $project): ?>
								<?php
									$project_category = $categories_model->getCategoryData($project->category_id);
									$project_tasks = $projects_model->getProjectTasks($project->id);
									$project_workers = $projects_model->getProjectWorkers($project->id);
								?>
								<div class="col-lg-6 box-col">
									<a href="<?php echo URL; ?>projects/view/<?php echo $project->id; ?>">
										<div class="box b-white <?php echo ($i == count($projects) - 1 ? '' : 'm-bottom-30'); ?>" data-search="<?php echo strtolower($project->title); ?> <?php echo strtolower($project_category->title); ?>">
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
								<?php $i++; ?>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>

			<!-- Contacts -->
			<?php if(count($contacts) > 0): ?>
				<div class="section m-bottom-20">
					<div class="text c-gray m-bottom-10">Contacts</div>
					<div class="row">
						<?php $i = 0; ?>
						<?php if(count($contacts) > 0): ?>
							<?php foreach($contacts as $contact): ?>
								<?php $contact_category = $categories_model->getCategoryData($contact->category_id); ?>
								<div class="col-lg-4 box-col">
									<a href="<?php echo URL; ?>contacts/view/<?php echo $contact->id; ?>">
										<div class="box b-white <?php echo ($i == count($contacts) - 1 ? '' : 'm-bottom-30'); ?>" data-search="<?php echo strtolower($contact->name); ?> <?php echo strtolower($contact->email); ?> <?php echo strtolower($contact_category->title); ?>">
											<div class="p-all-30 text-center">
												<div class="contact-image-big">
													<?php if(file_exists('public/application/contacts/' . $contact->id . '.png')): ?>
					                <img src="<?php echo URL; ?>public/application/contacts/<?php echo $contact->id; ?>.png" class="v-middle">
						              <?php else: ?>
						                <img src="<?php echo URL; ?>public/img/account.png">
						              <?php endif; ?>
												</div>
												<h4 class="contact-name c-title m-top-20"><?php echo $contact->name; ?></h4>
												<?php if($contact_category): ?>
													<div class="category m-top-5 b-<?php echo $contact_category->color; ?>-secondary c-<?php echo $contact_category->color; ?> caption"><?php echo $contact_category->title; ?></div>
												<?php else: ?>
													<div class="category m-top-5 b-blue-secondary c-primary caption">Contact</div>
												<?php endif; ?>
												<div class="contact-links m-top-20">
													<div class="icon-circle b-white text-center c-primary"><i class="fas fa-envelope v-middle"></i></div>
													<div class="icon-circle b-white text-center c-primary"><i class="fas fa-phone v-middle"></i></div>
													<div class="icon-circle b-white text-center c-primary"><i class="fas fa-map-marker-alt v-middle"></i></div>
												</div>
											</div>
										</div>
									</a>
								</div>
								<?php $i++; ?>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>

			<!-- Invoices -->
			<?php if(count($invoices) > 0): ?>
				<div class="section">
					<div class="text c-gray m-bottom-10">Invoices</div>
					<div class="row">
						<?php $i = 0; ?>
						<?php if(count($invoices) > 0): ?>
							<?php foreach($invoices as $invoice): ?>
								<?php
									$invoice_category = $categories_model->getCategoryData($invoice->category_id);
									$invoice_items = $invoices_model->getInvoiceItems($invoice->id);
									$invoice_items_value = $invoices_model->getInvoiceItemsValue($invoice->id);
								?>
								<div class="col-lg-6 box-col">
									<a href="<?php echo URL; ?>invoices/view/<?php echo $invoice->id; ?>">
										<div class="box b-white m-bottom-30" data-search="<?php echo strtolower($invoice->contact_name); ?> <?php echo strtolower($invoice->contact_email); ?> <?php echo strtolower($invoice_category->title); ?>">
											<div class="p-all-30">
												<div class="row">
													<div class="col-lg-6 text-left">
														<div class="invoice-contact-img">
															<?php if(file_exists('public/application/contacts/' . $invoice->contact_id . '.png')): ?>
							                <img src="<?php echo URL; ?>public/application/contacts/<?php echo $invoice->contact_id; ?>.png" class="v-middle">
								              <?php else: ?>
								                <img src="<?php echo URL; ?>public/img/account.png">
								              <?php endif; ?>
														</div>
													</div>
													<div class="col-lg-6 text-right">
														<?php if($invoice_category): ?>
															<div class="category b-<?php echo $invoice_category->color; ?>-secondary c-<?php echo $invoice_category->color; ?> caption"><?php echo $invoice_category->title; ?></div>
														<?php else: ?>
															<div class="category b-secondary c-primary caption">Invoice</div>
														<?php endif; ?>
													</div>
												</div>
												<h3 class="project-title c-title m-top-20 d-block m-bottom-5"><?php echo (strlen($invoice->contact_name) > 22 ? substr($invoice->contact_name, 0, 22) . '...' : $invoice->contact_name); ?></h3>
												<div class="text c-text m-bottom-0"><?php echo $invoice->contact_email; ?></div>
											</div>
											<div class="invoice-info">
												<div class="row">
													<div class="invoice-info-line col-lg-6 p-right-0 p-top-15 p-bottom-15 text-center">
														<h4 class="project-title c-title m-bottom-0"><?php echo count($invoice_items); ?></h4>
														<div class="text c-gray"><?php echo (count($invoice_items) > 0 ? (count($invoice_items) == 1 ? 'Item' : 'Items') : 'Items'); ?></div>
													</div>
													<div class="col-lg-6 p-left-0 p-top-15 p-bottom-15 text-center">
														<h4 class="project-title c-title m-bottom-0"><?php echo CURRENCY_SYMBOL . ($invoice_items_value > 0 ? $invoice_items_value : 0); ?></h4>
														<div class="text c-gray">Total value</div>
													</div>
												</div>
											</div>
											<div class="project-info">
												<div class="caption c-gray"><i class="fe fe-calendar m-right-10"></i>Due date: <span class="caption c-primary"><?php echo $invoices_model->formatInvoiceDueDate($invoice->due_date, 'j F, Y'); ?></span></div>
											</div>
										</div>
									</a>
								</div>
								<?php $i++; ?>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>

		</div>
		<div class="col-lg-4">
			<?php if(count($module_widgets) > 0): ?>
				<?php foreach($module_widgets as $module_widget): ?>
					<?php if($module_widget->title == 'wallet'): ?>
						<?php $modules_model->loadModuleWidget($module_widget->title); ?>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>

	</div>

	<!-- Module widgets -->
	<?php if(count($module_widgets) > 0): ?>
		<div class="row">
			<?php foreach($module_widgets as $module_widget): ?>
				<?php if($module_widget->title != 'wallet'): ?>
					<div class="col-lg-6">
						<?php $modules_model->loadModuleWidget($module_widget->title); ?>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

</div>