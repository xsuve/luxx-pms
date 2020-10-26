<!-- Invoices -->
<div class="container-fluid content">

	<!-- Invoices Stats -->
	<?php if(count($invoice_categories) > 0): ?>
		<div class="section m-bottom-20 hide-on-search">
			<div class="text c-gray m-bottom-10">Invoices stats</div>
			<div class="row">
				<?php $i = 0; ?>
				<?php foreach($invoice_categories as $invoice_category): ?>
					<?php if($i <= 2): ?>
						<div class="col-lg-4">
							<div class="box p-all-30 b-white">
								<div class="row">
									<div class="col-lg-6">
										<?php if($invoice_category): ?>
											<div class="category b-<?php echo $invoice_category->color; ?>-secondary c-<?php echo $invoice_category->color; ?> caption v-middle"><?php echo $invoice_category->title; ?></div>
										<?php else: ?>
											<div class="category b-secondary c-primary caption v-middle">Invoice</div>
										<?php endif; ?>
									</div>
									<div class="col-lg-6">
										<h2 class="c-title weight-400 m-bottom-5"><?php echo CURRENCY_SYMBOL . $invoices_model->getInvoiceCategoryValue($invoice_category->id); ?></h2>
										<div class="caption c-gray">invoices value</div>
									</div>
								</div>
							</div>
						</div>
						<?php $i++; ?>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

	<!-- Invoices -->
	<div class="section">
		<div class="text c-gray m-bottom-10">Invoices</div>
		<div class="row">
			<?php if(count($invoices) > 0): ?>
				<?php foreach($invoices as $invoice): ?>
					<?php
						$invoice_category = $categories_model->getCategoryData($invoice->category_id);
						$invoice_items = $invoices_model->getInvoiceItems($invoice->id);
						$invoice_items_value = $invoices_model->getInvoiceItemsValue($invoice->id);
					?>
					<div class="col-lg-4 box-col">
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
				<?php endforeach; ?>
			<?php else: ?>
				<div class="col-lg-12">
					<div class="no-elements-img sections text-center">
						<img src="<?php echo URL; ?>public/img/graphic-4.svg">
					</div>
					<h3 class="c-title m-top-30 text-center">No invoices!</h3>
					<div class="text c-gray text-center">You don't have any invoices yet.</div>
				</div>
			<?php endif; ?>
		</div>
	</div>

</div>