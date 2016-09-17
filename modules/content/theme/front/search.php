<?php
    if(!isset($_GET['q']) || empty($_GET['q'])) {
        _error(404);
        exit;
    }

    $contents = $block_obj->getContentsBySearchQuery($_GET['q']);
?>
<div class="wrapper">
    <div class="row container">
        <div class="col-md-12 tagBar cf">
            <div class="tagsHead">Search Query:</div>
            <div class="tagsLink"><?php _e($_GET['q']);?></div>
            <?php if($contents != 404) { ?>
            <div class="numberofTags">Number of record(s): <?php _e(sizeof($contents));?></div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- Stare Contant -->
<div class="wrapper">
    <div class="row container centerAlign grid">
        <?php
            if($contents != 404) {

                $tags = $block_obj->getTagsByContentType(array('c', 'n', 'e', 'r'));

                $content_tags = $block_obj->getContentTags($tags);

                foreach ($contents as $content) {

                    $type_name = $block_obj::$_types[$content['strContentType']];

                    $content_id = $content['id'];

                    $cover_image = File::checkImageLocation($content['strContentImg']);
                    ?>
                    <div class="col-md-4">
                        <div class="bigBlog">
                            <a href="<?php _e(SITE_URL.String::generateSEOString($type_name));?>/<?php _e($content['strSlug']);?>" class="blogLink">
                                <div class="picView"><img src="<?php _e($cover_image);?>" alt="<?php _e($content['strTitle']);?>" class="picW100p"/>
                                </div>
                                <h3 class="minHeight44"><?php _e($content['strTitle']);?></h3>
                                <?php _e($type_name);?></a>

                            <?php if(isset($content_tags[$content_id])) { ?>
                                <div class="otherLink">
                                    <?php foreach($content_tags[$content_id] as $tag) { ?>
                                        <a href="<?php _e(SITE_URL);?>tag/<?php _e($tag['strSlug']);?>"><?php _e($tag['strTag']);?></a>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php
                }
            } else {
                ?>
                <p>No record found for <strong><?php _e($_GET['q']); ?></strong>.</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <?php
            }
        ?>
	</div>
</div>

</div>
<!-- End Contant -->
<script type="text/javascript" src="<?php _e($theme_url);?>js/masonry.pkgd.min.js"></script>

<script>
    $( window ).load(function() {
        $('.grid').masonry({
            itemSelector: '.col-md-4',
            columnWidth: '.col-md-4',
            percentPosition: true
        });
    });
</script>