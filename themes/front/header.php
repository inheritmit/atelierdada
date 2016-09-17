<?php
    $studios = $cont_obj->getContentsByType('s');
    $products = $cont_obj->getContentsByType('p');
?>
<div class="header animatedParent cf<?php if(isset($req['content']) && $req['content'] == 'case-study') { ?> whiteHed<?php } ?>">
    <?php if(sizeof($req) != 0) { ?>
	<a href="<?php _e(SITE_URL);?>" class="logo animated bounceInDown" title="NASCENT"><img alt="NASCENT" title="NASCENT" src="<?php _e($theme_url);?>images/<?php if(isset($req['content']) && $req['content'] == 'case-study') { ?>nascent-logo-white.png<?php } else { ?>nascent-logo.png<?php } ?>"></a>
    <?php } ?>
    <div class="searchBoxMain">
        <a onclick="location.href='javascript:void(0);'" title="Search" class="search"><i class="fa fa-search"></i></a>
        <form id="search_form" name="search_form" class="searchFilter" action="<?php _e(SITE_URL);?>search">
            <label><input name="q" id="q" type="search" placeholder="Search" class="inputText"></label>
        </form>
    </div>
	<a onclick="location.href='javascript:void(0);'" class="smallNav animated bounceInLeft"><span></span><span></span><span class="lastChild"></span></a>
</div>
<div class="blackBg">&nbsp;</div>
<div class="menuBox">
	<div class="circle"></div>
	<ul class="mainNav cf">
		<li><a href="<?php _e(SITE_URL);?>" class="three-d">Home</a></li>
		<li><a href="<?php _e(SITE_URL);?>about-us" class="toggleSubNav">ABOUT <i class="fa fa-caret-down" aria-hidden="true"></i><i class="fa fa-caret-up arowHide" aria-hidden="true"></i></a>
			<ul class="subMenu cf">
				<li><a href="<?php _e(SITE_URL);?>about-us">The Company</a></li>
                <li><a href="<?php _e(SITE_URL);?>about-us#team">Our Team</a></li>
				<li><a href="<?php _e(SITE_URL);?>about-us#clients">Our Clients</a></li>
			</ul>
		</li>
        <?php
            if($studios != 404) {
                ?>
                <li><a onclick="location.href='javascript:void(0);'" class="toggleSubNav">STUDIO <i class="fa fa-caret-down" aria-hidden="true"></i><i class="fa fa-caret-up arowHide" aria-hidden="true"></i></a>
                    <ul class="subMenu cf">
                        <?php
                            $cnt = 0;
                            foreach($studios as $st) {

                                if($cnt == 0) {
                                    $current_studio = $st['strSlug'];
                                    $cnt++;
                                }

                                ?>
                                <li><a href="<?php _e(SITE_URL.'studio/'.$st['strSlug']); ?>"><?php _e($st['strTitle']);?></a></li>
                                <?php
                            }
                        ?>
                    </ul>
                </li>
                <?php
            }
        ?>
		<li><a href="<?php _e(SITE_URL); ?>case-studies">CASE STUDIES</a></li>
        <?php
            if($products != 404) {
                ?>
                <li><a onclick="location.href='javascript:void(0);'" class="toggleSubNav">PRODUCTS <i class="fa fa-caret-down" aria-hidden="true"></i><i class="fa fa-caret-up arowHide" aria-hidden="true"></i></a>
                    <ul class="subMenu cf">
                        <?php
                            $pcnt = 0;
                            foreach($products as $st) {

                                if($pcnt == 0) {
                                    $current_product = $st['strSlug'];
                                }

                                $pcnt++;

                                ?>
                                <li><a href="<?php _e(SITE_URL.'products#slide-'.$pcnt); ?>"><?php _e($st['strTitle']);?></a></li>
                                <?php
                            }
                        ?>
                    </ul>
                </li>
                <?php
            }
        ?>
		<li><a href="<?php _e(SITE_URL); ?>career/join-us">JOIN US</a></li>
		<li><a href="<?php _e(SITE_URL); ?>collaborate-us">COLLABORATE</a></li>
        <li><a href="<?php _e(SITE_URL); ?>kaleidoscope">KALEIDOSCOPE</a></li>
	</ul>
	<div class="followUs">
		<a href="https://twitter.com/nascent_it" target="_blank"><i class="fa fa-twitter"></i></a>
		<a href="https://www.linkedin.com/company/nascent-info-technologies" target="_blank"><i class="fa fa-linkedin"></i></a>
		<a href="https://plus.google.com/104337279329750748725/about" target="_blank"><i class="fa fa-google-plus"></i></a>
		<a href="https://www.facebook.com/Nascent.IT" target="_blank"><i class="fa fa-facebook"></i></a>
	</div>
</div>
