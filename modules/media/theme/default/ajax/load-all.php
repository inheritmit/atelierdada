<a onclick="location.href='javascript:void(0);'" id="dataLoad" class="ajaxButton loadMore firstLoad" data-url="media/load/all" data-container="#teamActivity" data-action="add"
   data-lib="dataTable" style="display:none;"></a>
<?php 
$pg = isset($_POST['page']) ? $_POST['page'] : 1;

$qAdd = "enmDeleted = '0'";
if(isset($_POST['q']) && !empty($_POST['q'])) {
	$qAdd .= " and strName like ('%".$_POST['q']."%')";
}

$media_count = $media_obj->getMediaCount($qAdd);
if($media_count != 0) {
	$medias = $media_obj->getMedias($qAdd);
?>
<div class="adv-table">
  <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="table-info">
    <thead>
      <tr class="headBorder">
        <th width="5%">No.</th>
        <th width="15%">Photo Name</th>
        <th width="50%">Photo Description</th>
	    <th width="10%" style="text-align: center">Photo </th>
        <th width="10%" style="text-align: center">Action</th>
      </tr>
    </thead>
    <tbody>
		<?php
		$cnt = 1;
		foreach($medias as $media) {
		if($media['enmStatus']=='1') {
			$class1="class='fa fa-eye _green ajaxButton'";
			$title1="title='Click to Deactivate'";
		} else {
			$class="class='fa fa-eye-slash _red ajaxButton'";
			$title="title='Click to Activate'";
		}
		 ?>
      <tr>
        <td><?php echo $cnt++;?></td>
        <td><?php _e($media['strName'])?></td>
        <td><?php _e($media['txtDescription'])?></td>
	    <td><a href="<?php _e($module_url);?>/photoupload?id=<?php echo $media['id'];?>">Upload photos</a></td>
        <td align="center">
			<a href="<?php _e($module_url);?>/edit?id=<?php echo $media['id'];?>" class="fa fa-edit" title="Edit Photo"></a>
			<span id="activate_<?php echo $media['id'];?>">
				<a href='javascript:void(0);'
				<?php if($media['enmStatus']==1){ echo $class1; echo $title1; } else { echo $class; echo $title; }?>
			    data-url="media/load/change-status?status=<?php echo $media['enmStatus']?>&id=<?php echo $media['id'];?>"
			    data-container="#activate_<?php echo $media['id'];?>" data-action="add"></a>
			</span>
            <a href='javascript:void(0);' class="ajaxButton fa fa-trash-o"
			   data-action="delete" data-msg="Are you really want to delete this record?"
			   data-url="media/load/delete-data&id=<?php echo $media['id']; ?>"
			   data-container="#tableListing" title="Delete Photos" data-trigger="a#dataLoad">
			</a>

		</td>
        
      </tr>
      <?php }?>
    </tbody>
  </table>
  <?php } else { ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listingPage">
    <tr>
      <td height="50" align="center">No Photos available.</td>
    </tr>
  </table>
  <?php } ?>
</div>
