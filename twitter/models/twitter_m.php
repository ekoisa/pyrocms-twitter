<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Twitter model
 * 
 * @author Antoine Benevaut
 * 
 * @package		OursITShow
 * @subpackage  Users
 * @category  	Module
 *
 */
class Twitter_m extends MY_Model {

	protected $_table = 'twitter';

	function get_user_id($token)
	{
		$this->db->select('user_id')
			->where('token', $token);
			
		return $this->db->get($this->_table)->result();
	}
	
	function save_token($user_id, $token)
	{
		(int) parent::insert(array(
			'user_id'	=> $user_id,
			'token'		=> $token
		));
	}
}

/* End of file twitter_m.php */
