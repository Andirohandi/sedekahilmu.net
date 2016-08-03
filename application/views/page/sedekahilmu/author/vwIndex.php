<div class="col-md-9">
  <div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb" style='color:fff'>
           <li><a href="<?php echo site_url(''); ?>"></i>Home</a></li>
           <li><a href="<?php echo site_url('sedekahilmu/all'); ?>"></i>Sedekah Ilmu</a></li>
           <li><a href="<?php echo site_url('sedekahilmu/author'); ?>"></i>Author</a></li>
           <li class="active"><?php echo strtoupper($author['nama']) ?></li>
        </ol>
    </div>
    <div class="col-md-12">
         <h4><b>Author Sedekah Ilmu #<?php echo strtoupper($author['nama']) ?></b></h4>
         <hr/>
         <div class="row">
         	<div class="col-md-12">
		           <div class="row" >
		               <div class="col-md-2">
		                    <center>
		                        <a href="<?php echo site_url('sedekahilmu/author/'.$author['user_id'].'/'.slug($author['nama'])) ?>">
		                           <img src="<?php echo base_url($author['gambar'] != '' ? $author['gambar'] : 'assets/img/no_poto.png' ) ?>" style='width:75px;height:75px' class='img img-circle' />
		                        </a>
		                        <?php if($author['facebook']){ ?>
		                        <br/><br/>
		                        <a href="<?php echo site_url($author['facebook']) ?>" target="_blank" class='btn btn-xs btn-info'><i class="glyphicon glyphicon-facebook"></i> Facebook</a>
		                   		<?php } ?>
		                    </center>
		               </div>
		               <div class="col-md-10">
		                   <b><a href="<?php echo site_url('sedekahilmu/author/'.$author['user_id'].'/'.slug($author['nama'])) ?>"><?php echo strtoupper($author['nama'])?></a></b><br/>
		                   <i><?php echo $author['profile']?></i>
		               </div>
		           </div>
		        <hr/>
		    </div>
		    
        	<div class="col-md-12">
        		<div class="input-group pull-right">
					<input type="text" name="cari" id='cari' class="form-control col-sm-5 col-xs-12 input" placeholder="Search Title . . ." onchange='pageLoad(1)'>
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
	var author     = "<?php echo $author['user_id'] ?>"
	
	$.ajax({
		url		: '<?php echo base_url()?>home/read_a/'+i,
		type	: 'post',
		dataType: 'html',
		data	: {limit:limit,cari:cari,author:author},
		beforeSend : function(){
			
		},
		success : function(result){
		
			$('#dataList').html(result);
		}
	})
}

</script>