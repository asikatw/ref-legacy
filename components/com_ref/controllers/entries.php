<?php
/**
 * @version     1.0.0
 * @package     com_ref
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

/**
 * Entries list controller class.
 */
class RefControllerEntries extends JControllerAdmin
{
	public $view_list = 'entries' ;
	public $view_item = 'entry' ;
	
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function &getModel($name = 'entry', $prefix = 'RefModel')
	{
		$model = parent::getModel($name, $prefix, array());
		return $model;
	}
	
	
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
}