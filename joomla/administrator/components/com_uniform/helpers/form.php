<?php

/**
 * @version     $Id: form.php 19013 2012-11-28 04:48:47Z thailv $
 * @package     JSNUniform
 * @subpackage  Helpers
 * @author      JoomlaShine Team <support@joomlashine.com>
 * @copyright   Copyright (C) 2012 JoomlaShine.com. All Rights Reserved.
 * @license     GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.joomlashine.com
 * Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 *
 */
defined('_JEXEC') or die('Restricted access');

/**
 *  JSNUniform generate form helper
 *
 * @package     Joomla.Administrator
 * @subpackage  com_uniform
 * @since       1.6
 */
class JSNFormGenerateHelper
{

	/**
	 * Generate html code for a form which includes all the required fields
	 *
	 * @param   object  $dataGenrate     Data genrate
	 *
	 * @param   string  $layout          The layout genrate
	 *
	 * @param   object  $dataSumbission  Data submission
	 *
	 * @return void
	 */
	public static function generate($dataGenrate = null, $dataSumbission = null, $pageContainer = null)
	{
		$formElement = array();

		foreach ($dataGenrate as $data)
		{
			$fileType = preg_replace('/[^a-z]/i', "", $data->type);
			$method = "field{$fileType}";
			if (method_exists('JSNFormGenerateHelper', $method))
			{
				$formElement[$data->position][] = self::$method($data, $dataSumbission);
			}
		}
		$getContainer = json_decode($pageContainer);
		$columnOutput = '';
		foreach ($getContainer as $items)
		{
			if ($items)
			{
				$columnOutput .= "<div class='jsn-row-container row-fluid'>";

				foreach ($items as $item)
				{
					$columName = !empty($item->columnName) ? $item->columnName : "left";
					$columClass = !empty($item->columnClass) ? $item->columnClass : "span12";
					$dataColumn = isset($formElement[$columName]) ? $formElement[$columName] : array();
					$columnOutput .= "<div class=\"jsn-container-{$columName} {$columClass}\">";
					if (!empty($dataColumn))
					{
						$columnOutput .= implode("\n", $dataColumn);
					}
					$columnOutput .= "</div>";
				}
				$columnOutput .= "</div>";
			}
		}
		return $columnOutput;
	}

	/**
	 * Return span number based on bootstrap grid layout
	 *
	 * @param   string  $styles       Style Column
	 *
	 * @param   int     $columnCount  Count column
	 *
	 * @return array
	 */
	public static function getColumnSizes($styles, $columnCount)
	{
		$spans = explode('-', $styles);
		$spanCount = count($spans);

		if ($spanCount < $columnCount)
		{
			$spans = array_merge($spans, array_fill(0, $columnCount - $spanCount, 1));
		}
		elseif ($spanCount > $columnCount)
		{
			$spans = array_slice($spans, 0, $columnCount);
		}

		$spanSum = array_sum($spans);
		$ratio = 12 / $spanSum;

		foreach ($spans as $index => $span)
		{
			$spans[$index] = ceil($span * $ratio);
		}

		$spans[] = 12 - array_sum($spans);
		return $spans;
	}

	/**
	 * Generate html code for "Website" data field
	 *
	 * @param   object  $data            Data field
	 *
	 * @param   array   $dataSumbission  Data submission
	 *
	 * @return string
	 */
	public static function fieldWebsite($data, $dataSumbission)
	{

		$identify = !empty($data->identify) ? $data->identify : "";
		$hideField = !empty($data->options->hideField) ? 'hide' : '';
		$customClass = !empty($data->options->customClass) ? $data->options->customClass : "";
		$required = !empty($data->options->required) ? '<span class="required">*</span>' : '';
		$requiredWebsite = !empty($data->options->required) ? 'website-required' : '';
		$instruction = !empty($data->options->instruction) ? " <i original-title=\"" . htmlentities(JText::_($data->options->instruction), ENT_QUOTES, "UTF-8") . "\" class=\"icon-question-sign\"></i>" : '';
		$sizeInput = !empty($data->options->size) ? $data->options->size : '';
		$defaultValue = !empty($dataSumbission[$data->id]) ? $dataSumbission[$data->id] : '';
		$placeholder = !empty($data->options->value) ? JText::_($data->options->value) : "";
		$html = "<div class=\"control-group {$customClass} {$identify} {$hideField}\"><label for=\"" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "\" class=\"control-label\">" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "{$required}{$instruction}</label><div class=\"controls\"><input class=\"website {$requiredWebsite} {$sizeInput}\" id=\"{$data->id}\" name=\"{$data->id}\" type=\"text\" value=\"{$defaultValue}\" placeholder=\"" . htmlentities($placeholder, ENT_QUOTES, "UTF-8") . "\" /></div></div>";
		return $html;
	}

	/**
	 * Generate html code for "SingleLineText" data field
	 *
	 * @param   object  $data            Data field
	 *
	 * @param   array   $dataSumbission  Data submission
	 *
	 * @return string
	 */
	public static function fieldSingleLineText($data, $dataSumbission)
	{

		$limitValue = "";
		$styleClassLimit = "";
		$identify = !empty($data->identify) ? $data->identify : "";
		if (isset($data->options->limitation) && $data->options->limitation == 1)
		{
			$josnLimit = json_encode(array('limitMin' => $data->options->limitMin, 'limitMax' => $data->options->limitMax, 'limitType' => $data->options->limitType));
			if (isset($data->options->limitMax) && isset($data->options->limitMin) && $data->options->limitMax >= $data->options->limitMin && $data->options->limitMax > 0 && $data->options->limitMin >= 0)
			{
				if ($data->options->limitMax != 0 && $data->options->limitType == 'Characters')
				{
					$limitValue = "data-limit='{$josnLimit}' maxlength=\"{$data->options->limitMax}\"";
				}
				else
				{
					$limitValue = "data-limit='{$josnLimit}'";
				}
				$styleClassLimit = "limit-required";
			}

		}
		$defaultValue = !empty($dataSumbission[$data->id]) ? $dataSumbission[$data->id] : '';
		$required = !empty($data->options->required) ? '<span class="required">*</span>' : '';
		$requiredBlank = !empty($data->options->required) ? 'blank-required' : '';
		$hideField = !empty($data->options->hideField) ? 'hide' : '';
		$customClass = !empty($data->options->customClass) ? $data->options->customClass : "";
		$instruction = !empty($data->options->instruction) ? " <i original-title=\"" . htmlentities(JText::_($data->options->instruction), ENT_QUOTES, "UTF-8") . "\" class=\"icon-question-sign\"></i>" : '';
		$sizeInput = !empty($data->options->size) ? $data->options->size : '';
		$placeholder = !empty($data->options->value) ? JText::_($data->options->value) : "";
		$html = "<div class=\"control-group {$customClass} {$identify} {$hideField}\"><label for=\"" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "\" class=\"control-label\">" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "{$required}{$instruction}</label><div class=\"controls {$requiredBlank}\"><input {$limitValue} class=\"{$styleClassLimit} {$sizeInput}\" id=\"{$data->id}\" name=\"{$data->id}\" type=\"text\" value=\"" . htmlentities($defaultValue, ENT_QUOTES, "UTF-8") . "\" placeholder=\"" . htmlentities($placeholder, ENT_QUOTES, "UTF-8") . "\" /></div></div>";
		return $html;
	}

