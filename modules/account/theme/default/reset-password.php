<?php
$account = $account_obj->getResetToken($_GET['email'], $_GET['token']);
//pr($account);exit;
if($account == 404) {
  _error(404);
}
?>
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>css/jquery.autocomplete.css" />
<script type="text/javascript" src="<?php _e($theme_url);?>assets/jquery-validate/jquery.validate.js" ></script>
<script type="text/javascript">
$(document).ready(function(e) {
	$("#resetpassword").validate({
		rules:
		{
			password: {
				required: true,
				minlength: 8,
				maxlength: 16
			},
			confirm_password:{
				equalTo: "#password"
			},
		},
		messages :
		{
			password: {
				required: "Please enter new password",
				minlength: "Password must be 8 to 16 characters",
				maxlength: "Password must be 8 to 16 characters"
			},
			confirm_password:{
				equalTo: "Passwords not matched"
			},
		}
	});
});
</script>
<style type="text/css">
label.error {
	width: 250px;
	display: inline;
	color: red;
}
</style>
<div class="row">
  <div class="col-lg-12">
    <h3 class="timeline-title"><i class="fa fa-user"></i> &nbsp; Reset Password</h3>
    <form id="resetpassword" name="resetpassword" method="post" class="cmxform form-horizontal tasi-form" action="<?php _e(SITE_URL);?>account/password/do">
      <input type="hidden" name="action" value="reset-password" />
      <input type="hidden" name="referer" value="<?php echo $_SERVER['REQUEST_URI'];?>" />
      <input type="hidden" name="accountId" id="accountId" value="<?php _e($account['vId']);?>" />
      <div class="col-lg-6" style="padding-left:0;">
        <section class="panel">
          <header class="panel-heading">Reset Password</header>
          <div class="panel-body">
            <div class="form">
            <!--  <div class="form-group">
                <label for="pname" class="control-label col-lg-4">Old Password:</label>
                <div class="col-lg-8">
                  <input type="text" value="" name="old_pass" id="old_pass" class="inputText required" />
                </div>
              </div>-->
              <div class="form-group">
                <label for="pname" class="control-label col-lg-4">New Password:</label>
                <div class="col-lg-8">
                  <input name="password" type="password" class="inputText required" id="password" />
                </div>
              </div>
              <div class="form-group">
                <label for="pname" class="control-label col-lg-4">Confirm Password:</label>
                <div class="col-lg-8">
                  <input name="confirm_password" type="password" class="inputText required"  id="confirm_password" />
                </div>
              </div>
              <div class="col-lg-offset-2 col-lg-10">
                <input class="btn btn-info" type="submit" id="submit" value ="Submit" name="submit" />
                <input name="cancel" class="btn btn-danger" type="button" id="cancel-button" value="Cancel" onClick="window.location='list'" />
              </div>
            </div>
          </div>
        </section>
      </div>
    </form>
  </div>
</div>
