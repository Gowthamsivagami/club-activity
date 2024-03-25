<?php 
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `club_list` where id = '{$_GET['id']}' and delete_flag = 0 ");
    if($qry->num_rows > 0 ){
        foreach($qry->fetch_array() as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
}
?>
<div class="section py-5">
    <div class="container">
        <h2 class="text-center"><b>Applying to <?= isset($name) ? $name : '' ?></b></h2>
        <center>
            <hr class="border-dark border-4 opacity-100" width="10%" style="height:2.5px">
        </center>
        <form action="" id="application-form">
            <input type="hidden" name="id">
            <input type="hidden" name="club_id" value="<?= isset($id) ? $id : '' ?>">
            <div class="row mb-2">
                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group mb-3 input-group input-group-dynamic">
                        <label class="form-label" for="firstname">First Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required="required" id="firstname" name="firstname">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group mb-3 input-group input-group-dynamic">
                        <label class="form-label" for="middlename">Middle Name</label>
                        <input type="text" class="form-control" id="middlename" name="middlename">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group mb-3 input-group input-group-dynamic">
                        <label class="form-label" for="lastname">Last Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required="required" id="lastname" name="lastname">
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group mb-3 input-group input-group-dynamic is-filled">
                        <label class="form-label" for="gender">Gender <span class="text-danger">*</span></label>
                        <select type="text" class="form-select" required="required" id="gender" name="gender">
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group mb-3 input-group input-group-dynamic">
                        <label class="form-label" for="year_level">Year Level <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required="required" id="year_level" name="year_level">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group mb-3 input-group input-group-dynamic">
                        <label class="form-label" for="section">Section <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required="required" id="section" name="section">
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group mb-3 input-group input-group-dynamic">
                        <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" required="required" id="email" name="email">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group mb-3 input-group input-group-dynamic">
                        <label class="form-label" for="contact">Contact # <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required="required" id="contact" name="contact">
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group mb-3">
                        <label class="form-label" for="address">Address <span class="text-danger">*</span></label>
                        <textarea rows="3" class="form-control border px-2 py-3 rounded-0" required="required" id="address" name="address"></textarea>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group mb-3">
                        <label class="form-label" for="message">Why do you want join to this club? <span class="text-danger">*</span></label>
                        <textarea rows="4" class="form-control border px-2 py-3 rounded-0" required="required" id="message" name="message"></textarea>
                    </div>
                </div>
            </div>
            <div class="text-end pt-3">
                <button class="btn btn-primary btn-sm"><span class="material-icons">send</span> Submit Application</button>
                <a href="./?page=clubs/view_details&id=<?= isset($id) ? $id : '' ?>" class="btn btn-light border btn-sm"><span class="material-icons">arrow_back_ios</span> Cancel</a>
            </div>
        </form>
    </div>
</div>
<script>
    $(function(){
        $('#application-form').submit(function(e){
            e.preventDefault()
            $('.pop-alert').remove()
            var _this = $(this)
            var el = $('<div>')
            el.addClass("pop-alert alert alert-danger text-light")
            el.hide()
            start_loader()
            $.ajax({
                url:'./classes/Master.php?f=save_application',
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
                        location.href= './?page=clubs/view_details&id=<?= isset($id) ? $id : '' ?>';
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