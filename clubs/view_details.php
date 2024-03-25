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
        width:20rem;
        height:20rem;
        object-fit: cover;
        object-position:center center
    }
    .text-gray-600{
        color:var(--bs-gray-600)
    }
    
    .text-gray-700{
        color:var(--bs-gray-700)
    }
</style>
<section class="py-4">
    <div class="container">
        <div class="text-center mb-3">
            <img src="<?= validate_image(isset($logo_path) ? $logo_path : '') ?>" alt="" class="image-thumbnail rounded-circle club-logo border">
        </div>
        <h2 class="text-center"><b><?= isset($name) ? $name : '' ?></b></h2>
        <center>
            <hr class="border-dark border-4 opacity-100" width="10%" style="height:2.5px">
        </center>
        <p class="text-center text-gray-600"><?= isset($description) ? $description : "" ?></p>
        <h3 class="text-center text-gray-600"><b>About Us</b></h3>
        <center>
            <hr class="border-dark border-4 opacity-100" width="10%" style="height:2.5px">
        </center>
        <div class="text-gray-500"><?= isset($id) && is_file(base_app."/club_contents/{$id}.html") ? file_get_contents(base_app."/club_contents/{$id}.html") : '' ?></div>
        <div class="text-end pt-3">
            <a href="./?page=clubs/application_form&id=<?= isset($id) ? $id : '' ?>" class="btn btn-primary btn-sm"><span class="material-icons">text_snippet</span> Apply to this Club</a>
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