<!DOCTYPE html>
<html lang="en">
    <?php include resource_path('views/admin/includes/head.php'); ?>
    <body>
        <?php include resource_path('views/admin/includes/header.php'); ?>
        <?php include resource_path('views/admin/includes/sidebar.php'); ?>
        <section class="content lifeContent">
            <div class="container container-width">
                <div class="row user-tabs-row">
                    <div class="col-md-3 col-sm-4">
                        <div class="statbox tabs tabe-margin">
                            <div class="stat-title">Total Profiles: <?= $sub_users_count; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <div class="statbox tabs tabe-margin">
                            <div class="stat-title">Featured: <?= $featured_profiles_count; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <div class="statbox tabs tabe-margin">
                            <div class="stat-title">Free: <?= $sub_users_count - $featured_profiles_count; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <div class="statbox tabs tabe-margin">
                            <div class="stat-title">Dispensary: <?= $dispensary_count; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <div class="statbox tabs tabe-margin">
                            <div class="stat-title">Medical: <?= $medical_count; ?></div>
                        </div>
                    </div>
                    <!--  </div>
                     <br>
                     <div class="row user-tabs-row"> -->
                    <div class="col-md-3 col-sm-4">
                        <div class="statbox tabs tabe-margin">
                            <div class="stat-title">Cannabites: <?= $cannabites_count; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <div class="statbox tabs tabe-margin">
                            <div class="stat-title">Entertainment: <?= $entertainment_count; ?></div>
                        </div>
                    </div> 
                    <div class="col-md-3 col-sm-4">
                        <div class="statbox tabs tabe-margin">
                            <div class="stat-title">Events: <?= $event_count; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <div class="statbox tabs tabe-margin">
                            <div class="stat-title">Unassigned: <?= $un_assigned_profiles_count; ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (\Session::has('success')) { ?>
                <h4 class="alert alert-success fade in">
                    <?php echo \Session::get('success') ?>
                </h4>
            <?php } ?>


            <div class="contentPd">
                <h2 class="mainHEading mainsubheading pull-left">Business Profiles</h2>
                <a class="add_s delete_all" href="javascript:void(0)">Delete All Selected</a>
                <!--<a class="add_s" href="<?php // echo asset('show_users');  ?>">Back</a>-->
                <table id="tableStyleAjax" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="90">Sr</th>
                            <th>Title</th>
                            <th width="220">Phone</th>
                            <th>Type</th>
                            <th>Location</th>
                            <th width="150">Reviews Count</th>
                            <th width="150">Block Listing</th>
                            <th width="120">Delete</th>
                            <th width="120"><input class="" type="checkbox" id="checkedAll"> Select</th>


                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                
                <div class="modal fade" id="modal_delete_sub_user" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Delete Profile</h4>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete the Profile?</p>
                            </div>
                            <div class="modal-footer form-adjust-admin">
                                <form style="" method="get" id="delete_form" action="">
                                    <div class="form-inner-space">
                                        <label>Reason</label> 
                                        <input name="id" type="hidden" id="delete_form_id" value="">  
                                        <input type="text" name="message" required="">
                                    </div>
                                    <button type="submit" onlick="#" class="gener-delete" value="Confirm">Confirm </button>

                                </form>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </section>
<?php include resource_path('views/admin/includes/footer.php'); ?>
        <script>
            
            function deleteModal(id){    
                $('#delete_form').attr('action', '<?= asset('delete_bussiness_profile') ?>'+'/'+id);
                $('#delete_form_id').val(id);
            }
            
            $('#tableStyleAjax').DataTable({
//                "processing": true,
                "serverSide": true,
                ajax: {
                    'url': "<?=asset('/business_profiles_ajax')?>",
                    "dataType": "json",
                    "type": "POST",
                    "data": {_token: $('meta[name="csrf-token"]').attr('content')}
                },
                "columns": [
                    {"data": "Sr"},
                    {"data": "Title"},
                    {"data": "Phone"},
                    {"data": "Type"},
                    {"data": "Location"},
                    {"data": "Reviews Count"},
                    {"data": "Block Listing"},
                    {"data": "Delete"},
                    {"data": "Select"}
                ],
                "aoColumnDefs": [
                    { "aTargets": [5, 6, 7, 8], "bSortable": false },
                    { "aTargets": [1], "className": "strainhover" }
                ]
            });
            function blocksubuser(ele, id) {
                if (ele.checked) {
                    is_blocked = 1;
                } else {
                    is_blocked = 0;
                }
                $.ajax({
                    url: '<?= asset('block_unblock_business_profiles') ?>',
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {is_blocked: is_blocked, id: id},
                    success: function (data) {
                    }
                });
            }
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
                        $('#loader').show();
                        var join_selected_values = allVals.join(",");
                        $.ajax({
                            url: '<?= asset('delete_multiple_subusers') ?>',
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

