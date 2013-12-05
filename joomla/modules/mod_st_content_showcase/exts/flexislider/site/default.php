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
$flex =  array();

foreach ($params->toArray() as $key => $value) 
{
	if (strpos($key, 'flex') !== false) {
		$flex[str_replace("flex_", '', $key)] = $value;
	}
}

$document = JFactory::getDocument();
$document->addScript('modules/'.ST_NAME.'/exts/flexislider/assets/jquery.flexslider.js');
$document->addScript('modules/'.ST_NAME.'/exts/flexislider/assets/jquery.mousewheel.js');
$document->addStyleSheet('modules/'.ST_NAME.'/exts/flexislider/assets/flexslider.css');
$document->addStyleSheet('modules/'.ST_NAME.'/exts/flexislider/styles/style.css');

$id = uniqid();
$document->addScriptDeclaration('
	jQuery.noConflict();
	(function($){
		$(window).load(function(){
			
			 $("#'.$id.'").flexslider('.json_encode($flex).');
		});
	})(jQuery);
');

?>
<div class="flexslider" style="<?php echo "width:".$params->get('flex_width'). "; margin: auto;"; ?>." id="<?php echo $id; ?>">
	<ul class="slides">
	<?php foreach ($list as $item) :?>
		<li>
			<?php if ($params->get('flex_modal', 0)): ?>
			<a class="modal" rel="{handler: 'image'}" href="<?php echo $item->image_large; ?>" title="<?php echo htmlspecialchars($item->title); ?>">
			<?php endif ?>
				<img src="<?php echo htmlspecialchars($item->image_intro); ?>"  alt="<?php echo htmlspecialchars($item->title); ?>"/>
				<?php if ($params->get('title', 1) && $item->title != ''): ?>
					<div class="flex-caption">
						<p class="title"><?php echo $item->title; ?></p>
						<p class="desc"><?php echo ($params->get('introtext_length') > 0) ? substr(strip_tags($item->introtext), 0 , $params->get('introtext_length')) : strip_tags($item->introtext); ?></p>	
					</div>
				<?php endif; ?>
			<?php if ($params->get('flex_modal', 0)): ?>
			</a>
			<?php endif ?>
		</li>
	<?php endforeach; ?>
	</ul>
</div>
