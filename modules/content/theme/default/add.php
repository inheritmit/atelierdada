<?php
    if (isset($req['parent']) && $req['parent'] == 'edit') {
        $action = 'edit';
        $contentDetail = $cont_obj->getContent("id=$_GET[id]");
    }

    _module('master');
    $master_obj = new master();
    $where="enmStatus='1' and enmDeleted='0'";
    $category=$master_obj->getMasters($where,'category');
    $tags = $master_obj->getMasters($where,'tag');
    foreach($tags as $tag) {
        $tag_title[] = "'" . $tag['strTag'] . "'";
    }
    $tag_data = implode(',', $tag_title);
?>
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>assets/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css" media="all"/>
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>assets/bootstrap-fileupload/bootstrap-fileupload.css" />
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>assets/bootstrap-datepicker/css/datepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>css/inputosaurus.css" rel="stylesheet" type="text/css" media="all"/>

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
<div class="col-lg-12">
   <form id="content_form" name="content_form" method="post" class="cmxform form-horizontal tasi-form" action="<?php _e($module_url);?>/manager/do" enctype="multipart/form-data">
      <input type="hidden" name="action" id="action" value="<?php if ($req['parent'] == 'add') {
                echo 'add';
      } else if ($req['parent'] == 'edit') {
         echo 'edit';
     } ?>"/>
     <input type="hidden" name="id" id="id" value="<?php if ($req['parent'] == 'edit') {
            echo $contentDetail['id'];
        } ?>"/>
       <input type="hidden" id="old_cover" name="old_cover" value="<?php echo isset($contentDetail) ? _e($contentDetail['strContentImg']) : '';  ?>">
    <section class="panel">
       <header class="panel-heading">Content Details</header>
         <div class="panel-body">
             <div class="form">
                <div class="form-group">
                    <label for="title" class="control-label col-lg-2">Title:</label>
                    <div class="col-lg-7">
                       <input type="text" name="title" id="title" maxlength="255" value="<?php echo @$contentDetail['strTitle']; ?>" class="form-control required"/>
                    </div>
                </div>


                <div class="form-group">
                    <label for="description" class="control-label col-lg-2">Description:</label>
                    <div class="col-lg-7">
                      <textarea name="content" id="content" class="form-control ckeditor required" rows="15"><?php echo @$contentDetail['strDescription'];?></textarea>
                    </div>
                </div>


                <div class="form-group">
                   <label for="cont_type" class="control-label col-lg-2">Content Type:</label>
                   <div class="col-lg-2">
                        <select name="cont_type" id="cont_type" class="form-control required">
                             <option value="">Select Type</option>
                            <option <?php if(@$contentDetail['strContentType']=='n'){?> selected="selected" <?php }?> value="n">News</option>
                            <option <?php if(@$contentDetail['strContentType']=='e'){?> selected="selected" <?php }?> value="e">Events</option>
                            <option <?php if(@$contentDetail['strContentType']=='p'){?> selected="selected" <?php }?> value="p">Product</option>
                            <option <?php if(@$contentDetail['strContentType']=='s'){?> selected="selected" <?php }?> value="s">Studio</option>
                            <option <?php if(@$contentDetail['strContentType']=='r'){?> selected="selected" <?php }?> value="r">Research</option>
                            <option <?php if(@$contentDetail['strContentType']=='c'){?> selected="selected" <?php }?> value="c">Case Studies</option>
                        </select>
                   </div>
                </div>


                 <div class="form-group">
				   <label class="control-label col-lg-2" for="content_date">Content Date:</label>
					<div data-date-viewmode="years" data-date-format="dd-mm-yyyy"
						 data-date="<?php  if(isset($contentDetail['dtContent']) && !empty($contentDetail['dtContent'])){
							 echo date('d-m-Y',strtotime($contentDetail['dtContent']));}?>"
						 class="col-lg-2 input-append date dpYears">
						<input type="text" readonly="readonly" value="<?php  if(isset($contentDetail['dtContent']) && !empty($contentDetail['dtContent'])){ echo date('d-m-Y',strtotime($contentDetail['dtContent']));}?>" size="16" name="content_date" id="content_date" class="form-control required" />(dd-mm-yyyy)
					</div>
               </div>

               <div class="form-group">
                 <?php
                   if (@$contentDetail['strContentType'] == 'n') {
                        $path = 'news/';
                   }elseif(@$contentDetail['strContentType']=='p'){

                        $path = 'product/';
                   }elseif(@$contentDetail['strContentType']=='e'){
                         $path = 'events/';
                   }elseif(@$contentDetail['strContentType']=='s'){
					   $path = 'studio/';
				   }elseif(@$contentDetail['strContentType']=='r'){
					   $path = 'research/';
				   }elseif(@$contentDetail['strContentType']=='c'){
					   $path = 'casestudies/';
				   }
                  if(isset($contentDetail['strContentImg']) && !empty($contentDetail['strContentImg'])) {
                    //echo UPLOAD_PATH . 'content/' . @$path . @$contentDetail['strContentImg']; exit;
                       if ($action = 'edit' && file_exists(UPLOAD_PATH . 'content/' . @$path . @$contentDetail['strContentImg'])) {
                        $imgurl = SITE_URL . 'file-manager/content/' . $path . $contentDetail['strContentImg'];

                        } else {
                        $imgurl = SITE_URL . 'themes/default/img/no-image.gif';
                        }
                  }else{
                        $imgurl = SITE_URL . 'themes/default/img/no-image.gif';
                  }

                 ?>
                  <label for="content" class="control-label col-lg-2">Cover Photo:</label>
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

                 <div class="form-group">
                     <label for="tag" class="control-label col-lg-2">Tag</label>
                     <div class="col-mg-9">
                         <?php
                            if (isset($req['parent']) && $req['parent'] == 'edit') {
                                $get_tags = $cont_obj->getRelTag($_GET['id']);
                                if($get_tags != 404){
                                    foreach($get_tags as $get_tag) {
                                        $tag_name_data[] = $get_tag['tag_name'];
                                    }
                                    $edit_tag_name = implode(',', $tag_name_data);
                                }
                            }
                         ?>
                         <input type="text" class="form-control required" name="tag" id="tag" value="<?php echo @$edit_tag_name; ?>">
                         <input type="hidden" name="final_tag" id="final_tag">

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

<script type="text/javascript" src="<?php _e($theme_url);?>js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php _e($theme_url);?>js/inputosaurus.js"></script>
<script type="text/javascript" src="<?php _e($theme_url);?>assets/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script type="text/javascript" src="<?php _e($theme_url);?>assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php _e($theme_url);?>assets/jquery-validate/jquery.validate.js"></script>
<script type="text/javascript" src="<?php _e($theme_url);?>assets/jquery-validate/additional-methods.js"></script>
<script type="text/javascript" src="<?php _e($theme_url);?>assets/ckeditor/ckeditor.js"></script>

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

