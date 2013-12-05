<?php
/**
 * @author     Daniel Dimitrov - compojoom.com
 * @date: 11.04.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');
$formAvatar = $this->config->get('template_params.form_avatar');
$user = JFactory::getUser();
JHtml::_('behavior.formvalidation');
?>

<?php if (!$this->discussionClosed) : ?>
	<?php if ($this->allowedToPost) : ?>
		<div class="ccomment-error-form row-fluid hide">
			<div class="alert alert-error">

			</div>
		</div>
		<div class="row-fluid margin-bottom">
		<?php if ($formAvatar) : ?>
			<div class="span1 hidden-phone">
				<img class="ccomment-avatar-form" src='{{user.getAvatar}}'/>
			</div>
		<?php endif; ?>
		<div class="<?php echo ($formAvatar) ? 'span11' : 'row-fluid'; ?>">

			<textarea name='comment' class='ccomment-textarea span12 required' cols='5' tabindex="5"
			          rows='10'
			          placeholder="<?php echo JText::_('COM_COMMENT_LEAVE_COMMENT'); ?>"
				></textarea>

			<?php if ($this->config->get('template_params.form_ubb')) : ?>
				<div class="ccomment-form-ubb">
					<?php if ($this->config->get('layout.support_emoticons')) : ?>
						<div class='ccomment-emoticons hide'>
							<?php foreach ($this->emoticons as $key => $value) : ?>
								<span data-open="<?php echo $key; ?>">
											<img src='<?php echo $value; ?>'
											     border='0'
											     alt='<?php echo $key; ?>'
											     title='<?php echo $key; ?>'
												/>
								</span>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<?php if ($this->config->get('layout.support_ubb') || $this->config->get('layout.support_emoticons')) : ?>
						<div class='ccomment-ubb-container'>
						<span class="ccomment-toggle-emoticons">
							<img src='<?php echo Juri::root(); ?>/media/com_comment/images/emoticon.png'
							     alt='emoticons'/>
						</span>
							<?php if ($this->config->get('layout.support_ubb')): ?>
								<span class="ccomment-ubb" data-open="[b]" data-close="[/b]">
									<img src='<?php echo Juri::root(); ?>media/com_comment/ubb/ubb_bold.gif' name='bb'
									     alt='[b]'/>
								</span>
								<span class="ccomment-ubb" data-open="[i]" data-close="[/i]">
									<img src='<?php echo Juri::root(); ?>media/com_comment/ubb/ubb_italicize.gif'
									     name='bi'
									     alt='[i]'/>
								</span>
								<span class="ccomment-ubb" data-open="[u]" data-close="[/u]">
									<img src='<?php echo Juri::root(); ?>media/com_comment/ubb/ubb_underline.gif'
									     name='bu'
									     alt='[u]'/>
								</span>
								<span class="ccomment-ubb" data-open="[s]" data-close="[/s]">
									<img src='<?php echo Juri::root(); ?>media/com_comment/ubb/ubb_strike.gif' name='bs'
									     alt='[s]'/>
								</span>
								<span class="ccomment-ubb" data-open="[url=" data-close="][/url]"
								      data-placeholder="Enter your title here">
									<img src='<?php echo Juri::root(); ?>media/com_comment/ubb/ubb_url.gif' name='burl'
									     alt='[url]'/>
								</span>
								<span class="ccomment-ubb" data-open="[quote]" data-close="[/quote]">
									<img src='<?php echo Juri::root(); ?>media/com_comment/ubb/ubb_quote.gif'
									     name='bquote'
									     alt='[quote]'/>
								</span>
								<span class="ccomment-ubb" data-open="[code]" data-close="[/code]">
									<img src='<?php echo Juri::root(); ?>media/com_comment/ubb/ubb_code.gif'
									     name='bcode'
									     alt='[code]'/>
								</span>
								<span class="ccomment-ubb" data-open="[img]" data-close="[/img]">
									<img src='<?php echo Juri::root(); ?>media/com_comment/ubb/ubb_image.gif'
									     name='bimg'
									     alt='[img]'/>
								</span>

								<select name='menuColor' class='select input-small'>
									<option><?php echo JText::_('COM_COMMENT_COLOR'); ?></option>
									<option data-open="[color=aqua]"
									        data-close="[/color]"><?php echo JText::_('COM_COMMENT_AQUA'); ?></option>
									<option data-open="[color=black]"
									        data-close="[/color]"><?php echo JText::_('COM_COMMENT_BLACK'); ?></option>
									<option data-open="[color=blue]"
									        data-close="[/color]"><?php echo JText::_('COM_COMMENT_BLUE'); ?></option>
									<option data-open="[color=fuchsia]"
									        data-close="[/color]"><?php echo JText::_('COM_COMMENT_FUCHSIA'); ?></option>
									<option data-open="[color=gray]"
									        data-close="[/color]"><?php echo JText::_('COM_COMMENT_GRAY'); ?></option>
									<option data-open="[color=green]"
									        data-close="[/color]"><?php echo JText::_('COM_COMMENT_GREEN'); ?></option>
									<option data-open="[color=lime]"
									        data-close="[/color]"><?php echo JText::_('COM_COMMENT_LIME'); ?></option>
									<option data-open="[color=maroon]"
									        data-close="[/color]"><?php echo JText::_('COM_COMMENT_MAROON'); ?></option>
									<option data-open="[color=navy]"
									        data-close="[/color]"><?php echo JText::_('COM_COMMENT_NAVY'); ?></option>
									<option data-open="[color=olive]"
									        data-close="[/color]"><?php echo JText::_('COM_COMMENT_OLIVE'); ?></option>
									<option data-open="[color=purple]"
									        data-close="[/color]"><?php echo JText::_('COM_COMMENT_PURPLE'); ?></option>
									<option data-open="[color=red]"
									        data-close="[/color]"><?php echo JText::_('COM_COMMENT_RED'); ?></option>
									<option data-open="[color=silver]"
									        data-close="[/color]"><?php echo JText::_('COM_COMMENT_SILVER'); ?></option>
									<option data-open="[color=teal]"
									        data-close="[/color]"><?php echo JText::_('COM_COMMENT_TEAL'); ?></option>
									<option data-open="[color=white]"
									        data-close="[/color]"><?php echo JText::_('COM_COMMENT_WHITE'); ?></option>
									<option data-open="[color=yellow]"
									        data-close="[/color]"><?php echo JText::_('COM_COMMENT_YELLOW'); ?></option>
								</select>
								<select name='menuSize' class='select input-small'>
									<option>-<?php echo JText::_('COM_COMMENT_SIZE'); ?>-</option>
									<option data-open="[size=10px]"
									        data-close="[/size]"><?php echo JText::_('COM_COMMENT_TINY'); ?></option>
									<option data-open="[size=12px]"
									        data-close="[/size]"><?php echo JText::_('COM_COMMENT_SMALL'); ?></option>
									<option data-open="[size=16px]"
									        data-close="[/size]"><?php echo JText::_('COM_COMMENT_MEDIUM'); ?></option>
									<option data-open="[size=20px]"
									        data-close="[/size]"><?php echo JText::_('COM_COMMENT_LARGE'); ?></option>
									<option data-open="[size=24px]"
									        data-close="[/size]"><?php echo JText::_('COM_COMMENT_HUGE'); ?></option>
								</select>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
		<div class="<?php echo ($formAvatar) ? 'offset1 span11' : 'row-fluid'; ?> ccomment-actions hide">
		<div class="span4 muted small">
		<?php echo JText::_('COM_COMMENT_POSTING_AS'); ?>
		<?php if ($user->guest) : ?>
			<button class="btn-link btn-small ccomment-posting-as">{{user.getDefaultName}}</button>
		<?php else : ?>
			<span class="ccomment-posting-as">
			<?php if ($this->config->get('layout.use_name', 1)) : ?>
				<?php echo $user->name; ?>
			<?php else : ?>
				<?php echo $user->username; ?>
			<?php endif; ?>
		</span>
		<!--					<button class="btn-link btn-mini ccomment-not-you">(--><?php //echo JText::_('COM_COMMENT_NOT_YOU'); ?><!--)</button>-->
	<?php endif; ?>
	</div>
	<?php if ($this->config->get('template_params.notify_users')) : ?>
		<label class="checkbox pull-right small ccomment-notify">
			<input type="checkbox" value="1" {{#user.notify}}checked="checked"{{/user.notify}} name="notify"
			name="ccomment-notify" />
					<span class="muted">
						<?php echo JText::_('COM_COMMENT_NOTIFY_FOLLOW_UP_EMAILS') ?>
					</span>
		</label>
	<?php endif; ?>
	</div>
	</div>
	<?php if ($this->config->get('security.captcha') && ccommentHelperSecurity::groupHasAccess($user->getAuthorisedGroups(), $this->config->get('security.captcha_usertypes'))) : ?>
		<div class="<?php echo ($formAvatar) ? 'offset1 span11' : 'row-fluid'; ?> ccomment-actions hide">
			<div class='muted small'>
				<?php if ($this->config->get('security.captcha_type') == "recaptcha") : ?>
					<div class="ccomment-recaptcha-placeholder">

					</div>
				<?php else : ?>
					<div>
						<?php echo JText::_('COM_COMMENT_FORMVALIDATE_CAPTCHATXT'); ?>
					</div>
					<div class="ccomment-captcha">
						<?php echo ccommentHelperCaptcha::insertCaptcha('security_refid', $this->config->get('security.captcha_type'), $this->config->get('security.recaptcha_public_key')); ?>
						<input type='text' name='security_try' id='security_try' maxlength='5'
						       tabindex='7' class='ccomment-captcha-input required'/>
					</div>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if (!$user->get('id')) : ?>
		<div class="row-fluid ccomment-user-info hide offset<?php echo ($formAvatar) ? 1 : 0; ?>
					<?php echo ($formAvatar) ? 'span11' : ''; ?>">
			<div class="span6">
				<input name='name'
				       class="ccomment-name span12 no-margin <?php echo $this->config->get('template_params.required_user', 0) ? 'required' : ''; ?>"
				       type='text'
				       value='{{user.getName}}'
				       placeholder="<?php echo JText::_('COM_COMMENT_ENTER_YOUR_NAME'); ?><?php echo $this->config->get('template_params.required_user', 0) ? '*' : ''; ?>"
				       tabindex="1"
					<?php if ($user->id) : ?> disabled="disabled" <?php endif; ?>
					/>
				<span class="help-block pull-right small muted">
					<?php echo JText::_('COM_COMMENT_DISPLAYED_NEXT_TO_YOUR_COMMENTS'); ?>
				</span>
			</div>

			<?php if ($this->config->get('template_params.notify_users')) : ?>
				<div class="span6">
					<input name='email'
					       class="ccomment-email span12 no-margin <?php echo $this->config->get('template_params.required_email', 0) ? 'required' : ''; ?>"
					       type='text'
					       value='{{user.getEmail}}'
					placeholder="<?php echo JText::_('COM_COMMENT_ENTER_YOUR_EMAIL'); ?><?php echo $this->config->get('template_params.required_email', 0) ? '*' : ''; ?>"
					tabindex="2"
					<?php if ($user->id) : ?> disabled="disabled" <?php endif; ?>
					/>
					<p class="help-block small pull-right muted">
						<?php echo JText::_('COM_COMMENT_NOT_DISPLAYED_PUBLICLY'); ?>
						<?php if ($this->config->get('integrations.gravatar')) : ?>
							<span class='gravatar'>
								<?php echo JText::_('COM_COMMENT_GRAVATAR_ENABLED'); ?>
							</span>
						<?php endif; ?>
					</p>
				</div>
			<?php endif; ?>
		</div>
	<?php else : ?>

	<?php endif; ?>
	<div class="row-fluid ccomment-actions hide">
		<?php if (!$this->config->get('security.auto_publish')) : ?>
			<div class="pull-left muted small ccomment-undergo-moderation offset<?php echo ($formAvatar) ? 1 : 0; ?>">
				<?php echo JText::_('COM_COMMENT_COMMENTS_UNDERGO_MODERATION'); ?>
			</div>
		<?php endif; ?>
		<div class="pull-right">
			<button class="btn ccomment-cancel"><?php echo JText::_('COM_COMMENT_CANCEL'); ?></button>
			<button type='submit' class='btn btn-primary ccomment-send'
			        data-message-enabled="<?php echo Jtext::_('COM_COMMENT_SENDFORM'); ?>"
			        data-message-disabled="<?php echo JText::_('COM_COMMENT_SAVING'); ?>" tabindex="7" name='bsend'>
				<?php echo JText::_('COM_COMMENT_SENDFORM'); ?>
			</button>
		</div>
	</div>

	<input type="hidden" name="contentid" value="{{info.contentid}}"/>
	<input type="hidden" name="component" value="{{info.component}}"/>

<?php else : ?>
	<div class="ccomment-not-authorised">
		<h5><?php echo JText::_('COM_COMMENT_NOT_AUTHORISED_TO_POST_COMMENTS') ?></h5>

		<p class="muted small">
			<?php if (!$this->config->get('security.auto_publish')) : ?>
				<?php echo JText::_('COM_COMMENT_COMMENTS_UNDERGO_MODERATION'); ?>
			<?php endif; ?>
		</p>
	</div>
<?php endif; ?>
<?php else : ?>
<div class="ccomment-comments-disabled alert alert-info">
	<?php echo JText::_('COM_COMMENT_DISABLEADDITIONALCOMMENTS') ?>
</div>
<?php endif; ?>

