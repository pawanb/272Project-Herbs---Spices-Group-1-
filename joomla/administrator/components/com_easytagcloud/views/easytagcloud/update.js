/**
* @package		EasyTagcloud
* @author       Kee Huang  (huangqi@vip.163.com)
* @copyright	Copyright(C)2013 Joomla Tonight. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
*/
function initUpdateTime(nextupdatetime){
   var nowtime=new Date();
   endtime=nowtime.getTime()+nextupdatetime;
   showUpdateTime();
}

function showUpdateTime(){  
    var nowtime=new Date();  	
    var t=endtime-nowtime.getTime();  
    var showhour=Math.floor(t/(1000*60*60)) % 24;  
    var showminute=Math.floor(t/(1000*60)) % 60;  
    var showsecond=Math.floor(t/1000) % 60;  
    var showmsecond=Math.floor(t/100) % 10;
    if(t>= 0){  
        document.getElementById("showcountdown").innerHTML=showhour+" hours "+showminute+" minutes "+showsecond+"."+showmsecond+" seconds";    
    }  
    else {  
        document.getElementById("showcountdown").innerHTML=0;  
		var update = document.getElementById("update"); 
		update.click();
    }  
    setTimeout("showUpdateTime()",100);  
}  


// -->  