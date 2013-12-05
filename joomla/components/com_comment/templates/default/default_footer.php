<?php
/**
 * @author Daniel Dimitrov - compojoom.com
 * @date: 11.04.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');
$user = JFactory::getUser();
$config = $this->config;
?>

<div class="row-fluid small muted ccomment-powered">
	<p class="text-center">
		<?php echo JText::sprintf('COM_COMMENT_POWERED_BY', 'http://compojoom.com'); ?>
	</p>
</div>