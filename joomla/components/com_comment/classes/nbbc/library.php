<?php
/**
 * @author     Daniel Dimitrov - compojoom.com
 * @date: 28.02.13
 *
 * I've copied the code for this class from the Kunena.Framework and I've removed
 * the things that we don't need. A big thank you goes to the Kunena Team!
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Kunena Component
 * @package    Kunena.Framework
 * @subpackage BBCode
 *
 * @copyright  (C) 2008 - 2012 Kunena Team. All rights reserved.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://www.kunena.org
 **/

defined('_JEXEC') or die('Restricted access');

require_once(JPATH_SITE . '/components/com_comment/classes/nbbc/nbbc.php');

class CCommentBbcodeLibrary extends BBCodeLibrary
{
	var $default_smileys = array();
	var $default_tag_rules = array(
		'b' => array(
			'simple_start' => "<b>",
			'simple_end' => "</b>",
			'class' => 'inline',
			'allow_in' => array('listitem', 'block', 'columns', 'inline', 'link'),
			'plain_start' => "<b>",
			'plain_end' => "</b>",
		),

		'i' => array(
			'simple_start' => "<i>",
			'simple_end' => "</i>",
			'class' => 'inline',
			'allow_in' => array('listitem', 'block', 'columns', 'inline', 'link'),
			'plain_start' => "<i>",
			'plain_end' => "</i>",
		),

		'u' => array(
			'simple_start' => "<u>",
			'simple_end' => "</u>",
			'class' => 'inline',
			'allow_in' => array('listitem', 'block', 'columns', 'inline', 'link'),
			'plain_start' => "<u>",
			'plain_end' => "</u>",
		),

		's' => array(
			'simple_start' => "<strike>",
			'simple_end' => "</strike>",
			'class' => 'inline',
			'allow_in' => array('listitem', 'block', 'columns', 'inline', 'link'),
			'plain_start' => "<i>",
			'plain_end' => "</i>",
		),

		'strike' => array(
			'simple_start' => "<strike>",
			'simple_end' => "</strike>",
			'class' => 'inline',
			'allow_in' => array('listitem', 'block', 'columns', 'inline', 'link'),
			'plain_start' => "<i>",
			'plain_end' => "</i>",
		),

		'tt' => array(
			'simple_start' => "<tt>",
			'simple_end' => "</tt>",
			'class' => 'inline',
			'allow_in' => array('listitem', 'block', 'columns', 'inline', 'link'),
			'plain_start' => "<i>",
			'plain_end' => "</i>",
		),

		'pre' => array(
			'simple_start' => "<pre>",
			'simple_end' => "</pre>",
			'class' => 'block',
			'allow_in' => array('listitem', 'block', 'columns'),
			'plain_start' => "<i>",
			'plain_end' => "</i>",
		),

		'font' => array(
			'mode' => BBCODE_MODE_LIBRARY,
			'allow' => array('_default' => '/^[a-zA-Z0-9._ -]+$/'),
			'method' => 'DoFont',
			'class' => 'inline',
			'allow_in' => array('listitem', 'block', 'columns', 'inline', 'link'),
		),

		'color' => array(
			'mode' => BBCODE_MODE_ENHANCED,
			'allow' => array('_default' => '/^#?[a-zA-Z0-9._ -]+$/'),
			'template' => '<span style="color:{$_default/tw}">{$_content/v}</span>',
			'class' => 'inline',
			'allow_in' => array('listitem', 'block', 'columns', 'inline', 'link'),
		),

		'size' => array(
			'mode' => BBCODE_MODE_LIBRARY,
			'method' => 'DoSize',
			'allow' => array('_default' => '/^[0-9.]+(px|em|pt|%)?$/D'),
			'class' => 'inline',
			'allow_in' => array('listitem', 'block', 'columns', 'inline', 'link'),
		),

		'sup' => array(
			'simple_start' => "<sup>",
			'simple_end' => "</sup>",
			'class' => 'inline',
			'allow_in' => array('listitem', 'block', 'columns', 'inline', 'link'),
		),

		'sub' => array(
			'simple_start' => "<sub>",
			'simple_end' => "</sub>",
			'class' => 'inline',
			'allow_in' => array('listitem', 'block', 'columns', 'inline', 'link')
		),

		'confidential' => array(
			'mode' => BBCODE_MODE_LIBRARY,
			'method' => 'DoConfidential',
			'class' => 'block',
			'allow_in' => array('listitem', 'block', 'columns'),
			'content' => BBCODE_REQUIRED,
			'plain_content' => array(),
		),

		'video' => array(
			'mode' => BBCODE_MODE_LIBRARY,
			'method' => 'DoVideo',
			'allow' => array('type' => '/^[\w\d.-_]*$/', 'param' => '/^[\w]*$/', 'size' => '/^\d*$/', 'width' => '/^\d*$/', 'height' => '/^\d*$/'),
			'class' => 'block',
			'allow_in' => array('listitem', 'block', 'columns'),
			'content' => BBCODE_VERBATIM,
			'plain_start' => "[video]",
			'plain_end' => "",
			'plain_content' => array(),
		),

		'img' => array(
			'mode' => BBCODE_MODE_LIBRARY,
			'method' => 'DoImage',
			'allow' => array('size' => '/^\d*$/'),
			'class' => 'block',
			'allow_in' => array('listitem', 'block', 'columns', 'link'),
			'content' => BBCODE_VERBATIM,
			'plain_start' => "[image]",
			'plain_end' => "",
			'plain_content' => array(),
		),


		'highlight' => array(
			'simple_start' => "<span style='font-weight: 700;'>",
			'simple_end' => "</span>",
			'class' => 'inline',
			'allow_in' => array('listitem', 'block', 'columns', 'inline', 'link'),
			'plain_start' => "<i>",
			'plain_end' => "</i>",
		),

		'acronym' => array(
			'mode' => BBCODE_MODE_ENHANCED,
			'template' => '<span class="bbcode_acronym" title="{$_default/e}">{$_content/v}</span>',
			'class' => 'inline',
			'allow_in' => array('listitem', 'block', 'columns', 'inline', 'link'),
		),

		'url' => array(
			'mode' => BBCODE_MODE_LIBRARY,
			'method' => 'DoUrl',
			'class' => 'link',
			'allow_in' => array('listitem', 'block', 'columns', 'inline'),
			'content' => BBCODE_REQUIRED,
			'plain_start' => "<a href=\"{\$link}\" rel=\"nofollow\" target=\"_blank\">",
			'plain_end' => "</a>",
			'plain_content' => array('_content', '_default'),
			'plain_link' => array('_default', '_content'),
		),

		'email' => array(
			'mode' => BBCODE_MODE_LIBRARY,
			'method' => 'DoEmail',
			'class' => 'link',
			'allow_in' => array('listitem', 'block', 'columns', 'inline'),
			'content' => BBCODE_VERBATIM,
			'plain_start' => "<a href=\"mailto:{\$link}\">",
			'plain_end' => "</a>",
			'plain_content' => array('_content', '_default'),
			'plain_link' => array('_default', '_content'),
		),

		'wiki' => array(
			'mode' => BBCODE_MODE_LIBRARY,
			'method' => "DoWiki",
			'class' => 'link',
			'allow_in' => array('listitem', 'block', 'columns', 'inline'),
			'end_tag' => BBCODE_PROHIBIT,
			'content' => BBCODE_PROHIBIT,
			'plain_start' => "<b>[",
			'plain_end' => "]</b>",
			'plain_content' => array('title', '_default'),
			'plain_link' => array('_default', '_content'),
		),

		'rule' => array(
			'mode' => BBCODE_MODE_LIBRARY,
			'method' => "DoRule",
			'class' => 'block',
			'allow_in' => array('listitem', 'block', 'columns'),
			'end_tag' => BBCODE_PROHIBIT,
			'content' => BBCODE_PROHIBIT,
			'before_tag' => "sns",
			'after_tag' => "sns",
			'plain_start' => "\n-----\n",
			'plain_end' => "",
			'plain_content' => array(),
		),

		'br' => array(
			'mode' => BBCODE_MODE_SIMPLE,
			'simple_start' => "<br />\n",
			'simple_end' => "",
			'class' => 'inline',
			'allow_in' => array('listitem', 'block', 'columns', 'inline', 'link'),
			'end_tag' => BBCODE_PROHIBIT,
			'content' => BBCODE_PROHIBIT,
			'before_tag' => "s",
			'after_tag' => "s",
			'plain_start' => "\n",
			'plain_end' => "",
			'plain_content' => array(),
		),

		'hr' => array(
			'mode' => BBCODE_MODE_SIMPLE,
			'simple_start' => "<hr />\n",
			'simple_end' => "",
			'class' => 'inline',
			'allow_in' => array('listitem', 'block', 'columns', 'inline', 'link'),
			'end_tag' => BBCODE_PROHIBIT,
			'content' => BBCODE_PROHIBIT,
			'before_tag' => "s",
			'after_tag' => "s",
			'plain_start' => "\n-----\n",
			'plain_end' => "",
			'plain_content' => array(),
		),

		'left' => array(
			'simple_start' => "\n<div class=\"bbcode_left\" style=\"text-align:left\">\n",
			'simple_end' => "\n</div>\n",
			'allow_in' => array('listitem', 'block', 'columns'),
			'before_tag' => "sns",
			'after_tag' => "sns",
			'before_endtag' => "sns",
			'after_endtag' => "sns",
			'plain_start' => "\n",
			'plain_end' => "\n",
		),

		'right' => array(
			'simple_start' => "\n<div class=\"bbcode_right\" style=\"text-align:right\">\n",
			'simple_end' => "\n</div>\n",
			'allow_in' => array('listitem', 'block', 'columns'),
			'before_tag' => "sns",
			'after_tag' => "sns",
			'before_endtag' => "sns",
			'after_endtag' => "sns",
			'plain_start' => "\n",
			'plain_end' => "\n",
		),

		'center' => array(
			'simple_start' => "\n<div class=\"ccomment-bbcode-center\" style=\"text-align:center\">\n",
			'simple_end' => "\n</div>\n",
			'allow_in' => array('listitem', 'block', 'columns'),
			'before_tag' => "sns",
			'after_tag' => "sns",
			'before_endtag' => "sns",
			'after_endtag' => "sns",
			'plain_start' => "\n",
			'plain_end' => "\n",
		),

		'indent' => array(
			'simple_start' => "\n<div class=\"ccomment-bbcode-indent\" style=\"margin-left:4em\">\n",
			'simple_end' => "\n</div>\n",
			'allow_in' => array('listitem', 'block', 'columns'),
			'before_tag' => "sns",
			'after_tag' => "sns",
			'before_endtag' => "sns",
			'after_endtag' => "sns",
			'plain_start' => "\n",
			'plain_end' => "\n",
		),

		'table' => array(
			'simple_start' => "\n<table>",
			'simple_end' => "</table>\n",
			'class' => 'table',
			'allow_in' => array('listitem', 'block', 'columns'),
			'end_tag' => BBCODE_REQUIRED,
			'content' => BBCODE_REQUIRED,
			'before_tag' => "sns",
			'after_tag' => "sns",
			'before_endtag' => "sns",
			'after_endtag' => "sns",
			'plain_start' => "\n",
			'plain_end' => "\n",
		),

		'tr' => array(
			'simple_start' => "\n<tr>",
			'simple_end' => "</tr>\n",
			'class' => 'tr',
			'allow_in' => array('table'),
			'end_tag' => BBCODE_REQUIRED,
			'content' => BBCODE_REQUIRED,
			'before_tag' => "sns",
			'after_tag' => "sns",
			'before_endtag' => "sns",
			'after_endtag' => "sns",
			'plain_start' => "\n",
			'plain_end' => "\n",
		),

		'th' => array(
			'simple_start' => "<th>",
			'simple_end' => "</th>",
			'class' => 'columns',
			'allow_in' => array('tr'),
			'before_tag' => "sns",
			'after_tag' => "sns",
			'before_endtag' => "sns",
			'after_endtag' => "sns",
			'plain_start' => "\n",
			'plain_end' => "\n",
		),

		'td' => array(
			'simple_start' => "<td>",
			'simple_end' => "</td>",
			'class' => 'columns',
			'allow_in' => array('tr'),
			'before_tag' => "sns",
			'after_tag' => "sns",
			'before_endtag' => "sns",
			'after_endtag' => "sns",
			'plain_start' => "\n",
			'plain_end' => "\n",
		),

		'columns' => array(
			'simple_start' => "\n<table class=\"ccomment-bbcode-columns\"><tbody><tr><td class=\"ccomment-bbcode-column ccomment-bbcode-firstcolumn\">\n",
			'simple_end' => "\n</td></tr></tbody></table>\n",
			'class' => 'columns',
			'allow_in' => array('listitem', 'block', 'columns'),
			'end_tag' => BBCODE_REQUIRED,
			'content' => BBCODE_REQUIRED,
			'before_tag' => "sns",
			'after_tag' => "sns",
			'before_endtag' => "sns",
			'after_endtag' => "sns",
			'plain_start' => "\n",
			'plain_end' => "\n",
		),

		'nextcol' => array(
			'simple_start' => "\n</td><td class=\"ccomment-bbcode-column\">\n",
			'class' => 'nextcol',
			'allow_in' => array('columns'),
			'end_tag' => BBCODE_PROHIBIT,
			'content' => BBCODE_PROHIBIT,
			'before_tag' => "sns",
			'after_tag' => "sns",
			'before_endtag' => "sns",
			'after_endtag' => "sns",
			'plain_start' => "\n",
			'plain_end' => "",
		),

		'code' => array(
			'mode' => BBCODE_MODE_LIBRARY,
			'method' => 'DoCode',
			'allow' => array('type' => '/^[\w]*$/',),
			'class' => 'code',
			'allow_in' => array('listitem', 'block', 'columns'),
			'content' => BBCODE_VERBATIM,
			'before_tag' => "sns",
			'after_tag' => "sn",
			'before_endtag' => "sn",
			'after_endtag' => "sns",
			'plain_start' => "\n",
			'plain_end' => "\n",
		),

		'quote' => array(
			'mode' => BBCODE_MODE_LIBRARY,
			'method' => 'DoQuote',
			'allow_in' => array('listitem', 'block', 'columns'),
			'before_tag' => "sns",
			'after_tag' => "sns",
			'before_endtag' => "sns",
			'after_endtag' => "sns",
			'plain_start' => "\nQuote:\n",
			'plain_end' => "\n",
		),

		'list' => array(
			'mode' => BBCODE_MODE_LIBRARY,
			'method' => 'DoList',
			'class' => 'list',
			'allow_in' => array('listitem', 'block', 'columns'),
			'before_tag' => "sns",
			'after_tag' => "sns",
			'before_endtag' => "sns",
			'after_endtag' => "sns",
			'plain_start' => "\n",
			'plain_end' => "\n",
		),

		'ul' => array(
			'mode' => BBCODE_MODE_LIBRARY,
			'method' => 'DoList',
			'default' => array('_default' => 'circle'),
			'class' => 'list',
			'allow_in' => array('listitem', 'block', 'columns'),
			'before_tag' => "sns",
			'after_tag' => "sns",
			'before_endtag' => "sns",
			'after_endtag' => "sns",
			'plain_start' => "\n",
			'plain_end' => "\n",
		),

		'ol' => array(
			'mode' => BBCODE_MODE_LIBRARY,
			'method' => 'DoList',
			'allow' => array('_default' => '/^[\d\w]*$/',),
			'default' => array('_default' => '1'),
			'class' => 'list',
			'allow_in' => array('listitem', 'block', 'columns'),
			'before_tag' => "sns",
			'after_tag' => "sns",
			'before_endtag' => "sns",
			'after_endtag' => "sns",
			'plain_start' => "\n",
			'plain_end' => "\n",
		),

		'*' => array(
			'simple_start' => "<li>",
			'simple_end' => "</li>\n",
			'class' => 'listitem',
			'allow_in' => array('list'),
			'end_tag' => BBCODE_OPTIONAL,
			'before_tag' => "s",
			'after_tag' => "s",
			'before_endtag' => "sns",
			'after_endtag' => "sns",
			'plain_start' => "\n * ",
			'plain_end' => "\n",
		),

		'li' => array(
			'simple_start' => "<li>",
			'simple_end' => "</li>\n",
			'class' => 'listitem',
			'allow_in' => array('listitem', 'block', 'columns', 'list'),
			'before_tag' => "s",
			'after_tag' => "s",
			'before_endtag' => "sns",
			'after_endtag' => "sns",
			'plain_start' => "\n * ",
			'plain_end' => "\n",
		),

		'terminal' => array(
			'mode' => BBCODE_MODE_LIBRARY,
			'method' => 'DoTerminal',
			'allow_in' => array('listitem', 'block', 'columns'),
			'class' => 'block',
			'allow' => array('colortext' => '/^[\w\d.-_]*$/'),
			'content' => BBCODE_PROHIBIT,
			'plain_start' => "\nTerminal:\n",
			'plain_end' => "\n",
		),
	);

