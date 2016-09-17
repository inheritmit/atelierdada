<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html lang="en">
<head>
<title><?php _e(SITE_TITLE);?> :: <?php echo @$page_data['title'];?></title>
<?php include($theme_path.'head-content.php');?>

</head>
<body>
<section id="container" class="">
  <?php include($theme_path.'header.php');?>
  <section id="main-content">
  	<section class="wrapper site-min-height">

      <?php
      if(isset($_SESSION[PF.'MSG']) && $_SESSION[PF.'MSG'] != ""){?>
        <div class="alert alert-success fade in">
          <button data-dismiss="alert" class="close close-sm" type="button">
            <i class="fa fa-times"></i>
          </button>
          <?php _e($_SESSION[PF.'MSG']);?>
        </div>
      <?php }
      unset($_SESSION[PF.'MSG']);?>

      <?php include($template);?>
    </section>
  </section>
  <?php include($theme_path.'footer.php');?>
</section>
</body>
</html>