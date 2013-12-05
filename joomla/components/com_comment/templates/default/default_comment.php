<?php
/**
 * @author     Daniel Dimitrov - compojoom.com
 * @date       : 11.04.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');
$avatars = $this->config->get('integrations.support_avatars') || $this->config->get('integrations.gravatar');
$profiles = $this->config->get('integrations.support_profiles');

$reply = false;
if ((int)$this->config->get('layout.tree') === 1)
{
	$reply = true;
}
else if ((int)$this->config->get('layout.tree') === 2)
{
	if (ccommentHelperSecurity::isModerator($this->contentId) && $this->allowedToPost)
	{
		$reply = true;
	}
}
?>
<div class="ccomment-comment-content" id="ccomment-{{id}}">
	<div class="row-fluid">
		<?php if ($avatars) : ?>
			<div class="span1 hidden-phone">
				<div class="row-fluid">
					<?php if ($profiles) : ?>
					{{#profileLink}}
					<a href='{{{profileLink}}}' target="_blank">
						{{/profileLink}}
						<?php endif; ?>
						<img class="ccomment-avatar" src='{{avatar}}' alt="avatar"/>
						<?php if ($profiles) : ?>
						{{#profileLink}}
					</a>
					{{/profileLink}}
				<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
		<div class="span<?php echo ($avatars) ? 11 : 12; ?>">
			<div class="row-fluid">
				<?php if ($profiles) : ?>
				{{#profileLink}}
				<a href='{{{profileLink}}}' target="_blank">
					{{/profileLink}}
					<?php endif; ?>
					<strong>
						{{#name}}
						{{&name}} {{&surname}}
						{{/name}}
						{{^name}}
						<?php echo JText::_('COM_COMMENT_ANONYMOUS'); ?>
						{{/name}}
					</strong>
					<?php if ($profiles) : ?>
					{{#profileLink}}
				</a>
				{{/profileLink}}
			<?php endif; ?>
				<span class="muted small">
				<a href="#!/ccomment-comment={{id}}" class="muted">
					{{date}}
				</a>
			</span>
			</div>
			<div class="row-fluid">
				{{{comment}}}
			</div>
		</div>
	</div>
	<div class="row-fluid small">
		<div class="offset<?php echo ($avatars) ? 1 : 0; ?>">

			<?php if ($this->config->get('layout.voting_visible')) : ?>
				<span class="muted">
					{{votes}}
					<i class="ccomment-thumbs-up ccomment-voting" data-vote="+1"></i>
					<i class="ccomment-thumbs-down ccomment-voting" data-vote="-1"></i>
				</span>
			<?php endif; ?>

			<?php if ($this->allowedToPost) : ?>
				<button class="btn btn-small ccomment-quote btn-link">
					<?php echo JText::_('COM_COMMENT_QUOTE'); ?>
				</button>
			<?php endif; ?>

			<?php if ($reply) : ?>
				<button class="btn btn-small ccomment-reply btn-link">
					<?php echo JText::_('COM_COMMENT_REPLY', true); ?>
				</button>
			<?php endif; ?>

			<div class="pull-right ccomment-moderation">
				{{#commentModerator}}
				<button class="btn btn-mini btn-ccomment-edit" data-action="unpublish">
					<?php echo JText::_('COM_COMMENT_EDIT'); ?>
				</button>
				{{/commentModerator}}

				<?php if (ccommentHelperSecurity::isModerator($this->contentId)) : ?>
					{{#published}}
					<button class="btn btn-mini btn-ccomment-unpublish btn-ccomment-change-state"
					        data-action="unpublish">
						<?php echo JText::_('COM_COMMENT_UNPUBLISH'); ?>
					</button>
					{{/published}}

					{{^published}}
					<button class="btn btn-mini btn-ccomment-publish btn-ccomment-change-state" data-action="publish">
						<?php echo JText::_('COM_COMMENT_PUBLISH'); ?>
					</button>
					{{/published}}

					<button class="btn btn-mini btn-ccomment-delete btn-ccomment-change-state"
					        data-action="delete"><?php echo JText::_('COM_COMMENT_DELETE'); ?></button>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
