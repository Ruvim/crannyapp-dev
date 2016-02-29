<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
//echo "Url=====>". APPPATH;
//exit;
//echo $path = $this->config->item("base_path");
//exit;
require APPPATH . 'libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Webservices extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits'
        // within application/config/rest.php
        $this->methods['user_get']['limit'] = 500; //500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; //100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; //50 requests per hour per user/key
		
		$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);  
        $this->output->set_header('Pragma: no-cache');
		$this->load->database();
		
		$this->load->helper('file');
		//$this->load->helper('date');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('string');
		$this->load->library('email');
		$this->load->library('parser');
		$this->load->library('session');
		$this->load->library('Websrvices_msg');
		//$this->load->library('Curl');
		
		$this->load->model('webservicesmodel');
    }
	
	function generatelog($currenturl,$reqmethod,$fields,$response)
	{
		$physicalpath=$this->config->item('base_path');
		//echo current_url();
			
		$data ="URL:".$currenturl."\n";
		$data.="METHOD:".$reqmethod."\n";
		$parameters="";
		if($reqmethod=='POST')
		{
			$count=count($fields);
			$i=1;
			foreach($fields as $key=>$value)
			{
				if($i==$count)
				{
					$parameters.=$key."=".$value;
				}
				else
				{
					$parameters.=$key."=".$value."&";
				}
				$i++;
			}
			$data.="Fields:".$parameters."\n";
		}
		$data.="Response:".$response."\n";
		
		$data.="Date:".date('m-d-Y',strtotime('now'))."\n";
		
		$data.="Time:".date('H:i:s',strtotime('now'))."\n";
		
		if ( ! write_file($physicalpath.'assets/log/log.txt', "\n".$data."\n","a+"))
		{	
			//write_file('upload/log.txt', $data);
			//echo 'Unable to write the file';
		}
		else
		{
			//echo 'File written!';
		}
	}
}