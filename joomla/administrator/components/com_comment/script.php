<?php
/**
 * @author     Daniel Dimitrov <daniel@compojoom.com>
 * @date       15.02.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

/**
 * Script file of CComment component
 *
 * @since  5.0
 */
class com_CommentInstallerScript extends CompojoomInstaller
{
	public $release = '3.0';

	public $minimum_joomla_release = '2.5.6';

	public $extension = 'com_comment';

	private $type = '';

	private $installationQueue = array(
		'free' => array(
			'plugins' => array(
				'plg_content_joscomment' => 1,
				'plg_k2_ccomment' => 0,
				'plg_search_ccomment' => 0
			)
		),
		'pro' => array(
			'modules' => array(
				// Modules => { (folder) => { (module) => { (position), (published) } }* }*
				'' => array(
					'mod_comments' => array('', 1),
				)
			),
			'plugins' => array(
				'plg_community_compojoomwalls' => 0,
				'plg_compojoomcomment_jomsocial' => 0,
				'plg_content_compojoomcommentjevents' => 0,
				'plg_ninjamonials_compojoomcommentninjamonials' => 0,
				'plg_adsmanagercontent_ccomment' => 0,
				'plg_hwdmediashare_comments_ccomment' => 0,
				'plg_joomgallery_ccomment' => 0,
				'plg_hikashop_ccomment' => 0,
				'plg_dpcalendar_ccomment' => 0,
				'plg_content_ccommentzoo' => 0,
				'plg_system_redshopccomment' => 0,
				'plg_compojoomcomment_aup' => 0,
				'plg_finder_ccomment' => 0,
				'plg_community_ccomment' => 0
			),
			'cbplugins' => array(
				'plug_ccommentwall',
				'plug_usercomments'
			)
		)
	);

	/** @var array Obsolete files and folders to remove from the Core release only */
	private $removeFilesCore = array(
		'files' => array(),
		'folders' => array(
			// Oly part of PRO version
			'components/com_comment/classes/akismet',
			'components/com_comment/classes/recaptcha'
		)
	);

	/** @var array Obsolete files and folders to remove from the Core and Pro releases */
	private $removeFilesPro = array(
		'files' => array(
			'administrator/components/com_comment/controllers/about.php',
			'administrator/components/com_comment/controllers/installer.php',
			'administrator/components/com_comment/controllers/joomvertising.php',
			'administrator/components/com_comment/controllers/maintenance.php',
			'administrator/components/com_comment/models/about.php',
			'administrator/components/com_comment/models/installer.php',
			'administrator/components/com_comment/models/joomvertising.php',
			'administrator/components/com_comment/models/maintenance.php',
			'administrator/components/com_comment/library/JOSC_config.php',
			'administrator/components/com_comment/library/JOSC_element.php',
			'administrator/components/com_comment/library/JOSC_library.php',
			'administrator/components/com_comment/library/JOSC_tabRow.php',
			'administrator/components/com_comment/library/JOSC_tabRows.php',
			'administrator/components/com_comment/tables/installer.php',
			'administrator/components/com_comment/install.comment.php',
			'administrator/components/com_comment/uninstall.comment.php',
		),
		'folders' => array(
			'components/com_comment/classes/joomlacomment',
			'components/com_comment/classes/ubbcode',
			'components/com_comment/includes',
			'components/com_comment/joscomment',
			'administrator/components/com_comment/admin_images',
			'administrator/components/com_comment/library/bitfolge',
			'administrator/components/com_comment/library/installer',
			'administrator/components/com_comment/plugin/',
			'administrator/components/com_comment/views/about',
			'administrator/components/com_comment/views/installer',
			'administrator/components/com_comment/views/joomvertising',
			'administrator/components/com_comment/views/maintenance',
			'media/com_comment/rss',
		)
	);

	/**
	 * method to uninstall the component
	 *
	 * @param   object  $parent  - the parent object
	 *
	 * @return void
	 */
	public function uninstall($parent)
	{
		$this->loadLanguage(JPATH_ADMINISTRATOR);
		$this->type = 'uninstall';
		$this->parent = $parent;

		require_once JPATH_ADMINISTRATOR . '/components/com_comment/version.php';

		$params = JComponentHelper::getParams('com_comment');

		// Let us install the modules & plugins
		$plugins = $this->uninstallPlugins($this->installationQueue['free']['plugins']);
		$modules = array();

		if (CCOMMENT_PRO)
		{
			$plugins = array_merge($plugins, $this->uninstallPlugins($this->installationQueue['pro']['plugins']));
			$modules = array_merge($modules, $this->uninstallModules($this->installationQueue['pro']['modules']));
		}

		$this->status->plugins = $plugins;
		$this->status->modules = $modules;

		$this->droppedTables = false;

		if ($params->get('global.complete_uninstall', 0))
		{
			CommentInstallerDatabase::dropTables();
			$this->droppedTables = true;
		}

		echo $this->displayInfoUninstallation();
	}

