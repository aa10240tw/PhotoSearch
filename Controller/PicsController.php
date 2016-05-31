<?php

class PicsController extends AppController
{
	public $name = 'Pics';
	public $uses = array("Pics");

	public function index()
	{
		$this -> autoRender = FALSE;//不產生 view
		header("Location:/demo/index.php");
		exit;
	}

	public function keysearch()
	{
		session_start();
		$this -> layout = 'search';
		$this -> set('title_for_page','KeySearch');
	}

	public function tagsearch()
	{
		session_start();
		$this -> layout = 'search';
		$this -> set('title_for_page','TagSearch');
	}

	public function profile()
	{
		$this -> layout = 'imgprofile';
		$this -> set('title_for_page','PicProfile');
	}
	public function erprofile()
	{
		$this -> set('title_for_page','Error');
		$this -> autoRender = FALSE;
		echo "Sorry! This picture has been delete!";
		header("Refresh:1; url=/demo/index.php");
		exit;
	}
	public function Map()
	{
		$this -> layout = 'default';
		$this -> set('title_for_page','Map');
	}
}

?>