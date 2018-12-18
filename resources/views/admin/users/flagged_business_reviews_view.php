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

            <div class="contentPd">
                <h2 class="mainHEading mainsubheading"><?= $title ?></h2>
                <?php if ($errors->has('sensation')) { ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors->get('sensation') as $message) { ?>
                            <?php echo $message ?><br>
                        <?php } ?>
                    </div>
                <?php } ?>
                <a class="add_s delete_all" data-delete="delete" href="javascript:void(0)">Delete All Selected</a> 
                <table id="tableStyle" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="100">Sr</th>
                            <th>Business Review</th>
                            <th>Flag by</th>
                            <th>Reason</th>
                            <th>Delete Business Review</th>
                            <th>Action</th>
                            <th width="120"><input class="" type="checkbox" id="checkedAll"> Select</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($flagged_business)) {
                            $i = 0;
                            ?>
                            <?php
                            foreach ($flagged_business as $fb) {
                                $i++;
                                ?>
                                <tr>
                                    <td >
        <?= $i ?>
                                    </td>
                                    <td><?=$fb->review->text?></td>
                                    <td class="strainhover">
                                        <a href='<?php echo asset('user_detail/' . $fb->user->id); ?>'><?= $fb->user->first_name ?></a>
                                    </td>
                                    <td><?= $fb->reason ?></td>
                                    <td>
                                        <a data-target="#modal_delete_business_review_<?= $fb->id ?>" data-toggle="modal" href="#">
                                            Delete Business Review
                                        </a>
                                    </td>
                                    <td>
                                        <a data-target="#modal_delete<?= $fb->id ?>" data-toggle="modal" href="#">
                                            <i class="fa fa-trash fa-fw"></i>
                                        </a>
                                    </td>
                                    <td><input class="sub_chk" type="checkbox"  data-id="<?= $fb->id ?>" ></td>
                                </tr>
                                <div class="modal fade" id="modal_delete_business_review_<?= $fb->id ?>" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Delete Business Review</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete the business review ?</p>
                                            </div>
<div class="modal-footer form-adjust-admin">
                                            <form style="" method="get" action="<?= asset('delete_business_review/' . $fb->business_review_id) ?>">
                                                <div class="form-inner-space">
                                                    <label>Reason</label> 
                                                    <input name="id" type="hidden" value="<?= $fb->business_review_id ?>" >  
                                                    <input type="text" name="message" required="" >  
                                                </div>
                                                <button type="submit" onlick="#" class="gener-delete" value="Confirm">Confirm </button>
                                                
                                            </form>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="modal_delete<?= $fb->id ?>" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Delete Business Review Flag</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete the business review flag ?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button onlick="#" class="gener-delete"><a href="<?php echo asset('delete_business_review_flag/' . $fb->id); ?>"> Confirm</a></button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                     <div id="loader" class="preloader-wrapper">
    <div class="preloader">
        <img src="<?php echo asset('userassets/images/edit_post_loader.svg'); ?>" alt="NILA">
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
                    $('#loader').show();
                    var join_selected_values = allVals.join(",");
                    $.ajax({
                        url: '<?= asset('delete_multiple_business_review_flags') ?>',
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

