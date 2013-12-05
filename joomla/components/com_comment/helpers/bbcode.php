<?php
/**
 * @author     Daniel Dimitrov <daniel@compojoom.com>
 * @date       27.02.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

require_once JPATH_SITE . '/components/com_comment/classes/nbbc/nbbc.php';
require_once JPATH_SITE . '/components/com_comment/classes/nbbc/library.php';

/**
 * Class CcommentHelperBBcode
 *
 * @since  5.0
 */
class CcommentHelperBBcode extends BBCode
{
	public $autolink_disable = false;

	/**
	 * the constructor
	 *
	 * @param   object  $config  - config object
	 */
	public function __construct($config)
	{
		parent::__construct();

		$this->defaults = new CCommentBbcodeLibrary($config);
		$this->tag_rules = $this->defaults->default_tag_rules;

		$this->smileys = $this->defaults->default_smileys;

		if (empty($this->smileys))
		{
			$this->SetEnableSmileys(false);
		}

		$this->SetSmileyDir(JPATH_ROOT);
		$this->SetDetectURLs(true);
		$this->SetURLPattern(array($this, 'parseUrl'));
		$this->SetURLTarget('_blank');

		$dispatcher = JDispatcher::getInstance();
		JPluginHelper::importPlugin('ccomment');
		$dispatcher->trigger('onCCommentBbcodeConstruct', array($this));
	}

	/**
	 * Parses a url
	 *
	 * @param   object  $params  - param object
	 *
	 * @return string
	 */
	public function parseUrl($params)
	{
		$url = $params['url'];
		$text = $params['text'];

		if (preg_match('#^mailto:#u', $url))
		{
			return '<a href="' . $url . '">' . $text . '</a>';
		}

		if (preg_match('#^https?://#u', $text))
		{
			// Remove http(s):// from the text
			$text = preg_replace('#^http(s?)://#u', '', $text);
		}
		elseif (isset($params['host']) && substr($params['host'], -3) == '.gz')
		{
			return $text;
		}

		// Remove natural language punctuation from the url
		$url = preg_replace('#[\.,!?\)]+$#u', '', $url);
		$url = preg_match('#^https?://#u', $url) ? $url : 'http://' . $url;

		// Shorten URL text if they are too long
		$text = preg_replace('#^(.{40})(.{4,})(.{20})$#u', '\1...\3', $text);

		if (!isset($params['query']))
		{
			$params['query'] = '';
		}

		if (!isset($params['path']))
		{
			$params['path'] = '';
		}

		if (isset($params['host']))
		{
			// Convert youtube links to embedded player
			parse_str($params['query'], $query);
			$path = explode('/', $params['path']);

			if (strstr($params['host'], '.youtube.') && !empty($path[1]) && $path[1] == 'watch' && !empty($query['v']))
			{
				$video = $query['v'];
			}
			elseif ($params['host'] == 'youtu.be' && !empty($path[1])) {
				$video = $path[1];
			}

			if (isset($video))
			{
				$uri = Juri::getInstance();
				$scheme = 'http';

				if ($uri->getScheme() == 'https')
				{
					$scheme = 'https';
				}

				return '<object width="425" height="344"><param name="movie" value="' . $scheme . '://www.youtube.com/v/'
						. urlencode($video) . '?version=3&feature=player_embedded&fs=1&cc_load_policy=1"></param><param name="allowFullScreen" value="true"></param><embed src="' . $scheme . '://www.youtube.com/v/'
						. urlencode($video) . '?version=3&feature=player_embedded&fs=1&cc_load_policy=1" type="application/x-shockwave-flash" allowfullscreen="true" width="425" height="344"></embed></object>';
			}
		}

		return "<a class=\"bbcode_url\" href=\"{$url}\" target=\"_blank\" rel=\"nofollow\">{$text}</a>";
	}

	/**
	 * Go through a string containing plain text and do two things on it:
	 * Replace < and > and & and " with HTML-safe equivalents, and replace
	 * smileys like :-) with <img /> tags.
	 *
	 * @param   string  $string  - a string
	 *
	 * @return mixed|string
	 */
	function Internal_ProcessSmileys($string)
	{
		if (!$this->enable_smileys || $this->plain_mode)
		{
			// If smileys are turned off, don't convert them.
			$output = $this->HTMLEncode($string);
		}
		else
		{
			// If the smileys need to be computed, process them now.
			if ($this->smiley_regex === false)
			{
				$this->Internal_RebuildSmileys();
			}

			// Split the string so that it consists of alternating pairs of smileys and non-smileys.
			$tokens = preg_split($this->smiley_regex, $string, -1, PREG_SPLIT_DELIM_CAPTURE);

			if (count($tokens) <= 1)
			{
				// Special (common) case:  This skips the smiley constructor if there
				// were no smileys found, which is most of the time.
				$output = $this->HTMLEncode($string);
			}
			else
			{
				$output = "";
				$is_a_smiley = false;

				foreach ($tokens as $token)
				{
					if (!$is_a_smiley)
					{
						// For non-smiley text, we just pass it through htmlspecialchars.
						$output .= $this->HTMLEncode($token);
					}
					else
					{
						if (isset($this->smiley_info[$token]))
						{
							// Use cached image-size information, if possible.
							$info = $this->smiley_info[$token];
						}
						else
						{
							$info = @getimagesize($this->smiley_dir . '/' . $this->smileys[$token]);
							$this->smiley_info[$token] = $info;
						}

						$alt = htmlspecialchars($token);
						$output .= "<img src=\"" . htmlspecialchars($this->smileys[$token])
								. "\" width=\"{$info[0]}\" height=\"{$info[1]}\""
								. " alt=\"$alt\" title=\"$alt\" class=\"bbcode_smiley\" />";
					}

					$is_a_smiley = !$is_a_smiley;
				}
			}
		}

		return $output;
	}
}
