<!DOCTYPE html>
<html lang="en">
    <?php include resource_path('views/admin/includes/head.php'); ?>
    <body>
        <?php include resource_path('views/admin/includes/header.php'); ?>
        <?php include resource_path('views/admin/includes/sidebar.php'); ?>
        <section class="content lifeContent">
            
            <?php if(Session::has('success')) {?>
                <h4 class="alert alert-success fade in">
                    <?php echo Session::get('success'); ?>
                </h4>
            <?php } ?>
            <?php if(Session::has('error')) {?>
                <h4 class="alert alert-danger fade in">
                    <?php echo Session::get('error'); ?>
                </h4>
            <?php } ?>
<!--            <a class="add_s" href="<?php echo asset('add_user')?>">Add New User</a>-->
            <a data-target="#add-modal" data-toggle="modal" class="add_s" href="#">Add Special User</a>

            <div class="contentPd">
                <h2 class="mainHEading mainsubheading">Payments Record</h2>
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
                        <th width="100">Sr.</th>
                        <th>Price</th>
                        <th>User</th>
                        <th>Searched By</th>
                        <th>Budz Adz</th>
                        <th>Tag</th>
                        <th>Time</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($payment_records)) { ?>
                        <?php 
                        $i = 1;
                        foreach($payment_records as $record) {?>
                            <tr>
                                <td><?php echo $i; $i++; ?></td>
                                <td><?php echo $record->price; ?></td>
                                <td><a href="<?= asset('user_detail/'.$record->user->id)?>"><?php echo $record->user->first_name; ?></a></td>
                                <td><a href="<?= asset('user_detail/'.$record->searchedByUser->id)?>"><?php echo $record->searchedByUser->first_name; ?></a></td>
                                <td><a href="<?= asset('user_business_profile_detail/'.$record->budz->id)?>"><?php echo $record->budz->title; ?></a></td>
                                <td><?php echo $record->tag->title; ?></td>
                                <td><?php echo date("m-d-Y H:i:s", strtotime($record->created_at)); ?></td>
                           </tr>
                        <?php } ?>
                    <?php } ?>
                    </tbody>
                </table>
                

            </div>
        </section>
        <div class="modal fade" id="add-modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Special User</h4>
                    </div>
                    <form action="<?php echo asset('add_special_user')?>" method="post">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <div class="modal-body">
                            <input type="email" value="" name="email" required="" placeholder="Email" value="<?php echo old('email'); ?>">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-default gener-delete">Submit</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php include resource_path('views/admin/includes/footer.php'); ?>
    </body>
</html>
