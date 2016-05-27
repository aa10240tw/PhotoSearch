<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php echo $title_for_page ; ?></title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<!-- Latest compiled JavaScript -->
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,700,500,900' rel='stylesheet' type='text/css'>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<?php
		//echo $this->Html->css('style');
		//echo $this->Html->css('skel-noscript');
		//echo $this->Html->css('style-desktop');
		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('offcanvas.css');

		//echo $this->Html->script('skel-panels.min');
		//echo $this->Html->script('skel.min');
		//echo $this->Html->script('init');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<?php echo $this->Flash->render(); ?>
	<?php echo $this->fetch('content'); ?>
</body>
</html>
