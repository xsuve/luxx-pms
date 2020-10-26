<div class="container-fluid form">
	<div class="box p-all-50 b-white v-middle">
		<h1 class="c-title text-center m-bottom-50">
			<div class="form-box-logo m-right-10">
				<img src="<?php echo URL; ?>public/img/luxx-logo.svg">
			</div>
			Reset your password
		</h1>
		<form action="<?php echo URL; ?>login/resetpassword" method="post">
			<input type="hidden" name="email" value="<?php echo $email; ?>">
			<input type="hidden" name="token" value="<?php echo $token; ?>">
			<div class="form-input-box">
				<div class="caption c-text m-bottom-5">New password</div>
				<input type="password" name="new_password" placeholder="Enter the new password" class="text c-text">
			</div>
			<div class="form-input-box">
				<div class="caption c-text m-bottom-5">Confirm new password</div>
				<input type="password" name="confirm_new_password" placeholder="Enter the new password again" class="text c-text">
			</div>
			<div class="form-button m-bottom-20">
				<button type="submit" name="reset_password" class="btn b-primary c-white btn-block">Reset password</button>
			</div>
		</form>
	</div>
</div>