<?php
    require_once("config.php");
    require_once("functions.inc.php");	
	$dbBean			= new DatabaseBean();
	$general		= new General($dbBean);
	$name 	  = isset($_POST['user']) ? $_POST['user'] : "";
	$password=isset($_POST['pw'])?$_POST['pw']:"";
	$name = stripQuotes(removeBadChars($name));
	$password = stripQuotes(removeBadChars($password));

	

	$sql="SELECT count(*) as ct FROM action_recorder WHERE user_name = '".$name."' AND success=0 AND DATE_SUB(NOW(), INTERVAL 15 MINUTE) <= date_added";	
	 if (! $dbBean->Query($sql)) $dbBean->Kill();
	$row = $dbBean->RowArray(); 
	$failattempts=$row['ct'];

	if($failattempts >5)

	{

		$_SESSION['msg']='The maximum number of login attempts has been reached. Please try again in 15 minutes.';

		$num='danger';

		$url= ADMIN_URL."/login.php";

		$general->redirectUrl($url,$num);
 	exit;
	}
	$sql="SELECT * FROM admins WHERE username = '".$name."' AND binary password='".md5($password)."' ;";	
	if (! $dbBean->Query($sql)) $dbBean->Kill();
	$row = $dbBean->RowArray(); 
	
	if($row)
	{
		$_SESSION['adm_logged']   = true;              
		$_SESSION['adm_user_id']  = $row['id'];
		$_SESSION['adm_username'] = $row['username']; 
		$_SESSION['adm_status']   = $row['status'];
		$fieldvalues = array('user_name'=>$name,'identifier'=>$_SERVER['REMOTE_ADDR'],'success'=>1);
		$saved = $dbBean->InsertRow("action_recorder", $fieldvalues);
		
		echo "<script>window.location.href='index.php'</script>";
		exit;                            			
	}else{			
		$fieldvalues = array('user_name'=>$name,'identifier'=>$_SERVER['REMOTE_ADDR'],'success'=>0);
		$saved = $dbBean->InsertRow("action_recorder", $fieldvalues);
		$_SESSION['adm_logged']   = false;
		$_SESSION['adm_user_id']  = "";
		$_SESSION['adm_username'] = "";
		$_SESSION['adm_status']   = "";
		$_SESSION['msg']='Wrong username or password!';
		$num='danger';
		$url= ADMIN_URL."/login.php";

		$general->redirectUrl($url,$num);
    	exit;
	}
?>