<?php 
	$modules = array('page' => array('title' => 'Pages',
									 'action' => array('add', 'edit','list','contact-list')),
					 'access-user' => array('title' => 'Access Users',
											'action' => array('add', 'access', 'list')),
					 'master' => array('title' => 'Manage Masters',
									   'action' => array('access-type', 'category')),
                     'access-type' => array('title' => 'Manage Access Types',
                                            'action' => array('add', 'edit', 'list', 'assign')),
					 'category' => array('title' => 'Manage Categories',
										'action' => array('add', 'edit', 'list')),
                     'content' => array('title' => 'Manage Contents',
                                         'action' => array('add', 'edit', 'list')),
                     'career' => array('title' => 'Manage Career',
                                        'action' => array('add', 'edit', 'list')));
									
	$actions = array('add' => 'Add',
					 'edit' => 'Update',
					 'delete' => 'Delete',
					 'list' => 'List',
					 
					 'approve' => 'Approve',
					 'reject' => 'Reject',
					 'assign' => 'Assign',
					 'main-approval' => 'Main Approval',
					 
					 'apply' => 'Application',
					 'approval' => 'Approval',
					 'cancel' => 'Cancel',
					 'entitlement' => 'Entitlement',
					 'list-team' => 'List Team',
					 'disable' =>'Disable',
					 'access' => 'Change Access',
					 'arrange' => 'Arrange Data',
					 'upload-files' => 'Upload Files',
                     'contact-list' => 'Contact List'
					 );

$id = $_GET['type'];
$access_type = $master_obj->getMasterByID($id);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>

<style type="text/css">
div.element { float:left; width:580px; }
label.entry { float:left; width: 250px; padding: 5px; }
label.element-entry { padding: 5px; float: none; }
div.box { border: 1px solid #DDD; background:#f4f3ee; padding: 10px; height:200px; overflow:auto; margin:5px 0; -moz-box-shadow: inset 0 0 2px #e2e2e2; -webkit-box-shadow: inset 0 0 2px #e2e2e2; box-shadow: inset 0 0 2px #e2e2e2; }
.optiondiv ul{
  margin-top: 5px;
}
.optiondiv ul li{
  margin-bottom: 4px;
}
.optiondiv ul li input{
  margin-top: 2px;
  border: 0;
  border-bottom: 1px #ccc solid;
}
.optiondiv ul li input:focus{
  border: 0;
  border-bottom: 1px #ccc solid;
}
</style>

<body>
   <section class="panel">
   <header class="panel-heading">
   <i class="fa fa-archive"></i>&nbsp;Assign Roles [ <?php echo $access_type['strAccessType']; ?> ]
   </header>
  <div class="panel-body"><div class="form">

	<form id="access_type_form" name="access_type_form" method="post" action="<?php _e(SITE_URL);?>master/assign/do">
	  <input type="hidden" name="id" value="<?php echo $_GET['type'];?>" />
      <input type="hidden" name="assign-action" value="assign-roles" />
      <input type="hidden" name="sub-action" value="<?php echo (!empty($access_type['modules']) ? 'edit' : 'add');?>" />
      
       <table width="100%" border="0" cellpadding="3" cellspacing="0">
        <thead>
		<tr>
          <td width="20%" style="font-size:16px;"><strong>Modules</strong></td>
          <td style="font-size:16px;"><strong>Actions</strong></td>
          </tr>
		</thead>
       
		<?php
		foreach($modules as $module => $mdata) {
			$current_modules = unserialize($access_type['txtModules']);
			$current_actions = unserialize($access_type['txtActions']);
	    ?>
        <tr style="border-top:1px solid #DDD;">
          <td valign="top"><input type="checkbox" name="module[]" value="<?php echo $module;?>"<?php if(!empty($access_type['txtModules']) && in_array($module, $current_modules)) { ?> checked="checked"<?php } ?> /> &nbsp;
            <?php echo $mdata['title'];?></td>
          <td>
		  <?php
          	foreach($mdata['action'] as $action) {
				$display = isset($modules[$action]) ? $modules[$action]['title'] : (isset($actions[$action]) ? $actions[$action] : 'undefined');
		  ?>
          	<span style="width:200px; display:inline-block; padding:5px;"><input type="checkbox" name="action[<?php echo $module;?>][<?php echo $action;?>]" value="1"<?php if(!empty($current_actions[$module]) && in_array($action, array_keys($current_actions[$module]))) {?> checked="checked"<?php } ?> /> &nbsp;<?php _e($display);?></span>
          <?php
          	}
		  ?>
          </td>
        </tr>
        
		<?php
		}
		?>
        
      </table>
      
          <div class="col-sm-8" style="margin-left:30%; margin-top:1%;">
               <button type="submit" name="submit" id="submit" class="btn btn-info">Save Changes</button> <input type="reset" name="button2" value="Reset" class="btn btn-danger" />	
          </div>
      
    </form>
	</div>
  </div>
</section>