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
             <a class="add_s delete_all" href="javascript:void(0)">Delete All Selected</a>
            <a data-target="#add-modal" data-toggle="modal" class="add_s" href="#">Add Special User</a>

            <div class="contentPd">
                <h2 class="mainHEading mainsubheading">Special Users</h2>
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
                        <th>icon</th>
                        <th>Actions</th>
                        <th><input class="" type="checkbox" id="checkedAll"> Select</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($special_users)) {?>
                        <?php 
                        $i = 1;
                        foreach($special_users as $user) {?>
                            <tr>
                                <td><?php echo $i; $i++; ?></td>
                                <td><?php echo $user->email; ?></td>
                                <td><?php if($user->getIcon){ ?> <img src="<?= asset('public/images'.$user->getIcon->icon)?>"> <?php }?></td>
                                <td>
                                    <a data-target="#delete-modal-<?php echo $user->id; ?>" data-toggle="modal" href="#">
                                        <i class="fa fa-trash fa-fw"></i>
                                    </a>
                                </td>
                                <td><input class="sub_chk" type="checkbox"  data-id="<?= $user->id ?>"></td>
                            </tr>
                            <div class="modal fade" id="delete-modal-<?php echo $user->id; ?>" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete the email ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button onlick="#" class="gener-delete"><a href="<?php echo asset('delete_special_user/'.$user->id); ?>"> Confirm</a></button>
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
        <div class="modal fade" id="add-modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Special User</h4>
                    </div>
                    <form action="<?php echo asset('add_special_user')?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <div class="modal-body">
                            <input type="email" value="" name="email" required="" placeholder="Email" value="<?php echo old('email'); ?>">
                        </div>
                        <div class="modal-body">
                            <input required="" type="file" value="" name="icon" placeholder="Icon" value="<?php echo old('email'); ?>">
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
                        url: '<?= asset('delete_special_multi_user') ?>',
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
