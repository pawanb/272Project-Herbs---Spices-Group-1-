<?php
/**
 * @package      ITPrism Modules
 * @subpackage   ITPShare
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2013 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

class ItpShareHelper {
    
	/**
     * A method that make a long url to short url
     * 
     * @param string $link
     * @param array $params
     * @return string
     */
    public static function getShortUrl($link, $params){
        
		JLoader::register("ItpShareModuleShortUrl", dirname(__FILE__).DIRECTORY_SEPARATOR."shorturl.php");
        
		$options = array(
            "login"     => $params->get("shortener_login"),
            "api_key"   => $params->get("shortener_api_key"),
            "service"   => $params->get("shortener_service"),
        );
		
		$shortLink = "";
        
        try {
        
            $shortUrl  = new ItpShareModuleShortUrl($link, $options);
            $shortLink = $shortUrl->getUrl();
        
            // Get original link
            if(!$shortLink) {
                $shortLink = $link;
            }
        
        } catch(Exception $e) {
        
            JLog::add($e->getMessage());
        
            // Get original link
            if(!$shortLink) {
                $shortLink = $link;
            }
        
        }
        
        return $shortLink;
            
    }
    
    /**
     * Generate a code for the extra buttons. 
     * Is also replace indicators {URL} and {TITLE} with that of the article.
     * 
     * @param string $title Article Title
     * @param string $url   Article URL
     * @param array $params Plugin parameters
     * 
     * @return string
     */
    public static function getExtraButtons($params, $url, $title) {
        
        $html  = "";
        // Extra buttons
        for($i=1; $i < 6;$i++) {
            $btnName = "ebuttons" . $i;
            $extraButton = $params->get($btnName, "");
            if(!empty($extraButton)) {
                $extraButton = str_replace("{URL}", $url,$extraButton);
                $extraButton = str_replace("{TITLE}", $title, $extraButton);
                $html  .= $extraButton;
            }
        }
        
        return $html;
    }
    
    public static function getTwitter($params, $url, $title){
        
        $html = "";
        if($params->get("twitterButton")) {
            
            $title  = htmlentities($title, ENT_QUOTES, "UTF-8");
            
        	// Get locale code
            if(!$params->get("dynamicLocale")) {
                $locale   = $params->get("twitterLanguage", "en");
            } else {
                $tag      = JFactory::getLanguage()->getTag();
                $locale   = str_replace("-","_", $tag);
                $locales  = self::getButtonsLocales($locale); 
                $locale   = JArrayHelper::getValue($locales, "twitter", "en");
            }
            
            $html = '
             	<div class="itp-share-tw">
                	<a href="https://twitter.com/share" class="twitter-share-button" data-url="' . $url . '" data-text="' . $title . '" data-via="' . $params->get("twitterName") . '" data-lang="' . $locale . '" data-size="' . $params->get("twitterSize") . '" data-related="' . $params->get("twitterRecommend") . '" data-hashtags="' . $params->get("twitterHashtag") . '" data-count="' . $params->get("twitterCounter") . '">Tweet</a>';
            
            if($params->get("load_twitter_library", 1)) {
                $html .= '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
            }
            
            $html .='</div>';
        }
         
        return $html;
    }
    
    public static function getGooglePlusOne($params, $url){
        
        $html = "";
        if($params->get("plusButton")) {
            
        	// Get locale code
            if(!$params->get("dynamicLocale")) {
                $locale   = $params->get("plusLocale", "en");
            } else {
                $tag      = JFactory::getLanguage()->getTag();
                $locale   = str_replace("-","_", $tag);
                $locales  = self::getButtonsLocales($locale); 
                $locale   = JArrayHelper::getValue($locales, "google", "en");
            }
            
            $html .= '<div class="itp-share-gone">';
            
            switch($params->get("plusRenderer")) {
                
                case 1:
                    $html .= self::genGooglePlus($params, $url);
                    break;
                    
                default:
                    $html .= self::genGooglePlusHTML5($params, $url);
                    break;
            }
            
            // Load the JavaScript asynchroning
    		if($params->get("loadGoogleJsLib")) {
      
                $html .= '<script>';
                $html .= ' window.___gcfg = {lang: "' . $locale . '"};';
                
                $html .= '
                  (function() {
                    var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
                    po.src = "https://apis.google.com/js/plusone.js";
                    var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);
                  })();
                </script>';
    		}
          
            $html .= '</div>';
        }
        
        return $html;
    }
    
    /**
     * 
     * Render the Google plus one in standart syntax
     * 
     * @param array $params
     * @param string $url
     */
    public static function genGooglePlus($params, $url) {
        
        $annotation = "";
        if($params->get("plusAnnotation")) {
            $annotation = ' annotation="' . $params->get("plusAnnotation") . '"';
        }
        
        $html = '<g:plusone size="' . $params->get("plusType") . '" ' . $annotation . ' href="' . $url . '"></g:plusone>';
				
        return $html;
    }
    
    /**
     * 
     * Render the Google plus one in HTML5 syntax
     * 
     * @param array $params
     * @param string $url
     */
    public static function genGooglePlusHTML5($params, $url) {
        
        $annotation = "";
        if($params->get("plusAnnotation")) {
            $annotation = ' data-annotation="' . $params->get("plusAnnotation") . '"';
        }
        
        $html = '<div class="g-plusone" data-size="' . $params->get("plusType") . '" ' . $annotation . ' data-href="' . $url . '"></div>';

        return $html;
    }
    
    
    public static function getFacebookLike($params, $url){
        
        $html = "";
        if($params->get("facebookLikeButton")) {
            
        	// Get locale code
            if(!$params->get("dynamicLocale")) {
                $locale   = $params->get("fbLocale", "en_US");
            } else {
                $tag      = JFactory::getLanguage()->getTag();
                $locale   = str_replace("-","_", $tag);
                $locales  = self::getButtonsLocales($locale); 
                $locale   = JArrayHelper::getValue($locales, "facebook", "en_US");
            }
            
            // Faces 
            $faces = (!$params->get("facebookLikeFaces")) ? "false" : "true";
            
            // Layout Styles
            $layout = $params->get("facebookLikeType", "button_count");
            if(strcmp("box_count", $layout)==0){
                $height = "80";
            } else {
                $height = "25";
            }
            
            // Generate code
            $html = '<div class="itp-share-fbl">';
            
            switch($params->get("facebookLikeRenderer")) {
                
                case 0: // iframe
                    $html .= self::genFacebookLikeIframe($params, $url, $layout, $faces, $height, $locale);
                break;
                    
                case 1: // XFBML
                    $html .= self::genFacebookLikeXfbml($params, $url, $layout, $faces, $height, $locale);
                break;
             
                default: // HTML5
                   $html .= self::genFacebookLikeHtml5($params, $url, $layout, $faces, $height, $locale);
                break;
            }
            
            $html .="</div>";
        }
        
        return $html;
    }
    
    public static function genFacebookLikeIframe($params, $url, $layout, $faces, $height, $fbLocale) {
        
        $html = '
            <iframe src="//www.facebook.com/plugins/like.php?';
            
            $html .= 'href=' . rawurlencode($url) . '&amp;send=' . $params->get("facebookLikeSend",0). '&amp;locale=' . $fbLocale . '&amp;layout=' . $layout . '&amp;show_faces=' . $faces . '&amp;width=' . $params->get("facebookLikeWidth","450") . '&amp;action=' . $params->get("facebookLikeAction",'like') . '&amp;colorscheme=' . $params->get("facebookLikeColor",'light') . '&amp;height='.$height.'';
            
            if($params->get("facebookLikeFont")){
                $html .= "&amp;font=" . $params->get("facebookLikeFont");
            }
            
            if($params->get("facebookLikeAppId")){
                $html .= "&amp;appId=" . $params->get("facebookLikeAppId");
            }
            
            if($params->get("facebookKidDirectedSite")){
                $html .= '&amp;kid_directed_site=true';
            }
            
            $html .= '" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:' . $params->get("facebookLikeWidth", "450") . 'px; height:' . $height . 'px;" allowTransparency="true"></iframe>
        ';
            
        return $html;
    }
    
    public static function genFacebookLikeXfbml($params, $url, $layout, $faces, $height, $fbLocale) {
        
        $html = "";
                
        if($params->get("facebookRootDiv",1)) {
            $html .= '<div id="fb-root"></div>';
        }
        
       if($params->get("facebookLoadJsLib", 1)) {
           $appId = "";
           if($params->get("facebookLikeAppId")){
               $appId = '&amp;appId=' . $params->get("facebookLikeAppId"); 
           }
            
           $html .= ' 
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/' . $fbLocale . '/all.js#xfbml=1'.$appId.'";
  fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>';
           
        }
        
        $html .= '
        <fb:like 
        href="' . $url . '" 
        layout="' . $layout . '" 
        show_faces="' . $faces . '" 
        width="' . $params->get("facebookLikeWidth","450") . '" 
        colorscheme="' . $params->get("facebookLikeColor","light") . '"
        send="' . $params->get("facebookLikeSend",0). '" 
        action="' . $params->get("facebookLikeAction",'like') . '" ';

        if($params->get("facebookLikeFont")){
            $html .= 'font="' . $params->get("facebookLikeFont") . '"';
        }
        
        if($params->get("facebookKidDirectedSite")){
            $html .= ' kid_directed_site="true"';
        }
        
        $html .= '></fb:like>
        ';
        
        return $html;
    }
    
    public static function genFacebookLikeHtml5($params, $url, $layout, $faces, $height, $fbLocale) {
        
        $html = '';
                
        if($params->get("facebookRootDiv",1)) {
            $html .= '<div id="fb-root"></div>';
        }
                
        if($params->get("facebookLoadJsLib", 1)) {
           $appId = "";
           if($params->get("facebookLikeAppId")){
                $appId = '&amp;appId=' . $params->get("facebookLikeAppId"); 
            }
            
           $html .= ' 
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/' . $fbLocale . '/all.js#xfbml=1'.$appId.'";
  fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>';
           
        }
        
        $html .= '
            <div 
            class="fb-like" 
            data-href="' . $url . '" 
            data-send="' . $params->get("facebookLikeSend",0). '" 
            data-layout="'.$layout.'" 
            data-width="' . $params->get("facebookLikeWidth","450") . '" 
            data-show-faces="' . $faces . '" 
            data-colorscheme="' . $params->get("facebookLikeColor","light") . '" 
            data-action="' . $params->get("facebookLikeAction",'like') . '"';
                
                
        if($params->get("facebookLikeFont")){
            $html .= ' data-font="' . $params->get("facebookLikeFont") . '" ';
        }
        
        if($params->get("facebookKidDirectedSite")){
            $html .= ' data-kid-directed-site="true"';
        }
        
        $html .= '></div>';
        
        return $html;
        
    }
    
    public static function getLinkedIn($params, $url){
        
        $html = "";
        if($params->get("linkedInButton")) {
            
            $html = '
            <div class="itp-share-lin">';
            
            if($params->get("load_linkedin_library", 1)) {
                $html .= '<script src="//platform.linkedin.com/in.js"></script>';
            }
            
            $html .= '<script type="IN/Share" data-url="' . $url . '" data-counter="' . $params->get("linkedInType", 'right'). '"></script>
            </div>
            ';

        }
        
        return $html;
    }
    
    
    public static function getReddit($params, $url, $title){
        
        $html = "";
        if($params->get("redditButton")) {
            
            $title  = htmlentities($title, ENT_QUOTES, "UTF-8");
            
            $html .= '<div class="itp-share-reddit">';
            $redditType = $params->get("redditType");
            
            $jsButtons = array(1,2,3);
            
            if(in_array($redditType,$jsButtons) ) {
                $html .='<script>
  reddit_url = "'. $url . '";
  reddit_title = "'.$title.'";
  reddit_bgcolor = "'.$params->get("redditBgColor").'";
  reddit_bordercolor = "'.$params->get("redditBorderColor").'";
  reddit_newwindow = "'.$params->get("redditNewTab").'";
</script>';
            }
                switch($redditType) {
                    
                    case 1:
                        $html .='<script src="//www.reddit.com/static/button/button1.js"></script>';
                        break;
                    case 2:
                        $html .='<script src="//www.reddit.com/static/button/button2.js"></script>';
                        break;
                    case 3:
                        $html .='<script src="//www.reddit.com/static/button/button3.js"></script>';
                        break;
                    case 4:
                        $html .='<script src="//www.reddit.com/buttonlite.js?i=0"></script>';
                        break;
                    case 5:
                        $html .='<script src="//www.reddit.com/buttonlite.js?i=1"></script>';
                        break;
                    case 6:
                        $html .='<script src="//www.reddit.com/buttonlite.js?i=2"></script>';
                        break;
                    case 7:
                        $html .='<script src="//www.reddit.com/buttonlite.js?i=3"></script>';
                        break;
                    case 8:
                        $html .='<script src="//www.reddit.com/buttonlite.js?i=4"></script>';
                        break;
                    case 9:
                        $html .='<script src="//www.reddit.com/buttonlite.js?i=5"></script>';
                        break;
                    case 10:
                        $html .='<a href="http://www.reddit.com/submit" onclick="window.location = \'http://www.reddit.com/submit?url='. $url . '\'; return false"> <img src="//www.reddit.com/static/spreddit6.gif" alt="'.JText::_("MOD_ITPSHARE_SUBMIT_REDDIT").'" border="0" /> </a>';
                        break;
                    case 11:
                        $html .='<a href="http://www.reddit.com/submit" onclick="window.location = \'http://www.reddit.com/submit?url='. $url . '\'; return false"> <img src="//www.reddit.com/static/spreddit1.gif" alt="'.JText::_("MOD_ITPSHARE_SUBMIT_REDDIT").'" border="0" /> </a>';
                        break;   
                    case 12:
                        $html .='<a href="http://www.reddit.com/submit" onclick="window.location = \'http://www.reddit.com/submit?url='. $url . '\'; return false"> <img src="//www.reddit.com/static/spreddit2.gif" alt="'.JText::_("MOD_ITPSHARE_SUBMIT_REDDIT").'" border="0" /> </a>';
                        break;   
                    case 13:
                        $html .='<a href="http://www.reddit.com/submit" onclick="window.location = \'http://www.reddit.com/submit?url='. $url . '\'; return false"> <img src="//www.reddit.com/static/spreddit3.gif" alt="'.JText::_("MOD_ITPSHARE_SUBMIT_REDDIT").'" border="0" /> </a>';
                        break;   
                    case 14:
                        $html .='<a href="http://www.reddit.com/submit" onclick="window.location = \'http://www.reddit.com/submit?url='. $url . '\'; return false"> <img src="//www.reddit.com/static/spreddit4.gif" alt="'.JText::_("MOD_ITPSHARE_SUBMIT_REDDIT").'" border="0" /> </a>';
                        break;   
                    case 15:
                        $html .='<a href="http://www.reddit.com/submit" onclick="window.location = \'http://www.reddit.com/submit?url='. $url . '\'; return false"> <img src="//www.reddit.com/static/spreddit5.gif" alt="'.JText::_("MOD_ITPSHARE_SUBMIT_REDDIT").'" border="0" /> </a>';
                        break;   
                    case 16:
                        $html .='<a href="http://www.reddit.com/submit" onclick="window.location = \'http://www.reddit.com/submit?url='. $url . '\'; return false"> <img src="//www.reddit.com/static/spreddit8.gif" alt="'.JText::_("MOD_ITPSHARE_SUBMIT_REDDIT").'" border="0" /> </a>';
                        break;   
                    case 17:
                        $html .='<a href="http://www.reddit.com/submit" onclick="window.location = \'http://www.reddit.com/submit?url='. $url . '\'; return false"> <img src="//www.reddit.com/static/spreddit9.gif" alt="'.JText::_("MOD_ITPSHARE_SUBMIT_REDDIT").'" border="0" /> </a>';
                        break;   
                    case 18:
                        $html .='<a href="http://www.reddit.com/submit" onclick="window.location = \'http://www.reddit.com/submit?url='. $url . '\'; return false"> <img src="//www.reddit.com/static/spreddit10.gif" alt="'.JText::_("MOD_ITPSHARE_SUBMIT_REDDIT").'" border="0" /> </a>';
                        break;   
                    case 19:
                        $html .='<a href="http://www.reddit.com/submit" onclick="window.location = \'http://www.reddit.com/submit?url='. $url . '\'; return false"> <img src="//www.reddit.com/static/spreddit11.gif" alt="'.JText::_("MOD_ITPSHARE_SUBMIT_REDDIT").'" border="0" /> </a>';
                        break;   
                    case 20:
                        $html .='<a href="http://www.reddit.com/submit" onclick="window.location = \'http://www.reddit.com/submit?url='. $url . '\'; return false"> <img src="//www.reddit.com/static/spreddit12.gif" alt="'.JText::_("MOD_ITPSHARE_SUBMIT_REDDIT").'" border="0" /> </a>';
                        break;   
                    case 21:
                        $html .='<a href="http://www.reddit.com/submit" onclick="window.location = \'http://www.reddit.com/submit?url='. $url . '\'; return false"> <img src="//www.reddit.com/static/spreddit13.gif" alt="'.JText::_("MOD_ITPSHARE_SUBMIT_REDDIT").'" border="0" /> </a>';
                        break;   
                    case 22:
                        $html .='<a href="http://www.reddit.com/submit" onclick="window.location = \'http://www.reddit.com/submit?url='. $url . '\'; return false"> <img src="//www.reddit.com/static/spreddit14.gif" alt="'.JText::_("MOD_ITPSHARE_SUBMIT_REDDIT").'" border="0" /> </a>';
                        break;   
                                        
                    default:
                        $html .='<a href="http://www.reddit.com/submit" onclick="window.location = \'http://www.reddit.com/submit?url=' . $url . '\'; return false"> <img src="//www.reddit.com/static/spreddit7.gif" alt="'.JText::_("MOD_ITPSHARE_SUBMIT_REDDIT").'" border="0" /> </a>';
                        break;
                }
                
                $html .='</div>';
                
        }
        
        return $html;
    }
    
    public static function getTumblr($params, $url){
            
        $html = "";
        if($params->get("tumblrButton")) {
            
            $html .= '<div class="itp-share-tbr">';
            
            if($params->get("loadTumblrJsLib")) {
                $html .= '<script src="//platform.tumblr.com/v1/share.js"></script>';
            }
            
            switch($params->get("tumblrType")) {
                
                case 1:
                    $html .='<a href="http://www.tumblr.com/share" title="'.JText::_("MOD_ITPSHARE_SHARE_THUMBLR").'" style="display:inline-block; text-indent:-9999px; overflow:hidden; width:61px; height:20px; background:url(\'//platform.tumblr.com/v1/share_2.png\') top left no-repeat transparent;">'.JText::_("MOD_ITPSHARE_SHARE_THUMBLR").'</a>';
                    break;
                case 2:
                    $html .='<a href="http://www.tumblr.com/share" title="'.JText::_("MOD_ITPSHARE_SHARE_THUMBLR").'" style="display:inline-block; text-indent:-9999px; overflow:hidden; width:129px; height:20px; background:url(\'//platform.tumblr.com/v1/share_3.png\') top left no-repeat transparent;">'.JText::_("MOD_ITPSHARE_SHARE_THUMBLR").'</a>';
                    break;
                case 3:
                    $html .='<a href="http://www.tumblr.com/share" title="'.JText::_("MOD_ITPSHARE_SHARE_THUMBLR").'" style="display:inline-block; text-indent:-9999px; overflow:hidden; width:20px; height:20px; background:url(\'//platform.tumblr.com/v1/share_4.png\') top left no-repeat transparent;">'.JText::_("MOD_ITPSHARE_SHARE_THUMBLR").'</a>';
                    break;
                case 4:
                    $html .='<a href="http://www.tumblr.com/share" title="'.JText::_("MOD_ITPSHARE_SHARE_THUMBLR").'" style="display:inline-block; text-indent:-9999px; overflow:hidden; width:81px; height:20px; background:url(\'//platform.tumblr.com/v1/share_1T.png\') top left no-repeat transparent;">'.JText::_("MOD_ITPSHARE_SHARE_THUMBLR").'</a>';
                    break;
                case 5:
                    $html .='<a href="http://www.tumblr.com/share" title="'.JText::_("MOD_ITPSHARE_SHARE_THUMBLR").'" style="display:inline-block; text-indent:-9999px; overflow:hidden; width:61px; height:20px; background:url(\'//platform.tumblr.com/v1/share_2T.png\') top left no-repeat transparent;">'.JText::_("MOD_ITPSHARE_SHARE_THUMBLR").'</a>';
                    break;
                case 6:
                    $html .='<a href="http://www.tumblr.com/share" title="'.JText::_("MOD_ITPSHARE_SHARE_THUMBLR").'" style="display:inline-block; text-indent:-9999px; overflow:hidden; width:129px; height:20px; background:url(\'//platform.tumblr.com/v1/share_3T.png\') top left no-repeat transparent;">'.JText::_("MOD_ITPSHARE_SHARE_THUMBLR").'</a>';
                    break;
                case 7:
                    $html .='<a href="http://www.tumblr.com/share" title="'.JText::_("MOD_ITPSHARE_SHARE_THUMBLR").'" style="display:inline-block; text-indent:-9999px; overflow:hidden; width:20px; height:20px; background:url(\'//platform.tumblr.com/v1/share_4T.png\') top left no-repeat transparent;">'.JText::_("MOD_ITPSHARE_SHARE_THUMBLR").'</a>';
                    break;   
                default:
                    $html .='<a href="http://www.tumblr.com/share" title="'.JText::_("MOD_ITPSHARE_SHARE_THUMBLR").'" style="display:inline-block; text-indent:-9999px; overflow:hidden; width:81px; height:20px; background:url(\'//platform.tumblr.com/v1/share_1.png\') top left no-repeat transparent;">'.JText::_("MOD_ITPSHARE_SHARE_THUMBLR").'</a>';
                    break;
            }
            
            $html .='</div>';
        }
        
        return $html;
    }
    
    public static function getPinterest($params, $url, $title){
        
        $html = "";
        if($params->get("pinterestButton")) {
            
            $bubblePosition = $params->get("pinterestType", "beside");
            
            $divClass = (strcmp("above", $bubblePosition) == 0) ? "itp-share-pinterest-above" : "itp-share-pinterest";

            $html .= '<div class="'.$divClass.'">';
            
            if(strcmp("one", $params->get('pinterestImages', "one")) == 0) {
                $html .= '<a href="http://pinterest.com/pin/create/button/?url=' . rawurlencode($url) . '&amp;description=' . rawurlencode($title) . '" data-pin-do="buttonPin" data-pin-config="'.$params->get("pinterestType", "beside").'"><img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" /></a>';
            } else {
                $html .= '<a href="//pinterest.com/pin/create/button/" data-pin-do="buttonBookmark" ><img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" /></a>';
            }
            
            
            $html .= '</div>';
            
            // Load the JS library
            if($params->get("loadPinterestJsLib")) {
                $html .= '
<script type="text/javascript">
    (function(d){
      var f = d.getElementsByTagName("SCRIPT")[0], p = d.createElement("SCRIPT");
      p.type = "text/javascript";
      p.async = true;
      p.src = "//assets.pinterest.com/js/pinit.js";
      f.parentNode.insertBefore(p, f);
    }(document));
</script>
';
            }
        }
        
        return $html;
    }
    
    public static function getStumbpleUpon($params, $url){
        
        $html = "";
        if($params->get("stumbleButton")) {
            
            $html = "
            <div class=\"itp-share-su\">
            <su:badge layout='" . $params->get("stumbleType", 1). "'></su:badge>
            </div>
            
            <script>
          (function() {
            var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true;
            li.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + '//platform.stumbleupon.com/1/widgets.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s);
          })();
        </script>
            ";
        }
        
        return $html;
    }
    
    public static function getBuffer($params, $url, $title){
        
        $html = "";
        if($params->get("bufferButton")) {
            
            $title  = htmlentities($title, ENT_QUOTES, "UTF-8");
            
            $html = '
            <div class="itp-share-buffer">
            <a href="http://bufferapp.com/add" class="buffer-add-button" data-text="' . $title . '" data-url="'.$url.'" data-count="'.$params->get("bufferType").'" data-via="'.$params->get("bufferTwitterName").'">Buffer</a><script src="//static.bufferapp.com/js/button.js"></script>
            </div>
            ';
        }
        
        return $html;
    }
    
    
    public static function getButtonsLocales($locale) {
        
         // Default locales
        $result = array(
            "twitter"     => "en",
        	"facebook"    => "en_US",
        	"google"      => "en"
        );
        
        // The locales map
        $locales = array (
            "en_US" => array(
                "twitter"     => "en",
            	"facebook"    => "en_US",
            	"google"      => "en"
            ),
            "en_GB" => array(
                "twitter"     => "en",
            	"facebook"    => "en_GB",
            	"google"      => "en_GB"
            ),
            "th_TH" => array(
                "twitter"     => "th",
            	"facebook"    => "th_TH",
            	"google"      => "th"
            ),
            "ms_MY" => array(
                "twitter"     => "msa",
            	"facebook"    => "ms_MY",
            	"google"      => "ms"
            ),
            "tr_TR" => array(
                "twitter"     => "tr",
            	"facebook"    => "tr_TR",
            	"google"      => "tr"
            ),
            "hi_IN" => array(
                "twitter"     => "hi",
            	"facebook"    => "hi_IN",
            	"google"      => "hi"
            ),
            "tl_PH" => array(
                "twitter"     => "fil",
            	"facebook"    => "tl_PH",
            	"google"      => "fil"
            ),
            "zh_CN" => array(
                "twitter"     => "zh-cn",
            	"facebook"    => "zh_CN",
            	"google"      => "zh"
            ),
            "ko_KR" => array(
                "twitter"     => "ko",
            	"facebook"    => "ko_KR",
            	"google"      => "ko"
            ),
            "it_IT" => array(
                "twitter"     => "it",
            	"facebook"    => "it_IT",
            	"google"      => "it"
            ),
            "da_DK" => array(
                "twitter"     => "da",
            	"facebook"    => "da_DK",
            	"google"      => "da"
            ),
            "fr_FR" => array(
                "twitter"     => "fr",
            	"facebook"    => "fr_FR",
            	"google"      => "fr"
            ),
            "pl_PL" => array(
                "twitter"     => "pl",
            	"facebook"    => "pl_PL",
            	"google"      => "pl"
            ),
            "nl_NL" => array(
                "twitter"     => "nl",
            	"facebook"    => "nl_NL",
            	"google"      => "nl"
            ),
            "id_ID" => array(
                "twitter"     => "in",
            	"facebook"    => "nl_NL",
            	"google"      => "in"
            ),
            "hu_HU" => array(
                "twitter"     => "hu",
            	"facebook"    => "hu_HU",
            	"google"      => "hu"
            ),
            "fi_FI" => array(
                "twitter"     => "fi",
            	"facebook"    => "fi_FI",
            	"google"      => "fi"
            ),
            "es_ES" => array(
                "twitter"     => "es",
            	"facebook"    => "es_ES",
            	"google"      => "es"
            ),
            "ja_JP" => array(
                "twitter"     => "ja",
            	"facebook"    => "ja_JP",
            	"google"      => "ja"
            ),
            "nn_NO" => array(
                "twitter"     => "no",
            	"facebook"    => "nn_NO",
            	"google"      => "no"
            ),
            "ru_RU" => array(
                "twitter"     => "ru",
            	"facebook"    => "ru_RU",
            	"google"      => "ru"
            ),
            "pt_PT" => array(
                "twitter"     => "pt",
            	"facebook"    => "pt_PT",
            	"google"      => "pt"
            ),
            "pt_BR" => array(
                "twitter"     => "pt",
            	"facebook"    => "pt_BR",
            	"google"      => "pt"
            ),
            "sv_SE" => array(
                "twitter"     => "sv",
            	"facebook"    => "sv_SE",
            	"google"      => "sv"
            ),
            "zh_HK" => array(
                "twitter"     => "zh-tw",
            	"facebook"    => "zh_HK",
            	"google"      => "zh_HK"
            ),
            "zh_TW" => array(
                "twitter"     => "zh-tw",
            	"facebook"    => "zh_TW",
            	"google"      => "zh_TW"
            ),
            "de_DE" => array(
                "twitter"     => "de",
            	"facebook"    => "de_DE",
            	"google"      => "de"
            ),
            "bg_BG" => array(
                "twitter"     => "en",
            	"facebook"    => "bg_BG",
            	"google"      => "bg"
            ),
            
        );
        
        if(isset($locales[$locale])) {
            $result = $locales[$locale];
        }
        
        return $result;
        
    }
    
    public static function getGoogleShare($params, $url){
        
        $html = "";
        if($params->get("gsButton")) {
            
        	// Get locale code
            if(!$params->get("dynamicLocale")) {
                $locale   = $params->get("gsLocale", "en");
            } else {
                $tag      = JFactory::getLanguage()->getTag();
                $locale   = str_replace("-","_", $tag);
                $locales  = self::getButtonsLocales($locale); 
                $locale   = JArrayHelper::getValue($locales, "google", "en");
            }
            
            $html .= '<div class="itp-share-gshare">';
            
            switch($params->get("gsRenderer")) {
                
                case 1:
                    $html .= self::genGoogleShare($params, $url);
                    break;
                    
                default:
                    $html .= self::genGoogleShareHTML5($params, $url);
                    break;
            }
            
            // Load the JavaScript asynchroning
        	if($params->get("loadGoogleJsLib")) {
        
                $html .= '<script>';
                $html .= ' window.___gcfg = {lang: "'.$locale.'"}; ';
                
                $html .= '
                  (function() {
                    var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
                    po.src = "https://apis.google.com/js/plusone.js";
                    var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);
                  })();
                </script>';
            }
          
            $html .= '</div>';
        }
        
        return $html;
    }
    
    /**
     * 
     * Render the Google Share in standart syntax
     * 
     * @param array $params
     * @param string $url
     * @param string $language
     */
    public static function genGoogleShare($params, $url) {
        
        $annotation = "";
        if($params->get("gsAnnotation")) {
            $annotation = ' annotation="' . $params->get("gsAnnotation") . '"';
        }
        
        $size = "";
        if($params->get("gsAnnotation") != "vertical-bubble") {
            $size = ' height="' . $params->get("gsType") . '" ';
        }
        
        $html = '<g:plus action="share" ' . $annotation . $size . ' href="' . $url . '"></g:plus>';
        
        return $html;
    }
    
    /**
     * 
     * Render the Google Share in HTML5 syntax
     * 
     * @param array $params
     * @param string $url
     * @param string $language
     */
    public static function genGoogleShareHTML5($params, $url) {
        
        $annotation = "";
        if($params->get("gsAnnotation")) {
            $annotation = ' data-annotation="' . $params->get("gsAnnotation") . '"';
        }
        
        $size = "";
        if($params->get("gsAnnotation") != "vertical-bubble") {
            $size = ' data-height="' . $params->get("gsType") . '" ';
        }
        
        $html = '<div class="g-plus" data-action="share" ' . $annotation . $size . ' data-href="' . $url . '"></div>';

        return $html;
    }
    
}