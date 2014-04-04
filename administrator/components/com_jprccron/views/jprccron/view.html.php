<?php
/* ------------------------------------------------------------------------
  # jprccron - Joomla cronjobs component for J1.6/1.7
  # ------------------------------------------------------------------------
  # author    Prieco S.A.
  # copyright Copyright (C) 2012 Prieco.com. All Rights Reserved.
  # @license - http://http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
  # Websites: http://www.prieco.com
  # Technical Support:  Forum - http://www.prieco.com/en/forum.html
  ------------------------------------------------------------------------- */

// No direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class JPrcCronViewJPrcCron extends JView {

    function display($tpl = null) {
        JToolBarHelper::title(JText::_('JPrcCron Scheduler - View Tasks '), 'logo.png');
        JToolBarHelper::publish();
        JToolBarHelper::unpublish();
        JToolBarHelper::addNewX();
        JToolBarHelper::editListX();
        JToolBarHelper::deleteList('Are you sure you want to delete selected items?');
        JToolBarHelper::preferences('com_jprccron', 300, 500);
        JToolBarHelper::help('screen.users.jprccron');

        JHTML::_('stylesheet', 'style.css', 'administrator/components/com_jprccron/assets/');

        // Get data from the model
        $items = & $this->get('Data');

        $this->assignRef('items', $items);
        $pagination = & $this->get('Pagination');
        $this->assignRef('pagination', $pagination);

        parent::display($tpl);
    }

}