<?php
include "include/config.php";

	
	$id  		= $_REQUEST['id'];
	$account  	= $_REQUEST['account'];
	
$str = 'http://42.121.19.218/v3-all/isfes/index.php?show=isfes_app_lattice&id=1 scrolling=no></if';
//echo base64_encode($str);

	$str01	= '<table height="6115" width="100%"><tr><td><link rel="stylesheet" type="text/css" href="http://42.121.19.218/v3-all/isfes/style.css" /><div class="wrapper"><div class="header_bg"><div class="kuang"><div class="top"><div class="power" style="font-size:10px;"><a href="http://www.isfes.com/" title="Power by ISFES(ISFES.com ERP APP)" target="_blank"><!--<img src="http://42.121.19.218/v3-all/themes/Sugar5/images/company_logo.png" alt="Power by Isfes ERP(ISFES.com ERP APP)" width="108" height="19" title="Power by Isfes ERP(ISFES.com ERP APP)" />-->
</a></div>
<div class="search"><div class="search_btn"><a href="javascript:document.getElementById('."'formSearch'".').submit()"></a></div><div class="search_bg"><form id="formSearch" name="formSearch" action="http://stores.ebay.com/'.$account.'/_i.html?"><input id="_nkw" name="_nkw" type="text" class="shufu" PLACEHOLDER="search..." /></form></div><div class="cl"></div></div><div class="cl"></div></div><div class="product"><div class="product_left"><div id="isfes_app_lattice"></div></div><div class="product_right"><div id="isfes_app_shop"></div></div><div class="cl"></div></div><div class="w_bottom"><div class="w_left"><div class="d-p"><div class="derection">Description</div><div class="d_text"><p>22222</p></div><div class="preview">Preview</div><div class="big_img" align="center"><img src="1111.jpg" /></div><div class="d_bottom"></div></div><div><!-----------------------></div><div id="isfes_app_left"></div></div><div class="w_right"><div id="isfes_app_right"></div></div><div class="cl"></div></div></div></div></div></td></tr></table>';

	
	$str02 ='<script language="javascript" type="text/javascript"> 


var BASE64_ENCODE_CHARS = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
var base64EncodeChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";



var BASE64_DECODE_CHARS = [-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 62, -1, -1, -1, 63, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, -1, -1, -1, -1, -1, -1, -1, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, -1, -1, -1, -1, -1, -1, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, -1, -1, -1, -1, -1]; 






function decodeBase64(str) { 

var c1, c2, c3, c4, i = 0, len = str.length, out=[]; while (i < len) { do { c1 = BASE64_DECODE_CHARS[str.charCodeAt(i++) & 0xff];} while (i < len && c1 == -1); if (c1 == -1) break; do { c2 = BASE64_DECODE_CHARS[str.charCodeAt(i++) & 0xff]; } while (i < len && c2 == -1); if (c2 == -1) break; out.push(String.fromCharCode((c1 << 2) | ((c2 & 0x30) >> 4))); do { c3 = str.charCodeAt(i++) & 0xff; if (c3 == 61) return out.join('."''".'); c3 = BASE64_DECODE_CHARS[c3]; } while (i < len && c3 == -1); if (c3 == -1) break; out.push(String.fromCharCode(((c2 & 0XF) << 4) | ((c3 & 0x3C) >> 2))); do { c4 = str.charCodeAt(i++) & 0xff; if (c4 == 61) return out.join('."''".'); c4 = BASE64_DECODE_CHARS[c4]; } while (i < len && c4 == -1); if (c4 == -1) break; out.push(String.fromCharCode(((c3 & 0x03) << 6) | c4)); } return out.join('."''".'); } 



function utf16to8(str) { var out, i, len, c; out = ""; len = str.length; for (i = 0; i < len; i++) { c = str.charCodeAt(i); if ((c >= 0x0001) && (c <= 0x007F)) { out += str.charAt(i); } else if (c > 0x07FF) { out += String.fromCharCode(0xE0 | ((c >> 12) & 0x0F)); out += String.fromCharCode(0x80 | ((c >> 6) & 0x3F)); out += String.fromCharCode(0x80 | ((c >> 0) & 0x3F)); } else { out += String.fromCharCode(0xC0 | ((c >> 6) & 0x1F));  out += String.fromCharCode(0x80 | ((c >> 0) & 0x3F)); } } return out; } 


