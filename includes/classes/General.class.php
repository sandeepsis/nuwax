<?php
class General {
	var $dbBean;
	
	function General($dbBean) 
	{
		$this->dbBean=$dbBean;
	}
	/*
	*General Functions
	*/
	//Send E-Mail
	function sendMail($to,$subject,$matter,$header)
	{
		mail($to,$subject,$matter,$header);
		
	}
	
	function Encrypt($string) {//hash then encrypt a string
		$crypted = crypt(md5($string), md5($string));
		return $crypted;
	}

    function dateDiff($start, $end) {
        $start_ts = strtotime($start);
        $end_ts = strtotime($end);
        $diff = $end_ts - $start_ts;
        return round($diff / 86400);
    }

	//Expires Http Headers
	function expireHeader($offset=19800)
	{
	  	$expire = "Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
  		@header('Cache-Control: public, no-cache, must-revalidate');
  		@header($expire);
	}
    function sendRedirect($url)
    {
        header("Location: $url");
    }
	
	function redirectUrl($url,$msg1)
    {
		$url=(empty($url)?'../index.php':$url);
		$sendurl=$url."?msg=".$msg1;
       	header("Location: $sendurl");
    }
    function redirect($uri = '', $method = 'location')
    {
        switch($method)
        {
            case 'refresh2'    : header("Refresh:0;url=".($uri));
                break;
            case 'refresh'    :

            echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL='.($uri).'">';
                break;
            default            : header("Location: ".($uri));
                break;
        }
        exit;
    }
	
	function showJSMessage($message)
    {
        echo '<script language="javascript" type="text/javascript">'.
        'alert("'.$message.'");'.
        '</script>';
    }
	

	function generateId($length, $type = 'ALPHANUMERIC') {
		if($type == 'ALPHANUMERIC')
        	$chars = "12345CDEFGHI67890NOPQRSTU01492VWXYZ43210XYZFGH98765ABCDEF83574GHIJKLM09876QRSTUV54321";
		else if($type == 'NUMERIC')
        	$chars = "1234567890987654321678905432101928374651029384756162738495061728394055432167890";
        $id = "";
        while (strlen($id)<$length) {
            $id .= $chars{mt_rand(0,strlen($chars))};
        }
        return $id;
    }
	
	function padString($str, $length, $padWith, $padType){
		$id = str_pad($str, $length, $padWith, $padType);
		return $id;
	}
	
	function wordWrap($text, $len = 80){
		$text = wordwrap(trim($text), $len, "\n", 1);
		return $text;
	}
	
	function subStr($text, $len){
		if(empty($len)){
			$len=870;
		}
		
		if (get_magic_quotes_gpc()){
		  $text = trim(stripslashes($text));
		}else{
		  $text = trim($text);
		} 
		
		if(strlen($text)>$len){
			$text = substr($text, 0, $len)."...";	
					
		}
		$text = '<span style="text-align:justify;">'.$this->wordWrap($text).'</span>';	
		return $text;
	}
	
	function stripTags($text){
		$text = strip_tags(trim($text));
		return $text;
	}
	
	function getExtension($file){
		return substr(strrchr($file, "."), 1);
	}
	
	function getFileNameWithoutExtension($filename){
		return strtolower(substr($filename, 0, strrpos($filename, ".")));
	}
	
	function makeDirectory($basePath, $dirName){
		if(!is_dir($basePath.$dirName)){
			mkdir($basePath.$dirName);
			chmod($basePath.$dirName, 0777);
			return true;
		}else{
			return false;
		}
	}
	
	function getCurrentDate(){
		return gmdate('Y-m-d H:i:s',time()+19800);
	}
	
	
	
	function alertMsg($message){
		if(isset($message) && $message!=''){
			$this->showJSMessage($message);		
		}
	}	
	
