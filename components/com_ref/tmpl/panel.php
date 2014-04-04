<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

?>
<div id="ref-panel-wrap">
	<div class="ref-toolbar">
		<div id="ref-title" class="fltlft">
			<?php echo JFactory::getApplication()->JComponentTitle; ?>
		</div>
		<div id="ref-buttons" class="fltrgt">
			<?php echo JToolBar::getInstance('toolbar')->render('toolbar') ; ?>
		</div>
		<div class="clr"></div>
	</div>
	<div id="ref-panel" class="">
	<br />
		<form action="<?php echo JFactory::getURI()->toString();?>" name="adminForm" 
			id="adminForm" class="form-validate" method="post">
			<?php echo $this->loadInnerTemplate('default');?>
			
			<!-- Hidden Inputs -->
			<input type="hidden" id="option" 		name="option" 		value="com_ref" />
			<input type="hidden" id="task" 			name="task" 		value="" />
			<input type="hidden" id="boxchecked" 	name="boxchecked" 	value="0" />
			<input type="hidden" id="filter_order" 	name="filter_order" value="<?php echo $this->getModel()->getState('list.ordering'); ?>" />
			<input type="hidden" id="filter_order_Dir" name="filter_order_Dir" value="<?php echo $this->getModel()->getState('list.direction'); ?>" />
			<?php echo JHtml::_('form.token'); ?>
		</form>
	</div>
</div>