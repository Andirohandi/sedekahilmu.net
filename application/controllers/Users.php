<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->load->helper('general_helper');
		$this->load->library('form_validation');
		$this->load->model("model_ilmu");
	}
	
	public function index(){
		 if(!$this->session->userdata('logginUser')){
	     	 redirect('users/signin','refresh');
	     }else{
	     	
	     	if($this->session->userdata('userstatus_id') == 3){
	     		redirect("users/verifikasi","refresh");
	     	}else if($this->session->userdata('userstatus_id') == 1){
	     		 $data['title']      = "Dashboard | SedekahIlmu";
			     $data['menu']       = 'dashboard';
			     $data['dashboard']	 = '1';
			    
			     $this->load->view('layout/vwHeader',$data);
			     $this->load->view('layout/vwLeftBar');
			     $this->load->view('page/user/vwIndex');
				 $this->load->view('layout/vwFooter');
	     	}else{
	     		$this->load->view("pageNotFound");
	     	}
	     }
	}
	
	
	function verifikasi(){
		  if(!$this->session->userdata('logginUser')){
	     	 redirect('users','refresh');
	     }else{
	     	
	     	if($this->session->userdata('userstatus_id') == 1){
	     		redirect("users","refresh");
	     	}else{
	     		 $data['title']      = "User Verfication | SedekahIlmu";
			     $data['menu']       = 'dashboard';
			     $data['dashboard']	 = '1';
			    
			     $this->load->view('layout/vwHeader',$data);
			     $this->load->view('page/user/vwVerification');
	     	}
	     }
	}
	
	//signup user
	function signup(){
	     
	     if($this->session->userdata('logginUser')){
	     	 redirect('users','refresh');
	     }else{
	     	 $data['title']      = "Sign Up | SedekahIlmu";
		     $data['menu']       = 'signup';
		    
		     $this->load->view('layout/vwHeader',$data);
		     $this->load->view('layout/vwLeftBar');
		     $this->load->view('page/user/vwRegistrasi');
			 $this->load->view('layout/vwFooter');
	     }
	}
	
	function daftarUser(){
		
		if(!isset($_POST['daftar'])){
			echo "<h3 style='color:red;font-weight:bold;'>Forbiden Access</h3>";
		}else{
			
			$this->form_validation->set_rules("nama", "Username", "required|trim");
			$this->form_validation->set_rules("password", "Password", "required|trim");
			$this->form_validation->set_rules("email", "Email", "required|trim|valid_email");
			
			$nama		= addslashes($this->input->post('nama',true));
			$password	= addslashes($this->input->post('password',true));
			$email		= addslashes($this->input->post('email',true));
			
			if($this->form_validation->run() == false ){
				$rs = array(
					'alert' => 'alert-danger',
					'rs'	=> 1,
					'msg'	=> '<b><i class="glyphicon glyphicon-remove"></i> Please fill data correctly...</b>'
				);
				
				$this->session->set_flashdata($rs);
				redirect("users/signup","refresh");
			}else{
				
				$cek	= $this->model_users->getAll(array("email" => $email))->row_array();
				
				if($cek){
					$rs = array(
						'alert' => 'alert-danger',
						'rs'	=> 1,
						'msg'	=> '<b><i class="glyphicon glyphicon-remove"></i> Sorry, your email has been registered. Please input other email..</b>'
					);
					
					$this->session->set_flashdata($rs);
					redirect("users/signup","refresh");
				}else{
					$password	= password_hash($password, PASSWORD_BCRYPT);
				
					$data	= array(
						'nama'		=> $nama,
						'password'	=> $password,
						'email'		=> $email,
						'userlevel_id' => 2,
						'userstatus_id' => 3
					);
					
					$config['email']= $email;
					$config['nama']	= $nama;
					$denmail		= $this->sendmail($config);
					
					if($denmail == true){
						
						$query = $this->model_users->getInsert($data);
						
						if($query){
							
							$where		= array(
								'email'	=> $email,
								'nama'	=> $nama,
								'userlevel_id' => 2
							);
							
							$getUser	= $this->model_users->getAll($where)->row_array();
							
							$rs = array(
								'alert' => 'alert-success',
								'rs'	=> 1,
								'msg'	=> ' '
							);
							
							$data_session	= array(
									'user_id'	=> $getUser['user_id'],
									'logginUser'=> true,
									'userstatus_id' => 3,
									'nama'		=> $nama,
									'email'	=> $email
							);
							
							$this->session->set_userdata($data_session);
							$this->session->set_flashdata($rs);
							
							redirect("users","refresh");
						}else{
							$rs = array(
								'alert' => 'alert-danger',
								'rs'	=> 1,
								'msg'	=> '<b><i class="glyphicon glyphicon-remove"></i> Registration is failed..</b>'
							);
							
							$this->session->set_flashdata($rs);
							redirect("users/signup","refresh");
						}
					}
				}
			}
		}
	}
	
	//sendmail
	function sendmail($data=array()){
		
		
	    $msg  = '';
		//$msg  .= '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">';
		$msg  .= '<div class="container">';
		$msg  .= '<div class="row">';
		$msg  .= '<div class="col-md-12">';
	    $msg  .= "<h4 class='page-title'> Hi, ".$data['nama']."</h4>";
	    $msg  .= "<p>Anda baru saja mendaftar di <a href='http://sedekahilmu.net'>Sedekah Ilmu</a>. Untuk menyelesaikan pendaftaran di <a href='http://sedekahilmu.net'>Sedekah Ilmu</a>, harap konfirmasikan akun anda.</p><br/>";
		$msg  .= "<a href=".site_url('users/confirm/'.encode($data['email']))." style='background-color:#3A5795;color:white;font-weight:bold;padding:10px;border-radius:5px;text-decoration:none;' > Konfirmasi Akun Anda</a>";
		$msg  .= "<br/><br/><p>Jika tombol di atas tidak berfungsi, salin tautan berikut dan masukkan ke peramban web Anda: </p>";
		$msg  .= "<div class='well' style='background-color:#D2D6DE;width:800px;padding:15px;border-radius:5px;'>";
	    $msg  .= "<a href=".site_url('users/confirm/'.encode($data['email'])).">".site_url('users/confirm/'.encode($data['email']))."</a>";
		$msg  .= "</div>";
	    $msg  .= "<br/><br/>Salam Bahagia,";
	    $msg  .= "<br/> Admin Sedekah Ilmu<br/><br/>";
	    $msg  .= "<blockquote>";
	    $msg  .= "<small><b><i>E-mail ini dikirim secara otomatis oleh Rumah Komunitas. Mohon tidak mengirimkan balasan ke e-mail ini.</i></b></small>";
		$msg  .= "</blockquote>";
		$msg  .= "</div>";
		$msg  .= "</div>";
		$msg  .= "</div>";
	    
	    //$this->load->library('email');
	   	$CI = get_instance();
		$CI->load->library('email');
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = ''; //change this, coba aja pake smtp google, or googling aja cara ngisinya ya :D
		$config['smtp_port'] = ''; // change this
		$config['smtp_user'] = ''; //change this
		$config['smtp_pass'] = ''; //change this
		$config['mailtype'] = 'html';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['newline'] = "\r\n";
		$config['crlf'] = "\r\n";
		//$config['newline'] = "\r\n"; //use double quotes to comply with RFC 822 standard
		
		$CI->email->initialize($config);
		
	    $this->email->from('noreply@sedekahilmu.net', 'Sedekah Ilmu');
	    $this->email->to($data['email']);
	    $this->email->subject('Verifikasi Akun Sedekah Ilmu');
	    $this->email->message($msg);
	   
	    if ($this->email->send())
	        return true;
	    else
	        return false;
	}
	
	//konfirmasi dari email
	function confirm($email=""){
		if($email == ''){
			$this->load->view("pageNotFound");
		}else{
			$email	= decode($email);
			
			$get	=  $this->model_users->getAll(array("email" => $email))->row_array();

			if($get['userstatus_id'] == 3){
				
				$update = $this->model_users->getUpdate(array("userstatus_id" => 1), $get['user_id']);
				
				
				if($update){
					
					$getUser=  $this->model_users->getAll(array("user_id" => $get['user_id']))->row_array();
					
					$data_session	= array(
							'user_id'	=> $getUser['user_id'],
							'logginUser'=> true,
							'level_id'	=> $getUser['userlevel_id'],
							'userstatus_id' => $getUser['userstatus_id']
					);
					
					$rs = array(
						'alert' => 'alert-success',
						'rs'	=> 1,
						'msg'	=> 'Selamat datang di <b>Sedekah ilmu</b>, semoga hari anda menyenangkan.. '
					);
					
					$this->session->set_flashdata($rs);		
					$this->session->set_userdata($data_session);
					
					redirect("users","refresh");
				}else{
					echo "<h4 style='color:red'>Sorry.. system error..</h4>";
				}
			}else{
			
				$this->load->view("pageNotFound");
			}
		}
	}
	
	function cekEmailRegistrasi(){
		$email	= addslashes($this->input->post("x",true));
		
		$query	= $this->model_users->getAll(array("email" => $email))->row_array();
		
		if($query){
			$data = array(
				"rs" => 1,
				"msg" => "<span style='color:red;font-size:12px'>Sorry, this Email has registered. Please Fill other email to registerhtml</span>"
			);
		}else{
			$data = array(
				"rs" => 2,
				"msg" => ""
			);
		}
		
		echo json_encode($data);
		
	}
	
	//signin user
	function signin(){
	     if($this->session->userdata('logginUser')){
	     	 redirect('users','refresh');
	     }else{
	     	
		     $data['title']      = "Sign In | SedekahIlmu";
		     $data['menu']       = 'signin';
		    
		     $this->load->view('layout/vwHeader',$data);
		     $this->load->view('layout/vwLeftBar');
		     $this->load->view('page/user/vwSignIn');
			 $this->load->view('layout/vwFooter');
	     }
	}
	
	function cek(){
		$CI = get_instance();
		$CI->load->library('email');
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'mail.abdibahagia.co.id'; //change this
		$config['smtp_port'] = '587';
		$config['smtp_user'] = 'andirohandi@abdibahagia.co.id'; //change this
		$config['smtp_pass'] = 'merahputih45'; //change this
		$config['mailtype'] = 'html';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['newline'] = "\r\n";
		$config['crlf'] = "\r\n";
		//$config['newline'] = "\r\n"; //use double quotes to comply with RFC 822 standard
		
		$CI->email->initialize($config);
		
		$this->email->from('noreply@sedekahilmu.net', 'Sedekah Ilmu');
		    $this->email->to('andirohandi.abdibahagia@gmail.com');
		    $this->email->subject('Verifikasi Akun Sedekah Ilmu');
		    $this->email->message('test');
		   

	}
	
	function signInUser(){
			if(!isset($_POST['signin'])){
			echo "<h3 style='color:red;font-weight:bold;'>Forbiden Access</h3>";
		}else{
			
			$this->form_validation->set_rules("password", "Password", "required|trim");
			$this->form_validation->set_rules("email", "Email", "required|trim|valid_email");
			
			$password	= addslashes($this->input->post('password',true));
			$email		= addslashes($this->input->post('email',true));
			
			if($this->form_validation->run() == false ){
				$rs = array(
					'alert' => 'alert-danger',
					'rs'	=> 1,
					'msg'	=> '<b><i class="glyphicon glyphicon-remove"></i> Please complete the form...</b>'
				);
				
				$this->session->set_flashdata($rs);
				redirect("users/signin","refresh");
			}else{
				
				$where	= array(
					'email'		=> $email,
				);
				
				$getUser = $this->model_users->getAll($where)->row_array();
				
				if($getUser){
					
					if($getUser['userstatus_id'] == 1){
						if(password_verify($password, $getUser['password'])){
							$data_session	= array(
									'user_id'	=> $getUser['user_id'],
									'logginUser'=> true,
									'level_id'	=> $getUser['userlevel_id'],
									'userstatus_id' => $getUser['userstatus_id']
							);
							
							$this->session->set_userdata($data_session);
							
							redirect("users","refresh");
						}else{
							$rs = array(
								'alert' => 'alert-danger',
								'rs'	=> 1,
								'msg'	=> '<b><i class="glyphicon glyphicon-remove"></i> Your email and password is incorrect..</b>'
							);
							
							$this->session->set_flashdata($rs);
							redirect("users/signin","refresh");
						}
					}else if($getUser['userstatus_id'] == 2){
						$rs = array(
							'alert' => 'alert-danger',
							'rs'	=> 1,
							'msg'	=> '<b><i class="glyphicon glyphicon-remove"></i> Your account has been blocked by admin. Pleas contact admin..</b>'
						);
						
						$this->session->set_flashdata($rs);
						redirect("users/signin","refresh");
					}else if($getUser['userstatus_id'] == 3){
						$data_session	= array(
								'user_id'	=> $getUser['user_id'],
								'logginUser'=> true,
								'level_id'	=> $getUser['userlevel_id'],
								'nama'	=> $getUser['nama'],
								'email'	=> $getUser['email'],
								'userstatus_id' => $getUser['userstatus_id']
						);
						
						$this->session->set_userdata($data_session);
						redirect("users/signin","refresh");
					}
				}else{
					$rs = array(
						'alert' => 'alert-danger',
						'rs'	=> 1,
						'msg'	=> '<b><i class="glyphicon glyphicon-remove"></i> Your email and password is incorrect..</b>'
					);
					
					$this->session->set_flashdata($rs);
					redirect("users/signin","refresh");
				}
			}
		}
	}
	
	//kirim ulang email
	function kirim_ulang_email($email = ""){
		echo "kirim ulang emai";
	}
	
	//signout user
	function signoutUser(){
		
		$this->session->unset_userdata('logginUser');
		
		session_destroy();
		
		redirect('','refresh');
	}
	
	//akun
	function akun(){
	     if(!$this->session->userdata('logginUser')){
	     	 redirect('users','refresh');
	     }else{
	     	 
		     $data['title']     = "Akun | SedekahIlmu";
		     $data['menu']      = 'akun';
		     $data['user']		= $this->model_users->getAll(array("user_id" => $this->session->userdata("user_id")))->row_array();
		     $data['dashboard']	 = '1';
		     $this->load->view('layout/vwHeader',$data);
		     $this->load->view('layout/vwLeftBar');
		     $this->load->view('page/user/vwProfile');
			 $this->load->view('layout/vwFooter');
	     }
	}
	
	function simpan_akun(){
		
		if(!isset($_POST['simpan'])){
			echo "<h3 style='color:red;font-weight:bold;'>Forbiden Access</h3>";
		}else{
			
			$this->form_validation->set_rules("nama", "Username", "trim");
			$this->form_validation->set_rules("facebook", "Password", "trim");
			$this->form_validation->set_rules("profile", "Email", "trim");
			
			$nama		= addslashes($this->input->post('nama',true));
			$facebook	= addslashes($this->input->post('facebook',true));
			$profile	= addslashes($this->input->post('profile',true));
			$image		= '';
			
			if($this->form_validation->run() == false ){
				$rs = array(
					'alert' => 'alert-danger',
					'rs'	=> 1,
					'msg'	=> '<b><i class="glyphicon glyphicon-remove"></i> Please fill data correctly...</b>' 
				);
				
				$this->session->set_flashdata($rs);
				redirect("users/akun","refresh");
			}else{
					
				$this->load->helper('file');
				$config['upload_path'] = './uploads/profile/';
				$config['allowed_types'] =  'jpg|png|jpeg|PNG';
				$config['max_size'] = '5120';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				
				if($this->upload->do_upload('upload-image')){
					$file = $this->upload->data();
					
					$image = 'uploads/profile/'.$file['file_name'];

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
						redirect("users/akun","refresh");
					}
				}
			}
			
			$update = '';
			
			if($image){
				$update = array(
					'nama' => $nama,
					'profile'	=> $profile,
					'gambar'	=> $image,
					'facebook'	=> $facebook,
				);
				
			}else{
				$update = array(
					'nama' => $nama,
					'profile'	=> $profile,
					'facebook'	=> $facebook
				);
			}
			
			
			$query = $this->model_users->getUpdate($update,$this->session->userdata("user_id"));
			
			if($query){
				$rs = array(
					'alert' => 'alert-success',
					'rs'	=> 1,
					'msg'	=> '<b><i class="glyphicon glyphicon-ok"></i> Update is success...</b>' 
				);
				
				$this->session->set_flashdata($rs);
				redirect("users/akun","refresh");
			}else{
				$rs = array(
					'alert' => 'alert-danger',
					'rs'	=> 1,
					'msg'	=> '<b><i class="glyphicon glyphicon-remove"></i> Update is failed...</b>' 
				);
				
				$this->session->set_flashdata($rs);
				redirect("users/akun","refresh");
			}
			
		}
	}
	
	function sedekah($page='',$id=''){
		
		if(!$this->session->userdata('logginUser')){
	     	 redirect('users','refresh');
	     }else{
	     	 
	     	 if($page==''){
	     		 $data['title']     = "Sedekah Ilmu | SedekahIlmu";
			     $data['menu']      = 'sedekah';
			     $data['dashboard']	 = '1';
			     $this->load->view('layout/vwHeader',$data);
			     $this->load->view('layout/vwLeftBar');
			     $this->load->view('page/user/sedekah/vwIndex');
				 $this->load->view('layout/vwFooter');
	     	 }else{
	     		
	     		if($page == 'add'){
	     			
	     			 $data['title']     = "Create Sedekah Ilmu | SedekahIlmu";
				     $data['menu']      = 'sedekah';
				     $data['kategori']	= $this->model_kategori_ilmu->getAll();
				     $data['dashboard']	 = '1';
				     $this->load->view('layout/vwHeader',$data);
				     $this->load->view('layout/vwLeftBar');
				     $this->load->view('page/user/sedekah/vwAdd');
					 $this->load->view('layout/vwFooter');

	     		}elseif($page == 'edit'){
	     			
	     			if($id !=''){
	     				 
	     				 $where	= array(
	     					'ilmu_id'	=> $id,
	     					'user_id'	=> $this->session->userdata('user_id')
	     				 );
	     				 
	     				 $cek	=  $this->model_ilmu->getAll($where)->row_array();
	     				 
	     				 if($cek){
	     				 	 
	     				 	 $listkategori	= array();
	     				 	 $query		= $this->model_ilmu->getIdKatByIdIlmu(array("ilmu_id" => $id))->result();
	     				 	 
	     				 	 foreach($query as $row){
	     				 	 	array_push($listkategori,$row->kategoriilmu_id);
	     				 	 }
	     				 	 
	     				 	 $data['title']     = "Edit Sedekah Ilmu | SedekahIlmu";
						     $data['menu']      = 'sedekah';
						     $data['kategori']	= $this->model_kategori_ilmu->getAll();
						     $data['sedekahilmu']	= $cek;	
						     $data['listkategori']	= $listkategori;	
						     $data['dashboard']	 = '1';
						     $this->load->view('layout/vwHeader',$data);
						     $this->load->view('layout/vwLeftBar');
						     $this->load->view('page/user/sedekah/vwEdit');
							 $this->load->view('layout/vwFooter');
	     				 }else{
	     				 	 $this->load->view('vwPageNotFound');
	     				 }
	     			}else{
	     				$this->load->view('vwPageNotFound');
	     			}
	     		}
	     	 }
	     }
	}
	
	function hapus_sedekah($ilmu_id=''){
		if(!$this->session->userdata('logginUser')){
	     	 redirect('users','refresh');
	     }else{
	     
	     	$ilmu_id = decode($ilmu_id);
	     	
	     	$cek	= $this->model_ilmu->getAll(array("ilmu_id" => $ilmu_id, "user_id" => $this->session->userdata("user_id")))->row_array();
	     	
	     	if($cek){
	     		
	     		if($cek['gambar']){
	     			unlink(FCPATH.$cek['gambar']);
	     			unlink(FCPATH.$cek['thumbnail']);
	     		}
	     		
	     		$delete = $this->model_ilmu->getDelete(array("ilmu_id" => $ilmu_id));
	     		
	     		$data	= array();
	     		
	     		if($delete){
	     			
	     			$this->model_ilmu->getDeleteKatDetail(array("ilmu_id" => $ilmu_id));
	     			
	     			$data = array(
	     				"rs"	=> 1,
	     				"msg"	=> "<i class='glyphicon glyphicon-ok'></i> Delete is success..",
	     				"alert"	=> "alert-success"
	     			);
	     		}else{
	     			$data = array(
	     				"rs"	=> 1,
	     				"msg"	=> "<i class='glyphicon glyphicon-ok'></i> Delete is failed..",
	     				"alert"	=> "alert-danger"
	     			);
	     		}
	     		
	     		$this->session->set_flashdata($data);
	     		redirect("users/sedekah","refresh");
	     		
	     	}else{
	     		$this->load->view('pageNotFound');
	     	}
	     }
	}
	
	function kategoriilmu($page=''){
		
		if(!$this->session->userdata('logginUser') && $this->session->userdata("level_id") != 1){
	     	 redirect('users','refresh');
	     }else{
	     	 
	     	 if(!$page){
	     		 $data['title']     = "Kategori | SedekahIlmu";
			     $data['menu']      = 'kategori';
			     $data['dashboard']	 = '1';
			     $this->load->view('layout/vwHeader',$data);
			     $this->load->view('layout/vwLeftBar');
			     $this->load->view('page/user/kategoriilmu/vwIndex');
				 $this->load->view('layout/vwFooter');
	     	 }else{
	     	 
	     	 	
	     	 }
	     }
	}
	
	function read_kategori($pg=1){
		 if(!$this->session->userdata('logginUser')){
	     	 redirect('users/signin','refresh');
	     }else{
	     	
	     	$key	= trim($this->input->post('cari',true));
			$limit	= trim($this->input->post('limit',true));
			$user_id= $this->session->userdata('user_id');
			$offset = ($limit*$pg)-$limit;
			$like	= '';
			$where	= "(user_id = '$user_id' )";
			
			if($key) $like = "(kategoriilmu_nm LIKE '%$key%')";
			
			$page 	= array();
	        $page['limit'] 		= $limit;
	        $page['count_row'] 	= $this->model_kategori_ilmu->getCount($where, $like);
	        $page['current'] 	= $pg;
	        $page['list'] 		= gen_paging($page);
	
	        $data['paging'] = $page;
			$data['key']	= $key;
			$data['list']	= $this->model_kategori_ilmu->getAll($where, $like,  $limit, $offset);
			
			$this->load->view('page/user/kategoriilmu/vwList',$data);
	     }
	}
	
	function cek_kategori($nama){
		
		$nama	= addslashes($nama);
		$rs		= "";
		
		$cek	= $this->model_kategori_ilmu->getAll(array("kategoriilmu_nm" => $nama))->row_array();
		
		if($cek){
			$rs = 1;
		}else{
			$rs = 2;
		}
		
		echo json_encode(array("result" => $rs));
		
	}
	
	function simpan_kategori(){
		if(!isset($_POST['simpan'])){
			
			$this->load->view("pageNotFound");
			
		}else{
			$data	= array();
			$nama	= addslashes($this->input->post("nama",true));
			
			$cek	= $this->model_kategori_ilmu->getAll(array("kategoriilmu_nm" => $nama))->row_array();
		
			if($cek){
				
				$data	= array(
					'msg'	=> 'Gagal menyimpan. Nama kategori sudah ada',
					'alert'	=> 'alert-danger',
					'rs'	=> 1
				);
				
			}else{
				
				$dt	= array(
					'kategoriilmu_nm'	=> $nama,
					'kategoriilmu_url'	=> slug($nama),
					'user_id'			=> $this->session->userdata("user_id")
				);
					
				$query	= $this->model_kategori_ilmu->getInsert($dt);
				
				if($query){
					$data	= array(
						'msg'	=> 'Kategori berhasil disimpan',
						'alert'	=> 'alert-success',
						'rs'	=> 1
					);
				}else{
					$data	= array(
						'msg'	=> 'Kategori gagal disimpan',
						'alert'	=> 'alert-danger',
						'rs'	=> 1
					);
				}
				
			}
			
			$this->session->set_flashdata($data);
			redirect("users/kategoriilmu","refresh");
		}
	}
	
	function hapus_kategori($id=''){
		if(!$this->session->userdata('logginUser')){
	     	 redirect('users','refresh');
	     }else{
	     
	     	$id = decode($id);
	     	
	     	$cek	= $this->model_kategori_ilmu->getAll(array("kategoriilmu_id" => $id, "user_id" => $this->session->userdata("user_id")))->row_array();
	     	
	     	if($cek){
	     		
	     		$delete = $this->model_kategori_ilmu->getDelete($id);
	     		
	     		$data	= array();
	     		
	     		if($delete){
	     			
	     			$data = array(
	     				"rs"	=> 1,
	     				"msg"	=> "<i class='glyphicon glyphicon-ok'></i> Delete is success..",
	     				"alert"	=> "alert-success"
	     			);
	     		}else{
	     			$data = array(
	     				"rs"	=> 1,
	     				"msg"	=> "<i class='glyphicon glyphicon-ok'></i> Delete is failed..",
	     				"alert"	=> "alert-danger"
	     			);
	     		}
	     		
	     		$this->session->set_flashdata($data);
	     		redirect("users/kategoriilmu","refresh");
	     		
	     	}else{
	     		$this->load->view('pageNotFound');
	     	}
	     }
	}
	
	function semuailmu($page='',$ilmu_id=''){
		if(!$this->session->userdata('logginUser') || $this->session->userdata('level_id') != 1){
	     	 redirect('users/signin','refresh');
	     }else{
	     	 
	     	 if($page==''){
	     	 	
	     	 	 $data['title']     = "Semua Sedekah Ilmu | SedekahIlmu";
			     $data['menu']      = 'semuailmu';
			     $data['dashboard']	 = '1';
			     $this->load->view('layout/vwHeader',$data);
			     $this->load->view('layout/vwLeftBar');
			     $this->load->view('page/user/semuailmu/vwIndex');
				 $this->load->view('layout/vwFooter');
				 
	     	 }else if($page=='edit' && $ilmu_id != ''){
	     	 	
	     	 	$id		= addslashes($ilmu_id);
	     	 	
	     	 	$where	= array(
 					'ilmu_id'	=> $id,
 					'user_id'	=> $this->session->userdata('user_id')
 				 );
 				 
 				 $cek	=  $this->model_ilmu->getAll($where)->row_array();
 				 
 				 if($cek){
 				 	 
 				 	 $listkategori	= array();
 				 	 $query		= $this->model_ilmu->getIdKatByIdIlmu(array("ilmu_id" => $id))->result();
 				 	 
 				 	 foreach($query as $row){
 				 	 	array_push($listkategori,$row->kategoriilmu_id);
 				 	 }
 				 	 
 				 	 $data['title']     = "Edit Sedekah Ilmu | SedekahIlmu";
				     $data['menu']      = 'semuailmu';
				     $data['kategori']	= $this->model_kategori_ilmu->getAll();
				     $data['sedekahilmu']	= $cek;	
				     $data['dashboard']	 = '1';
				     $this->load->view('layout/vwHeader',$data);
				     $this->load->view('layout/vwLeftBar');
				     $this->load->view('page/user/semuailmu/vwEdit');
					 $this->load->view('layout/vwFooter');
 				 }else{
 				 	$this->load->view("pageNotFound");
 				 }
	     	 }else{
	     	 	$this->load->view("pageNotFound");
	     	 }
			 
	     }
	}
	
	function user($page='',$user_id=''){
		if(!$this->session->userdata('logginUser') || $this->session->userdata('level_id') != 1){
	     	 redirect('users/signin','refresh');
	     }else{
	     	 if($page==''){
	     	 	
	     	 	 $data['title']     = "Allm User | SedekahIlmu";
			     $data['menu']      = 'user';
			     $data['dashboard']	 = '1';
			     $this->load->view('layout/vwHeader',$data);
			     $this->load->view('layout/vwLeftBar');
			     $this->load->view('page/user/user/vwIndex');
				 $this->load->view('layout/vwFooter');
				 
	     	 }else if($page=='edit' && $user_id != ''){
	     	 	
	     	 }
	     }
	}
	
	function read_all_user($pg=1){

     	$key	= trim($this->input->post('cari',true));
		$limit	= trim($this->input->post('limit',true));
		$offset = ($limit*$pg)-$limit;
		$like	= '';
		$where	= "";
		
		if($key) $where = "(nama LIKE '%$key%')";
		
		$page 	= array();
        $page['limit'] 		= $limit;
        $page['count_row'] 	= $this->model_users->getCount($where, $like);
        $page['current'] 	= $pg;
        $page['list'] 		= gen_paging($page);

        $data['paging'] = $page;
		$data['key']	= $key;
		$data['list']	= $this->model_users->getAll($where, $like,  $limit, $offset);
		
		$this->load->view('page/user/user/vwList',$data);
	     
	}
	
	function ubah_status_user(){
		if(!isset($_POST['simpan'])){
			echo "<h3 style='color:red;font-weight:bold;'>Forbiden Access</h3>";
		}else{
			
			$this->form_validation->set_rules("nama", "Username", "trim");
			$this->form_validation->set_rules("userstatus_id", "Status", "trim");
			$this->form_validation->set_rules("userlevel_id", "Level", "trim");
			
			$nama			= addslashes($this->input->post('nama',true));
			$userstatus_id	= addslashes($this->input->post('userstatus_id',true));
			$userlevel_id	= addslashes($this->input->post('userlevel_id',true));
			$user_id	= addslashes($this->input->post('user_id',true));
			
			if($this->form_validation->run() == false ){
				$rs = array(
					'alert' => 'alert-danger',
					'rs'	=> 1,
					'msg'	=> '<b><i class="glyphicon glyphicon-remove"></i> Please fill data correctly...</b>' 
				);
				
				$this->session->set_flashdata($rs);
				redirect("users/user","refresh");
			}else{
					
				$update = array(
					'userstatus_id' => $userstatus_id,
					'userlevel_id'	=> $userlevel_id
				);
				
			
				$query = $this->model_users->getUpdate($update,$user_id);
			
				if($query){
					$rs = array(
						'alert' => 'alert-success',
						'rs'	=> 1,
						'msg'	=> '<b><i class="glyphicon glyphicon-ok"></i> Update is success...</b>' 
					);
					
					$this->session->set_flashdata($rs);
					redirect("users/user","refresh");
				}else{
					$rs = array(
						'alert' => 'alert-danger',
						'rs'	=> 1,
						'msg'	=> '<b><i class="glyphicon glyphicon-remove"></i> Update is failed...</b>' 
					);
					
					$this->session->set_flashdata($rs);
					redirect("users/user","refresh");
				}
				
			}
		}
	}
}
