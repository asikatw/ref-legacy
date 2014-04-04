<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

jimport('joomla.database.table');

class RefTableTask extends JTable
{
	
	function __construct(&$db) 
	{
		parent::__construct('#__rp_tasks', 'id', $db);
	}
	
	/*
	 * function store
	 * @param $pk
	 */
	
	public function store($updateNulls = false)
	{
		$result = parent::store($updateNulls);
		
		if($result) {
			$table = JTable::getInstance('Result', 'RefTable') ;
			$table->task_id = $this->id ;
			$table->store();
		}
		
		return $result ;
	}
	
	
	/*
	 * function delete
	 * @param $
	 */
	
	public function delete($pk=null) {
		$result = parent::delete($pk);
		
		$db = JFactory::getDbo();
		
		// delete engine oages
		$q = $db->getQuery(true) ;
		$q->delete('')
			->from('#__rp_searchengine_pages')
			->where("task_id = {$pk}")
			;
		$db->setQuery($q);
		$db->query() ;
		
		// delete urls
		$q = $db->getQuery(true) ;
		$q->delete('')
			->from('#__rp_url_index')
			->where("task_id = {$pk}")
			;
		$db->setQuery($q);
		$db->query() ;
		
		// delete page data
		$q = $db->getQuery(true) ;
		$q->delete('')
			->from('#__rp_pages_data')
			->where("task_id = {$pk}")
			;
		$db->setQuery($q);
		$db->query() ;
		
		// delete results
		$q = $db->getQuery(true) ;
		$q->delete('')
			->from('#__rp_results')
			->where("task_id = {$pk}")
			;
		$db->setQuery($q);
		$db->query() ;
		
		
		// delete files
		if( JFolder::exists(JPATH_ROOT.DS.'files'.DS.$pk) )
			JFolder::delete( JPATH_ROOT.DS.'files'.DS.$pk ) ;
		
		return $result ;
	}
}