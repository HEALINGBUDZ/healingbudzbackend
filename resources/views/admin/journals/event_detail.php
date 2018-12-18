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
    <a class="add_s" href="<?php echo asset('admin_journal_events/'.$event->journal_id)?>">Back</a>

    <div class="contentPd">
        <h2 class="mainHEading">Event Description</h2>
        

        <span>Title</span>
        <p><?= $event->title ?></p>
        <hr>
        <span>Date</span>
        <p><?= $event->date ?></p>
        <hr>
        <span>Feeling</span>
        <p><?= LaravelEmojiOne::toImage($event->feeling); ?></p>
        <hr>
        <span>Description</span>
        <p><?= $event->description ?></p>

    </div>
</section>
<?php include resource_path('views/admin/includes/footer.php'); ?>
</body>
</html>


