<?php
/**
 * @version     2.0.3
 * @package     com_cot_forms
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Sylvie Fiat <sylvie.fiat@ird.fr>
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Cbm admin controller class.
 */
class Cot_formsControllerCbm_admin extends JControllerForm
{

    function __construct() {
        $this->view_list = 'cbm_admins';
        parent::__construct();
    }

}
