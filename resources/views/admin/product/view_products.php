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
    <a data-target="#add-modal" data-toggle="modal" class="add_s" href="#">Add New Product</a>
<a class="add_s delete_all" href="javascript:void(0)">Delete All Selected</a>
    <div class="contentPd">
        <h2 class="mainHEading mainsubheading">Products</h2>
        
        <?php if($errors->any()) { ?>
            <div class="alert alert-danger">
                <?php foreach ($errors->all() as $error) { ?>
                    <?= $error ?><br/>
                <?php } ?>
            </div>
        <?php } ?>
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th width="100">Sr.</th>
                <th>Image</th>
                <th>Title</th>
                <th>Points</th>
                <th>Number of Orders</th>
                <!--<th>Delivered</th>-->
                <th width="120">Actions</th>
                <th width="120"><input class="" type="checkbox" id="checkedAll"> Select</th>
            </tr>
            </thead>
            <tbody>
                <?php if(count($products) > 0 ){ ?>
                    <?php 
                    $i = 1;
                    foreach($products as $product){ ?>
                    <tr>
                        <td><?php echo $i; $i++; ?></td>
                        <td><div class="products-images" style="background-image: url(<?php echo asset('public/images'.$product->attachment); ?>);"></div>
                            <!-- <img src=""></td> -->
                        <td><?= $product->name; ?></td>
                        <td><?= $product->points; ?></td>
                        <td class="strainhover"><a href="<?php if($product->get_orders_count) { echo asset('get_product_orders/'.$product->id); } else { echo 'javascript:void(0)';}?>"><?= $product->get_orders_count; ?></a></td>
<!--                        <td>
                            <a href="#"><i class="fa fa-square-o" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-check-square-o" aria-hidden="true"></i></a>
                        </td>-->
                        <td>
                            <?php if($product->get_orders_count == 0){ ?>
                                <a data-target="#edit-modal-<?= $product->id; ?>" data-toggle="modal" href="#">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                <a data-target="#delete-modal-<?= $product->id; ?>" data-toggle="modal" href="#">
                                    <i class="fa fa-trash fa-fw"></i>
                                </a>
                            <?php } ?>
                        </td>
                        <td> <?php if($product->get_orders_count == 0){ ?> 
                            <input class="sub_chk" type="checkbox"  data-id="<?= $product->id ?>">
                         <?php } ?></td>
                    </tr>
                    <!-- Delete Model -->
                    <div class="modal fade" id="delete-modal-<?= $product->id; ?>" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Delete Product</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete the Product ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button onlick="#" class="gener-delete"><a href="<?php echo asset('delete_product/'.$product->id); ?>">Confirm</a></button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Delete Model -->
                    <!-- Edit Model -->
                    <div class="modal fade" id="edit-modal-<?= $product->id; ?>" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Edit Product</h4>
                                </div>
                                <form action="<?php echo asset('edit_product')?>" method="POST" enctype="multipart/form-data" style="padding: 0px;">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="product_id" value="<?= $product->id; ?>">
                                    <div class="modal-body">
                                        <label>Product Name</label>
                                        <input type="text" value="<?= $product->name; ?>" name="product_name">
                                        <label>Product Points</label>
                                        <input type="number" value="<?= $product->points; ?>" name="points" min="0" max="10000" step="1">
                                        <label>Product Image</label>
                                        <div class="file btn btn-lg btn-primary">Upload<input type="file" name="image" class="custom_file_button"></div>
                                        <div class="image-previewer">
                                            <img class="changing-image" src="<?php echo asset('public/images'.$product->attachment); ?>" alt="Image" style="display:block;">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-default gener-delete">Submit</button>
                                        <button type="button" class="btn btn-default modal-closer" data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Edit Model -->
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="add-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Product</h4>
                </div>
                <form action="<?php echo asset('add_product')?>" method="POST" enctype="multipart/form-data" style="padding: 0px;">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="modal-body">
                        <label>Product Name</label>
                        <input type="text" value="<?php echo old('product_name'); ?>" name="product_name" required="">
                        <label>Product Points</label>
                        <input type="number" value="<?php echo old('points'); ?>" name="points" min="0" max="10000" step="1" required="">
                        <label>Product Image</label>
                        <div class="file btn btn-lg btn-primary">Upload<input type="file" name="image" class="custom_file_button" accept="image/x-png,image/gif,image/jpeg" required=""></div>
                        <div class="image-previewer"><img class="changing-image" src="#" alt="Image"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default gener-delete">Submit</button>
                        <button type="button" class="btn btn-default modal-closer" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
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
                    var join_selected_values = allVals.join(",");
                    $.ajax({
                        url: '<?= asset('delete_multiple_products') ?>',
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