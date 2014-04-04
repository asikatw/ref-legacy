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

JHtml::_('behavior.framework', true);
//RefHelper::_('include.bootstrap');

// Create shortcuts to some parameters.
// $params		= $this->item->params;
$user		= JFactory::getUser();
$item 		= $this->item ;
$uri 		= JFactory::getURI() ;
?>
<script type="text/javascript">
	
	var n_num = 1 ;
	
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
		var weboSlide = new Fx.Slide('webo-url').hide();
		
		$$('#webo-check').addEvent('click', function(e){
			weboSlide.toggle();
		});
		
	});
</script>
<form action="<?php echo 'index.php?option=com_ref'; ?>" method="post" name="adminForm" id="adminForm">

	<div id="ref-wrap" class="container-fluid entries<?php echo $this->get('pageclass_sfx');?>">
		<div id="ref-wrap-inner">
			
			<div class="entry-item item row-fluid">
				<div class="entry-item-inner span8 offset2" style="text-align: left;">
					
					<fleldset>
						<legend>請輸入檢索字串</legend>
					
						<div class="form-horizontal">
							<div class="control-group">
								<label class="control-label" for="name">教師中文名</label>
								<div class="controls">
									<input type="text" name="name" id="name" placeholder="Name">
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="first_name">英文名</label>
								<div class="controls eng-name" n-num="1">
									<input type="text" name="first_name[]" class="span5" id="first_name" placeholder="First Name" onfocus="addNameInput(this);">
									<input type="text" name="last_name[]" class="span5" id="last_name" placeholder="Last Name" onfocus="addNameInput(this);">
								</div>
							</div>	
						</div>
						
						<button class="btn pull-right">搜尋</button>
					</fieldset>
					
					<fleldset>
						<legend>請選擇檢索項目</legend>
					
					
						<div class="form-horizontal">
							<label class="checkbox">
								<input type="checkbox" name="database[syllabus]" value="1"> 課程大綱
							</label>
							
							<label class="checkbox">
								<input type="checkbox" name="database[ndltd]" value="1"> 博碩士論文資料庫
							</label>
							
							<label class="checkbox">
								<input type="checkbox" name="database[udn]" value="1"> 報紙資料庫
							</label>
							
							<label class="checkbox">
								<input type="checkbox" name="database[readopac]" value="1"> 雜誌資料庫
							</label>
							
							<label class="checkbox">
								<input type="checkbox" name="database[wiki]" value="1"> 維基百科
							</label>
							
							<label class="checkbox">
								<input type="checkbox" name="database[webometrics]" value="1" id="webo-check" > Webometrics
							</label>
						</div>	
					
					</fleldset>
					
					<div id="webo-url" style="">
						<br /><br />
						<fieldset>
							<legend>個人網站網址</legend>
							<input type="text" name="site[]" class="span10 input-site" onfocus="addInputSite(this);" />
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
					
					<button class="btn pull-right">搜尋</button>
				</div>
			</div>
			
		</div>
	</div>
	
	<div>
		<input type="hidden" name="task" value="entry.save" />
		<input type="hidden" name="boxchecked" value="0" />
		<!--<input type="hidden" name="return" value="<?php echo base64_encode($uri->toString()); ?>" />-->
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>		
