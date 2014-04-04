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

class JCronViewAbout extends JView {

    /**
     * view display method
     * @return void
     * */
    function display($tpl = null) {
        JToolBarHelper::title(JText::_('JCron - CronTasks Scheduler'), 'logo.png');
        JToolBarHelper::preferences('com_jprccron', 250, 400);
        JToolBarHelper::help('screen.users.jprccron');

        $_CONFIG['incl_code'] = "\n<" . "?php /*JCron Code*/ $" . "from_template = 1;@include('components/com_jprccron/jprccron.php');/*DO NOT REMOVE ANYTHING*/ ?" . ">\n";
        $this->assignRef('code', $_CONFIG['incl_code']);
        JHTML::_('stylesheet', 'style.css', 'administrator/components/com_jprccron/assets/');
        parent::display($tpl);
    }

}