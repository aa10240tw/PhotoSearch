<?php
	//連接資料庫
	$db = mysqli_connect("localhost", "root", "root2048");
	if (!$db) die("錯誤: 無法連接MySQL伺服器!" . mysqli_connect_error());
	mysqli_select_db($db, "test") or  // 選擇資料庫
	  	die("錯誤: 無法選擇資料庫!" . mysqli_error($db));
	//接取表單
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
		$sql_size = ($size == 2) ? " and width >= ".$width." and height >= ".$height." "  : 
					" and width between 800 and ".$width." and height between 600 and ".$height." ";
	}
	elseif($size == 4)
	{
		$width = 800;
		$height = 600;
		$sql_size = " and width < ".$width." and height < ".$height." ";
	}
	$authType = $_GET['authType'];
	//搜尋
	$sql = "select image from pics where ".$sql_searh."AuthType = ".$authType.$sql_size."; ";
	$result = mysqli_query($db,$sql);
?>

<div class="l-container">
    <div class="photos" data-row-grid='{"minMargin":5,"maxMargin":5,"itemSelector":".photo-item","firstItemClass":"first-item","lastRowClass":"last-row","resize":true,"minWidth":426}'>
    <?php 
        //圖片顯示
        if(empty($result))	echo "No Search!";
        else
        {
        	$show = mysqli_fetch_all($result,MYSQLI_NUM);	
			for($i=0; $i < count($show); $i++)
			{
				echo '<article class="photo-item" style="width: 459px; height: =306px;">
	                <a href="https://www.pexels.com/photo/nature-sunny-field-sun-97778/" >
	            	<img height= "350px"  src="../webroot/'.$show[$i][0].'" style="background:rgb(98,108,75)" ></img>
	            	</a>
	                <button class="btn-like btn-like--small photo-item__info">
	                    <svg class="icon-heart" viewbox="0 0 100 100">
	                        <use xlink:href="#iconHeart">
	                        </use>
	                    </svg>
	                </button>
	                </article>';
			}
        }
		mysqli_close($db);
	?>
	</div>
</div>
        
<svg class="hidden">
    <defs>
        <path d="M84.417 38.466c0 5.63-2.407 10.7-6.248 14.233L50 80.866 21.832 52.7c-3.842-3.535-6.25-8.604-6.25-14.234 0-10.677 8.656-19.333 19.334-19.333 5.492 0 10.45 2.29 13.97 5.968.39.41.763.834 1.114 1.274.354-.44.725-.865 1.115-1.273 3.52-3.676 8.478-5.967 13.97-5.967 10.677 0 19.332 8.656 19.332 19.333z" id="iconHeart">
        </path>
    </defs>
</svg>
        
