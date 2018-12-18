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
    {{--<a data-target="#add-modal" data-toggle="modal" class="add_s" href="#">Add New Answer</a>--}}

    <div class="contentPd">
        {{--{{dd($recent_activities)}}--}}
        <h2 class="mainHEading mainsubheading">Experience Questions</h2>
        @if ($errors->has('expertise_question'))
            <div class="alert alert-danger">
                @foreach ($errors->get('expertise_question') as $message)
                    {{ $message }}<br>
                @endforeach
            </div>
        @endif
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Sr.</th>
                <th>Questions</th>
                <th>Answers</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($questions))
            <?php $i = 1; ?>
                @foreach($questions as $question)
                    <tr>
                        <td><?php echo $i; $i++; ?></td>
                        <td>{{$question->question}}</td>
                        <td class="strainhover"><a href="{{url('/')}}/expertise_answers/{{$question->id}}">View Answers</a></td>
                        <td>
                            <a data-target="#edit-modal-{{$question->id}}" data-toggle="modal" href="#"><i class="fa fa-edit fa-fw"></i></a>
                            <!--<a data-target="#modal-{{$question->id}}" data-toggle="modal" href="#"><i class="fa fa-trash fa-fw"></i></a>-->
                        </td>
                    </tr>
<!--                    <div class="modal fade" id="modal-{{$question->id}}" role="dialog">
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
                                    <button onlick="#"><a href="{{url('/')}}/deleteexpertise_question/{{$question->id}}"> Confirm</a></button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>-->


                    <div class="modal fade" id="edit-modal-{{$question->id}}" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Update Question</h4>
                                </div>
                                <form action="{{url('/')}}/update_expertise_question/{{$question->id}}" method="post" style="padding: 0px;">
                                    {{csrf_field()}}
                                    <div class="modal-body">
                                        <textarea name="expertise_question" required>{{$question->question}}</textarea>
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
                        <form action="{{url('/')}}/addexpertise_question" method="post">
                            {{csrf_field()}}
                            <div class="modal-body">
                                <input type="text" value="" name="question" required>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default">Submit</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            </tbody>
        </table>


    </div>
    </div>
</section>
<?php include resource_path('views/admin/includes/footer.php'); ?>



