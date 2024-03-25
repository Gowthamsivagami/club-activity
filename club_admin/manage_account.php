<?php 

$qry = $conn->query("SELECT * FROM `users` where id = '{$_settings->userdata('id')}'");
if($qry->num_rows > 0){
    foreach($qry->fetch_array() as $k => $v){
        if(!is_numeric($k)){
            $$k = $v;
        }
    }
}

?>
<section class="py-4">
    <div class="container">
    <h4 class="fw-bolder text-center">Update User Details</h4>
            <hr class="bg-primary">
            <br>
            <form action="" id="update-user-form">
                <input type="hidden" name="id" value="<?= $_settings->userdata('id') ?>">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3 input-group input-group-dynamic is-filled">
                            <label for="firstname" class="form-label">First Name <span class="text-primary">*</span></label>
                            <input type="text" name="firstname" id="firstname" autofocus class="form-control form-control-lg" value="<?= isset($firstname) ?  $firstname : '' ?>" required="required">
                        </div>
                        <div class="form-group mb-3 input-group input-group-dynamic is-filled">
                            <label for="middlename" class="form-label">Middle Name</label>
                            <input type="text" name="middlename" id="middlename" class="form-control form-control-lg" value="<?= isset($middlename) ?  $middlename : '' ?>">
                        </div>
                        <div class="form-group mb-3 input-group input-group-dynamic is-filled">
                            <label for="lastname" class="form-label">Last Name <span class="text-primary">*</span></label>
                            <input type="text" name="lastname" id="lastname" class="form-control form-control-lg" value="<?= isset($lastname) ?  $lastname : '' ?>" required="required">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3 input-group input-group-dynamic is-filled">
                            <label for="username" class="form-label">Username</label>
                            <span class="input-group-text"><i class="material-icons" aria-hidden="true">person_outline</i></span>
                            <input type="text" name="username" id="username" class="form-control form-control-lg" value="<?= isset($username) ?  $username : '' ?>" required="required">
                        </div>
                        <div class="form-group mb-3 input-group input-group-dynamic is-filled">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" name="password" id="password" class="form-control form-control-lg">
                            <button type="button" tabindex="-1" class="btn btn-outline-primary btn-lg mb-0 rounded-0 border-0 px-1 pass_view"><i class="material-icons">visibility_off</i></button>
                        </div>
                        <div class="form-group mb-3 input-group input-group-dynamic is-filled">
                            <label for="cpassword" class="form-label">Confirm New Password</label>
                            <input type="password" id="cpassword" class="form-control form-control-lg">
                            <button type="button" tabindex="-1" class="btn btn-outline-primary btn-lg mb-0 rounded-0 border-0 px-1 pass_view"><i class="material-icons">visibility_off</i></button>
                        </div>
                        <div class="form-group input-group input-group-dynamic is-filled">
                            <label for="image" class="form-label">Avatar <span class="text-primary">*</span></label>
                            <input type="file" name="image" id="image" class="form-control form-control-lg" accept="image/jpeg, image/png">
                        </div>
                        <div class="form-group">
                            <small><span class="text-muted">Current Avatar: <a target="_blank" class="text-primary" href="<?= base_url. (isset($avatar) ? $avatar : '') ?>"><?= (isset($avatar) ? str_replace("uploads/users/","",explode("?", $avatar)[0]) : '') ?></a></span></small>
                        </div>
                    </div>
                </div>
                
            <br>
            <div class="row justify-content-between align-items-center">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6 text-end">
                    <button class="btn btn-primary bg-gradient rounded-0 mb-0">Update Account</button>
                </div>
            </div>
            </form>
    </div>
</section>
<script>
    $(function(){
        $('#update-user-form').submit(function(e){
                e.preventDefault()
                $('.pop-alert').remove()
                var _this = $(this)
                var el = $('<div>')
                el.addClass("pop-alert alert alert-danger text-light mb-3 rounded-0 px-1 py-2")
                el.hide()
                if($('#password').val() != $('#cpassword').val()){
                    el.text('Passwords do not match.')
                    _this.prepend(el)
                    el.show('slow')
                    $('html, body').scrollTop(_this.offset().top - '150')
                    return false;
                }
                start_loader()
                $.ajax({
                    url:'../classes/Users.php?f=save_user',
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
                    }
                })
            })
    })
</script>