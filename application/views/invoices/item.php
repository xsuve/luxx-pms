<div class="container-fluid content">

  <!-- Edit item -->
  <div class="row">
    <div class="col-lg-6">
      <div class="section">
        <div class="text c-gray m-bottom-10">Edit item</div>
        <div class="box b-white p-all-30">
          <h3 class="project-title c-title m-bottom-30">Edit item</h3>
          <form action="<?php echo URL; ?>invoices/edititem/<?php echo $item->id; ?>" method="post">
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Title</div>
              <input type="text" name="item_title" placeholder="Enter the task title" class="text c-text" value="<?php echo $item->title; ?>">
            </div>
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Quantity</div>
              <input type="text" name="item_quantity" placeholder="Enter the item quantity" class="text c-text" value="<?php echo $item->quantity; ?>">
            </div>
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Price (<?php echo CURRENCY; ?>)</div>
              <input type="text" name="item_price" placeholder="Enter the item price" class="text c-text" value="<?php echo $item->price; ?>">
            </div>
            <div class="form-button">
              <button type="submit" name="submit_edit_item" class="btn b-secondary c-primary btn-block">Edit item</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-6"></div>
  </div>

</div>