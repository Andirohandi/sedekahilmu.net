
<link rel="stylesheet" href="<?php echo base_url('assets/chosen/prism.css')?>" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url('assets/chosen/chosen.css')?>" type="text/css" />

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/chosen/chosen.jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/chosen/prism.js') ?>"></script>

<div class="col-md-9">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb" style='color:fff'>
               <li><a href="<?php echo site_url(''); ?>"></i>Home</a></li>
               <li><a href="<?php echo site_url('users/sedekah'); ?>"></i>List Sedekah Ilmu</a></li>
               <li class="active">Create Sedekah Ilmu</li>
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
     <?php echo form_open_multipart('sedekahilmu/simpan_sedekah') ?>
         <div class="form-horizontal">
            <div class="form-group">
              <label for="judul" class="col-sm-3 control-label">Judul</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="judul" name='judul' placeholder="Judul..." required value="<?php echo $this->session->userdata("judul"); ?>" />
              </div>
            </div>
            <div class="form-group">
              <label for="statuspublish_id" class="col-sm-3 control-label">Status Publish</label>
              <div class="col-sm-9">
                <select class="form-control" name='statuspublish_id' required >
                	<option value='1' <?php echo $this->session->userdata("statuspublish_id") == 1 ? 'selected' : '' ; ?> > Publish </option>
                	<option value='2' <?php echo $this->session->userdata("statuspublish_id") == 2 ? 'selected' : '' ; ?>> Draft </option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="kategoriilmu_id" class="col-sm-3 control-label">Tags</label>
              <div class="col-sm-9">
				 <select data-placeholder="Tags.." style="width:100%;" multiple class="chosen-select-no-results" tabindex="11" name="kategoriilmu_id[]" required >
		            <option value=""></option>
		            <?php foreach($kategori->result() as $row){ ?>
		            	<option value="<?php echo $row->kategoriilmu_id; ?>"><?php echo $row->kategoriilmu_nm; ?></option>
		            <?php } ?>
		          </select>
              </div>
            </div>
            <div class="form-group">
              <label for="deskripsi" class="col-sm-3 control-label">Deskripsi</label>
              <div class="col-sm-9">
                <textarea class="form-control" id="deskripsi" style="min-height:500px" name='deskripsi' placeholder="Deskripsi..." ><?php echo $this->session->userdata("deskripsi"); ?></textarea>
              </div>
            </div>
            <div class="form-group" style='margin-top:0px'>
                <label for="email" class="col-sm-3 control-label">Gambar</label>
    			<div class='col-sm-1'>
    				<input type="file" style="display:none" class="form-control" id="upload-image" name="upload-image" multiple="multiple"></input>
    				<div id="upload" class="btn btn-default" style=''>
    					<i id='addImage' class='glyphicon glyphicon-plus hide'> Add</i>
    					<div id="thumbnail"><img src="<?php echo base_url('assets/img/no_image_availabel.png') ?>" /></div>
    				</div>
    			</div>
    		</div>
            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-10">
                <button type="submit" class="btn btn-primary" name='simpan'>Simpan</button>
              </div>
            </div>
        </div>
      <?php echo form_close(); ?>
      <div id="disqus_thread"></div>
    </div>
	</div>
</div>

<script>
$(document).ready(function(){
	
	var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
	
	tinymce.init({ selector:'textarea',
		plugins: [
				"advlist autolink lists link image charmap print preview anchor",
				"searchreplace visualblocks code",
				"insertdatetime media table contextmenu paste emoticons ",
			],
			toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image media |  charmap | preview code print",
			toolbar2: "responsivefilemanager ",
			image_advtab: true 
	})
	
	
	var fileDiv = document.getElementById("upload");
	var fileInput = document.getElementById("upload-image");
	
	console.log(fileInput);
	
	fileInput.addEventListener("change",function(e){
	  var files = this.files
	  showThumbnail(files)
	},false)

	fileDiv.addEventListener("click",function(e){
	  $(fileInput).show().focus().click().hide();
	  e.preventDefault();
	},false)

	fileDiv.addEventListener("dragenter",function(e){
	  e.stopPropagation();
	  e.preventDefault();
	},false);

	fileDiv.addEventListener("dragover",function(e){
	  e.stopPropagation();
	  e.preventDefault();
	},false);

	fileDiv.addEventListener("drop",function(e){
	  e.stopPropagation();
	  e.preventDefault();

	  var dt = e.dataTransfer;
	  var files = dt.files;

	  showThumbnail(files)
	},false);
	
});

function showThumbnail(files){
  for(var i=0;i<files.length;i++){
	var file = files[i]
	var imageType = /image.*/

	if(!file.type.match(imageType)){
	  console.log("Not an Image");
	  continue;
	}

	var image = document.createElement("img");
	// image.classList.add("")
	var thumbnail = document.getElementById("thumbnail");
	image.file = file;
	
	while(thumbnail.hasChildNodes()) {
		thumbnail.removeChild(thumbnail.lastChild);
	}
	
	thumbnail.appendChild(image)
	
	$('#addImage').hide();
	
	var reader = new FileReader()
	reader.onload = (function(aImg){
	  return function(e){
		aImg.src = e.target.result;
	  };
	}(image))
	var ret = reader.readAsDataURL(file);
	var canvas = document.createElement("canvas");
	ctx = canvas.getContext("2d");
	image.onload= function(){
	  ctx.drawImage(image,128,128)
	}
  }
}
</script>  

 <script> /** * RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS. * LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables */ /* var disqus_config = function () { this.page.url = PAGE_URL; // Replace PAGE_URL with your page's canonical URL variable this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable }; */ (function() { // DON'T EDIT BELOW THIS LINE var d = document, s = d.createElement('script'); s.src = '//sedekahilmu.disqus.com/embed.js'; s.setAttribute('data-timestamp', +new Date()); (d.head || d.body).appendChild(s); })(); </script> <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>