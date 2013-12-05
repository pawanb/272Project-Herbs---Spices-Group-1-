(function( $ ){
	// template object
	avatarTemplate = {}
	avatarTemplate.template = { name: '', version: ''}
  	avatarTemplate.url = {}
  	avatarTemplate.menu = {}
  	avatarTemplate.image = {}
  	avatarTemplate.layout = {}
  	avatarTemplate.settingPanel = {}
  	avatarTemplate.css3effect = { options: []}
  	
  	avatarTemplate.url.getVar = function (url) 
  	{
  		var vars = {},
	    	parts = url.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) { vars[key] = value; });
	    return vars;
	}
	
  	avatarTemplate.image.initEffects = function () {
  		avatarImage.effects.overlay();
  	}
  	
  	avatarTemplate.layout.init = function () {
  		avatarLayout.functions.sameHeightCols($('#avatar-body-middle > div:not(".clearbreak")'));
  	}

	avatarTemplate.settingPanel.init = function () {
		avatarSettingPanel.init();
  		avatarSettingPanel.background.change('#avatar-settings .bg-image .item'); 
  	}
  	
  	avatarTemplate.menu.init = function () {
  		avatarMenu.responsive.toggleButton();	
  	}
  	
  	avatarTemplate.css3effect.init = function () {
  		avatarCSS3.init();
  	}
  	
})( jQuery );

(function( $ ){
	avatarImage = {}
	avatarImage.effects = {}
	
	avatarImage.effects.overlay = function () 
	{
		$("div[class*='img-']").each(function()
		{
			var wrap = $(this),
			wh = wrap.height();
			ww = wrap.width();
			
			wrap.find('img').each(function(){
				var img = $(this);
				ih = img.height();
				iw = img.width();
				img.css({top: (wh - ih)/2 + 'px', left : (ww - iw)/2 + 'px'});
			});
		});
	}
})( jQuery );

(function( $ ){
	avatarLayout = {}
	avatarLayout.functions = {}
	
	avatarLayout.functions.sameHeightCols = function (els) 
	{
		function calSize() 
		{
			if($(window).width() > 767) 
			{ 
				if(els.length > 0) 
				{
					var $height = 0;
					
					els.each(function()
					{
						$h = $(this).height();
						
						if ($h > $height) {
							$height = $h;
						}
					});	
					
					els.each(function(){
						$(this).css('min-height', $height);
					});
				}
			} else {
				els.each(function(){
						$(this).css('min-height', '');
				});
			}
		}
		
		$(window).load(function () {
			calSize();
		});
		
		$(window).resize(function(){
			calSize();
		});
	}
})( jQuery );

(function( $ ){
	avatarSettingPanel = {}
	avatarSettingPanel.background = {}
	avatarSettingPanel.header = {}
	avatarSettingPanel.body = {}
	avatarSettingPanel.link = {}
	avatarSettingPanel.showcase = {}
	
	avatarSettingPanel.init = function () 
	{
		var panelSetting = $('#avatar-settings');
		$('#avatar-settings #close').click(function()
		{
			if (panelSetting.css('left') == '0px') {
				panelSetting.animate({ left: '-172px'}, 300);	
			} else {
				panelSetting.animate({ left: '0px'}, 300);
			}
		});
	}
	
	avatarSettingPanel.reset = function () 
	{
		var allCookies = document.cookie.split(';');
		
		for (var i=0;i<allCookies.length;i++) 
		{
			var cookiePair = allCookies[i].split('=');
			if (cookiePair[0].indexOf(avatarTemplate.template.name) != -1) {
				document.cookie = cookiePair[0] + '=;path=/';
				window.location.reload();
			}
		}
	}
	
	avatarSettingPanel.background.change = function (selector) 
	{
		$(selector).each(function ()
		{
			var self = $(this);
			self.click (function()
			{
				var bg = self.css('background-image');
				
				if (/opera/i.test(navigator.userAgent)){
					bg =  encodeURIComponent(bg);
				}
				
				document.cookie = avatarTemplate.template.name + '-background-image' + '=' + bg + ';path=/';
				$('body').css('background-image', self.css('background-image'));	
			});	
		});	
	}
	
	avatarSettingPanel.header.color = function (selector) 
	{
		$(':header').each (function () {
			$(this).css('color', selector.value);	
		});
		document.cookie = avatarTemplate.template.name + '-header-color' + '=' + selector.value + ';path=/';
	}
	
	avatarSettingPanel.body.color = function (selector) 
	{
		$('body').css('color', selector.value);	
		document.cookie = avatarTemplate.template.name + '-body-color' + '=' + selector.value + ';path=/';
	}
	
	avatarSettingPanel.showcase.change = function (selector) 
  	{
  		var self = avatarTemplate;
		document.cookie = avatarTemplate.template.name + '-showcase' + '=' + selector + ';path=/';
		window.location.reload();
   	}
})( jQuery );

(function( $ ){
	avatarMenu = {}
	avatarMenu.responsive = {}
	
	avatarMenu.responsive.toggleButton = function (){
		$('.avatar-nav-responsive .toggle').click(function()
		{
			var toggle = $(this);
			var parent = toggle.parent();

			parent.find('ul.avatar-main-menu').slideToggle();			

			$(window).resize(function(){
				if($(window).width() > 1024) {
					parent.find('ul.avatar-main-menu').removeAttr('style');
				}
			});
		});
	}
})( jQuery );

(function( $ ){
	avatarCSS3 = {}
	avatarCSS3.appearAfterScroll = {}
	
	avatarCSS3.appearAfterScroll.isIntoView = function(elem) 
	{
		var docViewTop = $(window).scrollTop();
	    var docViewBottom = docViewTop + $(window).height();
		var elemTop = $(elem).offset().top;
		var elemBottom = elemTop + $(elem).height();
		
		return (elemTop <= docViewBottom - 100);	
	}
	
	avatarCSS3.appearAfterScroll.init = function() 
	{
		avatarCSS3.appearAfterScroll.checkIntoView(true);
		$(window).scroll(function() {
			avatarCSS3.appearAfterScroll.checkIntoView(false); 	
		}); 
	}
	
	avatarCSS3.appearAfterScroll.checkIntoView = function(start) {
		if (!avatarTemplate.template.params.css3_effect_scroll) {
			return;
		}
		var selector = avatarTemplate.template.params.css3_effect_scroll.split(';');
		$.each(selector, function(index, value) {
			if (value) 
			{
				var els = $(value);
				
				if (els.length > 0) {
					els.each(function(){
						var el = $(this);
						if (start) 
						{
							el.addClass('avatar-scroll-disappear');
							setTimeout(function(){
								el.removeClass('avatar-scroll-disappear').addClass('avatar-scroll-appear');
							}, 1000);
						} 
						else 
						{
							if (avatarCSS3.appearAfterScroll.isIntoView($(this))) {
								$(this).addClass('avatar-scroll-appear').removeClass('avatar-scroll-disappear');
							} else {
								$(this).addClass('avatar-scroll-disappear').removeClass('avatar-scroll-appear');
							}	
						}
					});		
				}
			} 
		});	
	}
	
	avatarCSS3.init = function() 
	{
		avatarCSS3.appearAfterScroll.init();
	}
})( jQuery );