<?php 
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT *, CONCAT(lastname, ', ',firstname,' ',COALESCE(middlename,'')) as `name` FROM `users` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0 ){
        foreach($qry->fetch_array() as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
        if($club_id > 0)
        $club = $conn->query("SELECT * FROM club_list where id = '{$club_id}'")->fetch_array()['name'];
    }
}
?>
<style>
    .user-avatar{
        width:10rem;
        height:10rem;
        object-fit: scale-down;
        object-position:center center
    }
</style>
<section class="py-5">
    <div class="container">
        <h2 class="fw-bolder text-center"><b>User Details</b></h2>
        <hr>
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
                <div class="text-center">
                    <img src="<?= validate_image(isset($avatar) ? $avatar : '') ?>" alt="" class="image-thumbnail rounded-circle user-avatar border">
                </div>
                <dl class="row">
                    <dt class="col-3 px-2">Name</dt>
                    <dd class="col-9 px-2"><?= isset($name)? $name : "" ?></dd>
                    <dt class="col-3 px-2">Username</dt>
                    <dd class="col-9 px-2"><p class="mb-0"><?= isset($username) ? $username : '' ?></p></dd>
                    <dt class="col-3 px-2">Club</dt>
                    <dd class="col-9 px-2"><p class="mb-0"><?= isset($club) ? $club : 'N/A' ?></p></dd>
                    <dt class="col-3 px-2">Type</dt>
                    <dd class="col-9 px-2">
                        <?php
                            if(isset($type)){
                                if($type == 1){
                                    echo 'Admin';
                                }else{
                                    echo 'Club\'s Admin/Staff';
                                }
                            }
                        ?>
                    </dd>
                    <hr class="dark">
                    <div class="d-flex w-100 justify-content-end">
                        <div class="col-auto me-2">
                            <a href=".?page=users/manage_user&id=<?= isset($id) ? $id : '' ?>" class="btn btn-primary bg-gradient btn-sm rounded-0 d-flex align-items-center"><span class="material-icons">edit</span> Edit</a>
                        </div>
                        <div class="col-auto">
                            <a href="javascript:void(0)" class="btn btn-danger bg-gradient btn-sm rounded-0 d-flex align-items-center" id="delete_data"><span class="material-icons">delete</span> Delete</a>
                        </div>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</section>
<script>
    $(function(){
        $('#delete_data').click(function(){
            _conf("Are you sure to delete this from list?","delete_user",['<?= isset($id) ? $id : '' ?>'])
        })
    })
    function delete_user($id){
        start_loader();
        var _this = $(this)
        $('.err-msg').remove();
        var el = $('<div>')
        el.addClass("alert alert-danger err-msg")
        el.hide()
        $.ajax({
            url: '../classes/Master.php?f=delete_user',
            method: 'POST',
            data: {
                id: $id
            },
            dataType: 'json',
            error: err => {
                console.log(err)
                el.text('An error occurred.')
                el.show('slow')
                end_loader()
            },
            success: function(resp) {
                if (resp.status == 'success') {
                    location.replace('./?page=user')
                } else if (!!resp.msg) {
                    el.text('An error occurred.')
                    el.show('slow')
                } else {
                    el.text('An error occurred.')
                    el.show('slow')
                }
                end_loader()
            }
        })
    }
</script>