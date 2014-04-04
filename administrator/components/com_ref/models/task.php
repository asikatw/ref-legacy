<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

class RefModelTask extends JModelAdmin
{	
	/*
		RefModelTask::getTable() will call JTableTask.
		But our Table named RefTableTask, the $prefix must change to 'RefTable',
			so we need override getTable() method.
	*/
	function getTable($type = 'Task' , $prefix = 'RefTable' , $config = array() )
	{
		return parent::getTable( $type , $prefix , $config );
	}
	
	/*
	 * function getItem
	 * @param $arg
	 */
	
	public function getItem($pk=null)
	{
		$item = parent::getItem($pk);
		$item->professors_name = json_decode($item->professors_name);
		return $item ;
	}
	
	/*
		This method in parent class is abstract, so we need implemente it.
		It is used to handle data which we want to save before store in SQL.
		
		The $table is reference, just change it's data, don't need to return.
	*/
	function prepareTable($table)
	{
		$jform 		= JRequest::getVar('jform');
		$keyword 	= $jform['search_index_manual'] ;
		$date 		= JFactory::getDate( 'now' , JFactory::getConfig()->get('offset') ) ;
		$user		= JFactory::getUser();
		
		$table->entry_id = $jform['entry_id'];
		$table->keyword = $keyword ;
		if(!$keyword){
			$index 		= $jform['search_index_auto'];
			$separator 	= $jform['search_separator'];
			$keyword 	= array() ;
			
			foreach( $index as $k => $v ):
				if(!$v) continue ;
				
				if( $k >= 1 ):
					$i = $k - 1 ;
					$keyword[] = strtoupper(trim( $separator[$i] )) ;
					$keyword[] = trim( $v ) ;
				else:
					$keyword[] = $v ;
				endif;
			endforeach;
			
			$table->keyword = implode( ' ' , $keyword) ;
		}
		
		
		// database
		/*
		switch($table->database){
			case 'wiki' :
				$table->keyword .= ' site:wikipedia.org' ;
				break ;
			
			case 'ndltd' :
				$table->keyword .= ' site:ndltd.ncl.edu.tw' ;
				break;
			
			case 'udn' :
				$table->keyword .= ' site:udn.com' ;
				break;
		}*/
		
		
		// professors_name
		$table->professors_name = json_encode($jform['professors_name']);
		
		
		$table->status 		= 1 ;
		$table->created 	= $date->toSQL(true);
		$table->created_by	= $user->get('id');
		
		// re order
		jimport('joomla.filter.output');
		
		$this->table = $table ;
	}
	
	/*
	Get form from xml in models/forms.
	
	The loadForm() param 3 is option will 2 params:
	
		1 - All form data will save as array in  option 1 "control" from request, 
			if this option is empty, all data will put in root request.
			
		2 - Option 2 "load_data" means whether load default data and bind into formfield or not.
	*/
	function getForm($data = array(), $loadData = true)
	{
		$form = $this->loadForm( 'com_ref.task' , 'task' , array( 'control' => 'jform' , 'load_data' => 1 ) );
		return $form ;
	}

	/*
		JModelForm will call this method to gat $data and bind into form as default data.
	*/
	function loadFormData()
	{
		$data = JFactory::getApplication()->getUserState('com_ref.edit.task.data', array());
		//$data = new JObject($data);
		
		if (empty($data)) 
		{
			$data = $this->getItem();
		}
		
		$data->search_index_manual = $data->keyword ;
		unset($data->keyword);
		
		return $data;
	}
	
	/*
	 * function getReport
	 * @param 
	 */
	
	public function getReport()
	{
		$db = JFactory::getDbo();
		$q = $db->getQuery(true) ;
		$id = JRequest::getVar('id') ;
		
		$select = "
			a.name AS name,
			a.file_type AS file_type,
			b.referenced AS referenced,
			a.url AS url
		";
		
		$q->select($select)
			->from('#__rp_url_index AS a')
			->leftJoin('#__rp_pages_data AS b ON a.id = b.url_id')
			->where("a.task_id = {$id}")
			->where("referenced >= 1")
			;
		
		
		$db->setQuery($q);
		$urls = $db->loadRowList();
		
		array_unshift($urls, array( '標題', '網址', '頁面類型', '參考書目數量' ) );
		
		/*
		foreach( $urls as &$url ):
			
			foreach( $url as &$row ):
				$row = JString::transcode($row, 'UTF-8', 'big5');
			endforeach;
			
		endforeach;
		*/
		//AK::show($urls);jexit();
		return $urls;	
	}
	
	/*
	 * function getEnginePages
	 * @param $
	 */
	
	public function getSearchPages() {
		$db = JFactory::getDbo();
		$q = $db->getQuery(true) ;
		$id = JRequest::getVar('id') ;
		
		$select = 'a.*, b.*,c.*,
		a.id AS a_id,
		a.page AS a_page,
		SUM(c.parsed) AS page_parsed,
		COUNT(c.id) AS page_downloaded,
		COUNT(b.id) as page_url' ;
		
		$q->select($select)
			->from('#__rp_searchengine_pages AS a')
			->leftJoin('#__rp_url_index AS b ON a.page = b.page AND b.task_id = a.task_id')
			->leftJoin('#__rp_pages_data AS c ON b.id = c.url_id')
			->where("a.task_id='{$id}'")
			->where("( link_type = 'normal' OR link_type IS NULL )")
			->group('a.id')
			;
		
		/*
		$q->select('*')
			->from('#__rp_searchengine_pages')
			->where("task_id='{$id}'")
			;
		*/
		$db->setQuery($q);
		$pages = $db->loadObjectList();
		return $pages ;
	}
	
	/*
	 * function delete
	 * @param $
	 */
	
	public function delete(&$pks=null) {
		
		if( !parent::delete($pks) ){
			return false ;
		}
		
		$db = JFactory::getDbo();
		$q = $db->getQuery(true) ;
		
		$id = implode( ',' , $pks );
		$q->delete('#__rp_searchengine_pages')
			->where("task_id IN ( {$id} )")
			;
		
		$db->setQuery($q);
		$db->query();
		
	}
	
	/*
	 * function saveSearchEngine
	 * @param $
	 */
	
	public function saveSearchEngine($data) {
		$id = $this->getState('task.id');
		
		$parser = RefParser::getInstance($data['engine']);
		$parser->savePages( $id , $this->table );
		
	}
}