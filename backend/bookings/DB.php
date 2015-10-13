<?php
	include('config.php');
	$dbBean = new DatabaseBean();	
	$general = new General($dbBean);
	$Booking = new Booking($dbBean);

	if ($_REQUEST['FLAG']=='ADD_BOOKING') {			
		if (trim($_REQUEST['customer'])=="") {
			$_SESSION['msg']='Please select customer';
			$num='danger';
			$url= ADMIN_URL."/bookings/add.php";
			$general->redirectUrl($url, $num);
		    exit;
		}
		
		if (trim($_REQUEST['service'][0])=="") {
			$_SESSION['msg']='Please select service';
			$num='danger';
			$url= ADMIN_URL."/bookings/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if (trim($_REQUEST['offerprice'][0])=="") {
			$_SESSION['msg']='Please enter offer price';
			$num='danger';
			$url= ADMIN_URL."/bookings/add.php";
			$general->redirectUrl($url, $num);
			exit;
		} else {
			$pattern = '/^[0-9]+(?:\.[0-9]{0,2})?$/';
			if (preg_match($pattern, trim($_REQUEST['offerprice'][0])) == '0') {
				$_SESSION['msg']='Please enter valid offer price';
				$num='danger';
				$url= ADMIN_URL."/bookings/add.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
		
		if (trim($_REQUEST['servicedate'])=="") {
			$_SESSION['msg']='Please enter service date';
			$num='danger';
			$url= ADMIN_URL."/bookings/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if (trim($_REQUEST['servicetime'])=="") {
			$_SESSION['msg']='Please enter service time';
			$num='danger';
			$url= ADMIN_URL."/bookings/add.php";
			$general->redirectUrl($url, $num);
			exit;
		}
				
		if ($_REQUEST['status'] == '5') {
			if (trim($_REQUEST['therapist'])=="") {
				$_SESSION['msg']='Please select therapist';
				$num='danger';
				$url= ADMIN_URL."/bookings/add.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
		
		if ($_REQUEST['status'] == '1') {
			$status = "New";
		} else if ($_REQUEST['status'] == '2') {
			$status = "Confirmed";
		} else if ($_REQUEST['status'] == '3') {
			$status = "Cancelled";
		} else if ($_REQUEST['status'] == '4') {
			$status = "Absent";
		} else if ($_REQUEST['status'] == '5') {
			$status = "Complete";
		}
				
		if ($_REQUEST['therapist'] == '') {
			$fieldvalues = array('customerid' => $_REQUEST['customer'], "servicedate" => $_REQUEST['servicedate'], "servicetime" => $_REQUEST['servicetime'], "totalprice" => $_REQUEST['totalprice'],"status" => $_REQUEST['status'], "is_deleted" => '0', "date_added" => date('Y-m-d H:i:s'));
		} else {
			$fieldvalues = array('customerid' => $_REQUEST['customer'],'staffid' => $_REQUEST['therapist'], "servicedate" => $_REQUEST['servicedate'], "servicetime" => $_REQUEST['servicetime'], "totalprice" => $_REQUEST['totalprice'],"status" => $_REQUEST['status'], "is_deleted" => '0', "date_added" => date('Y-m-d H:i:s'));
		}
								
		$updated = $Booking->addBooking($fieldvalues);
		
		if ($updated) {
			for($i=0;$i<count($_REQUEST['service']);$i++)
			{
				if ($_REQUEST['service'][$i] !="" && $_REQUEST['offerprice'][$i] != "") {
					$booking_service 	= $_REQUEST['service'][$i];
					$actual_price 		= $_REQUEST['actualprice'][$i];
					$offer_price 		= $_REQUEST['offerprice'][$i];
						
					$fields	= array('bookingid','serviceid','actualprice','offerprice','status');
					$values	= array($updated,$booking_service, $actual_price,$offer_price,'0');
			
					$Booking->addBookingservices(array_combine ( $fields, $values ));				
				}
			}
			
			if ($_REQUEST['status'] == '5') {				
				//$r = $Booking->getcreditByBookingid($updated);
								
				//if (count($r) == 0) {				
					$field_values = array('customerid' => $_REQUEST['customer'],'bookingid' => $updated, 'credit' => -$_REQUEST['totalprice'],'credittype' => '1','date_added' => date('Y-m-d H:i:s'));
										
					$add = $Booking->addcreditmanagement($field_values);
					
					if ($add) {
						$data 		= $Booking->getCustomerById($_REQUEST['customer']);
						$usercredit = $data->credit;
						
						$newcredit	= $usercredit - $_REQUEST['totalprice'];
						
						$fieldvalues1 = array('credit' => $newcredit);							
						$cond = array('id'=> $_REQUEST['customer']);
							
						$Booking->updateCustomer($fieldvalues1,$cond);
					}
				//}
			} else if ($_REQUEST['status'] == '4') {
				
				$totprice = ($_REQUEST['totalprice']*50)/100;
				
				$field_values = array('customerid' => $_REQUEST['customer'],'bookingid' => $updated, 'credit' => -$totprice,'credittype' => '1','date_added' => date('Y-m-d H:i:s'));
				
				$add = $Booking->addcreditmanagement($field_values);
					
				if ($add) {
					$data 		= $Booking->getCustomerById($_REQUEST['customer']);
					$usercredit = $data->credit;
				
					$newcredit	= $usercredit - $totprice;
				
					$fieldvalues1 = array('credit' => $newcredit);
					$cond = array('id'=> $_REQUEST['customer']);
						
					$Booking->updateCustomer($fieldvalues1,$cond);
				}
			}
		}
		
		$details = $Booking->getBookingById($updated);
		$user = $details->customername;
		$servicenm = $details->servicename;
		
		if ($updated) {			
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
			$mail->Subject ="NuWax : ".$servicenm." Service Booking";//this is used to intialte subject of the mail
	
			$msg="Hello ".$user."<br/><br/>";
			$msg.="Your '".$servicenm."' service is booked. And your booking status is <b>".$status."</b>";
			$mail->MsgHTML($msg);
	
			$mail->AddAddress($_REQUEST['emailaddress']);
			if(!$mail->Send()){$mail->ErrorInfo;}
			$mail->ClearAddresses();			
		}
		
		if ($updated) {			
			$general->addLogAction($_SESSION['adm_user_id'],'Added', $updated, 'Booking Management', $_SESSION['adm_status']);
			$error  = 'success';
			$_SESSION['msg'] = 'Record added successfully.';
		} else {
			$error  ='danger';
			$_SESSION['msg']='Error adding record.';
		}
				
		$url= ADMIN_URL."/bookings/index.php";
		$general->redirectUrl($url,$error);
		exit;
	}	
	
	/*********************************************************************************************************/
	
	if ($_REQUEST['FLAG']=='EDIT_BOOKING') {	
		
		if (trim($_REQUEST['service'][0])=="") {
			$_SESSION['msg']='Please select service';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/bookings/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if (trim($_REQUEST['offerprice'][0])=="") {
			$_SESSION['msg']='Please enter offer price';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/bookings/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		} else {
			$pattern = '/^[0-9]+(?:\.[0-9]{0,2})?$/';
			if (preg_match($pattern, trim($_REQUEST['offerprice'][0])) == '0') {
				$_SESSION['msg']='Please enter valid offer price';
				$num='danger';
				$num.='&id='.$_REQUEST['id'];
				$url= ADMIN_URL."/bookings/edit.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
		
		if (trim($_REQUEST['servicedate'])=="") {
			$_SESSION['msg']='Please enter service date';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/bookings/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}
		
		if (trim($_REQUEST['servicetime'])=="") {
			$_SESSION['msg']='Please enter service time';
			$num='danger';
			$num.='&id='.$_REQUEST['id'];
			$url= ADMIN_URL."/bookings/edit.php";
			$general->redirectUrl($url, $num);
			exit;
		}
				
		if ($_REQUEST['status'] == '5') {
			if (trim($_REQUEST['therapist'])=="") {
				$_SESSION['msg']='Please select therapist';
				$num='danger';
				$num.='&id='.$_REQUEST['id'];
				$url= ADMIN_URL."/bookings/edit.php";
				$general->redirectUrl($url, $num);
				exit;
			}
		}
			
		$cond		= array("id" => $_REQUEST['id']);

		if ($_REQUEST['therapist'] != '') {		
			$fieldvalues = array('staffid' => $_REQUEST['therapist'], "servicedate" => $_REQUEST['servicedate'], "servicetime" => $_REQUEST['servicetime'], "totalprice" => $_REQUEST['totalprice'],"status" => $_REQUEST['status']);
		} else {
			$fieldvalues = array("servicedate" => $_REQUEST['servicedate'], "servicetime" => $_REQUEST['servicetime'], "totalprice" => $_REQUEST['totalprice'],"status" => $_REQUEST['status']);
		}
				
		$updated = $Booking->updateBooking($fieldvalues, $cond);
		
		if ($updated) {				
			for($i=0;$i<count($_REQUEST['serviceids']);$i++)
			{
				if ($_REQUEST['serviceids'][$i] !="" && $_REQUEST['offerprice'][$i] != "") {
					
					$booking_service 	= $_REQUEST['serviceids'][$i];
					$actual_price 		= $_REQUEST['actualprice'][$i];
					$offer_price 		= $_REQUEST['offerprice'][$i];
					
					if ($_REQUEST['servicerowid'][$i] != '0') {
						
						$cond = array('id'=> $_REQUEST['servicerowid'][$i]);
												
						$field_values1 = array('serviceid' => $booking_service,'actualprice' => $actual_price,'offerprice' => $offer_price,'status' => $_REQUEST['bookingservicestatus'][$i]);
						$Booking->updateBookingservices($field_values1,$cond);
					} else {
						
						$field_values1 = array('bookingid' =>$_REQUEST['id'] ,'serviceid' => $booking_service,'actualprice' => $actual_price,'offerprice' => $offer_price,'status' => $_REQUEST['bookingservicestatus'][$i]);
						$Booking->addBookingservices($field_values1);
					}
				}
			}
						
			if ($_REQUEST['status'] == '5') {				
				//$r = $Booking->getcreditByBookingid($_REQUEST['id']);
								
				//if (count($r) == 0) {				
					$field_values = array('customerid' => $_REQUEST['customer_id'],'bookingid' => $_REQUEST['id'], 'credit' => -$_REQUEST['totalprice'],'credittype' => '1','date_added' => date('Y-m-d H:i:s'));
										
					$add = $Booking->addcreditmanagement($field_values);
					
					if ($add) {
						$data 		= $Booking->getCustomerById($_REQUEST['customer_id']);
						$usercredit = $data->credit;
						
						$newcredit	= $usercredit - $_REQUEST['totalprice'];
						
						$fieldvalues1 = array('credit' => $newcredit);							
						$cond = array('id'=> $_REQUEST['customer_id']);
							
						$Booking->updateCustomer($fieldvalues1,$cond);
					}
				//}
			} else if ($_REQUEST['status'] == '4') {
				
				$totprice = ($_REQUEST['totalprice']*50)/100;
				
				$field_values = array('customerid' => $_REQUEST['customer_id'],'bookingid' => $_REQUEST['id'], 'credit' => -$totprice,'credittype' => '1','date_added' => date('Y-m-d H:i:s'));
				
				$add = $Booking->addcreditmanagement($field_values);
					
				if ($add) {
					$data 		= $Booking->getCustomerById($_REQUEST['customer_id']);
					$usercredit = $data->credit;
				
					$newcredit	= $usercredit - $totprice;
				
					$fieldvalues1 = array('credit' => $newcredit);
					$cond = array('id'=> $_REQUEST['customer_id']);
						
					$Booking->updateCustomer($fieldvalues1,$cond);
				}
			}
			
			if ($_REQUEST['hdnlaststatus'] != $_REQUEST['status']) {
				
				$details = $Booking->getBookingById($_REQUEST['id']);
				$user = $details->customername;
				$servicenm = $details->servicename;
				
				if ($_REQUEST['status'] == '1') {
					$status = "New";
				} else if ($_REQUEST['status'] == '2') {
					$status = "Confirmed";
				} else if ($_REQUEST['status'] == '3') {
					$status = "Cancelled";
				} else if ($_REQUEST['status'] == '4') {
					$status = "Absent";
				} else if ($_REQUEST['status'] == '5') {
					$status = "Complete";
				}
				
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
				$mail->Subject ="NuWax : ".$servicenm." Service Booking";//this is used to intialte subject of the mail
				
				$msg="Hello ".$user."<br/><br/>";
				$msg.="Your '".$servicenm."' service status change to <b>".$status."</b>";
				$mail->MsgHTML($msg);
				
				$mail->AddAddress('nirmalaparmar29@gmail.com'); //$_REQUEST['emailaddress']
				if(!$mail->Send()){$mail->ErrorInfo;}
				$mail->ClearAddresses();
			}
		}

		if ($updated) {
				$general->addLogAction($_SESSION['adm_user_id'], 'Edited', $_REQUEST['id'], 'Booking Management', $_SESSION['adm_status']);
				$error = 'success';
				$_SESSION['msg'] = 'Record updated successfully.';
		} else {
				$error = 'danger';
				$_SESSION['msg'] = 'Error updating record.';
		}
		
		$url= ADMIN_URL."/bookings/index.php";
		$general->redirectUrl($url,$error);
		exit;
	}		
	
	/*************************************************************************************/	
	if (isset($_REQUEST['FLAG']) && $_REQUEST['FLAG']=='DELETE') {		
		$id=$_REQUEST['id'];
		
		$cond		 = array("id" => $id);
		$fieldvalues = array('is_deleted' => '1');
		
		$deleted = $Booking->deleteBooking($fieldvalues,$cond);
		
		if ($deleted) {		
			$general->addLogAction($_SESSION['adm_user_id'], 'Deleted', (int)$_REQUEST['id'], 'Booking Management', $_SESSION['adm_status']);
			$error = 'success';
			$_SESSION['msg'] = 'Record deleted successfully.';
		} else {
			$error = 'danger';
			$_SESSION['msg'] = 'Error deleting record.';
		}
		

		$url = ADMIN_URL."/bookings/index.php";
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
			
			$val = $Booking->deleteBooking($fieldvalues,$cond);
		
			$general->addLogAction($_SESSION['adm_user_id'], 'Deleted', (int)$id,'Booking Management', $_SESSION['adm_status']);
		}
		
		if ($val) {
			$_SESSION['msg'] = 'Selected Entries have been deleted.';
			$error = 'success';
		} else {
			$_SESSION['msg'] = 'Error deleting entry.';
			$error = 'danger';
		}
	
		$url= ADMIN_URL."/bookings/index.php";
		$general->redirectUrl($url, $error);
		exit;
	
	}
	/*********************************************************************************************************/
	if ($_REQUEST['FLAG']=='GET_PRICE') {
		$id=$_REQUEST['id'];
	
		$record = $Booking->getServiceById($id);
				
		if ($record->price != '') {
			echo $record->price;
			exit;
		} else {
			echo "error";
			exit;
		}
		
		
	}	
	/*********************************************************************************************************/
?>
