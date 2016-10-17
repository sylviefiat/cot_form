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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_cot_forms/assets/css/cot_forms.css');
?>
<script type="text/javascript">
    js = jQuery.noConflict();
    

    Joomla.submitbutton = function(task)
    {
        if (task == 'cbm_admin.cancel') {
            Joomla.submitform(task, document.getElementById('cbm_admin-form'));
        }
        else {
            
            if (task != 'cbm_admin.cancel' && document.formvalidator.isValid(document.id('cbm_admin-form'))) {
                
                Joomla.submitform(task, document.getElementById('cbm_admin-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_cot_forms&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="cbm_admin-form" class="form-validate">

    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_COT_FORMS_TITLE_CBM_ADMIN', true)); ?>
        <div class="row-fluid">
            <div class="span10 form-horizontal">
                <fieldset class="adminform">

                    			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('id'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('observer_name'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('observer_name'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('observation_date'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('observation_date'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('observation_location'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('observation_location'); ?></div>
			</div>			
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('observation_localisation'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('observation_localisation'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('observation_region'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('observation_region'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('observation_country'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('observation_country'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('observation_country_code'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('observation_country_code'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('observation_latitude'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('observation_latitude'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('observation_longitude'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('observation_longitude'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('observation_results'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('observation_results'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('remarks'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('remarks'); ?></div>
			</div>
			

                </fieldset>
            </div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>
        
        

        <?php echo JHtml::_('bootstrap.endTabSet'); ?>

        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>

    </div>
</form>
