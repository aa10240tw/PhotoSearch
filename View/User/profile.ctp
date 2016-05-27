<?php
	$db = mysqli_connect("localhost","root","root2048");
	if (!$db)	die("錯誤: 無法連接MySQL伺服器!" . mysqli_connect_error());
	mysqli_select_db($db, "photosearch") or die("錯誤: 無法選擇資料庫!" . mysqli_error($db));
?>
<?php
	$msg = "";
	// 是否有上傳檔案資料
	if (isset($_FILES["upload"])) 
	{  
    	$namePic=$_POST["newPicName"];
    	//設置存儲目錄
    	$dir = "uploadPic/";
    	if(!is_dir($dir))	mkdir($dir);
    	//獲取new編碼ID
    	$sql_newID = "select auto_increment from information_schema.tables 
    					where table_schema='photosearch' and table_name='pics'";
    	$result = mysqli_query($db,$sql_newID);
    	$row = $result->fetch_row();
    	$id = $row[0] ;
    	//獲取副檔名
    	preg_match("/[a-zA-z0-9]+$/", $_FILES["upload"]["type"],$matchs);
    	//建立檔名
    	$_FILES["upload"]["name"] = $id.".".$matchs[0];
    	//儲存上傳的檔案, 即複製成上傳檔案的檔名
		if ( $namePic && copy($_FILES["upload"]["tmp_name"], $dir.$_FILES["upload"]["name"])) 
		{
			
			$newPicName = $_POST["newPicName"];
			$size = getimagesize($_FILES['upload']['tmp_name']);//尺寸
			$widthPic = $size[0];//寬度
			$heightPic = $size[1];//高度			
			$locPic = $_POST["newPicLoc"];//位置
			$authTypePic = $_POST["newPicAuthType"];//授權
			$typePic = $matchs[0];//副檔名
			$introPic = $_POST["newPicintro"];//描述
			$tagPic = $_POST["newPictag"];
			
			//插入至pic資料庫
			$sql_insertP = " insert into pics values (NULL,'".$newPicName."','". $dir.$id.".".$matchs[0]."','".$UserID."','".$introPic."','".$locPic."','".$widthPic."','".$heightPic."','".$authTypePic."','".$typePic."');";
			mysqli_query($db,$sql_insertP);

			//檢索並插入標籤
			if(!empty($tagPic))
			{
				for($i=0;$i<count($tagPic);$i++)
				{
					$result = mysqli_query($db,"select Name from Tag where Name == ".$tagPic[$i]);
					if(empty($result))
					{
						$sql_insertT = " insert into Tag values('".$tagPic[$i]."');";
						mysqli_query($db,$sql_insertT);
					}
				}
			}
			
			//新增關聯
			for($i=0;$i<count($tagPic);$i++)
			{
				$result = mysqli_query($db,"select Name from Tag where Name == ".$tagPic[$i]);
				if(empty($result))
				{
					$sql_insert = " insert into Pic_tag values(".$id.",'".$tagPic[$i]."')";
					mysqli_query($db,$sql_insert);
				}
			}
			unlink($_FILES["upload"]["tmp_name"]);  // 刪除上傳暫存檔案
			$msg = "檔案上傳成功";//顯示成功訊息
		}
		else $msg = "檔案上傳失敗，請填妥資料 ... ";
	}
?>
<!--sql msg-->
<?php 
	if (!empty($msg)) 
	{
		echo "<script language=\"JavaScript\">	window.alert('$msg');	</script>";
	}
?>
<!--sql msg-->

<!--sql-update-->
<?php


if(isset($_POST["update"]))
{

	$Update_msg = "";

	$newPass=$_POST["newPass"];
	$newName=$_POST["newName"];
	$email=$_POST["email"];
	$intro=$_POST["intro"];

	if($newName)
	{
		$sql_update="UPDATE User SET Name = '$newName' WHERE ID='$UserID' ";
		mysqli_query($db,$sql_update);
	}
	if($newPass)
	{
		$sql_update="UPDATE User SET Password = '$newPass' WHERE ID='$UserID' ";
		mysqli_query($db,$sql_update);
	}
	if($email)
	{
		$sql_update="UPDATE User SET  Mail= '$email' WHERE ID='$UserID' ";
		mysqli_query($db,$sql_update);

	}
	if($intro)
	{
		$sql_update="UPDATE User SET  Descreption= '$intro' WHERE ID='$UserID' ";
		mysqli_query($db,$sql_update);

	}

	if(isset($_FILES["Pic"]))
	{
		$dir = "ProPic/";
		//獲取副檔名
    	preg_match("/[a-zA-z0-9]+$/", $_FILES["Pic"]["type"],$matchs);
    	//建立檔名
    	$_FILES["Pic"]["name"] = $UserID.".".$matchs[0];

		if ( copy($_FILES["Pic"]["tmp_name"], $dir.$_FILES["Pic"]["name"])) 
		{
			$sql_update="UPDATE User SET  ProPic = '".$dir.$_FILES["Pic"]["name"]."' WHERE ID='$UserID' ";
			mysqli_query($db,$sql_update);
		}
		unlink($_FILES["Pic"]["tmp_name"]);  // 刪除上傳暫存檔案
	}
}