	/**
	 * Generate html code for "Phone" data field
	 *
	 * @param   object  $data            Data field
	 *
	 * @param   array   $dataSumbission  Data submission
	 *
	 * @return string
	 */
	public static function fieldDate($data, $dataSumbission)
	{

		$identify = !empty($data->identify) ? $data->identify : "";
		$hideField = !empty($data->options->hideField) ? 'hide' : '';
		$customClass = !empty($data->options->customClass) ? $data->options->customClass : "";
		$required = !empty($data->options->required) ? '<span class="required">*</span>' : '';
		$requiredBlank = !empty($data->options->required) ? 'group-blank-required' : '';
		$sizeInput = 'input-small';
		$valueDate = '';
		$valueDateRange = '';
		if (isset($dataSumbission['date'][$data->id]))
		{
			$valueDate = isset($dataSumbission['date'][$data->id]['date']) ? $dataSumbission['date'][$data->id]['date'] : "";
			$valueDateRange = isset($dataSumbission['date'][$data->id]['daterange']) ? $dataSumbission['date'][$data->id]['daterange'] : "";
		}
		$instruction = !empty($data->options->instruction) ? " <i original-title=\"" . htmlentities(JText::_($data->options->instruction), ENT_QUOTES, "UTF-8") . "\" class=\"icon-question-sign\"></i>" : '';
		$dateSettings = json_encode($data->options);
		$placeholder = !empty($data->options->dateValue) ? JText::_($data->options->dateValue) : "";
		$placeholderDateRange = !empty($data->options->dateValueRange) ? JText::_($data->options->dateValueRange) : "";
		if (isset($data->options->timeFormat) && $data->options->timeFormat == "1" && isset($data->options->dateFormat) && $data->options->dateFormat == "1")
		{
			$sizeInput = 'input-medium';
		}
		$html = "<div class=\"control-group {$customClass} {$identify} {$hideField}\">
					<label for=\"" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "\" class=\"control-label\">" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "{$required}{$instruction}</label>
						<div class=\"controls {$requiredBlank}\">
							<div class=\"input-append jsn-inline\"><input date-settings=\"" . htmlentities($dateSettings, ENT_QUOTES, "UTF-8") . "\" placeholder=\"" . htmlentities($placeholder, ENT_QUOTES, "UTF-8") . "\" value=\"" . $valueDate . "\" class=\"jsn-daterangepicker {$sizeInput}\" id=\"{$data->id}\" name=\"date[{$data->id}][date]\" type=\"text\" readonly /></div>
								";
		if ($data->options->enableRageSelection == "1" || $data->options->enableRageSelection == 1)
		{
			$html .= "<div class=\"input-append jsn-inline\"><input date-settings=\"" . htmlentities($dateSettings, ENT_QUOTES, "UTF-8") . "\" placeholder=\"" . htmlentities($placeholderDateRange, ENT_QUOTES, "UTF-8") . "\" value=\"" . htmlentities($valueDateRange, ENT_QUOTES, "UTF-8") . "\" class=\"jsn-daterangepicker {$sizeInput}\" id=\"range_{$data->id}\" name=\"date[{$data->id}][daterange]\" type=\"text\" readonly /></div>";
		}
		$html .= "</div></div>";
		return $html;
	}

	/**
	 * Generate html code for "Currency" data field
	 *
	 * @param   object  $data            Data field
	 *
	 * @param   array   $dataSumbission  Data submission
	 *
	 * @return string
	 */
	public static function fieldCurrency($data, $dataSumbission)
	{

		$identify = !empty($data->identify) ? $data->identify : "";
		$hideField = !empty($data->options->hideField) ? 'hide' : '';
		$customClass = !empty($data->options->customClass) ? $data->options->customClass : "";
		$required = !empty($data->options->required) ? '<span class="required">*</span>' : '';
		$requiredBlank = !empty($data->options->required) ? 'group-blank-required' : '';
		//$sizeInput = !empty($data -> options -> size) ? $data -> options -> size : '';
		$defaultValue = "";
		$centsValue = "";
		if (isset($dataSumbission['currency'][$data->id]))
		{
			$defaultValue = isset($dataSumbission['currency'][$data->id]['value']) ? $dataSumbission['currency'][$data->id]['value'] : "";
			$centsValue = isset($dataSumbission['currency'][$data->id]['cents']) ? $dataSumbission['currency'][$data->id]['cents'] : "";
		}
		$options['Haht'] = array('prefix' => '฿', 'cents' => 'Satang');
		$options['Dollars'] = array('prefix' => '$', 'cents' => 'Cents');
		$options['Euros'] = array('prefix' => '€', 'cents' => 'Cents');
		$options['Forint'] = array('prefix' => 'Ft', 'cents' => 'Filler');
		$options['Francs'] = array('prefix' => 'CHF', 'cents' => 'Rappen');
		$options['Koruna'] = array('prefix' => 'Kč', 'cents' => 'Haléřů');
		$options['Krona'] = array('prefix' => 'kr', 'cents' => 'Ore');
		$options['Pesos'] = array('prefix' => '$', 'cents' => 'Cents');
		$options['Pounds'] = array('prefix' => '£', 'cents' => 'Pence');
		$options['Ringgit'] = array('prefix' => 'RM', 'cents' => 'Sen');
		$options['Shekel'] = array('prefix' => '₪', 'cents' => 'Agora');
		$options['Yen'] = array('prefix' => '¥', 'cents' => '');
		$options['Rupee'] = array('prefix' => '₹', 'cents' => '');
		$options['Zloty'] = array('prefix' => 'zł', 'cents' => 'Grosz');

		//	$defaultValue = !empty($dataSumbission[$data -> id]) ? $dataSumbission[$data -> id] : '';
		$instruction = !empty($data->options->instruction) ? " <i original-title=\"" . htmlentities(JText::_($data->options->instruction), ENT_QUOTES, "UTF-8") . "\" class=\"icon-question-sign\"></i>" : '';
		$placeholder = !empty($data->options->value) ? JText::_($data->options->value) : "";
		$placeholderCents = !empty($data->options->cents) ? JText::_($data->options->cents) : "";
		$inputContent = "";
		if (isset($data->options->format))
		{
			$showHelpBlock = "";
			if (!empty($data->options->showCurrencyTitle) && $data->options->showCurrencyTitle == "Yes")
			{
				$showHelpBlock = "<span class=\"jsn-help-block-inline\">" . $data->options->format . "</span>";
			}

			$inputContent = "<div class=\"input-prepend jsn-inline currency-value\"><div class=\"controls-inner\"><span class=\"add-on\">" . $options[$data->options->format]['prefix'] . "</span><input name=\"currency[{$data->id}][value]\" type=\"text\" placeholder=\"" . htmlentities($placeholder, ENT_QUOTES, "UTF-8") . "\" class=\"input-medium currency\" value=\"{$defaultValue}\"></div>{$showHelpBlock}</div>";
			if ($data->options->format != "Yen" && $data->options->format != "Rupee")
			{
				$showHelpBlockSents = "";
				if (!empty($data->options->showCurrencyTitle) && $data->options->showCurrencyTitle == "Yes")
				{
					$showHelpBlockSents = "<span class=\"jsn-help-block-inline\">" . $options[$data->options->format]['cents'] . "</span>";
				}
				$inputContent .= "<div class=\"jsn-inline currency-cents\"><div class=\"controls-inner\"><input name=\"currency[{$data->id}][cents]\" type=\"text\" placeholder=\"{$placeholderCents}\" class=\"input-mini currency\" value=\"{$centsValue}\"></div>{$showHelpBlockSents}</div>";
			}
		}
		$html = "<div class=\"control-group {$customClass} {$identify} {$hideField}\"><label for=\"" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "\" class=\"control-label\">" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "{$required}{$instruction}</label><div class=\"controls {$requiredBlank} currency-control clearfix\"><div class=\"clearfix\">{$inputContent}</div></div></div>";
		return $html;
	}

