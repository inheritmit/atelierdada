<?php
    $services = $page_obj->getSubLinksByLink(12);
?>
<div id="tp-latest-news" class="tp-latest-news col-md-6"><!-- template news -->
        <div class="col-md-12 tp-title">
            <h1>Services</h1>
        </div>
        <div class="row">
            <?php
                $s = 0;
                foreach($services as $service) {

                    switch ($service['enmType']) {
                        case 'LB':
                            $sub_link = 'javascript:;';
                            break;
                        case 'PG':
                            $sub_link = SITE_URL . $service['strSlug'];
                            break;
                        case 'EL':
                        case 'PL':
                            $sub_link = SITE_URL . $service['strLink'];
                            break;
                    }

                    ?>
                    <div class="col-md-6 text-center">
                        <div class="tp-pic c<?php _e($s%2);?>">
                            <a href="<?php _e($sub_link);?>"><i class="fa <?php _e($service['strIcon']);?> fa-2x circle"></i><br /><?php _e($service['strLabel']);?></a>
                        </div>
                    </div>
                    <?php
                    $s++;
                }
            ?>
        </div>
</div>
<!-- /.template news -->