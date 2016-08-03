<div class="col-md-9">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb" style='color:fff'>
               <li><a href="<?php echo site_url(''); ?>"></i>Home</a></li>
               <li><a href="<?php echo site_url('sedekahilmu/all'); ?>"></i>Sedekah Ilmu</a></li>
               <li class="active">Tags</li>
            </ol>
        </div>
    </div>
    <div class='row'>
       <div class="col-md-12">
       		<h4><b>All Tags</b></h4>
       		<hr/>
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
	</div>
</div>