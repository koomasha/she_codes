/*
	url is built from two parts:
	1. main domain: http://www.shecodes.workingclock.com
	2. url adition per action.
	
	for example, url of sign up action:
	http://www.shecodes.workingclock.com/login/sign_up

*/

//GENERAL RESPONSE PROTOTYPE:
	{
		"error":"cann't create connection", //empty string on success, or error description on failure
		"data":[{}{}]
		//data comes here according to action 
	}

//LOGIN CLASS FUNCTION REQUEST EXAMPLE:
{
	
	//fb_login_test
	//URL: login/fb_login_test
	{
		"fbid": "some_id"
	}
	//response
	{
		"usrtoken":"some_token",
	}
	
	//login
	//URL:/login/login
	{
		"usreml":"test@gmail.com",
		"usrpwrd":"12345"
	}
	//response
	{
		"usrtoken":"some_token",
	}

	//fb_login
	//URL:'login/fb_login_test'
	// https://www.facebook.com/dialog/oauth?client_id=492475584228147&redirect_uri=http://www.shecodes.workingclock.com/login/fb_login
	{
		"fbcode":"code that fb returned after the request",
	}
	//response
	{
		"usrtoken":"some_token",
	}

	//reset_password
	//URL:/login/reset_password
	{
		"usreml":"test@gmail.com",
	}
	//only general response. no token.
	
	//logout
	//URL:/login/logout
	{
		"usrtoken":"some_token",
	}
	//only general response. no token.
	
	//sign_up
	//URL:/login/sign_up
	{
		"usreml":"test@gmail.com",
		"usrpwrd":"12345",
		"usrfirstname":"Moshe", //optional
		"usrlastname":"Israeli", //optional
		"usrphone":"0506523652", //optional
		"usrimgurl":"http://test.com/pic.png" //optional
	}
	//response
	{
		"usrtoken":"some_token",
	}
}

//USERS CLASS FUNCTION REQUEST EXAMPLE:
{
	//get_active_users_by_rating
	//URL: users/get_active_users_by_rating
	{
		"usrtoken":"some_token",
		"usrpage":"next_page", 
		"numofusrs":"amount_of_users_you want to get back"
	}
	//response
	{
		"data":[
			"moredata":1/0,
			"usrs"[
				{
				"usrid":"usrid",
				"usrfbid":"fb_id",
				"usrfirstname":"first_name",
				"usrlastname":"last_name",
				"usrrating":"rating",
				"usrimgurl":"img_url",
				"usrstatusname":"status"
				},
				...
			]
		]
	}
	
	//search_user 
	//URL: users/search_user
	{
		"usrtoken":"some_token",
		"searchstr": "some_string"	
		"usrpage":"next_page", 
		"numofusrs":"amount_of_users_you want to get back"
	}
	//response
	{
		"data":[
			"moredata":1/0,
			"usrs"[
				{
				"usrid":"usrid",
				"usrfbid":"fb_id",
				"usrfirstname":"first_name",
				"usrlastname":"last_name",
				"usrrating":"rating",
				"usrimgurl":"img_url",
				"usrstatusname":"status"
				},
				...
			]
		]
	}
	//get_my_data 
	//URL: users/get_my_data
	{
		"usrtoken":"some_token",
	}
	//response
	{
		"data":[
			"usrs"[
				{
				"usrid":"usrid",
				"usrfbid":"fb_id",
				"usrfirstname":"first_name",
				"usrlastname":"last_name",
				"usrrating":"rating",
				"usrimgurl":"img_url",
				"usrstatusname":"status"
				}
			]
		]
	}

	//add_rating
	//URL: users/add_rating
	{
		"usrtoken":"some_token",
		"usrid":[1,2,3], //array of userids
		"ratingpoints":"num_of_points_to_add",
		"ratingremark":"reason_to_add_rating",
		"branchid": "branch id" //optional. when value not present branch will be default
		"ratingdate":"rating_date" //epoch //optional
	}
	//response - only  general
}
//SESSION CLASS FUNCTION:
{	
	//create_session
	//URL: session/create_session
	{
		"usrtoken":"some_token",
		"sessionname":"name",
		"sessionplaceid":"place_id_from_selected_brunch",
		"sessionrating":"amount_of_rating_to_add_at_the_end_of_session",
		"usractive":1/0	//1 will add user as active host in session, 0 will add user as a creator only
		"sessiondate":"date", //optional. default will be set to current time // in next version maybe optional to set future session time
		"sessionactive":1/0 //optional. default will be set to active //session not active will give the optionality to add past session.
	}
	//response
	{
		"data":[{"created session id"}]
	}	
	
	//add_users_to_session
	//URL: session/add_users_to_session
	{
		"usrtoken":"some_token",
		"usrids":"ids_of_usrs_to_add"
	}
	//response - only general response
	
	//delete_users_from_session
	//URL: session/delete_users_from_session
	{
		"usrtoken":"some_token",
		"usrids":"ids_of_usrs_to_delete"
	}
	//response - only general response
	
	//close_session
	//URL: session/close_session
	{
		"usrtoken":"some_token",
		"sessionid":"session_to_close" 
	}
	//response - only general response
	
	//get_active_session	
	//URL: session/get_active_session
	{
		"usrtoken":"some_token"		
	}
	//response
	{
		"data":[
			{
			"sessionid":"usrid",
			"sessionname":"fb_id",
			"sessionplaceid":"first_name".
			"sessiondate":"session_creation_date"
			},
			...
		]
	}
}
	
//BRANCH CLASS FUNCTION:
{	
	//get_branches
	//URL: branches/get_branches
	{
		"usrtoken":"some_token",		
	}
	//response
	{
		"data":[
			{
				"bbranchid":"placeid",
				"branchname":"placename",
				"branchadress":"placeadress",
				"branchphone":"contact_phone",
				"branchemail":"contact_email"
			},
			...
		]
	}
}