	/**
	 * Generate html code for "Phone" data field
	 *
	 * @param   object  $data            Data field
	 *
	 * @param   array   $dataSumbission  Data submission
	 *
	 * @return string
	 */
	public static function fieldPhone($data, $dataSumbission)
	{

		$identify = !empty($data->identify) ? $data->identify : "";
		$hideField = !empty($data->options->hideField) ? 'hide' : '';
		$customClass = !empty($data->options->customClass) ? $data->options->customClass : "";
		$required = !empty($data->options->required) ? '<span class="required">*</span>' : '';
		$requiredBlank = !empty($data->options->required) ? 'group-blank-required' : '';
		//$sizeInput = !empty($data -> options -> size) ? $data -> options -> size : '';
		$defaultValue = "";
		$oneValue = "";
		$twoValue = "";
		$threeValue = "";
		if (isset($dataSumbission['phone'][$data->id]))
		{
			$defaultValue = isset($dataSumbission['phone'][$data->id]['default']) ? $dataSumbission['phone'][$data->id]['default'] : "";
			$oneValue = isset($dataSumbission['phone'][$data->id]['one']) ? $dataSumbission['phone'][$data->id]['one'] : "";
			$twoValue = isset($dataSumbission['phone'][$data->id]['two']) ? $dataSumbission['phone'][$data->id]['two'] : "";
			$threeValue = isset($dataSumbission['phone'][$data->id]['three']) ? $dataSumbission['phone'][$data->id]['three'] : "";
		}

		//	$defaultValue = !empty($dataSumbission[$data -> id]) ? $dataSumbission[$data -> id] : '';
		$instruction = !empty($data->options->instruction) ? " <i original-title=\"" . htmlentities(JText::_($data->options->instruction), ENT_QUOTES, "UTF-8") . "\" class=\"icon-question-sign\"></i>" : '';
		$placeholder = !empty($data->options->value) ? JText::_($data->options->value) : "";
		$placeholderOneField = !empty($data->options->oneField) ? JText::_($data->options->oneField) : "";
		$placeholderTwoField = !empty($data->options->twoField) ? JText::_($data->options->twoField) : "";
		$placeholderThreeField = !empty($data->options->threeField) ? JText::_($data->options->threeField) : "";
		$inputContent = "<input class=\"phone jsn-input-medium-fluid\" id=\"{$data->id}\" name=\"phone[{$data->id}][default]\" type=\"text\" value=\"{$defaultValue}\" placeholder=\"" . htmlentities($placeholder, ENT_QUOTES, "UTF-8") . "\" />";
		if (isset($data->options->format) && $data->options->format == "3-field")
		{
			$inputContent = "<div class=\"jsn-inline\"><input id=\"one_{$data->id}\" name=\"phone[{$data->id}][one]\" value='" . htmlentities($oneValue, ENT_QUOTES, "UTF-8") . "' type=\"text\" placeholder=\"" . htmlentities($placeholderOneField, ENT_QUOTES, "UTF-8") . "\" class=\"phone jsn-input-mini-fluid\"></div>
							<span class=\"jsn-field-prefix\">-</span>
							<div class=\"jsn-inline\"><input id=\"two_{$data->id}\" name=\"phone[{$data->id}][two]\" value='" . htmlentities($twoValue, ENT_QUOTES, "UTF-8") . "' type=\"text\" placeholder=\"" . htmlentities($placeholderTwoField, ENT_QUOTES, "UTF-8") . "\" class=\"phone jsn-input-mini-fluid\"></div>
							<span class=\"jsn-field-prefix\">-</span>
							<div class=\"jsn-inline\"><input id=\"three_{$data->id}\" name=\"phone[{$data->id}][three]\" value='" . htmlentities($threeValue, ENT_QUOTES, "UTF-8") . "' type=\"text\" placeholder=\"" . htmlentities($placeholderThreeField, ENT_QUOTES, "UTF-8") . "\" class=\"phone jsn-input-mini-fluid\"></div>";
		}
		$html = "<div class=\"control-group {$customClass} {$identify} {$hideField}\"><label for=\"" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "\" class=\"control-label\">" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "{$required}{$instruction}</label><div class=\"controls {$requiredBlank}\">{$inputContent}</div></div>";
		return $html;
	}

	/**
	 * Generate html code for "ParagraphText" data field
	 *
	 * @param   object  $data            Data field
	 *
	 * @param   array   $dataSumbission  Data submission
	 *
	 * @return string
	 */
	public static function fieldParagraphText($data, $dataSumbission)
	{

		$identify = !empty($data->identify) ? $data->identify : "";
		$hideField = !empty($data->options->hideField) ? 'hide' : '';
		$customClass = !empty($data->options->customClass) ? $data->options->customClass : "";
		$limitValue = "";
		$styleClassLimit = "";
		if (isset($data->options->limitation) && $data->options->limitation == 1)
		{
			$josnLimit = json_encode(array('limitMin' => $data->options->limitMin, 'limitMax' => $data->options->limitMax, 'limitType' => $data->options->limitType));
			if (isset($data->options->limitMax) && isset($data->options->limitMin) && $data->options->limitMax >= $data->options->limitMin && $data->options->limitMax > 0 && $data->options->limitMin >= 0)
			{
				if ($data->options->limitMax != 0 && $data->options->limitType == 'Characters')
				{
					$limitValue = "data-limit='{$josnLimit}' maxlength=\"{$data->options->limitMax}\"";
				}
				else
				{
					$limitValue = "data-limit='{$josnLimit}'";
				}
				$styleClassLimit = "limit-required";
			}
		}
		$sizeInput = !empty($data->options->size) ? $data->options->size : '';
		$defaultValue = !empty($dataSumbission[$data->id]) ? $dataSumbission[$data->id] : '';
		$required = !empty($data->options->required) ? '<span class="required">*</span>' : '';
		$requiredBlank = !empty($data->options->required) ? 'blank-required' : '';
		$rows = !empty($data->options->rows) && (int) $data->options->rows ? $data->options->rows : '10';
		$instruction = !empty($data->options->instruction) ? " <i original-title=\"" . htmlentities(JText::_($data->options->instruction), ENT_QUOTES, "UTF-8") . "\" class=\"icon-question-sign\"></i>" : '';
		$placeholder = !empty($data->options->value) ? JText::_($data->options->value) : "";
		$html = "<div class=\"control-group {$customClass} {$identify} {$hideField}\"><label for=\"" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "\" class=\"control-label\">" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "{$required}{$instruction}</label><div class=\"controls {$requiredBlank}\"><textarea {$limitValue} rows=\"{$rows}\" class=\" {$styleClassLimit} {$sizeInput}\" id=\"{$data->id}\" name=\"{$data->id}\" placeholder=\"" . htmlentities($placeholder, ENT_QUOTES, "UTF-8") . "\">{$defaultValue}</textarea></div></div>";
		return $html;
	}

