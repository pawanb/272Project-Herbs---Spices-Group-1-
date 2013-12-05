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

/* The following line loads the MooTools JavaScript Library */
JHtml::_('behavior.framework', true);

/* The following line gets the application object for things like displaying the site name */
$app = JFactory::getApplication();
$template = $this->_jtemplate;
$posTop		 	= $template->countModules('top');
$posTopLeft 	= $template->countModules('top-left');
$posTopMiddle 	= $template->countModules('top-middle'); 
$posTopRight 	= $template->countModules('top-right');
		
$posPromoTopLeft 	= $template->countModules('promo-top-left');
$posPromoTopMiddle 	= $template->countModules('promo-top-middle');
$posPromoTopRight 	= $template->countModules('promo-top-right');

$posUser8 			= $template->countModules('user-8');
$posUser9 			= $template->countModules('user-9');
$posUser10 			= $template->countModules('user-10');

$posUser11 			= $template->countModules('user-11');
$posUser12			= $template->countModules('user-12');
$posUser13 			= $template->countModules('user-13');
$posUser14 			= $template->countModules('user-14');

$posContentTop 		= $template->countModules('content-top');
			 
$posLeftTop 	= $template->countModules('left-top');
$posLeftMiddle1 = $template->countModules('left-middle-1');
$posLeftMiddle2 = $template->countModules('left-middle-2');
$posLeftBottom 	= $template->countModules('left-bottom');
			 
$posUser1 = $template->countModules('user-1');
$posUser2 = $template->countModules('user-2');
			 
$posUser3 = $template->countModules('user-3');
$posUser4 = $template->countModules('user-4');
			 
$posRightTop 		= $template->countModules('right-top');
$posRightMiddle1 	= $template->countModules('right-middle-1');
$posRightMiddle2 	= $template->countModules('right-middle-2');
$posRightBottom 	= $template->countModules('right-bottom');
			 
$posPromoBottomLeft 	= $template->countModules('promo-bottom-left');
$posPromoBottomMiddle 	= $template->countModules('promo-bottom-middle');
$posPromoBottomRight 	= $template->countModules('promo-bottom-right');

$posUser5 		= $template->countModules('user-5');
$posUser6 		= $template->countModules('user-6');
$posUser7 		= $template->countModules('user-7');
$posUser15 		= $template->countModules('user-15');
$posUser16		= $template->countModules('user-16');
$posUser17 		= $template->countModules('user-17');
$posUser18 		= $template->countModules('user-18');
$posUser19 		= $template->countModules('user-19');
$posUser20 		= $template->countModules('user-20');

$posContentBottom = $template->countModules('content-bottom');

