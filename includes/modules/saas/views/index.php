<!-- Saas Module -->
<div class="container-fluid content">

  <!-- Plans -->
  <div class="row">
    <div class="col-lg-7">
      <div class="section">
        <div class="text c-gray m-bottom-10">Plans</div>
        <div class="box b-white p-all-30">
          <?php $i = 0; ?>
          <?php if(count($plans) > 0): ?>
            <?php foreach($plans as $plan): ?>
              <div class="list-element p-bottom-15 p-top-15 <?php echo ($i == 0 ? 'first' : ''); ?> <?php echo ($i == (count($plans) - 1) ? 'last' : ''); ?>">
                <div class="row">
                  <div class="col-lg-2 p-right-0">
                    <div class="icon-circle b-<?php echo ($plan->admin_only == 1 ? 'red-secondary' : 'secondary'); ?> c-<?php echo ($plan->admin_only == 1 ? 'red' : 'primary'); ?> text-center v-middle">
                      <div class="v-middle caption"><?php echo strtoupper(substr($plan->title, 0, 1)); ?></div>
                    </div>
                  </div>
                  <div class="col-lg-4 text-left p-left-0">
                    <div class="list-element-title caption v-middle"><?php echo $plan->title; ?></div>
                  </div>
                  <div class="col-lg-4 text-right">
                    <div class="list-element-title text c-gray v-middle"><?php echo CURRENCY_SYMBOL . $plan->monthly_price; ?> / month</div>
                  </div>
                  <div class="col-lg-2 text-right">
                    <div class="list-element-title v-middle">
                      <button class="more-btn p-right-0 caption c-gray" onclick="event.stopPropagation(); this.childNodes[2].style.display = 'block';"><i class="fe fe-elipsis-h"></i>
                        <div class="more-dropdown module-dropdown box b-white p-top-10 p-left-10 p-bottom-10 v-middle caption text-right">
                          <a href="<?php echo URL; ?>modules/edit/saas/<?php echo $plan->id; ?>">
                            <div class="m-right-5 b-secondary c-primary text-center">
                              <i class="fe fe-edit v-middle"></i>
                            </div>
                          </a>
                          <a href="<?php echo URL; ?>modules/executemoduleaction/saas/deleteplan/<?php echo $plan->id; ?>">
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
              <img src="<?php echo URL; ?>public/img/graphic-2.svg">
            </div>
            <h3 class="c-title m-top-30 text-center">No plans!</h3>
            <div class="text c-gray text-center">You don't have any plans yet.</div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="section m-top-30">
        <div class="box module-widget-btn-box b-white p-top-20 p-right-30 p-bottom-20 p-left-30 m-bottom-15">
          <div class="row">
            <div class="col-lg-2">
              <div class="icon-circle b-secondary c-primary v-middle text-center">
                <i class="fe fe-star v-middle"></i>
              </div>
            </div>
            <div class="col-lg-7">
              <div class="caption c-title v-middle">This <?php echo ($pinned_status->pinned == 1 ? 'is' : 'is not'); ?> a pinned module.</div>
            </div>
            <div class="col-lg-3 text-right">
              <div class="v-middle">
                <a href="<?php echo URL; ?>modules/<?php echo ($pinned_status->pinned == 1 ? 'unpinmodule' : 'pinmodule'); ?>/saas">
                  <div class="module-widget-btn b-gray-secondary">
                    <div class="module-widget-btn-circle <?php echo ($pinned_status->pinned == 1 ? 'on' : 'off'); ?> v-middle"></div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>

        <!--
        <div class="box module-widget-btn-box b-white p-top-20 p-right-30 p-bottom-20 p-left-30">
          <div class="row">
            <div class="col-lg-2">
              <div class="icon-circle b-secondary c-primary v-middle text-center">
                <i class="fe fe-tiled v-middle"></i>
              </div>
            </div>
            <div class="col-lg-7">
              <div class="caption c-title v-middle">The widget is turned <?php echo ($widget_status->display_widget == 1 ? 'on' : 'off'); ?>.</div>
            </div>
            <div class="col-lg-3 text-right">
              <div class="v-middle">
                <a href="<?php echo URL; ?>modules/<?php echo ($widget_status->display_widget == 1 ? 'hidewidget' : 'displaywidget'); ?>/saas">
                  <div class="module-widget-btn b-gray-secondary">
                    <div class="module-widget-btn-circle <?php echo ($widget_status->display_widget == 1 ? 'on' : 'off'); ?> v-middle"></div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
        -->

        <div class="d-block m-top-30">
          <a href="<?php echo URL; ?>modules/deletemodule/saas">
            <button class="btn b-red-secondary c-red btn-block">Delete module</button>
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="line-divider"></div>

  <!-- Add new -->
  <div class="section">
    <div class="text c-gray m-bottom-10">New plan</div>
    <div class="box b-white p-all-30">
      <h3 class="project-title c-title">Add new plan</h3>
      <div class="text c-gray m-bottom-30">Note: Use '999' for unlimited.</div>
      <form action="<?php echo URL; ?>modules/executemoduleaction/saas/addplan" method="post">
        <div class="row">
          <div class="col-lg-6">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">Title</div>
                  <input type="text" name="plan_title" placeholder="Enter the plan title" class="text c-text">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">Monthly price (<?php echo CURRENCY; ?>)</div>
                  <input type="text" name="monthly_price" placeholder="Enter the monthly price" class="text c-text">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">Max. contacts</div>
                  <input type="text" name="max_contacts" placeholder="Enter the max contacts" class="text c-text">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">Max. projects</div>
                  <input type="text" name="max_projects" placeholder="Enter the max projects" class="text c-text">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">Max. invoices</div>
                  <input type="text" name="max_invoices" placeholder="Enter the max invoices" class="text c-text">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">Max. categories</div>
                  <input type="text" name="max_categories" placeholder="Enter the max invoices" class="text c-text">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">Max. tasks / project</div>
                  <input type="text" name="max_project_tasks" placeholder="Enter the max tasks" class="text c-text">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">Max. workers / project</div>
                  <input type="text" name="max_project_workers" placeholder="Enter the max workers" class="text c-text">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-input-box last">
                  <div class="caption c-text m-bottom-5">Max. attachments / project</div>
                  <input type="text" name="max_project_attachments" placeholder="Enter the max attachments" class="text c-text">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-input-box last">
                  <div class="caption c-text m-bottom-5">Max. items / invoice</div>
                  <input type="text" name="max_invoice_items" placeholder="Enter the max items" class="text c-text">
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="caption c-gray m-bottom-15">Plan extra features</div>
            <div class="m-bottom-15">
              <div class="form-checkbox d-inline-block m-right-10">
                <input type="checkbox" name="feature_kanban_board" id="addPlanKanbanBoardCheckbox">
                <span class="b-gray-secondary v-middle text-center">
                  <i class="fe fe-check v-middle c-white"></i>
                </span>
              </div>
              <div class="caption c-text d-inline-block">Projects Kanban board</div>
            </div>
            <div class="m-bottom-15">
              <div class="form-checkbox d-inline-block m-right-10">
                <input type="checkbox" name="feature_email_invoice" id="addPlanEmailInvoiceCheckbox">
                <span class="b-gray-secondary v-middle text-center">
                  <i class="fe fe-check v-middle c-white"></i>
                </span>
              </div>
              <div class="caption c-text d-inline-block">Send invoice to e-mail</div>
            </div>
            <div class="m-bottom-50">
              <div class="form-checkbox d-inline-block m-right-10">
                <input type="checkbox" name="feature_download_pdf" id="addPlanDownloadPDFCheckbox">
                <span class="b-gray-secondary v-middle text-center">
                  <i class="fe fe-check v-middle c-white"></i>
                </span>
              </div>
              <div class="caption c-text d-inline-block">Download invoice PDF</div>
            </div>

            <!-- <div class="caption c-gray m-bottom-15">Plan modules</div>
            <?php foreach($modules as $module): ?>
              <div class="m-bottom-15">
                <div class="form-checkbox d-inline-block m-right-10">
                  <input type="checkbox" name="kanban_board" id="addPlanKanbanBoard">
                  <span class="b-gray-secondary v-middle text-center">
                    <i class="fe fe-check v-middle c-white"></i>
                  </span>
                </div>
                <div class="caption c-text d-inline-block">Projects Kanban board</div>
              </div>
            <?php endforeach; ?> -->

            <div class="caption c-gray m-bottom-15">Plan administrative details</div>
            <div class="m-bottom-15">
              <div class="form-checkbox d-inline-block m-right-10">
                <input type="checkbox" name="admin_only" id="addPlanAdminOnlyCheckbox">
                <span class="b-gray-secondary v-middle text-center">
                  <i class="fe fe-check v-middle c-white"></i>
                </span>
              </div>
              <div class="caption c-text d-inline-block">Admin only (Only the admin can view the plan.)</div>
            </div>
          </div>
        </div>

        <div class="line-divider"></div>

        <div class="form-button text-right">
          <button type="submit" name="submit_add_plan" class="btn b-secondary c-primary">Add plan</button>
        </div>
      </form>
    </div>
  </div>

</div>