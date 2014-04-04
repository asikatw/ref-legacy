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
		if (task == 'entry.cancel' || document.formvalidator.isValid(document.id('entry-form'))) {
			Joomla.submitform(task, document.getElementById('entry-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<form action="<?php echo JRoute::_( JFactory::getURI()->toString() ); ?>" method="post" name="adminForm" id="entry-form" class="form-validate">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_REF_LEGEND_INFORMATION'); ?></legend>
			<ul class="adminformlist">

            <?php foreach( $this->form->getFieldset('information') as $form ): ?>
            <li><?php echo $form->label.' '.$form->input; ?></li>
            <?php endforeach;?>

            </ul>
		</fieldset>
	</div>
	
	<div class="width-40 fltrt">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_REF_LEGEND_PUBLISH'); ?></legend>
			<ul class="adminformlist">

            <?php foreach( $this->form->getFieldset('created') as $form ): ?>
            <li><?php echo $form->label.' '.$form->input; ?></li>
            <?php endforeach;?>

            </ul>
		</fieldset>
	</div>
	
	<div class="clr"></div>
	<?php if ($this->canDo->get('core.admin')): ?>
		<div class="">
			<?php //echo JHtml::_('sliders.start', 'permissions-sliders-'.$this->item->id, array('useCookie'=>1)); ?>

				<?php //echo JHtml::_('sliders.panel', JText::_('COM_REF_FIELDSET_RULES'), 'access-rules'); ?>
				<fieldset class="panelform">
					<?php //echo $this->form->getLabel('rules'); ?>
					<?php echo $this->form->getInput('rules'); ?>
				</fieldset>

			<?php //echo JHtml::_('sliders.end'); ?>
		</div>
	<?php endif; ?>
	
	<input type="hidden" name="option" value="com_ref" />
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
	<div class="clr"></div>
</form>