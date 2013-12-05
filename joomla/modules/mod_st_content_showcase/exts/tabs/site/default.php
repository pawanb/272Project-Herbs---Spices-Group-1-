<?php
/**
 * @copyright	submit-templates.com
 * @license		GNU General Public License version 2 or later;
 */

// no direct access
defined('_JEXEC') or die;

$id = uniqid();
$document = JFactory::getDocument();
$document->addScriptDeclaration('
	jQuery.noConflict();
	(function($){
		$(document).ready(function(){
			$(".st-content-tabs ul.nav li a:first").tab("show");	
		});
	})(jQuery);
');


?>
<div class="accordion st-content-tabs" id="<?php echo $id; ?>">
	<ul class="nav nav-tabs">
		<li><a href="#popular" data-toggle="tab">Popular</a></li>
		<li><a href="#latest" data-toggle="tab">Latest</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="popular">
			<?php foreach($list as $k => $item): ?>
			<div class="outter">
				<div class="row-fluid">
					<div class="span4">
						<a href="<?php echo $item->link;?>"><img src="<?php echo $item->image_intro; ?>"/></a>
					</div>
					<div class="span8">
						<a href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>