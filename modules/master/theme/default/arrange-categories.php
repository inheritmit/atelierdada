<?php  
	$categories = $mstObj->getMasters(1, 'category', 'position');
?>
<link href="<?php _e($theme_url);?>assets/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css" media="all"/>
<h3 class="timeline-title"><i class="fa fa-archive"></i> &nbsp; Arrange Categories <span class="label label-success ml20" id="response"></span></h3>
<section class="panel">
  <div class="panel-body">
	<ul class="cf sortable" id="category">
    	<?php
		if($categories != 404) {
			foreach($categories as $category) {
		?>
    	<li class="list-primary col-lg-4" id="category_<?php _e($category['id']);?>">
        	<i class="fa fa-ellipsis-v"></i> &nbsp;<?php _e($category['category_name']);?>
        </li>
        <?php
			}
		}
		?>
  	</ul>
  </div>
</section>
<script type="text/javascript" src="<?php _e($theme_url);?>assets/jquery-ui/jquery-ui.min.js" ></script>
<script type="text/javascript">
$(function() {
 	$(".sortable").sortable({ 
		opacity: 0.8, 
		cursor: 'move', 
		update: function() {
			var idv = $(this).attr('id');
			var order = $(this).sortable("serialize") + '&arr=' + idv; 
			$.post("<?php _e($module_url);?>/sorting/do", order, function(theResponse){
				$("#response").html(theResponse);
				$("#response").slideDown('slow');
				slideout();
			});
	  	}          
  	});
});
</script>