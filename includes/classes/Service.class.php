<?php
class Service {
    var $dbBean;
	var $general;
    
    function Service($dbBean) {
        $this->dbBean=$dbBean;
		$this->general=new General($this->dbBean);
	}
	
	public function addService($fieldvalues)
	{
		$saved = $this->dbBean->InsertRow("services", $fieldvalues);
		return $saved;
	}
	
	public function updateService($fieldvalues, $cond)
	{
		$edited = $this->dbBean->UpdateRows("services", $fieldvalues, $cond);
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
	
	public static function getServiceById($id=0)
	{
		$resultarray=array();
		global $dbBean;
		$query="SELECT * FROM services WHERE is_deleted=0 and id=" . intval($id);
		
		if (! $resultarray = $dbBean->QuerySingleRow($query)) $dbBean->Kill();
		return $resultarray;		
	}
		
	public function deleteService($fieldvalues,$cond)
	{
		$edited = $this->dbBean->UpdateRows("services", $fieldvalues, $cond);
		return $edited;
	}
	
	public static function getServicecategory()
	{
		$resultarray=array();
		global $dbBean;
	
		$query="SELECT * FROM servicecategory where is_deleted=0 order by id desc";
	
		if (!$dbBean->QueryArray($query)) $dbBean->Kill();
		if ($dbBean->RowCount()>0)
		{
			$resultarray = $dbBean->RecordsArray(MYSQLI_ASSOC);
		}
		return $resultarray;
	}
}
?>
