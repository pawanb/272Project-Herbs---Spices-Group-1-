<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<style type="text/css">
#convert_h {
	font-size: 16px;
	font-weight: bold;
}
#convert_b {
    padding: 10px;
}
#convert_r {
    color: #33CC33;
	font-weight: bold;
}
</style> 
<script language="javascript" type="text/javascript">
var converturi = '<?php echo JURI::root()."administrator/components/com_easytagcloud/models/convertor.php?task=convert" ?>';
</script>
<p id="convert_h">Convert meta keywords to tags (only for com_content):</p>
<p id="convert_r"><input type="button" value="CONVERT" id="convert_b" onclick="convert()" /><img src='../media/com_easytagcloud/assets/loading.gif' width='114' height='117' style="display: none;" id="convert_l"/></p>