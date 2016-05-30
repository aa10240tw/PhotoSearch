<style>
	.fill
	{
	    max-width: 100%;
	    height: auto;
	}	
</style>

<?php
	$db = mysqli_connect();
	if (!$db) die("錯誤: 無法連接MySQL伺服器!" . mysqli_connect_error());
	mysqli_select_db($db, "photosearch") or die("錯誤: 無法選擇資料庫!" . mysqli_error($db));
	if(empty($_GET))
	{
		header("Location:/demo/index.php");
		exit;
	}
	$var_value = $_GET['varname'];
	$sql = "select * from pics where ID =".$var_value;
	$result = mysqli_query($db,$sql);
?>

<!-- Navigation Bar -->
<nav class="navbar navbar-fixed-top navbar-inverse">
	<div class = "text-center" style="color:white;">
		<h3><a href="../index.php" style="color:white;"> PhotoSearch </a></h3>
	</div>         
</nav>
        
<div class="container-fluid" style="height: 75vh;">
	<div class="col-md-1" ></div>
	<!-- Image Area -->
    <div class="col-md-6 text-right">            
		<?php
		$show = mysqli_fetch_all($result);
		if(empty($show))
		{
			header("Location:/demo/Pics/erprofile");
			exit;
		}
	    echo '<img src ="../webroot/'.$show[0][2].'" class="fill"/>';
		?>
    </div>
	<!-- Text Area-->
	<div class="col-md-4" >
		<div class="list-group">
		    <a href="#" class="list-group-item active">
		    	<h4 class="list-group-item-heading">標題</h4>
		      	<p class="list-group-item-text">
		      		<?php echo $show[0][1]; ?>
		      	</p>
		      	<?php echo '#'.$show[0][0]; ?>
		    </a>
		    <?php $uploader = "../User/userpage/".$show[0][3]; ?>
		    <a href= <?php  echo $uploader ?> class="list-group-item">
		      	<h4 class="list-group-item-heading">上傳者</h4>
		      	<p class="list-group-item-text">
		      		<?php echo $show[0][3]; ?>
		      	</p>
		    </a>
		    <a href="#" class="list-group-item">
		      	<h4 class="list-group-item-heading">圖片資訊</h4>
		      	<p class="list-group-item-text">
		      		<?php echo $show[0][6].' x '.$show[0][7].' pixels'; ?>
		      	</p>
		      	<p class="list-group-item-text">
		      		<?php echo $show[0][9]; ?>
		      	</p>
		    </a>

		    <a href="#" class="list-group-item" style="color:#CCFF99;background-color:#5cb85c;" onclick="myFunction()" >
		    	<h4 class="list-group-item-heading" style="color:white;">拍攝地點</h4>
		      	<p class="list-group-item-text">
		        	<img src='../webroot/img/locicon.png' height ="25px" width="25px"/>
		      	<?php echo $show[0][5]; ?>
		      	</p>
		    </a>

		    <a href="#" class="list-group-item">
		      	<h4 class="list-group-item-heading">圖片描述</h4>
		      	<p class="list-group-item-text">
		      		<?php echo $show[0][4]; ?>
		      	</p>
		    </a>
		    <a href="#" class="list-group-item">
		      	<h4 class="list-group-item-heading">圖片標籤</h4>
		      	<?php
		      		$var_value = $_GET['varname'];
					$sql = "select * from pic_tag where Pic_ID =".$var_value;
					$tagResult = mysqli_query($db,$sql);
					$tagShow = mysqli_fetch_all($tagResult,MYSQL_NUM);
					for($i = 0; $i < count($tagShow) ; $i++)
					{
						echo "<span class='list-group-item-text'> #".$tagShow[$i][1]."</span>";
					}
		      	?>
		    </a>
    	</div>
	</div>
    <div class="col-md-1" ></div>       	
</div>

<script type="text/javascript">
function myFunction()
{
    var params = [
        'height='+600,
        'width='+600,
        'fullscreen=yes' // only works in IE, but here for completeness
    ].join(',');
    // and any other options from
    // https://developer.mozilla.org/en/DOM/window.open

    var addr = 'map?varname='.concat(<?php echo $var_value; ?>)
    var popup = window.open(addr, 'popup_window', params); 
    popup.moveTo(0,0);
}    
</script>
        
    

