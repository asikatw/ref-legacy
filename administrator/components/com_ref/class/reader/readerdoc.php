<?php

class RefReaderDoc
{
	/*
	 * function read
	 * @param $file
	 */
	
	public static function read($file, $type = 'doc')
	{
		$output = shell_exec("antiword -m UTF-8.txt $file") ;
		return $output ;
	}
}


