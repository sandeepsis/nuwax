<?php
	include('config.php');
	$dbBean = new DatabaseBean();	
	$general = new General($dbBean);
	$Service = new Service($dbBean);

	if($_REQUEST['FLAG']=='ADD_SERVICE')
	{			
		if(trim($_REQUEST['servicecat'])=="")
		{
			$_SESSION['msg']='Please select service category.';
			$num='danger';
			$url= ADMIN_URL."/services/add.php";
			$general->redirectUrl($url, $num);
		    exit;
		}
		
		if(trim($_REQUEST['servicename'])=="")
		{
			$_SESSION['msg']='Please enter service name.';
			$num='danger';
			$url= ADMIN_URL."/services/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if(trim($_REQUEST['price'])=="")
		{
			$_SESSION['msg']='Please enter price.';
			$num='danger';
			$url= ADMIN_URL."/services/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		else
		{
			$pattern = '/^[0-9]+(?:\.[0-9]{0,2})?$/';
			if (preg_match($pattern, trim($_REQUEST['price'])) == '0') {
				$_SESSION['msg']='Please enter valid price.';
				$num='danger';
				$url= ADMIN_URL."/services/add.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
				
		if(trim($_REQUEST['servicetime'])=="")
		{
			$_SESSION['msg']='Please enter service time';
			$num='danger';
			$url= ADMIN_URL."/services/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		else
		{
			$pattern = '/^[0-9]+$/';
			if (preg_match($pattern, trim($_REQUEST['servicetime'])) == '0') {
				$_SESSION['msg']='Please enter valid service time.';
				$num='danger';
				$url= ADMIN_URL."/services/add.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
				
		if(trim($_REQUEST['description'])=="")
		{
			$_SESSION['msg']='Please enter description';
			$num='danger';
			$url= ADMIN_URL."/services/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if(trim($_REQUEST['taxname'])=="")
		{
			$_SESSION['msg']='Please enter tax name';
			$num='danger';
			$url= ADMIN_URL."/services/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if(trim($_REQUEST['taxper'])=="")
		{
			$_SESSION['msg']='Please enter tax (%)';
			$num='danger';
			$url= ADMIN_URL."/services/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		else
		{
			$pattern = '/^[0-9]+(?:\.[0-9]{0,2})?$/';
			if (preg_match($pattern, trim($_REQUEST['taxper'])) == '0') {
				$_SESSION['msg']='Please enter valid tax (%).';
				$num='danger';
				$url= ADMIN_URL."/services/add.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
		
		
		$fieldvalues = array('servicecatid' => $_REQUEST['servicecat'],'servicename' => $_REQUEST['servicename'], 'price' => $_REQUEST['price'], 'servicetime'=> $_REQUEST['servicetime'], "description" => $_REQUEST['description'], "taxname" => $_REQUEST['taxname'],"taxapplicable" => $_REQUEST['taxper'], "tax_underpackage" => $_REQUEST['taxunderpackage'],"is_deleted" => '0', "date_added" => date('Y-m-d H:i:s'));
						
	    $updated = $Service->addService($fieldvalues);
			
	    if (count($_REQUEST['stafflevel']) > 0) {
			for($i=0;$i<=count($_REQUEST['stafflevel']);$i++)
			{
				if ($_REQUEST['stafflevel'][$i] !="" && $_REQUEST['levelprice'][$i] != "") {
					$staff_level= $_REQUEST['stafflevel'][$i];
					$level_price = $_REQUEST['levelprice'][$i];
						
					$fieldvalues1	= array('serviceid'=>$updated,'stafflevelid'=>$staff_level,'price'=>$level_price);
					$Service->addStafflevelprice($fieldvalues1); 
				}
			}
	    }
		
		if ($updated){			
			$general->addLogAction($_SESSION['adm_user_id'],'Added', $updated, 'Service Management', $_SESSION['adm_status']);
			$error  = 'success';
			$_SESSION['msg'] = 'Record added successfully.';
		}else{
			$error  ='danger';
			$_SESSION['msg']='Error adding record.';
		}
				
		$url= ADMIN_URL."/services/index.php";
		$general->redirectUrl($url,$error);
		exit;
	}	
	
	/*********************************************************************************************************/
	
	if($_REQUEST['FLAG']=='EDIT_SERVICE')
	{		
	if(trim($_REQUEST['servicecat'])=="")
		{
			$_SESSION['msg']='Please select service category.';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/services/edit.php";
			$general->redirectUrl($url, $num);
		    exit;
		}
		
		if(trim($_REQUEST['servicename'])=="")
		{
			$_SESSION['msg']='Please enter service name.';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/services/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if(trim($_REQUEST['price'])=="")
		{
			$_SESSION['msg']='Please enter price.';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/services/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		else
		{
			$pattern = '/^[0-9]+(?:\.[0-9]{0,2})?$/';
			if (preg_match($pattern, trim($_REQUEST['price'])) == '0') {
				$_SESSION['msg']='Please enter valid price.';
				$num='danger';
				$num.='&id='.$_REQUEST['id'];
				$url= ADMIN_URL."/services/edit.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
				
		if(trim($_REQUEST['servicetime'])=="")
		{
			$_SESSION['msg']='Please enter service time';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/services/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		else
		{
			$pattern = '/^[0-9]+$/';
			if (preg_match($pattern, trim($_REQUEST['servicetime'])) == '0') {
				$_SESSION['msg']='Please enter valid service time.';
				$num='danger';
				$num.='&id='.$_REQUEST['id'];
				$url= ADMIN_URL."/services/edit.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
				
		if(trim($_REQUEST['description'])=="")
		{
			$_SESSION['msg']='Please enter description';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/services/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if(trim($_REQUEST['taxname'])=="")
		{
			$_SESSION['msg']='Please enter tax name';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/services/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if(trim($_REQUEST['taxper'])=="")
		{
			$_SESSION['msg']='Please enter tax (%)';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/services/edit.php";
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
				$url= ADMIN_URL."/services/edit.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}		
				
		$cond		= array("id" => $_REQUEST['id']);

		$fieldvalues = array('servicecatid' => $_REQUEST['servicecat'],'servicename' => $_REQUEST['servicename'], 'price' => $_REQUEST['price'], 'servicetime'=> $_REQUEST['servicetime'], "description" => $_REQUEST['description'], "taxname" => $_REQUEST['taxname'],"taxapplicable" => $_REQUEST['taxper'], "tax_underpackage" => $_REQUEST['taxunderpackage']);
		
		$updated =$Service->updateService($fieldvalues, $cond);

		if (count($_REQUEST['stafflevel']) > 0) {
			if ($_REQUEST['stafflevel'][0] != "") {
				for($i=0;$i<=count($_REQUEST['stafflevel']);$i++)
				{
					if ($_REQUEST['stafflevel'][$i] !="" && $_REQUEST['levelprice'][$i] != "") {
						$staff_level= $_REQUEST['stafflevel'][$i];
						$level_price = $_REQUEST['levelprice'][$i];
			
						$sid = $_REQUEST['stafflevelpriceid'][$i];
						
						if ($sid != "") {
							$fieldvalues1	= array('stafflevelid'=>$staff_level,'price'=>$level_price);
							$cond1	  = array('id' => $sid);
												
							$Service->updateStafflevelprice($fieldvalues1,$cond1);
						} else {
							
							$fieldvalues1	= array('serviceid'=>$_REQUEST['id'],'stafflevelid'=>$staff_level,'price'=>$level_price);
							$Service->addStafflevelprice($fieldvalues1);						
						}
					}
				}
			}
		}
		
		$deletehdnarr = explode(",", $_REQUEST['hdndelete']);
		
		if (count($deletehdnarr) > 0) {
			for($t=0;$t<=count($deletehdnarr);$t++)
			{				
				$cond2= $deletehdnarr[$t];
				
				$Service->deleteStafflevelprice($cond2);	
			}
		}
	
		if ($updated) 
		{
				$general->addLogAction($_SESSION['adm_user_id'], 'Edited', $_REQUEST['id'], 'Service Management', $_SESSION['adm_status']);
				$error = 'success';
				$_SESSION['msg'] = 'Record updated successfully.';
		}else{
				$error = 'danger';
				$_SESSION['msg'] = 'Error updating record.';
		}
		
		$url= ADMIN_URL."/services/index.php";
		$general->redirectUrl($url,$error);
		exit;
	}		
	
	/*************************************************************************************/	
	if(isset($_REQUEST['FLAG']) && $_REQUEST['FLAG']=='DELETE')
	{		
		$id=$_REQUEST['id'];
		
		$cond		 = array("id" => $id);
		$fieldvalues = array('is_deleted' => '1');
		
		$deleted = $Service->deleteService($fieldvalues,$cond);
		
		if($deleted)
		{		
				$general->addLogAction($_SESSION['adm_user_id'], 'Deleted', (int)$_REQUEST['id'], 'Service Management', $_SESSION['adm_status']);
				$error = 'success';
				$_SESSION['msg'] = 'Record deleted successfully.';
		}
		else
		{
				$error = 'danger';
				$_SESSION['msg'] = 'Error deleting record.';
		}
		

		$url = ADMIN_URL."/services/index.php";
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
			
			$val = $Service->deleteService($fieldvalues,$cond);
		
			$general->addLogAction($_SESSION['adm_user_id'], 'Deleted', (int)$id,'Service Management', $_SESSION['adm_status']);
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
	
		$url= ADMIN_URL."/services/index.php";
		$general->redirectUrl($url, $error);
		exit;
	
	}
	/*********************************************************************************************************/	
	
?>
