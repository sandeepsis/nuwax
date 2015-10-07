<?php
class Staff {
    var $dbBean;
	var $general;
    
    function Staff($dbBean) {
        $this->dbBean=$dbBean;
		$this->general=new General($this->dbBean);
	}
		
	public function addStaffmember($resizeImage,$temp_storage, $large_img_path, $large_img_width, $large_img_height, $thumb_img_path, $thumb_img_width, $thumb_img_height, $request)
	{	
		if ( !is_array($request) || count($request) <= 0 ) {
			return false;
		}
		
		$fields	= array('serviceid','name','contactno', 'email','address','is_deleted', 'date_added');
		$values	= array($request['service'],$request['name'], $request['contactno'],$request['emailaddress'],$request['address'],'0', date('Y-m-d H:i:s'));
			
		$staff_id = 0;
		if ( ( $staff_id = $this->dbBean->InsertRow('staff', array_combine ( $fields, $values )) ) > 0 ) {
			
			$extension 	= pathinfo($_FILES['staffimg']['name'],PATHINFO_EXTENSION);
			$fname 		= time().'.'.$extension;
			
			$filename = $this->general->checkFileName($large_img_path, $fname);
			$new_file_location = $temp_storage.$filename;
						
			if ( !move_uploaded_file($_FILES['staffimg']['tmp_name'], $new_file_location) ) {
				return false;
			}
					
			$up = $resizeImage->resize($new_file_location, $large_img_width, $large_img_height, $this->general->getFileNameWithoutExtension($filename), $large_img_path, true);
	
			// If image is greather than to required size then resize
			$up = $resizeImage->resize($new_file_location, $thumb_img_width, $thumb_img_height, $this->general->getFileNameWithoutExtension($filename), $thumb_img_path, true);
	
			// Remove the copied file uploaded to producer
			unlink($new_file_location);			
			
			$fields	 = array('image');
			$values	 = array($filename);
			$cond	 = array('id' => $staff_id);
			$updated = $this->dbBean->UpdateRows('staff', array_combine ( $fields, $values ), $cond);
			
			for($i=0;$i<count($request['assignservice']);$i++)
			{
				if ($request['assignservice'][$i] !="" && $request['stafflevel'][$i] != "") {
					$assignservice = $request['assignservice'][$i];
					$assignstafflevel = $request['stafflevel'][$i];
					
					$fields	= array('staffid','serviceid','stafflevelid');
					$values	= array($staff_id,$assignservice, $assignstafflevel);
						
					$this->dbBean->InsertRow('staffservices', array_combine ( $fields, $values ));
				}
			}
		}
		
		return $staff_id;
	}
	
