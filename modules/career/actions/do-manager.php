<?php

	if(isset($_POST['action']) && !empty($_POST['action'])){

		if($_POST['action'] == 'add') {

			if (isset($_FILES['pdf_file']['name']) && !empty($_FILES['pdf_file']['name'])) {
				$upload_path = UPLOAD_PATH . 'career/pdf/';
				$time = time();
				move_uploaded_file($_FILES['pdf_file']['tmp_name'], $upload_path . $time . '_' . $_FILES['pdf_file']['name']);
				$pdfurl = $time . '_' . $_FILES['pdf_file']['name'];
			} else {
				$pdfurl = null;
			}

			$id = isset($_POST['id']) ? $_POST['id'] : 0;
			$slug = String::generateSEOString($_POST['title']);
			$slug = generateUniqueName($slug, $id, 'mst_career', 'strSlug');

			$data = array(
				'strTitle' => $_POST['title'],
				'strCode' => $_POST['code'],
				'strDescription' => $_POST['content'],
                'strPdfFile' => $pdfurl,
				'strSlug' => $slug,
				'dtiCreated' => TODAY_DATETIME,
				'idCreatedBy' => $_SESSION[PF . 'USERID']);

			if (isset($_POST['url']) && !empty($_POST['url'])) {
				$data['strUrl'] = $_POST['url'];
			}

			$rsData = $career_obj->insertData($data);

			if ($rsData) {
				$_SESSION[PF . 'MSG'] = "<strong>" . $_POST['title'] . "</strong> has been successfully added";
		    }else {
			    $_SESSION[PF . 'ERROR'] = "Error while Inserting data";
			}

		}

        if(isset($_POST['action']) && $_POST['action'] == 'edit') {

            $id = isset($_POST['id']) ? $_POST['id'] : 0;

            //code for pdf file start here
            if (isset($_FILES['pdf_file']['name']) && !empty($_FILES['pdf_file']['name'])) {
                //$upload_path = $module_path . 'upload/pdf/';
                $upload_path = UPLOAD_PATH . 'career/pdf/';
                $time = time();
                move_uploaded_file($_FILES['pdf_file']['tmp_name'], $upload_path . $time . '_' . $_FILES['pdf_file']['name']);
                $pdfurl = $time . '_' . $_FILES['pdf_file']['name'];

            } elseif (isset($_POST['h_pdffile']) && !empty($_POST['h_pdffile'])) {
                $pdfurl = $_POST['h_pdffile'];
            } else {
                $pdfurl = null;
            }
            //end here

            $slug = String::generateSEOString($_POST['title']);
            $slug = generateUniqueName($slug, $id, 'mst_career', 'strSlug');


            $modified = array(
                'strTitle' => $_POST['title'],
                'strCode' => $_POST['code'],
                'strDescription' => $_POST['content'],
                'strPdfFile' => $pdfurl,
                'strSlug' => $slug,
                'dtiModified' => TODAY_DATETIME,
                'idModifiedBy' => $_SESSION[PF . 'USERID']);

            $rsData = $career_obj->updateData($modified);

            if ($rsData) {
                $_SESSION[PF . 'MSG'] = "<strong>" . $_POST['title'] . "</strong> has been successfully Updated";
            } else {
                $_SESSION[PF . 'ERROR'] = "Error while Updateing data";
            }
		}
		_locate(SITE_URL."career/list");
	}
?>