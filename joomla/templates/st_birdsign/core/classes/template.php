<?php
/**
 * @version		$Id: coolfeed.php 100 2012-04-14 17:42:51Z trung3388@gmail.com $
 * @copyright	JoomAvatar.com
 * @author		Nguyen Quang Trung
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 * @package		Avatar Dream Framework Template
 * @facebook 	http://www.facebook.com/pages/JoomAvatar/120705031368683
 * @twitter	    https://twitter.com/#!/JoomAvatar
 * @support 	http://joomavatar.com/forum/
 */

// No direct access
defined('_JEXEC') or die;
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
class AvatarTemplate extends JObject {
	
	protected $_path;
	protected $_jtemplate;
	protected $_jparams;
	public $_showcase;
	public $_bgImage = '';
	public $_css;
	public $_google;
	public $_mobile = false;
	public $_responsive = false;
	public $_jquery = false;
	public $_optimize = 0;
	
	public function __construct($context) 
	{
		$this->_jtemplate = $context;
		
		parent::__construct();
		JHtmlBootstrap::loadCss($includeMaincss = true, $this->_jtemplate->direction);
		JHtmlBootstrap::framework();
		$this->_jparams = ($this->_jtemplate->params) ? $this->_jtemplate->params : JFactory::getApplication()->getTemplate(true)->params;
		$this->_google = new stdClass;
		$this->setShowcase();
		$this->setBackground();
		$this->_mobile = Avatar::isHandleDevice();
		$this->_responsive = ($this->_jparams->get('active_responsive')) ? $this->_jparams->get('active_responsive') : false;
		$this->_jquery = ($this->_jparams->get('load_jquery')) ? $this->_jparams->get('load_jquery') : false;
		$this->_optimize = $this->_jparams->get('optimize');
	}
	
	/*
	 * set/get showcase from session variable  
	 */
	public function setShowcase() 
	{
		$showcase = JRequest::getVar('atColor', '');
		$this->_showcase = ($showcase != '') ? $showcase : (($this->_jparams->get('template_showcase')) ? $this->_jparams->get('template_showcase') : -1);
		
		$colorC = isset($_COOKIE[$this->_jtemplate->template.'-showcase']) ? $_COOKIE[$this->_jtemplate->template.'-showcase'] : '';
		
		if ($colorC == '' && $this->_showcase) {
			setcookie($this->_jtemplate->template.'-showcase', $this->_showcase, time()+60*60*24*365, '/');
		} 
		
		$this->_showcase = (JRequest::getVar($this->_jtemplate->template.'-showcase', '', 'COOKIE')) ? JRequest::getVar($this->_jtemplate->template.'-showcase', '', 'COOKIE') : $this->_showcase;
	}
	
	public function render($layout = 'default') 
	{
		// Try to find a favicon by checking the template and showcase root folder
		$favicon = JPATH_ROOT.'/templates/'.$this->_jtemplate->template.'/showcases/'. $this->_showcase.'/favicon.ico';
		
		if (JFile::exists($favicon)) {
			$this->_jtemplate->addFavicon($favicon);
		}
		
		// detect handle devices
		//if (($this->_jparams->get('active_mobile') && $this->_mobile) || JRequest::getBool('avatar_mobile')) {
			//$layout = $layout . '_mobile';
		//}
		
		$this->_path = JPATH_THEMES.DIRECTORY_SEPARATOR.$this->_jtemplate->template.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'layouts'.DIRECTORY_SEPARATOR.$layout.'.php';
		
		if (JFile::exists($this->_path)) 
		{
			ob_start();
			$template = $this->_jtemplate;
			require_once ($this->_path);
			return ob_get_clean();
		}
		
		return null;
	}
	
	/**
	 * get CSS files 
	 * @return string - link tag <link rel="stylesheet" 
	 */
	public function addJSFiles()
	{
		$array = $this->getJSFiles();
		
		$js = "";
		
		foreach ($array as $file) {
			$js .= "<script src=\"{$file}\" type=\"text/javascript\"></script>\n";
		}
		
		return $js;
	}
	
	public function getJSFiles() 
	{
		return $this->_js['template'] = array(
			//$this->_jtemplate->baseurl .'/templates/'. $this->_jtemplate->template .'/core/libraries/bootstrap/js/bootstrap.js',
			$this->_jtemplate->baseurl .'/templates/'. $this->_jtemplate->template .'/js/avatar-template.js',
		); 
	}
	
