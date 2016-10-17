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
   .items_list {
	list-style: none;
}
</style>
<script type="text/javascript">
    function deleteItem(item_id){
        if(confirm("<?php echo JText::_('COM_COT_FORMS_DELETE_MESSAGE'); ?>")){
            document.getElementById('form-sc-admin-delete-' + item_id).submit();
        }
    }
</script>
<div>
<h2><?php echo JText::_('COM_COT_FORMS_TITLE_LIST_VIEW_OI_ADMINS'); ?></h2>
</div>
<div class="items">
    <ul class="items_list">
<?php $show = false; ?>
        <?php foreach ($this->items as $item) : ?>

            
				<?php
						$show = true;
						?>
							<li>
								<a href="<?php echo JRoute::_('index.php?option=com_cot_forms&view=oi_admin&id=' . (int)$item->id); ?>">
									<?php echo $item->id; ?> - <?php echo $item->observation_date; ?> <?php echo JText::_('COM_COT_FORMS_OBSERVER_ITEM'); ?> <?php echo $item->observer_name; ?>
								</a>
								
										- <a href="javascript:deleteItem(<?php echo $item->id; ?>);"><?php echo JText::_("COM_COT_FORMS_DELETE_ITEM"); ?></a>
										<form id="form-oi-admin-delete-<?php echo $item->id; ?>" style="display:inline" action="<?php echo JRoute::_('index.php?option=com_cot_forms&task=oi_admin.remove'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
											<input type="hidden" name="jform[id]" value="<?php echo $item->id; ?>" />
											<input type="hidden" name="option" value="com_cot_forms" />
											<input type="hidden" name="task" value="oi_admin.remove" />
											<?php echo JHtml::_('form.token'); ?>
										</form>
									
							</li>

<?php endforeach; ?>
        <?php
        if (!$show):
            echo JText::_('COM_COT_FORMS_NO_ITEMS');
        endif;
        ?>
    </ul>
</div>
<?php if ($show): ?>
    <div class="pagination">
        <p class="counter">
            <?php echo $this->pagination->getPagesCounter(); ?>
        </p>
        <?php echo $this->pagination->getPagesLinks(); ?>
    </div>
<?php endif; ?>

	<a href="<?php echo JRoute::_('index.php?option=com_cot_forms&task=oi_admin.edit&id=0'); ?>">
		<?php echo JText::_("COM_COT_FORMS_ADD_ITEM"); ?></a>
&nbsp;
<?php if ($show): ?>
	<a href="<?php echo JRoute::_('index.php?option=com_cot_forms&task=oi_admins.export'); ?>">
		<?php echo JText::_("COM_COT_FORMS_EXPORT_ITEM"); ?></a>
<?php endif; ?>
