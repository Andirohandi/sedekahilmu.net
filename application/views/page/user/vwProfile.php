<div class="col-md-9">
  <div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb" style='color:fff'>
           <li><a href="<?php echo site_url(''); ?>"></i>Home</a></li>
           <li class="active">Akun</li>
        </ol>
    </div>
    <div class="col-md-12">
      <?php
         if($this->session->flashdata('rs') == 1){ ?>
                    
             <div class="alert <?php echo $this->session->flashdata('alert'); ?>">
                       <?php echo $this->session->flashdata('msg') ?> 
             </div>       
        <?php }
      ?>
     <?php echo form_open_multipart('users/simpan_akun') ?>
         <div class="form-horizontal">
            <div class="form-group">
              <label for="nama" class="col-sm-3 control-label">Name</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="nama" name='nama' placeholder="Name..." required value="<?php echo $user['nama']?>" />
              </div>
            </div>
            <div class="form-group">
              <label for="email" class="col-sm-3 control-label">Email</label>
              <div class="col-sm-9">
                <input type="email" class="form-control" id="email" name='email' placeholder="Email..." required readonly value="<?php echo $user['email']?>" >
              </div>
            </div>
            <div class="form-group">
              <label for="email" class="col-sm-3 control-label">Url Facebook</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="facebook" name='facebook' placeholder="Url Facebook..."  value="<?php echo $user['facebook']?>" >
              </div>
            </div>
            <div class="form-group">
              <label for="email" class="col-sm-3 control-label">Profile Singkat</label>
              <div class="col-sm-9">
                <textarea class="form-control" id="profile" name='profile' placeholder="Profile Singkat..." style='height:200px'><?php echo $user['profile']?></textarea>
              </div>
            </div>
            <div class="form-group" style='margin-top:0px'>
                <label for="email" class="col-sm-3 control-label">Poto Akun</label>
    			<div class='col-sm-1'>
    				<input type="file" style="display:none" class="form-control" id="upload-image" name="upload-image" multiple="multiple"></input>
    				<div id="upload" class="btn btn-default" style=''>
    					<i id='addImage' class='glyphicon glyphicon-plus hide'> Add</i>
    					<div id="thumbnail"><img src="<?php echo base_url($user['gambar'] ? $user['gambar'] : 'assets/img/no_poto.png') ?>" /></div>
    				</div>
    			</div>
    		</div>
            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-10">
                <button type="submit" class="btn btn-primary" name='simpan'>Ubah Akun</button>
              </div>
            </div>
        </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
	
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