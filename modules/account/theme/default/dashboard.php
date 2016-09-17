<div class="row">
  <div class="col-lg-12">
  	<h3 class="timeline-title">Welcome to <?php _e(SITE_TITLE);?></h3>
    <?php if($account_obj->checkAccess('registration', 'account-pdf')) { ?>
    <div class="col-lg-4">
    	<a href="<?php _e($module_url);?>/pdf?t=<?php _e(_b64($account_details['strEmail']));?>" class="btn btn-success btn-lg" target="_blank"><i class="fa fa-download"></i> &nbsp;Download Your Application (PDF)</a>
    </div>
    <?php } ?>
  </div>
</div>