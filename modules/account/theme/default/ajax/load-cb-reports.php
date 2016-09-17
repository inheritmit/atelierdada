<?php
	if(!$account_obj->checkAccess('registration', 'cb-report')) {
		_error('unauthorized');
		exit;
	}
?>
	<a onclick="location.href='javascript:void(0);'" id="dataLoad" class="ajaxButton loadMore firstLoad" data-url="account/load/cb-reports" data-container="#cbReportsData" data-action="add" data-lib="dataTable" style="display:none;"></a>
	<?php 
	
		$reg = $account_obj->getRegistrationByAccount($_SESSION[PF.'USERID']);
		
		$pg = isset($_POST['page']) ? $_POST['page'] : 1;
		
		if($_SESSION[PF.'DESGID'] == 2) {
			$qAdd = " and idStore = ".$reg['idStore'];
		}
		
		$report_count = $account_obj->getCBReportsCount($qAdd);
	 	 	 
		if($report_count != 0) {			
			$reports = $account_obj->getCBReports($qAdd);
	?>
    <div class="adv-table">
       <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="table-info">
		 <thead>
          <tr class="headBorder">
          	<th class="number" width="5%">#</th>
            <th width="10%">Invoice Number</th>
            <th width="10%">Invoice Date</th>
            <th width="10%">Mfr #</th>
            <th class="action" width="10%">Action</th>
          </tr>
         </thead>
         <tbody>
         <?php
 		  	$cnt = 1;
		  	foreach($reports as $report) {
			  	if($report['enumStatus']=='1') {
					$class1="class='fa fa-eye _green ajaxButton'";
					$title1="title='Click to Deactivate'";
				} else {  
					$class="class='fa fa-eye-slash _red ajaxButton'";
					$title="title='Click to Activate'";
				}
		 ?>
          <tr>
          		<td class="number"><?php echo $cnt++;?></td>
               	<td><?php _e($report['strAccountInvoiceNum']);?></td>
               	<td><?php _e(date('m-d-Y', strtotime($report['dateInvoice'])));?></td>
               	<td><?php _e($report['strMfrCode']);?></td>
               	<td class="action">              
               	</td>
              </tr>
		 <?php }?>
        </tbody>
       </table> 
    <?php } else { ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listingPage">
        <tr><td height="50" align="center">No report available.</td></tr>
    </table>
    <?php } ?>
    </div>