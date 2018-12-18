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
        <h2 class="mainHEading mainsubheading">Purchased keyword</h2>
        
        <?php if($errors->any()) { ?>
            <div class="alert alert-danger">
                <?php foreach ($errors->all() as $error) { ?>
                    <?= $error ?><br/>
                <?php } ?>
            </div>
        <?php } ?>
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Sr.</th>
                <th>keyword Title</th>
                <th>User</th>
                <th>Zip Code</th>
                <th>State</th>
                <th>Price</th>
            </tr>
            </thead>
            <tbody>
            <?php if(isset($tags)) { ?>
                <?php 
                $i = 1;
                foreach($tags as $tag) { ?>
                    <tr>
                        <td><?php echo $i; $i++; ?></td>
                        <td class="strainhover"><a href="<?php echo asset('tag_searches/'.$tag->getTag->title.'/'.$tag->getTag->id)?>"><?= $tag->getTag->title ?></a></td>
                        <td class="strainhover"><a href='<?php echo asset('user_detail/'.$tag->getUser->id); ?>'><?= $tag->getUser->first_name ?></a></td>
                        <td><?= $tag->zip_code ?></td>
                        <td><?= $tag->state ?></td>
                        <td><?= $tag->price ?></td>
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


