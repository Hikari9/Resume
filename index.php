<?php

/**
 * Résumé Document
 * @author Rico Tiongson
 */

// inspiration: http://inspirationfeed.com/shop-2/30-sexy-resume-templates-guaranteed-to-get-you-hired/

include 'php/global.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset='UTF8'>
	<title>Rico Tiongson - Résumé</title>
	<?php source('https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js'); ?>
	<?php source('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'); ?>
	<?php source('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'); ?>
	<?php source('style.css'); ?>
	<?php source('fonts.css') ?>
	<?php source('main.js'); ?>
</head>
<body>
<div id='site' class='container'>
	<aside id='aside' class='aside' role='aside'>
		<div id='full-name' class='aside-title'>
			<span>Rico</span>
			<span>Tiongson</span>
		</div>
		<div class='aside-tab aside-description'>
			<span class='glyphicon glyphicon-stats'></span>
			<span id='job-title'>Data Scientist</span>
		</div>
	</aside>
	<main id='main' role='main'>
	</main>
</div>
</body>
</html>