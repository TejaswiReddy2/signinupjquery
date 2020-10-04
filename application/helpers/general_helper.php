<?php
// make friendly url using any string
if (!function_exists('friendlyURL')) {
	function friendlyURL($inputString){
		$url = strtolower($inputString);
		$patterns = $replacements = array();
		$patterns[0] = '/(&amp;|&)/i';
		$replacements[0] = '-and-';
		$patterns[1] = '/[^a-zA-Z01-9]/i';
		$replacements[1] = '-';
		$patterns[2] = '/(-+)/i';
		$replacements[2] = '-';
		$patterns[3] = '/(-$|^-)/i';
		$replacements[3] = '';
		$url = preg_replace($patterns, $replacements, $url);
	return $url;
	}
}

if (!function_exists('sanitizedNumber')) {
	function replaceSpecialCharInUrl($str)
	{
		$find     =   array("\t","\n"," ");
		$replace  =   array("","","");
		return str_replace($find,$replace,$str);
	}
}

// sanitized number :  function auto remove unwanted character form given value 
if (!function_exists('sanitizedNumber')) {
	function sanitizedNumber($_input) 
	{ 
		return (float) preg_replace('/[^0-9.]*/','',$_input); 
	}
}

// sanitized filename :  function auto remove unwanted character form given file name
if (!function_exists('sanitizedFilename')) {
	function sanitizedFilename($filename){
		$sanitized = preg_replace('/[^a-zA-Z0-9-_\.]/','', $filename);
		return $sanitized;
	}
}

// check, is file exist in folder or not
if (!function_exists('fileExist')) {
	function fileExist($source='', $file='', $defalut=''){
		if(!$file) return base_url().$source.$defalut;
			
		if(file_exists(FCPATH.$source.$file)):
			return base_url().$source.$file;
		else:
			return base_url().$source.$defalut;
		endif;
	}
}

// check, is file exist in folder or not
if (!function_exists('checkFileExist')) {
	function checkFileExist($source=''){
		if(file_exists(FCPATH.$source)):
			return base_url().$source;
		else:
			return false;
		endif;
	}
}

if (!function_exists('myExplode')) {
	function myExplode($string){
		if($string):
		$array = explode(",",$string);
		// print_r($array);die;
			return $array;
			
		else:
			return '';
		endif;
	}
}

/*
 * Show correct image
 */
if (!function_exists('correctImage')) {
	function correctImage($imageurl, $type = '') {
		if($type=='original'):
			$imageurl = str_replace('/thumb','',$imageurl);
		elseif($type):
			$imageurl = str_replace('thumb',$type,$imageurl);
		endif;
		return trim($imageurl);
	}
}

/*
 * Encription
 */
if (!function_exists('manojEncript')) {
	function manojEncript($text) {
		$text	=	('MANOJ').$text.('KUMAR');
		return	base64_encode($text);
	}
}

/*
 * Decription
 */
if (!function_exists('manojDecript')) {
	function manojDecript($text) { 
		$text	=	base64_decode($text);
		$text	=	str_replace(('MANOJ'),'',$text);
		$text	=	str_replace(('KUMAR'),'',$text);
		return $text;
	}
}

/*
 * Word Limiter
 */
define("STRING_DELIMITER", " ");
if (!function_exists('wordLimiter')){
	function wordLimiter($str, $limit = 10){
		$str = strip_tags($str); 
		if (stripos($str, STRING_DELIMITER)){
			$ex_str = explode(STRING_DELIMITER, $str);
			if (count($ex_str) > $limit){
				for ($i = 0; $i < $limit; $i++){
					$str_s.=$ex_str[$i].'&nbsp;';
				}
				return $str_s.'...';
			}else{
				return $str;
			}
		}else{
			return $str;
		}
	}
}

if (!function_exists('currentDateTime')) {
	function currentDateTime() {
		date_default_timezone_set('Africa/Lagos');
		return date("Y-m-d H:i:s");
	}
}

if (!function_exists('signupDateTime')) {
	function signupDateTime() {
		date_default_timezone_set('Africa/Lagos');
		return date("Y-m-d");
	}
}

if (!function_exists('currentIp')) {
	function currentIp() {
		return $_SERVER['REMOTE_ADDR']=='::1'?'192.168.1.100':$_SERVER['REMOTE_ADDR'];
	}
}

