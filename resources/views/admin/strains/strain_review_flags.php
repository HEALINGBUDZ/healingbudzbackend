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
        <h3 class="mainHEading">Strain Review: <?= $strain_review->review; ?></h3>
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Sr.</th>
                <th>User</th>
                <th>Reason</th
            </tr>
            </thead>
            <tbody>
            <?php if(count($strain_review_flags) > 0){ ?>
                <?php 
                $i = 1;
                foreach($strain_review_flags as $strain_review_flag){ ?>
                    <tr>
                        <td><?php echo $i; $i++; ?></td>
                        <td><?= $strain_review_flag->getUser->first_name;?></td>
                        <td><?= $strain_review_flag->reason;?></td>
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


