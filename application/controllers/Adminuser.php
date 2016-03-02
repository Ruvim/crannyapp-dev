<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adminuser extends CI_Controller 
{
	public function __construct()
    {
    	parent::__construct();
		$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');		
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');		
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);  		
		$this->output->set_header('Pragma: no-cache');
		$this->load->database();
		$this->load->model('adminuserModel');		
  	}
	
	function index()
	{
		$search_string = $this->input->post('search_string');
		////// Get Ascending Or Descending order From Ajax /////////
		//$order = $this->input->post('fieldName');//$this->input->post('orderType'); 
		//$order_type = $this->input->post('orderType');//$this->input->post('orderType');  
		///////// For Check Publish Data or Not with Ajax /////
		//$srchisActive = $this->input->post('srchisActive');
			
		//$startdate = ($this->input->post('startdate')!='') ? date("Y-m-d",strtotime($this->input->post('startdate'))) : '';
		//$enddate = ($this->input->post('enddate')!='') ? date("Y-m-d",strtotime($this->input->post('enddate'))) : '';
		
		//$order = ($order!='') ? $order : 'adminuser_id';
		//$order_type = ($order_type!='') ? $order_type : 'desc';
		$search_string = ($search_string!='') ? $search_string : '';
		//$srchisActive = ($srchisActive!='') ? $srchisActive : '';
		
		 // pagination settings
		if($this->uri->segment(5)!='')
		{
			$limit = $this->uri->segment(5);
		}
		elseif($this->uri->segment(4)!='')
		{
			$limit = $this->uri->segment(4);
		}
		else
		{
			$limit = $this->adminusermodel->get_pagesize('adminuser'); // new added by chirag
		}
		$limit = ($limit!=0) ? $limit : ''; // new added by Rutvi
	
		$config['per_page'] = $limit; // default 20
		$config['pagesize'] = $limit; // new added by Rutvi
		$config['use_page_numbers'] = TRUE;
		$config['num_links'] = 2;		
		$config['base_url'] = $this->config->item('admin_url').'/adminuser';
	
		// limit end
		$page = $this->uri->segment(3);
		
		// math to get the initial record to be select in the database
		$limit_end = ($page * $config['per_page']) - $config['per_page'];
		if ($limit_end < 0)
		{
			$limit_end = 0;
		} 
		
		//$data['count_adminuser']= $this->adminusermodel->countAdminuser($srchisActive,$search_string, $order, $order_type, $startdate, $enddate);
		$data['count_adminuser']= $this->adminusermodel->countAdminuser($search_string);
		$config['total_rows'] = $data['count_adminuser'];
		
		//$data['adminuser'] = $this->adminusermodel->getAdminuser($srchisActive,$search_string, $order, $order_type, $config['per_page'], $limit_end, $startdate, $enddate);
		$data['adminuser'] = $this->adminusermodel->getAdminuser($search_string, $config['per_page'], $limit_end);		
		$this->pagination->initialize($config); //// For Pagination		
		//echo '<pre>';print_r($data['adminuser']); exit;
		$data['mainContent'] = 'admin/adminuser/adminuserList';		
		$this->load->view('admin/includes/template', $data);

	}  //// End Of Index Function
	
	/*** encript the password 
    * @return mixed    */
	function __encrip_password($password)
	{
		return base64_encode($password);
	}		
	
	/*************************************************************** ADD Data *******************************************************/

	function add()
    {	
		$cdate = date("Y-m-d");
		//if save button was clicked, get the data sent via post
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{
			$this->form_validation->set_rules('user_name', 'user_name', 'required');
			//$this->form_validation->set_rules('password', 'password', 'required|min_length[6]');
			$this->form_validation->set_rules('email', 'email', 'required|valid_email');
			$this->form_validation->set_error_delimiters('<br /><em class="error">', '</em>');
			
			if ($this->form_validation->run() == FALSE) // validation hasn't been passed
			{			
				//$data['mainContent'] = 'admin/adminuser/authorAdd';		
				//$this->load->view('admin/includes/template', $data);
			}
			else // passed validation proceed to post success logic
			{
				$is_emailExist = $this->adminuserModel->findDuplicateEmail($this->input->post('email'));
				$is_nameExist = $this->adminuserModel->findDuplicateName($this->input->post('user_name'));
				
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
					
					$msg= 'User name '.EXIST;
					$msgtype= 'error';
				}
				else
				{
					
					// build array for the model
					//$encrypted_string = ENCODE($pass, ('my_random_salt'.'my_secret_password'));
					$form_data = array(
									'user_name' => set_value('user_name'),
									'email' => $this->input->post('email'),
									'password' => base64_encode($this->input->post('password')),
									'user_role' => $this->input->post('user_role'),
									'created_date' => $cdate,
									'isActive' => '1'
									
								);
								
					// run insert model to write data to db
				
					if ($this->adminuserModel->setAdminuserData($form_data) == TRUE) // the information has therefore been successfully saved in the db
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
			$this->form_validation->set_rules('user_name', 'user_name', 'required');
			//$this->form_validation->set_rules('password', 'password', 'required|min_length[6]');
			$this->form_validation->set_rules('email', 'email', 'required|valid_email');
			$this->form_validation->set_error_delimiters('<br /><em class="error">', '</em>');
			
			//if the form has passed through the validation
			if ($this->form_validation->run())
			{
				
				$is_nameExist = $this->adminuserModel->GetDuplicateName($this->input->post('user_name'),$id); // return 1 or blank
				$is_emailExist = $this->adminuserModel->GetDuplicateEmail($this->input->post('email'),$id); // return 1 or blank
				//echo $is_nameExist;
				//exit;
				if($is_nameExist)
				{
					/*$this->session->set_flashdata('flash_message', 'Name'.EXIST);
					$this->session->set_flashdata('flash_type', 'error');
						
					redirect('admin/adminuser/update/'.$id);   // or whatever logic needs to occur*/
					$msg= 'User name '.EXIST;
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
									'user_name' => set_value('user_name'),
									'email' => $this->input->post('email'),
									'password' => base64_encode($this->input->post('password')),
									'user_role' => $this->input->post('user_role'),
									'isActive' => '1'
								);
					// End Slider Image upload
					//if the insert has returned true then we show the flash message
					if($this->adminuserModel->setUpdatedAdminuserData($id, $form_data) == TRUE)
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
		$this->adminuserModel->setUpdatedAdminuserData($this->input->post('id'), $data_to_store);
		
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
			$data['export'] = $this->adminuserModel->getAllAdminuser();   
			$this->load->view('admin/adminuser/admin_excel', $data);        
	}
}
?>