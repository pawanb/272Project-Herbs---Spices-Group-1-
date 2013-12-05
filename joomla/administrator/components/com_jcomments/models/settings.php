<?php
/**
 * JComments - Joomla Comment System
 *
 * @version 3.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2013 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 */

defined('_JEXEC') or die;

jimport('joomla.filesystem.folder');

class JCommentsModelSettings extends JCommentsModelForm
{
	protected $context = null;

	public function __construct($config = array())
	{
		parent::__construct($config);

		if (empty($this->context)) {
			$this->context = strtolower($this->option . '.' . $this->getName());
		}
	}

	public function getItem($pk = null)
	{
		$language = $this->getState($this->getName() . '.language');

		$query = $this->_db->getQuery(true);
		$query->select("*");
		$query->from($this->_db->quoteName('#__jcomments_settings'));
		$query->where($this->_db->quoteName('component') . '=' . $this->_db->quote(''));
		$query->where($this->_db->quoteName('lang') . '=' . $this->_db->quote($language));

		$this->_db->setQuery($query);
		$params = $this->_db->loadObjectList();

		$item = new StdClass;

		if (is_array($params)) {
			$exclude = $this->getExclude();

			foreach ($params as $param) {
				$key = $param->name;
				$value = $param->value;

				if (!in_array($key, $exclude)) {
					$item->$key = $value;
				}
			}
		}

		return $item;
	}

	public function getExclude()
	{
		$keys = array('smilies', 'smilies_path', 'enable_geshi');

		return $keys;
	}

