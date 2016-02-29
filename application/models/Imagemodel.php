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
		$this->db->select('*');
		$this->db->select('g.*, s.name as state_name, count(image_spam_id) as spam_count,u.first_name,u.last_name');
		$this->db->from('image as g');
		$this->db->join('states as s','s.state_id = g.state','LEFT');
		$this->db->join('image_spam as gs','gs.image_id = g.image_id','LEFT');
		$this->db->join('users as u','u.user_id = g.user_id','LEFT');
		
		//echo $search_string;
		
		if($search_string) /// For Maintaining Search
		{
			$like   = "( g.image_name like '%".$search_string."%' )";  
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
		$this->db->select('g.*, s.name as state_name, count(image_spam_id) as spam_count,u.first_name,u.last_name,u.profile_pic,u.social_profile_pic,u.email');
		$this->db->from('image as g');
		$this->db->join('states as s','s.state_id = g.state','LEFT');
		$this->db->join('image_spam as gs','gs.image_id = g.image_id','LEFT');
		$this->db->join('users as u','u.user_id = g.user_id','LEFT');
				
		if($search_string)  /// For Maintaining Search
		{
			$like   = "( image_name like '%".$search_string."%' )";
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
		if($imageCount > 0)
		{			
			$images = $query->result_array();
			
			for($i=0;$i<$imageCount;$i++)
			{
				$imagedata[$i] = $images[$i];
								
				// get overall ratings
				$this->db->select('count(ratings) as totalratings, count(*) as totalreviews');
				$this->db->from('image_reviews');
				$this->db->where('image_id', $images[$i]['image_id']);
				$this->db->where('isActive', '1');
				$queryR = $this->db->get();			
				//echo $this->db->last_query();
				$imagereviews = $queryR->result_array();
				//echo '<pre>'; print_r($imagereviews); exit;
				
				// overall ratings	
				if(count($imagereviews))
				{
					$totalratings = ($imagereviews[0]['totalratings']/2);
					$reviewCount = $imagereviews[0]['totalreviews'];
				
					$overallRatings = ($totalratings > 0 && $reviewCount > 0) ? (float)($totalratings/$reviewCount) : 0;
				}
				else
				{
					$overallRatings = 0;
				}
				$imagedata[$i]['overall_ratings'] = $overallRatings;
			}
		}
		return $imagedata; 	
	}
					
	// Get overall ratings for the image 
	function getImageOverallRatings($image_id)
	{
		$imagedata = array();
		$imagereviews = array();			
				
		$this->db->select('u.user_name,u.profile_pic,gr.review_id,gr.user_id,gr.reviews,gr.review_image,gr.ratings,gr.created_date,gr.image_id');
		$this->db->from('image_reviews AS gr');
		$this->db->join('image as g','g.image_id = gr.image_id','LEFT');
		$this->db->join('users AS u','u.user_id = gr.user_id','LEFT');
		$this->db->where('g.image_id', $image_id);
		$this->db->where('g.isActive', '1');
		$this->db->where('gr.isActive', '1');
		$this->db->where('u.isActive', '1');
		$queryR = $this->db->get();
		//echo $this->db->last_query(); exit;
		$reviewCount = $queryR->num_rows();
		if($reviewCount > 0)
		{			
			$imagereviews = $queryR->result_array();
			$totalratings = 0;
			for($j=0;$j<count($imagereviews);$j++)
			{							
				$imagereviews[$j]['review_image'] = ($imagereviews[$j]['review_image']!='') ? $this->config->item('base_url').'/assets/uploads/reviewpictures/'.$imagereviews[$j]['review_image'] : '';
				$totalratings = $totalratings + $imagereviews[$j]['ratings'];
			}
			$imagedata['reviews'] = $imagereviews;
			
			
			// overall ratings				
			$overallRatings = (float)($totalratings/$reviewCount);
			$imagedata['overall_ratings'] = $overallRatings;
		}
		return $imagedata;
	}
	
	// Get count image reviews
	function countImageReview($image_id,$srchisActive=null,$search_string=null, $order, $order_type, $startdate, $enddate)
	{
		$this->db->select('*');
		$this->db->from('image_reviews');
		
		//echo $search_string;
		
		if($search_string) /// For Maintaining Search
		{
			$like   = "( reviews like '%".$search_string."%' )";  
			$this->db->where($like);
		}
		
		if($startdate)
		{
			$this->db->where('DATE_FORMAT(created_date,"%Y-%m-%d") >=', $startdate);
		}
		
		if($enddate)
		{
			$this->db->where('DATE_FORMAT(created_date,"%Y-%m-%d") <=', $enddate);
		}
		
		if($srchisActive!='') $this->db->where('isActive', $srchisActive);  /// For Active or Inactive
		$this->db->where('image_id', $image_id);
		$this->db->group_by('review_id');
		$this->db->order_by($order, $order_type);  /// For Maintain Sorting Order
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->num_rows();      
	}
	
	// Get all image reviews data from db
	function getImageReview($image_id,$srchisActive=null,$search_string=null, $order, $order_type, $limit_start=null, $limit_end=null, $startdate, $enddate)
	{
		$imagereviews = array();
		$this->db->select('gr.*,u.first_name,u.last_name,u.profile_pic,GROUP_CONCAT(a.amenity) as amenities');
		$this->db->from('image_reviews as gr');
		$this->db->join('users as u','u.user_id = gr.user_id','LEFT');		
		$this->db->join('image_amenities as ga','FIND_IN_SET(ga.amenity_id, gr.amenities_id)','LEFT');		
		$this->db->join('amenities as a','a.amenity_id = ga.amenity_id','LEFT');
				
		if($search_string)  /// For Maintaining Search
		{
			$like   = "( gr.reviews like '%".$search_string."%' )";
			$this->db->where($like);
			//$this->db->like('name', $search_string);
			//$this->db->or_like('email', $search_string);
		}
		
		if($startdate)
		{
			$this->db->where('DATE_FORMAT(gr.created_date,"%Y-%m-%d") >=', $startdate);
		}
		
		if($enddate)
		{
			$this->db->where('DATE_FORMAT(gr.created_date,"%Y-%m-%d") <=', $enddate);
		}
		
		if($srchisActive!='') $this->db->where('gr.isActive', $srchisActive);  /// For Active or Inactive		
		//$this->db->where_in('gr.amenities_id','ga.amenity_id');
		$this->db->where('gr.image_id', $image_id);
		$this->db->group_by('review_id');		
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
		$imagereviews = $query->result_array();
		
		return $imagereviews; 	
	}
		
	// Get all image reviews data from db
	function getAllImageReviews($image_id)
	{
		$imagereviews = array();
		$this->db->select('gr.*,u.first_name,u.last_name,u.profile_pic,GROUP_CONCAT(a.amenity) as amenities');
		$this->db->from('image_reviews as gr');
		$this->db->join('users as u','u.user_id = gr.user_id','LEFT');		
		$this->db->join('image_amenities as ga','FIND_IN_SET(ga.amenity_id, gr.amenities_id)','LEFT');		
		$this->db->join('amenities as a','a.amenity_id = ga.amenity_id','LEFT');				
		$this->db->where('gr.image_id', $image_id);
		$this->db->group_by('review_id');		
		$this->db->order_by('gr.review_id', 'desc');  /// For Maintain Sorting Order
		$query = $this->db->get();		
		//echo $this->db->last_query(); exit;
		$imagereviews = $query->result_array();
		
		return $imagereviews; 	
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
		$this->db->insert('image', $form_data);
		
		if ($this->db->affected_rows() == '1')
		{
			//return TRUE;
			return $this->db->insert_id();
		}
		
		return FALSE;
	}
	
	function setImageAmenities($form_data)
	{
		$this->db->insert('image_amenities', $form_data);
		
		if ($this->db->affected_rows() == '1')
		{
			//return TRUE;
			return $this->db->insert_id();
		}
		
		return FALSE;
	}
	
	function setImageImages($form_data)
	{
		$this->db->insert('image_images', $form_data);
		
		if ($this->db->affected_rows() == '1')
		{
			//return TRUE;
			return $this->db->insert_id();
		}
		
		return FALSE;
	}
		
	function setImageTimingData($form_data)
	{
		$this->db->insert('image_timings', $form_data);
		
		if ($this->db->affected_rows() == '1')
		{
			//return TRUE;
			return $this->db->insert_id();
		}
		
		return FALSE;
	}
	
	function setImageFeesData($form_data)
	{
		$this->db->insert('image_fees', $form_data);
		//echo $this->db->last_query();		
		if($this->db->affected_rows() == '1')
		{
			//return TRUE;
			return $this->db->insert_id();
		}
		
		return FALSE;
	}
	
	// delete all before adding new in update page - starts
	function deleteAllImageAmenities($image_id)
	{
		$image_id = explode(",",$image_id);
		$this->db->where_in('image_id', $image_id);
		$this->db->delete('image_amenities');
		
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
	
	function deleteAllImageTimingData($image_id)
	{
		$image_id = explode(",",$image_id);
		$this->db->where_in('image_id',$image_id);
		$this->db->delete('image_timings');
		
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
	
	function deleteAllImageFeesData($image_id)
	{
		$image_id = explode(",",$image_id);
		$this->db->where_in('image_id', $image_id);
		$this->db->delete('image_fees');
		
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
	// delete all before adding new in update page - ends
	
	// on image delete also delete its images
	function deleteAllImageImagesData($image_id)
	{
		$image_id = explode(",",$image_id);
		
		// fetch image names and unlink them
		
		
		$this->db->where_in('image_id', $image_id);
		$this->db->delete('image_images');
		
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
	
	/**
    * Update Authors
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function setUpdatedImageData($id, $data)
    {
		$this->db->where('image_id', $id);
		$this->db->update('image', $data);
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
		$this->db->update('image', $data);
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
		$this->db->delete('image');
		
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
	
	function deleteImageTiming($id)
	{
		$this->db->where_in('timing_id',$id);
		$this->db->delete('image_timings');
		
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
	
	function deleteImageFees($id)
	{
		$this->db->where_in('fees_id',$id);
		$this->db->delete('image_fees');
		
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
		
	function deleteimagereviewByimageId($id)
	{
		$id = explode(",",$id);
		$this->db->where_in('image_id',$id);
		$this->db->delete('image_reviews');
		
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
		
	function deleteimagereviewData($id)
	{
		$id = explode(",",$id);
		$this->db->where_in('review_id',$id);
		$this->db->delete('image_reviews');
		
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
	  $this->db->update('image',$data);
	  
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
		$this->db->from('image');
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
		$this->db->from('users as u');
		$this->db->join('image as g','g.user_id = u.user_id','LEFT');
		$this->db->where('g.image_id', $image_id);
		$query = $this->db->get();		
		return $query->result_array();
	}
		
	//// Delete Image
	function deleteimageimage($path,$imagename,$imageid)  
	{				
		if($imagename && $imageid){
			unlink($path.'/'.$imagename);
			unlink($path.'/resized/'.$imagename);			
			
			$this->db->where('image_id', $imageid);
			$this->db->delete('image_images');
			//echo $this->db->last_query();exit;
		}	
	}
	
	function getAllImage()
	{
		$imagedata = array();
		$this->db->select('g.*, s.name as state_name');
		$this->db->from('image as g');
		$this->db->join('states as s','s.state_id = g.state','LEFT');       
		$this->db->order_by('g.image_id', 'desc'); 
		$query = $this->db->get();		
		//echo $this->db->last_query(); exit;
		$imageCount = $query->num_rows();
		if($imageCount > 0)
		{			
			$images = $query->result_array();
			
			for($i=0;$i<$imageCount;$i++)
			{
				$imagedata[$i] = $images[$i];
				
				// get overall ratings
				$this->db->select('count(ratings) as totalratings, count(*) as totalreviews');
				$this->db->from('image_reviews');
				$this->db->where('image_id', $images[$i]['image_id']);
				$this->db->where('isActive', '1');
				$queryR = $this->db->get();			
				//echo $this->db->last_query();
				$imagereviews = $queryR->result_array();
				//echo '<pre>'; print_r($imagereviews); exit;
				
				// overall ratings	
				$totalratings = $imagereviews[0]['totalratings'];
				$reviewCount = $imagereviews[0]['totalreviews'];
				
				$overallRatings = ($totalratings > 0 && $reviewCount > 0) ? (float)($totalratings/$reviewCount) : 0;
				$imagedata[$i]['overall_ratings'] = $overallRatings;
			}
		}
		return $imagedata; 	
	}
}
?>