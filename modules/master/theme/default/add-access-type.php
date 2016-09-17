<?php
if(!$account_obj->checkAccess('access-type', 'add')) {
	_error('unauthorized');
	exit;
}

$type = 'access-type';
$action = 'add';

if($req['parent'] == 'edit-access-type') {
	$action = 'edit';
	$access_types = $mstObj->getMaster("id = ".$_GET['id'], $type);
}
?>
<script type="text/javascript" src="<?php _e($theme_url);?>assets/jquery-validate/jquery.validate.js" ></script>
<script type="text/javascript">
$(document).ready( function() {
	$("#access_types_form").validate({
		rules: {
            access_type_name: {
                required: true,
            },
		},
        // validation error messages
        messages: {
            access_type_name: { 
				required: "Access Type name is required"}
		}
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
<?php // include('submenu.php');?>
<h3 class="timeline-title"><i class="fa fa-user"></i>&nbsp; Access Types</h3>
<section class="panel">
  <header class="panel-heading"><?php _e(ucwords($action));?> Access Type</header>
  <div class="panel-body">
  <div class="form">
    <form id="access_types_form" name="access_types_form" method="post" class="cmxform form-horizontal tasi-form" action="<?php _e(SITE_URL);?>master/manager/do">
        <input type="hidden" name="action" id="action" value="<?php _e($action);?>">
        <input type="hidden" id="type" name="type" value="<?php _e($type);?>" />
        <?php if($action == 'edit') { ?>
        <input type="hidden" id="eid" name="ID" value="<?php _e($access_types['id']);?>" />
      	<?php } ?>
        
            
      <div class="form-group"><label for="pname" class="control-label col-lg-2">Access Type Name:</label>
         <div class="col-lg-10"><input name="access_type_name" id="access_type_name" type="text" class="form-control  required" value="<?php _e(@$access_types['access_type_name']);?>" maxlength="110"/>
         </div>
      </div>
          
      <div class="form-group"><label for="desc" class="control-label col-lg-2">Description:</label>
          <div class="col-lg-10"><textarea name="description" id="desc" type="text" class="form-control required"><?php _e(@$access_types['description']);?></textarea></div>
      </div>
	 
      <div class="form-group"> 
          <div class="col-lg-offset-2 col-lg-10">
          	<input class="btn btn-info" type="submit" id="submit" value ="Submit" name="submit" />
          	<input name="cancel" class="btn btn-danger" type="button" id="cancel-button" value="Cancel" onClick="window.location='access-types'" />
          </div>
       </div>
    </form>
  </div>
  </div>
</section>