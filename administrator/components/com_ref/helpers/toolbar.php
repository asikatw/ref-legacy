<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

include_once JPATH_ADMINISTRATOR.DS.'includes'.DS.'toolbar.php' ;

class RefToolBar extends JToolBarHelper
{
	static function title ($title, $icon = 'generic.png')
	{
		$doc = JFactory::getDocument();
		$app = JFactory::getApplication();
		
		$doc->setTitle($title) ;
		
		// Strip the extension.
		$icons = explode(' ', $icon);
		foreach($icons as &$icon) {
			//$icon = 'icon-48-'.preg_replace('#\.[^.]*$#', '', $icon);
		}

		$html = '<div class="pagetitle"><h2>'.$title.'</h2></div>';		
		
		$app->JComponentTitle = $html ;
	}
	
	/*
	 * function link
	 * @param $arg
	 */
	
	public static function link($url = 'javascript:history.back(1);' , $text = 'Back' , $icon='back') {
		$bar	= JToolBar::getInstance('toolbar');
		$bar->appendButton( 'link' , $icon , $text , JRoute::_($url) );
	}
}