<?php
    if(isset($req['slug']) && file_exists($theme_path.'video/'.$req['slug'].'.mp4')) {
        ?>
        <div class="minHeight cf" data-vide-bg="<?php _e($theme_url);?>video/<?php _e($req['slug']);?>">
            <div class="start">
            </div>
        </div>
        <?php
    } else if(isset($req['parent']) && file_exists($theme_path.'video/'.$req['parent'].'.mp4')) {
        ?>
        <div class="minHeight cf" data-vide-bg="<?php _e($theme_url);?>video/<?php _e($req['parent']);?>">
            <div class="start">
            </div>
        </div>
        <?php
    } else  {
        ?>
        <div class="innerBanner">
            <img src="<?php _e($theme_url);?>images/banner/tags.jpg" alt="">
        </div>
        <?php
    }
?>