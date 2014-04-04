<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

JHtml::_('behavior.formvalidation');

?>

<script type="text/javascript">
	
	var i = 2 ;
	
	addProfessorsName = function(){
		var li = $$('.professors_name_li')[0] ;
		li2 = li.clone();
		li2.getElements('input')[0].set('value', '');
		li2.getElements('input')[0].set('id', 'jform_professors_name'+i);
		
		li2.getElements('label')[0].set('for', 'jform_name'+i);
		li2.getElements('label')[0].innerText = '';
		
		li.getParent().appendChild(li2);
		
		i++ ;
	}
</script>

<form action="<?php echo $uri = JFactory::getURI()->toString() ; ?>" method="post" name="adminForm" id="adminForm">
<div class="row-fluid form-horizontal">
	<div class="span6 fltlft">
		<fieldset class="panelform">
			<legend>Control</legend>
			
			<?php foreach( $this->form->getFieldset('control') as $field): ?>
			<div class="control-group">
				<?php echo $field->label; ?>
				<div class="controls">
					<?php echo $field->input ;?>
				</div>
			</div>
			<?php endforeach;?>
			
		</fieldset>
	</div>
	<div class="span6 fltrt">
		<fieldset class="panelform">
			<legend>Term</legend>
			<div>
			<?php
			
				if(!isset($this->data->professors_name)) {
					$this->data->professors_name = array(0=>'');
				}
			
				foreach($this->data->professors_name as $k => $input ):
					if($k > 0 && !$input) continue ;
			?>		
				<div class="professors_name_li control-group">
					<label class="control-label" for="jform_name<?php echo $k + 1; ?>"><?php if($k == 0) echo 'Professors Name'; ?></label>
					<div class="controls">
						<input id="jform_professors_name<?php echo $k + 1; ?>" type="text" name="jform[professors_name][]" value="<?php echo $input; ?>" size="45"  />
					</div>
				</div>
			<?php endforeach; ?>
			</div>
			<div class="clr"></div>
			<a href="javascript:void(0);" onclick="addProfessorsName();" style="margin-top: 15px; display: inline-block;">[新增名稱]</a>
		</fieldset>
	</div>
</div>

<?php 
//$width = 12 ;
//if( !JRequest::getVar('id') ): 
		//$width = 6 ;
?>
<div class="row-fluid form-horizontal">
	<!--<div class="span<?php echo $width;?> fltlft">
		
		<fieldset class="panelform">
			<legend>Search Index</legend>
			<ul class="adminformlist">
			<?php for($i=0; $i<3; $i++): ?>
				<li>
				<?php if($i>0) echo $this->form->getField('search_separator][')->input ;?>
				<?php echo $this->form->getField('search_index_auto][')->input; ?>
				<br /><br />
				</li>
			<?php endfor;?>
			</ul>
		</fieldset>
	</div>-->
	<?php //endif;?>
	<div class="span12 fltrgt">
		<fieldset class="panelform">
			<legend>Search Index</legend>
			<?php echo $this->form->getField('search_index_manual')->input;?>
		</fieldset>
	</div>
</div>

<div class="clr"></div>
<div class="ref-toolbar">
	<div id="bottom-toolbar" class="fltrgt">
		<?php echo JToolBar::getInstance('toolbar')->render('toolbar') ; ?>
	</div>
	<div class="clr"></div>
</div>

<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
