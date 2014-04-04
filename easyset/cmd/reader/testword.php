<?php
$file 	= JPATH_ROOT.DS.'files'.DS.'15'.DS.'10873.pdf' ;
include_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_ref'.DS.'class'.DS.'reader'.DS.'reader.php' ;

REFReader::read($file);



jexit();

$file 	= JPATH_ROOT.DS.'files'.DS.'15'.DS.'10920.doc' ;
//$txt 	= JPATH_ROOT.DS.'files'.DS.'15'.DS.'10622.txt' ;

system("antiword -m UTF-8.txt {$file}") ;
//echo JFile::read($txt);