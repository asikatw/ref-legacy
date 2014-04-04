<?php
/**
 * @version		$Id: view.html.php 21376 2011-05-24 17:11:48Z dextercowley $
 * @package		Joomla.Installation
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.view');
jimport('joomla.html.html');

/**
 * The HTML Joomla Core License View
 *
 * @package		Joomla.Installation
 * @since		1.6
 */
class JInstallationViewLicense extends JView
{
	/**
	 * Display the view
	 *
	 */
	public function display($tpl = null)
	{
		$state = $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->assignRef('state', $state);
		
		// get default Config (Asikart.com)
		$session = JFactory::getSession();
		$configbak = $session->get('setup.configbak',0) ;
		//$session->set('setup.options', array());
		
		require_once( JPATH_ROOT.DS.'installation'.DS.'configuration.php' );
		$config = new JConfig();
		
		// set DB config
		$config->db_user 	= $config->user ;
		$config->db_pass 	= $config->password ;
		$config->db_name 	= $config->db ;
		$config->db_type	= $config->dbtype ;
		$config->db_host	= $config->host ;
		$config->db_prefix	= $config->dbprefix ;
		
		// set Site config
		$config->site_name	= $config->sitename ;
		$config->site_metadesc = $config->MetaDesc ;
		$config->site_metakeys = $config->MetaKeys ;
		$config->admin_email 	= $config->mailfrom ;
		
		$config = get_object_vars($config);
		
		$options = $session->get('setup.options', array());
		$options = array_merge( $options , $config );
		
		$session->set('setup.options', $options);
		$session->set('setup.configbak', 1);
		//print_r( $session->get('setup.options', array()) ) ;
		
		parent::display($tpl);
	}
}