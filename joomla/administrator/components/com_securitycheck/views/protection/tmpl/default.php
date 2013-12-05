<?php
/**
* Securitycheck Protection View para el Componente Securitycheck
* @ author Jose A. Luque
* @ Copyright (c) 2011 - Jose A. Luque
* @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*/

// Protect from unauthorized access
defined('_JEXEC') or die();
JRequest::checkToken( 'get' ) or die( 'Invalid Token' );

$script = <<<ENDSCRIPT
window.addEvent( 'domready' ,  function() {
	$('generate').addEvent('click',function(e){
		e.preventDefault();
		$('task').setProperty('value','generate');
		document.forms.adminForm.submit();
	});
});
ENDSCRIPT;
$document = JFactory::getDocument();
$document->addScriptDeclaration($script,'text/javascript');

function booleanlist( $name, $attribs = null, $selected = null, $id=false )
{
	$arr = array(
		JHTML::_('select.option',  '0', JText::_( 'COM_SECURITYCHECK_NO' ) ),
		JHTML::_('select.option',  '1', JText::_( 'COM_SECURITYCHECK_YES' ) )
	);
	return JHTML::_('select.genericlist',  $arr, $name, $attribs, 'value', 'text', (int) $selected, $id );
}

JHTML::_( 'behavior.framework' );

// Add style declaration
$media_url = "media/com_securitycheck/stylesheets/cpanelui.css";
JHTML::stylesheet($media_url);

$bootstrap_css = "media/com_securitycheck/stylesheets/bootstrap.min.css";
JHTML::stylesheet($bootstrap_css);

$site_url = JURI::base();
?>

<div class="securitycheck-bootstrap">
<?php
	if ($this->server == 'apache'){
?>
<div class="alert alert-warn">
	<?php echo JText::_('COM_SECURITYCHECK_USER_AGENT_INTRO'); ?>
</div>
<div class="alert alert-error">
	<?php echo JText::_('COM_SECURITYCHECK_USER_AGENT_WARN'); ?>	
</div>
<div class="alert alert-info">
<?php if($this->ExistsHtaccess) { 
		echo JText::_('COM_SECURITYCHECK_USER_AGENT_HTACCESS');
	  } else { 
	  	echo JText::_('COM_SECURITYCHECK_USER_AGENT_NO_HTACCESS');
} ?>
</div>
<?php
	} else if ($this->server == 'nginx'){
?>
<div class="alert alert-error">
	<?php echo JText::_('COM_SECURITYCHECK_NGINX_SERVER'); ?>	
</div>
<?php
	}
?>

<form action="index.php" name="adminForm" id="adminForm" method="post" class="form form-horizontal">
	<input type="hidden" name="option" value="com_securitycheck" />
	<input type="hidden" name="view" value="protection" />
	<input type="hidden" name="boxchecked" value="1" />
	<input type="hidden" name="task" id="task" value="save" />
	<input type="hidden" name="controller" value="protection" />
	<?php echo JHTML::_( 'form.token' ); ?>
	
		
	<fieldset>
		<legend><?php echo JText::_('COM_SECURITYCHECK_BACKEND_PROTECTION_TEXT') ?></legend>
		
		<div class="alert alert-error">
			<?php echo JText::_('COM_SECURITYCHECK_BACKEND_PROTECTION_EXPLAIN'); ?>	
		</div>
		
		<div class="control-group">
			<label for="hide_backend_url" class="control-label-more-width" title="<?php echo JText::_('COM_SECURITYCHECK_HIDE_BACKEND_URL_EXPLAIN') ?>"><?php echo JText::_('COM_SECURITYCHECK_HIDE_BACKEND_URL_TEXT'); ?></label>
			<div class="controls controls-row">
				<div class="input-prepend">
					<span class="add-on" style="background-color: #FFBF60;"><?php echo $site_url ?>?</span>
					<span class="input-large uneditable-input" name="hide_backend_url" id="hide_backend_url"><?php echo $this->protection_config['hide_backend_url'] ?></span>
				</div>
				<input type="submit" class="btn btn-primary" id="generate" value="<?php echo JText::_('COM_SECURITYCHECK_HIDE_BACKEND_GENERATE_KEY_TEXT') ?>" />
				<?php if ( $this->config_applied['hide_backend_url'] ) {?>
					<span class="help-inline">
						<div class="applied">
							<?php echo JText::_('COM_SECURITYCHECK_APPLIED') ?>
						</div>
					</span>
				<?php } ?>
			</div>
			<blockquote><p class="text-info"><small><?php echo JText::_('COM_SECURITYCHECK_HIDE_BACKEND_URL_EXPLAIN') ?></small></p></blockquote>
		</div>
	</fieldset>
</form>

</div>