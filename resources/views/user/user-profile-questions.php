<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); ?>
    <body>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <div class="new_container">
                        <ul class="bread-crumbs list-none">
                            <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                            <!--<li><a href="<?php // echo asset('questions');           ?>">Q&amp;A</a></li>-->
                            <li>Profile</li>
                        </ul>
                        <div class="profile-area">

                            <?php include 'includes/user-profile-header.php'; ?>
                            <div class="listing-area ">
                                <div class="tog-rev blu">
                                    <img src="<?php echo asset('userassets/images/question-icon-png.png') ?>" alt="Icon"> My Q’s
                                </div>
                                
                                    <ul class="journals list-none quest tog-sec" id="questions_listing">  
                                        <?php if (count($questions) > 0) { ?>
                                        <?php foreach ($questions as $key => $values) { ?>
                                            <?php foreach ($values as $question) { ?>
                                                <li>
                                                    <input type="hidden" class="month_year" value="<?= $question->month_year ?>">
                                                    <div class="q-txt">
                                                        <div class="q-text-a">
                                                            <a href="<?php echo asset('get-question-answers/' . $question->id); ?>">
                                                                <span><img src="<?php echo asset('userassets/images/act-q.png') ?>" alt="User Image" class="small-q"></span>
                                                                <div class="my_answer">You asked a question.
                                                                    <span class="hows-time"><?php echo timeago($question->created_at); ?></span>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="head-ques">
                                                            <div class="my_qs">
                                                                <span class="add">Q:</span>
                                                                <div class="my_qs_txt">
                                                                    <?php echo $question->question; ?>
                                                                    <span class="descrip"><?php echo $question->description; ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="how-time">
                                                            <!--<span><?php // echo timeago($question->created_at);        ?></span>-->
                                                            <?php if ($question->getAnswers->count() == 0) { ?>
                                                                                            <!--<a href="<?php echo asset('update-question/' . $question->id); ?>" ><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>-->
                                                            <?php } ?>
                                                            <!--<a href="#" data-toggle="modal" data-target="#delete_question<?php echo $question->id; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a>-->
                                                            <a href="<?php echo asset('get-question-answers/' . $question->id); ?>" class="answer-link">
                                                                <span><i class="fa fa-exchange"></i> <?php echo $question->getAnswers->count(); ?></span>ANSWERS
                                                            </a>
                                                        </span>
                                                    </div>
                                                </li>

                                                                                                <!--<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#delete_question<?php echo $question->id; ?>">Open Modal</button>-->

                                                <!-- Modal -->
                                                <div class="modal fade" id="delete_question<?php echo $question->id; ?>" role="dialog">
                                                    <div class="modal-dialog">
                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title">Delete Question </h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure to delete this question <?php echo $question->question; ?></p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a href="<?php echo asset('delete-question/' . $question->id); ?>" type="button" class="btn-heal">yes</a>
                                                                <button data-dismiss="modal" type="button" class="btn-heal">No</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <!-- Modal End-->
                                                <?php
                                            }
                                        }
                                        
                                    } else {
                                        ?>
                                        <li class="hb_not_more_posts_lbl">No record found.</li>
                                    <?php } ?>
                                    </ul>
                                    <div class="tog-rev blu">
                                        <img src="<?php echo asset('userassets/images/answer-icon.svg') ?>" alt="Icon"> My A’s
                                    </div>
                                   
                                        <ul class="journals list-none quest tog-sec" id="answers_listing">  
                                             <?php if (count($answers) > 0) { ?>
                                            <?php foreach ($answers as $key => $values) { ?>
                                                <?php foreach ($values as $answer) { ?>
                                                    <li>
                                                        <input type="hidden" class="month_year" value="<?= $answer->month_year ?>">
                                                        <div class="q-txt">
                                                            <div class="q-text-a">
                                                                <a href="<?php echo asset('get-question-answers/' . $answer->question_id); ?>">
                                                                    <span><img src="<?php echo asset('userassets/images/act-a.png') ?>" alt="Icon" class="small-q"></span>
                                                                    <div class="my_answer">
                                                                        You answered a question
                                                                        <span class="hows-time"><?php echo timeago($answer->created_at); ?></span>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                            <div class="head-ques">
                                                                <!--<a href="<?php // echo asset('get-question-answers/'.$answer->question_id);        ?>" class="head-ques">-->
                                                                <div class="head-ques-a">
                                                                    <span class="add">Q:</span><?php echo $answer->getAnswerQuestion->question; ?>
                                                                    <span class="descrip" style="color: #696969"><?php echo $answer->answer; ?></span>
                                                                </div>
                                                            </div>

                                                                                                                            <!--<span class="how-time"><span><?php // echo timeago($answer->created_at);       ?></span>-->
                                                            <span class="how-time">
                                                                <?php if (count($answer->AnswerLike) <= 0 && count($answer->Flag) <= 0) { ?>
                                                <!--                                                <a href="<?php echo asset('edit-answer/' . $answer->id) ?>">
                                                                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                                                                    Edit
                                                                                                </a>-->
                                                                <?php } ?>
                    <!--                                            <a href="#" data-toggle="modal" data-target="#delete_answer<?php echo $answer->id; ?>">
                                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                                    Delete
                                                                </a>-->
                                                                <a href="<?php echo asset('get-question-answers/' . $answer->question_id); ?>" class="answer-link">
                                                                    <span><i class="fa fa-eye"></i></span>View Answer
                                                                </a>
                                                            </span>
                                                        </div>

                                                    </li>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="delete_answer<?php echo $answer->id; ?>" role="dialog">
                                                        <div class="modal-dialog">
                                                            <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    <h4 class="modal-title">Delete Answer </h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Are you sure to delete this Answer: <?php echo $answer->answer; ?></p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <a href="<?php echo asset('delete-answer/' . $answer->id); ?>" type="button" class="btn-heal">yes</a>
                                                                    <button data-dismiss="modal" type="button" class="btn-heal">No</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Modal End-->
                                                    <?php
                                                }
                                            }
                                            
                                        } else {
                                            ?>
                                           <li class="hb_not_more_posts_lbl">No record found.</li>
                                        <?php } ?>
                                        </ul>
                                        <div style="display: none" class="hb_simple_loader" id="loading"><img src="<?php echo asset('userassets/images/new_loadeer.svg') ?>" alt="Loading . . . ." class="post-loader"><span></span></div>
                                        </div>
                                        </div>
                                    </div>  <div class="right_sidebars">
                                    <?php if($current_user){ include 'includes/rightsidebar.php'; ?>
                                    <?php include 'includes/chat-rightsidebar.php';} ?>
                                </div>
                                </div>
                                </article>
                                </div>
                                <?php  include('includes/footer.php'); ?>
                                <?php include('includes/functions.php');  ?>
                                </body>
                                <script>
                                    $(document).ready(function () {
                                        $('.tog-rev').click(function () {
                                            $(this).next('.tog-sec').slideToggle();
                                        });
                                    });
                                    var win = $(window);
                                    var count = 1;
                                    var ajaxcall = 1;
                                    //        var sorting = '<?php //echo $sorting        ?>';
                                    //        var q = '<?php //echo $q        ?>';
