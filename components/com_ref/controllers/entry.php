<?php
/**
 * @version     1.0.0
 * @package     com_ref
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Entry controller class.
 */
class RefControllerEntry extends JControllerForm
{
	
	public $view_list = 'entries' ;
	public $view_item = 'entry' ;
	
	public $redirect ;
	
    function __construct() {
		
		$this->allow_url_params = array(
			'return'
		);
		
        parent::__construct();
    }
	
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'Entry', $prefix = 'RefModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
	
	
	/*
	 * function save
	 * @param arg
	 */
	
	public function save($key = null, $urlVar = null)
	{
		$result = parent::save($key, $urlVar) ;
		
		if($result) {
			$post = JRequest::get('post');
			$post = json_encode($post) ;
	
				
			$url = "index.php?option=com_ref&view=entry" ;
			$this->setRedirect($url, '您所搜尋的教授尚未在資料庫中統計過，目前已排入統計流程，請稍待60分鐘後再重新搜尋。<br />請注意：太早回來搜尋，統計結果可能不正確。');
		}
		
		return $result ;
	}
	
	
	/*
	 * function getTasks
	 * @param 
	 */
	
	public function getTasksFromEntry()
	{
		
		$model = $this->getModel();
		$model->getTasksFromEntry();
		
		jexit();
	}
	
	
	
	public function batch($model = null)
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Set the model
		$model = $this->getModel();

		// Preset the redirect
		$this->setRedirect(JRoute::_('index.php?option=com_ref&view=entries' . $this->getRedirectToListAppend(), false));

		return parent::batch($model);
	}
	
	protected function getRedirectToItemAppend($recordId = null, $urlVar = 'id')
	{
		$append = parent::getRedirectToItemAppend($recordId , $urlVar );
		
		foreach( $this->allow_url_params as $param ):
			if(JRequest::getVar($param)){
				$append .= "&{$param}=" . JRequest::getVar($param) ;
			}
		endforeach;
		
		return $append ;
	}
	
	protected function getRedirectToListAppend()
	{
		$append = parent::getRedirectToListAppend();
		
		foreach( $this->allow_url_params as $param ):
			if(JRequest::getVar($param)){
				$append .= "&{$param}=" . JRequest::getVar($param) ;
			}
		endforeach;
		
		return $append ;
	}
	
	protected function postSaveHook( &$model, $validData = array())
    {
		
    }
	
	/*
	public function setRedirect($url, $msg = null, $type = null)
    {
		$task  = $this->getTask() ;
		$redirect_tasks = array('save', 'cancel', 'publish', 'unpublish', 'delete');
		
		if(!$this->redirect){
			$this->redirect = base64_decode(JRequest::getVar('return')) ;
		}
		
        if ($this->redirect && in_array($task, $redirect_tasks)){
            return parent::setRedirect($this->redirect, $msg, $type) ;
        }else{
			return parent::setRedirect($url, $msg, $type) ;
		}
    }
    */
}