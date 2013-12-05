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
class AvatarCompress extends JObject {
	
	public $_context;
	public $_jtemplate;
	public $_scripts = array();
	public $_styleSheets = array();
	public $_cacheCSSFile;
	public $_cacheJSFile;
	public $_cacheFolder;
	
	public function __construct($context = null) 
	{
		$this->_context 		= $context;
		$this->_jtemplate 		= $this->_context->get('_jtemplate');
		
		$this->setOptimize();
		$this->getFileInDocument();
		$this->checkCacheFolder();
	}
	
	/**
	 * set optimize info
	 */
	 
	public function setOptimize() 
	{
		$this->_cacheFolder 	= JPATH_ROOT.DIRECTORY_SEPARATOR.'cache/'.$this->_jtemplate->template;
		$this->_cacheCSSFile 	= $this->_cacheFolder.DIRECTORY_SEPARATOR.'template.css';
		$this->_cacheJSFile 	= $this->_cacheFolder.DIRECTORY_SEPARATOR.'template.js';
		$this->_cacheCSSFileURI = JURI::base().'cache/'.$this->_jtemplate->template.'/template.css';
		$this->_cacheJSFileURI 	= JURI::base().'cache/'.$this->_jtemplate->template.'/template.js';
		$this->_controllerGzip 	= $this->_jtemplate->baseurl .'/templates/'.$this->_jtemplate->template.'/core/controllers/gzip.php';
		
		// Gzip
		if ($this->_context->_optimize == 4 && $this->checkLibraries()) {
			$this->_cacheCSSFileURI = $this->_controllerGzip . '?' . base64_encode($this->_cacheCSSFile);
			$this->_cacheJSFileURI = $this->_controllerGzip . '?' . base64_encode($this->_cacheJSFile);
		}
	}
	
	/**
	 * check cache folder for this template and create that folder if it does not exists
	 * @return true/fasle
	 */
	public function checkCacheFolder() 
	{
		if (!JFolder::exists($this->_cacheFolder)) 
		{
			if (JFolder::create($this->_cacheFolder)) {
				$content = '<!DOCTYPE html><title></title>';
				JFile::write($this->_cacheFolder.DIRECTORY_SEPARATOR.'index.html', $content);
				
				return true;
			}
			
			return false;		
		}
		return true;
	}
	
	/**
	 * set all scripts and stylesheets are loaded   
	 */
	public function getFileInDocument() 
	{
		$this->setCompressFilesDocument('_scripts');
		$this->setCompressFilesDocument();
		$this->templateFiles();
	}
	
	public function setCompressFilesDocument($type = '_styleSheets') 
	{
		$files = $this->_jtemplate->$type;
		
		foreach ($files as $k => $v) {
			$this->{$type}[$k] = $k;
		}
			
		$this->_jtemplate->$type = array();
	}
	
	/**
	 * get all CSS files in showcase
	 */
	public function templateFiles()
	{
		$files = $this->_context->getCSSFiles();
		
		foreach ($files as $v) {
			$this->_styleSheets[$v] = $v;
		}	
		
		$files = $this->_context->getJSFiles();
		
		foreach ($files as $v) {
			$this->_scripts[$v] = $v;
		}	
	}
	
	/**
	 * check requirement libs
	 * @return true/false
	 */
	public function checkLibraries() 
	{
		if (extension_loaded('zlib') && !ini_get('zlib.output_compression') && ini_get('output_handler') != 'ob_gzhandler') {
			return true;
		}
		
		return false;
	}
	
	public function compress() 
	{
		$this->compressCSS();
		$this->compressJavascript();
	}
	
	public function compressCSS()
	{
		if ($this->_context->_optimize == 1 || $this->_context->_optimize == 3 || $this->_context->_optimize == 4) 
		{
			// don't create if files have exists
			if (!JFile::exists($this->_cacheCSSFile)) 
			{
				Avatar::import('core.libraries.minify.css');
				$options = array('prependRelativePath' => '../');
				$path = dirname(JPATH_ROOT);
				$output = '';
				
				foreach ($this->_styleSheets as $style) 
				{
					$options = array('currentDir' => $path.dirname($style));
					
					$source = @file_get_contents($path.$style);
					$output .= Minify_CSS::minify($source, $options);
				}
				
				file_put_contents($this->_cacheCSSFile, $output);
			}
			
			$this->_jtemplate->setHeadData(array('styleSheets' => array(
												$this->_cacheCSSFileURI => array(
														'mime' => 'text/css',
														'defer' => false,
														'async' => false,
														'media' => false,
														'attribs' => false
													))));
		}
	}	

	public function compressJavascript()
	{
		if ($this->_context->_optimize == 2 || $this->_context->_optimize == 3 || $this->_context->_optimize == 4) 
		{
			// don't create if files have exists
			if (!JFile::exists($this->_cacheJSFile)) 
			{
				Avatar::import('core.libraries.minify.jsmin');
				$path = dirname(JPATH_ROOT);
				$output = '';
				
				foreach ($this->_scripts as $script)  
				{
					$source = @file_get_contents($path.$script);
					$output .= JSMin::minify($source);
				}
				
				file_put_contents($this->_cacheJSFile, $output);			
			}
			
			$this->_jtemplate->setHeadData(array('scripts' => array(
												$this->_cacheJSFileURI => array(
														'mime' => 'text/javascript',
														'defer' => false,
														'async' => false,
														'media' => false,
														'attribs' => false
													))));
		}
	}
}
