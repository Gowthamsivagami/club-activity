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
<style>
    .club-logo{
        width:10rem;
        height:10rem;
        object-fit: scale-down;
        object-position:center center
    }
</style>
<section class="py-4">
    <div class="container">
        <div class="text-center">
            <img src="<?= validate_image(isset($logo_path) ? $logo_path : '') ?>" alt="" class="image-thumbnail rounded-circle club-logo border">
        </div>
        <dl>
            <dt>Club Name</dt>
            <dd class="ps-4"><?= isset($name) ? $name : "" ?></dd>
            <dt>Short Description</dt>
            <dd class="ps-4"><?= isset($description) ? $description : "" ?></dd>
            <dt>About the Club</dt>
            <dd class="ps-4"><?= isset($id) && is_file(base_app."/club_contents/{$id}.html") ? file_get_contents(base_app."/club_contents/{$id}.html") : '' ?></dd>
            <dt>Status</dt>
            <dd class="ps-4">
                <?php 
                if(isset($status)):
                    if($status == 1):
                        echo '<span class="badge bg-primary bg-gradient px-3 rounded-pill">Active</span>' ;
                    else:
                        echo '<span class="badge bg-secondary bg-gradient px-3 rounded-pill">Inactive</span>' ;
                    endif;
                endif;
                ?>    
            </dd>
        </dl>
        <div class="text-end pt-3">
            <a href=".?page=clubs/manage_club&id=<?= isset($id) ? $id : '' ?>" class="btn btn-primary bg-gradient btn-sm"><span class="material-icons">edit</span> Edit</a>
            <a href="javascript:void(0)" class="btn btn-danger bg-gradient btn-sm" id="delete_data"><span class="material-icons">delete</span> Delete</a>
            <a href="./?page=clubs" class="btn btn-light border btn-sm"><span class="material-icons">arrow_back_ios</span> Back to List</a>
        </div>
    </div>
</section>
<script>
    $(function(){
        $('#delete_data').click(function(){
            _conf("Are you sure to delete this from list?","delete_club",['<?= isset($id) ? $id : '' ?>'])
        })
    })
    function delete_club($id){
        start_loader();
        var _this = $(this)
        $('.err-msg').remove();
        var el = $('<div>')
        el.addClass("alert alert-danger err-msg")
        el.hide()
        $.ajax({
            url: '../classes/Master.php?f=delete_club',
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
                    location.replace('./?page=clubs')
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