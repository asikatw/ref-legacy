<?php
/**
 * @version     1.0.0
 * @package     com_ref
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

/**
 * Ref model.
 */
class RefModelpage extends JModelAdmin
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_REF';


	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Page', $prefix = 'RefTable', $config = array())
	{
		return parent::getTable( $type , $prefix , $config );
	}

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		An optional array of data for the form to interogate.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	JForm	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Initialise variables.
		$app	= JFactory::getApplication();

		// Get the form.
		$form = $this->loadForm('com_ref.page', 'page', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_ref.edit.page.data', array());

		if (empty($data)) 
		{
			$data = $this->getItem();
		}else{
			$data = new JObject($data);
		}

		return $data;
	}

	/**
	 * Method to get a single record.
	 *
	 * @param	integer	The id of the primary key.
	 *
	 * @return	mixed	Object on success, false on failure.
	 * @since	1.6
	 */
	public function getItem($pk = null)
	{
		if ($item = parent::getItem($pk)) {

			//Do any procesing on fields here if needed

		}

		return $item;
	}

	/**
	 * Prepare and sanitise the table prior to saving.
	 *
	 * @since	1.6
	 */
	protected function prepareTable(&$table)
	{
		jimport('joomla.filter.output');

		if (empty($table->id)) {

			// Set ordering to the last item if not set
			if (@$table->ordering === '') {
				$db = JFactory::getDbo();
				$db->setQuery('SELECT MAX(ordering) FROM #__ref_page');
				$max = $db->loadResult();
				$table->ordering = $max+1;
			}

		}
	}
	
	
	/*
	 * function parseSearchPage
	 * @param 
	 */
	
	public function parseSearchPage() {
		$db = JFactory::getDbo();
		$q = $db->getQuery(true) ;
		$table = JTable::getInstance('url', 'RefTable');
		$date = JFactory::getDate( 'now' , JFactory::getConfig()->get('offset') ) ;
		
		// get Search Page
		$q->select('*')
			->from('#__rp_searchengine_pages')
			->where('status = 1 AND published >= 1')
			->order('page')
			;
		
		$db->setQuery($q, 0, 1);
		$page = $db->loadObject();
		
		$page->status = 2 ;
		$db->updateObject('#__rp_searchengine_pages', $page , 'id' ) ;
		
		$parser = RefParser::getInstance($page->engine) ;
		$links  = $parser->parseSearchPage($page->cache);
		
		foreach( $links as $key1 => $link ):
			foreach( $link as $key2 => $row ):
				if(!$row) continue ;
			
				$table->bind($page) ;
				$table->bind($row) ;
				$table->id 			= null ;
				//$table->url 		= $row['link'] ;
				$table->number 		= ( ( $key1 + 1 ) * $table->page ) ;
				$table->created 	= $date->toMySQL();
				$table->link_type 	= $key2 ;
				//$table->file_type 	= 'html' ;
				
				$table->store();
				
				//AK::show($table);
				
				$table->reset();
				$table->id = null ;
				
			endforeach;
			
		endforeach;
	}
	
	
	/*
	 * function getResultPage
	 * @param $arg
	 */
	
	public function getResultPage() {
		
		$date = JFactory::getDate( 'now' , JFactory::getConfig()->get('offset') ) ;
		$table = $this->getTable('page', 'RefTable') ;
		
		$db = JFactory::getDbo();
		$q 	= $db->getQuery(true) ;
		
		$q->select('*')
			->from('#__rp_url_index')
			->where("downloaded = '0000-00-00 00:00:00'")
			->where('loading != 1')
			->where("link_type='normal'")
			->where("tried_times < 10")
			->order('id')
			;
		
		$db->setQuery($q, 0, RF::getConfig('once_download_pages', 20) );
		$urls = $db->loadObjectList();
		
		// update urls status
		$ids = array();
		foreach( $urls as $url ):
			$url->loading 		= 1 ;
			$url->last_loaded 	= $date->toMySQL();
			$url->tried_times	= $url->tried_times + 1 ;
			$url->status 		= 2 ;
			
			$db->updateObject('#__rp_url_index', $url , 'id' ) ;
		endforeach;
		
		// download page
		foreach( $urls as $url ):
		
			$url->url = htmlspecialchars_decode($url->url);
			
			$erron = RF::_('curl.getPageFile' , $url ) ;
			if(!$erron) {
				$table->id 			= null ;
				$table->task_id		= $url->task_id ;
				$table->url_id 		= $url->id ;
				$table->created 	= $date->toMySQL();
				$table->status 		= 1 ;
				$table->file_type 	= $url->file_type ;
				$table->ordering 	= $url->ordering ;
				$table->published 	= 1 ;
				
				//if( $url->file_type == 'html' ) {
					//$table->html = RF::_('curl.getPageHTML' , $url->url ) ;
				//}else{
					$table->file_path = "files/{$url->task_id}/{$url->id}.{$url->file_type}" ;
				//}
				
				$table->store();
				$table->reset();
				
				// update url 
				$url->loading 		= 0 ;
				$url->downloaded	= JFactory::getDate( 'now' , JFactory::getConfig()->get('offset') )->toMySQL() ;
				$db->updateObject('#__rp_url_index', $url , 'id' ) ;
				
			}else{
				$url->loading 		= 0 ;
				$url->error			= $erron ;
				
				$db->updateObject('#__rp_url_index', $url , 'id' ) ;
			}

		endforeach;
		
		
		//AK::show($urls);
	}
	
	
	/*
	 * function parseResultPage
	 * @param $arg
	 */
	
	public function parseResultPage() {
		include_once REF_ADMIN.DS.'class'.DS.'reader'.DS.'reader.php';
		include_once REF_ADMIN.DS.'class'.DS.'detector'.DS.'detector.php';
		
		$app = JFactory::getApplication() ;
		$db = JFactory::getDbo();
		$q = $db->getQuery(true) ;
		
		// get parsing pages
		$q->select('a.*, b.*, a.id AS id ,a.status AS status')
			->from('#__rp_pages_data AS a')
			->leftJoin('#__rp_tasks AS b ON a.task_id=b.id' )
			->where('a.status = 1')
			->where('a.parsing != 1')
			->where('a.parsed != 1')
			->where('a.published = 1')
			->where('b.published = 1')
			->order('a.id')
			;
		
		$db->setQuery($q,0, RF::getConfig('once_detect_pages', 20));
		$pages = $db->loadObjectList();
		
		// update pages data
		foreach( $pages as $page ):
			
			$u = new JObject();
			$u->id = $page->id ;
			$u->status = 2 ;
			$u->parsing = 1 ;
			
			$db->updateObject('#__rp_pages_data', $u , 'id' ) ;
			//AK::show($page);
		endforeach;
		
		
		// detect start
		foreach( $pages as $page ):
			$txt = '';
			$result = null ;
			$professors_names = (array)json_decode($page->professors_name );
			
			// get file to txt
			$txt = RefReader::read($page->file_path);
			
			// parse and detect
			RefDetector::detect($txt, $professors_names);
			
			$u = new JObject();
			$u->id = $page->id ;
			$u->status = 3 ;
			$u->parsing = 0 ;
			$u->parsed = 1 ;
			$u->referenced = count(RefDetector::$result) ;
			
			$db->updateObject('#__rp_pages_data', $u , 'id' ) ;
		endforeach;
		
		return true ;
	}

}