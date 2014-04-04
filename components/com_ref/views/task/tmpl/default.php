<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

?>
<div class="width-30 fltlft">
	<fieldset class="adminform">
		<legend><?php echo JText::_('Task Detail'); ?></legend>
		<ul class="adminformlist">

		<?php foreach( $this->form->getFieldset('control') as $form ): ?>
		<li>
			<?php echo $form->label ;?>
			<input value="<?php echo $form->value; ?>" readonly="true" class="readonly" />
		</li>
		<?php endforeach;?>
		
		<li>
			<?php $keyword = $this->form->getField('search_index_manual'); ?>
			<label for="">關鍵字</label>
			<textarea value="" readonly="readonly" class="readonly" rows="5" style="border: none; font-size: 100%;" ><?php echo $this->item->keyword; ?></textarea>
		</li>
		
		</ul>
	</fieldset>
</div>
<div class="width-70 fltrt">
	<fieldset class="adminform">
		<legend>Search Engine Pages</legend>
		<div style="margin:10px 0;">
			<a href="<?php echo JRoute::_('index.php?option=com_ref&view=pages&task_id='. JRequest::getVar('id') ); ?>">[觀看所有頁面]</a>
			/
			<a href="<?php echo JRoute::_('index.php?option=com_ref&task=task.report&id='. JRequest::getVar('id') ); ?>">[下載報表]</a>
		</div>
		<table class="adminlist">
			<thead>
				<tr>
					<th>
						頁數
					</th>
					<th>
						連結數
					</th>
					<th>下載狀態</th>
					<th>分析狀態</th>
					<th>儲存頁面數</th>
					<th>分析頁面數</th>
				</tr>
			</thead>
			<tbody>
				
				<?php foreach( $this->pages as $page ): ?>
				<tr class="row">
					<td>
						<?php echo $page->a_page; ?>
					</td>
					<td>
						<a href="<?php echo JRoute::_('index.php?option=com_ref&view=engine&id=' . $page->a_id ); ?>">
							頁面快取
						</a>
						 / 
						<a href="<?php echo JRoute::_('index.php?option=com_ref&view=pages&task_id='. JRequest::getVar('id') )."&search[field]=a.page&search[index]={$page->a_page}"; ?>">觀看連結</a>
					</td>
					<td>
						<?php
						$persent = 0 ;
						
						if($page->page_url > 0)
							$persent = 100 / $page->page_url * $page->page_downloaded ;
						
						$persent = round($persent) ;
						echo $persent ;
						?>%
						<div style="border:1px solid #ccc; padding: 3px;">
							<div style="padding:3px 0; background-color: green; width: <?php echo $persent; ?>%;"></div>
						</div>
					</td>
					<td>
						<?php
						$persent = 0 ;
						
						if($page->page_downloaded > 0)
							$persent = 100 / $page->page_downloaded * $page->page_parsed ;
						echo $persent ;
						?>%
						<div style="border:1px solid #ccc; padding: 3px;">
							<div style="padding:3px 0; background-color: red; width: <?php echo $persent; ?>%;"></div>
						</div>
					</td>
					<td>
						<?php echo $page->page_downloaded; ?> / <?php echo $page->page_url; ?>
					</td>
					<td>
						<?php echo $page->page_parsed ; ?> / <?php echo $page->page_downloaded; ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="6"></td>
				</tr>
			</tfoot>
		</table>
	</fieldset>
</div>
<div class="clr"></div>