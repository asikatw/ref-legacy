<?php
include_once('Lib_mb_utf8.php');

class RefDetectorWiki
{
	
	/*
	 * function detect
	 * @param $txt
	 */
	
	public static function detect($txt = '', $professors_names = array(), $author_terms = array())
	{
		// Detect encoding
		$encoding =  mb_detect_encoding($txt);
		
		// If is BIG5, convert encoding to utf-8
		if($encoding != 'UTF-8'){
			$txt = iconv("CP950", "UTF-8//IGNORE", $txt);
		}
		
		// Remove navbox
		$patterns = "/<table cellspacing\=\"0\" class\=\"navbo(.*?)<\/table>/s";
		$replace  = "";
		$txt = preg_replace($patterns, $replace, $txt);
		
		//echo $txt;
		
		$referenceString="";
		$pattern = sprintf("/<span class\=\"reference-text\">(.*?)(<\/span>)/u");
		if ( preg_match_all( $pattern, $txt, $matches, PREG_SET_ORDER ) ) {
			foreach ( $matches as $index => $value ) {
				$referenceString=$referenceString.$value[1];
			}
		} else {
			echo "reference NOT match</br>\n";
		}
		//echo $referenceString;
		
		$patterns = "/<span class\=\"reference-text\">(.*?)(<\/span>)/u";
		$replace  = "";
		$txt = preg_replace($patterns, $replace, $txt);
		
		
		$professorsNamesRegString = "";
		for ($i=0; $i<count($professors_names); $i++) {
			$professorsNamesRegString .= preg_quote($professors_names[$i]);
			if ( $i != (count($professors_names)-1)) {
				$professorsNamesRegString .= "|";
			}
		}
		
		
		$mentioned = 0;
		$cited = 0;
		if ( preg_match("/(".$professorsNamesRegString.")/u", $txt, $match) ) {
			$mentioned = 1;
		}
		$cited = preg_match_all("/(".$professorsNamesRegString.")/u", $referenceString, $match);
		
		$returnValue['mentioned'] = $mentioned;
		$returnValue['cited'] = $cited;
		
		return $returnValue;
		
	}
}