	/**
	 * method to run after an install/update/discover method
	 *
	 * @param   string  $type    - the type of the installation
	 * @param   object  $parent  - the parent object
	 *
	 * @return void
	 */
	public function postflight($type, $parent)
	{
		$this->loadLanguage();
		$this->status->config = false;
		require_once $parent->getParent()->getPath('source') . '/administrator/components/com_comment/version.php';

		$path = $this->parent->getParent()->getPath('source');

		switch ($this->updatingFrom)
		{
			case '4.2':
			case '4.2.1':
				$modified = CommentInstallerDatabase::modifyTables421();
				$updated = CommentInstallerDatabase::updateConfig421($path);
				$created = CommentInstallerDatabase::createTables421();
			case '5.0b1':
				CommentInstallerDatabase::createTables50b1();
			case '5.0rc1':
			case '5.0rc2':
			case '5.0rc3':
				// Remove the old K2 plugin
				$this->uninstallPlugins(array('plg_k2_compojoomcommentk2' => 0));
				break;
			case 'new':
				$this->status->config = CommentInstallerDatabase::insertConfig($path);
				break;
		}

		CommentInstallerDatabase::updateVersionNumber(CCOMMENT_VERSION);

		if (CCOMMENT_PRO)
		{
			$removeFiles = $this->removeFilesPro;
		}
		else
		{
			$removeFiles = array(
				'files' => array_merge($this->removeFilesPro['files'], $this->removeFilesCore['files']),
				'folders' => array_merge($this->removeFilesPro['folders'], $this->removeFilesCore['folders']),
			);
		}

		CompojoomInstaller::removeObsoleteFilesAndFolders($removeFiles);

		// Let us install the modules & plugins
		$plugins = $this->installPlugins($this->installationQueue['free']['plugins']);
		$modules = array();

		if (CCOMMENT_PRO)
		{
			$plugins = array_merge($plugins, $this->installPlugins($this->installationQueue['pro']['plugins']));
			$modules = array_merge($modules, $this->installModules($this->installationQueue['pro']['modules']));
		}

		$this->status->plugins = $plugins;
		$this->status->modules = $modules;

		// Install the cb plugin if CB is installed
		$this->status->cb = false;

		if (CCOMMENT_PRO && JFile::exists(JPATH_ADMINISTRATOR . '/components/com_comprofiler/library/cb/cb.installer.php'))
		{
			global $_CB_framework;
			require_once JPATH_ADMINISTRATOR . '/components/com_comprofiler/plugin.foundation.php';
			require_once JPATH_ADMINISTRATOR . '/components/com_comprofiler/plugin.class.php';
			require_once JPATH_ADMINISTRATOR . '/components/com_comprofiler/comprofiler.class.php';

			require_once JPATH_ADMINISTRATOR . '/components/com_comprofiler/library/cb/cb.installer.php';

			foreach ($this->installationQueue['pro']['cbplugins'] as $plugin)
			{
				$cbInstaller = new cbInstallerPlugin;

				if ($cbInstaller->install($path . '/components/com_comprofiler/plugin/user/' . $plugin . '/'))
				{
					$langPath = $parent->getParent()->getPath('source') . '/components/com_comprofiler/plugin/user/' . $plugin . '/administrator/language';

					$cbNames = explode('_', $plugin);

					if (JFolder::exists($langPath))
					{
						$languages = JFolder::folders($langPath);

						foreach ($languages as $language)
						{
							if (JFolder::exists(JPATH_ROOT . '/administrator/language/' . $language))
							{
								JFile::copy(
									$langPath . '/' . $language . '/' . $language . '.plg_' . $cbNames[1] . '.ini',
									JPATH_ROOT . '/administrator/language/' . $language . '/' . $language . '.plg_' . $cbNames[1] . '.ini'
								);
							}
						}
					}

					$this->status->cb = true;
				}
			}
		}

		echo $this->displayInfoInstallation();
	}

