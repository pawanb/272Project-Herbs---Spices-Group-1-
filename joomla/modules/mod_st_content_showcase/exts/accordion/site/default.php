<?php
/**
 * @copyright	submit-templates.com
 * @license		GNU General Public License version 2 or later;
 */

// no direct access
defined('_JEXEC') or die;

$id = uniqid();
$document = JFactory::getDocument();
$document->addStyleSheet('modules/mod_st_content_showcase/exts/accordion/assets/css/liteaccordion.css');
$document->addScript('modules/mod_st_content_showcase/exts/accordion/assets/js/liteaccordion.jquery.js');
$document->addScriptDeclaration('
	jQuery.noConflict();
	(function($){
		$(document).ready(function(){
			var stAcc'.$id.' = $("#'.$id.'");
			var option'.$id.' = {
				containerWidth : stAcc'.$id.'.parent().width(),
				autoPlay: true,
				pauseOnHover: true
			}
			stAccEl'.$id.' = stAcc'.$id.'.liteAccordion(option'.$id.');
			$(window).resize(function(){
				if(this.resizeTO) clearTimeout(this.resizeTO);
		        this.resizeTO = setTimeout(function() {
		        	stAccEl'.$id.'.liteAccordion("destroy");
					
		        	stAccEl'.$id.'.liteAccordion({
						containerWidth : stAcc'.$id.'.parent().width(),
						autoPlay: true,
						pauseOnHover: true
					});
		        }, 500);
			});
		});
	})(jQuery);
');
?>
<div class="st-accordion liteAccordion" id="<?php echo $id; ?>">
	<ol>
		<?php foreach ($categories as $id => $cate): ?>
		<li>
			<h2><span><?php echo ucfirst(basename($cate)); ?></span></h2>
			<div>
				<div class="inner">
					<?php $newrow = true; ?>
					<?php foreach($list as $k => $item): ?>
						<?php if ($id == $item->categoryid): ?>
						<?php
						if ($newrow) {
							echo '<div class="row-fluid items">';				
						}?>
						
						<div class="span<?php echo $params->get('accoridion_cols') ?>">
							<div class="item-inner">
								<?php if ($params->get('image')): ?>
									<div class="image">
										<a href="<?php echo $item->link;?>">
											<img src="<?php echo htmlspecialchars($item->image_intro); ?>"  alt="<?php echo htmlspecialchars($item->title); ?>"/>
										</a>	
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
									<div class="content"><?php echo ($params->get('introtext_length') > 0) ? substr(strip_tags($item->introtext), 0 , $params->get('introtext_length')) : $item->introtext; ?></div>
								<?php endif; ?>	
							</div>
						</div>
						
						<?php  if (($k + 1) % (12/$params->get('accoridion_cols')) < 1 || $k+1 == count($list)) {
							echo '</div>';
							$newrow = true;		
						} else {
							$newrow = false;
						}	
						?>
						<?php endif; ?>
					<?php endforeach; ?>
					
				</div>
			</div>
		</li>
		<?php endforeach; ?>
	</ol>
</div>