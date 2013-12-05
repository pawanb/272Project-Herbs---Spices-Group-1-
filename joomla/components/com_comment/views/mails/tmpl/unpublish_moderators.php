<?php
/**
 * @author Daniel Dimitrov - compojoom.com
 * @date: 01.03.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */
 
defined('_JEXEC') or die('Restricted access');
$link = JUri::root() . 'index.php?option=com_comment&task=comment.gotocomment&id='.$this->comment->id;
$publishLink = Juri::root() . 'index.php?option=com_comment&task=comment.publish&id='.$this->comment->id . '&mail=' . $this->userToEmail . '&hash='.$this->comment->moderate_hash.'&type=1';

?>

<p>
<?php echo JText::sprintf('COM_COMMENT_NOTIFY_UNPUBLISHED_MESSAGE_ON_SITE_MODERATOR', Juri::root(), JFactory::getConfig()->get('sitename')) ?>
</p>
<p>
	<b>
		<?php echo JText::_('COM_COMMENT_NOTIFY_PUBLISH_MESSAGE_FROM'); ?>:
	</b>
	<?php echo $this->escape($this->comment->name); ?><br />
	<b>
		<?php echo JText::_('COM_COMMENT_NOTIFY_PUBLISH_MESSAGE_TEXT'); ?>
	</b>
	<?php echo $this->escape($this->comment->comment); ?>
</p>

<p>
	<?php echo JText::sprintf('COM_COMMENT_NOTIFY_TO_VIEW_THE_COMMENT_CLICK_HERE_UNPUBLISHED_COMMENT', $link); ?>
</p>
<p>
	<?php echo JText::sprintf('COM_COMMENT_PUBLISH_COMMENT_MODERATOR_EMAIL', $publishLink); ?>
</p>
<p>
<?php echo JText::_('COM_COMMENT_NOTIFY_PUBLISH_MESSAGE_NOTICE'); ?>
</p>