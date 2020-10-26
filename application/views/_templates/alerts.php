<?php if(isset($_SESSION['alert']) && $_SESSION['alert'] != ''): ?>
	<div class="alert-box box b-white p-all-20">
		<div class="alert-box-icon icon-circle b-secondary c-primary text-center">
			<i class="fe fe-warning v-middle"></i>
		</div>
		<div class="alert-box-text caption c-title m-left-10">
			<span><?php echo $_SESSION['alert']; ?></span>
		</div>
	</div>
	<script type="text/javascript">
		function showAlert() {
			$('.alert-box').animate({
				'opacity': 1,
				'right': '20px'
			}, 350);
			setTimeout(hideAlert, 4500);
		}
		function hideAlert() {
			$('.alert-box').animate({
				'opacity': 0,
				'right': '-500px'
			}, 350);
		}
		showAlert();
	</script>
	<?php $_SESSION['alert'] = ''; ?>
<?php endif; ?>