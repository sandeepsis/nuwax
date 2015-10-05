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
	
	public function updatePackage($fieldvalues, $cond)
	{
		$edited = $this->dbBean->UpdateRows("package", $fieldvalues, $cond);
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
	
}
?>
