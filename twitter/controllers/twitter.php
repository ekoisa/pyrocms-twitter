<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

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
class Twitter extends Public_Controller {
		
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('tweet');
		$this->load->library('ion_auth_twitter');
		$this->load->library('form_validation');
		
		$this->lang->load('users/user');
		
		$this->set_debug();
	}
		
	/**
	 * index
	 */
	public function index()
	{
		$this->isActivate();

		$this->template
			->title(lang('twitter_title'))
			->build('index', array('datas' => ''));
	}

	/**
	 * login
	 * 
	 * Twitter login
	 */
	public function login()
	{
		$this->isActivate();
		
		if ( !$this->tweet->logged_in() )
		{
			$this->tweet->set_callback(site_url('twitter/auth'));
			$this->tweet->login();
		}
		else
		{
			redirect($this->settings->item('twitter_connect_redirection'));
		}
	}
	
	/**
	 * logout
	 * 
	 * Twitter logout
	 */
	public function logout()
	{
		$this->isActivate();
		
		if ( $this->tweet->logged_in() )
		{
			$this->tweet->logout();
			$this->ion_auth_twitter->logout();
		}
		redirect('twitter');
	}

	/**
	 * auth
	 * 
	 * Twitter authentification
	 * 
	 * if an user is logged in that update his tokens,
	 * else try user longin,
	 * 		if the user is now logged in redirect to home.
	 * 		else it's a new user, redirect to twitter/register. 
	 */
	public function auth()
	{
		$this->isActivate();
		
		$tokens = $this->tweet->get_tokens();

		if ( $this->ion_auth_twitter->logged_in() )
		{
			$this->ion_auth_twitter->update_user($this->user->id, array(
				'twitter_access_token' 		  => $tokens['oauth_token'],
				'twitter_access_token_secret' => $tokens['oauth_token_secret']
			));
		}
		else
		{
			if ( !$this->ion_auth_twitter->login($tokens) )
			{
				$this->data->error_string = $this->ion_auth->errors();
				redirect('twitter/register');
			}
		}
		redirect('twitter');
	}
	
	/**
	 * register
	 * 
	 * Twitter registration
	 * 
	 * user need to field an email form.
	 * 
	 * If the user email exist, that link his Twitter account
	 * 	with his user acount.
	 * 
	 * Else, add the new user.
	 * 
	 */
	public function register()
	{
		/*$user		= NULL;
		$tokens		= $this->tweet->get_tokens();
		
		$user_data	= array(
			'email' => $this->input->post('email'),
			'confirm_email' => $this->input->post('confirm_email')
		);

		$validation = array(
			array(
				'field' => 'email',
				'label' => lang('user_email'),
				'rules' => 'required|valid_email|callback__email_check',
			),
			array(
				'field' => 'confirm_email',
				'label' => lang('user_confirm_email'),
				'rules' => 'required|valid_email|matches[email]',
			)
		);
		
		$this->isActivate();
		$this->form_validation->set_rules($validation);
		
		$valid		= $this->form_validation->run();

		if ( $valid )
		{
			$user = $this->ion_auth_twitter->get_users_by_email($user_data['email']);
		}
		
		if ( $valid && isset($user->id) )
		{
			$this->ion_auth_twitter->update_user($user->id, array(
				'twitter_access_token' 		  => $tokens['oauth_token'],
				'twitter_access_token_secret' => $tokens['oauth_token_secret']
			));
			redirect('twitter/auth');
		}
		else if ( $valid )
		{
			$activation			= $this->settings->item('email_activation', 'ion_auth');
			$user				= $this->tweet->call('get', 'account/verify_credentials');
			
			$additional_data	= array(
				'display_name'					=> $user->screen_name,
				'first_name'					=> $user->name,
				'last_name'						=> '',
				'lang'							=> $user->lang, 
				'twitter_access_token'			=> $tokens['oauth_token'],
				'twitter_access_token_secret'	=> $tokens['oauth_token_secret']
			);

			$this->ion_auth_twitter->register($user->screen_name, $user_data['email'], $additional_data);
	*/
			/**
			 * Twitter post about user use your app
			 */					
		/*	if ( !$this->tweet->call('post', 'statuses/update', array('status' => $this->settings->item('twitter_registered_message').' '.shorten_url())) )
			{
				$this->session->set_flashdata('error', lang('twitter_tweet_error').": ".$this->twitter->last_error['error']);
			}
			
			if ($activation)
			{
				redirect('users/activate');	
			}
			redirect('twitter/auth');
		}
		else if ( !$valid )
		{
			$user_data['error'] = $this->form_validation->error_string();
		}
		
		$this->template
			->title(lang('user_register_title'))
			->build('register', array('user_data' => $user_data));
			*/
		
		$user		= NULL;
		$tokens		= $this->tweet->get_tokens();
		
		$user_data	= array(
					'email' => $this->input->post('email'),
					'confirm_email' => $this->input->post('confirm_email')
		);
		
		$validation = array(
		array(
						'field' => 'email',
						'label' => lang('user_email'),
						'rules' => 'required|valid_email|callback__email_check',
		),
		array(
						'field' => 'confirm_email',
						'label' => lang('user_confirm_email'),
						'rules' => 'required|valid_email|matches[email]',
		)
		);
		
		$this->isActivate();
		$this->form_validation->set_rules($validation);
		
		$valid		= $this->form_validation->run();
		
		if ( $valid )
		{
			$user = $this->ion_auth_twitter->get_users_by_email($user_data['email']);
		}
		
		if ( $valid && isset($user->id) )
		{
			$this->ion_auth_twitter->update_user($user->id, array(
						'twitter_access_token' 		  => $tokens['oauth_token'],
						'twitter_access_token_secret' => $tokens['oauth_token_secret']
			));
			redirect('twitter/auth');
		}
		else if ( $valid )
		{
			$activation			= $this->settings->item('email_activation', 'ion_auth');
			$user				= $this->tweet->call('get', 'account/verify_credentials');
				
			$additional_data	= array(
						'display_name'					=> $user->screen_name,
						'first_name'					=> $user->name,
						'last_name'						=> '',
						'lang'							=> $user->lang, 
						'twitter_access_token'			=> $tokens['oauth_token'],
						'twitter_access_token_secret'	=> $tokens['oauth_token_secret']
			);
		
			$this->ion_auth_twitter->register($user->screen_name, $user_data['email'], $additional_data);
		
			/**
			 * Twitter post about user use your app
			 */					
			if ( !$this->tweet->call('post', 'statuses/update', array('status' => $this->settings->item('twitter_registered_message').' '.shorten_url())) )
			{
				$this->session->set_flashdata('error', lang('twitter_tweet_error').": ".$this->twitter->last_error['error']);
			}
				
			if ($activation)
			{
				redirect('users/activate');
			}
			redirect('twitter/auth');
		}
		else if ( !$valid )
		{
			$user_data['error'] = $this->form_validation->error_string();
		}
		
		$this->template
		->title(lang('user_register_title'))
		->build('register', array('user_data' => $user_data));
	}
	
	/**
	 * set_debug
	 * 
	 * set debug for tweet library
	 */
	private function set_debug()
	{
		switch (ENVIRONMENT)
		{
			case 'local':
			case 'dev':
				$this->tweet->enable_debug(TRUE);
			break;

			case 'qa':
			case 'live':
			default:
				$this->tweet->enable_debug(FALSE);
			break;
		}
	}
	
	/**
	 * isActive
	 * 
	 * check settings
	 */
	private function isActivate()
	{
		if ( !$this->settings->item('twitter_connect') )
		{
			redirect('');
		}
	}
}

