<?php 
// no direct access
 defined('_JEXEC') or die('Restricted access');
 JLoader::register('TagsHelperRoute', JPATH_BASE . '/components/com_tags/helpers/route.php');
?>

<style type="text/css">
<!--
#easytagcloud<?php echo '_'.$module->id; ?> a:link {
	<?php echo $easytagcloud_params->show_underline; ?>
	<?php echo $easytagcloud_params->color; ?>
    <?php echo $easytagcloud_params->bgcolor; ?>
    <?php echo $easytagcloud_params->bold; ?>	
}

#easytagcloud<?php echo '_'.$module->id; ?> a:visited {
	<?php echo $easytagcloud_params->show_underline; ?>
	<?php echo $easytagcloud_params->color; ?>
    <?php echo $easytagcloud_params->bgcolor; ?>
    <?php echo $easytagcloud_params->bold; ?>	
}

#easytagcloud<?php echo '_'.$module->id; ?> a:hover {
	<?php echo $easytagcloud_params->hover_show_underline; ?>
    <?php echo $easytagcloud_params->hovercolor; ?>
    <?php echo $easytagcloud_params->hoverbgcolor; ?>
}

#easytagcloud<?php echo '_'.$module->id; ?> a {
	margin-left: <?php echo $easytagcloud_params->margin; ?>;
	margin-right: <?php echo $easytagcloud_params->margin; ?>;	
	padding: <?php echo $easytagcloud_params->padding; ?>;	
    -webkit-border-radius: <?php echo $easytagcloud_params->borderradius; ?>;	
    -moz-border-radius: <?php echo $easytagcloud_params->borderradius; ?>;
    border-radius: <?php echo $easytagcloud_params->borderradius; ?>;		
	<?php echo $easytagcloud_params->googlefont; ?>	
}

#easytagcloud<?php echo '_'.$module->id; ?> {
    line-height: <?php echo $easytagcloud_params->lineheight; ?>;
}

-->
</style>
<?php JLoader::register('TagsHelperRoute', JPATH_BASE . '/components/com_tags/helpers/route.php'); ?>    
    
<div id="easytagcloud<?php echo '_'.$module->id; ?>" style="text-align:<?php echo $easytagcloud_params->align; ?>" <?php echo $easytagcloud_params->googlefonteffect; ?>>
<?php
 foreach($easytagcloud_params->tagsarray as $key => $value) 
  {    
   $app = JFactory::getApplication();
   if($value == 1) {
      $tip = Jtext::_('MOD_EASYTAGCLOUD_RELATED_ITEM');
	} else {
		   $tip = Jtext::_('MOD_EASYTAGCLOUD_RELATED_ITEMS');
    }
	//colorful tags
    if($easytagcloud_params->colorfultags == 0) {
	   $tagcolor = "color:#".dechex(rand(0,16777215));
	} else {
			$tagcolor = "";
	}
			
		$tagurl = JRoute::_(TagsHelperRoute::getTagRoute($easytagcloud_params->tagsidarray[$key] . ':' . $easytagcloud_params->tagsaliasarray[$key])); 			
	    $searchphrase = "<a href='".$tagurl."' style='font-size:".$easytagcloud_params->tagsstyle[$key]."px;".$tagcolor."' title='".$value." $tip' target='".$easytagcloud_params->searchwindow; 
		$searchphrase .= $easytagcloud_params->intelmode ? "' class='".$easytagcloud_params->class[$key] : "";
		$searchphrase .= "'>".$key."</a>";   

	  
   echo $searchphrase;
   echo " ";
  } 
 if ($easytagcloud_params->notag) {
     echo Jtext::_('MOD_EASYTAGCLOUD_NOTAG');
 }
 ?>
</div>