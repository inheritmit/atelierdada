<?php
	if(!isset($_POST['t']) || empty($_POST['t']) || !in_array(_b64($_POST['t'], 'decode'), array_keys($master_obj->_types))) {
		_error(404);
		exit;
	}
	
	$type = _b64($_POST['t'], 'decode');
	
	if(!$account_obj->checkAccess($type, 'list')) {
		_error('unauthorized');
		exit;
	}
?>
<a onclick="location.href='javascript:void(0);'" id="dataLoad" class="ajaxButton loadMore firstLoad" data-lib="dataTable" data-url="master/load/data?t=<?php _e($_POST['t']);?>" data-container="#teamActivity" data-action="add" style="display:none;"></a>
<?php		
	$name = ucwords(str_replace('-', ' ', $type));
	
	$db_name_field = 'str'.str_replace(' ', '', $name);
	
	$qAdd = "enmDeleted = '0'";
	if(isset($_POST['q']) && !empty($_POST['q'])) {
		$qAdd = " and ".$db_name_field." like ('%".$_POST['q']."%')";
	}
	
	$master_data_count = $master_obj->getMasterCount($qAdd, $type);
	if($master_data_count != 0) {
		$master_data = $master_obj->getMasters($qAdd, $type);
?>
<div class="adv-table">
<table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="table-info">
<thead>
    <tr class="headBorder">
    <th width="5%" style="text-align:center;">No.</th>
    <th>Name</th>
    <th width="10%" style="text-align:center;">Action</th>
    </tr>
</thead>
<tbody>
<?php
$cnt = 1;
foreach($master_data as $data)
{
?>
    <tr class="<?php if($cnt%2!=0) echo 'odd';  else echo 'even';?>" id="recordsArray_<?php echo $data['id'];?>">
        <td style="text-align:center;"><?php echo $cnt++;?></td>
        <td><?php _e($data[$db_name_field]);?></td>
        <td class="icons action" style="text-align:center;"> 
        
        <a href="<?php _e($module_url);?>/edit?t=<?php _e($_POST['t']);?>&id=<?php _e($data['id']);?>" class="fa fa-edit" title="Edit <?php _e($name);?>"></a>
        <?php
		if($type != 'access-type') {
			if($data['enmStatus']=='1') {
                    $class1="class='fa fa-eye _green ajaxButton'";
                    $title1="title='Click to Deactivate'";
            } else {  
                    $class="class='fa fa-eye-slash _red ajaxButton'";
                    $title="title='Click to Activate'";
        	}
		?>
        <span id="activate_<?php echo $data['id'];?>">
           <a href='javascript:void(0);' <?php if($data['enmStatus']=='1'){ echo $class1; echo $title1; } else { echo $class; echo $title; }?>
			  data-url="master/load/change-status&id=<?php echo $data['id'];?>&type=<?php _e($type);?>"  data-container="#activate_<?php echo $data['id'];?>" data-action="add"></a>
        </span>
        <?php
		}
		?>
		<?php if($type == 'access-type') { ?><a href="<?php _e($module_url);?>/assign?type=<?php echo $data['id'];?>" class="fa fa-check-square-o"></a><?php } ?>


			<!--<a href='#' id='<?php /*echo $data['id'];*/?>'	class="ajaxButton fa fa-trash-o" data-action="delete"
			   data-container="#tableListing" data-msg="Are you really want to delete this record?"
			   data-url="master/load/delete-data?type=<?php /*_e($type);*/?>&id=<?php /*echo $data['id'];*/?>"
			   title="Delete <?php /*_e($type);*/?>" data-trigger="a#dataLoad"></a>-->


			<a href='javascript:void(0);' class="ajaxButton fa fa-trash-o" data-url="master/load/delete-data?type=<?php _e($type);?>&id=<?php echo $data['id'];?>" data-action="delete" data-container="#tableListing" title="Delete"  data-trigger="a#dataLoad" data-msg="Are you really want to delete this record?"></a>
		</td>
    </tr>
<?php }?>
</tbody>
</table> 
<?php } else { ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listingPage">
	<tr><td height="50" align="center">No Content Type<?php //_e($type);?> available.</td></tr>
</table>
<?php } ?>
</div>
