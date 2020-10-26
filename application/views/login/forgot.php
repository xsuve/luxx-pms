<div class="container-fluid form">
	<div class="box p-all-50 b-white v-middle">
		<h1 class="c-title text-center m-bottom-50">
			<div class="form-box-logo m-right-10">
				<img src="<?php echo URL; ?>public/img/luxx-logo.svg">
			</div>
			Reset your password
		</h1>
		<form action="<?php echo URL; ?>login/forgotpassword" method="post">
			<div class="form-input-box">
				<div class="caption c-text m-bottom-5">E-mail</div>
				<input type="email" name="email" placeholder="Enter the e-mail" class="text c-text">
			</div>
			<div class="form-button m-bottom-20">
				<button type="submit" name="forgot_password" class="btn b-primary c-white btn-block">Reset password</button>
			</div>
		</form>
		<div class="text c-text text-center">Still need help? <a href="<?php echo URL; ?>support" class="c-primary">Support</a></div>
	</div>
</div>