<?php

    if($_POST['action'] == 'add') {

        if (isset($_FILES['pdf_file']['name']) && !empty($_FILES['pdf_file']['name'])) {
            $upload_path = UPLOAD_PATH . 'career/pdf/';
            $time = time();
            move_uploaded_file($_FILES['pdf_file']['tmp_name'], $upload_path . $time . '_' . $_FILES['pdf_file']['name']);
            $pdfurl = $time . '_' . $_FILES['pdf_file']['name'];
        } else {
            $pdfurl = null;
        }


        $data = array(
            'strName' => $_POST['name'],
            'strDescription' => $_POST['message'],
            'strPhone' => $_POST['phone'],
            'strPdfFile' => $pdfurl,
            'email' => $_POST['email'],
            'intCareerId' => $_POST['id'],
            'dtiCreated' => TODAY_DATETIME);

        $rsData = $career_obj->insertJoinusData($data);

        if ($rsData) {
            $_SESSION[PF . 'MSG'] = "Your application has been successfully submitted";
        }else {
            $_SESSION[PF . 'ERROR'] = "Error while Inserting data";
        }

    }

    _locate(SITE_URL."default/post-submit");