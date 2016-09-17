<?php
	require_once 'Zend/Search/Lucene.php';
	require_once 'Zend/Search/Lucene/Document.php';
	
	_class('pdf2text');
	$pdf = new pdf2text();
	
	_class('office2text');
	$office = new office2text();
	
	function parseDate($date) {
		$distance = substr($date, 16, 2);
		if (!is_long($distance)) {
			$distance = null;
		}
		// Convert date from the PDF format of D:20090731160351+01'00'
		$date = mktime(substr($date, 10, 2), //hour
			substr($date, 12, 2), //minute
			substr($date, 14, 2), //second
			substr($date,  6, 2), //month
			substr($date,  8, 2), //day
			substr($date,  2, 4)); //distance
		return $date;
	}
	
	$_indexFile =  SITE_ROOT.'indexes';
	
	$index = Zend_Search_Lucene::create($_indexFile);
	
	$files = $drvObj->getFiles();
	if($files != 404) {
		foreach($files as $item) {
			
			$ext = pathinfo($item['storageName'], PATHINFO_EXTENSION);
			if($ext != 'pdf' && !in_array($ext, array_keys($convertTypes))) continue;
			
			$upload_path = $module_upload_path.'/'.$item['userId'].'/';
			
			$file_path = $upload_path.$item['storageName'];
			
			echo "<br />-------------------------------------------------------------------------------------";
			echo "<br />".$file_path;
			
			$pdf->setFilename($file_path);
			$pdf->decodePDF();
			
			$contents = $pdf->output();
			
			if(in_array($ext, array_keys($convertTypes))) {
				$office->setFile($file_path);
				$contents = $office->convertToText();
			}
			
			echo "<br />-------------------------------------------------------------------------------------";
			echo "<br />".$contents;
			
			$doc = new Zend_Search_Lucene_Document();
			
			$doc->addField(Zend_Search_Lucene_Field::Keyword('Filename', $item['fileName']));
			$doc->addField(Zend_Search_Lucene_Field::Keyword('Key', $item['id']));
			$doc->addField(Zend_Search_Lucene_Field::UnStored('Contents', $contents));
			
        	/**
			 * Parse the contents of the PDF document and pass the text to the
			 * contents item in the $indexValues array.
			 */
			
			if ($doc !== false) {
				// If the document creation was sucessful then add it to our index.
				$index->addDocument($doc);
			}
		}
	}
?>