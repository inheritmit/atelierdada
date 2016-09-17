<?php
/*if(!$account_obj->checkAccess('access-user', $req['parent'])) {
		_error('unauthorized');
		exit;
}*/

if(isset($req['parent']) && $req['parent'] == 'edit') {
		$accDetail = $account_obj->getAccountDetail($_GET['id']);
 // pr($accDetail);exit;
		/*if(empty($accDetail['strFirstName'])) {
			$getname = explode(" ",$accDetail['strFullName']);
			$namecount = sizeof($getname);
			if($namecount == 3){
			 $fname=$getname[0];
			 $mname=$getname[1];
			 $lname=$getname[2];
			}elseif($namecount==2){
			  $fname=$getname[0];
			  $lname=$getname[1];								 
			}elseif($namecount>3){
			  $fname=$getname[0];
			  $lname=$getname[$namecount-1];
			}
		} else {*/
			$fname = $accDetail['strFirstName'];
			$mname = $accDetail['strMiddleName'];
			$lname = $accDetail['strLastName'];
		//}
	}
	
	_module('master');
	$mstObj = new master();
	
	$access_types = $mstObj->getMasters(1, 'access-type');
?>
<style type="text/css">
label.error {
	width: 250px;
	display: inline;
	color: red;
}
</style>
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>assets/bootstrap-datepicker/css/datepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>assets/bootstrap-datetimepicker/css/datetimepicker.css" />
<script type='text/javascript' src="<?php _e($theme_url);?>js/jquery.autocomplete.js"></script>
<script type="text/javascript" src="<?php _e($theme_url);?>assets/jquery-validate/jquery.validate.js" ></script>
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>css/jquery.autocomplete.css" />
<script type="text/javascript">
  $(document).ready(function(){
    $("#profile_form").validate({
      rules:
      {
        password: {
          minlength: 8,
          maxlength: 16
        },
        copassword:{
          equalTo: "#password"
        },email:
        {
          required: true,
          email: true,
          <?php if($req['parent']=='add'){?>
          remote: '<?php echo SITE_URL;?>account/load/checkdata'
          <?php } ?>
        }
      },
      messages :
      {
        email:{
          required: "Please enter your email address.",
          email: "Please enter a valid email address.",
          <?php if($req['parent']=='add'){?>
          remote: jQuery.format("{0} is already taken.")
          <?php } ?>
        },
        password: {
          required: "Please enter password",
          minlength: "Password must be 8 to 16 characters",
          maxlength: "Password must be 8 to 16 characters"
        },
        copassword:{
          required: "Please enter Confirm password",
          equalTo: "Passwords not matched"
        }
      }
    });
  });