?>
<!--sql-update-->

<!--deletePic-->
<?php
	if(isset($_POST["delete"]))
	{
		$picID=$_POST['picID'];
		$sql_Pic = "select Type from pics WHERE ID ='$picID'";
		$type = mysqli_query($db,$sql_Pic);
		$typeRow = $type -> fetch_row();
		$sql_deleteFile="select image from pics WHERE ID ='$picID'";
		$result=mysqli_query($db,$sql_deleteFile);
		if($result)
		{
			$dir = "../webroot/uploadPic/";
			$img =  $dir.$picID.".".$typeRow[0];
			echo $img;
			unlink($img);//將檔案刪除
			$sql_deletePic="delete from pics WHERE ID ='".$picID."'";
			$result=mysqli_query($db,$sql_deletePic);
			echo "<script language=\"JavaScript\">window.alert('成功刪除圖片');</script>";
		}
		else
		{
			echo "<script language=\"JavaScript\">window.alert('成功刪除失敗');</script>";
		}
	}
?>
<!--deletePic-->

<!--content-->
<body id="userweb-body" >
	<section>
		<div id="userweb-Header">
			<nav class="navbar navbar-inverse navbar-fixed-top" style="height:15px;">
 				<div class="container-fluid">
    				<div class="navbar-header">
     					<a class="navbar-brand" href="../../index.php">PhotoSearch</a>
    				</div>
    				<ul class="nav navbar-nav navbar-right" style="padding-right:50px">
      					<li>
      						<a href="#" data-toggle="dropdown" >
      							<?php
      								echo '<img src="'.'../../webroot/'.$Proimg.'"'.'
    								alt = "Cinque Terre" class="img-rounded" width="25" width="25" '
      							?> 			
      						</a>
      						<ul class="dropdown-menu">
      							<li><a href="../../User/logout"><span class="glyphicon glyphicon-log-in">登出</span></a></li> </ul>
     					</li>		
   					</ul>
				</div>
			</nav>
		</div>
	</section>

	<div class="container-fluid" style="padding-top:50px;">
		<h1>　　Photo Search 個人管理</h1>
		<div class="row" style="padding-right:100px;">
			<div class="col-sm-4" style="padding-left:120px;" >
				<section>
					<?php
						$sql_ID = "select * from User where ID='".$UserID."'";
						$result=mysqli_query($db,$sql_ID);
						$row = $result->fetch_assoc();
					?>
					<div id = "profilePic">
						<br/>
						<?php 
							echo '<img src="'.'../../webroot/'.$Proimg.'"'.'
    								alt = "Cinque Terre" class="img-thumbnail" 
    								style="border:solid 1px;width:150px ;height:auto;border-color: #8E8585;">'; 
      					?> 		
					</div>		

					<h2><?php echo $row["Name"]?></h2>
					<br/>
					<p><span class="glyphicon glyphicon-user"></span><?php echo"<font color=\"#615F5F\">　帳號<br/>　　$UserID</font>"?></p>
					<p><span class="glyphicon glyphicon-envelope"></span><?php echo"<font color=\"#615F5F\">　信箱<br/>　　". $row["Mail"] . "</font>"?></p> 
					<p><span class="glyphicon glyphicon-pencil"></span><?php echo"<font color=\"#615F5F\">　介紹<br/></font>"?></p>  
					<div id="user-leftside" style="word-break: break-all;padding-right:10px;"> 
						<?php echo $row["Descreption"] ?> 
					</div> 
				</section>
			</div>
			<div class="col-sm-8" >
				<section>
					<div id=option>
						<ul class="nav nav-tabs" style="border-color:#194989;">
							<li class="active"><a data-toggle="tab" href="#menu0">個人資料</a></li>
							<li><a data-toggle="tab" href="#menu1">相簿管理</a></li>
							<li><a data-toggle="tab" href="#menu2">上傳圖片</a></li>
							<li><a data-toggle="tab" href="#menu3">收藏圖片</a></li>
						</ul>
						<div class="tab-content">
							<div id="menu0" class="tab-pane fade in active">
								<br/>
								<div class="well" >
								<h1>更新個人資料</h1><br/>
									<form method="post" action="" enctype="multipart/form-data"> 
										<input type="file" name="Pic" style="color:#000" /><br/>
										<label for="pass" >密碼：</label>
			  								<input type="password" class="form-control" name="newPass" id="newPass" placeholder="新密碼"/>
			  							<br/>
			  							<label for="pass">姓名：</label>
			  								<input type="text" class="form-control" name="newName" id="newName" placeholder="新名稱"/><br/>		

								  		<label for="email">信箱：</label>
			  								<input type="text" class="form-control" name="email" id="email" value=""/><br/>
			  							<label for="email">自我介紹 (200字以內)：</label><br/>
			  								<textarea type="text" class="form-control" name="intro" id="intro" style="BORDER-RIGHT: 2px dotted; BORDER-TOP: 2px dotted; OVERFLOW: hidden; BORDER-LEFT: 2px dotted; WIDTH: 230px; COLOR: #999;BORDER-BOTTOM: 2px dotted;HEIGHT: 100px"></textarea><br/>
		      							<input type="submit" class="btn btn-default" name="update" value="更新"/><br/><br/>
		      						</form>
								</div>
							</div>
							
							<!--管理相簿-->
							<div id="menu1" class="tab-pane fade">
								<br/>
								<div class="well" style="word-break: break-all;padding-right:10px;">
								<?php
									$sql_searchPic="SELECT * FROM pics WHERE Uploader='$UserID';";
									$result=mysqli_query($db,$sql_searchPic);
									while ($row = $result->fetch_row()) 
									{
										echo "<span style=\"float:left;\">
											  <img src=\"../../webroot/".$row[2]."\" class=\"img-rounded\" width=\"auto\" height=\"150\" style=\"margin-top:10px;\">
											  	<br/><br/>
											  	<form method=\"post\" action=\"\">
											  		<input type=\"hidden\" value=\"".$row[0]."\" name=\"picID\">
													<input type=\"submit\" class=\"btn btn-primary\" name=\"delete\" value=\"刪除\">".$row[1]."</input> 
												</form>　
											</span>";	
									}
								?>
								</div>
							</div>

							<div id="menu2" class="tab-pane fade">
								<br/>
								<div class="well" >
									<h1>上傳檔案</h1><br/>
        							<form action="" enctype="multipart/form-data" method="post">
      									<input type="file" name="upload" style="color:#000" /><br/>
						  				<p>
						  					照片名稱：<br/>
												<input type="text" class="form-control" name="newPicName" id="newPicName" value=""/> <br/>
											照片地點：<br/>
												<textarea class="form-control" type="text" name="newPicLoc" id="newPicLoc" ></textarea><br/>
											授權型態：<br/>
												<select class="form-control" name="newPicAuthType" id="newPicAuthType">
													<option value="1">標示為允許再利用且可修改</option>
													<option value="2">標示為允許再利用</option>
													<option value="3">標示為允許已非商業用途再利用且可修改</option>
													<option value="4">標示為允許已非商業用途再利用</option>
												</select><br/><br/>
											照片簡述：(200字以內)	剩餘字數：<span id="wordcount">200</span><br/>
												<textarea  ="form-control" maxlength="200" type="text" name="newPicintro" id="intro" onkeyup="wordsCount()" style="BORDER-RIGHT: 2px dotted; BORDER-TOP: 2px dotted; OVERFLOW: hidden; BORDER-LEFT: 2px dotted; WIDTH: 230px; COLOR:#999;BORDER-BOTTOM: 2px dotted;HEIGHT: 100px"></textarea><br/><br/>
											照片標籤：
												<input class="btn btn-default" type="text" id="tagValue" placeholder="請輸入標籤">
												<input class="btn btn-default" type="button" value="新增" onclick="add(PicTag)"><br/>
												<div id ="PicTag"></div>
												<legend id ="HiddenTag" name="PicTag" type = "hidden"></legend>
												<br/>
											</p>
	  									<input class="btn btn-default" type="submit" style="color:#000" value="上傳檔案" onclick="addH(PicTag,HiddenTag)" /><br/><br/>
    								</form>
								</div>
							</div>
							<div id="menu3" class="tab-pane fade">
								<br/>
								<div class="well" >Basic Well 4</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
