	</div>
</div>
<div class="container-fluid">
    <br/><br/>
    <div class="row">
        <div clas="col-md-12">
            <div class="footer">
                <center>
                    
                    <p>Register to our emails for regular updates from all authors</p>
                    <?php
                     if($this->session->flashdata('rs') == 1){ ?>
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
                            <input type="hidden" class="form-control" id="user_id" placeholder="Enter your name.." name="user_id" value='0'>
                            <input type="email" class="form-control" id="email_s" placeholder="Enter your email address.." name="email_s" required >
                          </div>
                          <button type="submit" class="btn btn-trans" name='simpan'>Submit</button>
                        </form>
                    </div>
                     <br/><br/><span style='color:grey'><a href="<?php echo base_url()?>">Sedekahilmu.net</a> @ 2016 - 2017</span>
                </center>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url('assets/js/main.js')?>"></script>
</body>
</html>