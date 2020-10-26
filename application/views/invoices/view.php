<!-- Invoice -->
<div class="container-fluid content">

	<!-- Invoice items -->
	<div class="row">

		<div class="col-lg-7">
			<div class="section">
				<div class="text c-gray m-bottom-10">Items</div>
				<div class="box b-white p-all-30">
					<?php $i = 0; ?>
					<?php if(count($invoice_items) > 0): ?>
						<?php foreach($invoice_items as $invoice_item): ?>
							<div class="list-element p-bottom-15 p-top-15 <?php echo ($i == 0 ? 'first' : ''); ?> <?php echo ($i == (count($invoice_items) - 1) ? 'last' : ''); ?>">
								<div class="row">
									<div class="col-lg-7 text-left">
										<div class="project-task-title caption c-title"><?php echo $invoice_item->title; ?></div>
									</div>
									<div class="col-lg-2 text-left">
										<div class="project-task-title caption c-gray">x<?php echo $invoice_item->quantity; ?></div>
									</div>
									<div class="col-lg-2 text-left">
										<div class="project-task-title caption c-gray"><?php echo CURRENCY_SYMBOL . $invoice_item->price; ?></div>
									</div>
									<div class="col-lg-1 p-left-0 text-right">
										<div class="project-task-info">
											<button class="more-btn p-right-0 caption c-gray" onclick="event.stopPropagation(); this.childNodes[2].style.display = 'block';"><i class="fe fe-elipsis-h"></i>
												<div class="more-dropdown box b-white p-all-10 v-middle caption text-right">
													<a href="<?php echo URL; ?>invoices/item/<?php echo $invoice_item->id; ?>">
														<div class="m-right-5 b-secondary c-primary text-center">
															<i class="fe fe-edit v-middle"></i>
														</div>
													</a>
													<a href="<?php echo URL; ?>invoices/deleteitem/<?php echo $invoice_item->id; ?>">
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
							<img src="<?php echo URL; ?>public/img/graphic-2.svg">
						</div>
						<h3 class="c-title m-top-30 text-center">No items!</h3>
						<div class="text c-gray text-center">The invoice has no items yet.</div>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<div class="col-lg-5">

			<!-- Add new item -->
			<div class="section m-bottom-20">
				<div class="text c-gray m-bottom-10">New item</div>
				<div class="box b-white p-all-30">
					<h3 class="project-title c-title m-bottom-30">Add new item</h3>
					<?php if($modules_model->moduleInstalled('saas') && $saas_exceeded_items == true): ?>
						<div class="text c-gray m-bottom-30">You have exceeded the number of maximum items / invoice.
						<br><br>
						Please consider upgrading your plan to get more features and extend the current plan features.</div>
						<button class="btn b-secondary c-primary">Upgrade plan</button>
					<?php else: ?>
						<form action="<?php echo URL; ?>invoices/additem" method="post">
							<input type="hidden" name="invoice_id" value="<?php echo $invoice->id; ?>">
							<div class="form-input-box">
								<div class="caption c-text m-bottom-5">Title</div>
								<input type="text" name="item_title" placeholder="Enter the task title" class="text c-text">
							</div>
							<div class="form-input-box">
								<div class="caption c-text m-bottom-5">Quantity</div>
								<input type="text" name="item_quantity" placeholder="Enter the item quantity" class="text c-text">
							</div>
							<div class="form-input-box">
								<div class="caption c-text m-bottom-5">Price (<?php echo CURRENCY; ?>)</div>
								<input type="text" name="item_price" placeholder="Enter the item price" class="text c-text">
							</div>
							<div class="form-button">
								<button type="submit" name="submit_add_item" class="btn b-secondary c-primary btn-block">Add item</button>
							</div>
						</form>
					<?php endif; ?>
				</div>
			</div>

			<!-- Details -->
			<div class="section">
				<div class="text c-gray m-bottom-10">Details</div>
				<div class="box b-white p-all-30">
					<button class="box-more-btn p-right-0 more-btn caption c-gray" onclick="event.stopPropagation(); this.childNodes[2].style.display = 'block';"><i class="fe fe-elipsis-h"></i>
						<div class="more-dropdown box b-white p-top-5 p-left-5 p-bottom-5 v-middle caption text-right">
							<a href="<?php echo URL; ?>invoices/edit/<?php echo $invoice->id; ?>">
								<div class="m-right-5 m-left-5 b-secondary c-primary text-center">
									<i class="fe fe-edit v-middle"></i>
								</div>
							</a>
							<a href="<?php echo URL; ?>invoices/deleteinvoice/<?php echo $invoice->id; ?>">
								<div class="m-left-5 m-right-5 b-red-secondary c-red text-center">
									<i class="fe fe-trash v-middle"></i>
								</div>
							</a>
							<div class="m-left-5 b-gray-secondary c-gray text-center" onclick="event.stopPropagation(); this.parentElement.style.display = 'none';">
								<i class="fe fe-close v-middle"></i>
							</div>
						</div>
					</button>
					<div class="row m-bottom-30">
						<div class="col-lg-3">
							<div class="contact-image invoice-image v-middle">
                <?php if(file_exists('public/application/invoices/' . $invoice->id . '.png')): ?>
                  <img src="<?php echo URL; ?>public/application/invoices/<?php echo $invoice->id; ?>.png">
                <?php else: ?>
                  <img src="<?php echo URL; ?>public/img/luxx-logo.png">
                <?php endif; ?>
              </div>
						</div>
						<div class="col-lg-8">
							<div class="d-block">
								<?php if($invoice_category): ?>
									<div class="category m-bottom-10 b-<?php echo $invoice_category->color; ?>-secondary c-<?php echo $invoice_category->color; ?> caption"><?php echo $invoice_category->title; ?></div>
								<?php else: ?>
									<div class="category m-bottom-10 b-secondary c-primary caption">Invoice</div>
								<?php endif; ?>
							</div>
							<h3 class="project-title c-title"><?php echo $invoice->contact_name; ?></h3>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4">
							<div class="caption c-gray m-bottom-10">Due date</div>
							<div class="caption c-gray project-view-info"><i class="fe fe-calendar m-right-10"></i><span class="c-text"><?php echo $invoices_model->formatInvoiceDueDate($invoice->due_date, 'd/m'); ?></span></div>
						</div>
						<div class="col-lg-4">
							<div class="caption c-gray m-bottom-10">Total items</div>
							<div class="caption c-gray project-view-info"><i class="fe fe-list-bullet m-right-10"></i><span class="c-text"><?php echo count($invoice_items); ?></span></div>
						</div>
						<div class="col-lg-4">
							<div class="caption c-gray m-bottom-10">Total value</div>
							<div class="caption c-gray project-view-info"><i class="fe fe-wallet m-right-10"></i><span class="c-text"><?php echo CURRENCY_SYMBOL . ($invoice_items_value > 0 ? $invoice_items_value : 0); ?></span></div>
						</div>
					</div>

					<div class="line-divider"></div>
					<div class="row">
						<div class="col-lg-6 text-right">
							<a href="<?php echo URL; ?>invoices/previewinvoice/<?php echo $invoice->id; ?>" target="_blank"><button class="btn b-yellow-secondary c-yellow btn-block">Preview PDF</button></a>
						</div>
						<div class="col-lg-6 text-left">
							<a href="<?php echo URL; ?>invoices/downloadinvoice/<?php echo $invoice->id; ?>"><button class="btn b-red-secondary c-red btn-block">Download PDF</button></a>
						</div>
						<div class="col-lg-6 text-right m-top-30">
							<a href="<?php echo URL; ?>invoices/email/<?php echo $invoice->id; ?>"><button class="btn b-secondary c-primary btn-block">E-mail invoice</button></a>
						</div>
					</div>

					<!-- <?php if($invoice->paid == 0): ?>
						<div class="line-divider"></div>

						<form action="<?php echo URL; ?>invoices/payinvoice/<?php echo $invoice->id; ?>" method="post">
							<button class="btn b-green-secondary c-green btn-block">Pay invoice</button>
						</form>
					</div> -->
				<?php endif; ?>

				</div>
			</div>

		</div>

	</div>

</div>
