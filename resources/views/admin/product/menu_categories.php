<!DOCTYPE html>
<html lang="en">
    <?php include resource_path('views/admin/includes/head.php'); ?>
    <body>
        <?php include resource_path('views/admin/includes/header.php'); ?>
        <?php include resource_path('views/admin/includes/sidebar.php'); ?>
        <section class="content lifeContent">

            <a data-target="#add-modal" data-toggle="modal" class="add_s" href="#">Add New Category</a>
            <a class="add_s delete_all" href="javascript:void(0)">Delete All Selected</a>
            <div class="contentPd">
                <h2 class="mainHEading mainsubheading"><?= $title?></h2>
                <?php if (\Session::has('success')) { ?>
                    <h4 class="alert alert-success fade in">
                        <?php echo \Session::get('success') ?>
                    </h4>
                <?php } ?>
                <?php if (\Session::has('error')) { ?>
                    <h4 class="alert alert-danger fade in">
                        <?php echo \Session::get('error') ?>
                    </h4>
                <?php } ?>
                <table id="tableStyle" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="100">Sr.</th>
                            <th>Title</th>
                            <th width="120">Actions</th>
                            <th width="130"><input class="" type="checkbox" id="checkedAll"> Select</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($cats) > 0) { ?>
                            <?php
                            $i = 1;
                            foreach ($cats as $cat) {
                                ?>
                                <tr>
                                    <td><?php
                                        echo $i;
                                        $i++;
                                        ?></td>
                                    <td><?= $cat->title?></td>
                                    <td>
                                        <a data-target="#edit-modal-<?= $cat->id; ?>" data-toggle="modal" href="#">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </a>
                                        <a data-target="#delete-modal-<?= $cat->id; ?>" data-toggle="modal" href="#">
                                            <i class="fa fa-trash fa-fw"></i>
                                        </a>
                                        
                                    </td>
                                    <td> <?php if ($cat->get_orders_count == 0) { ?> 
                                            <input class="sub_chk" type="checkbox"  data-id="<?= $cat->id ?>">
                                        <?php } ?></td>
                                </tr>
                                <!--Edit model-->
                                <div class="modal fade" id="edit-modal-<?= $cat->id; ?>" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Category</h4>
                    </div>
                    <form action="<?php echo asset('add_menu_category') ?>" method="POST" enctype="multipart/form-data" style="padding: 0px;">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="id" value="<?php echo $cat->id ?>">
                        <div class="modal-body">

                            <label>Title</label>
                            <input required="" type="text" value="<?= $cat->title?>" autocomplete="off" name="title" >
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-default gener-delete">Submit</button>
                            <button type="button" class="btn btn-default modal-closer" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
                                <!--Edit model end-->
                                <!-- Delete Model -->
                            <div class="modal fade" id="delete-modal-<?= $cat->id; ?>" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Delete Category</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete the Category ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button onlick="#" class="gener-delete"><a href="<?php echo asset('delete_menu_category/' . $cat->id); ?>">Confirm</a></button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Delete Model -->
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
                        <h4 class="modal-title">Add Category</h4>
                    </div>
                    <form action="<?php echo asset('add_menu_category') ?>" method="POST" enctype="multipart/form-data" style="padding: 0px;">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <div class="modal-body">

                            <label>Title</label>
                            <input required="" type="text" value="" autocomplete="off" name="title">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-default gener-delete">Submit</button>
                            <button type="button" class="btn btn-default modal-closer" data-dismiss="modal">Close</button>
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
            url: '<?= asset('delete_multiple_menu_categories') ?>',
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



