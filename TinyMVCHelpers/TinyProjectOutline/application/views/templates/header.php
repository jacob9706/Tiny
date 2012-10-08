<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo !empty($title) ? $title : "No Page Title"; ?></title>
	<!-- Example of how to use the html class to link to a stylesheet. 
			Stylesheets are located in the project root under a folder called css -->
	<?php echo $html->create_link('css/styles.css'); ?>
</head>
<body>