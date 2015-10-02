<?php
	include('config.php');
	$dbBean=new DatabaseBean();	
	$general		= new General($dbBean);
	include('../generalFunctions.php');
	

	if($_REQUEST['FLAG']=='CHPWD')
	{
		
		$cond		= array("id" => $_REQUEST['id']);
		$fieldvalues = array('password'=>md5($_REQUEST['password']));
		$updated = $dbBean->UpdateRows("admins", $fieldvalues, $cond);
		

		if($updated)
		{
				$general->addLogAction($_SESSION['adm_user_id'],'Changed',$_REQUEST['id'],'Admin Password',$_SESSION['adm_status']);
				$error  ='success';
				$_SESSION['msg']='Password successfully changed.';
		}else{
				$error  ='danger';
				$_SESSION['msg']='Error changing password.';
		}

		$url= ADMIN_URL."/admins/index.php";
		$general->redirectUrl($url,$error);
		exit;
	}	
	
	/***************************************************************************/
	
	
	
	if($_REQUEST['FLAG']=='EDIT')
	{
		
		
		$cond		= array("id" => $_REQUEST['id']);
		$fieldvalues = array('username'=>$_REQUEST['txtuser'],'last_name'=>$_REQUEST['txtlname'],'first_name'=>$_REQUEST['txtfname'],'email'=>$_REQUEST['txtemail'],'status'=>$_REQUEST['status']);
		
		$updated = $dbBean->UpdateRows("admins", $fieldvalues, $cond);

		if ($updated) 
		{
				$general->addLogAction($_SESSION['adm_user_id'],'Edited',$_REQUEST['id'],'Admin Management',$_SESSION['adm_status']);
				$error  ='success';
				$_SESSION['msg']='Record updated successfully.';
		}else{
				$error  ='danger';
				$_SESSION['msg']='Error updating record.';
		}

		$url= ADMIN_URL."/admins/index.php";
		$general->redirectUrl($url,$error);
		exit;
	}		
	
	
	/***************************************************************************/
	
	
	
	if($_REQUEST['FLAG']=='ADD')
	{
		
		$fieldvalues = array('username'=>$_REQUEST['txtuser'],'last_name'=>$_REQUEST['txtlname'],'first_name'=>$_REQUEST['txtfname'],'email'=>$_REQUEST['txtemail'],'password'=>md5($_REQUEST['password']),'status'=>$_REQUEST['status']);
		$updated = $dbBean->InsertRow("admins", $fieldvalues);
			

		if($updated)
		{
				$general->addLogAction($_SESSION['adm_user_id'],'Added',$updated,'Admin Management',$_SESSION['adm_status']);
				$error  ='success';
				$_SESSION['msg']='Record updated successfully.';
		}else{
				$error  ='danger';
				$_SESSION['msg']='Error updating record.';
		}

		$url= ADMIN_URL."/admins/index.php";
		$general->redirectUrl($url,$error);
		exit;
	}	
	/*************************************************************************************/	
	if(isset($_REQUEST['FLAG']) && $_REQUEST['FLAG']=='DELETE'){
		if((int)$_REQUEST['id']==1)
		{
		}
		else
		{
			$cond		= array("id" => $_REQUEST['id']);
			$deleted=$dbBean->DeleteRows("admins",$cond);
			if($deleted)
			{		
					$general->addLogAction($_SESSION['adm_user_id'],'Deleted',(int)$_REQUEST['id'],'Admin Management',$_SESSION['adm_status']);
					$error  ='success';
					$_SESSION['msg']='Record deleted successfully.';
			}
			else{
					$error  ='danger';
					$_SESSION['msg']='Error deleting record.';
				}
		}

		$url= ADMIN_URL."/admins/index.php";
		$general->redirectUrl($url,$error);
		exit;
	}
	/*************************************************************************************/

	if(isset($_REQUEST['FLAG']) && $_REQUEST['FLAG'] == 'DELSELECT_USERS')
	{
		
		$val=0;
		$delete = $_POST['delete'];
		foreach ($delete as $id) 
		{
			if($id > 1)
			{	
				
				$cond		= array("id" => $id);
				$val=$dbBean->DeleteRows("admins",$cond);
				$general->addLogAction($_SESSION['adm_user_id'],'Deleted',(int)$id,'Admin Management',$_SESSION['adm_status']);
				
			}
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
	
		$url= ADMIN_URL."/admins/index.php";
		$general->redirectUrl($url,$error);
		exit;
	
	}
/*****************************************************************************************************/


	if($_REQUEST['FLAG']=='FORGOT_PWD')
	{
		
		if(isset($_REQUEST['email']) && $_REQUEST['email']!='')
		{
			if( !filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL))
			{
					
					$error  ='danger';
					$_SESSION['msg']='Please fill valid email.';
					$url= ADMIN_URL."/login.php";
					$general->redirectUrl($url,$error);
					exit;
			}
			
		 	$query=	"SELECT * FROM `admins` where email='".$_REQUEST['email']."'";
			if (! $dbBean->Query($query)) $dbBean->Kill();
			
			if ($dbBean->RowCount()>0)
			{
				$email_data = $dbBean->RowArray(null,MYSQLI_ASSOC);
				$new_password=$general->create_password(12);
				
				$cond		= array("id" => $email_data['id']);
				$fieldvalues = array('password'=>md5($new_password));
				$updated = $dbBean->UpdateRows("admins", $fieldvalues, $cond);
				
				if($updated)
				{
					$mail = new PHPMailer();
					$mail->IsSMTP(); // telling the class to use SMTP
					$mail->Host       = "smtp.gmail.com"; // SMTP server
					$mail->SMTPDebug  =1; 									
					$mail->SMTPAuth   = true;                  
					$mail->Port = 587;
					$mail->SMTPSecure = 'tls';
					$mail->Username   = SMPT_EMAIL; // SMTP account username
					$mail->Password   = SMPT_PASS;        // SMTP account password
					$mail->SetFrom(SMPT_EMAIL, 'H-Kore');
					$mail->AddReplyTo(SMPT_EMAIL, 'H-Kore');
					$mail->Subject ="Admin password recovery";//this is used to intialte subject of the mail
					
					$msg="Hello ADMIN<br/><br/>.";
					$msg.="Your password has been reset. Your current password is<br/><br/>";
					$msg.="Password: ".$new_password."<br/>";
					$mail->MsgHTML($msg);
					
					
					$mail->AddAddress($_REQUEST['email']);
					if(!$mail->Send()){$mail->ErrorInfo;}
					$mail->ClearAddresses();
					
					$error  ='success';
					$_SESSION['msg']='Your password has been reset successfully. Please check your email for the new password.';
					$url= ADMIN_URL."/login.php";
					$general->redirectUrl($url,$error);
					exit;
				}
				else
				{
					$error  ='danger';
				echo 	$_SESSION['msg']='Error updating password. Contact Support for manualy changing password.';
					$url= ADMIN_URL."/login.php";
					$general->redirectUrl($url,$error);
					exit;
				}
			}
			else
			{
				$error  ='danger';
				$_SESSION['msg']='You are not a valid user.';
				$url= ADMIN_URL."/login.php";
				$general->redirectUrl($url,$error);
				exit;
				
			}
		}
	}	
	
	
?>