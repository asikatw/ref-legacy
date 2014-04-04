<?php
/**
 * @version     1.0.0
 * @package     com_payany
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Ref helper.
 */
class RefHelperCurl
{
	/*
	 * function getPageHTML
	 * @param $url
	 */
	
	public static function getPageHTML($url='')
	{
		if(!$url) return ;
		
		$ch = curl_init();
		 
		
		$options = array(
			CURLOPT_URL 			=> $url,
			CURLOPT_RETURNTRANSFER 	=> true,
			CURLOPT_USERAGENT 		=> "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.1 (KHTML, like Gecko) Chrome/14.0.835.163 Safari/535.1",
			CURLOPT_FOLLOWLOCATION 	=> true ,
			CURLOPT_HTTPHEADER		=> array('X-FORWARDED-FOR:140.112.180.156', 'CLIENT-IP:140.112.180.156'),
			CURLOPT_REFERER			=> 'asikard.com'
			
		);
		curl_setopt_array($ch, $options);
		$output = curl_exec($ch);
		curl_close($ch);
		
		if($output)
			return $output ;
		//jext();
	}
	
	public static function getPageFile($url)
	{
		if(!$url) return ;
		
		$url_result = self::handleURL($url->url);
		
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.path');
		
		$folder_path = JPATH_ROOT.DS.'files'.DS.$url->task_id ;
		$file_path = $folder_path.DS.$url->id.'.'.$url->file_type ;
		
		JPath::setPermissions($folder_path, 777, 777) ;
		if( !JFolder::exists($folder_path) ){
			JFolder::create($folder_path) ;
		}
		
		$fp = fopen( $file_path, 'w+' ) ;
		$ch = curl_init(  );
		
		$options = array(
			CURLOPT_URL 			=> $url_result,
			CURLOPT_RETURNTRANSFER 	=> true,
			CURLOPT_USERAGENT 		=> "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.1 (KHTML, like Gecko) Chrome/14.0.835.163 Safari/535.1",
			CURLOPT_FOLLOWLOCATION 	=> true ,
			CURLOPT_FILE			=> $fp ,
		);
		
		curl_setopt_array($ch, $options);
		curl_exec($ch);
		
		$errno = curl_errno($ch);
		$errmsg = curl_error($ch);
		
		curl_close($ch);
		fclose($fp);
		
		if($errno){
			return $errno.' - '.$errmsg ;
		}else {
			return 0 ;
		}
		
	}
	
	
	/*
	 * function handleURL
	 * @param $url
	 */
	
	public static function handleURL($url)
	{
		$uri = JFactory::getURI($url) ;
		
		if($uri->getHost() == 'readopac.ncl.edu.tw') {
			$new_uri = new JURI();
			$num = rand(1,3);
			$new_uri->setHost( 'readopac'.$num.'.ncl.edu.tw' );
			$new_uri->setPath( '/nclserialFront/search/detail.jsp' );
			$new_uri->setScheme( 'http' );
			$new_uri->setVar('sysId', $uri->getQuery());
			$new_uri->setVar('dtdId', '000040');
			
			return (string) $new_uri ;
		}else{
			return $url ;
		}
	}
}
