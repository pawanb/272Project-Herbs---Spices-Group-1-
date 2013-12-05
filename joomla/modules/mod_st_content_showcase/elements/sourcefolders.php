<?php

defined('_JEXEC') or die( 'Restricted access' );

class JFormFieldSourceFolders extends JFormFieldFolderList
{
    public $type = 'SourceFolders';

	/**
	 * Method to get the field options.
	 *
	 * @return  array  The field option objects.
	 *
	 * @since   11.1
	 */
	protected function getOptions()
	{
		// Initialize variables.
		$options = array();

		// Initialize some field attributes.
		$filter = (string) $this->element['filter'];
		$exclude = (string) $this->element['exclude'];
		$hideNone = (string) $this->element['hide_none'];
		$hideDefault = (string) $this->element['hide_default'];

		// Get the path in which to search for file options.
		$path = (string) $this->element['directory'];
		if (!is_dir($path))
		{
			$path = JPATH_ROOT . '/' . $path;
		}

		// Prepend some default options based on field attributes.
		if (!$hideNone)
		{
			$options[] = JHtml::_('select.option', '-1', JText::alt('JOPTION_DO_NOT_USE', preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname)));
		}
		if (!$hideDefault)
		{
			$options[] = JHtml::_('select.option', '', JText::alt('JOPTION_USE_DEFAULT', preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname)));
		}

		// Get a list of folders in the search path with the given filter.
		$folders = JFolder::folders($path, $filter);

		// Build the options list from the list of folders.
		if (is_array($folders))
		{
			foreach ($folders as $folder)
			{
				if ($folder == 'article') $folder = 'content';
				if (is_dir(JPATH_ROOT. '/administrator/components/com_'.strtolower($folder))) 
				{
					if ($folder == 'content') $folder = 'article';
					if (is_dir(JPATH_ROOT. '/modules/'.ST_NAME.'/models/'.strtolower($folder))) 
					{
						// Check to see if the file is in the exclude mask.
						if ($exclude)
						{
							if (preg_match(chr(1) . $exclude . chr(1), $folder))
							{
								continue;
							}
						}
		
						$options[] = JHtml::_('select.option', $folder, $folder);
					}
				}
			}
		}
		$options[] = JHtml::_('select.option', 'folder', 'Image Folder');
		return $options;
	}
}

?>