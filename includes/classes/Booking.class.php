<?php
class Booking {
    var $dbBean;
	var $general;
    
    function Booking($dbBean) {
        $this->dbBean=$dbBean;
		$this->general=new General($this->dbBean);
	}
	
	public function addBooking($fieldvalues)
	{
		$saved = $this->dbBean->InsertRow("bookings", $fieldvalues);
		return $saved;
	}
	
	public function addcreditmanagement($fieldvalues)
	{
		$saved = $this->dbBean->InsertRow("creditmanagement", $fieldvalues);
		return $saved;
	}
	
	public function updateCustomer($fieldvalues, $cond)
	{
		$edited = $this->dbBean->UpdateRows("customer", $fieldvalues, $cond);
		return $edited;
	}
	
	public function updateBooking($fieldvalues, $cond)
	{
		$edited = $this->dbBean->UpdateRows("bookings", $fieldvalues, $cond);
		return $edited;
	}

	public static function getBookings()
	{
		$resultarray=array();
		global $dbBean;
		
		$query="SELECT *,date_format(servicedate,'%d-%m-%Y') servicedate,(select name from customer where id=customerid) customername,(select servicename from services where id=serviceid) servicename FROM bookings where is_deleted=0 order by id desc";
		
		if (!$dbBean->QueryArray($query)) $dbBean->Kill();
		if ($dbBean->RowCount()>0)
		{
			$resultarray = $dbBean->RecordsArray(MYSQLI_ASSOC);
		}
		return $resultarray;		
	}
	
	public static function getBookingById($id=0)
	{
		$resultarray=array();
		global $dbBean;
		$query="SELECT *,(select name from customer where id=customerid) customername,(select servicename from services where id=serviceid) servicename FROM bookings WHERE is_deleted=0 and id=" . intval($id);
		
		if (! $resultarray = $dbBean->QuerySingleRow($query)) $dbBean->Kill();
		return $resultarray;		
	}
		
	public function deleteBooking($fieldvalues,$cond)
	{
		$edited = $this->dbBean->UpdateRows("bookings", $fieldvalues, $cond);
		return $edited;
	}
	
	public static function getServices()
	{
		$resultarray=array();
		global $dbBean;
	
		$query="SELECT * FROM services where is_deleted=0 order by id desc";
	
		if (!$dbBean->QueryArray($query)) $dbBean->Kill();
		if ($dbBean->RowCount()>0)
		{
			$resultarray = $dbBean->RecordsArray(MYSQLI_ASSOC);
		}
		return $resultarray;
	}
	
	public static function getCustomers()
	{
		$resultarray=array();
		global $dbBean;
	
		$query="SELECT * FROM customer where is_deleted=0 order by id desc";
	
		if (!$dbBean->QueryArray($query)) $dbBean->Kill();
		if ($dbBean->RowCount()>0)
		{
			$resultarray = $dbBean->RecordsArray(MYSQLI_ASSOC);
		}
		return $resultarray;
	}
	
	public static function getStaffs()
	{
		$resultarray=array();
		global $dbBean;
	
		$query="SELECT * FROM staff where is_deleted=0 order by id desc";
	
		if (!$dbBean->QueryArray($query)) $dbBean->Kill();
		if ($dbBean->RowCount()>0)
		{
			$resultarray = $dbBean->RecordsArray(MYSQLI_ASSOC);
		}
		return $resultarray;
	}
	
	public static function getCutomerById($id=0)
	{
		$resultarray=array();
		global $dbBean;
		$query="SELECT * FROM customer WHERE is_deleted=0 and id=" . intval($id);
	
		$resultarray = $dbBean->QuerySingleRow($query);
		return $resultarray;
	}
	
	public static function getServiceById($id=0)
	{
		$resultarray=array();
		global $dbBean;
		$query="SELECT * FROM services WHERE is_deleted=0 and id=" . intval($id);
	
		$resultarray = $dbBean->QuerySingleRow($query);
		return $resultarray;
	}
	
	public static function getcreditByBookingid($id=0)
	{
		$resultarray=array();
		global $dbBean;
		$query="SELECT * FROM creditmanagement WHERE bookingid=" . intval($id);
		$dbBean->QueryArray($query);
		if ($dbBean->RowCount()>0)
		{
			$resultarray = $dbBean->RecordsArray(MYSQLI_ASSOC);
		}
		
		return $resultarray;
	}
}
?>
