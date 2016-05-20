<?php

class UserController extends AppController
{
	public $name = 'User';
	public $uses = array("User");

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
		//未登入禁止跳入任意profile頁面
		session_start();
		if(empty($_SESSION["userID"]))
		{
			header("Location:/demo/index.php");//直接跳入首頁
			exit;
		}
		//防止直接輸入網址跳入主要profile 或 他人profile
		if(empty($userID) || $_SESSION["userID"] !=  $userID)
		{
			header("Location:/demo/User/profile/".$_SESSION["userID"]);	//已登入則跳入個人頁面
			exit;
		}
		
		//向 View 傳遞參數
		$UserName = $_SESSION['username'];
		$UserID = $_SESSION['userID'];
		$this -> set('UserName',$UserName);
		$this -> set('UserID',$UserID);

		//設定頁面樣式
		$this -> layout = 'profile';
		$this -> set('title_for_page','Profile');
	}
}

?>