<?php

$currentPath = $_SERVER['PHP_SELF'];
$pathInfo = pathinfo($currentPath);
$dirName = $pathInfo['dirname'];

function getBaseUrl() {
	$_currentPath = $_SERVER['PHP_SELF'];
	$_pathInfo = pathinfo($_currentPath);
	$hostName = $_SERVER['HTTP_HOST'];
	$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https://' ? 'https://' : 'http://';
	return $protocol . $hostName . $_pathInfo['dirname'] . "/";
}

$base_url = getBaseUrl();

$error = '';

if(isset($_POST['submit_install'])) {
	if(!empty($_POST['db_host']) && !empty($_POST['db_name']) && !empty($_POST['db_user']) && !empty($_POST['db_password']) && !empty($_POST['currency']) && !empty($_POST['currency_symbol']) && !empty($_POST['timezone']) && !empty($_POST['invoice_name']) && !empty($_POST['invoice_email']) && !empty($_POST['invoice_address']) && !empty($_POST['invoice_phone']) && !empty($_POST['admin_email'])) {
		$db_host = filter_var($_POST['db_host'], FILTER_SANITIZE_SPECIAL_CHARS);
		$db_name = filter_var($_POST['db_name'], FILTER_SANITIZE_SPECIAL_CHARS);
		$db_user = filter_var($_POST['db_user'], FILTER_SANITIZE_SPECIAL_CHARS);
		$db_password = filter_var($_POST['db_password'], FILTER_SANITIZE_SPECIAL_CHARS);
		$currency = filter_var($_POST['currency'], FILTER_SANITIZE_SPECIAL_CHARS);
		$currency_symbol = filter_var($_POST['currency_symbol'], FILTER_SANITIZE_SPECIAL_CHARS);
		$timezone = filter_var($_POST['timezone'], FILTER_SANITIZE_SPECIAL_CHARS);
		$invoice_name = filter_var($_POST['invoice_name'], FILTER_SANITIZE_SPECIAL_CHARS);
		$invoice_email = filter_var($_POST['invoice_email'], FILTER_SANITIZE_SPECIAL_CHARS);
		$invoice_address = filter_var($_POST['invoice_address'], FILTER_SANITIZE_SPECIAL_CHARS);
		$invoice_phone = filter_var($_POST['invoice_phone'], FILTER_SANITIZE_SPECIAL_CHARS);
		$admin_email = filter_var($_POST['admin_email'], FILTER_SANITIZE_SPECIAL_CHARS);

		$config_text = '<?php

// Errors
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Database
define("DB_TYPE", "mysql");
define("DB_HOST", "' . $db_host . '");
define("DB_NAME", "' . $db_name . '");
define("DB_USER", "' . $db_user . '");
define("DB_PASS", "' . $db_password . '");

// General
define("THEME", "Luxx");
define("URL", "' . $base_url . '");

// Invoice
define("INVOICE_NAME", "' . $invoice_name . '");
define("INVOICE_EMAIL", "' . $invoice_email . '");
define("INVOICE_ADDRESS", "' . $invoice_address . '");
define("INVOICE_PHONE", "' . $invoice_phone . '");

// Platform
define("TIMEZONE", "' . $timezone . '"); // https://www.php.net/manual/en/timezones.php
define("CURRENCY", "' . $currency . '");
define("CURRENCY_SYMBOL", "' . $currency_symbol . '");
define("ADMIN_EMAIL", "' . $admin_email . '");
define("ATTACHMENT_MAX_SIZE", 20000000); // 20000000 B -> 20 MB

?>';
		if(file_put_contents('application/config/config.php', $config_text)) {
        $connect = mysqli_connect($db_host, $db_user, $db_password);
			if(!$connect) {
		    die('Connection failed: ' . mysqli_connect_error());
			}

        $sql_create_db = 'CREATE DATABASE IF NOT EXISTS ' . $db_name . ';';

			if(mysqli_query($connect, $sql_create_db) === true) {
				mysqli_select_db($connect, $db_name);

				// Accounts
				$sql_tables[] = "
					CREATE TABLE `luxx_accounts` (
					  `id` int(11) NOT NULL,
					  `name` varchar(50) NOT NULL,
					  `email` varchar(50) NOT NULL,
					  `phone_number` varchar(20) NOT NULL,
					  `password` varchar(255) NOT NULL,
					  `register_date` date NOT NULL,
					  `activated` tinyint(1) NOT NULL,
					  `activate_token` varchar(64) NOT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;
				";

				// Categories
				$sql_tables[] = "
					CREATE TABLE `luxx_categories` (
					  `id` int(11) NOT NULL,
					  `account_id` int(11) NOT NULL,
					  `type` varchar(50) NOT NULL,
					  `title` varchar(50) NOT NULL,
					  `color` varchar(50) NOT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;
				";

				// Contacts
				$sql_tables[] = "
					CREATE TABLE `luxx_contacts` (
					  `id` int(11) NOT NULL,
					  `account_id` int(11) NOT NULL,
					  `category_id` int(11) NOT NULL,
					  `name` varchar(50) NOT NULL,
					  `email` varchar(50) NOT NULL,
					  `phone_number` varchar(20) NOT NULL,
					  `address` varchar(255) NOT NULL,
					  `company_details` text NOT NULL,
					  `pinned` tinyint(1) NOT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;
				";

				// Invoices
				$sql_tables[] = "
					CREATE TABLE `luxx_invoices` (
					  `id` int(11) NOT NULL,
					  `account_id` int(11) NOT NULL,
					  `category_id` int(11) NOT NULL,
					  `contact_id` int(11) NOT NULL,
					  `contact_name` varchar(50) NOT NULL,
					  `contact_email` varchar(50) NOT NULL,
					  `contact_phone` varchar(50) NOT NULL,
					  `contact_address` varchar(255) NOT NULL,
					  `due_date` date NOT NULL,
					  `vat` int(11) NOT NULL,
					  `paid` tinyint(1) NOT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;

				";

				// Invoice Items
				$sql_tables[] = "
					CREATE TABLE `luxx_invoices_items` (
					  `id` int(11) NOT NULL,
					  `invoice_id` int(11) NOT NULL,
					  `title` varchar(50) NOT NULL,
					  `quantity` int(11) NOT NULL,
					  `price` int(11) NOT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;
				";

				// Projects
				$sql_tables[] = "
					CREATE TABLE `luxx_projects` (
					  `id` int(11) NOT NULL,
					  `account_id` int(11) NOT NULL,
					  `category_id` int(11) NOT NULL,
					  `title` varchar(100) NOT NULL,
					  `deadline` date NOT NULL,
					  `income` int(11) NOT NULL,
					  `pinned` tinyint(1) NOT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;
				";

				// Notifications
				$sql_tables[] = "
					CREATE TABLE `luxx_notifications` (
					  `id` int(11) NOT NULL,
					  `account_id` int(11) NOT NULL,
					  `icon` varchar(30) NOT NULL,
					  `title` varchar(50) NOT NULL,
					  `notification_date` datetime NOT NULL,
					  `location` text NOT NULL,
					  `viewed` tinyint(1) NOT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;
				";

				// Tasks
				$sql_tables[] = "
					CREATE TABLE `luxx_projects_tasks` (
					  `id` int(11) NOT NULL,
					  `project_id` int(11) NOT NULL,
					  `worker_id` int(11) NOT NULL,
					  `category_id` int(11) NOT NULL,
					  `title` varchar(255) NOT NULL,
					  `completed` tinyint(1) NOT NULL,
					  `date_completed` date NOT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;
				";

				// Workers
				$sql_tables[] = "
					CREATE TABLE `luxx_projects_workers` (
					  `id` int(11) NOT NULL,
					  `contact_id` int(11) NOT NULL,
					  `project_id` int(11) NOT NULL,
					  `work_hours` int(11) NOT NULL,
					  `price_per_hour` int(11) NOT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;
				";

				// Modules
				$sql_tables[] = "
					CREATE TABLE `luxx_modules` (
					  `id` int(11) NOT NULL,
					  `account_id` int(11) NOT NULL,
					  `title` varchar(50) NOT NULL,
					  `pinned` tinyint(1) NOT NULL,
					  `display_widget` tinyint(1) NOT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;
				";

				$sql_table_alters[] = "ALTER TABLE `luxx_accounts` ADD PRIMARY KEY (`id`);";
				$sql_table_alters[] = "ALTER TABLE `luxx_categories` ADD PRIMARY KEY (`id`);";
				$sql_table_alters[] = "ALTER TABLE `luxx_contacts` ADD PRIMARY KEY (`id`);";
				$sql_table_alters[] = "ALTER TABLE `luxx_invoices` ADD PRIMARY KEY (`id`);";
				$sql_table_alters[] = "ALTER TABLE `luxx_invoices_items` ADD PRIMARY KEY (`id`);";
				$sql_table_alters[] = "ALTER TABLE `luxx_projects` ADD PRIMARY KEY (`id`);";
				$sql_table_alters[] = "ALTER TABLE `luxx_notifications` ADD PRIMARY KEY (`id`);";
				$sql_table_alters[] = "ALTER TABLE `luxx_projects_tasks` ADD PRIMARY KEY (`id`);";
				$sql_table_alters[] = "ALTER TABLE `luxx_projects_workers` ADD PRIMARY KEY (`id`);";
				$sql_table_alters[] = "ALTER TABLE `luxx_modules` ADD PRIMARY KEY (`id`);";

				$sql_table_alters[] = "ALTER TABLE `luxx_accounts` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
				$sql_table_alters[] = "ALTER TABLE `luxx_categories` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
				$sql_table_alters[] = "ALTER TABLE `luxx_contacts` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
				$sql_table_alters[] = "ALTER TABLE `luxx_invoices` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
				$sql_table_alters[] = "ALTER TABLE `luxx_invoices_items` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
				$sql_table_alters[] = "ALTER TABLE `luxx_projects` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
				$sql_table_alters[] = "ALTER TABLE `luxx_notifications` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT";
				$sql_table_alters[] = "ALTER TABLE `luxx_projects_tasks` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
				$sql_table_alters[] = "ALTER TABLE `luxx_projects_workers` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
				$sql_table_alters[] = "ALTER TABLE `luxx_modules` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";

       	foreach($sql_tables as $sql_table) {
       		if(mysqli_query($connect, $sql_table) === false) {
       			$error = 'The database table could not be created.';
       			header('location: install.php?s=2');
       		}
       	}

       	foreach($sql_table_alters as $sql_table_alter) {
     			if(mysqli_query($connect, $sql_table_alter) === true) {
     				$error = 'The table alters could not be executed.';
     				header('location: install.php?s=2');
     			}
     		}

     		$file = '.htaccess';
				$content = file($file);
				foreach($content as $lineNumber => &$lineContent) {
			    if($lineNumber == 6) {
		        $lineContent = 'RewriteBase ' . $dirName . '/' . PHP_EOL;
			    }
				}
				$allContent = implode('', $content);
				file_put_contents($file, $allContent);

 				unlink('install.php');
 				mysqli_close($connect);
 				header('location: index.php');
			} else {
				$error = 'The database could not be created.';
			}
		} else {
			$error = 'Unable to write data to the config file.';
		}
	} else {
		$error = 'Please fill all the required fields.';
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Luxx - Installation</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="public/img/luxx-logo.svg">
    <link href="https://fonts.googleapis.com/css?family=Muli:100,300,400,500,600,700" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!-- Luxx UI -->
    <link href="includes/luxx-ui/luxx.css" rel="stylesheet">

    <style type="text/css">
	    html, body {
		    font-family: 'Muli', sans-serif;
		    padding: 0px;
		    margin: 0px;
		    background-color: #f8fafb;
			}
			#section-2 {
				display: none;
			}
    	.install-box {
    		width: calc(45% - 60px);
    		margin: 100px auto;
    	}
    	.install-box-logo {
    		text-align: center;
    		width: 72px;
    		height: 72px;
    		margin: 0px auto 30px auto;
    	}
    	.install-box-logo img {
    		max-width: 100%;
    	}
			.input-form-box {
				margin-top: 30px;
			}
			.input-box {
				border: 1px solid #edeef4;
				border-radius: 3px;
				position: relative;
				height: 35px;
			}
			.input-box input {
				border: 0px;
				padding: 0px 10px;
				width: 100%;
				height: 100%;
				font-size: 12px;
				color: #484848;
			}
    	.install-error {
    		padding: 10px;
    		border: 1px solid #da4d43;
    		color: #da4d43;
    		font-size: 13px;
    		text-align: center;
    		margin-top: 20px;
    	}
    </style>
</head>
<body>
	<div class="box b-white p-all-50 text-center install-box">
		<div id="section-1">
			<div class="install-box-logo">
				<img src="public/img/luxx-logo.svg">
			</div>
			<h1 class="c-title">Luxx Installation</h1>
			<div class="text c-gray m-bottom-20">Welcome! Luxx is the perfect solution to manage the contacts, projects and invoices for your small business.</div>
			<div class="caption c-text m-bottom-30">The installation process is very easy and it only takes 60 seconds!</div>
			<div class="install-box-buttons">
				<button class="btn b-secondary c-primary" id="startInstallationButton">Start Installation</button>
			</div>
		</div>
		<div id="section-2">
			<div class="install-box-logo section-2-logo">
				<img src="public/img/luxx-logo.svg">
			</div>
			<form action="install.php?s=2" method="post">
				<h1 class="c-title">Database Informations</h1>
				<?php if(isset($error) && $error != ''): ?>
					<div class="install-error"><?php echo $error; ?></div>
				<?php endif; ?>

				<div class="input-form-box">
					<div class="row">
						<div class="col-lg-6">
							<div class="caption text-left">Database Host</div>
							<div class="caption c-gray text-left m-top-5">Your database host</div>
						</div>
						<div class="col-lg-6">
							<div class="input-box">
								<input type="text" name="db_host" placeholder="ex. localhost:3306">
							</div>
						</div>
					</div>
				</div>
				<div class="input-form-box">
					<div class="row">
						<div class="col-lg-6">
							<div class="caption text-left">Database Name</div>
							<div class="caption c-gray text-left m-top-5">Your database name</div>
						</div>
						<div class="col-lg-6">
							<div class="input-box">
								<input type="text" name="db_name" placeholder="ex. luxx">
							</div>
						</div>
					</div>
				</div>
				<div class="input-form-box">
					<div class="row">
						<div class="col-lg-6">
							<div class="caption text-left">Username</div>
							<div class="caption c-gray text-left m-top-5">Your database user</div>
						</div>
						<div class="col-lg-6">
							<div class="input-box">
								<input type="text" name="db_user" placeholder="ex. root">
							</div>
						</div>
					</div>
				</div>
				<div class="input-form-box">
					<div class="row">
						<div class="col-lg-6">
							<div class="caption text-left">Password</div>
							<div class="caption c-gray text-left m-top-5">Your database password</div>
						</div>
						<div class="col-lg-6">
							<div class="input-box">
								<input type="password" name="db_password" placeholder="ex. root">
							</div>
						</div>
					</div>
				</div>

				<h1 class="c-title m-top-50">Administrative Details</h1>
				<div class="input-form-box">
					<div class="row">
						<div class="col-lg-6">
							<div class="caption text-left">Currency</div>
							<div class="caption c-gray text-left m-top-5">Platform Currency</div>
						</div>
						<div class="col-lg-6">
							<div class="input-box">
								<input type="text" name="currency" placeholder="ex. USD">
							</div>
						</div>
					</div>
				</div>
				<div class="input-form-box">
					<div class="row">
						<div class="col-lg-6">
							<div class="caption text-left">Currency Symbol</div>
							<div class="caption c-gray text-left m-top-5">Platform Currency symbol</div>
						</div>
						<div class="col-lg-6">
							<div class="input-box">
								<input type="text" name="currency_symbol" placeholder="ex. $">
							</div>
						</div>
					</div>
				</div>
				<div class="input-form-box">
					<div class="row">
						<div class="col-lg-6">
							<div class="caption text-left">Timezone</div>
							<div class="caption c-gray text-left m-top-5"><a href="https://www.php.net/manual/en/timezones.php" target="_blank">PHP Timezones</a></div>
						</div>
						<div class="col-lg-6">
							<div class="input-box">
								<input type="text" name="timezone" placeholder="ex. Europe/Bucharest">
							</div>
						</div>
					</div>
				</div>
				<div class="input-form-box">
					<div class="row">
						<div class="col-lg-6">
							<div class="caption text-left">Invoice Name</div>
							<div class="caption c-gray text-left m-top-5">Invoice company name</div>
						</div>
						<div class="col-lg-6">
							<div class="input-box">
								<input type="text" name="invoice_name" placeholder="ex. Luxx Inc.">
							</div>
						</div>
					</div>
				</div>
				<div class="input-form-box">
					<div class="row">
						<div class="col-lg-6">
							<div class="caption text-left">Invoice E-mail</div>
							<div class="caption c-gray text-left m-top-5">Invoice company email</div>
						</div>
						<div class="col-lg-6">
							<div class="input-box">
								<input type="email" name="invoice_email" placeholder="ex. contact@luxx.com">
							</div>
						</div>
					</div>
				</div>
				<div class="input-form-box">
					<div class="row">
						<div class="col-lg-6">
							<div class="caption text-left">Invoice Address</div>
							<div class="caption c-gray text-left m-top-5">Invoice company address</div>
						</div>
						<div class="col-lg-6">
							<div class="input-box">
								<input type="text" name="invoice_address" placeholder="ex. Street 10, City, Country">
							</div>
						</div>
					</div>
				</div>
				<div class="input-form-box">
					<div class="row">
						<div class="col-lg-6">
							<div class="caption text-left">Invoice Phone</div>
							<div class="caption c-gray text-left m-top-5">Invoice company phone</div>
						</div>
						<div class="col-lg-6">
							<div class="input-box">
								<input type="text" name="invoice_phone" placeholder="ex. 0123456789">
							</div>
						</div>
					</div>
				</div>
				<div class="input-form-box">
					<div class="row">
						<div class="col-lg-6">
							<div class="caption text-left">Admin E-mail</div>
							<div class="caption c-gray text-left m-top-5">Administrator e-mail</div>
						</div>
						<div class="col-lg-6">
							<div class="input-box">
								<input type="text" name="admin_email" placeholder="ex. admin@luxx.com">
							</div>
						</div>
					</div>
				</div>

				<div class="m-top-50">
					<button type="submit" name="submit_install" class="btn b-secondary c-primary">Finish Installation</button>
				</div>
			</form>
		</div>
	</div>

	<script type="text/javascript">
		<?php if(isset($_GET['s'])): ?>
			$('#section-1').hide();
			$('#section-2').show();
		<?php endif; ?>
		$('#startInstallationButton').on('click', function() {
			$('#section-1').hide();
			$('#section-2').show();
		});
	</script>
</body>
</html>