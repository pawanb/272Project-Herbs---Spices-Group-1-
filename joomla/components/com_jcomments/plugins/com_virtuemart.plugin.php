<?php
/**
 * JComments plugin for VirtueMart objects support
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2013 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 */

defined('_JEXEC') or die;

class jc_com_virtuemart extends JCommentsPlugin
{
	function getObjectTitle($id)
	{
		$db = JFactory::getDBO();
		$db->setQuery('SELECT product_name, virtuemart_product_id FROM #__virtuemart_products_'.VMLANG.' WHERE virtuemart_product_id ='.$id);
		return $db->loadResult();
	}
	
	function getObjectLink($id)
	{
		$db = JFactory::getDBO();
		$db->setQuery('SELECT virtuemart_category_id FROM #__virtuemart_product_categories WHERE virtuemart_product_id ='.$id);
		$categoryId = $db->loadResult();
		
		$link = 'index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$id.'&virtuemart_category_id='.$categoryId;
		return JRoute::_($link);
	}
}