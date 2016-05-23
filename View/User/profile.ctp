<!--上傳資料-->
<?php
	$db = mysqli_connect();
	if (!$db)	die("錯誤: 無法連接MySQL伺服器!" . mysqli_connect_error());
	mysqli_select_db($db, "test") or die("錯誤: 無法選擇資料庫!" . mysqli_error($db));

	$msg = "";
	
	// 是否有上傳檔案資料
	if (isset($_FILES["file"])) 
	{  
    	$namePic=$_POST["newPicName"];
    	//設置存儲目錄
    	$dir = "uploadPic/";
    	if(!is_dir($dir))	mkdir($dir);
    	//獲取new編碼ID
    	$sql_newID = "select auto_increment from information_schema.tables 
    			where table_schema='test' and table_name='pics'";
    	$result = mysqli_query($db,$sql_newID);
    	$row = $result->fetch_row();
    	$id = $row[0] ;
    	//獲取副檔名
    	preg_match("/[a-zA-z0-9]+$/", $_FILES["file"]["type"],$matchs);
    	//建立檔名
    	$_FILES["file"]["name"] = $id.".".$matchs[0];

    	//儲存上傳的檔案, 即複製成上傳檔案的檔名
		if ( $namePic && copy($_FILES["file"]["tmp_name"], $dir.$_FILES["file"]["name"])) 
		{
			
			$newPicName = $_POST["newPicName"];
			$size = getimagesize($_FILES['file']['tmp_name']);//尺寸
			$widthPic = $size[0];//寬度
			$heightPic = $size[1];//高度			
			$locPic = $_POST["newPicLoc"];//位置
			$authTypePic = $_POST["newPicAuthType"];//授權
			$typePic = $matchs[0];//副檔名
			$introPic = $_POST["newPicintro"];//描述
			$tagPic = $_POST["newPictag"];
			
			//插入至pic資料庫
			$sql_insertP = " insert into pics values
			(NULL,'".$newPicName."','". $dir.$id.".".$matchs[0]."','".$UserID."','".$introPic."','".$locPic."','".$widthPic."','".$heightPic."','".$authTypePic."','".$typePic."');";
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

			mysqli_close($db); // 關閉伺服器連接
			unlink($_FILES["file"]["tmp_name"]);  // 刪除上傳暫存檔案
			$msg = "檔案上傳成功";//顯示成功訊息
		}
		else $msg = "檔案上傳失敗，請填妥資料 ... ";
	}
?>
<!--sql link-->

<!-- wordcount -->
<script type="text/javascript"> 
function wordsCount() 
{
	var total = document.getElementById('intro').value.length; 
	document.getElementById('wordcount').innerHTML = 200-total;
}
</script>
<!-- wordcount -->

<!-- 顯示使用者身份、nav -->
<section>
	<div id="userweb-Header">
		<?php  
			echo "<font color=\"#FFFFFF\">　　$UserName  歡迎登入 : )　　|　　<a href=\"../../index.php\">回首頁</a></font>";
		?>
	</div>
</section>

<!-- 使用者頭像 -->
<section>
	<dir id="user-leftside">
		 <h3><?php echo"<font color=\"#20486f\">使用者名稱:$UserName</font>"?></h3>
	</dir>
</section>

<!-- 使用者資料、相簿、收藏、編輯功能-->
<div id="TabbedPanels1" class="TabbedPanels">
	<ul class="TabbedPanelsTabGroup">
		<li class="TabbedPanelsTab" tabindex="0">個人資料</li>
		<li class="TabbedPanelsTab" tabindex="0">相簿</li>
		<li class="TabbedPanelsTab" tabindex="0">收藏</li>
		<li class="TabbedPanelsTab" tabindex="0">上傳相片</li>
		<!-- 若上傳成功顯示＄msg-->
		<li >
			<?php 
				if (!empty($msg)) 
				{
  					echo "　<img src='../../webroot/img/3g5.gif'>　[　" . $msg . "　]　";
				}
			?>
		</li>
	</ul>
	<!-- 個人資料 -->
	<div class="TabbedPanelsContentGroup">
	   	<div class="TabbedPanelsContent" style="height: 500px">
	      	<p>輸入介紹文字1</p>
		</div>  
		<!-- 相簿 -->
		<div class="TabbedPanelsContent" style="height: 500px">
	      	<p>輸入介紹文字2</p>
		</div>  
		<!-- 收藏 -->
		<div class="TabbedPanelsContent" style="height: 500px">
	      	<p>輸入介紹文字3</p>
		</div>  
		<!-- 上傳 -->
		<div class="TabbedPanelsContent" style="height: 500px">
	  		<div class="UploadPic" style="margin-left:50px">
	    		<form action="" enctype="multipart/form-data" method="post">
	  				<input type="file" name="file" style="color:#000" /><br/><br/>
	  				<p>
	  					照片名稱：<br/>
							<input type="text" name="newPicName" id="newPicName" value=""/> <br/><br/>
						照片地點：<br/>
							<textarea type="text" name="newPicLoc" id="newPicLoc" style="BORDER-RIGHT: 2px dotted; BORDER-TOP: 2px dotted; OVERFLOW: hidden; BORDER-LEFT: 2px dotted; WIDTH: 230px; COLOR: #999;BORDER-BOTTOM: 2px dotted;HEIGHT: 40px"></textarea><br/><br/>
						授權型態：<br/>
							<select name="newPicAuthType" id="newPicAuthType">
								<option value="1">標示為允許再利用且可修改</option>
								<option value="2">標示為允許再利用</option>
								<option value="3">標示為允許已非商業用途再利用且可修改</option>
								<option value="4">標示為允許已非商業用途再利用</option>
							</select><br/><br/>
						照片簡述：(200字以內)	剩餘字數：<span id="wordcount">200</span><br/>
							<textarea maxlength="200" type="text" name="newPicintro" id="intro" onkeyup="wordsCount()" style="BORDER-RIGHT: 2px dotted; BORDER-TOP: 2px dotted; OVERFLOW: hidden; BORDER-LEFT: 2px dotted; WIDTH: 230px; COLOR:#999;BORDER-BOTTOM: 2px dotted;HEIGHT: 100px"></textarea><br/><br/>
						照片標籤：
							<input type="text" id="tagValue" placeholder="請輸入標籤">
							<input type="button" value="新增" onclick="add(PicTag)"><br/>
							<div id ="PicTag"></div>
							<legend id ="HiddenTag" name="PicTag" type = "hidden"></legend>
							<br/><br/>
						</p>
	  				<input type="submit" style="color:#000" value="上傳檔案" onclick="addH(PicTag,HiddenTag)" />
				</form>
	    	</div>
		</div> 
	</div>
</div>

<!-- 樣板 -->
<script type="text/javascript">
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
swfobject.registerObject("FlashID");
</script>

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
