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
class RefModelwebometric extends JModelAdmin
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
	public function getTable($type = 'Webometric', $prefix = 'RefTable', $config = array())
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
		$form = $this->loadForm('com_ref.webometric', 'webometric', array('control' => 'jform', 'load_data' => $loadData));
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
		$data = JFactory::getApplication()->getUserState('com_ref.edit.webometric.data', array());

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
     * Method to allow derived classes to preprocess the form.
     *
     * @param   JForm   $form   A JForm object.
     * @param   mixed   $data   The data expected for the form.
     * @param   string  $group  The name of the plugin group to import (defaults to "content").
     *
     * @return  void 
     *
     * @see     JFormField
     * @since   11.1
     * @throws  Exception if there is an error in the form event.
     */
    protected function preprocessForm(JForm $form, $data, $group = 'content')
	{
		parent::preprocessForm($form, $data, $group);
	}
	

	/**
	 * Prepare and sanitise the table prior to saving.
	 *
	 * @since	1.6
	 */
	protected function prepareTable(&$table)
	{
		jimport('joomla.filter.output');
		include_once REF_ADMIN.'/class/detector/detector.php' ;
		
		$date 	= JFactory::getDate( 'now' , JFactory::getConfig()->get('offset') ) ;
		$user 	= JFactory::getUser() ;
		$db 	= JFactory::getDbo();
		
		
		// created date
		if(isset($table->created) && !$table->created){
			$table->created = $date->toSql();
		}
		
		$url 		= $table->url;
		
		$names		= json_decode( $this->getState('name') );
		$eng_name 	= array();
		$chinese_name = array_shift($names) ;
		foreach( $names as $val ):
			$eng_name[] = '"'.$val->first.' '.$val->last.'"' ;
			$eng_name[] = '"'.$val->last.', '.$val->first.'"' ;
		endforeach;
		$eng_name = implode(' OR ', $eng_name) ;
		
		$engines = array(
			'google',
			'bing'
		);
		
		// Visibility
		$query 	= " \"{$url}\" -site:{$url} " ;
		foreach( $engines as $engine ):
			$html = RefParser::getInstance($engine)->getFirstPageHTML( $query );
			$visibility[$engine] = RefDetector::detect('webometrics', $html, $engine);
		endforeach;
		$visibility = array_sum($visibility) ;
		
		
		// Size
		$query = " {$url} site:{$url} " ;
		foreach( $engines as $engine ):
			$html = RefParser::getInstance($engine)->getFirstPageHTML( $query );
			$size[$engine] = RefDetector::detect('webometrics', $html, $engine);
		endforeach;
		$size = array_sum($size);
		
		
		// Rich Files
		$query = " \"{$url}\" site:{$url} (filetype:pdf OR filetype:ppt OR filetype:doc )" ;
		foreach( $engines as $engine ):
			$html = RefParser::getInstance($engine)->getFirstPageHTML( $query );
			$files[$engine] = RefDetector::detect('webometrics', $html, $engine);
		endforeach;
		$files = array_sum($files);
		
		
		// Google Scholar
		$query 		= " \"{$chinese_name}\" OR {$eng_name} site:{$url}" ;
		$html 		= RefParser::getInstance('googlescholar')->getFirstPageHTML( $query );
		$scholar 	= RefDetector::detect('webometrics', $html, 'googlescholar');
		
		
		$table->web_scale 	= $size ;
		$table->visibility 	= $visibility ;
		$table->files 		= $files ;
		$table->scholarly 	= $scholar ;
	}

}