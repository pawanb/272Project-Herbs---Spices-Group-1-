<?php

/*
 * Copyright (C) 2009 Daniel Dimitrov (http://compojoom.com)
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

JLoader::discover('ccomment', JPATH_SITE . '/administrator/components/com_comment/library');
JLoader::discover('ccommentComponent', JPATH_SITE . '/administrator/components/com_comment/library/component');
JLoader::discover('ccommentModel', JPATH_SITE . '/components/com_comment/models');
JLoader::discover('ccommentHelper', JPATH_SITE . '/components/com_comment/helpers/');

/**
 * Class ccommentHelperUtils
 *
 * @since  5
 */
class CcommentHelperUtils
{
	/**
	 * This function loads the Settings class for a comment plugin
	 *
	 * @param   string  $component  - the component that we need the options for
	 *
	 * @return mixed
	 *
	 * @throws Exception
	 */
	public static function getComponentSettings($component)
	{
		$nameParts = explode('_', $component);
		$path = JPATH_SITE . '/administrator/components/com_comment/plugins/' . $component . '/settings.php';
		$class = 'ccommentComponent' . ucfirst($nameParts[1]) . 'Settings';
		JLoader::register($class, $path);

		if (!JLoader::load($class))
		{
			throw new Exception('Options file for ' . $component . 'doesn\'t exist');
		}

		return new $class;
	}


	/**
	 * This function initialises the comment plugin object
	 *
	 * @param   string  $component  - the component name (com_something)
	 * @param   object  $row        - the object that we are going to comment on
	 * @param   object  $params     - any parameters
	 *
	 * @throws Exception
	 * @return mixed
	 */
	public static function getPlugin($component, $row = null, $params = null)
	{
		$nameParts = explode('_', $component);
		$path = JPATH_SITE . '/administrator/components/com_comment/plugins/' . $component . '/' . $nameParts[1] . '.php';
		$class = 'ccommentComponent' . ucfirst($nameParts[1]) . 'Plugin';
		JLoader::register($class, $path);

		if (!JLoader::load($class))
		{
			throw new Exception('CComment plugin file for ' . $component . 'doesn\'t exist');
		}

		return new $class($row, $params);
	}

	/**
	 * Initialises the comment system
	 *
	 * @param   string  $component  - the component name
	 * @param   object  $row        - the object that we are going to comment on
	 * @param   object  $params     - any component parameters
	 *
	 * @return bool|mixed|string|void
	 */
	public static function commentInit($component, $row, $params = null)
	{
		$input = JFactory::getApplication()->input;
		$input->set('component', $component);
		$plugin = self::getPlugin($component, $row, $params);
		$fragment = $input->getString('_escaped_fragment_');

		if (!$plugin->isEnabled())
		{
			return false;
		}

		self::loadLanguage();

		if ($plugin->isSingleView())
		{
			if (isset($fragment))
			{
				return self::searchView($plugin, $component);
			}
			else
			{
				// Process mailqueue if we are in single view
				if (JComponentHelper::getParams('com_comment')->get('global.mailqueue_pageload', 1))
				{
					ccommentHelperQueue::send();
				}

				return self::loadSingleView($plugin, $component);
			}
		}
		else
		{
			if ($plugin->showReadOn())
			{
				return self::loadListView($plugin, $component);
			}
		}

		return false;
	}

	/**
	 * Loads the necessary language files for the component
	 *
	 * @return void
	 */
	public static function loadLanguage()
	{
		$lang = JFactory::getLanguage();
		$lang->load('com_comment', JPATH_ADMINISTRATOR, 'en-GB', true);
		$lang->load('com_comment', JPATH_ADMINISTRATOR, $lang->getDefault(), true);
		$lang->load('com_comment', JPATH_ADMINISTRATOR, null, true);
		$lang->load('com_comment', JPATH_SITE, 'en-GB', true);
		$lang->load('com_comment', JPATH_SITE, $lang->getDefault(), true);
		$lang->load('com_comment', JPATH_SITE, null, true);
	}

