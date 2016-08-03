<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->load->helper('general_helper');
		$this->load->library('form_validation');
	}
	
	public function index(){

	    $this->load->model("model_ilmu");
	    
	    $data['title']      = "Dengan sedekah berarti melatih keihklasan kita | Sedekahilmu.net";
	    $data['controller'] = 'Its My first Controller';
	    $data['menu']       = 'home';
	    
		$this->load->view('layout/vwHeader',$data);
		$this->load->view('layout/vwLogo');
		$this->load->view('layout/vwLeftBar');
		$this->load->view('page/main/vwIndex');
		$this->load->view('layout/vwFooter');
	}
	
	function read($pg=1){

     	$this->load->model("model_ilmu");
     	$key	= trim($this->input->post('cari',true));
		$limit	= trim($this->input->post('limit',true));
		$offset = ($limit*$pg)-$limit;
		$like	= '';
		$where	= "(statuspublish_id = 1 AND ilmustatus_id = 1)";
		
		if($key) $like = "(judul LIKE '%$key%')";
		
		$page 	= array();
        $page['limit'] 		= $limit;
        $page['count_row'] 	= $this->model_ilmu->getCount($where, $like);
        $page['current'] 	= $pg;
        $page['list'] 		= gen_paging($page);

        $data['paging'] = $page;
		$data['key']	= $key;
		$data['list']	= $this->model_ilmu->getAll($where, $like,  $limit, $offset);
		
		$this->load->view('page/main/vwListIlmu',$data);
	     
	}
	
	function read_a($pg=1){

     	$this->load->model("model_ilmu");
     	$key	= trim($this->input->post('cari',true));
		$limit	= trim($this->input->post('limit',true));
		$author	= trim($this->input->post('author',true));
		$offset = ($limit*$pg)-$limit;
		$like	= '';
		$where	= "((statuspublish_id = 1 AND ilmustatus_id = 1) AND user_id = '$author')";
		
		if($key) $like = "(judul LIKE '%$key%')";
		
		$page 	= array();
        $page['limit'] 		= $limit;
        $page['count_row'] 	= $this->model_ilmu->getCount($where, $like);
        $page['current'] 	= $pg;
        $page['list'] 		= gen_paging($page);

        $data['paging'] = $page;
		$data['key']	= $key;
		$data['list']	= $this->model_ilmu->getAll($where, $like,  $limit, $offset);
		
		$this->load->view('page/main/vwListIlmu',$data);
	     
	}
	
	function read_author($pg=1){

     	$key	= trim($this->input->post('cari',true));
		$limit	= trim($this->input->post('limit',true));
		$offset = ($limit*$pg)-$limit;
		$like	= '';
		$where	= "(userstatus_id = 1)";
		
		if($key) $where = "(nama LIKE '%$key%')";
		
		$page 	= array();
        $page['limit'] 		= $limit;
        $page['count_row'] 	= $this->model_users->getCount($where, $like);
        $page['current'] 	= $pg;
        $page['list'] 		= gen_paging($page);

        $data['paging'] = $page;
		$data['key']	= $key;
		$data['list']	= $this->model_users->getAll($where, $like,  $limit, $offset);
		
		$this->load->view('page/sedekahilmu/author/vwListAuthor',$data);
	     
	}
	
	function read_($pg=1){

     	$this->load->model("model_ilmu");
     	$key	= trim($this->input->post('cari',true));
		$limit	= trim($this->input->post('limit',true));
		$tag	= trim($this->input->post('tag',true));
		
		$ilmu	= array();
		
		$tag	= $this->model_ilmu->getIdIlmuByIdKategori(array("kategoriilmu_id" => $tag ));
		
		foreach($tag->result() as $row){
			array_push($ilmu,$row->ilmu_id);
		}
		
		$ilmu	= implode(",",$ilmu);
		
		$offset = ($limit*$pg)-$limit;
		$like	= '';
		$where	= "((statuspublish_id = 1 AND ilmustatus_id = 1) AND ilmu_id IN ($ilmu) )";
		
		if($key) $like = "(judul LIKE '%$key%')";
		
		$page 	= array();
        $page['limit'] 		= $limit;
        $page['count_row'] 	= $this->model_ilmu->getCount($where, $like);
        $page['current'] 	= $pg;
        $page['list'] 		= gen_paging($page);

        $data['paging'] = $page;
		$data['key']	= $key;
		$data['list']	= $this->model_ilmu->getAll($where, $like,  $limit, $offset);
		
		$this->load->view('page/main/vwListIlmu',$data);
	     
	}
	
	function signup_subscribe(){
		if(!isset($_POST['simpan'])){
			echo "<h3 style='color:red;font-weight:bold;'>Forbiden Access</h3>";
		}else{
			$this->load->model("Model_sibscribe");
			
			$this->form_validation->set_rules("email_s", "Email", "trim|required|valid_email");
			$this->form_validation->set_rules("nama_s", "Email", "trim|required");

			$email		= addslashes($this->input->post('email_s',true));
			$nama		= addslashes($this->input->post('nama_s',true));
			$user_id	= addslashes($this->input->post('user_id',true));
			$url		= addslashes($this->input->post('url',true));
			$rs			= '';
			
			$cekemail	= $this->Model_sibscribe->getAll(array("email" => $email, "user_id" => $user_id));
			
			if($user_id != 0){
				$rs = 2;
			}else{
				$rs = 1;
			}
			
			if(!$cekemail){
				if($this->form_validation->run() == false ){
					$rs = array(
						'alert' => 'alert-danger',
						'rs'	=> $rs,
						'msg'	=> '<b><i class="glyphicon glyphicon-remove"></i> Please fill data correctly...</b>' 
					);
					
					$this->session->set_flashdata($rs);
					redirect($url,"refresh");
				}else{
					
					$data	= array(
						'subscriber_nm'	=> $nama,
						'email'		=> $email,
						'user_id'	=> $user_id
					);
					
					$insert	= $this->Model_sibscribe->getInsert($data);
					
					if($insert){
						$rs = array(
							'alert' => 'alert-success',
							'rs'	=> $rs,
							'msg'	=> '<b><i class="glyphicon glyphicon-ok"></i> Success...</b>' 
						);
						
						$this->session->set_flashdata($rs);
						redirect($url,"refresh");
					}else{
						$rs = array(
							'alert' => 'alert-danger',
							'rs'	=> $rs,
							'msg'	=> '<b><i class="glyphicon glyphicon-remove"></i> Failed...</b>' 
						);
						
						$this->session->set_flashdata($rs);
						redirect($url,"refresh");
					}
					
				}
			}else{
				
				$rs = array(
					'alert' => 'alert-danger',
					'rs'	=> $rs,
					'msg'	=> '<b><i class="glyphicon glyphicon-remove"></i> Your email has registered for this...</b>' 
				);
				
				$this->session->set_flashdata($rs);
				redirect($url,"refresh");
			}
		}
	}
}
