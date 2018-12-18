<!DOCTYPE html>
<html lang="en">
    <?php include resource_path('views/admin/includes/head.php'); ?>
    <body>
        <?php include resource_path('views/admin/includes/header.php'); ?>
        <?php include resource_path('views/admin/includes/sidebar.php'); ?>
        <section class="content lifeContent">
            <div class="container container-width">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="statbox tabs tabe-margin">
                            <div class="stat-title">Total Posts: <?= $posts->count();?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="statbox tabs tabe-margin">
                            <div class="stat-title">Last Week: <?= $this_week;?></div>
                        </div>
                    </div>
                   
                </div>
            </div>
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
            <!--<a class="add_s" href="<?php // echo asset('add_user')?>">Add New User</a>-->

            <div class="contentPd">
                <h2 class="mainHEading mainsubheading">Wall Posts</h2>
                <a class="add_s delete_all" href="javascript:void(0)">Delete All Selected</a>
                <table id="tableStyle" class="display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th width="100">Sr.</th>
                        <th>Description</th>
                        <th>User</th>
                        <th>Image</th>
                        <th width="150">Like Count</th>
                        <th width="150">Comments Count</th>
                        <th width="150">Repost Count</th>
                        <th width="120">Actions</th>
                        <th width="120"><input class="" type="checkbox" id="checkedAll"> Select</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($posts)) {?>
                        <?php 
                        $i = 1;
                        foreach($posts as $post) {?>
                            <tr>
                                <td><?php echo $i; $i++; ?></td>
                                <td>
                     <?php $removed_anchor=preg_replace("/<a[^>]+\>/i", "",$post->description); echo  substr($removed_anchor, 0, 300); ?>   
                                    
                                </td>
                                <td class="strainhover"><a href='<?php echo asset('user_detail/'.$post->User->id); ?>'><?php echo $post->User->first_name; ?></a></td>
                                <td><?php if (count($post->files) > 0) {
                                    foreach ($post->files->take(1) as $file) { ?>
                                        <?php if ($file->type == 'image') { ?>
                                            <div class="wall-profile-image" style="background-image: url(<?php echo asset('public/images' . $file->file) ?>)"></div>
                                            

                                        <?php } else { ?>
                                        <div class="wall-profile-image" style="background-image: url(<?php echo asset('public/images' . $file->poster) ?>)"></div>
                                            


                                        <?php }
                                }} ?></td>
                               
                                    <td><?= $post->Likes->count()?></td>
                                
                                <td><?= $post->Comments->count()?></td>
                                <td><?= $post->Repost->count()?></td>
                                <td>
                                    
                                    <a data-target="#modal-<?php echo $post->id; ?>" data-toggle="modal" href="#">
                                        <i class="fa fa-trash fa-fw"></i>
                                        <a href="<?= asset('admin_post_detail/'.$post->id)?>" target="_blank"><i class="fa fa-info-circle fa-fw "></i></a>
                                    </a>
                                </td>
                                <td><input class="sub_chk" type="checkbox"  data-id="<?= $post->id ?>"></td>
                            </tr>
                            <div class="modal fade" id="modal-<?php echo $post->id; ?>" role="dialog">
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
                                            <form style="" method="get" action="<?= asset('admin_delete_post/' . $post->id) ?>">
                                                <div class="form-inner-space">
                                                    <label>Reason</label> 
                                                    <input name="id" type="hidden" value="<?= $post->id ?>" >  
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
                var check = confirm("Are you sure you want to delete this row?");
                if (check == true) {
                    $('#loader').show();
                    var join_selected_values = allVals.join(",");
                    $.ajax({
                        url: '<?= asset('admin_delete_multi_posts') ?>',
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
