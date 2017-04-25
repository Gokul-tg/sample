{literal}
<script language="javascript" type="text/javascript" src="javascript/jquery-latest.js"></script>
<script language="javascript" type="text/javascript" src="javascript/admin_valid.js"></script>
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
      
<script language="javascript" type="text/javascript">

function validation()
{ 
	document.getElementById('errmsg').innerHTML='';
	document.getElementById('sucmsg').innerHTML='';
	
	var uname=trim(document.getElementById('uname').value);
	document.getElementById('uname').value=uname;
	
	var pwd=trim(document.getElementById('pwd').value);
	document.getElementById('pwd').value=pwd;
	
	if(uname==''){
		document.getElementById('errmsg').innerHTML='Please enter the Username';
		document.getElementById('uname').focus();
		return false;
	}
	if(pwd==''){
		document.getElementById('errmsg').innerHTML='Please enter the Password';
		document.getElementById('pwd').focus();
		return false;
	}

	$('#hdAction').val('1');
}

</script>
{/literal}

<html>
<head>
<title>Login Form</title>
<body>
<form name="login" id="login" value="" action="welcome.php" method="post" onSubmit="return validation();">
<input type="hidden" name="Ident" value="">
<input type="hidden" name="CatIdent" value="">
<input type="hidden" name="redirect">
<input type="hidden" name="hdAction" id="hdAction">
   <div class="container" align="center">
   <h3>Login Form</h3>
    <label><b>Username:</b></label>
    <input type="text" name="uname" id="uname" placeholder="Enter Username" value="">
</br></br>
    <label><b>Password: </b></label>
    <input type="password" name="pwd" id="pwd" placeholder="Enter Password" value="">
</br></br>
    <input type="submit" name="submit" value="Login" class="btn" onclick="return validation();"/>
   </div>                          
</form>
</body>
</head>
</html>