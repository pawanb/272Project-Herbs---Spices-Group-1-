<?php
/**
 * @author Daniel Dimitrov - compojoom.com
 * @date: 01.03.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */
 
defined('_JEXEC') or die('Restricted access');
$link = JUri::root() . 'index.php?option=com_comment&task=comment.gotocomment&id='.$this->comment->id
?>
unpublish user
<p>
<?php echo JText::sprintf('COM_COMMENT_NOTIFY_PUBLISH_MESSAGE_ON_SITE', Juri::root(), JFactory::getConfig()->get('sitename')) ?> <br />
	<b>
		<?php echo JText::_('COM_COMMENT_NOTIFY_PUBLISH_MESSAGE_FROM'); ?>:
	</b>
	<?php echo $this->escape($this->comment->name); ?><br />
	<b>
		<?php echo JText::_('COM_COMMENT_NOTIFY_PUBLISH_MESSAGE_TEXT'); ?>
	</b>
	<?php echo $this->escape($this->comment->comment); ?>
	<br />
<?php echo JText::sprintf('COM_COMMENT_NOTIFY_PUBLISH_MESSAGE_CONTENT_ITEM', $link, $link); ?>
	<br />
<?php echo JText::_('COM_COMMENT_NOTIFY_PUBLISH_MESSAGE_NOTICE'); ?>
</p>