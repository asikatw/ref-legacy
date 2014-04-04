<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

class RefController extends JControllerLegacy
{
	public function display( $cache=false, $urlparams = null )
	{
		JRequest::setVar('view', JRequest::getCmd('view','tasks') );
		
		parent::display($cache);
	}
}