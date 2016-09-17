<?php
    $pg = isset($_POST['page']) ? $_POST['page'] : 1;

    $qAdd = " and enmDeleted = :deleted";

    $array_search = array(':deleted' => '0');
    $query_string = '';
    if (isset($_POST['t']) && in_array($_POST['t'], array_keys($cont_obj::$_types))) {
        $query_string = '?t=' . $_POST['t'];
        $array_search[':content_type'] = $_POST['t'];

        $qAdd .= " and strContentType = :content_type";
    }

    $cont_obj->setPrepare($array_search);
    $page_count = $cont_obj->getContentCount($qAdd);

    if ($page_count != 0) {
    $cont_obj->setPrepare($array_search);
    $pages = $cont_obj->getContents($qAdd);
?>
<a onclick="location.href='javascript:void(0);'" id="dataLoad" class="ajaxButton loadMore firstLoad" data-url="content/load/all<?php _e($query_string); ?>" data-container="#contentList" data-action="add"
   data-lib="dataTable" style="display:none;"></a>
<div class="adv-table">
    <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="table-info">
        <thead>
        <tr class="headBorder">
            <th width="70">No.</th>
            <th>Title</th>
            <th>Slug</th>
            <th width="10%">Type</th>
            <?php if($_POST['t'] == 's') { ?>
                <th width="10%">Projects/Case Studies</th>
            <?php } ?>
            <th width="10%">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
            $cnt = 1;
            foreach ($pages as $page) {
                if ($page['enmStatus'] == '1') {
                    $class = "class='fa fa-eye _green ajaxButton'";
                    $title = "title='Click to Deactivate'";
                } else {
                    $class = "class='fa fa-eye-slash _red ajaxButton'";
                    $title = "title='Click to Activate'";
                }

                if ($page['strContentType'] == 'n') {
                    $type = 'News';
                } elseif ($page['strContentType'] == 'p') {
                    $type = 'Product';
                } elseif ($page['strContentType'] == 'e') {
                    $type = 'Events';
                } elseif ($page['strContentType'] == 's') {
                    $type = 'Studio';
                } elseif ($page['strContentType'] == 'c') {
                    $type = 'Case-Studies';
                } elseif ($page['strContentType'] == 'r') {
                    $type = 'Research';
                }
                ?>
                <tr>
                    <td><?php echo $cnt++; ?></td>
                    <td><?php _e($page['strTitle']); ?></td>
                    <td><?php _e($page['strSlug']); ?></td>
                    <td><?php _e($type); ?></td>
                    <?php if($_POST['t'] == 's') { ?>
                        <td>
                            <a href="<?php _e($module_url); ?>/selectpc?id=<?php echo $page['id']; ?>" class="fa " title="Select Project Case Studies">Select</a></td>
                    <?php } ?>
                    <td><a href="<?php _e($module_url); ?>/edit-content?id=<?php echo $page['id']; ?>" class="fa fa-edit" title="Edit Content"></a>
        <span id="activate_<?php echo $page['id']; ?>">
        	<a href='javascript:void(0);' <?php _e($class.$title);?> data-url="content/load/change-status?status=<?php echo $page['enmStatus'] ?>&id=<?php echo $page['id']; ?>" data-container="#activate_<?php echo $page['id']; ?>"
               data-action="add"></a>
        </span>
                        <a href='javascript:void(0);' class="ajaxButton fa fa-trash-o" data-action="delete"
                           data-msg="Are you really want to delete this record?" data-url="content/load/delete-data&id=<?php echo $page['id']; ?>" data-container="#tableListing"
                           title="Delete Content" data-trigger="a#dataLoad"></a>
                    </td>
                </tr>
            <?php } ?>
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
<script type="text/javascript">
$().ready(function () {
        $(".fancybox").click(function () {
            $.fancybox.open({
                href: this.href,
                type: 'iframe',
                padding: 5,
                minWidth: 320,
                minHeight: 480,
                maxWidth: 320,
                maxHeight: 480,
                topRatio: 0,
                leftRatio: 0
            });
            return false;
        });
    });
</script>