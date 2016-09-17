<a onclick="location.href='javascript:void(0);'" id="dataLoad" class="ajaxButton loadMore firstLoad" data-url="career/load/joinus&id=<?php echo $_POST['id']; ?>" data-container="#teamActivity" data-action="add" data-lib="dataTable" style="display:none;"></a>
<?php 
		
$pg = isset($_POST['page']) ? $_POST['page'] : 1;
$qAdd = "enmDeleted = '0' and intCareerId = " . $_POST['id'];
if(isset($_POST['q']) && !empty($_POST['q'])) {
    $qAdd .= " and strTitle like ('%".$_POST['q']."%')";
}

$array_search = array(':enmDeleted' => '0');
$career_obj->setPrepare($array_search);
$page_count = $career_obj->getJoinUsCount("enmDeleted = :enmDeleted");
	 	 	 
		if($page_count != 0) {
			$pages = $career_obj->getJoinUs($qAdd);
	?>
<div class="adv-table">
  <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="table-info">
    <thead>
      <tr class="headBorder">
        <th width="70">No.</th>
        <th>Name</th>
        <th>Description</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Pdf</th>
      </tr>
    </thead>
    <tbody>
      <?php
 		  	$cnt = 1;
		  	foreach($pages as $page) {

		 ?>
      <tr>
        <td><?php echo $cnt++;?></td>
        <td><?php _e($page['strName']);?></td>
        <td><?php _e($page['strDescription']);?></td>
        <td><?php _e($page['strPhone']);?></td>
        <td><?php _e($page['email']);?></td>
        <td><a href="<?php echo SITE_URL . 'file-manager/career/pdf/' . $page['strPdfFile'] ?>" target="_blank"><?php echo $page['strPdfFile']; ?></a></td>
      </tr>
      <?php }?>
    </tbody>
  </table>
  <?php } else { ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listingPage">
    <tr>
      <td height="50" align="center">No Content available.</td>
    </tr>
  </table>
  <?php } ?>
</div>
