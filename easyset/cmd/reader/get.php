<?php

include_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_ref'.DS.'class'.DS.'reader'.DS.'reader.php';
include_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_ref'.DS.'class'.DS.'detector'.DS.'detector.php';
include_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_ref'.DS.'helpers'.DS.'ref.php';

$id = JRequest::getVar('id') ;

$db = JFactory::getDbo();
$q = $db->getQuery(true) ;

$q->select('*')
	->from('#__rp_pages_data')
	->where('url_id = '.$id)
	;

$db->setQuery($q);
$result = $db->loadObject();
	
$file_path = $result->file_path ;

$txt = RefReader::read($file_path);

echo JRequest::getVar('html') ? htmlspecialchars($txt) : $txt ;
jexit();