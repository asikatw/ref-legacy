<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

class RefParserYahoo extends RefParser
{
	public $pages = 10 ;
	
	public $links = 100 ;
	
	public $url = 'http://tw.search.yahoo.com' ;
	
	public $path = '/search' ;
	
	public $query = array(
					'p' 	=> null ,
					//'hl' 	=> 'zh-TW' ,
					//'num' 	=> 100 ,
					//'filter'=> 0 ,
					//'safe' 	=> 'on',
					//'start' => null
						  ) ;
	
	/*
	 * function __construce
	 * @param $config
	 */
	
	public function __construce($config = array()) {
		
	}
	
	
	/*
	 * function getFirstPage
	 * @param $data
	 */
	
	public function getFirstPageHTML($keyword)
	{
		$uri 	= JURI::getInstance($this->url);
		$uri->setPath($this->path);
		
		$text = $keyword ;
		$text = trim($text);
		$text = urlencode($text);
		$text = str_replace( '%20' , '+' , $text );
		
		$uri->setQuery($this->query) ;
		$uri->setVar( 'p', $text );
		
		// get result pages num
		$first_page = RF::_('curl.getPageHTML' , $uri->toString() ) ;
		
		return $first_page ;
	}
	
	
	/*
	 * function getPageLists
	 * @param $data
	 */
	
	public function getPageLists($data) {
		include_once JPath::clean(REF_ADMIN.'/includes/dom/simple_html_dom.php') ;
		
		if(!$data->get('keyword')) return ;
		
		$pages 	= array();
		$uri 	= JURI::getInstance($this->url);
		$uri->setPath($this->path);
		
		$text = $data->keyword ;
		$text = trim($text);
		$text = urlencode($text);
		$text = str_replace( '%20' , '+' , $text );
		
		$uri->setQuery($this->query) ;
		$uri->setVar( 'p', $text );
		
		// get result pages num
		echo $first_page = RF::_('curl.getPageHTML' , $uri->toString() ) ;
		$page = str_get_html( $first_page );
		$td = $page->find('table#nav td') ;
		
		$num = count($td) ;
		$num = $num - 2 ;
		$num = ( $num < 1 ) ? 1 : $num ;
		
		$this->pages = $num ;

		
		foreach( range(1,$this->pages) as $page ){
			$pages[] = $uri->toString();
			$uri->setVar( 'start' , $uri->getVar('start') + $this->links );
		}
		
		return $pages ;
	}
	
	
	/*
	 * function parseSearchPage
	 * @param $
	 */
	
	public function parseSearchPage($html=null, $type = 'normal' ) {
		parent::parseSearchPage();
		
		$page = str_get_html( $html );
		$result = array();
		
		// get normal link
		$links = $page->find('div.vsc') ;
		foreach( $links as $k => $link ):
			$normal = $link->find('h3.r a') ;
			$result[$k]['normal']['name'] 	= strip_tags($normal[0]->innertext) ;
			$result[$k]['normal']['url'] 	= $normal[0]->href ;
			
			// file type
			$file_type = $link->find('span.xsm');
			$result[$k]['normal']['file_type'] = 'html' ;
			if(isset($file_type[0]->innertext)):
				$type = $file_type[0]->innertext ;
				$type = str_replace('[', '', $type) ;
				$type = str_replace(']', '', $type) ;
				$type = strtolower($type) ;
				$result[$k]['normal']['file_type'] = $type ;
			endif;
			
			// storage
			$storage = $link->find('span.gl a') ;
			$result[$k]['google-storage'] = null ;
			if(isset($storage[0]->href)):
				$result[$k]['google-storage'] = $result[$k]['normal'] ;
				$result[$k]['google-storage']['url'] = $storage[0]->href ;
			endif;
			
		endforeach;
		
		//AK::show($result);
		
		return $result ;
	}
}