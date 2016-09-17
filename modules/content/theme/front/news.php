<div class="wrapper cf animatedParent animateOnce">
    <div class="row container centerAlign animated fadeInUpShort">

        <div class="col-md-12">
            <h1>News</h1>
            <p>Consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque<br class="rwd-break">
                penatibus et magnis dis parturient montes, nascetur ridiculus mus. </p>
        </div>

    </div>
</div>
<?php
    _subModule('content', 'block');
    $block_obj = new block();

    $news = $block_obj->getContents(" and strContentType = 'n' and enmDeleted = '0' and enmStatus = '1'");

    $i = 1;
    if(isset($news) && !empty($news) ){
        foreach($news as $value){

?>
<div class="productList productBgPic col-md-12 animatedParent" style="background:url(<?php echo SITE_URL . 'file-manager/content/product/' . $value['strContentImg']; ?>) no-repeat right center;">
    <div class="col-md-4 animated fadeInLeftShort">
        <div class="number"><?php _e($i++); ?></div>
        <h2><?php _e($value['strTitle']);?></h2>
        <?php _e($value['strDescription']); ?>
        <a href="<?php _e(SITE_URL);?>news/<?php _e($value['strSlug']);?>" class="view">View News</a>
    </div>
</div>
<?php
        }
    }
?>
<div class="cf"></div>
