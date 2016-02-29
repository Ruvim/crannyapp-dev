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
	
	// get image reviews
	public function review()
    {
		$image_id = $this->uri->segment(4);
		$search_string = $this->input->post('search_string');
		////// Get Ascending Or Descending order From Ajax /////////
		$order = $this->input->post('fieldName');//$this->input->post('orderType'); 
		$order_type = $this->input->post('orderType');//$this->input->post('orderType');  
		///////// For Check Publish Data or Not with Ajax /////
		$srchisActive = $this->input->post('srchisActive');
		$startdate = ($this->input->post('startdate')!='') ? date("Y-m-d",strtotime($this->input->post('startdate'))) : '';
		$enddate = ($this->input->post('enddate')!='') ? date("Y-m-d",strtotime($this->input->post('enddate'))) : '';	
			
		$order = ($order!='') ? $order : 'image_id';
		$order_type = ($order_type!='') ? $order_type : 'desc';
		$search_string = ($search_string!='') ? $search_string : '';
		$srchisActive = ($srchisActive!='') ? $srchisActive : '';
		
		 // pagination settings
		if($this->uri->segment(7)!='')
		{
			$limit = $this->uri->segment(7);
		}
		elseif($this->uri->segment(6)!='')
		{
			$limit = $this->uri->segment(6);
		}
		else
		{
			$limit = $this->Imagemodel->get_pagesize('imagereview'); // new added by chirag
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
		
		$data['count_review']= $this->Imagemodel->countImageReview($image_id,$srchisActive,$search_string, $order, $order_type, $startdate, $enddate);
		$config['total_rows'] = $data['count_review'];
		
		$data['review'] = $this->Imagemodel->getImageReview($image_id,$srchisActive,$search_string, $order, $order_type, $config['per_page'], $limit_end, $startdate, $enddate);        
		$this->pagination->initialize($config); //// For Pagination		

		$data['imageinfo'] = $this->Imagemodel->get_image_by_id($image_id);
		
		$data['mainContent'] = 'admin/image/imagereviewList';		
		$this->load->view('admin/includes/template', $data);
		
	}	
	
	private function set_upload_options($imagename)
	{   
		//upload an image options
		$config = array();
		$config['upload_path'] = $this->config->item('base_path').'assets/uploads/imagepictures';
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
		$image_id = '';
		$msg = '';
		$msgtype = '';
		//if save button was clicked, get the data sent via post
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{
			$this->form_validation->set_rules('image_name', 'image name', 'required');
			$this->form_validation->set_rules('address1', 'address1', 'required');
			$this->form_validation->set_rules('city', 'city', 'required');
			//$this->form_validation->set_rules('state', 'state', 'required');
			$this->form_validation->set_rules('country', 'country', 'required');
			$this->form_validation->set_rules('zipcode', 'zipcode', 'required');
			$this->form_validation->set_rules('contact_number', 'contact number', 'required');
			$this->form_validation->set_rules('description', 'description', 'required');
			$this->form_validation->set_error_delimiters('<br /><em class="error">', '</em>');
			
			if ($this->form_validation->run() == FALSE) // validation hasn't been passed
			{			
				//$data['mainContent'] = 'admin/image/authorAdd';		
				//$this->load->view('admin/includes/template', $data);
			}			
			else // passed validation proceed to post success logic
			{
				// tab 2 data
				$amenities = ($this->input->post('amenity')!='') ? $this->input->post('amenity') : '';
				
				$isClosed = ($this->input->post('isClosed')!='') ? $this->input->post('isClosed') : '';
				$selectedDays = ($this->input->post('selectedDays')!='') ? $this->input->post('selectedDays') : '';
				
				//$start_time = ($this->input->post('start_time')!='') ? $this->input->post('start_time') : '';
				$start_hour = ($this->input->post('start_hour')!='') ? $this->input->post('start_hour') : '';
				$start_minute = ($this->input->post('start_minute')!='') ? $this->input->post('start_minute') : '';
				$start_meridiem = ($this->input->post('start_meridiem')!='') ? $this->input->post('start_meridiem') : '';				
				
				//$end_time = ($this->input->post('end_time')!='') ? $this->input->post('end_time') : '';
				$end_hour = ($this->input->post('end_hour')!='') ? $this->input->post('end_hour') : '';
				$end_minute = ($this->input->post('end_minute')!='') ? $this->input->post('end_minute') : '';
				$end_meridiem = ($this->input->post('end_meridiem')!='') ? $this->input->post('end_meridiem') : '';
				
				$time_period = ($this->input->post('time_period')!='') ? $this->input->post('time_period') : '';
				$fees = ($this->input->post('fees')!='') ? $this->input->post('fees') : '';
				
				//echo '<pre>'; print_r($_REQUEST); print_r($_FILES); exit;
				
				// Get lat long details
				$image_name = (set_value('image_name')!='') ? set_value('image_name') : '';
				$address1 = (set_value('address1')!='') ? set_value('address1') : '';
				$city = (set_value('city')!='') ? set_value('city') : '';
				
				$state = ($this->input->post('state')!='') ? $this->input->post('state') : '';
				$country = ($this->input->post('country')!='') ? $this->input->post('country') : '';
				$zipcode = (set_value('zipcode')!='') ? set_value('zipcode') : '';
				
				$latitude = '';
				$longitude = '';
				//$fullAddress = $image_name.$address1.$city.$state.$zipcode.$country;
				$fullAddress = $state.$country.$zipcode;
				$s_address = preg_replace('/\s+/', '', $fullAddress);
				$url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$s_address."&sensor=false";
				$details = file_get_contents($url);
				$s_result = json_decode($details,true);
				if(count($s_result['results']))
				{
					$latitude = $s_result['results'][0]['geometry']['location']['lat'];
					$longitude = $s_result['results'][0]['geometry']['location']['lng'];
				}
				
				$cdate = date("Y-m-d");
				// build array for the model
				$form_data = array('image_name' => set_value('image_name'),
									'address1' => set_value('address1'),
									'city' => set_value('city'),
									'state' => $this->input->post('state'),
									'country' => $this->input->post('country'),
									'zipcode' => set_value('zipcode'),
									'contact_number' => set_value('contact_number'),
									'latitude' => $latitude,
									'longitude' => $longitude,
									'description' => set_value('description'),
									'isActive' => $this->input->post('isActive'),
									'isApproved' => $this->input->post('isApproved'),
									'created_date' => $cdate								
								);
									
				// run insert model to write data to db		
				$image_id = $this->Imagemodel->setImageData($form_data);		
				if ($image_id) // the information has therefore been successfully saved in the db
				{
					// Save amenities
					if($amenities)
					{
						for($i=0;$i<count($amenities);$i++)
						{
							$image_adata = array('image_id' => $image_id,
										'amenities' => $amenities[$i],
										'isActive' => '1');
							$image_amenityid = $this->Imagemodel->setImageAmenities($image_adata);								
						}
					}
					
					// Save timings
					if($isClosed!='' && $selectedDays!='')
					{
						for($i=0;$i<count($selectedDays);$i++)
						{
							$startdays = array();
							$enddays = array();
							
							if($selectedDays[$i]!='')
							{
								// check for multiple selected days
								if(strpos($selectedDays[$i],","))
								{
									$selected = explode(",",$selectedDays[$i]);
									
									for($s=0;$s<count($selected);$s++)
									{
										// check for range in selected days
										if(strpos($selected[$s],"-"))
										{
											$selDays = explode("-",$selected[$s]);
											$startdays[$s] = ($selDays!='') ? trim($selDays[0]) : '';
											$enddays[$s] = ($selDays!='') ? trim($selDays[1]) : '';
										}
										else
										{
											$startdays[$s] = ($selected[$s]!='') ? trim($selected[$s]) : '';
											$enddays[$s] = '';
										}
									}
								}
								else
								{
									// check for range in selected days
									if(strpos($selectedDays[$i],"-"))
									{
										$selDays = explode("-",$selectedDays[$i]);
										$startdays[0] = ($selDays!='') ? trim($selDays[0]) : '';
										$enddays[0] = ($selDays!='') ? trim($selDays[1]) : '';
									}
									else
									{
										$startdays[0] = ($selectedDays[$i]!='') ? trim($selectedDays[$i]) : '';
										$enddays[0] = '';
									}
								}
								
								if($start_hour[$i]!='')
								{
									$start_minute[$i] = ($start_minute[$i]!='') ? $start_minute[$i] : '00';
									$start_time[$i] = $start_hour[$i].":".$start_minute[$i]." ".$start_meridiem[$i];	
				
									// 12-hour time to 24-hour time 
									$time_in_24_hour_format1  = date("H:i", strtotime($start_time[$i]));									
									$startTime = $time_in_24_hour_format1;
								}
								else
								{
									$startTime = '';
								}
								
								if($end_hour[$i]!='')
								{
									$end_minute[$i] = ($end_minute[$i]!='') ? $end_minute[$i] : '00';
									$end_time[$i] = $end_hour[$i].":".$end_minute[$i]." ".$end_meridiem[$i];
									
									// 12-hour time to 24-hour time 
									$time_in_24_hour_format2  = date("H:i", strtotime($end_time[$i]));									
									$endTime = $time_in_24_hour_format2;
								}
								else
								{
									$endTime = '';
								}															
								
								$IsClosed = ($isClosed[$i]!='') ? $isClosed[$i] : '';
								
								for($c=0;$c<count($startdays);$c++)
								{
									$image_tdata = array('image_id' => $image_id,
												'start_day' => $startdays[$c],
												'end_day' => $enddays[$c],
												'start_time' => $startTime,
												'end_time' => $endTime,
												'isClosed' => $IsClosed,
												'isActive' => '1');
									$image_timingid = $this->Imagemodel->setImageTimingData($image_tdata);	
								}
							}
						}
					}
					
					// Save fees
					if($time_period!='' && $fees!='')
					{
						for($i=0;$i<count($time_period);$i++)
						{
							if($time_period[$i]!='' && $fees[$i]!='')
							{								
								$image_fdata = array('image_id' => $image_id,
											'time_period' => $time_period[$i],
											'fees' => $fees[$i],
											'isActive' => '1');
								$image_feesid = $this->Imagemodel->setImageFeesData($image_fdata);	
							}
						}
					}
					
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
										$image_idata = array('image_id' => $image_id,
												'user_id' => '0',
												'imagename' => $imagename,
												'isActive' => '1');
										$image_imageid = $this->Imagemodel->setImageImages($image_idata);
									}
								//}
							}
						}					
					}
				
					$this->session->set_flashdata('flash_message', 'Image'.ADDMSG);
					$this->session->set_flashdata('flash_type', 'success');
					
					if((($amenities!='') OR ($isClosed!='' && $selectedDays!='') OR ($time_period!='' && $fees!='') OR (!empty($_FILES))))
					{
						redirect('admin/image');   // on list page
					}
					else
					{
						redirect('admin/image/update/'.$image_id.'#tabs-2');   // on tab2
					}
				}
				else
				{
					$msg= 'Error While Saving Data.';
					$msgtype= 'error';
				}
				
			}
		}
		
		$countries = $this->Imagemodel->getCountries();
		$data['countries'] = $countries;
		
		$amenities = $this->Imagemodel->getAmenities();
		$data['amenities'] = $amenities;
		
		$data['message']= ($msg!='') ? $msg : '';
		$data['messagetype']= ($msgtype!='') ? $msgtype : '';
				
		$data['mainContent'] = 'admin/image/imageAdd';		
		$this->load->view('admin/includes/template', $data);
	}  /// End Of ADD Function
	
