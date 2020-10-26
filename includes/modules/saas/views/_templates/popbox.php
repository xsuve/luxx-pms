<?php if(isset($_SESSION['saas_title']) && $_SESSION['saas_title'] != ''): ?>
	<div class="pop-box">
		<div class="pop-box-close">
			<a href="<?php echo URL . $_SESSION['saas_close_link']; ?>"><i class="fe fe-close c-gray"></i></a>
		</div>
		<div class="v-middle">
			<div class="row">
				<div class="col-lg-1">
					<div class="pop-box-logo v-middle">
						<img src="<?php echo URL; ?>public/img/luxx-logo.svg">
					</div>
				</div>
				<div class="col-lg-11">
					<div class="v-middle">
						<h1 class="c-title"><?php echo $_SESSION['saas_title']; ?></h1>
						<div class="text c-text">Please consider upgrading your plan to get more features and extend the current plan features.</div>
					</div>
				</div>
			</div>
			<div class="row m-top-50">
				<?php foreach($plans as $plan): ?>
					<?php if($plan->monthly_price != 0): ?>
						<div class="col-lg-3">
							<div class="pricing-plan box b-white <?php echo ($plan->id == $account_plan->id ? 'current-plan' : ''); ?> p-all-30 text-center">
								<h3 class="c-title m-bottom-0"><?php echo $plan->title; ?></h3>
								<div class="line-divider m-20"></div>
								<h1 class="c-text">
									<sup class="weight-400"><?php echo CURRENCY_SYMBOL; ?></sup>
									<?php echo $plan->monthly_price; ?>
									<sub class="weight-400">/ month</sub>
								</h1>
								<div class="line-divider m-20"></div>
								<div class="pricing-plan-include text c-gray m-bottom-5">
									<span class="c-text"><?php echo $plan->max_contacts; ?></span> max. contacts
								</div>
								<div class="pricing-plan-include text c-gray m-bottom-5">
									<span class="c-text"><?php echo $plan->max_projects; ?></span> max. projects
								</div>
								<div class="pricing-plan-include text c-gray m-bottom-5">
									<span class="c-text"><?php echo $plan->max_invoices; ?></span> max. invoices
								</div>
								<div class="pricing-plan-include text c-gray m-bottom-5">
									<span class="c-text"><i class="fe fe-<?php echo ($plan->feature_kanban_board == 1 ? 'check' : 'close'); ?>"></i></span>&nbsp;&nbsp;&nbsp;Kanban board
								</div>
								<div class="pricing-plan-include text c-gray m-bottom-5">
									<span class="c-text"><i class="fe fe-<?php echo ($plan->feature_email_invoice == 1 ? 'check' : 'close'); ?>"></i></span>&nbsp;&nbsp;&nbsp;E-mail invoice
								</div>
								<div class="pricing-plan-include text c-gray m-bottom-5">
									<span class="c-text"><i class="fe fe-<?php echo ($plan->feature_download_pdf == 1 ? 'check' : 'close'); ?>"></i></span>&nbsp;&nbsp;&nbsp;Download invoice PDF
								</div>
								<div class="line-divider m-20"></div>
								<?php if($plan->id == $account_plan->id): ?>
									<button class="btn b-secondary c-primary">Current plan</button>
								<?php else: ?>
									<form action="<?php echo URL; ?>paypal/makepayment" method="post">
										<input type="hidden" name="plan_id" value="<?php echo $plan->id; ?>">
										<input type="hidden" name="from_url" value="<?php echo $_SESSION['saas_from_link']; ?>">
				            <button type="submit" name="submit_buy_now" class="btn b-primary c-white">Buy now</button>
				        	</form>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$('html').addClass('no-scroll');
	</script>
	<?php
		$_SESSION['saas_title'] = '';
		$_SESSION['saas_close_link'] = '';
		$_SESSION['saas_from_link'] = '';
	?>
<?php endif; ?>