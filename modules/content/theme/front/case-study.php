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

    $content_relations = $cont_obj->getRelationContents("intContentId = ".$content_details['id']." and strType = 'studio'");

    $content_title = '';
    if($content_relations != 404) {
        $content_title .= $content_relations[0]['strTitle'].": ";
    }
    $content_title .= '<span>'.$content_details['strTitle'].'</span>';

    $content_tags = $cont_obj->getContentTag("mst_cnt.id=" . $content_details['id']);

    $tags = array();
    if($content_tags != 404) {
        foreach($content_tags as $tag) {
            $tags[] = $tag['id'];
        }
    }

    $blocks_details = $block_obj->getBlockDetailsByContentID($content_details['id']);

    $blocks = $image_blocks = $mobile_blocks = array();
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
    } //pr($blocks);

    $color_array = array(
        '#00bcbc' => 'Blue',
        '#ffb700' => 'Yellow'
    );

    $bg = (!empty($content_details['strColor'])) ? $color_array[$content_details['strColor']] : 'Blue';
?>
<style type="text/css">
    .bgBlue {background:#00bcbc url(<?php _e($theme_url);?>images/casestudy/bg.png) no-repeat center 1100px;}
    .bgYellow {background:#ffb700 url(<?php _e($theme_url);?>images/casestudy/bg-yellow.png) no-repeat center 1100px;}
</style>
<div class="minHeightHome casestudyBanner cf bg<?php _e($bg);?>">
    <div class="start" >
        <div class="btimg">
            <h1><?php _e($content_title); ?></h1>
            <img src="<?php _e(File::checkImageLocation($content_details['strContentImg'])); ?>" alt=""/>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="row container animatedParent">
        <div class="col-md-12 animated fadeInUpShort">
            <?php
                if(sizeof($blocks) > 0) {
                    foreach ($blocks as $block) {

                        $slug = $block['block_slug'];

                        if ($slug == 'text') {
                            _e(String::updateHTML($block['txtContent']));
                        }

                        if ($slug == 'image') {
                            $content_block_id = $block['content_block_id'];
                            if(isset($image_blocks[$content_block_id])) {
                                ?>
                                <div class="text-center">
                                <?php
                                $icnt = 1;
                                foreach($image_blocks[$content_block_id] as $iblock) {
                                    ?>
                                        <p><img src="<?php _e(UPLOAD_URL); ?>content/<?php _e($iblock['txtContent']); ?>" alt="image<?php _e($icnt); ?>" class="maxWidth-2" /></p>
                                    <?php
                                    $icnt++;
                                }
                                ?>
                                </div>
                                <?php
                            }
                        }

                        if (in_array($slug, array('feature', 'trending'))) {
                            ?>
                            <div class="wrapper">
                                <div class="row container centerAlign">
                                    <div class="col-md-12">
                                <h2><?php _e($block['block_heading']);?></h2>
                                <p><?php _e(nl2br(String::updateHTML($block['block_description'])));?></p>
                            <?php

                            if($slug == 'feature') {

                                $features = $block_obj->getFeatures("idContent = ".$content_details['id']);

                                if($features != 404) {

                                    foreach($features as $feature) {
                                        ?>
                                        <div class="col-md-3">
                                            <div class="workList">
                                                <div>
                                                    <?php
                                                        if(!empty($feature['strImageName']) && file_exists(UPLOAD_PATH.'content/'.$feature['strImageName'])) {
                                                            _e('<img src="'.UPLOAD_URL.'content/'.$feature['strImageName'].'" alt="'.$feature['strFeatureName'].'" width="130" />');
                                                        }
                                                    ?>
                                                </div>
                                                <h3><?php _e($feature['strFeatureName']);?></h3>
                                                <?php _e($feature['strDescription']);?>
                                            </div>
                                        </div>
                                        <?php

                                    }

                                }

                            }

                            if($slug == 'trending') {

                                $trending = $block_obj->getTrending("idContent = ".$content_details['id']);

                                if($trending != 404) {

                                    ?>
                                    <div class="cf">
                                    <?php

                                    foreach($trending as $trend) {
                                        ?>
                                        <div class="col-md-4 listing">
                                            <div>
                                                <img src="<?php _e(File::checkImageLocation($trend['strImageName'])); ?>" alt="image<?php _e($trend['id']); ?>"/>
                                                <h5><?php _e($trend['strTrendingName']);?></h5>
                                                <p><?php _e($trend['strDescription']);?></p>
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
                                    </div>
                            </div>
                            <?php
                        }

                        if ($slug == 'social') {
                            ?>
                            <div class="followUs projectOn">
                                <span>Appreciate Project</span>
                                <!--<a href="https://twitter.com/share?url=<?php /*_e(urlencode(SITE_HOST._env('request_uri')));*/?>&amp;text=<?php /*_e(urlencode($content_details['strTitle']));*/?>&amp;hashtags=" target="_blank"><i class="fa fa-twitter"></i></a>
                                <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php /*_e(urlencode(SITE_HOST._env('request_uri')));*/?>" target="_blank"><i class="fa fa-linkedin"></i></a>
                                <a href="https://plus.google.com/share?url=<?php /*_e(urlencode(SITE_HOST._env('request_uri')));*/?>" target="_blank"><i class="fa fa-google-plus"></i></a>
                                <a href="http://www.facebook.com/sharer.php?u=<?php /*_e(urlencode(SITE_HOST._env('request_uri')));*/?>" target="_blank"><i class="fa fa-facebook"></i></a>-->
                                <a onclick="location.href='javascript:void(0);'" target="_blank"><i class="fa fa-thumbs-up"></i></a>
                            </div>
                            <?php
                        }

                        if ($slug == 'mobile') {

                            $mobile_block_details = $mobile_blocks[$content_block_id];

                            $app_store_images = array(
                                'android' => 'google-play.png',
                                'ios' => 'app-store.png'
                            );
                            ?>
                            <div class="followUs projectOn">
                                <span>Download Application From</span>
                                <?php
                                    if(isset($block_obj::$_mobile_apps)) {
                                        foreach($block_obj::$_mobile_apps as $app) {

                                            if(isset($mobile_block_details[$app])) {
                                                ?>
                                                <a href="<?php _e($mobile_block_details[$app]['txtContent']);?>" target="_blank"><img src="<?php _e($theme_url);?>images/<?php _e($app_store_images[$app]);?>" alt="<?php _e($app);?>" /></a>
                                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </div>
                            <?php
                        }
                    }
                }
            ?>
            <div class="clearfix"></div>
            <?php
                if($content_tags != 404 && !in_array($content_details['strContentType'], array('s', 'p'))) {
                    ?>
                    <div class="wrapper">
                    <p>Tags: <div class="otherLink">
                        <?php
                            foreach($content_tags as $tag) {
                                ?>
                                <a href="<?php _e(SITE_URL);?>tag/<?php _e($tag['strSlug']);?>"><?php _e($tag['strTag']);?></a>
                                <?php
                            }
                        ?></div></p>
                    </div>
                    <?php
                }
            ?>
        </div>
    </div>
    </div>

    <div class="wrapper">

    <?php

        if(sizeof($tags) > 0 && !in_array($content_details['strContentType'], array('s', 'p'))) {

            $related_content = $cont_obj->getRelatedContent($tags);

            if($related_content != 404) {
                ?>
                <div class="row container">
                    <div class="col-md-12"><h2>You May Also Like</h2></div>
                    <?php
                        foreach($related_content as $rcontent) {

                            $content_type = $rcontent['strContentType'];

                            $content_type_slug = $cont_obj->getContentTypeSlug($content_type);

                            ?>
                            <div class="col-md-4">
                                <div class="bigBlog"><a
                                        href="<?php _e(SITE_URL . $content_type_slug . '/' . $rcontent['strSlug']); ?>"
                                        class="blogLink">
                                        <div class="picView">
                                            <img src="<?php _e(File::checkImageLocation($rcontent['strContentImg'])); ?>" alt=""
                                                 class="picW100p"/>
                                        </div>
                                        <h3><?php _e($rcontent['strTitle']); ?></h3>
                                        Read More </a>
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
<script type="text/javascript">
    (function() {
        "use strict";
        $(document).scroll(function() {
            if ($(document).scrollTop() >= $('.wrapper').offset().top - $(window).height()  + 600) {
                $('.header').removeClass('whiteHed');
            } else {
                $('.header').addClass('whiteHed');
            }
        });
    })(jQuery);
</script>