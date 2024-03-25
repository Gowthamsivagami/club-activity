<style>
    .club-item:nth-child(2n-5){
        backdrop-filter: brightness(0.9);
    }
    .club-item:hover{
        backdrop-filter: brightness(0.78);
    }
    .club-item:hover .club-logo{
        transform:scale(1.2)
    }
    .img-holder{
        width:15rem;
        height:15rem;
    }
    .club-logo{
        width:100%;
        height:100%;
        object-fit:cover;
        object-position:center center;
        transition: all .2s ease-in-out;
    }
    .truncate-3{
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
<section class="py-4">
    <div class="container">
        <h3 class="fw-bolder text-center">Club List</h3>
        <center>
            <hr class="bg-primary w-25 opacity-100">
        </center>
        <div class="row justify-content-center py-5">
            <?php 
            $clubs = $conn->query("SELECT * FROM `club_list` where `status` = 1 and delete_flag = 0 order by `name` asc ");
            while($row = $clubs->fetch_assoc()):
            ?>
            <a href='./?page=clubs/view_details&id=<?= $row['id'] ?>' class="col-md-4 club-item px-3 py-4">
                <div class="d-flex justify-content-center">
                    <div class="img-holder position-relative overflow-hidden border rounded-circle">
                        <img src="<?= validate_image($row['logo_path']) ?>" alt="<?= $row['name'] ?>" class="image-thumbnail club-logo">
                    </div>
                </div>
                <h5 class="text-center"><b><?= $row['name'] ?></b></h5>
                <p class="text-sm text-muted text-center truncate-3"><?= $row['description'] ?></p>
            </a>
            <?php endwhile; ?>
        </div>
    </div>
</section>
<script>
    $(function(){
        
    })
   
</script>