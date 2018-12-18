<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); ?>
    <body class="questions-page">
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <div class="new_container">
                        <ul class="bread-crumbs list-none">
                            <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                            <li><a href="<?php echo asset('questions'); ?>">Q&amp;A</a></li>
                            <li>My Questions</li>
                        </ul>
                        <div class="clearfix pd-top hb_heading_bordered">
                            <h2 class="hb_page_top_title hb_text_blue hb_text_uppercase no-margin">My Questions</h2>
                        </div>
                        <header class="intro-header no-bg">
                            <h1 class="custom-heading white text-center">
                                <img src="userassets/images/side-icon12.svg" alt="Icon" class="no-margin">
                                <span class="top-padding">MY QUESTIONS</span>
                            </h1>
                        </header>
                        <?php if (Session::has('success')) { ?> 
                            <h5 class="alert alert-success"> <?php echo Session::get('success'); ?> </h5>
                        <?php } ?>
                        <!--                        <div class="date-main-act">
                                                    <i class="fa fa-calendar"></i>
                                                    <span>February 2018</span>
                                                </div>-->
                        <div class="listing-area ">
                            <ul class="journals list-none quest" id="questions_listing">
                                <?php if (count($questions) > 0) { ?>
                                    <?php foreach ($questions as $key => $values) { ?>
                                        <div class="date-main-act">
                                            <i class="fa fa-calendar"></i>
                                            <span><?= $key ?></span>
                                        </div>
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
                                                        <div class="">
                                                            <!--<div class="my_qs_txt">-->
                                                            <div class="">
                                                                <i class="fa fa-external-link"></i>
                                                                <span class="add">Q:</span>
                                                                <?php echo $question->question; ?>
                                                                <span class="descrip"><?php echo $question->description; ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <span class="how-time">
                                                        <!--<span><?php // echo timeago($question->created_at);  ?></span>-->
                                                        <?php if ($question->getAnswers->count() == 0) { ?>
                                                            <a href="<?php echo asset('update-question/' . $question->id); ?>" ><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                                                        <?php } ?>
                                                        <a href="#" data-toggle="modal" data-target="#delete_question<?php echo $question->id; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a>
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
                                        <?php }
                                    }
                                } else {
                                    ?>
                                    <div class="loader hb_not_more_posts_lbl" id="no_more_question">No more questions to show</div>
<?php } ?>
                            </ul>
                            <div style="display: none" class="hb_simple_loader" id="loading"><img src="<?php echo asset('userassets/images/new_loadeer.svg') ?>" alt="Loading . . . ." class="post-loader"><span></span></div>

                        </div>
                    </div>
                    <div class="right_sidebars">
<?php include 'includes/rightsidebar.php'; ?>
<?php include 'includes/chat-rightsidebar.php'; ?>
                    </div>
                </div>
            </article>
        </div>
<?php include('includes/footer-new.php'); ?>

    </body>
    <script>
        var win = $(window);
        var count = 1;
        var ajaxcall = 1;
//        var sorting = '<?php //echo $sorting   ?>';
//        var q = '<?php //echo $q   ?>';
        win.on('scroll', function () {
            var docheight = parseInt($(document).height());
            var winheight = parseInt(win.height());
            var differnce = (docheight - winheight) - win.scrollTop();
            if (differnce < 100) {
                if (ajaxcall === 1) {
                    $('#loading').show();
                    var last_month = $('.month_year').last().val();
                    ajaxcall = 0;
                    $.ajax({
                        url: "<?php echo asset('get-my-question-loader') ?>",
                        type: "GET",
                        data: {
                            "count": count,
                            "last_month": last_month
//                            "sorting":sorting,
//                            "q":q
                        },
                        beforeSend: function () {
                            $('#loading').show();
                        },
                        success: function (data) {
                            if (data) {
                                var a = parseInt(1);
                                var b = parseInt(count);
                                count = b + a;
                                $('#questions_listing').append(data);
                                $('#loading').hide();
                                ajaxcall = 1;
                            } else {
                                $('#no_more_question').hide();
                                $('#loading').hide();
                                noposts = ' <div class="loader hb_not_more_posts_lbl" id="nomoreposts">No more questions to show</div> ';
                                $('#questions_listing').append(noposts);
                            }
                        }
                    });
                }
//                setTimeout(function(){$('#post_loader').hide();},1000);
//                
            }
        });
    </script>
</html>