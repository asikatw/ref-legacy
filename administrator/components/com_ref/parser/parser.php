<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

abstract class RefParser extends JObject
{
	public static $instance = array() ;
	
	/*
	 * function getInstance
	 * @param $engine
	 */
	
	public static function getInstance($engine='google', $config = array() ) {
		if( !isset(self::$instance[$engine]) ){
			include_once JPath::clean(REF_ADMIN."/parser/{$engine}.php");
			
			$class = 'RefParser'.ucfirst($engine) ;
			self::$instance[$engine] = new $class ($config);
		}
		
		return self::$instance[$engine] ;
	}
	
	/*
	 * function savePages
	 * @param $data
	 */
	
	public function savePages( $task_id , $data = array() ) {
		$pages 	= $this->getPageLists($data);
		$date 	= JFactory::getDate( 'now' , JFactory::getConfig()->get('offset') ) ;
		$t 		= JTable::getInstance( 'engine' , 'RefTable' );
		
		// delete old first
		$db = JFactory::getDbo();
		$q = $db->getQuery(true) ;
		
		$q->delete('#__rp_searchengine_pages')
			->where("task_id='{$data->id}'")
			;
		$db->setQuery($q);
		$db->query();
		
		foreach( $pages as $k => $page ){
			$t->url 	= $page ;
			$t->engine	= $data->engine ;
			$t->page 	= $k + 1 ;
			$t->task_id = $task_id ;
			$t->created = $date->toSQL(true);
			$t->status	= 1 ;
			$t->published = 1 ;
			$t->cache	= RF::_('curl.getPageHTML' , $t->url ) ;
			
			$t->store();
			
			if($t->reset()){
				throw new Exception( $t->getErrorNum() ,$t->getError() ) ;
			}
			$t->id = null ;
		}
	}
	
	/*
	 * function getFirstPage
	 * @param $data
	 */
	
	public function getFirstPageHTML($q)
	{
		return '';
	}
	
	public function getPageLists($data) {
		return array() ;
	}
	
	/*
	 * function parseSearchPage
	 * @param $
	 */
	
	public function parseSearchPage($html=null) {
		include_once JPath::clean(REF_ADMIN.'/includes/dom/simple_html_dom.php') ;
	}
	
}