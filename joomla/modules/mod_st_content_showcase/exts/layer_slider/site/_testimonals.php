<?php if ($params->get('introtext')): ?>
	<div class="content">
		<div class="content-inner">
			<?php echo ($params->get('introtext_length') > 0) ? substr(strip_tags($item->introtext), 0 , $params->get('introtext_length')) : $item->introtext; ?>
		</div>
	</div>
<?php endif; ?>
<div class="row-fluid">
		<div class="image">
			<?php if ($params->get('title_link', false) && $item->link != '') : ?>
			<a href="<?php echo $item->link;?>">
			<?php endif; ?>
				<img src="<?php echo htmlspecialchars($item->image_intro); ?>"  alt="<?php echo htmlspecialchars($item->title); ?>"/>
			<?php if ($params->get('title_link', false) && $item->link != '') : ?>
			</a>
			<?php endif; ?>	
		</div>		
	
		<?php if ($params->get('title') &&  $item->title != ''): ?>
			<h3 class="title">
			<?php if ($params->get('title_link', false) && $item->link != '') : ?>
			<a href="<?php echo $item->link;?>">
					<?php echo $item->title;?></a>
			<?php else : ?>
				<?php echo $item->title; ?>
			<?php endif; ?>
			</h3>
		<?php endif ?>		
</div>

	