	/**
	 * @param JRegistry $config
	 */
	public function __construct($config)
	{
		if ($config->get('layout.support_emoticons'))
		{
			$emoticons = ccommentHelperUtils::getEmoticons($config);
			foreach ($emoticons as $key => $emoticon)
			{
				$this->default_smileys [$key] = $emoticon;
			}
		}
	}

	function DoEmail($bbcode, $action, $name, $default, $params, $content)
	{
		if ($action == BBCODE_CHECK)
		{
			return true;
		}
		$email = is_string($default) ? $default : $content;
		$text = is_string($default) ? $content : $default;
		return JHtml::_('email.cloak', htmlspecialchars($email), $bbcode->IsValidEmail($email), $text, $bbcode->IsValidEmail($text));
	}

	// Format a [url] tag by producing an <a>...</a> element.
	// The URL only allows http, https, mailto, and ftp protocols for safety.
	function DoURL($bbcode, $action, $name, $default, $params, $content)
	{
		// We can't check this with BBCODE_CHECK because we may have no URL before the content
		// has been processed.
		if ($action == BBCODE_CHECK)
		{
			$bbcode->autolink_disable++;
			return true;
		}

		$bbcode->autolink_disable--;
		$url = is_string($default) ? $default : $bbcode->UnHTMLEncode(strip_tags($content));
		// FIXME: add support for local (relative) URIs
		if ($bbcode->IsValidURL($url))
		{
			if ($bbcode->debug)
				echo "ISVALIDURL<br />";
			if ($bbcode->url_targetable !== false && isset ($params ['target']))
				$target = " target=\"" . htmlspecialchars($params ['target']) . "\"";
			elseif ($bbcode->url_target !== false)
				$target = " target=\"" . htmlspecialchars($bbcode->url_target) . "\"";
			return '<a href="' . htmlspecialchars($url) . '" class="ccomment-bbcode-url" rel="nofollow"' . $target . '>' . $content . '</a>';
		}
		return htmlspecialchars($params ['_tag']) . $content . htmlspecialchars($params ['_endtag']);
	}

