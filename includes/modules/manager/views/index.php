<!-- Add Reminder Box -->
<div class="lightbox-background" id="managerBox">
	<div class="lightbox">
		<div class="lightbox-close" id="closeAddReminderButton">
			<i class="fe fe-close vertical-middle"></i>
		</div>
		<div class="lightbox-title">Add Reminder</div>
		<form action="<?php echo URL; ?>modules/executemoduleaction/reminders/addreminder" method="post">
			<div class="row">
				<div class="col-lg-12">
					<div class="form-box-input">
						<input type="text" name="reminder_title" placeholder="&#xe82d;&nbsp;&nbsp;Reminder Title">
					</div>
				</div>
			</div>
			<div class="form-box-buttons">
				<button type="submit" name="submit_add_reminder" class="btn btn-primary">ADD REMINDER</button>
			</div>
		</form>
	</div>
</div>

<!-- Reminder Right Box -->
<div class="general-right-box" data-right-box-module="manager">
	<div class="general-right-box-close" data-right-box-module="manager">
		<i class="fe fe-close vertical-middle"></i>
	</div>

	<!-- Tabs -->
	<div class="general-right-box-tabs">
		<div class="row">
			<div class="col-lg-3">
				<div class="general-right-box-tab active" data-tab="manager-contacts">
					<span>CONTACTS</span>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="general-right-box-tab" data-tab="manager-projects">
					<span>PROJECTS</span>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="general-right-box-tab" data-tab="manager-invoices">
					<span>INVOICES</span>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="general-right-box-tab" data-tab="manager-settings">
					<span>SETTINGS</span>
				</div>
			</div>
		</div>
	</div>

	<!-- Content -->
	<div class="general-right-box-content">

		<div class="general-right-box-line"></div>

		<!-- Contacts Tab -->
		<div class="general-right-box-tab-box manager-contacts manager-details">

			<div class="row">
				<div class="col-lg-12 text-left">
					<div class="general-right-box-contact-info-box-title">Contacts</div>
					<div class="general-right-box-contact-info-box-text">0 contacts</div>
				</div>
			</div>

			<div class="general-right-box-line"></div>

		</div>

		<!-- Projects Tab -->
		<div class="general-right-box-tab-box manager-projects">

			<div class="row">
				<div class="col-lg-12 text-left">
					<div class="general-right-box-contact-info-box-title">Projects</div>
					<div class="general-right-box-contact-info-box-text">0 projects</div>
				</div>
			</div>

			<div class="general-right-box-line"></div>

		</div>

		<!-- Invoices Tab -->
		<div class="general-right-box-tab-box manager-invoices">

			<div class="row">
				<div class="col-lg-12 text-left">
					<div class="general-right-box-contact-info-box-title">Invoices</div>
					<div class="general-right-box-contact-info-box-text">0 invoices</div>
				</div>
			</div>

			<div class="general-right-box-line"></div>

		</div>

		<!-- Edit Tab -->
		<div class="general-right-box-tab-box manager-settings">
			<div class="general-right-box-buttons">
				<div class="row">
					<div class="col-lg-12">
						<?php $widget_status = $module_model_widget->getWidgetDisplayStatus('manager')->display_widget; ?>
						<?php if($widget_status == false): ?>
							<a href="<?php echo URL; ?>modules/displaywidget/manager">
								<button class="btn btn-primary">DISPLAY WIDGET</button>
							</a>
						<?php else: ?>
							<a href="<?php echo URL; ?>modules/hidewidget/manager">
								<button class="btn btn-primary">HIDE WIDGET</button>
							</a>
						<?php endif; ?>
					</div>

					<div class="general-right-box-line"></div>

					<div class="col-lg-12 text-right">
						<a href="<?php echo URL; ?>modules/deletemodule/manager">
							<button class="btn btn-primary">DELETE MODULE</button>
						</a>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>