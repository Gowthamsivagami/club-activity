<?php 
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT a.*,c.name as club, CONCAT(a.lastname,', ',a.firstname,' ', COALESCE(a.middlename,'')) as `name`, CONCAT(a.year_level,' - ',a.section) as `class` FROM `application_list` a inner join club_list c on a.club_id =c.id where a.id = '{$_GET['id']}'");
    if($qry->num_rows > 0 ){
        foreach($qry->fetch_array() as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
}
?>
<style>
    .application-logo{
        width:10rem;
        height:10rem;
        object-fit: scale-down;
        object-position:center center
    }
</style>
<section class="py-4">
    <div class="container">
        <dl class="row">
            <dt class="col-4 border py-1">Applying To</dt>
            <dd class="col-8 px-2 border py-1 mb-0"><?= isset($club) ? $club : "" ?></dd>
            <dt class="col-4 border py-1">Name</dt>
            <dd class="col-8 px-2 border py-1 mb-0"><?= isset($name) ? $name : "" ?></dd>
            <dt class="col-4 border py-1">Year Level - Section</dt>
            <dd class="col-8 px-2 border py-1 mb-0"><?= isset($class) ? $class : "" ?></dd>
            <dt class="col-4 border py-1">Gender</dt>
            <dd class="col-8 px-2 border py-1 mb-0"><?= isset($gender) ? $gender : "" ?></dd>
            <dt class="col-4 border py-1">Contact #</dt>
            <dd class="col-8 px-2 border py-1 mb-0"><?= isset($contact) ? $contact : "" ?></dd>
            <dt class="col-4 border py-1">Email</dt>
            <dd class="col-8 px-2 border py-1 mb-0"><?= isset($email) ? $email : "" ?></dd>
            <dt class="col-4 border py-1">Address</dt>
            <dd class="col-8 px-2 border py-1 mb-0"><?= isset($address) ? $address : "" ?></dd>
            <dt class="col-4 border py-1">Message</dt>
            <dd class="col-8 px-2 border py-1 mb-0"><?= isset($message) ? $message : "" ?></dd>
            <dt class="col-4 border py-1">Status</dt>
            <dd class="col-8 px-2 border py-1 mb-0">
                <?php 
                $status = isset($status)? $status : '';
                    switch($status){
                        case 0:
                            echo '<span class="badge bg-default border text-muted bg-gradient px-3 rounded-pill">Pending</span>' ;
                            break;
                        case 1:
                            echo '<span class="badge bg-primary bg-gradient px-3 rounded-pill">Confirmed</span>' ;
                            break;
                        case 2:
                            echo '<span class="badge bg-success bg-gradient px-3 rounded-pill">Approved</span>' ;
                            break;
                        case 3:
                            echo '<span class="badge bg-danger bg-gradient px-3 rounded-pill">Denied</span>' ;
                            break;
                    }
                ?>    
            </dd>
        </dl>
        <div class="text-end pt-3">
            <button id="update_status" type="button" class="btn btn-primary bg-gradient btn-sm"><span class="material-icons">edit</span> Update Status</button>
            <a href="javascript:void(0)" class="btn btn-danger bg-gradient btn-sm" id="delete_data"><span class="material-icons">delete</span> Delete</a>
            <a href="./?page=applications" class="btn btn-light border btn-sm"><span class="material-icons">arrow_back_ios</span> Back to List</a>
        </div>
    </div>
</section>
<script>
    $(function(){
        $('#delete_data').click(function(){
            _conf("Are you sure to delete this from list?","delete_application",['<?= isset($id) ? $id : '' ?>'])
        })
        $('#update_status').click(function(){
            uni_modal("Updating Application Status", 'applications/update_status.php?id=<?= isset($id) ? $id : '' ?>')
        })
    })
    function delete_application($id){
        start_loader();
        var _this = $(this)
        $('.err-msg').remove();
        var el = $('<div>')
        el.addClass("alert alert-danger err-msg")
        el.hide()
        $.ajax({
            url: '../classes/Master.php?f=delete_application',
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