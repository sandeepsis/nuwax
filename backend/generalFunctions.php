<?php
function getAdmin(){
	global $dbBean;
	$query=	"select CONCAT(first_name,' ',	last_name) as name, email from  admins";
	if (! $dbBean->Query($query)) $dbBean->Kill();
	$admin_data = $dbBean->RowArray(null,MYSQLI_ASSOC);
	
	return $admin_data;
}

function dashboardRegisterThisMonth(){
	global $dbBean;
	$firstday=date('Y-m-01');
	$today=date('Y-m-d');
	
	$query=	"select count(id) as regct from  registration where registration_date between '".$firstday." 00:00:00' and  '".$today." 23:59:59' and userstatus=1";
	if (! $dbBean->Query($query)) $dbBean->Kill();
	$data = $dbBean->RowArray(null,MYSQLI_ASSOC);
	
	return intval($data['regct']);
}

function dashboardPurchaseThisMonth(){
	global $dbBean;
	$firstday=date('Y-m-01');
	$today=date('Y-m-d');
	
	$query=	"select sum(package_amount) as pct  from  purchase where purchase_date between '".$firstday." 00:00:00' and  '".$today." 23:59:59' and status=1 and trans_id <> ''";

	if (! $dbBean->Query($query)) $dbBean->Kill();
	$data = $dbBean->RowArray(null,MYSQLI_ASSOC);
	
	return number_format($data['pct'],0);
}

function dashboardBookingsToday(){
	global $dbBean;
	$today=date('Y-m-d');
	$query=	"select count(id) as regct from  bookingclass where workout_date='".$today."' and booking_status=1";
	if (! $dbBean->Query($query)) $dbBean->Kill();
	$data = $dbBean->RowArray(null,MYSQLI_ASSOC);
	
	return intval($data['regct']);
}

function dashboardWaitlistsToday(){
	global $dbBean;
	$today=date('Y-m-d');
	$query=	"select count(id) as regct from  waitinglist where workout_date='".$today."' and status=1";
	if (! $dbBean->Query($query)) $dbBean->Kill();
	$data = $dbBean->RowArray(null,MYSQLI_ASSOC);
	
	return intval($data['regct']);
}


function dashboardRegisterlast(){
	global $dbBean;
	$records["data"]=array();
	$query = "SELECT  concat(year(`registration_date`),'-',month(`registration_date`)) as ymn, count(id) as ct  FROM `registration` WHERE status =1 and  registration_date >= date_sub(now(), interval 6 month) group by year(registration_date),month(`registration_date`) order by year(`registration_date`) desc, month(`registration_date`) desc limit 6";
	
	if (! $dbBean->Query($query)) $dbBean->Kill();
	$rows = $dbBean->RecordsArray(MYSQLI_ASSOC);
	
	for($i = 0; $i < count($rows); $i++) 
  	{
    	$records["data"][] = array(
		 $rows[$i]['ymn'],  
		 $rows[$i]['ct']
		  
	   );
  }
echo json_encode($records['data']);	


	
	
}

function dashboardPurchaselast(){
	global $dbBean;
	$records["data"]=array();
	$query = "SELECT  concat(year(`purchase_date`),'-',month(`purchase_date`)) as ymn, sum(`package_amount`) as ct  FROM `purchase` WHERE status =1 and trans_id <> '' and  purchase_date >= date_sub(now(), interval 6 month) group by year(purchase_date),month(`purchase_date`) order by year(`purchase_date`) desc, month(`purchase_date`) desc limit 6";
	
	if (! $dbBean->Query($query)) $dbBean->Kill();
	$rows = $dbBean->RecordsArray(MYSQLI_ASSOC);
	
	for($i = 0; $i < count($rows); $i++) 
  	{
    	$records["data"][] = array(
		 $rows[$i]['ymn'],  
		 $rows[$i]['ct']
		  
	   );
  }
echo json_encode($records['data']);	


	
	
}
?>