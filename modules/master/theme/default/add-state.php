<?php 
if(!isset($_SESSION[PF.'USERID']) || empty($_SESSION[PF.'USERID']))
setLocation(SITE_URL."index.php");

$action = 'add';
$type = 'state';
if($req['parent'] == 'edit-state') {
	$action = 'edit';
	$state = $mstObj->getMaster("id = ".$_GET['id'], 'state');
}
?>
<script type="text/javascript" src="<?php _e($theme_url);?>assets/jquery-validate/jquery.validate.js" ></script>
<script type="text/javascript">
$(document).ready( function() {
            $("#state_form").validate({
        		rules: {
        			state_name: {
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
	                	state_name: { 
	        				remote: "This state already exist",
	        				required: "state name is required"
	        					}
	        		}
	        	});
});
</script>
<?php include('submenu.php');?>
<h3 class="timeline-title"><i class="fa fa-file-o"></i>&nbsp;States</h3>
<section class="panel">
  <header class="panel-heading"><?php _e(ucwords($action));?> State</header>
  <div class="panel-body"><div class="form">
    <form id="state_form" name="state_form" method="post" class="cmxform form-horizontal tasi-form" action="<?php _e(SITE_URL);?>master/manager/do">
        <input type="hidden" name="action" id="action" value="<?php _e($action);?>">
        <input type="hidden" name="type" id="type" value="state">
        <?php if($action == 'edit') { ?>
        <input type="hidden"  id="eid" name="ID" value="<?php _e($state['id']);?>" />
        <?php } ?>
        <div class="form-group"><label for="state_name" class="control-label col-lg-2">State Name:</label>
          <div class="col-lg-10"><input  id="state_name" name="state_name" type="text" class="form-control required" value="<?php _e(@$state['state_name']);?>" maxlength="110" id="state_name" />
          <div id="leavetype_check"></div>
          </div>
        </div>
		<div class="form-group"> 
          <div class="col-lg-offset-2 col-lg-10"><input class="btn btn-info" type="submit" id="submit" value ="Submit" name="submit" />
          <input name="cancel" class="btn btn-danger" type="button" id="cancel-button" value="Cancel" onClick="window.location='states'" /></div>
       </div>
    </form>
  </div></div>
</section>