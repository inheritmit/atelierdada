<?php
if(!$account_obj->checkAccess('store', 'list')) {
	_error('unauthorized');
	exit;
}
?>
<a onclick="location.href='javascript:void(0);'" id="dataLoad" class="ajaxButton loadMore firstLoad" data-url="account/load/stores" data-container="#listStores" data-action="add" data-lib="dataTable" style="display:none;"></a>
	<?php 
		$pg = isset($_POST['page']) ? $_POST['page'] : 1;
		
		$qAdd = "enumApproved = '1'";
		
		$reg_count = $account_obj->getRegistrationsCount($qAdd);
	 	 	 
		if($reg_count != 0) {			
			$regs = $account_obj->getRegistrations($qAdd);
	?>
    <div class="adv-table">
       <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="table-info">
		 <thead>
          <tr class="headBorder">
          	<th class="number" width="5%">#</th>
          	<th width="10%">Store ID</th>
            <th>Company Name</th>
            <th width="15%">Phone</th>
            <th width="20%">Email Address</th>
            <th class="action" width="20%">Action</th>
          </tr>
         </thead>
         <tbody>
         <?php
 		  	$cnt = 1;
		  	foreach($regs as $reg) {
		 ?>
          <tr>
          	<td align="center" class="number"><?php echo $cnt++;?></td>
          	<td align="center"><?php _e($reg['idStore']);?></td>
            <td><?php _e($reg['txtCompanyName']);?></td>
            <td align="center"><?php _e($reg['txtCompanyPhone']);?></td>
            <td align="center"><?php _e($reg['txtCompanyEmail']);?></td>
            <td class="action">
            	<?php if($account_obj->checkAccess('store', 'report')) { ?>
            	<a href="<?php _e($module_url);?>/store-reports?t=<?php _e(_b64($reg['idStore']));?>" class="btn btn-info btn-xs"><i class="fa fa-file-text"></i> Reports</a>
                <?php } ?>
           	</td>
          </tr>
		 <?php }?>
        </tbody>
       </table> 
    <?php } else { ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listingPage">
        <tr><td height="50" align="center">No store available.</td></tr>
    </table>
    <?php } ?>
    </div>