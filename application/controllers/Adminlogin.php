<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adminlogin extends CI_Controller 
{
	public function __construct()
    {
    	parent::__construct();
		/*require_once APPPATH.'../vendor/autoload.php';
		$client = new Google_Client();
		$client->setApplicationName($this->config->item('applicationName'));
		$client->setDeveloperKey($this->config->item('developerKey'));
        $client->setClientSecret($this->config->item('clientSecret'));
        $client->setClientId($this->config->item('clientId'));
        $client->setRedirectUri("http://localhost/crannyapplocal/admin/googlelogin");
        $client->addScope("https://www.googleapis.com/auth/userinfo.email");
        
        if ($client->getAccessToken()) {
          $userData = $objOAuthService->userinfo->get();
          $access_token = $client->getAccessToken();
        } else {
          $authUrl = $client->createAuthUrl();
          echo '<a href="'.$authUrl.'">Google Login</a>';
        }
        die();*/
		$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');		
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');		
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);  		
		$this->output->set_header('Pragma: no-cache');
		$this->load->database();
		$this->load->model('adminuserModel');		
  	}
	
    /**
    * Check if the user is logged in, if he's not, 
    * send him to the login page
    * @return void
    */		
	function dashboard()
	{
		if($this->session->userdata('is_logged_in'))
		{
			$data['mainContent'] = 'admin/dashboardPage';		
			$this->load->view('admin/includes/template', $data);	
		}
		else
		{
			redirect('admin/login');
		}
	}	
	
	function index()
	{
		if($this->session->userdata('is_logged_in'))
		{			
			$data['mainContent'] = 'admin/dashboardPage';		
			$this->load->view('admin/includes/template', $data);
		}
		else
		{		
            $authUrl = '';
            $redirect_uri = "http://localhost/crannyapplocal/admin/login";
			require_once APPPATH.'../vendor/autoload.php';
            $client = new Google_Client();
            $client->setApplicationName($this->config->item('applicationName'));
            $client->setDeveloperKey($this->config->item('developerKey'));
            $client->setClientSecret($this->config->item('clientSecret'));
            $client->setClientId($this->config->item('clientId'));
            $client->setRedirectUri($redirect_uri);
            $client->addScope("https://www.googleapis.com/auth/userinfo.email");
             
            // Send Client Request
            $objOAuthService = new Google_Service_Oauth2($client);
            
            // Add Access Token to Session
            if (isset($_GET['code'])) {
              $client->authenticate($_GET['code']);
              $_SESSION['access_token'] = $client->getAccessToken();
              $client->setAccessToken($_SESSION['access_token']);
              $userData = $objOAuthService->userinfo->get();
              //header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
              $uemail = $userData->email;
              // check in database if this email exists
              $is_emailExist = $this->adminuserModel->findDuplicateEmail($uemail);
              if($is_emailExist)
              {
                $data = array(
                  'username' => $userData->name,
                  'is_logged_in' => true,
                  'user_id' => '',//$userinfo[0]['adminuser_id'],
                  'usertype' => ''//$userinfo[0]['user_role']
                );
                $this->session->set_userdata($data);
                redirect('admin/dashboard');
              }
              else
              {
                unset($_SESSION['access_token']);
                redirect('admin/login');
              }
              //print '<pre>'; print_r($userData); print_r($_SESSION);exit;
            }
            else {
              $authUrl = $client->createAuthUrl();
              $data['authUrl'] = $authUrl;
            }
            
            /*// Set Access Token to make Request
            if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
              $client->setAccessToken($_SESSION['access_token']);
              $userData = $objOAuthService->userinfo->get();
              print '<pre>';
              print_r($userData);
              print_r($_SESSION);
              exit;
            }

            if ($client->getAccessToken()) {
              $userData = $objOAuthService->userinfo->get();
              $access_token = $client->getAccessToken();
              $_SESSION['access_token'] = $client->getAccessToken();
            } else {
              $authUrl = $client->createAuthUrl();
              //echo '<a href="'.$authUrl.'">Google Login</a>';
              $data['authUrl'] = $authUrl;
            }*/
			
			$this->load->view('admin/login', $data);	
        }

	}  //// End Of Index Function
	
	public function googleLoginSubmit ()
	{
	    require_once APPPATH.'../vendor/autoload.php';
        $client = new Google_Client();
        $client->setApplicationName($this->config->item('applicationName'));
		$client->setDeveloperKey($this->config->item('developerKey'));
        $client->setClientSecret($this->config->item('clientSecret'));
        $client->setClientId($this->config->item('clientId'));
        //$client->setRedirectUri("http://localhost/crannyapplocal/admin/googlelogin");
        //$client->addScope("https://www.googleapis.com/auth/userinfo.email");

        // Send Client Request
        $objOAuthService = new Google_Service_Oauth2($client);
        $userData = $objOAuthService->userinfo->get();
        if ($client->getAccessToken()) {
          $userData = $objOAuthService->userinfo->get();
          $access_token = $client->getAccessToken();
        } else {
          $authUrl = $client->createAuthUrl();
        }
	    echo "<pre>"; print_r($userData);
    	exit;
		//$this->load->view('google', $data);
    }
	
	/*** encript the password 
    * @return mixed    */
	function __encrip_password($password)
	{
		return base64_encode($password);
	}
	
	/**
    * check the username and the password with the database
    * @return void
    */
	function validateCredentials()
	{	
		$username = $this->input->post('username');
		$password = $this->__encrip_password($this->input->post('password'));
		// echo $username." ".$password; 
		$userinfo = $this->adminuserModel->validate($username,$password);	
		//echo '<pre>'; print_r($userinfo); exit;
	    if($userinfo)
		{
			$data = array(
				'username' => $userinfo[0]['user_name'],
				'is_logged_in' => true,
				'user_id' => $userinfo[0]['adminuser_id'],
				'usertype' => $userinfo[0]['user_role']
			);
			$this->session->set_userdata($data);
			
			$remember = $this->input->post('remember_me');
			//print_r($this->session->userdata()); exit;
			if($remember)
			{
				$cookie = array(
					'name'   => 'remember_me',
					'value'  => $username,
					'expire' => '86500'
				);
				$this->input->set_cookie($cookie);

				$cookie1 = array(
					'name'   => 'remember_pass',
					'value'  => $password,
					'expire' => '86500'
				);

				$this->input->set_cookie($cookie1); 
			}
			elseif(!$remember) 
			{
				if($this->input->cookie('remember_me')!='') 
				{
					$cookie = array(
						'name'   => 'remember_me',
						'value'  => $username,
						'expire' => ''
					);
					$this->input->set_cookie($cookie); 
				}
				if($this->input->cookie('remember_pass')!='') 
				{
					$cookie1 = array(
						'name'   => 'remember_pass',
						'value'  => $password,
						'expire' => ''
					);
					$this->input->set_cookie($cookie1); 
				}
			}
			redirect('admin/dashboard');
		}
		else // incorrect username or password
		{	
			$username = '';
			if($this->input->cookie('remember_me')!='')
			{
				$username = $this->input->cookie('remember_me');

			}
			$data['username'] = $username;					
			$data['uname_error'] = "Invalid email or password.";
			$this->load->view('admin/login', $data);
		}
	}	

	/**
    * Destroy the session, and logout the user.
    * @return void
    */		

	function logout()
	{  
	   $this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
       $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
       $this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);  
       $this->output->set_header('Pragma: no-cache');
	   $data = array(
				     'username' => '',
				     'is_logged_in' => false,
					 'user_id' => '',
					 'usertype' => ''
		            );
		$this->session->unset_userdata($data);
        $this->session->sess_destroy();
		unset($_SESSION['access_token']);
		redirect('admin');
	}
	
    /**
    * The method just loads the forgot password view
    * @return void
    */
	function forgot()
	{
		$this->load->view('admin/forgot');	
	}
  	
	/**
    * check the username  with the database
    * @return void
    */
	function forgot_validateCredentials()
	{	
		$username = $this->input->post('email_id');
		$is_valid = $this->adminuserModel->forgot_validate($username);
		
		if($is_valid)
		{
			/** for generate 4 digit password */
			$alphabet = "0123456789";
			$newpass = array(); //remember to declare $pass as an array
			$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
			//exit;
			for ($i = 0; $i < 6; $i++) 
			{
				$n = rand(0, $alphaLength);
				$newpass[] = $alphabet[$n];
			}
			//print_r($newpass);
			
			$pass = implode("",$newpass);
			//	exit;
			
			$data['report'] = $this->adminuserModel->update_validate($username,$this->__encrip_password($pass)); 
			$data['query'] = $this->adminuserModel->get_all();
			//echo $data['query'][0]['email']; exit;
			/* echo $data['query'][0]['name'];*/
			
			if ($data['report'] > 0)
			{	
				//$new_password = $pass; // New password create
				$template_details = array(
											 'name' => "Admin",
											 'email' => $data['query'][0]['email'],
											 'link' =>  base_url(),
											 'path' =>  base_url().'assets/images/',
											 'password' => $pass,
											 'admin_email' => $this->config->item('admin_email')
										   );
				 //echo '<pre>'; print_r( $template_details ); 
				 
				$msg = $this->parser->parse('mail_templetes/forgotpassword',$template_details, TRUE);
				/*echo $msg;
				exit;*/
				$project_name = $this->config->item('project_name');
				$this->email->from($this->config->item('from_email'), $project_name);
				$this->email->to($data['query'][0]['email']);
				$this->email->subject($project_name." - Reset Password");
				$this->email->message($msg);
				$send = $this->email->send();
								
				//redirect('admin/login');
				
				$data['succ_msg'] = "We have reset the password and send it to your registered email address.";
			}
			$this->load->view('admin/forgot', $data);
		}
		else // incorrect username 
		{
		   $data['uname_error'] = "Email does not exist.";
		   $this->load->view('admin/forgot', $data);	
		}
	}	
	
	/*************************************************************** ADD Data *******************************************************/

	function add()
    {	
		//if save button was clicked, get the data sent via post
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{
			$this->form_validation->set_rules('name', 'name', 'required');
			$this->form_validation->set_rules('password', 'password', 'required|min_length[6]');
			$this->form_validation->set_rules('email', 'email', 'required|valid_email');
			//$this->form_validation->set_rules('number', 'Contact Number', 'required|max_length[15]|min_length[10]');						
			$this->form_validation->set_error_delimiters('<br /><em class="error">', '</em>');
			
			if ($this->form_validation->run() == FALSE) // validation hasn't been passed
			{			
				//$data['mainContent'] = 'admin/adminuser/authorAdd';		
				//$this->load->view('admin/includes/template', $data);
			}
			else // passed validation proceed to post success logic
			{
				$is_emailExist = $this->adminuserModel->findDuplicateEmail($this->input->post('email'));
				$is_nameExist = $this->adminuserModel->findDuplicateName($this->input->post('name'));
				
				if($is_emailExist)
				{
					/*$this->session->set_flashdata('flash_message', 'Email already Exist.');
					$this->session->set_flashdata('flash_type', 'error');
						
					redirect('admin/adminuser/add');   // or whatever logic needs to occur*/
					
					$msg= 'Email '.EXIST;
					$msgtype= 'error';
					
					//$data['mainContent'] = 'admin/adminuser/authorAdd';		
					//$this->load->view('admin/includes/template', $data);
				}
				elseif($is_nameExist)
				{
					/*$this->session->set_flashdata('flash_message', 'Name already Exist.');
					$this->session->set_flashdata('flash_type', 'error');
						
					redirect('admin/adminuser/add');   // or whatever logic needs to occur*/
					
					$msg= 'Name '.EXIST;
					$msgtype= 'error';
				}
				else
				{
					
					// build array for the model
					//$encrypted_string = ENCODE($pass, ('my_random_salt'.'my_secret_password'));
					$form_data = array(
									'name' => set_value('name'),
									'email' => $this->input->post('email'),
									'password' => base64_encode($this->input->post('password')),
									'isActive' => $this->input->post('isActive')
									
								);
								
					// run insert model to write data to db
				
					if ($this->adminuserModel->setAdminloginData($form_data) == TRUE) // the information has therefore been successfully saved in the db
					{
						$this->session->set_flashdata('flash_message', 'User'.ADDMSG);
						$this->session->set_flashdata('flash_type', 'success');
						
						redirect('admin/adminuser');   // or whatever logic needs to occur
					}
					else
					{
					   $this->session->set_flashdata('flash_message', 'ErrorWhile Saving Data.');
					   $this->session->set_flashdata('flash_type', 'error');
					}
					
				}
				
			}
		}
		$data['message']=isset($msg)?$msg:'';
		$data['messagetype']=isset($msgtype)?$msgtype:'';
		$data['mainContent'] = 'admin/adminuser/adminuserAdd';		
		$this->load->view('admin/includes/template', $data);
	}  /// End Of ADD Function
	
	/************************************************************ Update item by his id  * @return void ************************/
    public function update()
    {
		//admin id 
		$id = $this->uri->segment(4);
		
		//if save button was clicked, get the data sent via post
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{
			//form validation
			$this->form_validation->set_rules('name', 'name', 'required');
			$this->form_validation->set_rules('password', 'password', 'required|min_length[6]');
			$this->form_validation->set_rules('email', 'email', 'required|valid_email');
			//$this->form_validation->set_rules('number', 'Contact Number', 'required|max_length[15]|min_length[10]');	
			$this->form_validation->set_error_delimiters('<br /><em class="error">', '</em>');
			
			//if the form has passed through the validation
			if ($this->form_validation->run())
			{
				
				$is_nameExist = $this->adminuserModel->GetDuplicateName($this->input->post('name'),$id); // return 1 or blank
				$is_emailExist = $this->adminuserModel->GetDuplicateEmail($this->input->post('email'),$id); // return 1 or blank
				//echo $is_nameExist;
				//exit;
				if($is_nameExist)
				{
					/*$this->session->set_flashdata('flash_message', 'Name'.EXIST);
					$this->session->set_flashdata('flash_type', 'error');
						
					redirect('admin/adminuser/update/'.$id);   // or whatever logic needs to occur*/
					$msg= 'Name '.EXIST;
					$msgtype= 'error';
				}
				else if($is_emailExist)
				{
					/*$this->session->set_flashdata('flash_message', 'Email'.EXIST);
					$this->session->set_flashdata('flash_type', 'error');
						
					redirect('admin/adminuser/update/'.$id);   // or whatever logic needs to occur*/
					$msg= 'Email '.EXIST;
					$msgtype= 'error';
				}
				else
				{
					
					// build array for the model
					$form_data = array(
									'name' => set_value('name'),
									'email' => $this->input->post('email'),
									'password' => base64_encode($this->input->post('password')),
									'isActive' => $this->input->post('isActive')
								);
					// End Slider Image upload
					//if the insert has returned true then we show the flash message
					if($this->adminuserModel->setUpdatedAdminloginData($id, $form_data) == TRUE)
					{
						$this->session->set_flashdata('flash_message', 'User'.UPDATEMSG);
						$this->session->set_flashdata('flash_type', 'success');
						
					}
					else
					{
						$this->session->set_flashdata('flash_message', 'ErrorWhile Saving Data.');
						$this->session->set_flashdata('flash_type', 'error');
					}
					redirect('admin/adminuser');
					
				}//// End of $is_nameExist this condition
				
			}//validation run
			
		}
		// product data 
		$data['message']=isset($msg)?$msg:'';
		$data['messagetype']=isset($msgtype)?$msgtype:'';
		
		$data['adminuser'] = $this->adminuserModel->get_adminuser_by_id($id);
		
		// load the view
		$data['mainContent'] = 'admin/adminuser/adminuserEdit';		
		$this->load->view('admin/includes/template', $data);         

    } // End Of Update Function

    /**
    * Delete author by his id
    * @return void
    */
    public function delete()
    {
		$id = $this->input->post('id');
		if($this->adminuserModel->deleteadminuserData($id) == true)
		{
			/*  $this->session->set_flashdata('flash_message', 'delete');
		 	 $this->session->set_flashdata('flash_type', 'success');*/
		}
		else
		{
			/*	$this->session->set_flashdata('flash_message', 'error');
			$this->session->set_flashdata('flash_type', 'error');*/
		}
		
		echo "User";
		//  redirect('admin/authors');
    } // End Of Delete Function
	
	/**
    * Delete authors by his id
    * @return void
    */
    public function deleteSelected()
    {
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{
			// authors id array			
			$id = $this->input->post('itemId');
			// $this->adminuserModel->deleteauthorData($id);
			if($this->adminuserModel->deleteadminuserData($id) == true)
			{
				/*$this->session->set_flashdata('flash_message', 'User'.DELETEMSG);
				$this->session->set_flashdata('flash_type', 'success');*/
			}
			else
			{
				/*$this->session->set_flashdata('flash_message', 'error');
				$this->session->set_flashdata('flash_type', 'error');*/
			}
			//redirect('admin/adminuser');
			
			echo "User";
		}
	} // End of Selected Delete 
	
	/* Change status */
	public function changestatus()
    {
		$data['adminuser'] = $this->adminuserModel->get_adminuser_by_id($this->input->post('id'));
		echo $status = ($data['adminuser'][0]['isActive']==1)?0:1;
		
		$data_to_store = array(
			'isActive' => $status,
		);
		$this->adminuserModel->setUpdatedAdminloginData($this->input->post('id'), $data_to_store);
		
    } // End of update status
	
	///////////// Chnage Page Size For Paginarion //////////	
	function chagepagesize()
    {  
	  $limit = $this->input->post('limit'); 
	  $data = array('pagesize' => $limit);
	  $this->db->where('module','adminuser');
	  $this->db->update('pagesize',$data);
	  
	  $report = array();
	  $report['error'] = $this->db->error();
	  $report['message'] = $this->db->error();
	  
	  if($report !== 0)
	  {
			return true;
	  }
	  else
	  {
			return false;
	  }
	}
	/* delete profile pic. */
	public function deleteimage()
    {
		$upload_path = $this->config->item('base_path').'assets/uploads/adminuser';
		$id = $this->input->post('admin_id');
		$data_to_store = array(
			'profile_pic' => '',
		);
		$this->adminuserModel->deleteadminuserimage($upload_path,$id,$data_to_store);
		
    }
	
	////// For Export Data To Excel ///////
	public function exportToexcel()
	{
			$data['export'] = $this->adminuserModel->getAllAdminlogin();   
			$this->load->view('admin/adminuser/admin_excel', $data);        
	}
}
?>