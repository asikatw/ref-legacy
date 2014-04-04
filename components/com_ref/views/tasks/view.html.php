<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

include_once JPATH_COMPONENT_ADMINISTRATOR.DS.'class'.DS.'view.class.php' ;

class RefViewTasks extends RefView
{
	public function display($tpl=null)
	{
		$this->setToolBar() ;
		
		$this->items 	= $this->get('Items');
		$this->pagin 	= $this->get('Pagination');
		$this->filter 	= $this->get('Filter');
		$this->state 	= (array)$this->getModel()->getState();
		
		parent::displayWithPanel($tpl);
	}
	
	public function setToolBar()
	{
		$user = JFactory::getUser() ;
		
		RefToolBar::title('Tasks List');
		
		if( $user->authorise('core.edit', 'com_ref') ) :
			RefToolBar::addNew('task.add','New');
			RefToolBar::publish('tasks.publish','Publish');
			RefToolBar::unpublish('tasks.unpublish','Unpublish');
			RefToolBar::deleteList('','tasks.delete','Delete');
			JToolBarHelper::preferences('com_ref');
		endif;
	}
}