
    <footer class="footer mt-5 <?= in_array($page,['login','registration']) ? " w-100 bg-dark" : "" ?>">
        <div class="container">
            <div class=" row">
                <div class="col-12">
                    <div class="text-center">
                        <p class="<?= in_array($page,['login','registration']) ? "text-primary" : "text-dark" ?> my-4 text-sm font-weight-normal">
                            All rights reserved. Copyright ©
                            <script>
                                <?= date('Y') ?>
                            </script> <?= $_settings->info('short_name') ?> by <a href="mailto:oretnom23@gmail.com" target="_blank">oretnom23</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--   Core JS Files   -->
    <script src="<?= base_url ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- <script src="<?= base_url ?>assets/bootstrap/js/bootstrap.bundle.min.js" type="text/javascript"></script> -->
    <script src="<?= base_url ?>assets/js/plugins/perfect-scrollbar.min.js"></script>
    <!-- DataTables -->
    <script src="<?= base_url ?>assets/DataTables/datatables.min.js"></script>
    <script src="<?= base_url ?>assets/DataTables/RowReorder-1.2.8/js/dataTables.rowReorder.min.js"></script>
    <script src="<?= base_url ?>assets/DataTables/Responsive-2.2.9/js/dataTables.responsive.min.js"></script>

    <!-- Select2 -->
    <script src="<?= base_url ?>assets/select2/dist/js/select2.min.js"></script>



    <!--  Plugin for TypedJS, full documentation here: https://github.com/inorganik/CountUp.js -->
    <script src="<?= base_url ?>assets/js/plugins/countup.min.js"></script>

    <script src="<?= base_url ?>assets/js/plugins/choices.min.js"></script>

    <script src="<?= base_url ?>assets/js/plugins/prism.min.js"></script>
    <script src="<?= base_url ?>assets/js/plugins/highlight.min.js"></script>

    <!--  Plugin for Parallax, full documentation here: https://github.com/dixonandmoe/rellax -->
    <script src="<?= base_url ?>assets/js/plugins/rellax.min.js"></script>
    <!--  Plugin for TiltJS, full documentation here: https://gijsroge.github.io/tilt.js/ -->
    <script src="<?= base_url ?>assets/js/plugins/tilt.min.js"></script>
    <!--  Plugin for Selectpicker - ChoicesJS, full documentation here: https://github.com/jshjohnson/Choices -->
    <script src="<?= base_url ?>assets/js/plugins/choices.min.js"></script>


    <!--  Plugin for Parallax, full documentation here: https://github.com/wagerfield/parallax  -->
    <script src="<?= base_url ?>assets/js/plugins/parallax.min.js"></script>
    
    <!-- Summernote  -->
    <script src="<?= base_url ?>assets/summernote/summernote.min.js" type="text/javascript"></script>


    <!-- Control Center for Material UI Kit: parallax effects, scripts for the example pages etc -->
    <!--  Google Maps Plugin    -->

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTTfWur0PDbZWPr7Pmq8K3jiDp0_xUziI"></script>
    <script src="<?= base_url ?>assets/js/material-kit.min.js?v=3.0.2" type="text/javascript"></script>
    <script>
        $(function(){
            $('.modal').on('show.bs.modal',function(){
                console.log('test')
                $('.blur').addClass('blur-reset')
            })
            $('.modal').on('hidden.bs.modal',function(){
                $('.blur').removeClass('blur-reset')
            })
            window.uni_modal = function($title = '' , $url='',$size=""){
            start_loader()
            $.ajax({
                url:$url,
                error:err=>{
                    console.log()
                    alert("An error occured")
                },
                success:function(resp){
                    if(resp){
                        $('#uni_modal .modal-title').html($title)
                        $('#uni_modal .modal-body').html(resp)
                        if($size != ''){
                            $('#uni_modal .modal-dialog').addClass($size+'  modal-dialog-centered')
                        }else{
                            $('#uni_modal .modal-dialog').removeAttr("class").addClass("modal-dialog modal-md modal-dialog-centered")
                        }
                       
                        $('#uni_modal').modal('show')
                        end_loader()
                    }
                }
            })
        }
        window._conf = function($msg='',$func='',$params = []){
            $('#confirm_modal #confirm').attr('onclick',$func+"("+$params.join(',')+")")
            $('#confirm_modal .modal-body').html($msg)
            $('#confirm_modal').modal('show')
        }
        })
    </script>
