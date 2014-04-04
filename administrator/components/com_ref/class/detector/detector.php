<?php


abstract class RefDetector
{
	public static $result ;
	
	/*
	 * function detect
	 * @param $txt
	 */
	
	public static function detect($type = 'syllabus')
	{
		// Set file name
		$file_name = strtolower($type) ;
		$file_path = dirname(__FILE__).'/type/'.$file_name.'.php' ;
		
		// Set Class name
		$class_name = 'RefDetector'.ucfirst($type) ;
		$func_name  = __FUNCTION__ ;
		
		// Set params
		$args = func_get_args();
		array_shift($args) ;
		
		// Inlude
		if(file_exists($file_path)) {
			include_once $file_path ;
		}
		
		// Call function
		if( class_exists($class_name) && is_callable( array( $class_name, $func_name ) ) ){
			return call_user_func_array( array( $class_name, $func_name ), $args ) ;
		}
	}
}