	// Format a [size] tag by producing a <span> with a style with a different font-size.
	function DoSize($bbcode, $action, $name, $default, $params, $content)
	{
		if ($action == BBCODE_CHECK)
			return true;

		$size_css = array(1 => 'ccomment-xs', 'ccomment-s', 'ccomment-m', 'ccomment-l', 'ccomment-xl', 'ccomment-xxl');
		if (isset ($size_css [$default]))
		{
			$size = "class=\"{$size_css [$default]}\"";
		}
		elseif (!empty($default))
		{
			$size = "style=\"font-size:{$default}\"";
		}
		else
		{
			$size = "class=\"{$size_css [3]}\"";
		}
		return "<span {$size}>{$content}</span>";
	}

	// Format a [list] tag, which is complicated by the number of different
	// ways a list can be started.  The following parameters are allowed:
	//
	//   [list]           Unordered list, using default marker
	//   [list=circle]    Unordered list, using circle marker
	//   [list=disc]      Unordered list, using disc marker
	//   [list=square]    Unordered list, using square marker
	//
	//   [list=1]         Ordered list, numeric, starting at 1
	//   [list=A]         Ordered list, capital letters, starting at A
	//   [list=a]         Ordered list, lowercase letters, starting at a
	//   [list=I]         Ordered list, capital Roman numerals, starting at I
	//   [list=i]         Ordered list, lowercase Roman numerals, starting at i
	//   [list=greek]     Ordered list, lowercase Greek letters, starting at alpha
	//   [list=01]        Ordered list, two-digit numeric with 0-padding, starting at 01
	function DoList($bbcode, $action, $name, $default, $params, $content)
	{
		// Allowed list styles, striaght from the CSS 2.1 spec.  The only prohibited
		// list style is that with image-based markers, which often slows down web sites.
		$list_styles = Array('1' => 'decimal', '01' => 'decimal-leading-zero', 'i' => 'lower-roman', 'I' => 'upper-roman', 'a' => 'lower-alpha', 'A' => 'upper-alpha');
		$ci_list_styles = Array('circle' => 'circle', 'disc' => 'disc', 'square' => 'square', 'greek' => 'lower-greek', 'armenian' => 'armenian', 'georgian' => 'georgian');
		$ul_types = Array('circle' => 'circle', 'disc' => 'disc', 'square' => 'square');
		$default = trim($default);
		if (!$default)
			$default = $bbcode->tag_rules [$name] ['default'] ['_default'];

		if ($action == BBCODE_CHECK)
		{
			if (!is_string($default) || strlen($default) == "")
				return true;
			else if (isset ($list_styles [$default]))
				return true;
			else if (isset ($ci_list_styles [strtolower($default)]))
				return true;
			else
				return false;
		}

		// Choose a list element (<ul> or <ol>) and a style.
		if (!is_string($default) || strlen($default) == "")
		{
			$elem = 'ul';
			$type = '';
		}
		else if ($default == '1')
		{
			$elem = 'ol';
			$type = '';
		}
		else if (isset ($list_styles [$default]))
		{
			$elem = 'ol';
			$type = $list_styles [$default];
		}
		else
		{
			$default = strtolower($default);
			if (isset ($ul_types [$default]))
			{
				$elem = 'ul';
				$type = $ul_types [$default];
			}
			else if (isset ($ci_list_styles [$default]))
			{
				$elem = 'ol';
				$type = $ci_list_styles [$default];
			}
		}

		// Generate the HTML for it.
		if (strlen($type))
			return "\n<$elem class=\"ccomment-bbcode-list\" style=\"list-style-type:$type\">\n$content</$elem>\n";
		else
			return "\n<$elem class=\"ccomment-bbcode-list\">\n$content</$elem>\n";
	}

