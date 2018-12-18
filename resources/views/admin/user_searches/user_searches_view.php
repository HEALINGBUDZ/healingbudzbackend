<!DOCTYPE html>
<html lang="en">
<?php include resource_path('views/admin/includes/head.php'); ?>
<body>
<?php include resource_path('views/admin/includes/header.php'); ?>
<?php include resource_path('views/admin/includes/sidebar.php'); ?>
<section class="content lifeContent">
    
    <?php if(\Session::has('success')) { ?>
        <h4 class="alert alert-success fade in">
            <?php echo \Session::get('success'); ?>
        </h4>
    <?php } ?>
    <?php if (\Session::has('error')) { ?>
        <h4 class="alert alert-danger fade in">
            <?php echo \Session::get('error'); ?>
        </h4>
    <?php } ?>

    <div class="contentPd">
        <h2 class="mainHEading mainsubheading">User Searches</h2>
        <a class="add_s delete_all" href="javascript:void(0)">Delete All Selected</a>
        
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th width="100">Sr.</th>
                <th>Title</th>
                <th width="180">Searched Count</th>
                <th width="200">Approve Status</th>
                <th width="130">Actions</th>
                <th width="130"><input class="" type="checkbox" id="checkedAll"> Select</th>
            </tr>
            </thead>
            <tbody>
            <?php if(isset($user_searches)) {
                
                ?>
                <?php 
                $i = 1;
                foreach($user_searches as $search) {
                    $removed_anchor=preg_replace("/<a[^>]+\>/i", "",$search->key_word);
                    $removed_anchor=str_replace('"', "",$removed_anchor);
                    ?>
                    <tr>
                        <td><?php echo $i; $i++; ?></td>
                        <td><?= $removed_anchor ?></td>
                        <td><?php if($search->search_count){
                            echo $search->search_count->total_count;
                        }else{
                            echo '0';
                        } ?></td>
                        <td class="strainhover">
                            <?php if($search->is_tag == 0){ ?>
                            <a href="<?php echo asset('add_to_tag/'.$search->id)?>">Add To Tags</a>
                            <?php }else{ ?>
                            <a href="javascript:void(0)">Added To Tag</a>
                            <?php } ?>
                        </td>
                        <td>
                            <a data-target="#modal-<?= $search->id ?>" data-toggle="modal" href="#"><i class="fa fa-trash fa-fw"></i></a>
                        </td>
                         <td><input class="sub_chk" type="checkbox"  data-id="<?= $search->id ?>"></td>
                    </tr>
                    <div class="modal fade" id="modal-<?= $search->id ?>" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Delete Search</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete the search ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button onlick="#" class="gener-delete"><a href="<?php echo asset('delete_user_search/'.$search->id)?>"> Confirm</a></button>
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
                var check = confirm("Are you sure you want to delete this row?");
                if (check == true) {
                    var join_selected_values = allVals.join(",");
                    $.ajax({
                        url: '<?= asset('delete_multiple_user_searches') ?>',
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


