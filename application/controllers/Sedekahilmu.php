<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sedekahilmu extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->load->helper('general_helper');
		$this->load->library('form_validation');
		$this->load->model("model_users");
		$this->load->model("model_ilmu");
	}
	
	public function index(){
		 if(!$this->session->userdata('logginUser')){
	     	 redirect('users/signin','refresh');
	     }else{
	     	 $data['title']      = "Dashboard | SedekahIlmu";
		     $data['menu']       = 'dashboard';
		    
		     $this->load->view('layout/vwHeader',$data);
		     $this->load->view('layout/vwLeftBar');
		     $this->load->view('page/user/vwIndex');
			 $this->load->view('layout/vwFooter');
	     }
	}
	
	function all(){
		 $data['title']      = "Sedekah Ilmu | SedekahIlmu";
	     $data['menu']       = 'navsedekahilmu';
	    
	     $this->load->view('layout/vwHeader',$data);
	     $this->load->view('layout/vwLeftBar');
	     $this->load->view('page/sedekahilmu/vwAll');
		 $this->load->view('layout/vwFooter');
	}
	
	function read($pg=1){
		 if(!$this->session->userdata('logginUser')){
	     	 redirect('users/signin','refresh');
	     }else{
	     	
	     	$key	= trim($this->input->post('cari',true));
			$limit	= trim($this->input->post('limit',true));
			$user_id= $this->session->userdata('user_id');
			$offset = ($limit*$pg)-$limit;
			$like	= '';
			$where	= "(user_id = '$user_id')";
			
			if($key) $like = "(judul LIKE '%$key%')";
			
			$page 	= array();
	        $page['limit'] 		= $limit;
	        $page['count_row'] 	= $this->model_ilmu->getCount($where, $like);
	        $page['current'] 	= $pg;
	        $page['list'] 		= gen_paging($page);
	
	        $data['paging'] = $page;
			$data['key']	= $key;
			$data['list']	= $this->model_ilmu->getAll($where, $like,  $limit, $offset);
			
			$this->load->view('page/user/sedekah/vwList',$data);
	     }
	}
	
	function simpan_sedekah(){
		
		if(!isset($_POST['simpan'])){
			echo "<h3 style='color:red;font-weight:bold;'>Forbiden Access</h3>";
		}else{

			$this->form_validation->set_rules("statuspublish_id", "Statuspublish_id", "trim|required");
			$this->form_validation->set_rules("judul", "Judul", "trim|required");
			$this->form_validation->set_rules("deskripsi", "Deskripsi", "trim");
			
			$statuspublish_id		= addslashes($this->input->post('statuspublish_id',true));
			$judul		= addslashes($this->input->post('judul',true));
			$deskripsi	= $this->input->post('deskripsi',true);
			$kategori_ilmu	= $this->input->post('kategoriilmu_id',true);
			$image		= '';
			$thumbnail	= '';
			
			if($this->form_validation->run() == false ){
				$rs = array(
					'alert' => 'alert-danger',
					'rs'	=> 1,
					'msg'	=> '<b><i class="glyphicon glyphicon-remove"></i> Please fill data correctly...</b>' 
				);
				
				$this->session->set_flashdata($rs);
				redirect("users/sedekah/add","refresh");
			}else{
					
				$this->load->helper('file');
				$config['upload_path'] = './uploads/image/ilmu/';
				$config['allowed_types'] =  'jpg|png|jpeg';
				$config['max_size'] = '5120';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				
				if($this->upload->do_upload('upload-image')){
					$file = $this->upload->data();
					
					$image = 'uploads/image/ilmu/'.$file['file_name'];
					
					$config['image_library'] 	= 'gd2';
					$config['source_image'] 	= $file['full_path'];
					$config['create_thumb'] 	= TRUE;
					$config['maintain_ratio'] 	= TRUE;
					$config['width'] 			= 300;
					$config['height'] 			= 300;
					$config['new_image'] 		= './uploads/thumbnail/ilmu/';
	
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
					$thumbnail = 'uploads/thumbnail/ilmu/'.$file['raw_name'].'_thumb'.$file['file_ext'];
					$this->image_lib->clear();
					

				} else {
					$type = get_mime_by_extension($_FILES['upload-image']['name']);
					
					if(($type != 'image/jpeg' || $type != 'image/png' || $type != 'image/gif') && $_FILES['upload-image']['size'] > $config['max_size']) {
						$error = $this->upload->display_errors();
						$rs = array(
							'alert' => 'alert-danger',
							'rs'	=> 1,
							'msg'	=> $error
						);
						
						$this->session->set_flashdata($rs);
						redirect("users/sedekah/add","refresh");
					}
				}
			}
			
			$insert = array(
				'judul' => $judul,
				'user_id'	=> $this->session->userdata("user_id"),
				'deskripsi' => $deskripsi,
				'thumbnail'	=> $thumbnail,
				'gambar'	=> $image,
				'statuspublish_id'	=> $statuspublish_id,
				'ilmustatus_id'	=> 1,
				'url_ilmu'	=> slug($judul)
			);
			
			$wh = array(
				'judul' => $judul,
				'user_id'	=> $this->session->userdata("user_id"),
				'url_ilmu'	=> slug($judul)
			);
			
			$this->db->trans_begin();
			
			$this->model_ilmu->getInsert($insert);
			
			$ilmu	= $this->model_ilmu->getAll($wh)->row_array();
			
			for($i=0; $i<count($kategori_ilmu); $i++){
				
				$this->model_ilmu->getInsertKategoriDetail(array("ilmu_id" => $ilmu['ilmu_id'], "kategoriilmu_id" => $kategori_ilmu[$i]));
				
			}
			
			
			if($this->db->trans_status() === true){
				$this->db->trans_commit();
				$rs = array(
					'alert' => 'alert-success',
					'rs'	=> 1,
					'msg'	=> '<b><i class="glyphicon glyphicon-ok"></i> Success...</b>' 
				);
				
				$this->session->set_flashdata($rs);
				redirect("users/sedekah/add","refresh");
			}else{
				$this->db->trans_rollback();
				$rs = array(
					'alert' => 'alert-danger',
					'rs'	=> 1,
					'msg'	=> '<b><i class="glyphicon glyphicon-remove"></i> Failed...</b>' 
				);
				
				$this->session->set_flashdata($rs);
				redirect("users/sedekah/add","refresh");
			}
		}
	}
	
	function id($ilmu_id='', $url=''){
		
		if($ilmu_id == '' OR $url == ''){
			$this->load->view('pageNotFound');
		}else{
			$this->load->model('model_users');
			$ilmu_id	= addslashes(trim($ilmu_id));
			$url		= addslashes(trim($url));
			
			$where	= array(
				'url_ilmu'	=> $url,
				'ilmu_id'	=> $ilmu_id,
				'statuspublish_id'	=> 1,
				'ilmustatus_id'	=> 1
			);
			
			$cek	= $this->model_ilmu->getAll($where)->row_array();
			
			if($cek){
				 
				 $view	= ((int) $cek['viewer']) + 1 ;
				 
				 $this->model_ilmu->getUpdate(array("viewer" => $view ), $ilmu_id);
				 
				 $ktgr	= $this->model_ilmu->getIdKatByIdIlmu(array("ilmu_id" => $ilmu_id));
				 $kategori	= array();
				 
				 
				 foreach($ktgr->result() as $row){
				 	array_push($kategori,$row->kategoriilmu_id);
				 }
				 
				 $ktgr	= implode(",",$kategori);
				 
				 $kategori_ilmu		= $this->model_kategori_ilmu->getAll("kategoriilmu_id IN ($ktgr)");
				 
				 //ambil other ilmu
				 $other		= array();
				 $other_id_ilmu	= $this->model_ilmu->getIdKatByIdIlmu("kategoriilmu_id IN ($ktgr)");
				 foreach($other_id_ilmu->result() as $row){
				 	array_push($other,$row->ilmu_id);
				 }
				 $other	 = implode(",",$other);
				 $others = $this->model_ilmu->getIlmuTerkait("ilmu_id IN ($other)");
				 
				 $us	= $this->model_users->getAll(array("user_id" => $cek['user_id']))->row_array();
				 //meta
				$data['meta_judul'] = $cek['judul']." - By ".$us['nama']."| sedekahilmu.net";
				$data['meta_deskripsi'] = substr(strip_tags($cek['deskripsi']),0,150);
				$data['meta_image'] = $cek['gambar'];
				$data['meta_url'] = base_url('sedekahilmu/id/'.$cek['ilmu_id'].'/'.$cek['url_ilmu']);
				 
			 	 $data['title']     = $cek['judul']." | SedekahIlmu";
			     	$data['menu']      = 'navsedekahilmu';
			     $data['ilmu']		= $cek;
			     $data['tags']		= $kategori_ilmu;
			     $data['other']		= $others;
			     
			     
			     $this->load->view('layout/vwHeader',$data);
			     $this->load->view('layout/vwLeftBar');
			     $this->load->view('page/sedekahilmu/vwDetail');
				 $this->load->view('layout/vwFooter');
				
				
			}else{
				$this->load->view('pageNotFound');
			}
		}
	}
	
	function ubah_sedekah(){
		
		if(!isset($_POST['simpan'])){
			echo "<h3 style='color:red;font-weight:bold;'>Forbiden Access</h3>";
		}else{

			$this->form_validation->set_rules("statuspublish_id", "Statuspublish_id", "trim|required");
			$this->form_validation->set_rules("judul", "Judul", "trim|required");
			$this->form_validation->set_rules("deskripsi", "Deskripsi", "trim");
			
			$statuspublish_id		= addslashes($this->input->post('statuspublish_id',true));
			$judul		= addslashes($this->input->post('judul',true));
			$ilmu_id	= addslashes($this->input->post('ilmu_id',true));
			$deskripsi	= $this->input->post('deskripsi',true);
			$kategori_ilmu	= $this->input->post('kategoriilmu_id',true);
			$url_thumb	= addslashes($this->input->post('url_thumb',true));
			$url_gambar	= addslashes($this->input->post('url_gambar',true));
			
			$image		= '';
			$thumbnail	= '';
			
			if($this->form_validation->run() == false ){
				$rs = array(
					'alert' => 'alert-danger',
					'rs'	=> 1,
					'msg'	=> '<b><i class="glyphicon glyphicon-remove"></i> Please fill data correctly...</b>' 
				);
				
				$this->session->set_flashdata($rs);
				redirect("users/sedekah/edit/".$ilmu_id,"refresh");
			}else{
					
				$this->load->helper('file');
				$config['upload_path'] = './uploads/image/ilmu/';
				$config['allowed_types'] =  'jpg|png|jpeg';
				$config['max_size'] = '5120';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				
				if($this->upload->do_upload('upload-image')){
					$file = $this->upload->data();
					
					$image = 'uploads/image/ilmu/'.$file['file_name'];
					
					$config['image_library'] 	= 'gd2';
					$config['source_image'] 	= $file['full_path'];
					$config['create_thumb'] 	= TRUE;
					$config['maintain_ratio'] 	= TRUE;
					$config['width'] 			= 300;
					$config['height'] 			= 300;
					$config['new_image'] 		= './uploads/thumbnail/ilmu/';
	
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
					$thumbnail = 'uploads/thumbnail/ilmu/'.$file['raw_name'].'_thumb'.$file['file_ext'];
					$this->image_lib->clear();
					

				} else {
					$type = get_mime_by_extension($_FILES['upload-image']['name']);
					
					if(($type != 'image/jpeg' || $type != 'image/png' || $type != 'image/gif') && $_FILES['upload-image']['size'] > $config['max_size']) {
						$error = $this->upload->display_errors();
						$rs = array(
							'alert' => 'alert-danger',
							'rs'	=> 1,
							'msg'	=> $error
						);
						
						$this->session->set_flashdata($rs);
						redirect("users/sedekah/edit/".$ilmu_id,"refresh");
					}
				}
			}
			
			if($image){
				
				$image = $image;
				$thumbnail	= $thumbnail;
				
				unlink(FCPATH.$url_gambar);
				unlink(FCPATH.$url_thumb);
				
			}else{
				
				$image = $url_gambar;
				$thumbnail	= $url_thumb;
				
			}
			
			$update = array(
				'judul' => $judul,
				'deskripsi' => $deskripsi,
				'thumbnail'	=> $thumbnail,
				'gambar'	=> $image,
				'statuspublish_id'	=> $statuspublish_id,
				'url_ilmu'	=> slug($judul)
			);
			
			$this->db->trans_begin();
			
			$this->model_ilmu->getUpdate($update,$ilmu_id);
			
			$this->model_ilmu->getDeleteKatDetail(array("ilmu_id" => $ilmu_id));
			
			for($i=0; $i<count($kategori_ilmu); $i++){
				
				$this->model_ilmu->getInsertKategoriDetail(array("ilmu_id" => $ilmu_id, "kategoriilmu_id" => $kategori_ilmu[$i]));
				
			}
			
			
			if($this->db->trans_status() === true){
				$this->db->trans_commit();
				$rs = array(
					'alert' => 'alert-success',
					'rs'	=> 1,
					'msg'	=> '<b><i class="glyphicon glyphicon-ok"></i> Edit is Success...</b>' 
				);
				
				$this->session->set_flashdata($rs);
				redirect("users/sedekah/edit/".$ilmu_id,"refresh");
			}else{
				$this->db->trans_rollback();
				$rs = array(
					'alert' => 'alert-danger',
					'rs'	=> 1,
					'msg'	=> '<b><i class="glyphicon glyphicon-remove"></i> Edit is Failed...</b>' 
				);
				
				$this->session->set_flashdata($rs);
				redirect("users/sedekah/edit/".$ilmu_id,"refresh");
			}
		}
	}
	
	//tags
	function tags($tags=''){
		
		if($tags == ''){
			$data['title']      = "Tags | SedekahIlmu";
		    $data['menu']       = 'tags';
		    
			$this->load->view('layout/vwHeader',$data);
			$this->load->view('layout/vwLeftBar');
			$this->load->view('page/tags/vwAllTags');
			$this->load->view('layout/vwFooter');
		}else{
			
			$query = $this->model_kategori_ilmu->getAll(array("kategoriilmu_url" => $tags))->row_array();
			
			if($query){
				$data['title']      = "Tags ".$query['kategoriilmu_nm']." | SedekahIlmu";
			    $data['menu']       = 'tags';
			    $data['tags']       = $query;
			    
				$this->load->view('layout/vwHeader',$data);
				$this->load->view('layout/vwLeftBar');
				$this->load->view('page/sedekahilmu/vwIndex');
				$this->load->view('layout/vwFooter');
			}else{
				$this->load->view('pageNotFound');
			}
				
		}
	}
	
	function author($user_id='', $slug=''){
		
		if($user_id=='' || $slug==''){
			$data['title']      = "Author | SedekahIlmu";
		    $data['menu']       = 'author';
		    $data['author']       = $this->model_users->getAll(array("userstatus_id" => 1));
		    
			$this->load->view('layout/vwHeader',$data);
			$this->load->view('layout/vwLeftBar');
			$this->load->view('page/sedekahilmu/author/vwAll');
			$this->load->view('layout/vwFooter');
		}else{
			
			$cek	= $this->model_users->getAll(array("user_id" => $user_id,"userstatus_id" => 1))->row_array();
			
			if($cek){
				
				if(slug($cek['nama']) == $slug){
					
					$data['title']      = "Author - ".$cek['nama']." | SedekahIlmu";
				    $data['menu']       = 'author';
				    $data['author']       = $cek;
				    
					$this->load->view('layout/vwHeader',$data);
					$this->load->view('layout/vwLeftBar');
					$this->load->view('page/sedekahilmu/author/vwIndex');
					$this->load->view('layout/vwFooter');
					
					
				}else{
					$this->load->view('pageNotFound');
				}
			}else{
				$this->load->view('pageNotFound');
			}
		}
		
	}
	
	function read_semuailmu($pg=1){
		if(!$this->session->userdata('logginUser')){
	     	 redirect('users/signin','refresh');
	     }else{
	     	
	     	$key	= trim($this->input->post('cari',true));
			$limit	= trim($this->input->post('limit',true));
			$user_id= $this->session->userdata('user_id');
			$offset = ($limit*$pg)-$limit;
			$like	= '';
			$where	= "";
			
			if($key) $like = "(judul LIKE '%$key%')";
			
			$page 	= array();
	        $page['limit'] 		= $limit;
	        $page['count_row'] 	= $this->model_ilmu->getCount($where, $like);
	        $page['current'] 	= $pg;
	        $page['list'] 		= gen_paging($page);
	
	        $data['paging'] = $page;
			$data['key']	= $key;
			$data['list']	= $this->model_ilmu->getAll($where, $like,  $limit, $offset);
			
			$this->load->view('page/user/semuailmu/vwList',$data);
	     }
	}
	
	function ubah_status_sedekah(){
		if(!isset($_POST['simpan'])){
			echo "<h3 style='color:red;font-weight:bold;'>Forbiden Access</h3>";
		}else{

			$this->form_validation->set_rules("ilmustatus_id", "Status Ilmu", "trim|required");
			

			$ilmu_id		= addslashes($this->input->post('ilmu_id',true));
			$ilmustatus_id	= $this->input->post('ilmustatus_id',true);

			
			if($this->form_validation->run() == false ){
				$rs = array(
					'alert' => 'alert-danger',
					'rs'	=> 1,
					'msg'	=> '<b><i class="glyphicon glyphicon-remove"></i> Please fill data correctly...</b>' 
				);
				
				$this->session->set_flashdata($rs);
				redirect("users/semuailmu/edit/".$ilmu_id,"refresh");
			}else{
					
				$update = array(
					'ilmustatus_id' => $ilmustatus_id
				);
				
				$this->db->trans_begin();
				
				$this->model_ilmu->getUpdate($update,$ilmu_id);
				
				
				if($this->db->trans_status() === true){
					$this->db->trans_commit();
					$rs = array(
						'alert' => 'alert-success',
						'rs'	=> 1,
						'msg'	=> '<b><i class="glyphicon glyphicon-ok"></i> Edit is Success...</b>' 
					);
					
					$this->session->set_flashdata($rs);
					redirect("users/semuailmu/edit/".$ilmu_id,"refresh");
				}else{
					$this->db->trans_rollback();
					$rs = array(
						'alert' => 'alert-danger',
						'rs'	=> 1,
						'msg'	=> '<b><i class="glyphicon glyphicon-remove"></i> Edit is Failed...</b>' 
					);
					
					$this->session->set_flashdata($rs);
					redirect("users/semuailmu/edit/".$ilmu_id,"refresh");
				}
			}
		}
	}
}
