<?php
/**
 * @version     1.0.0
 * @package     com_fbimporter
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */


// no direct access
defined('_JEXEC') or die;

{COMPONENT_NAME}Loader('admin://class/plugin.class');

/**
 * Fbimporter Pro plugin
 */
class plg{COMPONENT_NAME_UCFIRST}Pro extends AKPlugin
{
	// Default {COMPONENT_NAME_UCFIRST} Events
	// ======================================================================================
	
	
	/*
	 * function onAKToolbarAppendButton
	 * @param $context
	 */
	
	public function onAKToolbarAppendButton($context, $args = array())
	{
		/*
		switch($context){
			case 'preferences' :
				$args[] = 550 ;
				$args[] = 875 ;
				$args[] = 'JToolbar_Options' ;
				$args[] = 'administrator/components/com_fbimporter/class/version/pro' ;
				break;
		}
		*/
	}
	
	
	/*
	 * function onAfterAddSubmenu
	 * @param $vName
	 */
	
	public function onAfterAddSubmenu($context, $vName)
	{
		
	}
	
	
	
	// Content Events
	// ======================================================================================
	
	
	/**
	 * Pro prepare content method
	 *
	 * Method is called by the view
	 *
	 * @param	string	The context of the content being passed to the plugin.
	 * @param	object	The content object.  Note $article->text is also available
	 * @param	object	The content params
	 * @param	int		The 'page' number
	 * @since	1.6
	 */
	public function onContentPrepare($context, &$article, &$params, $limitstart)
	{
		$app = JFactory::getApplication();
		
		// Code here
		
		
		@include $this->includeEvent(__FUNCTION__);
	}
	
	
	/**
	 * Pro after display title method
	 *
	 * Method is called by the view and the results are imploded and displayed in a placeholder
	 *
	 * @param	string		The context for the content passed to the plugin.
	 * @param	object		The content object.  Note $article->text is also available
	 * @param	object		The content params
	 * @param	int			The 'page' number
	 * @return	string
	 * @since	1.6
	 */
	public function onContentAfterTitle($context, &$article, &$params, $limitstart)
	{
		$app 	= JFactory::getApplication();
		$result = null ;
		
		// Code here
		
		
		@include $this->includeEvent(__FUNCTION__);
		
		return $result ;
	}
	
	
	/**
	 * Pro before display content method
	 *
	 * Method is called by the view and the results are imploded and displayed in a placeholder
	 *
	 * @param	string		The context for the content passed to the plugin.
	 * @param	object		The content object.  Note $article->text is also available
	 * @param	object		The content params
	 * @param	int			The 'page' number
	 * @return	string
	 * @since	1.6
	 */
	public function onContentBeforeDisplay($context, &$article, &$params, $limitstart)
	{
		$app 	= JFactory::getApplication();
		$result = null ;
		
		// Code here
		
		
		@include $this->includeEvent(__FUNCTION__);
		
		return $result ;
	}
	

	/**
	 * Pro after display content method
	 *
	 * Method is called by the view and the results are imploded and displayed in a placeholder
	 *
	 * @param	string		The context for the content passed to the plugin.
	 * @param	object		The content object.  Note $article->text is also available
	 * @param	object		The content params
	 * @param	int			The 'page' number
	 * @return	string
	 * @since	1.6
	 */
	public function onContentAfterDisplay($context, &$article, &$params, $limitstart)
	{
		$app 	= JFactory::getApplication();
		$result = null ;
		
		// Code here
		
		
		@include $this->includeEvent(__FUNCTION__);
		
		return $result ;
	}
	
	
	/**
	 * Pro before save content method
	 *
	 * Method is called right before content is saved into the database.
	 * Article object is passed by reference, so any changes will be saved!
	 * NOTE:  Returning false will abort the save with an error.
	 *You can set the error by calling $article->setError($message)
	 *
	 * @param	string		The context of the content passed to the plugin.
	 * @param	object		A JTableContent object
	 * @param	bool		If the content is just about to be created
	 * @return	bool		If false, abort the save
	 * @since	1.6
	 */
	public function onContentBeforeSave($context, &$article, $isNew)
	{
		$app 	= JFactory::getApplication();
		$result = array() ;
		
		// Code here
		
		
		@include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
	}
	
	
	/**
	 * Pro after save content method
	 * Article is passed by reference, but after the save, so no changes will be saved.
	 * Method is called right after the content is saved
	 *
	 * @param	string		The context of the content passed to the plugin (added in 1.6)
	 * @param	object		A JTableContent object
	 * @param	bool		If the content is just about to be created
	 * @since	1.6
	 */
	public function onContentAfterSave($context, &$article, $isNew)
	{
		$app 	= JFactory::getApplication();
		$result = array() ;
		
		// Code here
		
		
		@include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
	}
	

