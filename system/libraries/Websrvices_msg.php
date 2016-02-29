<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class CI_Websrvices_msg
{
	public function __construct()
	{			
		define('securitytoken', "Invalid security token.");
		define('requirefield',"The required fields are missing!");		
		
		define('user_notavailable',"Email does not exists in our system!");
		
		//For Login
		define('login_success',"Successfully logged in!");
		define('login_incorrect_fb',"Incorrect Facebook login details!");
		define('login_success_fb',"Successfully logged in!");
		define('login_success_email',"Successfully logged in!");
		define('login_incorrect',"Email and password does not match!");
				
		//For Signup
		define('signup_success',"Sign up is successful!");
		define('signup_unable',"Unable to signup, please try again!");
		define('signup_email_exist',"A user with this email already exists in our system!");		
	}
}
?>
