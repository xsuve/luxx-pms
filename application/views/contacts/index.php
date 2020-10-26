<!-- Contacts -->
<div class="container-fluid content">

	<!-- Pinned Contacts -->
	<?php if(count($pinned_contacts) > 0): ?>
		<div class="section m-bottom-20 hide-on-search">
			<div class="text c-gray m-bottom-10">Pinned contacts</div>
			<div class="row">
				<?php $i = 1; ?>
				<?php foreach($pinned_contacts as $pinned_contact): ?>
					<?php $pinned_contact_category = $categories_model->getCategoryData($pinned_contact->category_id); ?>
					<?php if($i <= 3): ?>
						<div class="col-lg-4">
							<a href="<?php echo URL; ?>contacts/view/<?php echo $pinned_contact->id; ?>">
								<div class="box p-all-30 b-white">
									<div class="contact-image">
										<?php if(file_exists('public/application/contacts/' . $pinned_contact->id . '.png')): ?>
		                <img src="<?php echo URL; ?>public/application/contacts/<?php echo $pinned_contact->id; ?>.png" class="v-middle">
			              <?php else: ?>
			                <img src="<?php echo URL; ?>public/img/account.png">
			              <?php endif; ?>
									</div>
									<div class="contact-details m-left-10">
										<h4 class="contact-name c-title"><?php echo $pinned_contact->name; ?></h4>
										<?php if($pinned_contact_category): ?>
											<div class="category m-top-5 b-<?php echo $pinned_contact_category->color; ?>-secondary c-<?php echo $pinned_contact_category->color; ?> caption"><?php echo $pinned_contact_category->title; ?></div>
										<?php else: ?>
											<div class="category m-top-5 b-secondary c-primary caption">Contact</div>
										<?php endif; ?>
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

	<!-- Contacts -->
	<div class="section">
		<div class="text c-gray m-bottom-10">Contacts</div>
		<div class="row">
			<?php if(count($contacts) > 0): ?>
				<?php foreach($contacts as $contact): ?>
					<?php $contact_category = $categories_model->getCategoryData($contact->category_id); ?>
					<div class="col-lg-3 box-col">
						<a href="<?php echo URL; ?>contacts/view/<?php echo $contact->id; ?>">
							<div class="box b-white m-bottom-30" data-search="<?php echo strtolower($contact->name); ?> <?php echo strtolower($contact->email); ?> <?php echo strtolower($contact_category->title); ?>">
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
				<?php endforeach; ?>
			<?php else: ?>
				<div class="col-lg-12">
					<div class="no-elements-img sections text-center">
						<img src="<?php echo URL; ?>public/img/graphic-1.svg">
					</div>
					<h3 class="c-title m-top-30 text-center">No contacts!</h3>
					<div class="text c-gray text-center">You don't have any contacts yet.</div>
				</div>
			<?php endif; ?>
		</div>
	</div>

</div>