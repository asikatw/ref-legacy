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
// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// Create shortcuts to some parameters.
$params		= $this->item->params;
$canEdit	= $this->item->params->get('access-edit');
$user		= JFactory::getUser();
?>

<div class="item-page<?php echo $params->get('pageclass_sfx')?>">
  <?php if ($params->get('show_title')|| $params->get('access-edit')) : ?>
  <h2 class="contentheading clearfix">
    <?php if ($params->get('link_titles') && !empty($this->item->readmore_link)) : ?>
    <?php echo $this->escape($this->item->title); ?>
    <?php else : ?>
    <?php echo $this->escape($this->item->title); ?>
    <?php endif; ?>
    <?php if ($canEdit) : ?>
    <span class="edit-icon"> <?php echo JHtml::_('icon.edit', $this->item, $params); ?> </span>
    <?php endif; ?>
  </h2>
  <?php endif; ?>
  <?php  if (!$params->get('show_intro')) :
		echo $this->item->event->afterDisplayTitle;
	endif; ?>
  <?php //echo $this->item->event->beforeDisplayContent; ?>
  <?php $useDefList = (($params->get('show_author')) OR ($params->get('show_category')) OR ($params->get('show_parent_category'))
	OR ($params->get('show_create_date')) OR ($params->get('show_modify_date')) OR ($params->get('show_publish_date'))
	OR ($params->get('show_hits'))); ?>
  <?php if ($params->get('access-edit') ||  $params->get('show_print_icon') || $params->get('show_email_icon') || $useDefList ) : ?>
  <div class="article-tools clearfix">
  <?php echo $this->item->event->beforeDisplayContent; ?>
    <?php if ($params->get('show_print_icon') || $params->get('show_email_icon')) : ?>
    <ul class="actions">
      <?php if (!$this->print) : ?>
      <?php if ($params->get('show_print_icon')) : ?>
			<li class="print-icon">
			<?php echo JHtml::_('icon.print_popup',  $this->item, $params); ?>
			</li>
			<?php endif; ?>
	
			<?php if ($params->get('show_email_icon')) : ?>
				<li class="email-icon">
				<?php echo JHtml::_('icon.email',  $this->item, $params); ?>
				</li>
			<?php endif; ?>
      <?php else : ?>
      <li> <?php echo JHtml::_('icon.print_screen',  $this->item, $params); ?> </li>
      <?php endif; ?>
    </ul>
    <?php endif; ?>
    <?php  if (!$params->get('show_intro')) :
		echo $this->item->event->afterDisplayTitle;
	endif; ?>
    
    <?php if ($useDefList) : ?>
    <dl class="article-info clearfix">
      <?php endif; ?>
      <?php if ($params->get('show_parent_category') && $this->item->parent_slug != '1:root') : ?>
      <dd class="parent-category-name">
        <?php	$title = $this->escape($this->item->parent_title);
					$url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->parent_slug)).'">'.$title.'</a>';?>
        <?php if ($params->get('link_parent_category') AND $this->item->parent_slug) : ?>
        <?php echo JText::sprintf('COM_CONTENT_PARENT', $url); ?>
        <?php else : ?>
        <?php echo JText::sprintf('COM_CONTENT_PARENT', $title); ?>
        <?php endif; ?>
      </dd>
      <?php endif; ?>
      <?php if ($params->get('show_category')) : ?>
      <dd class="category-name">
        <?php 	$title = $this->escape($this->item->category_title);
					$url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catslug)).'">'.$title.'</a>';?>
        <?php if ($params->get('link_category') AND $this->item->catslug) : ?>
        <?php echo JText::sprintf('JACOM_CONTENT_CATEGORY', $url); ?>
        <?php else : ?>
        <?php echo JText::sprintf('JACOM_CONTENT_CATEGORY', $title); ?>
        <?php endif; ?>
      </dd>
      <?php endif; ?>
      <?php if ($params->get('show_create_date')) : ?>
      <dd class="create"> <?php echo JText::sprintf('JACOM_CONTENT_CREATED_DATE_ON', JHTML::_('date',$this->item->created, JText::_('DATE_FORMAT_LC2'))); ?> </dd>
      <?php endif; ?>
      <?php if ($params->get('show_modify_date')) : ?>
      <dd class="modified"> <?php echo JText::sprintf('COM_CONTENT_LAST_UPDATED', JHTML::_('date',$this->item->modified, JText::_('DATE_FORMAT_LC2'))); ?> </dd>
      <?php endif; ?>
      <?php if ($params->get('show_publish_date')) : ?>
      <dd class="published"> <?php echo JText::sprintf('COM_CONTENT_PUBLISHED_DATE', JHTML::_('date',$this->item->publish_up, JText::_('DATE_FORMAT_LC2'))); ?> </dd>
      <?php endif; ?>
      <?php if ($params->get('show_author') && !empty($this->item->author)) : ?>
      <dd class="createdby">
	<?php $author = $this->item->created_by_alias ? $this->item->created_by_alias : $this->item->author; ?>
	<?php if (!empty($this->item->contactid) && $params->get('link_author') == true): ?>
	<?php
		$needle = 'index.php?option=com_contact&view=contact&id=' . $this->item->contactid;
		$item = JSite::getMenu()->getItems('link', $needle, true);
		$cntlink = !empty($item) ? $needle . '&Itemid=' . $item->id : $needle;
	?>
		<?php echo JText::sprintf('JACOM_CONTENT_WRITTEN_BY', JHtml::_('link', JRoute::_($cntlink), $author)); ?>
	<?php else: ?>
		<?php echo JText::sprintf('JACOM_CONTENT_WRITTEN_BY', $author); ?>
	<?php endif; ?>
      </dd>
      <?php endif; ?>
      <?php if ($params->get('show_hits')) : ?>
      <dd class="hits"> <?php echo JText::sprintf('COM_CONTENT_ARTICLE_HITS', $this->item->hits); ?> </dd>
      <?php endif; ?>
      <?php if ($useDefList) : ?>
    </dl>
    <?php endif; ?>
  </div>
  <?php endif; ?>
  <div class="article-content">
    <?php if (isset ($this->item->toc)) : ?>
    <?php echo $this->item->toc; ?>
    <?php endif; ?>
    <?php echo $this->item->text; ?> </div>
  <?php echo $this->item->event->afterDisplayContent; ?>
  <?php if ($params->get('show_modify_date')) : ?>
  <p class="modifydate"> <?php echo JText::sprintf('COM_CONTENT_LAST_UPDATED', JHTML::_('date',$this->item->modified, JText::_('DATE_FORMAT_LC2'))); ?> </p>
  <?php endif; ?>
</div>
