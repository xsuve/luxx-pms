<div class="container-fluid form">
	<div class="box p-all-50 b-white v-middle">
		<h1 class="c-title text-center m-bottom-50">
			<div class="form-box-logo m-right-10">
				<img src="<?php echo URL; ?>public/img/luxx-logo.svg">
			</div>
			Log into your account
		</h1>
		<form action="<?php echo URL; ?>login/loginaccount" method="post">
			<div class="form-input-box">
				<div class="caption c-text m-bottom-5">E-mail</div>
				<input type="email" name="email" placeholder="Enter the e-mail" class="text c-text">
			</div>
			<div class="form-input-box">
				<div class="caption c-text m-bottom-5">Password</div>
				<input type="password" name="password" placeholder="Enter the password" class="text c-text">
			</div>
			<div class="form-button m-bottom-20">
				<button type="submit" name="log_in_account" class="btn b-primary c-white btn-block">Log in</button>
			</div>
		</form>
		<div class="text c-text text-center m-bottom-10">Forgot your password? <a href="<?php echo URL; ?>login/forgot" class="c-primary">Reset</a></div>
		<div class="text c-text text-center">Don't have an account? <a href="<?php echo URL; ?>signup" class="c-primary">Sign up</a></div>
	</div>
</div>