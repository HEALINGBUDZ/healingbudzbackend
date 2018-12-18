<!DOCTYPE html>
<html lang="en">
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <?php include resource_path('views/admin/includes/head.php'); ?>
    <body>
        <?php include resource_path('views/admin/includes/header.php'); ?>
        <?php include resource_path('views/admin/includes/sidebar.php'); ?>
        <section class="content lifeContent">

            @if(\Session::has('success'))
            <h4 class="alert alert-success fade in">
                {{\Session::get('success')}}
            </h4>
            @endif
            
            <a class="add_s delete_all" href="javascript:void(0)">Delete All Selected</a>
            
            <a data-target="#add-modal" data-toggle="modal" class="add_s" href="#">Add New Flavor</a>

            <a href="<?=asset('/view_all_flavor_categories')?>" class="add_s">View All Flavor Cateogries</a>

            <div class="contentPd">
                {{--{{dd($recent_activities)}}--}}
                <h2 class="mainHEading mainsubheading">Flavors</h2>
                @if ($errors->has('flavor'))
                <div class="alert alert-danger">
                    @foreach ($errors->get('flavor') as $message)
                    {{ $message }}<br>
                    @endforeach
                </div>
                @endif
                <table id="tableStyle" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="100">Sr.</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Actions</th>
                            <th width="120"><input class="" type="checkbox" id="checkedAll"> Select</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($flavors))
                        <?php $i = 1; ?>
                        @foreach($flavors as $flavor)
                        <tr>
                            <td><?php echo $i; $i++; ?></td>
                            <td>{{$flavor->flavor}}</td>
                            <td>{{$flavor->getFlavorCategory->category}}</td>
                            <td>
                                @if($flavor->is_approved == 1)
                                <a data-target="#edit-modal-{{$flavor->id}}" data-toggle="modal" href="#"><i class="fa fa-edit fa-fw"></i></a>
                                <a data-target="#modal-{{$flavor->id}}" data-toggle="modal" href="#"><i class="fa fa-trash fa-fw"></i></a>
                                @endif
                            </td>
                            <td><input class="sub_chk" type="checkbox"  data-id="<?= $flavor->id ?>"></td>

                        </tr>
                    <div class="modal fade" id="modal-{{$flavor->id}}" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Delete Flavor</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete the flavor ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button onlick="#" class="gener-delete"><a href="{{url('/')}}/delete_flavor/{{$flavor->id}}"> Confirm</a></button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal fade" id="edit-modal-{{$flavor->id}}" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Edit Flavor</h4>
                                </div>
                                <form style="padding: 0px" action="{{url('/')}}/update_flavor/{{$flavor->id}}" method="post">
                                    {{csrf_field()}}
                                    <div class="modal-body">
                                        <input type="text" value="{{$flavor->flavor}}" autocomplete="off" name="flavor">
                                        <label>Flavor Category</label>
                                        <select name="category">
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}" <?= $flavor->getFlavorCategory->category == $category->category ? 'selected' : '' ?>>{{$category->category}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-default gener-delete">Submit</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @endforeach
                    @endif
                    <div class="modal fade" id="add-modal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Add Flavor</h4>
                                    <h6>Add , separated for multiple values</h6>
                                </div>
                                <form style="padding: 0px" action="{{url('/')}}/add_flavor" method="post">
                                    {{csrf_field()}}
                                    <div class="modal-body">
                                        <input type="text" value="" autocomplete="off" name="flavor">
                                        <label>Flavor Category</label>
                                        <select name="category">
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->category}}</option>
                                            @endforeach
                                        </select>
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
                            url: '<?= asset('delete_multiple_flavors') ?>',
                            type: 'POST',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: 'ids=' + join_selected_values,
                            success: function (data) {
                                if (data['success']) {
                                    $(".sub_chk:checked").each(function () {
                                        $(this).parents("tr").remove();
                                    });
                                    alert(data['success']);
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



