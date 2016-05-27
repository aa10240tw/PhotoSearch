<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_page ; ?>
	</title>
	<!-- icon-->
	<link href="../../webroot/img/PhotoSearch.ico" rel="PhotoSearch icon" type='image/x-icon'>
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,700,500,900' rel='stylesheet' type='text/css'>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

	<link rel="stylesheet" href="css/style.css" />
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<!-- Latest compiled JavaScript -->
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	<link href="../../webroot/SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
	<link href="../../webroot/SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
	<link href="../../webroot/SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
	<link href="../../webroot/SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />
	<script src="../../webroot/SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
	<script src="../../webroot/SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
	<script src="../../webroot/SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
	<script src="../../webroot/SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
	<script src="../../webroot/Scripts/swfobject_modified.js" type="text/javascript"></script>

	<?php
		echo $this->Html->css('style');
		echo $this->Html->script('skel-panels.min');
		echo $this->Html->script('skel.min');
		echo $this->Html->script('init');
	?>
</head>
<body>
	<?php echo $this->Flash->render(); ?>
	<?php echo $this->fetch('content'); ?>
</body>
</html>
