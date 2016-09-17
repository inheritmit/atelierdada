<?php
    /**
     * Created by PhpStorm.
     * User: mitesh
     * Date: 20/4/16
     * Time: 3:28 PM
     */

    _subModule('content', 'block');
    $block_obj = new block();

    $cont_obj->setPrepare(array(':slug' => $req['slug']));
    $content_details = $cont_obj->getContent("strSlug = :slug");

    if($content_details == 404) {
        _error(404);
        exit;
    }

    $content_tags = $cont_obj->getContentTag("mst_cnt.id=" . $content_details['id']);

    $tags = array();
    if($content_tags != 404) {
        foreach($content_tags as $tag) {
            $tags[] = $tag['id'];
        }
    }

    $blocks_details = $block_obj->getBlockDetailsByContentID($content_details['id']);

    $blocks = array();
    if($blocks_details != 404) {
        foreach($blocks_details as $block) {
            $block_slug = $block['block_slug'];
            $content_block_id = $block['content_block_id'];
            $blocks[$block_slug] = $block;
            if($block['block_slug'] == 'image') {
                $image_blocks[$content_block_id][]  = $block;
            }
        }
    }
?>
<!-- Stare Inner Banner -->
<div class="innerBanner">
    <img src="<?php _e($theme_url);?>images/banner/casestudy-detail.jpg" alt="content banner"/>
</div>
<!-- End Inner Banner -->
<div class="wrapper">
    <div class="row container centerAlign">
        <div class="col-md-12">

            <h1><?php _e($content_details['strTitle']);?>
                <span class="datehed"><?php _e(date('d F, Y', strtotime($content_details['dtContent'])));?></span>
            </h1>
            <?php
                if(sizeof($blocks) > 0) {
                    foreach ($blocks as $slug => $block) {
                        if ($slug == 'text') {
                            _e(String::updateHTML($block['txtContent']));
                        }

                        if ($slug == 'image') {
                            $content_block_id = $block['content_block_id'];
                            if(isset($image_blocks[$content_block_id])) {
                                $icnt = 1;
                                foreach($image_blocks[$content_block_id] as $iblock) {
                                    ?>
                                    <div class="case-detail-img animated fadeInUpShort" data-id="<?php _e($icnt); ?>"><img src="<?php _e(UPLOAD_URL); ?>content/<?php _e($iblock['txtContent']); ?>" alt="image<?php _e($icnt); ?>"/></div>
                                    <?php
                                    $icnt++;
                                }
                            }
                        }

                        if ($slug == 'social') {
                            ?>
                            <div class="followUs projectOn">
                                <span>Appreciate Project On</span>
                                <a href="https://twitter.com/share?url=<?php _e(urlencode(SITE_HOST._env('request_uri')));?>&amp;text=<?php _e(urlencode($content_details['strTitle']));?>&amp;hashtags=simplesharebuttons" target="_blank"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                                <a href="#"><i class="fa fa-google-plus"></i></a>
                                <a href="#"><i class="fa fa-facebook"></i></a>
                            </div>
                            <?php
                        }
                    }
                }
            ?>
            <?php
                if($content_tags != 404) {
                    ?>
                    <p>Tags:
                        <?php
                            foreach($content_tags as $tag) {
                                ?>
                                <a href="<?php _e(SITE_URL);?>tag/<?php _e($tag['strSlug']);?>"><?php _e($tag['strTag']);?></a>
                                <?php
                            }
                        ?></p>
                    <?php
                }
            ?>

        </div>
    </div>

    <?php
        if($content_tags != 404) {
            $related_content = $cont_obj->getRelatedContent($tags);

            if ($related_content != 404) {
                ?>
                <div class="row container">
                    <div class="col-md-12"><h2>You May Also Like</h2></div>
                    <?php
                        foreach ($related_content as $rcontent) {

                            $content_type = $rcontent['strContentType'];

                            $content_type_slug = $cont_obj->getContentTypeSlug($content_type);

                            ?>
                            <div class="col-md-4">
                                <div class="bigBlog"><a href="<?php _e(SITE_URL . $content_type_slug . '/' . $rcontent['strSlug']); ?>" class="blogLink">
                                        <div class="picView">
                                            <img src="<?php _e($theme_url); ?>images/case-study-1.jpg" alt="" class="picW100p"/>
                                        </div>
                                        <h3><?php _e($rcontent['strTitle']); ?></h3>
                                        Read More </a>

                                    <div class="otherLink"><a href="#">Technology</a> <a href="#">Information Technology</a> <a href="#">Technology</a> <a href="#">Sustainable Development</a> <a
                                            href="#">Sustainable
                                            Development</a></div>
                                </div>
                            </div>
                            <?php
                        }
                    ?>
                </div>
                <?php
            }
        }
    ?>

</div>