<section class="py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-3 position-relative bg-gradient bg-opacity-50">
                <div class="p-3 text-center">
                    <?php 
                    $applications = $conn->query("SELECT * FROM `application_list` where club_id = '{$_settings->userdata('club_id')}' and `status` = 0")->num_rows;
                    ?>
                    <h1 class=""><span id="state1" countto="70"><?= number_format($applications) ?></span></h1>
                    <h5 class="mt-3 ">Pending Applications</h5>
                    <p class="text-lg h2 font-weight-normal text-muted"><span style="font-size:3rem" class="material-icons">text_snippet</span></p>
                </div>
                <hr class="vertical dark border-dark">
            </div>
            <div class="col-md-3 position-relative bg-gradient bg-opacity-50">
                <div class="p-3 text-center">
                    <?php 
                    $applications = $conn->query("SELECT * FROM `application_list` where club_id = '{$_settings->userdata('club_id')}' and `status` = 1")->num_rows;
                    ?>
                    <h1 class=""><span id="state1" countto="70"><?= number_format($applications) ?></span></h1>
                    <h5 class="mt-3 ">Confirmed Applications</h5>
                    <p class="text-lg h2 font-weight-normal text-primary"><span style="font-size:3rem" class="material-icons">text_snippet</span></p>
                </div>
                <hr class="vertical dark border-dark">
            </div>
            <div class="col-md-3 position-relative bg-gradient bg-opacity-50">
                <div class="p-3 text-center">
                    <?php 
                    $applications = $conn->query("SELECT * FROM `application_list` where club_id = '{$_settings->userdata('club_id')}' and `status` = 2")->num_rows;
                    ?>
                    <h1 class=""><span id="state1" countto="70"><?= number_format($applications) ?></span></h1>
                    <h5 class="mt-3 ">Approved Applications</h5>
                    <p class="text-lg h2 font-weight-normal text-success"><span style="font-size:3rem" class="material-icons">text_snippet</span></p>
                </div>
                <hr class="vertical dark border-dark">
            </div>
            <div class="col-md-3 position-relative bg-gradient bg-opacity-50">
                <div class="p-3 text-center">
                    <?php 
                    $applications = $conn->query("SELECT * FROM `application_list` where club_id = '{$_settings->userdata('club_id')}' and `status` = 3")->num_rows;
                    ?>
                    <h1 class=""><span id="state1" countto="70"><?= number_format($applications) ?></span></h1>
                    <h5 class="mt-3 ">Denied Applications</h5>
                    <p class="text-lg h2 font-weight-normal text-danger"><span style="font-size:3rem" class="material-icons">text_snippet</span></p>
                </div>
                <hr class="vertical dark border-dark">
            </div>
        </div>
    </div>
</section>

<section class="py-1">
    <div class="container">
        <h3 class="text-center fw-bolder">Welcome to <?= $_settings->info('name') ?></h3>
    </div>
</section>