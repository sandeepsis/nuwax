<?php
class Customer {
    var $dbBean;
	var $general;
    
    function Customer($dbBean) {
        $this->dbBean=$dbBean;
		$this->general=new General($this->dbBean);
	}
	
	public function addCustomer($fieldvalues)
	{
		$saved = $this->dbBean->InsertRow("customer", $fieldvalues);
		return $saved;
	}
	
	public function addCustomertoken($fieldvalues)
	{
		$saved = $this->dbBean->InsertRow("customertoken", $fieldvalues);
		return $saved;
	}
		
	public function updateCustomer($fieldvalues, $cond)
	{
		$edited = $this->dbBean->UpdateRows("customer", $fieldvalues, $cond);
		return $edited;
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
	
	public static function getCustomerById($id=0)
	{
		$resultarray=array();
		global $dbBean;
		$query="SELECT * FROM customer WHERE is_deleted=0 and id=" . intval($id);
		
		if (! $resultarray = $dbBean->QuerySingleRow($query)) $dbBean->Kill();
		return $resultarray;
		
	}
	
	
	public function deleteCustomer($fieldvalues,$cond)
	{
		$edited = $this->dbBean->UpdateRows("customer", $fieldvalues, $cond);
		return $edited;
	}
	
	public static function getCustomerByEmail($email='',$id='')
	{
		$resultarray=array();
		global $dbBean;
		
		if ($id != ''){
			$cond = "email='". $email."' and id!=".$id;
		}else{
			$cond = "email='". $email."'";	
		}
				
		$query="SELECT count(id) cnt FROM customer WHERE  $cond";
		
		$dbBean->QueryArray($query);
		
		$resultarray = $dbBean->RecordsArray(MYSQLI_ASSOC);
		$cnt = $resultarray[0]['cnt'];
		
		return $cnt;
	}
	
	public static function getCustomertoken($token)
	{
		$resultarray=array();
		global $dbBean;
	
		$query="SELECT * FROM customertoken where token='".$token."'";
	
		if (!$dbBean->QueryArray($query)) $dbBean->Kill();
		if ($dbBean->RowCount()>0)
		{
			$resultarray = $dbBean->RecordsArray(MYSQLI_ASSOC);
		}
		return $resultarray;
	
	}
}
?>
