<!-- Contact -->
<div class="container-fluid content account">
	<div class="content-cover">
		<img src="<?php echo URL; ?>public/img/account-cover.jpg">
		<div class="content-cover-profile">
			<div class="content-account-image b-white">
				<?php if(file_exists('public/application/contacts/' . $contact->id . '.png')): ?>
        	<img src="<?php echo URL; ?>public/application/contacts/<?php echo $contact->id; ?>.png">
        <?php else: ?>
          <img src="<?php echo URL; ?>public/img/account.png">
        <?php endif; ?>
			</div>
			<h3 class="contact-account-name c-title m-top-20 m-bottom-0"><?php echo $contact->name; ?></h3>
			<div class="text c-text"><?php echo ($contact_category ? $contact_category->title : 'Contact'); ?></div>
		</div>
		<div class="content-cover-links">
			<div class="contact-links">
				<a href="<?php echo URL; ?>contacts/<?php echo $contact->pinned == 1 ? 'unpincontact' : 'pincontact'; ?>/<?php echo $contact->id; ?>" class="icon-circle b-white text-center c-primary"><i class="fas <?php echo $contact->pinned == 0 ? 'fa-plus-circle' : 'fa-minus-circle'; ?> v-middle"></i></a>
				<a href="mailto:<?php echo $contact->email; ?>" target="_blank" class="icon-circle b-white text-center c-primary m-left-15"><i class="fas fa-envelope v-middle"></i></a>
				<a href="tel:<?php echo $contact->phone_number; ?>" target="_blank" class="icon-circle b-white text-center c-primary m-left-15 m-right-15"><i class="fas fa-phone v-middle"></i></a>
				<a href="https://www.google.com/maps/place/<?php echo $contact->address; ?>" target="_blank" class="icon-circle b-white text-center c-primary"><i class="fas fa-map-marker-alt v-middle"></i></a>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid content account-fix">

	<!-- Contact info -->
	<div class="row">
		<div class="col-lg-6">
			<div class="section">
				<div class="text c-gray m-bottom-10">Details</div>
				<div class="box b-white p-all-30">
					<div class="contact-view-more-btn">
						<button class="more-btn p-right-0 caption c-gray v-middle" onclick="event.stopPropagation(); this.childNodes[2].style.display = 'block';"><i class="fe fe-elipsis-h"></i>
							<div class="more-dropdown box b-white p-top-5 p-left-5 p-bottom-5 v-middle caption text-right">
								<a href="<?php echo URL; ?>contacts/edit/<?php echo $contact->id; ?>">
									<div class="m-left-5 m-right-5 b-secondary c-primary text-center">
										<i class="fe fe-edit v-middle"></i>
									</div>
								</a>
								<a href="<?php echo URL; ?>contacts/deletecontact/<?php echo $contact->id; ?>">
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
					<div class="contact-view-detail m-bottom-10 m-top-30">
						<div class="contact-view-detail-left p-all-20">
							<div class="caption c-gray"><i class="fe fe-mail m-right-10"></i>E-mail</div>
						</div>
						<div class="contact-view-detail-right p-all-20">
							<div class="caption c-text"><?php echo $contact->email; ?></div>
						</div>
					</div>
					<div class="contact-view-detail m-bottom-10">
						<div class="contact-view-detail-left p-all-20">
							<div class="caption c-gray"><i class="fe fe-phone m-right-10"></i>Phone</div>
						</div>
						<div class="contact-view-detail-right p-all-20">
							<div class="caption c-text"><?php echo $contact->phone_number; ?></div>
						</div>
					</div>
					<div class="contact-view-detail">
						<div class="contact-view-detail-left p-all-20">
							<div class="caption c-gray"><i class="fe fe-location m-right-10"></i>Address</div>
						</div>
						<div class="contact-view-detail-right p-all-20">
							<div class="caption c-text"><?php echo $contact->address; ?></div>
						</div>
					</div>
					<?php if($contact->company_details != ''): ?>
						<div class="contact-view-detail m-top-10">
							<div class="contact-view-detail-left p-all-20">
								<div class="caption c-gray"><i class="fe fe-building m-right-10"></i>Company</div>
							</div>
							<div class="contact-view-detail-right p-all-20">
								<div class="caption c-text"><?php echo $contact->company_details; ?></div>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<!-- Contact projects -->
		<div class="col-lg-6">

			<!-- Add to project -->
			<?php if(count($projects) > 0): ?>
				<div class="section <?php echo (count($contact_projects) > 0 ? 'm-bottom-20' : ''); ?>">
					<div class="text c-gray m-bottom-10">Add to project</div>
					<div class="box b-white p-all-30">
						<h3 class="project-title c-title m-bottom-30">Add contact to project</h3>
						<form action="<?php echo URL; ?>contacts/addtoproject" method="post">
							<input type="hidden" name="contact_id" value="<?php echo $contact->id; ?>">
							<div class="form-input-box">
								<div class="caption c-text m-bottom-5">Project</div>
								<select name="project_id" class="text c-text">
									<option value="" selected="selected" disabled="disabled">Select the project</option>
										<?php if(count($contact_projects) > 0): ?>
											<?php foreach($projects as $project): ?>
												<?php foreach($contact_projects as $contact_project): ?>
													<?php if($project->id != $contact_project->id): ?>
														<option value="<?php echo $project->id; ?>"><?php echo $project->title; ?></option>
													<?php endif; ?>
												<?php endforeach; ?>
											<?php endforeach; ?>
										<?php else: ?>
											<?php foreach($projects as $project): ?>
												<option value="<?php echo $project->id; ?>"><?php echo $project->title; ?></option>
											<?php endforeach; ?>
										<?php endif; ?>
								</select>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-input-box">
										<div class="caption c-text m-bottom-5">Work hours</div>
										<input type="text" name="work_hours" placeholder="Enter the work hours" class="text c-text">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-input-box">
										<div class="caption c-text m-bottom-5">Price / hour (<?php echo CURRENCY; ?>)</div>
										<input type="text" name="price_per_hour" placeholder="Enter the price per hour" class="text c-text">
									</div>
								</div>
							</div>
							<div class="form-button">
								<button type="submit" name="submit_add_to_project" class="btn b-secondary c-primary btn-block">Add to project</button>
							</div>
						</form>
					</div>
				</div>
			<?php endif; ?>

			<!-- Projects -->
			<?php if(count($contact_projects) > 0): ?>
				<div class="section">
					<div class="text c-gray m-bottom-10">Projects</div>
					<div class="box b-white p-all-30">
						<?php $i = 0; ?>
						<?php foreach($contact_projects as $contact_project): ?>
							<?php
								$contact_project_category = $categories_model->getCategoryData($contact_project->category_id);
								$contact_completed_tasks = $contacts_model->getContactWorkerTasks($contact_project->id, true);
      					$contact_total_tasks = $contacts_model->getContactWorkerTasks($contact_project->id);
							?>
							<a href="<?php echo URL; ?>projects/view/<?php echo $contact_project->project_id; ?>">
								<div class="list-element p-bottom-15 p-top-15 <?php echo ($i == 0 ? 'first' : ''); ?> <?php echo ($i == (count($contact_projects) - 1) ? 'last' : ''); ?>">
									<div class="row">
										<div class="col-lg-1 p-right-0">
											<div class="category-dot b-<?php echo $contact_project_category->color; ?>-secondary m-right-10">
												<div class="b-<?php echo $contact_project_category->color; ?> v-middle"></div>
											</div>
										</div>
										<div class="col-lg-6">
											<h4 class="caption c-title d-inline-block"><?php echo (strlen($contact_project->title) > 37 ? substr($contact_project->title, 0, 37) . '...' : $contact_project->title); ?></h4>
										</div>
										<div class="col-lg-2 p-right-0">
											<div class="project-task-title caption c-gray"><?php echo count($contact_total_tasks); ?> <?php echo (count($contact_total_tasks) > 0 ? (count($contact_total_tasks) > 1 ? 'tasks' : 'task') : 'tasks'); ?></div>
										</div>
										<div class="col-lg-3 text-right">
											<div class="project-progress b-secondary v-middle">
												<div class="b-primary" style="width: <?php echo $projects_model->formatProjectProgress(count($contact_completed_tasks), count($contact_total_tasks)); ?>%;"></div>
											</div>
										</div>
									</div>
								</div>
							</a>
							<?php $i++; ?>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

		</div>

	</div>

</div>