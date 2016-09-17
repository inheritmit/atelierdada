<?php
/**
 * Created by yogesh.
 * Modules : Content
 * Date: 27/4/16
 */
?>

<?php
if (isset($req['parent']) && $req['parent'] == 'edit') {
	$action = 'edit';
	$contentDetail = $cont_obj->getContent("id=$_GET[id]");
}
	echo $req['parent'];

$productData = $cont_obj->getContents(" and strContentType='p' ");
$csData = $cont_obj->getContents(" and strContentType='c' ");
// pr($csData);
?>
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>assets/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css" media="all"/>
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>css/inputosaurus.css" rel="stylesheet" type="text/css" media="all"/>


<div class="col-lg-12">
	<form id="content_form" name="content_form" method="post" class="cmxform form-horizontal tasi-form" action="<?php _e($module_url);?>/manager/do" enctype="multipart/form-data">
		<input type="hidden" name="action" id="action" value="<?php if ($req['parent'] == 'selectpc') {
			echo 'addpc';
		} else if ($req['parent'] == 'edit') {
			echo 'editpc';
		} ?>"/>
		<input type="hidden" name="id" id="id" value="<?php if ($req['parent'] == 'edit') {
			echo $contentDetail['id'];
		} ?>"/>
		<input type="hidden" id="contentid" name="contentid" value="<?php echo $_GET['id'];  ?>">

		<?php // print_r($products); ?>

		<section class="panel">
			<header class="panel-heading">Projects and Case-Studies</header>
			<div class="panel-body">
				<div class="form">
					<div class="form-group">
						<label for="products" class="control-label col-lg-11">Products:</label>
						<?php foreach($productData as $value){?>
						<div class="col-lg-10">
							<input type="checkbox" name="products[]"  value="<?php echo @$value['id']; ?>" /><?php echo @$value['strTitle']; ?>
						</div>
						<?php } ?>
					</div>

					<div class="form-group">
						<label for="casestudies" class="control-label col-lg-11">Case Studies:</label>
						<?php foreach($csData as $value){?>
							<div class="col-lg-10">
								<input type="checkbox" name="casestudies[]"  value="<?php echo @$value['id']; ?>" /><?php echo @$value['strTitle']; ?>
							</div>
						<?php } ?>
					</div>




				</div>
			</div>
		</section>
		<div class="col-lg-offset-2 col-lg-10">
			<input class="btn btn-info" type="submit" id="submit" value="Submit" name="submit"/>
			<input name="cancel" class="btn btn-danger" type="button" id="cancel-button" value="Cancel" onClick="window.location='list'"/>
		</div>
	</form>
</div>

<script type="text/javascript" src="<?php _e($theme_url);?>assets/jquery-validate/jquery.validate.js"></script>
<script type="text/javascript" src="<?php _e($theme_url);?>assets/jquery-validate/additional-methods.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$("#content_form").validate({
			rules: {
				content: {
					required: function() {
						CKEDITOR.instances.content.updateElement();
					}
				},pdf_file: {
					extension: "pdf"
				},imgurl: {
					extension: "jpg,jpeg,JPG,JPEG,png,gif"
				}
			},
			errorPlacement: function(error, element){
				if (element.attr("name") == "content") {
					error.insertAfter("textarea#content");
				} else {
					error.insertAfter(element);
				}
			},messages:{
				pdf_file: {
					required: "Please upload resume",
					extension: "Please upload only pdf file formats"
				},imgurl: {
					extension: "Please upload only jpg,jpeg,JPG,JPEG,png,gif file formats"
				}
			}
		});

		$('#tag').inputosaurus({
			width : '350px',
			autoCompleteSource : [<?php echo $tag_data; ?>],
			activateFinalResult : true,
			change : function(ev){
				$('#final_tag').val(ev.target.value);
			}
		});
	});
	$(function(){
		$('#content_date').datepicker({
			format: 'dd-mm-yyyy'
		});
	});
</script>

