<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

?>
<form action="<?php echo $uri = JFactory::getURI()->toString() ; ?>" method="post" name="adminForm" id="adminForm">

<div class="row-fluid">
	<div class="span4">
		<fieldset class="adminform">
			<h2><?php echo JText::_('Task Detail'); ?></h2>
			<table class="table">
	
				<?php foreach( $this->form->getFieldset('control') as $form ): ?>
				<tr>
					<th>
						<?php echo $form->title ;?>
					</th>
					<td>
						<?php echo $form->value; ?>
					</td>
				</tr>
				<?php endforeach;?>
			
			<tr>
				<?php $keyword = $this->form->getField('search_index_manual'); ?>
				<th>關鍵字</th>
				<td><?php echo $this->item->keyword; ?></td>
			</tr>
			
			</table>
		</fieldset>
	</div>
	<div class="span8">
		<fieldset class="adminform">
			<legend>Search Engine Pages</legend>
			<div style="margin:10px 0;">
				<a href="<?php echo JRoute::_('index.php?option=com_ref&view=pages&task_id='. JRequest::getVar('id') ); ?>">[觀看所有頁面]</a>
				/
				<a href="<?php echo JRoute::_('index.php?option=com_ref&task=task.report&id='. JRequest::getVar('id') ); ?>">[下載報表]</a>
			</div>
			<table class="table table-striped">
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
					<tr>
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
							
							?>
							<div class="progress progress-success">
								<div class="bar" style="width: <?php echo $persent; ?>%"><?php echo $persent; ?>%</div>
							</div>
							<!--<div style="border:1px solid #ccc; padding: 3px;">
								<div style="padding:3px 0; background-color: green; width: <?php echo $persent; ?>%;"></div>
							</div>-->
						</td>
						<td>
							<?php
							$persent = 0 ;
							
							if($page->page_downloaded > 0)
								$persent = 100 / $page->page_downloaded * $page->page_parsed ;
							
							$persent = round($persent) ;
							?>
							<div class="progress progress-danger">
								<div class="bar" style="width: <?php echo $persent; ?>%"><?php echo $persent; ?>%</div>
							</div>
							<!--<div style="border:1px solid #ccc; padding: 3px;">
								<div style="padding:3px 0; background-color: red; width: <?php echo $persent; ?>%;"></div>
							</div>-->
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
				<!--<tfoot>
					<tr>
						<td colspan="8"></td>
					</tr>
				</tfoot>-->
			</table>
		</fieldset>
	</div>
</div>


<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>