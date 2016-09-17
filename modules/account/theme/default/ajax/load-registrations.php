<?php
if(!$account_obj->checkAccess('registration', 'list')) {
	_error('unauthorized');
	exit;
}
?>
<a onclick="location.href='javascript:void(0);'" id="dataLoad" class="ajaxButton loadMore firstLoad" data-url="account/load/registrations" data-container="#listRegistrations" data-action="add" data-lib="dataTable" style="display:none;"></a>
	<?php 
		
		$approval = array('new' => 0, 'approved' => 1, 'rejected' => 2);
		
		$pg = isset($_POST['page']) ? $_POST['page'] : 1;
		
		$qAdd = "1";
		if(isset($_POST['t']) && !empty($_POST['t'])) {
			$qAdd .= " and enumApproved = '".$approval[$_POST['t']]."'";
		}
		
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
				
				if($reg['enumApproved']=='0') {
					$class1='btn-success';
					$title1='<i class="fa fa-eye _green"></i> Approve';
				} else {  
					$class1="btn-danger";
					$title1='<i class="fa fa-eye-slash _red"></i> Reject';
				}
		 ?>
          <tr>
          	<td align="center" class="number"><?php echo $cnt++;?></td>
          	<td align="center"><?php _e(($reg['idStore'] == 0) ? '----' : $reg['idStore']);?></td>
            <td><?php _e($reg['txtCompanyName']);?><?php if(!empty($reg['fileAddresses'])) { if(file_exists($module_path.'/upload/signup/'.$reg['fileAddresses'])) { ?> <a href="<?php _e($module_url.'/upload/signup/'.$reg['fileAddresses']);?>"><i class="fa fa-download"></i></a><?php } else { ?> <i class="fa fa-exclamation-triangle" title="Attached file is not available"></i><?php } } ?></td>
            <td align="center"><?php _e($reg['txtCompanyPhone']);?></td>
            <td align="center"><?php _e($reg['txtCompanyEmail']);?></td>
            <td class="action">
            	<?php if($account_obj->checkAccess('registration', 'view-pdf')) { ?>
            	<a href="<?php _e($module_url);?>/pdf?t=<?php _e(_b64($reg['txtCompanyEmail']));?>" class="btn btn-info btn-xs" target="_blank"><i class="fa fa-file-text"></i> PDF</a>
                <?php } ?>
                <?php 
					if($reg['enumApproved'] == '1') { 
						if($account_obj->checkAccess('registration', 'edit')) {
				?>
                <a href="<?php _e($module_url);?>/update-registration?t=<?php _e(_b64($reg['txtCompanyEmail']));?>" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> Update</a>
                <?php 
						}
						
						if($account_obj->checkAccess('registration', 'upload-files')) {
				?>
                <a href="<?php _e($module_url);?>/upload-files?t=<?php _e(_b64($reg['txtCompanyEmail']));?>" class="btn btn-info btn-xs"><i class="fa fa-upload"></i> Upload</a>
                <?php 
						}
						
						if($account_obj->checkAccess('registration', 'generate-password') && $reg['enumApproved']=='1') {
							if($reg['accountId'] == 0) {
				?>
                <a href="<?php _e($module_url);?>/generate-password?t=<?php _e(_b64($reg['txtCompanyEmail']));?>" class="btn btn-success btn-xs" title="Generate Access Details"><i class="fa fa-lock"></i> Generate</a>
                <?php 
							} else if($reg['accountId'] != 0 && $reg['enmActivated'] == '0') {
				?>
                <a href="<?php _e($module_url);?>/access-details?t=<?php _e(_b64($reg['txtCompanyEmail']));?>" class="btn btn-success btn-xs" title="Print Access Details Letter"><i class="fa fa-print"></i> Print</a>
                <?php
							}
						}
					}
				?>
                <?php if($reg['enumApproved']=='0') { ?>
                <?php if($account_obj->checkAccess('registration', 'approve')) { ?>
            	<a href='javascript:void(0);' class="ajaxButton btn btn-success btn-xs" data-url="account/load/approval?stat=1&id=<?php echo $reg['id'];?>" data-trigger="a#dataLoad"><i class="fa fa-thumbs-o-up"></i> Approve</a>
                <?php } ?>
                <?php if($account_obj->checkAccess('registration', 'reject')) { ?>
                <a href='javascript:void(0);' class="ajaxButton btn btn-danger btn-xs" data-url="account/load/approval?stat=2&id=<?php echo $reg['id'];?>" data-trigger="a#dataLoad"><i class="fa fa-thumbs-o-down"></i> Reject</a>
                <?php } ?>
                <?php } ?>
           	</td>
          </tr>
		 <?php }?>
        </tbody>
       </table> 
    <?php } else { ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listingPage">
        <tr><td height="50" align="center">No registration available.</td></tr>
    </table>
    <?php } ?>
    </div>