<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

	public function index()
	{
	    $this->load->model("model_home");
	    $this->load->model("model_ilmu");
	    
	    $data['title']      = "Contact | SedekahIlmu";
	    $data['menu']       = 'contact';
	    
		$this->load->view('layout/vwHeader',$data);
		$this->load->view('layout/vwLeftBar');
		$this->load->view('page/main/vwContact');
		$this->load->view('layout/vwFooter');
	}
}