	public function getForm($data = array(), $loadData = true)
	{
		$form = $this->loadForm('com_jcomments.settings', 'settings', array('control' => 'jform',
																			'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		return $form;
	}

	protected function loadFormData()
	{
		$data = JFactory::getApplication()->getUserState('com_jcomments.edit.settings.data', array());

		if (empty($data)) {
			$data = $this->getItem();

			$parameters = array('notification_type', 'enable_categories');
			foreach ($parameters as $parameter) {
				if (isset($data->$parameter)) {
					$data->$parameter = explode(',', $data->$parameter);
				}
			}
		}

		return $data;
	}

	public function getTable($type = 'Settings', $prefix = 'JCommentsTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getLanguages()
	{
		$query = $this->_db->getQuery(true);

		$query->select('*');
		$query->from($this->_db->quoteName('#__languages'));
		$query->where($this->_db->quoteName('published') . '= 1');
		$this->_db->setQuery($query);

		$languages = $this->_db->loadObjectList();

		return is_array($languages) ? $languages : array();
	}

	public function getUserGroups()
	{
		$query = $this->_db->getQuery(true);
		$query->select('a.id AS value, a.title AS text, COUNT(DISTINCT b.id) AS level, a.parent_id')
			->from('#__usergroups AS a')
			->leftJoin($this->_db->quoteName('#__usergroups') . ' AS b ON a.lft > b.lft AND a.rgt < b.rgt')
			->group('a.id, a.title, a.lft, a.rgt, a.parent_id')
			->order('a.lft ASC');
		$this->_db->setQuery($query);
		$options = $this->_db->loadObjectList();

		return $options;
	}

	public function getPermissionForms()
	{
		JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
		JForm::addFieldPath(JPATH_COMPONENT . '/models/fields');

		$item = $this->getItem();
		$groups = $this->getUserGroups();
		$form = JForm::getInstance('jcomments.permissions', 'permissions', array('control' => ''), false, '/permissions');

		$parameters = array();
		foreach ($form->getFieldsets() as $fieldset) {
			foreach ($form->getFieldset($fieldset->name) as $field) {
				$name = $field->fieldname;
				$parameters[$name] = !empty($item->$name) ? explode(',', $item->$name) : array();
			}
		}

		$groupParameters = array();
		foreach ($groups as $group) {
			foreach ($parameters as $key => $values) {
				$groupParameters[$group->value][$key] = array('group' => $group->value,
															  'value' => in_array($group->value, $values) ? $group->value : null);
			}
		}

		$forms = array();
		foreach ($groups as $group) {
			$form = JForm::getInstance('jcomments.permissions.' . $group->value, 'permissions', array('control' => 'jform'), false, '/permissions');
			$form->bind($groupParameters[$group->value]);
			$forms[$group->value] = $form;
		}

		return $forms;
	}

	public function save($data)
	{
		$language = $this->getState($this->getName() . '.language');

		if (is_array($data)) {

			if (isset($data['forbidden_names'])) {
				$data['forbidden_names'] = preg_replace("#[\n|\r]+#", ',', $data['forbidden_names']);
				$data['forbidden_names'] = preg_replace("#,+#", ',', $data['forbidden_names']);
			}

			if (isset($data['badwords'])) {
				$data['badwords'] = preg_replace('#[\s|\,]+#i', "\n", $data['badwords']);
				$data['badwords'] = preg_replace('#[\n|\r]+#i', "\n", $data['badwords']);

				$data['badwords'] = preg_replace("#,+#", ',', preg_replace("#[\n|\r]+#", ',', $data['badwords']));
				$data['badwords'] = preg_replace("#,+#", ',', preg_replace("#[\n|\r]+#", ',', $data['badwords']));
			}

			if (!isset($data['comment_minlength'])) {
				$data['comment_minlength'] = 0;
			}

			if (!isset($data['comment_maxlength'])) {
				$data['comment_maxlength'] = 0;
			}

			if ($data['comment_minlength'] > $data['comment_maxlength']) {
				$data['comment_minlength'] = 0;
			}

			$query = $this->_db->getQuery(true);
			$query->select($this->_db->quoteName('name'));
			$query->from($this->_db->quoteName('#__jcomments_settings'));
			$query->where($this->_db->quoteName('component') . '=' . $this->_db->quote(''));
			$query->where($this->_db->quoteName('lang') . '=' . $this->_db->quote($language));

			$this->_db->setQuery($query);
			$params = $this->_db->loadColumn();

			$excludes = $this->getExclude();

			$config = JCommentsFactory::getConfig();

			foreach ($data as $key => $value) {
				if (!in_array($key, $excludes)) {

					if (is_array($value)) {
						if ($key == 'enable_categories') {
							if (in_array('*', $value, true)) {
								$value = array('*');
							}
						}
						$value = implode(',', $value);
					}

					if (get_magic_quotes_gpc()) {
						$value = stripslashes($value);
					}

					$value = trim($value);

					$config->set($key, $value);

					if (in_array($key, $params)) {
						$query = $this->_db->getQuery(true);
						$query->update($this->_db->quoteName('#__jcomments_settings'));
						$query->set($this->_db->quoteName('value') . '=' . $this->_db->quote($value));
						$query->where($this->_db->quoteName('component') . '=' . $this->_db->quote(''));
						$query->where($this->_db->quoteName('lang') . '=' . $this->_db->quote($language));
						$query->where($this->_db->quoteName('name') . '=' . $this->_db->quote($key));

						$this->_db->setQuery($query);
						$this->_db->execute();
					} else {
						$query = $this->_db->getQuery(true);
						$query->insert($this->_db->quoteName('#__jcomments_settings'));
						$query->set($this->_db->quoteName('value') . '=' . $this->_db->quote($value));
						$query->set($this->_db->quoteName('component') . '=' . $this->_db->quote(''));
						$query->set($this->_db->quoteName('lang') . '=' . $this->_db->quote($language));
						$query->set($this->_db->quoteName('name') . '=' . $this->_db->quote($key));

						$this->_db->setQuery($query);
						$this->_db->execute();
					}
				}
			}
		}

		return true;
	}

	public function reset()
	{
		return true;
	}

	protected function populateState($ordering = null, $direction = null)
	{
		$app = JFactory::getApplication('administrator');

		$language = $app->getUserStateFromRequest($this->context . '.language', 'language');
		$this->setState($this->getName() . '.language', $language);
	}
}