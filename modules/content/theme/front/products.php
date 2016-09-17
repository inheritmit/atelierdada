<div class="wrapper"></div>
<div id="fsvs-body">
<?php

    _subModule('content', 'block');
    $block_obj = new block();

    $blocks_details = $block_obj->getBlockDetailsByContentType('p'); //pr($blocks_details);

    $content_blocks = $mobile_blocks = array();
    if($blocks_details != 404) {
        foreach($blocks_details as $block) {
            $content_id = $block['content_id'];
            $content_blocks[$content_id] = $block;

            if($block['block_slug'] == 'mobile') {
                $type = $block['strType'];
                $mobile_blocks[$content_id][$type]  = $block;
            }
        }
    }

    $products = $block_obj->getContentsByType('p');

    $i = 1;
    if($products != 404) {
        foreach($products as $value) {
?>
<div class="productList oneMusicBgPic col-md-12 slide" data-vide-bg="<?php _e($theme_url);?>video/<?php _e($value['strSlug']);?>">
    <div class="col-md-4 pull-right">
        <div class="number"><?php _e("0".$i++); ?></div>
        <h2><?php _e($value['strTitle']);?></h2>
        <?php
            if(isset($content_blocks[$value['id']])) {
                _e($content_blocks[$value['id']]['txtContent']);
            }

            if (isset($mobile_blocks[$value['id']])) {

                $mobile_block_details = $mobile_blocks[$value['id']];

                $app_store_images = array(
                    'android' => 'google-play.png',
                    'ios' => 'app-store.png'
                );
                ?>
                <div class="projectOn">
                    <div>Download Application From</div>
                    <p></p>
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
        ?>
    </div>
</div>
<?php
        }
    }
?>
    </div>
<div class="an"></div>

<div class="greyBg">
    <div class="wrapper">
        <div class="row container centerAlign">
            <div class="col-md-12">
                <p class="font21">At Nascent,We believe in the power of innovation and free-spirited mind.</p>
                <a href="<?php _e(SITE_URL);?>collaborate-us" class="yellowBtn">Collaborate</a>
            </div>
        </div>
    </div>
</div>
