/*

  (Early beta) jQuery UI CoverFlow 2.2 App for jQueryUI 1.8.9 / core 1.6.2
  Copyright Addy Osmani 2011.
  
  With contributions from Paul Bakhaus, Nicolas Bonnicci
  
*/
(function ($) {
	$.app = function (options) {
	    var coverflowApp = coverflowApp || {};
	    
	    coverflowApp = {
	        defaultItem: 1,
	        //default set item to be centered on
	        defaultDuration: 1200,
	        //animation duration
	        html: $('#demo-frame div.wrapper').html(),
	        imageCaption: $('.demo #imageCaption'),
	        sliderCtrl: $('.demo #slider'),
	        coverflowCtrl: $('.demo #coverflow'),
	        coverflowImages: $('.demo #coverflow').find('img'),
	        coverflowItems: $('.demo .coverflowItem'),
	        sliderVertical: $('.demo #slider-vertical'),
	        origSliderHeight: '',
	        sliderHeight: '',
	        sliderMargin: '',
	        difference: '',
	        proportion: '',
	        handleHeight: '',
	        listContent: '',
	        autoPlay: '',
	        interval: '',
	        artist: '',
	        album: '',
	        sortable: $('#sortable'),
	        scrollPane: $('#scroll-pane'),
	
	        setDefault: function () {
	            this.defaultItem -= 1;
	            $('.coverflowItem').eq(this.defaultItem).addClass('ui-selected');
	        },
	
	        setCaption: function (title, description) {
	            this.imageCaption.html('<div class="title">'+title+'</div><div class="description">'+description+'</div>');
	        },
	        
	        setOpacity: function (index) {
	        	$('#'+options.jsn_themeflow_id+' .demo #coverflow').find('.imageItem').css('opacity', options.jsn_themeflow_transparency/100);
	        	$('#'+options.jsn_themeflow_id+' .demo #coverflow').find('.imageItem').eq(index).css('opacity', 1);
	        	$('#'+options.jsn_themeflow_id+' .demo #coverflow').css('opacity', '1');
	        },
	
	        addInterval: function () {
	        	return setInterval(function () {
	            	var current = coverflowApp.sliderCtrl.slider('value');
	            	current++;
	            	if (current == coverflowApp.sliderCtrl.slider('option', 'max') + 1)
	            		current = 0;
	            	coverflowApp.skipTo(current);
	            	
	            }, options.jsn_themeflow_play_duration * 1000);
	        },
	        
	        init_coverflow: function (elem) {
	        	//if (jsn_themeflow_animation_duration)
	        	coverflowApp.defaultDuration = 1000;
	            this.setDefault();
	            this.setOpacity(coverflowApp.defaultItem);
	            this.coverflowCtrl.coverflow({
	                item: coverflowApp.defaultItem,
	                duration: coverflowApp.defaultDuration,
	                select: function (event, sky) {
	                	coverflowApp.setOpacity(sky.value);
	                    coverflowApp.skipTo(sky.value);
	                }
	            });
	            
	            //
	            this.coverflowImages.each(function (index, value) {
	                var current = $(this);
	                try {
	                    coverflowApp.listContent += "<li class='ui-state-default coverflowItem' data-itemlink='" + (index) + "' data-description='" + current.data('album') + "'>" + current.data('artist') + "</li>";
	                } catch (e) {}
	            });
	
	            //Skip all controls to the current default item
	            this.coverflowItems = this.getItems();
	            this.sortable.html(this.listContent);
	            this.skipTo(this.defaultItem);
	
	            //
	            this.init_slider(this.sliderCtrl, 'horizontal');
	            //this.init_slider($("#slider-vertical"), 'vertical');
	            //change the main div to overflow-hidden as we can use the slider now
	            this.scrollPane.css('overflow', 'hidden');
	
	            //calculate the height that the scrollbar handle should be
	            this.difference = this.sortable.height() - this.scrollPane.height(); //eg it's 200px longer 
	            this.proportion = this.difference / this.sortable.height(); //eg 200px/500px
	            this.handleHeight = Math.round((1 - this.proportion) * this.scrollPane.height()); //set the proportional height
	            ///
	            this.setScrollPositions(this.defaultItem);
	
	            //
	            this.origSliderHeight = this.sliderVertical.height();
	            this.sliderHeight = this.origSliderHeight - this.handleHeight;
	            this.sliderMargin = (this.origSliderHeight - this.sliderHeight) * 0.5;
	
	            //
	            this.init_mousewheel();
	            this.init_keyboard();
	            
	            this.sortable.selectable({
	                stop: function () {
	                    var result = $("#select-result").empty();
	                    $(".ui-selected", this).each(function () {
	                        var index = $("#sortable li").index(this);
	                        coverflowApp.skipTo(index);
	                    });
	                }
	            });
	        },
	
	        init_slider: function (elem, direction) {
	            if (direction == 'horizontal') {
	                elem.slider({
	                    min: 0,
	                    max: $('#coverflow > *').length - 1,
	                    value: coverflowApp.defaultItem,
	                    slide: function (event, ui) {
	                        var current = $('.coverflowItem');
	                        coverflowApp.coverflowCtrl.coverflow('select', ui.value, true);
	                        current.removeClass('ui-selected');
	                        current.eq(ui.value).addClass('ui-selected');
	                        coverflowApp.setCaption(current.eq(ui.value).html(), current.eq(ui.value).data('description'));
	                    },
	                    stop: function (event, ui) {
	                    	$('#'+options.jsn_themeflow_id+' .demo #coverflow').find('.imageItem').css('opacity', options.jsn_themeflow_transparency/100);
	                    	$('#'+options.jsn_themeflow_id+' .demo #coverflow').find('.imageItem').eq(ui.value).css('opacity', 1);
	                    	$('#'+options.jsn_themeflow_id+' .demo #coverflow').css('opacity', '1');
	                    }
	                })
	            } else {
	                if (direction == 'vertical') {
	                    elem.slider({
	                        orientation: direction,
	                        range: "max",
	                        min: 0,
	                        max: 100,
	                        value: 0,
	                        slide: function (event, ui) {
	                            var topValue = -((100 - ui.value) * coverflowApp.difference / 100);
	                            coverflowApp.sortable.css({
	                                top: topValue
	                            });
	                        },
	                        stop: function (event, ui) {
	                        	$('#'+options.jsn_themeflow_id+' .demo #coverflow').find('.imageItem').css('opacity', options.jsn_themeflow_transparency/100);
	                        	$('#'+options.jsn_themeflow_id+' .demo #coverflow').find('.imageItem').eq(ui.value).css('opacity', 1);
	                        	$('#'+options.jsn_themeflow_id+' .demo #coverflow').css('opacity', '1');
	                        }
	                    })
	                }
	            }
	        },
	
	        getItems: function () {
	            var refreshedItems = $('.demo .coverflowItem');
	            return refreshedItems;
	        },
	
	        skipTo: function (itemNumber) {
	            var items = $('.coverflowItem');
	            this.sliderCtrl.slider("option", "value", itemNumber);
	            this.coverflowCtrl.coverflow('select', itemNumber, true);
	            items.removeClass('ui-selected');
	            items.eq(itemNumber).addClass('ui-selected');
	            this.setCaption(items.eq(itemNumber).html(), items.eq(itemNumber).data('description'));
	            this.setOpacity(itemNumber);
	            $('#'+options.jsn_themeflow_id+' .demo #coverflow').find('.imageItem').removeClass('openLink');
	            $('#'+options.jsn_themeflow_id+' .demo #coverflow').find('.imageItem').eq(itemNumber).addClass('openLink');
	            if (options.jsn_themeflow_click_action == 'open_image_link') {
	            	$('#coverflow .imageItem a').attr('onclick', 'return false;');
	            	$('#coverflow .imageItem.openLink a').removeAttr('onclick');
	            } else {
	            	$('#coverflow .imageItem a').attr('onclick', 'return false;');
	            }
	            	
	            if (options.jsn_themeflow_click_action == 'show_original_image') {
	            	jQuery('#coverflow .imageItem a').unbind('click.fb');
	            	jQuery('#coverflow .imageItem.openLink a').fancybox({
	    				'titlePosition'	: 'over',
	    				'titleFormat'	: function(title, currentArray, currentIndex, currentOpts){
	    					return '<div class="gallery-info-'+options.jsn_themeflow_id+'">'+title+ '</div>';
	    				}
	    			});
	            }
	        },
	
	        init_mousewheel: function () {
	        	if (options.jsn_themeflow_enable_mouse_wheel == 'yes') {
	        		$('#'+options.jsn_themeflow_id+' .wrapper').mousewheel(function (event, delta) {
	
	                    var speed = 1,
	                        sliderVal = coverflowApp.sliderCtrl.slider("value"),
	                        coverflowItem = 0,
	                        cflowlength = $('#coverflow > *').length - 1,
	                        leftValue = 0;
	
	                    //check the deltas to find out if the user has scrolled up or down 
	                    if (delta > 0 && sliderVal > 0) {
	                        sliderVal -= 1;
	                    } else {
	                        if (delta < 0 && sliderVal < cflowlength) {
	                            sliderVal += 1;
	                        }
	                    }
	
	                    leftValue = -((100 - sliderVal) * coverflowApp.difference / 100); //calculate the content top from the slider position
	                    if (leftValue > 0) leftValue = 0; //stop the content scrolling down too much
	                    if (Math.abs(leftValue) > coverflowApp.difference) leftValue = (-1) * coverflowApp.difference; //stop the content scrolling up beyond point desired
	                    coverflowItem = Math.floor(sliderVal);
	                    coverflowApp.skipTo(coverflowItem);
	
	                });
	        	}
	        },
	
	        init_keyboard: function () {
	        	if (options.jsn_themeflow_enable_keyboard_action == 'yes') {
		            $(document).keydown(function (e) {
		                var current = coverflowApp.sliderCtrl.slider('value');
		                if (e.keyCode == 37) {
		                    if (current > 0) {
		                        current--;
		                        coverflowApp.skipTo(current);
		                    }
		                } else {
		                    if (e.keyCode == 39) {
		                        if (current < $('#coverflow > *').length - 1) {
		                            current++;
		                            coverflowApp.skipTo(current);
		                        }
		                    }
		                }
		            })
	        	}
	        },
	
	        generateList: function () {
	            this.coverflowImages.each(function (index, value) {
	                var t = $(this);
	                try {
	                    listContent += "<li class='ui-state-default coverflowItem' data-itemlink='" + (index) + "' data-description='" + t.data('album') + "'>" + t.data('artist') + "</li>";
	                } catch (e) {}
	            })
	        },
	
	        setScrollPositions: function () {
	            $('#slider-vertical').slider('value', this.item * 5);
	            this.sortable.css('top', -this.item * 5 + 20);
	        },
	
	        handleScrollpane: function () {
	            this.scrollPane.css('overflow', 'hidden');
	
	            //calculate the height that the scrollbar handle should be
	            difference = this.sortable.height() - this.scrollPane.height(); //eg it's 200px longer 
	            proportion = difference / this.sortable.height(); //eg 200px/500px
	            handleHeight = Math.round((1 - proportion) * this.scrollPane.height()); //set the proportional height
	        }
	    };
	    coverflowApp.init_coverflow();
	    
	    if (options.jsn_themeflow_auto_play == 'yes') {
	    	coverflowApp.interval = coverflowApp.addInterval();
	    }
	    
	    if (options.jsn_themeflow_auto_play == 'yes' && options.jsn_themeflow_pause_over == 'yes') {
	    	$('#'+options.jsn_themeflow_id).mouseenter(function () {
	    		options.jsn_themeflow_auto_play = 'no';
	        	window.clearInterval(coverflowApp.interval);	
	        	
	        });
	        $('#'+options.jsn_themeflow_id).mouseleave(function () {
	        	options.jsn_themeflow_auto_play = 'yes';
	        	coverflowApp.interval = coverflowApp.addInterval();
	        });
	    }
	}
})(jsnThemeFlowjQuery);