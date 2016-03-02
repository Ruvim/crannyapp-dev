<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AdminUserModel extends CI_Model 
{	
	function __construct()
	{
		parent::__construct();
	}
	function encodeStr($str)
	{
		return htmlentities($str);
	}
	
	function decodeStr($str)
	{
		return strip_tags(html_entity_decode($str));
	}
	
	/**
    * Validate the login's data with the database
    * @param string $user_name
    * @param string $password
    * @return void
    */
	function validate($username, $password)
	{
		$this->db->select('*');
		//$this->db->where('(email="'.$username.'" OR user_name="'.$username.'")', NULL);
		$this->db->where('email', $username);
		$this->db->or_where('user_name', $username);
        $this->db->where('password', $password);
		$query = $this->db->get('adminusers');		
		//echo $sql = $this->db->last_query();		
		// echo '<pre>'; print_r($sql); exit;		
		if($query->num_rows() == 1)
		{
			//return true;
			return $query->result_array(); 
		}	
		else
		{
			return false;
		}
	}		
	
    /**
    * Serialize the session data stored in the database, 
    * store it in a new array and return it to the controller 
    * @return array
    */
	function get_db_session_data()
	{
		$query = $this->db->select('username')->get('ci_sessions');
		$user = array(); /* array to store the user data we fetch */
		foreach ($query->result() as $row)
		{
		    $udata = unserialize($row->user_data);
		    /* put data in array using username as key */
		    $user['username'] = $udata['username']; 
		    $user['is_logged_in'] = $udata['is_logged_in']; 
		}
		return $user;
	}
		
    /**
    * Validate the login's data with the database
    * @param string $user_name
    * @return void
    */
	function forgot_validate($username)
	{		
		$this->db->where('(email="'.$username.'" OR user_name="'.$username.'")', NULL);
	    $query = $this->db->get('adminusers');
		
		/*echo $this->db->last_query();
		exit;*/
		if($query->num_rows() == 1)
		{
			return true;
		}	
		else
			return false;
	}
	
  /**
    * Update username password data with the database
    * @param string $user_name
	* @param string $password
    * @return void
    */
	function update_validate($username,$pass)
	{
		
		$this->db->select('email');
		$this->db->from('adminusers');
		$this->db->where('email', $username);
		$adminuserquery = $this->db->get();
		
		if($adminuserquery->num_rows()>0)
		{
			$this->db->where('email',$username);
			$this->db->set('password', $pass);
			$this->db->update('adminusers');
		}
		
	   $report = array();
	   $report['error'] = $this->db->error();
	   //$report['message'] = $this->db->_error_message();
	   if($report !== 0)
	   {
			return true;
	   }
	   else
	   {
			return false;
	   }
	}
	
	// Get all data of admin
	function get_all()
	{
		$this->db->select('*');
		$this->db->from('adminusers');
		$this->db->where('isActive', '1');
		$query = $this->db->get();
		
		return $query->result_array(); 
	}
	
	function validCurrpassword($password)
	{
	 // echo $email_id;
		$this->db->where('password',$password);
		$this->db->where('adminuser_id',$this->session->userdata('user_id'));
	    $query = $this->db->get('adminusers');
		
		//echo $this->db->last_query();
		if($query->num_rows() == 1)
		{
			return true;
		}	
	}
	function update_password($pass)
	{
	   $this->db->where('adminuser_id',$this->session->userdata('user_id'));
	   $this->db->set('password', $pass);
	   $this->db->update('adminusers');
	   $report = array();
	   $report['error'] = $this->db->error();
	   //$report['message'] = $this->db->_error_message();
	   if($report !== 0)
	   {
			return true;
	   }
	   else
	   {
			return false;
	   }
	}
	
	function profileupdate($name,$email)
	{
		$this->db->where('adminuser_id',$this->session->userdata('user_id'));
		$this->db->set('user_name', $name);
		$this->db->set('email', $email);
		
		$this->db->update('adminusers');
	   $report = array();
	   $report['error'] = $this->db->error();
	  // $report['message'] = $this->db->show_error();
	   if($report !== 0)
	   {
			return true;
	   }
	   else
	   {
			return false;
	   }
	}
	
//////////////////////////////////////////////  ///////////////////////////////////////////////////
	
	// Get count of adminuser
	//function countAdminuser($srchisActive=null,$search_string=null, $order, $order_type)
	function countAdminuser($search_string=null)
	{
		$this->db->select('*');
		$this->db->from('adminusers');
		
		//echo $search_string;
		
		if($search_string) /// For Maintaining Search
		{
			//$this->db->like('name', $search_string);
			//$this->db->or_like('email', $search_string);
			$like   = "( user_name like '%".$search_string."%' OR email like '%".$search_string."%' )";  
			$this->db->where($like);
		}
		$this->db->where('isActive', $srchisActive);  /// For Active or Inactive
		$this->db->group_by('adminuser_id');
		$this->db->order_by($order, $order_type);  /// For Maintain Sorting Order
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->num_rows();      
	}
	
	// Get all authors data from db
	//function getAdminuser($srchisActive=null,$search_string=null, $order, $order_type, $limit_start=null, $limit_end=null)
	function getAdminuser($search_string=null, $limit_start=null, $limit_end=null)
	{
		$this->db->select('*');
		$this->db->from('adminusers');
				
		if($search_string)  /// For Maintaining Search
		{
		
			$like   = "( user_name like '%".$search_string."' OR email like '%".$search_string."%' )";
			$this->db->where($like);
			//$this->db->like('name', $search_string);
			//$this->db->or_like('email', $search_string);
		}
		
		if($srchisActive!='') $this->db->where('isActive', $srchisActive);  /// For Active or Inactive
		$this->db->group_by('adminuser_id');
		
		$this->db->order_by($order, $order_type);  /// For Maintain Sorting Order
        
		if($limit_start && $limit_end)
		{
          $this->db->limit($limit_start, $limit_end);	
        }

        if($limit_start != null)
		{
          $this->db->limit($limit_start, $limit_end);    
        }
        
		$query = $this->db->get();
		
		//echo $this->db->last_query();
		
		//exit;
		return $query->result_array(); 	
	}
	
	
	// Get Active Adminuser only
	function getActiveAdminuser()
	{
		$this->db->select('*');
		$this->db->from('adminusers');
		$this->db->where('isActive', '1');
		$query = $this->db->get();
		
		return $query->result_array(); 
	}
	/**
    * Get authors by his is
    * @param int $id 
    * @return array
    */
    public function get_adminuser_by_id($id)
    {   
	    $this->db->select('*');
		$this->db->from('adminusers');
		$this->db->where('adminuser_id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    }   
	
	/** 
	* function setAuthorsData()
	*
	* insert form data
	* @param $form_data - array
	* @return Bool - TRUE or FALSE
	*/

	function setAdminuserData($form_data)
	{
		$this->db->insert('adminusers', $form_data);
		
		if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	/**
    * Update Authors
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function setUpdatedAdminuserData($id, $data)
    {
		$this->db->where('adminuser_id', $id);
		$this->db->update('adminusers', $data);
		$report = array();
		$report['error'] = $this->db->error();
		//$report['message'] = $this->db->error_message();
		if($report !== 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function deleteAdminuserData($id)
	{
		//delete image from folder start 
		$id = explode(",",$id);
		
		$this->db->where_in('adminuser_id',$id);
		$this->db->delete('adminusers');
	  	
		$report = array();
	    $report['error'] = $this->db->error();
		if($report !== 0)
	    {
			return true;
	    }
	    else
	    {
			return false;
	    }
		exit;
	}
	
   /* Change status 
	* @param int $id - chapter id,varchar $status - status 
	*/
    function updateStatus($id,$status)
    {  
	  $status_state = ($status == '1') ? '0' : '1';
	  $data = array('isActive' => $status_state);
	  $this->db->where('adminuser_id',$id);
	  $this->db->update('adminusers',$data);
	  
	  $report = array();
	  $report['error'] = $this->db->error();
	  //$report['message'] = $this->db->_error_message();
	  
	  if($report !== 0)
	  {
			return true;
	  }
	  else
	  {
			return false;
	  }
	}
   
   /* Send details in email
    * @param int $id - authors id
	*/
	function send_details($id)
    {  
	   $this->db->select('*');
	   $this->db->from('adminusers');
	   $this->db->where('adminuser_id', $id);	 
	   $this->db->where('isActive', '1');
	   
	   $query = $this->db->get();
		
	   return $query->result_array();
    }
   
    // Get all pagesize of authors 
	function get_pagesize($module)
	{
		$this->db->select('pagesize');
		$this->db->from('pagesize');
        $this->db->where('module', $module);
 
		$query = $this->db->get();
		
		$result = $query->result_array();
		return $result[0]['pagesize']; 	
	}
	
	function findDuplicateEmail($email)
	{
	//	echo $email_id." ".$password; exit;
		/*$this->db->where('email', $email);
		$query = $this->db->get('adminusers');*/
		
		//$sql = $this->db->last_query();
		//echo '<pre>'; print_r($sql); 
		
		$query = $this->db->query('SELECT AU.email FROM adminusers AS AU WHERE  AU.email="'.$email.'"');
		
		if($query->num_rows() > 0)
		{
			return true;
		}	
	}
	
	function findDuplicateName($name)
	{
	//	echo $email_id." ".$password; exit;
		$this->db->where('user_name', $name);
		$query = $this->db->get('adminusers');
		
		//$sql = $this->db->last_query();
		//echo '<pre>'; print_r($sql); 
		if($query->num_rows() > 0)
		{
			return true;
		}	
	}
	//// Delete Admin user Image
	function deleteadminuserimage($path,$id,$data)  
	{
		$result = $this->adminuserModel->get_adminuser_by_id($id);
		$imagename = $result[0]['profile_pic'];
		
		$this->db->where('id', $id);
		$this->db->update('adminusers',$data);
		
		if($imagename){
			unlink($path.'/'.$imagename);
			unlink($path.'/40x40/'.$imagename);
		}
	
	}
	/** For Update Validation For username is exist or not **/
	function GetDuplicateName($name,$id)
	{
		$this->db->where('user_name', $name);
		$this->db->where('adminuser_id !=', $id);
		$query = $this->db->get('adminusers');
		
		if($query->num_rows() > 0)
		{
			return true;
		}	
	}
	/** For Update Validation For email is exist or not **/
	function GetDuplicateEmail($email,$id)
	{
		/*$this->db->where('email', $email);
		$this->db->where('id !=', $id);
		$query = $this->db->get('adminusers');*/
		
		$query = $this->db->query('SELECT AU.email FROM adminusers AS AU WHERE  AU.email="'.$email.'" AND AU.adminuser_id !="'.$id.'"');
		
		if($query->num_rows() > 0)
		{
			return true;
		}	
	}
	
	// Get Active Adminuser only
	function getAllAdminuser()
	{
		$this->db->select('*');
		$this->db->from('adminusers');
		$query = $this->db->get();
		
		return $query->result_array(); 
	}	
}
?>
