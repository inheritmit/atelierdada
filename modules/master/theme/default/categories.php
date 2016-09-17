<link href="<?php _e($theme_url);?>assets/advanced-datatable/css/demo_page.css" rel="stylesheet" />
<link href="<?php _e($theme_url);?>assets/advanced-datatable/css/demo_table.css" rel="stylesheet" />
<h3 class="timeline-title">
	<i class="fa fa-archive"></i>&nbsp;Manage Category
	<a href="<?php echo _e($module_url);?>/add-category" class="btn btn-primary ar"><i class="fa fa-plus"></i> Add New</a><div class="clear"></div>
    <a href="<?php echo _e($module_url);?>/bulk-add?t=<?php _e(_b64('category'));?>" class="btn btn-primary btn-xs ml20"><i class="fa fa-plus"></i> Bulk Add</a>
    <a href="<?php echo _e($module_url);?>/arrange-categories" class="btn btn-primary btn-xs ml20"><i class="fa fa-plus"></i> Arrange Categories</a>
</h3>
<section class="panel">
    <div class="panel-body">
	  	<ul class="teamActivity cf" id="tableListing">
	    	<li class="loadMore"> 
	    	<a onclick="location.href='javascript:void(0);'" id="dataLoad" class="ajaxButton loadMore firstLoad" data-lib="dataTable" data-url="master/load/data&type=category" data-container="#tableListing" data-action="add">Load More</a>
	    	</li>
	  	 </ul> 
  	</div>
</section>