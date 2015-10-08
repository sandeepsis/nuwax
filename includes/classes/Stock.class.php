<?php
class Stock {
    var $dbBean;
	var $general;
    
    function Stock($dbBean) {
        $this->dbBean=$dbBean;
		$this->general=new General($this->dbBean);
	}
	
	public function addStock($fieldvalues)
	{
		$saved = $this->dbBean->InsertRow("stockmanagement", $fieldvalues);
		return $saved;
	}
	
	public function updateStock($fieldvalues, $cond)
	{
		$edited = $this->dbBean->UpdateRows("stockmanagement", $fieldvalues, $cond);
		return $edited;
	}

	public static function getStockdetail()
	{
		$resultarray=array();
		global $dbBean;
		
		$query="SELECT *,(select categoryname from servicecategory where id=categoryid) categorynm FROM stockmanagement where is_deleted=0 order by id desc";
		
		if (!$dbBean->QueryArray($query)) $dbBean->Kill();
		if ($dbBean->RowCount()>0)
		{
			$resultarray = $dbBean->RecordsArray(MYSQLI_ASSOC);
		}
		return $resultarray;		
	}
	
	public static function getStockById($id=0)
	{
		$resultarray=array();
		global $dbBean;
		$query="SELECT * FROM stockmanagement WHERE is_deleted=0 and id=" . intval($id);
		
		if (! $resultarray = $dbBean->QuerySingleRow($query)) $dbBean->Kill();
		return $resultarray;		
	}
		
	public function deleteStock($fieldvalues,$cond)
	{
		$edited = $this->dbBean->UpdateRows("stockmanagement", $fieldvalues, $cond);
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
