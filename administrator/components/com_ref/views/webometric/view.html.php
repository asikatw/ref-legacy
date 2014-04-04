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
class RefViewWebometric extends RefView
{
	protected $state;
	protected $item;
	protected $form;
	
	public	$list_name = 'webometrics' ;
	public	$item_name = 'webometric' ;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$app = JFactory::getApplication() ;
		
		$this->state	= $this->get('State');
		$this->item		= $this->get('Item');
		$this->form		= $this->get('Form');
		$this->canDo	= RefHelper::getActions();

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		
		// if is frontend, show toolbar
		if($app->isAdmin())	{
			parent::display($tpl);
		}else{
			parent::displayWithPanel($tpl);
		}
	}

	/**
	 * Add the page title and toolbar.
	 */
	protected function addToolbar()
	{
		JRequest::setVar('hidemainmenu', true);

		$user		= JFactory::getUser();
		$isNew		= ($this->item->id == 0);

		JToolBarHelper::title( 'Webometric' . ' ' . JText::_('COM_REF_TITLE_ITEM_EDIT'), 'article-add.png');

		JToolBarHelper::apply('webometric.apply');
		JToolBarHelper::save('webometric.save');
		JToolBarHelper::custom('webometric.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
		JToolBarHelper::custom('webometric.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
		JToolBarHelper::cancel('webometric.cancel');
	}
}
