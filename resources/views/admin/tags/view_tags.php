<!DOCTYPE html>
<html lang="en">
    <?php include resource_path('views/admin/includes/head.php'); ?>
    <body>
        <?php include resource_path('views/admin/includes/header.php'); ?>
        <?php include resource_path('views/admin/includes/sidebar.php'); ?>
        <section class="content lifeContent">
            <div class="container container-width">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="statbox tabs tabe-margin">
                            <div class="stat-title">Total Keywords: <?= $tags->count(); ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="statbox tabs tabe-margin">
                            <div class="stat-title">Active Keywords: <?= $approved_count; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="statbox tabs tabe-margin">
                            <div class="stat-title">On Sale: <?= $on_sale ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (\Session::has('success')) { ?>
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
                <h2 class="mainHEading mainsubheading pull-left">Keywords</h2>
                <a class="add_s approve_btn" action="1" href="javascript:void(0)">Active All Selected</a>
                <a class="add_s approve_btn" action="0" href="javascript:void(0)">Inactive All Selected</a>
                <a class="add_s delete_all" href="javascript:void(0)">Delete All Selected</a>
                <a data-target="#add-modal" data-toggle="modal" class="add_s pull-right" href="#">Add New Keyword</a>
                <?php if ($errors->any()) { ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors->all() as $error) { ?>
                            <?= $error ?><br/>
                        <?php } ?>
                    </div>
                <?php } ?>
                <table id="tableStyleAjax" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="100">Sr#</th>
                            <th>Title</th>
                            <th width="120">Price</th>
                            <th width="160">Status</th>
                            <th>Sale</th>
                            <th width="150">Total Purchased</th>
                            <th width="120">Actions</th>
                            <th width="120"><input class="" type="checkbox" id="checkedAll"> Select</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($tags)) { ?>
                            <?php
                            $i = 0;
                            foreach ($tags as $tag) {
                                $i++;
                                ?>
                                <tr>
                                    <td><?= $i ?></td>

                                    <td class="strainhover"><a href="<?php echo asset('tag_searches/' . $tag->title . '/' . $tag->id) ?>"><?= $tag->title ?></td>
                                    <td><a style="cursor: pointer" data-target="#price-modal-<?= $tag->id ?>" data-toggle="modal"><?= $tag->price ?></a></td>
                                    <td>
                                        <?php if ($tag->is_approved == 0) { ?>
                                            <a href="<?php echo asset('tag_approve_status/1/' . $tag->id) ?>">Inactive</a>
                                        <?php } ?>
                                        <?php if ($tag->is_approved == 1) { ?>
                                            <a href="<?php echo asset('tag_approve_status/0/' . $tag->id) ?>">Active</a>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if ($tag->on_sale == 0) { ?>
                                            <a  style="cursor: pointer" data-target="#sale-modal-<?= $tag->id ?>" data-toggle="modal">Put On Sale</a>
                                        <?php } else { ?>
                                            <a style="cursor: pointer"  href="<?php echo asset('remove_tag_sale/' . $tag->id); ?>">Remove From Sale</a>
                                        <?php } ?>
                                    </td>
                                    <td><?= $tag->totalPurchased->count()?></td>
                                    <td>
                                        <?php // if ($tag->is_approved == 1 && count($tag->getTag) == 0) { ?>
                                            <a data-target="#edit-modal-<?= $tag->id ?>" data-toggle="modal" href="#"><i class="fa fa-edit fa-fw"></i></a>
                                            <a data-target="#modal-<?= $tag->id ?>" data-toggle="modal" href="#"><i class="fa fa-trash fa-fw"></i></a>
                                        <?php // } ?>
                                    </td>
                                    
                                    <td>
                                        <?php // if ($tag->is_approved == 1 && count($tag->getTag) == 0) { ?>
                                            <input class="sub_chk" type="checkbox"  data-id="<?= $tag->id ?>">
        <?php // } ?>
                                    </td>
                                </tr>
                            <div class="modal fade" id="modal-<?= $tag->id ?>" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Delete Keyword</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete the Keyword ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button onlick="#" class="gener-delete"><a href="<?php echo asset('delete_tag/' . $tag->id) ?>"> Confirm</a></button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="edit-modal-<?= $tag->id ?>" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Edit Keyword</h4>
                                        </div>
                                        <form style="padding:0px" action="<?php echo asset('update_tag'); ?>" method="post">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                            <input type="hidden" name="tag_id" value="<?php echo $tag->id; ?>">
                                            <div class="modal-body">
                                                <input class="add_tag" type="text" value="<?= $tag->title ?>" name="tag" required="">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-default gener-delete">Submit</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="price-modal-<?= $tag->id ?>" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Update Tag</h4>
                                        </div>
                                        <span>Update Price</span>
                                        <form   style="padding: 0px"  action="<?php echo asset('update_tag_price') ?>" method="post">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                            <input  type="hidden" name="tag_id" value="<?php echo $tag->id; ?>">
                                            <div class="modal-body">
                                                <input  type="number" value="<?= $tag->price ?>" name="price" required="">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-default gener-delete">Submit</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="sale-modal-<?= $tag->id ?>" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Put On Sale</h4>
                                        </div>
                                        <span class="add_price_span">Add Price</span>
                                        <form  style="padding: 0px" action="<?php echo asset('put_tag_on_sale') ?>" method="post">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                            <input type="hidden" name="tag_id" value="<?php echo $tag->id; ?>">
                                            <div class="modal-body">
                                                <input  type="number" value="<?= $tag->price ?>" name="price" min="0" max="1000" step="any" required="">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-default gener-delete">Submit</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
    <?php } ?>
<?php } ?>
                    <div class="modal fade" id="add-modal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Add Keyword</h4>
                                    <h6>Add , separated for multiple values</h6>
                                </div>
                                <form style="padding:0px"  action="<?php echo asset('add_tag'); ?>" method="post">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <div class="modal-body">
                                        <input class="add_tag" type="text" value="" name="tag" required="">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-default gener-delete">Submit</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    </tbody>
                </table>
            </div>
        </section>
<?php include resource_path('views/admin/includes/footer.php'); ?>
        <script>
            $('.add_tag').keypress(function (e) {
                if (e.which === 32) {
                    return false;
                }
            });
        </script>
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
                    var check = confirm("Are you sure you want to delete selected data?");
                    if (check == true) {
                        var join_selected_values = allVals.join(",");
                        $.ajax({
                            url: '<?= asset('delete_multiple_tags') ?>',
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
            
            $('.approve_btn').on('click', function (e) {
                var allVals = [];
                $(".sub_chk:checked").each(function () {
                    allVals.push($(this).attr('data-id'));
                });
                var status = $(this).attr('action');
                var msg = '';
                if(status == 1){
                    msg = "Are you sure you want to active selected data?";
                } else {
                    msg = "Are you sure you want to inactive selected data?";
                }
                if (allVals.length <= 0){
                    alert("Please select row.");
                } else {
                    var check = confirm(msg);
                    if (check == true) {
                        var join_selected_values = allVals.join(",");
                        $.ajax({
                            url: '<?= asset('approve_multiple_tags') ?>',
                            type: 'POST',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: {'ids': join_selected_values, 'status': status},
                            success: function (data) {
                                window.location.reload();
                            },
                            error: function (data) {
                                alert(data.responseText);
                            }
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
            $('#tableStyleAjax').DataTable({
                stateSave: true,
                "aoColumnDefs": [
                     { "aTargets": [7], "bSortable": false }
                 ]
            });
        </script>
    </body>
</html>


