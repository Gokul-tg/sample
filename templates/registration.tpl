<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>::Test Project::</title>
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" href="css/all.css">
</head>
{literal}
<script>
function validate()
{
	var passRegex=/^(?=.*\d)(?=.*[a-zA-Z])(?!.*\s).{6,12}$/;
	var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
	var alpha=/^[a-zA-Z ]+$/;
	var phoneRegx = /^\d{10}$/;
	var ValidChars = /^[0-9]{1,}[.]?[0-9]{1,2}$/;
	document.getElementById('valid').innerHTML="";
	if(document.getElementById("name").value == "")	
     {
	   document.getElementById('valid').innerHTML="Please enter the name";
       document.getElementById('name').focus();
            return false;
     }
	if(document.getElementById("password").value == "")	
    {
	   document.getElementById('valid').innerHTML="Please enter the password";
      document.getElementById('password').focus();
           return false;
    }
    if(document.getElementById("age").value == "")	
     {
	   document.getElementById('valid').innerHTML="Please enter the age";
       document.getElementById('age').focus();
            return false;
     }
    if(document.getElementById("designation").value == "")	
    {
	   document.getElementById('valid').innerHTML="Please enter the designation";
      document.getElementById('designation').focus();
           return false;
    }
    if(document.getElementById("email").value == "")	
    {
	   document.getElementById('valid').innerHTML="Please enter the email";
      document.getElementById('email').focus();
           return false;
    }
    if (!emailRegex.test(email.value))	
    {
	   document.getElementById('valid').innerHTML="Please enter the valid email";
      document.getElementById('email').focus();
           return false;
    }
    if(document.getElementById("address").value == "")	
    {
	   document.getElementById('valid').innerHTML="Please enter the address";
      document.getElementById('address').focus();
           return false;
    }
    if(document.getElementById("img").value == "")	
    {
	   document.getElementById('valid').innerHTML="Please select the image";
      document.getElementById('img').focus();
           return false;
    }
    if(document.getElementById("Prof_status").value == "")	
    {
	   document.getElementById('valid').innerHTML="Please enter the Status";
      document.getElementById('Prof_status').focus();
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
<div align="right" class="top-bar">
				<input type="button" value="Login" onclick="window.location.href='index.php'"></input>
			</div>
		<div id="center-column"> 
			<div align="center" class="top-bar">
				<h1>Registration</h1>
			</div>
			<br />
			<div class="Error" align="center" id="errmsg"></div>
			<form name="login" method="post" action="" onsubmit="return validate();" enctype="multipart/form-data">
			<input type="hidden" name="hdAction" id="hdAction"></input>
			<input type="hidden" name="Ident" id="Ident"></input>
				<div align="center" id="error" style="color:red; align: center;">
				<span id="valid">{if $smarty.request.err neq ''}{$smarty.request.err}{/if}</span>
				<div style="color:green; align:center" class="Success" id="sucmsg">{$SuccessMessage}</div>
				</div>
			  <div class="login-table">
					<table width="500px" align="center"cellpadding="5" cellspacing="3" class="listing-table">
						<tr class="bg">
							<td style="text-align:right;" width="35%"><strong>Name: </strong><font color="#FF0000">*</font></td>
							<td class="first style3" width="65%"><input type="text" id="name" class="editable" name="name"  value=""  maxlength="30" /></td>
						</tr>
						<tr class="bg">
							<td style="text-align:right;" width="35%"><strong>Password: </strong><font color="#FF0000">*</font></td>
							<td class="last"><input type="password" class="textbox" name="password" id="password" /></td>
						</tr>
						 <tr>
							<td style="text-align:right;" width="35%"><strong>Age: </strong><font color="#FF0000">*</font></td>
							<td class="first style3" width="65%"><input type="text" id="age" class="editable" name="age"  value=""  maxlength="30" /></td>
						</tr>
						<tr>
							<td style="text-align:right;" width="35%"><strong>Designation: </strong><font color="#FF0000">*</font></td>
							<td class="first style3" ><input type="text" id="designation" class="editable" name="designation"  value=""  maxlength="30" /></td>
						</tr>
						<tr>
							<td style="text-align:right;" width="35%"><strong>Email: </strong><font color="#FF0000">*</font></td>
							<td class="first style3" ><input type="tetx" id="email" class="editable" name="email"  value=""  maxlength="30" /></td>
						</tr>
						<tr>
							<td style="text-align:right;" width="35%"><strong>Address: </strong><font color="#FF0000">*</font></td>
							<td class="first style3" ><textarea id="address" class="editable" name="address"  value=""  maxlength="30" /></textarea></td>
						</tr>
						<tr>
						<td style="text-align:right;" width="35%"><strong><label for="imageupload">Image:</label></strong><font color="#FF0000">*</font></td>
						<td class="last"><input name="img" id="img" type="file"></td>
					</tr>
					<tr>
							<td style="text-align:right;" width="35%"><strong>Status: </strong><font color="#FF0000">*</font></td>
							<td class="first style3" ><input type="text" id="Prof_status" class="editable" name="Prof_status"  value=""  maxlength="30" /></td>
						</tr>
						<tr class="bg">
							<td colspan="2" align="center">
							<input type="submit" class="btn-submit" value="Register" name="submit" onclick="return validate();"/></td>
						</tr>
				</table>
			  </div>
		    </form>
		</div>
		
	</div>
	<div style="clear:both;"></div>
	
	</div>
</body>
</html>