	/**
	 * Loads the comment system on a list view
	 *
	 * @param   object  $plugin     - the comment plugin object
	 * @param   string  $component  - the component name
	 *
	 * @return string
	 */
	public static function loadListView($plugin, $component)
	{
		$config = ccommentConfig::getConfig($component);
		JLoader::register('ccommentViewComments', JPATH_SITE . '/components/com_comment/views/comments/view.html.php');
		$model = JModelLegacy::getInstance('Comment', 'ccommentModel');
		$id = $plugin->getPageId();
		$count = $model->countComments($id, $component);

		$view = new ccommentViewComments(
			array('base_path' => JPATH_SITE . '/components/com_comment')
		);

		$view->config = $config;
		$view->count = $count;
		$view->plugin = $plugin;
		$view->link = self::fixUrl($plugin->getLink($plugin->getPageId()));

		if ($config->get('template_params.preview_visible', 0))
		{
			$comments = $model->getPreviewComments($id, $component);
			$view->comments = ccommentHelperComment::prepareCommentForPreview($plugin, $comments);
		}

		$view->setLayout('readmore');
		$html = $view->readMore();

		return $html;
	}

	/**
	 * Loads the single view for the comments
	 *
	 * @param   object  $plugin     - the comment plugin object
	 * @param   string  $component  - the component name
	 *
	 * @return mixed|string|void
	 */
	public static function loadSingleView($plugin, $component)
	{
		JLoader::register('ccommentViewComments', JPATH_SITE . '/components/com_comment/views/comments/view.html.php');

		$config = ccommentConfig::getConfig($component);
		$model = JModelLegacy::getInstance('Comment', 'ccommentModel');
		$id = $plugin->getPageId();
		$count = $model->countComments($id, $component);
		$view = new ccommentViewComments(
			array('base_path' => JPATH_SITE . '/components/com_comment')
		);

		$view->setLayout('default');
		$view->plugin = $plugin;
		$view->config = $config;
		$view->count = $count;
		$view->contentId = $id;
		$view->component = $component;

		$html = $view->display();

		return $html;
	}

	/**
	 * Loads the comment for the ajax crawling
	 *
	 * @param   object  $plugin     - the plugin object
	 * @param   string  $component  - the component name
	 *
	 * @return string
	 */
	public static function searchView($plugin, $component)
	{
		JLoader::register('ccommentViewAjaxcrawler', JPATH_SITE . '/components/com_comment/views/ajaxcrawler/view.html.php');

		$input = JFactory::getApplication()->input;
		$fragment = $input->getString('_escaped_fragment_');
		parse_str($fragment, $query);

		$id = $plugin->getPageId();
		$commentId = isset($query['ccomment-comment']) ? $query['ccomment-comment'] : 0;
		$start = isset($query['ccomment-page']) ? $query['ccomment-page'] : 0;

		$model = JModelLegacy::getInstance('comment', 'ccommentModel');

		$config = ccommentConfig::getConfig($component);

		if ($commentId)
		{
			$pagination = new ccommentHelperPagination($commentId, $id, $component);
			$start = $pagination->findPage();
		}

		$comments = $model->getComments($id, $component, $start);

		if (count($comments))
		{
			$comments = ccommentHelperComment::prepareComments($comments, $config);
		}

		$view = new ccommentViewAjaxcrawler(
			array('base_path' => JPATH_SITE . '/components/com_comment')
		);

		$view->setLayout('default');
		$view->plugin = $plugin;
		$view->config = $config;
		$view->contentId = $id;
		$view->component = $component;
		$view->comments = $comments;

		$html = $view->display();

		return $html;
	}

	/**
	 * Sends the json response by properly setting a header
	 *
	 * @param   object|array  $data  - the data that is going to be sent to the client
	 *
	 * @return void
	 */
	public static function sendJsonResponse($data)
	{
		header('content-type:application/json');
		echo json_encode($data);
	}