/************************************************************ Update item by his id  * @return void ************************/
    public function update()
    {
		//admin id 
		$image_id = $this->uri->segment(4);
		
		$data['image'] = $this->Imagemodel->get_image_by_id($image_id);
		
		$user_id = $data['image'][0]['user_id']; // created by
		
		//if save button was clicked, get the data sent via post
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{
			//form validation
			$this->form_validation->set_rules('image_name', 'image name', 'required');
			$this->form_validation->set_rules('address1', 'address1', 'required');
			$this->form_validation->set_rules('city', 'city', 'required');
			//$this->form_validation->set_rules('state', 'state', 'required');
			$this->form_validation->set_rules('country', 'country', 'required');
			$this->form_validation->set_rules('zipcode', 'zipcode', 'required');
			$this->form_validation->set_rules('contact_number', 'contact number', 'required');
			$this->form_validation->set_rules('description', 'description', 'required');
			$this->form_validation->set_error_delimiters('<br /><em class="error">', '</em>');
			
			//if the form has passed through the validation
			if ($this->form_validation->run())
			{
				// tab 2 data
				$amenities = ($this->input->post('amenity')!='') ? $this->input->post('amenity') : '';
				
				$isClosed = ($this->input->post('isClosed')!='') ? $this->input->post('isClosed') : '';
				$selectedDays = ($this->input->post('selectedDays')!='') ? $this->input->post('selectedDays') : '';
				
				//$start_time = ($this->input->post('start_time')!='') ? $this->input->post('start_time') : '';
				$start_hour = ($this->input->post('start_hour')!='') ? $this->input->post('start_hour') : '';
				$start_minute = ($this->input->post('start_minute')!='') ? $this->input->post('start_minute') : '';
				$start_meridiem = ($this->input->post('start_meridiem')!='') ? $this->input->post('start_meridiem') : '';				
				
				//$end_time = ($this->input->post('end_time')!='') ? $this->input->post('end_time') : '';
				$end_hour = ($this->input->post('end_hour')!='') ? $this->input->post('end_hour') : '';
				$end_minute = ($this->input->post('end_minute')!='') ? $this->input->post('end_minute') : '';
				$end_meridiem = ($this->input->post('end_meridiem')!='') ? $this->input->post('end_meridiem') : '';
				
				$time_period = ($this->input->post('time_period')!='') ? $this->input->post('time_period') : '';
				$fees = ($this->input->post('fees')!='') ? $this->input->post('fees') : '';
				
				//echo '<pre>'; print_r($_REQUEST); print_r($_FILES); exit;
				
				$image_name = set_value('image_name');
				$isApproved = $this->input->post('isApproved');
				
				// Get lat long details
				$address1 = (set_value('address1')!='') ? set_value('address1') : '';
				$city = (set_value('city')!='') ? set_value('city') : '';
				
				$state = ($this->input->post('state')!='') ? $this->input->post('state') : '';
				$country = ($this->input->post('country')!='') ? $this->input->post('country') : '';
				$zipcode = (set_value('zipcode')!='') ? set_value('zipcode') : '';
				
				$countryName = ($country) ? $this->Imagemodel->getCountryName($country) : '';
				$stateName = ($state) ? $this->Imagemodel->getStateName($state) : '';
				
				$latitude = '';
				$longitude = '';
				//$fullAddress = $image_name.$address1.$city.$state.$zipcode.$country;
				$fullAddress = $stateName[0]['name'].$countryName[0]['name'].$zipcode;
				$s_address = preg_replace('/\s+/', '', $fullAddress);
				$url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$s_address."&sensor=false";
				$details = file_get_contents($url);
				$s_result = json_decode($details,true);
				//echo '<pre>'; print_r($s_result); exit;				
				if(count($s_result['results']))
				{
					$latitude = $s_result['results'][0]['geometry']['location']['lat'];
					$longitude = $s_result['results'][0]['geometry']['location']['lng'];
				}
				
				// build array for the model
				$form_data = array(
					'image_name' => set_value('image_name'),
					'address1' => set_value('address1'),
					'city' => set_value('city'),
					'state' => $this->input->post('state'),
					'country' => $this->input->post('country'),
					'zipcode' => set_value('zipcode'),
					'contact_number' => set_value('contact_number'),
					'latitude' => $latitude,
					'longitude' => $longitude,
					'description' => set_value('description'),
					'isActive' => $this->input->post('isActive'),
					'isApproved' => $this->input->post('isApproved')
				);
				
				//if the insert has returned true then we show the flash message
				if($this->Imagemodel->setUpdatedImageData($image_id, $form_data) == TRUE)
				{
					// On approval of image user will get mail
					if($user_id!='0' && $isApproved=='1')
					{
						$userInfo = $this->Imagemodel->getUserInfo($image_id);
						
						// *** send mail *****
						$admin = $this->config->item('admin_email');
						
						$template_details = array(
												 'name' => $userInfo[0]['first_name'].' '.$userInfo[0]['last_name'],
												 'link' =>  base_url(),
												 'path' =>  base_url().'assets/images/',
												 'image' => $image_name,
												 'admin_email' => $admin,
												 'ioslink' => $this->config->item('ioslink'),
												 'androidlink' => $this->config->item('androidlink')
											   );
						//echo '<pre>'; print_r($template_details); exit;
						$msg = $this->parser->parse('mail_templetes/imageapproval',$template_details, TRUE);
						
						$this->email->from($admin, 'Outperform Fitness');
						$this->email->to($userInfo[0]['email']);
						$this->email->subject($this->config->item('project_name').' - Image has been approved');
						$this->email->message($msg);
						$mail_sent = $this->email->send();
					}
					
					// Save amenities
					if($amenities)
					{
						$this->Imagemodel->deleteAllImageAmenities($image_id); // to delete all exist
						for($i=0;$i<count($amenities);$i++)
						{
							$image_adata = array('image_id' => $image_id,
										'amenities' => $amenities[$i],
										'isActive' => '1');
							$image_amenityid = $this->Imagemodel->setImageAmenities($image_adata);								
						}
					}
					
					// Save timings
					if($isClosed!='' && $selectedDays!='')
					{
						$this->Imagemodel->deleteAllImageTimingData($image_id); // to delete all exist
						for($i=0;$i<count($selectedDays);$i++)
						{
							$startdays = array();
							$enddays = array();
							
							if($selectedDays[$i]!='')
							{
								// check for multiple selected days
								if(strpos($selectedDays[$i],","))
								{
									$selected = explode(",",$selectedDays[$i]);
									
									for($s=0;$s<count($selected);$s++)
									{
										// check for range in selected days
										if(strpos($selected[$s],"-"))
										{
											$selDays = explode("-",$selected[$s]);
											$startdays[$s] = ($selDays!='') ? trim($selDays[0]) : '';
											$enddays[$s] = ($selDays!='') ? trim($selDays[1]) : '';
										}
										else
										{
											$startdays[$s] = ($selected[$s]!='') ? trim($selected[$s]) : '';
											$enddays[$s] = '';
										}
									}
								}
								else
								{
									// check for range in selected days
									if(strpos($selectedDays[$i],"-"))
									{
										$selDays = explode("-",$selectedDays[$i]);
										$startdays[0] = ($selDays!='') ? trim($selDays[0]) : '';
										$enddays[0] = ($selDays!='') ? trim($selDays[1]) : '';
									}
									else
									{
										$startdays[0] = ($selectedDays[$i]!='') ? trim($selectedDays[$i]) : '';
										$enddays[0] = '';
									}
								}
								
								if($start_hour[$i]!='')
								{
									$start_minute[$i] = ($start_minute[$i]!='') ? $start_minute[$i] : '00';
									$start_time[$i] = $start_hour[$i].":".$start_minute[$i]." ".$start_meridiem[$i];	
				
									// 12-hour time to 24-hour time 
									$time_in_24_hour_format1  = date("H:i", strtotime($start_time[$i]));									
									$startTime = $time_in_24_hour_format1;
								}
								else
								{
									$startTime = '';
								}
								
								if($end_hour[$i]!='')
								{
									$end_minute[$i] = ($end_minute[$i]!='') ? $end_minute[$i] : '00';
									$end_time[$i] = $end_hour[$i].":".$end_minute[$i]." ".$end_meridiem[$i];
									
									// 12-hour time to 24-hour time 
									$time_in_24_hour_format2  = date("H:i", strtotime($end_time[$i]));									
									$endTime = $time_in_24_hour_format2;
								}
								else
								{
									$endTime = '';
								}														
								
								$IsClosed = ($isClosed[$i]!='') ? $isClosed[$i] : '';
								
								for($c=0;$c<count($startdays);$c++)
								{
									$image_tdata = array('image_id' => $image_id,
												'start_day' => $startdays[$c],
												'end_day' => $enddays[$c],
												'start_time' => $startTime,
												'end_time' => $endTime,
												'isClosed' => $IsClosed,
												'isActive' => '1');
									$image_timingid = $this->Imagemodel->setImageTimingData($image_tdata);	
								}
							}
						}
					}
					
					// Save fees
					if($time_period!='' && $fees!='')
					{
						$this->Imagemodel->deleteAllImageFeesData($image_id); // to delete all exist
						for($i=0;$i<count($time_period);$i++)
						{
							if($time_period[$i]!='' && $fees[$i]!='')
							{								
								$image_fdata = array('image_id' => $image_id,
											'time_period' => $time_period[$i],
											'fees' => $fees[$i],
											'isActive' => '1');
								$image_feesid = $this->Imagemodel->setImageFeesData($image_fdata);	
							}
						}
					}
					
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
										$image_idata = array('image_id' => $image_id,
												'user_id' => '0',
												'imagename' => $imagename,
												'isActive' => '1');
										$image_imageid = $this->Imagemodel->setImageImages($image_idata);
									}
								//}
							}
						}					
					}
													
					$this->session->set_flashdata('flash_message', 'Image'.UPDATEMSG);
					$this->session->set_flashdata('flash_type', 'success');
					redirect('admin/image');
				}
				else
				{
					/*$this->session->set_flashdata('flash_message', 'ErrorWhile Saving Data.');
					$this->session->set_flashdata('flash_type', 'error');*/
					$msg= 'Error While Saving Data.';
					$msgtype= 'error';
				}
			}//validation run
			
		}
		
		$countries = $this->Imagemodel->getCountries();
		$data['countries'] = $countries;
		
		$amenities = $this->Imagemodel->getAmenities();
		$data['amenities'] = $amenities;				
		$data['image_amenities'] = $this->Imagemodel->get_image_amenities($image_id);
		$data['image_images'] = $this->Imagemodel->get_image_images($image_id);
		$data['image_timings'] = $this->Imagemodel->get_image_timings($image_id);
		$data['image_fees'] = $this->Imagemodel->get_image_fees($image_id);
		
		$data['message']=isset($msg)?$msg:'';
		$data['messagetype']=isset($msgtype)?$msgtype:'';
		//echo '<pre>';print_r($data['image_images']);exit;
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
			$this->Imagemodel->deleteimagereviewByimageId($id); // to delete all Reviews
			$this->Imagemodel->deleteAllImageAmenities($id); // to delete all Amenities
			$this->Imagemodel->deleteAllImageTimingData($id); // to delete all Timings
			$this->Imagemodel->deleteAllImageFeesData($id); // to delete all Fees				
			$this->Imagemodel->deleteAllImageImagesData($id); // to delete all Images
			
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
				$this->Imagemodel->deleteimagereviewByimageId($id); // to delete all Reviews
				$this->Imagemodel->deleteAllImageAmenities($id); // to delete all Amenities
				$this->Imagemodel->deleteAllImageTimingData($id); // to delete all Timings
				$this->Imagemodel->deleteAllImageFeesData($id); // to delete all Fees
				$this->Imagemodel->deleteAllImageImagesData($id); // to delete all Images
				
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
	
	////// For Export Data To Excel ///////
	public function exportToexcel()
	{
		$data['export'] = $this->Imagemodel->getAllImage();  
		$this->load->view('admin/image/image_excel', $data);        
	}
	
	////// For Export Data To Excel Reviews ///////
	public function exportToexcelReviews()
	{
		$id = $this->uri->segment(5);
		$data['export'] = $this->Imagemodel->getAllImageReviews($id);  
		//echo '<pre>';print_r($data['export']);exit;
		$this->load->view('admin/image/image_excel_review', $data);        
	}
	
	function getStates()
	{
		$countryid = $this->input->post('countryid');
		$selId = $this->input->post('selId');
		$result = '';
		if($countryid)
		{
			$states = $this->Imagemodel->getStates($countryid);
		
			$result = '<label class="form-label">State</label>
					   <select class="form-control" id="state" name="state">
					   <option value="">Select State</option>';
					   for($c=0;$c<count($states);$c++)
					   {
						   if($selId==$states[$c]['state_id'])
						   {
						   		$selected = 'selected="selected"';
						   }
						   else
						   {
							   $selected = '';
						   }
			$result .=  '<option value="'.$states[$c]['state_id'].'" '.$selected.'>'.$states[$c]['name'].'</option>';
					   }
			$result .= '</select>';
		}
		echo $result;
	}
			
	public function deleteImageTiming()
	{
		$timing_id = $this->input->post('timing_id');
				
		if($this->Imagemodel->deleteImageTiming($id) == true)
			return true;
		else
			return false;
	}
	
	public function deleteImageFees()
	{
		$timing_id = $this->input->post('fees_id');
				
		if($this->Imagemodel->deleteImageFees($id) == true)
			return true;
		else
			return false;
	}
	
	public function publishimage()
	{
		$cid = $this->input->post('id');
		$cdate = date("Y-m-d h:i:s");
		
		// Add challenges to new Image		
		/*$in_chq = "INSERT INTO challenge (imageid, title, title_url, author_name, description, why_it_matters, fun_fact, modifications, video_url, no_of_challenge, isActive, isDelete, created_date) SELECT '".$cid."', title, title_url, author_name, description, why_it_matters, fun_fact, modifications, video_url, no_of_challenge, isActive, isDelete, '".$cdate."' FROM challenge WHERE imageid = '2'";
		$this->db->query($in_chq);
		$ch = $this->db->insert_id();

		// Add virtual class to new Image
		$in_vcq = "INSERT INTO virtual_class (imageid, class_title, title_url, content, description, isActive, isDelete, created_date) SELECT '".$cid."', class_title, title_url, content, description, isActive, isDelete, '".$cdate."' FROM virtual_class WHERE imageid = '2'";
		$this->db->query($in_vcq);
		$vc = $this->db->insert_id();*/
		
		// Add theme builder to new Image
		$in_tbq = "INSERT INTO themebuilder (imageid, blue, orange, green, grey, white, lightwhite, black, lightgray, yellow, jumbocolor, darkgreen, created_date) VALUES ('".$cid."', '#197eb4', '#F79049', '#95ca4e', '#63686b', '#ffffff', '#c9cccd', '#31383c', '#606a70', '#f8cf2a', '#5b6aff', '#38c560', '".$cdate."')";
		$this->db->query($in_tbq);
		//echo $this->db->last_query();
		$tb = $this->db->insert_id();
		
		// Add home content to new Image
		$defaultArr = array('video_title' => 'The 100 Day Pilates Challenge',
						'video_url' => 'https://www.youtube.com/watch?v=W8rgDYEO7bk',
						'video_image' => 'top-designimage.png',
						'get_started' => '100\'s to Happiness&trade; is designed to help individuals discover the foundation of healthy
movement and breath patterns, which will open the door to a better quality of life... "Happiness"',
						'feature_1' => 'slide-img1.png',
						'feature_2' => 'slide-img2.png',
						'feature_3' => 'slide-img3.png', 
						'feature_4' => 'slide-img4.png',
						'about_text' => 'The purpose of the 100\'s to Happiness&trade; Challenge is to challenge participants to fully understand the Pilates Method through an interactive',
						'app_logo' => 'footer-logoicon.png',
						'app_store_url' => '#',
						'google_play_url' => '#',
						'background_image' => 'welcome-bg.jpg',
						'imageid' => $cid);
						
		/*$in_hcq = "INSERT INTO homecontent (imageid, video_title, video_url, video_image, get_started, feature_1, feature_2, feature_3, feature_4, about_text, app_logo, app_store_url, google_play_url, background_image, isActive) VALUES ('".$cid."', '".$defaultArr['video_title']."', '".$defaultArr['video_url']."', '".$defaultArr['video_image']."', '".$defaultArr['get_started']."', '".$defaultArr['feature_1']."', '".$defaultArr['feature_2']."', '".$defaultArr['feature_3']."', '".$defaultArr['feature_4']."', '".$defaultArr['about_text']."', '".$defaultArr['app_logo']."', '".$defaultArr['app_store_url']."', '".$defaultArr['google_play_url']."', '".$defaultArr['background_image']."', '1')";
		$this->db->query($in_hcq);
		//echo $this->db->last_query();
		$hc = $this->db->insert_id();*/
		$hc = $this->Settingsmodel->setHomecontent($defaultArr);
		
		$up_comq = "UPDATE image SET isActive = '1' WHERE imageid = '".$cid."'";
		$this->db->query($up_comq);
		//echo $this->db->last_query();
		//exit;
		
		//===================================insert cms pages for image=============================//
		$form_data1 = array('imageid' => $cid,
						'page_name' => 'About',
						'page_url' => 'about',
						'page_content' => '',
						'page_title' => 'About Us',
						'meta_description' => 'About Us',
						'isActive' => '1',
						'isDelete' => '1'
						);
		$this->Imagemodel->setCmsData($form_data1);
		
		$form_data2 = array('imageid' => $cid,
						'page_name' => 'How it Works',
						'page_url' => 'how-it-works',
						'page_content' => '',
						'page_title' => 'How it works',
						'meta_description' => 'How it works',
						'isActive' => '1',
						'isDelete' => '1'
						);
		$this->Imagemodel->setCmsData($form_data2);
		
		$form_data3 = array('imageid' => $cid,
						'page_name' => 'Terms of use',
						'page_url' => 'terms-of-use',
						'page_content' => '',
						'page_title' => 'Terms of use',
						'meta_description' => 'Terms of use',
						'isActive' => '1',
						'isDelete' => '1'
						);
		$this->Imagemodel->setCmsData($form_data3);
		
		$form_data4 = array('imageid' => $cid,
						'page_name' => 'Privacy Policy',
						'page_url' => 'privacy-policy',
						'page_content' => '',
						'page_title' => 'Privacy policy',
						'meta_description' => 'Privacy policy',
						'isActive' => '1',
						'isDelete' => '1'
						);
		$this->Imagemodel->setCmsData($form_data4);
				
		//===================================insert cms pages for image=============================//
		
		echo true;
	}
}

?>