<div class="container-fluid content">

	<!-- Edit contact -->
	<div class="row">
		<div class="col-lg-6">
			<div class="section">
				<div class="text c-gray m-bottom-10">Edit contact</div>
				<div class="box b-white p-all-30">
					<h3 class="project-title c-title m-bottom-30">Edit contact</h3>
					<form action="<?php echo URL; ?>contacts/editcontact/<?php echo $contact->id; ?>" method="post" enctype="multipart/form-data">
						<?php if(count($contact_categories) > 0): ?>
							<div class="form-input-box">
								<div class="caption c-text m-bottom-5">Category (optional)</div>
								<select name="contact_category_id" class="text c-text">
									<option value="0" <?php echo ($contact->category_id == 0 ? 'selected="selected"' : ''); ?>>Select the contact category</option>
										<?php foreach($contact_categories as $contact_category): ?>
											<option value="<?php echo $contact_category->id; ?>" <?php echo ($contact->category_id == $contact_category->id ? 'selected="selected"' : ''); ?>><?php echo $contact_category->title; ?></option>
										<?php endforeach; ?>
								</select>
							</div>
						<?php else: ?>
							<input type="hidden" name="contact_category_id" value="0">
						<?php endif; ?>
						<div class="form-input-box">
							<div class="caption c-text m-bottom-5">Name</div>
							<input type="text" name="contact_name" placeholder="Enter the contact name" class="text c-text" value="<?php echo $contact->name; ?>">
						</div>
						<div class="form-input-box">
							<div class="caption c-text m-bottom-5">E-mail</div>
							<input type="email" name="contact_email" placeholder="Enter the contact e-mail" class="text c-text" value="<?php echo $contact->email; ?>">
						</div>
						<div class="form-input-box">
							<div class="caption c-text m-bottom-5">Phone</div>
							<input type="text" name="contact_phone" placeholder="Enter the contact phone" class="text c-text" value="<?php echo $contact->phone_number; ?>">
						</div>
						<div class="form-input-box">
							<div class="caption c-text m-bottom-5">Address</div>
							<input type="text" name="contact_address" placeholder="Enter the contact address" class="text c-text" value="<?php echo $contact->address; ?>">
						</div>
						<div class="form-input-box">
							<div class="caption c-text m-bottom-5">Company details</div>
							<input type="text" name="company_details" placeholder="Enter the company details (optional)" class="text c-text" value="<?php echo $contact->company_details; ?>">
						</div>
						<div class="form-input-box">
							<div class="caption c-text m-bottom-5">Contact image</div>
							<div class="row">
								<div class="col-lg-8">
									<input type="file" name="contact_image" class="text c-text v-middle">
								</div>
								<div class="col-lg-4 text-center">
									<div class="contact-image v-middle">
										<?php if(file_exists('public/application/contacts/' . $contact->id . '.png')): ?>
						        	<img src="<?php echo URL; ?>public/application/contacts/<?php echo $contact->id; ?>.png">
						        <?php else: ?>
						          <img src="<?php echo URL; ?>public/img/account.png">
						        <?php endif; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="form-button">
							<button type="submit" name="submit_edit_contact" class="btn b-secondary c-primary btn-block">Edit contact</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="col-lg-6"></div>
	</div>

</div>