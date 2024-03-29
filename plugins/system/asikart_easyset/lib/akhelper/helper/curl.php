<?php

class AKCurl
{
	/*
	 * function getPageHTML
	 * @param $url
	 */
	
	public static function getHTML($url='')
	{
		if(!$url) return ;
		
		$ch = curl_init();
		 
		
		$options = array(
			CURLOPT_URL 			=> $url,
			CURLOPT_RETURNTRANSFER 	=> true,
			CURLOPT_USERAGENT 		=> "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.1 (KHTML, like Gecko) Chrome/14.0.835.163 Safari/535.1",
			CURLOPT_FOLLOWLOCATION 	=> true ,
		);
		curl_setopt_array($ch, $options);
		$output = curl_exec($ch);
		curl_close($ch);
		
		if($output)
			return $output ;
		//jext();
	}
	
	public static function getFile($url=null, $path=null)
	{
		if(!$url) return ;
		
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.path');
		
		$url = JFactory::getURI($url) ;
		
		//$folder_path = JPATH_ROOT.DS.'files'.DS.$url->task_id ;
		if(substr($path, -1) == DS){
			$file_name = JFile::getName($url);
			$file_path = $path.$file_name ;
			$folder_path = $path ;
		}else{
			$file_path = $path ;
			$folder_path = str_replace( JFile::getName($path), '', $file_path );
		}
		
		JPath::setPermissions($folder_path, 644, 755) ;
		if( !JFolder::exists($folder_path) ){
			JFolder::create($folder_path) ;
		}
		
		$fp = fopen( $file_path, 'w+' ) ;
		$ch = curl_init(  );
		
		$options = array(
			CURLOPT_URL 			=> $url,
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
}