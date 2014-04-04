<?php

class RefReaderAll
{
	/*
	 * function read
	 * @param $file
	 */
	
	public static function read($file, $type = 'all')
	{
		$output = JFile::read($file);
		
		return $output ;
	}
}