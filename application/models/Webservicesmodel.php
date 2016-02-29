<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Webservicesmodel extends CI_Model {

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
	
	// --------------------------------------------------------------------
		
	////////// check user is exist or not //////////
	public function checkSecurityToken($security_token,$user_id)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('security_token', $security_token);
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}		
}
?>