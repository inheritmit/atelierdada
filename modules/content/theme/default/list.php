<?php
    $query_string = '';
    $label = 'Content';
    if(isset($_GET['t']) && in_array($_GET['t'], array_keys($cont_obj::$_types))) {
        $query_string = '?t='.$_GET['t'];
        $label = $cont_obj::$_types[$_GET['t']];
    }
?>
<link href="<?php _e($theme_url);?>assets/advanced-datatable/css/demo_page.css" rel="stylesheet" />
<link href="<?php _e($theme_url);?>assets/advanced-datatable/css/demo_table.css" rel="stylesheet" />
<h3 class="timeline-title clear">
	<i class="fa fa-file-text-o"></i> &nbsp; Manage <?php _e($label);?>
	<a href="<?php echo _e($module_url);?>/add-content" class="btn btn-primary ar"><i class="fa fa-plus"></i> Add New</a>
</h3>
<section class="panel">
    <div class="panel-body">
  	<div class="an"></div>
	<div id="contentList">
    	<a onclick="location.href='javascript:void(0);'" class="ajaxButton loadMore firstLoad" data-lib="dataTable" data-url="content/load/all<?php _e($query_string);?>" data-container="#contentList" data-action="add">Load More</a>
  	</div></div>
</section> 		  