RE_EMAIL            = new RegExp(/^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,6}$/);


//for checking email duplicacy

var emailFlag = 0;
function checkEmail()
{
	if(!document.getElementById('email').value.match(RE_EMAIL)){
	//alert('E-mail should be as: example@yahoo.com!');
	//var response=document.write("E-mail should be as: example@yahoo.com!");
	document.getElementById('msbox').innerHTML='E-mail should be as: example@yahoo.com!';
	}
	else
	{
	var email = document.getElementById('email').value;
	
	var params	= 'email='+email;
	
	$.ajax({type: "get",url:"checkemail.php",data: params,success: responseEmail});
	}
//	alert(url)

}
function responseEmail(response)
{

   //var response = transport.responseText;
   //alert(response);
   if(response == 1)
   {
      emailFlag = 1;  
	  document.getElementById('msbox').style.color ="GREEN";
	  document.getElementById('msbox').innerHTML="E-mail is available";
   }
   else
   {
	   emailFlag = 0; 
	   document.getElementById('msbox').style.color ="RED";
	   document.getElementById('msbox').innerHTML="E-mail is not available";
   }
   //document.getElementById('msbox').innerHTML=response;
}
