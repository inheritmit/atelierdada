<?php
    _subModule('content', 'block');
    $block_obj = new block();

    $action = 'add';
    $product_id = $studio_id = 0;
    $blocks = $image_blocks = $mobile_blocks = array();
    if (isset($req['parent']) && $req['parent'] == 'edit-content') {
        $action = 'edit';

        if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            _error(404);
            exit;
        }

        $content_id = $_GET['id'];

        $contentDetail = $cont_obj->getContent("id=".$content_id);

        $blocks_details = $block_obj->getBlockDetailsByContentID($content_id);

        if($blocks_details != 404) {
            foreach($blocks_details as $block) {
                $block_slug = $block['block_slug'];
                $content_block_id = $block['content_block_id'];
                $blocks[$content_block_id] = $block;
                if($block['block_slug'] == 'image') {
                    $image_blocks[$content_block_id][]  = $block;
                }

                if($block['block_slug'] == 'mobile') {
                    $type = $block['strType'];
                    $mobile_blocks[$content_block_id][$type]  = $block;
                }
            }
        }
    }

    _module('master');
    $master_obj = new master();
    $where = "enmStatus='1' and enmDeleted='0'";
    $category = $master_obj->getMasters($where, 'category');

    $tags = $master_obj->getMasters($where, 'tag');
    foreach($tags as $tag) {
        $tag_title[] = "'" . $tag['strTag'] . "'";
    }
    $tag_data = implode(',', $tag_title);
?>
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>assets/jquery-ui/jquery-ui.min.css" media="all"/>
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>assets/bootstrap-fileupload/bootstrap-fileupload.css" />
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>assets/bootstrap-datepicker/css/datepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>vendor/inputosaurus/css/inputosaurus.css" media="all"/>
<style type="text/css">
    textarea.ckeditor {
        visibility: visible !important;
        display: block !important;
        height: 0 !important;
        border: none !important;
        resize: none;
        overflow: hidden;
        padding: 0 !important;
    }
