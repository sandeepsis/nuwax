<?php
	include('config.php');
	$dbBean = new DatabaseBean();	
	$general = new General($dbBean);
	$Customer = new Customer($dbBean);

	if($_REQUEST['FLAG']=='ADD_SERVICECAT')
	{			
		if(trim($_REQUEST['name'])=="")
		{
			$_SESSION['msg']='Please enter category name';
			$num='danger';
			$url= ADMIN_URL."/servicecategories/add.php";
			$general->redirectUrl($url, $num);
		    exit;
		}
		
		if(trim($_REQUEST['emailid'])=="")
		{
			$_SESSION['msg']='Please enter email.';
			$num='danger';
			$url= ADMIN_URL."/customers/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		else {
			if (!filter_var(trim($_REQUEST['emailid']), FILTER_VALIDATE_EMAIL)) {
				$_SESSION['msg']='Please enter valid email.';
				$num='danger';
				$url= ADMIN_URL."/customers/add.php";
				$general->redirectUrl($url, $num);
				exit;
			}
			else {
				$rowdata = $Customer->getCustomerByEmail($_REQUEST['emailid'],$id='');
				
				if($rowdata > 0)
				{
					$_SESSION['msg']='Email address already exist.';
					$num='danger';
					$url= ADMIN_URL."/customers/add.php";
					$general->redirectUrl($url, $num);
					exit;
				}
			}
		}
				
		if(trim($_REQUEST['contactno'])=="")
		{
			$_SESSION['msg']='Please enter contact no.';
			$num='danger';
			$url= ADMIN_URL."/customers/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
				
		if(trim($_REQUEST['address'])=="")
		{
			$_SESSION['msg']='Please enter address';
			$num='danger';
			$url= ADMIN_URL."/customers/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		$fieldvalues = array('name' => $_REQUEST['name'], 'email' => $_REQUEST['emailid'], 'contactno'=> $_REQUEST['contactno'], "address" => $_REQUEST['address'], "studentcardno" => $_REQUEST['studentcardno'],"status" => $_REQUEST['status'], "remark" => $_REQUEST['remark'], "credit" => $_REQUEST['credit'],"is_deleted" =>0, "registerdate" => date('Y-m-d H:i:s'));
						
		$updated = $Customer->addCustomer($fieldvalues);
		
		if ($updated){			
			$general->addLogAction($_SESSION['adm_user_id'],'Added', $updated, 'Customer Management', $_SESSION['adm_status']);
			$error  = 'success';
			$_SESSION['msg'] = 'Record added successfully.';
		}else{
			$error  ='danger';
			$_SESSION['msg']='Error adding record.';
		}
				
		$url= ADMIN_URL."/customers/index.php";
		$general->redirectUrl($url,$error);
		exit;
	}	
	
	/*********************************************************************************************************/
	
	if($_REQUEST['FLAG']=='EDIT_CUSTOMER')
	{		
		if(trim($_REQUEST['name'])=="")
		{
			$_SESSION['msg']='Please enter name.';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/customers/edit.php";
			$general->redirectUrl($url, $num);
		    exit;
		}
		
		if(trim($_REQUEST['emailid'])=="")
		{
			$_SESSION['msg']='Please enter email.';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/customers/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		else {
			if (!filter_var(trim($_REQUEST['emailid']), FILTER_VALIDATE_EMAIL)) {
				$_SESSION['msg']='Please enter valid email.';
				$num='danger';
				$num.='&id='.$_REQUEST['id'];
				$url= ADMIN_URL."/customers/edit.php";
				$general->redirectUrl($url, $num);
				exit;
			}
			else {
				$rowdata = $Customer->getCustomerByEmail($_REQUEST['emailid'],$_REQUEST['id']);
				
				if($rowdata > 0)
				{
					$_SESSION['msg']='Email address already exist.';
					$num='danger';
					$num.='&id='.$_REQUEST['id'];
					$url= ADMIN_URL."/customers/edit.php";
					$general->redirectUrl($url, $num);
					exit;
				}
			}
		}
				
		if(trim($_REQUEST['contactno'])=="")
		{
			$_SESSION['msg']='Please enter contact no.';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/customers/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}
				
		if(trim($_REQUEST['address'])=="")
		{
			$_SESSION['msg']='Please enter address';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/customers/edit`.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		$cond		= array("id" => $_REQUEST['id']);

		$fieldvalues = array('name' => $_REQUEST['name'], 'email' => $_REQUEST['emailid'], 'contactno'=> $_REQUEST['contactno'], "address" => $_REQUEST['address'], "studentcardno" => $_REQUEST['studentcardno'],"status" => $_REQUEST['status'], "remark" => $_REQUEST['remark'], "credit" => $_REQUEST['credit']);
		
		$updated =$Customer->updateCustomer($fieldvalues, $cond);

		if ($updated) 
		{
				$general->addLogAction($_SESSION['adm_user_id'], 'Edited', $_REQUEST['id'], 'Customer Management', $_SESSION['adm_status']);
				$error = 'success';
				$_SESSION['msg'] = 'Record updated successfully.';
		}else{
				$error = 'danger';
				$_SESSION['msg'] = 'Error updating record.';
		}
		
		$url= ADMIN_URL."/customers/index.php";
		$general->redirectUrl($url,$error);
		exit;
	}		
	
	
	
	/*************************************************************************************/	
	if(isset($_REQUEST['FLAG']) && $_REQUEST['FLAG']=='DELETE')
	{		
		$id=$_REQUEST['id'];
		
		$cond		 = array("id" => $id);
		$fieldvalues = array('is_deleted' => '1');
		
		$deleted = $Customer->deleteCustomer($fieldvalues,$cond);
		
		if($deleted)
		{		
				$general->addLogAction($_SESSION['adm_user_id'], 'Deleted', (int)$_REQUEST['id'], 'Customer Management', $_SESSION['adm_status']);
				$error = 'success';
				$_SESSION['msg'] = 'Record deleted successfully.';
		}
		else
		{
				$error = 'danger';
				$_SESSION['msg'] = 'Error deleting record.';
		}
		

		$url = ADMIN_URL."/customers/index.php";
		$general->redirectUrl($url, $error);
		exit;
	}
	/*************************************************************************************/

	if(isset($_REQUEST['FLAG']) && $_REQUEST['FLAG'] == 'DELSELECT')
	{
		
		$val=0;
		$delete = $_POST['delete'];
		foreach ($delete as $id) 
		{
			$cond		= array("id" => $id);
			$fieldvalues = array('is_deleted' => '1');
			
			$val = $Customer->deleteCustomer($fieldvalues,$cond);
		
			$general->addLogAction($_SESSION['adm_user_id'], 'Deleted', (int)$id,'Customer Management', $_SESSION['adm_status']);
		}
		
		if($val)
		{
			$_SESSION['msg'] = 'Selected Entries have been deleted.';
			$error = 'success';
		}
		else
		{
			$_SESSION['msg'] = 'Error deleting entry.';
			$error = 'danger';
		}
	
		$url= ADMIN_URL."/customers/index.php";
		$general->redirectUrl($url, $error);
		exit;
	
	}
	/*********************************************************************************************************/	
	
	if($_REQUEST['FLAG']=='CHANGEPWD')
	{
	
		$cond		= array("id" => $_REQUEST['id']);
		$fieldvalues = array('password'=>md5($_REQUEST['password']));
		$updated = $dbBean->UpdateRows("customer", $fieldvalues, $cond);
	
	
		if($updated)
		{
			$general->addLogAction($_SESSION['adm_user_id'],'Changed',$_REQUEST['id'],'Customer Password',$_SESSION['adm_status']);
			$error  ='success';
			$_SESSION['msg']='Password successfully changed.';
		}else{
			$error  ='danger';
			$_SESSION['msg']='Error changing password.';
		}
	
		$url= ADMIN_URL."/customers/index.php";
		$general->redirectUrl($url,$error);
		exit;
	}	
	/*********************************************************************************************************/
?>
