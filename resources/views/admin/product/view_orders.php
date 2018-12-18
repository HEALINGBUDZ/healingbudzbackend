<!DOCTYPE html>
<html lang="en">
<?php include resource_path('views/admin/includes/head.php'); ?>
<body>
<?php include resource_path('views/admin/includes/header.php'); ?>
<?php include resource_path('views/admin/includes/sidebar.php'); ?>
<section class="content lifeContent">
    <div class="container container-width">
        <div class="row">
            <div class="col-md-3 col-sm-4">
                <div class="statbox tabs user-tabs-row">
                    <div class="stat-title">Total Orders: <?= count($orders); ?></div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="statbox tabs user-tabs-row">
                    <div class="stat-title">Delivered: <?= $delivered; ?></div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="statbox tabs user-tabs-row">
                    <div class="stat-title">Pending: <?= $pending; ?></div>
                </div>
            </div>
        </div>
    </div>
    <?php if(\Session::has('success')) { ?>
        <h4 class="alert alert-success fade in">
            <?php echo \Session::get('success'); ?>
        </h4>
    <?php } ?>
    <!--<a data-target="#add-modal" data-toggle="modal" class="add_s" href="#">Add New Product</a>-->

    <div class="contentPd">
        <h2 class="mainHEading mainsubheading">Orders</h2>
        <a class="add_s delete_all" href="javascript:void(0)">Delete All Selected</a>
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
                <th>User</th>
                <th>Product</th>
                <th>Points</th>
                <th>Details</th>
                <th>Delivered</th>
                <th width="120">Actions</th>
                <th width="120"><input class="" type="checkbox" id="checkedAll"> Select</th>
            </tr>
            </thead>
            <tbody>
                <?php if(count($orders) > 0){ ?>
                    <?php 
                    $i = 1;
                    foreach($orders as $order){ 
                        if($order->getUser){
                        ?>
                    <tr>
                        <td><?php echo $i; $i++; ?></td>
                        <td class="strainhover"><a href="<?php echo asset('user_detail/'.$order->getUser->id)?>"><?= $order->getUser->first_name; ?></a></td>
                        <td><?= $order->getProduct->name; ?></td>
                        <td><?= $order->getProduct->points; ?></td>
                        <td class="strainhover">
                            <a data-target="#shipping-address-<?= $order->id;?>" data-toggle="modal" href="#">Shipping Address</a>
                        </td>
                        <td>
                            <?php if($order->status == 0){ ?>
                                <a href="<?php echo asset('order_status/1/'.$order->id)?>"><i class="fa fa-square-o" aria-hidden="true"></i></a>
                            <?php }else{ ?>
                                <a href="<?php echo asset('order_status/0/'.$order->id)?>"><i class="fa fa-check-square-o" aria-hidden="true"></i></a>
                            <?php } ?>
                        </td>
                        <td>
                            <a data-target="#delete-modal-<?= $order->id;?>" data-toggle="modal" href="#">
                                <i class="fa fa-trash fa-fw"></i>
                            </a>
                        </td>
                        <td><input class="sub_chk" type="checkbox"  data-id="<?= $order->id ?>"></td>
                    </tr>
                    <!-- Shipping Address Model -->
                    <div class="modal fade" id="shipping-address-<?= $order->id;?>" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Shipping Address</h4>
                                </div>
                                <div class="modal-body">
                                    <?php if($order->name){ ?>
                                        <p><strong>Name: </strong><em><?= $order->name; ?></em></p>
                                    <?php } ?>
                                    <?php if($order->city){ ?>
                                        <p><strong>City: </strong><em><?= $order->city; ?></em></p>
                                    <?php } ?>
                                    <?php if($order->state){ ?>
                                        <p><strong>State: </strong><em><?= $order->state; ?></em></p>
                                    <?php } ?>
                                    <p><strong>Address: </strong><em><?= $order->address; ?></em></p>
                                    <p><strong>Zip Code: </strong><em><?= $order->zip; ?></em></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Shipping Address Model -->
                    
                    <!-- Delete Model -->
                    <div class="modal fade" id="delete-modal-<?= $order->id;?>" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Delete Product</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete the Order ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button onlick="#" class="gener-delete"><a href="<?php echo asset('delete_order/'.$order->id); ?>">Confirm</a></button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Delete Model -->
                    <?php } ?>
                <?php }} ?>
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
                        url: '<?= asset('delete_multiple_orders') ?>',
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