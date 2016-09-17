<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php  _e((isset($page['title']) ? $page['title'] . ' - ' : '').SITE_TITLE); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta charset="utf-8">
    <?php include('head-content.php'); ?>
</head>
<body data-vide-bg="<?php _e($theme_url);?>video/home">
    <div class="minHeightHome cf logoCenter">
        <div class="start">
        <img src="<?php _e($theme_url);?>images/l.png" class="homeLogo" alt=""/>
        <div class="punchLine">Everything we do, we believe there is always a new way of looking at something, beyond the rules.</div>
        <a onclick="location.href='javascript:void(0);'" class="scrollIcon"></a>
        </div>
    </div>
<?php
    $cnData = $cont_obj->getFrontContent();

    $news = $casestudies = $research = $contents = $content_tags = array();
    if($cnData > 0) {
        foreach($cnData as $k => $v) {

            if($v['strContentType'] == "n") {
                $news[] = $v;
            }
            if($v['strContentType'] == "c") {
                $casestudies[] = $v;
            }
            if($v['strContentType'] == "r") {
                $research[] = $v;
            }

            $contents[] = $v['id'];
        }

        $tags = $cont_obj->getTagsByContents($contents);

        $content_tags = $cont_obj->getContentTags($tags);
    }


    // echo '<pre>'; print_r($casestudies);
