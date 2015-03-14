function setCookie(cname, cvalue, exmins) {
    var d = new Date();
    d.setTime(d.getTime() + (exmins*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) != -1) return c.substring(name.length, c.length);
    }
    return null;
}

function ajaxCall(request_postinfo,onstatechange)
{	
	url = request_postinfo.url;
	url = url.split('/');
	class_name = url[0];
	action = url[1];
    token = getCookie("token");
	if(token == 'undefined')
		token = null;
	if(token != null && action == 'fb_login')
		return;
	if(token == null && !(class_name == 'login'))
		location = '/login.html';
	else
	{	
		request_postinfo.usrtoken = token;
		$.ajax({
			url:'cross.php',
			type: 'POST',
			data : request_postinfo,
			success: function(data, textStatus, jqXHR)
			{
			    result = JSON.parse(jQuery.parseJSON(data));
				minnum = 60;
				if(action == 'login' || action == 'fb_login' || action == 'fb_login_test' || action == 'sign_up')
				{
					token =	result.token; 
				}
				else if(action == 'logout')
					minnum = -1;
				setCookie('token',token,minnum);
			    onstatechange(result);
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('ajax error - '+errorThrown);
			}
		});
	}
}