	function suffixNumber($number)
	{
		if ( is_numeric( $number ) && 0 <> $number )
		{
			if ( in_array( $number % 100, range( 11, 13 ) ) )
			{
				return $number . 'th';
			}
			switch ( $number % 10 )
			{
				case 1: return $number . 'st';
				case 2: return $number . 'nd';
				case 3: return $number . 'rd';
				default: return $number . 'th';
			}
		}
		return $number;
	}
	
	public function echoStr($str){
		if (get_magic_quotes_gpc()){
		  echo trim(stripslashes($str));
		}else{
		  echo trim($str);
		} 
	}
	
	public function getBaseName($str){
		if (get_magic_quotes_gpc()){
			$path_parts = pathinfo(trim(stripslashes($str)));
		  	echo $path_parts['dirname'].'/'.basename($path_parts['basename'],".php");
		}else{
			$path_parts = pathinfo(trim($str));
		  	echo $path_parts['dirname'].'/'.basename($path_parts['basename'],".php");
		} 
	}
	
/*******************************************HTACCESS***************************************************/

		public function writeUrl($file, $htaccstr, $currStr = '') //$currStr is URL need to be updated.
		{
		
			if(!isset($currStr) || $currStr == '')
			{
				file_put_contents($file, $htaccstr, FILE_APPEND);  
			}
			else
			{
				$this->delLine($file, $currStr);
				file_put_contents($file, $htaccstr, FILE_APPEND);  
			}
		}
		
		
		
/******************************************************************************************************/		
			
		public function delLine($filename, $text_to_delete)
		{
			$file_array = array();
			$file = fopen($filename, 'rt');
			if($file)
			{
				while(!feof($file))
				{
					$val = fgets($file);
					if(is_string($val))
					{
						array_push($file_array, $val);
					}	
				}	
				fclose($file);
			}
			
			
			// delete from file
			for($i = 0; $i < count($file_array); $i++)
			{
				if(strstr($file_array[$i], $text_to_delete))
				{
				  if(trim($file_array[$i]) == trim($text_to_delete))
				  { 
					$file_array[$i] = '';
				  } 	
				}
			}
			
			// write it back to the file
			$file_write = fopen($filename, 'wt');	
			if($file_write)
			{
				fwrite($file_write, implode("", $file_array));
				fclose($file_write);
			}
		}

/********************************************************************************************************************/	
	
		public function getPageHeading($menu_id){
			$menu_id = (empty($menu_id)?$_SESSION['menu_id']:$menu_id);
			$value['MENU']=$value['SUBMENU']="";
			if(!empty($menu_id)){
				$_SESSION['menu_id']=$menu_id;
			}
			
			$query="SELECT * FROM  menu WHERE id=".$_SESSION['menu_id'];
			if (! $this->dbBean->Query($query)) $this->dbBean->Kill();
			if ($this->dbBean->RowCount()>0)
			{
				$row = $this->dbBean->RowArray();
				$value['SUBMENU']=$row['name'];
				if(!empty($row['parent_id']) || $row['parent_id']!=0)
				{
					$qry1="SELECT * FROM  menu WHERE id=".$row['parent_id'];
					if (! $this->dbBean->Query($qry1)) $this->dbBean->Kill();
					$row1=$this->dbBean->RowArray();
					$value['MENU']=$row1['name'];
				}
				
			}
			
			return $value;
		}
		
/********************************************************************************************************************/	
		

		
		public function dateFormat($format,$date)
		{
			return gmdate($format,strtotime($date));
		}
		

//******************************************************************************************************************
		

	public function getIPaddr() 
	{
		if (isset($_SERVER)) 
		{
			 if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) 
			 {
				 $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			 } 
			 elseif (isset($_SERVER["HTTP_CLIENT_IP"])) 
			 {
				$realip = $_SERVER["HTTP_CLIENT_IP"];
			 } 
			 else 
			 {
				$realip = $_SERVER["REMOTE_ADDR"];
			 }
		} 
		else 
		{
			 if ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) 
			 {
				$realip = getenv( 'HTTP_X_FORWARDED_FOR' );
			 } 
			 elseif ( getenv( 'HTTP_CLIENT_IP' ) ) 
			 {
				$realip = getenv( 'HTTP_CLIENT_IP' );
			 } 
			 else 
			 {
				$realip = getenv( 'REMOTE_ADDR' );
			 }
		}
		return $realip; 
	}


