<?php
if (isset($req['parent']) && $req['parent'] == 'photoupload') {
	$photoDetail = $media_obj->getPhotoByAlbum($_GET['id']);
}
?>
<link rel="stylesheet" href="<?php _e($theme_url); ?>assets/colorbox/colorbox.css">
<style type="text/css">
	ul#gallery, ul#gallery li { list-style:none; padding:0; margin:0; }
	ul#gallery li.sortable { float: left; list-style: none; padding: 0 0 10px 0; width:200px; margin-right: 30px; position:relative; }
	ul#gallery li.last { margin-right: 0; }
	ul#gallery li .img_details { text-align: center; }
	ul#gallery li .img_details small { position: absolute; width:98%; text-align: center; top: 0; display:block; background-color: rgba(0,0,0,0.5); padding: 1%; }
	ul#gallery li .img_details small a { color: #FFF; }
</style>

<div id="msg"></div>
<table width="100%" border="0" cellspacing="0" cellpadding="4">
<tr>
	<td colspan="2">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td></td>
		<td width="35%" align="right">
		<p><a class='iframe'
			   href="<?php _e($module_url);?>/photogallery?albumid=<?php echo $_GET['id'];?>">Upload Image
			</a></p>
		<a href="<?php _e(SITE_URL);?>media/list" >&nbsp;<< Back <<</a>
		</td>
	</tr>
	</table>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
</table>

<div class="gallery">
<?php
if($photoDetail != 404)
{
?>
		<ul class="sortable-list" id="gallery">
			<?php

			$module_upload_url = SITE_URL.'modules/'.$module.'/upload/';
			$i = 1;
			foreach($photoDetail as $pd)
			{
				if($pd['enmStatus']=='1') {
					$class1="Deactivate"; // $class1="class='fa fa-eye _green ajaxButton'";
					$title1="title='Click to Deactivate'";
				} else {
					$class="Activate"; // $class="class='fa fa-eye-slash _red ajaxButton'";
					$title="title='Click to Activate'";
				}
?>
<li class="sortable <?php if($i%4 == 0) { ?> last<?php } ?>" id="recordsArray_<?php echo $pd['photoid'];?>">
	<img src="<?php echo SITE_URL . 'file-manager/media/medium/'.$pd['strImageName'];?>"
		 title="<?php echo $pd['strDescription'];?>"
		 alt="<?php echo $pd['strDescription'];?>" class="thumb" />

<div class="img_details">
	<?php echo $pd['strDescription'];?>
	<small>

		<a href='javascript:void(0);' class="ajaxButton fa "
		data-url="media/load/change-photostatus?status=<?php echo $pd['enmStatus']?>&id=<?php echo $pd['photoid'];?>"
		data-container="#activate_<?php echo $pd['photoid'];?>" data-action="add" data-trigger="#reloadPage">
			<?php if($pd['enmStatus']==1){ echo "Deactivate"; } else { echo "Activate"; }?>
		</a> |
		<a href='javascript:void(0);' class="ajaxButton fa "
		   data-url="media/load/change-photodefault?default=<?php echo $pd['enmDefaultImage']?>&id=<?php echo $pd['photoid'];?>"
		   data-container="#activate_<?php echo $pd['photoid'];?>" data-action="add" data-trigger="#reloadPage">
			<?php if($pd['enmDefaultImage']=='1'){ echo "Default"; } else { echo "Make Default"; }?>
		</a> |
		<a href='javascript:void(0);' class="ajaxButton fa "
		   data-url="media/load/change-photodelete?delete=<?php echo $pd['enmDeleted']?>&id=<?php echo $pd['photoid'];?>"
		   data-container="#activate_<?php echo $pd['photoid'];?>" data-action="delete" data-trigger="#reloadPage">
			<?php if($pd['enmDeleted']=='0'){ echo "Delete"; } ?>
		</a>
	</small>
</div>
</li>
<?php
$i++;
}?>
	</ul>
<?php } else
	echo '<div id="msg" style="text-align: center; margin-top: 50px"><b>Photos are not uploaded to this album.</b></div>';
?>
	<a id="reloadPage" onclick="location.href='javascript:void(0);'" onclick="location.reload();" style="display: none;"></a>
</div>


<script type="text/javascript" src="<?php _e($theme_url); ?>assets/jquery-validate/jquery.validate.js"></script>
<script type="text/javascript" src="<?php _e($theme_url); ?>assets/colorbox/jquery.colorbox.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(".iframe").colorbox({iframe:true, width:"60%", height:"40%"});
	$("#photo_form").validate();
});
</script>