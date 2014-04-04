<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

$order = $this->state['list.ordering'] ;
$order_dir = $this->state['list.direction'];
$user = JFactory::getUser() ;

?>
<form action="<?php echo $uri = JFactory::getURI()->toString() ; ?>" method="post" name="adminForm" id="adminForm">

<?php if( $user->authorise('core.edit', 'com_ref') ): ?>
<div class="form-inline">
	<?php 
		foreach($this->filter->getFieldset('search') as $filter ):
			echo $filter->label ;
			echo ' ' ;
			echo $filter->input ;
		endforeach;
	?>
	<div class="btn-group">
		<input type="submit" value="Search" class="btn" />
		<input type="button" value="Clear" class="btn" vlass="btn" onclick="$('search_index').value='';this.form.submit();" />
	</div>
</div>
<?php endif; ?>

<table class="adminlist table table-striped" style="border:1px solid white;">
	<thead>
		<tr>
			<th width="1%"><input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" /></th>
			<th><?php echo JHtml::_('grid.sort', 'Name' , 'a.name' , $order_dir , $order ); ?></th>
			<th><?php echo JHtml::_('grid.sort', 'Search Engine' , 'a.engine' , $order_dir , $order ); ?></th>
			<th><?php echo JHtml::_('grid.sort', 'Database' , 'a.database' , $order_dir , $order ); ?></th>
			<th><?php echo JHtml::_('grid.sort', 'Published' , 'a.published' , $order_dir , $order ); ?></th>
			<!--<th width="5%">
				<?php echo JHtml::_('grid.sort', 'Order' , 'a.ordering' , $order_dir , $order ); ?>
				<?php echo JHtml::_('grid.order',$this->items, 'filesave.png', 'tasks.saveorder' ); ?>
			</th>-->
			<!--<th>搜尋結果頁數</th>-->
			<th>每頁筆數</th>
			<th>有效頁面</th>
			<th>完成度</th>
			<th>分析結果</th>
			<th><?php echo JHtml::_('grid.sort', 'Created' , 'a.created' , $order_dir , $order ); ?></th>
			<th></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="10">
				<div class="pagination">
					<?php echo $this->pagin->getListFooter();?>
				</div>
			</td>
		</tr>
	</tfoot>
	<tbody>
		<?php foreach( $this->items as $k => $row ): ?>
		<tr class="row<?php echo ($k % 2) + 1 ; ?>">
			<td align="center"><?php echo JHtml::_('grid.id',$k,$row->id); ?></td>
			<td class="center">
				<?php if( $user->authorise('core.edit', 'com_ref') ): ?>
				<a href="index.php?option=com_ref&task=task.edit&layout=default&id=<?php echo $row->id; ?>">
					<?php echo $row->name ;?>
				</a>
				<?php else: ?>
					<?php echo $row->name ;?>
				<?php endif; ?>
			</td>
			<td class="center"><?php echo $row->a_engine ;?></td>
			<td class="center"><?php echo JText::_('COM_REF_DATABASE_'.strtoupper($row->a_database)) ;?></td>
			<td class="center"><?php echo JHtml::_('jgrid.published', $row->published , $k , 'tasks.' );?></td>
			<!--<td class="order">
				<?php echo JHtml::_('jgrid.orderUp' ,$k, 'tasks.orderUp');?>
				<?php echo JHtml::_('jgrid.orderDown' ,$k, 'tasks.orderDown');?>
				<input type="text" size="5" name="ordering[]" value="<?php echo $row->ordering;?>" class="text-area-order" />
			</td>-->
			<!--<td class="center"><?php echo $row->search_pages ;?></td>-->
			<td class="center"><?php echo 100 ;?></td>
			<td class="center"><?php echo $row->num_ablitily ;?></td>
			<td class="center">
				<?php
				$persent = 0 ;
				
				if($row->num_parsed > 0)
					$persent = 100 / $row->num_url * $row->num_parsed ;
				$persent = round($persent) ;
				?>
				<div class="progress progress-danger">
					<div class="bar" style="width: <?php echo $persent; ?>%">
						<?php echo $row->num_parsed ;?> / <?php echo $row->num_url ;?>
						:<?php echo $persent; ?>%
					</div>
				</div>
				<!--<div style="border:1px solid #ccc; padding: 3px;">
					<div style="padding:3px 0; background-color: red; width: <?php echo $persent; ?>%;"></div>
				</div>-->
			</td>
			<td class="center"><a href="<?php echo JRoute::_('index.php?option=com_ref&view=pages&task_id='. $row->id ); ?>">[觀看所有頁面]</a></td>
			<td class="center"><?php echo $row->created ;?></td>
			<td class="center"><?php //echo $row->finished ;?></td>
		</tr>
		<?php endforeach;?>
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