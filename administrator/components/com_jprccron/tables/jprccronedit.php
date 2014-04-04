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

class TableJPrcCronEdit extends JTable {

    /**
     * Primary Key
     *
     * @var int
     */
    var $id = null;
    var $task = null;
    var $type = null;
    var $published = null;
    var $mhdmd = null;
    var $file = null;
    var $ran_at = null;
    var $ok = null;
    var $log_text = null;
    var $unix_mhdmd = null;
    var $last_run = null;

    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function TableJPrcCronEdit(& $db) {
        parent::__construct('#__jprccron_tasks', 'id', $db);
    }

}