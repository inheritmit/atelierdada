<?php
	if(!$account_obj->checkAccess('access-user', 'list')) {
		_error('unauthorized');
		exit;
	}
?>
	<a onclick="location.href='javascript:void(0);'" id="dataLoad" class="ajaxButton loadMore firstLoad" data-url="account/load/all" data-container="#teamActivity" data-action="add" data-lib="dataTable" style="display:none;"></a>
	<?php 
		
		$pg = isset($_POST['page']) ? $_POST['page'] : 1;
		
		$qAdd = "main.enmDeleted = '0' and main.enmActivated='1'";
		if(isset($_POST['q']) && !empty($_POST['q'])) {
			$qAdd .= " and fullName like ('%".$_POST['q']."%')";
		}
		
		$account_count = $account_obj->getAccountsCount($qAdd);
	 	 	 
		if($account_count != 0) {			
			$accounts = $account_obj->getAccounts($qAdd);
	?>
    <div class="adv-table">
       <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="table-info">
		 <thead>
          <tr class="headBorder">
          	<th class="number" width="5%">#</th>
            <th>Name</th>
            <th class="action" width="20%">Account Type</th>
            <th class="action" width="10%">Action</th>
          </tr>
         </thead>
         <tbody>
         <?php
 		  	$cnt = 1;
		  	foreach($accounts as $account) {
			  	if($account['tinStatus']=='1') {
					$class1="class='fa fa-eye _green ajaxButton'";
					$title1="title='Click to Deactivate'";
				} else {  
					$class="class='fa fa-eye-slash _red ajaxButton'";
					$title="title='Click to Activate'";
				}
		 ?>
          <tr>
          		<td class="number"><?php echo $cnt++;?></td>
                       <td><a href="<?php _e($module_url);?>/profile?id=<?php _e($account['id']);?>"><?php _e($account['strFirstName'].' '.$account['strLastName']);?></a></td>
                       <td><?php _e($account['atName']);?></td>
                       
                       <td class="action">
                         <a href="<?php _e($module_url);?>/edit?id=<?php echo $account['id'];?>" class="fa fa-edit" title="Edit Access User"></a>
                         <span id="activate_<?php echo $account['id'];?>">
                         <a href='javascript:void(0);'  <?php if($account['tinStatus']==1){ echo $class1; echo $title1; } else { echo $class; echo $title; }?> data-url="account/load/change-status?status=<?php echo $account['tinStatus']?>&id=<?php echo $account['id'];?>" data-container="#activate_<?php echo $account['id'];?>" data-action="add"></a>
                         </span>
                       	 <a href='javascript:void(0);' class="ajaxButton fa fa-trash-o" data-action="delete" data-msg="Are you really want to delete this record?" data-url="account/load/delete-data?id=<?php echo $account['id'];?>" data-container="#tableListing" title="Delete Access User" data-trigger="a#dataLoad"></a>
						 <a href="<?php _e($module_url);?>/addfile?id=<?php echo $account['id'];?>" class="edit" title="AddFile"></a>
                       </td>
                      </tr>
		 <?php }?>
        </tbody>
       </table> 
    <?php } else { ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listingPage">
        <tr><td height="50" align="center">No Access User available.</td></tr>
    </table>
    <?php } ?>
    </div>