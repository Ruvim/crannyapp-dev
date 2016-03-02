<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Image extends CI_Controller {

    public function __construct()
    {
		parent::__construct();
		$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');		
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');		
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);  		
		$this->output->set_header('Pragma: no-cache');
		$this->load->database();
		
		$this->load->helper('file');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('string');
		$this->load->library('email');
		$this->load->library('parser');
		$this->load->library('session');
		$this->load->library('upload');
		$this->load->library('custom');
		
		$this->load->model('Imagemodel');
		
		if(!$this->session->userdata('is_logged_in'))
	    {
		   redirect('admin/login');
		}
  	}
		
    /**
    * Check if the user is logged in, if he's not, 
    * send him to the login page
    * @return void
    */	
	function index()
	{
		$search_string = $this->input->post('search_string');
		////// Get Ascending Or Descending order From Ajax /////////
		$order = $this->input->post('fieldName');//$this->input->post('orderType'); 
		$order_type = $this->input->post('orderType');//$this->input->post('orderType');  
		///////// For Check Publish Data or Not with Ajax /////
		$srchisActive = $this->input->post('srchisActive');
			
		$startdate = ($this->input->post('startdate')!='') ? date("Y-m-d",strtotime($this->input->post('startdate'))) : '';
		$enddate = ($this->input->post('enddate')!='') ? date("Y-m-d",strtotime($this->input->post('enddate'))) : '';
		
		$order = ($order!='') ? $order : 'g.image_id';
		$order_type = ($order_type!='') ? $order_type : 'desc';
		$search_string = ($search_string!='') ? $search_string : '';
		$srchisActive = ($srchisActive!='') ? $srchisActive : '';
		
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
			$limit = $this->Imagemodel->get_pagesize('image'); // new added by chirag
		}
		$limit = ($limit!=0) ? $limit : ''; // new added by Rutvi
	
		$config['per_page'] = $limit; // default 20
		$config['pagesize'] = $limit; // new added by Rutvi
		$config['use_page_numbers'] = TRUE;
		$config['num_links'] = 2;		
		$config['base_url'] = $this->config->item('admin_url').'/image';
	
		// limit end
		$page = $this->uri->segment(3);
		
		// math to get the initial record to be select in the database
		$limit_end = ($page * $config['per_page']) - $config['per_page'];
		if ($limit_end < 0)
		{
			$limit_end = 0;
		} 
		
		$data['count_image']= $this->Imagemodel->countImage($srchisActive,$search_string, $order, $order_type, $startdate, $enddate);
		$config['total_rows'] = $data['count_image'];
		
		$data['image'] = $this->Imagemodel->getImage($srchisActive,$search_string, $order, $order_type, $config['per_page'], $limit_end, $startdate, $enddate);        
		$this->pagination->initialize($config); //// For Pagination		
		//echo '<pre>';print_r($data['image']); exit;
		$data['mainContent'] = 'admin/image/imageList';		
		$this->load->view('admin/includes/template', $data);

	}  //// End Of Index Function

	private function set_upload_options($imagename)
	{   
		//upload an image options
		$config = array();
		$config['upload_path'] = $this->config->item('base_path').'assets/uploads/pictures';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|tif|tiff|jpe';
		$config['max_size'] = 0;
		$config['max_width'] = 0;
		$config['max_height'] = 0;
		$config['max_filename'] = 0;
		$config['overwrite'] = true;
		$config['file_name'] = $imagename;
	
		return $config;
	}
	
	/*************************************************************** ADD Data *******************************************************/

	function add()
    {	
		//if save button was clicked, get the data sent via post
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{
			$this->form_validation->set_rules('image_title', 'image_title', 'required');
			$this->form_validation->set_error_delimiters('<br /><em class="error">', '</em>');
			
			if ($this->form_validation->run() == FALSE) // validation hasn't been passed
			{			
				//$data['mainContent'] = 'admin/image/authorAdd';		
				//$this->load->view('admin/includes/template', $data);
			}			
			else // passed validation proceed to post success logic
			{	
				$cdate = date("Y-m-d");
																	
				// Save images
				if(!empty($_FILES))
				{
					$name_array = array();
					$count = count($_FILES['imagefiles']['size']);
					foreach($_FILES as $key=>$value)
					{							
						for($s=0;$s<$count;$s++) 
						{
							/*$image_info = getimagesize($value['tmp_name'][$s]);
							$image_width = $image_info[0];
							$image_height = $image_info[1];
							
							if($image_width < $this->config->item('imageimage_width') && $image_height < $this->config->item('imageimage_height'))
							{
								$msg = 'Please follow the recommended mimimum size.';
								$msgtype = 'error';
							}
							else
							{*/								
								$imagename = time().'_'.$value['name'][$s];
								
								$_FILES['imagefiles']['name'] = $imagename;
								$_FILES['imagefiles']['type'] = $value['type'][$s];
								$_FILES['imagefiles']['tmp_name'] = $value['tmp_name'][$s];
								$_FILES['imagefiles']['error'] = $value['error'][$s];
								$_FILES['imagefiles']['size'] = $value['size'][$s];  
								
								$config = $this->set_upload_options($imagename);
								$this->upload->initialize($config);
								$this->load->library('upload', $config);
								
								if($this->upload->do_upload('imagefiles')==FALSE)
								{
									//$error['upload_error'] = $this->upload->display_errors();
									$msg = $this->upload->display_errors();
									$msgtype = 'error';
								}
								else
								{
									$data1['imagefiles'] = $this->upload->data();
									//echo '<br>here1<pre>';	print_r($data1['imagefiles']);		
									// ** Start image resize **
									$config1 = array();
									$config1['image_library'] = 'gd2';
									$config1['source_image'] = $data1['imagefiles']['full_path'];
									$config1['allowed_types'] = 'gif|jpg|png|jpeg|bmp|tif|tiff|jpe';
									$config1['create_thumb'] = TRUE;
									$config1['maintain_ratio'] = FALSE;
									$config1['thumb_marker'] = '';
									$config1['width'] = 100;
									$config1['height'] = 100;
									$config1['new_image'] = $config['upload_path'].'/resized';
									$this->load->library('image_lib');
									$this->image_lib->initialize($config1);
									$this->image_lib->resize();
									// ** End image resize **
									
									// save to db
									// build array for the model
									$form_data = array('imagename' => $imagename,
														'image_title' => set_value('image_title'),
														'added_by' => $this->session->userdata('user_id'),
														'isActive' => '1',
														'created_date' => $cdate								
													);
														
									// run insert model to write data to db		
									$image_id = $this->Imagemodel->setImageData($form_data);
								}
							//}
						}
					}				
				}
			
				$this->session->set_flashdata('flash_message', 'Image'.ADDMSG);
				$this->session->set_flashdata('flash_type', 'success');
				redirect('admin/image');   // on list page				
			}
		}
			
		$data['mainContent'] = 'admin/image/imageAdd';		
		$this->load->view('admin/includes/template', $data);
	}  /// End Of ADD Function
	
