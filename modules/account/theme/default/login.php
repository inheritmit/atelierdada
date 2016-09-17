<script type="text/javascript" src="<?php _e(ASSET_URL);?>jquery-validate/jquery.validate.js" ></script>
<script type="text/javascript">
$(document).ready(function() {
	
	//jQuery.validator.messages.required = "";
	$('#login_form').validate({
       rules: {
            username: { 
               required:true
            },
			password: { 
               required:true
            }       
      },
	  messages:{
	      username:{
		    required:"Please Provide Email Address."
		  },
		  password:{
		    required:"Please Provide Password."
		  }
	  }
	});
});
</script>
<a href="<?php _e(SITE_URL);?>" id="logo<?php _e(ENV);?>"></a>
<form name="login_form" id="login_form" method="post" action="<?php echo SITE_URL.'account/login/do'?>" class="form-signin">
    <h2 class="form-signin-heading"><?php _e(SITE_REPRESENT_TITLE);?></h2>
    <div class="login-wrap">
      <input class="form-control" name="username" id="username" type="text" value="" placeholder="Email Address" autofocus />
      <input class="form-control" name="password" id="password" type="password" placeholder="Password" />
      <label class="checkbox">
        <span class="pull-right">
            <a data-toggle="modal" href="#myModal">Forgot Password?</a>
        </span>
      </label>
      <button class="btn btn-lg btn-login btn-block" type="submit">Login</button>
      <?php /*?><p>or you can sign in via social network</p>
      <div class="login-social-link">
        <a href="index-2.html" class="facebook">
            <i class="fa fa-facebook"></i>
            Facebook
        </a>
        <a href="index-2.html" class="twitter">
            <i class="fa fa-twitter"></i>
            Twitter
        </a>
      </div>
      <div class="registration">
        Don't have an account yet?
        <a class="" href="registration.html">
            Create an account
        </a>
      </div><?php */?>
      <div id="notify-login" class="notify">
          <?php
          if(isset($_SESSION[PF.'MSG']) && $_SESSION[PF.'MSG'] != ""){
           _e($_SESSION[PF.'MSG']);}
          unset($_SESSION[PF.'MSG']);

          ?></div>
  </div>
</form>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" id="myModal" class="modal fade">
<form id="forgot_pass" name="forgot_pass" method="post" action="<?php _e(SITE_URL);?>account/password/do">
    <input type="hidden" name="action" id="action2" value="send-reset-instructions" />
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Forgot Password ?</h4>
          </div>
          <div class="modal-body">
              <p>Please enter your registered email address below. We'll send you a mail with instructions to reset your account password.</p>
              <p>Please contact us at <a href="mailto:<?php echo SUPPORT_EMAIL;?>"><strong><?php echo SUPPORT_EMAIL;?></strong></a>, if you require further assistance.</p>
              <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

          </div>
          <div class="modal-footer">
              <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
              <button class="btn btn-success" type="submit">Submit</button>
          </div>
      </div>
  </div>
</form>
</div>