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
    <a class="add_s" href="<?php echo asset('business_profiles'); ?>">Back</a>

    <div class="contentPd">
        <h2 class="mainHEading">Business Profile: <?= $sub_user->title ?></h2>
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Sr.</th>
                <th>Review Text</th>
                <th>User</th>
                <th>Rating</th>
                <th>Flag Count</th>
            </tr>
            </thead>
            <tbody>
            <?php if(count($sub_user->allReviews) > 0){ ?>
                <?php 
                $i = 1;
                foreach($sub_user->allReviews as $review){ ?>
                    <tr>
                        <td><?php echo $i; $i++; ?></td>
                        <td><?= $review->text;?></td>
                        <td class="strainhover"><a href="<?=asset('user_detail/'.$review->user->id)?>"><?= $review->user->first_name;?></a></td>
                        <td><?= $review->rating;?></td>
                        <td class="strainhover"><a href="<?php if(count($review->reports)) { echo asset('get_business_profile_reviews_flags/'.$sub_user->id.'/'.$review->id); } else { echo 'javascript:void(0)';}?>"><?= count($review->reports);?></a></td>
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