<body>


<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});
</script>

<?php 
	mysqli_close($db); // 關閉伺服器連接
?>


<!-- wordcount -->
<script type="text/javascript"> 
function wordsCount() 
{
	var total = document.getElementById('intro').value.length; 
	document.getElementById('wordcount').innerHTML = 200-total;
}
</script>
<!-- wordcount -->

<!-- 新增標籤 -->
<script type="text/javascript">

function add(obj)
{
  var newElement = document.createElement("div");
  var tag = document.getElementById("tagValue").value;
  //設定這個input的屬性
  //newElement.disabled="disabled";
  newElement.name = "newPictag[]";
  newElement.innerHTML = "#" + tag;
  newElement.style = "margin-right:10px;font-size:15px;display:inline-block;";
  newElement.setAttribute('onmouseover', ' this.style = "margin-right:10px;font-size:15px;display:inline-block;text-decoration:line-through;"');
  newElement.setAttribute('onmouseout', ' this.style = "margin-right:10px;font-size:15px;display:inline-block;"');
  newElement.setAttribute('ondblclick', 'this.parentNode.removeChild(this);');
  //最後再使用appendChild加到要加的元素裡
  obj.appendChild(newElement);
  document.getElementById("tagValue").value = "";
}

function addH(objD,objH)
{
	for (i = 0;i < objD.children.length;i++) 
	{
        var newElement = document.createElement("input");
        newElement.name = "newPictag[]";
        newElement.type = "hidden";
        newElement.value = objD.children[i].innerHTML.substr(1);
        objH.appendChild(newElement);
    }
}
</script>
