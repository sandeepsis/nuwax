<?php
class Servicecategory {
    var $dbBean;
	var $general;
    
    function Servicecategory($dbBean) {
        $this->dbBean=$dbBean;
		$this->general=new General($this->dbBean);
	}
		
	public function addServicecategory($resizeImage,$temp_storage, $large_img_path, $large_img_width, $large_img_height, $thumb_img_path, $thumb_img_width, $thumb_img_height, $request)
	{
		if ( !is_array($request) || count($request) <= 0 ) {
			return false;
		}
		
		$fields	= array('categoryname','description', 'remark','is_deleted', 'date_added');
		$values	= array($request['categoryname'], $request['description'],$request['remark'],'0', date('Y-m-d H:i:s'));
			
		$cat_id = 0;
		if ( ( $cat_id = $this->dbBean->InsertRow('servicecategory', array_combine ( $fields, $values )) ) > 0 ) {
			
			$extension 	= pathinfo($_FILES['categoryimg']['name'],PATHINFO_EXTENSION);
			$fname 		= time().'.'.$extension;
			
			$filename = $this->general->checkFileName($large_img_path, $fname);
			$new_file_location = $temp_storage.$filename;
						
			if ( !move_uploaded_file($_FILES['categoryimg']['tmp_name'], $new_file_location) ) {
				return false;
			}
					
			$up = $resizeImage->resize($new_file_location, $large_img_width, $large_img_height, $this->general->getFileNameWithoutExtension($filename), $large_img_path, true);
	
			// If image is greather than to required size then resize
			$up = $resizeImage->resize($new_file_location, $thumb_img_width, $thumb_img_height, $this->general->getFileNameWithoutExtension($filename), $thumb_img_path, true);
	
			// Remove the copied file uploaded to producer
			unlink($new_file_location);			
			
			$fields	 = array('image');
			$values	 = array($filename);
			$cond	 = array('id' => $cat_id);
			$updated = $this->dbBean->UpdateRows('servicecategory', array_combine ( $fields, $values ), $cond);			
		}
		
		return $cat_id;
	}
	
	public function updateServicecategory($id,$old_file_name,$resizeImage,$temp_storage, $large_img_path, $large_img_width, $large_img_height, $thumb_img_path, $thumb_img_width, $thumb_img_height, $request)
	{
		if ( !is_array($request) || count($request) <= 0 ) {
			return false;
		}
		
		$fields	= array('categoryname','description', 'remark');
		$values	= array($request['categoryname'], $request['description'],$request['remark']);
		
		$filename = $old_file_name;
		if ( isset($_FILES['categoryimg']['name']) && $_FILES['categoryimg']['name'] != '' ) {
			$extension 	= pathinfo($_FILES['categoryimg']['name'],PATHINFO_EXTENSION);
			$fname 		= time().'.'.$extension;
			$filename = $this->general->checkFileName($large_img_path, $fname);
			$new_file_location = $temp_storage.$filename;
		
			if ( !($uploded = move_uploaded_file($_FILES['categoryimg']['tmp_name'], $new_file_location)) ) {
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
		
		if ( !$updated  = $this->dbBean->UpdateRows('servicecategory', array_combine ( $fields, $values ), $cond) ) {
			return false;
		}
		
		return $updated;
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
	
	public static function deleteServicecategory($large_img_path, $thumb_img_path,$idsToDelete)
	{
		global $dbBean;
		if ( count($idsToDelete) <= 0 ) {
			return false;
		}		
		
		$edited = false;
		foreach($idsToDelete as $ids){
			
			$s = Servicecategory::getServicecategoryById($ids);
			
			$image = $s->image;
			
			$cond		 = array("id" => $ids);
			$fieldvalues = array('is_deleted' => '1');
				
			if ( !($edited = $dbBean->UpdateRows("servicecategory",$fieldvalues, $cond)) ) {
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
}
?>