	/**
	 * Generate html code for "Number" data field
	 *
	 * @param   object  $data            Data field
	 *
	 * @param   array   $dataSumbission  Data submission
	 *
	 * @return string
	 */
	public static function fieldNumber($data, $dataSumbission)
	{

		$identify = !empty($data->identify) ? $data->identify : "";
		$hideField = !empty($data->options->hideField) ? 'hide' : '';
		$customClass = !empty($data->options->customClass) ? $data->options->customClass : "";
		$limitValue = "";
		$styleClassLimit = "";
		if (isset($data->options->limitation) && $data->options->limitation == 1)
		{
			$data->options->limitType = isset($data->options->limitType) ? $data->options->limitType : 'Characters';
			$josnLimit = json_encode(array('limitMin' => $data->options->limitMin, 'limitMax' => $data->options->limitMax, 'limitType' => $data->options->limitType));
			if (isset($data->options->limitMax) && isset($data->options->limitMin) && $data->options->limitMax >= $data->options->limitMin && $data->options->limitMax > 0 && $data->options->limitMin >= 0)
			{
				$limitValue = "data-limit='{$josnLimit}'";
				$styleClassLimit = "number-limit-required";
			}
		}
		$sizeInput = !empty($data->options->size) ? $data->options->size : '';
		$defaultValue = "";
		$defaultValueDecimal = "";
		if ($dataSumbission)
		{
			$defaultValue = isset($dataSumbission['number'][$data->id]['value']) ? $dataSumbission['number'][$data->id]['value'] : "";
			$defaultValueDecimal = isset($dataSumbission['number'][$data->id]['decimal']) ? $dataSumbission['number'][$data->id]['decimal'] : "";
		}
		$required = !empty($data->options->required) ? '<span class="required">*</span>' : '';
		$requiredInteger = !empty($data->options->required) ? 'integer-required' : '';
		$instruction = !empty($data->options->instruction) ? " <i original-title=\"" . htmlentities(JText::_($data->options->instruction), ENT_QUOTES, "UTF-8") . "\" class=\"icon-question-sign\"></i>" : '';
		$placeholder = !empty($data->options->value) ? JText::_($data->options->value) : "";
		$placeholderDecimal = !empty($data->options->decimal) ? JText::_($data->options->decimal) : "";
		$showDecimal = "";

		if (!empty($data->options->showDecimal) && $data->options->showDecimal == "1")
		{
			$showDecimal = "<span class=\"jsn-field-prefix\">.</span><input {$limitValue} class=\"number input-mini\" name=\"number[{$data->id}][decimal]\" type=\"number\" value=\"" . htmlentities($defaultValueDecimal, ENT_QUOTES, "UTF-8") . "\" placeholder=\"" . htmlentities($placeholderDecimal, ENT_QUOTES, "UTF-8") . "\" />";
		}
		$html = "<div class=\"control-group {$customClass} {$identify} {$hideField}\"><label for=\"" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "\" class=\"control-label\">" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "{$required}{$instruction}</label><div class=\"controls\"><input {$limitValue} class=\"number {$requiredInteger} {$styleClassLimit} {$sizeInput}\" id=\"{$data->id}\" name=\"number[{$data->id}][value]\" type=\"number\" value=\"" . htmlentities($defaultValue, ENT_QUOTES, "UTF-8") . "\" placeholder=\"" . htmlentities($placeholder, ENT_QUOTES, "UTF-8") . "\" />{$showDecimal}</div></div>";
		return $html;
	}

	/**
	 * Generate html code for "Name" data field
	 *
	 * @param   object  $data            Data field
	 *
	 * @param   array   $dataSumbission  Data submission
	 *
	 * @return string
	 */
	public static function fieldName($data, $dataSumbission)
	{


		$identify = !empty($data->identify) ? $data->identify : "";
		$hideField = !empty($data->options->hideField) ? 'hide' : '';
		$customClass = !empty($data->options->customClass) ? $data->options->customClass : "";
		$required = !empty($data->options->required) ? '<span class="required">*</span>' : '';
		$requiredBlank = !empty($data->options->required) ? 'group-blank-required' : '';
		$instruction = !empty($data->options->instruction) ? " <i original-title=\"" . htmlentities(JText::_($data->options->instruction), ENT_QUOTES, "UTF-8") . "\" class=\"icon-question-sign\"></i>" : '';
		$listField = !empty($data->options->sortableField) ? json_decode($data->options->sortableField) : array("vtitle", "vfirst", "vmiddle", "vlast");

		$html = "<div class=\"control-group {$customClass} {$identify} {$hideField}\"><label for=\"" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "\" class=\"control-label\">" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "{$required}{$instruction}</label><div id=\"{$data->id}\" class=\"controls {$requiredBlank}\">";
		$valueFirstName = '';
		$valueLastName = '';
		$valueMiddle = '';

		if (!empty($dataSumbission))
		{
			$valueFirstName = isset($dataSumbission['name'][$data->id]['first']) ? $dataSumbission['name'][$data->id]['first'] : "";
			$valueLastName = isset($dataSumbission['name'][$data->id]['last']) ? $dataSumbission['name'][$data->id]['last'] : "";
			$valueTitle = isset($dataSumbission['name'][$data->id]['title']) ? $dataSumbission['name'][$data->id]['title'] : "";
			$valueMiddle = isset($dataSumbission['name'][$data->id]['suffix']) ? $dataSumbission['name'][$data->id]['suffix'] : "";
		}

		$sizeInput = !empty($data->options->size) ? $data->options->size : '';
		foreach ($listField as $field)
		{
			switch($field)
			{
				case "vtitle":
					if (!empty($data->options->vtitle))
					{

						$html .= "<select class=\"jsn-input-fluid\" name=\"name[{$data->id}][title]\">";
						if (isset($data->options->items) && is_array($data->options->items))
						{
							foreach ($data->options->items as $option)
							{
								if (!empty($valueTitle))
								{
									if (isset($option->text) && $option->text == $valueTitle)
									{
										$selected = "selected='true'";
									}
									else
									{
										$selected = "";
									}
								}
								else
								{
									if ($option->checked == 1 || $option->checked == 'true')
									{
										$selected = "selected='true'";
									}
									else
									{
										$selected = "";
									}
								}
								$html .= "<option {$selected} value=\"{$option->text}\">{$option->text}</option>";
							}
						}
						$html .= "</select>&nbsp;&nbsp;";
					}
					break;
				case "vfirst":
					if (!empty($data->options->vfirst))
					{
						$html .= "<input type=\"text\" class=\"{$sizeInput}\" value='" . htmlentities($valueFirstName, ENT_QUOTES, "UTF-8") . "' name=\"name[{$data->id}][first]\" placeholder=\"" . htmlentities(JText::_("First"), ENT_QUOTES, "UTF-8") . "\" />&nbsp;&nbsp;";
					}
					break;
				case "vmiddle":
					if (!empty($data->options->vmiddle))
					{
						$html .= "<input name=\"name[{$data->id}][suffix]\" type=\"text\" value=\"" . htmlentities($valueMiddle, ENT_QUOTES, "UTF-8") . "\" class=\"{$sizeInput}\" placeholder=\"" . htmlentities(JText::_("Middle"), ENT_QUOTES, "UTF-8") . "\" />&nbsp;&nbsp;";
					}
					break;
				case "vlast":
					if (!empty($data->options->vlast))
					{
						$html .= "<input type=\"text\" class=\"{$sizeInput}\" value='" . htmlentities($valueLastName, ENT_QUOTES, "UTF-8") . "' name=\"name[{$data->id}][last]\" placeholder=\"" . htmlentities(JText::_("Last"), ENT_QUOTES, "UTF-8") . "\" />";
					}
					break;
			}
		}
		$html .= "</div></div>";
		return $html;
	}

	/**
	 * Generate html code for "FileUpload" data field
	 *
	 * @param   object  $data            Data field
	 *
	 * @param   array   $dataSumbission  Data submission
	 *
	 * @return string
	 */
	public static function fieldFileUpload($data, $dataSumbission)
	{

		$identify = !empty($data->identify) ? $data->identify : "";
		$hideField = !empty($data->options->hideField) ? 'hide' : '';
		$customClass = !empty($data->options->customClass) ? $data->options->customClass : "";
		$requiredBlank = !empty($data->options->required) ? 'blank-required' : '';
		$multiple = !empty($data->options->multiple) ? 'multiple' : '';
		$required = !empty($data->options->required) ? '<span class="required">*</span>' : '';
		$instruction = !empty($data->options->instruction) ? " <i original-title=\"" . htmlentities(JText::_($data->options->instruction), ENT_QUOTES, "UTF-8") . "\" class=\"icon-question-sign\"></i>" : '';
		$html = "<div class=\"control-group {$customClass} {$identify} {$hideField}\"><label for=\"" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "\" class=\"control-label\">" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "{$required}{$instruction}</label><div class=\"controls {$requiredBlank}\"><input id=\"{$data->id}\" class=\"input-file\" name=\"{$data->id}[]\" {$multiple} type=\"file\" /></div></div>";
		return $html;
	}

