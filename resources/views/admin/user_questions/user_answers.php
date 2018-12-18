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
        <a class="add_s" href="<?php echo asset('/user_questions');?>">Back</a>

    <div class="contentPd">
        <h2 class="mainHEading">User Answers</h2>
        <a class="add_s delete_all" href="javascript:void(0)">Delete All Selected</a>
        <?php if ($errors->has('answer')) { ?>
            <div class="alert alert-danger">
                <?php foreach ($errors->get('answer') as $message) { ?>
                    <?php echo $message; ?><br>
                <?php } ?>
            </div>
        <?php } ?>
        <p><strong>Question: </strong><?php if(!$answers->isEmpty()){ echo $answers[0]->getQuestion->question;}?></p>
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Sr.</th>
                <!--<th>Question</th>-->
                <th>Users Name</th>
                <th>Answer</th>
                <th>Actions</th>
                <th><input class="" type="checkbox" id="checkedAll"> Select</th>
            </tr>
            </thead>
            <tbody>
            <?php if(isset($answers)) { ?>
                <?php 
                $i = 1;
                foreach($answers as $answer) { ?>
                    <tr>
                        <td><?php echo $i; $i++; ?></td>
                        <td><?= $answer->getUser->first_name; ?></td>
                        <td><?php $reveted_tags= revertTagSpace($answer->answer); echo  substr($reveted_tags, 0, 100); ?></td>
                        <td>
                            <a data-target="#edit-modal-<?= $answer->id ?>" data-toggle="modal" href="#"><i class="fa fa-edit fa-fw"></i></a>
                            <a data-target="#modal-<?= $answer->id ?>" data-toggle="modal" href="#"><i class="fa fa-trash fa-fw"></i></a>
                        </td>
                        <td><input class="sub_chk" type="checkbox"  data-id="<?= $answer->id ?>"></td>
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
                                    <button onlick="#"><a href="<?php echo asset('/delete_answer/'.$answer->id)?>"> Confirm</a></button>
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
                                    <h4 class="modal-title">Edit Answer</h4>
                                </div>
                                <form action="<?php echo asset('/update_answer')?>" method="post" style="padding: 0px;">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="answer_id" value="<?php echo $answer->id; ?>">
                                    <div class="modal-body">
                                        <input type="text" value="<?= revertTagSpace($answer->answer) ?>" name="answer">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-default">Submit</button>
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
<?php include resource_path('views/admin/includes/footer.php'); ?>
<script>
        $('.delete_all').on('click', function (e) {
            var allVals = [];
            $(".sub_chk:checked").each(function () {
                allVals.push($(this).attr('data-id'));
            });


            if (allVals.length <= 0)
            {
                alert("Please select row.");
            } else {
                var check = confirm("Are you sure you want to delete this row?");
                if (check == true) {
                    var join_selected_values = allVals.join(",");
                    $.ajax({
                        url: '<?= asset('delete_multiple_answers') ?>',
                        type: 'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'ids=' + join_selected_values,
                        success: function (data) {
                            if (data['success']) {
                                $(".sub_chk:checked").each(function () {
                                    $(this).parents("tr").remove();
                                });
                                alert(data['success']);
                                window.location.reload();
                            } else if (data['error']) {
                                alert(data['error']);
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });


                    $.each(allVals, function (index, value) {
                        $('table tr').filter("[data-row-id='" + value + "']").remove();
                    });
                }
            }
        });

        $("#checkedAll").change(function () {
            if (this.checked) {
                $(".sub_chk").each(function () {
                    this.checked = true;
                });
            } else {
                $(".sub_chk").each(function () {
                    this.checked = false;
                });
            }
        });
    </script>
</body>
</html>

