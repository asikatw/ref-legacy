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
 * View to edit
 */
class RefViewEntry extends JViewLegacy
{
	protected $state;
	protected $item;
	protected $form;
	
	public	$list_name = 'entries' ;
	public	$item_name = 'entry' ;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$app 	= JFactory::getApplication() ;
		$user 	= JFactory::getUser() ;
		
		//$this->state	= $this->get('State');
		//$this->params	= $this->state->get('params');
		//$this->canDo	= RefHelper::getActions();
		
		$layout = $this->getLayout();
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		
		//$item->params = $this->params ;
		
		
		
		parent::display($tpl);
	}
	
	
	/**
	 * Add the page title and toolbar.
	 */
	protected function addToolbar()
	{
		JRequest::setVar('hidemainmenu', true);

		$user		= JFactory::getUser();
		$isNew		= ($this->item->id == 0);

		JToolBarHelper::title( 'Entry' . ' ' . JText::_('COM_REF_TITLE_ITEM_EDIT'), 'article-add.png');

		JToolBarHelper::apply('entry.apply');
		JToolBarHelper::save('entry.save');
		JToolBarHelper::custom('entry.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
		JToolBarHelper::custom('entry.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
		JToolBarHelper::cancel('entry.cancel');
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
