<?php if(isset($_SESSION['payment_title']) && $_SESSION['payment_title'] != ''): ?>
	<div class="pop-box text-center">
		<div class="box b-white p-all-50 v-middle text-center d-inline-block">
			<div class="pop-box-logo payment-logo">
				<img src="<?php echo URL; ?>public/img/luxx-logo.svg">
			</div>
			<h1 class="c-title m-top-50 m-bottom-15"><?php echo $_SESSION['payment_title']; ?></h1>
			<div class="text c-text m-bottom-30"><?php echo $_SESSION['payment_description']; ?></div>
			<div class="text c-gray">Payment ID: <span class="caption c-title"><?php echo $payment_id; ?></span></div>
			<div class="text c-gray m-top-5 m-bottom-5">Payment Token: <span class="caption c-title"><?php echo $payment_token; ?></span></div>
			<div class="text c-gray">Payer ID: <span class="caption c-title"><?php echo $payer_id; ?></span></div>
			<div class="text c-text m-top-30 m-bottom-30">Click the button below to return to the platform.</div>
			<a href="<?php echo URL; ?>dashboard"><button class="btn b-primary c-white">Return to platform</button></a>
		</div>
	</div>
	<script type="text/javascript">
		$('html').addClass('no-scroll');
	</script>
	<?php
		$_SESSION['payment_title'] = '';
		$_SESSION['payment_description'] = '';
	?>
<?php endif; ?>