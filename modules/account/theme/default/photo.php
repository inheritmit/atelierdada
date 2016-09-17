<?php 
	//$photourl = (file_exists($module_path.'/upload/photo/'.$account_details['strImageName'])) ? $module_url.'/upload/photo/'.$account_details['strImageName'] : $theme_url.'img/no-image.gif';
	$photourl = (file_exists($module_path.'/upload/photo/'.$account_details['strImageName'])) ? SITE_URL.'modules/account/upload/photo/'.$account_details['strImageName'] : $theme_url.'img/no-image.gif';
?>
<link href="<?php _e($theme_url);?>assets/jcrop/css/jquery.Jcrop.min.css" rel="stylesheet"/>
<link href="<?php _e($theme_url);?>css/image-crop.css" rel="stylesheet"/>
<h3 class="timeline-title"><i class="fa fa-user"></i> &nbsp; Profile</h3>
<div class="row">
  <?php include_once('profile-menu.php');?>
  <aside class="profile-info col-lg-9">
    <section class="panel">
      <header class="panel-heading">
          Your Profile Photo
      </header>
      <div class="panel-body">
      	<form name="photo_form" id="photo_form" method="post" enctype="multipart/form-data">
      	  <div id="photo-frame" class="row"<?php if(!file_exists($module_path.'/upload/photo/'.$account_details['strImageName'])) { ?> style="display:none;"<?php } ?>>
              <div class="col-md-6">
                  <img src="<?php _e($theme_url);?>img/6.jpg" id="demo3" alt="Jcrop Example" width="100%" />
              </div>
              <div class="col-md-6">
                  <div id="preview-pane">
                      <div class="preview-container">
                          <img src="<?php _e($theme_url);?>img/6.jpg" class="jcrop-preview" alt="Preview"/>
                      </div>
                  </div>
              </div>
          </div>
          <div id="uploadBox" style="margin-top:20px;">
          	<input type="hidden" name="url" id="url" value="<?php _e($module_url);?>/upload/do" />
            <a href="#" class="_up btn" rel="img" data-type="image/*">Upload Image</a><input class="upload" type="file" name="upl" style="display:none;" />
          </div>
        </form>
      </div>
    </section>
  </aside>
</div>
<script src="<?php _e($theme_url);?>assets/jcrop/js/jquery.Jcrop.min.js"></script>
<script src="<?php _e($theme_url);?>js/form-image-crop.js"></script>

<script src="<?php _e($theme_url);?>assets/ajaxupload/jquery.knob.js"></script>

<!-- jQuery File Upload Dependencies -->
<script src="<?php _e($theme_url);?>assets/ajaxupload/jquery.ui.widget.js"></script>
<script src="<?php _e($theme_url);?>assets/ajaxupload/jquery.iframe-transport.js"></script>
<script src="<?php _e($theme_url);?>assets/ajaxupload/jquery.fileupload.js"></script>

<!-- Our main JS file -->
<script src="<?php _e($theme_url);?>assets/ajaxupload/script.js"></script>

<script>
  jQuery(document).ready(function() {
	  // initiate layout and plugins
	  FormImageCrop.init();
  });
</script>