	/**
	 * get CSS files 
	 * @return string - link tag <link rel="stylesheet" 
	 */
	public function addCSSFiles()
	{
		$arrayCSS = $this->getCSSFiles();
		
		$css = '';
		
		foreach ($arrayCSS as $file) {
			$css .= '<link rel="stylesheet" href="'.$file.'" type="text/css"/>'."\n";
		}
	
		return $css;
	} 

	/**
	 * get CSS files
	 * @return array - list css files
	 */
	public function getCSSFiles() 
	{
		$this->_css['system'][] = $this->_jtemplate->baseurl .'/templates/system/css/system.css';
		$this->_css['system'][] = $this->_jtemplate->baseurl .'/templates/system/css/general.css';
		$this->_css['system'][] = $this->_jtemplate->baseurl .'/templates/system/css/editor.css';
		
		$this->_css['system'][] = $this->_jtemplate->baseurl .'/templates/'. $this->_jtemplate->template .'/core/assets/css/layout.css';
		$this->_css['system'][] = $this->_jtemplate->baseurl .'/templates/'. $this->_jtemplate->template .'/core/assets/css/core_joomla.css';
		//$this->_css['system'][] = $this->_jtemplate->baseurl .'/templates/'. $this->_jtemplate->template .'/core/libraries/bootstrap/css/bootstrap.css';
		
		if ($this->_responsive) {
			$this->_css['system'][] = $this->_jtemplate->baseurl .'/templates/'. $this->_jtemplate->template .'/core/assets/css/responsive.css';
			//$this->_css['system'][] = $this->_jtemplate->baseurl .'/templates/'. $this->_jtemplate->template .'/core/libraries/bootstrap/css/bootstrap-responsive.css';
		}
		
		$this->_css['showcase']['default'][] = $this->_jtemplate->baseurl .'/templates/'.$this->_jtemplate->template.'/css/template.css';
		$this->_css['showcase']['default'][] = $this->_jtemplate->baseurl .'/templates/'.$this->_jtemplate->template.'/css/typography.css';
		
		$color = $this->_jtemplate->baseurl .'/templates/'.$this->_jtemplate->template.'/showcases/'. $this->_showcase.'/css/style.css';
		
		if ($this->_showcase ) {
			$this->_css['showcase']['default'][] = $color;	
		}
		
		if ($this->_jtemplate->direction == 'rtl') {
			$this->_css['showcase']['default'][] = $this->_jtemplate->baseurl .'/templates/'.$this->_jtemplate->template.'/css/rtl.css';
		}
		
		$this->_css['showcase']['customize'] = array();
		
		if ($this->_jparams->get('customize_css') != '') 
		{
			$files = explode(',', $this->_jparams->get('customize_css'));
			
			foreach ($files as $file) 
			{
				$path = '/templates/'.$this->_jtemplate->template.'/css/customize/'.trim($file);
			
				if (JFile::exists(JPATH_ROOT.$path)) {
					$this->_css['showcase']['customize'][] = $this->_jtemplate->baseurl .$path;	
				}
			}
		}
		
		return array_unique(array_merge($this->_css['system'], $this->_css['showcase']['default'], $this->_css['showcase']['customize']));	
	}
	
