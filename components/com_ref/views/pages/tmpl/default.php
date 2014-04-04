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
JHtml::_('behavior.modal');
JHTML::_('script','system/multiselect.js',false,true);
$user	= JFactory::getUser();
$userId	= $user->get('id');
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$canOrder	= $user->authorise('core.edit.state', 'com_ref');
$saveOrder	= $listOrder == 'a.ordering';
?>

<form action="<?php echo JRoute::_('index.php?option=com_ref&view=pages'); ?>" method="post" name="adminForm" id="adminForm">
	<fieldset id="filter-bar">
		<div class="filter-search fltlft form-inline">
			<?php 
				foreach($this->filter['search']->getFieldset('search') as $search ):
					echo $search->label ;
					echo ' ' ;
					echo $search->input ;
				endforeach;
			?>
			<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('search_index').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
		<!--<div class="filter-select fltrt">
 			<?php 
				foreach($this->filter['filter']->getFieldset('filter') as $filter ):
					echo $filter->input ;
				endforeach;
			?>
		</div>-->
	</fieldset>
	<div class="clr"> </div>

	<table class="adminlist table table-striped">
		<thead>
			<tr>
				<th width="1%">
					<input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this)" />
				</th>
				<th>
					標題
				</th>
				<th>
					連結
				</th>
				<th>
					連結類型
				</th>
				<th width="4%">
					搜尋排序
				</th>
				<th width="4%">
					搜尋頁面
				</th>
				<th width="4%">
					檔案類型
				</th>
				<th width="6%">
					嘗試次數
				</th>
				<th width="13%">
					儲存狀態
				</th>
				<th width="4%">
					已分析
				</th>

                <?php if (isset($this->items[0]->id)) { ?>
                <th width="1%" class="nowrap">
                    <?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
                </th>
                <?php } ?>
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
			$ordering	= ($listOrder == 'a.ordering');
			$canCreate	= $user->authorise('core.create',		'com_ref');
			$canEdit	= $user->authorise('core.edit',			'com_ref');
			$canCheckin	= $user->authorise('core.manage',		'com_ref');
			$canChange	= $user->authorise('core.edit.state',	'com_ref');
			?>
			<tr class="row<?php echo $i % 2; ?>">
				<td class="center">
					<?php echo JHtml::_('grid.id', $i, $item->a_id); ?>
				</td>

				<td>
					<a href="<?php echo $item->a_url; ?>">
						<?php echo $item->a_name; ?>
					</a>
				</td>
				
				<td>
					<a href="<?php echo $item->a_url; ?>" class="hasTip" title="網址::<?php echo htmlentities($item->a_url) ?>">
						<?php echo JString::substr($item->a_url, 0, 50); ?>
					</a>
				</td>
				
				<td>
					<?php echo $item->a_link_type; ?>
				</td>
				
				<td>
					<?php echo $item->a_number; ?>
				</td>
				
				<td>
					<?php echo $item->a_page; ?>
				</td>
				
				<td>
					<?php
						$attr = array();
						$attr['target'] = '_blank' ;
						$attr['class'] = 'modal' ;
						$attr['rel'] = "{handler: 'iframe', size: {x: 875, y: 550},}" ;
						
						$root = RF::getConfig('file_url_root', JURI::root());
						$view_path = trim($root, '/').'/'.$item->b_file_path ;
						
						if($item->b_file_type !== 'html'){
							$view_path = urlencode($view_path) ;
							$view_path = "https://docs.google.com/viewer?url={$view_path}&embedded=true" ;
						}
						
						if( $item->b_file_path ) {
							echo JHtml::link($view_path, $item->a_file_type, $attr) ;
						}else{
							echo $item->a_file_type ;
						}
					?>
				</td>
				
				<td>
					<?php echo $item->a_tried_times; ?> / 10
				</td>
				
				<td>
					<?php
						if($item->a_downloaded=='0000-00-00 00:00:00' && !$item->a_error ) {
							echo '等待下載' ;
						}elseif($item->a_error) {
							echo '<span class="red">下載失敗，錯誤訊息：<br />'.$item->a_error.'</span>' ;
						}else {
							echo '<span class="enabled">下載成功，時間：'.$item->a_downloaded.'</span>' ;
						}
					?>
				</td>
				
				<td>
					<?php if( !$item->parsed ): ?>
						-
					<?php elseif($item->referenced) : ?>
						<img src="administrator/templates/bluestork/images/admin/tick.png" alt="是" />
					<?php else: ?>
						<img src="administrator/templates/bluestork/images/admin/publish_x.png" alt="否" />
					<?php endif; ?>
				</td>

                
				<td class="center">
					<?php echo (int) $item->a_id; ?>
				</td>
                
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>