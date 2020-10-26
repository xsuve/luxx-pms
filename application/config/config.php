<?php

// Errors
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Database
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost:3306');
define('DB_NAME', 'luxx_db');
define('DB_USER', 'root');
define('DB_PASS', 'root');

// General
define('THEME', 'Luxx');
define('URL', 'http://localhost/luxx/');

// Invoice
define('INVOICE_NAME', 'Mouple Inc.');
define('INVOICE_EMAIL', 'contact.mouple@gmail.com');
define('INVOICE_ADDRESS', 'Street 10, Romania');
define('INVOICE_PHONE', '012 345 6789');

// Platform
define('TIMEZONE', 'Europe/Bucharest'); // https://www.php.net/manual/en/timezones.php
define('CURRENCY', 'USD');
define('CURRENCY_SYMBOL', '$');
define('ADMIN_EMAIL', 'contact.mouple@gmail.com');
define('ATTACHMENT_MAX_SIZE', 20000000); // 20000000 B -> 20 MB

// PayPal
define('PAYPAL_SANDBOX', 1); // 1 -> Sandbox, 0 -> Live
define('PAYPAL_SANDBOX_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr');
define('PAYPAL_LIVE_URL', 'https://www.paypal.com/cgi-bin/webscr');
define('PAYPAL_EMAIL', 'contact.mouple@gmail.com');
define('PAYPAL_CLIENT_ID', 'ASqb_1bFQm9tutWJ99UNH1cWHvgNsic0M_qdvmvWR88yz7xnxGOpq8rxHDYEez0UJw96YoTnQ1SYjqf4');
define('PAYPAL_CLIENT_SECRET', 'EKN15XO98chu5-3KNaWa13ifwELkR40olxJNxxJCp8ojF8c0y7O2PX0lTxksi-ebyjg0thUDzmz8VBeE');

?>