</script>
<div class="row">
  <div class="col-lg-12">
    <h3 class="timeline-title"><i class="fa fa-user"></i> &nbsp; Access Users <!--<a href="<?php //echo _e($module_url);?>/add" class="btn btn-primary ar"><i class="fa fa-plus"></i> Add New</a>--><div class="clear"></div></h3>
    <form id="profile_form" name="profile_form" method="post" class="cmxform form-horizontal tasi-form" action="<?php _e(SITE_URL);?>account/manager/do">
      <input type="hidden" name="action" id="action" value="<?php if($req['parent']=='add') { echo 'add';} else if($req['parent'] == 'edit') { echo 'edit';}?>" />
     <input type="hidden" name="id" id="id" value="<?php if($req['parent']=='edit') { echo $accDetail['id'];}?>" />


      <div class="col-lg-6" style="padding-left:0;">
        <section class="panel">
          <header class="panel-heading">Personal Details</header>
          <div class="panel-body">
            <div class="form">
              <div class="form-group">
                <label for="title" class="control-label col-lg-4">Title:</label>

                <div class="col-lg-8">
                  <select name="title" id="title" class="form-control required">
                    <option  value="" selected="selected">Select Title</option>
                    <option value="Mr. "<?php if(@$accDetail['title'] == 'Mr. ') { ?> selected="selected"<?php } ?>>Mr.</option>
                    <option value="Dr. "<?php if(@$accDetail['title'] == 'Dr. ') { ?> selected="selected"<?php } ?>>Dr.</option>
                    <option value="Ms. "<?php if(@$accDetail['title'] == 'Ms. ') { ?> selected="selected"<?php } ?>>Ms.</option>
                  </select>
                </div>
              </div>

             <div class="form-group">
                <label for="fname" class="control-label col-lg-4">First Name:</label>
                <div class="col-lg-8">
                  <input type="text" name="fname" id="fname" value="<?php echo @$fname;?>" class="form-control required" />
                </div>
              </div>

              <div class="form-group">
                <label for="mname" class="control-label col-lg-4">Middle Name:</label>
                <div class="col-lg-8">
                  <input type="text" name="mname" id="mname" value="<?php echo @$mname;?>"  class="form-control" />
                </div>
              </div>

              <div class="form-group">
                <label for="lname" class="control-label col-lg-4">Last Name:</label>
                <div class="col-lg-8">
                  <input type="text" name="lname" id="lname" value="<?php echo @$lname;?>"  class="form-control required" />
                </div>
              </div>

              <div class="form-group">
                <label for="pname" class="control-label col-lg-4">Access Type:</label>
                <div class="col-lg-8">
                  <select name="sel_des" id="sel_des" class="form-control required">
                    <option value="" selected="selected"> -- Select -- </option>
                    <?php
					foreach($access_types as $access_types){
					?>	
					<option value="<?php echo $access_types['id'];?>"<?php if(@$accDetail['idDesg']==$access_types['id']) { ?> selected="selected"<?php } ?>><?php echo $access_types['strAccessType'];?></option>
					<?php
                    }
					?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label for="pname" class="control-label col-lg-4">Birth Date:</label>
                <div data-date-viewmode="years" data-date-format="dd-mm-yyyy" data-date="<?php  if(isset($accDetail['dtBirth']) && !empty($accDetail['dtBirth'])){ echo date('d-m-Y',strtotime($accDetail['dtBirth']));}?>"  class="col-lg-7 input-append date dpYears">
                  <input type="text"  value="<?php  if(isset($accDetail['dtBirth']) && !empty($accDetail['dtBirth'])){ echo date('d-m-Y',strtotime($accDetail['dtBirth']));}?>" size="16" name="birthdate" id="birthdate" class="form-control required" />
                  <span class="input-group-btn add-on">
                  <button class="btn btn-danger" type="button"><i class="fa fa-calendar"></i></button>
                  </span> </div>
              </div>


              <div class="form-group">
                <label for="pname" class="control-label col-lg-4">Gender:</label>
                <div class="col-lg-8">
                  <select name="gender" id="gender" class="form-control required">
                    <option value="" selected="selected">Select Gender</option>
                    <option value="M"<?php if(@$accDetail['strGender'] == 'M') { ?> selected="selected"<?php } ?>>Male</option>
                    <option value="F"<?php if(@$accDetail['strGender'] == 'F') { ?> selected="selected"<?php } ?>>Female</option>
                  </select>
                </div>
              </div>


            </div>
          </div>
      </section>
  </div>
      
  <div class="col-lg-6">

     <section class="panel">

          <header class="panel-heading">Contact Details</header>

          <div class="panel-body">

            <div class="form">

              <div class="form-group">
                <label for="pname" class="control-label col-lg-4">Address:</label>
                <div class="col-lg-8">
                  <textarea cols="10" rows="5" class="form-control required" name="address" id="address"><?php echo @$accDetail['strAddress'];?></textarea>
                </div>
              </div>

              <div class="form-group">
                <label for="pname" class="control-label col-lg-4">Email:</label>
                <div class="col-lg-8">
                  <input type="text" name="email" id="email" value="<?php echo @$accDetail['strEmail'];?>"<?php if(!empty($accDetail['strEmail'])) { ?> readonly<?php } ?> class="form-control" />
                </div>
              </div>

              <div class="form-group">
                <label for="pname" class="control-label col-lg-4">Mobile:</label>
                <div class="col-lg-8">
                  <input type="text" name="mobile" id="mobile" value="<?php echo @$accDetail['strMobile'];?>" class="form-control required" />
                </div>
              </div>

            </div>
          </div>
        </section>
      </div>



      <div class="col-lg-6">

        <section class="panel">

          <header class="panel-heading">Access Details</header>
            <div class="panel-body">
               <div class="form">

                 <div class="form-group">
                   <label for="pname" class="control-label col-lg-4">Password:</label>
                   <div class="col-lg-8">
                   <input type="password" name="password" id="password" <?php if($req['parent']=='edit') {?> class="form-control" <?php }?>  class="form-control required"/>
                 </div>

               </div>

              <div class="form-group">
                <label for="pname" class="control-label col-lg-4">Confirm Password:</label>
                <div class="col-lg-8">
                  <input type="password" name="copassword" id="copassword" <?php if($req['parent']=='edit') {?> class="form-control" <?php }?>  class="form-control required"/>
                </div>
              </div>

            </div>
          </div>
        </section>
      </div>






















      <div class="col-lg-offset-2 col-lg-10">
        <input class="btn btn-info" type="submit" id="submit" value ="Submit" name="submit" />
        <input name="cancel" class="btn btn-danger" type="button" id="cancel-button" value="Cancel" onClick="window.location='list'" />
      </div>
    </form>
  </div>
</div>

<script type="text/javascript" src="<?php _e($theme_url);?>assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script> 
<script type="text/javascript" src="<?php _e($theme_url);?>assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php _e($theme_url);?>js/advanced-form-components.js"></script>
<script type="text/javascript">
$(function(){
   $('.dpYears').datepicker({
       //format: 'dd-mm-yyyy'
   });
});
</script>