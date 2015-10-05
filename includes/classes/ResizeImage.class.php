<?php

class ResizeImage {



	var $image_to_resize;

	var $new_width;

	var $new_height;

	var $ratio;

	var $new_image_name;

	var $save_folder;

	var $image_type;

	var $image;

	var $new_image_ext;



	function resize($image_to_resize, $new_width, $new_height, $new_image_name, $save_folder, $ratio=true)

	{

		$this->image_to_resize = $image_to_resize;

		$this->new_width = $new_width;

		$this->new_height = $new_height;

		$this->ratio = $ratio;

		$this->new_image_name = $new_image_name;

		$this->save_folder = $save_folder;

		

		if(!file_exists($this->image_to_resize))

		{

		  exit("File ".$this->image_to_resize." does not exist.");

		}

		

		$this->load($this->image_to_resize);
		
		if ( $this->getWidth() <= $this->new_width && $this->getHeight() <= $this->new_height ) {
			// If image is less than or equal to required size copy source image to destination
			copy( $image_to_resize, $this->save_folder.$this->new_image_name.'.'.$this->new_image_ext );
		}
		else {
			if($this->new_width >= $this->getWidth() && $this->new_height >= $this->getHeight()){
	
				$this->resizeImg($this->getWidth(),$this->getHeight());
	
			}else if($this->new_width <= $this->getWidth() && $this->new_height <= $this->getHeight()){
	
				if(($this->getWidth() / $this->getHeight()) > ($this->new_width / $this->new_height)){	
	
					$this->resizeToWidth($this->new_width);	
	
				}else if(($this->getWidth() / $this->getHeight()) < ($this->new_width / $this->new_height)){
	
					$this->resizeToHeight($this->new_height);	
	
				}else{
	
					$this->resizeImg($this->new_width,$this->new_height);
	
				}
	
			}else if($this->new_width > $this->getWidth() && $this->new_height < $this->getHeight()){
	
				$this->resizeToHeight($this->new_height);
	
			}else if($this->new_width < $this->getWidth() && $this->new_height > $this->getHeight()){
	
				$this->resizeToWidth($this->new_width);
	
			}
		}

		$this->save($this->save_folder.$this->new_image_name.'.'.$this->new_image_ext, $this->image_type); 

		//$this->save($this->save_folder.$this->new_image_name.'.jpg', $this->image_type); 

		return $this->new_image_ext;

	}

	

	

	 

	function load($filename) {

	  $image_info = getimagesize($filename);

	  $this->image_type = $image_info[2];	  

	  if( $this->image_type == IMAGETYPE_JPEG ) {

	  	if(strtolower(substr(strrchr($this->image_to_resize, "."), 1)) == 'jpeg')

			$this->new_image_ext = 'jpeg';

		else

			$this->new_image_ext = 'jpg';

		$this->image = imagecreatefromjpeg($filename);

	  } elseif( $this->image_type == IMAGETYPE_GIF ) {

	  	 $this->new_image_ext = 'gif';	

		 $this->image = imagecreatefromgif($filename);

	  } elseif( $this->image_type == IMAGETYPE_PNG ) {

	     $this->new_image_ext = 'png';

		 $this->image = imagecreatefrompng($filename);

		 

	  } else {

		 $this->new_image_ext = 'jpg';

		 $this->image = imagecreatefromjpeg($filename);

	  }	  

	}

	function save($filename, $image_type=IMAGETYPE_JPEG, $compression=100, $permissions=null) {

	  if( $image_type == IMAGETYPE_JPEG ) {

		 imagejpeg($this->image,$filename,$compression);

	  } elseif( $image_type == IMAGETYPE_GIF ) {

		 imagegif($this->image,$filename);         

	  } elseif( $image_type == IMAGETYPE_PNG ) {		

		 imagepng($this->image,$filename);

	  }   

	  if( $permissions != null) {

		 chmod($filename,$permissions);

	  }

	}

	function output($image_type=IMAGETYPE_JPEG) {

	  if( $image_type == IMAGETYPE_JPEG ) {

		 imagejpeg($this->image);

	  } elseif( $image_type == IMAGETYPE_GIF ) {

		 imagegif($this->image);         

	  } elseif( $image_type == IMAGETYPE_PNG ) {

		 imagepng($this->image);

	  }   

	}

	function getWidth() {

	  return imagesx($this->image);

	}

	function getHeight() {

	  return imagesy($this->image);

	}

	function resizeToHeight($height) {

	  $ratio = $height / $this->getHeight();

	  $width = $this->getWidth() * $ratio;

	  $this->resizeImg($width,$height);

	}

	function resizeToWidth($width) {

	  $ratio = $width / $this->getWidth();

	  $height = $this->getheight() * $ratio;

	  $this->resizeImg($width,$height);

	}

	function scale($scale) {

	  $width = $this->getWidth() * $scale/100;

	  $height = $this->getheight() * $scale/100; 

	  $this->resizeImg($width,$height);

	}

	function resizeImg($width,$height) {

	  $new_image = imagecreatetruecolor($width, $height);

	

		if ( ($this->image_type == IMAGETYPE_GIF) || ($this->image_type == IMAGETYPE_PNG) ) {			

		  $transparency = imagecolortransparent($this->image);

	

		  if ($transparency >= 0) {

			$transparent_color  = imagecolorsforindex($this->image, $trnprt_indx);

			$transparency       = imagecolorallocate($new_image, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);

			imagefill($new_image, 0, 0, $transparency);

			imagecolortransparent($new_image, $transparency);

		  }elseif ($this->image_type == IMAGETYPE_PNG) {		  	

			imagealphablending($new_image, false);

			$color = imagecolorallocatealpha($new_image, 0, 0, 0, 127);

			imagefill($new_image, 0, 0, $color);

			imagesavealpha($new_image, true);

		  }

		}

	

	  imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());

	  $this->image = $new_image;   

	}     

}

?>