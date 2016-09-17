<?php 
$action = 'bulk-add';
$type = _b64($_GET['t'], 'decode');
?>
<style type="text/css">
div.element { float:left; width:580px; }
label.entry { float:left; width: 250px; padding: 5px; }
label.element-entry { padding: 5px; float: none; }
div.box { border: 1px solid #DDD; background:#f4f3ee; padding: 10px; height:200px; overflow:auto; margin:5px 0; -moz-box-shadow: inset 0 0 2px #e2e2e2; -webkit-box-shadow: inset 0 0 2px #e2e2e2; box-shadow: inset 0 0 2px #e2e2e2; }
</style>
<script type="text/javascript" src="<?php _e($theme_url);?>assets/jquery-validate/jquery.validate.js"></script>
<script type="text/javascript">
$(document).ready( function() {
	$("#<?php _e($type);?>_form").validate({
		rules: {
			<?php _e($type);?>_name: {
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
        	<?php _e($type);?>_name: { 
				remote: "This <?php _e($type);?> already exist",
				required: "<?php _e($type);?> name is required"
			}
		}
	});
});
</script>
<h3 class="timeline-title"><i class="fa fa-archive"></i>&nbsp;Categories</h3>
<section class="panel">
  <header class="panel-heading"><?php _e(ucwords($action));?>&nbsp;Categories</header>
  <div class="panel-body">
    <form id="<?php _e($type);?>_form" name="<?php _e($type);?>_form" method="post" class="cmxform form-horizontal tasi-form" action="<?php _e($module_url);?>/manager/do">
      <input type="hidden" name="action" id="action" value="<?php _e($action);?>">
      <input type="hidden" id="type" name="type" value="<?php _e($type);?>" />
      <?php 
	  	if(isset($_GET['parent'])) { 
			
			$parents = $mstObj->getMasters("enmDeleted =  '0' and parent = '0'", $type);
            if($parents != 404) {
	  ?>
      <div class="form-group">
         <div class="col-lg-4">
           <select id="parent" name="parent" class="form-control">
              <option value="0" selected="selected"> -- Select -- </option>
            <?php foreach($parents as $pdata){ ?>
               <option value="<?php echo $pdata['id'];?>"><?php echo $pdata['store_name'];?></option>
            <?php } ?>
           </select>
         </div>
      </div>
      <?php
			}
	  	}
	  ?>
      <div class="form-group"><label for="names" class="control-label col-lg-12">Enter Names line by line:</label>
         <div class="col-lg-4">
           <textarea name="names" id="names" type="text" class="form-control required" rows="10"></textarea>
           <div id="type_check"></div>	
         </div>
      </div>
	  <div style="margin-top: 20px"></div>
      <div class="form-group">
    	<div class="col-lg-10">
    		<input class="btn btn-info" type="submit" id="submit" value="Submit" name="submit" />
          	<input name="cancel" class="btn btn-danger" type="button" id="cancel-button" value="Cancel" onClick="window.location='categories'" />
        </div>
      </div>
    </form>
  </div>
</section>
     