<?php
    $action = 'add';

    if (isset($req['parent']) && $req['parent'] == 'edit-trending') {
        $action = 'edit';
        if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            _error(404);
            exit;
        }
        $trending_id = $_GET['id'];
        $trendingDetail = $cont_obj->getTrending("f.id=".$trending_id, 'single');
	}


	$studio = $cont_obj->getContents(" and strContentType = 's'");

?>
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>assets/bootstrap-fileupload/bootstrap-fileupload.css" />
<div class="col-lg-12">
    <form id="trending_form" name="trending_form" method="post" class="cmxform form-horizontal tasi-form" action="<?php _e($module_url); ?>/manager/do" enctype="multipart/form-data">
        <input type="hidden" name="action" id="action" value="<?php _e($action);?>-trending"/>
        <?php if ($action == 'edit') { ?>
        <input type="hidden" name="id" id="id" value="<?php _e($trendingDetail['id']);?>"/>
            <input type="hidden" id="old_image" name="old_image" value="<?php _e(!empty($trendingDetail['strImageName']) ? $trendingDetail['strImageName'] : '');?>">
        <?php } ?>
        <section class="panel">
            <header class="panel-heading">Add Trending</header>
            <div class="panel-body">
                <div class="form">
                    <div class="form-group">
                        <label for="title" class="control-label col-lg-2">Trending Name:</label>
                        <div class="col-lg-7">
                            <input type="text" name="name" id="name" maxlength="255" value="<?php echo @$trendingDetail['strTrendingName']; ?>" class="form-control required"/>
                        </div>
                    </div>
					<div class="form-group">
						<label for="description" class="control-label col-lg-2">Description:</label>
						<div class="col-lg-7">
							<textarea name="description" id="description" class="form-control" rows="5"><?php echo @$trendingDetail['strDescription'];?></textarea>
						</div>
					</div>
                    <div class="form-group">
                        <label for="cont_type" class="control-label col-lg-2">Select Studio:</label>
                        <div class="col-lg-2">
                            <select name="studio" id="studio" class="form-control required">
                                <option value="">Select Studio</option>
								<?php if( isset($studio) && !empty($studio) ) {
									foreach($studio as $st){   ?>
								<option <?php if(@$trendingDetail['idContent']==$st['id']){?> selected="selected" <?php }?> value="<?php _e($st['id'])?>">
									<?php _e($st['strTitle'])?>
								</option>
								<?php } }  ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php
                            if(isset($trendingDetail['strImageName']) && !empty($trendingDetail['strImageName'])) {
                                if ($action = 'edit' && file_exists(UPLOAD_PATH . 'content/' . @$trendingDetail['strImageName'])) {
                                    $imgurl = SITE_URL . 'file-manager/content/' . $trendingDetail['strImageName'];
                                } else {
                                    $imgurl = SITE_URL . 'themes/default/img/no-image.gif';
                                }
                            }else{
                                $imgurl = SITE_URL . 'themes/default/img/no-image.gif';
                            }

                        ?>
                        <label for="content" class="control-label col-lg-2">Photo:</label>
                        <div class="col-md-9">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="<?php _e(@$imgurl);?>" alt="">
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                <div>
                               <span class="btn btn-white btn-file">
                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                <input type="file" class="default" id="imgurl" name="imgurl" />
                              </span>
                                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group"></div>
                </div>

            </div>
        </section>
        <div class="col-lg-offset-2 col-lg-10">
            <input class="btn btn-info" type="submit" id="submit" value="Submit" name="submit"/>
            <input name="cancel" class="btn btn-danger" type="button" id="cancel-button" value="Cancel" onClick="window.location='trendings'"/>
        </div>
    </form>
</div>
<script type="text/javascript" src="<?php _e($theme_url); ?>assets/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script type="text/javascript" src="<?php _e($theme_url); ?>assets/jquery-validate/jquery.validate.js"></script>
<script type="text/javascript" src="<?php _e($theme_url); ?>assets/ckeditor/ckeditor.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#trending_form").validate();
    });
</script>

