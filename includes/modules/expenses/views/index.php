<!-- Expenses -->
<div class="container-fluid content">

  <!-- Expenses Stats -->
  <?php if(count($stats_expenses) > 0): ?>
    <div class="section projects-stats m-bottom-20 hide-on-search text-center">
      <div class="projects-stats-top text-left">
        <h2 class="c-title m-bottom-0"><?php echo count($stats_expenses); ?></h2>
        <div class="text c-gray">Total <?php echo(count($stats_expenses) > 0 ? (count($stats_expenses) > 1 ? 'expenses' : 'expense') : 'expenses'); ?></div>
      </div>

      <?php
        $today = date('Y-m-d');
        $today_m = date('Y-m-d');
        $minus = date('Y-m-d', strtotime('-16 days', strtotime(date('Y-m-d'))));
        $minus_o = $minus;
        $minus_m = date('Y-m-d', strtotime('-16 days', strtotime(date('Y-m-d'))));
        $plus = date('Y-m-d', strtotime('+16 days', strtotime(date('Y-m-d'))));
        $plus_o = $plus;
        $plus_m = date('Y-m-d', strtotime('+16 days', strtotime(date('Y-m-d'))));
        $max = 0;
        while(strtotime($minus_m) <= strtotime($plus_m)) {
          $stats_expenses_m = $module_model->getAccountExpensesDate($account->id, $minus_m);
          if(count($stats_expenses_m) > $max) {
            $max = count($stats_expenses_m);
          }
          $minus_m = date('Y-m-d', strtotime('+1 day', strtotime($minus_m)));
        }
      ?>
      <?php while(strtotime($minus) < strtotime($today)): ?>
        <?php
          $stats_expenses = $module_model->getAccountExpensesDate($account->id, $minus);
          $height = (count($stats_expenses) > 0 ? ((count($stats_expenses) * 100) / $max) : 0);
        ?>
        <div class="projects-stats-box m-left-5 m-right-5">
          <div class="projects-stats-box-bar m-bottom-10">
            <div class="projects-stats-box-bar-height b-gray-secondary" style="height: <?php echo $height; ?>%;">
              <div class="projects-stats-box-bar-tooltip box b-white p-all-15 text-left">
                <h5 class="c-title"><?php echo count($stats_expenses); ?> <?php echo(count($stats_expenses) > 0 ? (count($stats_expenses) > 1 ? 'EXPENSES' : 'EXPENSE') : 'EXPENSES'); ?></h5>
                <div class="text c-gray"><?php echo date('j F, Y', strtotime($minus)); ?></div>
              </div>
            </div>
          </div>
          <div class="projects-stats-box-bar-day text c-gray text-center"><?php echo date('j', strtotime($minus)); ?></div>
        </div>
        <?php $minus = date('Y-m-d', strtotime('+1 day', strtotime($minus))); ?>
      <?php endwhile; ?>

      <?php while(strtotime($plus) >= strtotime($today)): ?>
        <?php
          $stats_expenses = $module_model->getAccountExpensesDate($account->id, $today);
          $height = (count($stats_expenses) > 0 ? ((count($stats_expenses) * 100) / $max) : 0);
        ?>
        <div class="projects-stats-box m-left-5 m-right-5">
          <div class="projects-stats-box-bar m-bottom-10">
            <div class="projects-stats-box-bar-height b-gray-secondary" style="height: <?php echo $height; ?>%;">
              <div class="projects-stats-box-bar-tooltip box b-white p-all-15 text-left">
                <h5 class="c-title"><?php echo count($stats_expenses); ?> <?php echo(count($stats_expenses) > 0 ? (count($stats_expenses) > 1 ? 'EXPENSES' : 'EXPENSE') : 'EXPENSES'); ?></h5>
                <div class="text c-gray"><?php echo date('j F, Y', strtotime($today)); ?></div>
              </div>
            </div>
          </div>
          <div class="projects-stats-box-bar-day text c-gray text-center"><?php echo date('j', strtotime($today)); ?></div>
        </div>
        <?php $today = date('Y-m-d', strtotime('+1 day', strtotime($today))); ?>
      <?php endwhile; ?>

      <div class="row m-bottom-20 m-top-10">
        <div class="col-lg-6 text-left">
          <h5 class="c-text"><?php echo date('F', strtotime($minus_o)); ?></h5>
        </div>
        <div class="col-lg-6 text-right">
          <h5 class="c-text"><?php echo date('F', strtotime($plus_o)); ?></h5>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <!-- Expenses -->
  <div class="row">
    <div class="col-lg-7">
      <div class="section">
        <div class="text c-gray m-bottom-10">Expenses</div>
        <div class="box b-white p-all-30">
          <?php $i = 0; ?>
          <?php if(count($expenses) > 0): ?>
            <?php foreach($expenses as $expense): ?>
              <?php
                switch($expense->category) {
                  case 'insurance':
                    $expense_icon = 'fe fe-umbrella';
                  break;

                  case 'shopping':
                    $expense_icon = 'fe fe-cart';
                  break;

                  case 'health':
                    $expense_icon = 'fe fe-heart';
                  break;

                  case 'groceries':
                    $expense_icon = 'fe fe-shopping-bag';
                  break;

                  case 'entertainment':
                    $expense_icon = 'fe fe-gamepad';
                  break;

                  case 'transport':
                    $expense_icon = 'fe fe-car';
                  break;

                  case 'restaurants':
                    $expense_icon = 'fe fe-cutlery';
                  break;

                  case 'general':
                    $expense_icon = 'fe fe-wallet';
                  break;

                  case 'services':
                    $expense_icon = 'fe fe-wrench';
                  break;

                  case 'utilities':
                    $expense_icon = 'fe fe-home';
                  break;

                  case 'travel':
                    $expense_icon = 'fe fe-location';
                  break;
                }
              ?>
              <div class="list-element p-bottom-15 p-top-15 <?php echo ($i == 0 ? 'first' : ''); ?> <?php echo ($i == (count($expenses) - 1) ? 'last' : ''); ?>">
                <div class="row">
                  <div class="col-lg-6 text-left">
                    <div class="list-element-title caption v-middle"><?php echo $expense->title; ?></div>
                  </div>
                  <div class="col-lg-2 text-left">
                    <div class="v-middle">
                      <div class="caption c-title text-center m-bottom-5"><?php echo CURRENCY_SYMBOL . $expense->price; ?></div>
                      <div class="list-element-title text c-gray text-center"><?php echo date_format(date_create($expense->expense_date), 'j M.'); ?></div>
                    </div>
                  </div>
                  <div class="col-lg-2 text-right">
                    <div class="icon-circle small b-secondary c-primary text-center v-middle" title="<?php echo ucfirst($expense->category); ?>"><i class="<?php echo $expense_icon; ?> v-middle"></i></div>
                  </div>
                  <div class="col-lg-2 text-right">
                    <div class="list-element-title v-middle">
                      <button class="more-btn p-right-0 caption c-gray" onclick="event.stopPropagation(); this.childNodes[2].style.display = 'block';"><i class="fe fe-elipsis-h"></i>
                        <div class="more-dropdown module-dropdown box b-white p-top-10 p-left-10 p-bottom-10 v-middle caption text-right">
                          <a href="<?php echo URL; ?>modules/edit/expenses/<?php echo $expense->id; ?>">
                            <div class="m-right-5 b-secondary c-primary text-center">
                              <i class="fe fe-edit v-middle"></i>
                            </div>
                          </a>
                          <a href="<?php echo URL; ?>modules/executemoduleaction/expenses/deleteexpense/<?php echo $expense->id; ?>">
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
            <h3 class="c-title m-top-30 text-center">No expenses!</h3>
            <div class="text c-gray text-center">You don't have any expenses yet.</div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="section">
        <div class="text c-gray m-bottom-10">New expense</div>
        <div class="box b-white p-all-30">
          <h3 class="project-title c-title m-bottom-30">Add new expense</h3>
          <form action="<?php echo URL; ?>modules/executemoduleaction/expenses/addexpense" method="post">
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Title</div>
              <input type="text" name="expense_title" placeholder="Enter the expense title" class="text c-text">
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">Date</div>
                  <input type="text" name="expense_date" placeholder="Enter the expense date" class="text c-text" id="addExpenseDateDatepicker">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">Price (<?php echo CURRENCY; ?>)</div>
                  <input type="text" name="expense_price" placeholder="Enter the expense price" class="text c-text">
                </div>
              </div>
            </div>
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Category</div>
              <select name="expense_category" class="text c-text">
                <option value="" selected="selected" disabled="disabled">Select the expense category</option>
                <option value="insurance">Insurance</option>
                <option value="shopping">Shopping</option>
                <option value="health">Health</option>
                <option value="groceries">Groceries</option>
                <option value="entertainment">Entertainment</option>
                <option value="transport">Transport</option>
                <option value="restaurants">Restaurants</option>
                <option value="general">General</option>
                <option value="services">Services</option>
                <option value="utilities">Utilities</option>
                <option value="travel">Travel</option>
              </select>
            </div>
            <div class="form-button">
              <button type="submit" name="submit_add_expense" class="btn b-secondary c-primary btn-block">Add expense</button>
            </div>
          </form>
        </div>
      </div>

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
                <a href="<?php echo URL; ?>modules/<?php echo ($pinned_status->pinned == 1 ? 'unpinmodule' : 'pinmodule'); ?>/expenses">
                  <div class="module-widget-btn b-gray-secondary">
                    <div class="module-widget-btn-circle <?php echo ($pinned_status->pinned == 1 ? 'on' : 'off'); ?> v-middle"></div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>

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
                <a href="<?php echo URL; ?>modules/<?php echo ($widget_status->display_widget == 1 ? 'hidewidget' : 'displaywidget'); ?>/expenses">
                  <div class="module-widget-btn b-gray-secondary">
                    <div class="module-widget-btn-circle <?php echo ($widget_status->display_widget == 1 ? 'on' : 'off'); ?> v-middle"></div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="d-block m-top-30">
          <a href="<?php echo URL; ?>modules/deletemodule/expenses">
            <button class="btn b-red-secondary c-red btn-block">Delete module</button>
          </a>
        </div>
      </div>
    </div>
  </div>

</div>