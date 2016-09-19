<?php
	/** Add any master data by providing master type */
	
	if(!isset($_GET['t']) || empty($_GET['t']) || !in_array(_b64($_GET['t'], 'decode'), array_keys($master_obj->_types))) {
		_error(404);
		exit;
	}
	
	$type = _b64($_GET['t'], 'decode');
	$name = ucwords(str_replace('-', ' ', $type));
	
	$db_name_field = 'str'.str_replace(' ', '', $name);
	
	$input_name = str_replace('-', '_', $type).'_name';
	
	if(!$account_obj->checkAccess($type, 'add')) {
		_error('unauthorized');
		exit;
	}
	
	$action = 'add';
	
	if(strstr($req['parent'], 'edit')) {
		$action = 'edit';
		$master_details = $master_obj->getMaster("id = ".$_GET['id'], $type);
	}
?>
<style type="text/css">
div.element { float:left; width:580px; }
label.entry { float:left; width: 250px; padding: 5px; }
label.element-entry { padding: 5px; float: none; }
div.box { border: 1px solid #DDD; background:#f4f3ee; padding: 10px; height:200px; overflow:auto; margin:5px 0; -moz-box-shadow: inset 0 0 2px #e2e2e2; -webkit-box-shadow: inset 0 0 2px #e2e2e2; box-shadow: inset 0 0 2px #e2e2e2; }
</style>
<?php // include('submenu.php');?>
<h3 class="timeline-title"><i class="fa fa-user"></i>&nbsp; <?php echo "Content Type";// _e($name);?></h3>
<section class="panel">
  <header class="panel-heading"><?php _e(ucwords($action));?> <?php echo "Content Type"; //_e($name);?></header>
  <div class="panel-body">
  <div class="form">
    <form id="master_form" name="master_form" method="post" class="cmxform form-horizontal tasi-form" action="<?php _e(SITE_URL);?>master/manager/do">
        <input type="hidden" name="action" id="action" value="<?php _e($action);?>">
        <input type="hidden" id="type" name="type" value="<?php _e($_GET['t']);?>" />
        <?php if($action == 'edit') { ?>
        <input type="hidden" id="id" name="ID" value="<?php _e($master_details['id']);?>" />
      	<?php } ?>
        
            
      <div class="form-group"><label for="pname" class="control-label col-lg-2"><?php echo "Content type";//_e($name);?> Name:</label>
         <div class="col-lg-10">
             <input name="<?php _e($input_name);?>" id="<?php _e($input_name);?>" type="text" class="form-control required" value="<?php _e(@$master_details[$db_name_field]);?>" maxlength="50" />
         </div>
      </div>
          
      <div class="form-group"><label for="desc" class="control-label col-lg-2">Description:</label>
          <div class="col-lg-10"><textarea name="description" id="description" type="text" class="form-control"><?php _e(@$master_details['txtDescription']);?></textarea></div>
      </div>
	 
      <div class="form-group"> 
          <div class="col-lg-offset-2 col-lg-10">
          	<input class="btn btn-info" type="submit" id="submit" value ="Submit" name="submit" />
          	<input name="cancel" class="btn btn-danger" type="button" id="cancel-button" value="Cancel" onClick="window.location='list?t=<?php _e($_GET['t']);?>'" />
          </div>
       </div>
    </form>
  </div>
  </div>
</section>

<script type="text/javascript" src="<?php _e(ASSET_URL); ?>jquery-validate/jquery.validate.js" ></script>
<script type="text/javascript">
$(document).ready( function() {
	$("#master_form").validate({
        rules: {
            '<?php _e($input_name);?>': {
                required: true
            }
        },
        messages: {
            '<?php _e($input_name);?>': {
				required: "Content type is required"
            },
		}
	});
});

</script>