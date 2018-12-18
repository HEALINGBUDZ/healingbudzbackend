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
        <h2 class="mainHEading mainsubheading">Help & Support</h2>
        
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th width="100">Sr.</th>
                <th>User Name</th>
                <th>Business Listing</th>
                <th>Message</th>
            </tr>
            </thead>
            <tbody>
                <?php 
                $i = 1;
                foreach($supports as $support) {
                    $sub_user='';
                    $bussiness_profile_url='javascript:void(0)';
                    if(isset($support->SubUser->title)){
                        $sub_user=$support->SubUser->title;
                        $bussiness_profile_url= asset('user_business_profile_detail/'.$support->sub_user_id);
                    }
                    ?>
                    <tr>
                        <td><?php echo $i; $i++; ?></td>
                        <td class="strainhover"><a href="<?= asset('user_detail/'.$support->user_id)?>"><?= $support->user->first_name ?></a></td>
                        <td class="strainhover"><a href="<?= $bussiness_profile_url ?>"><?= $sub_user ?></a></td>
                        <td><?= $support->message ?></td>
                        
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>
<?php include resource_path('views/admin/includes/footer.php'); ?>
</body>
</html>


