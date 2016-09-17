<?php
if(!isset($_SESSION[PF.'USERID']) || empty($_SESSION[PF.'USERID']))
setLocation(SITE_URL."index.php");

$action = 'add';
$type = 'category';
if($req['parent'] == 'edit-category') {
	$action = 'edit';
	$category = $mstObj->getMaster("id = ".$_GET['id'],$type);
}
?>
<link href="<?php _e($theme_url);?>assets/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css" media="all"/>
<link href="<?php _e($theme_url);?>assets/jquery-tagedit/css/jquery.tagedit.css" rel="stylesheet" type="text/css" media="all"/>
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>assets/bootstrap-fileupload/bootstrap-fileupload.css" />
<style type="text/css">
div.element { float:left; width:580px; }
label.entry { float:left; width: 250px; padding: 5px; }
label.element-entry { padding: 5px; float: none; }
div.box { border: 1px solid #DDD; background:#f4f3ee; padding: 10px; height:200px; overflow:auto; margin:5px 0; -moz-box-shadow: inset 0 0 2px #e2e2e2; -webkit-box-shadow: inset 0 0 2px #e2e2e2; box-shadow: inset 0 0 2px #e2e2e2; }
</style>
<script type="text/javascript" src="<?php _e($theme_url);?>assets/jquery-validate/jquery.validate.js"></script>
<script type="text/javascript">
$(document).ready( function() {
	$("#category_form").validate({
		rules: {
			category_name: {
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
        	category_name: { 
				remote: "This category already exist",
				required: "category name is required"
			}
		}
	});
});
</script>
<h3 class="timeline-title"><i class="fa fa-archive"></i>&nbsp;Categories</h3>
<section class="panel">
  <header class="panel-heading"><?php _e(ucwords($action));?>&nbsp;Category</header>
  <div class="panel-body">
    <div class="form">
    <form id="category_form" name="category_form" method="post" class="cmxform form-horizontal tasi-form" enctype="multipart/form-data" action="<?php _e($module_url);?>/manager/do">
        <input type="hidden" name="action" id="action" value="<?php _e($action);?>">
        <input type="hidden" id="type" name="type" value="<?php _e($type);?>" />
        <?php if($action == 'edit') { ?>
        <input type="hidden" id="eid" name="ID" value="<?php _e($category['id']);?>" />
      	<?php } ?>
      <div class="form-group"><label for="pname" class="control-label col-lg-2">Name:</label>
         <div class="col-lg-10">
         <input name="category_name" id="category_name" type="text" class="form-control  required" value="<?php _e(@$category['category_name']);?>" maxlength="110"/>
         <div id="type_check"></div>	
         </div>
      </div>
      <div class="form-group"><label for="desc" class="control-label col-lg-2">Description:</label>
          <div class="col-lg-10"><textarea name="description" id="desc" type="text" class="form-control required"><?php _e(@$category['description']);?></textarea></div>
      </div>
	</div>
	<div style="margin-top: 20px"></div>
    <div class="form-group">
    	<div class="col-lg-offset-2 col-lg-10">
    		<input class="btn btn-info" type="submit" id="submit" value="Submit" name="submit" />
          	<input name="cancel" class="btn btn-danger" type="button" id="cancel-button" value="Cancel" onClick="window.location='categories'" />
        </div>
    </div>
    </form>
  </div>
</section>
     