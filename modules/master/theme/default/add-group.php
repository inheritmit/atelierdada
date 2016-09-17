<?php 
if($_SESSION['ROLE']['GROUP'] === false)
{
	setLocation(SITE_URL.'dashboard/list');
}
if(!isset($_SESSION[PF.'USERID']))
setLocation(SITE_URL."index.php");

$action = 'add';
$type = 'group';
if($req['parent'] == 'edit-group') {
	$action = 'edit';
	$group = $mstObj->getMaster("id = ".$_GET['id'],'group');
}
?>
<script type="text/javascript" src="<?php _e($theme_url);?>assets/jquery-validate/jquery.validate.js"></script>
<script type="text/javascript">
$(document).ready( function() {
	$("#group_form").validate({
		rules: {
            group_name: {
                required: true,
				remote: { 
					url: "<?php echo SITE_URL;?>master/load/checkdata",
					type: "post",
					data: {
						  ttype: function() { return $("#type").val(); },
						  eid: function() { return $("#eid").val(); },
						  pgaction: function() { return $("#action").val(); },
        			}
				}
            },
		},
        // validation error messages
        messages: {
            group_name: { 
				remote: "This group already exist",
				required: "group name is required"}
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
<section class="panel">
  <header class="panel-heading"><i class="fa fa-archive"></i>&nbsp;<?php _e(ucwords($action));?>&nbsp;Group</header>
  <div class="panel-body">
    <div class="form">
    <form id="group_form" name="group_form" method="post" class="cmxform form-horizontal tasi-form" action="<?php _e(SITE_URL);?>master/manager/do">
        <input type="hidden" name="action" id="action" value="<?php _e($action);?>">
        <input type="hidden" id="type" name="type" value="<?php _e($type);?>" />
        <?php if($action == 'edit') { ?>
        <input  id="eid" type="hidden" name="ID" value="<?php _e($group['id']);?>" />
      	<?php } ?>
      <div class="form-group"><label for="pname" class="control-label col-lg-2">Group Name:</label>
         <div class="col-lg-10"><input name="group_name" id="group_name" type="text" class="form-control required" value="<?php _e(@$group['group_name']);?>" maxlength="110"/>
         <div id="leavetype_check"></div>	
         </div>
      </div>      
	
	<div style="margin-top: 20px"></div>
    <div class="form-group">
    	<div class="col-lg-offset-2 col-lg-10">
    		<input class="btn btn-info" type="submit" id="submit" value ="Submit" name="submit" />
          	<input name="cancel" class="btn btn-danger" type="button" id="cancel-button" value="Cancel" onClick="window.location='groups'" />
        </div>
    </div>
    </form>
    </div>
  </div>
</section>