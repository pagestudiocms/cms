<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Filemanager extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();	
	}
	
	/**
     * Index
     *
     * Display entries and apply any search filters

     * @return void
     */
	public function index()
	{
        $data = array();
        $data['breadcrumb'] = set_crumbs(array(current_url() => 'File Manager'));
		
		$this->template->view('admin/index', $data);
	}
}