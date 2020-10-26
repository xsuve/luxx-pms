<!-- Categories -->
<div class="container-fluid content">

	<!-- Categories -->
	<div class="row">
		<div class="col-lg-7">
			<div class="section">
				<div class="text c-gray m-bottom-10">Categories</div>
				<div class="box b-white p-all-30">
					<?php $i = 0; ?>
					<?php if(count($categories) > 0): ?>
						<?php foreach($categories as $category): ?>
							<div class="list-element p-bottom-15 p-top-15 <?php echo ($i == 0 ? 'first' : ''); ?> <?php echo ($i == (count($categories) - 1) ? 'last' : ''); ?>">
								<div class="row">
									<div class="col-lg-6 text-left">
										<div class="project-task-title caption"><?php echo $category->title; ?></div>
									</div>
									<div class="col-lg-2 text-left">
										<div class="project-task-title caption c-gray"><?php echo $category->type; ?></div>
									</div>
									<div class="col-lg-2 text-right">
										<div class="category-dot b-<?php echo $category->color; ?>-secondary">
											<div class="b-<?php echo $category->color; ?> v-middle"></div>
										</div>
									</div>
									<div class="col-lg-2 text-right">
										<div class="project-task-info">
											<button class="more-btn p-right-0 caption c-gray" onclick="event.stopPropagation(); this.childNodes[2].style.display = 'block';"><i class="fe fe-elipsis-h"></i>
												<div class="more-dropdown box b-white p-all-10 v-middle caption text-right">
													<a href="<?php echo URL; ?>categories/edit/<?php echo $category->id; ?>">
														<div class="m-right-5 b-secondary c-primary text-center">
															<i class="fe fe-edit v-middle"></i>
														</div>
													</a>
													<a href="<?php echo URL; ?>categories/deletecategory/<?php echo $category->id; ?>">
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
							<img src="<?php echo URL; ?>public/img/graphic-1.svg">
						</div>
						<h3 class="c-title m-top-30 text-center">No categories!</h3>
						<div class="text c-gray text-center">You don't have any categories yet.</div>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<div class="col-lg-5">
			<div class="section">
				<div class="text c-gray m-bottom-10">New category</div>
				<div class="box b-white p-all-30">
					<h3 class="project-title c-title m-bottom-30">Add new category</h3>
					<?php if($modules_model->moduleSaas($account->id) && $saas_exceeded == true): ?>
						<div class="text c-gray m-bottom-30">You have exceeded the number of maximum categories.
						<br><br>
						Please consider upgrading your plan to get more features and extend the current plan features.</div>
						<button class="btn b-secondary c-primary">Upgrade plan</button>
					<?php else: ?>
						<form action="<?php echo URL; ?>categories/addcategory" method="post">
							<div class="form-input-box">
								<div class="caption c-text m-bottom-5">Title</div>
								<input type="text" name="category_title" placeholder="Enter the category title" class="text c-text">
							</div>
							<div class="form-input-box">
								<div class="caption c-text m-bottom-5">Type</div>
								<select name="category_type" class="text c-text">
									<option value="" selected="selected" disabled="disabled">Select the category type</option>
									<option value="contact">Contact</option>
									<option value="project">Project</option>
									<option value="task">Task</option>
									<option value="invoice">Invoice</option>
								</select>
							</div>
							<div class="caption c-text m-bottom-10">Color</div>
							<div class="add-category-colors m-bottom-30">
								<div class="b-red-secondary m-right-15">
									<input type="radio" name="category_color" value="red" checked="checked">
									<span class="b-red v-middle"></span>
								</div>
								<div class="b-orange-secondary m-right-15">
									<input type="radio" name="category_color" value="orange">
									<span class="b-orange v-middle"></span>
								</div>
								<div class="b-yellow-secondary m-right-15">
									<input type="radio" name="category_color" value="yellow">
									<span class="b-yellow v-middle"></span>
								</div>
								<div class="b-green-secondary m-right-15">
									<input type="radio" name="category_color" value="green">
									<span class="b-green v-middle"></span>
								</div>
								<div class="b-blue-secondary m-right-15">
									<input type="radio" name="category_color" value="blue">
									<span class="b-blue v-middle"></span>
								</div>
								<div class="b-purple-secondary m-right-15">
									<input type="radio" name="category_color" value="purple">
									<span class="b-purple v-middle"></span>
								</div>
								<div class="b-gray-secondary">
									<input type="radio" name="category_color" value="gray">
									<span class="b-gray v-middle"></span>
								</div>
							</div>
							<div class="form-button">
								<button type="submit" name="submit_add_category" class="btn b-secondary c-primary btn-block">Add category</button>
							</div>
						</form>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

</div>