	/**
	 * Generate html code for "Email" data field
	 *
	 * @param   object  $data            Data field
	 *
	 * @param   array   $dataSumbission  Data submission
	 *
	 * @return string
	 */
	public static function fieldEmail($data, $dataSumbission)
	{


		$identify = !empty($data->identify) ? $data->identify : "";
		$hideField = !empty($data->options->hideField) ? 'hide' : '';
		$customClass = !empty($data->options->customClass) ? $data->options->customClass : "";
		$required = !empty($data->options->required) ? '<span class="required">*</span>' : '';
		$requiredEmail = !empty($data->options->required) ? 'email-required' : '';
		$instruction = !empty($data->options->instruction) ? " <i original-title=\"" . htmlentities(JText::_($data->options->instruction), ENT_QUOTES, "UTF-8") . "\" class=\"icon-question-sign\"></i>" : '';


		$defaultValue = !empty($dataSumbission[$data->id]) ? $dataSumbission[$data->id] : '';
		$defaultValueConfirm = !empty($dataSumbission[$data->id . "_confirm"]) ? $dataSumbission[$data->id . "_confirm"] : '';


		$sizeInput = !empty($data->options->size) ? $data->options->size : '';
		$placeholder = !empty($data->options->value) ? JText::_($data->options->value) : "";
		$placeholderConfirm = !empty($data->options->valueConfirm) ? JText::_($data->options->valueConfirm) : "";

		$html = "<div class=\"control-group {$customClass} {$identify} {$hideField}\"><label for=\"" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "\" class=\"control-label\">" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "{$required}{$instruction}</label><div class=\"controls\">";
		$html .= "<div class=\"row-fluid\"><input class=\"email {$requiredEmail} {$sizeInput}\" id=\"{$data->id}\" name=\"{$data->id}\" type=\"text\" value=\"" . htmlentities($defaultValue, ENT_QUOTES, "UTF-8") . "\" placeholder=\"" . htmlentities($placeholder, ENT_QUOTES, "UTF-8") . "\" /></div>";
		if (!empty($data->options->requiredConfirm))
		{
			$html .= "<div class=\"row-fluid\"><input class=\"{$sizeInput} jsn-email-confirm\" id=\"{$data->id}_confirm\" name=\"{$data->id}_confirm\" type=\"text\" value=\"" . htmlentities($defaultValueConfirm, ENT_QUOTES, "UTF-8") . "\" placeholder=\"" . htmlentities($placeholderConfirm, ENT_QUOTES, "UTF-8") . "\" /></div>";
		}
		$html .= "</div></div>";
		return $html;
	}

	/**
	 * Generate html code for "DropDown" data field
	 *
	 * @param   object  $data            Data field
	 *
	 * @param   array   $dataSumbission  Data submission
	 *
	 * @return string
	 */
	public static function fieldDropdown($data, $dataSumbission)
	{

		$identify = !empty($data->identify) ? $data->identify : "";
		$hideField = !empty($data->options->hideField) ? 'hide' : '';
		$customClass = !empty($data->options->customClass) ? $data->options->customClass : "";
		$required = !empty($data->options->required) ? '<span class="required">*</span>' : '';
		$randomDropdown = !empty($data->options->randomize) ? 'dropdown-randomize' : '';
		$instruction = !empty($data->options->instruction) ? " <i original-title=\"" . htmlentities(JText::_($data->options->instruction), ENT_QUOTES, "UTF-8") . "\" class=\"icon-question-sign\"></i>" : '';
		$defaultValue = !empty($dataSumbission[$data->id]) ? $dataSumbission[$data->id] : "";
		$sizeInput = !empty($data->options->size) ? $data->options->size : '';
		$dataSettings = !empty($data->options->itemAction) ? $data->options->itemAction : '';
		$requiredBlank = !empty($data->options->firstItemAsPlaceholder) && !empty($data->options->required) ? 'dropdown-required' : '';
		$html = "<div class=\"control-group {$customClass} {$identify} {$hideField}\" data-settings=\"" . htmlentities($dataSettings, ENT_QUOTES, "UTF-8") . "\"><label for=\"" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "\" class=\"control-label\">" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "{$required}{$instruction}</label><div class=\"controls {$requiredBlank}\"><select id=\"{$data->id}\" class=\"dropdown {$sizeInput} {$randomDropdown}\" name=\"{$data->id}\">";

		if (isset($data->options->items) && is_array($data->options->items))
		{
			foreach ($data->options->items as $index => $option)
			{
				if (!empty($defaultValue))
				{
					if (isset($option->text) && $option->text == $defaultValue)
					{
						$selected = "selected='true'";
					}
					else
					{
						$selected = "";
					}
				}
				else
				{
					if ($option->checked == 1 || $option->checked == 'true')
					{
						$selected = "selected='true'";
					}
					else
					{
						$selected = "";
					}
				}
				$selectDefault = "";
				if ($selected)
				{
					$selectDefault = "selectdefault=\"true\"";
				}
				if (!empty($data->options->firstItemAsPlaceholder) && $index == 0)
				{
					$html .= "<option {$selected} {$selectDefault} value=\"\">" . htmlentities(JText::_($option->text), ENT_QUOTES, "UTF-8") . "</option>";
				}
				else
				{
					$html .= "<option class=\"jsn-column-item\" {$selected} {$selectDefault} value=\"" . htmlentities($option->text, ENT_QUOTES, "UTF-8") . "\">" . htmlentities(JText::_($option->text), ENT_QUOTES, "UTF-8") . "</option>";
				}
			}
		}
		$textOthers = !empty($data->options->labelOthers) ? $data->options->labelOthers : "Others";
		if (!empty($data->options->allowOther))
		{
			$html .= "<option class=\"lbl-allowOther\" value=\"Others\">" . JText::_($textOthers) . "</option>";
			$html .= "</select>";
			$html .= "<div class=\"jsn-column-item jsn-uniform-others\"><textarea class='jsn-dropdown-Others hide' name=\"fieldOthers[{$data->id}]\"  rows=\"3\"></textarea></div></div>";
		}
		else
		{
			$html .= "</select></div>";
		}
		$html .= "</div>";
		return $html;
	}

	/**
	 * Generate html code for "DropDown" data field
	 *
	 * @param   object  $data            Data field
	 *
	 * @param   array   $dataSumbission  Data submission
	 *
	 * @return string
	 */
	public static function fieldList($data, $dataSumbission)
	{

		$identify = !empty($data->identify) ? $data->identify : "";
		$hideField = !empty($data->options->hideField) ? 'hide' : '';
		$customClass = !empty($data->options->customClass) ? $data->options->customClass : "";
		$required = !empty($data->options->required) ? '<span class="required">*</span>' : '';
		$requiredBlank = !empty($data->options->required) ? 'list-required' : '';
		$randomList = !empty($data->options->randomize) ? 'list-randomize' : '';
		$instruction = !empty($data->options->instruction) ? " <i original-title=\"" . htmlentities(JText::_($data->options->instruction), ENT_QUOTES, "UTF-8") . "\" class=\"icon-question-sign\"></i>" : '';
		$defaultValue = !empty($dataSumbission[$data->id]) ? $dataSumbission[$data->id] : "";
		$sizeInput = !empty($data->options->size) ? $data->options->size : '';
		$multiple = !empty($data->options->multiple) ? "multiple" : "size='4'";
		$html = "<div class=\"control-group {$customClass} {$identify} {$hideField} \"><label for=\"" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "\" class=\"control-label\">" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "{$required}{$instruction}</label><div class=\"controls {$requiredBlank}\"><select {$multiple} id=\"{$data->id}\" class=\"list {$sizeInput} {$randomList}\" name=\"{$data->id}[]\">";

		if (isset($data->options->items) && is_array($data->options->items))
		{
			foreach ($data->options->items as $option)
			{
				if (!empty($defaultValue))
				{
					if (isset($option->text) && $option->text == $defaultValue)
					{
						$selected = "selected='true'";
					}
					else
					{
						$selected = "";
					}
				}
				else
				{
					if ($option->checked == 1 || $option->checked == 'true')
					{
						$selected = "selected='true'";
					}
					else
					{
						$selected = "";
					}
				}
				$html .= "<option class=\"jsn-column-item\" {$selected} value=\"" . $option->text . "\">" . htmlentities(JText::_($option->text), ENT_QUOTES, "UTF-8") . "</option>";
			}
		}
		$html .= "</select></div></div>";
		return $html;
	}

