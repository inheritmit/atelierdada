<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php _e(SITE_TITLE);?> :: Module not found</title>
<?php include($theme_path.'head-content.php');?>
</head>
<body>
<div class="wrapper cf">
  <div class="headerBlock">
	<?php include($theme_path.'header.php'); ?>
  </div>
  <div class="container cf">
   	  <div id="content">
        <h3>Error 404! Module not found (<strong><?php echo $module_name;?></strong>)</h3>
        <div class="historyBlog"><p>Requested page does not exists</p></div>
      </div>
  </div>
</div>
<?php include($theme_path.'footer.php');?>
</body>
</html>