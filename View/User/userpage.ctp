<style>
  body {
      position: relative; 
  }
  .affix {
      top:0;
      width: 1000px;
      z-index: 9999 !important;
  }
  .navbar {
      margin-bottom: 0px;
  }

  .affix ~ .container-fluid {
     position: relative;
     top: 50px;
  }
  .container-fluid
  {
    //padding-left: 100px;
  }
  #section1 {padding-top:50px;padding-left:50px;height:auto;color: #44648E; background-color: rgba(215,232,233,0.4);}
  #section2 {padding-top:50px;padding-left:50px;height:auto;color: #44648E; background-color: rgba(215,232,233,0.4);}
  #description
    {
      text-align: left;
      margin: 5px 5px 5px 5px;
      padding-left: 10px;
      border:solid 1px;
      border-color: #413F3C;
      color:#413F3C;
      width: 350px;
      height:100px;
      border-radius: 255px 15px 225px 15px/15px 225px 15px 255px;
      padding-right:20px;
      padding-top:10px; 
      box-shadow:1px 1px 1px 1px #D9E4F5;
      background-color: rgba(255,255,255,0.5);

    }
    #body
    {
      margin-left: 150px;
      width:1000px;
      border-right: dashed 1px;
      border-left: dashed 1px;
      background: url(../images/blue.jpg) no-repeat center center;
    background-attachment: fixed;
    background-size: cover;
    }
</style>

<?php
  $db = mysqli_connect();
  if (!$db) die("錯誤: 無法連接MySQL伺服器!" . mysqli_connect_error());
  mysqli_select_db($db, "photosearch") or die("錯誤: 無法選擇資料庫!" . mysqli_error($db));
  $sql = "select * from user where ID = '$userID'";
  $result = mysqli_query($db,$sql);
  $userInfo = $result->fetch_row();
?>

<body id="body" data-spy="scroll" data-target=".navbar" data-offset="50">

<embed src="http://b1.rimg.tw/oei/c9e2386c.swf" width=100vw style="position: absolute; left: 0px; top: -100px" height="100px"; quality="high" wmode="transparent" align="RIGHT" bgcolor="#D6D6D6"></embed>

<div  class="container-fluid" 
  style="background-color:rgba(255,255,255,0);;color:#44648E; height:auto; padding-bottom:20px" >
  <div style="float:left">
  <br/>
  <?php
    echo '<img src="'.'../../webroot/'.$Proimg.'"'.'
                    alt = "Cinque Terre" class="img-thumbnail" 
                    style="border:solid 1px;width:150px ;height:auto;border-color: #8E8585;">'; 
  ?> 
  </div>
  <div style="float:left ;margin-left:50px;">
    <h2 style="text-shadow:2px 2px 2px #D9E4F5;"><?php echo $userInfo[2]?></h2>
    <h4><span class="glyphicon glyphicon-user"></span><?php echo"<font color=\"#413F3C\">　帳號<br/>　　$userInfo[0]</font>"?></h4>
    <h4><span class="glyphicon glyphicon-envelope"></span><?php echo"<font color=\"#413F3C\">　信箱<br/>　　". $userInfo[3] . "</font>"?></h4>            
  </div>
  <div style="float:left ;word-break: break-all;margin-left:50px;"> 
      <br/>
      <h4><span class="glyphicon glyphicon-pencil"></span><?php echo"<font color=\"#413F3C\">　介紹<br/></font>"?></h4>  
      <div id="description">
        <?php echo $userInfo[2] ?> 
      </div>
  </div> 
</div>

<nav class="navbar navbar-inverse" data-spy="affix" data-offset-top="197">
  <div class="container-fluid">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        </button>
        <a class="navbar-brand" href="index.php">Photo Search</a>
    </div>
    <div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li><a href="#section1">相簿</a></li>
          <li><a href="#section2">留言</a></li>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>    

<div id="section1" class="container-fluid" >
  <h1>相簿</h1>
  <div style="word-break: break-all;padding-left:10px">
  <?php
    $sql_showPic="SELECT * FROM pics WHERE Uploader='$userInfo[0]';";
    $result=mysqli_query($db,$sql_showPic);
    while ($row = $result->fetch_row()) 
    {
      echo "<span style=\"float:left;margin-right:30px;margin-bottom:30px;\"><a href=\"../../webroot/".$row[2]."\"><img src=\"../../webroot/".$row[2]."\" class=\"img-rounded\" alt=\"Cinque Terre\" width=\"auto\" height=\"150\" style=\"margin-top:10px;\"></a></span>"; 
    }
  ?>
  <br/>
  <br/>
  </div>
</div>
<div id="section2" class="container-fluid">
  <h1>留言</h1>
  <div id="disqus_thread" style="width:900px"></div>
<script>
    /**
     *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
     *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
     */
    /*
    var disqus_config = function () {
        this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
        this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
    };
    */
    (function() {  // DON'T EDIT BELOW THIS LINE
        var d = document, s = d.createElement('script');
        
        s.src = '//photosearch.disqus.com/embed.js';
        
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
<script id="dsq-count-scr" src="//photosearch.disqus.com/count.js" async></script>

</div>

<?php 
  mysqli_close($db); // 關閉伺服器連接
?>

</body>