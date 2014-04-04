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
class RefViewWebometrics extends JView
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
		$canDo	= RefHelper::getActions($state->get('filter.category_id'));

		JToolBarHelper::title(JText::_('COM_REF_TITLE_WEBOMETRICS'), 'webometrics.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR.DS.'views'.DS.'webometric';
        if (file_exists($formPath)) {
            if ($canDo->get('core.create')) {
			    JToolBarHelper::addNew('webometric.add','JTOOLBAR_NEW');
		    }

		    if ($canDo->get('core.edit')) {
			    JToolBarHelper::editList('webometric.edit','JTOOLBAR_EDIT');
			    JToolBarHelper::deleteList('', 'webometrics.delete','JTOOLBAR_EMPTY_TRASH');
		    }
        }

		if ($canDo->get('core.edit.state')) {
			    JToolBarHelper::divider();
			    JToolBarHelper::publish('webometrics.publish', 'JTOOLBAR_ENABLE', true);
				JToolBarHelper::unpublish('webometrics.unpublish', 'JTOOLBAR_DISABLE', true);
            	JToolBarHelper::custom('webometrics.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
		}
        
		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_ref');
		}

	}
}
