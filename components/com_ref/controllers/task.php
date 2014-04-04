<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

class RefControllerTask extends JControllerForm
{
	
	public function display($cache=false)
	{
		JRequest::setVar('view', JRequest::getCmd('view','tasks') );
		parent::display($cache);
	}
	/*
	public function add()
	{
		JRequest::setVar('layout', 'form' );
		$this->display();
	}
	*/
	public function getModel($type='task')
	{
		return parent::getModel($type, 'RefModel' , array() );
	}
	
	/*
	 * function postSaveHook
	 * @param 
	 */
	
	public function postSaveHook( &$model, $validData = array()) {
		
		if($validData['database'] != 'webometrics'){
			$model->saveSearchEngine($validData);
		}
	}
	
	
	/*
	 * function report
	 * @param 
	 */
	
	public function report()
	{
		include_once REF_ADMIN.DS.'includes'.DS.'PHPExcel.php';
		include_once REF_ADMIN.DS.'includes'.DS.'PHPExcel'.DS.'Writer'.DS.'Excel2007.php';
		$id = JRequest::getVar('id', 0) ;
		
		$model = $this->getModel();
		
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		$worksheet = $objPHPExcel->getActiveSheet();
		
		$content = $model->getReport();
		$task = $model->getItem();
		//AK::show($content);jexit();
		$worksheet->fromArray( $content, NULL, 'A1' );
		
		$objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('新細明體');
		
		$file_name = 'report-'.$task->name.'.xlsx' ;
		$path = JPATH_ROOT.DS.'files'.DS.$id.DS.$file_name ;
		
		if(JFile::exists($path))
			JFile::delete($path);
		
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save($path);
		
		$this->setRedirect(JURI::root()."files/{$id}/{$file_name}");
	}
}