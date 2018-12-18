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
    {{--<a data-target="#add-modal" data-toggle="modal" class="add_s" href="#">Add New Question</a>--}}

    <div class="contentPd">
        {{--{{dd($recent_activities)}}--}}
        <h2 class="mainHEading">Legal</h2>
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

        <form action="{{url('/')}}/update/legal/{{$legal->id}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <label class="fullField">
                <span>Description</span>
                <textarea name="description" class="wh-speaker">{!! $legal->description !!}</textarea>
                @if ($errors->has('description'))
                    <div class="alert alert-danger">
                        @foreach ($errors->get('description') as $message)
                            {{ $message }}<br>
                        @endforeach
                    </div>
                @endif
            </label>
            <input type="hidden" value="{{$legal->id}}" name="id">
            <div class="btnCol">
                <input type="submit" name="signIn"  value="Submit">
            </div>
        </form>
    </div>
</section>
<?php include resource_path('views/admin/includes/footer.php'); ?>

<script src="{{ URL::to('public/src/js/vendor/tinymce/js/tinymce/tinymce.min.js') }}"></script>

<script>
    var editor_config = {
        path_absolute :"{{url('/')}}/",
        selector: "textarea",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscrenn",
            "inserdatetime media  nonbreaking save table contextmenu directonality",
            "emotions template pasts textcolor colorpicker textpattren"
        ],
        toolbar:"insertfile undo redo | stylesheet | bolditalic | alignleft aligncenter alignright alignjustify | bullist | numlist | linkimagemedi | outdent |indenet",
        relative_url: false,
        file_browser_callback: function(field_name,url,type,win)
        {
            var x = window.innerWidth | document.documentElement.ClientWidth | document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight | document.documentElement.ClientHeight | document.getElementsByTagName('body')[0].clientHeight;

            var cmsURL = editor_config.path_absoulte +'laravel-filemanager?field_name'+field
            if(type == 'image')
            {
                cmsURL = cmsURL+"&type=Image";
            }
            else
            {
                cmsURL = cmsURL +"&type=File"
            }
            tinyMCE.activeEditor.windowManager.open({
                file : cmsURL,
                title: 'Filemanager',
                width : x*0.8,
                height : y*0.8,
                resizeable : "yes",
                close_previous : "no"
            });
        }

    };
    tinymce.init(editor_config);



</script>





