<?php
	include('config.php');
	$dbBean = new DatabaseBean();	
	$general = new General($dbBean);
	$Stock = new Stock($dbBean);

	if ($_REQUEST['FLAG']=='ADD_STOCK') {			
		if (trim($_REQUEST['category'])=="") {
			$_SESSION['msg']='Please select category';
			$num='danger';
			$url= ADMIN_URL."/stock/add.php";
			$general->redirectUrl($url, $num);
		    exit;
		}
		
		if (trim($_REQUEST['productname'])=="") {
			$_SESSION['msg']='Please enter product name';
			$num='danger';
			$url= ADMIN_URL."/stock/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if (trim($_REQUEST['skucode'])=="") {
			$_SESSION['msg']='Please enter skucode';
			$num='danger';
			$url= ADMIN_URL."/stock/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if (trim($_REQUEST['barcode'])=="") {
			$_SESSION['msg']='Please enter barcode';
			$num='danger';
			$url= ADMIN_URL."/stock/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if (trim($_REQUEST['model'])=="") {
			$_SESSION['msg']='Please enter product model';
			$num='danger';
			$url= ADMIN_URL."/stock/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if (trim($_REQUEST['unit'])=="") {
			$_SESSION['msg']='Please enter product unit';
			$num='danger';
			$url= ADMIN_URL."/stock/add.php";
			$general->redirectUrl($url, $num);
			exit;
		} else {
			$pattern = '/^[0-9]+$/';
			if (preg_match($pattern, trim($_REQUEST['unit'])) == '0') {
				$_SESSION['msg']='Please enter valid product unit';
				$num='danger';
				$url= ADMIN_URL."/stock/add.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
				
		if (trim($_REQUEST['volume'])=="") {
			$_SESSION['msg']='Please enter product volume';
			$num='danger';
			$url= ADMIN_URL."/stock/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}else{
			$pattern = '/^[0-9]+(?:\.[0-9]{0,2})?$/';
			if (preg_match($pattern, trim($_REQUEST['volume'])) == '0') {
				$_SESSION['msg']='Please enter valid product volume';
				$num='danger';
				$url= ADMIN_URL."/stock/add.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
				
		if (trim($_REQUEST['costprice'])=="")	{
			$_SESSION['msg']='Please enter cost price';
			$num='danger';
			$url= ADMIN_URL."/stock/add.php";
			$general->redirectUrl($url, $num);
			exit;
		} else {
			$pattern = '/^[0-9]+(?:\.[0-9]{0,2})?$/';
			if (preg_match($pattern, trim($_REQUEST['costprice'])) == '0') {
				$_SESSION['msg']='Please enter valid cost price';
				$num='danger';
				$url= ADMIN_URL."/stock/add.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
		
		if (trim($_REQUEST['sellingprice'])=="")	{
			$_SESSION['msg']='Please enter selling price';
			$num='danger';
			$url= ADMIN_URL."/stock/add.php";
			$general->redirectUrl($url, $num);
			exit;
		} else {
			$pattern = '/^[0-9]+(?:\.[0-9]{0,2})?$/';
			if (preg_match($pattern, trim($_REQUEST['sellingprice'])) == '0') {
				$_SESSION['msg']='Please enter valid selling';
				$num='danger';
				$url= ADMIN_URL."/stock/add.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
		
		$fieldvalues = array('status' => $_REQUEST['status'],'categoryid' => $_REQUEST['category'], 'productname' => $_REQUEST['productname'], 'skucode'=> $_REQUEST['skucode'], "barcode" => $_REQUEST['barcode'], "model" => $_REQUEST['model'], "unit" => $_REQUEST['unit'],"volume" => $_REQUEST['volume'], "costprice" => $_REQUEST['costprice'],"sellingprice" => $_REQUEST['sellingprice'],"description" => $_REQUEST['description'],"is_deleted" => '0', "date_added" => date('Y-m-d H:i:s'));
						
		$updated = $Stock->addStock($fieldvalues);
		
		if ($updated) {			
			$general->addLogAction($_SESSION['adm_user_id'],'Added', $updated, 'Stock Management', $_SESSION['adm_status']);
			$error  = 'success';
			$_SESSION['msg'] = 'Record added successfully.';
		} else {
			$error  ='danger';
			$_SESSION['msg']='Error adding record.';
		}
				
		$url= ADMIN_URL."/stock/index.php";
		$general->redirectUrl($url,$error);
		exit;
	}	
	
	/*********************************************************************************************************/
	
	if ($_REQUEST['FLAG']=='EDIT_STOCK') {		
		if (trim($_REQUEST['category'])=="") {
			$_SESSION['msg']='Please select category';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/stock/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if (trim($_REQUEST['productname'])=="") {
			$_SESSION['msg']='Please enter product name';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/stock/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if (trim($_REQUEST['skucode'])=="") {
			$_SESSION['msg']='Please enter skucode';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/stock/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if (trim($_REQUEST['barcode'])=="") {
			$_SESSION['msg']='Please enter barcode';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/stock/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if (trim($_REQUEST['model'])=="") {
			$_SESSION['msg']='Please enter product model';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/stock/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if (trim($_REQUEST['unit'])=="") {
			$_SESSION['msg']='Please enter product unit';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/stock/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		} else {
			$pattern = '/^[0-9]+$/';
			if (preg_match($pattern, trim($_REQUEST['unit'])) == '0') {
				$_SESSION['msg']='Please enter valid product unit';
				$num='danger';
				$num.='&id='.$_REQUEST['id'];
				$url= ADMIN_URL."/stock/edit.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
		
		if (trim($_REQUEST['volume'])=="") {
			$_SESSION['msg']='Please enter product volume';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/stock/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}else{
			$pattern = '/^[0-9]+(?:\.[0-9]{0,2})?$/';
			if (preg_match($pattern, trim($_REQUEST['volume'])) == '0') {
				$_SESSION['msg']='Please enter valid product volume';
				$num='danger';
				$num.='&id='.$_REQUEST['id'];
				$url= ADMIN_URL."/stock/edit.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
		
		if (trim($_REQUEST['costprice'])=="")	{
			$_SESSION['msg']='Please enter cost price';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/stock/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		} else {
			$pattern = '/^[0-9]+(?:\.[0-9]{0,2})?$/';
			if (preg_match($pattern, trim($_REQUEST['costprice'])) == '0') {
				$_SESSION['msg']='Please enter valid cost price';
				$num='danger';
				$num.='&id='.$_REQUEST['id'];
				$url= ADMIN_URL."/stock/edit.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
		
		if (trim($_REQUEST['sellingprice'])=="")	{
			$_SESSION['msg']='Please enter selling price';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/stock/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		} else {
			$pattern = '/^[0-9]+(?:\.[0-9]{0,2})?$/';
			if (preg_match($pattern, trim($_REQUEST['sellingprice'])) == '0') {
				$_SESSION['msg']='Please enter valid selling';
				$num='danger';
				$num.='&id='.$_REQUEST['id'];
				$url= ADMIN_URL."/stock/edit.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
		
		$cond		= array("id" => $_REQUEST['id']);

		$fieldvalues = array('status' => $_REQUEST['status'],'categoryid' => $_REQUEST['category'], 'productname' => $_REQUEST['productname'], 'skucode'=> $_REQUEST['skucode'], "barcode" => $_REQUEST['barcode'], "model" => $_REQUEST['model'], "unit" => $_REQUEST['unit'],"volume" => $_REQUEST['volume'], "costprice" => $_REQUEST['costprice'],"sellingprice" => $_REQUEST['sellingprice'],"description" => $_REQUEST['description']);
		
		$updated =$Stock->updateStock($fieldvalues, $cond);

		if ($updated) {
				$general->addLogAction($_SESSION['adm_user_id'], 'Edited', $_REQUEST['id'], 'Stock Management', $_SESSION['adm_status']);
				$error = 'success';
				$_SESSION['msg'] = 'Record updated successfully.';
		} else {
				$error = 'danger';
				$_SESSION['msg'] = 'Error updating record.';
		}
		
		$url= ADMIN_URL."/stock/index.php";
		$general->redirectUrl($url,$error);
		exit;
	}		
	
	/*************************************************************************************/	
	if (isset($_REQUEST['FLAG']) && $_REQUEST['FLAG']=='DELETE') {		
		$id=$_REQUEST['id'];
		
		$cond		 = array("id" => $id);
		$fieldvalues = array('is_deleted' => '1');
		
		$deleted = $Stock->deleteStock($fieldvalues,$cond);
		
		if ($deleted) {		
			$general->addLogAction($_SESSION['adm_user_id'], 'Deleted', (int)$_REQUEST['id'], 'Stock Management', $_SESSION['adm_status']);
			$error = 'success';
			$_SESSION['msg'] = 'Record deleted successfully.';
		} else {
			$error = 'danger';
			$_SESSION['msg'] = 'Error deleting record.';
		}
		

		$url = ADMIN_URL."/stock/index.php";
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
			
			$val = $Stock->deleteStock($fieldvalues,$cond);
		
			$general->addLogAction($_SESSION['adm_user_id'], 'Deleted', (int)$id,'Stock Management', $_SESSION['adm_status']);
		}
		
		if ($val) {
			$_SESSION['msg'] = 'Selected Entries have been deleted.';
			$error = 'success';
		} else {
			$_SESSION['msg'] = 'Error deleting entry.';
			$error = 'danger';
		}
	
		$url= ADMIN_URL."/stock/index.php";
		$general->redirectUrl($url, $error);
		exit;
	
	}
	/*********************************************************************************************************/	
	
?>
