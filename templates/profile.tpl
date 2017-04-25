{include file="header.tpl"}
{literal}
<script>
function validate()
{  
	// alert('hi');
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
    // if(document.getElementById("img").value == "")	
    // {
	   // document.getElementById('valid').innerHTML="Please select the image";
    //   document.getElementById('img').focus();
    //        return false;
    // }
    if(document.getElementById("Prof_status").value == "")	
    {
	   document.getElementById('valid').innerHTML="Please enter the Status";
      document.getElementById('Prof_status').focus();
           return false;
    }
    document.getElementById('hdAction').value=1;
   // updateuser();
    disableField();
}
function updateuser() { 
	alert('hi');
	var str = $("#prof").serialize();
	var limit=2;
	alert(limit);
	alert(str);
		 $.ajax({
	       url: 'updateuser.php',
	       type: 'POST',
	       data: "perpage="+limit+"&"+str,
	       success: function(data) {
			
	         alert(data);
	             //finished
	         }
	    });
		/*$.ajax({
				url: "updateuser.php?"+$( '#profile' ).serialize(),
				success: function(result){
					var btnSuccess = document.querySelector('.Success');
					btnSuccess.innerHTML = result;
			}
		});*/
	}
function enableField(){
	var elementList = document.querySelectorAll('.field-disable'),
		colorElem = document.querySelector('.jscolorpicker'),	
		btnEdit = document.querySelector('.btn-edit'),
		btnSave = document.querySelector('.btn-save'),
		btnChange = document.querySelector('.btn-change'),
		length = elementList.length,
		element, i;

		btnEdit.classList.add('hide');
		btnSave.classList.remove('hide');
		btnChange.classList.remove('hide');
		colorElem.classList.remove('jscolor-hide');

	for (i = 0; i < length; i++) {
		element = elementList[i];
		element.classList.add('field-enable');
		element.classList.remove('field-disable');
		element.disabled = false;		
	}
}
function disableField(){
	var elementList = document.querySelectorAll('.field-enable'),
		colorElem = document.querySelector('.jscolorpicker'),
		btnEdit = document.querySelector('.btn-edit'),
		btnSave = document.querySelector('.btn-save'),
		btnChange = document.querySelector('.btn-change'),
		length = elementList.length,
		element, i;

	btnEdit.classList.remove('hide');
	btnSave.classList.add('hide');
	btnChange.classList.add('hide');
	colorElem.classList.add('jscolor-hide');
	for (i = 0; i < length; i++) {
		element = elementList[i];
		element.classList.add('field-disable');
		element.classList.remove('field-enable');
		element.disabled = true;
	}
}
function changeBg(value) {

	element = document.querySelector('.petowner-detail');
	element.style.backgroundColor = '#'+value;
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
	<form name="prof" id="prof" method="post" action="" enctype="multipart/form-data" />
		<div style="margin-right: 100px;" class="top-bar" align="right">
				<input type="button" class="btn btn-success spb btn-edit" value="Edit" onclick="enableField();">
				<input type="button" class="btn btn-success spb btn-save hide" value="Save" onclick="validate();"></span>
			</div>
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" style="margin-top: 50px;text-align: center;">
		<div class="show-image">
		<h3>
			<img border="0" src="uploads/{$Users.0.UserImage}" style="max-width: 150px; max-height: 150px;" /> 
		</h3> 
			<input type="file" name="img" id="img" class="editable btn-change hide" style="cursor: pointer;" >
			 
		</div>
		<h3>
			<span><input type="text" id="Prof_status" class="editable field-disable" style="width: 109%;" name="Prof_status"
			disabled value="{$Users.0.Prof_status|stripslashes|htmlspecialchars}" /> </span>
		</h3>
	</div>
	<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
	<div class="" align="left">
		<h3 align="center">
		<input type="hidden" name="hdAction" id="hdAction"></input> 
		<input 	type="hidden" name="Ident" id="Ident" value="{$smarty.request.Ident}"></input>
		<div id="error" style="color: red; align: center;">
	    <span align:center" id="valid">{if $smarty.request.err neq ''}{$smarty.request.err}{/if}</span>
		</div>
		<div style="color: green; align: center" class="Success" id="sucmsg">{$SuccessMessage}</div>
		<b>
		<u style="margin-right:45%;">MY PROFILE PAGE</u></b>
		</h3>
		<h3>
			<span class="col-lg-6 col-md-6">Name: </span>
			<span><input type="text" id="name" class="field-disable" name="name" disabled	value="{$Users.0.Name|stripslashes|htmlspecialchars}" maxlength="30" />
			</span>
		</h3>
		<h3>
			<span class="col-lg-6 col-md-6">Age: </span>
			<span><input type="text" id="age" class="field-disable" name="age" disabled
			value="{$Users.0.Age|stripslashes|htmlspecialchars}" maxlength="30" /></span>
		</h3>
		<h3>
			<span class="col-lg-6 col-md-6">Designation: </span>
			<span><input type="text" id="designation" class="field-disable"	name="designation"
			disabled value="{$Users.0.Designation|stripslashes|htmlspecialchars}" maxlength="30" /> </span>
		</h3>
		<h3>
			<span class="col-lg-6 col-md-6">Email: </span>
			<span><input type="text" id="email" class="field-disable" name="email" disabled value="{$Users.0.Email|stripslashes|htmlspecialchars}" maxlength="30" /> </span>
		</h3>
		<h3>
			<span class="col-lg-6 col-md-6">Address: </span>
			<span><textarea name="address" class="field-disable" disabled id="address">{$Users.0.Address|stripslashes|htmlspecialchars}</textarea>
			</span>
		</h3>
		
		<h3>
			<span class="col-lg-6 col-md-6">Background: </span>
			<input type="text" id="bgcolor" name="bgcolor" class="jscolorpicker jscolor-hide jscolor field-disable" disabled  onchange="changeBg(this.value)">
		</h3>
	</div> 
	</form>
</div>
<div class="clear"></div>
</div>
</div>
</body>
</html>
