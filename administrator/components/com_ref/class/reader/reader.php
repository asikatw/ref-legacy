<?php

class RefReader
{
	
	/*
	 * function read
	 * @param $
	 */
	
	public static function read($file)
	{
		// detect file type
		$filetmp = explode('.', $file) ;
		$type = array_pop($filetmp) ;
		$file = JPath::clean(RF::getConfig('file_path_root', JPATH_ROOT).DS.$file);
		
		if(!$type || $type == '') return null ;
		
		switch($type){
			case 'doc' :
			case 'docx' :
				$name = 'doc' ; break ;
			
			case 'ppt' :
			case 'pptx' :
				$name = 'ppt'; break ;
			
			case 'xls' :
			case 'xlsx' :
				$name = 'xls'; break ;
				
			case 'pdf' :
				$name = 'pdf'; break ;
			
			default:
				$name = 'all'; break ;
		}
		
		$path = dirname(__FILE__)."/reader{$name}.php" ;
		$class_name = 'RefReader'.ucfirst($name);
		
		include_once JPath::clean($path);
		if(class_exists($class_name)) {
			return call_user_func_array( array( $class_name , 'read' ), array( $file, $type ) ) ;
		}
	}
	
}