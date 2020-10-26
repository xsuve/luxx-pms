<div class="container-fluid content">

  <!-- Edit invoice -->
  <div class="row">
    <div class="col-lg-7">
      <div class="section">
        <div class="text c-gray m-bottom-10">Edit invoice</div>
        <div class="box b-white p-all-30">
          <h3 class="project-title c-title m-bottom-30">Edit invoice</h3>
          <form action="<?php echo URL; ?>invoices/editinvoice/<?php echo $invoice->id; ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="invoice_contact_id" <?php echo ($invoice->contact_id != null ? 'value="' . $invoice->contact_id . '"' : ''); ?>>
            <?php if(count($invoice_categories) > 0): ?>
              <div class="form-input-box">
                <div class="caption c-text m-bottom-5">Category (optional)</div>
                <select name="invoice_category_id" class="text c-text">
                  <option value="0" <?php echo ($invoice->category_id == 0 ? 'selected="selected"' : ''); ?>>Select the invoice category</option>
                    <?php foreach($invoice_categories as $invoice_category): ?>
                      <option value="<?php echo $invoice_category->id; ?>" <?php echo ($invoice->category_id == $invoice_category->id ? 'selected="selected"' : ''); ?>><?php echo $invoice_category->title; ?></option>
                    <?php endforeach; ?>
                </select>
              </div>
            <?php else: ?>
              <input type="hidden" name="invoice_category_id" value="0">
            <?php endif; ?>
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Invoice contact e-mail</div>
              <input type="email" name="invoice_contact_email" placeholder="Enter the invoice contact e-mail" class="text c-text" value="<?php echo $invoice->contact_email; ?>">
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">Invoice contact name</div>
                  <input type="text" name="invoice_contact_name" placeholder="Enter the invoice contact name" class="text c-text" value="<?php echo $invoice->contact_name; ?>">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">Invoice contact phone</div>
                  <input type="text" name="invoice_contact_phone" placeholder="Enter the invoice contact phone" class="text c-text" value="<?php echo $invoice->contact_phone; ?>">
                </div>
              </div>
            </div>
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Invoice contact address</div>
              <input type="text" name="invoice_contact_address" placeholder="Enter the invoice contact address" class="text c-text" value="<?php echo $invoice->contact_address; ?>">
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">Due date</div>
                  <input type="text" name="invoice_due_date" placeholder="Enter the invoice due date" class="text c-text" id="addInvoiceDueDateDatepicker" value="<?php echo $invoice->due_date; ?>">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">VAT (%)</div>
                  <input type="text" name="invoice_vat" placeholder="Enter the invoice VAT" class="text c-text" value="<?php echo $invoice->vat; ?>">
                </div>
              </div>
            </div>
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Status</div>
              <select name="invoice_paid" class="text c-text">
                <option value="" disabled="disabled">Select the invoice status</option>
                <option value="1" <?php echo ($invoice->paid == 1 ? 'selected="selected"' : ''); ?>>Paid</option>
                <option value="0" <?php echo ($invoice->paid == 0 ? 'selected="selected"' : ''); ?>>Unpaid</option>
              </select>
            </div>
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Invoice logo</div>
              <div class="row">
                <div class="col-lg-8">
                  <input type="file" name="invoice_logo" class="text c-text v-middle">
                </div>
                <div class="col-lg-4 text-center">
                  <div class="contact-image invoice-image v-middle">
                    <?php if(file_exists('public/application/invoices/' . $invoice->id . '.png')): ?>
                      <img src="<?php echo URL; ?>public/application/invoices/<?php echo $invoice->id; ?>.png">
                    <?php else: ?>
                      <img src="<?php echo URL; ?>public/img/luxx-logo.png">
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-button">
              <button type="submit" name="submit_edit_invoice" class="btn b-secondary c-primary btn-block">Edit invoice</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-5"></div>
  </div>

</div>