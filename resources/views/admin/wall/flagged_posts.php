<!DOCTYPE html>
<html lang="en">
    <?php include resource_path('views/admin/includes/head.php'); ?>
    <body>
        <?php include resource_path('views/admin/includes/header.php'); ?>
        <?php include resource_path('views/admin/includes/sidebar.php'); ?>
        <section class="content lifeContent">
           
            <?php if(Session::has('success')) { ?>
                <h4 class="alert alert-success fade in">
                    <?php echo Session::get('success'); ?>
                </h4>
            <?php } ?>
            <?php if(Session::has('error')) { ?>
                <h4 class="alert alert-danger fade in">
                    <?php echo Session::get('error'); ?>
                </h4>
            <?php } ?>
            <!--<a class="add_s" href="<?php // echo asset('add_user')?>">Add New User</a>-->

            <div class="contentPd">
                <h2 class="mainHEading mainsubheading">Flagged Posts</h2>
                <a class="add_s delete_all" data-delete="delete" href="javascript:void(0)">Delete All Selected</a> 
                <a class="add_s delete_all" data-delete="flag" href="javascript:void(0)">Delete Flag Selected</a>
                
                <table id="tableStyle" class="display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th width="100">Sr.</th>
                        <th>Description</th>
                        <th>User</th>
                        <th>Image</th>
                        <th>Flagged By</th>
                        <th>Reason</th>
                        <th width="120">Actions</th>
                        <th width="120"><input class="" type="checkbox" id="checkedAll"> Select</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($posts)) {?>
                        <?php 
                        $i = 1;
                        foreach($posts as $post) {
                            $removed_anchor=preg_replace("/<a[^>]+\>/i", "",$post->Flags->description);
                            ?>
                            <tr>
                                <td><?php echo $i; $i++; ?></td>
                                <td>
                                    <?= $removed_anchor ?> 
                                </td>
                                <td class="strainhover"><a href='<?php echo asset('user_detail/'.$post->Flags->User->id); ?>'><?php echo $post->Flags->User->first_name; ?></a></td>
                                <td><?php if (count($post->Flags->files) > 0) {
                                    foreach ($post->Flags->files->take(1) as $file) { ?>

            <?php if ($file->type == 'image') { ?>
                                            <img src="<?php echo asset('public/images' . $file->file) ?>" alt="Image" class="img-responsive">

            <?php } else { ?>
                                            <img src="<?php echo asset('public/images' . $file->poster) ?>" alt="Image" class="img-responsive">


                                        <?php }
                                }} ?></td>
                               
                                    <td><?= $post->User->first_name?></td>
                                
                                <td><?= $post->reason?></td>
                                <td>
                                    
                                    <a data-target="#modal-<?php echo $post->Flags->id; ?>" data-toggle="modal" href="#">
                                        <i class="fa fa-trash fa-fw"></i>
                                       
                                    </a> 
                                     <a data-target="#modal-flag<?php echo $post->id; ?>" data-toggle="modal" href="#">
                                        <i class="fa fa-flag fa-fw"></i>
                                       
                                    </a> 
                                    <a href="<?= asset('admin_post_detail/'.$post->Flags->id)?>" target="_blank"><i class="fa fa-info-circle fa-fw "></i></a>
                                </td>
                                <td><input class="sub_chk" type="checkbox"  data-id="<?= $post->id ?>" data-post="<?= $post->Flags->id ?>"></td>
                            </tr>
                            <div class="modal fade" id="modal-<?php echo $post->Flags->id; ?>" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            Delete Post
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete the post ?</p>
                                        </div>
                                        <div class="modal-footer form-adjust-admin">
                                            <form style="" method="get" action="<?= asset('admin_delete_post/' . $post->Flags->id) ?>">
                                                <div class="form-inner-space">
                                                    <label>Reason</label> 
                                                    <input name="id" type="hidden" value="<?= $post->Flags->id ?>" >  
                                                    <input type="text" name="message" required="" >  
                                                </div>
                                                <button type="submit" onlick="#" class="gener-delete" value="Confirm">Confirm </button>
                                                
                                            </form>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    
                     <div class="modal fade" id="modal-flag<?php echo $post->id; ?>" role="dialog">
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
                                            <button onlick="#" class="gener-delete"><a href="<?php echo asset('admin_post_remove_flag/'.$post->id); ?>"> Confirm</a></button>
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
            <div id="loader" class="preloader-wrapper">
                                <div class="preloader">
                                    <img src="<?php echo asset('userassets/images/edit_post_loader.svg'); ?>" alt="NILA">
                                </div>
                            </div>
        </section>
        <?php include resource_path('views/admin/includes/footer.php'); ?>
          <script>
            $('.delete_all').on('click', function (e) {

                check_url = $(this).data('delete');
                if (check_url == 'delete') {
                    url = '<?= asset('admin_delete_multi_posts') ?>';
                } else {
                    url = '<?= asset('admin_post_remove_multi_flag') ?>';
                }
                if (check_url == 'delete') {
                    var allVals = [];
                    $(".sub_chk:checked").each(function () {
                        allVals.push($(this).attr('data-post'));
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
                        $('#loader').show();
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
