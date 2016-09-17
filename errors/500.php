<!DOCTYPE HTML>
<html>
<head>
<?php include($site_root.'head-content.php');?>
</head>
<body>
<div class="headerBlock">
<?php 
	$_SESSION['module_name']='home';//This is need for the Header Current Class set on 15-05-2013 Ankur
	include($site_root.'header.php');
?>
</div>
<div class="wrapper cf">
  <div class="container cf">
   	  <div id="content">
        <h3>Error 404! Page not found</h3>
        <div class="historyBlog"><p>Requested page does not exists</p></div>
      </div>
  </div>
</div>
<?php include($site_root.'footer.php');?>
</body>
</html>