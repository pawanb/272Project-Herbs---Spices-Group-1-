<?php
/**
 * @copyright	submit-templates.com
 * @license		GNU General Public License version 2 or later;
 */
if (count($list) < 3) {
	return;
}
?>
<div class="st-news-block">
	<div class="row-fluid">
		<div class="span8">
			<div class="intro">
			<?php $item = $list[0]; ?>
			<?php if ($item->link != '') : ?>
				<a href="<?php echo $item->link;?>">
					<img src="<?php echo htmlspecialchars($item->image_intro); ?>"  alt="<?php echo htmlspecialchars($item->title); ?>"/></a>
			<?php else : ?>
					<img src="<?php echo htmlspecialchars($item->image_intro); ?>"  alt="<?php echo htmlspecialchars($item->title); ?>"/>
			<?php endif; ?>
			
			<?php if (isset($item->author) || isset($item->publish_up) ): ?>
			<div class="article-info">
				<?php if (isset($item->author)): ?> 
					<span class="createdby">
						<?php echo $item->author; ?>
					</span>
				<?php endif; ?>
				<?php if (isset($item->publish_up)): ?>
					<span class="published"><?php echo JHtml::_('date', $item->publish_up, JText::_('DATE_FORMAT_LC3')); ?></span>
				<?php endif; ?>
			</div>
			<?php endif; ?>
			
			<?php if ($params->get('title')): ?>
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
				<p><?php echo ($params->get('introtext_length') > 0) ? substr(strip_tags($item->introtext), 0 , $params->get('introtext_length')) : strip_tags($item->introtext); ?></p>
			<?php endif; ?>	
			</div>
		</div>
		
		<div class="span4">
			<?php unset($list[0]); ?>
			<?php foreach ($list as $k => $item): ?>
				<?php if ($k == 3) break; ?>
				<div class="item">
					<?php if ($item->link != '') : ?>
						<a href="<?php echo $item->link;?>">
							<img src="<?php echo htmlspecialchars($item->image_intro); ?>"  alt="<?php echo htmlspecialchars($item->title); ?>"/></a>
					<?php else : ?>
							<img src="<?php echo htmlspecialchars($item->image_intro); ?>"  alt="<?php echo htmlspecialchars($item->title); ?>"/>
					<?php endif; ?>
					<div class="article-info"><span class="published"><?php echo JHtml::_('date', $item->publish_up, JText::_('DATE_FORMAT_LC3')); ?></span></div>
					<?php if ($params->get('title')): ?>
						<h2 class="title">
						<?php if ($item->link != '') : ?>
						<a href="<?php echo $item->link;?>">
								<?php echo $item->title;?></a>
						<?php else : ?>
							<?php echo $item->title; ?>
						<?php endif; ?>
						</h2>
					<?php endif ?>
				</div>
			<?php endforeach; ?>		
		</div>	
	</div>
</div>