	public function updateStaffmember($id,$old_file_name,$resizeImage,$temp_storage, $large_img_path, $large_img_width, $large_img_height, $thumb_img_path, $thumb_img_width, $thumb_img_height, $request)
	{	
		if ( !is_array($request) || count($request) <= 0 ) {
			return false;
		}
		
		$fields	= array('serviceid','name','contactno', 'email','address');
		$values	= array($request['service'],$request['name'], $request['contactno'],$request['emailaddress'],$request['address']);
		
		$filename = $old_file_name;
		if ( isset($_FILES['staffimg']['name']) && $_FILES['staffimg']['name'] != '' ) {
			$extension 	= pathinfo($_FILES['staffimg']['name'],PATHINFO_EXTENSION);
			$fname 		= time().'.'.$extension;
			$filename = $this->general->checkFileName($large_img_path, $fname);
			$new_file_location = $temp_storage.$filename;
		
			if ( !($uploded = move_uploaded_file($_FILES['staffimg']['tmp_name'], $new_file_location)) ) {
				return false;
			}
		
			$up = $resizeImage->resize($new_file_location, $large_img_width, $large_img_height, $this->general->getFileNameWithoutExtension($filename), $large_img_path, true);
		
			// If image is greather than to required size then resize
			$up = $resizeImage->resize($new_file_location, $thumb_img_width, $thumb_img_height, $this->general->getFileNameWithoutExtension($filename), $thumb_img_path, true);
		
			// Remove the copied file uploaded to producer
			unlink($new_file_location);
			
			if ( $old_file_name != '' ) {
				if ( file_exists( $large_img_path.$old_file_name ) ) {
					unlink($large_img_path.$old_file_name);
				}
				if ( file_exists( $thumb_img_path.$old_file_name ) ) {
					unlink($thumb_img_path.$old_file_name);
				}
			}
		}
		
		$fields[] = 'image';
		$values[] = $filename;
		$cond	  = array('id' => $id);
		
		if ( !$updated  = $this->dbBean->UpdateRows('staff', array_combine ( $fields, $values ), $cond) ) {
			return false;
		}
		
		for($i=0;$i<count($request['assignservice']);$i++)
		{
			if ($request['assignservice'][$i] !="" && $request['stafflevel'][$i] != "") {
				$assignservice = $request['assignservice'][$i];
				$assignstafflevel = $request['stafflevel'][$i];
					
				$sid = $request['staffserviceid'][$i];
				
				if ($sid != "") {
		
					$fieldvalues = array('serviceid' => $assignservice,'stafflevelid' => $assignstafflevel);
		
					$cond	  = array('id' => $sid);
					$this->dbBean->UpdateRows('staffservices', $fieldvalues, $cond);
				} else {
					$fieldvalues = array('staffid'=>$id ,'serviceid' => $assignservice,'stafflevelid' => $assignstafflevel);
					
					$this->dbBean->InsertRow('staffservices', $fieldvalues);
				}
				
			}
		}
		
		$deletehdnarr = explode(",", $request['hdndelete']);
		if (count($deletehdnarr) > 0) {
			for($t=0;$t<=count($deletehdnarr);$t++)
			{
				$cond= array("id" => $deletehdnarr[$t]);
				$deleted=$this->dbBean->DeleteRows("staffservices", $cond);
			}
		}
		
		return $updated;
	}

	public static function getStaffmembers()
	{
		$resultarray=array();
		global $dbBean;
		
		$query="SELECT *,(select servicename from services where id=serviceid) servicename FROM staff where is_deleted=0 order by id desc";
		
		if (!$dbBean->QueryArray($query)) $dbBean->Kill();
		if ($dbBean->RowCount()>0)
		{
			$resultarray = $dbBean->RecordsArray(MYSQLI_ASSOC);
		}
		return $resultarray;		
	}
	
	public static function getStaffmemberById($id=0)
	{
		$resultarray=array();
		global $dbBean;
		$query="SELECT * FROM staff WHERE is_deleted=0 and id=" . intval($id);
		
		if (! $resultarray = $dbBean->QuerySingleRow($query)) $dbBean->Kill();
		return $resultarray;
		
	}	
	
	public static function deleteStaffmember($large_img_path, $thumb_img_path,$idsToDelete)
	{
		global $dbBean;
		if ( count($idsToDelete) <= 0 ) {
			return false;
		}		
		
		$edited = false;
		foreach($idsToDelete as $ids){
			
			$s = Staff::getStaffmemberById($ids);
			
			$image = $s->image;
			
			$cond		 = array("id" => $ids);
			$fieldvalues = array('is_deleted' => '1');
				
			if ( !($edited = $dbBean->UpdateRows("staff",$fieldvalues, $cond)) ) {
				break;
			}
			if ( $image != '' ) {
				if ( file_exists( $large_img_path.$image ) ) {
					unlink($large_img_path.$image);
				}
				if ( file_exists( $thumb_img_path.$image) ) {
					unlink($thumb_img_path.$image);
				}
			}
		}
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
	
	public static function getStafflevel()
	{
		$resultarray=array();
		global $dbBean;
	
		$query="SELECT * FROM stafflevel where is_deleted=0 order by id asc";
	
		if (!$dbBean->QueryArray($query)) $dbBean->Kill();
		if ($dbBean->RowCount()>0)
		{
			$resultarray = $dbBean->RecordsArray(MYSQLI_ASSOC);
		}
		return $resultarray;
	}
	
	public static function getStaffservicesbyStaffid($id)
	{
		$resultarray=array();
		global $dbBean;
	
		$query="SELECT * FROM staffservices where staffid=".intval($id);
	
		$w = $dbBean->QueryArray($query);
		
		if ($dbBean->RowCount()>0)
		{
			$resultarray = $dbBean->RecordsArray(MYSQLI_ASSOC);
		}
		return $resultarray;
	}
}
?>
