<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

abstract class RefDetectorCourse
{
	public static $result ;
	
	/*
	 * function detect
	 * @param $txt
	 */
	
	public static function detect($txt = '', $professors_names = array())
	{
		// Detect encoding
		$encoding =  mb_detect_encoding($txt);
		
		// If is BIG5, convert encoding to utf-8
		if($encoding != 'UTF-8'){
			$txt = JString::transcode($txt, 'big5', 'UTF-8');
		}
		
		$txtmp = $txt ;
		
		// Get terms
		$params = JComponentHelper::getParams('com_ref');
		
		$course_terms = $params->get('course_terms');
		$course_terms = explode(',',$course_terms);
		
		$reference_terms = $params->get('reference_terms');
		$reference_terms = explode(',',$reference_terms);
		
		
		// detect is before course terms?
		$p = false ;
		foreach( $course_terms as $course_term ):
			$p = strpos($txt, $course_term);
			if($p !== false) break ;
		endforeach;
		
		if($p > 0){
			$txtmp = substr($txtmp, $p);
		}
		
		
		// detect is before reference terms?
		$p = false ;
		foreach( $reference_terms as $reference_term ):
			$p = strpos( $txt, $reference_term);
			if($p !== false) break ;
		endforeach;
		
		if($p > 0){
			$txtmp = substr($txtmp, $p);
		}
		
		
		// detect professors name
		$txtmps = explode("\n", $txtmp);
		$result = array();
		
		foreach( $txtmps as $row ):
			
			$p = false ;
			
			foreach( $professors_names as $professors_name ):
				$p = strpos( $row, $professors_name );
				
				if($p !== false ){
					$result[] = $row ;
					break ;
				}
				
			endforeach;
			
		endforeach;
		
		self::$result = $result ;
		
		if(count($result) > 0) return true ;
		
		return false ;
	}
}