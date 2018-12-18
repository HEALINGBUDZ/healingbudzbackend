<!DOCTYPE html>
<html lang="en">
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
            <a data-target="#add-modal" data-toggle="modal" class="add_s" href="#">Add New Question</a>

            <div class="contentPd">
                {{--{{dd($recent_activities)}}--}}

                <h2 class="mainHEading mainsubheading">Basic Q&A</h2>
                @if ($errors->has('sensation'))
                <div class="alert alert-danger">
                    @foreach ($errors->get('sensation') as $message)
                    {{ $message }}<br>
                    @endforeach
                </div>
                @endif
                @if($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                    {{ $error }}<br/>
                    @endforeach
                </div>
                @endif
                <table id="tableStyle" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Sr.</th>
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($basic_qa))
                        <?php $i = 1;?>
                        @foreach($basic_qa as $basic)
                        <tr>
                            <td><?php echo $i; $i++; ?></td>
                            <td>{{str_limit($basic->question,30)}}</td>
                            <td>{{str_limit($basic->answer,30)}}</td>
                            <td>
                                <a data-target="#edit-modal-{{$basic->id}}" data-toggle="modal" href="#"><i class="fa fa-edit fa-fw"></i></a>
                                <a data-target="#modal-{{$basic->id}}" data-toggle="modal" href="#"><i class="fa fa-trash fa-fw"></i></a>
                            </td>
                        </tr>
                    <div class="modal fade" id="modal-{{$basic->id}}" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Delete Question</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete the question ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button onlick="#" class="gener-delete"><a href="{{url('/')}}/delete_basic_qa/{{$basic->id}}"> Confirm</a></button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal fade" id="edit-modal-{{$basic->id}}" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Update Question</h4>
                                </div>
                                <form action="{{url('/')}}/update_basic_qa/{{$basic->id}}" method="post" enctype="multipart/form-data" style="padding: 0px;">
                                    {{csrf_field()}}
                                    <div class="modal-body">
                                        <span>Question</span>
                                        <textarea name="question">{{$basic->question}}</textarea>
                                        <span>Answer</span>
                                        <textarea name="answer">{{$basic->answer}}</textarea>
                                        <label class="fullField">
                                            <span>Image</span>
                                            <input type=file name="image" value="" id="banner-uploader">
                                        </label>
                                    </div>
                                    <div class="imgCol">
                                        @if($basic->image_path != '')
                                        <button type="button" class="del-img-btn" data-id="{{$basic->id}}" data-col="image_path" data-table="default_questions">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        <figure class="car"><img src="{{url('/').'/public'.$basic->image_path}}" style="width: 100px;" class="changing-image"></figure>
                                        @endif
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
                                    <h4 class="modal-title">Add Question</h4>
                                </div>
                                <form action="{{url('/')}}/add_basic_qa" method="post" enctype="multipart/form-data" style="padding: 0px;">
                                    {{csrf_field()}}
                                    <div class="modal-body">
                                        <label>Question</label>
                                        <textarea name="question"></textarea>
                                        <label>Answer</label>
                                        <textarea name="answer"></textarea>
                                        <div>
                                        <input type="file" name="image">
                                        </div>
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



