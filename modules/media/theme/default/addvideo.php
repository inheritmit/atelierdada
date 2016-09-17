<?php
if(isset($req['parent']) && $req['parent'] == 'editvideo') {
    $videoDetail = $media_obj->getVideo("id=$_GET[id]");
}

_module('master');
$mstObj = new master();
$categories = $mstObj->getMasters(1, 'category');
?>
<link href="<?php _e($theme_url);?>assets/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css" media="all"/>
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>assets/bootstrap-fileupload/bootstrap-fileupload.css" />
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>assets/bootstrap-datepicker/css/datepicker.css" />

<div class="col-lg-12">
<h3 class="timeline-title"><i class="fa fa-file-text-o"></i> &nbsp; Video Album</h3>

<form id="video_form" name="video_form" method="post" action="<?php _e($module_url); ?>/videomanager/do" class="cmxform form-horizontal tasi-form" >
    <input type="hidden" name="action" id="action" value="<?php if ($req['parent'] == 'addvideo') {
        echo 'add';
    } else if ($req['parent'] == 'editvideo') {
        echo 'edit';
    } ?>"/>
    <input type="hidden" name="id" id="id" value="<?php if ($req['parent'] == 'editvideo') {
        echo $videoDetail['id'];
    } ?>"/>

<section class="panel">
<header class="panel-heading">Video Details</header>
<div class="panel-body">
    <div class="form">

        <div class="form-group">
            <label for="media_type" class="control-label col-lg-2">Media Type:</label>
            <div class="col-lg-2">
                <select name="media_type" id="media_type" class="form-control required">
                    <option value="">Select Type</option>
                    <option <?php if(@$videoDetail['enmType']=='Audio'){?> selected="selected" <?php }?> value="Audio">Audio</option>
                    <option <?php if(@$videoDetail['enmType']=='Video'){?> selected="selected" <?php }?> value="Video">Video</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="category" class="control-label col-lg-2">Category:</label>
            <div class="col-lg-10">
                <select name="category" id="category" class="form-control required">
                    <option value="" selected="selected"> -- Select -- </option>
                    <?php foreach($categories as $cat){ ?>
                    <option value="<?php echo $cat['id'];?>"<?php if(@$videoDetail['idCategory']==$cat['id']) { ?> selected="selected"<?php } ?>>
                        <?php echo $cat['strCategory'];?>
                    </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="video_date" class="control-label col-lg-2">Video Date:</label>
            <div data-date-viewmode="years" data-date-format="dd-mm-yyyy"
                 data-date="<?php  if(isset($videoDetail['dtVideo']) && !empty($videoDetail['dtVideo'])){
                     echo date('d-m-Y',strtotime($videoDetail['dtVideo']));}?>"
                 class="col-lg-2 input-append date dpYears">
                <input type="text"  readonly value="<?php  if(isset($videoDetail['dtVideo']) && !empty($videoDetail['dtVideo'])){
                    echo date('d-m-Y',strtotime($videoDetail['dtVideo']));
                }?>" size="16" name="video_date" id="video_date" class="form-control required" />(dd-mm-yyyy)
            </div>
        </div>

        <div class="form-group">
            <label for="videoname" class="control-label col-lg-2">Video Name:</label>
            <div class="col-lg-10">
                <input type="text" name="videoname" id="videoname" value="<?php echo @$videoDetail['strName']; ?>" class="form-control required"/>
            </div>
        </div>
        <div class="form-group">
            <label for="videourl" class="control-label col-lg-2">Video url:</label>
            <div class="col-lg-10">
                <input type="text" name="videourl" id="videourl" value="<?php echo @$videoDetail['txtUrl']; ?>" class="form-control required"/>
            </div>
        </div>
    </div>
</div>
</section>

<div class="col-lg-offset-2 col-lg-10">
    <input class="btn btn-info" type="submit" id="submit" value="Submit" name="submit"/>
    <input name="cancel" class="btn btn-danger" type="button" id="cancel-button" value="Cancel" onClick="window.location='videolist'"/>
</div>
</form>
</div>
<script type="text/javascript" src="<?php _e($theme_url); ?>assets/jquery-validate/jquery.validate.js"></script>
<script type="text/javascript" src="<?php _e($theme_url);?>assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#video_form").validate();

        $('#video_date').datepicker({
            format: 'dd-mm-yyyy'
        });
    });
</script>