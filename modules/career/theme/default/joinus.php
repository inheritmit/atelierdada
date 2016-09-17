<?php
	$careerDetail = $career_obj->getCareer("id=$_GET[id]");
?>
<link href="<?php _e($theme_url);?>assets/advanced-datatable/css/demo_page.css" rel="stylesheet" />
<link href="<?php _e($theme_url);?>assets/advanced-datatable/css/demo_table.css" rel="stylesheet" />
<h3 class="timeline-title clear">
	<i class="fa fa-file-text-o"></i> &nbsp; Join Us - <?php echo $careerDetail['strTitle']; ?>
</h3>
<section class="panel">
    <div class="panel-body">
  	<div class="an"></div>
	<ul class="teamActivity cf" id="teamActivity">
    	<li class="loadMore"><a onclick="location.href='javascript:void(0);'" class="ajaxButton loadMore firstLoad" data-lib="dataTable" data-url="career/load/joinus?id=<?php echo $_GET['id']; ?>" data-container="#teamActivity" data-action="add">Load More</a></li>
  	</ul></div>
</section> 		  