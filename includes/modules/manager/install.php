<?php

$module_folder_name = 'manager';

$module_database_tables[] = '
	CREATE TABLE `luxx_reminders` (
	  `id` int(11) NOT NULL,
	  `account_id` int(11) NOT NULL,
	  `title` varchar(50) NOT NULL,
	  `completed` tinyint(1) NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
';

$module_database_table_ids[] = '
	ALTER TABLE `luxx_reminders`
  	  ADD PRIMARY KEY (`id`);
';

$module_database_table_autoincrements[] = '
	ALTER TABLE `luxx_reminders`
      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
';

?>