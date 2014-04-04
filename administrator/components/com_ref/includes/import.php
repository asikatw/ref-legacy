<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

$doc = JFactory::getDocument();
$app = JFactory::getApplication() ;

// define
define('REF_SITE' , JPATH_COMPONENT_SITE ) ;
define('REF_ADMIN', JPATH_COMPONENT_ADMINISTRATOR);

//include joomla api
jimport('joomla.application.component.controller');
jimport('joomla.application.component.controllerform');
jimport('joomla.application.component.controlleradmin');

jimport('joomla.application.component.view');

jimport('joomla.application.component.modeladmin');
jimport('joomla.application.component.modellist');
jimport('joomla.application.component.modelitem');

jimport('joomla.html.toolbar');

// include ref class
include_once JPath::clean( REF_ADMIN."/class/view.class.php" ) ;
include_once JPath::clean( REF_ADMIN."/helpers/ref.php" ) ;
include_once JPath::clean( REF_ADMIN."/helpers/toolbar.php" ) ;
include_once JPath::clean( REF_ADMIN."/parser/parser.php" ) ;


// include css
//$doc->addStyleSheet('administrator/templates/bluestork/css/template.css');
$doc->addStyleSheet('administrator/templates/isis/css/template.css');
$doc->addStyleSheet('components/com_ref/css/ref.css');

if($app->isSite()){
	JHtml::_('behavior.framework');
	$doc->addStyleSheet('components/com_ref/includes/css/fix-bootstrap-to-joomla.css');
	$doc->addScript('components/com_ref/includes/js/fix-bootstrap-to-joomla.js');
}