	/**
	 * Displays information about the status of the installation
	 *
	 * @return string
	 */
	private function displayInfoInstallation()
	{
		$html[] = $this->addCSS();
		$html[] = '<div class="ccomment-info alert alert-info">'
			. JText::sprintf('COM_COMMENT_INSTALLATION_SUCCESS', (CCOMMENT_PRO ? 'Professional' : 'Core')) . '</div>';

		if (!CCOMMENT_PRO)
		{
			$html[] .= '<p>' . JText::sprintf('COM_COMMENT_UPGRADE_TO_PRO', 'https://compojoom.com/joomla-extensions/compojoomcomment') . '</p>';
		}

		$html[] .= '<p>' . JText::_('COM_COMMENT_LATEST_NEWS_PROMOTIONS') . ':</p>';
		$html[] .= '<table><tr><td>' . JText::_('COM_COMMENT_LIKE_FB') . ': </td><td><iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Ffacebook.com%2Fcompojoom&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=true&amp;font&amp;colorscheme=light&amp;action=like&amp;height=21&amp;appId=119257468194823" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe></td></tr>
							<tr><td>' . JText::_('COM_COMMENT_FOLLOW_TWITTER') . ': </td><td><a href="https://twitter.com/compojoom" class="twitter-follow-button" data-show-count="false">Follow @compojoom</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></td></tr></table>';

		if ($this->status->cb)
		{
			$html[] = '<p><br/><br/>' . JText::_('COM_COMMENT_CB_DETECTED_PLUGINS_INSTALLED') . '</p>';
		}

		if ($this->status->plugins)
		{
			$html[] = $this->renderPluginInfoInstall($this->status->plugins);
		}

		if ($this->status->modules)
		{
			$html[] = $this->renderModuleInfoInstall($this->status->modules);
		}

		return implode('', $html);
	}

	/**
	 * Ads css to the page
	 *
	 * @return string
	 */
	public function addCss()
	{
		$css = '<style type="text/css">
					.ccomment-info {
						background-color: #D9EDF7;
					    border-color: #BCE8F1;
					    color: #3A87AD;
					    border-radius: 4px 4px 4px 4px;
					    padding: 8px 35px 8px 14px;
					    text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
					    margin-bottom: 18px;
					}

				</style>
				';

		return $css;
	}

	/**
	 * Displays uninstall info to the user
	 *
	 * @return string
	 */
	public function displayInfoUninstallation()
	{
		$html[] = $this->addCss();
		$html[] = '<div class="ccomment-info alert alert-info">CComment is now removed from your system</div>';

		if ($this->droppedTables)
		{
			$html[] = '<p>The option uninstall complete mode was set to true. Database tables were removed</p>';
		}
		else
		{
			$html[] = '<p>The option uninstall complete mode was set to false. The database tables were not removed.</p>';
		}

		$html[] = $this->renderPluginInfoUninstall($this->status->plugins);
		$html[] = $this->renderModuleInfoUninstall($this->status->modules);

		return implode('', $html);
	}

	/**
	 * Method to get component version
	 *
	 * @return string - the version number
	 */
	public function getVersion()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$ext = null;

		$query->select('*');
		$query->from($db->qn('#__extensions'));
		$query->where($db->qn('name') . '=' . $db->quote('com_comment'));
		$query->where($db->qn('type') . '=' . $db->quote('component'));
		$db->setQuery($query);

		$ext = $db->loadObject();

		if ($ext)
		{
			$json = $ext->manifest_cache;
			$data = json_decode($json);
			$version = $data->version;
		}
		else
		{
			// Work with exception on 2.5 as well! Exceptions are good!
			if (!version_compare(JVERSION, '3.0', 'gt'))
			{
				JError::$legacy = false;
			}

			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('version')->from('#__comment_version');
			$db->setQuery($query);

			try
			{
				$version = $db->loadObject();

				if ($version)
				{
					$version = $version->version;
				}
			}
			catch (Exception $e)
			{

				$query->clear();
				$query->select('*')->from('#__comment_setting');
				$db->setQuery($query);

				try
				{
					$db->loadObject();
					$version = '4.2.1';
				}
				catch (Exception $e)
				{

					$version = 'new';
				}
			}
		}

		return $version;
	}
}

/**
 * Class CompojoomInstaller
 *
 * @since  5.0
 */
