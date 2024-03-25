<section class="py-4">
    <div class="container">
        <h3 class="fw-bolder text-center">User List</h3>
        <center>
            <hr class="bg-primary w-25 opacity-100">
        </center>
        <table class="table table-striped table-bordered dt-init">
            <colgroup>
                <col width="5%">
                <col width="15%">
                <col width="25%">
                <col width="25%">
                <col width="15%">
                <col width="15%">
            </colgroup>
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Updated</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Club</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</section>
<noscript id="action-btn-clone">
<div class="dropdown">
<button class="btn btn-primary btn-sm bg-gradient rounded-0 mb-0" type="button" id="" data-bs-toggle="dropdown" aria-expanded="false">
    Action <span class="material-icons">keyboard_arrow_down</span>
</button>
    <ul class="dropdown-menu" aria-labelledby="">
        <li><a class="dropdown-item view_data w-100 d-flex align-items-center" href="javascript:void(0)"><span class="material-icons me-2">wysiwyg</span> View</a></li>
        <li><a class="dropdown-item edit_data w-100 d-flex align-items-center" href="javascript:void(0)"><span class="material-icons me-2">edit</span> Edit</a></li>
        <li><a class="dropdown-item reset_pass w-100 d-flex align-items-center" href="javascript:void(0)"><span class="material-icons me-2">lock_reset</span> Reset Password</a></li>
        <li><a class="dropdown-item delete_data w-100 d-flex align-items-center" href="javascript:void(0)"><span class="material-icons me-2">delete</span> Delete</a></li>
    </ul>
</div>
</noscript>
<script>
    $(function(){
        $('.dt-init').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url:"../classes/Master.php?f=dt_users",
                method:"POST"
            },
            columns: [{
                    data: 'no',
                    className: 'py-1 px-2 text-center',
                    width:"5%"
                },
                {
                    data: 'date_updated',
                    className: 'py-1 px-2',
                    width:"15%"
                },
                {
                    data: 'name',
                    className: 'name',
                    width:"25%"
                },
                {
                    data: 'club',
                    className: 'club',
                    width:"25%"
                },
                {
                    className: 'py-1 px-2 text-center',
                    render:function(data, type, row, meta){
                        if(row.type == 1)
                            return 'Administrator';
                        else
                            return 'Club\'s Admin/Staff';
                    },
                    width:"15%"
                },
                {
                    data: null,
                    orderable: false,
                    className: 'text-center py-1 px-2',
                    render: function(data, type, row, meta) {
                        var el = $('<div>')
                        el.append($($('noscript#action-btn-clone').html()).clone())
                        el.attr('id','dropdown'+row.id)
                        el.find('.dropdown-menu').attr('aria-labelledby','dropdown'+row.id)
                        el.find('.edit_data,.delete_data,.view_data,.reset_pass').attr('data-id',row.id).attr('data-name',row.name)
                        el.find('.edit_data').attr("href","./?page=users/manage_user&id="+row.id)
                        el.find('.view_data').attr("href","./?page=users/view_details&id="+row.id)
                        
                        return el.html();
                        
                    },
                    width:"15%"
                }
            ],
            columnDefs: [{
                orderable: false,
                targets: [2,5]
            }],
            initComplete: function(settings, json) {
                $('table td, table th').addClass('px-2 py-1 align-middle')
            },
            drawCallback: function(settings) {
                $('table td, table th').addClass('px-2 py-1 align-middle')
                $('.delete_data').click(function(){
                    _conf("Are you sure to delete <b>"+$(this).attr('data-name')+"</b> from list?","delete_user",[$(this).attr('data-id')])
                })
                $('.reset_pass').click(function(){
                    _conf("Are you sure to reset <b>"+$(this).attr('data-name')+"'s</b> password?","reset_pass",[$(this).attr('data-id')])
                })
            },
            language:{
                oPaginate: {
                    sNext: '<i class="fa fa-angle-right"></i>',
                    sPrevious: '<i class="fa fa-angle-left"></i>',
                    sFirst: '<i class="fa fa-step-backward"></i>',
                    sLast: '<i class="fa fa-step-forward"></i>'
                }
            }
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
                    location.reload()
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
    function reset_pass($id){
        start_loader();
        var _this = $(this)
        $('.err-msg').remove();
        var el = $('<div>')
        el.addClass("alert alert-danger err-msg")
        el.hide()
        $.ajax({
            url: '../classes/Master.php?f=save_user',
            method: 'POST',
            data: {
                id: $id,
                reset_password:true
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
                    location.reload()
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