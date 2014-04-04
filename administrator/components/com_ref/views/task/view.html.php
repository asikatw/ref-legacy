<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

include_once JPATH_COMPONENT_ADMINISTRATOR.DS.'class'.DS.'view.class.php' ;

class RefViewTask extends RefView
{
	public function display($tpl=null)
	{
		$this->item = $this->get('Item');
		$this->form = $this->get('Form');
		$this->pages = $this->get('SearchPages');
		$this->data	= $this->getModel()->loadFormData() ;
		
		
		if( JRequest::getVar('layout') == 'edit' ){
			RefToolBar::title('Task Edit');
			RefToolBar::save('task.save', 'Save');
			RefToolBar::apply('task.apply' , 'Apply' );
			RefToolBar::cancel('task.cancel', 'Cancel' );
		}else{
			RefToolBar::title('Task: '. $this->item->name );
			RefToolBar::back('Back', 'index.php?option=com_ref&view=tasks');
		}
		
		parent::display($tpl);
	}
}