<!DOCTYPE html>
<html lang="en">
    <?php include resource_path('views/admin/includes/head.php'); ?>
    <body>
        <?php include resource_path('views/admin/includes/header.php'); ?>
        <?php include resource_path('views/admin/includes/sidebar.php'); ?>
        <section class="content lifeContent">
            <?php if (\Session::has('success')) { ?>
                <h4 class="alert alert-success fade in">
                    <?php echo \Session::get('success'); ?>
                </h4>
            <?php } ?>

            <div class="contentPd">
                <h2 class="mainHEading mainsubheading">Shout Outs</h2>
                <a class="add_s delete_all" href="javascript:void(0)">Delete All Selected</a>
                <table id="tableStyle" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="80px">Sr.</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Business Title</th>
                            <th>Validity Date</th>
                            <th>Location</th>
                            <th width="90px">Likes</th>
                            <th width="90px">Views</th>
                            <th width="90px">Shares</th>
                            <th width="90px">Delete</th>
                            <th width="110px"><input class="" type="checkbox" id="checkedAll"> Select</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($shout_outs) > 0) { ?>
                            <?php
                            $i = 1;
                            foreach ($shout_outs as $shout_out) {
                                ?>
                                <tr>
                                    <td><?php echo $i;
                        $i++; ?></td>
                                    <td>
                                        <?php if ($shout_out->image) { ?>
                                            <img src="<?php echo asset('public/images' . $shout_out->image); ?>">
        <?php } ?>
                                    </td>
                                    <td><?= $shout_out->message; ?></td>
                                    <td class="strainhover"><a href="<?php echo asset('user_business_profile_detail/' . $shout_out->getSubUser->id) ?>"><?= $shout_out->getSubUser->title; ?></a></td>
                                    <td><?=  date("m-d-Y", strtotime($shout_out->validity_date)); ?></td>
                                    <td><?= $shout_out->public_location; ?></td>
                                    <td><?= $shout_out->likes_count; ?></td>
                                    <td><?= $shout_out->views_count; ?></td>
                                    <td><?= $shout_out->shares_count; ?></td>
                                    <td>
                                        <a data-target="#modal_delete_sub_user<?php echo $shout_out->id; ?>" data-toggle="modal" href="#">
                                            <i class="fa fa-trash fa-fw"></i>
                                        </a>  
                                    </td>
                                    <td><input class="sub_chk" type="checkbox"  data-id="<?= $shout_out->id ?>"></td>
                                </tr>
                            <div class="modal fade" id="modal_delete_sub_user<?= $shout_out->id ?>" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Delete Shoutout</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete the Shoutout?</p>
                                        </div>
                                        <div class="modal-footer form-adjust-admin">
                                            <form style="" method="get" action="<?= asset('delete_shout_outs/' . $shout_out->id) ?>">
                                                <div class="form-inner-space">
                                                    <label>Reason</label> 
                                                    <input name="id" type="hidden" value="<?= $shout_out->id ?>" >  
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
            <div id="loader" class="preloader-wrapper">
                <div class="preloader">
                    <img src="<?php echo asset('userassets/images/edit_post_loader.svg'); ?>" alt="NILA">
                </div>
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
                    var check = confirm("Are you sure you want to delete these rows?");
                    if (check == true) {
                        $('#loader').show();
                        var join_selected_values = allVals.join(",");
                        $.ajax({
                            url: '<?= asset('delete_multi_shout_outs') ?>',
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
                        setTimeout(function () {
                            window.location.reload();
                        }, 6000);

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