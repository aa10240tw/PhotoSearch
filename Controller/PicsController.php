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
		$this -> layout = 'search';
		$this -> set('title_for_page','KeySearch');
	}

	public function tagsearch()
	{
		$this -> layout = 'search';
		$this -> set('title_for_page','TagSearch');
	}

	public function profile()
	{
		$this -> layout = 'default';
		$this -> set('title_for_page','PicProfile');
	}
}

?>