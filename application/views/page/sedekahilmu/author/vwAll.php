<div class="col-md-9">
  <div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb" style='color:fff'>
           <li><a href="<?php echo site_url(''); ?>"></i>Home</a></li>
           <li><a href="<?php echo site_url('sedekahilmu/all'); ?>"></i>Sedekah Ilmu</a></li>
           <li class="active">Author</li>
        </ol>
    </div>
    <div class="col-md-12">
         <h4><b>All Authors Sedekah Ilmu</b></h4>
         <hr/>
         <div class="row">
        	<div class="col-md-12">
        		<div class="input-group pull-right">
					<input type="text" name="cari" id='cari' class="form-control col-sm-5 col-xs-12 input" placeholder="Search Author . . ." onchange='pageLoad(1)'>
					<div class="input-group-btn">
						<button class="btn btn-default" onclick='pageLoad(1)'><i class="glyphicon glyphicon-search"></i> Search</button>
					</div>
				</div>
        	</div>
        </div>
        <br/>
        <div id="dataList"></div>
      
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
	pageLoad(1);
	
});

function pageLoad(i){
	var limit 	= 9;
	var cari 	= $("#cari").val();
	
	$.ajax({
		url		: '<?php echo base_url()?>home/read_author/'+i,
		type	: 'post',
		dataType: 'html',
		data	: {limit:limit,cari:cari},
		beforeSend : function(){
			
		},
		success : function(result){
		
			$('#dataList').html(result);
		}
	})
}

</script>