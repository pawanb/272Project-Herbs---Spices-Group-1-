<?php
/**
 * @author     Daniel Dimitrov - compojoom.com
 * @date: 01.03.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');
$link = JUri::root() . 'index.php?option=com_comment&task=comment.gotocomment&id=' . $this->comment->id;
$unsubscribeLink = Juri::root() . 'index.php?option=com_comment&task=comment.unsubscribe&id=' . $this->comment->id . '&hash=' . $this->comment->unsubscribe_hash.'&mail='.$this->userToEmail;
?>

<p>
	<?php echo JText::sprintf('COM_COMMENT_NOTIFY_PUBLISH_MESSAGE_ON_SITE_USERS', Juri::root(), JFactory::getConfig()->get('sitename')) ?>
	<br/>
	<b>
		<?php echo JText::_('COM_COMMENT_NOTIFY_PUBLISH_MESSAGE_FROM'); ?>:
	</b>
	<?php echo $this->escape($this->comment->name); ?><br/>
	<b>
		<?php echo JText::_('COM_COMMENT_NOTIFY_PUBLISH_MESSAGE_TEXT'); ?>
	</b>
	<?php echo $this->escape($this->comment->comment); ?>
</p>
<p>
	<?php echo JText::sprintf('COM_COMMENT_NOTIFY_TO_VIEW_THE_COMMENT_CLICK_HERE', $link); ?>
</p>
<p>
	<?php echo JText::sprintf('COM_COMMENT_NOTIFY_UNSUBSCRIBE', $unsubscribeLink); ?>
</p>
<p>
	<?php echo JText::_('COM_COMMENT_NOTIFY_PUBLISH_MESSAGE_NOTICE'); ?>
</p>