if (!function_exists('generateRandomString')) {
	function generateRandomString($length = 10, $mode="sln") {
		$characters = "";
		if(strpos($mode,"s")!==false){$characters.="abcdefghijklmnopqrstuvwxyz";}
		if(strpos($mode,"l")!==false){$characters.="ABCDEFGHIJKLMNOPQRSTUVWXYZ";}
		if(strpos($mode,"n")!==false){$characters.="0123456789";}
	
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
}	

if (!function_exists('checkFloat')) {
	function checkFloat($s_value) {
		$regex = '/^\s*[+\-]?(?:\d+(?:\.\d*)?|\.\d+)\s*$/';
		return preg_match($regex, $s_value);
	}
}	

/*
 * Get session data
 */
if (!function_exists('sessionData')) {
	function sessionData($text) {
		$CIOBJ = & get_instance();
		return	$CIOBJ->session->userdata($text);
	}
}

/*
 * Get correct link
 */
if (!function_exists('correctLink')) {
	function correctLink($text='',$link='') {
		return	sessionData($text)?sessionData($text):$link;
	}
}

/*
 * Get referral code
 */
if (!function_exists('generateReferral')) {
	function generateReferral($limit5) {
		$characters = "0123456789";	
		$randomString	=	substr(str_shuffle($characters), 0, $limit5);
		//$charactersLength = strlen($characters);
		//$randomString = '';
		
		/*for ($i = 0; $i < 32; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}*/
		return $randomString;
	}
}

/*
 * Get full url
 */
 if (!function_exists('currentFullUrl')) {
	function currentFullUrl()
	{
		$CI =& get_instance();
		$url = $CI->config->site_url($CI->uri->uri_string());
		return $_SERVER['QUERY_STRING'] ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;
	}
}

if (!function_exists('generateUniqueId')) {
	function generateUniqueId($currentId = 1) {
		$newId		=	1000000000+$currentId;
		return $newId;
	}
}

if (!function_exists('generateToken')) {
	function generateToken() {
		$characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";	
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < 32; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
}

/*
 * Change ddmmyy to yymmdd
 */
if (!function_exists('DDMMYYtoYYMMDD')) {
	function DDMMYYtoYYMMDD($date) {
		if($date):
			$datedata			=	explode('-',$date);
			$datedata			=	$datedata[2].'-'.$datedata[1].'-'.$datedata[0];
		else:
			$datedata			=	'';
		endif;
		return $datedata;
	}
}

/*
 * Change ddmmyy to yymmdd
 */
if (!function_exists('DMYtoYMD')) {
	function DMYtoYMD($date) {
		if($date):
			$datedata			=	explode('/',$date);
			$datedata			=	$datedata[2].'-'.$datedata[0].'-'.$datedata[1];
		else:
			$datedata			=	'';
		endif;
		return $datedata;
	}
}

/*
 * Change yymmdd to ddmmyy
 */
if (!function_exists('YYMMDDtoDDMMYY')) {
	function YYMMDDtoDDMMYY($date) {
		if($date && $date != '1970-01-01 00:00:00' && $date != '0000-00-00 00:00:00'):
			$datedata			=	explode(' ',$date);
			$datedata			=	explode('-',$datedata[0]);
			$datedata			=	$datedata[2].'-'.$datedata[1].'-'.$datedata[0];
		else:
			$datedata			=	'';
		endif;
		return $datedata;
	}
}

/*
 * Show date format
 */
if (!function_exists('showDateFormat')) {
	function showDateFormat($date) {
		if($date && $date != '1970-01-01 00:00:00' && $date != '0000-00-00 00:00:00'):
			$datedata			=	date('F d Y', strtotime($date));
		else:
			$datedata			=	'';
		endif;
		return $datedata;
	}
}

/*
 * add time in date
 */
if (!function_exists('addTimeInDate')) {
	function addTimeInDate($date) {
		return $date.' 00:00:00';
	}
}

/*
 * remove time from date
 */
if (!function_exists('removeTimeFromDate')) {
	function removeTimeFromDate($date) {
		$datedata				=	explode(' ',$date);
		return $datedata[0];
	}
}

/*
 * remove time from date
 */
if (!function_exists('showDateFormat')) {
	function showDateFormat($date) {
		return date('F m Y',strtotime($date));
	}
}

if (!function_exists('getTablePrefix')) {
	function getTablePrefix() 
	{ 
		return 'wems_'; 
	}
}	

/*
 * Show Current MK Time
 */
if (!function_exists('getCurrentMKTime')) {
	function getCurrentMKTime()
	{  
		return mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"));;
	}
}

if (!function_exists('numberFormat')) {
	function numberFormat($price) {
		if(checkFloat($price)):
			return number_format($price, 2, '.', '');
		else:
			return number_format($price, 2, '.', '');
		endif;
	}
}

if (!function_exists('getfuturedate')) {
	function getfuturedate($date,$days) {
		$Date 					= 	$date;
		$expirydate 			=	date('Y-m-d', strtotime($Date. ' + '.$days.' days'));
		return $expirydate;
	}
}

if (!function_exists('getCurrentUserId')) {
	function getCurrentUserId() {
		$CIOBJ = & get_instance();
		if($CIOBJ->session->userdata('user_type') == 'Customer'):
			$userId 				=		$CIOBJ->session->userdata('user_id');
		elseif($CIOBJ->session->userdata('merchant_type') == 'Merchant'):
			$userId 				=		$CIOBJ->session->userdata('merchant_id');
		else:
			$userId = '0';
		endif;
		return $userId;
	}
}

if (!function_exists('getSessionForOrder')) {
	function getSessionForOrder() {
		return "SESSION".rand(10000000000,999999999999);
	}
}

if (!function_exists('getRandomOrderId')) {
	function getRandomOrderId() {
		return "WEMS".rand(10000000000,999999999999);
	}
}

if (!function_exists('getSlugUrl')) {
	function getSlugUrl($name='') {
		$slug =	strtolower(str_replace(' ', '-', $name));
		return $slug;
	}
}

if (!function_exists('getOrigUrl')) {
	function getOrigUrl($name='') {
		$slug =	str_replace('-', ' ', $name);
		return ucfirst($slug);
	}
}

