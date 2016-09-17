<?php	
	$account_details = $account_obj->getAccount("sha1(concat('".PASSWORD_HASH."', strEmail)) = '".$_GET['hash']."'");
	if($account_details == 404) {
		include_once(SITE_PATH.'errors/404.php');
		exit;
	}
?>
<div class="row">
  
  <div class="col-lg-12"><h3>Verify your account</h3>
  	<section class="panel">
      <div class="panel-body">
        <div class="form">
            <form id="verification_form" name="verification_form" method="post" class="verificationForm cf" action="<?php _e(SITE_URL);?>account/manager/do">
                <input type="hidden" name="action" id="action" value="check" />
                <input type="hidden" name="hash" id="hash" value="<?php _e($_GET['hash']);?>">
                <p>Please enter the verification code sent by email to provided email address</p>
                <label for="active_code" class="error cf" style="display:none;">Please enter the verification code</label>
                <label><input name="active_code" type="text" class="form-control required" id="active_code" value="" style="width:300px;" placeholder="Enter your verification code" /></label>
                <label><input class="btn btn-info" type="submit" id="submit" value="Submit" name="submit" /></label>
                <p class="vCode">Didn't receive a verifiaction code? <a href="<?php _e(SITE_URL);?>account/resend/do?t=<?php _e(time());?>&hash=<?php _e($_GET['hash']);?>">Click here to resend</a></p>
            </form>
        </div>
      </div>
    </section>
  </div>
</div>
<script type="text/javascript" src="<?php _e(SITE_URL);?>assets/jquery-validate/jquery.validate.js" ></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#verification_form").validate();
});
</script>