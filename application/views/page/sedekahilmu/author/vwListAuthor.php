<?php $no = ($paging['limit']*$paging['current'])-$paging['limit']; 
	$no++; 
	if($list->num_rows() > 0 ) { ?>	
	
		<?php $no = 1; 
		
		foreach($list->result() as $row){ ?>
			<?php if($no == 1 || $no % 3 == 1 ){?>
    	<div class='row'>
    	    <?php } ?>
    		<div class="col-sm-6 col-md-4">
            <div style='margin-bottom:30px;border:1px dotted #D2D6DE'>
            	<br/><br/>
            	<center>
            		<a href="<?php echo site_url('sedekahilmu/author/'.$row->user_id.'/'.slug($row->nama)) ?>">
	                  	<img src="<?php echo base_url($row->gambar != '' ? $row->gambar : 'assets/img/no_poto.png' ) ?>" alt="<?php echo $row->nama; ?>" class='img img-circle' style="width:100px;height 100px">
	                 </a>
            	</center>
                 
              	<div class="caption">
              		<center>
              			<br/>
              			<?php echo strtoupper($row->nama)?><br/><br/>
              			<a href="<?php echo site_url('sedekahilmu/author/'.$row->user_id.'/'.slug($row->nama)) ?>" class='btn btn-primary btn-sm'>Detail</a>
              			<br/><br/>
              		</center>
                	
              	</div>
            </div>
          </div>
         <?php if($no % 3 == 0 || $no == $list->num_rows()){?>
    	 </div>
    	<?php } ?>
		<?php $no++; } ?>

		<input type='hidden' id='current' name='current' value='<?php echo $paging['current'] ?>'>
		<input type='hidden' id='last' name='last' value='<?php echo $last ?>'>

	<div class='row'>
		<div class='col-sm-4 col-xs-12' style='margin-top:5px;margin-bottom:10px'>
			<?php echo $paging['count_row'] ?> Authors 
		</div>
		<div class='col-sm-8 col-xs-12 pull-right' style='margin-top:5px;margin-bottom:10px'>
			<?php echo $paging['list']; ?>
		</div>
	</div>
	
<?php } else { ?>

	<div class='row'>
		<div class='col-sm-12'>
			<div class="box">
				<div class="box-body">
					<br/>
					<?php if( $key == '' ){ ?>
						
						<h3 style='font-family:callibri;text-align:center;'><i class='fa fa-warning'></i> Author ilmu is empty</h3>
			
					<?php } else { ?>
					
						<h3 style='font-family:callibri;text-align:center;'><i class='fa fa-warning'></i> Author sedkah ilmu has you looking for is not found</h3>
						
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	
	<?php 
	} 
?>