/**
 * @mainpage User Guide
 * 
 * <h2>Tweet uri</h2>
 * 
 * <ul>
 * 	<li>twitter</li>
 * 	<li>twitter/login</li>
 * 	<li>twitter/logout</li>
 * </ul>
 * 
 * <h2>Tweet integration</h2>
 * 
 * $this->tweet->call('get', 'account/verify_credentials');<br />
 * <a href="http://dev.twitter.com/doc/">Twitter api doc</a><br />
 * 
 * <h2>Twitter widgets</h2>
 * 
 * <ul>
 * 	<li>twitter follow</li>
 * 	<li>twitter like</li>
 * </ul>
 *
 * <h2>Tweet plugin</h2>
 *
 * <code>
 * <?php if ( '{pyro:tweet:logged_in}' ): ?><br />
 * 		\<a href="{pyro:url:site uri='twitter/logout'}"><br />
 * 			{pyro:helper:lang line="logout_label"}<br />
 * 		\</a><br />
 * <?php else: ?><br />
 *		\<a href="{pyro:url:site uri='users/logout'}"><br />
 *			{pyro:helper:lang line="logout_label"}<br />
 *		\</a><br />
 * <?php endif; ?><br />
 * 
 * <?php if ( '{pyro:tweet:logged_in}' ): ?><br />
 *		\<a href="{pyro:url:site uri='twitter/login'}"><br />
 *			{pyro:helper:lang line="logout_label"}<br />
 *		\</a><br />
 *	<?php else: ?><br />
 *		\<a href="{pyro:url:site uri='twitter/login'}"><br />
 *			{pyro:theme:image file='button_signin.jpg' module='twitter' alt='Twitter connect'}<br />
 *		\</a><br />
 * <?php endif; ?><br />
 * </code>
 */

/* End of file twitter.php */
