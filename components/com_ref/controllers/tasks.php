<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

class RefControllerTasks extends JControllerAdmin
{
	public $view_list = 'tasks' ;
	
	public function getModel($type='task')
	{
		return parent::getModel($type);
	}
	
}