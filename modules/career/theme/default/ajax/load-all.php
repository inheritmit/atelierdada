<a onclick="location.href='javascript:void(0);'" id="dataLoad" class="ajaxButton loadMore firstLoad" data-url="career/load/all" data-container="#teamActivity" data-action="add" data-lib="dataTable" style="display:none;"></a>
<?php 
		
		$pg = isset($_POST['page']) ? $_POST['page'] : 1;
		$qAdd = "enmDeleted = '0'";
		if(isset($_POST['q']) && !empty($_POST['q'])) {
			$qAdd .= " and strTitle like ('%".$_POST['q']."%')";
		}

        $array_search = array(':enmDeleted' => '0');
        $career_obj->setPrepare($array_search);
        $page_count = $career_obj->getCareersCount("enmDeleted = :enmDeleted");
	 	 	 
		if($page_count != 0) {			
			$pages = $career_obj->getCareers($qAdd);
            ?>
            <div class="adv-table">
                <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="table-info">
                    <thead>
                    <tr class="headBorder">
                        <th width="70">No.</th>
                        <th>Title</th>
                        <th width="10%">Applications</th>
                        <th width="10%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $cnt = 1;
                        foreach($pages as $page) {
                            if($page['enmStatus'] == '1') {
                                $class1 = "class='fa fa-eye _green ajaxButton'";
                                $title1 = "title='Click to Deactivate'";
                            } else {
                                $class = "class='fa fa-eye-slash _red ajaxButton'";
                                $title = "title='Click to Activate'";
                            }
                            ?>
                            <tr>
                                <td><?php echo $cnt++; ?></td>
                                <td><?php _e($page['strTitle']); ?></td>
                                <td><a href="<?php _e($module_url); ?>/joinus?id=<?php echo $page['id']; ?>"
                                       class="fa fa-list" title="View Applications"> View</a></td>
                                <td><a href="<?php _e($module_url); ?>/edit?id=<?php echo $page['id']; ?>"
                                       class="fa fa-edit" title="Edit Content"></a>
        <span id="activate_<?php echo $page['id']; ?>">
        	<a href='javascript:void(0);' <?php if($page['enmStatus'] == 1) {
                echo $class1;
                echo $title1;
            } else {
                echo $class;
                echo $title;
            } ?>
               data-url="career/load/change-status?status=<?php echo $page['enmStatus'] ?>&id=<?php echo $page['id']; ?>"
               data-container="#activate_<?php echo $page['id']; ?>" data-action="add"></a>
        </span>
                                    <a href='javascript:void(0);' class="ajaxButton fa fa-trash-o" data-action="delete"
                                       data-msg="Are you really want to delete this record?"
                                       data-url="career/load/delete-data&id=<?php echo $page['id']; ?>"
                                       data-container="#tableListing" title="Delete Content"
                                       data-trigger="a#dataLoad"></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
  <?php } else { ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listingPage">
    <tr>
      <td height="50" align="center">No Content available.</td>
    </tr>
  </table>
  <?php } ?>
