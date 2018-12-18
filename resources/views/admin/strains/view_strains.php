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
                        <div class="statbox tabs tabe-margin">
                            <div class="stat-title">Total Strains: <?= $strains_count; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <div class="statbox tabs tabe-margin">
                            <div class="stat-title">Indica: <?= $indica_count; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <div class="statbox tabs tabe-margin">
                            <div class="stat-title">Sativa: <?= $sativa_count ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <div class="statbox tabs tabe-margin">
                            <div class="stat-title">Hybrid: <?= $hybrid_count; ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (\Session::has('success')) { ?>
                <h4 class="alert alert-success fade in">
                    <?php echo \Session::get('success'); ?>
                </h4>
            <?php } ?>
            <a data-target="#add-modal" data-toggle="modal" class="add_s" href="#">Add New Strain</a>
<a class="add_s delete_all" href="javascript:void(0)">Delete All Selected</a>
            <div class="contentPd">
                <h2 class="mainHEading mainsubheading">Strains</h2>
                
                <table id="tableStyleAjax" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="90">Sr</th>
                            <th>Title</th>
                            <th width="100">Type</th>
                            <th>Overview</th>
                            <th width="120">User Edits</th>
                            <th width="120">No of Reviews</th>
                            <th width="120">Strain Flags</th>
                            <th width="100">Images</th>
                            <th width="110">Not Approved</th>
                            <th width="120">Actions</th>
                            <th width="120"><input class="" type="checkbox" id="checkedAll"> Select</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
                <div class="modal fade" id="modal" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Delete Strain</h4>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete the strain ?</p>
                            </div>
                            <div class="modal-footer">
                                <button onlick="#" class="gener-delete"><a href="#" id="delete_anchor"> Confirm</a></button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal fade" id="edit-modal" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Update Strain</h4>
                            </div>
                            <form action="<?php echo asset('update_strain') ?>" method="post" enctype="multipart/form-data" style="padding: 0px;">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <input type="hidden" name="strain_id" value="">
                                <div class="modal-body">
                                    <label>Title</label>
                                    <input type="text" autocomplete="off" name="title" value="" maxlength="35">
                                    <label>Overview</label>
                                <?php /* <input type="text" autocomplete="off" name="overview" value="<?= $strain->overview ?>"> */ ?>
                                    <textarea autocomplete="off" name="overview"></textarea>
                                    <label>Strain Type</label>
                                    <select name="type_id">
                                        <?php foreach ($strain_types as $type) { ?>
                                            <option value="<?= $type->id ?>">
                                            <?= $type->title ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <label>Image</label>
                                    <input type="file" name="file">
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-default gener-delete">Submit</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="modal fade" id="add-modal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add Strain</h4>
                        </div>
                        <form action="<?php echo asset('add_strain') ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="modal-body">
                                <label>Title</label>
                                <input type="text" autocomplete="off" name="title" required="" maxlength="35">
                                <label>Overview</label>
                                <input type="text" autocomplete="off" name="overview" required="">
                                <label>Strain Type</label>
                                <select name="type_id" required="">
                                        <?php foreach ($strain_types as $type) { ?>
                                        <option value="<?= $type->id ?>">
                                        <?= $type->title ?>
                                        </option>
<?php } ?>
                                </select>
                                <label>Image</label>
                                <input multiple="" type="file" name="file[]" accept="image/*">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default gener-delete">Submit</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
<?php include resource_path('views/admin/includes/footer.php'); ?>
        <script>
        function deleteModal(id){    
            $('#delete_anchor').attr('href', '<?php echo asset('delete_strain' ) ?>'+'/'+id);
        }
        
        function editModal(id, title, overview, type){    
            $('input[name=strain_id]').val(id);
            $('input[name=title]').val(title);
            $('textarea[name=overview]').html(overview);
            $('select[name=type_id] option[value="' + type + '"]').attr('checked','checked');
            $('select[name=type_id]').val($('select[name=type_id] option[value="' + type + '"]').attr('value'));
        }

        $('#tableStyleAjax').DataTable({
//            "processing": true,
            "serverSide": true,
            ajax: {
                'url': "<?=asset('/strains_ajax')?>",
                "dataType": "json",
                "type": "POST",
                "data": {_token: $('meta[name="csrf-token"]').attr('content')}
            },
            "columns": [
                {"data": "Sr"},
                {"data": "Title"},
                {"data": "Type"},
                {"data": "Overview"},
                {"data": "User Edits"},
                {"data": "No of Reviews"},
                {"data": "Strain Flags"},
                {"data": "Images"},
                {"data": "Not Approved"},
                {"data": "Actions"},
                {"data": "Select"}    
            ],
            "aoColumnDefs": [
                { "aTargets": [10, 9], "bSortable": false },
                { "aTargets": [1,4,5,6,7,8], "className": "strainhover" }
            ]
        });    
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
                        url: '<?= asset('delete_multiple_strains') ?>',
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
<script>
    $(document).ready(function(){
          var allRadios = document.getElementsByName('rating');
var booRadio;
var x = 0;
for(x = 0; x < allRadios.length; x++){
  allRadios[x].onclick = function() {
    if(booRadio == this){
      this.checked = false;
      booRadio = null;
    } else {
      booRadio = this;
    }
  };
}
    });
    
$('input[type=file]').change(handleImageSelect);
    function handleImageSelect(event)
    {
        var input = this;
        var filename = $(input).val();
        var fileType = filename.replace(/^.*\./, '');
        var ValidImageTypes = ["jpg", "jpeg", "png", "bmp"];
        if ($.inArray(fileType, ValidImageTypes) < 0) {
            alert("The file does not match the upload conditions, You can only upload jpg/jpeg/png/bmp files");
            event.preventDefault();
            $(this).val('');
            return;
        }
        if (input.files && input.files[0])
        {
            var reader = new FileReader();
            reader.readAsDataURL(input.files[0]);
        }
        else {
            alert("The file does not match the upload conditions, The maximum file size for uploads should not exceed 2MB");
        }
    }    
</script>

