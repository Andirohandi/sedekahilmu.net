<div class="col-md-12">
  <div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb" style='color:fff'>
           <li><a href="<?php echo site_url(''); ?>"></i>Home</a></li>
           <li class="active">User Verification</li>
        </ol>
    </div>
    <div class="col-md-12">
        
        <b>Hi <?php echo $this->session->userdata('nama');?>,</b><br/><br/>

		We have send message to your email. Please check email for verification your account.
		<br/><br/>

		<a href='<?php echo site_url('users/kirim_ulang_email/'.encode($this->session->userdata('email'))); ?>' class='btn btn-info'><i class='fa fa-link'></i> Kirim Ulang Link Verifikasi</a>
       
    </div>
  </div>
</div>
           