<!--[if lt IE 8]>
<link rel="stylesheet" href="<?php _e($theme_url);?>assets/link-icons/css/ie7.css">
<!--<![endif]-->
<link href="<?php _e($theme_url);?>assets/link-icons/css/link-icon-font.css" type="text/css" rel="stylesheet">
<a onclick="location.href='javascript:void(0);'" id="dataLoad" class="ajaxButton loadMore firstLoad _type" data-lib="thickBox" data-url="drive/load/my?sort=latest<?php if(isset($_GET['q']) && !empty($_GET['q'])) { ?>&q=<?php _e($_GET['q']);?><?php } ?>" data-container="#driveItems" data-action="add" style="display:none;">Load More</a>
<?php include_once('drive-footer.php');?>
<div id="driveItems"></div>