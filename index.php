<?php

/*
if( ! empty( $_SERVER['HTTP_REFERER'] ) ) {
	if( FALSE !== strstr( $_SERVER['HTTP_REFERER'], 'codecanyon.net' ) ) {
		?>
<!DOCTYPE html>
<html>
	<head>
		<script>window.top.location.href = "http://xsuve.com/demo/luxx/";</script>
	</head>
	<body></body>
</html>
		<?php
		exit;
	}
}
*/

/**
 * Name: Luxx
 * Developer: xsuve
**/

if(file_exists('install.php')) {
	header('location: install.php');
} else {
	require 'application/config/config.php';

	require 'application/libs/application.php';
	require 'application/libs/controller.php';

	$app = new Application();
}

?>