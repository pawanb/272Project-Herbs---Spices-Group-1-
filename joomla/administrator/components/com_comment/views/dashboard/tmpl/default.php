<?php

/**
 * @author     Daniel Dimitrov - compojoom.com
 * @date: 02.04.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */


defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');

JToolbarHelper::title(JText::_('COM_COMMENT_DASHBOARD'));
if (!version_compare(JVERSION, '3.0', 'gt'))
{
	JHtml::stylesheet('media/com_comment/backend/css/bootstrap.css');
	JHtml::stylesheet('media/com_comment/backend/css/strapper.css');
}
JHtml::stylesheet('media/com_comment/backend/css/dashboard.css');
JHtml::script('https://www.google.com/jsapi');
?>

<div class="compojoom-bootstrap">
	<div class="row-fluid">
		<div class="span6">
			<div class="row-fluid">
				<h5><?php echo JText::_('COM_COMMENT_USER_ENGAGEMENT'); ?></h5>
			</div>
			<div class="row-fluid" id="activity-chart">
				<?php if (count($this->statsArray) == 1) : ?>
					<span class="ccomment-no-stats">
					<?php echo JText::_('COM_COMMENT_NO_DATA_FOR_LAST_30_DAYS'); ?>
					</span>
				<?php endif; ?>
			</div>
		</div>
		<div class="span6">
			<h5><?php echo JText::sprintf('COM_COMMENT_LATEST_X_COMMENTS', 5); ?></h5>
			<?php if ($this->latest) : ?>
				<table class="table">
					<tr>
						<th><?php echo JText::_('COM_COMMENT_COMMENT_TITLE_TH'); ?></th>
						<th><?php echo JText::_('COM_COMMENT_DATE'); ?></th>
						<th><?php echo JText::_('COM_COMMENT_PUBLISH'); ?></th>
						<th><?php echo JText::_('COM_COMMENT_ACTION'); ?></th>
					</tr>
					<?php foreach ($this->latest as $item): ?>
						<tr>
							<td>
								<?php echo JString::substr($this->escape($item->comment), 0, 140); ?>
							</td>
							<td>
								<?php echo $item->date; ?>
							</td>
							<td>
								<?php echo JText::_(($item->published ? 'JYES' : 'JNO'));  ?>
							</td>
							<td>
								<a href="<?php echo JRoute::_('index.php?option=com_comment&task=comment.edit&id=' . $item->id); ?>">Edit</a>
							</td>
						</tr>
					<?php endforeach; ?>
				</table>
			<?php else: ?>
				<span class="ccomment-no-stats"><?php echo JText::_('COM_COMMENT_NO_COMMENTS'); ?></span>
			<?php endif; ?>
		</div>
	</div>
	<div class="fluid-row">
		<p>
			<?php echo JText::sprintf('COM_COMMENT_LANGUAGE_PACK', 'https://compojoom.com/downloads/languages-cool-geil/ccomment'); ?>
		</p>
		<strong>
			CComment <?php echo CCOMMENT_PRO ? 'PRO' : 'Core'; ?>
			<?php echo ccommentHelperComponents::getComponentVersion('com_comment')->get('version'); ?></strong>
		<br>
	<span style="font-size: x-small">
		Copyright &copy;2008&ndash;<?php echo date('Y'); ?> Daniel Dimitrov / compojoom.com
	</span>
		<br>

		<?php if (CCOMMENT_PRO) : ?>
			<strong>
				If you use CComment PRO, please post a rating and a review at the
				<a href="http://extensions.joomla.org/extensions/contacts-and-feedback/articles-comments/12259"
				   target="_blank">Joomla! Extensions Directory</a>.
			</strong>
		<?php endif; ?>
		<br>

	<span style="font-size: x-small">
		CComment is Free software released under the
		<a href="www.gnu.org/licenses/gpl.html">GNU General Public License,</a>
		version 2 of the license or &ndash;at your option&ndash; any later version
		published by the Free Software Foundation.
	</span>

		<div>
			<div class="row-fluid">
				<strong><?php echo JText::_('COM_COMMENT_LATEST_NEWS_PROMOTIONS'); ?>:</strong>
			</div>
			<div class="row-fluid">
				<div class="span3">
					<?php echo JText::_('COM_COMMENT_LIKE_FB'); ?><br/>
					<iframe
						src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fcompojoom&amp;width=292&amp;height=62&amp;show_faces=false&amp;colorscheme=light&amp;stream=false&amp;border_color&amp;header=false&amp;appId=545781062132616"
						scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:292px; height:62px;"
						allowTransparency="true"></iframe>
				</div>
				<div class="span3">
					<?php echo JText::_('COM_COMMENT_FOLLOW_TWITTER'); ?><br /><br />
					<a href="https://twitter.com/compojoom" class="twitter-follow-button" data-show-count="false">Follow @compojoom</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				</div>
			</div>
		</div>
	</div>

<?php if (count($this->statsArray) > 1) : ?>
	<script type="text/javascript">
		google.load("visualization", "1", {packages: ["corechart"]});
		google.setOnLoadCallback(drawChart);
		function drawChart() {
			var data = google.visualization.arrayToDataTable(
				<?php echo json_encode($this->statsArray); ?>
			);

			var options = {
				vAxis: {title: '<?php echo JText::_('COM_COMMENT_COMMENTS'); ?>', titleTextStyle: {color: 'red'}}
			};

			var chart = new google.visualization.ColumnChart(document.getElementById('activity-chart'));
			chart.draw(data, options);
		}

	</script>
<?php endif; ?>