	/**
	 * add Google Analytics Code
	 * @return string - javascript code
	 */
	public function addGoogleAnalytics() 
	{
		$this->_google->analytics = '';
		if ($this->_jparams->get('google_analytics') != '') {
				$this->_google->analytics = '<script type="text/javascript">
				  var _gaq = _gaq || [];
				  _gaq.push(["_setAccount", "'.$this->_jparams->get('google_analytics').'"]);
				  _gaq.push(["_trackPageview"]);

				  (function() {
					var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
					ga.src = ("https:" == document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js";
					var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
				  })();

				</script>';
		}
		
		return $this->_google->analytics;
	}
	
	/**
	 * Load Google Font Library
	 * @return string - link to google
	 */
	public function addGoogleFont()
	{
		if ($this->_jparams->get('google_font_api')) 
		{
			$googleFont 			= 'http://fonts.googleapis.com/css?family=';
			$gFontSubset 			= '';
			$gFontMainMenu 			= json_decode($this->_jparams->get('google_font_main_menu'));
			$googleFontArray = array();
			if (!isset($this->_google->font)) {
				$this->_google->font = new stdClass;	
			}
			$this->_google->font->mainMenuFamily = '';
			$this->_google->font->subMenuFamily	= '';
			$this->_google->font->pageHeadingFamily = '';
			$this->_google->font->moduleHeadingFamily = '';
			$this->_google->font->contentFamily= '';
			$this->_google->font->contentHeadingFamily = '';
			
			$gFontContent 			= json_decode($this->_jparams->get('google_font_content'));
			
			if ($gFontContent) {
				$this->_google->font->contentFamily 	= $gFontContent[0];
				$gFontSubset 			= @$gFontContent[2];
				$gFontContent			= urlencode(@$gFontContent[0]). ':' . urlencode(@$gFontContent[1]);
				$googleFontArray[] = $gFontContent;
			}
			
			if ($gFontMainMenu) {
				$this->_google->font->mainMenuFamily	= $gFontMainMenu[0];
				$gFontSubset 	= @$gFontMainMenu[2];
				$gFontMainMenu 	= urlencode(@$gFontMainMenu[0]) . ':' . urlencode(@$gFontMainMenu[1]);
				$googleFontArray[] = $gFontMainMenu;
			}
			
			$gFontSubMenu 		= json_decode($this->_jparams->get('google_font_submenu'));
			if ($gFontSubMenu) {
				$this->_google->font->subMenuFamily		= $gFontSubMenu[0];
				$gFontSubset 	= @$gFontSubMenu[2];
				$gFontSubMenu	= urlencode(@$gFontSubMenu[0]). ':' . urlencode(@$gFontSubMenu[1]);
				$googleFontArray[] = $gFontSubMenu;
			}
			
			$gFontPageHeading 		= json_decode($this->_jparams->get('google_font_page_heading'));
			if ($gFontPageHeading) {
				$this->_google->font->pageHeadingFamily = $gFontPageHeading[0];
				$gFontSubset 			= @$gFontPageHeading[2];
				$gFontPageHeading		= urlencode(@$gFontPageHeading[0]). ':' . urlencode(@$gFontPageHeading[1]);
				$googleFontArray[] = $gFontPageHeading;
			}
			
			$gFontModuleHeading 		= json_decode($this->_jparams->get('google_font_module_heading'));
			if ($gFontModuleHeading) {
				$this->_google->font->moduleHeadingFamily	= $gFontModuleHeading[0];
				$gFontSubset 				= urlencode(@$gFontModuleHeading[2]);
				$gFontModuleHeading			= urlencode(@$gFontModuleHeading[0]). ':' . urlencode(@$gFontModuleHeading[1]);
				$googleFontArray[] = $gFontModuleHeading;
			}
			
			$gFontContentHeading 		= json_decode($this->_jparams->get('google_font_content_heading'));
			if ($gFontContentHeading) {
				$this->_google->font->contentHeadingFamily 	= $gFontContentHeading[0];
				$gFontSubset				= @$gFontContentHeading[2];
				$gFontContentHeading		= urlencode(@$gFontContentHeading[0]). ':' . urlencode(@$gFontContentHeading[1]);
				$googleFontArray[] = $gFontContentHeading;
			}
			
			$googleFont .= implode('|', $googleFontArray);
			
			if ($gFontSubset) {
				$googleFont 			.= '&subset='. $gFontSubset;
			}
			
			$this->_google->font->url = $googleFont;
			
			return '<link href="'.$googleFont.'" rel="stylesheet" type="text/css">';
		}
		
		return '';
	}
	
	/**
	 * 
	 * add CSS when using the Google Font
	 */
	public function addGoogleFontCSS() 
	{
		$css = '';
		
		if ($this->_jparams->get('google_font_api')) 
		{
			if ($this->_jparams->get('google_font_content')) {
			  	$css .= 'body{ font-family: '.$this->_google->font->contentFamily.'}'."\n";
			}
			
			if ($this->_jparams->get('google_font_content_heading')) {
				$css .= 'h1,h2,h3,h4,h5,h6{ font-family: '. $this->_google->font->contentHeadingFamily .';}'."\n";
			}
			
			if ($this->_jparams->get('google_font_main_menu')) {
				$css .= '.avatar-main-menu { font-family: '. $this->_google->font->mainMenuFamily.';}'."\n";
			}
			
			if ($this->_jparams->get('google_font_submenu')) {
				$css .= '.avatar-submenu, .avatar-tree-menu, .avatar-slide-menu { font-family: '. $this->_google->font->subMenuFamily .';}'."\n";
			}
			if ($this->_jparams->get('google_font_page_heading')) {
				$css .= '.avatar-page-heading { font-family: '. $this->_google->font->pageHeadingFamily .';}'."\n";
			}
			if ($this->_jparams->get('google_font_module_heading')) {
			 	$css .= '.avatar-module-heading { font-family: '. $this->_google->font->moduleHeadingFamily .';}'."\n";
			}
		}		
		
		return $css;
	}
	
	/**
	 *  add CSS code base on params
	 */
	public function addCSSCode()
	{
		$css = "\n";;
		
		if ($this->_bgImage != '') {
			$css .= 'body { background-image: '.$this->_bgImage.';}'."\n";
		}
		
		if ($this->_jparams->get('link_color') != ''){
			$css .= 'a:link, a:visited { color:'. $this->_jparams->get('link_color'). ';}'."\n";
		}
		
		if ($this->_jparams->get('hover_color') != '') {
			$css .= 'a:hover { color: '. $this->_jparams->get('hover_color').';}'."\n";
		}
		
		if ($this->_jparams->get('body_font')) {
			$css .= 'body{ font-family: '. $this->_jparams->get('body_font') .';}'."\n";
		}
		
		if ($this->_jparams->get('menu_font')) {
			$css .= '.avatar-main-menu{ font-family: '. $this->_jparams->get('menu_font'). ';}'."\n";
		}
		
		$css .= $this->addGoogleFontCSS();
		
		if ($this->_jparams->get('heading_1')) {
			$css .= 'h1{' . $this->_jparams->get('heading_1') .';}'."\n";
		}
		
		if ($this->_jparams->get('heading_2')) {
			$css .= 'h2{' . $this->_jparams->get('heading_2') .';}'."\n";
		}
		
		if ($this->_jparams->get('heading_3')) {
			$css .= 'h3{'. $this->_jparams->get('heading_3') .';}'."\n";
		}
		
		if ($this->_jparams->get('heading_4')) {
			$css .= 'h4{' . $this->_jparams->get('heading_4') .';}'."\n";
		}
		
		if ($this->_jparams->get('heading_5')) {
			$css .= 'h5{' . $this->_jparams->get('heading_5') .';}'."\n";
		}
		
		if ($this->_jparams->get('heading_6')) {
			$css .= 'h6{' . $this->_jparams->get('heading_6') .';}'."\n";
		}
		
		if (isset($_COOKIE[$this->_jtemplate->template. '-header-color']) && $_COOKIE[$this->_jtemplate->template. '-header-color'] != '') {
			$css .= 'h1, h2, h3, h4, h5, h6 {color:'.$_COOKIE[$this->_jtemplate->template. '-header-color'].' !important;}'."\n";
		}
		
		if (isset($_COOKIE[$this->_jtemplate->template. '-body-color']) && $_COOKIE[$this->_jtemplate->template. '-body-color'] != '') {
			$css .= 'body {color:'.$_COOKIE[$this->_jtemplate->template. '-body-color'].';}'."\n";
		}
		
		return $css;
	}

	/**
	 * 
	 * hide main component base on ItemID
	 */
	public function hideComponentBaseOnItemID() 
	{
		$app = JFactory::getApplication();
		
		if ($this->_jparams->get('hide_menu_items')) 
		{
			$menu = $app->getMenu();
				
			if (isset($menu->getActive()->id)) 
			{
				$itemID = $menu->getActive()->id;
				
				$hideMenuItems = $this->_jparams->get('hide_menu_items');
				
				if ($hideMenuItems == '') return false;
				
				if (!is_array($hideMenuItems)) $hideMenuItems = array($hideMenuItems);
				
				if (in_array($itemID, $hideMenuItems)) return true;
			} 
		} else {
			return false;
		}
		
		return false;
	}

	public function getMenuClass() 
	{
		$app = JFactory::getApplication();
		$menu = $app->getMenu();
		$active = $menu->getActive();
		if (isset($active->id)) 
		{
			return $active->params->get('pageclass_sfx');
		} 
		return '';
	}
	
	/**
	 *  add header data
	 */
	public function addHead() 
	{
		$head = '';
		
		if ($this->_jquery) {
			$head = $this->loadJquery();
		}
		$head .= $this->addGoogleFont();
		$head .= '<jdoc:include type="head" />';
		
		if ($this->_optimize == 0 || $this->_optimize == 2) {
			$head .= $this->addCSSFiles();
		}
		
		if ($this->_optimize == 0 || $this->_optimize == 1) {
			$head .= $this->addJSFiles();
		}
		
		if ($this->_responsive) {
			$head .= '<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">'."\n";
		}
		
		if ($this->_jparams->get('go_to_top')) {
			$head .= $this->goToTop();
		}
		
		$head .= $this->selectColor();
		$head .= '<style type="text/css">'.$this->addCSSCode().'</style>';
			
		return $head;
	}
	
	/**
	 * optimize the css and js
	 */
	public function optimize() 
	{
		if ($this->_optimize) {
			Avatar::import('core.helpers.compress');
			$compressObj = new AvatarCompress($this);
			$compressObj->compress();	
		}
	}
	
	/**
	 *  get Doctype
	 */
	public function getDocType() 
	{
		$doctype = '';
		switch ($this->_jparams->get('doctype')) {
			case '1':
				$doctype = '<!DOCTYPE html>';
				break;
			case '2':
				$doctype = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
				break;
			case '3':
				$doctype = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
				break;
			case '4':
				$doctype = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">';
				break;
			case '5':
				$doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
				break;
			case '6':
				$doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
				break;
			case '7':
				$doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">';
				break;
			case '8':
				$doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">';
				break;
		}

		return $doctype;	
	}

	/*
	 * Responsive feature
	 */
	 
	 public function responsive() 
	 {
	 	$script = "<script>
			jQuery.noConflict();
			(function($){
				$(document).ready(function()
				{
					if ($('body').hasClass('avatar-responsive'))
					{
						var mainMenu = $('.avatar-nav-responsive > ul');
						
						mainMenu.find('li > span.pull').click(function(event){
							$(this.getParent()).find('ul:first').slideToggle();
						});
						
						$(window).resize(function(){
							if($(window).width() > 767) {
								mainMenu.find('ul').removeAttr('style');
							}
						});
					}
				});
			})(jQuery)
		</script>";	
		
		return $script;
	 }
	 
	 /*
	  * Load jQuery
	  */
	 public function loadJquery() {
	 	$script = "\n\r\t".'<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript"></script>'."\n\r\t".'<script type="text/javascript">jQuery.noConflict();</script>'."\n\r\t";
		//return $script;
	 }

	/*
	 * Go to top function
	 */
	 
	public function goToTop() 
	{
		$script = "
			<script stype=\"text/javascript\">
			jQuery.noConflict();
			(function($){
				$(document).ready(function() {
					var goToTop = $('#avatar-go-to-top');
					goToTop.hide();
					
					// fade in #back-top
					$(function () {
						$(window).scroll(function () {
							if ($(this).scrollTop() > 100) {
								goToTop.fadeIn();
							} else {
								goToTop.fadeOut();
							}
						});
				
						// scroll body to 0px on click
						goToTop.click(function () {
							$('body,html').animate({
								scrollTop: 0
							}, 800);
							return false;
						});
					});
				});
			})(jQuery)
			</script>
		";	
		return $script;
	}
	
	/*
	 * Select color
	 */
	 
	 public function selectColor () 
	 {
	 	$script = "
	 		<script type=\"text/javascript\">
				jQuery.noConflict();
				(function($){
					$(document).ready(function()
					{
						avatarTemplate.url.base = \"".JURI::base()."\";
						avatarTemplate.template.name = \"".$this->_jtemplate->template."\";
						avatarTemplate.template.params = ".$this->_jparams->toString().";
						avatarTemplate.image.initEffects();
						avatarTemplate.layout.init();
						avatarTemplate.settingPanel.init();
						avatarTemplate.menu.init();
						avatarTemplate.css3effect.init();
					});
				})(jQuery)
			</script>
	 	";
		return $script;
	 }

	public function panelSettings() 
	{
		if (!$this->_jparams->get('template_panel_setting')) {
			return '';
		}
		
		$path = JPATH_THEMES.DIRECTORY_SEPARATOR.$this->_jtemplate->template.DIRECTORY_SEPARATOR;
		$uri = JFactory::getURI();
		
		$showcases = JFolder::folders($path.'showcases');
		$html = '';
		if (count($showcases)) 
		{
			$html .= '<h3>'. JText::_('AVATAR_TEMPLATE_CORE_SETTING_SHOWCASES', true). '</h3>';
			// $html .= '<select class="showcases" onchange="avatarSettingPanel.showcase.change(this);">';
			// $html .= '<option '.(($this->_showcase == -1) ? 'selected="selected"' : '').' value="-1">'.JText::_('JOPTION_USE_DEFAULT').'</option>';
			$html .= '<div class="color-image clearfix">';
			foreach ($showcases as $showcase) {
				if ($this->_showcase == $showcase) {}
				// $html .= '<option '.(($this->_showcase == $showcase) ? ' selected="selected"' : '').' value="'.htmlspecialchars($showcase).'">'.$showcase.'</option>';
				$url = $uri->root().'templates/'.$this->_jtemplate->template.'/showcases/'.$showcase.'/color.png';					$html .= '<span onclick="avatarSettingPanel.showcase.change(\''.htmlspecialchars($showcase).'\');" class="item" style='.htmlspecialchars("background-image:url(".$url.")").'></span>';
			}
			$html .= '</div>';
			
			// $html .= '</select>';	
		}
		
		$url = $uri->root().'templates/'.$this->_jtemplate->template.'/backgrounds/';
		$filter = '.(jpg||png||gif||jpeg)$';
		$images = JFolder::files($path.'backgrounds', $filter, false);
		
		if (count($images)) 
		{
			$html .= '<h3>'. JText::_('AVATAR_TEMPLATE_CORE_SETTING_BACKGROUND_IMAGE', true). '</h3>';
			$html .= '<div class="bg-image clearfix">';
			
			foreach ($images as $image) {
				$html .= '<span class="item" style='.htmlspecialchars("background-image:url(".$url.$image.")").'></span>';	
			}
			
			$html .= '</div>';	
		} 
		
		
		$url = $uri->root().'templates/'.$this->_jtemplate->template.'/core/libraries/js/color-picker/';
		JHtml::_('stylesheet', $url.'jquery.miniColors.css', array('media' => 'all'), true);
		JHtml::_('script', $url.'jquery.miniColors.js', false, true);
		
		$value = JRequest::getVar($this->_jtemplate->template.'-header-color', '#ffffff', 'COOKIE');
		
		$html .= '<div class="header-color">';
		$html .= '<h3>'.JText::_('AVATAR_TEMPLATE_CORE_SETTING_HEADER_COLOR', true).'</h3>: <input class="picker-color" value="'.$value.'" type="minicolors" name="header-color" onchange="avatarSettingPanel.header.color(this);"/>';
		$html .= '</div>'; 
		
		$value = JRequest::getVar($this->_jtemplate->template.'-body-color', '#ffffff', 'COOKIE');
		$html .= '<div class="body-color">';
		$html .= '<h3>'.JText::_('AVATAR_TEMPLATE_CORE_SETTING_BODY_COLOR', true).'</h3>: <input class="picker-color" value="'.$value.'" type="minicolors" name="body-color" onchange="avatarSettingPanel.body.color(this);"/>';
		$html .= '</div>';
		
		$html .= '<br/>';
		$html .= '<button onclick="avatarSettingPanel.reset(); return false;" class="btn">'.JText::_('AVATAR_TEMPLATE_CORE_SETTING_RESET').'</button>';
		return '<div id="avatar-settings"><span id="close"></span>'.$html.'</div>';
	}
	
	/*
	 * set/get showcase from session variable  
	 */
	public function setBackground() 
	{
		$uri = JFactory::getURI();
		$this->_bgImage = ($this->_jparams->get('template_background')) ? $this->_jparams->get('template_background') : '';
		$bg = JRequest::getVar($this->_jtemplate->template.'-background-image', '', 'COOKIE');
		$url = $uri->root().'templates/'.$this->_jtemplate->template.'/backgrounds/';
		
		if ($bg == '' && $this->_bgImage) {
			setcookie($this->_jtemplate->template.'-background-image', 'url('.$url.$this->_bgImage.')', time()+60*60*24*365, '/');
		}
 		$this->_bgImage = (JRequest::getVar($this->_jtemplate->template.'-background-image', '', 'COOKIE')) ? JRequest::getVar($this->_jtemplate->template.'-background-image', '', 'COOKIE') : 'url('.$url.$this->_bgImage.')';
	}
}