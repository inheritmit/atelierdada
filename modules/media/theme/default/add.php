<?php
if(isset($req['parent']) && $req['parent'] == 'edit') {
    $photoDetail = $media_obj->getPhoto("id=$_GET[id]");
}

_module('master');
$mstObj = new master();
$categories = $mstObj->getMasters(1, 'category');
?>
<style type="text/css">
    textarea.ckeditor {
        visibility: visible !important;
        display: block !important;
        height: 0 !important;
        border: none !important;
        resize:none;
        overflow: hidden;
        padding: 0 !important;
    }

</style>
<link href="<?php _e($theme_url);?>assets/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css" media="all"/>
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>assets/bootstrap-fileupload/bootstrap-fileupload.css" />
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>assets/bootstrap-datepicker/css/datepicker.css" />

<div class="col-lg-12">
<!--<h3 class="timeline-title"><i class="fa fa-file-text-o"></i> &nbsp; Photo Album
    <a href="<?php /*echo _e($module_url); */?>/add" class="btn btn-primary ar"><i class="fa fa-plus"></i> Add New</a><div class="clear"></div>
</h3>-->

<form id="photo_form" name="photo_form" method="post" class="cmxform form-horizontal tasi-form" action="<?php _e($module_url); ?>/manager/do">
    <input type="hidden" name="action" id="action" value="<?php if ($req['parent'] == 'add') {
        echo 'add';
    } else if ($req['parent'] == 'edit') {
        echo 'edit';
    } ?>"/>
    <input type="hidden" name="id" id="id" value="<?php if ($req['parent'] == 'edit') {
        echo $photoDetail['id'];
    } ?>"/>

<section class="panel">
<header class="panel-heading">Album Details</header>
<div class="panel-body">
    <div class="form">
        <div class="form-group">
            <label for="category" class="control-label col-lg-2">Category:</label>
            <div class="col-lg-10">
                <select name="category" id="category" class="form-control required">
                    <option value="" selected="selected"> -- Select -- </option>
                    <?php foreach($categories as $cat){ ?>
                    <option value="<?php echo $cat['id'];?>"<?php if(@$photoDetail['idCategory']==$cat['id']) { ?> selected="selected"<?php } ?>><?php echo
                        $cat['strCategory'];?>
                    </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="media_date" class="control-label col-lg-2">Photo Date:</label>
            <div data-date-viewmode="years" data-date-format="dd-mm-yyyy"
                 data-date="<?php  if(isset($photoDetail['dtPhoto']) && !empty($photoDetail['dtPhoto'])){
                     echo date('d-m-Y',strtotime($photoDetail['dtPhoto']));}?>"
                 class="col-lg-2 input-append date dpYears">
                <input type="text" readonly value="<?php  if(isset($photoDetail['dtPhoto']) && !empty($photoDetail['dtPhoto'])){
                    echo date('d-m-Y',strtotime($photoDetail['dtPhoto']));
                }?>" size="16" name="media_date" id="media_date" class="form-control required" />(dd-mm-yyyy)
            </div>
        </div>

        <div class="form-group">
            <label for="photoname" class="control-label col-lg-2">Album Name:</label>
            <div class="col-lg-10">
                <input type="text"  maxlength="50" name="photoname" id="photoname" value="<?php echo @$photoDetail['strName']; ?>" class="form-control required"/>
            </div>
        </div>
        <div class="form-group">
            <label for="description" class="control-label col-lg-2">Album Description:</label>

            <div class="col-lg-10">
                <textarea name="description" id="description" class="required form-control ckeditor " rows="2">
                    <?php echo @$photoDetail['txtDescription']; ?>
                </textarea>
            </div>
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

<script type="text/javascript" src="<?php _e($theme_url); ?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php _e($theme_url); ?>assets/jquery-validate/jquery.validate.js"></script>
<script type="text/javascript" src="<?php _e($theme_url);?>assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        $("#photo_form").validate({
            rules: {
                description: {
                    required: function() {
                        CKEDITOR.instances.description.updateElement();
                    }
                }
            },
            errorPlacement: function(error, element)
            {
                if (element.attr("name") == "description") {
                    error.insertBefore("textarea#description");
                } else {
                    error.insertAfter(element);
                }
            }
        });


        $('#media_date').datepicker({
            format: 'dd-mm-yyyy'
        });
    });
</script>
