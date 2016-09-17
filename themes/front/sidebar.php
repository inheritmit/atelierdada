<script type="text/jscript">
$().ready(function(e) {
	$('[placeholder]').focus(function() {
		var input = $(this);
		if (input.val() == input.attr('placeholder')) {
		input.val('');
		input.removeClass('placeholder');
		}
	}).blur(function() {
		var input = $(this);
		if (input.val() == '' || input.val() == input.attr('placeholder')) {
		input.addClass('placeholder');
		input.val(input.attr('placeholder'));
		}
	}).blur().parents('form').submit(function() {
		$(this).find('[placeholder]').each(function() {
		var input = $(this);
		if (input.val() == input.attr('placeholder')) {
		input.val('');
		}
		})
	});
	$("#login").validate({
		rules: {
			email: {
				email:true
			},
			password: "require"
		},
		messages: {
			email: "Valid Email Only",
			password: "Enter Password"
		},
		onfocusout: false,
                errorPlacement: function(error, element) {
            		//element.val(error.text());
            		element.attr("placeholder", error.text());
        		}
		});
});
</script>
<form name="login" id="login" method="post" action="<?php _e(SITE_URL);?>rms/do/login" class="signinbox">
  <h1>Sign In</h1>
  <p><?php if(isset($_SESSION[PF.'ERROR'])) echo $_SESSION[PF.'ERROR'];?></p>
  <p>E-mail</p>
  <input type="text" class="inputText placeholder required" placeholder="Registered email" name="email" id="email">
  <p class="pt10">Password</p>
  <input type="password" class="inputText placeholder required" placeholder="Password" name="password" id="password">
  <p></p>
  <p class="pt10">
    <label class="checkbox al">
      <input name="" type="checkbox" value="">
      &nbsp;Stay
      signed in </label>
    <input name="loginaction" id="loginaction" type="submit" value="Sign In" class="button">
  </p>
  <p class="pt10  clear"><a href="<?php _e($module_url."/forgotpassword");?>">Forgot your password?</a></p> 
  <!--<p class="borbot pt10 clear"></p>
  <a href="#" class="linkin">Or Sign In with Linkedin</a>
  <p class="pt10">New to Site</p>
  <input name="" type="reset" value="Create an Account" class="button" style="width: 100%;">-->
</form>


