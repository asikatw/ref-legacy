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
 * Page controller class.
 */
class RefControllerPage extends JControllerForm
{

    function __construct() {
        $this->view_list = 'pages';
        parent::__construct();
    }
	
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'Page', $prefix = 'RefModel', $config = array('ignore_request' => false))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
	
		
	protected function getRedirectToItemAppend($recordId = null, $urlVar = 'id')
	{
		return parent::getRedirectToItemAppend($recordId , $urlVar ).'&task_id'.JRequest::getVar('task_id') ;
	}
	
	protected function getRedirectToListAppend()
	{
		return parent::getRedirectToListAppend().'&task_id'.JRequest::getVar('task_id') ;
	}
	
	
	/*
	 * function parseSearchPage
	 * @param 
	 */
	
	public function parseSearchPage() {
		$model = $this->getModel();
		$model->parseSearchPage();
		
		jexit();
	}
	
	
	/*
	 * function getResultPage
	 * @param $arg
	 */
	
	public function getResultPage() {
		$model = $this->getModel();
		$model->getResultPage();
		
		jexit();
	}
	
	
	/*
	 * function parseResultPage
	 * @param $arg
	 */
	
	public function parseResultPage() {
		$model = $this->getModel();
		$model->parseResultPage();
		
		jexit();
	}
	
	/*
	 * function cronTest
	 * @param $
	 */
	
	public function cronTest() {
		$file = JPATH_ROOT.DS.'cron.txt' ;
		$date = JFactory::getDate( 'now' , JFactory::getConfig()->get('offset') ) ;
		$text = $date->toMySQL();
		$method = JRequest::getVar('method') ;
		$text = 'Cron Log: '.$text." - {$method}\n" ;
		
		$fp = fopen($file, 'w+') ;
		fwrite($fp, $text);
		fclose($fp) ;
		
		jexit();
	}
	
	
	/*
	 * function test
	 * @param 
	 */
	
	public function test()
	{
		$url = new JObject();
		echo $url->url = 'https://nol.ntu.edu.tw/nol/coursesearch/print_table.php?course_id=103%2051180&amp;class=&amp;dpt_code=0000&amp;ser_no=10086&amp;semester=96-2' ;
		echo "\n";
		echo htmlspecialchars_decode($url->url);
		
		$url->task_id = 0 ;
		$url->file_type = 'html' ;
		$url->id = 1 ;
		
		//RF::_('curl.getPageFile' , $url ) ;
		
		/*
		$fp = fopen( JPATH_ROOT.'/test.html', 'w+' ) ;
		$ch = curl_init(  );
		
		$options = array(
			CURLOPT_URL 			=> $url,
			CURLOPT_RETURNTRANSFER 	=> true,
			CURLOPT_USERAGENT 		=> "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.1 (KHTML, like Gecko) Chrome/14.0.835.163 Safari/535.1",
			CURLOPT_FOLLOWLOCATION 	=> true ,
			CURLOPT_FILE			=> $fp ,
		);
		
		curl_setopt_array($ch, $options);
		
		$errno = curl_errno($ch);
		$errmsg = curl_error($ch);
		
		curl_close($ch);
		fclose($fp);
		
		echo file_get_contents(JPATH_ROOT.'/test.html');
		*/
		jexit();
	}
	
	
	/*
	 * function testDetector
	 * @param 
	 */
	
	public function testDetector()
	{
		include_once REF_ADMIN.DS.'class'.DS.'reader'.DS.'reader.php';
		include_once REF_ADMIN.DS.'class'.DS.'detector'.DS.'detector.php';
		$id = JRequest::getVar('file') ;
		
		$file = "files/{$id}" ;
		$txt = RefReader::read($file);
		$professors_names = array('黃俊傑') ;
		
		RefDetector::detect($txt, $professors_names);
		
		AK::show(RefDetector::$result);
		jexit();
	}
}