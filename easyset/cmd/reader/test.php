<?php



$file 	= JPATH_ROOT.DS.'files'.DS.'14'.DS.'10622.pdf' ;
$txt 	= JPATH_ROOT.DS.'files'.DS.'14'.DS.'10622.txt' ;

system("/usr/bin/pdftotext {$file} {$txt}") ;
echo JFile::read($txt);