</style>
<div class="row">
    <form id="content_form" name="content_form" method="post" class="cmxform form-horizontal tasi-form" action="<?php _e($module_url); ?>/manager/do" enctype="multipart/form-data">
        <input type="hidden" name="action" id="action" value="<?php _e($action);?>-content"/>
        <?php if ($action == 'edit') { ?>
            <input type="hidden" name="id" id="id" value="<?php _e($contentDetail['id']);?>"/>
            <input type="hidden" id="old_image" name="old_image" value="<?php _e(!empty($contentDetail['strContentImg']) ? $contentDetail['strContentImg'] : '');?>">
            <input type="hidden" id="old_product" name="old_product" value="<?php _e($product_id);?>">
            <input type="hidden" id="old_studio" name="old_studio" value="<?php _e($studio_id);?>">
        <?php } ?>
        <div class="col-lg-8">
            <section class="panel">
                <header class="panel-heading">Content Details</header>
                <div class="panel-body">
                    <div class="form">
                        <div class="form-group">
                            <label for="title" class="control-label col-lg-2">Title:</label>

                            <div class="col-lg-10">
                                <input type="text" name="title" id="title" maxlength="255"
                                       value="<?php echo @$contentDetail['strTitle']; ?>"
                                       class="form-control required"/>
                            </div>
                        </div>

                        <div class="form-group"></div>
                    </div>
                    <?php
                        $content_blocks = $block_obj->getBlocks();

                        if($content_blocks != 404) {
                            ?>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-lg-2">Quick Add</label>

                                    <div class="col-lg-8">
                                        <?php
                                            foreach($content_blocks as $block) {

                                                if($block['enmStatus'] == '1') {

                                                    $class_add = ($block['strSlug'] == 'text') ? ' page-load' : '';
                                                    ?>
                                                    <a class="content_block btn btn-info btn-xs<?php _e($class_add);?>"
                                                       onclick="location.href='javascript:void(0);'"
                                                       data-type="<?php _e($block['strSlug']); ?>"
                                                       data-id="<?php _e($block['id']); ?>"><i
                                                            class="fa fa-plus"></i> <?php _e($block['strContentBlock']); ?>
                                                    </a>
                                                    <?php
                                                }

                                                /*if($block['enmStatus'] == '0') {
                                                    */ ?><!--
                                                <a class="btn btn-default btn-xs" onclick="location.href='javascript:void(0);'"><i class="fa fa-plus"></i> <?php /*_e($block['strContentBlock']); */ ?></a>
                                                --><?php
                                                /*                                            }*/
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div id="content-blocks" class="sortable">
                                    <div
                                        class="form-group no-entries"<?php if(sizeof($blocks) > 0) { ?> style="display: none;"<?php } ?>>
                                        <label>Use quick links to add specific content blocks</label>
                                    </div>
                                    <?php
                                        $cnt = $icnt = 1;
                                        if(sizeof($blocks) > 0) {
                                            foreach($blocks as $block) { //pr($block, false);

                                                $slug = $block['block_slug'];

                                                $content_block_id = $block['content_block_id'];

                                                if($block['content_block_status'] == '1') {
                                                    $class = "class='fa fa-eye _green ajaxButton btn btn-success'";
                                                    $title = "title='Click to Deactivate'";
                                                } else {
                                                    $class = "class='fa fa-eye-slash _red ajaxButton btn btn-danger'";
                                                    $title = "title='Click to Activate'";
                                                }

                                                $block_actions = '<div class="col-lg-offset-6 col-lg-3"><input type="text" name="'.$slug.'_position['.$cnt.']" id="'.$slug.'_position_'.$cnt.'" maxlength="2" value="'.$cnt.'" class="form-control input-sm position" placeholder="Position" title="Content Block Position" /></div><div class="row col-lg-3"><a onclick="location.href=\'javascript:void(0);\'" class="fa fa-trash-o btn btn-danger" onclick="deleteBlock('.$cnt.');" title="Delete Content Block"></a></div>';

                                                ?>
                                                <input type="hidden" name="content_block_id[<?php _e($cnt); ?>]"
                                                       id="content_block_id_<?php _e($cnt); ?>"
                                                       value="<?php _e($content_block_id); ?>"/>
                                                <?php
                                                if($slug == 'text') {
                                                    ?>
                                                    <div class="form-group" id="block<?php _e($cnt); ?>">
                                                        <input type="hidden" name="block[<?php _e($cnt); ?>]"
                                                               id="block_<?php _e($cnt); ?>"
                                                               value="<?php _e($slug); ?>"/>
                                                        <input type="hidden" name="block_id[<?php _e($slug); ?>]"
                                                               id="block_id_<?php _e($cnt); ?>"
                                                               value="<?php _e($block['block_id']); ?>"/>

                                                        <div class="row">
                                                            <div class="col-lg-8">
                                                                <label for="<?php _e($slug); ?>_<?php _e($cnt); ?>"
                                                                       class="control-label col-lg-6">Descriptive
                                                                    Text:</label>

                                                            </div>
                                                            <div class="col-lg-4"><?php _e($block_actions);?></div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <textarea name="<?php _e($slug); ?>[<?php _e($cnt); ?>]"
                                                                      id="<?php _e($slug); ?>_<?php _e($cnt); ?>"
                                                                      class="form-control ckeditor"
                                                                      rows="15"><?php _e($block['txtContent']); ?></textarea>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }

                                                if($slug == 'file-upload') {
                                                    ?>
                                                    <div class="form-group" id="block<?php _e($cnt); ?>">
                                                        <input type="hidden" name="block[<?php _e($cnt); ?>]"
                                                               id="block_<?php _e($cnt); ?>"
                                                               value="<?php _e($slug); ?>"/>
                                                        <input type="hidden" name="block_id[<?php _e($slug); ?>]"
                                                               id="block_id_<?php _e($cnt); ?>"
                                                               value="<?php _e($block['block_id']); ?>"/>

                                                        <div class="row">
                                                            <div class="col-lg-8">
                                                                <label for="<?php _e($slug); ?>_<?php _e($cnt); ?>"
                                                                       class="control-label col-lg-6">File
                                                                    Upload: </label>
                                                            </div>
                                                            <div class="col-lg-4"><?php _e($block_actions); ?></div>
                                                        </div>

                                                        <div class="col-lg-12">
                                                            <div class="col-lg-10 row">
                                                                <input type="text"
                                                                       name="<?php _e($slug); ?>_title[<?php _e($cnt); ?>]"
                                                                       id="<?php _e($slug); ?>_title_<?php _e($cnt); ?>"
                                                                       maxlength="100"
                                                                       value="<?php _e($block['block_heading']); ?>"
                                                                       class="form-control"
                                                                       placeholder="Heading"/>
                                                            </div>
                                                            <div class="col-lg-10 row">
                                                                <a
                                                                    href="<?php _e(UPLOAD_URL); ?>content/<?php _e($block['txtContent']); ?>"
                                                                    target="_blank">Uploaded File</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }

                                                if($slug == 'image') {
                                                    ?>
                                                    <div class="form-group" id="block<?php _e($cnt); ?>">
                                                        <input type="hidden" name="block[<?php _e($cnt); ?>]"
                                                               id="block_<?php _e($cnt); ?>"
                                                               value="<?php _e($slug); ?>"/>
                                                        <input type="hidden" name="block_id[<?php _e($slug); ?>]"
                                                               id="block_id_<?php _e($cnt); ?>"
                                                               value="<?php _e($block['block_id']); ?>"/>
                                                        <div class="row">
                                                            <div class="col-lg-8">
                                                        <label for="<?php _e($slug); ?>_<?php _e($cnt); ?>"
                                                               class="control-label col-lg-6">Images: <a
                                                                onclick="location.href='javascript:void(0);'"
                                                                class="add-more btn btn-success btn-xs"
                                                                data-count="<?php _e($cnt); ?>"
                                                                data-type="<?php _e($slug); ?>"><i
                                                                    class="fa fa-plus"></i> More</a></label>
                                                            </div>
                                                            <div class="col-lg-4"><?php _e($block_actions); ?></div>
                                                        </div>

                                                        <div class="col-lg-12" id="images<?php _e($cnt); ?>">
                                                            <div class="col-lg-10">
                                                                <input type="text"
                                                                                          name="<?php _e($slug); ?>_title[<?php _e($cnt); ?>]"
                                                                                          id="<?php _e($slug); ?>_title_<?php _e($cnt); ?>"
                                                                                          maxlength="100"
                                                                                          value="<?php _e($block['block_heading']); ?>"
                                                                                          class="form-control"
                                                                                          placeholder="Heading"/>
                                                            </div>
                                                            <?php
                                                                if(isset($image_blocks[$content_block_id])) {
                                                                    foreach($image_blocks[$content_block_id] as $iblock) {
                                                                        ?>
                                                                        <div class="col-lg-4">
                                                                            <img src="<?php _e(UPLOAD_URL); ?>content/thumbs/<?php _e($iblock['txtContent']); ?>" alt="image<?php _e($cnt); ?>"/>
                                                                        </div>
                                                                        <?php
                                                                        $icnt++;
                                                                    }
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }

                                                if($slug == 'social' && sizeof($block_obj::$SocialShare) > 0) {
                                                    ?>
                                                    <div class="form-group" id="block<?php _e($cnt); ?>">
                                                        <input type="hidden" name="block[<?php _e($cnt); ?>]"
                                                               id="block_<?php _e($cnt); ?>"
                                                               value="<?php _e($slug); ?>"/>
                                                        <input type="hidden" name="block_id[<?php _e($slug); ?>]"
                                                               id="block_id_<?php _e($cnt); ?>"
                                                               value="<?php _e($block['block_id']); ?>"/>
                                                        <div class="row">
                                                            <div class="col-lg-8">
                                                        <label for="<?php _e($slug); ?>_<?php _e($cnt); ?>"
                                                               class="control-label col-lg-6">Social Share:</label>
                                                            </div>
                                                            <div class="col-lg-4"><?php _e($block_actions); ?></div>
                                                        </div>

                                                        <div class="col-lg-12">
                                                            <div class="col-lg-10 row">
                                                                <input type="text"
                                                                                              name="<?php _e($slug); ?>_title[<?php _e($cnt); ?>]"
                                                                                              id="<?php _e($slug); ?>_title_<?php _e($cnt); ?>"
                                                                                              maxlength="100"
                                                                                              value="<?php _e($block['block_heading']); ?>"
                                                                                              class="form-control"
                                                                                              placeholder="Heading"/>
                                                            </div>
                                                            <div class="row">
                                                                <p>Select social sites to enable sharing for this content</p>
                                                                <?php foreach($block_obj::$SocialShare as $slug => $link) { ?>
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="social-<?php _e($slug);?>" value="<?php _e($slug);?>"> <i class="fa fa-<?php _e($slug);?>"></i>
                                                                </label>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }

                                                if($slug == 'mobile') {

                                                    $mobile_block_details = $mobile_blocks[$content_block_id];
                                                    ?>
                                                    <div class="form-group" id="block<?php _e($cnt); ?>">
                                                        <input type="hidden" name="block[<?php _e($cnt); ?>]"
                                                               id="block_<?php _e($cnt); ?>"
                                                               value="<?php _e($slug); ?>"/>
                                                        <input type="hidden" name="block_id[<?php _e($slug); ?>]"
                                                               id="block_id_<?php _e($cnt); ?>"
                                                               value="<?php _e($block['block_id']); ?>"/>
                                                        <div class="row">
                                                            <div class="col-lg-8">
                                                        <label for="<?php _e($slug); ?>_<?php _e($cnt); ?>"
                                                               class="control-label col-lg-2">Mobile Application
                                                            Links:</label>
                                                            </div>
                                                            <div class="col-lg-4"><?php _e($block_actions); ?></div>
                                                        </div>

                                                        <div class="col-lg-7 row">
                                                            <div class="row"><input type="text"
                                                                                    name="<?php _e($slug); ?>_title[<?php _e($cnt); ?>]"
                                                                                    id="<?php _e($slug); ?>_title_<?php _e($cnt); ?>"
                                                                                    maxlength="100"
                                                                                    value="<?php _e($block['block_heading']); ?>"
                                                                                    class="form-control"
                                                                                    placeholder="Heading"/></div>
                                                            <?php
                                                                foreach($block_obj::$_mobile_apps as $app) {
                                                                    ?>
                                                                    <div class="row"><input type="text"
                                                                                            name="<?php _e($slug); ?>_<?php _e($app); ?>[<?php _e($cnt); ?>]"
                                                                                            id="<?php _e($slug); ?>_<?php _e($app); ?>_<?php _e($cnt); ?>"
                                                                                            maxlength="255"
                                                                                            value="<?php _e(@$mobile_block_details[$app]['txtContent']); ?>"
                                                                                            class="form-control"/></div>
                                                                    <?php
                                                                    $icnt++;
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }

                                                $cnt++;
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="form-group">
                                <label>No content block is defined to add</label>
                            </div>
                            <?php
                        }
                    ?>
                </div>
            </section>
            <div class="col-lg-offset-2 col-lg-10">
                <input class="btn btn-info" type="submit" id="submit" value="Submit" name="submit"/>
                <input name="cancel" class="btn btn-danger" type="button" id="cancel-button" value="Cancel"
                       onClick="window.location='list'"/>
            </div>
        </div>
        <div class="col-lg-4">
            <section class="panel">
                <div class="panel-heading">Other Details</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="cont_type" class="control-label col-lg-3">Type:</label>

                        <div class="col-lg-9">
                            <select name="cont_type" id="cont_type" class="form-control required">
                                <option value="">Select Type</option>
                                <option <?php if(@$contentDetail['strContentType'] == 'n') { ?> selected="selected" <?php } ?>
                                    value="n">News
                                </option>
                                <option <?php if(@$contentDetail['strContentType'] == 'e') { ?> selected="selected" <?php } ?>
                                    value="e">Events
                                </option>
                                <option <?php if(@$contentDetail['strContentType'] == 'p') { ?> selected="selected" <?php } ?>
                                    value="p">Product
                                </option>
                                <option <?php if(@$contentDetail['strContentType'] == 's') { ?> selected="selected" <?php } ?>
                                    value="s">Studio
                                </option>
                                <option <?php if(@$contentDetail['strContentType'] == 'r') { ?> selected="selected" <?php } ?>
                                    value="r">Research
                                </option>
                                <option <?php if(@$contentDetail['strContentType'] == 'c') { ?> selected="selected" <?php } ?>
                                    value="c">Case Studies
                                </option>
                                <option <?php if(@$contentDetail['strContentType'] == 't') { ?> selected="selected" <?php } ?>
                                    value="t">Trending
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3" for="content_date">Date:</label>

                        <div data-date-viewmode="years" data-date-format="dd-mm-yyyy"
                             data-date="<?php if(isset($contentDetail['dtContent']) && !empty($contentDetail['dtContent'])) {
                                 echo date('d-m-Y', strtotime($contentDetail['dtContent']));
                             } ?>"
                             class="col-lg-9 input-append date dpYears">
                            <input type="text" readonly="readonly"
                                   value="<?php if(isset($contentDetail['dtContent']) && !empty($contentDetail['dtContent'])) {
                                       echo date('d-m-Y', strtotime($contentDetail['dtContent']));
                                   } ?>" size="16" name="content_date" id="content_date"
                                   class="form-control required"/>(dd-mm-yyyy)
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tag" class="control-label col-lg-3">Tag:</label>

                        <div class="col-lg-9">
                            <?php
                                if(isset($req['parent']) && $req['parent'] == 'edit-content') {
                                    $get_tags = $cont_obj->getRelTag($content_id);
                                    if($get_tags != 404) {
                                        foreach($get_tags as $get_tag) {
                                            $tag_name_data[] = $get_tag['tag_name'];
                                        }
                                        $edit_tag_name = implode(',', $tag_name_data);
                                    }
                                }
                            ?>
                            <input type="text" class="form-control required" name="tag" id="tag"
                                   value="<?php echo @$edit_tag_name; ?>">
                            <input type="hidden" name="final_tag" id="final_tag">

                        </div>
                    </div>
                </div>
            </section>

            <section class="panel">
                <div class="panel-heading">Cover Image</div>
                <div class="panel-body">
                    <div class="form-group">
                        <?php
                            if(isset($contentDetail['strContentImg']) && !empty($contentDetail['strContentImg'])) {
                                if($action = 'edit' && file_exists(UPLOAD_PATH . 'content/' . @$contentDetail['strContentImg'])) {
                                    $imgurl = UPLOAD_URL.'content/' . $contentDetail['strContentImg'];
                                } else {
                                    $imgurl = SITE_URL . 'themes/default/img/no-image.gif';
                                }
                            } else {
                                $imgurl = SITE_URL . 'themes/default/img/no-image.gif';
                            }

                        ?>
                        <div class="col-md-12">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="<?php _e(@$imgurl); ?>" alt="">
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail"
                                     style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                <div>
                               <span class="btn btn-white btn-file">
                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                <input type="file" class="default" id="imgurl" name="imgurl"/>
                              </span>
                                    <a href="#" class="btn btn-danger fileupload-exists"
                                       data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </form>
</div>
<script type="text/javascript" src="<?php _e($theme_url);?>assets/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php _e($theme_url);?>vendor/inputosaurus/js/inputosaurus.js"></script>
<script type="text/javascript" src="<?php _e($theme_url); ?>assets/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script type="text/javascript" src="<?php _e($theme_url); ?>assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php _e(ASSET_URL); ?>jquery-validate/jquery.validate.js"></script>
<script type="text/javascript" src="<?php _e($theme_url); ?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    var count = <?php _e($cnt);?>;
    $(document).ready(function () {

        $("#content_form").validate();

        $('#content_date').datepicker({
            format: 'dd-mm-yyyy'
        });

        addMoreImages();

        $('.content_block').click(function(){

            var contents = $('#content-blocks');
            contents.find('.no-entries').hide();

            var dtype = $(this).attr('data-type');
            var did = $(this).attr('data-id');

            var html = '<div class="form-group" id="block'+count+'"><input type="hidden" name="block['+count+']" id="block_'+count+'" value="'+dtype+'" /><input type="hidden" name="block_id['+dtype+']" id="block_id_'+count+'" value="'+did+'" />';

            var block_action = '<div class="col-lg-offset-6 col-lg-3"><input type="text" name="'+dtype+'_position['+count+']" id="'+dtype+'_position_'+count+'" maxlength="2" value="'+count+'" class="form-control input-sm position" placeholder="Position" title="Content Block Position" /></div><div class="row col-lg-3"><a onclick="location.href=\'javascript:void(0);\'" class="fa fa-trash-o btn btn-danger" onclick="deleteBlock('+count+');" title="Delete Content Block"></a></div>';

            if(dtype == 'text') {
                html += '<div class="row"><div class="col-lg-8"><label for="'+dtype+'_'+count+'" class="control-label col-lg-6">Descriptive Text:</label></div><div class="col-lg-4">'+block_action+'</div></div><div class="col-lg-12"><textarea name="'+dtype+'['+count+']" id="'+dtype+'_'+count+'" class="form-control ckeditor" rows="15"></textarea></div>';
            } else if(dtype == 'image') {
                html += '<div class="row"><div class="col-lg-8"><label for="'+dtype+'_'+count+'" class="control-label col-lg-6">Images: <a onclick="location.href=\'javascript:void(0);\'" class="add-more btn btn-success btn-xs" data-count="'+count+'" data-type="'+dtype+'"><i class="fa fa-plus"></i> More</a> </label></div><div class="col-lg-4">'+block_action+'</div></div><div class="col-lg-12" id="images'+count+'"><div class="col-lg-12 row"><input type="text" name="'+dtype+'_title['+count+']" id="'+dtype+'_title_'+count+'" maxlength="50" value="" class="form-control" placeholder="Heading" /></div><div class="col-lg-10 row"><input type="file" name="'+dtype+'['+count+'][]" id="'+dtype+'_'+count+'_1" value="" class="form-control" /></div><div class="col-lg-2"></div></div>';
            } else if(dtype == 'file-upload') {
                html += '<div class="row"><div class="col-lg-8"><label for="'+dtype+'_'+count+'" class="control-label col-lg-6">File Upload: </label></div><div class="col-lg-4">'+block_action+'</div></div><div class="col-lg-12"><div class="col-lg-10 row"><input type="text" name="'+dtype+'_title['+count+']" id="'+dtype+'_title_'+count+'" maxlength="50" value="" class="form-control" placeholder="Heading" /></div><div class="col-lg-10 row"><input type="file" name="'+dtype+'['+count+']" id="'+dtype+'_'+count+'" value="" class="form-control" /></div></div>';
            } else if(dtype == 'social') {
                html += '<div class="row"><div class="col-lg-8"><label for="'+dtype+'_'+count+'" class="control-label col-lg-6">Social Sharing:</label></div><div class="col-lg-4">'+block_action+'</div></div><div class="col-lg-12"><div class="col-lg-10 row"><input type="text" name="'+dtype+'_title['+count+']" id="'+dtype+'_title_'+count+'" maxlength="100" value="" class="form-control" placeholder="Heading" /></div><div class="col-lg-10 row">Social sharing for this content entry is enabled.</div></div>';
            } else if(dtype == 'map') {
                html += '<div class="row"><div class="col-lg-8"><label for="'+dtype+'_'+count+'" class="control-label col-lg-6">Latitude & Longitude:</label></div><div class="col-lg-4">'+block_action+'</div></div><div class="col-lg-3"><input type="text" name="'+dtype+'_title['+count+']" id="title" maxlength="10" value="" class="form-control" placeholder="Latitude" /></div><div class="col-lg-3"><input type="text" name="title" id="title" maxlength="10" value="" class="form-control" placeholder="Longitude" /></div></div>';
            } else if(dtype == 'mobile') {
                html += '<div class="row"><div class="col-lg-8"><label for="'+dtype+'_'+count+'" class="control-label col-lg-6">Mobile Application Links:</label></div><div class="col-lg-4">'+block_action+'</div></div><div class="col-lg-7 row"><div class="col-lg-10 row"><input type="text" name="'+dtype+'_title['+count+']" id="'+dtype+'_title_'+count+'" maxlength="25" value="" class="form-control" placeholder="Heading" /></div><div class="col-lg-10 row"><input type="text" name="'+dtype+'_android['+count+']" id="'+dtype+'_android_'+count+'" maxlength="255" value="" class="form-control" placeholder="Google Play Store URL" /></div><div class="col-lg-10 row"><input type="text" name="'+dtype+'_ios['+count+']" id="'+dtype+'_ios_'+count+'" maxlength="255" value="" class="form-control" placeholder="Apple App Store URL" /></div></div>';
            }

            html += '</div>'

            contents.append(html);

            if(dtype == 'text') {
                CKEDITOR.replace( dtype + '_' + count );
            } else if(dtype == 'image') {
                addMoreImages();
            }

            makeSortable();

            count++;
        });

        $('#tag').inputosaurus({
            width : '100%',
            autoCompleteSource : [<?php echo $tag_data; ?>],
            activateFinalResult : true,
            change : function(ev){
                $('#final_tag').val(ev.target.value);
            }
        });

        makeSortable();

        <?php if (isset($req['parent']) && $req['parent'] == 'add-content') { ?>
        $('.page-load').trigger('click');
        <?php } ?>
    });

    function deleteBlock(cnt) {
        $('#block'+cnt).fadeOut(300, function() { $(this).remove() });
    }

    function addMoreImages() {
        var image_count = <?php _e($icnt);?>;
        $('.add-more').click(function(){
            var count = $(this).attr('data-count');
            var dtype = $(this).attr('data-type');
            var container = $('#images'+count);

            container.append('<div class="col-lg-10 row"><input type="file" name="'+dtype+'['+count+'][]" id="image_'+count+'_'+image_count+'" value="" class="form-control" /></div><div class="col-lg-2">Actions</div>');
            image_count++;
        });
    }

    function makeSortable() {
        $(".sortable").sortable({
            opacity: 0,
            cursor: 'move',
            update: function () {
                var cnt = 1;
                $(this).find('input.position').each(function () {
                    $(this).val(cnt++);
                })
            }
        });
    }
</script>

