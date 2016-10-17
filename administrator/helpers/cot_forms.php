<?php
/**
 * @version     2.0.2
 * @package     com_cot_forms
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Sylvie Fiat <sylvie.fiat@ird.fr>
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Cot forms helper.
 */
class Cot_formsHelper
{
	/**
	 * Configure the Linkbar.
	 */
	public static function addSubmenu($vName = '')
	{		
		JHtmlSidebar::addEntry(
			JText::_('COM_COT_FORMS_TITLE_COT_ADMINS'),
			'index.php?option=com_cot_forms&view=cot_admins',
			$vName == 'cot_admins'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_COT_FORMS_TITLE_SC_ADMINS'),
			'index.php?option=com_cot_forms&view=sc_admins',
			$vName == 'sc_admins'
		);	
		JHtmlSidebar::addEntry(
			JText::_('COM_COT_FORMS_TITLE_OI_ADMINS'),
			'index.php?option=com_cot_forms&view=oi_admins',
			$vName == 'oi_admins'
		);	
		JHtmlSidebar::addEntry(
			JText::_('COM_COT_FORMS_TITLE_HABITAT_ADMINS'),
			'index.php?option=com_cot_forms&view=habitat_admins',
			$vName == 'habitat_admins'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_COT_FORMS_TITLE_CBM_ADMINS'),
			'index.php?option=com_cot_forms&view=cbm_admins',
			$vName == 'cbm_admins'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_COT_FORMS_TITLE_AQUACULTURE_ADMINS'),
			'index.php?option=com_cot_forms&view=aquaculture_admins',
			$vName == 'aquaculture_admins'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_COT_FORMS_TITLE_MAMMALS_ADMINS'),
			'index.php?option=com_cot_forms&view=mammals_admins',
			$vName == 'mammals_admins'
		);

	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_cot_forms';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}

	
}
