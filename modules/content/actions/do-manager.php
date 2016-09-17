<?php
    _subModule('content', 'block');
    $block_obj = new block();

    _module('master');
    $master_obj = new master();

    function checkSum($filename) {
        $sha1 = sha1($filename);
        $number = preg_replace("/[^0-9,.]/", "", $sha1);
        $code = substr($number, 5, 16);
        return $code;
    }

    function storageName($filename, $size) {
        $code = checkSum($filename);
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $new_file = $code.'_'.TIME.'_'.$size.'.'.$ext;
        return $new_file;
    }

	$upload_path = UPLOAD_PATH.'content/';

    if(!file_exists($upload_path.'thumbs/')) {
        mkdir($upload_path.'thumbs/', 0777);
    }

    if(!file_exists($upload_path.'medium/')) {
        mkdir($upload_path.'medium/', 0777);
    }

    // Upload cover image for content
    $imgurl = (isset($_POST['old_image']) && !empty($_POST['old_image'])) ? $_POST['old_image'] : '';
    if (isset($_FILES['imgurl']['name']) && !empty($_FILES['imgurl']['name'])) {
        if (File::isAllowedType($_FILES['imgurl']['type'])) {
            $imgurl = storageName($_FILES['imgurl']['name'], $_FILES['imgurl']['size']);
            if(move_uploaded_file($_FILES['imgurl']['tmp_name'], $upload_path . $imgurl)) {
                chmod($upload_path . $imgurl, 0777);
                createthumb($upload_path . $imgurl, $upload_path . 'thumbs/' . $imgurl, 200, 0, false);
                createthumb($upload_path . $imgurl, $upload_path . 'medium/' . $imgurl, 400, 0, false);
            }
        } else {
            $_SESSION[PF . 'ERROR'] = "wrong file type";
        }
    }

    // Generate slug for content
    if(isset($_POST['title'])) {
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        $slug = String::generateSEOString($_POST['title']);
        $slug = generateUniqueName($slug, $id, 'mst_content', 'strSlug', 'id', '1');
    }

    // Save new tags
    if (isset($_POST['final_tag']) && !empty($_POST['final_tag'])) {

        $tags = explode(',', $_POST['final_tag']);
        foreach($tags as $tag) {

            $where="strTag = '" . $tag . "' and enmStatus='1' and enmDeleted='0'";
            $get_tag = $master_obj->getMasters($where,'tag');

            if($get_tag == 404){

                $tag_insert = $master_obj->insertData(['tag_name' => $tag], 'tag');
                $tag_id[] = $tag_insert;
            } else {
                $tag_id[] = $get_tag[0]['id'];
            }
        }
    }

    if(isset($_POST['action']) && !empty($_POST['action'])) {

        if($_POST['action'] == "add-trending"){
            $name= $_POST['name'];
            $id = isset($_POST['id']) ? $_POST['id'] : 0;
            $slug = String::generateSEOString($_POST['name']);
            $slug = generateUniqueName($slug, $id, 'rel_trending', 'strSlug', 'id', '1');

            $array_search = array(':deleted' => '0', ':name' => $name);
            $cont_obj->setPrepare($array_search);
            $result = $cont_obj->getTrendingCount("f.enmDeleted = :deleted and f.strTrendingName = :name");

            if($result != 0) {
                $_SESSION[PF.'MSG'] = "This ".$_POST['name']." is already available";
                _locate(SITE_URL."content/add-trending");
            } else {

                $data = array(
                    'strTrendingName' => $_POST['name'],
                    'strDescription' => $_POST['description'],
                    'idContent' => $_POST['studio'],
                    'strSlug' => $slug,
                    'strImageName' => $imgurl,
                    'dtiCreated' => TODAY_DATETIME,
                    'idCreatedBy' => $_SESSION[PF . 'USERID']);
                $trending_id = $cont_obj->insertTrending($data);
                if ($trending_id) {
                    $_SESSION[PF . 'MSG'] = "<strong>" . $_POST['name'] . "</strong> has been successfully added";
                }else {
                    $_SESSION[PF . 'ERROR'] = "Error while Inserting data";
                }
            }
            _locate(SITE_URL."content/trending");
        }

        if($_POST['action'] == "edit-trending"){

            $name= $_POST['name'];
            $id = isset($_POST['id']) ? $_POST['id'] : 0;
            $slug = String::generateSEOString($_POST['name']);
            $slug = generateUniqueName($slug, $id, 'rel_trending', 'strSlug', 'id', '1');

            $array_search = array(':deleted' => '0', ':name' => $name, ':id' => $id);
            $cont_obj->setPrepare($array_search);
            $result = $cont_obj->getTrendingCount("f.enmDeleted = :deleted and f.strTrendingName = :name and f.id != :id");

            if($result != 0) {
                $_SESSION[PF.'MSG'] = "This ".$_POST['name']." is already available";
                _locate(SITE_URL."content/add-trending");
            } else {

                $data = array(
                    'strTrendingName' => $_POST['name'],
                    'strDescription' => $_POST['description'],
                    'idContent' => $_POST['studio'],
                    'strSlug' => $slug,
                    'strImageName' => $imgurl,
                    'dtiModified' => TODAY_DATETIME,
                    'idModifiedBy' => $_SESSION[PF . 'USERID'],
                    'id' => $id);
                $trending_id = $cont_obj->updateTrending($data);
                if ($trending_id) {
                    $_SESSION[PF . 'MSG'] = "<strong>" . $_POST['name'] . "</strong> has been successfully updated";
                }else {
                    $_SESSION[PF . 'ERROR'] = "Error while Inserting data";
                }
            }
            _locate(SITE_URL."content/trending");
        }

        if($_POST['action'] == "add-feature"){
            $name= $_POST['name'];
			$id = isset($_POST['id']) ? $_POST['id'] : 0;
			$slug = String::generateSEOString($_POST['name']);
			$slug = generateUniqueName($slug, $id, 'rel_features', 'strSlug', 'id', '1');

            $array_search = array(':deleted' => '0', ':name' => $name);
            $cont_obj->setPrepare($array_search);
            $result = $cont_obj->getFeatureCount("f.enmDeleted = :deleted and f.strFeatureName = :name");

            if($result != 0) {
                $_SESSION[PF.'MSG'] = "This ".$_POST['name']." is already available";
                _locate(SITE_URL."content/add-feature");
            } else {

                $data = array(
                    'strFeatureName' => $_POST['name'],
                    'strDescription' => $_POST['description'],
					'idContent' => $_POST['studio'],
                    'strSlug' => $slug,
                    'strImageName' => $imgurl,
                    'dtiCreated' => TODAY_DATETIME,
                    'idCreatedBy' => $_SESSION[PF . 'USERID']);
                $feature_id = $cont_obj->insertFeature($data);
                if ($feature_id) {
                    $_SESSION[PF . 'MSG'] = "<strong>" . $_POST['name'] . "</strong> has been successfully added";
                }else {
                    $_SESSION[PF . 'ERROR'] = "Error while Inserting data";
                }
            }
			_locate(SITE_URL."content/features");
        }

        if($_POST['action'] == "edit-feature"){

			$name= $_POST['name'];
			$id = isset($_POST['id']) ? $_POST['id'] : 0;
			$slug = String::generateSEOString($_POST['name']);
			$slug = generateUniqueName($slug, $id, 'rel_features', 'strSlug', 'id', '1');

			$array_search = array(':deleted' => '0', ':name' => $name, ':id' => $id);
			$cont_obj->setPrepare($array_search);
			$result = $cont_obj->getFeatureCount("f.enmDeleted = :deleted and f.strFeatureName = :name and f.id != :id");

			if($result != 0) {
				$_SESSION[PF.'MSG'] = "This ".$_POST['name']." is already available";
				_locate(SITE_URL."content/add-feature");
			} else {

				$data = array(
					'strFeatureName' => $_POST['name'],
					'strDescription' => $_POST['description'],
					'idContent' => $_POST['studio'],
					'strSlug' => $slug,
					'strImageName' => $imgurl,
					'dtiModified' => TODAY_DATETIME,
					'idModifiedBy' => $_SESSION[PF . 'USERID'],
					'id' => $id);
				$feature_id = $cont_obj->updateFeature($data);
				if ($feature_id) {
					$_SESSION[PF . 'MSG'] = "<strong>" . $_POST['name'] . "</strong> has been successfully updated";
				}else {
					$_SESSION[PF . 'ERROR'] = "Error while Inserting data";
				}
			}
			_locate(SITE_URL."content/features");
        }

        if($_POST['action'] == 'add-content') {

            $title = $_POST['title'];

            $array_search = array(':deleted' => '0', ':title' => $title);
            $cont_obj->setPrepare($array_search);
            $result = $cont_obj->getContentCount(" and enmDeleted = :deleted and strTitle = :title");

            if($result != 0) {
                $_SESSION[PF.'MSG'] = "This ".$_POST['title']." is already available";
                _locate(SITE_URL."content/add-content");
            } else {

                if (isset($_FILES['pdf_file']['name']) && !empty($_FILES['pdf_file']['name'])) {
                    $upload_path = UPLOAD_PATH . 'content/pdf/';
                    $time = time();
                    move_uploaded_file($_FILES['pdf_file']['tmp_name'], $upload_path . $time . '_' . $_FILES['pdf_file']['name']);
                    $pdfurl = $time . '_' . $_FILES['pdf_file']['name'];
                }

                $data = array(
                    'strTitle' => $_POST['title'],
                    'strContentType' => $_POST['cont_type'],
                    'dtContent' => date('Y-m-d', strtotime($_POST['content_date'])),
                    'strColor' => $_POST['content_color'],
                    'strSlug' => $slug,
                    'strContentImg' => $imgurl,
                    'strPdfFile' => isset($pdfurl) ? $pdfurl : '',
                    'dtiCreated' => TODAY_DATETIME,
                    'idCreatedBy' => $_SESSION[PF . 'USERID']);
                $content_id = $cont_obj->insertData($data);

                $id = $content_id;

                if(isset($_POST['cont_type']) && $_POST['cont_type'] == 'c') {

                    if(isset($_POST['product']) && !empty($_POST['product'])) {
                        $relation_data = array(
                            'type' => 'product',
                            'type_id' => $_POST['product'],
                            'content_id' => $content_id
                        );

                        $cont_obj->insertContentRelation($relation_data);
                    }

                    if(isset($_POST['studio']) && !empty($_POST['studio'])) {
                        $relation_data = array(
                            'type' => 'studio',
                            'type_id' => $_POST['studio'],
                            'content_id' => $content_id
                        );

                        $cont_obj->insertContentRelation($relation_data);
                    }

                }

                if (isset($tag_id) && !empty($tag_id)) {

                    foreach($tag_id as $tag_id_value) {
                        $rel_tag_data = [
                            'intTagID' => $tag_id_value,
                            'intContentID' => $content_id
                        ];

                        $cont_obj->insertRelTagData($rel_tag_data);

                    }

                }

                if(isset($_POST['block'])) {

                    foreach($_POST['block'] as $pos => $block) {

                        $block_id = $_POST['block_id'][$block];
                        $block_title = isset($_POST[$block.'_title'][$pos]) ? $_POST[$block.'_title'][$pos] : '';
                        $block_desc = isset($_POST[$block.'_desc'][$pos]) ? $_POST[$block.'_desc'][$pos] : '';
                        $block_position = isset($_POST[$block.'_position'][$pos]) ? $_POST[$block.'_position'][$pos] : 0;

                        $block_data = array(
                            'content' => $id,
                            'block' => $block_id,
                            'heading' => $block_title,
                            'description' => $block_desc,
                            'position' => $block_position
                        );

                        $content_block_id = $block_obj->insertContentBlock($block_data);

                        if(isset($_POST[$block][$pos]) && $block == 'text') {

                            $block_details = array(
                                'details' => $_POST[$block][$pos],
                                'content_block' => $content_block_id
                            );

                            $block_details_id = $block_obj->insertBlockDetails($block_details);

                        }

                        if(isset($_POST[$block][$pos]) && $block == 'mobile') {
                            if (sizeof(block::$_mobile_apps) > 0) {

                                foreach(block::$_mobile_apps as $app) {

                                    if(isset($_POST[$block.'_'.$app][$pos]) && !empty($_POST[$block.'_'.$app][$pos])) {

                                        $block_details = array(
                                            'details' => $_POST[$block.'_'.$app][$pos],
                                            'content_block' => $content_block_id,
                                            'type' => $app
                                        );

                                        $block_details_id = $block_obj->insertBlockDetails($block_details);

                                    }

                                }

                            }
                        }

                        if($block == 'file-upload' && isset($_FILES[$block]['name'])) {

                            $file_block = $_FILES[$block];
                            $filename = $file_block['name'];

                            if (!empty($filename)) {
                                if (File::isAllowedType($file_block['type'], 'file')) {
                                    $fileurl = storageName($filename, $file_block['size']);
                                    if(move_uploaded_file($file_block['tmp_name'], $upload_path . $fileurl)) {
                                        chmod($upload_path . $fileurl, 0777);

                                        $block_details = array(
                                            'details' => $fileurl,
                                            'content_block' => $content_block_id
                                        );

                                        $block_details_id = $block_obj->insertBlockDetails($block_details);
                                    } else {
                                        $_SESSION[PF.'ERROR'] = 'ERROR! unable to upload file';
                                    }
                                } else {
                                    $_SESSION[PF . 'ERROR'] = "ERROR! wrong file type";
                                }
                            }

                        }

                        if(isset($_FILES[$block]['name'][$pos]) && $block == 'image') {

                            foreach($_FILES[$block]['name'][$pos] as $count => $filename) {

                                $file_block = $_FILES[$block];

                                if (!empty($filename)) {
                                    if (File::isAllowedType($file_block['type'][$pos][$count])) {
                                        $imgurl = storageName($filename, $file_block['size'][$pos][$count]);
                                        if(move_uploaded_file($file_block['tmp_name'][$pos][$count], $upload_path . $imgurl)) {
                                            chmod($upload_path . $imgurl, 0777);
                                            createthumb($upload_path . $imgurl, $upload_path . 'thumbs/' . $imgurl, 200, 0, false);
                                            createthumb($upload_path . $imgurl, $upload_path . 'medium/' . $imgurl, 400, 0, false);

                                            $block_details = array(
                                                'details' => $imgurl,
                                                'content_block' => $content_block_id
                                            );

                                            $block_details_id = $block_obj->insertBlockDetails($block_details);
                                        } else {
                                            $_SESSION[PF.'ERROR'] = 'ERROR! unable to upload file';
                                        }
                                    } else {
                                        $_SESSION[PF . 'ERROR'] = "ERROR! wrong file type";
                                    }
                                } else {
                                    $imgurl = null;
                                }

                            }

                        }

                    }

                }

                if ($content_id) {
                    $_SESSION[PF . 'MSG'] = "<strong>" . $_POST['title'] . "</strong> has been successfully added";
                }else {
                    $_SESSION[PF . 'ERROR'] = "Error while Inserting data";
                }
            }
        }

        if($_POST['action'] == 'edit-content') {

            $title = $_POST['title'];

            if (isset($_FILES['pdf_file']['name']) && !empty($_FILES['pdf_file']['name'])) {
                $upload_path = UPLOAD_PATH . 'content/pdf/';
                $time = time();
                move_uploaded_file($_FILES['pdf_file']['tmp_name'], $upload_path . $time . '_' . $_FILES['pdf_file']['name']);
                $pdfurl = $time . '_' . $_FILES['pdf_file']['name'];
            }elseif(isset($_POST['old_pdf'])) {
                $pdfurl = $_POST['old_pdf'];
            } else {
                $pdfurl = "";
            }

            $array_search = array(':deleted' => '0', ':title' => $title, ':id' => $id);
            $cont_obj->setPrepare($array_search);
            $result = $cont_obj->getContentCount(" and enmDeleted = :deleted and strTitle = :title and id != :id");

            if($result != 0) {
                $_SESSION[PF.'MSG'] = "This ".$_POST['title']." is already available";
                _locate(SITE_URL."content/add-content");
            } else {

                $data = array(
                    'strTitle' => $_POST['title'],
                    'strContentType' => $_POST['cont_type'],
                    'dtContent' => date('Y-m-d', strtotime($_POST['content_date'])),
                    'strColor' => $_POST['content_color'],
                    'strSlug' => $slug,
                    'strContentImg' => $imgurl,
                    'strPdfFile' => $pdfurl,
                    'dtiModified' => TODAY_DATETIME,
                    'idModifiedBy' => $_SESSION[PF . 'USERID'],
                    'id' => $id);
                $content_updated = $cont_obj->updateData($data);

                if(isset($_POST['cont_type']) && $_POST['cont_type'] == 'c') {

                    if(isset($_POST['product']) && !empty($_POST['product']) && @$_POST['old_product'] != $_POST['product']) {
                        $relation_data = array(
                            'type' => 'product',
                            'type_id' => $_POST['product'],
                            'content_id' => $id
                        );

                        $cont_obj->updateContentRelation($relation_data);
                    }

                    if(isset($_POST['studio']) && !empty($_POST['studio']) && @$_POST['old_studio'] != $_POST['studio']) {
                        $relation_data = array(
                            'type' => 'studio',
                            'type_id' => $_POST['studio'],
                            'content_id' => $id
                        );

                        $cont_obj->updateContentRelation($relation_data);
                    }

                }

                if (isset($tag_id) && !empty($tag_id)) {

                    $cont_obj->deleteTag("intContentID = " . $id);

                    foreach($tag_id as $tag_id_value) {
                        $rel_tag_data = [
                            'intTagID' => $tag_id_value,
                            'intContentID' => $id,
                            'dtiCreated' => TODAY_DATETIME,
                            'idCreatedBy' => $_SESSION[PF.'USERID']
                        ];
                        $cont_obj->insertRelTagData($rel_tag_data);
                    }
                }

                if(isset($_POST['block'])) {

                    //pr($_FILES);

                    foreach($_POST['block'] as $pos => $block) {

                        $block_id = $_POST['block_id'][$block];
                        $block_title = isset($_POST[$block.'_title'][$pos]) ? $_POST[$block.'_title'][$pos] : '';
                        $block_desc = isset($_POST[$block.'_desc'][$pos]) ? $_POST[$block.'_desc'][$pos] : '';
                        $block_position = isset($_POST[$block.'_position'][$pos]) ? $_POST[$block.'_position'][$pos] : 0;

                        $block_data = array(
                            'content' => $id,
                            'block' => $block_id,
                            'heading' => $block_title,
                            'description' => $block_desc,
                            'position' => $block_position
                        );

                        if(isset($_POST['content_block_id'][$pos])) {
                            $content_block_id = $_POST['content_block_id'][$pos];
                            $block_data['id'] = $content_block_id;
                            $content_block_updated = $block_obj->updateContentBlock($block_data);

                            $block_content_details = $block_obj->getBlockDetailsByContentBlockID($content_block_id);
                        } else {
                            $content_block_id = $block_obj->insertContentBlock($block_data);
                        }

                        if(isset($_POST[$block][$pos]) && $block == 'text') {

                            $block_details = array(
                                'details' => $_POST[$block][$pos],
                                'content_block' => $content_block_id
                            );

                            if(isset($_POST['content_block_id'][$pos])) {
                                $block_details_id = $block_obj->updateBlockDetails($block_details);
                            } else {
                                $block_details_id = $block_obj->insertBlockDetails($block_details);
                            }

                        }

                        if($block == 'mobile') {

                            if (sizeof(block::$_mobile_apps) > 0) {

                                foreach(block::$_mobile_apps as $app) {

                                    if(isset($_POST[$block.'_'.$app][$pos]) && !empty($_POST[$block.'_'.$app][$pos])) {

                                        $block_details = array(
                                            'details' => $_POST[$block.'_'.$app][$pos],
                                            'content_block' => $content_block_id,
                                            'type' => $app
                                        );

                                        if(isset($_POST['content_block_id'][$pos]) && $block_content_details != 404) {
                                            $block_details_id = $block_obj->updateBlockDetails($block_details);
                                        } else {
                                            $block_details_id = $block_obj->insertBlockDetails($block_details);
                                        }

                                    }

                                }

                            }
                        }

                        if($block == 'file-upload' && isset($_FILES[$block]['name'][$pos])) {

                            $file_block = $_FILES[$block];
                            $filename = $file_block['name'][$pos];

                            if (!empty($filename)) {
                                if (File::isAllowedType($file_block['type'][$pos], 'file')) {
                                    $fileurl = storageName($filename, $file_block['size'][$pos]);
                                    if(move_uploaded_file($file_block['tmp_name'][$pos], $upload_path . $fileurl)) {
                                        chmod($upload_path . $fileurl, 0777);

                                        $block_details = array(
                                            'details' => $fileurl,
                                            'content_block' => $content_block_id
                                        );

                                        $block_details_id = $block_obj->insertBlockDetails($block_details);
                                    } else {
                                        $_SESSION[PF.'ERROR'] = 'ERROR! unable to upload file {file-upload}';
                                    }
                                } else {
                                    $_SESSION[PF . 'ERROR'] = "ERROR! wrong file type {file-upload}";
                                }
                            }

                        }

                        if(isset($_FILES[$block]['name'][$pos]) && $block == 'image') {

                            foreach($_FILES[$block]['name'][$pos] as $count => $filename) {

                                $file_block = $_FILES[$block];

                                if (!empty($filename)) {
                                    if (File::isAllowedType($file_block['type'][$pos][$count])) {
                                        $imgurl = storageName($filename, $file_block['size'][$pos][$count]);
                                        if(move_uploaded_file($file_block['tmp_name'][$pos][$count], $upload_path . $imgurl)) {
                                            chmod($upload_path . $imgurl, 0777);
                                            createthumb($upload_path . $imgurl, $upload_path . 'thumbs/' . $imgurl, 200, 0, false);
                                            createthumb($upload_path . $imgurl, $upload_path . 'medium/' . $imgurl, 400, 0, false);

                                            $block_details = array(
                                                'details' => $imgurl,
                                                'content_block' => $content_block_id
                                            );

                                            $block_details_id = $block_obj->insertBlockDetails($block_details);
                                        } else {
                                            $_SESSION[PF.'ERROR'] = 'ERROR! unable to upload file';
                                        }
                                    } else {
                                        $_SESSION[PF . 'ERROR'] = "ERROR! wrong file type";
                                    }
                                }

                            }

                        }

                    }

                }

                if ($content_updated) {
                    $_SESSION[PF . 'MSG'] = "<strong>" . $_POST['title'] . "</strong> has been successfully updated";
                }else {
                    $_SESSION[PF . 'ERROR'] = "ERROR! unable to update record";
                }
            }
        }

		if($_POST['action'] == 'addpc'){

            if(isset($_POST['products']) && !empty($_POST['products'])) {
                foreach ($_POST['products'] as $val) {
                    $data1 = array(
                        'intContentId' => $_POST['contentid'],
                        'intTypeId' => $val,
                        'strType' => 'product'
                    );
                    $rsCRData1 = $cont_obj->insertContentRelationData($data1);
                }
            }
            if(isset($_POST['casestudies']) && !empty($_POST['casestudies'])) {
                foreach ($_POST['casestudies'] as $val) {
                    $data2 = array(
                        'intContentId' => $_POST['contentid'],
                        'intTypeId' => $val,
                        'strType' => 'case-study'
                    );
                    $rsCRData2 = $cont_obj->insertContentRelationData($data2);
                }
            }
            if ($rsCRData1 || $rsCRData2) {
                $_SESSION[PF . 'MSG'] = "Content has been added successfully ";
            }else {
                $_SESSION[PF . 'ERROR'] = "Error while Inserting data";
            }
        }
        if($_POST['action'] == 'editpc'){
            //pr($_POST); exit;

            if(isset($_POST['products']) && !empty($_POST['products'])) {
                $cont_obj->deleteContentRelationData("intContentId=" . $_POST['contentid']);
            }

            if(isset($_POST['products']) && !empty($_POST['products'])) {
                foreach ($_POST['products'] as $val) {
                    $data1 = array(
                        'intContentId' => $_POST['contentid'],
                        'intTypeId' => $val,
                        'strType' => 'product'
                    );
                    $rsCRData1 = $cont_obj->insertContentRelationData($data1);
                }
            }
            if(isset($_POST['casestudies']) && !empty($_POST['casestudies'])) {
                foreach ($_POST['casestudies'] as $val) {
                    $data2 = array(
                        'intContentId' => $_POST['contentid'],
                        'intTypeId' => $val,
                        'strType' => 'case-study'
                    );
                    $rsCRData2 = $cont_obj->insertContentRelationData($data2);
                }
            }
            if ($rsCRData1 || $rsCRData2) {
                $_SESSION[PF . 'MSG'] = "project or case-study updated successfully ";
            }else {
                $_SESSION[PF . 'ERROR'] = "Error while Inserting data";
            }
            _locate(SITE_URL."content/list?t=s");

        }

        if($_POST['action'] == 'add') {

			$title=$_POST['title'];

			$array_search = array(':enmDeleted' => '0');
			$cont_obj->setPrepare($array_search);
			$result = $cont_obj->getContentCount(" and enmDeleted = :enmDeleted");

			if (isset($_FILES['pdf_file']['name']) && !empty($_FILES['pdf_file']['name'])) {
				$upload_path = UPLOAD_PATH . 'content/pdf/';
				$time = time();
				move_uploaded_file($_FILES['pdf_file']['tmp_name'], $upload_path . $time . '_' . $_FILES['pdf_file']['name']);
				$pdfurl = $time . '_' . $_FILES['pdf_file']['name'];
			} else {
				$pdfurl = null;
			}

			$id = isset($_POST['id']) ? $_POST['id'] : 0;
			$slug = String::generateSEOString($_POST['title']);
			$slug = generateUniqueName($slug, $id, 'mst_content', 'strSlug', 'id', '1');

			$data = array(
				'strTitle' => $_POST['title'],
				'strContentType' => $_POST['cont_type'],
				'dtContent' => date('Y-m-d', strtotime($_POST['content_date'])),
				'strDescription' => $_POST['content'],
				'strSlug' => $slug,
				'dtiCreated' => TODAY_DATETIME,
				'idCreatedBy' => $_SESSION[PF . 'USERID'],
				'strContentImg' => $imgurl,
				'strPdfFile' => $pdfurl);

			if (isset($_POST['url']) && !empty($_POST['url'])) {
				$data['strUrl'] = $_POST['url'];
			}

			$rsData = $cont_obj->insertData($data);
			//strat code for insert category id related to content id into rel_content table
			if (isset($_POST['sel_category']) && !empty($_POST['sel_category'])) {
				for ($i = 0; $i < count($_POST['sel_category']); $i++) {
					$content_data = array(
						'intCategoryID' => $_POST['sel_category'][$i],
						'intContentID' => $rsData,
						'dtiCreated' => TODAY_DATETIME,
						'idCreatedBy' => $_SESSION[PF . 'USERID']);
					$rsContentData = $cont_obj->insertCategoryData($content_data);
				}
			}


            if (isset($tag_id) && !empty($tag_id)) {


                foreach($tag_id as $tag_id_value) {
                    $rel_tag_data = [
                        'intTagID' => $tag_id_value,
                        'intContentID' => $rsData
                    ];

                    $cont_obj->insertRelTagData($rel_tag_data);

                }

            }


			if ($rsContentData) {
				$_SESSION[PF . 'MSG'] = "<strong>" . $_POST['title'] . "</strong> has been successfully added";
		    }else {
			    $_SESSION[PF . 'ERROR'] = "Error while Inserting data";
			}
		 //}
		}

        if($_POST['action'] == 'edit') {

			$title = $_POST['title'];

			/*$array_search = array('enmDeleted' => '0','strTitle' => $title,'id'=>$_POST['id']);

			$result = $cont_obj->getContentCount($array_search);*/
			$array_search = array(':enmDeleted' => '0', ':id' => $_POST['id']);
			$cont_obj->setPrepare($array_search);
			$result = $cont_obj->getContentCount(" and enmDeleted = :enmDeleted and id != :id");


            $id = isset($_POST['id']) ? $_POST['id'] : 0;

            //code for pdf file start here
            if (isset($_FILES['pdf_file']['name']) && !empty($_FILES['pdf_file']['name'])) {
                //$upload_path = $module_path . 'upload/pdf/';
                $upload_path = UPLOAD_PATH . 'content/pdf/';
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
            $slug = generateUniqueName($slug, $id, 'mst_content', 'strSlug', 'id', '1');


            $modified = array(
                'strTitle' => $_POST['title'],
                'strContentType' => $_POST['cont_type'],
                'dtContent' => date('Y-m-d', strtotime($_POST['content_date'])),
                'strDescription' => $_POST['content'],
                'strSlug' => $slug,
                'dtiModified' => TODAY_DATETIME,
                'idModifiedBy' => $_SESSION[PF . 'USERID'],
                'strContentImg' => $imgurl,
                'strPdfFile' => $pdfurl,
                'id' => $id);

            if (isset($_POST['url']) && !empty($_POST['url'])) {
                $modified['strUrl'] = $_POST['url'];
            }
            //pr($modified);exit;
            $rsData = $cont_obj->updateData($modified);

            if (isset($tag_id) && !empty($tag_id)) {

                $cont_obj->deleteTag("intContentID = " . $id);

                foreach($tag_id as $tag_id_value) {
                    $rel_tag_data = [
                        'intTagID' => $tag_id_value,
                        'intContentID' => $_POST['id']
                    ];

                    $cont_obj->insertRelTagData($rel_tag_data);

                }

            }

            //End here

            if ($rsData) {
                $_SESSION[PF . 'MSG'] = "<strong>" . $_POST['title'] . "</strong> has been successfully Updated";
            } else {
                $_SESSION[PF . 'ERROR'] = "Error while Updateing data";
            }
		}

		_locate(SITE_URL."content/list?t=".$_POST['cont_type']);
	}