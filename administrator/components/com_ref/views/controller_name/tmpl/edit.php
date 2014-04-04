<?php
/**
 * @version     1.0.0
 * @package     com_ref
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */

// no direct access
defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'webometric.cancel' || document.formvalidator.isValid(document.id('webometric-form'))) {
			Joomla.submitform(task, document.getElementById('webometric-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<form action="<?php echo JRoute::_( JFactory::getURI()->toString() ); ?>" method="post" name="adminForm" id="webometric-form" class="form-validate">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_REF_LEGEND_WEBOMETRIC'); ?></legend>
			<ul class="adminformlist">

            <?php foreach( $this->form->getFieldset('information') as $form ): ?>
            <li><?php echo $form->label.' '.$form->input; ?></li>
            <?php endforeach;?>

            </ul>
		</fieldset>
	</div>
	
	<input type="hidden" name="option" value="com_ref" />
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
	<div class="clr"></div>
</form>