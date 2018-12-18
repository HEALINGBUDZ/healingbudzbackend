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
        <h2 class="mainHEading mainsubheading">Users Strains</h2>
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="100">Sr.</th>
                    <th>Strain Name</th>
                    <th>User</th>
                    <th width="120">Likes</th>
                </tr>
            </thead>
            <tbody>
            <?php if(isset($users_strains)) { ?>
                <?php 
                $i = 1;
                foreach($users_strains as $user_strain) {
//                    $des=trim(revertTagSpace($user_strain->description));
                    $removed_anchor=preg_replace("/<a[^>]+\>/i", "",$user_strain->description);
                    $remove_tags=trim(revertTag($removed_anchor));
//                     substr(preg_replace("/<a[^>]+\>/i", "",trim(revertTagSpace($user_strain->description))), 0, 30) ?>
                    <tr>
                        <td><?php echo $i; $i++; ?></td>
                        <td class="strainhover"><a href="<?php echo asset('user_strain_detail/'.$user_strain->id)?>"><?= $user_strain->getStrain->title ?></a></td>
                        <td><a href='<?php echo asset('user_detail/'.$user_strain->getUser->id); ?>'><?= $user_strain->getUser->first_name ?></a></td>
                        <td><?= $user_strain->get_likes_count ?></td>
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

