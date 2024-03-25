<section class="py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-4 position-relative bg-gradient bg-opacity-25">
                <div class="p-3 text-center">
                    <?php 
                    $clubs = $conn->query("SELECT * FROM `club_list` where delete_flag = 0")->num_rows;
                    ?>
                    <h1 class=""><span id="state1" countto="70"><?= number_format($clubs) ?></span></h1>
                    <h5 class="mt-3 ">Clubs</h5>
                    <p class="text-lg h2 font-weight-normal text-dark"><span style="font-size:3rem" class="material-icons">view_list</span></p>
                </div>
            </div>
            <div class="col-md-4 position-relative bg-gradient bg-opacity-50">
                <div class="p-3 text-center">
                    <?php 
                    $users = $conn->query("SELECT * FROM `users` where `type` = 2 ")->num_rows;
                    ?>
                    <h1 class=""><span id="state1" countto="70"><?= number_format($users) ?></span></h1>
                    <h5 class="mt-3 ">Club Admin/Staff Users</h5>
                    <p class="text-lg h2 font-weight-normal text-muted"><span style="font-size:3rem" class="material-icons">people_alt</span></p>
                </div>
                <hr class="vertical dark border-dark">
            </div>
            <div class="col-md-4 position-relative bg-gradient bg-opacity-50">
                <div class="p-3 text-center">
                    <?php 
                    $applications = $conn->query("SELECT * FROM `application_list`")->num_rows;
                    ?>
                    <h1 class=""><span id="state1" countto="70"><?= number_format($applications) ?></span></h1>
                    <h5 class="mt-3 ">Applications</h5>
                    <p class="text-lg h2 font-weight-normal text-primary"><span style="font-size:3rem" class="material-icons">text_snippet</span></p>
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