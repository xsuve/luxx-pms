<!-- Account -->
<div class="container-fluid content account">
	<div class="content-cover">
		<img src="<?php echo URL; ?>public/img/account-cover.jpg">
		<div class="content-cover-profile">
			<div class="content-account-image b-white">
				<?php if(file_exists('public/application/accounts/' . $account->id . '.png')): ?>
        	<img src="<?php echo URL; ?>public/application/accounts/<?php echo $account->id; ?>.png">
        <?php else: ?>
          <img src="<?php echo URL; ?>public/img/account.png">
        <?php endif; ?>
			</div>
			<h3 class="contact-account-name c-title m-top-20 m-bottom-0"><?php echo $account->name; ?></h3>
			<div class="text c-text">signed up on <?php echo date('j F, Y', strtotime($account->register_date)); ?></div>
		</div>
	</div>
</div>

<div class="container-fluid content account-fix">

	<!-- Account info -->
	<div class="row">

		<div class="col-lg-6">
			<div class="section">
				<div class="text c-gray m-bottom-10">Details</div>
				<div class="box b-white p-all-30">
					<div class="contact-view-more-btn">
						<button class="more-btn p-right-0 caption c-gray v-middle" onclick="event.stopPropagation(); this.childNodes[2].style.display = 'block';"><i class="fe fe-elipsis-h"></i>
							<div class="more-dropdown box b-white p-top-5 p-left-5 p-bottom-5 v-middle caption text-right">
								<a href="<?php echo URL; ?>account/edit">
									<div class="m-left-5 m-right-5 b-secondary c-primary text-center">
										<i class="fe fe-edit v-middle"></i>
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
							<div class="caption c-gray"><i class="fe fe-user m-right-10"></i>Name</div>
						</div>
						<div class="contact-view-detail-right p-all-20">
							<div class="caption c-text"><?php echo $account->name; ?></div>
						</div>
					</div>
					<div class="contact-view-detail m-bottom-10 m-top-10">
						<div class="contact-view-detail-left p-all-20">
							<div class="caption c-gray"><i class="fe fe-mail m-right-10"></i>E-mail</div>
						</div>
						<div class="contact-view-detail-right p-all-20">
							<div class="caption c-text"><?php echo $account->email; ?></div>
						</div>
					</div>
					<div class="contact-view-detail m-bottom-10">
						<div class="contact-view-detail-left p-all-20">
							<div class="caption c-gray"><i class="fe fe-phone m-right-10"></i>Phone</div>
						</div>
						<div class="contact-view-detail-right p-all-20">
							<div class="caption c-text"><?php echo $account->phone_number; ?></div>
						</div>
					</div>
					<div class="contact-view-detail">
						<div class="contact-view-detail-left p-all-20">
							<div class="caption c-gray"><i class="fe fe-calendar m-right-10"></i>Member</div>
						</div>
						<div class="contact-view-detail-right p-all-20">
							<div class="caption c-text"><?php echo date('j F, Y', strtotime($account->register_date)); ?></div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Account -->
		<div class="col-lg-6">

			<?php if($modules_model->moduleInstalled('saas')): ?>
				<div class="section">
					<div class="text c-gray m-bottom-10">Current plan</div>
					<div class="box b-white p-all-30">
						<div class="row">
							<div class="col-lg-2">
								<div class="account-plan-image v-middle">
									<img src="<?php echo URL; ?>public/img/luxx-logo.svg">
								</div>
							</div>
							<div class="col-lg-6 p-left-0">
								<div class="v-middle">
									<h4 class="c-title m-bottom-0"><?php echo $account_plan->title; ?></h4>
									<div class="text c-gray"><?php echo date_format(date_create($account_plan->next_payment), 'j F, Y'); ?></div>
								</div>
							</div>
							<div class="col-lg-4 text-right">
								<button class="btn b-secondary c-primary btn-block v-middle">Upgrade</button>
							</div>
						</div>
						<div class="line-divider"></div>

						<!-- Max contacts -->
						<div class="row m-bottom-30">
							<div class="col-lg-7">
								<div class="caption c-text v-middle">Maximum contacts (<?php echo count($total_contacts); ?>/<?php echo $max_contacts; ?>)</div>
							</div>
							<div class="col-lg-5">
								<div class="project-progress b-secondary v-middle">
									<div class="b-primary" style="width: <?php echo $projects_model->formatProjectProgress(count($total_contacts), $max_contacts); ?>%;"></div>
								</div>
							</div>
						</div>

						<!-- Max projects -->
						<div class="row m-bottom-30">
							<div class="col-lg-7">
								<div class="caption c-text v-middle">Maximum projects (<?php echo count($total_projects); ?>/<?php echo $max_projects; ?>)</div>
							</div>
							<div class="col-lg-5">
								<div class="project-progress b-secondary v-middle">
									<div class="b-primary" style="width: <?php echo $projects_model->formatProjectProgress(count($total_projects), $max_projects); ?>%;"></div>
								</div>
							</div>
						</div>

						<!-- Max invoices -->
						<div class="row m-bottom-30">
							<div class="col-lg-7">
								<div class="caption c-text v-middle">Maximum invoices (<?php echo count($total_invoices); ?>/<?php echo $max_invoices; ?>)</div>
							</div>
							<div class="col-lg-5">
								<div class="project-progress b-secondary v-middle">
									<div class="b-primary" style="width: <?php echo $projects_model->formatProjectProgress(count($total_invoices), $max_invoices); ?>%;"></div>
								</div>
							</div>
						</div>

						<!-- Max categories -->
						<div class="row">
							<div class="col-lg-7">
								<div class="caption c-text v-middle">Maximum categories (<?php echo count($total_categories); ?>/<?php echo $max_categories; ?>)</div>
							</div>
							<div class="col-lg-5">
								<div class="project-progress b-secondary v-middle">
									<div class="b-primary" style="width: <?php echo $projects_model->formatProjectProgress(count($total_categories), $max_categories); ?>%;"></div>
								</div>
							</div>
						</div>

					</div>
				</div>
			<?php endif; ?>

		</div>

	</div>

</div>