//*********************************************************************************************************************
 public function addLogAction($userID, $action,$recId,$sec,$user_level) 
 {
   		$ip = $this->getIPaddr();

		
		$fieldvalues = array('userID'=>$userID,'action'=>$action,'recordID'=>$recId,'siteSection'=>$sec,'ip'=>$ip,'userLevel'=>$user_level);
		$saved = $this->dbBean->InsertRow("data_log", $fieldvalues);
		
		
}
//*********************************************************************************************************************
		
	public function ByteSize($bytes)  
    { 
		$size = $bytes / 1024; 
		if($size < 1024) 
			{ 
			$size = number_format($size, 2); 
			$size .= ' KB'; 
			}  
		else  
			{ 
			if($size / 1024 < 1024)  
				{ 
				$size = number_format($size / 1024, 2); 
				$size .= ' MB'; 
				}  
			else if ($size / 1024 / 1024 < 1024)   
				{ 
				$size = number_format($size / 1024 / 1024, 2); 
				$size .= ' GB'; 
				}  
			} 
		return $size; 
    } 
	
//*********************************************************************************************************************	

  function create_password ($length)
  {

    // start with a blank password
    $password = "";

    // define possible characters - any character in this string can be
    // picked for use in the password, so if you want to put vowels back in
    // or add special characters such as exclamation marks, this is where
    // you should do it
    $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";

    // we refer to the length of $possible a few times, so let's grab it now
    $maxlength = strlen($possible);
  
    // check for length overflow and truncate if necessary
    if ($length > $maxlength) {
      $length = $maxlength;
    }
	
    // set up a counter for how many characters are in the password so far
    $i = 0; 
    
    // add random characters to $password until $length is reached
    while ($i < $length) { 

      // pick a random character from the possible ones
      $char = substr($possible, mt_rand(0, $maxlength-1), 1);
        
      // have we already used this character in $password?
      if (!strstr($password, $char)) { 
        // no, so it's OK to add it onto the end of whatever we've already got...
        $password .= $char;
        // ... and increase the counter by one
        $i++;
      }

    }

    // done!
    return $password;

  }
 //*********************************************************************************************************************

	function getdepartment($id)
	{
			$value='';
			$query="SELECT * FROM  departments WHERE id=".$id;
			if (! $this->dbBean->Query($query)) $this->dbBean->Kill();
			if ($this->dbBean->RowCount()>0)
			{
				$row = $this->dbBean->RowArray();
				$value=$row['name'];
				
			}
			
			return $value;		
	}

	static function getalldepartments()
	{
		$resultarray=array();
		global $dbBean;
		$query="SELECT id,name FROM departments WHERE 1";
		if (!$dbBean->QueryArray($query)) $dbBean->Kill();
		if ($dbBean->RowCount()>0)
		{
			$resultarray = $dbBean->RecordsArray(MYSQLI_ASSOC);
		}
		return $resultarray;
			
	}

	function checkFileName($url,$fname){
		$fname = preg_replace('/[^\w\._]+/', '_', $fname);
		$fname=strtolower($fname);
		if(file_exists($url.$fname)){
			$ext = strrpos($fname, '.');
			$fileName_a = substr($fname, 0, $ext);
			$fileName_b = substr($fname, $ext);
			$count = 1;
			while (file_exists($url . $fileName_a . '_' . $count . $fileName_b))
				$count++;
			$fname = $fileName_a . '_' . $count . $fileName_b;
		}
		return $fname;
	}

} //end class
?>