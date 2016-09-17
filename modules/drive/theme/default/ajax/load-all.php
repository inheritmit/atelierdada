<?php
	if(isset($_POST['folder']) && !empty($_POST['folder'])) {
		$folder = $drvObj->getItemByStorageName($_POST['folder']);
	}
	
	if (isset($_POST['q']) && is_string($_POST['q'])) {
		
		$results = array();
		
		require_once 'Zend/Filter/Input.php';
		require_once 'Zend/Search/Lucene.php';
		require_once 'Zend/Search/Lucene/Proxy.php';
		require_once 'Zend/Search/Lucene/Search/Query/Term.php';
		require_once 'Zend/Search/Lucene/Search/Query/Boolean.php';
		require_once 'Zend/Search/Lucene/Index/Term.php';
		
		$_indexFile =  SITE_ROOT.'indexes';
		
		$filters = array('q' => array('StringTrim', 'StripTags'));
		$validators = array('q' => array('presence' => 'required'));
		$input = new Zend_Filter_Input($filters, $validators, $_POST);
		
		$queryString = $input->getEscaped('q');
 
        if ($input->isValid()) {
			$luceneIndex = Zend_Search_Lucene::open($_indexFile);
			try {
                $hits = $luceneIndex->find($queryString);
            } catch (Zend_Search_Lucene_Exception $ex) {
                $hits = array();
            }
			
			if(count($hits) > 0) {
				foreach($hits as $hit) {
					$document = $hit->getDocument(); //echo "<pre>"; print_r($document);
					
					$results[] = $document->getFieldValue('Key');
				}
				
				$drvObj->setFilter('idx', implode(", ", $results));
			}
			
        } else {
            $messages = $input->getMessages();
        }
		
		if(sizeof($results) == 0) {
			die('No document found containing string <strong>'.$_POST['q'].'</strong>');
		}
    }
?>
<h3 class="drive-title"><i class="fa fa-archive"></i> <a href="<?php _e($module_url);?>/all">All Documents</a><?php if(isset($folder)) { ?> <i class="fa fa-caret-right"></i> <?php _e($folder['fileName']);?><?php } ?></h3>
<section class="panel">
  <div class="panel-body">
	<?php
		if(isset($_POST['folder']) && !empty($_POST['folder'])) {
			$items = $drvObj->getDriveByFolder($folder['id']);
		} else {
			$items = $drvObj->getDrive();
		}
		
		if($items != 404) {
	?>
    <div>
    <table class="display table" id="table-info" width="100%" style="table-layout:fixed;">
      <thead>
      	<tr class="row">
		  <th class="col-lg-1">&nbsp;</th>
          <th class="col-lg-5">Title</th>
          <th class="col-lg-4">Owner</th>
          <th class="col-lg-2">Last Updated</th>
        </tr>
      </thead>
      <tbody>
         <?php
		 	foreach($items as $item) {
				
				$owner = ($item['userId'] == $_SESSION['USERID']) ? 'me' : $item['ownerName'];
				
				$main_file_url = $file_url = $module_upload_url.'/'.$item['userId'].'/';
				$main_file_path = $module_upload_path.'/'.$item['userId'].'/';
				
				if($item['folder'] != 0) {
					$file_url .= $item['folderTime'].'/';
				}
				
				$file_url .= $item['storageName'];
				
				$ext = pathinfo($item['fileName'], PATHINFO_EXTENSION);
				
				if(in_array($ext, array_keys($convertTypes))) {
					$output_file_name = str_replace('.'.$ext, '.pdf', $item['storageName']);
					$file_url = $main_file_url.'converted/'.$output_file_name;
					$file_path = $main_file_path.'converted/'.$output_file_name;					
				}
		 ?>
          <tr class="row" style="display:block;">
          	<td class="col-lg-1">&nbsp;</td>
            <td class="col-lg-5">
            	<?php if($item['type'] == 'folder') { ?>
                <a onclick="location.href='javascript:void(0);'" class="ajaxButton loadMore" data-lib="thickBox" data-url="drive/load/all?sort=latest&folder=<?php _e($item['storageName']);?>" data-container="#driveItems" data-action="add" data-location="folder/<?php _e($item['storageName']);?>"><i class="fa fa-<?php _e($item['type']);?>"></i> <?php _e($item['fileName']);?></a>
                <?php } else { ?>
                	<?php if(in_array($ext, array_keys($convertTypes)) || strtolower($ext) == 'pdf') { ?>
                	<a href="<?php _e($theme_url.'assets/pdfjs/viewer.html');?>?file=<?php _e($module_url.'/file-view/'.$item['fileTime']);?>&TB_iframe=true&full=true" class="thickbox <?php _e(strtolower($ext));?>">&nbsp;&nbsp;<?php _e($item['fileName']);?></a> <?php if(in_array($ext, array_keys($convertTypes)) && !file_exists($file_path)) { ?> <a href="<?php _e($module_url.'/convert/do?f='.$item['fileTime']);?>" class="btn btn-info btn-xs">Convert</a><?php } ?>
                	<?php } else { ?>
                    <a href="<?php _e($module_url.'/image-view/'.$item['fileTime']);?>?TB_iframe=true&full=true" class="thickbox <?php _e(strtolower($ext));?>">&nbsp;&nbsp;<?php _e($item['fileName']);?></a>
                    <?php } ?>
                <?php } ?>
            </td>
            <td class="col-lg-4"><?php _e($owner);?></td>
            <td class="col-lg-2"><?php _e(date('d-m-Y H:i', $item['fileTime']));?></td>
          </tr>
		 <?php }?>
       </tbody>
    </table>
    </div>
    <?php } else { ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listingPage">
        <tr><td height="50" align="center">No file available.</td></tr>
    </table>
    <?php } ?>
  </div>
</section>