class CompojoomInstaller
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->status = new stdClass;
	}

	/**
	 * Removes obsolete files and folders
	 *
	 * @param   array  $removeFiles  - remove the files
	 *
	 * @return void
	 */
	public static function removeObsoleteFilesAndFolders($removeFiles)
	{
		// Remove files
		JLoader::import('joomla.filesystem.file');

		if (!empty($removeFiles['files']))
		{
			foreach ($removeFiles['files'] as $file)
			{
				$f = JPATH_ROOT . '/' . $file;

				if (!JFile::exists($f))
				{
					continue;
				}

				JFile::delete($f);
			}
		}

		// Remove folders
		JLoader::import('joomla.filesystem.file');

		if (!empty($removeFiles['folders']))
		{
			foreach ($removeFiles['folders'] as $folder)
			{
				$f = JPATH_ROOT . '/' . $folder;

				if (!JFolder::exists($f))
				{
					continue;
				}

				JFolder::delete($f);
			}
		}
	}

	/**
	 * Loads the necessary lang files for the installation
	 *
	 * @param null $path
	 */
	public function loadLanguage($path = null)
	{
		$extension = $this->extension;
		$jlang = JFactory::getLanguage();

		if (!$path)
		{
			$path = $this->parent->getParent()->getPath('source') . '/administrator';
		}

		$jlang->load($extension, $path, 'en-GB', true);
		$jlang->load($extension, $path, $jlang->getDefault(), true);
		$jlang->load($extension, $path, null, true);
		$jlang->load($extension . '.sys', $path, 'en-GB', true);
		$jlang->load($extension . '.sys', $path, $jlang->getDefault(), true);
		$jlang->load($extension . '.sys', $path, null, true);
	}

	/**
	 * Function that installs the modules in the package
	 *
	 * @param   array  $modulesToInstall  - the modules to install
	 *
	 * @return array
	 */
	public function installModules($modulesToInstall)
	{
		$src = $this->parent->getParent()->getPath('source');
		$status = array();

		// Modules installation
		if (count($modulesToInstall))
		{
			foreach ($modulesToInstall as $folder => $modules)
			{
				if (count($modules))
				{
					foreach ($modules as $module => $modulePreferences)
					{
						// Install the module
						if (empty($folder))
						{
							$folder = 'site';
						}

						$path = "$src/modules/$module";

						if ($folder == 'admin')
						{
							$path = "$src/administrator/modules/$module";
						}

						if (!is_dir($path))
						{
							continue;
						}

						$db = JFactory::getDbo();

						// Was the module alrady installed?
						$query = $db->getQuery('true');
						$query->select('COUNT(*)')->from($db->qn('#__modules'))
							->where($db->qn('module') . '=' . $db->q($module));
						$db->setQuery($query);

						$count = $db->loadResult();

						$installer = new JInstaller;
						$result = $installer->install($path);
						$status[] = array('name' => $module, 'client' => $folder, 'result' => $result);

						// Modify where it's published and its published state
						if (!$count)
						{
							list($modulePosition, $modulePublished) = $modulePreferences;
							$query->clear();
							$query->update($db->qn('#__modules'))->set($db->qn('position') . '=' . $db->q($modulePosition));

							if ($modulePublished)
							{
								$query->set($db->qn('published') . '=' . $db->q(1));
							}

							$query->set($db->qn('params') . '=' . $db->q($installer->getParams()));
							$query->where($db->qn('module') . '=' . $db->q($module));
							$db->setQuery($query);
							$db->execute();
						}

						// Get module id
						$query->clear();
						$query->select('id')->from($db->qn('#__modules'))
							->where($db->qn('module') . '=' . $db->q($module));
						$db->setQuery($query);

						$moduleId = $db->loadObject()->id;

						$query->clear();
						$query->select('COUNT(*) as count')->from($db->qn('#__modules_menu'))
							->where($db->qn('moduleid') . '=' . $db->q($moduleId));

						$db->setQuery($query);

						$result = $db->loadObject();

						if (!$db->loadObject()->count)
						{
							// Insert the module on all pages, otherwise we can't use it
							$query->clear();
							$query->insert($db->qn('#__modules_menu'))->columns($db->qn('moduleid') . ',' . $db->qn('menuid'))->values($db->q($moduleId) . ' , ' . $db->q('0'));
							$db->setQuery($query);
							$db->execute();
						}
					}
				}
			}
		}

		return $status;
	}

	/**
	 * Function that uninstalls the modules in the package
	 *
	 * @param   array  $modulesToUninstall  - the modules to uninstall
	 *
	 * @return array
	 */
	public function uninstallModules($modulesToUninstall)
	{
		$status = array();

		if (count($modulesToUninstall))
		{
			$db = JFactory::getDbo();

			foreach ($modulesToUninstall as $folder => $modules)
			{
				if (count($modules))
				{
					foreach ($modules as $module => $modulePreferences)
					{
						// Find the module ID
						$query = $db->getQuery(true);
						$query->select('extension_id')->from('#__extensions')->where($db->qn('element') . '=' . $db->q($module))
							->where($db->qn('type') . '=' . $db->q('module'));
						$db->setQuery($query);

						$id = $db->loadResult();

						// Uninstall the module
						$installer = new JInstaller;
						$result = $installer->uninstall('module', $id, 1);
						$status[] = array('name' => $module, 'client' => $folder, 'result' => $result);
					}
				}
			}
		}

		return $status;
	}

	/**
	 * Function that installs the plugins in the package
	 *
	 * @param   array  $plugins  - the plugins to install
	 *
	 * @return array
	 */
	public function installPlugins($plugins)
	{
		$src = $this->parent->getParent()->getPath('source');

		$db = JFactory::getDbo();
		$status = array();

		foreach ($plugins as $plugin => $published)
		{
			$parts = explode('_', $plugin);
			$pluginType = $parts[1];
			$pluginName = implode('_', array_slice($parts, 2));

			$path = $src . "/plugins/$pluginType/$pluginName";

			$query = $db->getQuery(true);
			$query->select('COUNT(*)')
				->from('#__extensions')
				->where($db->qn('element') . '=' . $db->q($pluginName))
				->where($db->qn('folder') . '=' . $db->q($pluginType));

			$db->setQuery($query);
			$count = $db->loadResult();

			$installer = new JInstaller;
			$result = $installer->install($path);
			$status[] = array('name' => $plugin, 'group' => $pluginType, 'result' => $result);

			if ($published && !$count)
			{
				$query->clear();
				$query->update('#__extensions')
					->set($db->qn('enabled') . '=' . $db->q(1))
					->where($db->qn('element') . '=' . $db->q($pluginName))
					->where($db->qn('folder') . '=' . $db->q($pluginType));
				$db->setQuery($query);
				$db->query();
			}
		}

		return $status;
	}

	public function uninstallPlugins($plugins)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$status = array();

		foreach ($plugins as $plugin => $published)
		{
			$parts = explode('_', $plugin);
			$pluginType = $parts[1];
			$pluginName = $parts[2];
			$query->clear();
			$query->select('extension_id')->from($db->qn('#__extensions'))
				->where($db->qn('type') . '=' . $db->q('plugin'))
				->where($db->qn('element') . '=' . $db->q($pluginName))
				->where($db->qn('folder') . '=' . $db->q($pluginType));
			$db->setQuery($query);

			$id = $db->loadResult();

			if ($id)
			{
				$installer = new JInstaller;
				$result = $installer->uninstall('plugin', $id, 1);
				$status[] = array('name' => $plugin, 'group' => $pluginType, 'result' => $result);
			}
		}

		return $status;
	}

	/**
	 * Get a variable from the manifest file (actually, from the manifest cache).
	 *
	 * @param   string  $name  - the name
	 *
	 * @return string
	 */
	public function getParam($name)
	{
		$db = JFactory::getDbo();
		$db->setQuery('SELECT manifest_cache FROM #__extensions WHERE name = ' . $db->q('com_comment'));
		$manifest = json_decode($db->loadResult(), true);

		return $manifest[$name];
	}

	/**
	 * Render info about the installed modules
	 *
	 * @param   array  $modules  - the instlaled modules
	 *
	 * @return string
	 */
	public function renderModuleInfoInstall($modules)
	{
		$rows = 0;

		$html = array();
		$html[] = '<p><br />' . JText::_('COM_COMMENT_FOLLOWING_MODULES_INSTALLED') . '</p>';

		if (count($modules))
		{
			$html[] = '<table class="table table-striped">';
			$html[] = '<thead><tr>';
			$html[] = '<th>' . JText::_(strtoupper($this->extension) . '_MODULE') . '</th>';
			$html[] = '<th>' . JText::_(strtoupper($this->extension) . '_CLIENT') . '</th>';
			$html[] = '<th>' . JText::_(strtoupper($this->extension) . '_STATUS') . '</th>';
			$html[] = '</tr></thead>';

			foreach ($modules as $module)
			{
				$html[] = '<tr class="row' . (++$rows % 2) . '">';
				$html[] = '<td class="key">' . $module['name'] . '</td>';
				$html[] = '<td class="key">' . ucfirst($module['client']) . '</td>';
				$html[] = '<td>';
				$html[] = '<span style="color:' . (($module['result']) ? 'green' : 'red') . '; font-weight: bold;">';
				$html[] = ($module['result']) ? JText::_(strtoupper($this->extension) . '_MODULE_INSTALLED') : JText::_(strtoupper($this->extension) . '_MODULE_NOT_INSTALLED');
				$html[] = '</span>';
				$html[] = '</td>';
				$html[] = '</tr>';
			}

			$html[] = '</table>';
		}


		return implode('', $html);
	}

	/**
	 * Renders info about the uninstalled modules
	 *
	 * @param   array  $modules  - array with the modules
	 *
	 * @return string
	 */
	public function renderModuleInfoUninstall($modules)
	{
		$rows = 0;
		$html = array();

		if (count($modules))
		{
			$html[] = '<table class="table table-striped">';
			$html[] = '<thead><tr>';
			$html[] = '<th>' . JText::_(strtoupper($this->extension) . '_MODULE') . '</th>';
			$html[] = '<th>' . JText::_(strtoupper($this->extension) . '_CLIENT') . '</th>';
			$html[] = '<th>' . JText::_(strtoupper($this->extension) . '_STATUS') . '</th>';
			$html[] = '</tr></thead>';

			foreach ($modules as $module)
			{
				$html[] = '<tr class="row' . (++$rows % 2) . '">';
				$html[] = '<td class="key">' . $module['name'] . '</td>';
				$html[] = '<td class="key">' . ucfirst($module['client']) . '</td>';
				$html[] = '<td>';
				$html[] = '<span style="color:' . (($module['result']) ? 'green' : 'red') . '; font-weight: bold;">';
				$html[] = ($module['result']) ? JText::_(strtoupper($this->extension) . '_MODULE_UNINSTALLED') : JText::_(strtoupper($this->extension) . '_MODULE_COULD_NOT_UNINSTALL');
				$html[] = '</span>';
				$html[] = '</td>';
				$html[] = '</tr>';
			}

			$html[] = '</table>';
		}

		return implode('', $html);
	}

	/**
	 * Renders plugin info about the installation
	 *
	 * @param   array  $plugins  - array with plugins
	 *
	 * @return string
	 */
	public function renderPluginInfoInstall($plugins)
	{
		$rows = 0;
		$html[] = '<p><br />' . JText::_('COM_COMMENT_FOLLOWING_PLUGINS_INSTALLED') . '</p>';
		$html[] = '<table class="table table-striped">';

		if (count($plugins))
		{
			$html[] = '<thead><tr>';
			$html[] = '<th>' . JText::_(strtoupper($this->extension) . '_PLUGIN') . '</th>';
			$html[] = '<th>' . JText::_(strtoupper($this->extension) . '_GROUP') . '</th>';
			$html[] = '<th>' . JText::_(strtoupper($this->extension) . '_STATUS') . '</th>';
			$html[] = '</tr></thead>';

			foreach ($plugins as $plugin)
			{
				$html[] = '<tr class="row' . (++$rows % 2) . '">';
				$html[] = '<td class="key">' . $plugin['name'] . '</td>';
				$html[] = '<td class="key">' . ucfirst($plugin['group']) . '</td>';
				$html[] = '<td>';
				$html[] = '<span style="color: ' . (($plugin['result']) ? 'green' : 'red') . '; font-weight: bold;">';
				$html[] = ($plugin['result']) ? JText::_(strtoupper($this->extension) . '_PLUGIN_INSTALLED') : JText::_(strtoupper($this->extension) . 'PLUGIN_NOT_INSTALLED');
				$html[] = '</span>';
				$html[] = '</td>';
				$html[] = '</tr>';
			}
		}

		$html[] = '</table>';

		return implode('', $html);
	}

	/**
	 * Renders plugin information about the installation+
	 *
	 * @param   array  $plugins  - array with the plugins
	 *
	 * @return string
	 */
	public function renderPluginInfoUninstall($plugins)
	{
		$rows = 0;
		$html = array();

		if (count($plugins))
		{
			$html[] = '<table class="table table-striped">';
			$html[] = '<thead>';
			$html[] = '<tr>';
			$html[] = '<th>Plugin</th>';
			$html[] = '<th>Group</th>';
			$html[] = '<th></th>';
			$html[] = '</tr></thead><tbody>';

			foreach ($plugins as $plugin)
			{
				$html[] = '<tr class="row' . (++$rows % 2) . '">';
				$html[] = '<td class="key">' . $plugin['name'] . '</td>';
				$html[] = '<td class="key">' . ucfirst($plugin['group']) . '</td>';
				$html[] = '<td>';
				$html[] = '	<span style="color:' . (($plugin['result']) ? 'green' : 'red') . '; font-weight: bold;">';
				$html[] = ($plugin['result']) ? JText::_(strtoupper($this->extension) . '_PLUGIN_UNINSTALLED') : JText::_(strtoupper($this->extension) . '_PLUGIN_NOT_UNINSTALLED');
				$html[] = '</span>';
				$html[] = '</td>';
				$html[] = ' </tr> ';
			}

			$html[] = '</tbody> ';
			$html[] = '</table> ';
		}

		return implode('', $html);
	}

	/**
	 * method to run before an install/update/discover method
	 *
	 * @param   string  $type    - the type of the instlalation
	 * @param   object  $parent  - the parent object
	 *
	 * @return void
	 */
	public function preflight($type, $parent)
	{
		$jversion = new JVersion;

		// Extract the version number from the manifest file
		$this->release = $parent->get("manifest")->version;

		// Find the version that we are updating from if any (don't do this on postflight as the extension table is
		// Already updated
		$this->updatingFrom = $this->getVersion('com_comment');

		// Find mimimum required joomla version from the manifest file
		$this->minimum_joomla_release = $parent->get("manifest")->attributes()->version;

		if (version_compare($jversion->getShortVersion(), $this->minimum_joomla_release, 'lt'))
		{
			Jerror::raiseWarning(
				null, 'Cannot install ' . $this->extension . ' in a Joomla release prior to '
				. $this->minimum_joomla_release
			);

			return false;
		}

	}

	/**
	 * method to update the component
	 *
	 * @param   object  $parent  - the parent object
	 *
	 * @return void
	 */
	public function update($parent)
	{
		$this->parent = $parent;
	}

	/**
	 * method to install the component
	 *
	 * @param   object  $parent  - the parent object
	 *
	 * @return void
	 */
	public function install($parent)
	{
		$this->parent = $parent;
	}
}

