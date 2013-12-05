<?php
/**
 * @copyright	submit-templates.com
 * @license		GNU General Public License version 2 or later;
 */

// no direct access
defined('_JEXEC') or die;
$flex =  array();

foreach ($params->toArray() as $key => $value) 
{
	if (strpos($key, 'galleria') !== false) 
	{
		if ($value == 'false') {
			$value = false;
		}
		if($value == 'true') {
			$value = true;
		}
		$flex[str_replace("galleria_", '', $key)] = $value;
	}
}

$document = JFactory::getDocument();
$document->addScript('modules/mod_st_content_showcase/exts/galleria/assets/galleria-1.2.8.min.js');
$id = uniqid();
$document->addScriptDeclaration('
	jQuery.noConflict();
	(function($){
		$(window).load(function(){
			Galleria.loadTheme("'.JURI::root().'modules/'.ST_NAME.'/exts/galleria/assets/galleria.classic.js");
			
			Galleria.run("#'.$id.'", '.json_encode($flex).');
			
			// Galleria.run("#'.$id.'", {responsive: true, 
								// carousel: true, carouselSteps: 2, 
								// imageCrop: true, thumbnails: "empty",
								// swipe: true,
								// autoplay: 4000,
								// imagePan: true,
								// transition: "slide",
								// trueFullscreen: true,
								// fullscreenDoubleTap: true
								// });
								
			Galleria.on("loadfinish", function(){
				$(this._dom.container).parent().css("height", "auto");
			});
		});
	})(jQuery);
');
?>

<div class="st-galleria" style="width: 100%; height: 500px;" id="<?php echo $id; ?>">
	<div class="data-source">
		<?php foreach ($list as $item) :?>
			<img 
				src="<?php echo htmlspecialchars($item->image_intro); ?>"  
				alt="<?php echo htmlspecialchars($item->title); ?>"
				data-big="<?php echo htmlspecialchars($item->image_large); ?>"
				<?php if ((int)$params->get('introtext', 1) > 0 && $item->introtext != ''): ?>
			        data-title="<?php echo htmlspecialchars($item->title); ?>"
			        data-description="<?php echo htmlspecialchars(($params->get('introtext_length') > 0) ? substr(strip_tags($item->introtext), 0 , $params->get('introtext_length')) : strip_tags($item->introtext)); ?>"
	            <?php endif; ?>
	         />
		<?php endforeach; ?>
	</div>
</div>
