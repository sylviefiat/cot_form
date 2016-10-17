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

JHtml::_('jquery.framework',  true, true);
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_cot_forms', JPATH_ADMINISTRATOR);
?>

<!-- Styling for making front end forms look OK -->
<!-- This should probably be moved to the template CSS file -->
<style>
    .front-end-edit ul {
        padding: 0 !important;
    }
    .front-end-edit li {
        list-style: none;
        margin-bottom: 6px !important;
    }
    .front-end-edit label {
        margin-right: 10px;
        display: block;
        float: left;
        text-align: center;
        width: 200px !important;
    }
    .front-end-edit .radio label {
        float: none;
    }
    .front-end-edit .readonly {
        border: none !important;
        color: #666;
    }    
    .front-end-edit #editor-xtd-buttons {
        height: 50px;
        width: 600px;
        float: left;
    }
    .front-end-edit .toggle-editor {
        height: 50px;
        width: 120px;
        float: right;
    }

    #jform_rules-lbl{
        display:none;
    }

    #access-rules a:hover{
        background:#f5f5f5 url('../images/slider_minus.png') right  top no-repeat;
        color: #444;
    }

    fieldset.radio label{
        width: 50px !important;
    }
</style>
<script type="text/javascript">
    function getScript(url,success) {
        var script = document.createElement('script');
        script.src = url;
        var head = document.getElementsByTagName('head')[0],
        done = false;
        // Attach handlers for all browsers
        script.onload = script.onreadystatechange = function() {
            if (!done && (!this.readyState
                || this.readyState == 'loaded'
                || this.readyState == 'complete')) {
                done = true;
                success();
                script.onload = script.onreadystatechange = null;
                head.removeChild(script);
            }
        };
        head.appendChild(script);
    }
    getScript('//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js',function() {
        js = jQuery.noConflict();
        js(document).ready(function(){
            js('#form-cot_admin').submit(function(event){
                 
            }); 
            document.getElementById("jform_counting_method_timed_swim_chbx").checked = document.getElementById("jform_counting_method_timed_swim").value.length>0?1:0;
            document.getElementById("jform_counting_method_distance_swim_chbx").checked = document.getElementById("jform_counting_method_distance_swim").value.length>0?1:0;
            document.getElementById("jform_counting_method_other_chbx").checked = document.getElementById("jform_counting_method_other").value.length>0?1:0;

            enable_timed_swim(document.getElementById("jform_counting_method_timed_swim").value.length>0?true:false);
            enable_distance_swim(document.getElementById("jform_counting_method_distance_swim").value.length>0?true:false);
            enable_other(document.getElementById("jform_counting_method_other").value.length>0?true:false);
            
        });
    });

    function enable_timed_swim(status) {
        if(!status){
                document.getElementById("jform_counting_method_timed_swim").value = "";
                document.getElementById("jform_counting_method_timed_swim").setAttribute('readonly','readonly');
        } else {
                document.getElementById("jform_counting_method_timed_swim").removeAttribute('readonly');
        }
    }

    function enable_distance_swim(status) {
        if(!status){
                document.getElementById("jform_counting_method_distance_swim").value = "";
                document.getElementById("jform_counting_method_distance_swim").setAttribute('readonly','readonly');
        } else {
                document.getElementById("jform_counting_method_distance_swim").removeAttribute('readonly');
        }
    }

    function enable_other(status) {
        if(!status){
                document.getElementById("jform_counting_method_other").value = "";
                document.getElementById("jform_counting_method_other").setAttribute('readonly','readonly');
        } else {
                document.getElementById("jform_counting_method_other").removeAttribute('readonly');
        }
    }
    
</script>

<div class="cot_admin-edit front-end-edit">
    <?php if (!empty($this->item->id)): ?>
        <h1><?php echo JText::_('COM_COT_FORMS_EDIT_ITEM_TITLE'); ?> <?php echo $this->item->id; ?></h1>
    <?php else: ?>
        <h1><?php echo JText::_('COM_COT_FORMS_COT_ADMIN_ADD_ITEM_TITLE'); ?></h1>
    <?php endif; ?>

    <form id="form-cot_admin" action="<?php echo JRoute::_('index.php?option=com_cot_forms&task=cot_admin.save'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
        <ul>
            			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('id'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('observer_name'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('observer_name'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('observer_tel'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('observer_tel'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('observer_email'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('observer_email'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('observation_date'); ?></div>
				<div class="controls">
                    <?php echo $this->form->getInput('observation_day'); ?>
                    <?php echo $this->form->getInput('observation_month'); ?>
                    <?php echo $this->form->getInput('observation_year'); ?>
                </div>
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
				<div class="control-label"><?php echo $this->form->getLabel('observation_location'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('observation_location'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('observation_number'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('observation_number'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('observation_culled'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('observation_culled'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('observation_list'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('observation_list'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('observation_method'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('observation_method'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('depth_range'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('depth_range'); ?></div>
			</div>
			<div class="control-group">
                                <div class="control-label">
                                        <label id="jform_counting_method_label" class="hasTooltip" title="<?php echo JText::_('OBSERVATION_COUNTING_METHOD_DESC');?>">
                                                <?php echo JText::_('OBSERVATION_COUNTING_METHOD');?>
                                        </label>
                                </div>
                                <div class="controls">
                                <fieldset>
                                <ul>
                                        <li>
                                                <input id="jform_counting_method_timed_swim_chbx" class="control-label" type="checkbox" name="counting_method_timed_swim" onclick="enable_timed_swim(this.checked)"> &nbsp; &nbsp;
                                                <?php echo $this->form->getLabel('counting_method_timed_swim'); ?>
                                        </li><li>
                                                <?php echo $this->form->getInput('counting_method_timed_swim'); ?>
                                        </li>
                                </ul>
                                <ul>
                                        <li>
                                                <input id="jform_counting_method_distance_swim_chbx" class="control-label" type="checkbox" name="counting_method_distance_swim" onclick="enable_distance_swim(this.checked)" > &nbsp; &nbsp;
                                                <?php echo $this->form->getLabel('counting_method_distance_swim'); ?>
                                        </li><li>
                                                <?php echo $this->form->getInput('counting_method_distance_swim'); ?>
                                        </li>
                                </ul>
                                <ul>
                                        <li>
                                                <input id="jform_counting_method_other_chbx" class="control-label" type="checkbox" name="counting_method_other" onclick="enable_other(this.checked)" > &nbsp; &nbsp;
                                                <?php echo $this->form->getLabel('counting_method_other'); ?>
                                        </li><li>
                                                <?php echo $this->form->getInput('counting_method_other'); ?>
                                        </li>

                                </ul>
                                </fieldset>
                                </div>

                        </div>

			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('remarks'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('remarks'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('observation_state'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('observation_state'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('captcha'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('captcha'); ?></div>
			</div>

        </ul>

        <div>
            <button type="submit" class="validate"><span><?php echo JText::_('JSUBMIT'); ?></span></button>
            <?php echo JText::_('or'); ?>
            <a href="<?php echo JRoute::_('index.php?option=com_cot_forms&task=cot_adminform.cancel'); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>

            <input type="hidden" name="option" value="com_cot_forms" />
            <input type="hidden" name="task" value="cot_adminform.save" />
            <?php echo JHtml::_('form.token'); ?>
        </div>
    </form>
</div>