?>
<!-- Stare Header -->
<?php include('header.php'); ?>
<!-- End Header -->
<div class="scrollStop"></div>
<!-- Stare Contant -->
<div class="wrapper">
    <div class="row">
        <div class="col-md-9">
            <!-- Start 1 -->
            <div class="row animatedParent" data-sequence="300">
                <div class="col-md-7 animated fadeInUpShort" data-id="1">
                    <div class="bigBlog">
                        <a href="<?php _e(SITE_URL . 'case-study/' . $casestudies[0]['strSlug']); ?>" class="blogLink">
                            <div class="picView">
                                <img src="<?php _e(File::checkImageLocation($casestudies[0]['strContentImg'])); ?>" alt="" class="picW100p"/>
                            </div>
                            <h3><?php _e($casestudies[0]['strTitle']); ?></h3>Case Study
                        </a>

                        <?php if(isset($content_tags[$casestudies[0]['id']])) { ?>
                            <div class="otherLink">
                                <?php foreach($content_tags[$casestudies[0]['id']] as $tag) { ?>
                                    <a href="<?php _e(SITE_URL);?>tag/<?php _e($tag['strSlug']);?>"><?php _e($tag['strTag']);?></a>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="smallBlog animated fadeInUpShort" data-id="2">
                        <a href="<?php _e(SITE_URL . 'research/' . $research[0]['strSlug']); ?>" class="blogLink">
                            <div class="picView">
                                <img src="<?php _e(File::checkImageLocation($research[0]['strContentImg'])); ?>" alt="" class="picW100p"/>
                            </div>
                            <h3><?php _e($research[0]['strTitle']); ?></h3> Research
                        </a>
                        <?php if(isset($content_tags[$research[0]['id']])) { ?>
                            <div class="otherLink">
                                <?php foreach($content_tags[$research[0]['id']] as $tag) { ?>
                                    <a href="<?php _e(SITE_URL);?>tag/<?php _e($tag['strSlug']);?>"><?php _e($tag['strTag']);?></a>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- End 1 -->

            <!-- Start 2 -->
            <div class="row animatedParent" data-sequence="300">
                <div class="col-md-5">
                    <div class="noteonly note2 cf animated fadeInUpShort" data-id="1">
                        <div class="square"><span class="btnBefore"></span><span class="btnAfter"></span></div>
                        <h4><img src="<?php _e($theme_url); ?>images/qs.png" alt="" class="qs"/>Technology <span>exists</span> <br>
                            to <span>advance</span> <br>
                            the <span class="bi">human race</span> <img src="<?php _e($theme_url); ?>images/qe.png" alt="" class="qe"/>
                        </h4>
                    </div>
                    <div class="bigBlog animated fadeInUpShort" data-id="2">
                        <a href="<?php _e(SITE_URL . 'research/' . $research[1]['strSlug']); ?>" class="blogLink">
                            <div class="picView">
                                <img
                                    src="<?php _e(File::checkImageLocation($research[1]['strContentImg'])); ?>"
                                    alt="" class="picW100p"/>
                            </div>
                            <h3><?php _e($research[1]['strTitle']); ?></h3> Research
                        </a>
                        <?php if(isset($content_tags[$research[1]['id']])) { ?>
                            <div class="otherLink">
                                <?php foreach($content_tags[$research[1]['id']] as $tag) { ?>
                                    <a href="<?php _e(SITE_URL); ?>tag/<?php _e($tag['strSlug']); ?>"><?php _e($tag['strTag']); ?></a>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>

                    <a href="about-us#team" class="picLink animated fadeInUpShort" data-id="3">
                        <img src="<?php _e($theme_url); ?>images/our-team.jpg" alt=""/>
                        <span class="picName">Our Team</span>
                        <span class="readMore">Read More</span>
                    </a>

                    <div class="noteonly cf animated fadeInUpShort" data-id="4">
                        <div class="square"></div>
                        <h4><img src="<?php _e($theme_url); ?>images/qs.png" alt="" class="qs"/>People <span>love</span> <br>
                            <span class="bi">technology</span><br>
                            <span>that</span> loves <span class="bi">people</span>.
                            <img src="<?php _e($theme_url); ?>images/qe.png" alt="" class="qe"/>
                        </h4>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="bigBlog animated fadeInUpShort" data-id="3">
                        <a href="<?php _e(SITE_URL . 'news/' . $news[0]['strSlug']); ?>" class="blogLink">
                            <div class="picView">
                                <img src="<?php _e(File::checkImageLocation($news[0]['strContentImg'])); ?>" alt="" class="picW100p"/>
                            </div>
                            <h3><?php _e($news[0]['strTitle']); ?></h3> News
                        </a>

                        <?php if(isset($content_tags[$news[0]['id']])) { ?>
                            <div class="otherLink">
                                <?php foreach($content_tags[$news[0]['id']] as $tag) { ?>
                                    <a href="<?php _e(SITE_URL);?>tag/<?php _e($tag['strSlug']);?>"><?php _e($tag['strTag']);?></a>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="noteonly note3 cf animated fadeInUpShort" data-id="4">
                        <div class="square"></div>
                        <h4><img src="<?php _e($theme_url); ?>images/qs.png" alt="" class="qs" /><span>Rules</span><br>
                            got <span class="bi">people</span> nowhere <br>
                            <span>fantastic.</span> <img src="<?php _e($theme_url); ?>images/qe.png" alt="" class="qe" /></h4>
                    </div>
                    <div class="bigBlog animated fadeInUpShort" data-id="5">
                        <a href="<?php _e(SITE_URL . 'case-study/' . $casestudies[1]['strSlug']); ?>" class="blogLink">
                            <div class="picView">
                                <img src="<?php _e(File::checkImageLocation($casestudies[1]['strContentImg'])); ?>" alt="" class="picW100p"/>
                            </div>
                            <h3><?php _e($casestudies[1]['strTitle']); ?></h3> Case Study
                        </a>

                        <?php if(isset($content_tags[$casestudies[1]['id']])) { ?>
                            <div class="otherLink">
                                <?php foreach($content_tags[$casestudies[1]['id']] as $tag) { ?>
                                    <a href="<?php _e(SITE_URL);?>tag/<?php _e($tag['strSlug']);?>"><?php _e($tag['strTag']);?></a>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- End 2 -->

            <!-- Start 3 -->
            <div class="row animatedParent" data-sequence="300">
                <div class="col-md-5">
                    <a href="<?php _e(SITE_URL);?>career/join-us" class="picLink animated fadeInUpShort" data-id="1">
                        <img src="<?php _e($theme_url); ?>images/join-us.jpg" alt=""/>
                        <span class="picName">Join Us</span>
                        <span class="readMore">Read More</span>
                    </a>

                    <div class="bigBlog animated fadeInUpShort" data-id="2">
                        <a href="<?php _e(SITE_URL . 'news/' . $news[1]['strSlug']); ?>" class="blogLink">
                            <div class="picView">
                                <img src="<?php _e(File::checkImageLocation($news[1]['strContentImg'])); ?>" alt="" class="picW100p"/>
                            </div>
                            <h3><?php _e($news[1]['strTitle']); ?></h3>
                            News
                        </a>
                        <?php if(isset($content_tags[$news[1]['id']])) { ?>
                            <div class="otherLink">
                                <?php foreach($content_tags[$news[1]['id']] as $tag) { ?>
                                    <a href="<?php _e(SITE_URL);?>tag/<?php _e($tag['strSlug']);?>"><?php _e($tag['strTag']);?></a>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="bigBlog animated fadeInUpShort" data-id="3">
                        <a href="<?php _e(SITE_URL . 'case-study/' . $casestudies[2]['strSlug']); ?>" class="blogLink">
                            <div class="picView">
                                <img src="<?php _e(File::checkImageLocation($casestudies[2]['strContentImg'])); ?>" alt="" class="picW100p"/>
                            </div>
                            <h3><?php _e($casestudies[2]['strTitle']); ?></h3> Case Study
                        </a>

                        <?php if(isset($content_tags[$casestudies[2]['id']])) { ?>
                            <div class="otherLink">
                                <?php foreach($content_tags[$casestudies[2]['id']] as $tag) { ?>
                                    <a href="<?php _e(SITE_URL);?>tag/<?php _e($tag['strSlug']);?>"><?php _e($tag['strTag']);?></a>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="noteonly cf animated fadeInUpShort" data-id="4">
                        <div class="square"></div>
                        <h4><img src="<?php _e($theme_url); ?>images/qs.png" alt="" class="qs"/><span>Never</span> stop <br>
                            <span class="bi">until</span> <br>
                            you are <span>never</span> <span class="bi">before</span>
                            <img src="<?php _e($theme_url); ?>images/qe.png" alt="" class="qe"/>
                        </h4>
                    </div>
                </div>
            </div>
            <!-- End 3 -->

            <!-- Start 4 -->
            <div class="row animatedParent" data-sequence="300">
                <div class="col-md-12 photos cf">
                    <a href="#" class="animated fadeInUpShort" data-id="1"><img src="<?php _e($theme_url); ?>images/photo-1.jpg" alt=""/></a>
                    <a href="#" class="mlr animated fadeInUpShort" data-id="2"><img src="<?php _e($theme_url); ?>images/photo-2.jpg" alt=""/></a>
                    <a href="#" class="animated fadeInUpShort" data-id="3"><img src="<?php _e($theme_url); ?>images/photo-3.jpg" alt=""/></a>
                </div>
            </div>
            <!-- End 4 -->
        </div>

        <!-- Start Services & Products -->
        <div class="col-md-3 animatedParent rightSideBar" data-sequence="0">
            <div class="theiaStickySidebar">
                <div class="services cf animated fadeInUpShort" data-id="1">
                    <h2>Studios</h2>
                    <?php $i = 0;
                        foreach ($studios as $v) {

                            $i++; ?>
                            <a href="<?php _e(SITE_URL);?>studio/<?php _e($v['strSlug']);?>" class="ser<?php echo $i; ?>"><?php _e($v['strTitle']); ?><span><?php _e("0" . $i); ?></span></a><br>
                        <?php } ?>
                </div>
                <div class="product animated fadeInUpShort" data-id="2">
                    <h2>Products</h2>
                    <ul class="ProductSlider cycle-slideshow cf" data-cycle-fx="scrollHorz" data-cycle-slides="li" data-cycle-speed="1000" data-cycle-timeout="5000" data-cycle-pager="#pager"
                        data-cycle-loader="true">
                        <?php
                            $p = 1;
                            foreach ($products as $v) {
                                ?>
                                <li><a href="<?php _e(SITE_URL);?>products#slide-<?php _e($p++);?>"><img src="<?php _e(File::checkImageLocation($v['strContentImg'])); ?>" alt=""></a></li>
                            <?php } ?>
                    </ul>
                    <div class="cycle-pager" id="pager"></div>
                </div>
            </div>
        </div>
        <!-- End Services & Products -->

    </div>
</div>
<!-- End Contant -->

<!-- Stare Footer -->
    <?php include('footer.php'); ?>
    <?php include('footer-scripts.php'); ?>
<!-- End Footer -->


