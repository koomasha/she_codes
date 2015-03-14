<html>
	<head>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="ajaxfunc.js"></script>
		<script src="test_script.js"></script>
	</head>

	<body>
		<input type="text" value="" id="curr_session">
		
		<h2>Env</h2>
		<table>
			<tr>
				<td>
					<button onclick="env();">Check env</button>
					<div id="env_resonse"></div>
				</td>
			</tr>
		</table>
			
		<h2>Login</h2>
		<table>
			<tr>
				<td>
					<button onclick="sign_up();">Sign up</button>
					<div id="sign_up_resonse"></div>
				</td>
			</tr>	
			<tr>
				<td>
					<button onclick="logout();">Logout</button>
					<div id="logout_resonse"></div>
				</td>
			</tr>	
			<tr>
				<td>
					<button onclick="login();">Login</button>
					<div id="login_resonse"></div>
				</td>
			</tr>
			<tr>			
				<td>
					<button onclick="fb_login_test();">fb_login_test</button>
					<div id="fb_login_test_response"></div>
				</td>
			</tr>	
			<tr>			
				<td>
					<div style="height: 85px;">
					<a href="http://www.shecodes.workingclock.com/login/fb_login?uri=http://localhost/she_codes/test/she_codes_test.php">fb_login</a>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<button onclick="reset_password();">Reset password</button>
					<div id="reset_password_resonse"></div>
				</td>
			</tr>	
		</table>
		
		<h2>Users</h2>
		<table>
			<tr>
				<td>
					<button onclick="get_active_users_by_rating();">Get active users by rating</button>
					<div id="get_active_users_by_rating_response"></div>
				</td>
			</tr>	
			<tr>
				<td>
					<button onclick="search_user();">Search User</button>
					<div id="search_user_response"></div>
				</td>
			</tr>	
			<tr>
				<td>
					<button onclick="get_my_data();">Get My data</button>
					<div id="get_my_data_response"></div>
				</td>
			</tr>
			<tr>
				<td>
					<button onclick="add_rating();">Add rating</button>
					<div id="add_rating_response"></div>
				</td>
			</tr>
		</table>
		
		<h2>Branches</h2>
		<table>
			<tr>
				<td>
					<button onclick="get_branches();">Get branches</button>
					<div id="get_branches_response"></div>
				</td>
			</tr>	
		</table>
		
		
	</body>
</html>