<?php
/**
 * Created by Yogesh Rathod.
 * Module : Content
 * Date: 19/4/2016
 */

    $case_studies = $block_obj->getContentWithRelationsByType('c'); //pr($case_studies);

    $cs_studios = array();
    if($case_studies != 404) {
        foreach($case_studies as $case_study) {
            if(!empty($case_study['relation_name'])) {
                $relation_slug = $case_study['relation_slug'];
                $cs_studios[$relation_slug] = $case_study;
            }
        }
    }
?>
<!-- Stare Contant -->
<div class="wrapper">
	<div class="row container centerAlign">
		<div class="col-md-12">
			<h1>Case Studies</h1>
			<p>Browse through the Case Studies here, to get a more reflective understanding of Nascent's work in the field of technology and innovation.
			</p>

            <ul class="nav nav-tabs btn-group btn-group-justified caseStudiesTab" id="navTabs">
                <li><a class="btn active" href="javascript:void(0)" data-slug="all"><span>All</span></a></li>
                <?php
                    if(sizeof($cs_studios) > 0) {
                        foreach($cs_studios as $studio) {
                        ?>
                <li><a class="btn" href="javascript:void(0)" data-slug="<?php _e($studio['relation_slug']); ?>"><span><?php _e($studio['relation_name']); ?></span></a></li>
                        <?php
                        }
                    }
                ?>
            </ul>

		</div>

        <div class="col-md-12">
		<div class="tab-content cf grid" id="case-studies">
			<?php
				if($case_studies != 404) {
                    foreach($case_studies as $cs) {
                        ?>
                        <div class="col-md-4" data-id="content-<?php _e($cs['id']); ?>" data-type="<?php _e($cs['relation_slug']); ?>">
                            <div class="bigBlog">
                                <a href="<?php _e(SITE_URL);?>case-study/<?php _e($cs['strSlug']);?>">
                                    <div class="picView">
                                        <img src="<?php _e(File::checkImageLocation($cs['strContentImg'])); ?>" alt="" class="picW100p"/>
                                    </div>
                                    <h3><?php _e($cs['strTitle']); ?></h3> Read More </a>

                                <div class="otherLink">
                                    <?php
                                        $rsTag = $cont_obj->getContentTag("mst_cnt.id=" . $cs['id']);
                                        if($rsTag != 404) {
                                            foreach($rsTag as $cs) {
                                                ?>
                                                <a href="<?php _e(SITE_URL);?>tag/<?php _e($cs['strSlug']);?>"><?php _e($cs['strTag']); ?></a>
                                                <?php
                                            }
                                        }?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
            ?>
        </div>
	</div>
</div>

</div>

<div class="greyBg">
	<div class="wrapper">
		<div class="row container centerAlign">
			<div class="col-md-12">
				<p class="font21">At Nascent you can be yourself, and that’s the best anyone can be. Your creativity, out-of-the-line uniqueness is of great value to the company and we encourage such free flow of ideas for our products and processes.</p>
				<a href="<?php _e(SITE_URL);?>career/join-us" class="yellowBtn">Join Us</a>
			</div>
		</div>
	</div>
</div>
<!-- End Contant -->
<script type="text/javascript" src="<?php _e($theme_url);?>vendor/quicksand/jquery.quicksand.js"></script>
<script type="text/javascript" src="<?php _e($theme_url);?>vendor/quicksand/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php _e($theme_url);?>js/masonry.pkgd.min.js"></script>
<script type="text/javascript">

    // bind radiobuttons in the form
    var $filterType = $('.btn-group .btn');

    // get the first collection
    var $case_studies = $('#case-studies');

    // clone case studies to get a second collection
    var $data = $case_studies.clone();

    var url = location.href, idx = url.indexOf("#");
    var current = (idx != -1) ? url.substring(idx+1) : 'all';

    // DOMContentLoaded
    $(function() {

        activeTab(current);

        // attempt to call Quicksand on every form change
        $filterType.click(function(e) {
            current = $(this).attr('data-slug');
            activeTab(current);
        });

    });

    function activeTab(current) {

        if (current == 'all') {
            var $filteredData = $data.find('div.col-md-4');
        } else {
            var $filteredData = $data.find('div.col-md-4[data-type="' + current + '"]');
        }

        $filterType.removeClass('active');
        $('.btn-group .btn[data-slug="' + current + '"]').addClass('active');

        // finally, call quicksand
        $case_studies.quicksand($filteredData, {
            duration: 800,
            easing: 'easeInOutQuad'
        });

        /*if (current != 'all') {
            $('html, body').animate({
                scrollTop: $("#navTabs").offset().top
            }, 900);
            $("#navTabs").animate({scrollTop: 0}, 0);
        }*/

        arrangeBoxes();
    }

        function arrangeBoxes() {
            $( window ).load(function() {
            $('.grid').masonry({
                itemSelector: '.col-md-4',
                columnWidth: '.col-md-4',
                //percentPosition: true
            });
            });
        }

</script>