<!-- Module Widget -->
<?php if(count($expenses) > 0): ?>
	<?php
		$total_expenses_value = 0;
		foreach($expenses as $expense) {
			$total_expenses_value += $expense->price;
		}
	?>

	<div class="expenses-stats">
		<div class="row">
			<div class="col-lg-12 col-12">
				<div class="expenses-stats-box">
					<div class="expenses-stats-box-header">
						<div class="row">
							<div class="col-lg-6 col-7 text-left">
								<div class="expenses-stats-box-header-text">TOTAL 14 DAYS EXPENSES</div>
								<div class="expenses-stats-box-header-number"><?php echo CURRENCY_SYMBOL . number_format($total_fourteen_days_expenses); ?></div>
							</div>
							<div class="col-lg-6 col-5 text-right">
								<?php

									$last_day_expenses = $fourteen_days_expenses->day_two;
									$this_day_expenses = $fourteen_days_expenses->day_one;

									$change = 0;
									if($last_day_expenses <= 0 && $this_day_expenses <= 0) {
										$change = 0;
									} else {
										if($last_day_expenses <= 0) {
											$change = 100;
										} else {
											if($this_day_expenses <= 0) {
												$change = 0;
											} else {
												$change = (($this_day_expenses / $last_day_expenses) * 100) - 100;
											}
										}
									}

								?>
								<div class="expenses-stats-box-header-text d-smm-none">PREVIOUS DAY CHANGE</div>
								<div class="expenses-stats-box-header-change <?php echo ($change > 0 ? 'up' : 'down'); ?>"><?php echo ($change > 0 ? '+' : ''); ?><?php echo number_format($change, 2); ?>%</div>
								<div class="expenses-stats-box-header-change-box <?php echo ($change > 0 ? 'up' : 'down'); ?>">
									<span class="lnr lnr-arrow-<?php echo ($change > 0 ? 'up' : 'down'); ?>"></span>
								</div>
							</div>
						</div>
					</div>
					<div class="expenses-stats-box-body">
						<canvas id="totalExpensesChart"></canvas>
						<script type="text/javascript">
var totalIncomeChartCtx = document.getElementById('totalExpensesChart').getContext('2d');
var strokeGradient = totalIncomeChartCtx.createLinearGradient(0, 0, 320, 0);
strokeGradient.addColorStop(0, '#5691ff');
strokeGradient.addColorStop(1, '#9955fe');

var areaGradient = totalIncomeChartCtx.createLinearGradient(0, 0, 320, 0);
areaGradient.addColorStop(0, 'rgba(86, 145, 255, 0.4)');
areaGradient.addColorStop(1, 'rgba(153, 85, 254, 0.4)');

