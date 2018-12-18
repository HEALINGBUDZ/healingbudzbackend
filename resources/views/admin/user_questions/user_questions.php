<!DOCTYPE html>
<html lang="en">
<?php include resource_path('views/admin/includes/head.php'); ?>
<body>
<?php include resource_path('views/admin/includes/header.php'); ?>
<?php include resource_path('views/admin/includes/sidebar.php'); ?>
<section class="content lifeContent">
    <div class="container container-width">
        <div class="row">
            <div class="col-md-3 col-sm-4">
                <div class="statbox tabs tabe-margin">
                    <div class="stat-title">Total Question: <?= $questions->count(); ?></div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="statbox tabs tabe-margin">
                    <div class="stat-title">Answered Questions: <?= $answered_questions; ?></div>
                </div>
            </div>
        </div>
    </div>
    <?php if(\Session::has('success')) { ?>
        <h4 class="alert alert-success fade in">
            <?php echo \Session::get('success') ?>
        </h4>
    <?php } ?>

    <div class="contentPd">
        <h2 class="mainHEading mainsubheading">User Questions</h2>
        <a class="add_s delete_all" href="javascript:void(0)">Delete All Selected</a>
        <?php if($errors->has('question')) { ?>
            <div class="alert alert-danger">
                <?php foreach ($errors->get('question') as $message) { ?>
                    <?php echo $message ?><br>
                <?php } ?>
            </div>
        <?php } ?>
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th width="100">Sr.</th>
                <th>Question</th>
                <th>Description</th>
                <th>User</th>
                <th width="120">Answers</th>
                <th width="200">Created At</th>
                <th width="120">Actions</th>
                <th width="120"><input class="" type="checkbox" id="checkedAll"> Select</th>
            </tr>
            </thead>
            <tbody>
            <?php if(isset($questions)) { ?>
                <?php 
                $i = 1;
                foreach($questions as $question) { ?>
                    <tr>
                        <td><?php echo $i; $i++; ?></td>
                        <td class="strainhover"><a target="_blank" href='<?php echo asset('get-question-answers/'.$question->id); ?>'><?= revertTagSpace($question->question) ?></a></td>
                        <td><?php $reveted_tags = revertTagSpace($question->description);  echo  substr($reveted_tags, 0, 100); ?></td>
                        <td class="strainhover">
                            <a href='<?php echo asset('user_detail/'.$question->getUser->id); ?>'><?= $question->getUser->first_name; ?></a>
                        </td>
                        <td class="strainhover"><a href="<?php if($question->getAnswers->count()){ echo asset('user_answers/'.$question->id); } else { echo 'javascript:void(0)'; } ?>"><?= $question->getAnswers->count(); ?></a></td>
                        <td><?php  echo date("m-d-Y", strtotime($question->created_at));   ?></td>
                        <td>
                            <a data-target="#edit-modal-<?= $question->id ?>" data-toggle="modal" href="#"><i class="fa fa-edit fa-fw"></i></a>
                            <a data-target="#modal-<?= $question->id ?>" data-toggle="modal" href="#"><i class="fa fa-trash fa-fw"></i></a>
                        </td>
                        <td><input class="sub_chk" type="checkbox"  data-id="<?= $question->id ?>"></td>
                    </tr>
                    <div class="modal fade" id="modal-<?= $question->id ?>" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Delete Question</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete the question ?</p>
                                </div>
                                <div class="modal-footer form-adjust-admin">
                                            <form style="" method="get" action="<?= asset('delete_question/' . $question->id) ?>">
                                                <div class="form-inner-space">
                                                    <label>Reason</label> 
                                                    <input name="id" type="hidden" value="<?= $question->id ?>" >  
                                                    <input type="text" name="message" required="" >  
                                                </div>
                                                <button type="submit" onlick="#" class="gener-delete" value="Confirm">Confirm </button>
                                                
                                            </form>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="edit-modal-<?= $question->id ?>" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Edit Question</h4>
                                </div>
                                <form action="<?php echo asset('update_question'); ?>" method="post" style="padding: 0px;">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="question_id" value="<?php echo $question->id; ?>">
                                    <div class="modal-body">
                                        <input type="text" value="<?= revertTagSpace($question->question); ?>" name="question">
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
                        url: '<?= asset('delete_multiple_questions') ?>',
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


