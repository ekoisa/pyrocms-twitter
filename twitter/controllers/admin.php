<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$datas = array();
		
		$this->template
			->title("Twitter")
			->build('admin/index', array('db' => $datas));
	}
}