var totalIncomeChart = new Chart(totalIncomeChartCtx, {
    type: 'line',
    data: {
    	labels: ["<?php echo date('d/m (l)', strtotime('-13 days')); ?>", "<?php echo date('d/m (l)', strtotime('-12 days')); ?>", "<?php echo date('d/m (l)', strtotime('-11 days')); ?>", "<?php echo date('d/m (l)', strtotime('-10 days')); ?>", "<?php echo date('d/m (l)', strtotime('-9 days')); ?>", "<?php echo date('d/m (l)', strtotime('-8 days')); ?>", "<?php echo date('d/m (l)', strtotime('-7 days')); ?>", "<?php echo date('d/m (l)', strtotime('-6 days')); ?>", "<?php echo date('d/m (l)', strtotime('-5 days')); ?>", "<?php echo date('d/m (l)', strtotime('-4 days')); ?>", "<?php echo date('d/m (l)', strtotime('-3 days')); ?>", "<?php echo date('d/m (l)', strtotime('-2 days')); ?>", "<?php echo date('d/m (l)', strtotime('-1 day')); ?>", "<?php echo date('d/m (l)'); ?>"],
        datasets: [{
        	borderColor: strokeGradient,
            pointBorderColor: strokeGradient,
            pointBackgroundColor: strokeGradient,
            pointHoverBackgroundColor: strokeGradient,
            pointHoverBorderColor: strokeGradient,
            backgroundColor: areaGradient,
            pointBorderWidth: 2,
            borderWidth: 2,
            label: 'Expenses',
            data: [<?php echo $fourteen_days_expenses->day_fourteen; ?>, <?php echo $fourteen_days_expenses->day_thirteen; ?>, <?php echo $fourteen_days_expenses->day_twelve; ?>, <?php echo $fourteen_days_expenses->day_eleven; ?>, <?php echo $fourteen_days_expenses->day_ten; ?>, <?php echo $fourteen_days_expenses->day_nine; ?>, <?php echo $fourteen_days_expenses->day_eight; ?>, <?php echo $fourteen_days_expenses->day_seven; ?>, <?php echo $fourteen_days_expenses->day_six; ?>, <?php echo $fourteen_days_expenses->day_five; ?>, <?php echo $fourteen_days_expenses->day_four; ?>, <?php echo $fourteen_days_expenses->day_three; ?>, <?php echo $fourteen_days_expenses->day_two; ?>, <?php echo $fourteen_days_expenses->day_one; ?>]
        }]
    },
    options: {
    	responsive: true,
    	maintainAspectRatio: false,
    	tooltips: {
    		xPadding: 10,
    		yPadding: 10,
    		position: 'nearest',
    		intersect: false,
    		bodyFontFamily: 'Muli',
    		footerFontColor: '#8e8e8e',
    		custom: function(tooltip) {
    			if(!tooltip) return;
    			tooltip.displayColors = false;
    		},
    		callbacks: {
                label: function(tooltipItem, data) {
                    return 'Expenses: $' + tooltipItem.yLabel;
                }
            }
    	},
    	layout: {
    		padding: {
    			left: 0,
    			right: 0,
    			top: 10,
    			bottom: 0
    		}
    	},
    	scales :{
    		xAxes: [{
    			ticks: {
	    			display: false,
	    			padding: 0
	    		},
    			gridLines: {
    				display: false,
    				drawTicks: false,
    				drawBorder: false
    			},
    		}],
    		yAxes: [{
    			ticks: {
    				beginAtZero: true,
	    			display: false,
	    			padding: 0
	    		},
    			gridLines: {
    				display: false,
    				drawTicks: false,
    				drawBorder: false
    			},
    		}]
    	},
        legend: {
    		display: false
        }
    }
});
						</script>
					</div>
				</div>

				<div class="expenses-category-stats-box">
					<div class="row">
						<?php foreach($top_expenses as $top_expense): ?>
							<?php
								$total_top_expense_value = 0;
								$total_top_expense_value += $top_expense->price;

								switch($top_expense->category) {
									case 'insurance':
										$top_expense_icon = 'fe fe-umbrella';
									break;

									case 'shopping':
										$top_expense_icon = 'fe fe-cart';
									break;

									case 'health':
										$top_expense_icon = 'fe fe-heart';
									break;

									case 'groceries':
										$top_expense_icon = 'fe fe-shopping-bag';
									break;

									case 'entertainment':
										$top_expense_icon = 'fe fe-gamepad';
									break;

									case 'transport':
										$top_expense_icon = 'fe fe-car';
									break;

									case 'restaurants':
										$top_expense_icon = 'fe fe-cutlery';
									break;

									case 'general':
										$top_expense_icon = 'fe fe-wallet';
									break;

									case 'services':
										$top_expense_icon = 'fe fe-wrench';
									break;

									case 'utilities':
										$top_expense_icon = 'fe fe-home';
									break;

									case 'travel':
										$top_expense_icon = 'fe fe-location';
									break;
								}
							?>

							<div class="col-lg-2 col-2">
								<div class="expense-category-stats-box-progress-bar">
									<div style="height: <?php echo number_format(((($top_expense->price / $total_expenses_value) * 100) * 80) / 100, 2); ?>%;"></div>
								</div>
								<div class="expense-category-stats-box-icon">
									<i class="<?php echo $top_expense_icon; ?> vertical-middle"></i>
								</div>
								<div class="expense-category-stats-box-text"><?php echo CURRENCY_SYMBOL . $total_top_expense_value; ?></div>
							</div>
						<?php endforeach; ?>

					</div>
				</div>
			</div>
		</div>
	</div>

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

		<div class="expense-widget-box">
			<div class="row">
				<div class="col-lg-2 col-3">
					<div class="expense-widget-box-icon vertical-middle">
						<i class="<?php echo $expense_icon; ?> vertical-middle"></i>
					</div>
				</div>
				<div class="col-lg-5 col-6 no-padding-left">
					<div class="vertical-middle">
						<div class="expense-widget-box-title"><?php echo $expense->title; ?></div>
						<div class="expense-widget-box-text"><?php echo $expense->expense_date; ?></div>
					</div>
				</div>
				<div class="col-lg-3 d-smm-none">
					<div class="expense-widget-box-price vertical-middle text-center"><?php echo CURRENCY_SYMBOL . $expense->price; ?></div>
				</div>
				<div class="col-lg-2 col-3">
					<div class="vertical-middle text-right">
						<div class="expense-widget-box-actions">
							<a href="<?php echo URL; ?>modules/executemoduleaction/expenses/deleteexpense/<?php echo $expense->id; ?>">
								<button><i class="fe fe-trash"></i></button>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
<?php else: ?>
	<div class="no-expenses-text">You don't have any expenses yet.</div>
<?php endif; ?>