<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

jimport('joomla.database.table');

class RefTableResult extends JTable
{
	
	function __construct(&$db) 
	{
		parent::__construct('#__rp_results', 'id', $db);
	}
	
}