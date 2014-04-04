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

class JCronControllerJCronEdit extends JCronController {

    function __construct() {
        parent::__construct();

        // Register Extra tasks
        $this->registerTask('add', 'edit');
    }

    /**
     * display the edit form
     * @return void
     */
    function edit() {
        JRequest::setVar('view', 'jprccronedit');
        JRequest::setVar('hidemainmenu', 1);

        parent::display();
    }

    /**
     * save a record (and redirect to main page)
     * @return void
     */
    function save() {
        $model = $this->getModel('jprccronedit');
        $result = $model->store();
        if ($result[0]) {
            $msg = JText::_('Task Saved!');
        } else {
            $msg = JText::_('Error Saving Task');
        }

        // Check the table in so it can be edited.... we are done with it anyway
        $link = 'index.php?option=com_jprccron&view=jprccron';
        $this->setRedirect($link, $msg);
    }

    function apply() {
        $model = $this->getModel('jprccronedit');
        $result = $model->store();
        if ($result[0]) {
            $msg = JText::_('Task Saved!');
        } else {
            $msg = JText::_('Error Saving Task');
        }

        // Check the table in so it can be edited.... we are done with it anyway
        $link = 'index.php?option=com_jprccron&controller=jprccronedit&task=edit&cid[]=' . $result[1];
        $this->setRedirect($link, $msg);
    }

    /**
     * remove record(s)
     * @return void
     */
    function remove() {
        $model = $this->getModel('jprccronedit');
        if (!$model->delete()) {
            $msg = JText::_('Error: One or More Tasks Could not be Deleted');
        } else {
            $msg = JText::_('Task(s) Deleted');
        }

        $this->setRedirect('index.php?option=com_jprccron&view=jprccron', $msg);
    }

    /**
     * cancel editing a record
     * @return void
     */
    function cancel() {
        $msg = JText::_('Operation Cancelled');
        $this->setRedirect('index.php?option=com_jprccron&view=jprccron', $msg);
    }

    function publish() {
        $model = $this->getModel('jprccronedit');
        if (!$model->publish()) {
            $msg = JText::_('Error: One or More Tasks Could not be Published');
        } else {
            $msg = JText::_('Task(s) Published');
        }

        $this->setRedirect('index.php?option=com_jprccron&view=jprccron', $msg);
    }

    function unpublish() {
        $model = $this->getModel('jprccronedit');
        if (!$model->unpublish()) {
            $msg = JText::_('Error: One or More Tasks Could not be Unpublished');
        } else {
            $msg = JText::_('Task(s) Unpublished');
        }

        $this->setRedirect('index.php?option=com_jprccron&view=jprccron', $msg);
    }

}