<?php
    if (isset($req['parent']) && $req['parent'] == 'edit') {
        $careerDetail = $career_obj->getCareer("id=$_GET[id]");

    }
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
<div class="col-lg-12">
   <form id="career_form" name="career_form" method="post" class="cmxform form-horizontal tasi-form" action="<?php _e($module_url);?>/manager/do" enctype="multipart/form-data">
      <input type="hidden" name="action" id="action" value="<?php if ($req['parent'] == 'add') {
                echo 'add';
      } else if ($req['parent'] == 'edit') {
         echo 'edit';
     } ?>"/>
     <input type="hidden" name="id" id="id" value="<?php if ($req['parent'] == 'edit') {
            echo $careerDetail['id'];
        } ?>"/>
    <section class="panel">
       <header class="panel-heading">Content Details</header>
         <div class="panel-body">
             <div class="form">
                <div class="form-group">
                    <label for="title" class="control-label col-lg-2">Title:</label>
                    <div class="col-lg-7">
                       <input type="text" name="title" id="title" maxlength="255" value="<?php echo @$careerDetail['strTitle']; ?>" class="form-control required"/>
                    </div>
                </div>

                 <div class="form-group">
                     <label for="code" class="control-label col-lg-2">Code:</label>
                     <div class="col-lg-7">
                         <input type="text" name="code" id="code" maxlength="255" value="<?php echo @$careerDetail['strCode']; ?>" class="form-control required"/>
                     </div>
                 </div>


                <div class="form-group">
                    <label for="content" class="control-label col-lg-2">Description:</label>
                    <div class="col-lg-7">
                      <textarea name="content" id="content" class="form-control ckeditor required" rows="15"><?php echo @$careerDetail['strDescription'];?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="pdf_file" class="control-label col-lg-2">Pdf File:</label>
                    <div class="col-lg-7">
                        <input type="file" name="pdf_file" id="pdf_file" class="form-control" />
                        <?php if ($req['parent'] == 'edit' && $careerDetail['strPdfFile'] != "") { ?>
                            <a href="<?php echo SITE_URL . 'file-manager/career/pdf/' . $careerDetail['strPdfFile'] ?>" target="_blank"><?php echo $careerDetail['strPdfFile']; ?></a>
                            <input type="hidden" name="h_pdffile" id="h_pdffile" value="<?php echo @$careerDetail['strPdfFile'];?>">
                        <?php } ?>
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

<script type="text/javascript" src="<?php _e($theme_url);?>assets/jquery-validate/jquery.validate.js"></script>
<script type="text/javascript" src="<?php _e($theme_url);?>assets/ckeditor/ckeditor.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    $("#career_form").validate({
        rules: {
            content: {
                required: function() {
                    CKEDITOR.instances.content.updateElement();
                }
            },pdf_file: {
                extension: "pdf"
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
            }
        }
    });

});

</script>

