<?php $no = ($paging['limit']*$paging['current'])-$paging['limit']; 
	$no++; 
	if($list->num_rows() > 0 ) { ?>	
	<div class='row'>
		<div class='col-sm-12'>
			<table class="table table-bordered" style='font-size:12px'>
				<tr class="bg-aqua" >
					<th style='width:5%;text-align:center'>No</th>
					<th style='width:35%;text-align:center'>Judul</th>
					<th style='width:15%;text-align:center'>Tanggal</th>
					<th style='width:10%;text-align:center'>Status Publish</th>
					<th style='width:10%;text-align:center'>Status Aktif</th>
					<th style='width:10%;text-align:center'>Jml View</th>
					<th style='width:15%;text-align:center'>Aksi</th>
				</tr>
				<?php foreach($list->result() as $row){ 
					
					?>
					<tr>
						<td align='center'><?php echo $no; ?></td>
						<td><a href="<?php echo site_url('sedekahilmu/id/'.$row->ilmu_id.'/'.$row->url_ilmu)?>"><?php echo $row->judul; ?></a></td>
						<td align='center'><?php echo date('d-M-Y',strtotime($row->tgl_input)); ?></td>
						<td align='center'><?php echo $row->statuspublish_id == 1 ? "<i class='glyphicon glyphicon-ok'>" : "<i class='glyphicon glyphicon-remove'>"; ?></td>
						<td align='center'><?php echo $row->ilmustatus_id == 1 ? "<i class='glyphicon glyphicon-ok'>" : "<i class='glyphicon glyphicon-remove'>"; ?></td>
						<td align='center'><?php echo $row->viewer; ?></td>
						<td>
							<center>
								<a href="<?php echo site_url('users/semuailmu/edit/'.$row->ilmu_id); ?>" class="btn btn-info btn-sm" ><i class='glyphicon glyphicon-edit'></i> Edit </a>
							</center>
						</td>
					</tr>
				<?php $no++; } ?>
			</table>
			<input type='hidden' id='current' name='current' value='<?php echo $paging['current'] ?>'>
			<input type='hidden' id='last' name='last' value='<?php echo $last ?>'>
		</div>
	</div>
	<div class='row'>
		<div class='col-sm-4 col-xs-12' style='margin-top:5px;margin-bottom:10px'>
			<?php echo $paging['count_row'] ?> Rows 
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
						
						<h3 style='font-family:callibri;text-align:center;'><i class='fa fa-warning'></i> Sedekah ilmu is empty</h3>
			
					<?php } else { ?>
					
						<h3 style='font-family:callibri;text-align:center;'><i class='fa fa-warning'></i> Sedekah ilmu has you looking for is not found</h3>
						
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	
	<?php 
	} 
?>