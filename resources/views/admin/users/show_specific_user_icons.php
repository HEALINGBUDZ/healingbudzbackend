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
                <h2 class="mainHEading mainsubheading">Special User Icons</h2>
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
                        <th>Email</th>
                        <th>Icon</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($special_users)) { ?>
                        <?php 
                        $i = 1;
                        foreach($special_users as $user) {?>
                            <tr>
                                <td><?php echo $i; $i++; ?></td>
                                <td><?php echo $user->email; ?></td>
                                <td><img src="<?php echo asset('public/images/'.$user->icon) ?>" ></td>
                                <td>
                                    <a data-target="#delete-modal-<?php echo $user->id; ?>" data-toggle="modal" href="#">
                                        <i class="fa fa-trash fa-fw"></i>
                                    </a>
                                     <a data-target="#edit-modal<?php echo $user->id; ?>" data-toggle="modal" href="#">
                                        <i class="fa fa-pencil fa-fw"></i>
                                    </a>
                                </td>

                            </tr>
                            <div class="modal fade" id="delete-modal-<?php echo $user->id; ?>" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                             Delete user icon
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete the user icon?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button onlick="#" class="gener-delete"><a href="<?php echo asset('delete_specific_user_icon/'.$user->id); ?>"> Confirm</a></button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    
                    <div class="modal fade" id="edit-modal<?php echo $user->id; ?>" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Special User</h4>
                    </div>
                    <form style="padding: 0px" action="<?php echo asset('add_specific_user_icon')?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                          <input type="hidden" name="id" value="<?= $user->id ?>">
                        <div class="modal-body">
                            <input type="file" value="" name="icon" required="" placeholder="Icon" value="<?php echo old('email'); ?>">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-default gener-delete">Submit</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
                        <h4 class="modal-title">Add Special Icons</h4>
                    </div>
                    <form action="<?php echo asset('add_specific_user_icon')?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <div class="modal-body">
                            <input type="email" value="" name="email" required="" placeholder="Email" value="<?php echo old('email'); ?>">
                        </div>
                        <div class="modal-body">
                            <input type="file" value="" name="icon" required="" placeholder="Icon" value="<?php echo old('email'); ?>">
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