/**
 * Class CommentInstallerDatabase
 *
 * @since  5.0
 */
class CommentInstallerDatabase
{
	/**
	 * Updates the version number
	 *
	 * @param $number
	 */
	public static function updateVersionNumber($number)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery('clear');
		$query->select('*')->from('#__comment_version');
		$db->setQuery($query, 0, 1);

		$version = $db->loadObject();
		$query->clear();

		if ($version)
		{
			$query->update('#__comment_version')->set($db->qn('version') . '=' . $db->q($number))
				->where($db->qn('id') . '=' . $db->q(1));
		}
		else
		{
			$query->insert('#__comment_version')->columns('id, version')->values($db->q(1) . ',' . $db->q($number));
		}

		$db->setQuery($query);
		$db->execute();
	}

	public static function dropTables()
	{
		$db = JFactory::getDBO();
		$dropTables[] = 'DROP TABLE ' . $db->quoteName('#__comment') . ';';
		$dropTables[] = 'DROP TABLE ' . $db->quoteName('#__comment_captcha') . ';';
		$dropTables[] = 'DROP TABLE ' . $db->quoteName('#__comment_queue') . ';';
		$dropTables[] = 'DROP TABLE ' . $db->quoteName('#__comment_setting') . ';';
		$dropTables[] = 'DROP TABLE ' . $db->quoteName('#__comment_voting') . ';';
		$dropTables[] = 'DROP TABLE ' . $db->quoteName('#__comment_version') . ';';

		foreach ($dropTables as $drop)
		{
			$db->setQuery($drop);
			$db->execute();
		}

		return true;
	}

	public static function modifyTables421()
	{
		JError::$legacy = true;
		$db = JFactory::getDbo();
		$query = 'ALTER TABLE ' . $db->qn('#__comment_setting') . ' DROP ' . $db->qn('set_sectionid') . ','
			. ' CHANGE ' . $db->qn('set_name') . ' ' . $db->qn('note') . ' varchar(255) NOT NULL DEFAULT "", '
			. ' CHANGE ' . $db->qn('set_component') . ' ' . $db->qn('component') . ' varchar(50) NOT NULL DEFAULT ""';
		$db->setQuery($query);

		try
		{
			$modified['setting'] = $db->execute();
		}
		catch (Exception $e)
		{
			$modified['setting'] = false;
		}


		$query = 'ALTER TABLE ' . $db->qn('#__comment')
			. ' DROP ' . $db->qn('usertype') . ','
			. ' ADD ' . $db->qn('modified_by') . " int(10) unsigned NOT NULL DEFAULT '0',"
			. ' ADD ' . $db->qn('modified') . " datetime NOT NULL DEFAULT '0000-00-00 00:00:00',"
			. ' ADD ' . $db->qn('unsubscribe_hash') . " VARCHAR( 255 ) NOT NULL ,"
			. ' ADD ' . $db->qn('moderate_hash') . " VARCHAR( 255 ) NOT NULL,"
			. ' ADD ' . $db->qn('deleted') . " tinyint(1) NOT NULL DEFAULT '0',"
			. ' ADD ' . $db->qn('spam') . " tinyint(1) NOT NULL DEFAULT '0';";

		$db->setQuery($query);

		try
		{
			$modified['comment'] = $db->execute();
		}
		catch (Exception $e)
		{
			$modified['comment'] = false;
		}

		$query = 'DROP TABLE IF EXISTS' . $db->qn('#__comment_installer');

		try
		{
			$db->setQuery($query);
			$modified['installer'] = $db->execute();
		}
		catch (Exception $e)
		{
			$modified['installer'] = false;
		}


		return $modified;
	}

	public static function createTables421() {
		$db = JFactory::getDbo();
		$query = 'CREATE TABLE IF NOT EXISTS ' . $db->qn('#__comment_version') . ' (
					  `id` int(11) NOT NULL,
					  `version` varchar(55) NOT NULL
					) DEFAULT CHARSET=utf8;';

		$db->setQuery($query);

		return $db->execute();
	}

	/**
	 * Ads the mailqueue table
	 *
	 * @return mixed
	 */
	public static function createTables50b1() {
		$db = JFactory::getDbo();
		$query = 'CREATE TABLE IF NOT EXISTS '.$db->qn('#__comment_queue').' (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `mailfrom` varchar(255) DEFAULT NULL,
					  `fromname` varchar(255) DEFAULT NULL,
					  `recipient` varchar(255) NOT NULL,
					  `subject` text NOT NULL,
					  `body` text NOT NULL,
					  `created` datetime NOT NULL,
					  `type` varchar(10) NOT NULL DEFAULT "html",
					  `status` tinyint(1) NOT NULL DEFAULT "0",
					  PRIMARY KEY (`id`),
					  KEY `status` (`status`)
					) DEFAULT CHARSET=utf8;';

		$db->setQuery($query);
		return $db->execute();
	}

	public static function updateConfig421($path)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$json = self::getDefaultConfig($path);
		$updates = array();

		$query->select('*')->from('#__comment_setting');
		$db->setQuery($query);
		$configs = $db->loadObjectList();

		foreach ($configs as $config)
		{
			$query->clear();
			$query->update('#__comment_setting')->set('params = ' . $db->q($json));
			$db->setQuery($query);
			$updates[$config->component] = $db->execute();
		}

		return $updates;
	}

	public static function insertConfig($path)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$json = self::getDefaultConfig($path);

		$query->insert('#__comment_setting')->columns('note,component,params')
			->values($db->q('The standard joomla article manager') . ',' . $db->q('com_content') . ',' . $db->q($json));
		$db->setQuery($query);
		return $db->execute();
	}

	public static function getDefaultConfig($path)
	{
		$settings = $path . '/administrator/components/com_comment/models/forms/settings.xml';
		$template = $path . '/components/com_comment/templates/default/settings.xml';
		$form = new JForm('comment');
		$form->loadFile($settings);
		$form->loadFile($template);

		$json = array();

		$fieldsets = $form->getFieldsets();
		foreach ($fieldsets as $fieldsetkey => $fieldset)
		{
			$fields = $form->getFieldset($fieldsetkey);
			foreach ($fields as $fieldkey => $field)
			{
				$json[$field->group][$field->fieldname] = $field->value;
			}
		}

		return json_encode($json);
	}
}

