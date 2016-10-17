<?php

/**
 * @version     2.0.2
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

            		<li><span class="fields_ttl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_SC_ADMIN_ID'); ?>:</span>
			<span class="fields_dsc"><?php echo $this->item->id; ?></span></li>
			</br>
			<li><span class="fields_ttl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_ADMIN_OBSERVERS'); ?></span></li>

			<li><span class="fields_lbl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_COT_ADMIN_OBSERVER_NAME'); ?>:</span>
			<span class="fields_dsc"><?php echo $this->item->observer_name; ?></span></li>
			</br>
			<li><span class="fields_ttl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_COT_ADMIN_OBSERVATION'); ?></span></li>

			<li><span class="fields_lbl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_ADMIN_SURVEY_DATE'); ?>:</span>
			<span class="fields_dsc"><?php echo $this->item->observation_date; ?></span></li>
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
			<li><span class="fields_lbl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_COT_ADMIN_OBSERVATION_METHOD'); ?>:</span>
			<span class="fields_dsc"><?php echo $this->item->observation_method; ?></span></li>
			<li><span class="fields_lbl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_ADMIN_OBSERVATION_TARGET'); ?>:</span>
			<span class="fields_dsc"><?php echo $this->item->observation_target; ?></span></li>
			<li><span class="fields_lbl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_ADMIN_OBSERVATION_RESULTS'); ?>:</span>
			<span class="fields_dsc"><?php echo $this->item->observation_results; ?></span></li>
			<li><span class="fields_lbl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_COT_ADMIN_DEPTH_RANGE'); ?>:</span>
			<span class="fields_dsc"><?php echo $this->item->depth_range; ?></li>			
			<li><span class="fields_lbl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_COT_ADMIN_REMARKS'); ?>:</span>
			<span class="fields_dsc"><?php echo $this->item->remarks; ?></span></li>
			<li><span class="fields_lbl"><?php echo JText::_('COM_COT_FORMS_FORM_LBL_ADMIN_STATE'); ?>:</span>
			<span class="fields_dsc"><?php echo $this->item->observation_state; ?></span></li>
        </ul>

    </div>
    
	<a href="<?php echo JRoute::_('index.php?option=com_cot_forms&task=sc_admin.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_COT_FORMS_EDIT_ITEM"); ?></a>

								
									<a href="javascript:document.getElementById('form-sc-admin-delete-<?php echo $this->item->id ?>').submit()"><?php echo JText::_("COM_COT_FORMS_DELETE_ITEM"); ?></a>
									<form id="form-sc-admin-delete-<?php echo $this->item->id; ?>" style="display:inline" action="<?php echo JRoute::_('index.php?option=com_cot_forms&task=sc-admin.remove'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
										<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
										<input type="hidden" name="option" value="com_cot_forms" />
										<input type="hidden" name="task" value="sc_admin.remove" />
										<?php echo JHtml::_('form.token'); ?>
									</form>
								
<?php
else:
    echo JText::_('COM_COT_FORMS_ITEM_NOT_LOADED');
endif;
?>