function utf8to16(str) { var out, i, len, c; var char2, char3; out = ""; len = str.length; i = 0; while (i < len) { c = str.charCodeAt(i++); switch (c >> 4) { case 0 : case 1 : case 2 : case 3 : case 4 : case 5 : case 6 : case 7 : out += str.charAt(i - 1); break; case 12 : case 13 : char2 = str.charCodeAt(i++); out += String.fromCharCode(((c & 0x1F) << 6) | (char2 & 0x3F)); break; case 14 : char2 = str.charCodeAt(i++); char3 = str.charCodeAt(i++); out += String.fromCharCode(((c & 0x0F) << 12) | ((char2 & 0x3F) << 6) | ((char3 & 0x3F) << 0)); break; } } return out; } 



function base64encode(str) {
    var out, i, len;
    var c1, c2, c3;


 
    len = str.length;
    i = 0;
    out = "";
    while(i < len) {
 c1 = str.charCodeAt(i++) & 0xff;
 if(i == len)
 {
     out += base64EncodeChars.charAt(c1 >> 2);
     out += base64EncodeChars.charAt((c1 & 0x3) << 4);
     out += "==";
     break;
 }
 c2 = str.charCodeAt(i++);
 if(i == len)
 {
     out += base64EncodeChars.charAt(c1 >> 2);
     out += base64EncodeChars.charAt(((c1 & 0x3)<< 4) | ((c2 & 0xF0) >> 4));
     out += base64EncodeChars.charAt((c2 & 0xF) << 2);
     out += "=";
     break;
 }
 c3 = str.charCodeAt(i++);
 out += base64EncodeChars.charAt(c1 >> 2);
 out += base64EncodeChars.charAt(((c1 & 0x3)<< 4) | ((c2 & 0xF0) >> 4));
 out += base64EncodeChars.charAt(((c2 & 0xF) << 2) | ((c3 & 0xC0) >>6));
 out += base64EncodeChars.charAt(c3 & 0x3F);
    }
    return out;
}


</script>';
	
	
	
	$isfes_app_lattice		= base64_encode('rame frameborder="0" width="760" height="330" src=http://42.121.19.218/v3-all/isfes/index.php?show=isfes_app_lattice&id='.$id.' scrolling=no></if');
	$isfes_app_shop			= base64_encode('rame frameborder="0" width="187" height="330" src=http://42.121.19.218/v3-all/isfes/index.php?show=isfes_app_shop&id='.$id.' scrolling=no></if');
	$isfes_app_left			= base64_encode('rame frameborder="0" width="720" height="5115" src=http://42.121.19.218/v3-all/isfes/index.php?show=isfes_app_left&id='.$id.' scrolling=no></if');
	$isfes_app_right		= base64_encode('rame frameborder="0" width="235" height="8715" src=http://42.121.19.218/v3-all/isfes/index.php?show=isfes_app_right&id='.$id.' scrolling=no></if');

	$str03 = '<script language="JavaScript" type="text/javascript"> 
document.getElementById("isfes_app_lattice").innerHTML=utf8to16(decodeBase64("PGlm"))+utf8to16(decodeBase64("'.$isfes_app_lattice.'"))+utf8to16(decodeBase64("cmFtZT4="));
document.getElementById("isfes_app_shop").innerHTML=utf8to16(decodeBase64("PGlm"))+utf8to16(decodeBase64("'.$isfes_app_shop.'"))+utf8to16(decodeBase64("cmFtZT4="));
document.getElementById("isfes_app_left").innerHTML=utf8to16(decodeBase64("PGlm"))+utf8to16(decodeBase64("'.$isfes_app_left.'"))+utf8to16(decodeBase64("cmFtZT4="));
document.getElementById("isfes_app_right").innerHTML=utf8to16(decodeBase64("PGlm"))+utf8to16(decodeBase64("'.$isfes_app_right.'"))+utf8to16(decodeBase64("cmFtZT4="));
</script>';


 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'></div>

<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	<td nowrap="nowrap" scope="row" >&nbsp;
    &nbsp;&nbsp;&nbsp;请将下列代码复制到 刊登物品的描述框中就可：<br />
    <textarea name="keys" cols="80" rows="15" id="keys"><?php echo $str01.$str02.$str03 ?></textarea>
    <br />
    <br /></td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
