<!DOCTYPE html>
<html lang="en">
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <?php include resource_path('views/admin/includes/head.php'); ?>
    <body>
        <?php include resource_path('views/admin/includes/header.php'); ?>
        <?php include resource_path('views/admin/includes/sidebar.php'); ?>
        <section class="content lifeContent">

            <?php if (\Session::has('success')) { ?>
                <h4 class="alert alert-success fade in">
                    <?php echo \Session::get('success') ?>
                </h4>
            <?php } ?>
            <a class="add_s multiselect-operation-btn" purpose="delete_all" href="javascript:void(0)">Delete All Selected</a>
            <a class="add_s multiselect-operation-btn" purpose="approve_all" href="javascript:void(0)">Approve Selected</a>
            <a class="add_s multiselect-operation-btn" purpose="disapprove_all" href="javascript:void(0)">Disapprove Selected</a>
            <a data-target="#add-modal" data-toggle="modal" class="add_s" href="#">Add New Sensation</a>
            
            <div class="contentPd">
                <h2 class="mainHEading mainsubheading">Mood And Sensations</h2>
                <?php if ($errors->has('sensation')) { ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors->get('sensation') as $message) { ?>
                            <?= $message ?><br>
                        <?php } ?>
                    </div>
                <?php } ?>
                <table id="tableStyle" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="100">Sr.</th>
                            <th>Sensation</th>
                            <th>Approve Status</th>
                            <th width="120">Actions</th>
                            <th width="120"><input class="" type="checkbox" id="checkedAll"> Select</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($sensations)) { ?>
                            <?php 
                            $i = 1;
                            foreach ($sensations as $sensation) { ?>
                                <tr>
                                    <td><?php echo $i; $i++; ?></td>
                                    <td><?= $sensation->sensation ?></td>
                                    <td class="strainhover">
                                        <?php if ($sensation->is_approved == 0) { ?>
                                            <a href="<?php echo asset('/sensation_approve_status/1/' . $sensation->id) ?>">Disapproved</a>
                                        <?php } ?>
                                        <?php if ($sensation->is_approved == 1) { ?>
                                            <a href="<?php echo asset('/sensation_approve_status/0/' . $sensation->id) ?>">Approved</a>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if ($sensation->is_approved == 1) { ?>
                                            <a data-target="#edit-modal-<?= $sensation->id ?>" data-toggle="modal" href="#"><i class="fa fa-edit fa-fw"></i></a>
                                        <?php } ?>
                                        <a data-target="#modal-<?= $sensation->id ?>" data-toggle="modal" href="#"><i class="fa fa-trash fa-fw"></i></a>
                                    </td>
                                    <td><input class="sub_chk" type="checkbox"  data-id="<?= $sensation->id ?>"></td>
                                </tr>
                            <div class="modal fade" id="modal-<?= $sensation->id ?>" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Delete Sensation</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete the sensation ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button onlick="#" class="gener-delete"><a href="<?php echo asset('/delete_sensation/' . $sensation->id) ?>"> Confirm</a></button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="edit-modal-<?= $sensation->id ?>" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Edit Sensation</h4>
                                        </div>
                                        <form style="padding: 0px" action="<?php echo asset('/update_sensation/' . $sensation->id) ?>" method="post">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                            <input type="hidden" name="sensation_id" value="<?php echo $sensation->id; ?>">
                                            <div class="modal-body">
                                                <input type="text" value="<?= $sensation->sensation ?>" name="sensation" required="">
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
                        <div class="modal fade" id="add-modal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add Sensation</h4>
                            <h6>Add , separated for multiple values</h6>
                        </div>
                        <form style="padding: 0px" action="<?php echo asset('add_sensation') ?>" method="post">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="modal-body">
                                <input type="text" value="" name="sensation" required="">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default gener-delete">Submit</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
                    </tbody>
                </table>
            </div>
        
        </section>

        <?php include resource_path('views/admin/includes/footer.php'); ?>
        <script>
            
            $('.multiselect-operation-btn').on('click', function (e) {
            var allVals = [];
            var purpose = $(this).attr('purpose');
            $(".sub_chk:checked").each(function () {
                allVals.push($(this).attr('data-id'));
            });

            if (allVals.length <= 0)
            {
                alert("Please select row.");
            } else {
                if (purpose == 'delete_all') {
                    check = confirm("Are you sure you want to delete this row?");
                } else if (purpose == 'approve_all') {
                    check = confirm("Are you sure you want to approve this row?");
                } else if (purpose == 'disapprove_all') {
                    check = confirm("Are you sure you want to disapprove this row?");
                }
                if (check == true) {
                    var join_selected_values = allVals.join(",");
                    var url = data = '';
                    if (purpose == 'delete_all') {
                        url = '<?= asset('delete_multiple_sensation') ?>';
                        data = 'ids=' + join_selected_values;
                    } else if (purpose == 'approve_all') {
                        url = '<?= asset('approve_disapprove_multiple_sensation') ?>';
                        data = {ids: join_selected_values, status: 1};
                    } else if (purpose == 'disapprove_all') {
                        url = '<?= asset('approve_disapprove_multiple_sensation') ?>';
                        data = {ids: join_selected_values, status: 0};
                    }
                    $.ajax({
                        url: url,
                        data: data,
                        type: 'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (data) {
                            if (purpose == 'delete_all') {
                                if (data['success']) {
                                    $(".sub_chk:checked").each(function () {
                                        $(this).parents("tr").remove();
                                    });
                                    alert(data['success']);
                                } else if (data['error']) {
                                    alert(data['error']);
                                } else {
                                    alert('Whoops Something went wrong!!');
                                }
                            } else if (purpose == 'disapprove_all' || purpose == 'approve_all') {
                                alert(data['success']);
                                window.location.reload();
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



