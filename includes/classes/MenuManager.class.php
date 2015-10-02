<?php
class Menu {
    var $dbBean;
	var $general;
    
    function Menu($dbBean) {
        $this->dbBean=$dbBean;
		$this->general=new General($this->dbBean);
	}
	//$dbBean->printAllQueries(true);
	
	/* ############################################## ~*~ MAIN MENU ~*~ ############################################## */
	
	public function createMenu($fieldvalues)
	{
		$saved = $this->dbBean->InsertRow("menu", $fieldvalues);
		return $saved;
	}
	
	public function updateMenu($fieldvalues,$cond)
	{
		$edited = $this->dbBean->UpdateRows("menu", $fieldvalues, $cond);
		return $edited;
	}

	public static function getMenus()
	{
		$resultarray=array();
		global $dbBean;
		$query="SELECT * FROM menu WHERE parent_id=0";
		if (!$dbBean->QueryArray($query)) $dbBean->Kill();
		if ($dbBean->RowCount()>0)
		{
			$resultarray = $dbBean->RecordsArray(MYSQLI_ASSOC);
		}
		return $resultarray;
		
	}
	
	public function deleteMenu($id)
	{
		
		$sub_cond= array("parent_id" => $id);
		$this->dbBean->DeleteRows("menu",$sub_cond);
		
		$cond= array("id" => $id);
		$deleted=$this->dbBean->DeleteRows("menu",$cond);
		return $deleted;
	}
	
	/* ############################################## ~*~ MENU OPTIONS ~*~ ############################################## */
	
	public function createMenuOption($fieldvalues)
	{
		$saved = $this->dbBean->InsertRow("menu", $fieldvalues);
		return $saved;
		
		
	}
	
	public function updateMenuOption($fieldvalues,$cond)
	{
		
		$edited = $this->dbBean->UpdateRows("menu", $fieldvalues, $cond);
		return $edited;
	}
	
	public function deleteMenuOption($id)
	{
		$cond= array("id" => $id);
		$deleted=$this->dbBean->DeleteRows("menu",$cond);
		return $deleted;
		
	}
	
	public function getMenuOptionParent($id){
		$query	=	"SELECT * FROM menu where id=".$id;
	 	if (! $this->dbBean->Query($query)) $this->dbBean->Kill();
		$result = $this->dbBean->RowArray(); 
		$parent_id=$result['parent_id'];
		return $parent_id;
	}

	public static function getMenuOptions($parent_id)
	{
		
		$resultarray=array();
		global $dbBean;
		$query="SELECT * FROM menu WHERE parent_id='".$parent_id."'";
		if (!$dbBean->QueryArray($query)) $dbBean->Kill();
		if ($dbBean->RowCount()>0)
		{
			$resultarray = $dbBean->RecordsArray(MYSQLI_ASSOC);
		}
		return $resultarray;
		
	}
	
	
}
?>
