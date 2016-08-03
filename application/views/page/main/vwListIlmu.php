<?php $no = ($paging['limit']*$paging['current'])-$paging['limit']; 
	$no++; 
	if($list->num_rows() > 0 ) { $no=1;?>	
	
	<?php foreach($list->result() as $row){?>
	    <?php if($no == 1 || $no % 3 == 1 ){?>
    	<div class='row'>
    	    <?php } ?>
    		<div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                 <div class="title">
                   <a href="<?php echo site_url('sedekahilmu/id/'.$row->ilmu_id.'/'.$row->url_ilmu) ?>"><b><?php echo $row->judul; ?></b></a>
                 </div>
                 <a href="<?php echo site_url('sedekahilmu/id/'.$row->ilmu_id.'/'.$row->url_ilmu) ?>">
                  <img src="<?php echo base_url($row->thumbnail != '' ? $row->thumbnail : 'assets/img/sedekah4.jpg' ) ?>" alt="<?php echo $row->judul; ?>">
                  </a>
              <div class="caption">
                <?php $desk = strip_tags($row->deskripsi); echo substr($desk,0,150); ?>
                <br/><br/><a href="<?php echo site_url('sedekahilmu/id/'.$row->ilmu_id.'/'.$row->url_ilmu) ?>" class="btn btn-primary" role="button">Read More</a>
              </div>
            </div>
          </div>
         <?php if($no % 3 == 0 || $no == $list->num_rows()){?>
    	 </div>
    	<?php } ?>
    <?php $no++; } ?>	
	<div class='row'>
		<div class='col-sm-4 col-xs-12' style='margin-top:5px;margin-bottom:10px'>
			<?php echo $paging['count_row'] ?> Ilmu 
		</div>
		<div class='col-sm-8 col-xs-12 pull-right' style='margin-top:5px;margin-bottom:10px'>
			<?php echo $paging['list']; ?>
		</div>
	</div>
	
<?php } ?>