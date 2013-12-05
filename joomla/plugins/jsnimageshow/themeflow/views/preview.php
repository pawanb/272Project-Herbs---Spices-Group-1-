<?php
/**
 * @version     $Id$
 * @package     JSN.ImageShow
 * @subpackage  JSN.ThemeCarousel
 * @author      JoomlaShine Team <support@joomlashine.com>
 * @copyright   Copyright (C) 2012 JoomlaShine.com. All Rights Reserved.
 * @license     GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.joomlashine.com
 * Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 */
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.plugin.plugin' );
$path = JURI::root() . 'plugins/jsnimageshow/themeflow/assets';
?>
<style>
#coverflow img.left-orient{
	-webkit-transform: matrix(1, -0.2, 0, 1, 0, 0) scale(1);
	-moz-transform: matrix(1, -0.2, 0, 1, 0, 0) scale(1);
	-o-transform: matrix(1, -0.2, 0, 1, 0, 0) scale(1);
}
#coverflow img{
	-webkit-transform: matrix(1, 0, 0, 1, 0, 0) scale(1.29);
	-moz-transform: matrix(1, 0, 0, 1, 0, 0) scale(1.29);
	-o-transform: matrix(1, 0, 0, 1, 0, 0) scale(1.29);
}
#coverflow img.right-orient{
	-webkit-transform: matrix(1, 0.2, 0, 1, 0, 0) scale(1);
	-moz-transform: matrix(1, 0.2, 0, 1, 0, 0) scale(1);
	-o-transform: matrix(1, 0.2, 0, 1, 0, 0) scale(1);
}
#jsn-themeflow-container .wrapper{
	border: 2px solid transparent;
}
#imageCaption{
	border: 2px solid transparent;
}
</style>
<div id="jsn-themeflow-container" class="jsn-themeflow-container">
	<div class="demo">
		<div class="wrapper">
			<div id="coverflow">
	            <img class="left-orient" style="position: relative;left:-95px;z-index: 9;" src="<?php echo $path ?>/images/thumb/thumb-01.jpg" />
				<img class="left-orient" style="position: relative;left:-190px;z-index: 10;" src="<?php echo $path ?>/images/thumb/thumb-02.jpg" />	
				<img style="position: relative;left:-190px;z-index: 12;" src="<?php echo $path ?>/images/thumb/thumb-04.jpg" />
				<img class="right-orient" style="position: relative;left:-190px;z-index: 11;" src="<?php echo $path ?>/images/thumb/thumb-05.jpg" />
				<img class="right-orient" style="position: relative;left:-285px;z-index: 10;" src="<?php echo $path ?>/images/thumb/thumb-06.jpg" />
			</div>
			<div class="flow-left"></div>
			<div class="flow-right"></div>
		</div>
	</div>
</div>