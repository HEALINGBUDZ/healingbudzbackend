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
            <a class="add_s" href="<?php echo asset('expertise_questions'); ?>">Back</a>
            <a data-target="#add-modal" data-toggle="modal" class="add_s" href="#">Add New Answer</a>
            <div class="contentPd">
                <h2 class="mainHEading">Experience Answers</h2>
                <?php if ($errors->has('expertise_answer')) { ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors->get('expertise_answer') as $message) { ?>
                            <?php echo $message; ?><br>
                        <?php } ?>
                    </div>
                <?php } ?>
                <table id="tableStyle" class="display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Sr.</th>
                        <th>Answers</th>
                        <th>Approve Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($answers)) { ?>
                        <?php 
                        $i = 1;
                        foreach($answers as $answer){ ?>
                            <tr>
                                <td><?php echo $i; $i++; ?></td>
                                <td><?= $answer->title ?></td>
                                <td>
                                    <?php if($answer->is_approved == 0) { ?>
                                    <a href="<?php echo asset('/exp_answer_approve_status/1/'.$answer->id)?>">Disapproved</a>
                                    <?php } ?>
                                    <?php if($answer->is_approved == 1) { ?>
                                        <a href="<?php echo asset('/exp_answer_approve_status/0/'.$answer->id)?>">Approved</a>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a data-target="#edit-modal-<?= $answer->id ?>" data-toggle="modal" href="#"><i class="fa fa-edit fa-fw"></i></a>
                                    <a data-target="#modal-<?= $answer->id ?>" data-toggle="modal" href="#"><i class="fa fa-trash fa-fw"></i></a>
                                </td>
                            </tr>
                            <div class="modal fade" id="modal-<?= $answer->id ?>" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Delete Answer</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete the answer ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button onlick="#"><a href="<?php echo asset('delete_expertise_answer/'.$answer->id)?>"> Confirm</a></button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="edit-modal-<?= $answer->id ?>" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Update Answer</h4>
                                        </div>
                                        <form action="<?php echo asset('update_expertise_answer/'.$answer->id)?>" method="post" style="padding: 0px;">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                            <div class="modal-body">
                                                <input type="text" value="<?php echo $answer->title ?>" name="expertise_answer" required>
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
                        <div class="modal fade" id="add-modal" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Add Answer</h4>
                                    </div>
                                    <form action="<?php echo asset('add_expertise_answer')?>" method="post" style="padding: 0px;" style="padding: 0px;">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                        <input type="hidden" name="exp_question_id" value="<?php echo $exp_question_id; ?>">
                                        <div class="modal-body">
                                            <input type="text" value="" name="expertise_answer" required>
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
                    </tbody>
                </table>
            </div>
        </section>
    <?php include resource_path('views/admin/includes/footer.php'); ?>
    </body>
</html>


