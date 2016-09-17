<?php 
if(!isset($_SESSION[PF.'USERID']) || empty($_SESSION[PF.'USERID']))
_locate(SITE_URL."index.php");

$action = 'add';
$type = 'area';
if($req['parent'] == 'edit-area') {
	$action = 'edit';
	$area = $mstObj->getMaster("id = ".$_GET['id'], $type);
}
?>
<script type="text/javascript" src="<?php _e($theme_url);?>assets/jquery-validate/jquery.validate.js"></script>
<script type="text/javascript">
$(document).ready( function() {
	$("#area_form").validate({
// 		rules: {
//             area_name: {
//                 required: true,
// 				remote: { 
//					url: "<?php echo SITE_URL;?>master/load/checkdata",
// 					type: "post",
// 					data: {
// 						  eid: function() { return $("#eid").val(); },
// 					}
// 				}
//             },
// 		},
//         // validation error messages
//         messages: {
//             area_name: { 
// 				remote: "This area already exist",
// 				required: "area name is required"}
// 		}
	});
});
</script>
<link href="<?php _e($theme_url);?>assets/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css" media="all"/>
<link href="<?php _e($theme_url);?>assets/jquery-tagedit/css/jquery.tagedit.css" rel="stylesheet" type="text/css" media="all"/>
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>assets/bootstrap-fileupload/bootstrap-fileupload.css" />
<style type="text/css">
div.element { float:left; width:580px; }
label.entry { float:left; width: 250px; padding: 5px; }
label.element-entry { padding: 5px; float: none; }
div.box { border: 1px solid #DDD; background:#f4f3ee; padding: 10px; height:200px; overflow:auto; margin:5px 0; -moz-box-shadow: inset 0 0 2px #e2e2e2; -webkit-box-shadow: inset 0 0 2px #e2e2e2; box-shadow: inset 0 0 2px #e2e2e2; }
</style>
<?php  include('submenu.php');?>
<?php echo _msg(PF.'MSG','session-msgs');?>
<h3 class="timeline-title"><i class="fa fa-archive"></i>&nbsp;Area</h3>
<?php echo _msg(PF.'MSG','session-msgs');?>
<section class="panel">
  <header class="panel-heading"><?php _e(ucwords($action));?>&nbsp;Area</header>
  <div class="panel-body">
    <div class="form">
    <form id="area_form" name="area_form" method="post" class="cmxform form-horizontal tasi-form" enctype="multipart/form-data" action="<?php _e(SITE_URL);?>master/manager/do">
        <input type="hidden" name="action" id="action" value="<?php _e($action);?>">
        <input type="hidden" id="type" name="type" value="<?php _e($type);?>" />
        <?php if($action == 'edit') { ?>
        <input  id="eid" type="hidden" name="ID" value="<?php _e($area['id']);?>" />
      	<?php } ?>
      <div class="form-group"><label for="area_name" class="control-label col-lg-2">Area Name:</label>
         <div class="col-lg-10"><input name="area_name" id="area_name" type="text" class="form-control required" value="<?php _e(@$area['area_name']);?>" maxlength="110"/></div>
      </div>
      <div class="form-group"><label for="pincode" class="control-label col-lg-2">Pincode:</label>
          <div class="col-lg-10">
          <input name="pincode" id="pincode" type="text" class="form-control required" value="<?php _e(@$area['pincode']);?>" maxlength="110"/>
          </div>
      </div>
      <div class="form-group"><label for="status" class="control-label col-lg-2">Status:</label>
          <div class="col-lg-10">
                <select name="status" id="status" class="form-control required">
                 	<option value="" selected="selected" >Select Status</option>
                    <option value="1" <?php if(@$area['status']=='1'){?> selected="selected" <?php }?> >Active</option>
                    <option value="0" <?php if(@$area['status']=='0'){?> selected="selected" <?php }?> >InActive</option>
                </select> 
          </div>
      </div>
	</div>
	<div style="margin-top: 20px"></div>
    <div class="form-group">
    	<div class="col-lg-offset-2 col-lg-10">
    		<input class="btn btn-info" type="submit" id="submit" value ="Submit" name="submit" />
          	<input name="cancel" class="btn btn-danger" type="button" id="cancel-button" value="Cancel" onClick="window.location='areas'" />
        </div>
    </div>
    </form>
  </div>
</section>