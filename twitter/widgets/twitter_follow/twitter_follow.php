<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Twitter widgets
 * 
 * @author Antoine Benevaut
 * 
 * @package		OursITShow
 * @subpackage  Users
 * @category  	Widgets
 *
 */
class Widget_Twitter_follow extends Widgets {

	/**
	 * @name version
	 * @desc based on svn repository (actualy offline)
	 * @var string
	 */
	public $version		= '1.0';
	
	public $author		= 'Antoine Benevaut';
	public $website		= 'www.oursITshow.org';
	
	/**
 	 * @name title
 	 * @desc en / fr only
 	 * @var multitype:string
 	 */
	public $title		= array(
		'en' => 'Twitter follow button',
		'fr' => 'Bouton Twitter suivre'
	);
	
	public $description	= array(
		'en' => 'Display Twitter follow button.',
		'fr' => 'Affiche le bouton Twitter suivre.',
	);
	
	public $fields		= array(
		array(
			'field' => 'data-name',
		    'label' => 'Twitter account name.',
			'rules' => 'required'
		),
		array(
			'field' => 'data-button',
		    'label' => 'Button color.'
		),
		array(
		    'field' => 'data-text-color',
		    'label' => 'Button color.',
			'rules' => 'max_length[6]'
		),
		array(
		    'field' => 'data-link-color',
		    'label' => 'Link color.',
			'rules' => 'max_length[6]'
		),
		array(
		    'field' => 'data-width',
		    'label' => 'width.'
		),
		array(
		    'field' => 'data-align',
		    'label' => 'Align'
		),
		array(
		    'field' => 'data-show-count',
		    'label' => 'Display number of followers'
		)
	);

	public function form($options)
	{
		$this->load->model('settings/settings_m');
		
	  	!empty($options['data-name']) OR $options['data-name'] = $this->settings_m->get('twitter_username')->value;
	  	!empty($options['data-button']) OR $options['data-button'] = "white";
	  	!empty($options['data-text-color']) OR $options['data-text-color'] = "FFFFFF";
	  	!empty($options['data-link-color']) OR $options['data-link-color'] = "00AEFF";
	  	!empty($options['data-width']) OR $options['data-width'] = "100%";
	  	!empty($options['data-align']) OR $options['data-align'] = "right";
	  	!empty($options['data-show-count']) OR $options['data-show-count'] = "false";
	  	
	  return array('options' => $options);
	}

	public function run($options)
	{
	  return $options;
	}
}

/* End of file twitter_follow.php */
