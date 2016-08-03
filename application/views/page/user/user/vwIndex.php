<div class="col-md-9">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb" style='color:fff'>
               <li><a href="<?php echo site_url(''); ?>"></i>Home</a></li>
               <li class="active">List User</li>
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
			<select name='limit' id='limit' class="form-control col-sm-4 col-xs-12" onchange='pageLoad(1)'>
				<option value='9' >9 rows</option>
				<option value='15' selected >15 rows</option>
				<option value='30' >30 rows</option>
			</select>
		</div>
		<div class='col-sm-5  col-xs-12 pull-right' style='margin-top:5px;margin-bottom:5px'>
			<div class="input-group pull-right">
				<input type="text" name="cari" id='cari' class="form-control col-sm-5 col-xs-12 input" placeholder="Search Name . . ." onchange='pageLoad(1)'>
				<div class="input-group-btn">
					<button class="btn btn-default"><i class="glyphicon glyphicon-search"></i> Search</button>
				</div>
			</div>
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
<div class="modal fade" tabindex="-1" role="dialog" id="modal-ubah-user" data-backdrop="static" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Change Status User</h4>
      </div>
      <div class="modal-body">
      	<?php echo form_open('users/ubah_status_user')?>
        <div class="form-horizontal">
        	<div class="form-group">
			    <label for="nama" class="col-sm-2 control-label">Name</label>
			    <div class="col-sm-10">
			      <input type="text" name="nama" class="form-control" id="nama" placeholder="Name.." required >
			      <input type="hidden" name="user_id" class="form-control" id="user_id" placeholder="Name.." required >
			      <small><span id="error-name" style='display:none;color:red;'>Maaf, Nama kategori sudah ada..</span></small>
			    </div>
		    </div>
		    <div class="form-group">
			    <label for="userstatus_id" class="col-sm-2 control-label">Status</label>
			    <div class="col-sm-10">
			      <select name="userstatus_id" id="userstatus_id" class='form-control'>
			      	<option value='1' >AKTIF</option>
			      	<option value='2' >TIDAK AKTIF</option>
			      </select>
			    </div>
		    </div>
		    <div class="form-group">
			    <label for="userlevel_id" class="col-sm-2 control-label">Level</label>
			    <div class="col-sm-10">
			      <select name="userlevel_id" id="userlevel_id" class='form-control'>
			      	<option value='1' >ADMIN</option>
			      	<option value='2' >USER</option>
			      </select>
			    </div>
		    </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id='simpan' name='simpan'>Save</button>
      </div>
      <?php echo form_close()?>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
$(document).ready(function(){
	pageLoad(1);
	
});

function pageLoad(i){
	var limit 	= $('#limit').val();
	var cari 	= $('#cari').val();
	
	$.ajax({
		url		: '<?php echo base_url()?>users/read_all_user/'+i,
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

function getData(x,y,z,n){
	$("#user_id").val(x);
	$("#userlevel_id").val(y);
	$("#userstatus_id").val(z);
	$("#nama").val(n);
}
</script>