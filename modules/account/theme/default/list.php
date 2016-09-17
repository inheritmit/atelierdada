<?php 
	$_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];
	
    if(!isset($req['page'])){
	  	$pg = 1;
		if(isset($_SESSION['q'])) { 
			unset($_SESSION['q']); 
		}
	} else {
		$pg = $req['page'];
  	}
?>
<link href="<?php _e($theme_url);?>assets/advanced-datatable/css/demo_page.css" rel="stylesheet" />
<link href="<?php _e($theme_url);?>assets/advanced-datatable/css/demo_table.css" rel="stylesheet" />

<h3 class="timeline-title">
	<i class="fa fa-archive"></i>&nbsp;Manage User
	<a href="<?php echo _e($module_url);?>/add" class="btn btn-primary ar"><i class="fa fa-plus"></i> Add New</a><div class="clear"></div>
</h3>
<div class="panel-body">
	<div class="an"></div>
	<ul class="teamActivity cf" id="teamActivity">
	    <?php if(isset($_GET['cid'])){?>
	    <li class="loadMore"><a onclick="location.href='javascript:void(0);'" class="ajaxButton loadMore firstLoad" data-lib="dataTable" data-url="account/load/all&cid=<?php echo $_GET['cid'];?>" data-container="#teamActivity" data-action="add">Load More</a></li>
	    <?php }else{?>
    	<li class="loadMore"><a onclick="location.href='javascript:void(0);'" class="ajaxButton loadMore firstLoad" data-lib="dataTable" data-url="account/load/all" data-container="#teamActivity" data-action="add">Load More</a></li>
      	<?php }?>
    </ul>