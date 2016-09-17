<?php
	if(!$account_obj->checkAccess('registration', 'report')) {
		_error('unauthorized');
		exit;
	}
?>
	<a onclick="location.href='javascript:void(0);'" id="dataLoad" class="ajaxButton loadMore firstLoad" data-url="account/load/reports" data-container="#reportsData" data-action="add" data-lib="dataTable" style="display:none;"></a>
	<?php 
	
		$reg = $account_obj->getRegistrationByAccount($_SESSION[PF.'USERID']);
		
		$pg = isset($_POST['page']) ? $_POST['page'] : 1;
		
		$qAdd = '';
		if($_SESSION[PF.'DESGID'] == 2) {
			$qAdd = " and idStore = ".$reg['idStore'];
		}
		
		$report_count = $account_obj->getReportsCount($qAdd);
	 	 	 
		if($report_count != 0) {			
			$reports = $account_obj->getReports($qAdd);
	?>
    <div class="adv-table">
       <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="table-info">
		 <thead>
          <tr class="headBorder">
          	<th width="5%" align="center" class="number">#</th>
            <th align="center">Millennium Invoice Number</th>
            <th width="10%">Claimed Coupons</th>
            <th width="10%">Invoiced Coupons</th>
            <th width="10%">Claimed Face</th>
            <th width="10%">Invoiced Face</th>
            <th width="10%">Charged Back</th>
            <th width="10%">Adjustment</th>
            <th width="10%">CB Handling Fee</th>
            <th width="10%">Adjustment Handling Fee</th>
            <th width="10%">Amount Due</th>
            <?php if($account_obj->checkAccess('job', 'update-invoice')) { ?>
            <th width="5%">Show Fees</th>
            <th width="5%">Postal Charge</th>
            <?php } ?>
            <?php if($account_obj->checkAccess('job', 'print-cheque')) { ?>
            <th width="5%">Print Cheque</th>
            <?php } ?>
            <?php if($account_obj->checkAccess('job', 'cheque-details')) { ?>
            <th width="5%">Cheque Details</th>
            <?php } ?>
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
          		<td align="center" class="number"><?php echo $cnt++;?></td>
               	<td align="center"><a href="<?php _e($module_url);?>/invoice?id=<?php _e($report['id']);?>" target="_blank"><?php _e($report['strJobInvoiceNum']);?></a></td>
               	<td align="right"><?php _e($report['numClaimedCoupons']);?></td>
               	<td align="right"><?php _e($report['numInvoicedCoupons']);?></td>
               	<td align="right"><?php _e($report['numClaimedFace']);?></td>
               	<td align="right"><?php _e($report['numInvoicedFace']);?></td>
               	<td align="right"><?php _e($report['numChargedBack']);?></td>
               	<td align="right"><?php _e($report['numAdjustment']);?></td>
               	<td align="right"><?php _e($report['numCBHandingFee']);?></td>
               	<td align="right"><?php _e($report['numAdjHandlingFee']);?></td>
               	<td align="right"><?php _e($report['numAmountDue']);?></td>
                <?php if($account_obj->checkAccess('job', 'update-invoice')) { ?>
           		<td align="center"><input name="chkShowFees[]" type="checkbox" id="chkShowFees<?php _e($report['id']);?>" value="1" rel="t=fees&id=<?php _e($report['id']);?>" class="chkBox"<?php if($report['enumShowFees'] == '1') { ?> checked="checked"<?php } ?> /></td>
               	<td align="center"><input name="chkShowTC[]" type="checkbox" id="chkShowTC<?php _e($report['id']);?>" value="1" rel="t=tc&id=<?php _e($report['id']);?>" class="chkBox"<?php if($report['enumShowTC'] == '1') { ?> checked="checked"<?php } ?> /></td>
                <?php } ?>
                <?php if($account_obj->checkAccess('job', 'print-cheque')) { ?>
               	<td align="center"><a href="<?php _e($module_url);?>/cheque?id=<?php _e($report['id']);?>" target="_blank">Print</a></td>
                <?php } ?>
                <?php if($account_obj->checkAccess('job', 'cheque-details')) { ?>
               	<td align="center"><a href="<?php _e($module_url);?>/cheque-details?id=<?php _e($report['id']);?>">Not Added</a></td>
                <?php } ?>
           	  </tr>
		 <?php } ?>
        </tbody>
       </table> 
    <?php } else { ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listingPage">
        <tr><td height="50" align="center">No report available.</td></tr>
    </table>
    <?php } ?>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$('.chkBox').click(function() {
		var chk = $(this).attr('checked') ? 1 : 0;
		var qstr = $(this).attr('rel');
		$.ajax({
			type: 'post',
			url: '<?php _e($module_url);?>/update-report/do',
			data: 'status='+chk+'&action=update-report&'+qstr,
			success: function() {
				
			}
		});
	});
});
</script>