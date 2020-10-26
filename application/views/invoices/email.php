<div class="container-fluid content">

  <!-- E-mail invoice -->
  <div class="row">
    <div class="col-lg-6">
      <div class="section">
        <div class="text c-gray m-bottom-10">E-mail invoice</div>
        <div class="box b-white p-all-30">
          <h3 class="project-title c-title m-bottom-30">E-mail invoice</h3>
          <form action="<?php echo URL; ?>invoices/emailinvoice/<?php echo $invoice->id; ?>" method="post">
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Subject</div>
              <input type="text" name="subject" placeholder="Enter the e-mail subject" class="text c-text" value="Invoice for <?php echo $invoice->contact_name; ?>">
            </div>
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">E-mail</div>
              <input type="email" name="email" placeholder="Enter the contact e-mail address" class="text c-text" value="<?php echo $invoice->contact_email; ?>">
            </div>
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Message</div>
              <textarea type="text" name="message" placeholder="Enter the e-mail message" class="text c-text" style="min-height: 100px;">
Thanks for using our services.
You have the invoice attached below.
            </textarea>
            </div>
            <div class="form-button">
              <button type="submit" name="submit_email_invoice" class="btn b-secondary c-primary btn-block">E-mail invoice</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="section">
        <div class="text c-gray m-bottom-10">Invoice preview</div>
        <div class="box b-white p-all-30">
          <iframe src="<?php echo URL; ?>invoices/previewinvoice/<?php echo $invoice->id; ?>" class="email-invoice-preview" frameborder="0"></iframe>
        </div>
      </div>
    </div>
  </div>

</div>