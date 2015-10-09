<?php
class Product {
    var $dbBean;
	var $general;
    
    function Product($dbBean) {
        $this->dbBean=$dbBean;
		$this->general=new General($this->dbBean);
	}
	
	public function addProduct($fieldvalues)
	{
		$saved = $this->dbBean->InsertRow("products", $fieldvalues);
		return $saved;
	}
	
	public function updateProduct($fieldvalues, $cond)
	{
		$edited = $this->dbBean->UpdateRows("products", $fieldvalues, $cond);
		return $edited;
	}

	public static function getProducts()
	{
		$resultarray=array();
		global $dbBean;
		
		$query="SELECT *,(select categoryname from servicecategory where id=categoryid) categorynm FROM products where is_deleted=0 order by id desc";
		
		if (!$dbBean->QueryArray($query)) $dbBean->Kill();
		if ($dbBean->RowCount()>0)
		{
			$resultarray = $dbBean->RecordsArray(MYSQLI_ASSOC);
		}
		return $resultarray;		
	}
	
	public static function getProductById($id=0)
	{
		$resultarray=array();
		global $dbBean;
		$query="SELECT * FROM products WHERE is_deleted=0 and id=" . intval($id);
		
		if (! $resultarray = $dbBean->QuerySingleRow($query)) $dbBean->Kill();
		return $resultarray;		
	}
		
	public function deleteProduct($fieldvalues,$cond)
	{
		$edited = $this->dbBean->UpdateRows("products", $fieldvalues, $cond);
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
