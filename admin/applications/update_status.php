<?php 
require_once("./../../config.php");
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `application_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0 ){
        foreach($qry->fetch_array() as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
}
?>
<div class="container-fluid">
    <form action="" id="application-form" class="py-3">
        <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
        <div class="form-group">
            <label for="status" class="form-label">Status <span class="text-primary">*</span></label>
            <select name="status" id="status" class="form-select rounded-0" required>
                <option class="px-2 py-2" value="0" <?= isset($status) && $status == 0 ? 'selected': '' ?>>Pending</option>
                <option class="px-2 py-2" value="1" <?= isset($status) && $status == 1 ? 'selected': '' ?>>Confirmed</option>
                <option class="px-2 py-2" value="2" <?= isset($status) && $status == 2 ? 'selected': '' ?>>Approved</option>
                <option class="px-2 py-2" value="3" <?= isset($status) && $status == 3 ? 'selected': '' ?>>Denied</option>
            </select>
        </div>
    </form>
</div>
<script>
    var fuser_ajax;
    function displayImg(input,_this) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#cimg').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }else{
            $('#cimg').attr('src', '<?php echo validate_image(isset($logo_path) ? $logo_path : '') ?>');
        }
    }
    $(function(){
        $('#content').summernote({
            height: 200,
            theme:'bootstrap',
            toolbar: [
                [ 'style', [ 'style' ] ],
                [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
                [ 'fontname', [ 'fontname' ] ],
                [ 'fontsize', [ 'fontsize' ] ],
                [ 'color', [ 'color' ] ],
                [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
                [ 'table', [ 'table' ] ],
                [ 'insert', [ 'picture', 'video' ] ],
                [ 'view', [ 'undo', 'redo', 'help' ] ]
            ]
        })
        $('.note-modal').find('.close').addClass('btn-close')
        $('.note-modal').find('.close').attr('data-bs-dismiss','modal')
        $('#application-form').submit(function(e){
            e.preventDefault()
            $('.pop-alert').remove()
            var _this = $(this)
            var el = $('<div>')
            el.addClass("pop-alert alert alert-danger text-light")
            el.hide()
            start_loader()
            $.ajax({
                url:'../classes/Master.php?f=save_application',
                type:'POST',
                method:'POST',
                cache:false,
                contentType:false,
                processData:false,
                data:new FormData(_this[0]),
                dataType:'json',
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