<div class="homepage">
<?php 
session_start();
if( $_SESSION )
{
	$username = $_SESSION["username"];
	$userID = $_SESSION["userID"];
	$account = "User/profile/";
	$msg = '<li><a>Hello,</a>
			<a href =' . $account . $userID . '>'.$username. '</a></li>
			<li><a href= "User/logout">登出</a></li>';
}
else
{
	$msg = '<li><a href="User/login">登入</a></li>';
}
?>
<!-- Header -->
	<div id="header">
		<!--flashStart-->
		<embed src="http://b1.rimg.tw/oei/c9e2386c.swf" width=100% style="position: absolute; left: 0px; top: -20px" height="400"; quality="high" wmode="transparent" align="RIGHT" bgcolor="#D6D6D6"></embed>
		<!--flashEnd-->
		
		<!-- NavStart -->
		<div id="nav-wrapper"> 
			
			<nav id="nav">
				<ul>
					<li class="active"><a href="index.php">首頁</a></li>
					<?php echo $msg ?>
				</ul>
			</nav>
		</div>
		<!-- NavEnd -->

		<div class="container"> 
			
			<!-- Logo -->
			<div id="logo">
				<h1><a href="#">Photo Search</a></h1><br/>
				<span class="tag">
					<form method="get" action="" name="search">
						<input type="search" name="q" id="search" value=""/></input>
						<div style="display:inline;">
  							<input type="submit" onclick="document.search.action='Pics/keysearch'" id="keySubmit" value="關鍵字搜尋" />
  							<input type="submit" onclick="document.search.action='Pics/tagsearch'" id="tagSubmit" value="標籤搜尋" />
  						</div>
  					<br/>
						<select name="size" id="size">
							<option value="1">尺寸無限制</option>
							<option value="2">大</option>
							<option value="3">中</option>
							<option value="4">小</option>
						</select>

						<select name="authType" id="authType">
							<option value="1">不限使用權</option>
							<option value="2">標示為允許再利用且可修改</option>
							<option value="3">標示為允許再利用</option>
							<option value="4">標示為允許已非商業用途再利用且可修改</option>
							<option value="5">標示為允許已非商業用途再利用</option>
						</select>
  					<br/>
  					</form>
				</span>
			</div>
			<!--- Logo -->
		</div>
	</div>

<!-- Featured -->

<!-- Main -->

<!-- Footer -->
	<div id="footer">
		<ul class="contact" style="font-size: 10px">
			<li><a href="#" class="fa fa-twitter"><span>Twitter</span></a></li>
			<li class="active"><a href="https://www.facebook.com/ntnucsieclub/" class="fa fa-facebook"><span>Facebook</span></a></li>
			<li><a href="#" class="fa fa-tumblr"><span>Google+</span></a></li>
			<span class="tag">&emsp;&emsp;© NTNU CSIE</span>
		</ul>
	</div>

<!-- php -->
</div>
