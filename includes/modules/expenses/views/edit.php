<div class="container-fluid content">

	<!-- Edit expense -->
	<div class="row">
		<div class="col-lg-6">
			<div class="section">
				<div class="text c-gray m-bottom-10">Edit expense</div>
				<div class="box b-white p-all-30">
          <h3 class="project-title c-title m-bottom-30">Edit expense</h3>
          <form action="<?php echo URL; ?>modules/executemoduleaction/expenses/editexpense/<?php echo $expense->id; ?>" method="post">
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Title</div>
              <input type="text" name="expense_title" placeholder="Enter the expense title" class="text c-text" value="<?php echo $expense->title; ?>">
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">Date</div>
                  <input type="text" name="expense_date" placeholder="Enter the expense date" class="text c-text" id="addExpenseDateDatepicker" value="<?php echo $expense->expense_date; ?>">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">Price (<?php echo CURRENCY; ?>)</div>
                  <input type="text" name="expense_price" placeholder="Enter the expense price" class="text c-text" value="<?php echo $expense->price; ?>">
                </div>
              </div>
            </div>
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Category</div>
              <select name="expense_category" class="text c-text">
                <option value="" disabled="disabled">Select the expense category</option>
                <option value="insurance" <?php echo ($expense->category == 'insurance' ? 'selected="selected"' : ''); ?>>Insurance</option>
                <option value="shopping" <?php echo ($expense->category == 'shopping' ? 'selected="selected"' : ''); ?>>Shopping</option>
                <option value="health" <?php echo ($expense->category == 'health' ? 'selected="selected"' : ''); ?>>Health</option>
                <option value="groceries" <?php echo ($expense->category == 'groceries' ? 'selected="selected"' : ''); ?>>Groceries</option>
                <option value="entertainment" <?php echo ($expense->category == 'entertainment' ? 'selected="selected"' : ''); ?>>Entertainment</option>
                <option value="transport" <?php echo ($expense->category == 'transport' ? 'selected="selected"' : ''); ?>>Transport</option>
                <option value="restaurants" <?php echo ($expense->category == 'restaurants' ? 'selected="selected"' : ''); ?>>Restaurants</option>
                <option value="general" <?php echo ($expense->category == 'general' ? 'selected="selected"' : ''); ?>>General</option>
                <option value="services" <?php echo ($expense->category == 'services' ? 'selected="selected"' : ''); ?>>Services</option>
                <option value="utilities" <?php echo ($expense->category == 'utilities' ? 'selected="selected"' : ''); ?>>Utilities</option>
                <option value="travel" <?php echo ($expense->category == 'travel' ? 'selected="selected"' : ''); ?>>Travel</option>
              </select>
            </div>
            <div class="form-button">
              <button type="submit" name="submit_edit_expense" class="btn b-secondary c-primary btn-block">Edit expense</button>
            </div>
          </form>
        </div>
			</div>
		</div>

		<div class="col-lg-6"></div>
	</div>

</div>