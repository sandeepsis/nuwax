<?php
	include('config.php');
	$dbBean=new DatabaseBean();	
	$general		= new General($dbBean);
	$Menu= new Menu($dbBean);

	if($_REQUEST['FLAG']=='ADD_GROUP')
	{
		if(trim($_REQUEST['name'])=="")
		{
			$_SESSION['msg']='Please enter Group Name.';
			$num='danger';
			$url= ADMIN_URL."/menu_manager/add.php";
			$general->redirectUrl($url,$num);
		    exit;
		}
		else if(trim($_REQUEST['order'])=="")
		{
			$_SESSION['msg']='Please enter order.';
			$num='danger';
			$url= ADMIN_URL."/menu_manager/add.php";
			$general->redirectUrl($url,$num);
		    exit;
		}
		
		
		$fieldvalues = array('name'=>$_REQUEST['name'],'is_menu_group'=>1,'order_index'=>$_REQUEST['order'],'is_dashboard_icon'=>$_REQUEST['dashboard']);
		$updated =$Menu->createMenu($fieldvalues);
		
		if($updated)
		{
				$general->addLogAction($_SESSION['adm_user_id'],'Added',$updated,'Menu Management',$_SESSION['adm_status']);
				$error  ='success';
				$_SESSION['msg']='Record updated successfully.';
		}else{
				$error  ='danger';
				$_SESSION['msg']='Error updating record.';
		}

		$url= ADMIN_URL."/menu_manager/index.php";
		$general->redirectUrl($url,$error);
		exit;
	}	
	
	/*********************************************************************************************************/

	
	if($_REQUEST['FLAG']=='EDIT_GROUP')
	{
		if($_REQUEST['name']=="")
		{
			$_SESSION['msg']='Please enter Group Name.';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/menu_manager/edit.php";
		    $general->redirectUrl($url,$num);
		    exit;
			
		}
		else if($_REQUEST['order']=="")
		{
			$_SESSION['msg']='Please enter order.';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/menu_manager/edit.php";
		    $general->redirectUrl($url,$num);
		    exit;
		}
		
		$cond		= array("id" => $_REQUEST['id']);
		$fieldvalues = array('name'=>$_REQUEST['name'],'order_index'=>$_REQUEST['order'],'is_dashboard_icon'=>$_REQUEST['dashboard']);
		$updated =$Menu->updateMenu($fieldvalues,$cond);

		if ($updated) 
		{
				$general->addLogAction($_SESSION['adm_user_id'],'Edited',$_REQUEST['id'],'Menu Management',$_SESSION['adm_status']);
				$error  ='success';
				$_SESSION['msg']='Record updated successfully.';
		}else{
				$error  ='danger';
				$_SESSION['msg']='Error updating record.';
		}

		$url= ADMIN_URL."/menu_manager/index.php";
		$general->redirectUrl($url,$error);
		exit;
	}		
	
	
	
	/*************************************************************************************/	
	if(isset($_REQUEST['FLAG']) && $_REQUEST['FLAG']=='DELETE')
	{
		
		$id=$_REQUEST['id'];
		$deleted =$Menu->deleteMenu($id);
		
		if($deleted)
		{		
				$general->addLogAction($_SESSION['adm_user_id'],'Deleted',(int)$id,'Menu Management',$_SESSION['adm_status']);
				$error  ='success';
				$_SESSION['msg']='Record deleted successfully.';
		}
		else
		{
				$error  ='danger';
				$_SESSION['msg']='Error deleting record.';
		}
		

		$url= ADMIN_URL."/menu_manager/index.php";
		$general->redirectUrl($url,$error);
		exit;
	}
	/*************************************************************************************/

	if(isset($_REQUEST['FLAG']) && $_REQUEST['FLAG'] == 'DELSELECT')
	{
		
		$val=0;
		$delete = $_POST['delete'];
		foreach ($delete as $id) 
		{
				$val =$Menu->deleteMenu($id);
				$general->addLogAction($_SESSION['adm_user_id'],'Deleted',(int)$id,'Menu Management',$_SESSION['adm_status']);
		}
		
		if($val)
		{
			$_SESSION['msg']='Selected Entries have been deleted.';
			$error='success';
		}
		else
		{
			$_SESSION['msg']='Error deleting entry.';
			$error  ='danger';
		}
	
		$url= ADMIN_URL."/menu_manager/index.php";
		$general->redirectUrl($url,$error);
		exit;
	
	}
	/*********************************************************************************************************/	
	
	if($_REQUEST['FLAG']=='ADD_MENU_OPTION')
	{
		if(trim($_REQUEST['name'])=="")
		{
			$_SESSION['msg']='Please enter Group Name.';
			$error='danger';
			$error.='&parent_id='.$_REQUEST['parent_id'];
			$url= ADMIN_URL."/menu_manager/add_submenu.php";
			$general->redirectUrl($url,$num);
		    exit;
		}
		else if(trim($_REQUEST['page_name'])=="")
		{
			$_SESSION['msg']='Please enter Page name.';
			$error='danger';
			$error.='&parent_id='.$_REQUEST['parent_id'];
			$url= ADMIN_URL."/menu_manager/add_submenu.php";
			$general->redirectUrl($url,$num);
		    exit;
		}

		else if(trim($_REQUEST['order'])=="")
		{
			$_SESSION['msg']='Please enter order.';
			$error='danger';
			$error.='&parent_id='.$_REQUEST['parent_id'];
			$url= ADMIN_URL."/menu_manager/add_submenu.php";
			$general->redirectUrl($url,$num);
		    exit;
		}
		else if(trim($_REQUEST['icon'])=="")
		{
			$_SESSION['msg']='Please enter Icon name.';
			$error='danger';
			$error.='&parent_id='.$_REQUEST['parent_id'];
			$url= ADMIN_URL."/menu_manager/add_submenu.php";
			
			$general->redirectUrl($url,$num);
		    exit;
		}
		
		$fieldvalues = array('parent_id'=>$_REQUEST['parent_id'],'name'=>$_REQUEST['name'],'page_name'=>$_REQUEST['page_name'],'order_index'=>$_REQUEST['order'],'icon'=>$_REQUEST['icon']);
		$updated =$Menu->createMenuOption($fieldvalues);
		
		if($updated)
		{
				$general->addLogAction($_SESSION['adm_user_id'],'Added',$updated,'Menu Management',$_SESSION['adm_status']);
				$error  ='success';
				$_SESSION['msg']='Record updated successfully.';
		}else{
				$error  ='danger';
				$_SESSION['msg']='Error updating record.';
		}

		$url= ADMIN_URL."/menu_manager/submenu_index.php";
		$error.='&parent_id='.$_REQUEST['parent_id'];
		$general->redirectUrl($url,$error);
		exit;
	}	
	
	/*********************************************************************************************************/
	
	if($_REQUEST['FLAG']=='EDIT_MENU_OPTION')
	{
		if(trim($_REQUEST['name'])=="")
		{
			$_SESSION['msg']='Please enter Group Name.';
			$error='danger';
			$error.='&parent_id='.$_REQUEST['parent_id'];
			$url= ADMIN_URL."/menu_manager/edit_submenu.php";
			$general->redirectUrl($url,$num);
		    exit;
		}
		else if(trim($_REQUEST['page_name'])=="")
		{
			$_SESSION['msg']='Please enter Page name.';
			$error='danger';
			$error.='&parent_id='.$_REQUEST['parent_id'];
			$url= ADMIN_URL."/menu_manager/edit_submenu.php";
			$general->redirectUrl($url,$num);
		    exit;
		}

		else if(trim($_REQUEST['order'])=="")
		{
			$_SESSION['msg']='Please enter order.';
			$error='danger';
			$error.='&parent_id='.$_REQUEST['parent_id'];
			$url= ADMIN_URL."/menu_manager/edit_submenu.php";
			$general->redirectUrl($url,$num);
		    exit;
		}
		else if(trim($_REQUEST['icon'])=="")
		{
			$_SESSION['msg']='Please enter Icon name.';
			$error='danger';
			$error.='&parent_id='.$_REQUEST['parent_id'];
			$url= ADMIN_URL."/menu_manager/edit_submenu.php";
			$general->redirectUrl($url,$num);
		    exit;
		}
		
		
		
		
		
		$cond		= array("id" => $_REQUEST['id']);
		$fieldvalues = array('parent_id'=>$_REQUEST['parent_id'],'name'=>$_REQUEST['name'],'page_name'=>$_REQUEST['page_name'],'order_index'=>$_REQUEST['order'],'icon'=>$_REQUEST['icon'],'is_hidden'=>$_REQUEST['ishidden']);
		$updated =$Menu->updateMenuOption($fieldvalues,$cond);
		
		
		if($updated)
		{
				$general->addLogAction($_SESSION['adm_user_id'],'Edited',$updated,'Menu Management',$_SESSION['adm_status']);
				$error  ='success';
				$_SESSION['msg']='Record updated successfully.';
		}else{
				$error  ='danger';
				$_SESSION['msg']='Error updating record.';
		}

		$error.='&parent_id='.$_REQUEST['parent_id'];
		$url= ADMIN_URL."/menu_manager/submenu_index.php";
		$general->redirectUrl($url,$error);
		exit;
	}	
	
		/*************************************************************************************/	
	if(isset($_REQUEST['FLAG']) && $_REQUEST['FLAG']=='DELETE_SUBMENU')
	{
		
		$id=$_REQUEST['id'];
		$parent_id= $Menu->getMenuOptionParent($id);
		$deleted =$Menu->deleteMenuOption($id);
		if($deleted)
		{		
				$general->addLogAction($_SESSION['adm_user_id'],'Deleted',(int)$id,'Menu Management',$_SESSION['adm_status']);
				$error  ='success';
				$_SESSION['msg']='Record deleted successfully.';
		}
		else
		{
				$error  ='danger';
				$_SESSION['msg']='Error deleting record.';
		}
		

		$error.='&parent_id='.$parent_id;
		$url= ADMIN_URL."/menu_manager/submenu_index.php";
		$general->redirectUrl($url,$error);
		exit;
	}
	/*************************************************************************************/

	if(isset($_REQUEST['FLAG']) && $_REQUEST['FLAG'] == 'DELSELECT_SUBMENU')
	{
		
		$val=0;
		$delete = $_POST['delete'];
		$parent_id= $Menu->getMenuOptionParent($delete[0]);
		
		foreach ($delete as $id) 
		{
				$val =$Menu->deleteMenuOption($id);
				$general->addLogAction($_SESSION['adm_user_id'],'Deleted',(int)$id,'Menu Management',$_SESSION['adm_status']);
		}
		
		if($val)
		{
			$_SESSION['msg']='Selected Entries have been deleted.';
			$error='success';
		}
		else
		{
			$_SESSION['msg']='Error deleting entry.';
			$error  ='danger';
		}
	
		$error.='&parent_id='.$parent_id;
		$url= ADMIN_URL."/menu_manager/submenu_index.php";
		$general->redirectUrl($url,$error);
		exit;
	
	}
	/*********************************************************************************************************/	
	
	
?>