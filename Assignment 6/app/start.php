<?php
	define('ROOT', '/');
	ini_set('error_reporting', E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>TALink</title>
	<link rel="stylesheet" href="<?=ROOT?>index.css" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
	<?php include_once(__DIR__ . '/navbar.php'); ?>
	<div id="content-wrapper">
		<div id="sidebar"></div>
		<div id="content">
			