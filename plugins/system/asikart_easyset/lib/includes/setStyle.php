<?php

function setStyle() {
	$doc = JFactory::getDocument();
	if( $doc->getType() != 'html' ) return ;

	
	//include_once AK_LIB_PATH.DS.'dom'.DS.'simple_html_dom.php';
	$body = JResponse::getBody();
	
	/*
	$html = new DOMDocument();
	$html->loadHTML($body);
	
	$head = $html->getElementsByTagName('head') ;
	$link = $html->createElement("link");
	$style = $head->item(0)->appendChild( $link ) ;
	$style->setAttribute( 'rel' , 'stylesheet' );
	$style->setAttribute( 'href' , 'easyset/custom.css' );
	$style->setAttribute( 'type' , 'text/css' );
	*/
	
	$body = explode( '</head>' , $body );
	$base = JURI::root();
	$style = "\n" ;
	
	if( AK::_( 'app.isSite' ) ):
		if(JVERSION < 3.0) $style .= '<link rel="stylesheet" href="'.AK_ADMIN_CSS_URL.'/system.css" type="text/css" />'."\n";
		$style .= '<link rel="stylesheet" href="'.AK_CSS_URL.'/custom-typo.css" type="text/css" />'."\n";
		$style .= '<link rel="stylesheet" href="'.AK_CSS_URL.'/custom.css" type="text/css" />'."\n";
	else:
		if(JVERSION < 3.0) $style .= '<link rel="stylesheet" href="'.AK_ADMIN_CSS_URL.'/system.css" type="text/css" />'."\n";
		$style .= '<link rel="stylesheet" href="'.AK_CSS_URL.'/custom-admin.css" type="text/css" />'."\n";
	endif;
	
	$body[0] .= $style ;
	
	
	//Fold content
    $replace['{fold}'] = '<div class="ak-fold-warp"><div class="ak-fold-outter"><div class="ak-fold-inner">';
    $replace['{/fold}'] = '</div></div><div class="ak-fold-button"></div></div><div class="clearfix"></div>';
    if( AK::_('app.isSite') ) $body[1] = strtr( $body[1] , $replace );
    
    $body = implode( '</head>' , $body );
	JResponse::setBody($body);
}
