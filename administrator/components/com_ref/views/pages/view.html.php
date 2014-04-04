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
class RefViewPages extends RefView
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->state		= $this->get('State');
		$this->task			= $this->get('Task');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->filter		= $this->get('Filter');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		
		$state	= $this->get('State');
		//$canDo	= RefHelper::getActions($state->get('filter.category_id'));

		JToolBarHelper::title(JText::_('搜尋結果') .": {$this->task->name}", 'pages.png');

        //Check if the form exists before showing the add/edit buttons
        
		JToolBarHelper::back( '回到搜尋引擎頁面' , JRoute::_('index.php?option=com_ref&view=task&layout=default&id='. JRequest::getVar('task_id') ) );
		//JToolBarHelper::addNew('page.add','JTOOLBAR_NEW');
		JToolBarHelper::editList('page.edit','編輯');
		JToolBarHelper::deleteList('', 'pages.delete','刪除');

		JToolBarHelper::divider();
		JToolBarHelper::publish('pages.publish', '啟動', true);
		JToolBarHelper::unpublish('pages.unpublish', '停止', true);
		//JToolBarHelper::custom('pages.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
	}
}
