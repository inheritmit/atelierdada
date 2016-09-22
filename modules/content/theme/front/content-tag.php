<?php
    $tag_details = $cont_obj->getTagBySlug($req['slug']);

    $contents = $cont_obj->getContentByTag($tag_details['id']);
?>
<!-- Stare Inner Banner -->
<div class="innerBanner">
	<img src="<?php _e($theme_url); ?>images/banner/case-study.jpg" alt=""/>
</div>
<!-- End Inner Banner -->
<!-- Stare Contant -->
<div class="wrapper">
	<div class="row container centerAlign">
		<div class="col-md-12">
			<h1>Tag</h1>
            <p></p>
		</div>

		<div class="tab-content cf">
            <?php
                if($contents != 404) {
                    ?>
                    <div id="all" class="tab-pane fade in active">
                        <?php
                                foreach ($contents as $content) {

                                    ?>
                                    <div class="col-md-4">
                                        <div class="bigBlog"><a href="#" class="blogLink">
                                                <div class="picView">
                                                    <img src="<?php echo UPLOAD_URL.'content/casestudies/' . $content['strContentImg']; ?>" alt="" class="picW100p"/>
                                                </div>
                                                <h3><?php _e($content['strTitle']); ?></h3> Read More </a>

                                            <div class="otherLink">
                                                <a href="#">Technology</a>
                                                <a href="#">Information Technology</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                    </div>
                    <?php
                }
            ?>
	</div>
</div>

</div>
<!-- End Contant -->


<link rel="stylesheet" type="text/css" href="css/fonts.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.queryloader2.js"></script>
<script type="text/javascript" src="js/css3-animate-it.js"></script>
<script type="text/javascript" src="js/general.js"></script>

<script>
	$(document).ready(function() {

		$(".caseStudiesTab li a").click(function (){
			$('html, body').animate({
				scrollTop: $("#navTabs").offset().top
			}, 900);
			$("#navTabs").animate({scrollTop:0}, 0);
		});
	});
</script>