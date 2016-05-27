<?php

class UserController extends AppController
{
	public $name = 'User';
	public $uses = array("User");

	public function index()
	{
		header("Location:/demo/index.php");//直接跳入首頁
		exit;
	}

	public function login()
	{
		//設定頁面樣式
		$this -> layout = 'default';
		$this -> set('title_for_page','Login');
	}

	public function logout()
	{
		
		$this -> autoRender = FALSE;//不產生 view
		//清除 SESSION
		session_start();
		unset($_SESSION['username']);
		unset($_SESSION["userID"]);
		header("Location:/demo/index.php");
		exit;
	}

	public function profile($userID = '')
	{
		//防止直接輸入網址跳入主要profile 
		if(empty($userID) )
		{
			
			header("Location:/demo/index.php");//直接跳入首頁
			exit;
		}
		
		//禁止跳入任意profile頁面、跳轉到userpage
		session_start();
		if(empty($_SESSION)  || $_SESSION["userID"] !=  $userID )
		{
			header("Location:/demo/User/userpage/".$userID);
			exit;
		}

		//向 View 傳遞參數
		$UserName = $_SESSION['username'];
		$UserID = $_SESSION['userID'];
		$this -> set('UserName',$UserName);
		$this -> set('UserID',$UserID);

		//設定頭貼
		$db = mysqli_connect();
      	if (!$db) die("錯誤: 無法連接MySQL伺服器!" . mysqli_connect_error());
     	mysqli_select_db($db, "photosearch") or die("錯誤: 無法選擇資料庫!" . mysqli_error($db));
      	$sql = "select * from user where ID = '$UserID'";
      	$result = mysqli_query($db,$sql);
      	$userInfo = $result->fetch_row();
      	$this -> set('Proimg',$userInfo[5]);

		//設定頁面樣式
		$this -> layout = 'profile';
		$this -> set('title_for_page',$userInfo[1].'-Profile');

		mysqli_close($db);
	}

	public function UserPage($userID = '')
	{
		if(empty($userID))
		{
			header("Location:/demo/index.php");//直接跳入首頁
			exit;
		}
		
		
		//連接資料庫
		$db = mysqli_connect();
      	if (!$db) die("錯誤: 無法連接MySQL伺服器!" . mysqli_connect_error());
     	mysqli_select_db($db, "photosearch") or die("錯誤: 無法選擇資料庫!" . mysqli_error($db));
      	
      	$sql = "select * from user where ID = '$userID'";
      	$result = mysqli_query($db,$sql);
      	$userInfo = $result->fetch_row();
		
		session_start();
      	if(empty($userInfo))
      	{
      		header("Location:/demo/index.php");//直接跳入首頁
      		exit;
      	}
      	else
      	{
      		//設定參數
			$this -> set('title_for_page',$userInfo[2]." - Photo Search");
			$this -> set('userID',$userID);
			$this -> set('Proimg',$userInfo[5]);
      	}
      	
		//設定頁面樣式
		$this -> layout = 'profile';
		mysqli_close($db);
	}
}
?>