<?php
class Servicecategory {
    var $dbBean;
	var $general;
    
    function Servicecategory($dbBean) {
        $this->dbBean=$dbBean;
		$this->general=new General($this->dbBean);
	}
	
	public function addServicecategory($fieldvalues)
	{
		$saved = $this->dbBean->InsertRow("servicecategory", $fieldvalues);
		return $saved;
	}
	
	public function updateServicecategory($fieldvalues, $cond)
	{
		$edited = $this->dbBean->UpdateRows("servicecategory", $fieldvalues, $cond);
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
	
	public static function getServicecategoryById($id=0)
	{
		$resultarray=array();
		global $dbBean;
		$query="SELECT * FROM servicecategory WHERE is_deleted=0 and id=" . intval($id);
		
		if (! $resultarray = $dbBean->QuerySingleRow($query)) $dbBean->Kill();
		return $resultarray;
		
	}
	
	
	public function deleteServicecategory($fieldvalues,$cond)
	{
		$edited = $this->dbBean->UpdateRows("servicecategory", $fieldvalues, $cond);
		return $edited;
	}
	
}
?>
