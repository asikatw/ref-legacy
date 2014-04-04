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
// RefHelper::_('include.bootstrap');

$user	= JFactory::getUser();
$userId	= $user->get('id');

$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$canOrder	= $user->authorise('core.edit.state', 'com_ref');
$saveOrder	= $listOrder == 'a.ordering';
?>
<script type="text/javascript">
	
	var n_num = <?php echo count($this->entry->get('eng_name', array(1))); ?> ;
	
	var addNameInput = function(n) {
		
		c 	= n.getParent();
		num = c.get('n-num');
		
		if(num != n_num) return ;
		
		c2 = c.clone();
		c2.set('n-num', num+1);
		
		i = c2.getElements('input') ;
		i.set('value', '');
		
		c2.inject(c, 'after');
		
		n_num = num+1 ;
	}
	
	window.addEvent('domready', function(){
		var weboSlide = new Fx.Slide('webo-url');
		
		<?php if( !isset($this->q->database->webometrics) ): ?>
		weboSlide.hide();
		<?php endif; ?>
		
		$$('#webo-check').addEvent('click', function(e){
			weboSlide.toggle();
		});
		
	});
</script>
<form action="<?php echo 'index.php?option=com_ref'; ?>" method="post" name="adminForm" id="adminForm">
	
	<div id="ref-wrap" class="container-fluid entries<?php echo $this->get('pageclass_sfx');?>">
		<div id="ref-wrap-inner">
			
			<div class="row-fluid" style="text-align: left;">
				<div class="span9">
					<fleldset>
						<legend>搜尋</legend>
					
						<div class="form-horizontal">
							<div class="control-group">
								<label class="control-label" for="name">教師中文名</label>
								<div class="controls">
									<input type="text" name="name" id="name" placeholder="Name" value="<?php echo $this->entry->get('chinese_name'); ?>">
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="first_name">英文名</label>
								<?php foreach( $this->entry->eng_name as $k => $name ): ?>
								<div class="controls eng-name" n-num="<?php echo $k+1; ?>">
									<input type="text" name="first_name[]" class="span5" id="first_name" placeholder="First Name" onfocus="addNameInput(this);" value="<?php echo $name->first; ?>">
									<input type="text" name="last_name[]" class="span5" id="last_name" placeholder="Last Name" onfocus="addNameInput(this);" value="<?php echo $name->last; ?>">
								</div>
								<?php endforeach; ?>
							</div>	
						</div>
						
						<div class="form-inline">
							<label class="checkbox">
								<input type="checkbox" name="database[syllabus]" value="1" <?php echo isset($this->q->database->syllabus) ? 'checked' : ''; ?>> 課程大綱
							</label>
							|
							<label class="checkbox">
								<input type="checkbox" name="database[ndltd]" value="1" <?php echo isset($this->q->database->ndltd) ? 'checked' : ''; ?>> 博碩士論文資料庫
							</label>
							|
							<label class="checkbox">
								<input type="checkbox" name="database[udn]" value="1" <?php echo isset($this->q->database->udn) ? 'checked' : ''; ?>> 報紙資料庫
							</label>
							|
							<label class="checkbox">
								<input type="checkbox" name="database[readopac]" value="1" <?php echo isset($this->q->database->readopac) ? 'checked' : ''; ?>> 雜誌資料庫
							</label>
							|
							<label class="checkbox">
								<input type="checkbox" name="database[wiki]" value="1" <?php echo isset($this->q->database->wiki) ? 'checked' : ''; ?>> 維基百科
							</label>
							|
							<label class="checkbox">
								<input type="checkbox" name="database[webometrics]" id="webo-check" value="1" <?php echo isset($this->q->database->webometrics) ? 'checked' : ''; ?>> Webometrics
							</label>
							<br /><br />
						</div>
						
						<div id="webo-url" style="">
							<fieldset>
								<?php foreach( $this->q->site as $site ): ?>
								<input type="text" name="site[]" class="span8 input-site" onfocus="addInputSite(this);" placeholder="" value="<?php echo $site; ?>" />
								<?php endforeach; ?>
							</fieldset>
						</div>
						<script type="text/javascript">
							var s 	= $$('.input-site') ;
							var sn 	= 0 ;
							
							s.each(function(e){
								e.set('num', sn) ;
								sn++;
							});
							
							var addInputSite = function(e){
								if(e.get('num') == (sn - 1)) {
									e2 = e.clone();
									e2.set('value', '');
									e2.set('num', sn);
									e2.inject(e, 'after');
									sn++;
									
									var warp = $$('#webo-url')[0].getParent();
									warp.setStyle('height', warp.getHeight() + 40);
								}
							}
							
						</script>
						
						<button class="btn">重新搜尋</button>
					</fieldset>
					
					<br />
					<br />
					<br />
					
					<fieldset>
						<legend>檢索結果</legend>
						
						<table class="table table-bordered">
							<tbody>
								<?php if( isset($this->q->database->syllabus) ): ?>
								<!--課程大綱-->
								<tr>
									<th rowspan="2" width="20%">課程大綱</th>
									<td  width="20%">被引用</td>
									<td><?php echo $this->results['syllabus']->cited; ?></td>
								</tr>
								<tr>
									<td>自我引用</td>
									<td><?php echo $this->results['syllabus']->self_cited; ?></td>
								</tr>
								<?php endif; ?>
								
								
								<?php if( isset($this->q->database->ndltd) ): ?>
								<!--博碩士論文資料庫-->
								<tr>
									<th rowspan="2">博碩士論文資料庫</th>
									<td>指導論文次數</td>
									<td><?php echo $this->results['ndltd']->guidance; ?></td>
								</tr>
								<tr>
									<td>論文參考文獻次數</td>
									<td><?php echo $this->results['ndltd']->cited; ?></td>
								</tr>
								<?php endif; ?>
								
								<?php if( isset($this->q->database->udn) ): ?>
								<!--報紙資料庫-->
								<tr>
									<th rowspan="2">報紙資料庫</th>
									<td>著作篇數</td>
									<td><?php echo $this->results['udn']->writings; ?></td>
								</tr>
								<tr>
									<td>被提及次數</td>
									<td><?php echo $this->results['udn']->mentioned; ?></td>
								</tr>
								<?php endif; ?>
								
								<?php if( isset($this->q->database->readopac) ): ?>
								<!--雜誌資料庫-->
								<tr>
									<th rowspan="2">雜誌資料庫</th>
									<td>著作篇數</td>
									<td><?php echo $this->results['readopac']->writings; ?></td>
								</tr>
								<tr>
									<td>被提及次數</td>
									<td><?php echo $this->results['readopac']->mentioned; ?></td>
								</tr>
								<?php endif; ?>
								
								
								<?php if( isset($this->q->database->webometrics) && $this->webometrics ): ?>
								<!--Webometrics-->
								<tr>
									<th rowspan="4">Webometrics</th>
									<td>網頁規模</td>
									<td><?php echo $this->webometrics->web_scale; ?></td>
								</tr>
								<tr>
									<td>能見度</td>
									<td><?php echo $this->webometrics->visibility; ?></td>
								</tr>
								<tr>
									<td>檔案</td>
									<td><?php echo $this->webometrics->files; ?></td>
								</tr>
								<tr>
									<td>學術文件</td>
									<td><?php echo $this->webometrics->scholarly; ?></td>
								</tr>
								<?php endif; ?>
								
								
								<?php if( isset($this->q->database->wiki) ): ?>
								<!--維基百科-->
								<tr>
									<th rowspan="2">維基百科</th>
									<!--<td>條目</td>
									<td><?php echo $this->results['wiki']->entries; ?></td>
								</tr>
								<tr>-->
									<td>被提及與列為參考文獻</td>
									<td><?php echo $this->results['wiki']->mentioned; ?></td>
								</tr>
								<?php endif; ?>
								
								
								<!--課程大綱-->
								<!--<tr>
									<th rowspan="2">課程大綱</th>
									<td>被引用</td>
									<td></td>
								</tr>
								<tr>
									<td>自我引用</td>
									<td></td>
								</tr>-->
								
							</tbody>
						</table>
						
					</fieldset>
					
					<br /><br />
					
					
				</div>
			
				<div class="span3">
					
					<fieldset>
						<legend>相關搜索</legend>
						<h4></h>您現在搜索的是：</h4>
						<p><?php echo $this->entry->title; ?></p>
						<h4>其他相關搜索：</h4>
						
						<?php if( $this->relative ): ?>
						<ul class="nav nav-list">
							<?php foreach( $this->relative as $relavive): ?>
							<li>
								<a href="<?php echo $relavive->link; ?>">
									<?php echo $relavive->title; ?>
								</a>
							</li>
							<?php endforeach; ?>
						</ul>
						<?php endif; ?>
					</fieldset>
					
					
				</div>	
			</div>
			
			
			
			
			
		</div>
	</div>
	
	<div>
		<input type="hidden" name="task" value="entry.save" />
		<input type="hidden" name="boxchecked" value="0" />
		<!--<input type="hidden" name="return" id="return_url" value="<?php echo base64_encode(JFactory::getURI()->toString()); ?>" />-->
		<?php echo JHtml::_('form.token'); ?>
	</div>
	
</form>