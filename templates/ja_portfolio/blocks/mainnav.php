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
?>
<?php $this->genBlockBegin ($block) ?>
	<?php if (($jamenu = $this->loadMenu())) $jamenu->genMenu (); ?>
<?php $this->genBlockEnd ($block) ?>

<!-- jdoc:include type="menu" level="0" / -->
<?php if ($this->hasSubmenu() && ($jamenu = $this->loadMenu())) : ?>
<div id="ja-subnav" class="wrap">
<div class="main clearfix">
<?php $jamenu->genMenu (1); ?>
<!-- jdoc:include type="menu" level="1" / -->
</div>
</div>
<?php endif;?>

<ul class="no-display">
    <li><a href="<?php echo $this->getCurrentURL();?>#ja-content" title="<?php echo JText::_("Skip to content");?>"><?php echo JText::_("Skip to content");?></a></li>
</ul>
