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
 * Engine controller class.
 */
class RefControllerEngine extends JControllerForm
{

    function __construct() {
        $this->view_list = 'engines';
        parent::__construct();
    }
	
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'Engine', $prefix = 'RefModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
	
		
	protected function getRedirectToItemAppend($recordId = null, $urlVar = 'id')
	{
		return parent::getRedirectToItemAppend($recordId , $urlVar );
	}
}