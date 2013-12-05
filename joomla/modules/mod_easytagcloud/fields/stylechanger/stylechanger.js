/*
 * @package		EasyTagCloud
 * @version		2.4
 * @author		Kee Huang
 * @copyright	Copyright (c) 2013 www.joomlatonight.com. All rights reserved
 */

function changestyle(x){
	 var maxfont = document.getElementById("jform_params_maxfontsize");
	 var minfont = document.getElementById("jform_params_minfontsize");	 
	 var tagscolor = document.getElementById("jform_params_tagscolor");
	 var tagshovercolor = document.getElementById("jform_params_tagshovercolor");
	 var tagsbgcolor = document.getElementById("jform_params_tagsbgcolor");
	 var tagshoverbgcolor = document.getElementById("jform_params_tagshoverbgcolor");
	 var lineheight = document.getElementById("jform_params_line_height");
	 var horizontal = document.getElementById("jform_params_horizontal_space");
	 var padding = document.getElementById("jform_params_tagspadding");
	 var borderradius = document.getElementById("jform_params_borderradius");
	 var colorful = document.getElementById("jform_params_colorful_tags");
	 var params = new Array(maxfont,minfont,tagscolor,tagshovercolor,tagsbgcolor,tagshoverbgcolor,lineheight,horizontal,padding,borderradius,colorful);
	 var style0 = new Array(28,11,"","","","",24,2,2,0,0); // default
     var style1 = new Array(16,11,"#FFFFFF","#FFEAC9","#DB220D","#DB220D",30,2,4,2,0); // red
     var style2 = new Array(16,11,"#FFFFFF","#38B6FF","#003399","#003399",30,2,4,2,0); // blue	 
     var style3 = new Array(16,11,"#FFFFFF","#96FF59","#006600","#006600",30,2,4,2,0); // green		
     var style4 = new Array(16,11,"#FFFFFF","#CCCCCC","#000000","#000000",30,2,4,2,0); // black		
     var style5 = new Array(16,11,"#FFFFFF","#EBEBEB","#666666","#666666",30,2,4,2,0); // gray	
     var style6 = new Array(16,11,"#FFFFFF","#FFCC99","#FF6600","#FF6600",30,2,4,2,0); // gray	 
	 var styles = new Array(style0,style1,style2,style3,style4,style5,style6)


	 var style = styles[x];
	 for (var i = 0; i < 10; i++) {
          params[i].value = style[i];
		  if (i == 2 || i == 3 || i == 4 || i ==5) {
		  params[i].style.backgroundColor = style[i];
		  }
		  //params[i].disabled = true;
	 }
}



// -->  