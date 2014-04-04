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
class RefModelWebometrics extends JModelList
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
			'a' => '#__rp_webometrics'
		);
		
		
		
		// Set filter fields
		// ========================================================================
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'filter_order_Dir', 'filter_order', 
				'search' , 'filter'
            );
			
            $config['filter_fields'] = RefHelper::_('db.mergeFilterFields', $config['filter_fields'] , $config['tables'] );
        }
		
		
		
		// Fulltext search setting
		// ========================================================================
		$config['fulltext_search'] = false ;
		
		
		
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
		

		// Load the parameters.
		$params = JComponentHelper::getParams('com_ref');
		$this->setState('params', $params);
		
		// Fulltext search
		$this->setState( 'search.fulltext', $this->config['fulltext_search'] );
		
		
		foreach( $this->filter_fields as $field ){
			$this->setState($field, $app->getUserStateFromRequest($this->context.'.field.'.$field, $field) );
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
		$form['search'] = JForm::getInstance('com_ref.webometrics.search', 'webometrics_search', array( 'control' => 'search' ,'load_data'=>'true'));
		$form['filter'] = JForm::getInstance('com_ref.webometrics.filter', 'webometrics_filter', array( 'control' => 'filter' ,'load_data'=>'true'));
		
		// Get default data of this form. Any State key same as form key will auto match.
		$form['search']->bind( $this->getState('search') );
		$form['filter']->bind( $this->getState('filter') );
		
		return $form;
	}
	
	
	/*
	 * function getFulltextSearch
	 * @param 
	 */
	
	public function getFullSearchFields()
	{
		$file = JPATH_COMPONENT.'/models/forms/webometrics_search.xml' ;
		
		$xml = simplexml_load_file($file);
		$field = $xml->xpath('/form/fieldset/field') ;
		$options = $field[0]->option ;
		
		$fields = array();
		foreach( $options as $option ):
			$attr = $option->attributes();
			$fields[] = $attr['value'];
		endforeach;
		
		return $fields ;
	}
	

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JDatabaseQuery
	 * @since	1.6
	 */
	protected function getListQuery()
	{
		// Get some data
		// ========================================================================
		
		// Create a new query object.
		$db		= $this->getDbo();
		$q		= $db->getQuery(true);
		$order 	= $this->getState('list.ordering' , 'a.id');
		$dir	= $this->getState('list.direction', 'asc');

		// Filter and Search
		$filter = $this->getState('filter',array()) ;
		$search = $this->getState('search') ;
		
		
		
		// Search
		// ========================================================================
		if($search['index']){
			
			if($this->getState( 'search.fulltext' )){
				$fields = $this->getFullSearchFields();
				
				foreach( $fields as &$field ):
					$field = "{$field} LIKE '%{$search['index']}%'" ;
				endforeach;
				
				$q->where( "( ".implode(' OR ', $fields )." )" );
				
			}else{
				$q->where("{$search['field']} LIKE '%{$search['index']}%'");
			}
			
		}
		
		
		
		// Filter
		// ========================================================================
		foreach($filter as $k => $v ){
			if($v !== '*'){
				$q->where("{$k}='{$v}'") ;
			}
		}
		
		
		
		// Build query
		// ========================================================================
		
		// get select columns
		$select = RefHelper::_( 'db.getSelectList', $this->config['tables'] );
		
		//build query
		$q->select($select)
			->from('#__rp_webometrics AS a')
			//->where("")
			->order( " {$order} {$dir}" ) ;
		
		return $q;
	}
}
