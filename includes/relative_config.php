<?php
	date_default_timezone_set('Asia/Hong_Kong');
	
	define('ADMIN_TITLE','Nuwax');

	/*   URL definitions */
	define('SITE_FOLDER','nuwax');
	define('ADMIN_FOLDER','backend');
	define('SERVER_URL','http://salil-pc/');
	//define('SERVER_URL','http://wl02/sis/');
	
	define('PROVIDER_URL','http://karmatechnologies.asia/');
	define('SITE_URL',SERVER_URL.SITE_FOLDER.'/');   
	define('ADMIN_URL',SITE_URL.ADMIN_FOLDER);
	
	/*   Path definitions */
	define('SITE_ABS_PATH', $_SERVER['DOCUMENT_ROOT'].'sis/'.SITE_FOLDER.'/');
	define('ADMIN_ABS_PATH', SITE_ABS_PATH.ADMIN_FOLDER.'/');
	
	define('UPLOAD_PATH',SITE_ABS_PATH.'content/');
	define('UPLOAD_URL',SITE_URL.'content/');
	
	define('TEMP_STORAGE', UPLOAD_PATH.'temp/');
	
	/* Service category images path */
	define('SERVICECAT_WIDTH', 1920);
	define('SERVICECAT_HEIGHT', 550);
	define('SERVICECAT_IMG_THUMB_WIDTH', 220);
	define('SERVICECAT_IMG_THUMB_HEIGHT', 63);
	define('SERVICECAT', 'servicecategory/');
	define('SERVICECAT_LARGE_IMG', SERVICECAT.'large/');
	define('SERVICECAT_THUMB_IMG', SERVICECAT.'thumb/');
	
	/* Staff members images path */
	define('STAFF_WIDTH', 1920);
	define('STAFF_HEIGHT', 550);
	define('STAFF_IMG_THUMB_WIDTH', 220);
	define('STAFF_IMG_THUMB_HEIGHT', 63);
	define('STAFF', 'staff/');
	define('STAFF_LARGE_IMG', STAFF.'large/');
	define('STAFF_THUMB_IMG', STAFF.'thumb/');
	
	/* Staff members images path */
	define('VOUCHER_NO_CONST', 1000);
	
	/* mail constants */
	define("SMPT_EMAIL", "youremail@gmail.com");
	define("SMPT_PASS", "yourpassword");
?>
