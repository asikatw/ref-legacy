<?php
include_once('Lib_mb_utf8.php');

class RefDetectorReadopac
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
		
		//file_put_contents("test.txt", $txt);
		//echo $txt;
		
		$authorNameString="";
		$pattern = sprintf("/(search_index\=AU)(.*?)(>)(.*?)(<\/a>)/us");
		if ( preg_match_all( $pattern, $txt, $matches, PREG_SET_ORDER ) ) {
			foreach ( $matches as $index => $value ) {
				$authorNameString=$authorNameString.$value[4];
			}
		} else {
			echo "story NOT match</br>\n";
		}
		echo $authorNameString;
		
		/*
		$authorTermsRegString = "";
		for ($i=0; $i<count($author_terms); $i++) {
			$authorTermsRegString .= preg_quote($author_terms[$i]);
			if ( $i != (count($author_terms)-1)) {
				$authorTermsRegString .= "|";
			}
		}
		*/
		$professorsNamesRegString = "";
		for ($i=0; $i<count($professors_names); $i++) {
			$professorsNamesRegString .= preg_quote($professors_names[$i]);
			if ( $i != (count($professors_names)-1)) {
				$professorsNamesRegString .= "|";
			}
		}
		
		$writings = 0;
		$mentioned = 0;
		/*
		if ( preg_match("/(".$authorTermsRegString.")/u", $data, $match) && preg_match("/(".$professorsNamesRegString.")/u", $data, $match) ) {
			$writings = 1;
		} else {
			if ( preg_match("/(".$professorsNamesRegString.")/u", $story, $match) ) {
				$mentioned = 1;
			}
		}
		*/
		if ( preg_match("/(".$professorsNamesRegString.")/u", $authorNameString, $match) ) {
			$writings = 1;
		}
		$returnValue['writings'] = $writings;
		//$returnValue['mentioned'] = $mentioned;
		
		return $returnValue;
	}
}