	/**
	 * Returns options that are going to be used by the javascript on the client side
	 *
	 * @param   string  $component  - the component name
	 *
	 * @return array
	 */
	public static function getJSConfig($component)
	{
		$config = ccommentConfig::getConfig($component);

		$jsconfig = array(
			'comments_per_page' => (int) $config->get('layout.comments_per_page'),
			'sort' => (int) $config->get('layout.sort'),
			'tree' => (int) $config->get('layout.tree'),
			'form_position' => (int) $config->get('template_params.form_position'),
			'voting' => (int) $config->get('layout.voting_visible'),
			'copyright' => (int) $config->get('layout.show_copyright', 1),
			'pagination_position' => (int) $config->get('template_params.pagination_position'),
			'avatars' => (int) $config->get('integrations.support_avatars'),
			'gravatar' => (int) $config->get('integrations.gravatar'),
			'baseUrl' => Juri::root()
		);

		if ($config->get('security.captcha') && $config->get('security.captcha_type') == 'recaptcha')
		{
			$jsconfig['captcha_pub_key'] = $config->get('security.recaptcha_public_key');
		}

		return $jsconfig;
	}

	/**
	 * Outputs language strings in the appropriate language to be used with Javascript
	 *
	 * @return void
	 */
	public static function getJsLocalization()
	{
		$strings = array(
			'COM_COMMENT_PLEASE_FILL_IN_ALL_REQUIRED_FIELDS',
			'COM_COMMENT_ANONYMOUS'
		);

		foreach ($strings as $string)
		{
			JText::script($string);
		}
	}

	/**
	 * Censors a given string
	 *
	 * @param   string     $text    - the text to censor
	 * @param   JRegistry  $config  - the configuration object for the component
	 *
	 * @return mixed
	 */
	public static function censorText($text, $config)
	{
		if ($config->get('global.censorship'))
		{
			$words = $config->get('global.censorship_word_list');

			if (count($words))
			{
				$replace = 'str_ireplace';

				if ($config->get('global.censorship_case_sensitive', 1))
				{
					$replace = 'str_replace';
				}

				foreach ($words as $from => $to)
				{
					$text = call_user_func($replace, $from, $to, $text);
				}
			}
		}

		return $text;
	}


	/**
	 * Gets the itemid for a component
	 *
	 * @param   string  $component  - the component that we look for (com_something)
	 *
	 * @return int - component ID
	 */
	public static function getItemid($component = '')
	{
		static $ids;

		if (!isset($ids))
		{
			$ids = array();
		}

		if (!isset($ids[$component]))
		{
			$database = JFactory::getDBO();
			$query = "SELECT id FROM #__menu"
				. "\n WHERE link LIKE '%option=$component%'"
				. "\n AND type = 'component'"
				. "\n AND published = 1 LIMIT 1";
			$database->setQuery($query);
			$ids[$component] = $database->loadResult();
		}

		return $ids[$component];
	}

	/**
	 * Gets the emoticons
	 *
	 * @param   object  $config  - a comment plugin config object
	 *
	 * @return array
	 */
	public static function getEmoticons($config)
	{
		$appl = JFactory::getApplication();
		$icons = array();
		$override = false;
		$pack = $config->get('layout.emoticon_pack');
		$path = JPATH_SITE . '/components/com_comment/assets/emoticons/' . $pack . '/config.php';
		$pathOverride = JPATH_SITE . '/templates/' . $appl->getTemplate() . '/html/com_comment/emoticons/' . $pack . '/config.php';

		if (is_file($pathOverride))
		{
			$override = true;
			$path = $pathOverride;
		}

		if (is_file($path))
		{
			require_once $path;

			if (isset($ccommentEmoticons))
			{
				if ($override)
				{
					$src = JUri::root(true) . '/templates/' . $appl->getTemplate() . '/html/com_comment/emoticons/' . $pack . '/images/';
				}
				else
				{
					$src = JUri::root(true) . '/media/com_comment/emoticons/' . $pack . '/images/';
				}

				foreach ($ccommentEmoticons as $key => $value)
				{
					$icons[$key] = $src . $value;
				}
			}
		}

		return $icons;
	}

	/**
	 * Makes an url with scheme, host and port - if necessary
	 *
	 * @param   string  $url  - the url to fix
	 *
	 * @return string
	 */
	public static function fixUrl($url)
	{
		if (substr(ltrim($url), 0, 7) != 'http://' && substr(ltrim($url), 0, 8) != 'https://')
		{
			$uri = JURI::getInstance();
			$base = $uri->toString(array('scheme', 'host', 'port'));
			$url = $base . $url;
		}

		return $url;
	}
}
