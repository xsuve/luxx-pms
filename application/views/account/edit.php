<div class="container-fluid content">

	<!-- Edit account -->
	<div class="row">
		<div class="col-lg-6">

			<!-- Edit account -->
			<div class="section m-bottom-20">
				<div class="text c-gray m-bottom-10">Edit account</div>
				<div class="box b-white p-all-30">
					<h3 class="project-title c-title m-bottom-30">Edit account info</h3>
					<form action="<?php echo URL; ?>account/editaccount" method="post" enctype="multipart/form-data">
						<div class="form-input-box">
							<div class="caption c-text m-bottom-5">Phone number</div>
							<input type="text" name="account_phone_number" placeholder="Enter the account phone" class="text c-text" value="<?php echo $account->phone_number; ?>">
						</div>
						<div class="form-input-box">
							<div class="caption c-text m-bottom-5">Account profile</div>
							<div class="row">
								<div class="col-lg-8">
									<div class="v-middle">
										<input type="file" name="account_profile" class="text c-text">
										<div class="form-input-box-text caption c-gray m-top-5">An image with under 500 KB and with the dimensions 512px by 512px works the best.</div>
									</div>
								</div>
								<div class="col-lg-4 text-center">
									<div class="contact-image v-middle">
										<?php if(file_exists('public/application/accounts/' . $account->id . '.png')): ?>
						        	<img src="<?php echo URL; ?>public/application/accounts/<?php echo $account->id; ?>.png">
						        <?php else: ?>
						          <img src="<?php echo URL; ?>public/img/account.png">
						        <?php endif; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="form-button">
							<button type="submit" name="submit_edit_account" class="btn b-secondary c-primary btn-block">Edit account</button>
						</div>
					</form>
				</div>
			</div>

			<!-- Update password -->
			<div class="section">
				<div class="text c-gray m-bottom-10">Update password</div>
				<div class="box b-white p-all-30">
					<h3 class="project-title c-title m-bottom-30">Update account password</h3>
					<form action="<?php echo URL; ?>account/updatepassword" method="post">
						<div class="form-input-box">
							<div class="caption c-text m-bottom-5">Current password</div>
							<input type="password" name="current_password" placeholder="Enter the current password" class="text c-text">
						</div>
						<div class="form-input-box">
							<div class="caption c-text m-bottom-5">New password</div>
							<input type="password" name="new_password" placeholder="Enter the new password" class="text c-text">
						</div>
						<div class="form-input-box">
							<div class="caption c-text m-bottom-5">Confirm password</div>
							<input type="password" name="confirm_new_password" placeholder="Enter the new password" class="text c-text">
						</div>
						<div class="form-button">
							<button type="submit" name="submit_update_password" class="btn b-secondary c-primary btn-block">Update password</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="col-lg-6"></div>
	</div>

</div>