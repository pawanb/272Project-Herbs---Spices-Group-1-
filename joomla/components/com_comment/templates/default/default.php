<?php
/**
 * @package    Ccomment
 * @author     Daniel Dimitrov <daniel@compojoom.com>
 * @date       12.01.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

// Output the js localisation
ccommentHelperUtils::getJsLocalization();
$document = JFactory::getDocument();
$component = $this->component;
$count = $this->count;
$id = $this->contentId;
$user = JFactory::getUser();

// Tell google that it can crawl the page for ajax content only if we have comments
if ($count)
{
	$document->setMetaData('fragment', '!');
}

$htmlId = 'ccomment-' . str_replace('com_', '', $component) . '-' . $id;
$config = $this->config;
$avatar = '';

if ($config->get('template_params.form_avatar'))
{
	if ($user->guest)
	{
		$avatar = ccommentHelperAvatars::noAvatar();
	}
	else
	{
		$avatar = ccommentHelperAvatars::getUserAvatar($user->id, $config->get('integrations.support_avatars'));

		if ($avatar == '' && $config->get('integrations.gravatar'))
		{
			$avatar = ccommentHelperAvatars::getUserGravatar($user->email);
		}
	}
}

$userInfo = array(
	'loggedin' => !$user->guest,
	'avatar' => $avatar,
	'token' => JSession::getFormToken()
);

$pageItem = array('contentid' => (int) $id, 'component' => $component, 'count' => (int) $count);

JHtml::_('behavior.framework', true);

// Keep the session alive - the user is writing comments!!!
JHtml::_('behavior.keepalive');
JHtml::script('media/com_comment/js/libraries/requirejs/require.min.js');
JHtml::script('media/com_comment/js/dynamictextarea.js');
JHtml::script('media/com_comment/js/String.MD5.js');
JHtml::script('media/com_comment/js/String.UTF-8.js');
JHtml::script('media/com_comment/js/libraries/placeholder/placeholder.js');

if ($config->get('template_params.emulate_bootstrap', 1))
{
	JHtml::stylesheet('media/com_comment/templates/default/css/bootstrap.css');
}

JHtml::stylesheet('media/com_comment/templates/default/css/default.css');
// Ontouchstart -> makes sure that the device we are currently on support/doesn't support touch events
$document->addScriptDeclaration(
	"window.addEvent('domready', function() {
	if (!('ontouchstart' in document.documentElement)) {
	    document.documentElement.className += ' ccomment-no-touch';
	}
	var compojoom = window.compojoom = compojoom || {};
	compojoom.ccomment = {
			user: " . json_encode($userInfo) . ",
					item: " . json_encode($pageItem) . ",
					config: " . json_encode(ccommentHelperUtils::getJSConfig($component)) . "
				};
(function(window){
	'use strict';

	require.config({
			baseUrl: '" . JUri::base() . "',
			paths: {
				epitome: './media/com_comment/js/libraries/epitome',
				collections: './media/com_comment/js/collections',
				controllers: './media/com_comment/js/controllers',
				models: './media/com_comment/js/models',
				views: './media/com_comment/js/views/',
				mustache: './media/com_comment/js/libraries/mustache/mustache'
			}
		});

	require([
		'collections/comments',
		'views/comments-outer'
	], function(Comments, CommentsView){
		var comments = new Comments([]),
			hash = location.hash, startPage = 1, comment = 0, params = {};

		var cv = new CommentsView({
			collection: comments,
			element: '" . $htmlId . "'
		});

		if(hash.indexOf('#!/ccomment-page') === 0) {
			startPage = hash.replace('#!/ccomment-page=','');
			params = {start: startPage};
		}

		if(hash.indexOf('#!/ccomment-comment=') === 0) {
			comment = hash.replace('#!/ccomment-comment=','');
			params = {comment: comment};
		}

		comments.fetch(false, params);

	});

}(this))
});");

// Add the recaptcha js if we need it
if ($this->config->get('security.captcha') && $this->config->get('security.captcha_type') == 'recaptcha')
{
	$document->addScript('http://www.google.com/recaptcha/api/js/recaptcha_ajax.js');
}
?>
<div id="<?php echo $htmlId; ?>" class="ccomment row-fluid"></div>

<script type="text/template" id="ccomment-comment-template">
	<?php echo $this->loadTemplate('comment'); ?>
</script>

<script type="text/template" id="comment-outer-template">
	<ul class='ccomment-comments-list'>
		<?php if ($count) : ?>
			<li class="text-center"><?php echo JText::_('COM_COMMENT_LOADING_COMMENTS'); ?><span
					class="ccomment-loading"></span></li>
		<?php else : ?>
			<li class="ccomment-no-comments"><?php echo JText::_('COM_COMMENT_NO_COMMENTS_YET'); ?></li>
		<?php endif; ?>
	</ul>
</script>

<script type="text/template" id="ccomment-form-template">
	<?php echo $this->loadTemplate('form'); ?>
</script>

<script type="text/template" id="ccomment-menu-template">
	<?php echo $this->loadTemplate('menu'); ?>
</script>

<?php if ($this->config->get('layout.show_copyright', 1)) : ?>
	<script type="text/template" id="ccomment-footer-template">
		<?php echo $this->loadTemplate('footer'); ?>
	</script>
<?php endif; ?>

<div id="ccomment-token" style="display:none;">
	<?php echo JHtml::_('form.token'); ?>
</div>