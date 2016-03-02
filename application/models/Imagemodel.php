<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Imagemodel extends CI_Model {
	
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
	
	// Get count image
	function countImage($srchisActive=null,$search_string=null, $order, $order_type, $startdate, $enddate)
	{		
		$this->db->select('g.*, u.user_name');
		$this->db->from('images as g');
		$this->db->join('adminusers as u','u.adminuser_id = g.added_by','LEFT');
		//echo $search_string;
		
		if($search_string) /// For Maintaining Search
		{
			$like   = "( g.image_title like '%".$search_string."%' )";  
			$this->db->where($like);
		}
		
		if($startdate)
		{
			$this->db->where('g.created_date >=', $startdate);
		}
		
		if($enddate)
		{
			$this->db->where('g.created_date <=', $enddate);
		}
				
		if($srchisActive!='') $this->db->where('g.isActive', $srchisActive);  /// For Active or Inactive
		$this->db->group_by('g.image_id');
		$this->db->order_by($order, $order_type);  /// For Maintain Sorting Order
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->num_rows();      
	}
	
	// Get all images data from db
	function getImage($srchisActive=null,$search_string=null, $order, $order_type, $limit_start=null, $limit_end=null, $startdate, $enddate)
	{
		$imagedata = array();
		$this->db->select('g.*, u.user_name');
		$this->db->from('images as g');
		$this->db->join('adminusers as u','u.adminuser_id = g.added_by','LEFT');
				
		if($search_string)  /// For Maintaining Search
		{
			$like   = "( image_title like '%".$search_string."%' )";
			$this->db->where($like);
			//$this->db->like('name', $search_string);
			//$this->db->or_like('email', $search_string);
		}
		
		if($startdate)
		{
			$this->db->where('g.created_date >=', $startdate);
		}
		
		if($enddate)
		{
			$this->db->where('g.created_date <=', $enddate);
		}
		
		if($srchisActive!='') $this->db->where('g.isActive', $srchisActive);  /// For Active or Inactive		
		$this->db->group_by('g.image_id');		
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
		//echo $this->db->last_query(); exit;
		$imageCount = $query->num_rows();
		$imagedata = $query->result_array();
		return $imagedata; 	
	}
					
	/** 
	* function setAuthorsData()
	*
	* insert form data
	* @param $form_data - array
	* @return Bool - TRUE or FALSE
	*/

	function setImageData($form_data)
	{
		$this->db->insert('images', $form_data);
		
		if ($this->db->affected_rows() == '1')
		{
			//return TRUE;
			return $this->db->insert_id();
		}
		
		return FALSE;
	}
			
	/**
    * Update Authors
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function setUpdatedImageData($id, $data)
    {
		$this->db->where('image_id', $id);
		$this->db->update('images', $data);
		//echo $this->db->last_query();
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
	
	function setUpdateStatus($id, $data) // for selected records
    {
		$id = explode(",",$id);
		$this->db->where_in('image_id', $id);
		$this->db->update('images', $data);
		//echo $this->db->last_query();
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
	
	function deleteImageData($id)
	{
		$id = explode(",",$id);
		$this->db->where_in('image_id',$id);
		$this->db->delete('images');
		
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
		exit;
	}		
		
    /* Change status 
	* @param int $id - chapter id,varchar $status - status 
	*/
    function updateStatus($id,$status)
    {  
	  $status_state = ($status == '1') ? '0' : '1'; 
	  $data = array('isActive' => $status_state);
	  $this->db->where('image_id',$id);
	  $this->db->update('images',$data);
	  
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
   
	function get_image_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('images');
		$this->db->where('image_id', $id);
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
	
	// Get max Authors ID only
	function getUserInfo($image_id)
	{
		$this->db->select('u.*,g.image_name');
		$this->db->from('adminusers as u');
		$this->db->join('images as g','g.added_by = u.adminuser_id','LEFT');
		$this->db->where('g.image_id', $image_id);
		$query = $this->db->get();		
		return $query->result_array();
	}
		
	//// Delete Image
	/*function deleteimageimage($path,$imagename,$imageid)  
	{				
		if($imagename && $imageid){
			unlink($path.'/'.$imagename);
			unlink($path.'/resized/'.$imagename);			
			
			$this->db->where('image_id', $imageid);
			$this->db->delete('image_images');
			//echo $this->db->last_query();exit;
		}	
	}*/
}
?>