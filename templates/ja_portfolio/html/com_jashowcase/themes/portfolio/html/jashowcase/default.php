<?php
/*
 * ------------------------------------------------------------------------
 * JA Portfolio template for Joomla 1.7.x
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2011 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - Copyrighted Commercial Software
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites:  http://www.joomlart.com -  http://www.joomlancers.com
 * This file may not be redistributed in whole or significant part.
 * ------------------------------------------------------------------------
*/

defined ( '_JEXEC' ) or die ( 'Restricted access' );
//include script, css file
echo $this->loadTemplate('head');

//load html
echo $this->loadTemplate('main');
?>