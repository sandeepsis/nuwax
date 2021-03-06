<?php
class Salesorder {
    var $dbBean;
	var $general;
    
    function Salesorder($dbBean) {
        $this->dbBean=$dbBean;
		$this->general=new General($this->dbBean);
	}
	
	public function addSalesorder($fieldvalues)
	{
		$saved = $this->dbBean->InsertRow("stockmanagement", $fieldvalues);
		return $saved;
	}
	
	public function updateSalesorder($fieldvalues, $cond)
	{
		$edited = $this->dbBean->UpdateRows("stockmanagement", $fieldvalues, $cond);
		return $edited;
	}
	
	public function updateProduct($fieldvalues, $cond)
	{
		$edited = $this->dbBean->UpdateRows("products", $fieldvalues, $cond);
		return $edited;
	}

	public static function getSalesorders()
	{
		$resultarray=array();
		global $dbBean;
		
		$query="SELECT *,date_format(voucherdate,'%d-%m-%Y') voucherdate,(SELECT productname FROM products where id=productid) productname FROM stockmanagement where vouchertype=1 order by id desc";
		
		if (!$dbBean->QueryArray($query)) $dbBean->Kill();
		if ($dbBean->RowCount()>0)
		{
			$resultarray = $dbBean->RecordsArray(MYSQLI_ASSOC);
		}
		return $resultarray;		
	}
	
	public static function getSalesorderById($id=0)
	{
		$resultarray=array();
		global $dbBean;
		$query="SELECT * FROM stockmanagement WHERE id=" . intval($id);
		
		if (! $resultarray = $dbBean->QuerySingleRow($query)) $dbBean->Kill();
		return $resultarray;		
	}
	
	public static function getProducts()
	{
		$resultarray=array();
		global $dbBean;
	
		$query="SELECT * FROM products where is_deleted=0 order by id desc";
	
		if (!$dbBean->QueryArray($query)) $dbBean->Kill();
		if ($dbBean->RowCount()>0)
		{
			$resultarray = $dbBean->RecordsArray(MYSQLI_ASSOC);
		}
		return $resultarray;
	}
	
	public static function getproductById($id=0)
	{
		$resultarray=array();
		global $dbBean;
		$query="SELECT * FROM products WHERE is_deleted=0 and id=" . intval($id);
	
		if (! $resultarray = $dbBean->QuerySingleRow($query)) $dbBean->Kill();
		return $resultarray;
	}
	
	public static function getLastSalesordersId()
	{
		$resultarray=array();
		global $dbBean;
	
		$query="SELECT * FROM stockmanagement order by id desc limit 0,1";
	
		$dbBean->QueryArray($query);
				
		if ($dbBean->RowCount()>0)
		{
			$resultarray = $dbBean->RecordsArray(MYSQLI_ASSOC);
		}
		return $resultarray;
	}
	
}
?>
