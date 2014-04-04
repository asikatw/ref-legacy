<?php
/**
 * @version		1.0
 * @package		Joomla.Administrator
 * @subpackage	templates.clarification
 * @copyright	Copyright (C) 2011 four went ways. Based on BlueStork, the default admin template: Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

$app = JFactory::getApplication();
JHtml::_('behavior.noframes');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>
<jdoc:include type="head" />

<link rel="stylesheet" href="templates/system/css/system.css" type="text/css" />
<link href="templates/<?php echo $this->template ?>/css/template.css" rel="stylesheet" type="text/css" />

<?php  if ($this->direction == 'rtl') : ?>
	<link href="templates/<?php echo $this->template ?>/css/template_rtl.css" rel="stylesheet" type="text/css" />
<?php  endif; ?>

<!--[if IE 7]>
<link href="templates/<?php echo  $this->template ?>/css/ie7.css" rel="stylesheet" type="text/css" />
<![endif]-->

<!--[if lte IE 6]>
<link href="templates/<?php echo  $this->template ?>/css/ie6.css" rel="stylesheet" type="text/css" />
<![endif]-->

<?php if ($this->params->get('textBig')) : ?>
	<link rel="stylesheet" type="text/css" href="templates/<?php echo  $this->template ?>/css/textbig.css" />
<?php endif; ?>

<script type="text/javascript">
	function setFocus() {
		document.getElementById('form-login').username.select();
		document.getElementById('form-login').username.focus();
	}
</script>
</head>
<body id="login" onload="javascript:setFocus()">

	<div id="content-box">
		<div class="padding">
			<div class="clr"></div>
			<div id="element-box" class="login">
				<div class="m wbg">
					<h1><?php echo JText::_('COM_LOGIN_JOOMLA_ADMINISTRATION_LOGIN') ?></h1>
					<jdoc:include type="message" />
					<jdoc:include type="component" />
					<p><?php echo JText::_('COM_LOGIN_VALID') ?></p>
					<p><a href="<?php echo JURI::root(); ?>"><?php echo JText::_('COM_LOGIN_RETURN_TO_SITE_HOME_PAGE') ?></a></p>
					<div id="lock"></div>
					<div class="clr"></div>
				</div>
			</div>
			<noscript>
				<?php echo JText::_('JGLOBAL_WARNJAVASCRIPT') ?>
			</noscript>
			<div class="clr"></div>
		</div>
	</div>
	
	<div id="footer">
		<p class="copyright" style="text-align:center;">
			<?php $joomla= '<a href="http://www.joomla.org">Joomla!&#174;</a>';
			echo JText::sprintf('JGLOBAL_ISFREESOFTWARE', $joomla) ?>
		</p>
	</div>
</body>
</html>
