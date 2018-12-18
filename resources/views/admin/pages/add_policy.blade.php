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
        <h2 class="mainHEading mainsubheading">Privacy policy</h2>
        <?php if($errors->any()) {?>
            <div class="alert alert-danger">
                <?php foreach ($errors->all() as $error) { ?>
                    <?= $error ?><br/>
                <?php } ?>
            </div>
        <?php } ?>

        <form action="<?php echo asset('/update/policy'); ?>" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <label class="fullField">
                <span>Description</span>
                <textarea name="description" class="wh-speaker"><?= $policy->description ?></textarea>
                <?php if ($errors->has('description')) { ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors->get('description') as $message) { ?>
                            <?= $message ?><br>
                        <?php } ?>
                    </div>
                <?php } ?>
            </label>
            <input type="hidden" value="<?= $policy->id ?>" name="id">
            <div class="btnCol radius-btn">
                <input type="submit" name="signIn"  value="Submit">
            </div>
        </form>
    </div>
</section>
<?php include resource_path('views/admin/includes/footer.php'); ?>
    <script src="//cdn.ckeditor.com/4.5.5/standard/ckeditor.js"></script>
<script>
    
    CKEDITOR.replace('description');
    
</script>

</body>
</html>

