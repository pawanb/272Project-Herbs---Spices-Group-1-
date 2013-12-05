<?php
/**
 * @copyright	submit-templates.com
 * @license		GNU General Public License version 2 or later;
 */

// no direct access

defined('_JEXEC') or die;
if ($params->get('wall_modal')) {
	JHTML::_('behavior.modal');
}

$document = JFactory::getDocument();
if (version_compare(JVERSION, '3.0.0', '<')) {
	$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js');	
}
$document->addScript("modules/mod_st_content_showcase/exts/wall/jquery.masonry.min.js");
$document->addStyleSheet("modules/mod_st_content_showcase/exts/wall/layout.css");
$document->addStyleSheet("modules/mod_st_content_showcase/exts/wall/styles/".$params->get('wall_style'));
$id = uniqid();
$document->addScriptDeclaration("
	jQuery.noConflict();
	(function($){
		var wallParams = ".$params->toString().";
		setCols = function (contain, containerWidth, cols) 
		{
			var widthWindow = $(window).width();
			
			if (widthWindow <= 320) {
				cols = wallParams.wall_grid_cols_320;
			} else if (widthWindow <= 480) {
				cols = wallParams.wall_grid_cols_480;
			} else if (widthWindow <= 767) {
				cols = wallParams.wall_grid_cols_767;
			}
			
			if (widthWindow <= 320) {
				itemWidth = containerWidth/wallParams.wall_grid_cols_320;
			} else if (widthWindow <= 480) {
				itemWidth = containerWidth/wallParams.wall_grid_cols_480;
			} else if (widthWindow <= 767){
				itemWidth = containerWidth/wallParams.wall_grid_cols_767;
			} else {
				itemWidth = containerWidth/cols;
			}
			
			$(contain + ' .item').each(function(el)
			{
				if (wallParams.wall_item_width == 'random') 
				{
					//random Item Cosl 1->12
					wallParams.wall_item_width = Math.floor(Math.random() * (12 - 1 + 1)) + 1;
					// Item Cols can not bigger grid cols
					(wallParams.wall_item_width > cols) ? wallParams.wall_item_width = cols : '';
					$(this).css('width', itemWidth * wallParams.wall_item_width);
				} 
				else 
				{
					$(this).css('width', itemWidth * wallParams.wall_item_width);
				}	
			});
			return cols;	
		}
		
		$(document).ready(function(){
			var wrapper = $('#".$id."');
			var contain = wrapper.find('.layout-wall');
			contain.imagesLoaded(function(){
				contain.masonry({
		        	itemSelector : '.item',
		        	isAnimated: true,
		        	isResizable: true,
					columnWidth: function( containerWidth ) {
						cols = setCols('#".$id."', containerWidth, wallParams.wall_grid_cols);
						return containerWidth /cols;
	  				}
		        });	
				
				$(window).resize(function(){
					contain.masonry('reload');
					setTimeout(function(){
						contain.css({'overflow' : 'visible'});	
					}, 1000);
				});	
			});
			
			// category
			wrapper.find('.category-wall span.all').addClass('current');
			wrapper.find('.category-wall span').each(function()
			{
				$(this).click(function()
				{	
					var className = $(this).attr('class');
					if (className == 'all') {
						className = 'item';
					}
					
					contain.find(' > div:not([class*=\"' + className + '\"])').removeClass('displayBlock').addClass('displayNone');
					contain.find(' > div[class*=\"' + className + '\"]').removeClass('displayNone').addClass('displayBlock');
				
					contain.masonry({
			        	itemSelector : '.' + className,
			        	isAnimated: true,
			        	isResizable: true,
						columnWidth: function( containerWidth ) {
							cols = setCols('#".$id."', containerWidth, wallParams.wall_grid_cols);
							return containerWidth /cols;
		  				}
			        });

					contain.masonry('reload');
					setTimeout(function(){
						contain.css({'overflow' : 'visible'});	
					}, 1000);
					wrapper.find('.category-wall span').removeClass('current');
					$(this).addClass('current');
				});
			});
		});	
	})(jQuery);
");






?>
<div class="st-content-showcase-wall <?php echo str_replace('.css', '', $params->get('wall_style', '')); ?>"  id="<?php echo $id; ?>">
<?php if ($params->get('wall_category') && count($categories)) :?>
	<div class="category-wall">
			<span class="all"><?php echo JText::_('ST_WALL_CATEGORY_ALL') ?></span>
		<?php foreach ($categories as $cate): ?>
			<?php $cate = ucfirst(basename($cate)); ?>
			<span class="<?php echo preg_replace('/[^a-zA-Z]/', 'a', strtolower($cate)); ?>"><?php echo $cate; ?></span>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
	<div class="layout-wall">
	
	<?php foreach ($list as $item) :?>
		<div class="item <?php echo (isset($item->category) ? preg_replace('/[^a-zA-Z]/', 'a', basename(strtolower($item->category))) : ''); ?>">
			<div class="inner">
				<?php  
				$classImage = '';
				if ($params->get('image', 1) && isset($item->image_intro) and !empty($item->image_intro)) : 
					$classImage = 'image';
				?>
					<?php if ($params->get('image_link', 1)): ?>
					<a <?php echo ($params->get('wall_modal', 1)) ? ' class="modal" rel="{handler: \'image\'}" ' : ''; ?>  href="<?php echo $item->image_large; ?>" title="<?php echo htmlspecialchars($item->title); ?>">
					<?php endif ?>
					<div class="media">
						<img src="<?php echo htmlspecialchars($item->image_intro); ?>"  alt="<?php echo htmlspecialchars($item->title); ?>"/>
					</div>
					<?php if ($params->get('image_link', 1)): ?>
					</a>
					<?php endif ?>	
				<?php endif; ?>
				
				<div class="info <?php echo $classImage; ?>">
					
					<?php if ($params->get('title', 1)): ?>
						<h3 class="title">
						<?php if ($params->get('title_link') && $item->link != '') : ?>
						<a href="<?php echo $item->link;?>">
								<?php echo $item->title;?></a>
						<?php else : ?>
							<?php echo $item->title; ?>
						<?php endif; ?>
						</h3>
					<?php endif ?>
					
					<?php if(isset($item->category) && $item->category != ''): ?>
						<div class="category">
							<?php echo $item->category; ?>
						</div>
					<?php endif; ?>
					
					<?php if ($params->get('introtext', 1)): ?>
						<div class="description"><?php echo ($params->get('introtext_length', 0) > 0) ? substr(strip_tags($item->introtext), 0 , $params->get('introtext_length')) : strip_tags($item->introtext); ?></div>
					<?php endif; ?>	
				</div>
			</div>
		</div>
	<?php endforeach; ?>
	</div>
</div>