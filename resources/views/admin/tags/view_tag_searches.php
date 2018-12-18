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
            <a class="add_s" href="<?php echo asset('tags');?>">Back</a>
            <div class="contentPd">
                <h2 class="mainHEading"><?= $tag_name?></h2>

                <table id="tableStyle" class="display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Sr.</th>
                        <th>Zip Code</th>
                        <th>Count</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($tags)) { ?>
                        <?php 
                        $i = 1;
                        foreach($tags as $tag) { ?>
                            <tr>
                                <td><?php echo $i; $i++; ?></td>
                                <td><?= $tag->zip_code ?></td>
                                <td><?= $tag->count ?></td>
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


