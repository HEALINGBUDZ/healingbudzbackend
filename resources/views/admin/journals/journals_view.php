<!DOCTYPE html>
<html lang="en">
<?php include resource_path('views/admin/includes/head.php'); ?>
<body>
<?php include resource_path('views/admin/includes/header.php'); ?>
<?php include resource_path('views/admin/includes/sidebar.php'); ?>
<section class="content lifeContent">

    <?php if(\Session::has('success')) { ?>
        <h4 class="alert alert-success fade in">
            <?php echo \Session::get('success') ?>
        </h4>
    <?php } ?>

    <div class="contentPd">
        <h2 class="mainHEading mainsubheading">Journals</h2>
        <a class="add_s delete_all" href="javascript:void(0)">Delete All Selected</a>
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th width="100">Sr.</th>
                <th>Title</th>
                <th>Followers</th>
                <th>Likes</th>
                <th>Events</th>
                <th width="120">Actions</th>
                <th width="120"><input class="" type="checkbox" id="checkedAll"> Select</th>
            </tr>
            </thead>
            <tbody>
            <?php if(isset($journals)) { ?>
                <?php 
                $i = 1;
                foreach($journals as $journal) {?>
                    <tr>
                        <td><?php echo $i; $i++; ?></td>
                        <td><?= $journal->title ?></td>
                        <td><?= $journal->get_followers_count ?></td>
                        <td><?= $journal->get_likes_count ?></td>
                        <td class="strainhover"><a href="<?php if($journal->events_count) { echo asset('admin_journal_events/'.$journal->id); } else { echo 'javascript:void(0)'; } ?>"><?= $journal->events_count ?></a></td>
                        <td>
                            <a data-target="#modal-<?= $journal->id ?>" data-toggle="modal" href="#"><i class="fa fa-trash fa-fw"></i></a>
                        </td>
                        <td><input class="sub_chk" type="checkbox"  data-id="<?= $journal->id ?>"></td>
                    </tr>
                    <div class="modal fade" id="modal-<?= $journal->id ?>" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete the journal ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button onlick="#" class="gener-delete"><a href="<?php echo asset('admin_delete_journal/'.$journal->id); ?>"> Confirm</a></button>
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
                        url: '<?= asset('delete_multiple_journals') ?>',
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