	/**
	 * Pro before delete method.
	 *
	 * @param	string	The context for the content passed to the plugin.
	 * @param	object	The data relating to the content that is to be deleted.
	 * @return	boolean
	 * @since	1.6
	 */
	public function onContentBeforeDelete($context, $data)
	{
		$result = array() ;
		
		// Code here
		
		
		@include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
	}
	
	
	/**
	 * Pro after delete method.
	 *
	 * @param	string	The context for the content passed to the plugin.
	 * @param	object	The data relating to the content that was deleted.
	 * @return	boolean
	 * @since	1.6
	 */
	public function onContentAfterDelete($context, $data)
	{
		$result = array() ;
		
		// Code here
		
		
		@include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
	}
	

	/**
	 * Pro after delete method.
	 *
	 * @param	string	The context for the content passed to the plugin.
	 * @param	array	A list of primary key ids of the content that has changed state.
	 * @param	int		The value of the state that the content has been changed to.
	 * @return	boolean
	 * @since	1.6
	 */
	public function onContentChangeState($context, $pks, $value)
	{
		$result = array() ;
		
		// Code here
		
		
		@include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
	}
	
	
	
	// Form Events
	// ====================================================================================
	
	
	/**
	 * @param	JForm	$form	The form to be altered.
	 * @param	array	$data	The associated data for the form.
	 *
	 * @return	boolean
	 * @since	1.6
	 */
	function onContentPrepareForm($form, $data)
	{
		$app 	= JFactory::getApplication() ;
		$result = null ;
		
		// Code here
		
		
		@include $this->includeEvent(__FUNCTION__);
		
		return $result;
	}
	
	
	
	// User Events
	// ====================================================================================
	
	
	/**
	 * Utility method to act on a user after it has been saved.
	 *
	 *
	 * @param	array		$user		Holds the new user data.
	 * @param	boolean		$isnew		True if a new user is stored.
	 * @param	boolean		$success	True if user was succesfully stored in the database.
	 * @param	string		$msg		Message.
	 *
	 * @return	void
	 * @since	1.6
	 */
	public function onUserBeforeSave($user, $isnew, $success, $msg)
	{
		$result = array() ;
		
		// Code here
		
		
		@include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
	}
	
	
	/**
	 * Utility method to act on a user after it has been saved.
	 *
	 *
	 * @param	array		$user		Holds the new user data.
	 * @param	boolean		$isnew		True if a new user is stored.
	 * @param	boolean		$success	True if user was succesfully stored in the database.
	 * @param	string		$msg		Message.
	 *
	 * @return	void
	 * @since	1.6
	 */
	public function onUserAfterSave($user, $isnew, $success, $msg)
	{
		$result = array() ;
		
		// Code here
		
		
		@include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
	}
	
	
	/**
	 * This method should handle any login logic and report back to the subject
	 *
	 * @param	array	$user		Holds the user data
	 * @param	array	$options	Array holding options (remember, autoregister, group)
	 *
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	public function onUserLogin($user, $options = array())
	{
		$result = array() ;
		
		// Code here
		
		
		@include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
	}
	
	
	/**
	 * This method should handle any logout logic and report back to the subject
	 *
	 * @param	array	$user		Holds the user data.
	 * @param	array	$options	Array holding options (client, ...).
	 *
	 * @return	object	True on success
	 * @since	1.5
	 */
	public function onUserLogout($user, $options = array())
	{
		$result = array() ;
		
		// Code here
		
		
		@include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
	}
	
	
	/**
	 * Utility method to act on a user before it has been saved.
	 *
	 *
	 * @param	array		$user		Holds the new user data.
	 * @param	boolean		$isnew		True if a new user is stored.
	 * @param	boolean		$success	True if user was succesfully stored in the database.
	 * @param	string		$msg		Message.
	 *
	 * @return	void
	 * @since	1.6
	 */
	public function onUserBeforeDelete($user, $isnew, $success, $msg)
	{
		$result = array() ;
		
		// Code here
		
		
		@include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
	}
	
	
	/**
	 * Remove all sessions for the user name
	 *
	 * @param	array		$user	Holds the user data
	 * @param	boolean		$succes	True if user was succesfully stored in the database
	 * @param	string		$msg	Message
	 *
	 * @return	boolean
	 * @since	1.6
	 */
	public function onUserAfterDelete($user, $succes, $msg)
	{
		$result = array() ;
		
		// Code here
		
		
		@include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
	}
	
	
	/**
	 * @param	string	$context	The context for the data
	 * @param	int		$data		The user id
	 * @param	object
	 *
	 * @return	boolean
	 * @since	1.6
	 */
	public function onContentPrepareData($context, $data)
	{
		$result = array() ;
		
		// Code here
		
		
		@include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
	}
}
