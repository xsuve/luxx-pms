<div class="container-fluid content">

	<!-- Edit category -->
	<div class="row">
		<div class="col-lg-6">
			<div class="section">
				<div class="text c-gray m-bottom-10">Edit category</div>
				<div class="box b-white p-all-30">
					<h3 class="project-title c-title m-bottom-30">Edit category</h3>
					<form action="<?php echo URL; ?>categories/editcategory/<?php echo $category->id; ?>" method="post">
						<div class="form-input-box">
							<div class="caption c-text m-bottom-5">Title</div>
							<input type="text" name="category_title" placeholder="Enter the category title" class="text c-text" value="<?php echo $category->title; ?>">
						</div>
						<div class="form-input-box">
							<div class="caption c-text m-bottom-5">Type</div>
							<select name="category_type" class="text c-text">
								<option value="" disabled="disabled">Select the category type</option>
								<option value="contact" <?php echo ($category->type == 'contact' ? 'selected="selected"' : ''); ?>>Contact</option>
								<option value="project" <?php echo ($category->type == 'project' ? 'selected="selected"' : ''); ?>>Project</option>
								<option value="task" <?php echo ($category->type == 'task' ? 'selected="selected"' : ''); ?>>Task</option>
								<option value="invoice" <?php echo ($category->type == 'invoice' ? 'selected="selected"' : ''); ?>>Invoice</option>
							</select>
						</div>
						<div class="caption c-text m-bottom-10">Color</div>
						<div class="add-category-colors m-bottom-30">
							<div class="b-red-secondary m-right-15">
								<input type="radio" name="category_color" value="red" <?php echo ($category->color == 'red' ? 'checked="checked"' : ''); ?>>
								<span class="b-red v-middle"></span>
							</div>
							<div class="b-orange-secondary m-right-15">
								<input type="radio" name="category_color" value="orange" <?php echo ($category->color == 'orange' ? 'checked="checked"' : ''); ?>>
								<span class="b-orange v-middle"></span>
							</div>
							<div class="b-yellow-secondary m-right-15">
								<input type="radio" name="category_color" value="yellow" <?php echo ($category->color == 'yellow' ? 'checked="checked"' : ''); ?>>
								<span class="b-yellow v-middle"></span>
							</div>
							<div class="b-green-secondary m-right-15">
								<input type="radio" name="category_color" value="green" <?php echo ($category->color == 'green' ? 'checked="checked"' : ''); ?>>
								<span class="b-green v-middle"></span>
							</div>
							<div class="b-blue-secondary m-right-15">
								<input type="radio" name="category_color" value="blue" <?php echo ($category->color == 'blue' ? 'checked="checked"' : ''); ?>>
								<span class="b-blue v-middle"></span>
							</div>
							<div class="b-purple-secondary m-right-15">
								<input type="radio" name="category_color" value="purple" <?php echo ($category->color == 'purple' ? 'checked="checked"' : ''); ?>>
								<span class="b-purple v-middle"></span>
							</div>
							<div class="b-gray-secondary">
								<input type="radio" name="category_color" value="gray" <?php echo ($category->color == 'gray' ? 'checked="checked"' : ''); ?>>
								<span class="b-gray v-middle"></span>
							</div>
						</div>
						<div class="form-button">
							<button type="submit" name="submit_edit_category" class="btn b-secondary c-primary btn-block">Edit category</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="col-lg-6"></div>
	</div>

</div>