<div class="col-md-9">
  <div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb" style='color:fff'>
           <li><a href="<?php echo site_url(''); ?>"></i>Home</a></li>
           <li class="active">Dashboard</li>
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
      
      <center>
        <div style="font-family: 'Lobster', cursive;font-size:15px">
        Sedekah itu adalah tindakan yang keren dan kekinian<br/>

        Dengan sedekah berarti melatih keihklasan kita.<br/>
        Ikhlas bukan sekedar kemampuan untuk rela memberi, tapi juga rela menerima.<br/>
        Menerima kondisi kita saat ini, atau menerima akan ‘datangnya sebuah keajaiban terbaru’ dalam hidup kita.<br/><br/>

        Karena tidak ada yang tidak masuk akal bagi Nya, hanya akal kita saja yang ada batasnya.<br/><br/>
        </div>
        
        <quote>
            <b>Quote by <a href='https://www.facebook.com/profile.php?id=100011738073140&fref=ts'>Zam R</a></b>
        </quote>
       
        
      </center>
    </div>
  </div>
</div>
           