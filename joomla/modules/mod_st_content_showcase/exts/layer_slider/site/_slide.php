<?php if ($params->get('image', true)):?>
<div class="image">
	<a href="<?php echo $item->link;?>">
		<img src="<?php echo htmlspecialchars($item->image_intro); ?>"  alt="<?php echo htmlspecialchars($item->title); ?>"/>
	</a>
</div>
<?php endif; ?>
<?php if ($params->get('title') &&  $item->title != ''): ?>
	<h3 class="title">
	<?php if ($item->link != '') : ?>
	<a href="<?php echo $item->link;?>">
			<?php echo $item->title;?></a>
	<?php else : ?>
		<?php echo $item->title; ?>
	<?php endif; ?>
	</h3>
<?php endif ?>
<?php if ($params->get('introtext')): ?>
	<?php if($params->get('layer_slider_html')) { ?>
		<div class="content"><?php echo ($params->get('introtext_length') > 0) ? substr(strip_tags($item->introtext), 0 , $params->get('introtext_length')) : $item->introtext; ?></div>
	<?php } else { ?>
		<div class="content"><?php echo ($params->get('introtext_length') > 0) ? substr(strip_tags($item->introtext), 0 , $params->get('introtext_length')) : strip_tags($item->introtext); ?></div>
	<?php } ?>
<?php endif; ?>	