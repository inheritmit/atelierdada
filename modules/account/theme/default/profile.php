<style type="text/css">
  .nameclass div{width: 300px; float: left; margin-right: 10px;}
  .imageradio label{float: left; margin-right: 10px; border-right: 1px #ccc solid; padding-right: 5px;}
  .imageradio label img{width: 50px;}
</style>
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>assets/bootstrap-datepicker/css/datepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>assets/bootstrap-fileupload/bootstrap-fileupload.css" />
<h3 class="timeline-title"><i class="fa fa-user"></i> &nbsp; Profile</h3>
<div class="row">
  <?php include_once('profile-menu.php');?>
  <aside class="profile-info col-lg-9">
  <?php 
  if(isset($_SESSION[PF.'MSG']) && $_SESSION[PF.'MSG'] != "")
  {
  ?>
    <div class="alert alert-success fade in">
        <button data-dismiss="alert" class="close close-sm" type="button">
            <i class="fa fa-times"></i>
        </button>
        <?php _e($_SESSION[PF.'MSG']); ?>
    </div>
    <?php 
  }unset($_SESSION[PF.'MSG']);
    ?>
    <section class="panel">
        <header class="panel-heading">
           <?php _e($row['strFirstName'].' '.$row['strLastName']); ?> Profile.
        </header>
        <div class="panel-body">
            <form method="post" name="profilepage" id="profilepage" accept-charset="utf-8" enctype="multipart/form-data" action="<?php _e(SITE_URL);?>account/profile/do">
              <input type="hidden" name="account_id" id="account_id" value="<?php _e($row['id']); ?>" />
                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Name</label>
                    <div class="col-sm-10 nameclass">
                        <div>
                          <span class="help-block">First Name</span>
                          <input type="text" class="form-control required" name="firstname" id="firstname" value="<?php _e($row['strFirstName']); ?>">
                        </div>
                        <div>
                          <span class="help-block">Last Name</span>
                          <input type="text" class="form-control" name="lastname" id="lastname" value="<?php _e($row['strLastName']); ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Email Id</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" disabled name="emailid" id="emailid" value="<?php _e($row['strEmail']); ?>" />
                    </div>
                </div>
                <div class="form-group">
                <?php 
                  if($row['strImgurl'] != "" and $row['strImgurl'] != NULL)
                  {
                  $imgurl = SITE_URL."file-manager/account/avtar/".$row['strImgurl'];
                  }else{
                    $imgurl = "";
                  }
                ?>
                  <label for="imgurl" class="control-label col-lg-2">Profile Pic.</label>
                  <div class="col-lg-10">
                    <input type="hidden" name="oldimg" id="oldimg" value="<?php _e($row['strImgurl']); ?>">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="fileupload-new thumbnail" style="width: 140px; height: 140px;">
                        <img src="<?php _e($imgurl); ?>" alt="Select Profile Pic.">
                    </div>
                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                    <div>
                       <span class="btn btn-white btn-file">
                       <span class="fileupload-new"><i class="fa fa-paperclip"></i> Select image</span>
                       <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                       <input name="imgurl" id="imgurl" type="file" class="default">
                       </span>
                          <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                      </div>
                    </div>
              </div>

          </div>
           <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Birth Date</label>
                    <div class="col-lg-10">
                        <div data-date-viewmode="years" data-date-format="dd-mm-yyyy" data-date=""  class="input-append date dpYears">
                            <input type="text" readonly="" name="birthdate" id="birthdate" value="<?php if(isset($row['dtBirth']) && $row['dtBirth'] != ""){_e(date("d-m-Y", strtotime($row['dtBirth']))); } ?>" size="16" class="form-control required">
                              <span class="input-group-btn add-on">
                                <button class="btn btn-danger" type="button"><i class="fa fa-calendar"></i></button>
                              </span>
                        </div>
                        <span class="help-block">Select date</span>
                        <label class="error" for="birthdate" style="display:none;" ></label>
                    </div>
           </div>

           <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Address</label>
                    <div class="col-sm-10">
                        <textarea  class="form-control required" name="address" id="address"><?php _e($row['strAddress']);?></textarea>
                    </div>
           </div>

           <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">City</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control required" name="city" id="city" value="<?php _e($row['strCity']); ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Pincode</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control digits" maxlength="6" minLength="6" name="pincode" id="pincode" value="<?php _e($row['strPincode']); ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Mobile No.</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control required digits" name="mobileno" minLength="10" id="mobileno" value="<?php _e($row['strMobile']); ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                        <button type="submit" name="submit" id="submit" class="btn btn-danger">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </section>    
</aside>
</div>
<script type="text/javascript" src="<?php _e($theme_url);?>assets/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script type="text/javascript" src="<?php _e($theme_url);?>assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php _e($theme_url);?>js/jquery.validate.js" ></script>
<script type="text/javascript">
  $(document).ready( function() {
     $("#changepassword").validate(); 
     $("#profilepage").validate({
      rules:{
        pincode:{
          required: true,
          number: true
        },
        mobileno:{
          required: true,
          number: true
        }
      },
      messages:{
        pincode:{
          required: "Please insert your area Pincode.",
          number: "please insert only number"
        },
        mobileno:{
          required: "please insert your Contact no.",
          number: "please insert only number"
        },
        city: {
          required: "Please insert your City name"
        },
        state: {
          required: "Please insert your State name"
        },
        address: {
          required: "Please insert your Address"
        },
        firstname: {
          required: "Please insert your Name"
        },
        birthdate: {
          required: "Please select your BirthDate"
        }
      }
     }); 
  });
</script>