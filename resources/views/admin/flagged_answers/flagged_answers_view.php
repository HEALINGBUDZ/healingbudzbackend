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

    <div class="contentPd">
        <h2 class="mainHEading mainsubheading">Flagged Answers</h2>
        <a class="add_s delete_all" data-delete="delete" href="javascript:void(0)">Delete All Selected</a> 
        <a class="add_s delete_all" data-delete="flag" href="javascript:void(0)">Delete Flag Selected</a>
        <?php if ($errors->has('sensation')){ ?>
            <div class="alert alert-danger">
                <?php foreach ($errors->get('sensation') as $message) { ?>
                    <?php echo  $message ?><br>
                <?php } ?>
            </div>
        <?php } ?>
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th width="80">Sr.</th>
                <th>Answer</th>
                <th>Question</th>
                <th>Flag to</th>
                <th>Flag by</th>
                <th>Reason</th>
                <th width="120">Delete Flag</th>
                <th width="150">Delete Answer</th>
                <th width="150">Created At</th>
                <th width="120"><input class="" type="checkbox" id="checkedAll"> Select</th>
            </tr>
            </thead>
            <tbody>
            <?php if(isset($answers)) { ?>
                <?php 
                $i = 1;
                foreach($answers as $answer){ ?>
                    <tr>
                        <td><?php echo $i; $i++; ?></td>
                        <td class="strainhover">
                            <a href='<?php echo asset('get-question-answers/'.$answer->getAnswer->id); ?>'>
                                <?= $answer->getAnswer->answer ?>
                            </a>
                        </td>
                        <td class="strainhover">
                            <a href='<?php echo asset('user_question_detail/'.$answer->getAnswer->getQuestion->id); ?>'>
                                <?= $answer->getAnswer->getQuestion->question ?>
                            </a>
                        </td>
                        <td class="strainhover">
                            <a href='<?php echo asset('user_detail/'.$answer->flagByUserAnswer->id); ?>'>
                                <?= $answer->flagByUserAnswer->first_name ?>
                            </a>
                        </td>
                        <td class="strainhover">
                            
                            <a href='<?php echo asset('user_detail/'.$answer->flagToUserAnswer->id); ?>'>
                                <?= $answer->flagToUserAnswer->first_name ?>
                            </a>
                        </td>
                        <td><?= $answer->reason ?></td>
                        <td>
                            <a data-target="#modal_delete_answer_flag<?= $answer->id ?>" data-toggle="modal" href="#">
                                <i class="fa fa-trash fa-fw"></i>
                            </a>
                        </td>
                        <td>
                            <a data-target="#modal_delete_answer_<?= $answer->id ?>" data-toggle="modal" href="#">
                                <i class="fa fa-trash fa-fw"></i>
                            </a>
                        </td>
                         <td><?php echo date("m-d-Y", strtotime($answer->created_at)); ?></td>
                         <td><input class="sub_chk" type="checkbox"  data-id="<?= $answer->id ?>" data-subuser="<?= $answer->getAnswer->id ?>"></td>
                    </tr>
                    <div class="modal fade" id="modal_delete_answer_flag<?= $answer->id ?>" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Delete Flag</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete the answer flag ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button onlick="#" class="gener-delete"><a href="<?php echo asset('delete_flagged_answer/'.$answer->id); ?>"> Confirm</a></button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modal_delete_answer_<?= $answer->id ?>" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Delete Answer</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete the answer?</p>
                                </div>
<!--                                <div class="modal-footer">
                                    <button onlick="#" class="gener-delete"><a href="<?php echo asset('delete_answer/'.$answer->getAnswer->id); ?>"> Confirm</a></button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>-->
                                <div class="modal-footer form-adjust-admin">
                                            <form style="" method="get" action="<?= asset('delete_answer/' . $answer->getAnswer->id) ?>">
                                                <div class="form-inner-space">
                                                    <label>Reason</label> 
                                                    <input name="id" type="hidden" value="<?= $answer->getAnswer->id ?>" >  
                                                    <input type="text" name="message" required="" >  
                                                </div>
                                                <button type="submit" onlick="#" class="gener-delete" value="Confirm">Confirm </button>
                                                
                                            </form>
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
   <script>
            $('.delete_all').on('click', function (e) {

                check_url = $(this).data('delete');
                if (check_url == 'delete') {
                    url = '<?= asset('delete_multiple_answers') ?>';
                } else {
                    url = '<?= asset('delete_flag_multiple_answers') ?>';
                }
                if (check_url == 'delete') {
                    var allVals = [];
                    $(".sub_chk:checked").each(function () {
                        allVals.push($(this).attr('data-subuser'));
                    });
                } else {
                    var allVals = [];
                    $(".sub_chk:checked").each(function () {
                        allVals.push($(this).attr('data-id'));
                    });
                }

                if (allVals.length <= 0)
                {
                    alert("Please select row.");
                } else {
                    var check = confirm("Are you sure you want to delete this row?");
                    if (check == true) {
                        var join_selected_values = allVals.join(",");
                        $.ajax({
                            url: url,
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

