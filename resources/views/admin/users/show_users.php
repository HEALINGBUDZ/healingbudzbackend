<!DOCTYPE html>
<html lang="en">
    <?php include resource_path('views/admin/includes/head.php'); ?>
    <style>
        .stat-title a {
            color: #fff;
        }
    </style>
    <body>
        <?php include resource_path('views/admin/includes/header.php'); ?>
        <?php include resource_path('views/admin/includes/sidebar.php'); ?>
        <section class="content lifeContent">
            <div class="">
                <div class="row user-tabs-row">
                    <div class="col-xs-12 col-sm-4 col-md-3">
                        <div class="statbox tabs ">
                            <div class="stat-title">
                                <a href="<?=url('show_users?filter=all');?>">
                                Total User: <?= $total_users; ?>
                            </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <div class="statbox tabs">
                            <div class="stat-title">
                                <a href="<?=url('show_users?filter=last_week');?>">Last Week: <?= $last_week; ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <div class="statbox tabs">
                            <div class="stat-title">Web: <?= $web_users_count ?></div>
                            <div class="stat-title">Mobile: <?= $mobile_users_count; ?></div>
                            <div class="stat-title">Social: <?= $total_users     - ($web_users_count + $mobile_users_count); ?>
                                <br>
                                <h5>Google: <?=$google_user?>, Facebook: <?=$fb_user?></h5>
                                <small></small> </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (Session::has('success')) { ?>
                <h4 class="alert alert-success fade in">
                    <?php echo Session::get('success'); ?>
                </h4>
            <?php } ?>
            <?php if (Session::has('error')) { ?>
                <h4 class="alert alert-danger fade in">
                    <?php echo Session::get('error'); ?>
                </h4>
            <?php } ?>


            <div class="contentPd">
                <h2 class="mainHEading mainsubheading pull-left">Users</h2>
                <a class="add_s delete_all" href="javascript:void(0)">Delete All Selected</a>
                <a class="add_s" href="<?php echo asset('add_user') ?>">Add New User</a>
                <table id="tableStyle" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="80">Sr.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Zip Code</th>
                            <th>Signup By</th>
                            <th width="120">Total Posts</th>
                            <th width="130">Business Profiles</th>
                            <th>User Account</th>
                            <th width="120">Actions</th>
                            <th>Create at</th>
                            <th width="120"><input class="" type="checkbox" id="checkedAll"> Select</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($users)) { ?>
                            <?php
                            $i = 1;
                            foreach ($users as $user) {
                                ?>
                                <tr>
                                    <td><?php echo $i;
                        $i++;
                                ?></td>
                                    <td class="strainhover">
                                        <a href='<?php echo asset('user_detail/' . $user->id); ?>'>
        <?php echo $user->first_name . ' ' . $user->last_name; ?>
                                        </a>
                                    </td>
                                    <td><?php echo $user->email; ?></td>
                                    <td><?php echo $user->zip_code; ?></td>
                                    <?php if ($user->is_web == 1 && $user->google_id == NULL && $user->fb_id == NULL) { ?>
                                        <td>web</td>
                                    <?php } else if ($user->is_web == 0 && $user->google_id == NULL && $user->fb_id == NULL) { ?>
                                        <td>mobile</td>
                                    <?php } else { ?>
                                        <td>social</td>
                                        <?php } ?>
                                    <td class="strainhover"><a href="<?php
                                        if ($user->posts->count()) {
                                            echo asset('admin_user_wall/' . $user->id);
                                        } else {
                                            echo 'javascript:void(0)';
                                        }
                                        ?>"><?php echo $user->posts->count(); ?></a></td>
                                    <td class="strainhover"><a href="<?php
                                                               if ($user->sub_user_count) {
                                                                   echo asset('user_business_profiles/' . $user->id);
                                                               } else {
                                                                   echo 'javascript:void(0)';
                                                               }
                                                               ?>"><?php echo $user->sub_user_count; ?></a></td>
                                    <td class="strainhover"><a href="<?php echo asset('user_account/' . $user->id) ?>" target="_blank">Jump To User</a></td>
                                    <td>
                                        <a href='<?php echo asset('user_detail/' . $user->id); ?>'><i class="fa fa-edit fa-fw"></i></a>
                                        <a data-target="#modal-<?php echo $user->id; ?>" data-toggle="modal" href="#">
                                            <i class="fa fa-trash fa-fw"></i>
                                        </a>
                                        <?php if(!$user->is_blocked){ ?>
                                        <a data-target="#ban-modal-<?php echo $user->id; ?>" data-toggle="modal" href="#"><i class="fa fa-ban fa-fw"></i></a>
                                        <?php } else{ ?>
                                        <a data-target="#unban-modal-<?php echo $user->id; ?>" data-toggle="modal" href="#"><i style="color:red" class="fa fa-ban fa-fw"></i></a>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo date("m-d-Y", strtotime($user->created_at));  ?></td>
                                    <td><input class="sub_chk" type="checkbox"  data-id="<?= $user->id ?>"></td>
 
                                </tr>
                                <!--Delete Modal-->
                            <div class="modal fade" id="modal-<?php echo $user->id; ?>" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            Delete User
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete the user ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button onlick="#" class="gener-delete"><a href="<?php echo asset('delete_user/' . $user->id); ?>"> Confirm</a></button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <!--Block Modal-->
                    <div class="modal fade" id="ban-modal-<?php echo $user->id; ?>" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            Block User
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to block the user ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button onlick="#" class="gener-delete"><a href="<?php echo asset('block_user/' . $user->id); ?>"> Confirm</a></button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <!--UnBlock Modal-->
                    <div class="modal fade" id="unban-modal-<?php echo $user->id; ?>" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            Unblock User
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to unblock the user ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button onlick="#" class="gener-delete"><a href="<?php echo asset('unblock_user/' . $user->id); ?>"> Confirm</a></button>
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
        </div>
    </section>
<?php include resource_path('views/admin/includes/footer.php'); ?>
</html>
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
                    url: '<?= asset('delete_multiple_users') ?>',
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
