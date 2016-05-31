<?php
	//連接資料庫
	$db = mysqli_connect();
	if (!$db) die("錯誤: 無法連接MySQL伺服器!" . mysqli_connect_error());
	mysqli_select_db($db, "photosearch") or  // 選擇資料庫
	  	die("錯誤: 無法選擇資料庫!" . mysqli_error($db));
	//接取表單
	if(empty($_GET))
	{
		header("Location:/demo/index.php");
		exit;
	}
	$search = $_GET['q'];
	$sql_searh = "";
	if(!empty($search))
	{
		$sql_searh = "(Descreption like '%$search%' or Title like '%$search%') and ";
	}
	$size = $_GET['size'];
	$sql_size = "";
	if($size == 2 || $size == 3)
	{
		$width = 1920;
		$height = 1080; 
		$sql_size = ($size == 2) ? " and width > ".$width." and height > ".$height." "  : 
					" and width between 800 and ".$width." and height between 600 and ".$height." ";
	}
	elseif($size == 4)
	{
		$width = 800;
		$height = 600;
		$sql_size = " and width < ".$width." and height < ".$height." ";
	}
	$authType = $_GET['authType'] - 1;
	if($authType == 0)
	{
		$sql_authType = " (AuthType = 1 or AuthType = 2 or AuthType = 3 or AuthType = 4)";
	}
	else
	{
		$sql_authType = " AuthType = ".$authType." ";
	}

	//搜尋
	
	$sql = "select * from pics where ".$sql_searh.$sql_authType.$sql_size."; ";
	$result = mysqli_query($db,$sql);
	$show = mysqli_fetch_all($result,MYSQLI_NUM);
?>
<div style="overflow: visible">
	<ul class="polaroids">
    <?php 
        //圖片顯示
        if(empty($show))	echo "No Search!";
        else
        {
        	echo "<p>您所搜尋的關鍵字為：".$search."</p>";	
			for($i=0; $i < count($show); $i++)
			{
				echo '<li>
					<a href="profile?varname='.$show[$i][0].'" title="'.$show[$i][1].'">
                        <img alt="Roeland!" src="../webroot/'.$show[$i][2].'">
                        </img>
                        <iframe width="0" height="0" name="actionframe" style="visibility:hidden;display:none"></iframe> <!--提交表單而不跳轉-->

                        <form action="'.$_SERVER['REQUEST_URI'].'" target="actionframe" method="post">
                        	<input type="hidden" name = "pid" value="'.$show[$i][0].'">
	                        <button class="btn btn-success" name="collect" type="submit">
					            收藏
					        </button>
					    </form>
                    </a>
                </li>';
			}
        }
		
	?>
	</ul>
</div>
<?php
	if(isset($_POST['collect']))
	{
		if( $_SESSION )
		{
			$userID = $_SESSION["userID"];
			$pid = $_POST['pid'];
			$sql_qq = "insert into collect values($pid,'$userID')";
			echo "<script>alert(\"".收藏成功."\")</script>";
			mysqli_query($db,$sql_qq);
		}
		else
		{

			echo "<script>alert(\"".請先登入."\")</script>";
			
			$url = "../User/login";
			echo "<script>window.open(\"$url\",\"_blank\")</script>";//跳轉login-in page
		}
	}
	mysqli_close($db);
?>

        

        
