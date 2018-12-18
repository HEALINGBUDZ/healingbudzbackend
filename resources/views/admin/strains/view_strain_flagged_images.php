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
    <a class="add_s delete_all" href="javascript:void(0)">Delete All Selected Flags</a>
    <div class="contentPd">
        <h2 class="mainHEading">Strain Flagged Images</h2>
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th width="90">Sr.</th>
                <th>Image</th>
                <th>Flagged By</th>
                <th>Reason</th>
                <th>Delete Image</th>
                <th width="120">Actions</th>
                <th width="120"><input class="" type="checkbox" id="checkedAll"> Select</th>
            </tr>
            </thead>
            <tbody>
            <?php if(isset($flags)){ ?>
                <?php 
                $i = 1;
                foreach($flags as $flag){ ?>
                    <tr>
                        <td><?php echo $i; $i++; ?></td>
                        <td><img src="<?php echo asset('/public/images'. $flag->getImage->image_path); ?>" style="width: 100px"></td>
                        <td class="strainhover">
                            <a href='<?php echo asset('user_detail/'.$flag->getUser->id); ?>'>
                                <?= $flag->getUser->first_name ?>
                            </a>
                        </td>
                        <td><?=$flag->reason?></td>
                        <td class="strainhover">
                            <a data-target="#modal_delete_image_<?= $flag->id ?>" data-toggle="modal" href="#">
                                Delete Image
                            </a>
                        </td>
                        <td>
                            <a data-target="#modal_delete_flag_<?= $flag->id ?>" data-toggle="modal" href="#">
                                <i class="fa fa-trash fa-fw"></i>
                            </a>
                        </td>
                        <td><input class="sub_chk" type="checkbox"  data-id="<?= $flag->id ?>"></td>
                    </tr>
                    <div class="modal fade" id="modal_delete_image_<?= $flag->id ?>" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Delete Strain Image</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete the strain image ?</p>
                                </div>
<div class="modal-footer form-adjust-admin">
                                            <form style="" method="get" action="<?= asset('delete_strain_image/' . $flag->image_id) ?>">
                                                <div class="form-inner-space">
                                                    <label>Reason</label> 
                                                    <input name="id" type="hidden" value="<?= $flag->image_id ?>" >  
                                                    <input type="text" name="message" required="" >  
                                                </div>
                                                <button type="submit" onlick="#" class="gener-delete" value="Confirm">Confirm </button>
                                                
                                            </form>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modal_delete_flag_<?= $flag->id ?>" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Delete Strain Image Flag</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete the strain image flag ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button onlick="#" class="gener-delete"><a href="<?php echo asset('delete_strain_flagged_image/'.$flag->id); ?>"> Confirm</a></button>
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
                    var join_selected_values = allVals.join(",");
                    $.ajax({
                        url: '<?= asset('delete_multiple_strain_flagged_images') ?>',
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