class CommentInstallerFiles
{

	public function dropToolbars()
	{
		$toolbar_rem = (JPATH_BASE . '/components/com_comment/toolbar.hotspots.html.php');
		$toolbar2_rem = (JPATH_BASE . '/components/com_comment/toolbar.hotspots.php');
		if (file_exists($toolbar_rem))
		{
			unlink($toolbar_rem);
		}
		if (file_exists($toolbar2_rem))
		{
			unlink($toolbar2_rem);
		}
	}

	/**
	 * This function moves files to the media folder and deletes
	 * unnecessary folders
	 */
	public function updateFiles()
	{
		jimport('joomla.filesystem');
		$adminPath = JPATH_ADMINISTRATOR . '/components/com_comment/';
		$frontendPath = JPATH_ROOT . '/components/com_comment/';

		// For now, we won't delete change any file

		$filesToMove = array(
			'frontend' => array(),
			'backend' => array()
		);

		$foldersToDelete = array(
			'backend' => array(),
			'frontend' => array()
		);

		$filesToDelete = array(
			'backend' => array(),
			'frontend' => array()
		);

		$captchaPath = $frontendPath . 'captcha';

		$exclude = array('.svn', 'CVS', 'captcha.PNG', 'XFILES.TTF', 'index.html');
		// should we delete captcha images?
		/*
		$captchaImages = JFolder::files($captchaPath, $filter = '.', false, false, $exclude);

		if (is_array($captchaImages) && !empty($captchaImages)) {
			foreach ($captchaImages as $captchaImage) {
				JFile::delete($captchaPath . '/' . $captchaImage);
			}
		}
		 */

		foreach ($filesToMove as $pathToFiles)
		{
			foreach ($pathToFiles as $key => $pathToFile)
			{
				if (JFolder::exists($pathToFile))
				{
					$oldDestination = $frontendPath . 'images/' . $key . '/';
					$moveTo = JPATH_ROOT . '/media/com_comment/images/' . $key . '/';
					$files = JFolder::files($pathToFile);
					foreach ($files as $file)
					{
						if (!JFile::exists($moveTo . $file))
						{
							JFile::move($oldDestination . $file, $moveTo . $file);
						}
					}
				}
			}
		}

		foreach ($foldersToDelete as $pathToFolders)
		{
			foreach ($pathToFolders as $pathToFolder)
			{
				if (JFolder::exists($pathToFolder))
				{
					JFolder::delete($pathToFolder);
				}
			}
		}

		foreach ($filesToDelete as $paths)
		{
			foreach ($paths as $path)
			{
				if (JFile::exists($path))
				{
					JFile::delete($path);
				}
			}
		}
	}
}