	/**
	 * Generate html code for "Country" data field
	 *
	 * @param   object  $data            Data field
	 *
	 * @param   array   $dataSumbission  Data submission
	 *
	 * @return string
	 */
	public static function fieldCountry($data, $dataSumbission)
	{

		$identify = !empty($data->identify) ? $data->identify : "";
		$hideField = !empty($data->options->hideField) ? 'hide' : '';
		$customClass = !empty($data->options->customClass) ? $data->options->customClass : "";
		$required = !empty($data->options->required) ? '<span class="required">*</span>' : '';
		$requiredBlank = !empty($data->options->required) ? 'blank-required' : '';
		$instruction = !empty($data->options->instruction) ? " <i original-title=\"" . htmlentities(JText::_($data->options->instruction), ENT_QUOTES, "UTF-8") . "\" class=\"icon-question-sign\"></i>" : '';
		$defaultValue = !empty($dataSumbission[$data->id]) ? $dataSumbission[$data->id] : "";
		$sizeInput = !empty($data->options->size) ? $data->options->size : '';
		$html = "<div class=\"control-group {$customClass} {$identify} {$hideField} \"><label for=\"" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "\" class=\"control-label\">" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "{$required}{$instruction}</label><div class=\"controls {$requiredBlank}\"><select id=\"{$data->id}\" class=\"{$sizeInput}\" name=\"{$data->id}\">";
		if (isset($data->options->items) && is_array($data->options->items))
		{
			foreach ($data->options->items as $option)
			{
				if (!empty($defaultValue))
				{
					if (isset($option->text) && $option->text == $defaultValue)
					{
						$selected = "selected='true'";
					}
					else
					{
						$selected = "";
					}
				}
				else
				{
					if (isset($option->checked) && $option->checked == 1)
					{
						$selected = "selected='true'";
					}
					else
					{
						$selected = "";
					}
				}
				$html .= "<option {$selected} value=\"" . htmlentities($option->text, ENT_QUOTES, "UTF-8") . "\">" . htmlentities(JText::_($option->text), ENT_QUOTES, "UTF-8") . "</option>";
			}
		}
		$html .= "</select></div></div>";
		return $html;
	}

	/**
	 * Generate html code for "Choices" data field
	 *
	 * @param   object  $data            Data field
	 *
	 * @param   array   $dataSumbission  Data submission
	 *
	 * @return string
	 */
	public static function fieldChoices($data, $dataSumbission)
	{

		$identify = !empty($data->identify) ? $data->identify : "";
		$hideField = !empty($data->options->hideField) ? 'hide' : '';
		$customClass = !empty($data->options->customClass) ? $data->options->customClass : "";
		$required = !empty($data->options->required) ? '<span class="required">*</span>' : '';
		$instruction = !empty($data->options->instruction) ? " <i original-title=\"" . htmlentities(JText::_($data->options->instruction), ENT_QUOTES, "UTF-8") . "\" class=\"icon-question-sign\"></i>" : '';
		$requiredChoices = !empty($data->options->required) ? 'choices-required' : '';
		$randomChoices = !empty($data->options->randomize) ? 'choices-randomize' : '';
		$dataSettings = !empty($data->options->itemAction) ? $data->options->itemAction : '';
		$html = "<div class=\"control-group {$customClass} {$identify} {$hideField} \" data-settings=\"" . htmlentities($dataSettings, ENT_QUOTES, "UTF-8") . "\" ><label for=\"" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "\" class=\"control-label\">" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "{$required}{$instruction}</label><div class=\"controls {$requiredChoices}\"><div id=\"{$data->id}\" class=\"choices jsn-columns-container {$data->options->layout} {$randomChoices}\">";

		$defaultValue = isset($dataSumbission[$data->id]) ? $dataSumbission[$data->id] : "";
		if (isset($data->options->items) && is_array($data->options->items))
		{
			foreach ($data->options->items as $i => $option)
			{
				if (!empty($defaultValue))
				{
					if (isset($option->text) && $option->text == $defaultValue)
					{
						$checked = "checked='true'";
					}
					else
					{
						$checked = "";
					}
				}
				else
				{
					if (isset($option->checked) && $option->checked == "true")
					{
						$checked = "checked='true'";
					}
					else
					{
						$checked = "";
					}
				}
				$html .= "<div class=\"jsn-column-item\"><label class=\"radio\"><input {$checked} name=\"{$data->id}\" value=\"" . htmlentities($option->text, ENT_QUOTES, "UTF-8") . "\" type=\"radio\" />" . htmlentities(JText::_($option->text), ENT_QUOTES, "UTF-8") . "</label></div>";
			}
		}
		$textOthers = !empty($data->options->labelOthers) ? $data->options->labelOthers : "Others";
		if (!empty($data->options->allowOther))
		{
			$html .= "<div class=\"jsn-column-item jsn-uniform-others\"><label class=\"radio lbl-allowOther\"><input class=\"allowOther\" name=\"{$data->id}\" value=\"Others\" type=\"radio\" />" . htmlentities(JText::_($textOthers), ENT_QUOTES, "UTF-8") . "</label>";
			$html .= "<textarea disabled=\"true\" class='jsn-value-Others' name=\"fieldOthers[{$data->id}]\" rows=\"3\"></textarea></div>";
		}
		$html .= "<div class=\"clearbreak\"></div></div></div></div>";

		return $html;
	}

	/**
	 * Generate html code for "Checkboxes" data field
	 *
	 * @param   object  $data            Data field
	 *
	 * @param   array   $dataSumbission  Data submission
	 *
	 * @return string
	 */
	public static function fieldCheckboxes($data, $dataSumbission)
	{

		$identify = !empty($data->identify) ? $data->identify : "";
		$hideField = !empty($data->options->hideField) ? 'hide' : '';
		$customClass = !empty($data->options->customClass) ? $data->options->customClass : "";
		$required = !empty($data->options->required) ? '<span class="required">*</span>' : '';
		$instruction = !empty($data->options->instruction) ? " <i original-title=\"" . htmlentities(JText::_($data->options->instruction), ENT_QUOTES, "UTF-8") . "\" class=\"icon-question-sign\"></i>" : '';
		$requiredCheckbox = !empty($data->options->required) ? 'checkbox-required' : '';
		$randomCheckbox = !empty($data->options->randomize) ? 'checkbox-randomize' : '';
		$dataSettings = !empty($data->options->itemAction) ? $data->options->itemAction : '';
		$html = "<div class=\"control-group {$customClass} {$identify} {$hideField} \" data-settings=\"" . htmlentities($dataSettings, ENT_QUOTES, "UTF-8") . "\"><label for=\"" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "\" class=\"control-label\">" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "{$required}{$instruction}</label><div class=\"controls\"><div id=\"{$data->id}\" class=\"checkboxes jsn-columns-container {$data->options->layout} {$randomCheckbox} {$requiredCheckbox}\">";
		$defaultValue = isset($dataSumbission[$data->id]) ? $dataSumbission[$data->id] : "";
		if (isset($data->options->items) && is_array($data->options->items))
		{
			foreach ($data->options->items as $i => $option)
			{
				$checked = "";
				if (!empty($defaultValue))
				{
					if (isset($option->text) && in_array($option->text, $defaultValue))
					{
						$checked = "checked='true'";
					}
				}
				else
				{
					if (isset($option->checked) && $option->checked == "true")
					{
						$checked = "checked='true'";
					}
				}

				$html .= "<div class=\"jsn-column-item\"><label class=\"checkbox\"><input {$checked} name=\"{$data->id}[]\" value=\"" . htmlentities($option->text, ENT_QUOTES, "UTF-8") . "\" type=\"checkbox\" />" . htmlentities(JText::_($option->text), ENT_QUOTES, "UTF-8") . "</label></div>";
			}
		}
		$textOthers = !empty($data->options->labelOthers) ? $data->options->labelOthers : "Others";
		if (!empty($data->options->allowOther))
		{
			$html .= "<div class=\"jsn-column-item jsn-uniform-others\"><label class=\"checkbox lbl-allowOther\"><input class=\"allowOther\" value=\"Others\" type=\"checkbox\" />" . htmlentities(JText::_($textOthers), ENT_QUOTES, "UTF-8") . "</label>";
			$html .= "<textarea disabled=\"true\" class='jsn-value-Others' name=\"{$data->id}[]\"  rows=\"3\"></textarea></div>";
		}
		$html .= "<div class=\"clearbreak\"></div></div></div></div>";

		return $html;
	}

