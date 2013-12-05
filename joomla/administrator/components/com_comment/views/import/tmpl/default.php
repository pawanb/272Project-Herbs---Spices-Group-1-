<?php
/***************************************************************
 *  Copyright notice
 *
 *  Copyright 2009 Daniel Dimitrov. (http://compojoom.com)
 *  All rights reserved
 *
 *  This script is part of the Compojoom Comment project. The Compojoom Comment project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

defined('_JEXEC') or die('Restricted access');
JToolBarHelper::title('Import comments');

?>
<h2><?php echo JText::_('COM_COMMENT_IMPORT'); ?></h2>
<form action='<?php echo JRoute::_('index.php?option=com_comment&task=import.from') ?>' method='post' name='adminForm'>
	<p>
		<?php echo JText::sprintf('COM_COMMENT_SELECT_IMPORT', 'https://compojoom.com/support/documentation/compojoom_comment'); ?>
	</p>
	<?php if (!CCOMMENT_PRO) : ?>
		<p class="alert alert-info">
			<?php echo JText::_('COM_COMMENT_PLEASE_NOTE'); ?>
			: <?php echo JText::sprintf('COM_COMMENT_PRO_NOTICE', 'https://compojoom.com/joomla-extensions/compojoomcomment'); ?>
		</p>
	<?php else: ?>
		<p class="alert alert-info">
			<?php echo JText::_('COM_COMMENT_IMPORTERS_DISABLED'); ?>
		</p>
	<?php endif; ?>
	<select name="import">
		<option value="general"><?php echo JText::_('COM_COMMENT_GENERAL_IMPORT'); ?></option>
		<?php if(CCOMMENT_PRO) : ?>
			<option value="komento" <?php echo ($this->components['komento']) ? '' : 'disabled'?>>
				Komento
			</option>
			<option value="jcomments" <?php echo ($this->components['jcomments']) ? '' : 'disabled'?>>
				JComments
			</option>
			<option value="disqus" <?php echo ($this->components['disqus']) ? '' : 'disabled'?>>
				Disqus
			</option>
		<?php else: ?>
			<option value="komento" disabled>
				Komento
			</option>
			<option value="jcomments" disabled>
				JComments
			</option>
			<option value="disqus" disabled>
				Disqus
			</option>
		<?php endif; ?>
	</select>

	<button class="btn btn-primary"><?php echo JText::_('COM_COMMENT_SUBMIT') ?></button>
	<?php echo JHtml::_('form.token');?>
</form>