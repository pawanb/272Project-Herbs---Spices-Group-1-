<?php
/**
 * @author Daniel Dimitrov - compojoom.com
 * @date: 11.04.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');  ?>

<form name='ccomment-search-form' id='ccomment-search-form' method='post' style="display:none;">
  <?php echo $this->hidden; ?>
  <fieldset>
      <legend><?php echo JText::_('COM_COMMENT_SEARCH'); ?></legend>
      <div>
      <label for="serch"><?php echo JText::_('COM_COMMENT_PROMPT_KEYWORD'); ?></label>
      <input name='tsearch' type='text' class='inputbox' size='40' />
      <input name='bsearch' type='button' class='button ccomment-search' value='<?php echo JText::_('COM_COMMENT_SEARCH'); ?>'  />
      </div>
      <div>
        <input type='radio' name='rsearchphrase' value="any" checked='checked' /><?php echo JText::_('COM_COMMENT_SEARCH_ANYWORDS'); ?>
        <input type='radio' name='rsearchphrase' value="all" /><?php echo JText::_('COM_COMMENT_SEARCH_ALLWORDS'); ?>
        <input type='radio' name='rsearchphrase' value="exact" /><?php echo JText::_('COM_COMMENT_SEARCH_PHRASE'); ?>

      </div>
  </fieldset>
  <div style='margin-bottom: 5px;'></div>
</form>