	function DoQuote($bbcode, $action, $name, $default, $params, $content)
	{
		if ($action == BBCODE_CHECK)
			return true;

		$post = isset($params["post"]) ? $params["post"] : false;
		$user = isset($default) ? $default : false;
		$html = '<div class="ccomment-quote-text">';
		if ($user) {
			$html .= '<div class="ccomment-quote-text-author">' . $user . " " . JText::_('COM_COMMENT_USER_WROTE') . ":</div>";
		}
		$html .= '<div class="ccomment-quote-text-body">' . $content . '</div>';
		$html .= '</div>';
		return $html;
	}

	function DoCode($bbcode, $action, $name, $default, $params, $content)
	{
		static $enabled = false;

		if ($action == BBCODE_CHECK)
		{
			$bbcode->autolink_disable++;
			return true;
		}
		$bbcode->autolink_disable--;

		$type = isset ($params ["type"]) ? $params ["type"] : "php";
		if ($type == 'js')
		{
			$type = 'javascript';
		}
		elseif ($type == 'html')
		{
			$type = 'html4strict';
		}
		if ($enabled === false)
		{
			$enabled = true;
			// Joomla 1.6+
			$path = JPATH_ROOT . '/plugins/content/geshi/geshi/geshi.php';
			if (file_exists($path))
			{
				require_once $path;
			}
		}
		if ($enabled && class_exists('GeSHi'))
		{
			$geshi = new GeSHi ($bbcode->UnHTMLEncode($content), $type);
			$geshi->enable_keyword_links(false);
			$code = $geshi->parse_code();
		}
		else
		{
			$type = preg_replace('/[^A-Z0-9_\.-]/i', '', $type);
			$code = '<pre xml:' . $type . '>' . $content . '</pre>';
		}
		return '<div class="highlight">' . $code . '</div>';
	}


