<?php
include_once('Lib_mb_utf8.php');

class RefDetectorNdltd
{
	
	/*
	 * function detect
	 * @param $txt
	 */
	
	public static function detect($txt = '', $professors_names = array())
	{
		$orgTxt = $txt;
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
		
		
		$nameRegString = "";
		for ($i=0; $i<count($professors_names); $i++) {
			$nameRegString .= preg_quote($professors_names[$i]);
			if ( $i != (count($professors_names)-1)) {
				$nameRegString .= "|";
			}
		}
		$ttlCount=0;
		//echo "/(".$titleRegString.")(.{0,".$units."})(".$nameRegString."))/u";
		if ( preg_match("/(指導教授:)(.{0,5})(".$nameRegString.")/u", $txtmp2, $match) ) {
			$self_cited = true;
		} else {
			// Find out Where is the reference
			preg_match("/(<div id\=\"gs32_levelrecord\")(.*?)(<\/ul>)/us", $orgTxt, $match);
			$menuContent=$match[0];
			//echo $menuContent;
			
			preg_match_all("/(<a href\=\"#XX\")(.*?)(<\/em>)/us", $menuContent, $match);
			//print_r($match);
			
			$referencePosition=-1;
			foreach ( $match[2] as $index => $value ) {
				if ( preg_match("/參考文獻/us", $value, $match2) ) {
					$referencePosition = $index;
				}
			}
			
			//echo $referencePosition;
			//echo $orgTxt;
			
			preg_match_all("/(<div id\=\"aa\")(.*?)(<\/div>)/us", $orgTxt, $match);
			//print_r($match);
			
			$ttlCount = preg_match_all("/".$nameRegString."/u", $match[0][$referencePosition], $match3);
		}
		
		if ( $self_cited ) {
			$returnValue['guidance'] = 1;
			$returnValue['cited'] = 0;
		} else {
			$returnValue['guidance'] = 0;
			$returnValue['cited'] = $ttlCount;
		}
		
		return $returnValue;
	}
}

