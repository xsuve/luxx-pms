<!-- Modules -->
<div class="container-fluid content">

	<!-- Modules -->
	<div class="section">
		<div class="text c-gray m-bottom-10">Modules</div>
		<div class="row">
			<?php if(count($modules) > 0): ?>
				<?php foreach($modules as $module): ?>

					<?php
						$module_name = basename($module);
						$this->loadModule($module_name);
					?>

				<?php endforeach; ?>
			<?php else: ?>
				<div class="col-lg-12">
					<div class="no-elements-img sections text-center">
						<img src="<?php echo URL; ?>public/img/graphic-3.svg">
					</div>
					<h3 class="c-title m-top-30 text-center">No modules!</h3>
					<div class="text c-gray text-center">You don't have any modules yet.</div>
				</div>
			<?php endif; ?>
		</div>
	</div>

</div>