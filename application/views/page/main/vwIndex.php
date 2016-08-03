
    <div class="col-md-9">
        <div class="row">
          <div class="col-md-12">
              <ol class="breadcrumb">
                <li class="active">Home</li>
              </ol>
          </div>
        </div>
        
        <div id="dataList"></div>
        
        <div class="row">
        	<hr/>
        	<div class="col-md-6">
        		<div class="panel panel-primary">
			        <div class="panel-heading">
			          <h3 class="panel-title" style='font-size:15px'><b>Facebook</b></h3>
			        </div>
			        <div class="panel-body">
			          	<div id="fb-root"></div>
						<script>
							(function(d, s, id) {
								var js, fjs = d.getElementsByTagName(s)[0];
								if (d.getElementById(id)) return;
								js = d.createElement(s); js.id = id;
								 js.src = "//connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.6&appId=923440137750844";
								fjs.parentNode.insertBefore(js, fjs);
							}(document, 'script', 'facebook-jssdk'));
						</script>
						<div class="fb-page" data-href="https://www.facebook.com/sedekahilmu.net/?fref=ts" data-tabs="timeline" data-height="300" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/sedekahilmu.net/?fref=ts" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/sedekahilmu.net/?fref=ts">sedekahilmu.net</a></blockquote></div>
				    </div>
			     </div>
        	</div>
        	<div class="col-md-6">
        		<div class="panel panel-primary">
			        <div class="panel-heading">
			          <h3 class="panel-title" style='font-size:15px'><b>Twitter</b></h3>
			        </div>
			        <div class="panel-body">
			          	<a class="twitter-timeline" data-height="300" data-theme="light" href="https://twitter.com/sedekahilmu_net">Tweets by sedekahilmu_net</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
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
	var limit 	= 9;
	var cari 	= '';
	
	$.ajax({
		url		: '<?php echo base_url()?>home/read/'+i,
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