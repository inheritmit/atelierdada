<link href="<?php _e($theme_url);?>assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
<link href="<?php _e($theme_url);?>assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
<?php include('submenu.php');?>
<h3 class="timeline-title">
	<i class="fa fa-archive"></i>&nbsp;Manage Country
	<a href="<?php echo _e($module_url);?>/add-country" class="btn btn-primary ar"><i class="fa fa-plus"></i> Add New</a><div class="clear"></div>
</h3>
<section class="panel">
    <div class="panel-body">
	  	<ul class="teamActivity cf" id="tableListing">
	    	<li class="loadMore"> 
	    	<a onclick="location.href='javascript:void(0);'" id="dataLoad" class="ajaxButton loadMore firstLoad" data-lib="dataTable" data-url="master/load/data&type=country" data-container="#tableListing" data-action="add">Load More</a>
	    	</li>
	  	 </ul> 
  	</div>
</section>