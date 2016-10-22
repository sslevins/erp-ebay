<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
<title>SugarCRM</title> 
<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/yui.css" />
<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/deprecated.css" />
<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/style.css" /> 
<link rel="stylesheet" type="text/css" media="all" href="cache/themes/Sugar5/css/login.css">
</head>
<body >  
<div id="header"> 
    <div id="companyLogo"><img src="themes/Sugar5/images/company_logo.png" width="212" height="40"></div>    
  <div id="globalLinks">					
    <ul> 
        <li> 
        </li> 
        <li> 
        </li> 
        <li> 
        </li> 
        </ul> 
</div>        <div class="clear"></div> 
        <div class="clear"></div> 
        <br /><br /> 
        <div id="moduleList"> 
<ul> 
    <li class="noBorder">&nbsp;</li> 
        </ul> 
</div>    <div class="clear"></div> 
    <div class="line"></div> 
    </div> 
 
<div id="main"> 
    <div id="content" class="noLeftColumn" > 
        <table style="width:100%"><tr><td>
<table cellpadding="0" align="center" width="100%" cellspacing="0" border="0"> 
	<tr> 
		<td align="center"> 
		<div class="dashletPanelMenu" style="width: 460px;"> 
		<div class="hd"><div class="tl"></div><div class="hd-center"></div><div class="tr"></div></div> 
		<div class="bd">	
		<div class="ml"></div> 
		<div class="bd-center"> 
			<div class="loginBox"> 
			<table cellpadding="0" cellspacing="0" border="0" align="center"> 
				<tr> 
					<td align="left"><b>Welcome to</b><br> 
						<IMG src="themes/Sugar5/images/sugar_md_open.png" alt="Sugar" width="340" height="25" style="margin: 5px 0;"> 
					</td> 
				</tr> 
				<tr> 
					<td align="center"> 
						<div class="login"> 
							<form action="login_handle.php" method="post" name="DetailView" id="form"> 
								<table cellpadding="0" cellspacing="2" border="0" align="center" width="100%"> 
																		<tr> 
										<td colspan="2" scope="row"><span id='post_error' class="error"><?php echo $errormessage;?></span></td> 
									</tr> 
																	<tr> 
										<td scope="row" colspan="2" style="font-size: 12px; font-weight: normal; padding-bottom: 4px;">请输入用户名和密码										</td> 
									</tr> 
									<tr> 
										<td scope="row" width="23%">用户名:</td> 
										<td width="77%"><input type="text" size='35' tabindex="1" id="user_name" name="name"  value='' /></td> 
									</tr> 
									<tr> 
										<td scope="row">密码:</td> 
										<td width="77%"><input type="password" size='26' tabindex="2" id="user_password" name="password" value='' /></td> 
									</tr> 
																		<tr> 
										<td>&nbsp;</td> 
										<td><input title="Log In " class="button primary" type="submit" tabindex="3" id="login_button" name="Login" value="登陆"><br>&nbsp;</td>		
									</tr>
<tr>
<td colspan="2">公共测试帐号和密码：test888,如果您想单独开一帐号试用，请与我们联系.</td>
								    </tr> 
								</table> 
							</form> 
						</div> 
					</td> 
				</tr> 
			</table> 
			</div> 
			</div> 
			<div class="mr"></div> 
			</div> 
<div class="ft"><div class="bl"></div><div class="ft-center"></div><div class="br"></div></div> 
</div> 
		</td> 
	</tr> 
</table> 
<br> 
<br>
</td></tr></table> 
    </div> 
    <div class="clear"></div> 
</div> 
<?php
include "bottom.php";
?>