$posFooter	 		= $template->countModules('footer');
$posFooterLeft 		= $template->countModules('footer-left');
$posFooterMiddle 	= $template->countModules('footer-middle');
$posFooterRight 	= $template->countModules('footer-right');
$posFooter1 = $template->countModules('footer-1');
$posFooter2 = $template->countModules('footer-2');
$posFooter3 = $template->countModules('footer-3');
$posFooter4 = $template->countModules('footer-4');
$posFooter5 = $template->countModules('footer-5');
$posFooter6 = $template->countModules('footer-6');
?>
<?php echo $this->getDoctype(); ?>
<!-- <?php echo Avatar::getTemplateInfo(); ?> -->
<html lang="<?php echo $template->language; ?>" dir="<?php echo $template->direction; ?>" >
	<head>
		<?php 
			echo $this->addHead();
			
			$posTopMiddleWidth = '100';
			
			if ($posTopLeft || $posTopMiddle || $posTopRight) {
				$posTopMiddleWidth = 100 - $template->params->get('top_left') - $template->params->get('top_right');
			}
			
			$posFooterMiddleWidth = '100';
			
			if ($posFooterLeft || $posFooterMiddle || $posFooterRight) {
				$posFooterMiddleWidth = 100 - $template->params->get('footer_left') - $template->params->get('footer_right');
			}
			
			$posPromoTopMiddleWidth = '100';
			
			if ($posPromoTopLeft || $posPromoTopMiddle || $posPromoTopRight) {
				$posPromoTopMiddleWidth = 100 - $template->params->get('promo_top_left') - $template->params->get('promo_top_right');
			}
			
			$posPromoBottomMiddleWidth = '100';
			
			if ($posPromoBottomLeft || $posPromoBottomMiddle || $posPromoBottomRight) {
				$posPromoBottomMiddleWidth = 100 - $template->params->get('promo_bottom_left') - $template->params->get('promo_bottom_right');
			}
			
			$avatarMainContentWidth = '100';
			
			if ($template->countModules('inner-right')) {
				$avatarMainContentWidth = $avatarMainContentWidth - $template->params->get('inner_right');
			}
			
			if ($template->countModules('inner-left')) {
				$avatarMainContentWidth = $avatarMainContentWidth - $template->params->get('inner_left');
			}
			
			$avatarContentWidth = '100';
			
			if ($posLeftTop || $posLeftMiddle1 || $posLeftMiddle2 || $posLeftBottom) {
				$avatarContentWidth = $avatarContentWidth - $template->params->get('left');
			}
			
			if ($posRightTop || $posRightMiddle1 || $posRightMiddle2 || $posRightBottom) {
				$avatarContentWidth = $avatarContentWidth - $template->params->get('right');
			}
		?>
		<style type="text/css">
			.avatar-wrapper{
				width: <?php echo $template->params->get('template_width'); ?>;
				margin: auto;
			}
			
			#avatar-pos-top-left {
				width: <?php echo $template->params->get('top_left'); ?>%;
			}
			#avatar-pos-top-middle {
				width: <?php echo $posTopMiddleWidth; ?>%;
			}
			#avatar-pos-top-right {
				width: <?php echo $template->params->get('top_right'); ?>%;
			}
			
			#avatar-pos-footer-left {
				width: <?php echo $template->params->get('footer_left'); ?>%;
			}
			#avatar-pos-footer-middle {
				width: <?php echo $posFooterMiddleWidth; ?>%;
			}
			#avatar-pos-footer-right {
				width: <?php echo $template->params->get('footer_right'); ?>%;
			}
			
			#avatar-pos-promo-top-left {
				width: <?php echo $template->params->get('promo_top_left'); ?>%;
			}
			#avatar-pos-promo-top-middle {
				width: <?php echo $posPromoTopMiddleWidth; ?>%;
			}
			#avatar-pos-promo-top-right {
				width: <?php echo $template->params->get('promo_top_right'); ?>%;
			}
			
			#avatar-pos-promo-bottom-left {
				width: <?php echo $template->params->get('promo_bottom_left'); ?>%;
			}
			#avatar-pos-promo-bottom-middle {
				width: <?php echo $posPromoBottomMiddleWidth; ?>%;
			}
			#avatar-pos-promo-bottom-right {
				width: <?php echo $template->params->get('promo_bottom_right'); ?>%;
			}
			
			#avatar-left {
				width: <?php echo $template->params->get('left'); ?>%;
			}
			#avatar-right {
				width: <?php echo $template->params->get('right'); ?>%;
			}
			#avatar-content {
				width: <?php echo $avatarContentWidth; ?>%;
			}
			#avatar-pos-inner-left {
				width: <?php echo $template->params->get('inner_left'); ?>%;
			}
			#avatar-pos-inner-right {
				width: <?php echo $template->params->get('inner_right'); ?>%;
			}
			
			#avatar-main-content{
				width: <?php echo $avatarMainContentWidth; ?>%;
			}
			<?php if ($template->params->get('go_to_top') && $template->params->get('go_to_top_css')): ?>
				#avatat-go-to-top {
					<?php echo $template->params->get('go_to_top_css');?>
				}
			<?php endif; ?>
		</style>
		
		<?php echo $this->addGoogleAnalytics(); ?>
	</head>
	<body id="avatar-template" class="<?php echo ($this->_responsive) ? 'avatar-responsive' : ''; echo ($template->params->get('css3_effect')) ? ' css3-effect ' : ''; echo ' '.$this->getMenuClass(); ?>">
		<a name="top" id="top"></a>
		<div class="clearfix">
			<?php if ($template->params->get('go_to_top')): ?>
				<a id="avatar-go-to-top" href="#top">
					<span><?php echo $template->params->get('go_to_top_text'); ?></span>
				</a>
			<?php endif; ?>
			<?php if ($template->countModules('stick-left-top')) : ?>
				<div class="avatar-position-stick" id="avatar-position-stick-left-top">
					<jdoc:include type="modules" name="stick-left-top" style="avatarmodule" />
				</div>
			<?php endif; ?>
			
			<?php if ($template->countModules('stick-left-middle')) : ?>
				<div class="avatar-position-stick" id="avatar-position-stick-left-middle">
					<jdoc:include type="modules" name="stick-left-middle" style="avatarmodule" />
				</div>
			<?php endif; ?>
			
			<?php if ($template->countModules('stick-left-bottom')) : ?>
				<div class="avatar-position-stick" id="avatar-position-stick-left-bottom">
					<jdoc:include type="modules" name="stick-left-bottom" style="avatarmodule" />
				</div>
			<?php endif; ?>
			
			<?php if ($template->countModules('stick-right-top')) : ?>
				<div class="avatar-position-stick" id="avatar-position-stick-right-top">
					<jdoc:include type="modules" name="stick-right-top" style="avatarmodule" />
				</div>
			<?php endif; ?>
			
			<?php if ($template->countModules('stick-right-middle')) : ?>
				<div class="avatar-position-stick" id="avatar-position-stick-right-middle">
					<jdoc:include type="modules" name="stick-right-middle" style="avatarmodule" />
				</div>
			<?php endif; ?>
			
			<?php if ($template->countModules('stick-right-bottom')) : ?>
				<div class="avatar-position-stick" id="avatar-position-stick-right-bottom">
					<jdoc:include type="modules" name="stick-right-bottom" style="avatarmodule" />
				</div>
			<?php endif; ?>
			<?php if ($template->countModules('stick-right-bottom')) : ?>
				<div class="avatar-position-stick" id="avatar-position-stick-right-bottom">
					<jdoc:include type="modules" name="stick-right-bottom" style="avatarmodule" />
				</div>
			<?php endif; ?>
			<?php if ($template->countModules('fixed-1')) : ?>
				<div class="avatar-position-stick" id="avatar-position-fixed-1">
					<jdoc:include type="modules" name="fixed-1" style="avatarmodule" />
				</div>
			<?php endif; ?>
			<?php if ($template->countModules('fixed-2')) : ?>
				<div class="avatar-position-stick" id="avatar-position-fixed-2">
					<jdoc:include type="modules" name="fixed-2" style="avatarmodule" />
				</div>
			<?php endif; ?>
			
			<?php if ($posTop): ?>
				<div id="avatar-header-block">
					<div class="avatar-wrapper <?php echo $template->params->get('avatar_header_block'); ?>">
						<jdoc:include type="modules" name="top" style="avatarmodule" />
					</div>
				</div>
			<?php endif; ?>
			
			<?php if ($posTopLeft || $posTopMiddle || $posTopRight): ?>
				<div id="avatar-header-inside-block">
					<div class="avatar-wrapper <?php echo $template->params->get('avatar_header_inside_block'); ?>">
					<?php if ($posTopLeft): ?>
						<div id="avatar-pos-top-left">
							<jdoc:include type="modules" name="top-left" style="avatarmodule" />
						</div>
					<?php endif; ?>
					
					<?php if ($posTopMiddle): ?>
						<div id="avatar-pos-top-middle">
							<jdoc:include type="modules" name="top-middle" style="avatarmodule" />
						</div>
					<?php endif; ?>
					
					<?php if ($posTopRight): ?>
						<div id="avatar-pos-top-right">
							<jdoc:include type="modules" name="top-right" style="avatarmodule" />
						</div>
					<?php endif; ?>
					<div class="clearbreak"></div>
					</div>
				</div>
			<?php endif; ?>
			
			<?php if ($template->countModules('tool')): ?>
				<div id="avatar-tool-block">
					<div class="avatar-wrapper <?php echo $template->params->get('avatar_tool_block'); ?>">
						<jdoc:include type="modules" name="tool" style="avatarmodule" />
					</div>
				</div>
			<?php endif; ?>
			<?php if ($template->countModules('full-1')): ?>
				<div id="avatar-full-1-block">
					<div class="avatar-wrapper <?php echo $template->params->get('avatar_full_1_block'); ?>">
						<jdoc:include type="modules" name="full-1" style="avatarmodule" />
					</div>
				</div>
			<?php endif; ?>
			<?php if ($posPromoTopLeft || $posPromoTopMiddle || $posPromoTopRight || $posUser10 || $posUser8 || $posUser9 || $posContentTop) :?>
				<div id="avatar-body-top-block">
					<div class="avatar-wrapper <?php echo $template->params->get('avatar_body_top_block'); ?>">
					<?php if ($posPromoTopLeft || $posPromoTopMiddle || $posPromoTopRight ): ?>
						<div id="avatar-promo-top">
							<?php if ($posPromoTopLeft): ?>
								<div id="avatar-pos-promo-top-left">
									<jdoc:include type="modules" name="promo-top-left" style="avatarmodule" />
								</div>
							<?php endif; ?>
							
							<?php if ($posPromoTopMiddle): ?>
								<div id="avatar-pos-promo-top-middle">
									<jdoc:include type="modules" name="promo-top-middle" style="avatarmodule" />
								</div>
							<?php endif; ?>
							
							<?php if ($posPromoTopRight): ?>
								<div id="avatar-pos-promo-top-right">
									<jdoc:include type="modules" name="promo-top-right" style="avatarmodule" />
								</div>
							<?php endif; ?>
							<div class="clearbreak"></div>
						</div>
					<?php endif; ?>
					
					<?php if ($posContentTop): ?>
						<div id="avatar-pos-content-top">
							<jdoc:include type="modules" name="content-top" style="avatarmodule" />
						</div>
					<?php endif; ?>
					
					<?php if ($posUser10 || $posUser8 || $posUser9): ?>
						<div id="avatar-user-top-col-3">
							<?php if ($posUser8): ?>
								<div id="avatar-pos-user-8">
									<jdoc:include type="modules" name="user-8" style="avatarmodule" />
								</div>
							<?php endif; ?>
							
							<?php if ($posUser9): ?>
								<div id="avatar-pos-user-9">
									<jdoc:include type="modules" name="user-9" style="avatarmodule" />
								</div>
							<?php endif; ?>
							
							<?php if ($posUser10): ?>
								<div id="avatar-pos-user-10">
									<jdoc:include type="modules" name="user-10" style="avatarmodule" />
								</div>
							<?php endif; ?>
							<div class="clearbreak"></div>
						</div>
					<?php endif;?>
					
					<?php if ($posUser11 || $posUser12 || $posUser13 || $posUser14): ?>
						<div id="avatar-user-top-col-4">
							<?php if ($posUser11): ?>
								<div id="avatar-pos-user-11">
									<jdoc:include type="modules" name="user-11" style="avatarmodule" />
								</div>
							<?php endif; ?>
							
							<?php if ($posUser12): ?>
								<div id="avatar-pos-user-12">
									<jdoc:include type="modules" name="user-12" style="avatarmodule" />
								</div>
							<?php endif; ?>
							
							<?php if ($posUser13): ?>
								<div id="avatar-pos-user-13">
									<jdoc:include type="modules" name="user-13" style="avatarmodule" />
								</div>
							<?php endif; ?>
							
							<?php if ($posUser14): ?>
								<div id="avatar-pos-user-14">
									<jdoc:include type="modules" name="user-14" style="avatarmodule" />
								</div>
							<?php endif; ?>
							<div class="clearbreak"></div>
						</div>
					<?php endif;?>
					</div>
				</div>
			<?php endif; ?>		
			<?php if ($template->countModules('full-2')): ?>
				<div id="avatar-full-2-block">
					<div class="avatar-wrapper <?php echo $template->params->get('avatar_full_2_block'); ?>">
						<jdoc:include type="modules" name="full-2" style="avatarmodule" />
					</div>
				</div>
			<?php endif; ?>
			<?php if ($template->countModules('full-3')): ?>
				<div id="avatar-full-3-block">
					<div class="avatar-wrapper <?php echo $template->params->get('avatar_full_3_block'); ?>">
						<jdoc:include type="modules" name="full-3" style="avatarmodule" />
					</div>
				</div>
			<?php endif; ?>
			<?php if ($template->countModules('full-4')): ?>
				<div id="avatar-full-4-block">
					<div class="avatar-wrapper <?php echo $template->params->get('avatar_full_4_block'); ?>">
						<jdoc:include type="modules" name="full-4" style="avatarmodule" />
					</div>
				</div>
			<?php endif; ?>
			<?php if ($template->countModules('full-5')): ?>
				<div id="avatar-full-5-block">
					<div class="avatar-wrapper <?php echo $template->params->get('avatar_full_5_block'); ?>">
						<jdoc:include type="modules" name="full-5" style="avatarmodule" />
					</div>
				</div>
			<?php endif; ?>
			
			<?php 
				$hasRightCol = false;
				$hasLeftCol = false;
				if ($posRightTop || $posRightMiddle1 || $posRightMiddle2 || $posRightBottom) {
					$hasRightCol = true;
				} 
				if ($posLeftTop || $posLeftMiddle1 || $posLeftMiddle2 || $posLeftBottom) {
					$hasLeftCol = true;
				}
			?>
			
			<div id="avatar-body-middle-block" class="<?php echo ($hasLeftCol) ? 'has-left-col' :''; ?> <?php echo ($hasRightCol) ? 'has-right-col' :''; ?>">
				<div class="avatar-wrapper <?php echo $template->params->get('avatar_body_middle_block'); ?>">
				<?php if ($hasLeftCol): ?>
					<div id="avatar-left">
						<?php if ($posLeftTop): ?>
							<div id="avatar-pos-left-top">
								<jdoc:include type="modules" name="left-top" style="avatarmodule" />
							</div>
						<?php endif; ?>
						
						<?php if ($posLeftMiddle1 || $posLeftMiddle2): ?>
							<div id="avatar-pos-left-middle">
								<?php if ($posLeftMiddle1): ?>
									<div id="avatar-pos-left-middle-1">
										<jdoc:include type="modules" name="left-middle-1" style="avatarmodule" />
									</div>
								<?php endif; ?>	
								
								<?php if ($posLeftMiddle2): ?>
									<div id="avatar-pos-left-middle-2">
										<jdoc:include type="modules" name="left-middle-2" style="avatarmodule" />
									</div>
								<?php endif; ?>
								<div class="clearbreak"></div>
							</div>
						<?php endif; ?>
						
						<?php if ($posLeftBottom): ?>
							<div id="avatar-pos-left-bottom">
								<jdoc:include type="modules" name="left-bottom" style="avatarmodule" />
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				
				<div id="avatar-content">
					<?php if ($template->countModules('inner-left')):?>
						<div id="avatar-pos-inner-left">
							<jdoc:include type="modules" name="inner-left" style="avatarmodule" />
						</div>
					<?php endif; ?>
					
					<div id="avatar-main-content">
						<div id="avatar-main-content-inner">
						<?php if ($template->countModules('breadcrumbs')): ?>
							<div id="avatar-pos-breadcrumbs">
								<jdoc:include type="modules" name="breadcrumbs" style="avatarmodule" />
							</div>	
						<?php endif; ?>
						
						<?php if ($template->params->get('show_message')): ?>
							<div id="avatar-pos-message">
								<jdoc:include type="message" />
							</div>	
						<?php endif; ?>
						
						<?php if ($template->countModules('banner-top')): ?>
							<div id="avatar-pos-banner-top">
								<jdoc:include type="modules" name="banner-top" style="avatarmodule" />
							</div>	
						<?php endif; ?>
						
						<?php if ($template->countModules('user-top')): ?>
							<div id="avatar-pos-content-user-top">
								<jdoc:include type="modules" name="user-top" style="avatarmodule" />
							</div>	
						<?php endif; ?>
						
						<?php if ($posUser1 || $posUser2): ?>
							<div id="avatar-content-user-top">
								<?php if ($posUser1): ?>
									<div id="avatar-pos-content-user-1">
										<jdoc:include type="modules" name="user-1" style="avatarmodule" />
									</div>	
								<?php endif; ?>
								<?php if ($posUser2): ?>
									<div id="avatar-pos-content-user-2">
										<jdoc:include type="modules" name="user-2" style="avatarmodule" />
									</div>	
								<?php endif; ?>
								<div class="clearbreak"></div>
							</div>
						<?php endif; ?>
						
						<?php if ($template->countModules('main-body-top')): ?>
							<div id="avatar-pos-main-body-top">
								<jdoc:include type="modules" name="main-body-top" style="avatarmodule" />
							</div>	
						<?php endif; ?>
						
						<?php if ($template->params->get('show_main_body')): ?>
							<?php if (!$this->hideComponentBaseOnItemID()): ?>
							<div id="avatar-pos-main-body">
								<jdoc:include type="component" />
							</div>
							<?php endif; ?>	
						<?php endif; ?>
						
						<?php if ($template->countModules('main-body-bottom')): ?>
							<div id="avatar-pos-main-body-bottom">
								<jdoc:include type="modules" name="main-body-bottom" style="avatarmodule" />
							</div>	
						<?php endif; ?>
						
						<?php if ($posUser3 || $posUser4): ?>
							<div id="avatar-content-user-bottom">
								<?php if ($posUser3): ?>
									<div id="avatar-pos-content-user-3">
										<jdoc:include type="modules" name="user-3" style="avatarmodule" />
									</div>	
								<?php endif; ?>
								<?php if ($posUser4): ?>
									<div id="avatar-pos-content-user-4">
										<jdoc:include type="modules" name="user-4" style="avatarmodule" />
									</div>	
								<?php endif; ?>
								<div class="clearbreak"></div>
							</div>
						<?php endif; ?>
					
						<?php if ($template->countModules('user-bottom')): ?>
							<div id="avatar-pos-content-user-bottom">
								<jdoc:include type="modules" name="user-bottom" style="avatarmodule" />
							</div>	
						<?php endif; ?>
					
						<?php if ($template->countModules('banner-bottom')): ?>
							<div id="avatar-pos-banner-bottom">
								<jdoc:include type="modules" name="banner-bottom" style="avatarmodule" />
							</div>
						<?php endif; ?>
						</div>
					</div>
					
					<?php if ($template->countModules('inner-right')):?>
						<div id="avatar-pos-inner-right">
							<jdoc:include type="modules" name="inner-right" style="avatarmodule" />
						</div>
					<?php endif; ?>
					<div class="clearbreak"></div>
				</div>
				<?php if ($hasRightCol): ?>
					<div id="avatar-right">
						<?php if ($posRightTop): ?>
							<div id="avatar-pos-right-top">
								<jdoc:include type="modules" name="right-top" style="avatarmodule" />
							</div>
						<?php endif; ?>
						
						<?php if ($posRightMiddle1 || $posRightMiddle2): ?>
							<div id="avatar-pos-right-middle">
								<?php if ($posRightMiddle1): ?>
									<div id="avatar-pos-right-middle-1">
										<jdoc:include type="modules" name="right-middle-1" style="avatarmodule" />
									</div>
								<?php endif; ?>	
								
								<?php if ($posRightMiddle2): ?>
									<div id="avatar-pos-right-middle-2">
										<jdoc:include type="modules" name="right-middle-2" style="avatarmodule" />
									</div>
								<?php endif; ?>
								<div class="clearbreak"></div>
							</div>
						<?php endif; ?>
						
						<?php if ($posRightBottom): ?>
							<div id="avatar-pos-right-bottom">
								<jdoc:include type="modules" name="right-bottom" style="avatarmodule" />
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<div class="clearbreak"></div>
				</div>
			</div>
			
			
			<?php if ($posPromoBottomLeft || $posPromoBottomMiddle || $posPromoBottomRight || 
			$posUser5 || $posUser6 || $posUser7 || $posUser15 || $posUser16 || $posUser17 || $posUser18 || $posUser19 || $posUser20
			|| $posContentBottom) :?>
				<div id="avatar-body-bottom-block">
					<div class="avatar-wrapper <?php echo $template->params->get('avatar_body_bottom_block'); ?>">
					<?php if ($posPromoBottomLeft || $posPromoBottomMiddle || $posPromoBottomRight ): ?>
						<div id="avatar-promo-bottom">
							<?php if ($posPromoBottomLeft): ?>
								<div id="avatar-pos-promo-bottom-left">
									<jdoc:include type="modules" name="promo-bottom-left" style="avatarmodule" />
								</div>
							<?php endif; ?>
							
							<?php if ($posPromoBottomMiddle): ?>
								<div id="avatar-pos-promo-bottom-middle">
									<jdoc:include type="modules" name="promo-bottom-middle" style="avatarmodule" />
								</div>
							<?php endif; ?>
							
							<?php if ($posPromoBottomRight): ?>
								<div id="avatar-pos-promo-bottom-right">
									<jdoc:include type="modules" name="promo-bottom-right" style="avatarmodule" />
								</div>
							<?php endif; ?>
							<div class="clearbreak"></div>
						</div>
					<?php endif; ?>
					
					<?php if ($posContentBottom): ?>
						<div id="avatar-pos-content-bottom">
							<jdoc:include type="modules" name="content-bottom" style="avatarmodule" />
						</div>
					<?php endif; ?>
					
					<?php if ($posUser5 || $posUser6 || $posUser7): ?>
						<div id="avatar-user-top-col-3">
							<?php if ($posUser5): ?>
								<div id="avatar-pos-user-5">
									<jdoc:include type="modules" name="user-5" style="avatarmodule" />
								</div>
							<?php endif; ?>
							
							<?php if ($posUser6): ?>
								<div id="avatar-pos-user-6">
									<jdoc:include type="modules" name="user-6" style="avatarmodule" />
								</div>
							<?php endif; ?>
							
							<?php if ($posUser7): ?>
								<div id="avatar-pos-user-7">
									<jdoc:include type="modules" name="user-7" style="avatarmodule" />
								</div>
							<?php endif; ?>
							<div class="clearbreak"></div>
						</div>
					<?php endif;?>
					<?php if ($posUser19 || $posUser20): ?>
						<div id="avatar-user-middle-col-2">
							<?php if ($posUser19): ?>
								<div id="avatar-pos-user-19">
									<jdoc:include type="modules" name="user-19" style="avatarmodule" />
								</div>
							<?php endif; ?>
							
							<?php if ($posUser20): ?>
								<div id="avatar-pos-user-20">
									<jdoc:include type="modules" name="user-20" style="avatarmodule" />
								</div>
							<?php endif; ?>
							<div class="clearbreak"></div>
						</div>
					<?php endif;?>
					<?php if ($posUser15 || $posUser16 || $posUser17 || $posUser18): ?>
						<div id="avatar-user-bottom-col-4">
							<?php if ($posUser15): ?>
								<div id="avatar-pos-user-15">
									<jdoc:include type="modules" name="user-15" style="avatarmodule" />
								</div>
							<?php endif; ?>
							
							<?php if ($posUser16): ?>
								<div id="avatar-pos-user-16">
									<jdoc:include type="modules" name="user-16" style="avatarmodule" />
								</div>
							<?php endif; ?>
							
							<?php if ($posUser17): ?>
								<div id="avatar-pos-user-17">
									<jdoc:include type="modules" name="user-17" style="avatarmodule" />
								</div>
							<?php endif; ?>
							
							<?php if ($posUser18): ?>
								<div id="avatar-pos-user-18">
									<jdoc:include type="modules" name="user-18" style="avatarmodule" />
								</div>
							<?php endif; ?>
							<div class="clearbreak"></div>
						</div>
					<?php endif;?>
					</div>
				</div>
			<?php endif; ?>
			
			<?php if ($template->countModules('full-6')): ?>
				<div id="avatar-full-6-block">
					<div class="avatar-wrapper <?php echo $template->params->get('avatar_full_6_block'); ?>">
						<jdoc:include type="modules" name="full-6" style="avatarmodule" />
					</div>
				</div>
			<?php endif; ?>
			
			<?php if ($template->countModules('full-7')): ?>
				<div id="avatar-full-7-block">
					<div class="avatar-wrapper <?php echo $template->params->get('avatar_full_7_block'); ?>">
						<jdoc:include type="modules" name="full-7" style="avatarmodule" />
					</div>
				</div>
			<?php endif; ?>
			<?php if ($template->countModules('full-8')): ?>
				<div id="avatar-full-8-block">
					<div class="avatar-wrapper <?php echo $template->params->get('avatar_full_8_block'); ?>">
						<jdoc:include type="modules" name="full-8" style="avatarmodule" />
					</div>
				</div>
			<?php endif; ?>
			<?php if ($template->countModules('full-9')): ?>
				<div id="avatar-full-9-block">
					<div class="avatar-wrapper <?php echo $template->params->get('avatar_full_9_block'); ?>">
						<jdoc:include type="modules" name="full-9" style="avatarmodule" />
					</div>
				</div>
			<?php endif; ?>
			<?php if($posFooterLeft || $posFooterMiddle || $posFooterRight): ?>
				<div id="avatar-footer-inside-block">
					<div class="avatar-wrapper <?php echo $template->params->get('avatar_footer_inside_block'); ?>">
					<?php if ($posFooterLeft): ?>
						<div id="avatar-pos-footer-left">
							<jdoc:include type="modules" name="footer-left" style="avatarmodule" />
						</div>
					<?php endif; ?>
					
					<?php if ($posFooterMiddle): ?>
						<div id="avatar-pos-footer-middle">
							<jdoc:include type="modules" name="footer-middle" style="avatarmodule" />
						</div>
					<?php endif; ?>
					
					<?php if ($posFooterRight): ?>
						<div id="avatar-pos-footer-right">
							<jdoc:include type="modules" name="footer-right" style="avatarmodule" />
						</div>
					<?php endif; ?>
					<div class="clearbreak"></div>
					</div>
				</div>
			<?php endif;?>
			
			<?php if ($posFooter1 || $posFooter2 || $posFooter3 || $posFooter4 || $posFooter5 || $posFooter6) : ?>
				<div id="avatar-footer-number">
					<div class="avatar-wrapper <?php echo $template->params->get('avatar_footer_number_block'); ?>">
						<?php if ($posFooter1): ?>
							<div id="avatar-pos-footer-number-1">
								<jdoc:include type="modules" name="footer-1" style="avatarmodule" />
							</div>
						<?php endif; ?>
						<?php if ($posFooter2): ?>
							<div id="avatar-pos-footer-number-2">
								<jdoc:include type="modules" name="footer-2" style="avatarmodule" />
							</div>
						<?php endif; ?>
						<?php if ($posFooter3): ?>
							<div id="avatar-pos-footer-number-3">
								<jdoc:include type="modules" name="footer-3" style="avatarmodule" />
							</div>
						<?php endif; ?>
						<?php if ($posFooter4): ?>
							<div id="avatar-pos-footer-number-4">
								<jdoc:include type="modules" name="footer-4" style="avatarmodule" />
							</div>
						<?php endif; ?>
						<?php if ($posFooter5): ?>
							<div id="avatar-pos-footer-number-5">
								<jdoc:include type="modules" name="footer-5" style="avatarmodule" />
							</div>
						<?php endif; ?>
						<?php if ($posFooter6): ?>
							<div id="avatar-pos-footer-number-6">
								<jdoc:include type="modules" name="footer-6" style="avatarmodule" />
							</div>
						<?php endif; ?>
						<div class="clearbreak"></div>
					</div>
				</div>
			<?php endif; ?>
			
			<?php if ($posFooter): ?>
				<div id="avatar-footer-block">
					<div class="avatar-wrapper <?php echo $template->params->get('avatar_footer_block'); ?>">
						<jdoc:include type="modules" name="footer" style="avatarmodule" />
					</div>
				</div>
			<?php endif; ?>
		</div>
		<div id="avatar-debug">
			<jdoc:include type="modules" name="debug" />
		</div>
		<?php echo Avatar::getCopyright($template->params->get('copyright')); ?>
		<?php 
			echo $this->panelSettings();	
		?>
	</body>
</html>
