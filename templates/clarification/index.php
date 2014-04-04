<?php
/**
 * @version		1.0
 * @package		Joomla.Administrator
 * @subpackage	templates.clarification
 * @copyright	Copyright (C) 2011 four went ways. Based on BlueStork, the default admin template: Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

$app = JFactory::getApplication();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo  $this->language; ?>" lang="<?php echo  $this->language; ?>" dir="<?php echo  $this->direction; ?>" >
<head>
<jdoc:include type="head" />

<link rel="stylesheet" href="templates/system/css/system.css" type="text/css" />
<link href="templates/<?php echo  $this->template ?>/css/template.css" rel="stylesheet" type="text/css" />

<?php if ($this->direction == 'rtl') : ?>
	<link href="templates/<?php echo  $this->template ?>/css/template_rtl.css" rel="stylesheet" type="text/css" />
<?php endif; ?>

<!--[if IE 7]>
<link href="templates/<?php echo  $this->template ?>/css/ie7.css" rel="stylesheet" type="text/css" />
<![endif]-->

<!--[if gte IE 8]>
<link href="templates/<?php echo  $this->template ?>/css/ie8.css" rel="stylesheet" type="text/css" />
<![endif]-->

<?php if ($this->params->get('textBig')) : ?>
	<link rel="stylesheet" type="text/css" href="templates/<?php echo  $this->template ?>/css/textbig.css" />
<?php endif; ?>

</head>
<body id="minwidth-body">
	<?php if ($this->params->get('statusPosition')) : ?>
	<div id="status-line">
		<span class="title"><a href="index.php"><?php echo $this->params->get('showSiteName') ? $app->getCfg('sitename') : JText::_('TPL_CLARIFICATION_HEADER'); ?></a></span>
		<div id="module-status-top">
			<jdoc:include type="modules" name="status" />
		</div>
	</div>
	<?php endif; ?>
	<div id="header-box<?php if (!$this->params->get('statusPosition')) : ?>-nostatusline<?php endif; ?>">
		<span class="logo"><a href="http://www.joomla.org" target="_blank"><img src="templates/<?php echo  $this->template ?>/images/logo.png" alt="Joomla!" /></a></span>
		
		<?php if (!$this->params->get('statusPosition')) : ?>
		<span class="title" style="float:left;"><a href="index.php"><?php echo $this->params->get('showSiteName') ? $app->getCfg('sitename') : JText::_('TPL_CLARIFICATION_HEADER'); ?></a></span>
		<?php endif; ?>
		
		<div id="module-menu"<?php if ($this->params->get('statusPosition')) : ?> class="menu-alt"<?php endif; ?>>
			<jdoc:include type="modules" name="menu" />
		
			<?php
				//Display a harcoded logout
				$task = JRequest::getCmd('task');
				if ($task == 'edit' || $task == 'editA' || JRequest::getInt('hidemainmenu')) {
					$logoutLink = '';
				} else {
					$logoutLink = JRoute::_('index.php?option=com_users');
				}
				$hideLinks	= JRequest::getBool('hidemainmenu');
				$output = array();
				// Print the logout link.
				$output[] = ($hideLinks ? '' : '<a class="logout fltrt" href="'.$logoutLink.'">'.JText::_('JLOGOUT').'</a>');
				// Reverse rendering order for rtl display.
				if ($this->direction == "rtl") :
					$output = array_reverse($output);
				endif;
				// Output the items.
				foreach ($output as $item) :
				echo $item;
				endforeach;
			?>
		
		</div>
		<div class="clr"></div>
	</div>
	<div id="content-box">
		<div id="main-toolbar">
			<jdoc:include type="modules" name="toolbar" />
			<jdoc:include type="modules" name="title" />
		</div>
		<?php if (!JRequest::getInt('hidemainmenu')): ?>
		<jdoc:include type="modules" name="submenu" style="rounded" id="submenu-box" />
		<?php endif; ?>
		<div id="element-box">
			<jdoc:include type="message" />
			<jdoc:include type="component" />
			<div class="clr"></div>
		</div>
			
		<noscript>
			<?php echo  JText::_('JGLOBAL_WARNJAVASCRIPT') ?>
		</noscript>
		<div class="clr"></div>
	</div>
	<div class="clr"></div>

	<jdoc:include type="modules" name="footer" style="none"  />
	<div id="footer">
		<?php if (!$this->params->get('statusPosition')) : ?>
		<div id="module-status">
			<jdoc:include type="modules" name="status" />
		</div>
		<?php endif; ?>
		<p class="copyright">
			<?php $joomla= '<a href="http://www.joomla.org">Joomla!&#174;</a>';
				echo JText::sprintf('JGLOBAL_ISFREESOFTWARE', $joomla) ?>
			<span class="version"><?php echo  JText::_('JVERSION') ?> <?php echo  JVERSION; ?></span>
		</p>
	</div>
</body>
</html>
