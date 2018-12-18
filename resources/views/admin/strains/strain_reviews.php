<!DOCTYPE html>
<html lang="en">
<?php include resource_path('views/admin/includes/head.php'); ?>
<body>
<?php include resource_path('views/admin/includes/header.php'); ?>
<?php include resource_path('views/admin/includes/sidebar.php'); ?>
<section class="content lifeContent">

    <?php if(\Session::has('success')) { ?>
        <h4 class="alert alert-success fade in">
            <?php echo \Session::get('success') ?>
        </h4>
    <?php } ?>
    <a class="add_s" href="<?php echo asset('strains'); ?>">Back</a>

    <div class="contentPd">
        <h2 class="mainHEading">Strain: <?= $strain->title; ?></h2>
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Sr.</th>
                <th>Review Text</th>
                <th>User</th>
                <th>Rating</th>
                <th>Review Flag Count</th>
            </tr>
            </thead>
            <tbody>
            <?php if(count($strain_reviews) > 0){ ?>
                <?php 
                $i = 1;
                foreach($strain_reviews as $strain_review){ ?>
                    <tr>
                        <td><?php echo $i; $i++; ?></td>
                        <td><?= $strain_review->review;?></td>
                        <td><?= $strain_review->getUser->first_name;?></td>
                        <?php if($strain_review->rating){ ?>
                            <td><?= $strain_review->rating->rating;?></td>
                        <?php } else{ ?>
                            <td>0</td>
                        <?php } ?>
                            <td><a href="<?php echo asset('get_strain_reviews_flags/'.$strain->id.'/'.$strain_review->id)?>"><?= $strain_review->flags_count;?></a></td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
</section>
<?php include resource_path('views/admin/includes/footer.php'); ?>
</body>
</html>


