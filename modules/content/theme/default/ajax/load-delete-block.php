<?php

    if(empty($_POST['id']) || !is_numeric($_POST['id'])) {
        die('ERROR! Invalid parameter provided.');
    }
    $id = $_POST['id'];

    if($block_obj->deleteContentBlock($id)) {
        die("Content Block has been successfully deleted");
    } else {
        die("ERROR! unable to delete content block.");
    }