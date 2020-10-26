<?php

$total_cryptocurrencies_value = 0;

foreach($cryptocurrencies as $cryptocurrency) {
	$json = file_get_contents('https://min-api.cryptocompare.com/data/pricemultifull?fsyms=' . $cryptocurrency->cryptocurrency . '&tsyms=' . CURRENCY);
	$cryptocurrency_data = json_decode($json);
	$c = $cryptocurrency->cryptocurrency;
	$s = CURRENCY;

	$total_cryptocurrencies_value += ($cryptocurrency->amount * $cryptocurrency_data->RAW->$c->$s->PRICE);
}

?>

<!-- Add Cryptocurrency Box -->
<div class="lightbox-background" id="addCryptocurrencyBox">
	<div class="lightbox">
		<div class="lightbox-close" id="closeAddCryptocurrencyButton">
			<i class="fe fe-close vertical-middle"></i>
		</div>
		<div class="lightbox-title">Add Cryptocurrency</div>
		<form action="<?php echo URL; ?>modules/executemoduleaction/crypto/addcryptocurrency" method="post">
			<div class="row">
				<div class="col-lg-6 col-6">
					<div class="form-box-input">
						<input type="text" name="cryptocurrency" placeholder="&#xe82f;&nbsp;&nbsp;Cryptocurrency Ticker (ex. BTC)">
					</div>
				</div>
				<div class="col-lg-6 col-6">
					<div class="form-box-input">
						<input type="text" name="amount" placeholder="&#xe82f;&nbsp;&nbsp;Cryptocurrency Amount">
					</div>
				</div>
			</div>
			<div class="form-box-buttons">
				<button type="submit" name="submit_add_cryptocurrency" class="btn btn-primary">ADD CRYPTOCURRENCY</button>
			</div>
		</form>
	</div>
</div>

<!-- Cryptocurrency Right Box -->
<div class="general-right-box" data-right-box-module="crypto">
	<div class="general-right-box-close" data-right-box-module="crypto">
		<i class="fe fe-close vertical-middle"></i>
	</div>

	<!-- Tabs -->
	<div class="general-right-box-tabs">
		<div class="row">
			<div class="col-lg-6">
				<div class="general-right-box-tab active" data-tab="crypto-details">
					<span>DETAILS</span>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="general-right-box-tab" data-tab="crypto-settings">
					<span>SETTINGS</span>
				</div>
			</div>
		</div>
	</div>

	<!-- Content -->
	<div class="general-right-box-content">

		<div class="general-right-box-line"></div>

		<!-- Details Tab -->
		<div class="general-right-box-tab-box crypto-details">

			<div class="row">
				<div class="col-lg-6 col-6 text-left">
					<div class="general-right-box-contact-info-box-title">Cryptocurrencies</div>
					<div class="general-right-box-contact-info-box-text"><?php echo count($cryptocurrencies); ?> <?php echo (count($cryptocurrencies) > 0 ? (count($cryptocurrencies) > 1 ? 'cryptocurrencies' : 'cryptocurrency') : 'cryptocurrencies'); ?></div>
				</div>
				<div class="col-lg-6 col-6 text-right">
					<div class="general-right-box-buttons">
						<button class="btn btn-primary openAddCryptocurrencyButton">ADD CRYPTO</button>
					</div>
				</div>
			</div>

			<div class="general-right-box-line"></div>

			<div class="cryptocurrency-stats">
				<div class="row">
					<div class="col-lg-6 col-12">
						<div class="general-right-box-project-worker-stats-box">
							<div class="general-right-box-project-worker-stats-title">TOTAL CRYPTOCURRENCIES</div>
							<div class="general-right-box-project-worker-stats-number"><?php echo count($cryptocurrencies); ?></div>
						</div>
					</div>
					<div class="col-lg-6 col-12">
						<div class="general-right-box-project-worker-stats-box">
							<div class="general-right-box-project-worker-stats-title">TOTAL VALUE</div>
							<div class="general-right-box-project-worker-stats-number"><?php echo CURRENCY_SYMBOL . number_format($total_cryptocurrencies_value, 2); ?></div>
						</div>
					</div>
				</div>
			</div>

			<?php if(count($cryptocurrencies) > 0): ?>
				<?php foreach($cryptocurrencies as $cryptocurrency): ?>
					<?php
						$json = file_get_contents('https://min-api.cryptocompare.com/data/pricemultifull?fsyms=' . $cryptocurrency->cryptocurrency . '&tsyms=' . CURRENCY);
						$cryptocurrency_data = json_decode($json);
						$c = $cryptocurrency->cryptocurrency;
						$s = CURRENCY;
					?>

					<div class="cryptocurrency-box">
						<div class="row">
							<div class="col-lg-2">
								<div class="cryptocurrency-box-icon vertical-middle">
									<img src="https://www.cryptocompare.com<?php echo $cryptocurrency_data->RAW->$c->$s->IMAGEURL; ?>">
								</div>
							</div>
							<div class="col-lg-1 no-padding-left">
								<div class="cryptocurrency-box-title vertical-middle"><?php echo $cryptocurrency->cryptocurrency; ?></div>
							</div>
							<div class="col-lg-3">
								<div class="cryptocurrency-box-text vertical-middle">x<?php echo number_format($cryptocurrency->amount, 2); ?></div>
							</div>
							<div class="col-lg-3">
								<div class="cryptocurrency-box-text vertical-middle"><?php echo CURRENCY_SYMBOL; ?> <?php echo number_format($cryptocurrency_data->RAW->$c->$s->PRICE, 4); ?></div>
							</div>
							<div class="col-lg-2">
								<div class="cryptocurrency-box-text vertical-middle"><?php echo CURRENCY_SYMBOL; ?> <?php echo number_format($cryptocurrency->amount * $cryptocurrency_data->RAW->$c->$s->PRICE, 2); ?></div>
							</div>
							<div class="col-lg-1 text-right">
								<div class="cryptocurrency-box-action vertical-middle">
									<a href="<?php echo URL; ?>modules/executemoduleaction/crypto/deletecryptocurrency/<?php echo $cryptocurrency->id; ?>">
										<i class="fe fe-trash"></i>
									</a>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php else: ?>
				<div class="general-right-box-text">You don't have any cryptocurrencies yet.</div>
			<?php endif; ?>
		</div>

		<!-- Edit Tab -->
		<div class="general-right-box-tab-box crypto-settings">
			<div class="general-right-box-buttons">
				<div class="row">
					<div class="col-lg-12">
						<?php $widget_status = $module_model_widget->getWidgetDisplayStatus('crypto')->display_widget; ?>
						<?php if($widget_status == false): ?>
							<a href="<?php echo URL; ?>modules/displaywidget/crypto">
								<button class="btn btn-primary">DISPLAY WIDGET</button>
							</a>
						<?php else: ?>
							<a href="<?php echo URL; ?>modules/hidewidget/crypto">
								<button class="btn btn-primary">HIDE WIDGET</button>
							</a>
						<?php endif; ?>
					</div>

					<div class="general-right-box-line"></div>

					<div class="col-lg-12 text-right">
						<a href="<?php echo URL; ?>modules/deletemodule/crypto">
							<button class="btn btn-primary">DELETE MODULE</button>
						</a>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>