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

<div class="width-50 fltlft">
	<fieldset class="panelform">
		<legend>Control</legend>
		<ul class="adminformlist">
		<?php foreach( $this->form->getFieldset('control') as $field): ?>
			<li>
				<?php echo $field->label.' '.$field->input ;?>
			</li>
			
		<?php endforeach;?>
		</ul>
	</fieldset>
</div>
<div class="width-50 fltrt">
	<fieldset class="panelform">
		<legend>Term</legend>
		<ul class="adminformlist">
		<?php
		
			if(!isset($this->data->professors_name)) {
				$this->data->professors_name = array(0=>'');
			}
		
			foreach($this->data->professors_name as $k => $input ):
				if($k > 0 && !$input) continue ;
		?>		
			<li class="professors_name_li">
				<label for="jform_name<?php echo $k + 1; ?>"><?php if($k == 0) echo 'Professors Name'; ?></label>
				<input id="jform_professors_name<?php echo $k + 1; ?>" type="text" name="jform[professors_name][]" value="<?php echo $input; ?>" size="45"  />
			</li>
		<?php endforeach; ?>
		</ul>
		<div class="clr"></div>
		<a href="javascript:void(0);" onclick="addProfessorsName();" style="margin-top: 15px; display: inline-block;">[新增名稱]</a>
	</fieldset>
</div>
<div class="clr"></div>

<?php 
$width = 100 ;
if( !JRequest::getVar('id') ): 
		$width = 50 ;
?>
<div class="width-<?php echo $width;?> fltlft">
	
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
</div>
<?php endif;?>
<div class="width-<?php echo $width;?> fltrgt">
	<fieldset class="panelform">
		<legend>Search Index</legend>
		<?php echo $this->form->getField('search_index_manual')->input;?>
	</fieldset>
</div>
<div class="clr"></div>
<div class="ref-toolbar">
	<div id="bottom-toolbar" class="fltrgt">
		<?php echo JToolBar::getInstance('toolbar')->render('toolbar') ; ?>
	</div>
	<div class="clr"></div>
</div>


