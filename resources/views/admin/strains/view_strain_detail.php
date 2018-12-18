<!DOCTYPE html>
<html lang="en">
<?php include resource_path('views/admin/includes/head.php'); ?>
<body>
<?php include resource_path('views/admin/includes/header.php'); ?>
<?php include resource_path('views/admin/includes/sidebar.php'); ?>
<section class="content lifeContent">
    <div class="container container-width">
        <div class="row">
            <div class="col-md-3 col-sm-4">
                <div class="statbox tabs tabe-margin">
                    <div class="stat-title">Total User Strains: <?= $user_strains_count; ?></div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="statbox tabs tabe-margin">
                    <div class="stat-title">Strain Likes: <?= $strain_likes_count; ?></div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="statbox tabs tabe-margin">
                    <div class="stat-title">Strain Dislikes: <?= $strain_dislikes_count; ?></div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="statbox tabs tabe-margin">
                    <div class="stat-title">Flaged: <?= $strain_flags_count; ?></div>
                </div>
            </div>
        </div>
    </div>
    <?php if(\Session::has('success')) { ?>
        <h4 class="alert alert-success fade in">
            <?php echo \Session::get('success') ?>
        </h4>
    <?php } ?>
    <div class="contentPd">
        <h2 class="mainHEading">Strain Detail</h2>
        <p><strong>Title: </strong><?= $strain->title; ?></p>
        <p><strong>Type: </strong><?= $strain->getType->title; ?></p>
        <p><strong>Overview: </strong><?= $strain->overview; ?></p>
        <h2 class="mainHEading">Strains Comments</h2>
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Sr.</th>
                    <th>Reviewed By</th>
                    <th>Review</th>
                    <th>Rating</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $i = 1;
                foreach($strain->getReview as $review) { ?>
                    <tr>
                        <td><?php echo $i; $i++; ?></td>
                        <td><a href='<?php echo asset('user_detail/'.$review->getUser->id); ?>'><?= $review->getUser->first_name ?></a></td>
                        <td><?= $review->review ?></td>
                        <td><?php if($review->rating){ echo $review->rating->rating; }else{ echo 0; } ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <h2 class="mainHEading">User Strains</h2>
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Sr.</th>
                <th>Description</th>
                <th>User</th>
                <th>Indica</th>
                <th>Sativa</th>
                <th>Genetics</th>
            </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach($strain->getUserStrains as $user_strain) { ?>
                <tr>
                    <td><?php echo $i; $i++; ?></td>
                    <td><?= $user_strain->description ?></td>
                    <td><a href='<?php echo asset('user_detail/'.$user_strain->getUser->id); ?>'><?= $user_strain->getUser->first_name ?></a></td>
                    <td><?= $user_strain->indica ?></td>
                    <td><?= $user_strain->sativa ?></td>
                    <td><?= $user_strain->genetics ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>
<?php include resource_path('views/admin/includes/footer.php'); ?>
</body>
</html>

