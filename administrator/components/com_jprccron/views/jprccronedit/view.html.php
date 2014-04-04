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

class JPrcCronViewJPrcCronEdit extends JView {

    function display($tpl = null) {
        $cron = & $this->get('Data');

        $isNew = ($cron->id < 1);
        $text = $isNew ? JText::_('Add') : JText::_('Edit');

        JToolBarHelper::title(JText::_('JPrcCron Scheduler - ') . $text, 'logo.png');
        JToolBarHelper::save();
        JToolBarHelper::apply();

        if ($isNew) {
            JToolBarHelper::cancel();
            $fs = array('0', '3', '*', '*', '*');
            $cron->mhdmd = implode(" ", $fs);
        } else {
            // for existing items the button is renamed `close`
            JToolBarHelper::cancel('cancel', 'Close');
            $fs = explode(" ", $cron->mhdmd);
        }

        /* Set drop-down list with tasks  */
        $option = array();
        $option[] = JHTML::_('select.option', '0', 'SSH Command');
        $option[] = JHTML::_('select.option', '1', 'Web Address fopen()');
        $option[] = JHTML::_('select.option', '2', 'Web Address fsockopen()');
        $option[] = JHTML::_('select.option', '3', 'Plugin');  //Added #PN 2010-02-15

        $crontype = JHTML::_('select.genericlist', $option, 'type', null, 'value', 'text', $cron->type);
        $cron->type = $crontype;

        /* Set drop-down list with minutes  */

        $option = array();
        $option[] = JHTML::_('select.option', '*', 'Every Minute');
        $option[] = JHTML::_('select.option', '*/2', 'Every Other Minute');
        $option[] = JHTML::_('select.option', '*/5', 'Every Five Minutes');
        $option[] = JHTML::_('select.option', '*/10', 'Every Ten Minutes');
        $option[] = JHTML::_('select.option', '*/15', 'Every Fifteen Minutes');

        for ($i = 0; $i < 60; $i++)
            $option[] = JHTML::_('select.option', $i, $i);

        $minutes = JHTML::_('select.genericlist', $option, 'minute2', array('size' => 10), 'value', 'text', $fs[0]);
        $cron->minutes = $minutes;


        /* Set drop-down list with hours  */

        $option = array();
        $option[] = JHTML::_('select.option', '*', 'Every Hour');
        $option[] = JHTML::_('select.option', '*/2', 'Every Other Hour');
        $option[] = JHTML::_('select.option', '*/4', 'Every Four Hours');
        $option[] = JHTML::_('select.option', '*/6', 'Every Six Hours');
        $option[] = JHTML::_('select.option', '0', '12 AM/Midnight');

        for ($i = 1; $i < 24; $i++)
            if ($i < 12)
                $option[] = JHTML::_('select.option', $i, $i . ' = ' . $i . ' AM');
            elseif ($i == 12)
                $option[] = JHTML::_('select.option', $i, $i . ' = ' . $i . ' PM/Noon');
            else
                $option[] = JHTML::_('select.option', $i, $i . ' = ' . ($i - 12) . ' PM');

        $hours = JHTML::_('select.genericlist', $option, 'hour2', array('size' => 10), 'value', 'text', $fs[1]);
        $cron->hours = $hours;


        /* Set drop-down list with days  */

        $option = array();
        $option[] = JHTML::_('select.option', '*', 'Every Day');

        for ($i = 1; $i <= 31; $i++)
            $option[] = JHTML::_('select.option', $i, $i);

        $days = JHTML::_('select.genericlist', $option, 'day2', array('size' => 10), 'value', 'text', $fs[2]);
        $cron->days = $days;


        /* Set drop-down list with weekdays  */

        $option = array();
        $option[] = JHTML::_('select.option', '*', 'Every Weekday');

        $date = &JFactory::getDate();

        for ($i = 0; $i <= 6; $i++)
            $option[] = JHTML::_('select.option', $i, $this->dayToString($i));

        $weekdays = JHTML::_('select.genericlist', $option, 'weekday2', array('size' => 10), 'value', 'text', $fs[4]);
        $cron->weekdays = $weekdays;


        /* Set drop-down list with months  */

        $option = array();
        $option[] = JHTML::_('select.option', '*', 'Every Month');

        for ($i = 1; $i <= 12; $i++)
            $option[] = JHTML::_('select.option', $i, $this->monthToString($i));

        $months = JHTML::_('select.genericlist', $option, 'month2', array('size' => 10), 'value', 'text', $fs[3]);
        $cron->months = $months;


        $this->assignRef('cron', $cron);
        JHTML::_('script', 'script.js', 'administrator/components/com_jprccron/assets/');
        JHTML::_('stylesheet', 'style.css', 'administrator/components/com_jprccron/assets/');

        parent::display($tpl);
    }

    function dayToString($day, $abbr = false) {
        switch ($day) {
            case 0: return $abbr ? JText::_('SUN') : JText::_('SUNDAY');
            case 1: return $abbr ? JText::_('MON') : JText::_('MONDAY');
            case 2: return $abbr ? JText::_('TUE') : JText::_('TUESDAY');
            case 3: return $abbr ? JText::_('WED') : JText::_('WEDNESDAY');
            case 4: return $abbr ? JText::_('THU') : JText::_('THURSDAY');
            case 5: return $abbr ? JText::_('FRI') : JText::_('FRIDAY');
            case 6: return $abbr ? JText::_('SAT') : JText::_('SATURDAY');
        }
    }

    function monthToString($month, $abbr = false) {
        switch ($month) {
            case 1: return $abbr ? JText::_('JANUARY_SHORT') : JText::_('JANUARY');
            case 2: return $abbr ? JText::_('FEBRUARY_SHORT') : JText::_('FEBRUARY');
            case 3: return $abbr ? JText::_('MARCH_SHORT') : JText::_('MARCH');
            case 4: return $abbr ? JText::_('APRIL_SHORT') : JText::_('APRIL');
            case 5: return $abbr ? JText::_('MAY_SHORT') : JText::_('MAY');
            case 6: return $abbr ? JText::_('JUNE_SHORT') : JText::_('JUNE');
            case 7: return $abbr ? JText::_('JULY_SHORT') : JText::_('JULY');
            case 8: return $abbr ? JText::_('AUGUST_SHORT') : JText::_('AUGUST');
            case 9: return $abbr ? JText::_('SEPTEMBER_SHORT') : JText::_('SEPTEMBER');
            case 10: return $abbr ? JText::_('OCTOBER_SHORT') : JText::_('OCTOBER');
            case 11: return $abbr ? JText::_('NOVEMBER_SHORT') : JText::_('NOVEMBER');
            case 12: return $abbr ? JText::_('DECEMBER_SHORT') : JText::_('DECEMBER');
        }
    }

}