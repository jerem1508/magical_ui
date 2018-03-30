function email_verification(email)
{
	console.log("email_verification : " + email);


	return true;
} // /email_verification()


function get_new_password(email)
{
	console.log("get_new_password : " + email);



	return "toto";

} // /get_new_password()


function send_email(type_email, param)
{
    console.log("send_email : type=" + type_email + " ,param : " + param);

	var tparams = {
		"type" : type_email,
		"data" : param
	}

	console.log(JSON.stringify(tparams));

    $.ajax({
        type: 'post',
        dataType: "json",
        contentType: "application/json; charset=utf-8",
        url: 'Home/send_password',
        data: JSON.stringify(tparams),
        success: function (result) {
			console.log("send_email SUCCESS");
			console.log(result);
        },
        error: function (result, status, error){
			console.log("send_email ERROR");
			console.log(result);
        }
	});// /ajax
} // /send_email()
