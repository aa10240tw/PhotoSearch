<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

?>


<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_page ; ?>
	</title>
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,700,500,900' rel='stylesheet' type='text/css'>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

	<link href='pic/013.ico' rel='icon' type='image/x-icon'/>
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
