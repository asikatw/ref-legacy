<?php
include_once('Lib_mb_utf8.php');

class RefDetectorSyllabus
{
	
	/*
	 * function detect
	 * @param $txt
	 */
	
	public static function detect($txt = '', $professors_names = array(), $professors_titles = array(),
								  $units = 5, $course_terms = array(), $reference_terms = array())
	{
		$patterns = "/<script(.*?)script>/s";
		$replace  = "";
		$txt = preg_replace($patterns, $replace, $txt);
		
		$patterns = "/<SCRIPT(.*?)SCRIPT>/s";
		$replace  = "";
		$txt = preg_replace($patterns, $replace, $txt);
		
		$patterns = "/<style(.*?)style>/s";
		$replace  = "";
		$txt = preg_replace($patterns, $replace, $txt);
			
		$txt = strip_tags($txt);
		
		
		// Detect encoding
		$encoding =  mb_detect_encoding($txt);
		
		// If is BIG5, convert encoding to utf-8
		if($encoding != 'UTF-8'){
			$txt = iconv("CP950", "UTF-8//IGNORE", $txt);
		}
		
		//echo $txt;
		
		$txtmp = $txt;
		$txtmp2 = str_replace(array("\r\n", "\r", "\n"), "\t", trim($txt));
		$txtmp2 = str_replace(array("　"), '', $txtmp2); 
		$txtmp2 = mb_ereg_replace("[\t \.\(\)\~\\\"，；、：‧（）【】〔〕「」『』〈〉《》＜＞★☆…？！〃◎" . "\xEF\xBC\x8F" . "]",'',$txtmp2);
		
		//echo $txtmp2;
		
		
		// Detect self_cited OR Cited.
		$self_cited = false;
		
		$titleRegString = "";
		for ($i=0; $i<count($professors_titles); $i++) {
			$titleRegString .= preg_quote($professors_titles[$i]);
			if ( $i != (count($professors_titles)-1)) {
				$titleRegString .= "|";
			}
		}
		
		$nameRegString = "";
		for ($i=0; $i<count($professors_names); $i++) {
			$nameRegString .= preg_quote($professors_names[$i]);
			if ( $i != (count($professors_names)-1)) {
				$nameRegString .= "|";
			}
		}
		
		//echo "/(".$titleRegString.")(.{0,".$units."})(".$nameRegString."))/u";
		if ( preg_match("/(".$titleRegString.")(.{0,".$units."})(".$nameRegString.")/u", $txtmp2, $match) ) {
			$self_cited = true;
		}
		
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
		
		if ( $self_cited ) {
			$returnValue['self_cited'] = count($result);
			$returnValue['cited'] = 0;
		} else {
			$returnValue['self_cited'] = 0;
			$returnValue['cited'] = count($result);
		}
		
		return $returnValue;
	}
}
