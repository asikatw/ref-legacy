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
JHtml::_('behavior.multiselect');

$user	= JFactory::getUser();
$userId	= $user->get('id');

$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$canOrder	= $user->authorise('core.edit.state', 'com_ref');
$saveOrder	= $listOrder == 'a.ordering';
?>

<form action="<?php echo JRoute::_('index.php?option=com_ref&view=webometrics'); ?>" method="post" name="adminForm" id="adminForm">
	<fieldset id="filter-bar">
		<div class="filter-search fltlft pull-left">
			
			<?php
				$field = $this->filter['search']->getField('field') ;
				echo $field->label . ' ' ;
				
				if( !$this->state->get('search.fulltext') ){
					echo $field->input ;
				}
			?>
			
			<?php 
				$index = $this->filter['search']->getField('index') ;
				echo $index->input ;
			?>
			<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('search_index').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
		<div class="filter-select fltrt pull-right">
 			<?php 
				foreach($this->filter['filter']->getFieldset('filter') as $filter ):
					echo $filter->input ;
				endforeach;
			?>
		</div>
		
		<div class="clr"> </div>
	</fieldset>
	

	<table class="adminlist table table-striped">
		<thead>
			<tr>
				<th width="1%">
					<input type="checkbox" name="checkall-toggle" value="" onclick="Joomla.checkAll(this)" />
				</th>
				
				<th>
					<?php echo JHtml::_('grid.sort',  'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder); ?>
				</th>

				
				
                <th width="1%" class="nowrap">
                    <?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
                </th>

			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="10">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php foreach ($this->items as $i => $item) :
			
			$item = new JObject($item);
			
			$ordering	= ($listOrder == 'a.ordering');
			$canCreate	= $user->authorise('core.create',		'com_ref');
			$canEdit	= $user->authorise('core.edit',			'com_ref');
			$canCheckin	= $user->authorise('core.manage',		'com_ref');
			$canChange	= $user->authorise('core.edit.state',	'com_ref');
			$canEditOwn = $user->authorise('core.edit.own',		'com_ref');
			?>
			<tr class="row<?php echo $i % 2; ?>">
				<td class="center">
					<?php echo JHtml::_('grid.id', $i, $item->a_id); ?>
				</td>
				
				<td>
					<?php if ($item->get('a_checked_out')) : ?>
						<?php echo JHtml::_('jgrid.checkedout', $i, $item->get('a_checked_out'), $item->get('a_checked_out_time'), 'webometrics.', $canCheckin); ?>
					<?php endif; ?>
					<?php if ($canEdit || $canEditOwn) : ?>
						<a href="<?php echo JRoute::_('index.php?option=com_ref&task=webometric.edit&id='.$item->a_id); ?>">
							<?php echo $item->get('a_url'); ?>
						</a>
					<?php else: ?>
						<?php echo $item->get('a_title'); ?>
					<?php endif; ?>
					<p class="smallsub">
						<?php echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape( $item->get('a_alias') ));?>
					</p>
				</td>
				
				

				<td class="center">
					<?php echo (int) $item->get('a_id'); ?>
				</td>
   
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	
	<?php
		if( JFile::exists(JPATH_COMPONENT_ADMINISTRATOR.'/views/webometrics/tmpl/default_batch.php') ){
			echo $this->loadTemplate('batch'); 
		}
	?>
	
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>