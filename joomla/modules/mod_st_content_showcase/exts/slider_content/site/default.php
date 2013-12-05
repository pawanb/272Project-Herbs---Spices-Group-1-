<?php
	$doc = JFactory::getDocument();
	$doc->addStyleSheet(JURI::root().'modules/mod_st_content_showcase/exts/slider_content/assets/css/default.css');
	$doc->addScript(JURI::root().'modules/mod_st_content_showcase/exts/slider_content/assets/js/stslidercontent.js');
	$sliderID = "st-slider-content-". uniqid();
?>
<script type="text/javascript">
(function($){
	$(document).ready(function(){
		STContentShowcase.sliderContent({id: '<?php echo "#".$sliderID; ?>'});
	});
})(jQuery);
</script>
<div id="<?php echo $sliderID; ?>" class="st-slider-content">
	<div class="contain" style="width: <?php echo $params->get('slider_content_width'); ?>; height: <?php echo $params->get('slider_content_height'); ?>">
		<div class="slides active">
			<?php foreach ($list as $k => $item) :?>
				<?php 
					$width = 100 / $params->get('slider_content_cols');
				?>
				<div class="slide <?php echo ($k < $params->get('slider_content_cols')) ? 'display-block' : 'display-none'; ?>" style="width: <?php echo $width; ?>%;">
					<div class="inner clearfix">
						<?php if ($params->get('slider_content_image')): ?>
							<div class="image">
								<a href="<?php echo $item->link;?>">
									<img src="<?php echo htmlspecialchars($item->image_intro); ?>"  alt="<?php echo htmlspecialchars($item->title); ?>"/>
								</a>	
							</div>
						<?php endif; ?>
						<div class="detail">
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
						
						<?php
							if (isset($item->created) && $params->get('slider_content_date')) {
								echo '<div class="date">' . JHTML::_('date', $item->created, JText::_('DATE_FORMAT_LC2')) . '</div>';
							}
						?>
						
						<?php if ($params->get('introtext')): ?>
							<div class="content"><?php echo ($params->get('introtext_length') > 0) ? substr(strip_tags($item->introtext), 0 , $params->get('introtext_length')) : $item->introtext; ?></div>
						<?php endif; ?>	
						</div>
						<?php if ($item->link != '') : ?>
							<?php if ($params->get('slider_content_readmore') != ''): ?>
								<a class="readmore" href="<?php echo $item->link;?>"><?php echo $params->get('slider_content_readmore'); ?></a>	
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
				<?php  if ($k+1 < count($list) && ((($k + 1) % $params->get('slider_content_cols')) < 1)) {
					echo '</div><div class="slides">';				
				}?>
			<?php endforeach; ?>
		</div>
	</div>
	<?php $page = ceil(count($list) / $params->get('slider_content_cols')); ?>
	<?php if ($page > 1): ?>		
	<div class="nav">
		<?php for($i = 1; $i <= $page; $i++) { ?>
			<span <?php echo (($i == 1) ? 'class="active"' : ''); ?>></span>
		<?php }?>
	</div>
	<?php endif; ?>
</div>