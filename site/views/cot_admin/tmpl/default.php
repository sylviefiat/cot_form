<?php

/**
 * @version     2.0.3
 * @package     com_cot_forms
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Sylvie Fiat <sylvie.fiat@ird.fr>
 */
// no direct access
defined('_JEXEC') or die;
?>
<!-- Styling for making front end forms look OK -->
<!-- This should probably be moved to the template CSS file -->
<style>
.fields_list {
	list-style: none;
}
.fields_lbl {
	padding-left:5em;
}
.fields_dsc {
}
.fields_ttl {
	font-weight: bold;
}
</style>
<?php
//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_cot_forms', JPATH_ADMINISTRATOR);


?>
<?php if ($this->item) : ?>

    <div class="item_fields">

        <ul class="fields_list">

            		<li><span class="fields_ttl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_COT_ADMIN_ID'); ?>:</span>
			<span class="fields_dsc"><?php echo $this->item->id; ?></span></li>
			</br>
			<li><span class="fields_ttl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_COT_ADMIN_OBSERVER'); ?></span></li>

			<li><span class="fields_lbl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_COT_ADMIN_OBSERVER_NAME'); ?>:</span>
			<span class="fields_dsc"><?php echo $this->item->observer_name; ?></span></li>
			<li><span class="fields_lbl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_COT_ADMIN_OBSERVER_TEL'); ?>:</span>
			<span class="fields_dsc"><?php echo $this->item->observer_tel; ?></span></li>
			<li><span class="fields_lbl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_COT_ADMIN_OBSERVER_EMAIL'); ?>:</span>
			<span class="fields_dsc"><?php echo $this->item->observer_email; ?></span></li>
			</br>
			<li><span class="fields_ttl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_COT_ADMIN_OBSERVATION'); ?></span></li>

			<li><span class="fields_lbl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_COT_ADMIN_OBSERVATION_DATE'); ?>:</span>
				<span class="fields_dsc"><?php 
 					if($this->item->observation_day!==null){
 						echo $this->item->observation_day;
 						if($this->item->observation_month!==null){
 							echo '/';
 						} 
 					}									      
 					if($this->item->observation_month!==null){
 						echo $this->item->observation_month;
 						if($this->item->observation_year!==null){
 							echo '/';
 						}
 					}
 					if($this->item->observation_year!==null){
 						echo $this->item->observation_year;
 					}
 				?></span>
 			</li>

			<li><span class="fields_lbl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_COT_ADMIN_OBSERVATION_LOCATION'); ?>:</span>
			<span class="fields_dsc"><?php echo $this->item->observation_location; ?></span></li>
			<li><span class="fields_lbl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_COT_ADMIN_OBSERVATION_REGION'); ?>:</span>
			<span class="fields_dsc"><?php echo $this->item->observation_region; ?></span></li>
			<li><span class="fields_lbl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_COT_ADMIN_OBSERVATION_COUNTRY'); ?>:</span>
			<span class="fields_dsc"><?php echo $this->item->observation_country; ?></span></li>
			<li><span class="fields_lbl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_COT_ADMIN_OBSERVATION_LATITUDE'); ?>:</span>
			<span class="fields_dsc"><?php echo $this->item->observation_latitude; ?></span></li>
			<li><span class="fields_lbl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_COT_ADMIN_OBSERVATION_LONGITUDE'); ?>:</span>
			<span class="fields_dsc"><?php echo $this->item->observation_longitude; ?></span></li>
			<li><span class="fields_lbl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_COT_ADMIN_OBSERVATION_NUMBER'); ?>:</span>
			<span class="fields_dsc"><?php echo $this->item->observation_number; ?></span></li>
			<li><span class="fields_lbl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_COT_ADMIN_OBSERVATION_CULLED'); ?>:</span>
			<span class="fields_dsc"><?php echo $this->item->observation_culled; ?></span></li>
			<li><span class="fields_lbl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_COT_ADMIN_OBSERVATION_LIST'); ?>:</span>
			<span class="fields_dsc"><?php echo $this->item->observation_list; ?></span></li>
			<li><span class="fields_lbl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_COT_ADMIN_OBSERVATION_METHOD'); ?>:</span>
			<span class="fields_dsc"><?php echo $this->item->observation_method; ?></span></li>
			<li><span class="fields_lbl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_COT_ADMIN_DEPTH_RANGE'); ?>:</span>
			<span class="fields_dsc"><?php echo $this->item->depth_range; ?></li>
			<li><span class="fields_lbl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_COT_ADMIN_COUNTING_METHOD'); ?>:</span>
			<span class="fields_dsc">
				<?php if($this->item->counting_method_timed_swim!=='') {
					echo JText::_('COM_COT_FORMS_FORM_LBL_COT_ADMIN_COUNTING_METHOD_TIMED_SWIM'); 
					echo ": ";
					echo $this->item->counting_method_timed_swim; 
					if($this->item->counting_method_distance_swim!=='' || ($this->item->counting_method_distance_swim=='' && $this->item->counting_method_other!==''))
						echo ', ';
				} ?>
			</span>
			<span class="fields_dsc">
				<?php if($this->item->counting_method_distance_swim!=='') { 
					echo JText::_('COM_COT_FORMS_FORM_LBL_COT_ADMIN_COUNTING_METHOD_DISTANCE_SWIM');
					echo ": ";
					echo $this->item->counting_method_distance_swim; 
					if($this->item->counting_method_other!=='')
						echo ', ';
				} ?>
			</span>
			<span class="fields_dsc">
				<?php if($this->item->counting_method_other!=='')  {
					echo JText::_('COM_COT_FORMS_FORM_LBL_COT_ADMIN_COUNTING_METHOD_OTHER');
					echo ": ";					 
					echo $this->item->counting_method_other; 
				} ?>
			</span>
			</li>
			<li><span class="fields_lbl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_COT_ADMIN_REMARKS'); ?>:</span>
			<span class="fields_dsc"><?php echo $this->item->remarks; ?></span></li>		
			<li><span class="fields_lbl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_COT_ADMIN_ADMIN_VALIDATION'); ?>:</span>
			<span class="fields_dsc"><?php echo ($this->item->admin_validation?'true':'false'); ?></span></li>

        </ul>

    </div>
    
	<a href="<?php echo JRoute::_('index.php?option=com_cot_forms&task=cot_admin.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_COT_FORMS_EDIT_ITEM"); ?></a>

								
									<a href="javascript:document.getElementById('form-cot-admin-delete-<?php echo $this->item->id ?>').submit()"><?php echo JText::_("COM_COT_FORMS_DELETE_ITEM"); ?></a>
									<form id="form-cot-admin-delete-<?php echo $this->item->id; ?>" style="display:inline" action="<?php echo JRoute::_('index.php?option=com_cot_forms&task=cot-admin.remove'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
										<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
										<input type="hidden" name="option" value="com_cot_forms" />
										<input type="hidden" name="task" value="cot_admin.remove" />
										<?php echo JHtml::_('form.token'); ?>
									</form>

									<?php if(!$this->item->admin_validation){ ?>
										<a href="javascript:document.getElementById('form-cot-admin-validate-<?php echo $this->item->id; ?>').submit()"><?php echo JText::_("COM_COT_FORMS_VALIDATE_ITEM"); ?></a>
										<form id="form-cot-admin-validate-<?php echo $this->item->id; ?>" style="display:inline" action="<?php echo JRoute::_('index.php?option=com_cot_forms&task=cot_admin.validate'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
											<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
											<input type="hidden" name="option" value="com_cot_forms" />
											<input type="hidden" name="task" value="cot_admin.validate" />
											<?php echo JHtml::_('form.token'); ?>
										</form>
										<?php } ?>
								
<?php
else:
    echo JText::_('COM_COT_FORMS_ITEM_NOT_LOADED');
endif;
?>