	function DoVideo($bbcode, $action, $name, $default, $params, $content)
	{
		if ($action == BBCODE_CHECK)
		{
			$bbcode->autolink_disable++;
			return true;
		}

		$bbcode->autolink_disable--;
		if (!$content)
			return;

		$vid_minwidth = 200;
		$vid_minheight = 44; // min. display size
		$vid_maxwidth = 450; // Max 90% of text width
		$vid_maxheight = 720; // max. display size
		$vid_sizemax = 100; // max. display zoom in percent

		$vid ["type"] = (isset ($params ["type"])) ? JString::strtolower($params ["type"]) : '';
		$vid ["param"] = (isset ($params ["param"])) ? $params ["param"] : '';

		if (!$vid ["type"])
		{
			$vid_players = array('divx' => 'divx', 'flash' => 'swf', 'mediaplayer' => 'avi,mp3,wma,wmv', 'quicktime' => 'mov,qt,qti,qtif,qtvr', 'realplayer', 'rm');
			foreach ($vid_players as $vid_player => $vid_exts)
				foreach (explode(',', $vid_exts) as $vid_ext)
					if (preg_match('/^(.*\.' . $vid_ext . ')$/i', $content) > 0)
					{
						$vid ["type"] = $vid_player;
						break 2;
					}
			unset ($vid_players);
		}
		if (!$vid ["type"])
		{
			$vid_auto = preg_match('#^http://.*?([^.]*)\.[^.]*(/|$)#u', $content, $vid_regs);
			if ($vid_auto)
			{
				$vid ["type"] = JString::strtolower($vid_regs [1]);
				switch ($vid ["type"])
				{
					case 'wideo' :
						$vid ["type"] = 'wideo.fr';
						break;
				}
			}
		}

		$vid_providers = array(

			'bofunk' => array('flash', 446, 370, 0, 0, 'http://www.bofunk.com/e/%vcode%', '', ''),

			'break' => array('flash', 464, 392, 0, 0, 'http://embed.break.com/%vcode%', '', ''),

			'clipfish' => array('flash', 464, 380, 0, 0, 'http://www.clipfish.de/videoplayer.swf?as=0&videoid=%vcode%&r=1&c=0067B3', 'videoid=([\w\-]*)', ''),

			'metacafe' => array('flash', 400, 345, 0, 0, 'http://www.metacafe.com/fplayer/%vcode%/.swf', '\/watch\/(\d*\/[\w\-]*)', array(array(6, 'wmode', 'transparent'))),

			'myspace' => array('flash', 430, 346, 0, 0, 'http://lads.myspace.com/videos/vplayer.swf', 'VideoID=(\d*)', array(array(6, 'flashvars', 'm=%vcode%&v=2&type=video'))),

			'rutube' => array('flash', 400, 353, 0, 0, 'http://video.rutube.ru/%vcode%', '\.html\?v=([\w]*)'),

			'sapo' => array('flash', 400, 322, 0, 0, 'http://rd3.videos.sapo.pt/play?file=http://rd3.videos.sapo.pt/%vcode%/mov/1', 'videos\.sapo\.pt\/([\w]*)', array(array(6, 'wmode', 'transparent'))),

			'streetfire' => array('flash', 428, 352, 0, 0, 'http://videos.streetfire.net/vidiac.swf', '\/([\w-]*).htm', array(array(6, 'flashvars', 'video=%vcode%'))),

			'veoh' => array('flash', 540, 438, 0, 0, 'http://www.veoh.com/videodetails2.swf?player=videodetailsembedded&type=v&permalinkId=%vcode%', '\/videos\/([\w-]*)', ''),

			'videojug' => array('flash', 400, 345, 0, 0, 'http://www.videojug.com/film/player?id=%vcode%', '', ''),

			'vimeo' => array('flash', 400, 321, 0, 0, 'http://www.vimeo.com/moogaloop.swf?clip_id=%vcode%&server=www.vimeo.com&fullscreen=1&show_title=1&show_byline=1&show_portrait=0&color=', '\.com\/(\d*)', ''),

			'wideo.fr' => array('flash', 400, 368, 0, 0, 'http://www.wideo.fr/p/fr/%vcode%.html', '\/([\w-]*).html', array(array(6, 'wmode', 'transparent'))),

			'youtube' => array('flash', 425, 355, 0, 0, 'http://www.youtube.com/v/%vcode%?fs=1&hd=0&rel=1&cc_load_policy=1', '\/watch\?v=([\w\-]*)', array(array(6, 'wmode', 'transparent'))),

			// Cannot allow public flash objects as it opens up a whole set of vulnerabilities through hacked flash files
			//				'_default' => array ($vid ["type"], 480, 360, 0, 25, $content, '', '' )
			//
		);

		if (isset ($vid_providers [$vid ["type"]]))
		{
			list ($vid_type, $vid_width, $vid_height, $vid_addx, $vid_addy, $vid_source, $vid_match, $vid_par2) = (isset ($vid_providers [$vid ["type"]])) ? $vid_providers [$vid ["type"]] : $vid_providers ["_default"];
		}
		else
		{
			return;
		}

		unset ($vid_providers);
		if (!empty ($vid_auto))
		{
			if ($vid_match and (preg_match("/$vid_match/i", $content, $vid_regs) > 0))
				$content = $vid_regs [1];
			else
				return;
		}
		$vid_source = preg_replace('/%vcode%/', $content, $vid_source);
		if (!is_array($vid_par2))
			$vid_par2 = array();

		$vid_size = isset ($params ["size"]) ? intval($params ["size"]) : 0;
		if (($vid_size > 0) and ($vid_size < $vid_sizemax))
		{
			$vid_width = ( int ) ($vid_width * $vid_size / 100);
			$vid_height = ( int ) ($vid_height * $vid_size / 100);
		}
		$vid_width += $vid_addx;
		$vid_height += $vid_addy;
		if (!isset ($params ["size"]))
		{
			if (isset ($params ["width"]))
				if ($params ['width'] == '1')
				{
					$params ['width'] = $vid_minwidth;
				}
			if (isset ($params ["width"]))
			{
				$vid_width = intval($params ["width"]);
			}
			if (isset ($params ["height"]))
				if ($params ['height'] == '1')
				{
					$params ['height'] = $vid_minheight;
				}
			if (isset ($params ["height"]))
			{
				$vid_height = intval($params ["height"]);
			}
		}

		if ($vid_width < $vid_minwidth)
			$vid_width = $vid_minwidth;
		if ($vid_width > $vid_maxwidth)
			$vid_width = $vid_maxwidth;
		if ($vid_height < $vid_minheight)
			$vid_height = $vid_minheight;
		if ($vid_height > $vid_maxheight)
			$vid_height = $vid_maxheight;

		switch ($vid_type)
		{
			case 'divx' :
				$vid_par1 = array(array(1, 'classid', 'clsid:67DABFBF-D0AB-41fa-9C46-CC0F21721616'), array(1, 'codebase', 'http://go.divx.com/plugin/DivXBrowserPlugin.cab'), array(4, 'type', 'video/divx'), array(4, 'pluginspage', 'http://go.divx.com/plugin/download/'), array(6, 'src', $vid_source), array(6, 'autoplay', 'false'), array(5, 'width', $vid_width), array(5, 'height', $vid_height));
				$vid_allowpar = array('previewimage');
				break;
			case 'flash' :
				$vid_par1 = array(array(1, 'classid', 'clsid:d27cdb6e-ae6d-11cf-96b8-444553540000'), array(1, 'codebase', 'http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab'), array(2, 'movie', $vid_source), array(4, 'src', $vid_source), array(4, 'type', 'application/x-shockwave-flash'), array(4, 'pluginspage', 'http://www.macromedia.com/go/getflashplayer'), array(6, 'quality', 'high'), array(6, 'allowFullScreen', 'true'), array(6, 'allowScriptAccess', 'never'), array(5, 'width', $vid_width), array(5, 'height', $vid_height));
				$vid_allowpar = array('flashvars', 'wmode', 'bgcolor', 'quality');
				break;
			case 'mediaplayer' :
				$vid_par1 = array(array(1, 'classid', 'clsid:22d6f312-b0f6-11d0-94ab-0080c74c7e95'), array(1, 'codebase', 'http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab'), array(4, 'type', 'application/x-mplayer2'), array(4, 'pluginspage', 'http://www.microsoft.com/Windows/MediaPlayer/'), array(6, 'src', $vid_source), array(6, 'autostart', 'false'), array(6, 'autosize', 'true'), array(5, 'width', $vid_width), array(5, 'height', $vid_height));
				$vid_allowpar = array();
				break;
			case 'quicktime' :
				$vid_par1 = array(array(1, 'classid', 'clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B'), array(1, 'codebase', 'http://www.apple.com/qtactivex/qtplugin.cab'), array(4, 'type', 'video/quicktime'), array(4, 'pluginspage', 'http://www.apple.com/quicktime/download/'), array(6, 'src', $vid_source), array(6, 'autoplay', 'false'), array(6, 'scale', 'aspect'), array(5, 'width', $vid_width), array(5, 'height', $vid_height));
				$vid_allowpar = array();
				break;
			case 'realplayer' :
				$vid_par1 = array(array(1, 'classid', 'clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA'), array(4, 'type', 'audio/x-pn-realaudio-plugin'), array(6, 'src', $vid_source), array(6, 'autostart', 'false'), array(6, 'controls', 'ImageWindow,ControlPanel'), array(5, 'width', $vid_width), array(5, 'height', $vid_height));
				$vid_allowpar = array();
				break;
			default :
				return;
		}

		$vid_par3 = array();
		foreach ($params as $vid_key => $vid_value)
		{
			if (in_array(JString::strtolower($vid_key), $vid_allowpar))
				array_push($vid_par3, array(6, $vid_key, $bbcode->HTMLEncode($vid_value)));
		}

		$vid_object = $vid_param = $vid_embed = array();
		foreach (array_merge($vid_par1, $vid_par2, $vid_par3) as $vid_data)
		{
			list ($vid_key, $vid_name, $vid_value) = $vid_data;
			if ($vid_key & 1)
				$vid_object [$vid_name] = ' ' . $vid_name . '="' . preg_replace('/%vcode%/', $content, $vid_value) . '"';
			if ($vid_key & 2)
				$vid_param [$vid_name] = '<param name="' . $vid_name . '" value="' . preg_replace('/%vcode%/', $content, $vid_value) . '" />';
			if ($vid_key & 4)
				$vid_embed [$vid_name] = ' ' . $vid_name . '="' . preg_replace('/%vcode%/', $content, $vid_value) . '"';
		}

		$tag_new = '<object';
		foreach ($vid_object as $vid_data)
			$tag_new .= $vid_data;
		$tag_new .= '>';
		foreach ($vid_param as $vid_data)
			$tag_new .= $vid_data;
		$tag_new .= '<embed';
		foreach ($vid_embed as $vid_data)
			$tag_new .= $vid_data;
		$tag_new .= ' /></object>';

		return $tag_new;
	}

