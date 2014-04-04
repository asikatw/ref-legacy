<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;


include_once JPATH_COMPONENT_ADMINISTRATOR.DS.'includes'.DS.'import.php' ;

$controller = JControllerLegacy::getInstance('Ref');
 
// Perform the Request task
$controller->execute(JRequest::getCmd('task','tasks'));
 
// Redirect if set by the controller
$controller->redirect();
