<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function index()
	{
	    $this->load->model("model_home");
	    $this->load->model("model_ilmu");
	    
	    $data['title']      = "Profile | SedekahIlmu";
	    $data['menu']       = 'profile';
	    
		$this->load->view('layout/vwHeader',$data);
		$this->load->view('layout/vwLeftBar');
		$this->load->view('page/main/vwProfile');
		$this->load->view('layout/vwFooter');
	}
}
