<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>::Test Project::</title>
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" href="css/all.css">
</head>
{literal}
<script language="javascript" type="text/javascript" src="javascript/admin_valid.js"></script>
<script>

function cursor_val()
{
	document.login.username.focus();
}

function validate()
{
	document.getElementById('valid').innerHTML="";
		if(document.getElementById("username").value == "")	
     {
	   document.getElementById('valid').innerHTML="Please enter username";
       document.getElementById('username').focus();
            return false;
     }
    if(document.getElementById("password").value == "")	
     {
	   document.getElementById('valid').innerHTML="Please enter password";
       document.getElementById('password').focus();
            return false;
     }
    document.getElementById('hdAction').value=1;
}
</script>

{/literal}
<!--Design Prepared by Rajasri Systems-->   
<body>
<div id="main">
<div class="logo"><a href="#"><img src="img/logo.png" alt="" style="width:50px; height:50px;"/></a></div>
<div style="clear:both;"></div>
<div id="login-panel">
		<div id="center-column"> 
			<div  align="center" class="top-bar">
				<h1>User Login</h1>
			</div><br />
			<div class="Error" align="center" id="errmsg"></div>
			
			<form name="login" method="post" action="" onsubmit="return validate();">
			<input type="hidden" name="hdAction" id="hdAction"></input>
			<input type="hidden" name="Ident" id="Ident"></input>
				<div align="center" id="error" style="color:red; align: center; ">
				<span id="valid">{if $smarty.request.err neq ''}{$smarty.request.err}{/if}</span></div>
			  <div class="login-table">
					<table width="500px" align="center" cellpadding="5" cellspacing="3" class="listing-table">
						<tr>
						  <td style="text-align:right;" width="35%"><strong>Username: </strong><font color="#FF0000">*</font></td>
						  <td width="59%" class="last"><input type="text" class="textbox" name="username" id="username" /></td>
						</tr>
						<tr class="bg">
							<td style="text-align:right;" width="35%"><strong>Password: </strong><font color="#FF0000">*</font></td>
							<td class="last"><input type="password" class="textbox" name="password" id="password" /></td>
						</tr>
						<tr class="bg">
							<td colspan="2" align="center"><input type="submit" class="btn-submit" value="Login" name="submit" onclick="return validate();"/>
							<input type="button" value="Register" onclick="window.location.href='registration.php'"></td>
						</tr>
				</table>
			  </div>
		    </form>
		    </div>
		</div>
		
	</div>
	<div style="clear:both;"></div>
	
	</div>
</body>
</html>