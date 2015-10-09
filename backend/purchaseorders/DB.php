<?php
	include('config.php');
	$dbBean = new DatabaseBean();	
	$general = new General($dbBean);
	$Purchaseorder = new Purchaseorder($dbBean);

	if ($_REQUEST['FLAG']=='ADD_PURCHASE') {
		if (trim($_REQUEST['product'])=="") {
			$_SESSION['msg']='Please select product';
			$num='danger';
			$url= ADMIN_URL."/purchaseorders/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if (trim($_REQUEST['productqty'])=="") {
			$_SESSION['msg']='Please enter product quantity';
			$num='danger';
			$url= ADMIN_URL."/purchaseorders/add.php";
			$general->redirectUrl($url, $num);
			exit;
		} else {
			$pattern = '/^[0-9]+$/';
			if (preg_match($pattern, trim($_REQUEST['productqty'])) == '0') {
				$_SESSION['msg']='Please enter valid product quantity';
				$num='danger';
				$url= ADMIN_URL."/purchaseorders/add.php";
				$general->redirectUrl($url, $num);
				exit;
			}		
		}
		
		if (trim($_REQUEST['name'])=="") {
			$_SESSION['msg']='Please enter seller / purchaser name';
			$num='danger';
			$url= ADMIN_URL."/purchaseorders/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if (trim($_REQUEST['emailaddress'])=="") {
			$_SESSION['msg']='Please enter seller / purchaser email address';
			$num='danger';
			$url= ADMIN_URL."/purchaseorders/add.php";
			$general->redirectUrl($url, $num);
			exit;
		} else {
			if (!filter_var(trim($_REQUEST['emailaddress']), FILTER_VALIDATE_EMAIL)) {
				$_SESSION['msg']='Please enter valid seller / purchaser email address';
				$num='danger';
				$url= ADMIN_URL."/purchaseorders/add.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
		
		if (trim($_REQUEST['contactno'])=="") {
			$_SESSION['msg']='Please enter seller / purchaser contact no';
			$num='danger';
			$url= ADMIN_URL."/purchaseorders/add.php";
			$general->redirectUrl($url, $num);
			exit;
		} else {
			$pattern = '/^[0-9]+$/';
			if (preg_match($pattern, trim($_REQUEST['contactno'])) == '0') {
				$_SESSION['msg']='Please enter valid seller / purchaser contact no';
				$num='danger';
				$url= ADMIN_URL."/purchaseorders/add.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
				
		if (trim($_REQUEST['voucherdate'])=="") {
			$_SESSION['msg']='Please select Voucher date';
			$num='danger';
			$url= ADMIN_URL."/purchaseorders/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		$fieldvalues = array('voucherno' => $_REQUEST['voucherno'], 'productid' => $_REQUEST['product'], 'productquantity'=> $_REQUEST['productqty'], "name" => $_REQUEST['name'], "emailaddress" => $_REQUEST['emailaddress'], "contactno" => $_REQUEST['contactno'],"voucherdate" => $_REQUEST['voucherdate'],'vouchertype' => $_REQUEST['vouchertype'],"remark" => $_REQUEST['remark'], "date_added" => date('Y-m-d H:i:s'));
						
		$updated = $Purchaseorder->addPurchaseorder($fieldvalues);
		
		if ($updated) {
			$rows 			= $Purchaseorder->getProductById($_REQUEST['product']);
			$curr_stock 	= $rows->current_stock;
			$new_stock		= $curr_stock + $_REQUEST['productqty'];
						
			$fieldvalues1 = array('current_stock' => $new_stock);
			
			$cond = array('id'=> $_REQUEST['product']);
			
			$Purchaseorder->updateProduct($fieldvalues1,$cond);		
		}
		
		if ($updated) {			
			$general->addLogAction($_SESSION['adm_user_id'],'Added', $updated, 'Purchase orders', $_SESSION['adm_status']);
			$error  = 'success';
			$_SESSION['msg'] = 'Record added successfully.';
		} else {
			$error  ='danger';
			$_SESSION['msg']='Error adding record.';
		}
				
		$url= ADMIN_URL."/purchaseorders/index.php";
		$general->redirectUrl($url,$error);
		exit;
	}	
	
	/*********************************************************************************************************/
	
	if ($_REQUEST['FLAG']=='EDIT_PURCHASE') {		
		if (trim($_REQUEST['name'])=="") {
			$_SESSION['msg']='Please enter seller / purchaser name';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/purchaseorders/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if (trim($_REQUEST['emailaddress'])=="") {
			$_SESSION['msg']='Please enter seller / purchaser email address';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/purchaseorders/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		} else {
			if (!filter_var(trim($_REQUEST['emailaddress']), FILTER_VALIDATE_EMAIL)) {
				$_SESSION['msg']='Please enter valid seller / purchaser email address';
				$num='danger';
				$num.='&id='.$_REQUEST['id'];
				$url= ADMIN_URL."/purchaseorders/edit.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
		
		if (trim($_REQUEST['contactno'])=="") {
			$_SESSION['msg']='Please enter seller / purchaser contact no';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/purchaseorders/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		} else {
			$pattern = '/^[0-9]+$/';
			if (preg_match($pattern, trim($_REQUEST['contactno'])) == '0') {
				$_SESSION['msg']='Please enter valid seller / purchaser contact no';
				$num='danger';
				$num.='&id='.$_REQUEST['id'];
				$url= ADMIN_URL."/purchaseorders/edit.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
		
		
		$fieldvalues = array("name" => $_REQUEST['name'], "emailaddress" => $_REQUEST['emailaddress'], "contactno" => $_REQUEST['contactno'],"remark" => $_REQUEST['remark']);
		
		$cond		= array("id" => $_REQUEST['id']);
		
		$updated =$Purchaseorder->updatePurchaseorder($fieldvalues, $cond);
				
		if ($updated) {
				$general->addLogAction($_SESSION['adm_user_id'], 'Edited', $_REQUEST['id'], 'Purchase order', $_SESSION['adm_status']);
				$error = 'success';
				$_SESSION['msg'] = 'Record updated successfully.';
		} else {
				$error = 'danger';
				$_SESSION['msg'] = 'Error updating record.';
		}
		
		$url= ADMIN_URL."/purchaseorders/index.php";
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
		

		$url = ADMIN_URL."/purchaseorders/index.php";
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
	
		$url= ADMIN_URL."/purchaseorders/index.php";
		$general->redirectUrl($url, $error);
		exit;
	
	}
	/*********************************************************************************************************/	
	
?>
