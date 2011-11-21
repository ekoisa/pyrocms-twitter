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
class Module_Twitter extends Module {
	
	/**
	 * @name version
	 * @desc based on svn repository (actualy offline)
	 * @var string
	 */
 	public $version	= '1.0.62';

 	/**
 	 * @name info
 	 * @desc en / fr only
 	 * @return multitype:string multitype:string
 	 */
	public function info()
  	{
    	return array(
    		'name' => array(
    			'en' => 'Twitter',
				'fr' => 'Twitter'
			),
		 	'description' => array(
		 		'en' => 'Twitter module.',
				'fr' => 'Twitter module'
			),
		 	'frontend'	=> TRUE,
		 	'backend'	=> FALSE,
		 	'skip_xss'	=> TRUE,
		 	'menu'		=> 'users'
		);
	}

  	public function install()
	{
		/**
		 * @var array
		 * @name settings_tw_connect
		 * @desc add an option to twitter settings, twitter_connect.
		 */
    	$settings_tw_connect = array(
    		'slug'			=> 'twitter_connect',
		    'title'			=> 'Twitter connection',
		    'description'	=> 'Would you enable twitter connection?',
		    'type'			=> 'radio',
		    'default'		=> false,
		    'value'			=> '',
		    'options'		=> '1=Enabled|0=Disabled',
		    'is_required' 	=> false,
		    'is_gui'		=> true,
		    'module'		=> 'twitter',
		    'order'			=> '975'
		);
		
		/**
		 * @var array
		 * @name settings_tw_connect_redirect
		 * @desc add an option to twitter settings, twitter_connect_redirect.
		 */
    	$settings_tw_connect_redirection = array(
    		'slug'			=> 'twitter_connect_redirection',
		    'title'			=> 'Twitter logged in redirection',
		    'description'	=> 'Where would you redirect your users after logged in?',
		    'type'			=> 'text',
		    'default'		=> false,
		    'value'			=> 'home',
		    'options'		=> '',
		    'is_required' 	=> false,
		    'is_gui'		=> true,
		    'module'		=> 'twitter',
		    'order'			=> '976'
		);
		
		/**
		 * @var array
		 * @name settings_tw_register_message
		 * @desc add an option to twitter settings, twitter_redistered_message.
		 */
    	$settings_tw_registered_message = array(
    		'slug'			=> 'twitter_registered_message',
		    'title'			=> 'Twitter registration message',
		    'description'	=> 'Filed the message posted after registration. This put the site web url at the end.',
		    'type'			=> 'text',
		    'default'		=> false,
		    'value'			=> 'I am using @OursITShow twitter connect on @PyroCMS @',
		    'options'		=> '',
		    'is_required' 	=> false,
		    'is_gui'		=> true,
		    'module'		=> 'twitter',
		    'order'			=> '977'
		);
		
    	return $this->dbforge->drop_table('twitter')
      		&& $this->db->insert('settings', $settings_tw_connect)
    		&& $this->db->insert('settings', $settings_tw_connect_redirection)
    		&& $this->db->insert('settings', $settings_tw_registered_message);
  	}

  	public function uninstall()
  	{
    	return $this->dbforge->drop_table('twitter')
      		&& $this->db->delete('settings', array('slug' => 'twitter_connect'))
      		&& $this->db->delete('settings', array('slug' => 'twitter_connect_redirection'))
      		&& $this->db->delete('settings', array('slug' => 'twitter_registered_message'));
  	}

  	public function upgrade($old_version)
  	{
  		switch ( $old_version )
  		{
  			case '1.0.62':
  			{
  				// for futher upgrade
  			}
  		}
	    return TRUE;
  	}

  	public function help()
  	{
    	return "<h2>Overview</h2><p>This module allow you to purpose to yours users a Twitter connect button.<br /></p>";
  	}
}

/* End of file details.php */