//                                    win.on('scroll', function () {
//                                        var docheight = parseInt($(document).height());
//                                        var winheight = parseInt(win.height());
//                                        var differnce = (docheight - winheight) - win.scrollTop();
//                                        if (differnce < 100) {
//                                            if (ajaxcall === 1) {
//                                                $('#loading').show();
//                                                var last_month = $('.month_year').last().val();
//                                                ajaxcall = 0;
//                                                $.ajax({
//                                                    url: "<?php // echo asset('user-profile-questions-loader/'.$user->id) ?>",
//                                                    type: "GET",
//                                                    data: {
//                                                        "count": count,
//                                                        "last_month": last_month
//                                                                //                            "sorting":sorting,
//                                                                //                            "q":q
//                                                    },
//                                                    success: function (data) {
//                                                        if (data) {
//                                                            var a = parseInt(1);
//                                                            var b = parseInt(count);
//                                                            count = b + a;
//                                                            $('#strains_listing').append(data);
//                                                            $('#loading').hide();
//                                                            ajaxcall = 1;
//                                                        } else {
//                                                            $('#loading').hide();
//                                                            noposts = ' <div class="loader hb_not_more_posts_lbl" id="nomoreposts">No More Strains To Show</div> ';
//                                                            $('#strains_listing').append(noposts);
//                                                        }
//                                                    }
//                                                });
//                                            }
//
//
//                                        }
//                                    });
                                </script>
                                </html>