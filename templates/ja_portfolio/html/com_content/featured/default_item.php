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
defined('_JEXEC') or die('Restricted access'); 
$params = &$this->item->params;
$canEdit	= $this->item->params->get('access-edit');
?>
<?php
//Get out all images
$regex = "/\<img[^\>]*>/";
$images = '';
//print_r($this->item);die();
if (preg_match_all($regex,$this->item->introtext, $matches)) {
  $this->item->introtext = preg_replace ($regex, '', $this->item->introtext);
  $images = implode ("\n", $matches[0]);
}

?>
<div class="contentpaneopen<?php echo $this->escape($params->get( 'pageclass_sfx' )); ?> <?php if ($images): ?>haveimage<?php endif; ?> clearfix">
  <div class="article-main">
    <?php if ($params->get('show_title')) : ?>
    <h2 class="contentheading<?php echo $this->escape($params->get( 'pageclass_sfx' )); ?>">
      <?php if ($params->get('link_titles') && $params->get('access-view')) : ?>
      <a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid)); ?>"> <?php echo $this->escape($this->item->title); ?> </a>
      <?php else : ?>
      <?php echo $this->escape($this->item->title); ?>
      <?php endif; ?>
    	<?php if ($canEdit) : ?>
				<span class="edit-icon">
					<?php echo JHtml::_('icon.edit', $this->item, $params); ?>
				</span>
				<?php endif; ?>
    </h2>
    <?php endif; ?>
    <?php  if (!$this->item->params->get('show_intro')) :
	echo $this->item->event->afterDisplayTitle;
endif; ?>
    <?php
if (
($this->item->params->get('show_create_date'))
|| (($this->item->params->get('show_author')) && ($this->item->author != ""))
|| (($this->item->params->get('show_section') && $this->item->sectionid) || ($this->item->params->get('show_category') && $this->item->catid))
|| ($this->item->params->get('show_pdf_icon') || $this->item->params->get('show_print_icon') || $this->item->params->get('show_email_icon'))
|| ($this->item->params->get('show_url') && $this->item->urls)
) :
?>
    <div class="article-tools clearfix">
    <?php echo $this->item->event->beforeDisplayContent; ?>
      <dl class="article-info">
        <dd class="create">
		<?php echo JText::sprintf('JACOM_CONTENT_CREATED_DATE_ON', JHtml::_('date',$this->item->created, JText::_('DATE_FORMAT_LC3'))); ?>
		</dd>
<?php endif; ?>
<?php if ($params->get('show_modify_date')) : ?>
		<dd class="modified">
		<?php echo JText::sprintf('COM_CONTENT_LAST_UPDATED', JHtml::_('date',$this->item->modified, JText::_('DATE_FORMAT_LC3'))); ?>
		</dd>
<?php endif; ?>
<?php if ($params->get('show_publish_date')) : ?>
		<dd class="published">
		<?php echo JText::sprintf('COM_CONTENT_PUBLISHED_DATE', JHtml::_('date',$this->item->publish_up, JText::_('DATE_FORMAT_LC23'))); ?>
		</dd>
<?php endif; ?>
<?php if ($params->get('show_author') && !empty($this->item->author)) : ?>
	<dd class="createdby">
		<?php $author =  $this->item->author; ?>
		<?php $author = ($this->item->created_by_alias ? $this->item->created_by_alias : $author);?>

			<?php if (!empty($this->item->contactid ) &&  $params->get('link_author') == true):?>
				<?php 	echo JText::sprintf('JACOM_CONTENT_WRITTEN_BY' ,
				 JHtml::_('link',JRoute::_('index.php?option=com_contact&view=contact&id='.$this->item->contactid),$author)); ?>

			<?php else :?>
				<?php echo JText::sprintf('JACOM_CONTENT_WRITTEN_BY', $author); ?>
			<?php endif; ?>
		</dd>
	<?php endif; ?>
<?php if ($params->get('show_hits')) : ?>
		<dd class="hits">
		<?php echo JText::sprintf('COM_CONTENT_ARTICLE_HITS', $this->item->hits); ?>
		</dd>
      </dl>
      <?php if ($params->get('show_print_icon') || $params->get('show_email_icon') || $canEdit) : ?>
      <div class="buttonheading">
        <?php if ($params->get('show_email_icon')) : ?>
        <span class="ja-button-email"><?php echo JHtml::_('icon.email', $this->item, $params); ?></span>
        <?php endif; ?>
        <?php if ($params->get('show_print_icon')) : ?>
        <span class="ja-button-print"><?php echo JHtml::_('icon.print_popup', $this->item, $params); ?></span>
        <?php endif; ?>
      </div>
      <?php endif; ?>
      <?php if ($this->item->params->get('show_url') && $this->item->urls) : ?>
      <span class="article-url"> <a href="http://<?php echo $this->escape($this->item->urls) ; ?>" target="_blank"><?php echo $this->escape($this->item->urls); ?></a> </span>
      <?php endif; ?>
    
    <?php endif; ?>
    </div>
    <div class="article-content">
      <?php if ($images): ?>
      <?php echo $images ?>
      <?php endif; ?>
      <?php if (isset ($this->item->toc)) : ?>
      <?php echo $this->item->toc; ?>
      <?php endif; ?>
      <?php echo $this->item->introtext; ?> </div>
    <?php if ( intval($this->item->modified) != 0 && $this->item->params->get('show_modify_date')) : ?>
    <span class="modifydate"> <?php echo JText::sprintf('LAST_UPDATED2', JHTML::_('date', $this->item->modified, JText::_('DATE_FORMAT_LC2'))); ?> </span>
    <?php endif; ?>
    <?php if ($params->get('show_readmore') && $this->item->readmore) :
	if ($params->get('access-view')) :
		$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
	else :
		$menu = JFactory::getApplication()->getMenu();
		$active = $menu->getActive();
		$itemId = $active->id;
		$link1 = JRoute::_('index.php?option=com_users&view=login&&Itemid=' . $itemId);
		$returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
		$link = new JURI($link1);
		$link->setVar('return', base64_encode($returnURL));
	endif;
?>
    <p class="readmore"> <a href="<?php echo $link; ?>">
      <?php if (!$params->get('access-view')) :
						echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
					elseif ($readmore = $this->item->alternative_readmore) :
						echo $readmore;
						if ($params->get('show_readmore_title', 0) != 0) :
						    echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
						endif;
					elseif ($params->get('show_readmore_title', 0) == 0) :
						echo JText::sprintf('COM_CONTENT_READ_MORE_TITLE');	
					else :
						echo JText::_('COM_CONTENT_READ_MORE');
						echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
					endif; ?>
      </a> </p>
    <?php endif; ?>
  </div>
</div>
<?php echo $this->item->event->afterDisplayContent; ?>
<div class="item-separator"></div>