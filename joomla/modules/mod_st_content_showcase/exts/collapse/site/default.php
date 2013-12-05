<?php
/**
 * @copyright	beautiful-templates.com
 * @license		GNU General Public License version 2 or later;
 */

// no direct access
defined('_JEXEC') or die;

$id = uniqid();
$document = JFactory::getDocument();
$document->addStyleSheet('modules/mod_st_content_showcase/exts/collapse/assets/css/collapse.css');
$document->addScriptDeclaration('
	jQuery.noConflict();
	(function($){
		$(document).ready(function(){
			$(".collapse").collapse();
			$("body").on("click.collapse.data-api", "[data-toggle=collapse]", function(){
				if ($($(this).attr("href")).hasClass("in")) {
					$(this).parent().addClass("active").removeClass("disable");
				} else {
					$(this).parent().addClass("disable").removeClass("active");
				}
			});
		});
	})(jQuery);
');
?>
<div class="accordion st-collapse" id="<?php echo $id; ?>">
	<?php foreach($list as $k => $item): ?>
	<div class="accordion-group">
    	<div class="accordion-heading">
      		<a class="accordion-toggle" data-toggle="collapse" data-parent="#<?php echo $id; ?>" href="#collapse-<?php echo $id. '-'. $k; ?>">
        		<?php echo $item->title;?>
      		</a>
    	</div>
	    <div id="collapse-<?php echo $id. '-'. $k; ?>" class="accordion-body collapse in">
	      	<div class="accordion-inner">
	        	<div class="content"><?php echo ($params->get('introtext_length') > 0) ? substr(strip_tags($item->introtext), 0 , $params->get('introtext_length')) : $item->introtext; ?></div>
	      	</div>
	    </div>
  	</div>
  	<?php endforeach; ?>
</div>