	/**
	 * Generate html code for "Address" data field
	 *
	 * @param   object  $data            Data field
	 *
	 * @param   array   $dataSumbission  Data submission
	 *
	 * @return string
	 */
	public static function fieldAddress($data, $dataSumbission)
	{
		$valueStreet = '';
		$valueLine2 = '';
		$valueCity = '';
		$valueCode = '';
		$valueState = '';
		$valueCountry = '';
		if (!empty($dataSumbission))
		{
			$valueStreet = isset($dataSumbission['address'][$data->id]['street']) ? $dataSumbission['address'][$data->id]['street'] : "";
			$valueLine2 = isset($dataSumbission['address'][$data->id]['line2']) ? $dataSumbission['address'][$data->id]['line2'] : "";
			$valueCity = isset($dataSumbission['address'][$data->id]['city']) ? $dataSumbission['address'][$data->id]['city'] : "";
			$valueCode = isset($dataSumbission['address'][$data->id]['code']) ? $dataSumbission['address'][$data->id]['code'] : "";
			$valueState = isset($dataSumbission['address'][$data->id]['state']) ? $dataSumbission['address'][$data->id]['state'] : "";
			$valueCountry = isset($dataSumbission['address'][$data->id]['country']) ? $dataSumbission['address'][$data->id]['country'] : "";
		}

		$identify = !empty($data->identify) ? $data->identify : "";
		$hideField = !empty($data->options->hideField) ? 'hide' : '';
		$customClass = !empty($data->options->customClass) ? $data->options->customClass : "";
		$requiredBlank = !empty($data->options->required) ? 'group-blank-required' : '';
		$required = !empty($data->options->required) ? '<span class="required">*</span>' : '';
		$instruction = !empty($data->options->instruction) ? " <i original-title=\"" . htmlentities(JText::_($data->options->instruction), ENT_QUOTES, "UTF-8") . "\" class=\"icon-question-sign\"></i>" : '';
		$listField = !empty($data->options->sortableField) ? json_decode($data->options->sortableField) : array("vstreetAddress", "vstreetAddress2", "vcity", "vstate", "vcode", "vcountry");

		$html = "<div class=\"control-group {$customClass} jsn-group-field {$identify} {$hideField} \"><label for=\"" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "\" class=\"control-label\">" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "{$required}{$instruction}</label><div id=\"{$data->id}\" class=\"controls {$requiredBlank}\">";

		$position2 = array_search('vstreetAddress2', $listField);
		$position1 = array_search('vstreetAddress', $listField);
		if ($position1 > $position2)
		{
			$position2 = array_search('vstreetAddress', $listField);
			$position1 = array_search('vstreetAddress2', $listField);
		}
		$sortableField = array();
		$field = array();
		foreach ($listField as $i => $val)
		{
			if (isset($data->options->$val) && $data->options->$val == 1)
			{
				$sortableField[] = $val;
			}
			switch($val)
			{
				case "vstreetAddress":
					$field[$val] = "<input type=\"text\" value='" . htmlentities($valueStreet, ENT_QUOTES, "UTF-8") . "' name=\"address[{$data->id}][street]\" placeholder=\"" . htmlentities(JText::_("Street_Address"), ENT_QUOTES, "UTF-8") . "\" class=\"jsn-input-xxlarge-fluid\" />";
					break;
				case "vstreetAddress2":
					$field[$val] = "<input type=\"text\" value='" . htmlentities($valueLine2, ENT_QUOTES, "UTF-8") . "' name=\"address[{$data->id}][line2]\" placeholder=\"" . htmlentities(JText::_("Address_Line_2"), ENT_QUOTES, "UTF-8") . "\" class=\"jsn-input-xxlarge-fluid\" />";
					break;
				case "vcity":
					$field[$val] = "<input value='" . htmlentities($valueCity, ENT_QUOTES, "UTF-8") . "' type=\"text\" name=\"address[{$data->id}][city]\" class=\"jsn-input-xlarge-fluid\" placeholder=\"" . htmlentities(JText::_("City"), ENT_QUOTES, "UTF-8") . "\" />";
					break;
				case "vstate":
					$field[$val] = "<input value='" . htmlentities($valueState, ENT_QUOTES, "UTF-8") . "'  name=\"address[{$data->id}][state]\" type=\"text\" placeholder=\"" . htmlentities(JText::_("State_Province_Region"), ENT_QUOTES, "UTF-8") . "\" class=\"jsn-input-xlarge-fluid\" />";
					break;
				case "vcode":
					$field[$val] = "<input value='" . htmlentities($valueCode, ENT_QUOTES, "UTF-8") . "'  type=\"text\" name=\"address[{$data->id}][code]\" class=\"jsn-input-xlarge-fluid\" placeholder=\"" . htmlentities(JText::_("Postal_Zip_code"), ENT_QUOTES, "UTF-8") . "\" />";
					break;
				case "vcountry":
					$field[$val] = "<select class=\"jsn-input-xlarge-fluid\" name=\"address[{$data->id}][country]\">";
					if (isset($data->options->country) && is_array($data->options->country))
					{
						foreach ($data->options->country as $option)
						{
							if (!empty($valueCountry))
							{
								if (isset($option->text) && $option->text == $valueCountry)
								{
									$selected = "selected='true'";
								}
								else
								{
									$selected = "";
								}
							}
							else
							{
								if (isset($option->checked) && $option->checked == 1)
								{
									$selected = "selected='true'";
								}
								else
								{
									$selected = "";
								}
							}
							$field[$val] .= "<option {$selected} value=\"" . htmlentities($option->text, ENT_QUOTES, "UTF-8") . "\">" . htmlentities(JText::_($option->text), ENT_QUOTES, "UTF-8") . "</option>";
						}
					}
					$field[$val] .= "</select>";
					break;
			}
		}
		if ($position1 > 0)
		{
			$check = 0;
			for ($i = 0; $i < $position1; $i++)
			{
				if ($check % 2 == 0)
				{
					$html .= '<div class="row-fluid">';
				}
				$html .= "<div class='span6'>" . $field[$sortableField[$i]] . "</div>";
				if ($check % 2 != 0 || $i == $position1 - 1)
				{
					$html .= "</div>\n";
				}
				$check++;
			}
		}
		$html .= "<div class='row-fluid'><div class='span12'>" . $field[$sortableField[$position1]] . "</div></div>\n";
		$check = 0;
		for ($i = $position1 + 1; $i < $position2; $i++)
		{
			if ($check % 2 == 0)
			{
				$html .= '<div class="row-fluid">';
			}
			$html .= "<div class='span6'>" . $field[$sortableField[$i]] . "</div>";
			if ($check % 2 != 0 || $i == $position2 - 1)
			{
				$html .= "</div>\n";
			}
			$check++;
		}
		$html .= "<div class='row-fluid'><div class='span12'>" . $field[$sortableField[$position2]] . "</div></div>\n";
		$check = 0;
		if ($position2 < count($sortableField))
		{
			for ($i = $position2 + 1; $i < count($sortableField); $i++)
			{
				if ($check % 2 == 0)
				{
					$html .= '<div class="row-fluid">';
				}
				$html .= "<div class='span6'>" . $field[$sortableField[$i]] . "</div>";
				if ($check % 2 != 0 || $i == count($sortableField) - 1)
				{
					$html .= "</div>\n";
				}
				$check++;
			}
		}
		$html .= "</div></div>";
		return $html;
	}

