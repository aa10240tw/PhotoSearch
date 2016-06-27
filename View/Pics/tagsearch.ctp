<?php
	//連接資料庫
	$db = mysqli_connect("localhost","root","root2048");
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
	$sql = "";
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
		$sql_authType = " ";
	}
	else
	{
		$sql_authType = " and AuthType = ".$authType." ";
	}
	
	//搜尋
	if(!empty($search))
	{
		//標籤關鍵字
		$sql = "select * from pics , Pic_tag
				where pics.ID = Pic_tag.Pic_ID and 
				Pic_tag.tag_name = '".$search."'".$sql_authType.$sql_size."; ";
	}
	else
	{
		//標籤列表
		$sql = "select distinct Name from tag";
	}
	$result = mysqli_query($db,$sql);
?>

<div style="overflow: visible">
	<ul class="polaroids">
    <!-- 圖片顯示 -->
    <?php 
        if(empty($result))	echo "Error!";
        elseif(!empty($search))
        {
        	$show = mysqli_fetch_all($result,MYSQLI_NUM);
        	if(count($show)==0)
        	{
        		echo "No Search!";	
        	}
        	else
        	{
        		echo "<p>您所搜尋標籤為：".$search."</p>";
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
        }
        else
        {
        	echo "所有標籤列表";
        	$show = mysqli_fetch_all($result,MYSQLI_NUM);
        	for($i=0;$i<count($show);$i++)
        	{
				echo "<p><a href='tagsearch?q=".$show[$i][0]."&size=1&authType=1'>".$show[$i][0]."</a></p>";
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
        

        