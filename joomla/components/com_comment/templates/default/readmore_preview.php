<?php
/**
 * @author Daniel Dimitrov - compojoom.com
 * @date: 11.04.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');
$previewLength = $this->config->get('template_params.preview_length', 80);
$dateFormat = $this->config->get('layout.date_format', 'age');
?>

<div class='ccomment-preview-container'>
	<?php foreach ($this->comments as $value) : ?>
		<?php
		if ($value->title != '') {
			$title = stripslashes($value->title);
		} else {
			$title = stripslashes($value->comment);
		}
		if (JString::strlen($title) > $previewLength) {
			$title = JString::substr($title, 0, $previewLength) . '...';
		}
		?>
		<div class='ccomment-preview'>
			<a href="<?php echo $this->link; ?>#!/ccomment-comment<?php echo $value->id; ?>">
				<?php echo ccommentHelperComment::getLocalDate($value->date, $dateFormat); ?>
				<b><?php echo $title; ?></b>
			</a>
		</div>
	<?php endforeach; ?>
</div>