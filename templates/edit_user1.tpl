{include file="header.tpl"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>::Test Project::</title>
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" href="css/all.css">
</head>
{literal}
<script src="jscolor.js"></script>
<script>

function update(jscolor) {
    // 'jscolor' instance can be used as a string
    document.getElementById('rect').style.backgroundColor = '#' + jscolor
}

$('#colorselector2').ColorPicker({
    color: '#EFEFEF',
    onShow: function (colpkr) {
        $(colpkr).fadeIn(500);
        return false;
    },
    onHide: function (colpkr) {
        $(colpkr).fadeOut(500);
        return false;
    },
    onChange: function (hsb, hex, rgb) {
        $('#colorSelector div').css('backgroundColor', '#' + hex);
    }
});

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

<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1>
				Users<small> Dashboard </small>
			</h1>
			<ol class="breadcrumb">
				<li class=""><a href=""><i class="fa fa-dashboard"></i> Dashboard</a>
				</li>
				<li class="active"><i class="fa fa-dashboard"></i> My Profile</li>
			</ol>
		</div>
	</div>
	 
	<div class="petowner-detail" align="center">
<div id="login-panel">
<div align="right" class="top-bar">
				<a class="btn btn-success spb" href="profile.php">Back</a>
			</div>

		<div id="center-column"> 
			<div align="center" class="top-bar">
				<h1>Edit Details</h1>
			</div>
			<br/>
			<div class="Error" align="center" id="errmsg"></div>
			<form name="login" method="post" action="" onsubmit="return validate();" enctype="multipart/form-data">
			<input type="hidden" name="hdAction" id="hdAction"></input>
			<input type="hidden" name="Ident" id="Ident" value="{$smarty.request.Ident}"></input>
				<div id="error" style="color:red; align: center;">
				<span id="valid">{if $smarty.request.err neq ''}{$smarty.request.err}{/if}</span></div>
				<div style="color:green; align:center" class="Success" id="sucmsg">{$SuccessMessage}</div>
			  <div class="login-table">
					<table width="100%" align="center" cellpadding="5" cellspacing="3" class="listing-table">
						<tr class="bg">
							<td style="text-align:right;" width="35%"><strong>Name: </strong><font color="#FF0000">*</font></td>
							<td class="first style3" width="65%"><input type="text" id="name" class="editable" name="name"  value="{$Users.0.Name|stripslashes|htmlspecialchars}"  maxlength="30" /></td>
						</tr>
						
						 <tr>
							<td style="text-align:right;" width="35%"><strong>Age: </strong><font color="#FF0000">*</font></td>
							<td class="first style3" width="65%"><input type="text" id="age" class="editable" name="age"  value="{$Users.0.Age|stripslashes|htmlspecialchars}"  maxlength="30" /></td>
						</tr>
						<tr>
							<td style="text-align:right;" width="35%"><strong>Designation: </strong><font color="#FF0000">*</font></td>
							<td class="first style3" ><input type="text" id="designation" class="editable" name="designation"  value="{$Users.0.Designation|stripslashes|htmlspecialchars}"  maxlength="30" /></td>
						</tr>
						<tr>
							<td style="text-align:right;" width="35%"><strong>Email: </strong><font color="#FF0000">*</font></td>
							<td class="first style3" ><input type="tetx" id="email" class="editable" name="email"  value="{$Users.0.Email|stripslashes|htmlspecialchars}"  maxlength="30" /></td>
						</tr>
						<tr>
				<td style="text-align:right;" width="35%"><strong>Address: </strong><font color="#FF0000">*</font></td>
				<td style="padding-top: 10px; padding-bottom: 10px;">
				<textarea name="address" id="address">{$Users.0.Address|stripslashes|htmlspecialchars}</textarea>
				</td>
			</tr>
						<tr>
						<td class="first" width="41%"><strong style="float:right;">Image: <span class="mandatory">*</span></strong></td>
			                <td class="last" width="59%">
			               <!--  <input type="hidden" name="img" id="img" value="{$Category.0.Userimage|stripslashes|htmlspecialchars}">  -->
			                <br><img border="0" src="uploads/{$Users.0.UserImage|stripslashes|htmlspecialchars}" style="max-width: 150px; max-height: 150px;"/>
			                <input type="file" name="img" id="img" class="editable" style="cursor: pointer;" >
			                </td>
					</tr>
					<tr>
							<td style="text-align:right;" width="35%"><strong>Status: </strong><font color="#FF0000">*</font></td>
							<td class="first style3" ><input type="text" id="Prof_status" class="editable" name="Prof_status"  value="{$Users.0.Prof_status|stripslashes|htmlspecialchars}"  maxlength="30" /></td>
						</tr>
						
					<tr>
							<td style="text-align:right;" width="35%"><strong>Background: </strong><font color="#FF0000">*</font></td>
							<td class="first style3" ><input class="jscolor" onchange="update(this.jscolor)" value="cc66ff">
							<p id="rect" style="border:1px solid gray; width:161px; height:100px;"></td>
						</tr>
						<tr class="bg">
							<td colspan="2" align="center">
							<input type="submit" class="btn-submit" value="Update" name="submit" onclick="return validate();"/></td>
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