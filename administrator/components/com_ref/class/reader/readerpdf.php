<?php

class RefReaderPdf
{
	/*
	 * function read
	 * @param $file
	 */
	
	public static function read($file, $type = 'pdf')
	{
		$filetmp = explode('.', $file) ;
		$type = array_pop($filetmp) ;
		$filetmp = implode('.', $filetmp);
		
		shell_exec("/usr/bin/pdftotext {$file} {$filetmp}.txt") ;
		$output = JFile::read("{$filetmp}.txt");
		
		return $output ;
	}
}