<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>css/home/styles.css">
<body class="verification">
<div id="header">
	<div class="wrapper">
		<a href="<?php _e(SITE_URL);?>" id="logo<?php _e(ENV);?>"></a>
        <div class="hedTitle">Forgot Your Password?</div>
 	</div>
</div>
<div class="wrapper">
	<p style="padding:30px 0;">Please enter your registered email address below. We'll send you a mail with instructions to reset your account password.</p>
	<p>Please contact us at <a href="mailto:<?php echo SUPPORT_EMAIL;?>"><strong><?php echo SUPPORT_EMAIL;?></strong></a>, if you require further assistance.</p>
    <form id="forgot_pass" name="forgot_pass" method="post" class="verificationForm cf" action="<?php _e(SITE_URL);?>account/password/do">
    	<input type="hidden" name="action" id="action" value="send-reset-instructions" />
		<label><input name="email" type="text" class="inputText required" placeholder="Enter your registered e-mail address" style="width:250px;" id="email" value="<?php echo isset($_POST['email_address']) ? $_POST['email_address'] : '' ?>" /></label>
		<label><input class="button update" type="submit" id="submit" value="submit" name="submit" /></label>
        <label><input name="cancel" class="button" type="button" id="cancel-button" value="Cancel"  onClick="window.location='<?php _e($theme_url);?>'" /></label>
    </form>
</div>
<script type="text/javascript" src="<?php _e($theme_url);?>assets/jquery-validate/jquery.validate.js" ></script>
<script type="text/javascript">
	$(function()
	{
		$("#forgot_pass").validate({
			rules:
			{
				email:
				{
					required: true,
					email: true
				},
			},
			messages :
			{
				email:
				{
					required: "Please enter a valid email address."
				}
			}
		});
	});
</script>