	/**
	 * Generate html code for "Password" data field
	 *
	 * @param   object  $data            Data field
	 *
	 * @param   array   $dataSumbission  Data submission
	 *
	 * @return string
	 */
	public static function fieldPassword($data, $dataSumbission)
	{

		$limitValue = "";
		$styleClassLimit = "";
		$identify = !empty($data->identify) ? $data->identify : "";
		if (isset($data->options->limitation) && $data->options->limitation == 1 && $data->options->limitMax > 0)
		{
			$josnLimit = json_encode(array('limitMin' => $data->options->limitMin, 'limitMax' => $data->options->limitMax));
			if (isset($data->options->limitMax) && isset($data->options->limitMin) && $data->options->limitMax >= $data->options->limitMin && $data->options->limitMax > 0 && $data->options->limitMin >= 0)
			{
				$limitValue = "data-limit='{$josnLimit}'";
				$styleClassLimit = "limit-password-required";
			}
		}
		//$defaultValue = !empty($dataSumbission[$data->id])?$dataSumbission[$data->id]:'';
		$required = !empty($data->options->required) ? '<span class="required">*</span>' : '';
		$requiredBlank = !empty($data->options->required) ? 'group-blank-required' : '';
		$hideField = !empty($data->options->hideField) ? 'hide' : '';
		$customClass = !empty($data->options->customClass) ? $data->options->customClass : "";
		$instruction = !empty($data->options->instruction) ? " <i original-title=\"" . htmlentities(JText::_($data->options->instruction), ENT_QUOTES, "UTF-8") . "\" class=\"icon-question-sign\"></i>" : '';
		$sizeInput = !empty($data->options->size) ? $data->options->size : '';
		$placeholder = !empty($data->options->value) ? JText::_($data->options->value) : "";
		$placeholderConfirm = !empty($data->options->valueConfirmation) ? JText::_($data->options->valueConfirmation) : "";
		$confirmHtml = "";
		if (!empty($data->options->confirmation))
		{
			$confirmHtml = "<div><input {$limitValue} class=\"{$sizeInput}\" name=\"password[{$data->id}][]\" type=\"password\" value=\"\" placeholder=\"" . htmlentities($placeholderConfirm, ENT_QUOTES, "UTF-8") . "\" /></div>";
		}
		$html = "<div class=\"control-group {$customClass} jsn-group-field {$identify} {$hideField}\">
		<label for=\"" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "\" class=\"control-label\">" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "{$required}{$instruction}</label>
			<div class=\"controls {$requiredBlank} {$styleClassLimit}\" id=\"{$data->id}\" >
				<div><input {$limitValue} class=\"{$sizeInput}\" name=\"password[{$data->id}][]\" type=\"password\" value=\"\" placeholder=\"" . htmlentities($placeholder, ENT_QUOTES, "UTF-8") . "\" /></div>
				{$confirmHtml}
			</div>
		</div>";
		return $html;
	}


	/**
	 * Generate html code for "Static Content" data field
	 *
	 * @param   object  $data            Data field
	 *
	 * @param   array   $dataSumbission  Data submission
	 *
	 * @return string
	 */
	public static function fieldStaticContent($data, $dataSumbission)
	{

		$identify = !empty($data->identify) ? $data->identify : "";
		$hideField = !empty($data->options->hideField) ? 'hide' : '';
		$customClass = !empty($data->options->customClass) ? $data->options->customClass : "";
		$value = isset($data->options->value) ? JText::_($data->options->value) : "";
		$html = "<div class=\"control-group {$customClass} {$identify} {$hideField} \"><div class=\"controls clearfix\">{$value}</div></div>";
		return $html;
	}

	/**
	 * Generate html code for "Static Content" data field
	 *
	 * @param   object  $data            Data field
	 *
	 * @param   array   $dataSumbission  Data submission
	 *
	 * @return string
	 */
	public static function fieldGoogleMaps($data, $dataSumbission)
	{

		$identify = !empty($data->identify) ? $data->identify : "";
		$hideField = !empty($data->options->hideField) ? 'hide' : '';
		$customClass = !empty($data->options->customClass) ? $data->options->customClass : "";
		$height = isset($data->options->height) ? $data->options->height : "";
		$width = isset($data->options->width) ? $data->options->width : "";
		$formatWidth = isset($data->options->formatWidth) ? $data->options->formatWidth : "";
		$googleMaps = isset($data->options->googleMaps) ? $data->options->googleMaps : "";
		$googleMapsMarKer = isset($data->options->googleMapsMarKer) ? $data->options->googleMapsMarKer : "";
		$html = "<div class=\"control-group {$customClass} {$identify} {$hideField} \"><div class=\"content-google-maps clearfix\" data-width='{$width} {$formatWidth}' data-height='{$height}' data-value='{$googleMaps}' data-marker='" . htmlentities($googleMapsMarKer, ENT_QUOTES, "UTF-8") . "'><div class=\"google_maps map rounded\"></div></div></div>";
		return $html;
	}

	/**
	 * Generate html code for "Likert" data field
	 *
	 * @param   object  $data            Data field
	 *
	 * @param   array   $dataSumbission  Data submission
	 *
	 * @return string
	 */
	public static function fieldLikert($data, $dataSumbission)
	{

		$identify = !empty($data->identify) ? $data->identify : "";
		$hideField = !empty($data->options->hideField) ? 'hide' : '';
		$customClass = !empty($data->options->customClass) ? $data->options->customClass : "";
		$required = !empty($data->options->required) ? '<span class="required">*</span>' : '';
		$instruction = !empty($data->options->instruction) ? " <i original-title=\"" . htmlentities(JText::_($data->options->instruction), ENT_QUOTES, "UTF-8") . "\" class=\"icon-question-sign\"></i>" : '';
		$requiredLikert = !empty($data->options->required) ? 'likert-required' : '';
		$dataSettings = !empty($data->options->itemAction) ? $data->options->itemAction : '';
		$html = "<div class=\"control-group {$customClass} {$identify} {$hideField} \" data-settings=\"" . htmlentities($dataSettings, ENT_QUOTES, "UTF-8") . "\"><label for=\"" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "\" class=\"control-label\">" . htmlentities(JText::_($data->label), ENT_QUOTES, "UTF-8") . "{$required}{$instruction}</label><div class=\"controls\">";

		if (isset($data->options->rows) && is_array($data->options->rows) && isset($data->options->columns) && is_array($data->options->columns))
		{
			$tdRows = "<input type=\"hidden\" name='likert[{$data->id}][settings]' value='".htmlentities(json_encode(array('rows'=>$data->options->rows,'columns'=>$data->options->columns)), ENT_QUOTES, "UTF-8")."' />";
			$tdColumns = '';
			$html .= '';

			foreach ($data->options->rows as $row)
			{
				$tdRows .="<tr>";
				$tdRows .= '<td>'.$row->text.'</td>';
				foreach ($data->options->columns as $column)
				{
					$tdRows .= "<td class=\"text-center\"><input type=\"radio\" name='likert[{$data->id}][values][".htmlentities($row->text, ENT_QUOTES, "UTF-8")."]' value='".htmlentities($column->text, ENT_QUOTES, "UTF-8")."' /></td>";
				}
				$tdRows .="</tr>";
			}
			foreach ($data->options->columns as $column)
			{
				$tdColumns .= '<th class="text-center">'.$column->text.'</th>';
			}
			$html .= "<table class=\"table table-bordered table-striped {$requiredLikert}\">
				<thead>
					<tr>
						<th></th>
						{$tdColumns}
					</tr>
				</thead>
				<tbody>
					{$tdRows}
				</tbody>
			</table>";
		}

		$html .= "</div></div>";

		return $html;
	}
}