<?php 
if(!isset($_SESSION[PF.'USERID']) || empty($_SESSION[PF.'USERID']))
setLocation(SITE_URL."index.php");

$action = 'add';
$type = 'language';
if($req['parent'] == 'edit-language') {
	$action = 'edit';
	$country = $mstObj->getMaster("id = ".$_GET['id'], 'language');
}
?>
<script type="text/javascript" src="<?php _e($theme_url);?>assets/jquery-validate/jquery.validate.js" ></script>
<script type="text/javascript">
$(document).ready( function() {
	$("#language_form").validate({
		rules: {
            language_name: {
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
            language_name: { 
				remote: "This language already exist",
				required: "language name is required"}
		}
	});
});
</script>
<?php include('submenu.php');?>
<h3 class="timeline-title"><i class="fa fa-file-o"></i>&nbsp;Language</h3>
<section class="panel">
  <header class="panel-heading"><?php _e(ucwords($action));?> Language</header>
  <div class="panel-body"><div class="form">
    <form id="language_form" name="language_form" method="post" class="cmxform form-horizontal tasi-form" action="<?php _e(SITE_URL);?>master/manager/do">
        <input type="hidden" name="action" id="action" value="<?php _e($action);?>">
        <input type="hidden" name="type" id="type" value="language">
        <?php if($action == 'edit') { ?>
        <input type="hidden" id="eid" name="ID" value="<?php _e($country['id']);?>" />
        <?php } ?>
        <div class="form-group"><label for="language_name" class="control-label col-lg-2">Language Name:</label>
          <div class="col-lg-10"><input name="language_name" type="text" class="form-control required" value="<?php _e(@$country['language_name']);?>" maxlength="110" id="language_name" />
           <div id="language_check"></div>	
          </div>
        </div>
		<div class="form-group"> 
          <div class="col-lg-offset-2 col-lg-10"><input class="btn btn-info" type="submit" id="submit" value ="Submit" name="submit" />
          <input name="cancel" class="btn btn-danger" type="button" id="cancel-button" value="Cancel" onClick="window.location='languages'" /></div>
       </div>
    </form>
  </div></div>
</section>