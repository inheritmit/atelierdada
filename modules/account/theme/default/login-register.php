<!-- Start Header -->
<div id="header">
	<div class="wrapper">
		<a href="<?php _e(SITE_URL);?>" id="logo<?php _e(ENV);?>"></a>
        <form name="login_form" id="login_form" method="post" action="<?php echo SITE_URL.'account/login/do'?>" class="form cf">
            <fieldset>
                <h2>Login</h2>
                <label><input class="inputText" name="username" id="username" type="text" value="" placeholder="Email Address or Phone No." /></label>
                <label><input class="inputText" name="password" id="password" type="password" placeholder="Password" /></label>
                <label style="width:auto;"><input class="button" name="submit" type="submit" value="Login"></label>
                <label><input name="" type="checkbox" value=""> Keep me logged in</label>
                <a href="<?php _e(SITE_URL);?>account/forgot-password">Forgot your Password</a>
            </fieldset>
            <div id="notify-login" class="notify"><?php echo _msg(PF.'ERROR', 'error');?></div>
        </form>
 	</div>
</div>
<!-- Start Header -->
<!-- Start Banner --> 
<div class="loginBanner">
	<div class="wrapper cf">
    	<ul class="ban cf">
        	<li><img src="<?php _e(SITE_URL);?>images/home/ban1.jpg"></li>
            <li><img src="<?php _e(SITE_URL);?>images/home/ban2.jpg"></li>
        </ul>
        
        <div class="al">
        <h2>Or Login With</h2>
        <div class="social cf">
        	<a href="<?php _e(SITE_URL);?>account/login/facebook" class="f"></a>
            <a href="<?php _e(SITE_URL);?>account/login/twitter" class="t"></a>
            <a href="<?php _e(SITE_URL);?>account/login/google" class="g"></a>
            <a href="<?php _e(SITE_URL);?>account/login/linkedin" class="in"></a>
        </div>
        <span class="newU ">If you are a new user</span>        
        <form id="registration_form" name="registration_form" method="post" class="form cf" action="<?php _e(SITE_URL);?>account/registration/do" style="padding:0; float:none;">
            <input type="hidden" name="action" id="action" value="add" />
            <?php if(isset($checkAccount) && is_array($checkAccount) && $checkAccount != 404) { ?>
            <input type="hidden" name="r" value="<?php echo $_GET['r'];?>" />
            <?php } ?>
        	<fieldset>
            	<h2>Register <small style="font-size:12px; margin-left:20px; color:red;">* All fields are mandatory</small></h2>
                <label><input class="inputText" name="fullname" id="fullname" value="" type="text" placeholder="Full Name" /></label>
                <label><input class="inputText" name="birth_date" id="birth_date" type="text" value="" placeholder="Date of Birth (dd/mm/yyyy)" maxlength="10" /></label>
            	<label><input class="inputText" name="email" id="email" type="text" value="" placeholder="Email Address" /></label>
                <label><input class="inputText" name="confirm_email" id="confirm_email" type="text" value="" placeholder="Confirm Email Address" /></label>
                <label><input class="inputText" name="new_password" id="new_password" type="password" value="" placeholder="Password" /></label>
                <label><input class="inputText" name="confirm_password" id="confirm_password" type="password" value="" placeholder="Confirm Password" /></label>
                <label><input class="inputText" name="mobile_number" id="mobile_number" type="text" placeholder="Mobile Number" maxlength="10" /></label>
                <label style="width:auto;"><input class="button" name="register-now" type="submit" value="Register"></label>
            </fieldset>
        </form><div id="notify" class="notify"><div class="error" style="display:none;"></div></div></div>        
    </div>
</div> 
<!-- Start Banner -->
<!-- Start activities -->
<div class="activities cf">
	<h2>Activities On Namo KEMP</h2>
    
    <div class="activSliderBox">
    <ul class="cf">
    	<li>
        	<div class="cf"><h3>Save Girl Child</h3> <a href="#" class="ar">#Savegirlchild</a></div>
            <a href="#" class="upic"><img src="<?php _e(SITE_URL);?>images/home/activ-pic.gif" ></a>
            <a href="#" class="aciTitle">By Anubhav Rajpal</a>
            <span class="ago">Ahmedabad, 2 minutes ago</span>
            <p>�Let�s create poster and demonstate all around ahmedabad to spread awareness�</p>
            Date 25th July 2013, Time 10.00 am
        </li>
        <li>
        	<div class="cf"><h3>Save Girl Child</h3> <a href="#" class="ar">#Savegirlchild</a></div>
            <a href="#" class="upic"><img src="<?php _e(SITE_URL);?>images/home/activ-pic.gif" ></a>
            <a href="#" class="aciTitle">By Anubhav Rajpal</a>
            <span class="ago">Ahmedabad, 2 minutes ago</span>
            <p>�Let�s create poster and demonstate all around ahmedabad to spread awareness�</p>
            Date 25th July 2013, Time 10.00 am
        </li>
        <li>
        	<div class="cf"><h3>Save Girl Child</h3> <a href="#" class="ar">#Savegirlchild</a></div>
            <a href="#" class="upic"><img src="<?php _e(SITE_URL);?>images/home/activ-pic.gif" ></a>
            <a href="#" class="aciTitle">By Anubhav Rajpal</a>
            <span class="ago">Ahmedabad, 2 minutes ago</span>
            <p>�Let�s create poster and demonstate all around ahmedabad to spread awareness�</p>
            Date 25th July 2013, Time 10.00 am
        </li>
        <li>
        	<div class="cf"><h3>Save Girl Child</h3> <a href="#" class="ar">#Savegirlchild</a></div>
            <a href="#" class="upic"><img src="<?php _e(SITE_URL);?>images/home/activ-pic.gif" ></a>
            <a href="#" class="aciTitle">By Anubhav Rajpal</a>
            <span class="ago">Ahmedabad, 2 minutes ago</span>
            <p>�Let�s create poster and demonstate all around ahmedabad to spread awareness�</p>
            Date 25th July 2013, Time 10.00 am
        </li>
    </ul>
    </div>
    <div class="arrows"><a onclick="location.href='javascript:void(0);'" class="leftArr disabled"></a><a onclick="location.href='javascript:void(0);'" class="rightArr"></a></div>
</div>
<!-- End activities -->