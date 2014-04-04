<?php
/**
 * @version     1.0.0
 * @package     com_ref
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Ref.
 */
class RefViewResult extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;
	
	public	$list_name = 'entries' ;
	public	$item_name = 'entry' ;
	
	public	$lead_items ;
	public	$intro_items ;
	public	$link_items ;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$app = JFactory::getApplication() ;
		
		$this->state		= $this->get('State');
		$this->params		= $this->state->get('params');
		//$this->category		= $this->get('Category');
		$this->entry		= $this->get('Entry');
		$this->results		= $this->get('Results');
		$this->relative		= $this->get('Relative');
		
		//$this->pagination	= $this->get('Pagination');
		//$this->filter		= $this->get('Filter');

		
		
		// Check for errors.
		// =====================================================================================
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		
		
		// Set Name
		$name = $this->entry->get('name') ;
		$name = json_decode($name) ;
		$this->entry->set('chinese_name', array_shift($name)) ;
		if(!count($name)) {
			$name[0] = new JObject();
		}
		$this->entry->set('eng_name', $name) ;
		
		// Set Input
		$q = JRequest::getVar('q') ;
		$q = json_decode($q) ;
		$this->q = $q ;
		
		if( isset($this->q->database->webometrics) ){
			$this->webometrics	= $this->get('Webometrics');
		}
		
		parent::display($tpl);
	}
	
	
	/*
	 * function showInfo
	 * @param $key
	 */
	
	public function showInfo( $item, $key = null, $label = null, $strip = true, $link = null ,$class = null)
	{
		if(empty($item->$key)){
			return false ;
		}
		
		$lang  = $strip ? substr($key, 2) : $key ;
		
		if(!$label){
			$label = JText::_('COM_REF_'.strtoupper($lang)) ;
		}else{
			$label = JText::_(strtoupper($label)) ;
		}
		
		$value = $item->$key ;
		
		if($link){
			$value = JHtml::_('link', $link, $value);
		}
		
		$lang = str_replace( '_', '-', $lang );
		
		$info =
<<<INFO
		<div class="{$lang} {$class}" fltlft">
			<span class="label">{$label}:</span>
			<span class="valur">{$value}</span>
		</div>
INFO;
		return $info ;
	}
	
}
