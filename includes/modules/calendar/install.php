<?php

$module_folder_name = 'calendar';

$module_database_tables[] = '
	CREATE TABLE `luxx_calendar` (
	  `id` int(11) NOT NULL,
	  `account_id` int(11) NOT NULL,
	  `title` varchar(50) NOT NULL,
	  `start_date` datetime NOT NULL,
	  `end_date` datetime NOT NULL,
	  `all_day` tinyint(1) NOT NULL,
	  `color` varchar(50) NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
';

$module_database_table_ids[] = '
	ALTER TABLE `luxx_calendar` ADD PRIMARY KEY (`id`);
';

$module_database_table_autoincrements[] = '
	ALTER TABLE `luxx_calendar` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
';

?>