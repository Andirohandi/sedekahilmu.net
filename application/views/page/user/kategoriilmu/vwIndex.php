<div class="col-md-9">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb" style='color:fff'>
               <li><a href="<?php echo site_url(''); ?>"></i>Home</a></li>
               <li class="active">Category List</li>
            </ol>
        </div>
    </div>
    <div class='row'>
    	<div class="col-md-12">
    		
    	<?php
         if($this->session->flashdata('rs') == 1){ ?>
                    
             <div class="alert <?php echo $this->session->flashdata('alert'); ?>">
                       <?php echo $this->session->flashdata('msg') ?> 
             </div>       
        <?php }
      	?>
    		
    	</div>
        <div class='col-sm-2 col-xs-12' style='margin-top:5px;margin-bottom:5px'>
            <a href="javascript:void(0)" class="btn btn-success" data-toggle="modal" data-target="#modal-create" ><i class="glyphicon glyphicon-plus"></i> Create</a>
        </div>
		<div class='col-sm-4 col-xs-12 pull-right' style='margin-top:5px;margin-bottom:5px'>
			<div class="input-group pull-right">
				<input type="text" name="cari" id='cari' class="form-control col-sm-5 col-xs-12 input" placeholder="Search Category . . ." onchange='pageLoad(1)'>
				<div class="input-group-btn">
					<button class="btn btn-default"><i class="glyphicon glyphicon-search"></i> Search</button>
				</div>
			</div>
		</div>
		<div class='col-sm-2 col-xs-12 pull-right' style='margin-top:5px;margin-bottom:5px'>
			<select name='limit' id='limit' class="form-control col-sm-4 col-xs-12" onchange='pageLoad(1)'>
				<option value='5' >5 rows</option>
				<option value='10' >10 rows</option>
				<option value='25' >25 rows</option>
			</select>
		</div>
	</div>
	<div id='dataList'>
		<div class='row' id='loading' style="display:none">
			<div class='col-md-12'>
				<div class="box">
					<div class="box-header">
						
					</div>
					<div class="box-body">
					 
					</div>
					<div class="overlay">
						<i class="fa fa-spinner fa-pulse fa-5x"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal-create" data-backdrop="static" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Create Category</h4>
      </div>
      <div class="modal-body">
      	<?php echo form_open('users/simpan_kategori')?>
        <div class="form-horizontal">
        	<div class="form-group">
		    <label for="nama" class="col-sm-2 control-label">Name</label>
		    <div class="col-sm-10">
		      <input type="text" name="nama" class="form-control" id="nama" placeholder="Name.." required onchange="cekNamaKategori(this.value)">
		      <small><span id="error-name" style='display:none;color:red;'>Maaf, Nama kategori sudah ada..</span></small>
		    </div>
		  </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary disabled" id='simpan' name='simpan'>Save</button>
      </div>
      <?php echo form_close()?>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
$(document).ready(function(){
	pageLoad(1);
	
});

function cekNamaKategori(x){
	
	if(x==''){
		$("#error-name").hide();
		$("#simpan").addClass("disabled");
	}else{
		$.ajax({
			url		: '<?php echo base_url()?>users/cek_kategori/'+x,
			type	: 'post',
			dataType: 'json',
			data	: {},
			beforeSend : function(){
			},
			success : function(result){
				
				if(result.result == 1){
					$("#error-name").show();
					$("#simpan").addClass("disabled");
				}else{
					$("#error-name").hide();
					$("#simpan").removeClass("disabled");
				}
			}
		})
	}
}

function pageLoad(i){
	var limit 	= $('#limit').val();
	var cari 	= $('#cari').val();
	
	$.ajax({
		url		: '<?php echo base_url()?>users/read_kategori/'+i,
		type	: 'post',
		dataType: 'html',
		data	: {limit:limit,cari:cari},
		beforeSend : function(){
			$('#loading').fadeIn('slow');
		},
		success : function(result){
			$('#loading').attr('style','display:none');
			$('#dataList').html(result);
		}
	})
}

</script>