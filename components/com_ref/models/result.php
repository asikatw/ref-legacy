<?php
/**
 * @version     1.0.0
 * @package     com_ref
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Ref records.
 */
class RefModelResult extends JModelList
{

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array())
    {
		
		// Set query tables
		// ========================================================================
		$config['tables'] = array(
				'a' => '#__ref_entries',
				'b' => '#__categories',
				'c' => '#__users',
				'd' => '#__viewlevels',
				'e' => '#__languages'
			);
		
		
		
		// Set filter fields
		// ========================================================================
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'filter_order_Dir', 'filter_order', 
				'search' , 'filter'
            );    
        }
		
		
		
		$this->config = $config ;

        parent::__construct($config);
    }


	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		
		
	}

	
	/*
	 * function getEntry
	 * @param 
	 */
	
	public function getEntry()
	{
		$id = JRequest::getVar('id') ;
		
		$table = $this->getTable('Entry', 'RefTable');
		if($table->load($id)){
			$this->setState('entry', $table);
			return $table ;
		}
		
		return false ;
	}
	
	
	/*
	 * function getResults
	 * @param 
	 */
	
	public function getResults()
	{
		$db = JFactory::getDbo();
		$q = $db->getQuery(true) ;
		
		$id = JRequest::getVar('id') ;
		
		$q->select("a.*, b.*")
			->from("#__rp_results AS a")
			->leftJoin('#__rp_tasks AS b ON a.task_id = b.id')
			->where("b.entry_id={$id}")
			;
		
		$db->setQuery($q);
		return $results = $db->loadObjectList('database');
	}
	
	
	/*
	 * function getWebometrics
	 * @param 
	 */
	
	public function getWebometrics()
	{
		$db = JFactory::getDbo();
		$q = $db->getQuery(true) ;
		
		$id = JRequest::getVar('id') ;
		$query = JRequest::getVar('q') ;
		$query = json_decode($query);
		$entry = $this->getState('entry');
		$urls 	= array();
		
		foreach( $query->site as $site ):
			$tmp = JFactory::getURI( $site ) ;
			$tmp->setScheme('');
			$urls[] = $tmp;
		endforeach;
		
		$urls = implode("','", $urls);
		
		$q->select("*")
			->from("#__rp_webometrics")
			->where("entry_id={$entry->id}")
			->where("url IN ('{$urls}')")
			;
		
		$db->setQuery($q);
		$result = $db->loadObjectList();
		
		if(!$result) {
			$model = JModelLegacy::getInstance('Entry', 'RefModel');
			$model->getWebometrics($entry->id, $entry->name, $query->site);
			
			$result = $db->loadObjectList();
		}
		
		$result2 = new JObject(array( 'web_scale' => 0, 'visibility' => 0,'files' => 0,'scholarly' => 0 ));
		foreach( $result as $row ):
			$result2->web_scale 	+= $row->web_scale ;
			$result2->visibility 	+= $row->visibility ;
			$result2->files 		+= $row->files ;
			$result2->scholarly 	+= $row->scholarly ;
		endforeach;
		
		return $result2 ;
	}
	
	
	/*
	 * function getRelative
	 * @param 
	 */
	
	public function getRelative()
	{
		$query = JRequest::getVar('q');
		
		$db = JFactory::getDbo();
		$q = $db->getQuery(true) ;
		
		// Set Title LIKE
		$entry = $this->getState('entry');
		$titles = explode(', ', $entry->title);
		
		foreach( $titles as $title ):
			$q->where("title LIKE '%{$title}%'", 'OR') ;
		endforeach;
		
		$q->select("*")
			->from("#__rp_entries")
			->order("title DESC")
			;
		
		$db->setQuery($q);
		$result = $db->loadObjectList();
		
		if($result) {
			foreach( $result as $key => &$row ):
				if($row->id == $entry->id){
					unset($result[$key]);
					continue ;
				}
				$row->link = JRoute::_("index.php?option=com_ref&view=result&id={$row->id}&q={$query}") ;
			endforeach;
		}
		
		return $result ;
	}
	
	
	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param	string		$id	A prefix for the store id.
	 * @return	string		A store id.
	 * @since	1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id.= ':' . $this->getState('search');
		$id.= ':' . $this->getState('filter');

		return parent::getStoreId($id);
	}
	
	
	/**
	 * Method to get list page filter form.
	 *
	 * @return	object		JForm object.
	 * @since	2.5
	 */
	
	public function getFilter()
	{
		// Get filter inputs from from xml files in /models/form.
		JForm::addFormPath(JPATH_COMPONENT.'/models/forms');
        JForm::addFieldPath(JPATH_COMPONENT.'/models/fields');
		
		// load forms
		$form['search'] = JForm::getInstance('com_ref.entries.search', 'entries_search', array( 'control' => 'search' ,'load_data'=>'true'));
		$form['filter'] = JForm::getInstance('com_ref.entries.filter', 'entries_filter', array( 'control' => 'filter' ,'load_data'=>'true'));
		
		// Get default data of this form. Any State key same as form key will auto match.
		$form['search']->bind( $this->getState('search') );
		$form['filter']->bind( $this->getState('filter') );
		
		return $form;
	}
	
	
	/*
	 * function getCategory
	 * @param 
	 */
	
	public function getCategory()
	{
		if(!empty($this->category)){
			return $this->category ;
		}
		
		$pk = $this->getState('category.id') ;
		
		$this->category  = JTable::getInstance('Category');
		$this->category->load($pk);
		
		return $this->category ;
	}
	

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JDatabaseQuery
	 * @since	1.6
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$q		= $db->getQuery(true);
		
		return $q;
	}
}
