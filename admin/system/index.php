<style>
	img#cimg{
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
	img#cimg2{
		height: 50vh;
		width: 100%;
		object-fit: contain;
		/* border-radius: 100% 100%; */
	}
</style>
<section class="py-3">
    <div class="container">
        <h3 class="fw-bolder text-center">Manage System Information</h3>
        <center>
            <hr class="bg-primary w-25 opacity-100">
        </center>
        <form action="" id="system-form">
            <div class="form-group input-group input-group-dynamic is-filled mb-3">
                <label for="name" class="form-label">System Name</label>
                <input type="text" class="form-control" value="<?= $_settings->info('name') ?>" name="name" id="name">
            </div>
            <div class="form-group input-group input-group-dynamic is-filled mb-3">
                <label for="short_name" class="form-label">System Short Name</label>
                <input type="text" class="form-control" value="<?= $_settings->info('short_name') ?>" name="short_name" id="short_name">
            </div>
            <div class="form-group mb-3">
				<label for="" class="form-label">Welcome Content</label>
	             <textarea name="content[welcome]" id="" cols="30" rows="2" class="form-control summernote"><?php echo  is_file(base_app.'welcome.html') ? file_get_contents(base_app.'welcome.html') : "" ?></textarea>
			</div>
			<div class="form-group mb-3">
				<label for="" class="form-label">About Us</label>
	             <textarea name="content[about]" id="" cols="30" rows="2" class="form-control summernote"><?php echo  is_file(base_app.'about.html') ? file_get_contents(base_app.'about.html') : "" ?></textarea>
			</div>
            <div class="form-group mb-3 input-group input-group-dynamic is-filled">
				<label for="" class="form-label">System Logo</label>
                <input type="file" class="py-2" id="customFile" name="img" onchange="displayImg(this,$(this))">
			</div>
			<div class="form-group mb-3 d-flex justify-content-center">
				<img src="<?php echo validate_image($_settings->info('logo')) ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
			</div>
			<div class="form-group mb-3 input-group input-group-dynamic is-filled">
                <label for="" class="form-label">Website Cover</label>
                <input type="file" class="py-2" id="customFile" name="cover" onchange="displayImg2(this,$(this))">
			</div>
			<div class="form-group mb-3 d-flex justify-content-center">
				<img src="<?php echo validate_image($_settings->info('cover')) ?>" alt="" id="cimg2" class="img-fluid img-thumbnail">
			</div>
            <div class="text-center mt-2">
                 <button class="btn btn-primary bg-gradient btn-sm rounded-0 d-flex align-items-center w-100 justify-content-center"><span class="material-icons">update</span> Update</button>
            </div>
        </form>
    </div>
</section>
<script>
    function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }else{
            $('#cimg').attr('src', '<?php echo validate_image($_settings->info('logo')) ?>');
        }
	}
	function displayImg2(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg2').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }else{
            $('#cimg').attr('src', '<?php echo validate_image($_settings->info('cover')) ?>');
        }
	}
    $(document).ready(function(){
		 $('.summernote').summernote({
		        height: 200,
		        toolbar: [
		            [ 'style', [ 'style' ] ],
		            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
		            [ 'fontname', [ 'fontname' ] ],
		            [ 'fontsize', [ 'fontsize' ] ],
		            [ 'color', [ 'color' ] ],
		            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
		            [ 'table', [ 'table' ] ],
		            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
		        ]
		    })
            $('#system-form').submit(function(e){
            e.preventDefault()
            $('.pop-alert').remove()
            var _this = $(this)
            var el = $('<div>')
            el.addClass("pop-alert alert alert-danger text-light")
            el.hide()
            if($('[name="to_user"]').val() == ''){
                el.text('Recepient is required.')
                _this.prepend(el)
                el.show('slow')
                $('html, body').scrollTop(_this.offset().top - '150')
                return false;
            }
            start_loader()
            $.ajax({
                url:'../classes/SystemSettings.php?f=update_settings',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error:err=>{
                    console.error(err)
                    el.text("An error occured while saving data")
                    _this.prepend(el)
                    el.show('slow')
                    $('html, body').scrollTop(_this.offset().top - '150')
                    end_loader()
                },
                success:function(resp){
                    if(resp.status == 'success'){
                        location.reload();
                    }else if(!!resp.msg){
                        el.text(resp.msg)
                        _this.prepend(el)
                        el.show('slow')
                        $('html, body').scrollTop(_this.offset().top - '150')
                    }else{
                        el.text("An error occured while saving data")
                        _this.prepend(el)
                        el.show('slow')
                        $('html, body').scrollTop(_this.offset().top - '150')
                    }
                    end_loader()
                    console

                }
            })
        })
	})
</script>