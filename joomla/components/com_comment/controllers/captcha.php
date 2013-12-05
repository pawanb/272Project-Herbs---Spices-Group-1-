<?php
/**
 * @author Daniel Dimitrov - compojoom.com
 * @date: 11.04.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controllerlegacy');

class ccommentControllerCaptcha extends JControllerLegacy
{

    public function __construct($var) {
        parent::__construct();
    }

    public function generate() {
        $model = $this->getModel('Captcha', 'ccommentModel');

        $model->createImage();
        jexit();
    }
}