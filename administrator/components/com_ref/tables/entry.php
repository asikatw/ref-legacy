<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

jimport('joomla.database.table');

class RefTableEntry extends JTable
{
	
	function __construct(&$db) 
	{
		parent::__construct('#__rp_entries', 'id', $db);
	}
	
	
	public function delete($pk=null) {
		$result = parent::delete($pk);
		
		// get task ids
		$db = JFactory::getDbo();
		$q = $db->getQuery(true) ;
		
		$q->select("id")
			->from("#__rp_tasks")
			->where("entry_id={$pk}")
			;
		
		$db->setQuery($q);
		$ids = $db->loadColumn();
		
		$task = JTable::getInstance('Task', 'RefTable');
		
		foreach( $ids as $id ):
			$task->delete($id) ;
		endforeach;
		
		return $result ;
	}
}