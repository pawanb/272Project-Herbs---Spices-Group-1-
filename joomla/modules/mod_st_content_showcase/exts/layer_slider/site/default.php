<?php
/**
 * @copyright	submit-templates.com
 * @license		GNU General Public License version 2 or later;
 */

// no direct access
defined('_JEXEC') or die;
$layerOptions =  array();

foreach ($params->toArray() as $key => $value) 
{
	if (strpos($key, 'layer_slider') !== false) 
	{
		if ($value == 'false') {
			$value = false;
		}
		if($value == 'true') {
			$value = true;
		}
		$layerOptions[str_replace("layer_slider_", '', $key)] = $value;
	}
}
$id = uniqid();
$document = JFactory::getDocument();
$document->addStyleSheet('modules/mod_st_content_showcase/exts/layer_slider/assets/css/style.css');
$document->addStyleSheet('modules/mod_st_content_showcase/exts/layer_slider/assets/css/'.str_replace('.php', '', $params->get('layer_slider_layout',  '_slide.php')).'/style.css');
$document->addStyleSheet('modules/mod_st_content_showcase/exts/layer_slider/assets/effects/'.$params->get('layer_slider_effects', 'default').'/style.css');
$document->addScript('modules/mod_st_content_showcase/exts/layer_slider/assets/js/jquery.sequence.js');
$document->addScriptDeclaration('
	jQuery.noConflict();
	(function($){
		$(document).ready(function(){
			var layerOptions = '.json_encode($layerOptions).';
			
			if (layerOptions.nav) {
				layerOptions.nextButton = "#'.$id.' .sequence-next";
				layerOptions.prevButton = "#'.$id.' .sequence-prev";
			}
			
			//layerOptions.preventDelayWhenReversingAnimations = true;
			//layerOptions.transitionThreshold = 3000;
				
			if (layerOptions.pagination) { layerOptions.pagination = "#'.$id.' .sequence-pagination" }
			var options'.$id.' = layerOptions;
	    
	    	var mySequence'.$id.' = $("#'.$id.'").sequence(options'.$id.').data("sequence");
		});
	})(jQuery);
');
?>
<?php 
	$leftPos = $colWidth = 100 / $params->get('layer_slider_cols');
	$class = ($layerOptions['pagination']) ? ' no-pagination ' : '';
	$class .= ' layer_layout'.str_replace('.php', '', $params->get('layer_slider_layout',  '_slide.php'));
	$class .= ' layer-effect-'.$params->get('layer_slider_effects', 'default');
?>
<div class="st-layer-slider <?php echo $class; ?>" style="width: <?php echo $params->get('layer_slider_width'); ?>; height: <?php echo $params->get('layer_slider_height');?>;" id="<?php echo $id; ?>">
	<?php if ($layerOptions['nav']):?>
	<div class="sequence-prev" /></div>
	<div class="sequence-next" /></div>
	<?php endif; ?>
	<?php if ($layerOptions['pagination']): ?>
	<ul class="sequence-pagination">
		<?php foreach ($list as $key => $item) :?>
		<?php if (($key+1) % $params->get('layer_slider_cols') < 1 || ($key + 1 == count($list))): ?>
			<li><span></span></li>
		<?php endif; ?>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>
	<ul class="sequence-canvas">
		<?php  $colIndex = 0; ?>
		<?php foreach ($list as $key => $item) :?>
			<?php if($colIndex < 1): ?>
			<li >
			<?php endif;?>
				<div class="column" style="width: <?php echo $colWidth; ?>%; left: <?php echo $colIndex * $colWidth; ?>%;">
					<div class="column-inner">
						<?php require $params->get('layer_slider_layout', '_slide.php'); ?>		
					</div>
				</div>
			<?php if (($key+1) % $params->get('layer_slider_cols') < 1 || ($key + 1 == count($list))) { ?>
				</li>
			<?php 
				$colIndex = 0;
			} else {
			 	$colIndex++;
			 }?>
		<?php endforeach; ?>
	</ul>
</div>
