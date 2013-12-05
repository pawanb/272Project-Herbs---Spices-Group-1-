/**
* @package		com_easytagcloud
* @author       Kee Huang  (huangqi@vip.163.com)
* @copyright	Copyright(C)2013 Joomla Tonight. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
*/
 

function convert() {
	var xmlhttp;	
	document.getElementById("convert_b").style.display="none";
	document.getElementById("convert_l").style.display="";	
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
	xmlhttp.onreadystatechange=function() {
          if (xmlhttp.readyState==4 && xmlhttp.status==200) {
              document.getElementById("convert_r").innerHTML=xmlhttp.responseText;
			  
          }
    }

    xmlhttp.open("GET",converturi,true);
    xmlhttp.send();

	
}
// -->  