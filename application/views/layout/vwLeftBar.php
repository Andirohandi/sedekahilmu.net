<div class="col-md-3">
  <div class="left-sidebar">
    
    <?php $user = $this->model_users->getAll(array("user_id" => $this->session->userdata("user_id")))->row_array()?>
      <?php if(isset($dashboard)){?>
      <?php if($this->session->userdata('logginUser')){ ?>
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title" style='font-size:15px'><b>User Profile</b></h3>
        </div>
        <div class="panel-body">
          <center><img src="<?php echo base_url($user['gambar'] != '' ? $user['gambar'] : 'assets/img/no_poto.png' ) ?>" style='width:125px;height:125px' class='img img-circle' />
          
          <br/><br/><h3 class="panel-title" style='font-size:15px'><b><?php echo $user['nama']?></b></h3>
          </center>
        </div>
      </div>
      
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><b>User Menu</b></h3>
        </div>
      </div>
      <ul class="nav nav-pills nav-stacked" style='margin-top:-15px;'>
          <li class="<?php echo $menu == 'home' ? 'active2' : '' ?>">
      	    <a href="<?php echo site_url('')?>">Home</a>
      	  </li>
      	  <li class="<?php echo $menu == 'dashboard' ? 'active2' : '' ?>">
      	    <a href="<?php echo site_url('users')?>">Dashboard</a>
      	  </li>
      	  <li class="<?php echo $menu == 'akun' ? 'active2' : '' ?>">
      	    <a href="<?php echo site_url('users/akun')?>">Akun</a>
      	  </li>
      	  <li class="<?php echo $menu == 'sedekah' ? 'active2' : '' ?>">
      	    <a href="<?php echo site_url('users/sedekah')?>">Sedekah Ilmu</a>
      	  </li>
      	  <?php if($this->session->userdata('level_id') == 1){ ?>
      	    <li class="<?php echo $menu == 'kategori' ? 'active2' : '' ?>">
        	    <a href="<?php echo site_url('users/kategoriilmu')?>">Kategori Ilmu</a>
        	  </li>
        	  <li class="<?php echo $menu == 'semuailmu' ? 'active2' : '' ?>">
      	      <a href="<?php echo site_url('users/semuailmu')?>">Semua Ilmu</a>
      	    </li>
      	    <li class="<?php echo $menu == 'user' ? 'active2' : '' ?>">
      	      <a href="<?php echo site_url('users/user')?>">Data User</a>
      	    </li>
      	  <?php } ?>
      </ul>
      <br/>
      <?php } ?>
    <?php }else{ ?>
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title"><b>Last Sedekah Ilmu</b></h3>
      </div>
      <div class="panel-body">
        <?php 
          $ilmu = $this->model_ilmu->getFiveLatest();
          
          foreach($ilmu->result() as $row_){ ?>
            
            <div style='padding:10px 0;border-bottom:1px dotted #d2d6de'><a href="<?php echo site_url('sedekahilmu/id/'.$row_->ilmu_id.'/'.$row_->url_ilmu)?>" ><?php echo $row_->judul; ?></a></div>
            
          <?php }
          
        ?>
      </div>
       <div class="panel-footer" style='min-height:30px'>
          <small><a href="<?php echo site_Url('sedekahilmu/all')?>" class="pull-right" style='padding-bottom:5px'> View All</a></small>
      </div>
    </div>
    <?php if($ilmu->num_rows() > 0){ ?>
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title"><b>Tags</b></h3>
      </div>
      <div class="panel-body">
        <?php 
        
          $ilmu = $this->model_ilmu->getIdKategori();
          
          $kategori = array();

          foreach($ilmu->result() as $row_){
            array_push($kategori,$row_->kategoriilmu_id);
          }
          
          $kategori = implode(",",$kategori);
          //var_dump($kategori);
          
          $kategori = $this->model_kategori_ilmu->getAll("kategoriilmu_id IN ($kategori)");
          
          foreach($kategori->result() as $row){
        ?>
          <a href="<?php echo site_url('sedekahilmu/tags/'.$row->kategoriilmu_url) ?>" ><span class="badge badge-danger" ># <?php echo $row->kategoriilmu_nm ?></span></a>
        <?php } ?>
      </div>
      <div class="panel-footer" style='min-height:30px'>
          <small><a href="<?php echo site_Url('sedekahilmu/tags')?>" class="pull-right" style='padding-bottom:5px'> View All</a></small>
      </div>
    </div>
    <?php } ?>
    
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title"><b>Quote</b></h3>
      </div>
      <div class="panel-body">
        <center>
        Sedekah itu adalah tindakan yang keren dan kekinian<br/>

        Dengan sedekah berarti melatih keihklasan kita.<br/>
        Ikhlas bukan sekedar kemampuan untuk rela memberi, tapi juga rela menerima.<br/>
        Menerima kondisi kita saat ini, atau menerima akan ‘datangnya sebuah keajaiban terbaru’ dalam hidup kita.<br/><br/>

        Karena tidak ada yang tidak masuk akal bagi Nya, hanya akal kita saja yang ada batasnya.<br/><br/>
        
            <b>~ <a href='https://www.facebook.com/profile.php?id=100011738073140&fref=ts'>Zam R</a></b>
        </center>
        </div>
    </div>
    
    
    
    <?php } ?>
    
  </div>
</div>