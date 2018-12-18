<!DOCTYPE html>
<html lang="en">
    <?php include resource_path('views/admin/includes/head.php'); ?>
    <body>
        <?php include resource_path('views/admin/includes/header.php'); ?>
        <?php include resource_path('views/admin/includes/sidebar.php'); ?>
        <section class="content lifeContent">

            <a data-target="#add-modal" data-toggle="modal" class="add_s" href="#">Add New Icon</a>
            <a class="add_s delete_all" href="javascript:void(0)">Delete All Selected</a>
            <div class="contentPd">
                <h2 class="mainHEading mainsubheading">User Icons</h2>
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
                            <th>Image</th>
                            <th width="120">Actions</th>
                            <th width="120"><input class="" type="checkbox" id="checkedAll"> Select</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($icons) > 0) { ?>
                            <?php
                            $i = 1;
                            foreach ($icons as $icon) {
                                ?>
                                <tr>
                                    <td><?php
                                        echo $i;
                                        $i++;
                                        ?></td>
                                    <td><img src="<?php echo asset('public/images' . $icon->name); ?>">

                                    <td>
<!--                                        <a data-target="#edit-modal-<?= $icon->id; ?>" data-toggle="modal" href="#">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </a>-->
                                        <a data-target="#delete-modal-<?= $icon->id; ?>" data-toggle="modal" href="#">
                                            <i class="fa fa-trash fa-fw"></i>
                                        </a>
                                    </td>
                                    <td> <?php if ($icon->get_orders_count == 0) { ?> 
                                            <input class="sub_chk" type="checkbox"  data-id="<?= $icon->id ?>">
                                        <?php } ?></td>
                                </tr>
                                <!-- Delete Model -->
                            <div class="modal fade" id="delete-modal-<?= $icon->id; ?>" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Delete Icon</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete the Icon ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button onlick="#" class="gener-delete"><a href="<?php echo asset('delete_icon/' . $icon->id); ?>">Confirm</a></button>
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
                        <h4 class="modal-title">Add icon</h4>
                    </div>
                    <form action="<?php echo asset('add_icon') ?>" method="POST" enctype="multipart/form-data" style="padding: 0px;">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <div class="modal-body">

                            <label>Icon</label>
                            <div class="file btn btn-lg btn-primary">Upload<input type="file" name="image" class="custom_file_button profile_photo" accept="image/x-png,image/gif,image/jpeg" required=""></div>
                            <div  class="image-previewer-icon"><img style="display: none" class="changing-icon" src="#" alt="Image"></div>
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
            url: '<?= asset('delete_multiple_icons') ?>',
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
        <script>
            var base_url = "<?php echo url('/'); ?>";
            $('.profile_photo').change(handleCoverPicSelect);
            function handleCoverPicSelect(event)
            {
            var input = this;
            var fileExtension = ['jpeg', 'jpg', 'png'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == - 1) {

            alert("Only formats are allowed : " + fileExtension.join(', '));
            $(this).val("");
            return;
            }
            if (input.files && input.files[0])
            {
            var id = $(this).attr('data-id');
            var data = event.target.files;
            var image = new FormData(event.target);
            var image_input = $(this).parent().find('img');
            image.append('image', data[0]);
            image.append('id', id);
            image.append('_token', "<?php echo csrf_token(); ?>");
            $.ajax({
            url: base_url + '/change_icon_image',
                    method : "POST",
                    data: image,
                    contentType:false,
                    processData:false,
                    success: function(data){
                    if (data.response == 'error'){
                    alert('image must have dimentions 200x200.');
                    } else{
                    var reader = new FileReader();
                    reader.onload = function(e) {
                    $('.changing-icon').show();
                    $('.changing-icon').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                    }
            },
                    error:function(data){
                    //                    var response = data.responseJSON
                    alert('image must have dimentions 200x200.');
                    },
            });
            }
            }
        </script>
    </body>
</html>     



