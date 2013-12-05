<?php
/**
 * @package    - com_comment
 * @author     : DanielDimitrov - compojoom.com
 * @date: 16.04.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

$avatars = $this->config->get('integrations.support_avatars') || $this->config->get('integrations.gravatar');
$profiles = $this->config->get('integrations.support_profiles');

?>
<?php foreach ($this->comments as $comment) : ?>
	<div class="ccomment-comment-content" id="ccomment-<?php echo $comment->id; ?>">
		<div class="row-fluid">
			<?php if ($avatars) : ?>
				<div class="span1 hidden-phone">
					<div class="row-fluid">
						<?php if($profiles) : ?>
					<?php if($comment->profileLink) : ?>
						<a href='<?php echo $comment->profileLink; ?>' target="_blank">
							<?php endif; ?>
							<?php endif; ?>

							<img class="ccomment-avatar" src='<?php echo $comment->avatar; ?>' alt="avatar"/>

							<?php if($profiles) : ?>
							<?php if($comment->profileLink) : ?>
						</a>
					<?php endif; ?>
					<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
			<div>
				<div class="row-fluid">
					<?php if($profiles) : ?>
				<?php if($comment->profileLink) : ?>
					<a href='<?php echo $comment->profileLink; ?>' target="_blank">
						<?php endif; ?>
						<?php endif; ?>
						<strong>
							<?php if ($comment->name) : ?>
								<?php echo $comment->name; ?>
							<?php else : ?>
								<?php echo JText::_('COM_COMMENT_ANONYMOUS'); ?>
							<?php endif; ?>
						</strong>
						<?php if($profiles) : ?>
						<?php if($comment->profileLink) : ?>
					</a>
				<?php endif; ?>
				<?php endif; ?>
					<span class="muted small">
				<a href="#!/ccomment-comment=<?php echo $comment->id; ?>" class="muted">
					<?php echo $comment->date; ?>
				</a>
			</span>
				</div>
				<div class="row-fluid">
					<?php echo $comment->comment; ?>
				</div>
			</div>
		</div>
		<div class="row-fluid small">
			<div class="offset<?php echo ($avatars) ? 1 : 0; ?>">

				<?php if ($this->config->get('layout.voting_visible')) : ?>
					<span class="muted">
					<?php echo JText::_('COM_COMMENT_VOTES');?>:<?php echo $comment->votes; ?>
				</span>
				<?php endif; ?>

			</div>
		</div>
	</div>
<?php endforeach; ?>