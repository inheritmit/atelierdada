<?php
    $pg = isset($_POST['page']) ? $_POST['page'] : 1;

    $qAdd = "f.enmDeleted = :deleted";
    $array_search = array(':deleted' => '0');
    $query_string = '';
        $cont_obj->setPrepare($array_search);
    $page_count = $cont_obj->getTrendingCount($qAdd);

    if ($page_count != 0) {
        $cont_obj->setPrepare($array_search);
        $pages = $cont_obj->getTrending($qAdd);
?>
<a onclick="location.href='javascript:void(0);'" id="dataLoad" class="ajaxButton loadMore firstLoad" data-url="content/load/trending<?php _e($query_string); ?>" data-container="#contentList"
   data-action="add"
   data-lib="dataTable" style="display:none;"></a>
<div class="adv-table">
    <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="table-info">
        <thead>
        <tr class="headBorder">
            <th width="5%">No.</th>
            <th width="25%">Trending Name</th>
            <th width="40%">Description</th>
            <th width="20%">studio</th>
            <th width="10%">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
            $cnt = 1;
            foreach ($pages as $page) {
                if ($page['enmStatus'] == '1') {
                    $class1 = "class='fa fa-eye _green ajaxButton'";
                    $title1 = "title='Click to Deactivate'";
                } else {
                    $class = "class='fa fa-eye-slash _red ajaxButton'";
                    $title = "title='Click to Activate'";
                }
                ?>
                <tr>
                    <td><?php echo $cnt++; ?></td>
                    <td><?php _e($page['strTrendingName']); ?></td>
                    <td><?php _e($page['strDescription']); ?></td>
                    <td><?php _e($page['strTitle']); ?></td>
                    <td>
                        <a href="<?php _e($module_url); ?>/edit-trending?id=<?php echo $page['id']; ?>" class="fa fa-edit" title="Edit Trending"></a>
                        <span id="activate_<?php echo $page['id']; ?>">
        	                <a href='javascript:void(0);' <?php if ($page['enmStatus'] == 1) {
                            echo $class1;
                            echo $title1;
                        } else {
                            echo $class;
                            echo $title;
            } ?> data-url="content/load/change-trending?status=<?php echo $page['enmStatus'] ?>&id=<?php echo $page['id']; ?>" data-container="#activate_<?php echo $page['id']; ?>"
               data-action="add"></a>
        </span>
            <a href='javascript:void(0);' class="ajaxButton fa fa-trash-o" data-action="delete"
               data-msg="Are you really want to delete this record?" data-url="content/load/delete-trending&id=<?php echo $page['id']; ?>" data-container="#tableListing"
               title="Delete Content" data-trigger="a#dataLoad"></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listingPage">
            <tr>
                <td height="50" align="center">No trending available.</td>
            </tr>
        </table>
    <?php } ?>
</div>
