<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

jimport('joomla.database.table');

class RefTablePage extends JTable
{
	
	function __construct(&$db) 
	{
		parent::__construct('#__rp_pages_data', 'id', $db);
	}
}