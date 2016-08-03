<div class="col-md-9">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb" style='color:fff'>
               <li><a href="<?php echo site_url(''); ?>"></i>Home</a></li>
               <li class="active">List Semua Sedekah Ilmu</li>
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
				<option value='5' >5 rows</option>
				<option value='10' selected >10 rows</option>
				<option value='25' >25 rows</option>
			</select>
		</div>
		<div class='col-sm-5  col-xs-12 pull-right' style='margin-top:5px;margin-bottom:5px'>
			<div class="input-group pull-right">
				<input type="text" name="cari" id='cari' class="form-control col-sm-5 col-xs-12 input" placeholder="Search Title . . ." onchange='pageLoad(1)'>
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

<script>
$(document).ready(function(){
	pageLoad(1);
	
});

function pageLoad(i){
	var limit 	= $('#limit').val();
	var cari 	= $('#cari').val();
	
	$.ajax({
		url		: '<?php echo base_url()?>sedekahilmu/read_semuailmu/'+i,
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