/************************************************************ Update item by his id  * @return void ************************/
    public function update()
    {
		$image_id = $this->uri->segment(4);
		
		$data['image'] = $this->Imagemodel->get_image_by_id($image_id);
		
		//if save button was clicked, get the data sent via post
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{
			//form validation
			$this->form_validation->set_rules('image_title', 'image_title', 'required');
			$this->form_validation->set_error_delimiters('<br /><em class="error">', '</em>');
			
			//if the form has passed through the validation
			if ($this->form_validation->run())
			{		
				$imagename = '';
				// Save images
				if(!empty($_FILES))
				{
					$name_array = array();
					$count = count($_FILES['imagefiles']['size']);
					foreach($_FILES as $key=>$value)
					{							
						for($s=0;$s<$count;$s++) 
						{
							/*$image_info = getimagesize($value['tmp_name'][$s]);
							$image_width = $image_info[0];
							$image_height = $image_info[1];
							
							if($image_width < $this->config->item('imageimage_width') && $image_height < $this->config->item('imageimage_height'))
							{
								$msg = 'Please follow the recommended mimimum size.';
								$msgtype = 'error';
							}
							else
							{*/							
								if($value['name'][$s]!='') $imagename = time().'_'.$value['name'][$s];
								
								$_FILES['imagefiles']['name'] = $imagename;
								$_FILES['imagefiles']['type'] = $value['type'][$s];
								$_FILES['imagefiles']['tmp_name'] = $value['tmp_name'][$s];
								$_FILES['imagefiles']['error'] = $value['error'][$s];
								$_FILES['imagefiles']['size'] = $value['size'][$s];  
								
								$config = $this->set_upload_options($imagename);
								$this->upload->initialize($config);
								$this->load->library('upload', $config);
								
								if($this->upload->do_upload('imagefiles')==FALSE)
								{
									//$error['upload_error'] = $this->upload->display_errors();
									$msg = $this->upload->display_errors();
									$msgtype = 'error';
								}
								else
								{
									$data1['imagefiles'] = $this->upload->data();
									//echo '<br>here1<pre>';	print_r($data1['imagefiles']);		
									// ** Start image resize **
									$config1 = array();
									$config1['image_library'] = 'gd2';
									$config1['source_image'] = $data1['imagefiles']['full_path'];
									$config1['allowed_types'] = 'gif|jpg|png|jpeg|bmp|tif|tiff|jpe';
									$config1['create_thumb'] = TRUE;
									$config1['maintain_ratio'] = FALSE;
									$config1['thumb_marker'] = '';
									$config1['width'] = 100;
									$config1['height'] = 100;
									$config1['new_image'] = $config['upload_path'].'/resized';
									$this->load->library('image_lib');
									$this->image_lib->initialize($config1);
									$this->image_lib->resize();
									// ** End image resize **
								}
							//}
						}
					}					
				}
				// save to db
				if($imagename!='')
				{
					$image_idata = array('imagename' => $imagename,
							'image_title' => set_value('image_title'),
							'added_by' => $this->session->userdata('user_id'));
				}
				else
				{
					$image_idata = array('image_title' => set_value('image_title'),
							'added_by' => $this->session->userdata('user_id'));
				}
				$image_imageid = $this->Imagemodel->setUpdatedImageData($image_id, $image_idata);
												
				$this->session->set_flashdata('flash_message', 'Image'.UPDATEMSG);
				$this->session->set_flashdata('flash_type', 'success');
				redirect('admin/image');
			
			}//validation run			
		}
		
		// load the view
		$data['mainContent'] = 'admin/image/imageEdit';		
		$this->load->view('admin/includes/template', $data);         

    } // End Of Update Function

    /**
    * Delete author by his id
    * @return void
    */
    public function delete()
    {
				
		$id = $this->input->post('id');
		if($this->Imagemodel->deleteimageData($id) == true)
		{
			/*  $this->session->set_flashdata('flash_message', 'delete');
		 	 $this->session->set_flashdata('flash_type', 'success');*/
		}
		else
		{
			/*	$this->session->set_flashdata('flash_message', 'error');
			$this->session->set_flashdata('flash_type', 'error');*/
		}
		
		echo "Image";
		//  redirect('admin/authors');
    } // End Of Delete Function
		
	public function deletereview()
    {				
		$id = $this->input->post('id');
		if($this->Imagemodel->deleteimagereviewData($id) == true)
		{
			/*  $this->session->set_flashdata('flash_message', 'delete');
		 	 $this->session->set_flashdata('flash_type', 'success');*/
		}
		else
		{
			/*	$this->session->set_flashdata('flash_message', 'error');
			$this->session->set_flashdata('flash_type', 'error');*/
		}
		
		echo "Image Reviews";
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
			// $this->Imagemodel->deleteauthorData($id);
			if($this->Imagemodel->deleteimageData($id) == true)
			{	
				/*$this->session->set_flashdata('flash_message', 'Image'.DELETEMSG);
				$this->session->set_flashdata('flash_type', 'success');*/
			}
			else
			{
				/*$this->session->set_flashdata('flash_message', 'error');
				$this->session->set_flashdata('flash_type', 'error');*/
			}
			//redirect('admin/image');
			echo "Image";
			
		}
	} // End of Selected Delete 
		
	public function deleteSelectedreview()
    {
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{
			// authors id array			
			$id = $this->input->post('itemId');
			// $this->Imagemodel->deleteauthorData($id);
			if($this->Imagemodel->deleteimagereviewData($id) == true)
			{
				/*$this->session->set_flashdata('flash_message', 'Image'.DELETEMSG);
				$this->session->set_flashdata('flash_type', 'success');*/
			}
			else
			{
				/*$this->session->set_flashdata('flash_message', 'error');
				$this->session->set_flashdata('flash_type', 'error');*/
			}
			//redirect('admin/image');
			echo "Image Reviews";
			
		}
	} // End of Selected Delete 
	
	/* Change status */
	public function changestatus()
    {
		$data['image'] = $this->Imagemodel->get_image_by_id($this->input->post('id'));
		$status = ($data['image'][0]['isActive']=='1') ? '0' : '1';
		
		$data_to_store = array(
			'isActive' => $status,
		);
		$this->Imagemodel->setUpdatedImageData($this->input->post('id'), $data_to_store);
		echo $status;
		
    } // End of update status
	
	// change status for selected	
	public function changeallstatus()
    {
		$id = $this->input->post('itemId');
		$status = $this->input->post('status');
		
		$data_to_store = array(
			'isActive' => $status,
		);
		$this->Imagemodel->setUpdateStatus($id, $data_to_store);
		echo "Image";		
    }
	
///////////// Chnage Page Size For Paginarion //////////	
	function chagepagesize()
    {  
	  $limit = $this->input->post('limit'); 
	  $data = array('pagesize' => $limit);
	  $this->db->where('module','image');
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
	/* delete image pic. */
	public function deleteimage()
    {
		$path = $this->config->item('base_path').'assets/uploads/imagepictures';
		$imageid = $this->input->post('imageid');
		$imagename = $this->input->post('imagename');
		$this->Imagemodel->deleteimageimage($path,$imagename,$imageid);
    }
}

?>