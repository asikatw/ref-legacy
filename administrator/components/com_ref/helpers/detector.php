<?php
/**
 * @version     1.0.0
 * @package     com_payany
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Ref helper.
 */
class RefHelperDetector
{
	/*
	 * function detect
	 * @param $args
	 */
	
	public static function detect($database = 'syllabus', $args)
	{
		include_once REF_ADMIN.'/class/detector/detector.php';
		
		switch($database) {
			default:
			case 'syllabus' :
				return RefDetector::detect($database, $args['txt'], $args['professors_names'], $args['professors_titles'],
									$args['units'], $args['course_terms'], $args['reference_terms']);
				break;
			
			case 'ndltd' :
				return RefDetector::detect($database, $args['txt'], $args['professors_names'] );
				break;
			
			case 'udn' :
				return RefDetector::detect($database, $args['txt'], $args['professors_names'] , $args['author_terms']);
				break;
			
			case 'readopac' :
				return RefDetector::detect($database, $args['txt'], $args['professors_names'] , $args['author_terms']);
				break;
			
			case 'webometrics' :
				return RefDetector::detect($database, $args['txt'], $args['engine'] );
				break;
			
			case 'wiki' :
				return RefDetector::detect($database, $args['txt'], $args['professors_names'] , $args['author_terms']);
				break;
		}
	}
	
	
	/*
	 * function saveResult
	 * @param $task_id
	 */
	
	public static function saveResult($task_id, $result)
	{
		$cited 		= JArrayHelper::getValue($result, 'cited', 0) ;
		$self_cited = JArrayHelper::getValue($result, 'self_cited', 0) ;
		$guidance 	= JArrayHelper::getValue($result, 'guidance', 0) ;
		$writings 	= JArrayHelper::getValue($result, 'writings', 0) ;
		$mentioned 	= JArrayHelper::getValue($result, 'mentioned', 0) ;
		$number 	= JArrayHelper::getValue($result, 'number', 0) ;
		$entries 	= JArrayHelper::getValue($result, 'entries', 0) ;
		
		$db = JFactory::getDbo();
		$q = $db->getQuery(true) ;
		
		$q->update('#__rp_results')
			->set( "cited = cited + {$cited}" )
			->set( "self_cited 	= self_cited 	+ {$self_cited}" )
			->set( "guidance 	= guidance 		+ {$guidance}" )
			->set( "writings 	= writings 		+ {$writings}" )
			->set( "mentioned 	= mentioned 	+ {$mentioned}" )
			->set( "entries 	= entries 		+ {$entries}" )
			->where("task_id={$task_id}")
			;
		
		$db->setQuery($q);
		$db->query();
	}
}
