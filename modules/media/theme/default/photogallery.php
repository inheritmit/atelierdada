<div class="col-lg-12">
<form id="photogallery_form" name="photogallery_form" method="post" action="<?php _e($module_url); ?>/upload/do" class="cmxform form-horizontal tasi-form"  enctype="multipart/form-data">
<input type="hidden" name="albumid" id="albumid" value="<?php echo @$_GET['albumid']; ?>"/>
<input type="hidden" name="action" value="uploadphoto"/>
<section class="panel">
	<header class="panel-heading">Upload files</header>
	<div class="panel-body">
		<div class="form">
			<div class="form-group">
				<label for="photoname" class="control-label col-lg-2">Album Name:</label>
				<div class="col-lg-10">
					<input type="file" name="photoname[]" value="" multiple="multiple" class="form-control required"/>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="col-lg-offset-2 col-lg-10">
	<input class="btn update" type="submit" id="submit" value="Submit" name="submit"/>
	<input name="cancel" class="btn" type="button" id="cancel-button" value="Cancel" onclick="parent.$.colorbox.close(); return false;" />
</div>
</form>
</div>

<script type="text/javascript" src="<?php _e($theme_url); ?>assets/jquery-validate/jquery.validate.js"></script>
<script type="text/javascript" src="<?php _e($theme_url); ?>assets/jquery-validate/additional-methods.js"></script>
<script type="text/javascript">
$(document).ready(function() {

	$("#photogallery_form").validate({
		rules: {
			'photoname[]': {
				required: true,
				accept: "image/jpeg, image/png, image/gif"
			}
		},
		messages:{
			'photoname[]':{
				required : "Please upload atleast one image",
				accept:"Only jpeg|png|gif file is allowed!"
			}
		}
	});

});
</script>
