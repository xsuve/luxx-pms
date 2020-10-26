<?php

class Invoices extends Controller {

  public function index() {
    $account = $this->getSessionAccount();

    if($account != null) {
      $invoices_model = $this->loadModel('InvoicesModel');
      $invoices = $invoices_model->getAccountInvoices($account->id);
      $contacts_model = $this->loadModel('ContactsModel');

      $categories_model = $this->loadModel('CategoriesModel');
      $invoice_categories = $categories_model->getAccountCategories($account->id, 'invoice');

      require 'application/views/_templates/header.php';
      require 'application/views/_templates/topbar.php';
      require 'application/views/_templates/sidebar.php';
      require 'application/views/_templates/alerts.php';
      require 'application/views/invoices/index.php';
      require 'application/views/_templates/footer.php';
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // View
  public function view($id = null) {
    if(isset($id) && $id != null) {
      $account = $this->getSessionAccount();
      $admin = $this->getAdminAccount();

      if($account != NULL) {
        $invoices_model = $this->loadModel('InvoicesModel');
        $invoice = $invoices_model->getInvoiceData($id);

        if($invoice != false) {
          $invoice_items = $invoices_model->getInvoiceItems($id);
          $invoice_items_value = $invoices_model->getInvoiceItemsValue($id);

          $categories_model = $this->loadModel('CategoriesModel');
          $invoice_category = $categories_model->getCategoryData($invoice->category_id);

          $modules_model = $this->loadModel('ModulesModel');
          if($modules_model->moduleInstalled('saas')) {
            $saas_exceeded_items = false;
            $saas_exceeded_attachments = false;
            $module_model = $this->loadModuleModel('saas', 'SaasModel');
            $plans = $module_model->getPlans($admin->id, true);
            $account_plan = $module_model->getAccountPlan($account->id);
            if(count($invoice_items) >= $module_model->getSaasInclude($account->id, 'max_invoice_items')) {
              $saas_exceeded_items = true;
            }
          }

          require 'application/views/_templates/header.php';
          require 'application/views/_templates/topbar.php';
          require 'application/views/_templates/sidebar.php';
          require 'application/views/_templates/alerts.php';
          require 'application/views/invoices/view.php';
          require 'application/views/_templates/footer.php';
        } else {
          $_SESSION['alert'] = 'That invoice does not exist.';
          header('location: ' . URL . 'invoices');
        }
      } else {
        header('location: ' . URL . 'login');
      }
    } else {
      header('location: ' . URL . 'invoices');
    }
  }

  // View
  public function email($id = null) {
    if(isset($id) && $id != null) {
      $account = $this->getSessionAccount();
      $admin = $this->getAdminAccount();

      if($account != NULL) {
        require 'application/views/_templates/header.php';

        $invoices_model = $this->loadModel('InvoicesModel');
        $invoice = $invoices_model->getInvoiceData($id);
        if($invoice != false) {

          $modules_model = $this->loadModel('ModulesModel');
          if($modules_model->moduleInstalled('saas')) {
            $module_model = $this->loadModuleModel('saas', 'SaasModel');
            $plans = $module_model->getPlans($admin->id, true);
            $account_plan = $module_model->getAccountPlan($account->id);

            if($module_model->getSaasInclude($account->id, 'feature_email_invoice') != true) {
              $_SESSION['saas_title'] = 'Your plan does not have this feature included.';
              $_SESSION['saas_close_link'] = 'invoices/view/' . $invoice->id;
              $_SESSION['saas_from_link'] = 'invoices/view/' . $invoice->id;

              require 'includes/modules/saas/views/_templates/header.php';
              require 'includes/modules/saas/views/_templates/popbox.php';
            } else {
              $invoice_items = $invoices_model->getInvoiceItems($id);
              $invoice_items_value = $invoices_model->getInvoiceItemsValue($id);

              require 'application/views/_templates/topbar.php';
              require 'application/views/_templates/sidebar.php';
              require 'application/views/_templates/alerts.php';
              require 'application/views/invoices/email.php';
            }
          }
        } else {
          $_SESSION['alert'] = 'That invoice does not exist.';
          header('location: ' . URL . 'invoices');
        }

        require 'application/views/_templates/footer.php';
      } else {
        header('location: ' . URL . 'login');
      }
    } else {
      header('location: ' . URL . 'invoices');
    }
  }

  // Add
  public function add() {
    $account = $this->getSessionAccount();
    $admin = $this->getAdminAccount();

    if($account != null) {
      require 'application/views/_templates/header.php';

      $modules_model = $this->loadModel('ModulesModel');
      if($modules_model->moduleInstalled('saas')) {
        $module_model = $this->loadModuleModel('saas', 'SaasModel');
        $plans = $module_model->getPlans($admin->id, true);
        $account_plan = $module_model->getAccountPlan($account->id);

        $invoices_model = $this->loadModel('InvoicesModel');
        $invoices = $invoices_model->getAccountInvoices($account->id);

        if(count($invoices) >= $module_model->getSaasInclude($account->id, 'max_invoices')) {
          $_SESSION['saas_title'] = 'You have exceeded the number of maximum invoices.';
          $_SESSION['saas_close_link'] = 'invoices';
          $_SESSION['saas_from_link'] = 'invoices';

          require 'includes/modules/saas/views/_templates/header.php';
          require 'includes/modules/saas/views/_templates/popbox.php';
        } else {
          $categories_model = $this->loadModel('CategoriesModel');
          $invoice_categories = $categories_model->getAccountCategories($account->id, 'invoice');

          $contacts_model = $this->loadModel('ContactsModel');
          $contacts = $contacts_model->getAccountContacts($account->id);

          $projects_model = $this->loadModel('ProjectsModel');
          $projects = $projects_model->getAccountProjects($account->id);

          require 'application/views/_templates/topbar.php';
          require 'application/views/_templates/sidebar.php';
          require 'application/views/_templates/alerts.php';
          require 'application/views/invoices/add.php';
        }
      } else {
        $categories_model = $this->loadModel('CategoriesModel');
        $invoice_categories = $categories_model->getAccountCategories($account->id, 'invoice');

        $contacts_model = $this->loadModel('ContactsModel');
        $contacts = $contacts_model->getAccountContacts($account->id);

        $projects_model = $this->loadModel('ProjectsModel');
        $projects = $projects_model->getAccountProjects($account->id);

        require 'application/views/_templates/topbar.php';
        require 'application/views/_templates/sidebar.php';
        require 'application/views/_templates/alerts.php';
        require 'application/views/invoices/add.php';
      }

      require 'application/views/_templates/footer.php';
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Edit
  public function edit($id = null) {
    if(isset($id) && $id != null) {
      $account = $this->getSessionAccount();

      if($account != null) {
        $invoices_model = $this->loadModel('InvoicesModel');
        $invoice = $invoices_model->getInvoiceData($id);

        if($invoice != false) {
          $categories_model = $this->loadModel('CategoriesModel');
          $invoice_categories = $categories_model->getAccountCategories($account->id, 'invoice');

          require 'application/views/_templates/header.php';
          require 'application/views/_templates/topbar.php';
          require 'application/views/_templates/sidebar.php';
          require 'application/views/_templates/alerts.php';
          require 'application/views/invoices/edit.php';
          require 'application/views/_templates/footer.php';
        } else {
          $_SESSION['alert'] = 'That invoice does not exist.';
          header('location: ' . URL . 'invoices');
        }
      } else {
        header('location: ' . URL . 'login');
      }
    } else {
      header('location: ' . URL . 'invoices');
    }
  }

  // Add Invoice
  public function addInvoice() {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($_POST['submit_add_invoice'])) {
        $invoices_model = $this->loadModel('InvoicesModel');
        $add_invoice = $invoices_model->addInvoice($account->id, $_POST['invoice_contact_id'], $_POST['invoice_project_id'], $_POST['invoice_category_id'], $_POST['invoice_contact_email'], $_POST['invoice_contact_name'], $_POST['invoice_contact_address'], $_POST['invoice_contact_phone'], $_POST['invoice_due_date'], $_POST['invoice_vat'], $_FILES['invoice_logo']);
        if(isset($add_invoice) && $add_invoice != null) {
          $_SESSION['alert'] = $add_invoice;
          header('location: ' . URL . 'invoices/add');
        }

        header('location: ' . URL . 'invoices/add');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Item
  public function item($id = null) {
    if(isset($id) && $id != null) {
      $account = $this->getSessionAccount();

      if($account != NULL) {
        $invoices_model = $this->loadModel('InvoicesModel');
        $item = $invoices_model->getInvoiceItemData($id);

        if($item != false) {
          require 'application/views/_templates/header.php';
          require 'application/views/_templates/topbar.php';
          require 'application/views/_templates/sidebar.php';
          require 'application/views/_templates/alerts.php';
          require 'application/views/invoices/item.php';
          require 'application/views/_templates/footer.php';
        } else {
          $_SESSION['alert'] = 'That invoice item does not exist.';
          header('location: ' . URL . 'invoices');
        }
      } else {
        header('location: ' . URL . 'login');
      }
    } else {
      header('location: ' . URL . 'invoices');
    }
  }

  // Add Item
  public function addItem() {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($_POST['submit_add_item'])) {
        $invoices_model = $this->loadModel('InvoicesModel');

        $invoice_data = $invoices_model->getInvoiceData($_POST['invoice_id']);
        if($invoice_data->account_id == $account->id) {
          $add_item = $invoices_model->addItem($account->id, $_POST['invoice_id'], $_POST['item_title'], $_POST['item_quantity'], $_POST['item_price']);
          if(isset($add_item) && $add_item != null) {
            $_SESSION['alert'] = $add_item;
            header('location: ' . URL . 'invoices/view/' . $invoice_data->id);
          }

          header('location: ' . URL . 'invoices/view/' . $invoice_data->id);
        } else {
          $_SESSION['alert'] = 'You do not have permission to do this.';
          header('location: ' . URL . 'invoices');
        }
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Edit Item
  public function editItem($item_id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($_POST['submit_edit_item'])) {
        $invoices_model = $this->loadModel('InvoicesModel');
        $item = $invoices_model->getInvoiceItemData($item_id);

        if($item != false) {
          $edit_item = $invoices_model->editItem($item_id, $_POST['item_title'], $_POST['item_quantity'], $_POST['item_price']);
          if(isset($edit_item) && $edit_item != null) {
            $_SESSION['alert'] = $edit_item;
            header('location: ' . URL . 'invoices/item/' . $item_id);
          }

          header('location: ' . URL . 'invoices/item/' . $item_id);
        } else {
          $_SESSION['alert'] = 'That invoice item does not exist.';
          header('location: ' . URL . 'invoices');
        }
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Delete Item
  public function deleteItem($item_id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($item_id) && $item_id != null) {
        $invoices_model = $this->loadModel('InvoicesModel');
        $invoice_item_data = $invoices_model->getInvoiceItemData($item_id);

        if($invoice_item_data != false) {
          $invoice_data = $invoices_model->getInvoiceData($invoice_item_data->invoice_id);
          if($invoice_data->account_id == $account->id) {
            $delete_item = $invoices_model->deleteItem($account->id, $item_id);
            if(isset($delete_item) && $delete_item != null) {
              $_SESSION['alert'] = $delete_item;
              header('location: ' . URL . 'invoices');
            }

            header('location: ' . URL . 'invoices');
          } else {
            $_SESSION['alert'] = 'You do not have permission to do this.';
            header('location: ' . URL . 'invoices');
          }
        } else {
          $_SESSION['alert'] = 'That invoice item does not exist.';
          header('location: ' . URL . 'invoices');
        }
      } else {
        header('location: ' . URL . 'invoices');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Generate Invoice HTML
  public function generateInvoiceHTML($invoice_id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      $invoices_model = $this->loadModel('InvoicesModel');
      $invoice_data = $invoices_model->getInvoiceData($invoice_id);

      if($invoice_data != false) {
        if($invoice_data->account_id == $account->id) {
          $invoice_items = $invoices_model->getInvoiceItems($invoice_id);
          $invoice_items_value = $invoices_model->getInvoiceItemsValue($invoice_id);
          $total_quantity = 0;
          foreach($invoice_items as $invoice_item) {
            $total_quantity += $invoice_item->quantity;
          }

          $invoice_logo_image = '';
          if(file_exists('public/application/invoices/' . $invoice_data->id . '.png')) {
            $invoice_logo_image = URL . 'public/application/invoices/' . $invoice_data->id . '.png';
          } else {
            $invoice_logo_image = URL . 'public/img/luxx-logo.png';
          }

          $html = '
<style>
@page {
margin: 70px;
}
body {
font-family: montserrat;
}

/* Grid */
.row {
width: 100%;
}
.text-right {
text-align: right;
}
.text-left {
text-align: left;
}

/* Download Invoice */
.download-invoice-box {
position: relative;
background-color: #fff;
margin: 0px;
width: 100%;
}
.download-invoice-box-header {

}
.download-invoice-box-image {
  width: 64px;
  height: 64px;
  margin: 0px 0px 0px auto;
}
.download-invoice-box-image img {
  max-width: 100%;
  height: 100%;
}
.download-invoice-box-title {
color: #484848;
font-weight: bold;
letter-spacing: 1px;
font-size: 19px;
padding-top: 25px;
}
.download-invoice-box-subtitle {
color: #484848;
font-weight: bold;
letter-spacing: 0.2px;
font-size: 14px;
margin-bottom: 10px;
}
.download-invoice-box-text {
color: #989898;
font-weight: 600;
letter-spacing: 0.2px;
font-size: 12px;
}
.download-invoice-box-text div {
display: block;
}
.download-invoice-box-text div span {
color: #484848;
}
.download-invoice-box-items {
padding-bottom: 50px;
}
.download-invoice-box-items-header {

}
.download-invoice-box-line {
height: 1px;
background-color: #dfdfdf;
}
.download-invoice-box-items-title {
color: #989898;
font-weight: 600;
letter-spacing: 0.2px;
font-size: 10px;
}
.download-invoice-box-items-text {
color: #484848;
font-weight: 600;
letter-spacing: 0.2px;
font-size: 12px;
}
.download-invoice-box-item {

}
.download-invoice-box-footer {
padding-bottom: 70px;
}
.footer-text {
font-size: 21px;
}
.footer-total {
color: #54a0f7;
font-size: 22px;
font-weight: bold;
}
.download-invoice-box-item.footer-info {
margin-bottom: 0px;
}
</style>
<div class="download-invoice-box">
<div class="download-invoice-box-header">
    <div class="row">
        <columns column-count="2" />
            <div class="col-6">
                <div class="download-invoice-box-title">INVOICE #' . $invoice_data->id . '</div>
            </div>
        <newcolumn />
            <div class="col-6 text-right">
                <div class="download-invoice-box-image">
                  <img src="' . $invoice_logo_image . '">
                </div>
            </div>
        <columns column-count="1" />
    </div>
</div>
<div class="download-invoice-box-details">
    <div class="row">
        <columns column-count="2" />
            <div class="col-6 text-left">
                <div class="download-invoice-box-subtitle">' . $invoice_data->contact_name . '</div>
                <div class="download-invoice-box-text">
                    <div>E-mail: <span>' . $invoice_data->contact_email . '</span></div>
                    <div>Address: <span>' . $invoice_data->contact_address . '</span></div>
                    <div>Phone: <span>' . $invoice_data->contact_phone . '</span></div>
                </div>
            </div>
        <newcolumn />
            <div class="col-6">
                <div class="download-invoice-box-subtitle">' . INVOICE_NAME . '</div>
                <div class="download-invoice-box-text">
                    <div>E-mail: <span>' . INVOICE_EMAIL . '</span></div>
                    <div>Address: <span>' . INVOICE_ADDRESS . '</span></div>
                    <div>Phone: <span>' . INVOICE_PHONE . '</span></div>
                </div>
            </div>
        <columns column-count="1" />
    </div>
</div>
<div class="download-invoice-box-items">
    <div class="download-invoice-box-items-header">
        <div class="row">
            <columns column-count="3" />
                <div class="col-6 text-left">
                    <div class="download-invoice-box-items-title">DESCRIPTION</div>
                </div>
            <newcolumn />
                <div class="col-3 text-right">
                    <div class="download-invoice-box-items-title">QUANTITY</div>
                </div>
            <newcolumn />
                <div class="col-3 text-right">
                    <div class="download-invoice-box-items-title">PRICE</div>
                </div>
            <columns column-count="1" />
                <div class="col-12">
                    <div class="download-invoice-box-line"></div>
                </div>
            <columns column-count="1" />
        </div>
    </div>
    <div class="download-invoice-box-items-rows">
    ';
        if(count($invoice_items) > 0) {
            foreach($invoice_items as $invoice_item) {
                $html .= '
                <div class="download-invoice-box-item">
                    <div class="row">
                        <columns column-count="3" />
                            <div class="col-6 text-left">
                                <div class="download-invoice-box-items-text">' . $invoice_item->title . '</div>
                            </div>
                        <newcolumn />
                            <div class="col-3 text-right">
                                <div class="download-invoice-box-items-text">' . $invoice_item->quantity . '</div>
                            </div>
                        <newcolumn />
                            <div class="col-3 text-right">
                                <div class="download-invoice-box-items-text">' . CURRENCY_SYMBOL . $invoice_item->price . '</div>
                            </div>
                    </div>
                </div>
                ';
            }
        } else {
            $html .= '
            <div class="download-invoice-box-item">
                <div class="row">
                    <columns column-count="3" />
                        <div class="col-6 text-left">
                            <div class="download-invoice-box-items-text">-</div>
                        </div>
                    <newcolumn />
                        <div class="col-3 text-right">
                            <div class="download-invoice-box-items-text">-</div>
                        </div>
                    <newcolumn />
                        <div class="col-3 text-right">
                            <div class="download-invoice-box-items-text">-</div>
                        </div>
                </div>
            </div>
            ';
        }

        $html .= '
        <columns column-count="1" />
    </div>
</div>
<div class="download-invoice-box-footer">
    <div class="download-invoice-box-items-header">
        <div class="row">
            <columns column-count="4" />
                <div class="col-6 text-left">
                    <div class="download-invoice-box-items-title">BASIC INFORMATIONS</div>
                </div>
            <newcolumn />
                <div class="col-3 text-right">
                    <div class="download-invoice-box-items-title">QUANTITY</div>
                </div>
            <newcolumn />
                <div class="col-3 text-right">
                    <div class="download-invoice-box-items-title">VAT</div>
                </div>
            <newcolumn />
                <div class="col-3 text-right">
                    <div class="download-invoice-box-items-title">TOTAL</div>
                </div>
            <columns column-count="1" />
                <div class="col-12">
                    <div class="download-invoice-box-line footer-line"></div>
                </div>
            <columns column-count="1" />
        </div>
    </div>
    <div class="download-invoice-box-item footer-info">
        <div class="row">
            <columns column-count="4" />
                <div class="col-6 text-left">
                    <div class="download-invoice-box-text">
                        <div>Total items: <span>' . count($invoice_items) . '</span></div>
                        <div>Due date: <span>' . $invoice_data->due_date . '</span></div>
                    </div>
                </div>
            <newcolumn />
                <div class="col-3 text-right">
                    <div class="download-invoice-box-items-text">' . $total_quantity . '</div>
                </div>
            <newcolumn />
                <div class="col-3 text-right">
                    <div class="download-invoice-box-items-text">' . $invoice_data->vat . '%</div>
                </div>
            <newcolumn />
                <div class="col-3 text-right">
                    <div class="download-invoice-box-items-text footer-text footer-total">' . CURRENCY_SYMBOL . ($invoice_items_value > 0 ? ((($invoice_data->vat * $invoice_items_value) / 100) + $invoice_items_value) : 0) . '</div>
                </div>
            <columns column-count="1" />
        </div>
    </div>
</div>
</div>
          ';

          return $html;
        } else {
          $_SESSION['alert'] = 'You do not have permission to do this.';
          header('location: ' . URL . 'invoices');
        }
      } else {
        $_SESSION['alert'] = 'That invoice does not exist.';
        header('location: ' . URL . 'invoices');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Preview Invoice
  public function previewInvoice($invoice_id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      $invoices_model = $this->loadModel('InvoicesModel');
      $invoice_data = $invoices_model->getInvoiceData($invoice_id);

      if($invoice_data != false) {
        if($invoice_data->account_id == $account->id) {
          ob_end_clean();
          ob_start();
          include('public/libs/mpdf/mpdf.php');

          $html = $this->generateInvoiceHTML($invoice_id);

          $mpdf = new \Mpdf\Mpdf();
          $mpdf->WriteHTML($html);
          $mpdf->SetTitle('Invoice_No.' . $invoice_data->id . '_' . str_replace(' ', '-', $invoice_data->contact_name));
          $mpdf->Output('Invoice_No.' . $invoice_data->id . '_' . str_replace(' ', '-', $invoice_data->contact_name) . '.pdf', \Mpdf\Output\Destination::INLINE);
          ob_end_flush();
        } else {
          $_SESSION['alert'] = 'You do not have permission to do this.';
          header('location: ' . URL . 'invoices');
        }
      } else {
        $_SESSION['alert'] = 'That invoice does not exist.';
        header('location: ' . URL . 'invoices');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // String Invoice
  public function stringInvoice($invoice_id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      $invoices_model = $this->loadModel('InvoicesModel');
      $invoice_data = $invoices_model->getInvoiceData($invoice_id);

      if($invoice_data != false) {
        if($invoice_data->account_id == $account->id) {
          include('public/libs/mpdf/mpdf.php');

          $html = $this->generateInvoiceHTML($invoice_id);

          $mpdf = new \Mpdf\Mpdf();
          $mpdf->WriteHTML($html);
          $mpdf->SetTitle('Invoice_No.' . $invoice_data->id . '_' . str_replace(' ', '-', $invoice_data->contact_name));
          return $mpdf->Output('Invoice_No.' . $invoice_data->id . '_' . str_replace(' ', '-', $invoice_data->contact_name) . '.pdf', 'S');
        } else {
          $_SESSION['alert'] = 'You do not have permission to do this.';
          header('location: ' . URL . 'invoices');
        }
      } else {
        $_SESSION['alert'] = 'That invoice does not exist.';
        header('location: ' . URL . 'invoices');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Download Invoice
  public function downloadInvoice($invoice_id) {
    $account = $this->getSessionAccount();
    $admin = $this->getAdminAccount();

    if($account != null) {
      if(isset($invoice_id) && $invoice_id != null) {
        $invoices_model = $this->loadModel('InvoicesModel');
        $invoice_data = $invoices_model->getInvoiceData($invoice_id);
        if($invoice_data != false) {
          if($invoice_data->account_id == $account->id) {

            $modules_model = $this->loadModel('ModulesModel');
            if($modules_model->moduleInstalled('saas')) {
              $module_model = $this->loadModuleModel('saas', 'SaasModel');
              $plans = $module_model->getPlans($admin->id, true);
              $account_plan = $module_model->getAccountPlan($account->id);

              if($module_model->getSaasInclude($account->id, 'feature_download_pdf') != true) {
                $_SESSION['saas_title'] = 'Your plan does not have this feature included.';
                $_SESSION['saas_close_link'] = 'invoices/view/' . $invoice_data->id;

                require 'application/views/_templates/header.php';
                require 'includes/modules/saas/views/_templates/header.php';
                require 'includes/modules/saas/views/_templates/popbox.php';
              } else {
                ob_end_clean();
                ob_start();
                include('public/libs/mpdf/mpdf.php');

                $html = $this->generateInvoiceHTML($invoice_id);

                $mpdf = new \Mpdf\Mpdf();
                $mpdf->WriteHTML($html);
                $mpdf->SetTitle('Invoice_No.' . $invoice_data->id . '_' . str_replace(' ', '-', $invoice_data->contact_name));
                $mpdf->Output('Invoice_No.' . $invoice_data->id . '_' . str_replace(' ', '-', $invoice_data->contact_name) . '.pdf', \Mpdf\Output\Destination::DOWNLOAD);
                ob_end_flush();
              }
            }

          } else {
            $_SESSION['alert'] = 'You do not have permission to do this.';
            header('location: ' . URL . 'invoices');
          }
        } else {
          $_SESSION['alert'] = 'That invoice does not exist.';
          header('location: ' . URL . 'invoices');
        }
      } else {
        header('location: ' . URL . 'invoices');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // E-mail Invoice
  public function emailInvoice($invoice_id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($invoice_id) && $invoice_id != null) {
        if(isset($_POST['submit_email_invoice'])) {
          $invoices_model = $this->loadModel('InvoicesModel');
          $email_invoice = $invoices_model->emailInvoice($invoice_id, $_POST['subject'], $_POST['email'], $_POST['message']);
          if(isset($email_invoice) && $email_invoice != null) {
            $_SESSION['alert'] = $email_invoice;
            header('location: ' . URL . 'invoices/email/' . $invoice_id);
          }

          header('location: ' . URL . 'invoices/email/' . $invoice_id);
        }
      } else {
        header('location: ' . URL . 'invoices');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Edit Invoice
  public function editInvoice($invoice_id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($_POST['submit_edit_invoice'])) {
        if(isset($invoice_id) && $invoice_id != null) {
          $invoices_model = $this->loadModel('InvoicesModel');
          $invoice_data = $invoices_model->getInvoiceData($invoice_id);

          if($invoice_data != false) {
            if($invoice_data->account_id == $account->id) {
              $edit_invoice = $invoices_model->editInvoice($invoice_id, $_POST['invoice_contact_id'], $_POST['invoice_category_id'], $_POST['invoice_contact_name'], $_POST['invoice_contact_email'], $_POST['invoice_contact_address'], $_POST['invoice_contact_phone'], $_POST['invoice_due_date'], $_POST['invoice_vat'], $_POST['invoice_paid'], $_FILES['invoice_logo']);
              if(isset($edit_invoice) && $edit_invoice != null) {
                $_SESSION['alert'] = $edit_invoice;
                header('location: ' . URL . 'invoices/edit/' . $invoice_id);
              }

              header('location: ' . URL . 'invoices/edit/' . $invoice_id);
            } else {
              $_SESSION['alert'] = 'You do not have permission to do this.';
              header('location: ' . URL . 'invoices');
            }
          } else {
            $_SESSION['alert'] = 'That invoice does not exist.';
            header('location: ' . URL . 'invoices');
          }
        } else {
          header('location: ' . URL . 'invoices');
        }
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Pay Invoice
  public function payInvoice($invoice_id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($invoice_id) && $invoice_id != null) {
        $invoices_model = $this->loadModel('InvoicesModel');
        $invoice_data = $invoices_model->getInvoiceData($invoice_id);

        if($invoice_data != false) {
          if($invoice_data->account_id == $account->id) {
            $pay_invoice = $invoices_model->payInvoice($account->id, $invoice_id);
            if(isset($pay_invoice) && $pay_invoice != null) {
              $_SESSION['alert'] = $pay_invoice;
              header('location: ' . URL . 'invoices/view/' . $invoice_id);
            }

            header('location: ' . URL . 'invoices/view/' . $invoice_id);
          } else {
            $_SESSION['alert'] = 'You do not have permission to do this.';
            header('location: ' . URL . 'invoices');
          }
        } else {
          $_SESSION['alert'] = 'That invoice does not exist.';
          header('location: ' . URL . 'invoices');
        }
      } else {
        header('location: ' . URL . 'invoices');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Delete Invoice
  public function deleteInvoice($invoice_id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($invoice_id) && $invoice_id != null) {
        $invoices_model = $this->loadModel('InvoicesModel');
        $invoice_data = $invoices_model->getInvoiceData($invoice_id);

        if($invoice_data != false) {
          if($invoice_data->account_id == $account->id) {
            $delete_invoice = $invoices_model->deleteInvoice($invoice_id);
            if(isset($delete_invoice) && $delete_invoice != null) {
              $_SESSION['alert'] = $delete_invoice;
              header('location: ' . URL . 'invoices');
            }

            header('location: ' . URL . 'invoices');
          } else {
            $_SESSION['alert'] = 'You do not have permission to do this.';
            header('location: ' . URL . 'invoices');
          }
        } else {
          $_SESSION['alert'] = 'That invoice does not exist.';
          header('location: ' . URL . 'invoices');
        }
      } else {
        header('location: ' . URL . 'invoices');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

}

?>
