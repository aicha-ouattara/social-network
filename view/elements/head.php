<!DOCTYPE html>

<html lang="en" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<base href="http://localhost/social-network/">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<meta http-equiv="expires" content="86400">
		<link rel="stylesheet" href="<?=CSS;?>network.css">
		<?php foreach ($this->cssList as $name): ?>
			<link rel="stylesheet" href="<?=CSS.$name?>">
		<?php endforeach; ?>
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>
		<script src="https://kit.fontawesome.com/9ddb75d515.js" crossorigin="anonymous"></script>
		<script src="http://localhost:443/socket.io/socket.io.js"></script>
		<script src="/social-network/assets/js/client.js"></script>
		<title><?=$this->pageTitle;?></title>
	</head>
	<body>
		<main>
