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
    <a class="add_s" href="<?php echo asset('admin_journals'); ?>">Back</a>
    <div class="contentPd">
        <h2 class="mainHEading">Journal Events</h2>
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Sr.</th>
                <th>Title</th>
                <th>Date</th>
                <th>Feeling</th>
                <th>Description</th>
                <th>Detail</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php if(isset($events)) { ?>
                <?php 
                $i = 1;
                foreach($events as $event) { ?>
                    <tr>
                        <td><?php echo $i; $i++; ?></td>
                        <td><?= $event->title ?></td>
                        <td><?= $event->date ?></td>
                        <td><?= LaravelEmojiOne::toImage($event->feeling); ?></td>
                        <td><?= str_limit($event->description,15) ?></td>
                        <td class="strainhover"><a href="<?php echo asset('admin_event_description/'.$event->id); ?>">View Detail</a></td>
                        <td>
                            <a data-target="#modal-<?= $event->id; ?>" data-toggle="modal" href="#"><i class="fa fa-trash fa-fw"></i></a>
                        </td>
                    </tr>
                    <div class="modal fade" id="modal-<?= $event->id; ?>" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete the event ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button onlick="#"><a href="<?php echo asset('admin_delete_event/'.$event->id); ?>"> Confirm</a></button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
</section>
<?php include resource_path('views/admin/includes/footer.php'); ?>
</body>
</html>


