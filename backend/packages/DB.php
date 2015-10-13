<?php
	include('config.php');
	$dbBean = new DatabaseBean();	
	$general = new General($dbBean);
	$Package = new Package($dbBean);

	if ($_REQUEST['FLAG']=='ADD_PACKAGE') {			
		if (trim($_REQUEST['packagename'])=="") {
			$_SESSION['msg']='Please enter package name';
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
				
		if (trim($_REQUEST['creditprovided'])=="" && trim($_REQUEST['servicediscount'])=="" && trim($_REQUEST['productdiscount'])=="") {
			$_SESSION['msg']='Please Enter atleast one out of credit provided, service discount or product discount';
			$num='danger';
			$url= ADMIN_URL."/packages/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}else{			
			$pattern = '/^[0-9]+(?:\.[0-9]{0,2})?$/';
			
			if ($_REQUEST['creditprovided']!="") {
				$credit = $_REQUEST['creditprovided'];
				$msg = "credit provided";
			} else if ($_REQUEST['servicediscount']!="") {
				$credit = $_REQUEST['servicediscount'];
				$msg = "service discount";
			} else if ($_REQUEST['productdiscount']!="") {
				$credit = $_REQUEST['productdiscount'];
				$msg = "product discount";
			}
						
			if (preg_match($pattern, trim($credit)) == '0') {
				$_SESSION['msg']='Please enter valid '.$msg;
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
			$_SESSION['msg']='Please enter package name';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/packages/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if (trim($_REQUEST['cost'])=="") {
			$_SESSION['msg']='Please enter cost';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/packages/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		} else {
			$pattern = '/^[0-9]+(?:\.[0-9]{0,2})?$/';
			if (preg_match($pattern, trim($_REQUEST['cost'])) == '0') {
				$_SESSION['msg']='Please enter valid cost';
				$num='danger';
				$num.='&id='.$_REQUEST['id'];
				$url= ADMIN_URL."/packages/edit.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
		
		if (trim($_REQUEST['creditprovided'])=="" && trim($_REQUEST['servicediscount'])=="" && trim($_REQUEST['productdiscount'])=="") {
			$_SESSION['msg']='Please Enter atleast one out of credit provided, service discount or product discount';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/packages/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}else{			
			$pattern = '/^[0-9]+(?:\.[0-9]{0,2})?$/';
			
			if ($_REQUEST['creditprovided']!="") {
				$credit = $_REQUEST['creditprovided'];
				$msg = "credit provided";
			} else if ($_REQUEST['servicediscount']!="") {
				$credit = $_REQUEST['servicediscount'];
				$msg = "service discount";
			} else if ($_REQUEST['productdiscount']!="") {
				$credit = $_REQUEST['productdiscount'];
				$msg = "product discount";
			}
						
			if (preg_match($pattern, trim($credit)) == '0') {
				$_SESSION['msg']='Please enter valid '.$msg;
				$num='danger';
				$num.='&id='.$_REQUEST['id'];
				$url= ADMIN_URL."/packages/edit.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
		
		$cnt = count($_REQUEST['serviceapplicable']);
		
		if ($cnt==0) {
			$_SESSION['msg']='Please select service for package';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/packages/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}
				
		if (trim($_REQUEST['taxname'])=="")	{
			$_SESSION['msg']='Please enter tax name';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/packages/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if (trim($_REQUEST['taxper'])=="") {
			$_SESSION['msg']='Please enter tax (%)';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/packages/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		else
		{
			$pattern = '/^[0-9]+(?:\.[0-9]{0,2})?$/';
			if (preg_match($pattern, trim($_REQUEST['taxper'])) == '0') {
				$_SESSION['msg']='Please enter valid tax (%).';
				$num='danger';
				$num.='&id='.$_REQUEST['id'];
				$url= ADMIN_URL."/packages/edit.php";
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
	
	if ($_REQUEST['FLAG']=='ALLOCATE_PACKAGE') {
		
		if (trim($_REQUEST['customer'])=="") {
			$_SESSION['msg']='Please select customer';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/packages/packageallocate.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if ($_REQUEST['paymenttype'] !="0") {			
			if (trim($_REQUEST['bank'])=="") {
				$_SESSION['msg']='Please enter bank name';
				$num='danger';
				$num.='&id='.$_REQUEST['id'];
				$url= ADMIN_URL."/packages/packageallocate.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		
			if (trim($_REQUEST['instrumentname'])=="")	{
				$_SESSION['msg']='Please enter instrument name';
				$num='danger';
				$num.='&id='.$_REQUEST['id'];
				$url= ADMIN_URL."/packages/packageallocate.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		
			if (trim($_REQUEST['instrumentno'])=="")	{
				$_SESSION['msg']='Please enter instrument no';
				$num='danger';
				$num.='&id='.$_REQUEST['id'];
				$url= ADMIN_URL."/packages/packageallocate.php";
				$general->redirectUrl($url, $num);
				exit;
			} else {
				$pattern = '/^[0-9]+$/';
				if (preg_match($pattern, trim($_REQUEST['instrumentno'])) == '0') {
					$_SESSION['msg']='Please enter valid instrument no';
					$num='danger';
					$num.='&id='.$_REQUEST['id'];
					$url= ADMIN_URL."/packages/packageallocate.php";
					$general->redirectUrl($url, $num);
					exit;
				}
			}
					
			if (trim($_REQUEST['chequeamount'])=="") {
				$_SESSION['msg']='Please enter cheque amount';
				$num='danger';
				$num.='&id='.$_REQUEST['id'];
				$url= ADMIN_URL."/packages/packageallocate.php";
				$general->redirectUrl($url, $num);
				exit;
			}
			
			if (trim($_REQUEST['chequedate'])=="") {
				$_SESSION['msg']='Please enter cheque date';
				$num='danger';
				$num.='&id='.$_REQUEST['id'];
				$url= ADMIN_URL."/packages/packageallocate.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
		
		if (trim($_REQUEST['allocationdate'])=="") {
			$_SESSION['msg']='Please enter allocation date';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/packages/packageallocate.php";
			$general->redirectUrl($url, $num);
			exit;
		}
	
		if ($_REQUEST['paymenttype'] == 0) {
			$fieldvalues = array('customerid' => $_REQUEST['customer'],'packageid' => $_REQUEST['id'], 'payment_type' => $_REQUEST['paymenttype'], 'amount'=> $_REQUEST['amount'], "allocationdate" => $_REQUEST['allocationdate'],"remark" => $_REQUEST['remark'], "date_added" => date('Y-m-d H:i:s'));
		} else{
			$fieldvalues = array('customerid' => $_REQUEST['customer'],'packageid' => $_REQUEST['id'], 'payment_type' => $_REQUEST['paymenttype'], 'amount'=> $_REQUEST['amount'], "bank" => $_REQUEST['bank'], "instrumentname" => $_REQUEST['instrumentname'], "instrumentno" => $_REQUEST['instrumentno'],"chequeamount" => $_REQUEST['chequeamount'],"chequedate" => $_REQUEST['chequedate'],"allocationdate" => $_REQUEST['allocationdate'],"remark" => $_REQUEST['remark'], "date_added" => date('Y-m-d H:i:s'));
		}
				
		$updated = $Package->packageAllocation($fieldvalues);
	
		if ($updated) {
			if ($_REQUEST['creditprovided'] != "") {
								
				//$r = $Package->getcreditByPackageid($_REQUEST['id']);
				
				//if (count($r) == 0) {
					
					$field_values = array('customerid' => $_REQUEST['customer'],'packageid' => $_REQUEST['id'], 'credit' => $_REQUEST['creditprovided'],'credittype' => '0','date_added' => date('Y-m-d H:i:s'));
				
					$add = $Package->addcreditmanagement($field_values);
						
					if ($add) {
						$data 		= $Package->getCutomerById($_REQUEST['customer']);
						$usercredit = $data->credit;
				
						$newcredit	= $usercredit + $_REQUEST['creditprovided'];
				
						$fieldvalues1 = array('credit' => $newcredit);
						$cond = array('id'=> $_REQUEST['customer']);
							
						$Package->updateCustomer($fieldvalues1,$cond);
					}
				//}
			}
		}
		
		
		if ($updated) {
			$general->addLogAction($_SESSION['adm_user_id'],'Added', $updated, 'Package Allocation', $_SESSION['adm_status']);
			$error  = 'success';
			$_SESSION['msg'] = 'Package allocated successfully.';
		} else {
			$error  ='danger';
			$_SESSION['msg']='Error allocating package.';
		}
	
		$url= ADMIN_URL."/packages/index.php";
		$general->redirectUrl($url,$error);
		exit;
	}
	
	/*********************************************************************************************************/
?>
