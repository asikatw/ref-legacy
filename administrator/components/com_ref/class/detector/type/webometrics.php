<?php
include_once('Lib_mb_utf8.php');

class RefDetectorWebometrics
{
	
	/*
	 * function detect
	 * @param $txt
	 */
	
	public static function detect($txt = '', $engine = '')
	{
		$orgTxt = $txt;
		// Detect encoding
		$encoding =  mb_detect_encoding($txt);
		
		// If is BIG5, convert encoding to utf-8
		if($encoding != 'UTF-8'){
			$txt = iconv("CP950", "UTF-8//IGNORE", $txt);
		}
		
		if ( $engine == "google" ) {
			preg_match("/約有 (.*?) 項結果/u", $txt, $match2);
			return intval(str_replace(",", "", $match2[1]));
		} else if ( $engine == "googlescholar" ) {
			preg_match("/約有 (.*?) 項結果/u", $txt, $match2);
			return intval(str_replace(",", "", $match2[1]));
		} else if ( $engine == "yahoo" ) {
			preg_match("/id\=\"resultCount\">(.*?)<\/span>/u", $txt, $match2);
			return intval(str_replace(",", "", $match2[1]));
		} else if ( $engine == "bing" ) {
			preg_match("/id\=\"count\">(.*?) 個結果/u", $txt, $match2);
			return intval(str_replace(",", "", $match2[1]));
		}
	
	}
}

