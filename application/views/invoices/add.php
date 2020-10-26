<div class="container-fluid content">

  <!-- Add project invoice -->
  <div class="row">
    <div class="col-lg-7">
      <div class="section">
        <div class="text c-gray m-bottom-10">New invoice</div>
        <div class="box b-white p-all-30">
          <h3 class="project-title c-title m-bottom-30">Add new invoice</h3>
          <form action="<?php echo URL; ?>invoices/addinvoice" method="post" enctype="multipart/form-data">
            <?php if(count($invoice_categories) > 0): ?>
              <div class="form-input-box">
                <div class="caption c-text m-bottom-5">Category (optional)</div>
                <select name="invoice_category_id" class="text c-text">
                  <option value="0" selected="selected">Select the invoice category</option>
                    <?php foreach($invoice_categories as $invoice_category): ?>
                      <option value="<?php echo $invoice_category->id; ?>"><?php echo $invoice_category->title; ?></option>
                    <?php endforeach; ?>
                </select>
              </div>
            <?php else: ?>
              <input type="hidden" name="invoice_category_id" value="0">
            <?php endif; ?>
            <div class="row">
              <div class="col-lg-6">
                <?php if(count($contacts) > 0): ?>
                  <div class="form-input-box">
                    <div class="caption c-text m-bottom-5">Contact (optional)</div>
                    <select name="invoice_contact_id" class="text c-text" id="addInvoiceContactSelect">
                      <option value="0" selected="selected">Select the invoice contact</option>
                        <?php foreach($contacts as $contact): ?>
                          <option value="<?php echo $contact->id; ?>" data-contact-email="<?php echo $contact->email; ?>" data-contact-name="<?php echo $contact->name; ?>" data-contact-phone="<?php echo $contact->phone_number; ?>" data-contact-address="<?php echo $contact->address; ?>"><?php echo $contact->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                  </div>
                <?php else: ?>
                  <input type="hidden" name="invoice_contact_id" value="0">
                <?php endif; ?>
              </div>
              <div class="col-lg-6">
                <?php if(count($projects) > 0): ?>
                  <div class="form-input-box">
                    <div class="caption c-text m-bottom-5">Project (optional)</div>
                    <select name="invoice_project_id" class="text c-text">
                      <option value="0" selected="selected">Select the invoice project</option>
                        <?php foreach($projects as $project): ?>
                          <option value="<?php echo $project->id; ?>"><?php echo $project->title; ?></option>
                        <?php endforeach; ?>
                    </select>
                  </div>
                <?php else: ?>
                  <input type="hidden" name="invoice_project_id" value="0">
                <?php endif; ?>
              </div>
            </div>
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Invoice contact e-mail</div>
              <input type="email" name="invoice_contact_email" placeholder="Enter the invoice contact e-mail" class="text c-text" id="addInvoiceContactEmailInput">
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">Invoice contact name</div>
                  <input type="text" name="invoice_contact_name" placeholder="Enter the invoice contact name" class="text c-text" id="addInvoiceContactNameInput">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">Invoice contact phone</div>
                  <input type="text" name="invoice_contact_phone" placeholder="Enter the invoice contact phone" class="text c-text" id="addInvoiceContactPhoneInput">
                </div>
              </div>
            </div>
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Invoice contact address</div>
              <input type="text" name="invoice_contact_address" placeholder="Enter the invoice contact address" class="text c-text" id="addInvoiceContactAddressInput">
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">Due date</div>
                  <input type="text" name="invoice_due_date" placeholder="Enter the invoice due date" class="text c-text" id="addInvoiceDueDateDatepicker">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">VAT (%) (optional)</div>
                  <input type="text" name="invoice_vat" placeholder="Enter the invoice VAT" class="text c-text">
                </div>
              </div>
            </div>
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Invoice logo  (optional)</div>
              <input type="file" name="invoice_logo" class="text c-text">
            </div>
            <div class="form-button">
              <button type="submit" name="submit_add_invoice" class="btn b-secondary c-primary btn-block">Add invoice</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-5"></div>
  </div>

</div>