	function DoImage($bbcode, $action, $name, $default, $params, $content)
	{
		if ($action == BBCODE_CHECK)
		{
			return true;
		}

		$fileurl = trim(strip_tags($content));


		if (!preg_match("/\\.(?:gif|jpeg|jpg|jpe|png)$/ui", $fileurl))
		{
			// If the image has not legal extension, return it as link or text
			$fileurl = $bbcode->HTMLEncode($fileurl);
			return "<a href=\"" . $fileurl . "\" rel=\"nofollow\" target=\"_blank\">" . $fileurl . '</a>';
		}

		// Make sure we add image size if specified
		$width = ($params ['size'] ? ' width="' . $params ['size'] . '"' : '');
		$fileurl = $bbcode->HTMLEncode($fileurl);

		return '<div class="ccomment-bbcode-image"><img src="' . $fileurl . ($width ? '" width="' . $width : '') . '" style="max-height:' . $config->imageheight . 'px; " alt="" /></div>';
	}

	function DoTerminal($bbcode, $action, $name, $default, $params, $content)
	{
		if ($action == BBCODE_CHECK)
			return true;

		if (!isset($params ["colortext"])) $colortext = '#ffffff';
		else $colortext = $params ["colortext"];

		return "<div class=\"highlight\"><pre style=\"font-family:monospace;background-color:#444444;\"><span style=\"color:{$colortext};\">{$content}</span></pre></div>";
	}
}