<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Twitter module
 * 
 * @author Antoine Benevaut
 * 
 * @package		OursITShow
 * @subpackage  Users
 * @category  	Module
 *
 */
class Ion_auth_twitter extends Ion_auth {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->ci->load->config('ion_auth_twitter');
		$this->ci->load->model('ion_auth_twitter_model');
	}
	
	public function login($tokens, $remember=false)
	{		
		if ($this->ci->ion_auth_twitter_model->login($tokens, $remember))
		{
			$this->set_message('login_successful');
			return TRUE;
		}

		$this->set_error('login_unsuccessful');
		return FALSE;
	}

	public function register($username, $email, $additional_data, $group_name = false)
	{
		$email_activation = $this->ci->config->item('email_activation', 'ion_auth');
		$id = $this->ci->ion_auth_twitter_model->register($username, '', $email, $additional_data, $group_name);

		if ( ! $email_activation)
		{
			if ($id !== FALSE)
			{
				$this->set_message('account_creation_successful');
				return $id;
			}
			else
			{
				$this->set_error('account_creation_unsuccessful');
				return FALSE;
			}
		}
		else
		{		
			if ( !$id)
			{
				$this->set_error('account_creation_unsuccessful');
				return FALSE;
			}

			$deactivate = $this->ci->ion_auth_model->deactivate($id);

			if ( ! $deactivate)
			{
				$this->set_error('deactivate_unsuccessful');
				return FALSE;
			}

			$activation_code = $this->ci->ion_auth_model->activation_code;
			$identity        = $this->ci->config->item('identity', 'ion_auth');
			$user            = $this->ci->ion_auth_model->get_user($id)->row();

			$data = array(
				'identity'   => $user->{$identity},
				'id'         => $user->id,
			 	'email'      => $email,
			 	'activation' => $activation_code
			);

			$message = $this->ci->load->view($this->ci->config->item('email_templates', 'ion_auth').$this->ci->config->item('email_activate', 'ion_auth'), $data, true);

			$this->ci->email->clear();
			$config['mailtype'] = "html";
			$this->ci->email->initialize($config);
			$this->ci->email->set_newline("\r\n");
			$this->ci->email->from($this->ci->settings->get('server_email'), $this->ci->settings->get('site_name'));
			$this->ci->email->reply_to($this->ci->settings->get('contact_email'));
			$this->ci->email->to($email);
			$this->ci->email->subject($this->ci->settings->get('site_name') . ' - Account Activation');
			$this->ci->email->message($message);

			if ($this->ci->email->send() == TRUE)
			{
				$this->set_message('activation_email_successful');
				return $id;
			}

			$this->set_error('activation_email_unsuccessful');
			return FALSE;
		}
		return FALSE;
	}
}