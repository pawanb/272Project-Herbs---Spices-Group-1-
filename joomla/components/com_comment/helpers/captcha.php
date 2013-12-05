<?php

/*
 * Copyright Copyright (C) 2010 Daniel Dimitrov (http://compojoom.com). All rights reserved.
 * Copyright Copyright (C) 2007 Alain Georgette. All rights reserved.
 * Copyright Copyright (C) 2006 Frantisek Hliva. All rights reserved.
 * License http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * !JoomlaComment is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * !JoomlaComment is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA  02110-1301, USA.
 */

defined('_JEXEC') or die('Direct Access to this location is not allowed.');

class ccommentHelperCaptcha
{

	public static function insertCaptcha($inputname, $CaptchaType, $RecaptchaPublicKey)
	{
		switch ($CaptchaType)
		{
			case "recaptcha":
				return ccommentHelperRecaptcha::getHtml($RecaptchaPublicKey);
			default:
				$refid = md5(time() * rand());
				$uri = JRoute::_('index.php?option=com_comment&task=captcha.generate&refid=' . $refid);
				$insertstr =
					"<img src=\"" . $uri . "\" alt=\"" . $CaptchaType . " Security Image\" />\n"
					. "<input type=\"hidden\" name=\"" . $inputname . "\" value=\"" . $refid . "\" />"
					;
				return $insertstr;
		}
	}

	public static function checkCaptcha($referenceid, $enteredvalue)
	{
		$db = JFactory::getDBO();

		$referenceid = $db->q($referenceid);
		$enteredvalue = $db->q($enteredvalue);
		// delete and check in the same time if exist
		$query = "DELETE FROM #__comment_captcha "
			. "\n WHERE referenceid=" . $referenceid . " AND hiddentext=" . $enteredvalue;
		$db->setQuery($query);
		$db->query();
		$result = $db->getAffectedRows();
		if ($result)
		{
			return true;
		}

		return false;
	}

	public static function captchaResult($CaptchaType, $RecaptchaPrivateKey)
	{
		$input = JFactory::getApplication()->input;
		$data = $input->get('jform', '', 'array');
		switch ($CaptchaType)
		{
			case "recaptcha":
				$recaptcha_challenge_field = $data["recaptcha_challenge_field"];
				$recaptcha_response_field = $data["recaptcha_response_field"];
				$resp = ccommentHelperRecaptcha::checkAnswer($RecaptchaPrivateKey,
					$_SERVER["REMOTE_ADDR"],
					$recaptcha_challenge_field,
					$recaptcha_response_field);
				return ($resp->is_valid == 1);
			default:
				$security_try = $data["security_try"];
				$checkSecurity = false;
				if ($security_try)
				{
					$security_refid = $data["security_refid"];
					$checkSecurity = self::checkCaptcha($security_refid, $security_try);
				}
				return $checkSecurity;
		}
	}
}