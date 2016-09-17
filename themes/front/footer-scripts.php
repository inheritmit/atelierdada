<!-- End Footer -->
<script type="text/javascript" src="<?php _e($theme_url);?>js/jquery.queryloader2.js"></script>
<script type="text/javascript" src="<?php _e($theme_url);?>js/jquery.cycle.min.js"></script>
<script type="text/javascript" src="<?php _e($theme_url);?>js/css3-animate-it.js"></script>
<script type="text/javascript" src="<?php _e($theme_url);?>js/theia-sticky-sidebar.js"></script>
<script type="text/javascript" src="<?php _e($theme_url);?>js/jquery.vide.js"></script>
<script type="text/javascript" src="<?php _e($theme_url);?>js/fsvs.js"></script>
<script type="text/javascript" src="<?php _e($theme_url);?>js/general.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $('.rightSideBar').theiaStickySidebar({
            additionalMarginTop: 30
        });
		
		$(".scrollIcon, .scrollBut").click(function (){
	$('html, body').animate({
	scrollTop: $("body > .scrollStop").offset().top
	}, 800);
	}); 

    });
</script>
<script>

    $(document).ready( function() {

        if( $.fn.fsvs ) {
            var slider = $.fn.fsvs({
                speed : 1000,
                nthClasses : 4,
                mouseDragEvents : false
            });
        }

        if( $.fn.flare ) {
            var flares = $('.flare').flare();
            for( var flare in flares ) {
                //flares[flare].reset();
            }
        }

        var sectionHeight = $('#fsvs-body > .slide:eq(0)').height();
        $('#fsvs-body > .slide').each( function(){
            var section = $(this),
                item = $('.item', section ),
                demo = $('.demo', section ),
                itemHeight = item.outerHeight(),
                demoHeight = demo.outerHeight();
            item.css({
                marginTop : ( ( sectionHeight - itemHeight ) / 2 ) + 'px'
            });
            demo.css({
                marginTop : ( ( sectionHeight - demoHeight ) / 2 ) + 'px'
            });

        });

    });
</script>