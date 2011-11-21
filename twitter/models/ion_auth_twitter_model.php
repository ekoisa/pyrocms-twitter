<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Twitter module
 * 
 * @author Antoine Benevaut
 * 
 * @package		OursITShow
 * @subpackage  Users
 * @category  	Library
 *
 */
class Ion_auth_twitter_model extends Ion_auth_model {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('session');
		$this->load->library('ion_auth');
	}

	public function tokens_check($tokens = '')
	{		
	    if (empty($tokens))
	    {
			return FALSE;
	    }

	    $query = $this->db->select('id')
	    		->where('twitter_access_token', $tokens['oauth_token'])
	    		->where('twitter_access_token_secret', $tokens['oauth_token_secret'])
				->get(SITE_REF.'_profiles');

		return $query->row();
	}

	public function login($tokens, $remember=FALSE)
	{
		if (!($profile = $this->tokens_check($tokens)))
		{
			return FALSE;
		}
		
		$user = $this->db->where('active', 1)
				->where('id', $profile->id)
				->limit(1)
				->get($this->tables['users'])
				->row();
				
		$this->update_last_login($user->id);

		$group_row = $this->db->select('name')->where('id', $user->group_id)->get($this->tables['groups'])->row();

		$session_data = array(
			$this->identity_column => $user->{$this->identity_column},
			'id'                   => $user->id, //kept for backwards compatibility
			'user_id'              => $user->id, //everyone likes to overwrite id so we'll use user_id
			'group_id'             => $user->group_id,
			'group'                => $group_row->name
			 );
			 
		$this->session->set_userdata($session_data);

		if ($remember && $this->config->item('remember_users', 'ion_auth'))
		{
			$this->remember_user($user->id);
		}

		return TRUE;
	}
	
	/**
	 * register
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function register($username, $password, $email, $additional_data = false, $group_name = false)
	{
		if ($this->identity_column == 'twitter_access_token' && srtlen('twitter_access_token'))
		{
		}

		// If username is taken, use username1 or username2, etc.
		if ($this->identity_column != 'username')
		{
			for($i = 0; $this->username_check($username); $i++)
			{
				if($i > 0)
				{
					$username .= $i;
				}
			}
		}

	    // If a group ID was passed, use it
		if (isset($additional_data['group_id']))
		{
			$group_id = $additional_data['group_id'];
			unset($additional_data['group_id']);
		}

	    // Otherwise use the group name if it exists
		else
		{
			// Group ID
			if(!$group_name)
			{
				$group_name = $this->config->item('default_group', 'ion_auth');
			}

			$group_id = ($group = $this->db->select('id')
				->where('name', $group_name)
				->get($this->tables['groups'])
				->row()) ? $group->id: 0;
		}

		// IP Address
		$ip_address	= $this->input->ip_address();
		$salt		= $this->store_salt ? $this->salt() : FALSE;
		$password	= $this->hash_password($password, $salt);

		// Users table.
		$data = array(
			'username'   => $username,
			'password'   => $password,
			'email'      => $email,
			'group_id'   => $group_id,
			'ip_address' => $ip_address,
			'created_on' => now(),
			'last_login' => now(),
			'active'     => 1
		);

		if ($this->store_salt)
		{
			$data['salt'] = $salt;
		}

		$this->db->insert($this->tables['users'], $data);

		// Meta table.
		$id = $this->db->insert_id();

		$data = array($this->meta_join => $id);

		if ( ! empty($this->columns))
		{
			foreach ($this->columns as $input)
			{
				if (is_array($additional_data) && isset($additional_data[$input]))
				{
					$data[$input] = $additional_data[$input];
				}
				elseif ($this->input->post($input))
				{
					$data[$input] = $this->input->post($input);
				}
			}
		}

		$this->db->insert($this->tables['meta'], $data);

		return $this->db->affected_rows() > 0 ? $id: false;
	}
}

/* End of file ion_auth_twitter_model.php */
