<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

class RefController extends JControllerLegacy
{
	public function display( $cache=true, $urlparams = null)
	{
		
		JRequest::setVar('view', JRequest::getCmd('view','entries') );
		RefHelper::addSubmenu(JRequest::getVar('view'));
		parent::display($cache);
	}
}