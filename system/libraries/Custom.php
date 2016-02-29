<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class CI_Custom
{
	public function __construct()
	{
		define('ADDMSG'," Added Successfully.");
		define('UPDATEMSG'," Updated Successfully.");
		define('DELETEMSG'," Deleted Successfully.");
		define('STATUSMSG'," Status Changed Successfully.");
		define('EXIST'," Already Exists.");
		//echo "===>".ADDMSG."===>".UPDATEMSG."===>".DELETEMSG."===>".STATUSMSG;
	}
}
?>
