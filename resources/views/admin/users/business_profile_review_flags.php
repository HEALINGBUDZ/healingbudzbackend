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
        <h3 class="mainHEading">Review: <?= $review->text ?></h4>
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Sr.</th>
                <th>User</th>
                <th>Reason</th>
            </tr>
            </thead>
            <tbody>
            <?php if(count($review_flags) > 0){ ?>
                <?php 
                $i = 1;
                foreach($review_flags as $review){ ?>
                    <tr>
                        <td><?php echo $i; $i++; ?></td>
                        <td><?= $review->user->first_name;?></td>
                        <td><?= $review->reason;?></td>
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


