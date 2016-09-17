<?php
    $listing_array = array(
        'researches' => 'r',
        'news' => 'n',
        'events' => 'e',
        'studios' => 's',
        'products' => 'p'
    );
?>
<!-- Stare Inner Banner -->
<div class="innerBanner">
    <img src="<?php _e($theme_url); ?>images/banner/products.jpg" alt=""/>
</div>
<!-- End Inner Banner -->
<div class="wrapper cf animatedParent animateOnce">
    <div class="row container centerAlign animated fadeInUpShort">

        <div class="col-md-12">
            <h1>Our Products</h1>
            <p>Consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque<br class="rwd-break">
                penatibus et magnis dis parturient montes, nascetur ridiculus mus. </p>
        </div>

    </div>
</div>

<?php
    $i = 1;
    if(isset($products) && !empty($products) ){//pr($products); exit;
    foreach($products as $value){

?>

<div class="productList productBgPic col-md-12 animatedParent" style="background:url(<?php echo SITE_URL . 'file-manager/content/product/' . $value['strContentImg']; ?>) no-repeat right center;">
    <div class="col-md-4 animated fadeInLeftShort">
        <div class="number"><?php _e($i++); ?></div>
        <h2><?php _e($value['strTitle']);?></h2>
        <?php _e($value['strDescription']); ?>
        <a href="<?php _e(SITE_URL . 'product/' . $value['strSlug']); ?>" class="view">View Case Study</a>
    </div>

</div>

<?php }} ?>
<div class="cf"></div>
