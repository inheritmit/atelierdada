<?php
require_once($module_path.'/class/default.class.php');
$defaultclassobj=new defaultclass();  

$key=$_REQUEST['key'];


if(isset($_REQUEST['action']) && !empty($_REQUEST['action']))
{	        
	$upload_path = $module_path.'/upload/default/';

		if($_REQUEST['action'] == 'add') 
		{	
				if($_FILES['imgurl']['size'] > 90000000){
						
						
						$_SESSION['MSG']  = "Please provide a smaller file";
						setLocation(SITE_URL."default/manage/add?k=".$key);
						
				}
				else{
					if (isset($_FILES['imgurl']['name']) && !empty($_FILES['imgurl']['name']))
				   {
					if(isAllowedImageType($_FILES['imgurl']['type'])){  
						$time=time();						
						move_uploaded_file($_FILES['imgurl']['tmp_name'],$module_path."/upload/default/" . $time.'_'.$_FILES['imgurl']['name']);
						$imgurl = $time.'_'.$_FILES['imgurl']['name'];
						chmod($upload_path . $time.'_'.$_FILES['imgurl']['name'],0644);
					    createthumb($upload_path . $imgurl, $upload_path . 'thumbs/' . $imgurl, 86, 0, false);
						createthumb($upload_path . $imgurl, $upload_path . 'medium/' . $imgurl, 304, 0,  false);
						createthumb($upload_path . $imgurl, $upload_path . 'large/' . $imgurl, 462, 321,  false);
						 }
					else{
						$_SESSION['MSG']  = "wrong file type";
						setLocation(SITE_URL."default/manage/add?k=".$key);	
					    }
				    }
				}
					   
				
		$title=strip_tags($_POST['title']);
				$_SESSION['title']=trim($_POST['title']);
				
			    
   
						$data=array('title'=>$title,
									'imgurl'=>$imgurl,
									'createdBy'=>$_SESSION['USERID'],
									'createdDate'=>TODAY_DATETIME,
									'modifiedBy'=>$_SESSION['USERID'],
									'modifiedDate'=>TODAY_DATETIME);
						 $defaultclass_data=$defaultclassobj->insert_defaultclass($data);
						
												
					if($defaultclass_data){
							 $_SESSION['MSG']  = "successfully been added."; 		     		  
					}else{
							$_SESSION['MSG']  = "Error while inserting data";
					}
			setLocation(SITE_URL."default/manage/index?k=".$key);	
		}
	    if($_REQUEST['action'] == 'edit') 
		{ 	$imgurlc = $_REQUEST['imgurl4'];

if(!empty($_POST['imgurl4']) && file_exists($upload_path . $imgurlc))
			{
				unlink($upload_path . $imgurlc);
				unlink($upload_path . 'thumbs/' . $imgurlc);
				unlink($upload_path . 'medium/' . $imgurlc);
				unlink($upload_path . 'large/' . $imgurlc);
				
			}
			if(isset($_FILES['imgurl']) && !empty($_FILES['imgurl']) && isset($_FILES['imgurl']['name']) && !empty($_FILES['imgurl']['name']) && $_FILES['imgurl']['size'] > 0)
		{
			
			if($_FILES['imgurl']['size'] > 90000000){ 
							$_SESSION['MSG']  = "Please provide a smaller file";
							setLocation(SITE_URL."default/manage/edit?k=".$key."&id=".$_POST['id']);
						
					}else{ 
						if(isAllowedImageType($_FILES['imgurl']['type'])){
							
								$time=time();
								move_uploaded_file($_FILES['imgurl']['tmp_name'],$module_path."/upload/default/" . $time.'_'.$_FILES['imgurl']['name']);
								$imgurl = $time.'_'.$_FILES['imgurl']['name'];
								chmod($upload_path . $time.'_'.$_FILES['imgurl']['name'],0644);
								createthumb($upload_path . $imgurl, $upload_path . 'thumbs/' . $imgurl, 86, 0, false);
								createthumb($upload_path . $imgurl, $upload_path . 'medium/' . $imgurl, 304, 0,  false);
								createthumb($upload_path . $imgurl, $upload_path . 'large/' . $imgurl, 462, 321,  false);
				    	}else{
							$_SESSION['MSG']  = "wrong file type";
							setLocation(SITE_URL."default/manage/edit?k=".$key."&id=".$_POST['id']);
				    	}				
					}
			
		}else{  
		      $imgurl = $_REQUEST['imgurl2'];
		}
		
				
		   		$title=strip_tags($_POST['title']);
				
				
		        $data_edit=array('title'=>$title,
								 'imgurl'=>$imgurl,
								 'modifiedBy'=>$_SESSION['USERID'],
								 'modifiedDate'=>TODAY_DATETIME);				
		        $update_data=$defaultclassobj->update_defaultclass($data_edit,$_POST['id']);
			    
			   if($update_data)
				{
				 $_SESSION['MSG']  ="successfully been update."; 		     		  
				}
				else
				{
				$_SESSION['MSG']  = "Error while updating data";
				}	
		   setLocation(SITE_URL."default/manage/index?k=".$key);	
	}
}
?>