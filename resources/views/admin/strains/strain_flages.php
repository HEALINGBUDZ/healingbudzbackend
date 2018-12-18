<!DOCTYPE html>
<html lang="en">
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
            <a class="add_s" href="<?php echo asset('strains'); ?>">Back</a>

            <div class="contentPd">
                <h2 class="mainHEading">Strain: <?= $strain->title; ?></h2>
                <a class="add_s delete_all" data-delete="delete" href="javascript:void(0)">Delete All Selected</a> 
        <a class="add_s delete_all" data-delete="flag" href="javascript:void(0)">Delete Flag Selected</a>
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Sr.</th>
                            <th>User</th>
                            <th>Reason</th>
                            <th>Action</th>
                            <th><input class="" type="checkbox" id="checkedAll"> Select</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($strain->getFlag) > 0) { ?>
                            <?php 
                            $i = 1;
                            foreach ($strain->getFlag as $strain_flag) { ?>
                                <tr>
                                    <td><?php echo $i; $i++; ?></td>
                                    <td><?= $strain_flag->getUser->first_name; ?></td>
                                    <td><?= $strain_flag->reason; ?></td>
                                    <td>
                                        <a data-target="#modal-<?php echo $strain->id; ?>" data-toggle="modal" href="#">
                                            <i class="fa fa-trash fa-fw"></i>
                                        </a> 
                                        <a data-target="#modal-flag<?php echo $strain_flag->id; ?>" data-toggle="modal" href="#">
                                            <i class="fa fa-flag fa-fw"></i>
                                        </a> 
                                    </td>
                                    <td><input class="sub_chk" type="checkbox"  data-id="<?= $strain_flag->id ?>" data-subuser="<?= $strain->id ?>"></td>
                            <div class="modal fade" id="modal-flag<?php echo $strain_flag->id; ?>" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            Remove Flag
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to remove flag ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button onlick="#"><a href="<?php echo asset('admin_strain_remove_flag/' . $strain_flag->id); ?>"> Confirm</a></button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    </tbody>
                </table>
                <div class="modal fade" id="modal-<?php echo $strain->id; ?>" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                Delete Strain
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete the strain ?</p>
                            </div>
                            <div class="modal-footer">
                                <button onlick="#"><a href="<?php echo asset('delete_strain/' . $strain->id); ?>"> Confirm</a></button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php include resource_path('views/admin/includes/footer.php'); ?>
        <script>
            $('.delete_all').on('click', function (e) {

                check_url = $(this).data('delete');
                if (check_url == 'delete') {
                    url = '<?= asset('delete_multiple_strains') ?>';
                } else {
                    url = '<?= asset('delete_flag_multiple_strains') ?>';
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


