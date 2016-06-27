<!-- 連接資料庫 -->
<?php
	$db = mysqli_connect("localhost","root","root2048");
	if (!$db)	die("錯誤: 無法連接MySQL伺服器!" . mysqli_connect_error());
	mysqli_select_db($db, "photosearch") or die("錯誤: 無法選擇資料庫!" . mysqli_error($db));
?>

<!-- 剩餘字數 -->
<script type="text/javascript"> 
function wordsCount() 
{
	var total = document.getElementById('intro').value.length; 
	document.getElementById('wordcount').innerHTML = 200-total;
}
</script>

<!-- Header -->
<div id="userweb-Header" style="color: #000 ">
	<font color="#FFF">　　Photo Search　會員專區　|　<a href="../index.php" >首頁</a></font>
</div>
<!-- Header --> 

<!-- Main -->
<div id="main">
	<div class="container">
		<div class="row">
			<!-- 登入區域 -->
			<div id="sidebar" class="4u">
				<section>
					<header style="font-size: 16px">
						<span class="byline"><strong>已有帳戶登入</strong></span>	
					</header>
					<ul class="style">
  						<form method="post" action="">  
	 						<label for="user">帳號：</label>
	  							<input type="text" name="user" id="user" value=""/><br/>
	  						<label for="pass">密碼：</label>
	  							<input type="password" name="pass" id="pass" value=""/><br/><br/>
	  						<input type="submit" name="send" value="登入"/>
	  						<br/>
						</form>
					</ul>
					<!-- 登入與連接資料庫 -->
					<?php  
						session_start();
						if (isset($_POST["send"]))
						{
							$user=$_POST["user"];
							$pass=$_POST["pass"];
							$sql = "select * from user where id='$user' and password='$pass'";
							if($result=mysqli_query($db,$sql))
							{
								$num=$result->num_rows;
								if($num==1)
								{
									$row = $result -> fetch_array();
									$_SESSION["username"] = $row["Name"];
									$_SESSION["userID"] = $row["ID"];
									header("Location:/demo/index.php");
									exit;
								}
								else
								{
									echo "帳戶不存在或密碼錯誤";
								}   
							}
						}  						
					?>
				</section>
				<!-- 社交帳號連接 -->
				<section>
					<ul class="contact">
						<li><strong>[ 聯絡我們 ]</strong><br/></li>
						<ul class="style" style="font-size: 10px;">
							<li><a href="#" class="fa fa-twitter"><span>Twitter</span></a></li>
							<li class="active"><a href="https://www.facebook.com/ntnucsieclub/" class="fa fa-facebook"><span>Facebook</span></a></li>
							<li><a href="#" class="fa fa-tumblr"><span>Google+</span></a></li><br/>
						</ul>
					</ul>
				</section>
			</div>
				
			<!-- 註冊區域 -->
			<div id="content" class="8u skel-cell-important">
				<section>
					<header><h2>註冊新帳戶</h2></header>
					<p>註冊帳號前，請閱讀以下注意事項：</p>
					<li>請注意版權問題，勿上傳未授權之圖片</li>
					<li>請保管好帳號</li>
					<hr style="margin-top: 10px; margin-bottom: -70px ; width: 250px" />
					<form method="post" action="">  
						<label for="user">帳號：</label>
							<input type="text" name="newUser" id="newUser" value=""/><br/>
						<label for="pass">密碼：</label>
							<input type="password" name="newPass" id="newPass" value=""/><br/>
						<label for="pass">姓名：</label>
							<input type="text" name="newName" id="newName" value=""/><br/>
						<label for="email">信箱：</label>
							<input type="email" name="email" id="email" value=""/><br/>
						<label for="email">自我介紹 (200字以內)：</label><br/>
							<textarea maxlength="200" type="text" name="intro" id="intro" onkeyup="wordsCount()" style="BORDER-RIGHT: 2px dotted; BORDER-TOP: 2px dotted; OVERFLOW: hidden; BORDER-LEFT: 2px dotted; WIDTH: 230px; COLOR:#999;BORDER-BOTTOM: 2px dotted;HEIGHT: 100px"></textarea>
							<p>剩餘字數：<span id="wordcount">200</span></p><br/><br/>
						<input type="submit" name="sendnew" value="註冊"/>
					</form>
					<?php
						if(isset($_POST["sendnew"]))
						{
							$newUser=$_POST["newUser"];
							$sql_account="select * from user where id='$newUser'";
							if($result_1=mysqli_query($db,$sql_account))
							{
								$num=$result_1->num_rows;
								if($num>0)
								{
									echo "帳戶已存在，請重新命名 <br/>";
								}
								else
								{
									$newPass=$_POST["newPass"];
									$newName=$_POST["newName"];
									$email=$_POST["email"];
									$intro=$_POST["intro"];
									$Propic = "Propic/default.jpg";
									if($newPass && $newName && $email)
									{
										$sql_insert="insert into user values('$newUser','$newName','$intro','$email','$newPass','$Propic')";
										if($result_2=mysqli_query($db,$sql_insert))
										{
											echo "　<img src='../webroot/img/3g5.gif'> 恭喜，註冊成功 ! <br/>";	
										}
									}
									else
									{
										echo "資料尚未填完整<br/>";
									}
									
								}
							}
						}
						
						mysqli_close($db);  // 關閉伺服器連接
					?>
				</section>
			</div>
		</div>
	</div>
</div>
<!-- /Main -->