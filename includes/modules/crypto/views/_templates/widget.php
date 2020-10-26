<!-- Module Widget -->
<div class="reminders-box">
	<?php if(count($reminders) > 0): ?>
		<?php foreach($reminders as $reminder): ?>
			<div class="reminder-box widget-box">
				<div class="row">
					<div class="col-lg-1 no-padding-right">
						<div class="reminder-box-button vertical-middle <?php echo ($reminder->completed == 1 ? 'completed' : ''); ?>" data-reminder-id="<?php echo $reminder->id; ?>">
							<i class="fe fe-check vertical-middle"></i>
						</div>
					</div>
					<div class="col-lg-9">
						<div class="reminder-box-title vertical-middle"><?php echo $reminder->title; ?></div>
					</div>
					<div class="col-lg-2">
						<div class="vertical-middle text-right">
							<div class="reminder-widget-box-actions">
								<a href="<?php echo URL; ?>modules/executemoduleaction/reminders/deletereminder/<?php echo $reminder->id; ?>">
									<button><i class="fe fe-trash"></i></button>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	<?php else: ?>
		<div class="general-right-box-text">You don't have any reminders yet.</div>
	<?php endif; ?>
</div>