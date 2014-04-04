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
class RefModelPages extends JModelList
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
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'filter_order_Dir', 'filter_order', 
				'search' , 'filter'
            );
            
        $config['tables'] = array(
				'a' => '#__rp_url_index',
				'b' => '#__rp_pages_data'
			);
            
            $config['filter_fields'] = RF::_('db.mergeFilterFields', $config['filter_fields'] , $config['tables'] );
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
		// Initialise variables.
		$app = JFactory::getApplication();

		// Load the filter state.
		$search = $app->getUserStateFromRequest($this->context.'.filter.search.'.JRequest::getVar('task_id') , 'filter_search');
		$this->setState('filter.search', $search);

		$published = $app->getUserStateFromRequest($this->context.'.filter.state.'.JRequest::getVar('task_id'), 'filter_published', '', 'string');
		$this->setState('filter.state', $published);

		// Load the parameters.
		$params = JComponentHelper::getParams('com_ref');
		$this->setState('params', $params);
		
		
		foreach( $this->filter_fields as $field ){
			$this->setState($field, $app->getUserStateFromRequest($this->context.".field.{JRequest::getVar('task_id')}.{$field}", $field) );
		}

		// List state information.
		parent::populateState('a.id', 'asc');
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
	
	
	public function getFilter()
	{
		// Get filter inputs from from xml files in /models/form.
		JForm::addFormPath(REF_SITE.'/models/forms');
        JForm::addFieldPath(REF_SITE.'/models/fields');
		
		// load forms
		$form['search'] = JForm::getInstance('com_ref.pages.search', 'pages_search', array( 'control' => 'search' ,'load_data'=>'true'));
		$form['filter'] = JForm::getInstance('com_ref.pages.filter', 'pages_filter', array( 'control' => 'filter' ,'load_data'=>'true'));
		
		// Get default data of this form. Any State key same as form key will auto match.
		$form['search']->bind( $this->getState('search') );
		$form['filter']->bind( $this->getState('filter') );
		
		return $form;
	}
	
	
	/*
	 * function getTask
	 * @param 
	 */
	
	public function getTask()
	{
		$task = $this->getTable('task', 'RefTable');
		$task->load(JRequest::getVar('task_id', 0)) ;
		
		return $task ;
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
		$order 	= $this->getState('list.ordering' , 'a.id');
		$dir	= $this->getState('list.direction', 'asc');
		$task_id = JRequest::getVar('task_id') ;
		
		// Filter and Search
		$filter = $this->getState('filter',array()) ;
		$search = $this->getState('search') ;
		
		if($search['index']){
			$q->where("{$search['field']} LIKE '%{$search['index']}%'");
		}
		
		foreach($filter as $k => $v ){
			if($v)
				$q->where("{$k}='{$v}'") ;
		}
		// Filter and search
		
		$select = RF::_('db.getSelectList', $this->config['tables'] ) ;
		
		//build query
		$q->select($select)
			->from('#__rp_url_index AS a')
			->leftJoin('#__rp_pages_data AS b ON a.id=b.url_id')
			->where("a.task_id={$task_id}")
			->where("a.link_type='normal'")
			->order( " {$order} {$dir}" )
			;
		
		return $q;
	}
}
