<?php 
require_once('auth.php');
?>
<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url ?>assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="<?= validate_image($_settings->info('logo')) ?>">

    <title><?= ucwords(str_replace(["_","/"]," ",$page)) ?> | <?= $_settings->info('name') ?></title>



    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="<?= base_url ?>assets/font-awesome/css/all.min.css" />

    <!-- Font Awesome Icons -->
    <script src="<?= base_url ?>assets/font-awesome/js/all.min.js" crossorigin="anonymous"></script>

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <script src="<?= base_url ?>assets/bootstrap/js/popper.min.js" type="text/javascript"></script>

    <script src="<?= base_url ?>assets/js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <!-- CSS Files -->
    <link href="<?= base_url ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= base_url ?>assets/css/material-kit.css?v=3.0.2" rel="stylesheet" />
    <link href="<?= base_url ?>assets/summernote/summernote-lite.min.css" rel="stylesheet" />
    <link href="<?= base_url ?>assets/DataTables/datatables.min.css" rel="stylesheet" />
    <link href="<?= base_url ?>assets/DataTables/RowReorder-1.2.8/css/dataTables.rowReorder.min.css" rel="stylesheet" />
    <link href="<?= base_url ?>assets/DataTables/Responsive-2.2.9/css/dataTables.responsive.min.css" rel="stylesheet" />
    <link href="<?= base_url ?>assets/select2/dist/css/select2.min.css" rel="stylesheet" />
    <link href="<?= base_url ?>assets/css/custom.css" rel="stylesheet" />

    <script>
            var loader = $('<div id="pre-loader">')
            loader.html('<div class="lds-ring"><div></div><div></div><div></div><div></div></div>')
            function start_loader(){
                $('body').find('#pre-loader').remove()
                $('body').prepend(loader)
            }
            function end_loader(){
                $('body').find('#pre-loader').remove()
            }
            $(function(){
                setTimeout(() => {
                    end_loader()
                }, 500);
            })
    </script>

</head>