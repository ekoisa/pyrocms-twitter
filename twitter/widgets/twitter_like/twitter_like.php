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
class Widget_Twitter_like extends Widgets {

	public $version		= '1.0';
	
	public $author		= 'Antoine Benevaut';
	public $website		= 'www.oursITshow.org';
	
	public $title		= array(
		'en' => 'Twitter like button',
		'fr' => 'Bouton Twitter like'
	);
	
	public $description	= array(
		'en' => 'Display Twitter like button.',
		'fr' => 'Affiche le bouton Twitter like.',
	);

	public $fields = array(
		array(
			'field' => 'data-via',
		    'label' => 'Twitter account name.',
			'rules' => 'required'
		),
		array(
			'field' => 'data-lang',
		    'label' => 'Langue.',
			'rules' => 'required'
		),
		array(
			'field' => 'data-url',
		    'label' => 'Choose an url.',
			'rules' => 'required'
		),
		array(
			'field' => 'data-text',
		    'label' => 'description.'
		),
		array(
			'field' => 'data-count',
		    'label' => 'mode.',
			'rules' => 'required'
		),
		array(
			'field' => 'data-related',
		    'label' => 'Other account'
		),
		array(
			'field' => 'data-related-desc',
		    'label' => 'Other account description'
		)
	);

	public function form($options)
	{
		$this->load->model('settings/settings_m');
		
	  !empty($options['data-via']) OR $options['data-via'] = $this->settings_m->get('twitter_username')->value;
	  !empty($options['data-lang']) OR $options['data-lang'] = "default";
	  !empty($options['data-url']) OR $options['data-url'] = "default";
	  !empty($options['data-text']) OR $options['data-text'] = "";
	  !empty($options['data-count']) OR $options['data-count'] = "none";
	  !empty($options['data-related']) OR $options['data-related'] = "";
	  !empty($options['data-related-desc']) OR $options['data-related-desc'] = "";

	  return array('options' => $options);
	}

	public function run($options)
	{
	  return $options;
	}
}

/* End of file twitter_like.php */
