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
		if (task == 'engine.cancel' || document.formvalidator.isValid(document.id('engine-form'))) {
			Joomla.submitform(task, document.getElementById('engine-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<div class="width-30 fltlft">
	<fieldset class="adminform">
		<legend><?php echo JText::_('COM_REF_LEGEND_ENGINE'); ?></legend>
		<ul class="adminformlist">

		<?php foreach( $this->form->getFieldset('information') as $form ): ?>
		<li><?php echo $form->label.' '.$form->input; ?></li>
		<?php endforeach;?>

		</ul>
	</fieldset>
</div>
<div class="width-70 fltrt">
	<fieldset class="adminform">
		<legend>Cache</legend>
		<div style="width:100%; overflow: scroll">
			<div style="-webkit-transform: scale(0.7); -webkit-transform-origin:0px 0px;">
				<pre>
					<?php echo $this->form->getField('cache')->value ; ?>
				</pre>	
			</div>
		</div>
	</fieldset>
</div>
	