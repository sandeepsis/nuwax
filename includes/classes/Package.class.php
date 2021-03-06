<?php
class Package {
    var $dbBean;
	var $general;
    
    function Package($dbBean) {
        $this->dbBean=$dbBean;
		$this->general=new General($this->dbBean);
	}
	
	public function addPackage($fieldvalues)
	{
		$saved = $this->dbBean->InsertRow("package", $fieldvalues);
		return $saved;
	}
	
	public function addPackageservices($fieldvalues)
	{
		$saved = $this->dbBean->InsertRow("packageservices", $fieldvalues);
		return $saved;
	}
		
	public function addcreditmanagement($fieldvalues)
	{
		$saved = $this->dbBean->InsertRow("creditmanagement", $fieldvalues);
		return $saved;
	}
	
	public function updatePackage($fieldvalues, $cond)
	{
		$edited = $this->dbBean->UpdateRows("package", $fieldvalues, $cond);
		return $edited;
	}
	
	public function updatePackageservices($fieldvalues, $cond)
	{
		$edited = $this->dbBean->UpdateRows("packageservices", $fieldvalues, $cond);
		return $edited;
	}
	
	public function updateCustomer($fieldvalues, $cond)
	{
		$edited = $this->dbBean->UpdateRows("customer", $fieldvalues, $cond);
		return $edited;
	}

	public static function getPackages()
	{
		$resultarray=array();
		global $dbBean;
		
		$query="SELECT * FROM package where is_deleted=0 order by id desc";
		
		if (!$dbBean->QueryArray($query)) $dbBean->Kill();
		if ($dbBean->RowCount()>0)
		{
			$resultarray = $dbBean->RecordsArray(MYSQLI_ASSOC);
		}
		return $resultarray;		
	}
	
	public static function getPackageById($id=0)
	{
		$resultarray=array();
		global $dbBean;
		$query="SELECT * FROM package WHERE is_deleted=0 and id=" . intval($id);
		
		if (! $resultarray = $dbBean->QuerySingleRow($query)) $dbBean->Kill();
		return $resultarray;		
	}
		
	public function deletePackage($fieldvalues,$cond)
	{
		$edited = $this->dbBean->UpdateRows("package", $fieldvalues, $cond);
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
	
	public function packageAllocation($fieldvalues)
	{
		$saved = $this->dbBean->InsertRow("packageallocation", $fieldvalues);
		return $saved;
	}
	
	public static function getcreditByPackageid($id=0)
	{
		$resultarray=array();
		global $dbBean;
		$query="SELECT * FROM creditmanagement WHERE packageid=" . intval($id);
		$dbBean->QueryArray($query);
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
	
	public static function getPackageservicesByPackageid($id=0)
	{
		//$resultarray=array();
		global $dbBean;
		$query="SELECT serviceid FROM packageservices WHERE packageid=" . intval($id);
	
		$resultarray = $dbBean->QuerySingleRow($query);
		return $resultarray;
	}
	
	public function deletePackageservices($id)
	{
		$cond= array("packageid" => intval($id));
		$edited = $this->dbBean->DeleteRows("packageservices", $cond);
		return $edited;
	}
	
}
?>
