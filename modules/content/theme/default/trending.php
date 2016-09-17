<?php $label = 'Trending'; ?>
<link href="<?php _e($theme_url);?>assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
<link href="<?php _e($theme_url);?>assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
<h3 class="timeline-title clear">
	<i class="fa fa-file-text-o"></i> &nbsp; Manage <?php _e($label);?>
	<a href="<?php echo _e($module_url);?>/add-trending" class="btn btn-primary ar"><i class="fa fa-plus"></i> Add New</a>
</h3>
<section class="panel">
    <div class="panel-body">
  	<div class="an"></div>
	<div id="contentList">
    	<a onclick="location.href='javascript:void(0);'" class="ajaxButton loadMore firstLoad" data-lib="dataTable"
           data-url="content/load/trending"
           data-container="#contentList" data-action="add">Load More</a>
  	</div></div>
</section> 		  