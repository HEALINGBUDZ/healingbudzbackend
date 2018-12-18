<!DOCTYPE html>
<html lang="en">
<?php include resource_path('views/admin/includes/head.php'); ?>
<body>
<?php include resource_path('views/admin/includes/header.php'); ?>
<?php include resource_path('views/admin/includes/sidebar.php'); ?>
<section class="content lifeContent">
    
    <?php if(\Session::has('success')) { ?>
        <h4 class="alert alert-success fade in">
            <?php echo \Session::get('success'); ?>
        </h4>
    <?php } ?>
    <div class="contentPd">
        <h2 class="mainHEading">User Strain Detail</h2>
        <p><strong>Strain Name: </strong><?= $user_strain->getStrain->title; ?></p>
        <p><strong>Genetics: </strong><?= $user_strain->genetics; ?></p>
        <p><strong>Indica: </strong><?= $user_strain->indica; ?>%</p>
        <p><strong>Sativa: </strong><?= $user_strain->sativa; ?>%</p>
        <p><strong>Cross Breed: </strong><?= $user_strain->cross_breed; ?></p>
        <p><strong>Plant Height: </strong><?= $user_strain->plant_height; ?></p>
        <p><strong>Flowering Time: </strong><?= $user_strain->flowering_time; ?></p>
        <p><strong>Growing: </strong><?= $user_strain->growing; ?></p>
        <p><strong>F Temperature: </strong><?= $user_strain->min_fahren_temp; ?> to <?= $user_strain->max_fahren_temp; ?></p>
        <p><strong>C Temperature: </strong><?= $user_strain->min_celsius_temp; ?> to <?= $user_strain->max_celsius_temp; ?></p>
        <p><strong>Yield: </strong><?= $user_strain->yeild; ?></p>
        <p><strong>Climate: </strong><?= $user_strain->climate; ?></p>
        <p><strong>Note: </strong><?= $user_strain->note; ?></p>
        <p><strong>Description: </strong><?= $user_strain->description; ?></p>
        <br>
        <h3>User Detail</h3>
        <p><strong>Name: </strong><a href='<?php echo asset('user_detail/'.$user_strain->getUser->id); ?>'><?= $user_strain->getUser->first_name; ?></a></p>
        <img alt="User Pic" src="<?php echo getImage($user_strain->getUser->image_path, $user_strain->getUser->avatar);?>" id="profile-image1" class="img-circle img-responsive">
    </div>
    
</section>
<?php include resource_path('views/admin/includes/footer.php'); ?>
</body>
</html>

