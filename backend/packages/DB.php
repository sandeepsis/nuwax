<?php
	include('config.php');
	$dbBean = new DatabaseBean();	
	$general = new General($dbBean);
	$Package = new Package($dbBean);

	if ($_REQUEST['FLAG']=='ADD_PACKAGE') {			
		if (trim($_REQUEST['packagename'])=="") {
			$_SESSION['msg']='Please select package name';
			$num='danger';
			$url= ADMIN_URL."/packages/add.php";
			$general->redirectUrl($url, $num);
		    exit;
		}
		
		if (trim($_REQUEST['cost'])=="") {
			$_SESSION['msg']='Please enter cost';
			$num='danger';
			$url= ADMIN_URL."/packages/add.php";
			$general->redirectUrl($url, $num);
			exit;
		} else {
			$pattern = '/^[0-9]+(?:\.[0-9]{0,2})?$/';
			if (preg_match($pattern, trim($_REQUEST['cost'])) == '0') {
				$_SESSION['msg']='Please enter valid cost';
				$num='danger';
				$url= ADMIN_URL."/packages/add.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
				
		if (trim($_REQUEST['creditprovided'])=="") {
			$_SESSION['msg']='Please enter credit';
			$num='danger';
			$url= ADMIN_URL."/packages/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}else{
			$pattern = '/^[0-9]+(?:\.[0-9]{0,2})?$/';
			if (preg_match($pattern, trim($_REQUEST['creditprovided'])) == '0') {
				$_SESSION['msg']='Please enter valid credit';
				$num='danger';
				$url= ADMIN_URL."/packages/add.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
		
		$cnt = count($_REQUEST['serviceapplicable']);
				
		if ($cnt==0)	{
			$_SESSION['msg']='Please select service for package';
			$num='danger';
			$url= ADMIN_URL."/packages/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if (trim($_REQUEST['servicediscount'])=="")	{
			$_SESSION['msg']='Please enter service discount (%)';
			$num='danger';
			$url= ADMIN_URL."/packages/add.php";
			$general->redirectUrl($url, $num);
			exit;
		} else {
			$pattern = '/^[0-9]+(?:\.[0-9]{0,2})?$/';
			if (preg_match($pattern, trim($_REQUEST['servicediscount'])) == '0') {
				$_SESSION['msg']='Please enter valid service discount (%).';
				$num='danger';
				$url= ADMIN_URL."/packages/add.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
		
		if (trim($_REQUEST['productdiscount'])=="")	{
			$_SESSION['msg']='Please enter product discount (%)';
			$num='danger';
			$url= ADMIN_URL."/packages/add.php";
			$general->redirectUrl($url, $num);
			exit;
		} else {
			$pattern = '/^[0-9]+(?:\.[0-9]{0,2})?$/';
			if (preg_match($pattern, trim($_REQUEST['productdiscount'])) == '0') {
				$_SESSION['msg']='Please enter valid product discount (%).';
				$num='danger';
				$url= ADMIN_URL."/packages/add.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
		
		if (trim($_REQUEST['taxname'])=="") {
			$_SESSION['msg']='Please enter tax name';
			$num='danger';
			$url= ADMIN_URL."/packages/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if (trim($_REQUEST['taxper'])=="") {
			$_SESSION['msg']='Please enter tax (%)';
			$num='danger';
			$url= ADMIN_URL."/packages/add.php";
			$general->redirectUrl($url, $num);
			exit;
		} else {
			$pattern = '/^[0-9]+(?:\.[0-9]{0,2})?$/';
			if (preg_match($pattern, trim($_REQUEST['taxper'])) == '0') {
				$_SESSION['msg']='Please enter valid tax (%).';
				$num='danger';
				$url= ADMIN_URL."/packages/add.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
		
		$servicedata = implode(',', $_REQUEST['serviceapplicable']);
		
		
		$fieldvalues = array('name' => $_REQUEST['packagename'],'cost' => $_REQUEST['cost'], 'creditprovided' => $_REQUEST['creditprovided'], 'serviceapplicable'=> $servicedata, "servicediscount" => $_REQUEST['servicediscount'], "productdiscount" => $_REQUEST['productdiscount'], "taxname" => $_REQUEST['taxname'],"taxpercent" => $_REQUEST['taxper'],"is_deleted" => '0', "date_added" => date('Y-m-d H:i:s'));
						
		$updated = $Package->addPackage($fieldvalues);
		
		if ($updated) {			
			$general->addLogAction($_SESSION['adm_user_id'],'Added', $updated, 'Package Management', $_SESSION['adm_status']);
			$error  = 'success';
			$_SESSION['msg'] = 'Record added successfully.';
		} else {
			$error  ='danger';
			$_SESSION['msg']='Error adding record.';
		}
				
		$url= ADMIN_URL."/packages/index.php";
		$general->redirectUrl($url,$error);
		exit;
	}	
	
	/*********************************************************************************************************/
	
	if ($_REQUEST['FLAG']=='EDIT_PACKAGE') {		
		if (trim($_REQUEST['packagename'])=="")	{
			$_SESSION['msg']='Please select package name';
			$num='danger';
			$url= ADMIN_URL."/packages/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if (trim($_REQUEST['cost'])=="") {
			$_SESSION['msg']='Please enter cost';
			$num='danger';
			$url= ADMIN_URL."/packages/add.php";
			$general->redirectUrl($url, $num);
			exit;
		} else {
			$pattern = '/^[0-9]+(?:\.[0-9]{0,2})?$/';
			if (preg_match($pattern, trim($_REQUEST['cost'])) == '0') {
				$_SESSION['msg']='Please enter valid cost';
				$num='danger';
				$url= ADMIN_URL."/packages/add.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
		
		if (trim($_REQUEST['creditprovided'])=="") {
			$_SESSION['msg']='Please enter credit';
			$num='danger';
			$url= ADMIN_URL."/packages/add.php";
			$general->redirectUrl($url, $num);
			exit;
		} else {
			$pattern = '/^[0-9]+(?:\.[0-9]{0,2})?$/';
			if (preg_match($pattern, trim($_REQUEST['creditprovided'])) == '0') {
				$_SESSION['msg']='Please enter valid credit';
				$num='danger';
				$url= ADMIN_URL."/packages/add.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
		
		$cnt = count($_REQUEST['serviceapplicable']);
		
		if ($cnt==0) {
			$_SESSION['msg']='Please select service for package';
			$num='danger';
			$url= ADMIN_URL."/packages/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if (trim($_REQUEST['servicediscount'])=="")	{
			$_SESSION['msg']='Please enter service discount (%)';
			$num='danger';
			$url= ADMIN_URL."/packages/add.php";
			$general->redirectUrl($url, $num);
			exit;
		} else {
			$pattern = '/^[0-9]+(?:\.[0-9]{0,2})?$/';
			if (preg_match($pattern, trim($_REQUEST['servicediscount'])) == '0') {
				$_SESSION['msg']='Please enter valid service discount (%).';
				$num='danger';
				$url= ADMIN_URL."/packages/add.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
		
		if (trim($_REQUEST['productdiscount'])=="")	{
			$_SESSION['msg']='Please enter product discount (%)';
			$num='danger';
			$url= ADMIN_URL."/packages/add.php";
			$general->redirectUrl($url, $num);
			exit;
		} else {
			$pattern = '/^[0-9]+(?:\.[0-9]{0,2})?$/';
			if (preg_match($pattern, trim($_REQUEST['productdiscount'])) == '0') {
				$_SESSION['msg']='Please enter valid product discount (%).';
				$num='danger';
				$url= ADMIN_URL."/packages/add.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
		
		if (trim($_REQUEST['taxname'])=="")	{
			$_SESSION['msg']='Please enter tax name';
			$num='danger';
			$url= ADMIN_URL."/packages/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if (trim($_REQUEST['taxper'])=="") {
			$_SESSION['msg']='Please enter tax (%)';
			$num='danger';
			$url= ADMIN_URL."/packages/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		else
		{
			$pattern = '/^[0-9]+(?:\.[0-9]{0,2})?$/';
			if (preg_match($pattern, trim($_REQUEST['taxper'])) == '0') {
				$_SESSION['msg']='Please enter valid tax (%).';
				$num='danger';
				$url= ADMIN_URL."/packages/add.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
		
		$servicedata = implode(',', $_REQUEST['serviceapplicable']);
				
		$cond		= array("id" => $_REQUEST['id']);

		$fieldvalues = array('name' => $_REQUEST['packagename'],'cost' => $_REQUEST['cost'], 'creditprovided' => $_REQUEST['creditprovided'], 'serviceapplicable'=> $servicedata, "servicediscount" => $_REQUEST['servicediscount'], "productdiscount" => $_REQUEST['productdiscount'], "taxname" => $_REQUEST['taxname'],"taxpercent" => $_REQUEST['taxper']);
		
		$updated =$Package->updatePackage($fieldvalues, $cond);

		if ($updated) {
				$general->addLogAction($_SESSION['adm_user_id'], 'Edited', $_REQUEST['id'], 'Package Management', $_SESSION['adm_status']);
				$error = 'success';
				$_SESSION['msg'] = 'Record updated successfully.';
		} else {
				$error = 'danger';
				$_SESSION['msg'] = 'Error updating record.';
		}
		
		$url= ADMIN_URL."/packages/index.php";
		$general->redirectUrl($url,$error);
		exit;
	}		
	
	/*************************************************************************************/	
	if (isset($_REQUEST['FLAG']) && $_REQUEST['FLAG']=='DELETE') {		
		$id=$_REQUEST['id'];
		
		$cond		 = array("id" => $id);
		$fieldvalues = array('is_deleted' => '1');
		
		$deleted = $Package->deletePackage($fieldvalues,$cond);
		
		if ($deleted) {		
			$general->addLogAction($_SESSION['adm_user_id'], 'Deleted', (int)$_REQUEST['id'], 'Package Management', $_SESSION['adm_status']);
			$error = 'success';
			$_SESSION['msg'] = 'Record deleted successfully.';
		} else {
			$error = 'danger';
			$_SESSION['msg'] = 'Error deleting record.';
		}
		

		$url = ADMIN_URL."/packages/index.php";
		$general->redirectUrl($url, $error);
		exit;
	}
	/*************************************************************************************/

	if (isset($_REQUEST['FLAG']) && $_REQUEST['FLAG'] == 'DELSELECT') {		
		$val=0;
		$delete = $_POST['delete'];
		foreach ($delete as $id) 
		{
			$cond		= array("id" => $id);
			$fieldvalues = array('is_deleted' => '1');
			
			$val = $Package->deletePackage($fieldvalues,$cond);
		
			$general->addLogAction($_SESSION['adm_user_id'], 'Deleted', (int)$id,'Package Management', $_SESSION['adm_status']);
		}
		
		if ($val) {
			$_SESSION['msg'] = 'Selected Entries have been deleted.';
			$error = 'success';
		} else {
			$_SESSION['msg'] = 'Error deleting entry.';
			$error = 'danger';
		}
	
		$url= ADMIN_URL."/packages/index.php";
		$general->redirectUrl($url, $error);
		exit;
	
	}
	/*********************************************************************************************************/	
	
?>
