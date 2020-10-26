<!-- Wallet -->
<div class="container-fluid content">

  <!-- Payments -->
  <div class="row">
    <div class="col-lg-7">
      <div class="section">
        <div class="text c-gray m-bottom-10">Payments</div>
        <div class="box b-white p-all-30">
          <?php $i = 0; ?>
          <?php if(count($payments) > 0): ?>
            <?php foreach($payments as $payment): ?>
              <div class="list-element p-bottom-15 p-top-15 <?php echo ($i == 0 ? 'first' : ''); ?> <?php echo ($i == (count($payments) - 1) ? 'last' : ''); ?>">
                <div class="row">
                  <div class="col-lg-6 text-left">
                    <div class="list-element-title caption v-middle"><?php echo $payment->title; ?></div>
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
              <img src="<?php echo URL; ?>public/img/graphic-3.svg">
            </div>
            <h3 class="c-title m-top-30 text-center">No payments!</h3>
            <div class="text c-gray text-center">You don't have any payments yet.</div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="section">
        <div class="text c-gray m-bottom-10">New card</div>
        <div class="box b-white p-all-30">
          <h3 class="project-title c-title m-bottom-30">Add new card</h3>
          <form action="<?php echo URL; ?>modules/executemoduleaction/wallet/addcard" method="post">
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Number</div>
              <input type="text" name="card_number" placeholder="Enter the card number" class="text c-text">
            </div>
            <div class="form-input-box">
              <div class="caption c-text m-bottom-5">Holder name</div>
              <input type="text" name="card_holder_name" placeholder="Enter the card holder name" class="text c-text">
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">Valid thru</div>
                  <input type="text" name="card_valid_thru" placeholder="Enter the card expiration date" class="text c-text" id="addCardExpirationDateDatepicker">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-input-box">
                  <div class="caption c-text m-bottom-5">CVC</div>
                  <input type="text" name="card_cvc" placeholder="Enter the card cvc" class="text c-text">
                </div>
              </div>
            </div>
            <div class="form-button">
              <button type="submit" name="submit_add_card" class="btn b-secondary c-primary btn-block">Add card</button>
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
                <a href="<?php echo URL; ?>modules/<?php echo ($pinned_status->pinned == 1 ? 'unpinmodule' : 'pinmodule'); ?>/wallet">
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
                <a href="<?php echo URL; ?>modules/<?php echo ($widget_status->display_widget == 1 ? 'hidewidget' : 'displaywidget'); ?>/wallet">
                  <div class="module-widget-btn b-gray-secondary">
                    <div class="module-widget-btn-circle <?php echo ($widget_status->display_widget == 1 ? 'on' : 'off'); ?> v-middle"></div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="d-block m-top-30">
          <a href="<?php echo URL; ?>modules/deletemodule/wallet">
            <button class="btn b-red-secondary c-red btn-block">Delete module</button>
          </a>
        </div>
      </div>
    </div>
  </div>

</div>