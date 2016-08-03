<div class="col-md-9">
  <div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb" style='color:fff'>
           <li><a href="<?php echo site_url(''); ?>"></i>Home</a></li>
           <li class="active">Sign Up</li>
        </ol>
    </div>
    <div class="col-md-12">
      <?php
         if($this->session->flashdata('rs') == 1){ ?>
                    
             <div class="alert <?php echo $this->session->flashdata('alert'); ?>">
                       <?php echo $this->session->flashdata('msg') ?> 
             </div>       
        <?php }
      ?>
      <form class="form-horizontal" action="<?php echo base_url('users/daftarUser') ?>" method="POST" >
        <div class="form-group">
          <label for="nama" class="col-sm-3 control-label">Name</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="nama" name='nama' placeholder="Name..." required >
          </div>
        </div>
        <div class="form-group">
          <label for="email" class="col-sm-3 control-label">Email</label>
          <div class="col-sm-9">
            <input type="email" class="form-control" id="email" name='email' placeholder="Email..." required onchange="getEmailRegister(this.value)">
            <label for="email" id="error-email-registered"></label>
          </div>
        </div>
        <div class="form-group">
          <label for="password" class="col-sm-3 control-label">Password</label>
          <div class="col-sm-9">
            <input type="password" class="form-control" id="password" name='password' placeholder="Password..." required onchange="cekConfirmationPassword()" >
          </div>
        </div>
        <div class="form-group">
          <label for="pass" class="col-sm-3 control-label">Confirmation Password</label>
          <div class="col-sm-9">
            <input type="password" class="form-control" id="pass" placeholder="Confirmation Password..." required onchange="cekConfirmationPassword()" >
            <label for="pass" id="error-confirm-password"></label>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-10">
            <div id="form-btn-register">
              <button type="submit" class="btn btn-primary"  id='btn-register' name="daftar">Sign Up</button>
            </div>
            <button type="submit" class="btn btn-primary hide" name='daftar' id='btn-submit-register'>Sign Up</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
  
</script>