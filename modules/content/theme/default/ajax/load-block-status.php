<?php

    if(empty($_POST['id']) || !is_numeric($_POST['id'])) {
        die('ERROR! Invalid parameter provided.');
    }

    if(isset($_POST['status']) && !in_array($_POST['status'], array(0,1))) {
        die('ERROR! Invalid parameter provided.');
    }

    $id = $_POST['id'];
    $status = $_POST['status'];

    $update_status = ($status == 1) ? 0 : 1;

    if($block_obj->updateContentBlockStatus($id, $update_status)) {
        ?>
        <a href='javascript:void(0);' data-url="content/load/block-status?status=<?php _e($update_status); ?>&id=<?php _e($id); ?>" data-action="add" data-container="#activate_<?php _e($id); ?>"
           class="ajaxButton fa btn<?php if($update_status == '1') echo " fa-eye btn-success"; else echo " fa-eye-slash btn-danger" ?>"
           title="Click to <?php if($update_status == '0') echo "Active"; else echo "DeActivate"; ?>"></a>
        <?php
    } else {
        ?>
        <a href='javascript:void(0);' data-url="content/load/block-status?status=<?php _e($status); ?>&id=<?php _e($id); ?>" data-action="add" data-container="#activate_<?php _e($id); ?>"
           class="ajaxButton fa btn<?php if($status == '1') echo " fa-eye btn-success"; else echo " fa-eye-slash btn-danger" ?>"
           title="Click to <?php if($status == '0') echo "Active"; else echo "DeActivate"; ?>"></a> ERROR!
        <?php
    }