<?php 
    $author = $this->model_users->getAll(array("user_id" => $ilmu['user_id']))->row_array();
?>

<link href="<?php echo base_url()?>assets/ayoshare/ayoshare.css" rel="stylesheet">
<script src="<?php echo base_url()?>assets/ayoshare/ayoshare.js"></script>

<div class="col-md-9">
  <div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb" style='color:fff'>
           <li><a href="<?php echo site_url(''); ?>"></i>Home</a></li>
           <li><a href="<?php echo site_url('sedekahilmu/all'); ?>"></i>Sedekah Ilmu</a></li>
           <li class="active"><?php echo $ilmu['judul']?></li>
        </ol>
    </div>
    <div class="col-md-12">
      <h2><?php echo $ilmu['judul']?></h2>
      <small>
          <a href="<?php echo site_url('sedekahilmu/author/'.$author['user_id'].'/'.slug($author['nama'])) ?>"><i class="glyphicon glyphicon-user"></i> <?php echo $author['nama'] ?></a>
          &nbsp;&nbsp;&nbsp; 
          <i class="glyphicon glyphicon-calendar"></i> <?php echo date("d-M-y", strtotime($ilmu['tgl_input']));?>
          &nbsp;&nbsp;&nbsp; 
          <i class="glyphicon glyphicon-eye-open"></i> <?php echo $ilmu['viewer'];?> Views
      </small>
      <br/>
      <?php foreach($tags->result() as $row){ ?>
          <a href="<?php echo site_url('sedekahilmu/tags/'.$row->kategoriilmu_url) ?>" ><span class="badge badge-danger" ># <?php echo $row->kategoriilmu_nm ?></span></a>
      <?php } ?>
      <hr/>
      <?php if($ilmu['gambar']){?>
          <center><img src="<?php echo base_url($ilmu['gambar']) ?>" classs='img img-responsive '></img></center>
          <br/>
      <?php } ?>
      <?php echo $ilmu['deskripsi']?>
    </div>
    
    <div class="col-md-12">
        <hr/>
		<center><div id="anu" data-ayoshare="<?php echo site_url('sedekahilmu/id/'.$ilmu['ilmu_id'].'/'.$ilmu['url_ilmu'])?>"></div></center>
	</div>
    <div class="col-md-12">
        <hr/>
           <h4><b>Author : </b></h4>
           <div class="row">
               <div class="col-md-2">
                    <center>
                        <a href="<?php echo site_url('sedekahilmu/author/'.$author['user_id'].'/'.slug($author['nama'])) ?>">
                           <img src="<?php echo base_url($author['gambar'] != '' ? $author['gambar'] : 'assets/img/no_poto.png' ) ?>" style='width:75px;height:75px' class='img img-circle' />
                        </a>
                    </center>
               </div>
               <div class="col-md-10">
                   <b><a href="<?php echo site_url('sedekahilmu/author/'.$author['user_id'].'/'.slug($author['nama'])) ?>"><?php echo strtoupper($author['nama'])?></a></b><br/>
                   <i><?php echo $author['profile']?></i>
                   <br/><br/><br/>
                   <div class="col-md 12">
                           <small><p><b>Register to our emails for regular updates from author #<?php echo strtoupper($author['nama'])?></b></p></small>
                       </div>
                   <div class="row">
                       
                        <?php
                         if($this->session->flashdata('rs') == 2){ ?>
                            <div class='col-md-12'>
                             <div class="alert <?php echo $this->session->flashdata('alert'); ?>">
                                       <?php echo $this->session->flashdata('msg') ?> 
                             </div> 
                             </div> 
                        <?php }
                      	?>
                       <div class="col-md-12">
                         <form class="form-inline" action="<?php echo site_url('home/signup_subscribe') ?>" method="POST">
                          <div class="form-group">
                            <label class="sr-only" for="email">Email address</label>
                            <input type="hidden" class="form-control" id="url" placeholder="Enter your email address.." name="url" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5) ?>">
                            <input type="text" class="form-control" id="nama_s" placeholder="Enter your name.." name="nama_s" required>
                            <input type="hidden" class="form-control" id="user_id" placeholder="Enter your name.." name="user_id" value="<?php echo $author['user_id']?>">
                            <input type="email" class="form-control" id="email_s" placeholder="Enter your email address.." name="email_s" required >
                          </div>
                          <button type="submit" class="btn btn-primary" name='simpan'>Submit</button>
                        </form>
                    </div>
                   </div>
                   
               </div>
           </div>
        <hr/>
    </div>
    <?php if($other->num_rows() > 0){ ?>
    <div class="col-md-12">
        
        <h4><b>Related Sedekah Ilmu : </b></h4>
        <div class="row">
          <?php foreach($other->result() as $row){ ?>
              <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                     <div class="title">
                       <a href="<?php echo site_url('sedekahilmu/id/'.$row->ilmu_id.'/'.$row->url_ilmu) ?>"><b><?php echo $row->judul; ?></b></a>
                     </div>
                  <div class="caption">
                    <?php $desk = strip_tags($row->deskripsi); echo substr($desk,0,150); ?>
                    <br/><br/><a href="<?php echo site_url('sedekahilmu/id/'.$row->ilmu_id.'/'.$row->url_ilmu) ?>" class="btn btn-primary" role="button">Read More</a>
                  </div>
                </div>
              </div>
          <?php } ?>
        </div>
        <hr/>
    </div>
    <?php } ?>
    <div class="col-md-12">
        
        <div id="disqus_thread"></div> 
        
        <script> 
            /*var disqus_config = function () {
                this.page.url = "<?php echo "https://codeigniterok-andirohandi.c9users.io/".$this->uri->segment(0).'/'.$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4); ?>";  // Replace PAGE_URL with your page's canonical URL variable
                this.page.identifier = "<?php echo $ilmu['ilmu_id']?>"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
            }*/


        (function() { // DON'T EDIT BELOW THIS LINE 
        	var d = document, s = d.createElement('script'); s.src = '//sedekahilmu.disqus.com/embed.js'; s.setAttribute('data-timestamp', +new Date()); (d.head || d.body).appendChild(s); })(); 
      </script> 
      <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a>
      </noscript>
        
    </div>
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#anu").ayoshare(
			google = true, // true or false
			stumbleupon = true,
			facebook = true,
			linkedin = true,
			pinterest = true,
			bufferapp = true,
			reddit = true,
			vk = true,
			pocket = true,
			twitter = true
		);
    })
    
</script>
