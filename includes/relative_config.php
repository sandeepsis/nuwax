<?php
	date_default_timezone_set('Asia/Hong_Kong');
	
	define('ADMIN_TITLE','Nuwax');

	/*   URL definitions */
	define('SITE_FOLDER','nuwax');   
	define('ADMIN_FOLDER','backend');
	//define('SERVER_URL','http://salil-pc/');
	define('SERVER_URL','http://wl02/sis/');
	
	define('PROVIDER_URL','http://karmatechnologies.asia/');
	define('SITE_URL',SERVER_URL.SITE_FOLDER.'/');   
	define('ADMIN_URL',SITE_URL.ADMIN_FOLDER);
	
	/*   Path definitions */
	define('SITE_ABS_PATH', $_SERVER['DOCUMENT_ROOT'].'/'.SITE_FOLDER.'/');
	define('ADMIN_ABS_PATH', SITE_ABS_PATH.ADMIN_FOLDER.'/');
	
	define('UPLOAD_PATH',SITE_ABS_PATH.'content/');
	define('UPLOAD_URL',SITE_URL.'content/');
	
	define('ADMIN_IMG',ADMIN_ABS_PATH.'images/');
	define('ADMIN_ICON_THUMBS',ADMIN_IMG.'icons/');
	define('ADMIN_ICON_IMAGES',ADMIN_URL.'/images/icons/');
	
	define('ADMIN_ICON_IMAGE_WIDTH',100);
	define('ADMIN_ICON_IMAGE_HEIGHT',100);
	define('ADMIN_ICON_THUMB_WIDTH',32);
	define('ADMIN_ICON_THUMB_HEIGHT',32);
	
	define('TEMP_STORAGE', UPLOAD_PATH.'temp/');
	
	define('SLIDE_WIDTH', 1920);
	define('SLIDE_HEIGHT', 550);
	define('SLIDE_IMG_THUMB_WIDTH', 220);
	define('SLIDE_IMG_THUMB_HEIGHT', 63);
	define('SLIDE', 'slide/');
	define('SLIDE_LARGE_IMG', SLIDE.'large/');
	define('SLIDE_THUMB_IMG', SLIDE.'thumb/');
	define('SLIDE_VIDEO', SLIDE.'video/');
	
	define('SPECIAL_OFFER_WIDTH', 207);
	define('SPECIAL_OFFER_HEIGHT', 236);
	define('SPECIAL_OFFER_THUMB_WIDTH', 100);
	define('SPECIAL_OFFER_THUMB_HEIGHT', 114);
	define('SPECIAL_OFFER', 'special_offer/');
	define('SPECIAL_OFFER_LARGE_IMG', SPECIAL_OFFER.'large/');
	define('SPECIAL_OFFER_THUMB_IMG', SPECIAL_OFFER.'thumb/');
	
	define('DEPARTMENT_WIDTH', 232);
	define('DEPARTMENT_HEIGHT', 173);
	define('DEPARTMENT_THUMB_WIDTH', 100);
	define('DEPARTMENT_THUMB_HEIGHT', 75);
	define('DEPARTMENT', 'department/');
	define('DEPARTMENT_LARGE_IMG', DEPARTMENT.'large/');
	define('DEPARTMENT_THUMB_IMG', DEPARTMENT.'thumb/');

	
	define('HOME_TREND_WIDTH', 347);
	define('HOME_TREND_HEIGHT', 237);
	define('HOME_TREND_THUMB_WIDTH', 100);
	define('HOME_TREND_THUMB_HEIGHT', 68);
	define('HOME_TREND', 'home_trend/');
	define('HOME_TREND_LARGE_IMG', HOME_TREND.'large/');
	define('HOME_TREND_THUMB_IMG', HOME_TREND.'thumb/');
	
	define('HOME_BOTTOM_TREND_WIDTH', 294);
	define('HOME_BOTTOM_TREND_HEIGHT', 220);
	define('HOME_BOTTOM_TREND_THUMB_WIDTH', 100);
	define('HOME_BOTTOM_TREND_THUMB_HEIGHT', 75);
	define('HOME_BOTTOM_TREND', 'home_bottom_trend/');
	define('HOME_BOTTOM_TREND_LARGE_IMG', HOME_BOTTOM_TREND.'large/');
	define('HOME_BOTTOM_TREND_THUMB_IMG', HOME_BOTTOM_TREND.'thumb/');
	
	define('SERVICE_WIDTH', 205);
	define('SERVICE_HEIGHT', 205);
	define('SERVICE_THUMB_WIDTH', 100);
	define('SERVICE_THUMB_HEIGHT', 100);
	define('SERVICE', 'service/');
	define('SERVICE_LARGE_IMG', SERVICE.'large/');
	define('SERVICE_THUMB_IMG', SERVICE.'thumb/');
	define('SERVICE_VIDEO', SERVICE.'video/');
	
	define('HOW_TO', 'how_to/');
	define('HOW_TO_VIDEO', HOW_TO.'video/');
	
	define('SELL_WIDTH', 205);
	define('SELL_HEIGHT', 205);
	define('SELL_THUMB_WIDTH', 100);
	define('SELL_THUMB_HEIGHT', 100);
	define('SELL', 'sell/');
	define('SELL_LARGE_IMG', SELL.'large/');
	define('SELL_THUMB_IMG', SELL.'thumb/');
	define('SELL_VIDEO', SELL.'video/');
	
	/* mail constants */
	define("SMPT_EMAIL", "youruser@gmail.com");
	define("SMPT_PASS", "yourpassword");
?>
