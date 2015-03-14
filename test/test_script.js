//TEST LOGIN SCRIPTS
function env()
{
	
	postinfo ={
		url:'login/env'
	}
	ajaxCall(postinfo,function(response){					
		document.getElementById('env_resonse').innerHTML = JSON.stringify(response);
	});
}


function sign_up()
{
	postinfo ={
		url:'login/sign_up',
		usreml:'koomasha@gmail.com',
		usrpwrd:'12345',
	}
	ajaxCall(postinfo,function(response){					
		document.getElementById('curr_session').value = response.token;
		document.getElementById('sign_up_resonse').innerHTML = JSON.stringify(response);
	});
}


function logout()
{
	
	postinfo ={
		url:'login/logout'
	}
	ajaxCall(postinfo,function(response){					
		document.getElementById('logout_resonse').innerHTML = JSON.stringify(response);
	});
}

function fb_login_test()
{
	postinfo ={
		fbid:"10202869980061851",
		url:'login/fb_login_test'
	}
	ajaxCall(postinfo,function(response){
		document.getElementById('curr_session').value = response.token;
		document.getElementById('fb_login_test_response').innerHTML = JSON.stringify(response);
	});
}

function fb_login(code)
{
	postinfo ={
		fbcode:code,
		url:'login/fb_login'
	}
	ajaxCall(postinfo,function(response){
		document.getElementById('curr_session').value = response.token;
		document.getElementById('fb_login_test_response').innerHTML = JSON.stringify(response);
	});
}

function login()
{
	
	postinfo ={
		url:'login/login',
		usreml:"koomasha@gmail.com",
		usrpwrd:"12345"
	}
	ajaxCall(postinfo,function(response){
		document.getElementById('curr_session').value = response.token;
		document.getElementById('login_resonse').innerHTML = JSON.stringify(response);
	});
}

function reset_password()
{
	
	postinfo ={
		url:'login/reset_password',
		usreml:"koomasha@gmail.com"
	}
	ajaxCall(postinfo,function(response){
		document.getElementById('curr_session').value = response.token;
		document.getElementById('reset_password_resonse').innerHTML = JSON.stringify(response);
	});
}
//END LOGIN TEST


function get_active_users_by_rating()
{
	postinfo ={
		url:'users/get_active_users_by_rating',
		usrpage:1,
		numofusrs:15
	}
	ajaxCall(postinfo,function(response){
		document.getElementById('curr_session').value = response.token;
		document.getElementById('get_active_users_by_rating_response').innerHTML = JSON.stringify(response);
	//test_liat(response);
	});
}

function search_user()
{
	
	postinfo ={
		url:'users/search_user',
		searchstr:'masha',
		usrpage:1,
		numofusrs:40
	}
	ajaxCall(postinfo,function(response){
		document.getElementById('curr_session').value = response.token;
		document.getElementById('search_user_response').innerHTML = JSON.stringify(response);
	});
}

function get_my_data()
{
	
	postinfo ={
		url:'users/get_my_data',
	}
	ajaxCall(postinfo,function(response){
		document.getElementById('curr_session').value = response.token;
		document.getElementById('get_my_data_response').innerHTML = JSON.stringify(response);
	});
}

function add_rating()
{
	
	postinfo ={
		url:'users/add_rating',
		usrid:[3089],
		ratingpoints:2.5,
		ratingremark:"test",
		//branchid:"0",
		//ratingdate:1422832922 //epoch
	}
	ajaxCall(postinfo,function(response){
		document.getElementById('curr_session').value = response.token;
		document.getElementById('add_rating_response').innerHTML = JSON.stringify(response);
	});
}
	
function get_branches()
{
		postinfo ={
		url:'branches/get_branches',
	}
	ajaxCall(postinfo,function(response){
		document.getElementById('curr_session').value = response.token;
		document.getElementById('get_branches_response').innerHTML = JSON.stringify(response);
	});
}	


function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

getCode = getParameterByName("code");
if(getCode != "")
{
	fb_login(getCode);
}
