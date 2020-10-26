<?php

$module_folder_name = 'expenses';

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

$module_database_table_ids[] = '
	ALTER TABLE `luxx_expenses` ADD PRIMARY KEY (`id`);
';

$module_database_table_autoincrements[] = '
	ALTER TABLE `luxx_expenses` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
';

?>