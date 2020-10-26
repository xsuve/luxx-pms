<!-- Wallet Widget -->
<div class="section">
  <div class="text c-gray m-bottom-10">Wallet</div>

  <?php if(count($cards) > 0): ?>
    <div class="box b-white p-all-30">
      <?php if(count($cards) > 1): ?>
        <!--  -->
      <?php else: ?>
        <a href="<?php echo URL; ?>modules/view/wallet">
          <div class="wallet-card p-all-20">
            <div class="wallet-card-mask"></div>
            <div class="wallet-card-type">
              <?php if(substr($priority_card->number, 0, 1) == 4): ?>
                <img src="<?php echo URL; ?>includes/modules/wallet/public/img/visa-logo.svg">
              <?php elseif(substr($priority_card->number, 0, 2) == 51 || substr($priority_card->number, 0, 2) == 52 || substr($priority_card->number, 0, 2) == 53 || substr($priority_card->number, 0, 2) == 54 || substr($priority_card->number, 0, 2) == 55): ?>
                <img src="<?php echo URL; ?>includes/modules/wallet/public/img/mastercard-logo.svg">
              <?php endif; ?>
            </div>
            <div class="wallet-card-number c-white m-top-10 text-center">XXXX<span></span>XXXX<span></span>XXXX<span></span><?php echo substr($priority_card->number, 12, 4); ?></div>
            <div class="wallet-card-info">
              <div class="row">
                <div class="col-lg-7">
                  <div class="wallet-card-caption m-bottom-5 c-white">CARD HOLDER</div>
                  <div class="wallet-card-text c-white"><?php echo $priority_card->holder_name; ?></div>
                </div>
                <div class="col-lg-5 text-right">
                  <div class="wallet-card-caption m-bottom-5 c-white">VALID THRU</div>
                  <div class="wallet-card-text small c-white"><?php echo date_format(date_create($priority_card->valid_thru), 'm / y'); ?></div>
                </div>
              </div>
            </div>
          </div>
        </a>
      <?php endif; ?>

      <div class="wallet-line"></div>
      <div class="row m-bottom-15">
        <div class="col-lg-4">
          <div class="caption c-gray">Number:</div>
        </div>
        <div class="col-lg-8">
          <div class="caption c-title">XXXX XXXX XXXX <?php echo substr($priority_card->number, 12, 4); ?></div>
        </div>
      </div>
      <div class="row m-bottom-15">
        <div class="col-lg-4">
          <div class="caption c-gray">Holder:</div>
        </div>
        <div class="col-lg-8">
          <div class="caption c-title"><?php echo $priority_card->holder_name; ?></div>
        </div>
      </div>
      <div class="row m-bottom-15">
        <div class="col-lg-4">
          <div class="caption c-gray">Valid thru:</div>
        </div>
        <div class="col-lg-8">
          <div class="caption c-title"><?php echo date_format(date_create($priority_card->valid_thru), 'm / y'); ?></div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4">
          <div class="caption c-gray">Last used:</div>
        </div>
        <div class="col-lg-8">
          <div class="caption c-title"><?php echo $module_model->formatCardLastUsedDate($priority_card->last_used); ?></div>
        </div>
      </div>
      <div class="wallet-line"></div>
      <a href="<?php echo URL; ?>modules/view/wallet"><button class="btn b-secondary c-primary btn-block">Make payment</button></a>
    </div>

  <?php else: ?>
    <div class="text c-gray">You don't have any cards yet.</div>
  <?php endif; ?>
</div>