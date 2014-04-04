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
class RefModelEntry extends JModelAdmin
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
	public function getTable($type = 'Entry', $prefix = 'RefTable', $config = array())
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
		$form = $this->loadForm('com_ref.entry', 'entry', array('control' => 'jform', 'load_data' => $loadData));
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
		$data = JFactory::getApplication()->getUserState('com_ref.edit.entry.data', array());

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
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication();

		// Load state from the request.
		$pk = JRequest::getInt('id');
		$this->setState('item.id', $pk);

		// Load the parameters.
		$params = JComponentHelper::getParams('com_ref');
		$this->setState('params', $params);
		
		parent::populateState();
	}
	
	
	/*
	 * function getTasks
	 * @param 
	 */
	
	public function getTasksFromEntry()
	{
		$db = JFactory::getDbo();
		$q = $db->getQuery(true) ;
		$post = JRequest::get('post') ;
		
		$q->select("*")
			->from("#__rp_entries")
			->where("status = 0")
			;
			
		$db->setQuery($q);
		$entry = $db->loadObject();
		
		if(!$entry) return ;
		
		
		// Set Status = 1
		$entry->status = 1 ;
		$db->updateObject('#__rp_entries', $entry, 'id') ;
		
		
		// Init Controller
		include_once REF_ADMIN.'/controllers/task.php';
		$ctrl 	= new RefControllerTask ;
		$jform 	= array();
		$eng_name 	= array();
		$names  = json_decode($entry->name) ;
		$chinese_name = array_shift($names) ;
		foreach( $names as $val ):
			$eng_name[] = '"'.$val->first.' '.$val->last.'"' ;
			$eng_name[] = '"'.$val->last.', '.$val->first.'"' ;
		endforeach;
		$professors_name = $eng_name ;
		array_unshift($professors_name, $chinese_name);
		$eng_name = implode( ' OR ', $eng_name );
		$input = $app = JFactory::getApplication()->input ;
		
		
		// Get Syllabus
		// =============================================================================
		$jform['entry_id']	= $entry->id ;
		$jform['name'] 		= $entry->title . " [Syllabus]" ;
		$jform['published'] = 1 ;
		$jform['engine'] 	= 'google' ;
		$jform['database'] 	= 'syllabus' ;
		$jform['professors_name'] = $professors_name ;
		
		$jform['search_index_manual'] = <<<INDEX
("{$chinese_name}" OR {$eng_name} ) AND (課程大綱 OR "Syllabus")
INDEX;
		
		$token = JSession::getFormToken(true);
		$input->post->set('jform', $jform) ;
		$input->post->set($token, 1) ;
		JRequest::setVar('jform', $jform, 'POST', true) ;
		//JRequest::setVar($token, 1, 'POST', true) ;
		
		$ctrl->save();
		echo 'Syllabus OK.';
		
		
		
		// Get Ndltd
		// =============================================================================
		$jform['name'] 		= $entry->title . " [Ndltd]" ;
		$jform['published'] = 1 ;
		$jform['engine'] 	= 'google' ;
		$jform['database'] 	= 'ndltd' ;
		
		$jform['search_index_manual'] = <<<INDEX
("{$chinese_name}" OR {$eng_name} ) site:ndltd.ncl.edu.tw
INDEX;
		
		//$token = JSession::getFormToken(true);
		$input->post->set('jform', $jform) ;
		JRequest::setVar('jform', $jform, 'POST', true) ;
		//JRequest::setVar($token, 1, 'POST', true) ;
		
		$ctrl->save();
		echo 'Ndltd OK.';
		
		
		
		// Get Newspaper
		// =============================================================================
		$jform['name'] 		= $entry->title . " [UDN]" ;
		$jform['published'] = 1 ;
		$jform['engine'] 	= 'google' ;
		$jform['database'] 	= 'udn' ;
		
		$jform['search_index_manual'] = <<<INDEX
("{$chinese_name}" OR {$eng_name} ) site:udn.com
INDEX;
		
		//$token = JSession::getFormToken(true);
		$input->post->set('jform', $jform) ;
		JRequest::setVar('jform', $jform, 'post', true) ;
		//JRequest::setVar($token, 1, 'POST', true) ;
		
		$ctrl->save();
		
		
		
		// Get Readopac
		// =============================================================================
		$jform['name'] 		= $entry->title . " [Readopac]" ;
		$jform['published'] = 1 ;
		$jform['engine'] 	= 'google' ;
		$jform['database'] 	= 'readopac' ;
		
		$jform['search_index_manual'] = <<<INDEX
("{$chinese_name}" OR {$eng_name} ) site:readopac.ncl.edu.tw
INDEX;
		
		//$token = JSession::getFormToken(true);
		$input->post->set('jform', $jform) ;
		JRequest::setVar('jform', $jform, 'POST', true) ;
		//JRequest::setVar($token, 1, 'POST', true) ;
		
		$ctrl->save();
		
		
		
		// Get Wiki
		// =============================================================================
		$jform['name'] 		= $entry->title . " [Wiki]" ;
		$jform['published'] = 1 ;
		$jform['engine'] 	= 'google' ;
		$jform['database'] 	= 'wiki' ;
		
		$jform['search_index_manual'] = <<<INDEX
("{$chinese_name}" OR {$eng_name} ) site:zh.wikipedia.org/zh-tw
INDEX;
		
		//$token = JSession::getFormToken(true);
		$input->post->set('jform', $jform) ;
		JRequest::setVar('jform', $jform, 'POST', true) ;
		//JRequest::setVar($token, 1, 'POST', true) ;
		
		$ctrl->save();
		
		
		// Set Status = 1
		$entry->status = 2 ;
		$db->updateObject('#__rp_entries', $entry, 'id') ;
		//AK::show(JRequest::get());
		//AK::show($ctrl);
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
	protected function prepareTable($table)
	{
		jimport('joomla.filter.output');
		$data = JFactory::getApplication()->getUserState('com_ref.edit.entry.data', array());
		
		$date 	= JFactory::getDate( 'now' , JFactory::getConfig()->get('offset') ) ;
		$user 	= JFactory::getUser() ;
		$db 	= JFactory::getDbo();
		$app 	= JFactory::getApplication() ;
		
		// alias
        if( isset($table->alias) ) {
			
			if(!$table->alias){
				$table->alias = JFilterOutput::stringURLSafe( trim($table->title) ) ;
			}else{
				$table->alias = JFilterOutput::stringURLSafe( trim($table->alias) ) ;
			}
			
			if(!$table->alias){
				$table->alias = JFilterOutput::stringURLSafe( $date->toMySQL() ) ;
			}
		}
		
		// created date
		if(isset($table->created) && !$table->created){
			$table->created = $date->toMySQL();
		}
		
		// created user
		if(isset($table->created_by) && !$table->created_by){
			$table->created_by = $user->get('id');
		}
		
		// ordering
		if (!$table->id) {
			// Set ordering to the last item if not set
			if (!$table->ordering) {
				$db->setQuery('SELECT MAX(ordering) FROM #__rp_entries');
				$max = $db->loadResult();
				$table->ordering = $max+1;
			}
		}
		
		
		// REF
		$post 		= JRequest::get() ;
		$f_names 	= $post['first_name'];
		$l_names	= $post['last_name'];
		
		$uni_name 	= array();
		$name		= array();
		
		// set title
		foreach( $f_names as $key => $f_name ):
			if(trim($f_name) ){
				$uni_name[] = ucfirst($f_name) ;
				$eng['first'] 	= ucfirst($f_name) ;
				$eng['last'] 	= ucfirst($l_names[$key]) ;
				$name[] = $eng ;
			}
		endforeach;
		
		foreach( $l_names as $key => $l_name ):
			if(trim($l_name) ){
				$uni_name[] = ucfirst($l_name) ;
			}
		endforeach;
		
		$uni_name = array_unique($uni_name) ;
		sort($uni_name);
		$uni_name = implode(', ', $uni_name) ;
		
		$table->title = trim($post['name']).', '.trim($uni_name) ;
		array_unshift($name, $post['name']) ;
		$table->name = json_encode($name);
		
		
		// If Entry exists, Redirect
		$this->existsRedirect($table);
	}
	
	
	/*
	 * function existsRedirect
	 * @param arg
	 */
	
	public function existsRedirect($table)
	{
		$db = JFactory::getDbo();
		$app = JFactory::getApplication() ;
		
		$q = $db->getQuery(true) ;
		
		// Set Title LIKE
		$titles = explode(', ', $table->title);
		
		foreach( $titles as $title ):
			$q->where("title LIKE '%{$title}%'") ;
		endforeach;
		
		$q->select("id")
			->from("#__rp_entries")
			->order("title DESC")
			;
		$db->setQuery($q);
		$results = $db->loadColumn();
		
		$post = JRequest::get('post');
		$this->setState('name', $table->name) ;


		if($results) {
			$id = array_shift($results) ;
			if(count($results)) {
				$rel_ids = '&relative='.implode(',', $results) ;
			}
			
			$webo_url = $this->getWebometrics($id, $table->name);
			$post['site'] = $webo_url ;
			unset($post['task']);
			$post = json_encode($post);
			
			$url = "index.php?option=com_ref&view=result&id={$id}{$rel_ids}&q={$post}" ;
			$app->redirect( $url );
			jexit();
		}
	}
	
	
	/*
	 * function getWebometrics
	 * @param arg
	 */
	
	public function getWebometrics($entry_id = null, $name = array(), $url = null)
	{
		$post = JRequest::get('post') ;
		
		if( empty($post['database']['webometrics']) ) {
			return '' ;
		}elseif(empty($post['site'])){
			return '' ;
		}
		
		$db = JFactory::getDbo();
		$app = JFactory::getApplication() ;
		
		$q = $db->getQuery(true) ;
		
		$url = $url ? $url : JRequest::getVar('site') ;
		
		$urls = is_array($url) ? $url : array($url);
		$return = array();
		
		JModelLegacy::addIncludePath(REF_ADMIN.'/models');
		$model = JModelLegacy::getInstance('Webometric', 'RefModel');
		$model->setState('name', $name) ;
		
		foreach( $urls as $url ):
			$url = JFactory::getURI( $url ) ;
			$url->setScheme('');
			$url = trim( (string)$url ,'/');
			$q = $db->getQuery(true) ;
			
			$q->select("id")
				->from("#__rp_webometrics")
				->where("url='{$url}'")
				->where("entry_id={$entry_id}")
				;
			
			$db->setQuery($q);
			$result = $db->loadResult();
			
			if(!$result) {
				
				$data['entry_id'] = $entry_id ;
				$data['url'] = $url ;
				
				$model->save($data);
			}
		endforeach;
		
		return $urls ;
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
		
		$item = $this->getItem();
		
		$this->category  = JTable::getInstance('Category');
		$this->category->load($item->catid);
		
		return $this->category ;
	}
	
	
}