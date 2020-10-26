<?php

$module_folder_name = 'saas';

$module_database_tables[] = '
	CREATE TABLE `luxx_expenses` (
	  `id` int(11) NOT NULL,
	  `account_id` int(11) NOT NULL,
	  `title` varchar(50) NOT NULL,
	  `price` int(11) NOT NULL,
	  `expense_date` date NOT NULL,
	  `category` varchar(30) NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
';

$module_database_tables[] = '
	CREATE TABLE `luxx_expenses_stats` (
	  `id` int(11) NOT NULL,
	  `account_id` int(11) NOT NULL,
	  `current_day` varchar(5) NOT NULL,
	  `day_fourteen` float NOT NULL,
	  `day_thirteen` float NOT NULL,
	  `day_twelve` float NOT NULL,
	  `day_eleven` float NOT NULL,
	  `day_ten` float NOT NULL,
	  `day_nine` float NOT NULL,
	  `day_eight` float NOT NULL,
	  `day_seven` float NOT NULL,
	  `day_six` float NOT NULL,
	  `day_five` float NOT NULL,
	  `day_four` float NOT NULL,
	  `day_three` float NOT NULL,
	  `day_two` float NOT NULL,
	  `day_one` float NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
';

$module_database_table_ids[] = '
	ALTER TABLE `luxx_expenses`
  	  ADD PRIMARY KEY (`id`);
';

$module_database_table_ids[] = '
	ALTER TABLE `luxx_expenses_stats`
      ADD PRIMARY KEY (`id`);
';

$current_day = date('d/m');
$module_database_table_autoincrements[] = '
	ALTER TABLE `luxx_expenses`
  	  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
';

$module_database_table_autoincrements[] = '
  	ALTER TABLE `luxx_expenses_stats`
      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
';

$module_database_table_autoincrements[] = '
     INSERT INTO `luxx_expenses_stats` (`account_id`, `current_day`, `day_fourteen`, `day_thirteen`, `day_twelve`, `day_eleven`, `day_ten`, `day_nine`, `day_eight`, `day_seven`, `day_six`, `day_five`, `day_four`, `day_three`, `day_two`, `day_one`) VALUES (' . $account_id . ', "' . $current_day . '", 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
';

$module_database_deletes[] = 'DROP TABLE luxx_expenses_stats';

?>