<?php
	include('config.php');
	$dbBean = new DatabaseBean();	
	$general = new General($dbBean);
	$Servicecategory = new Servicecategory($dbBean);

	if ($_REQUEST['FLAG']=='ADD_SERVICECAT') {			
		if (trim($_REQUEST['categoryname'])=="") {
			$_SESSION['msg']='Please enter category name';
			$num='danger';
			$url= ADMIN_URL."/servicecategories/add.php";
			$general->redirectUrl($url, $num);
		    exit;
		}
				
		if (trim($_REQUEST['description'])=="") {
			$_SESSION['msg']='Please enter description';
			$num='danger';
			$url= ADMIN_URL."/servicecategories/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
				
		if ($_FILES['categoryimg']['name'] == "") {
			$_SESSION['msg']='Please select image';
			$num='danger';
			$url= ADMIN_URL."/servicecategories/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		$resizeImage = new ResizeImage();
		
		if ( $Servicecategory->addServicecategory($resizeImage, TEMP_STORAGE, UPLOAD_PATH.SERVICECAT_LARGE_IMG, SERVICECAT_WIDTH, SERVICECAT_HEIGHT, UPLOAD_PATH.SERVICECAT_THUMB_IMG, SERVICECAT_IMG_THUMB_WIDTH, SERVICECAT_IMG_THUMB_HEIGHT, $_REQUEST) ) {
			$general->addLogAction($_SESSION['adm_user_id'], 'Added', $_REQUEST, 'Service Category Management', $_SESSION['adm_status']);
			$error = 'success';
			$_SESSION['msg'] = 'Record saved successfully.';
		} else {
			$error = 'danger';
			$_SESSION['msg'] = 'Error in saving record.';
		}
		
		$url= ADMIN_URL."/servicecategories/index.php";
		$general->redirectUrl($url,$error);
		exit;
	}	
	
	/*********************************************************************************************************/
	
	if ($_REQUEST['FLAG']=='EDIT_SERVICECAT') {		
		if (trim($_REQUEST['categoryname'])=="") {
			$_SESSION['msg']='Please enter category name';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/servicecategories/edit.php";
			$general->redirectUrl($url, $num);
		    exit;
		}
				
		if (trim($_REQUEST['description'])=="") {
			$_SESSION['msg']='Please enter description';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/servicecategories/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}
				
		$resizeImage = new ResizeImage();
		
		if ( $Servicecategory->updateServicecategory($_REQUEST['id'],$_REQUEST['hdncatimg'],$resizeImage, TEMP_STORAGE, UPLOAD_PATH.SERVICECAT_LARGE_IMG, SERVICECAT_WIDTH, SERVICECAT_HEIGHT, UPLOAD_PATH.SERVICECAT_THUMB_IMG, SERVICECAT_IMG_THUMB_WIDTH, SERVICECAT_IMG_THUMB_HEIGHT, $_REQUEST) ) {
			$general->addLogAction($_SESSION['adm_user_id'], 'Edited', $_REQUEST, 'Service Category Management', $_SESSION['adm_status']);
			$error = 'success';
			$_SESSION['msg'] = 'Record updated successfully.';
		} else {
			$error = 'danger';
			$_SESSION['msg'] = 'Error in saving record.';
		}
		
		$url= ADMIN_URL."/servicecategories/index.php";
		$general->redirectUrl($url,$error);
		exit;
	}		
	
	
	
	/*************************************************************************************/	
	if (isset($_REQUEST['FLAG']) && $_REQUEST['FLAG']=='DELETE') {		
		$id = $_REQUEST['id'];
		
		$idsToDelete = array();
		if ( $id > 0 ) {
			$idsToDelete[] = $id;
		}
		
		if ( Servicecategory::deleteServicecategory(UPLOAD_PATH.SERVICECAT_LARGE_IMG, UPLOAD_PATH.SERVICECAT_THUMB_IMG,$idsToDelete) ) {
			$general->addLogAction($_SESSION['adm_user_id'], 'Deleted', $id, 'Service category Management', $_SESSION['adm_status']);
			$error = 'success';
			$_SESSION['msg'] = 'Record deleted successfully.';
		} else {
			$error = 'danger';
			$_SESSION['msg'] = 'Error deleting record.';
		}		

		$url = ADMIN_URL."/servicecategories/index.php";
		$general->redirectUrl($url, $error);
		exit;
	}
	/*************************************************************************************/

	if (isset($_REQUEST['FLAG']) && $_REQUEST['FLAG'] == 'DELSELECT') {		
		$val=0;
		$delete = $_POST['delete'];
		
		$idsToDelete = array();
		
		$idsToDelete = $_POST['delete'];
		
		if ( Servicecategory::deleteServicecategory(UPLOAD_PATH.SERVICECAT_LARGE_IMG, UPLOAD_PATH.SERVICECAT_THUMB_IMG,$idsToDelete) ) {
			$general->addLogAction($_SESSION['adm_user_id'], 'Deleted', $id, 'Service category Management', $_SESSION['adm_status']);
			$_SESSION['msg'] = 'Selected Entries have been deleted.';
			$error = 'success';
		} else {
			$_SESSION['msg'] = 'Error deleting entry.';
			$error = 'danger';
		}
			
		$url= ADMIN_URL."/servicecategories/index.php";
		$general->redirectUrl($url, $error);
		exit;
	
	}
	/*********************************************************************************************************/
?>
