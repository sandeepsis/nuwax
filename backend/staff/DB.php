<?php
	include('config.php');
	$dbBean = new DatabaseBean();	
	$general = new General($dbBean);
	$Staff = new Staff($dbBean);

	if ($_REQUEST['FLAG']=='ADD_STAFF')
	{	
		if (trim($_REQUEST['name'])=="") {
			$_SESSION['msg']='Please enter name';
			$num='danger';
			$url= ADMIN_URL."/staff/add.php";
			$general->redirectUrl($url, $num);
		    exit;
		}
						
		if($_FILES['staffimg']['name'] == "") {
			$_SESSION['msg']='Please select image';
			$num='danger';
			$url= ADMIN_URL."/staff/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if(trim($_REQUEST['contactno'])=="") {
			$_SESSION['msg']='Please enter contact no';
			$num='danger';
			$url= ADMIN_URL."/staff/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		else
		{
			$pattern = '/^[0-9]+$/';
			if (preg_match($pattern, trim($_REQUEST['contactno'])) == '0') {
				$_SESSION['msg']='Please enter valid contactno';
				$num='danger';
				$url= ADMIN_URL."/staff/add.php";
				$general->redirectUrl($url, $num);
				exit;
			}			
		}
		if(trim($_REQUEST['emailaddress'])=="")	{
			$_SESSION['msg']='Please enter email address';
			$num='danger';
			$url= ADMIN_URL."/staff/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		else {
			if (!filter_var(trim($_REQUEST['emailaddress']), FILTER_VALIDATE_EMAIL)) {
				$_SESSION['msg']='Please enter valid email address';
				$num='danger';
				$url= ADMIN_URL."/staff/add.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
		
		if (trim($_REQUEST['address'])=="")	{
			$_SESSION['msg']='Please enter address';
			$num='danger';
			$url= ADMIN_URL."/staff/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if (trim($_REQUEST['service'])=="")	{
			$_SESSION['msg']='Please select services';
			$num='danger';
			$url= ADMIN_URL."/staff/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if ($_REQUEST['assignservice'][0] == "")	{
			$_SESSION['msg']='Please select assign service';
			$num='danger';
			$url= ADMIN_URL."/staff/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if ($_REQUEST['stafflevel'][0] == "") {
			$_SESSION['msg']='Please select staff level';
			$num='danger';
			$url= ADMIN_URL."/staff/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
				
		$resizeImage = new ResizeImage();
		
		if( $Staff->addStaffmember($resizeImage, TEMP_STORAGE, UPLOAD_PATH.STAFF_LARGE_IMG, STAFF_WIDTH, STAFF_HEIGHT, UPLOAD_PATH.STAFF_THUMB_IMG, STAFF_IMG_THUMB_WIDTH, STAFF_IMG_THUMB_HEIGHT, $_REQUEST) )
		{
			$general->addLogAction($_SESSION['adm_user_id'], 'Added', $_REQUEST, 'Staff Management', $_SESSION['adm_status']);
			$error = 'success';
			$_SESSION['msg'] = 'Record saved successfully.';
		}else{
			$error = 'danger';
			$_SESSION['msg'] = 'Error in saving record.';
		}
		
		$url= ADMIN_URL."/staff/index.php";
		$general->redirectUrl($url,$error);
		exit;
	}	
	
	/*********************************************************************************************************/
	
	if($_REQUEST['FLAG']=='EDIT_STAFF')
	{					
		if (trim($_REQUEST['name'])=="")
		{
			$_SESSION['msg']='Please enter name';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/staff/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if (trim($_REQUEST['hdnstaffimg'])=="") {
			if ($_FILES['staffimg']['name'] == "") {
				$_SESSION['msg']='Please select image';
				$num='danger';
				$num.='&id='.$_REQUEST['id'];
				$url= ADMIN_URL."/staff/edit.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
		
		if (trim($_REQUEST['contactno'])=="") {
			$_SESSION['msg']='Please enter contact no';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/staff/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		else
		{
			$pattern = '/^[0-9]+$/';
			if (preg_match($pattern, trim($_REQUEST['contactno'])) == '0') {
				$_SESSION['msg']='Please enter valid contactno';
				$num='danger';
				$num.='&id='.$_REQUEST['id'];
				$url= ADMIN_URL."/staff/edit.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
		if(trim($_REQUEST['emailaddress'])=="") {
			$_SESSION['msg']='Please enter email address';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/staff/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		else {
			if (!filter_var(trim($_REQUEST['emailaddress']), FILTER_VALIDATE_EMAIL)) {
				$_SESSION['msg']='Please enter valid email address';
				$num='danger';
				$num.='&id='.$_REQUEST['id'];
				$url= ADMIN_URL."/staff/edit.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
		
		if (trim($_REQUEST['address'])=="") {
			$_SESSION['msg']='Please enter address';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/staff/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if (trim($_REQUEST['service'])=="") {
			$_SESSION['msg']='Please select services';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/staff/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if ($_REQUEST['assignservice'][0] == "")	{
			$_SESSION['msg']='Please select assign service';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/staff/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if ($_REQUEST['stafflevel'][0] == "") {
			$_SESSION['msg']='Please select staff level';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/staff/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}
				
		$resizeImage = new ResizeImage();
		
		if( $Staff->updateStaffmember($_REQUEST['id'],$_REQUEST['hdnstaffimg'],$resizeImage, TEMP_STORAGE, UPLOAD_PATH.STAFF_LARGE_IMG, STAFF_WIDTH, STAFF_HEIGHT, UPLOAD_PATH.STAFF_THUMB_IMG, STAFF_IMG_THUMB_WIDTH, STAFF_IMG_THUMB_HEIGHT, $_REQUEST) )
		{
			$general->addLogAction($_SESSION['adm_user_id'], 'Edited', $_REQUEST, 'Staff Management', $_SESSION['adm_status']);
			$error = 'success';
			$_SESSION['msg'] = 'Record updated successfully.';
		}else{
			$error = 'danger';
			$_SESSION['msg'] = 'Error in saving record.';
		}
		
		$url= ADMIN_URL."/staff/index.php";
		$general->redirectUrl($url,$error);
		exit;
	}		
	
	
	
	/*************************************************************************************/	
	if(isset($_REQUEST['FLAG']) && $_REQUEST['FLAG']=='DELETE')
	{		
		$id = $_REQUEST['id'];
		
		$idsToDelete = array();
		if ( $id > 0 ) {
			$idsToDelete[] = $id;
		}
		
		if ( Staff::deleteStaffmember(UPLOAD_PATH.STAFF_LARGE_IMG, UPLOAD_PATH.STAFF_THUMB_IMG,$idsToDelete) ) {
			$general->addLogAction($_SESSION['adm_user_id'], 'Deleted', $id, 'Staff Management', $_SESSION['adm_status']);
			$error = 'success';
			$_SESSION['msg'] = 'Record deleted successfully.';
		}
		else {
			$error = 'danger';
			$_SESSION['msg'] = 'Error deleting record.';
		}
		

		$url = ADMIN_URL."/staff/index.php";
		$general->redirectUrl($url, $error);
		exit;
	}
	/*************************************************************************************/

	if(isset($_REQUEST['FLAG']) && $_REQUEST['FLAG'] == 'DELSELECT')
	{		
		$val=0;
		$delete = $_POST['delete'];
		
		$idsToDelete = array();
		
		$idsToDelete = $_POST['delete'];
		
		if ( Staff::deleteStaffmember(UPLOAD_PATH.STAFF_LARGE_IMG, UPLOAD_PATH.STAFF_THUMB_IMG,$idsToDelete) ) {
			$general->addLogAction($_SESSION['adm_user_id'], 'Deleted', $id, 'Staff Management', $_SESSION['adm_status']);
			$_SESSION['msg'] = 'Selected Entries have been deleted.';
			$error = 'success';
		}
		else {
			$_SESSION['msg'] = 'Error deleting entry.';
			$error = 'danger';
		}
			
		$url= ADMIN_URL."/staff/index.php";
		$general->redirectUrl($url, $error);
		exit;
	
	}
	/*********************************************************************************************************/
?>
