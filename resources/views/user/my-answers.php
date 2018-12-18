<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); ?>
    <body class="answers-page">
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <div class="new_container">
                        <ul class="bread-crumbs list-none">
                            <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                            <li><a href="<?php echo asset('questions'); ?>">Q&amp;A</a></li>
                            <li>My Answers</li>
                        </ul>
                        <div class="clearfix pd-top hb_heading_bordered">
                            <h2 class="hb_page_top_title hb_text_blue hb_text_uppercase no-margin">My Answers</h2>
                        </div>
                        <header class="intro-header no-bg">
                            <h1 class="custom-heading white text-center">
                                <img src="userassets/images/answer-icon.svg" alt="Icon" class="no-margin">
                                <span class="top-padding">MY ANSWERS</span>
                            </h1>
                        </header>
<!--                        <div class="date-main-act">
                            <i class="fa fa-calendar"></i>
                            <span>February 2018</span>
                        </div>-->
                        <div class="listing-area">
                            <ul class="journals list-none quest" id="answers_listing">
                                <?php if(count($answers) > 0) {?>
                                <?php foreach($answers as $key => $values){ ?>
                                    <div class="date-main-act">
                                        <i class="fa fa-calendar"></i>
                                        <span><?= $key ?></span>
                                    </div>
                                <?php foreach ($values as $answer) { ?>
                                <li>
                                    <input type="hidden" class="month_year" value="<?= $answer->month_year ?>">
                                    <div class="q-txt">
                                        <div class="q-text-a">
                                            <a href="<?php echo asset('get-question-answers/'.$answer->question_id); ?>">
                                                <span><img src="<?php echo asset('userassets/images/act-a.png') ?>" alt="Icon" class="small-q"></span>
                                                <div class="my_answer">
                                                    You answered on a question
                                                    <span class="hows-time"><?php echo timeago($answer->created_at); ?></span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="head-ques">
                                            <!--<a href="<?php // echo asset('get-question-answers/'.$answer->question_id); ?>" class="head-ques">-->
                                            <!--<div class="head-ques-a">-->
                                            <div class="">
                                                <i class="fa fa-external-link"></i>
                                                <span class="add">Q:</span><?php echo $answer->getAnswerQuestion->question; ?>
                                                <div class="icons-a-blues">
                                                    <span>A:</span>
                                                    <?php echo $answer->answer; ?>
                                                </div>
                                                <?php if(count($answer->attachments) > 0){ ?>
                                                <div class="att-link-blue">
                                                    <i class="fa fa-link"></i> Attachment
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>


                                        <!--<span class="how-time"><span><?php // echo timeago($answer->created_at); ?></span>-->
                                        <span class="how-time">
                                            <?php // if(count($answer->Flag) <= 0){ ?>
                                                <a href="<?php echo asset('edit-answer/'.$answer->id)?>">
                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                    Edit
                                                </a>
                                            <?php // } ?>
                                            <a href="#" data-toggle="modal" data-target="#delete_answer<?php echo $answer->id;?>">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                Delete
                                            </a>
                                            <a href="<?php echo asset('get-question-answers/'.$answer->question_id); ?>" class="answer-link">
                                                <span><i class="fa fa-eye"></i></span>View Answer
                                            </a>
                                        </span>
                                    </div>

                                </li>
                                <!-- Modal -->
                                <div class="modal fade" id="delete_answer<?php echo $answer->id;?>" role="dialog">
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
                                                <a href="<?php echo asset('delete-answer/'.$answer->id); ?>" type="button" class="btn-heal">yes</a>
                                                <button data-dismiss="modal" type="button" class="btn-heal">No</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal End-->
                                <?php } } } else { ?>
                                <div class="loader hb_not_more_posts_lbl" id="no_more_answer">No more answers to show</div>
                                <?php } ?>
                            </ul>

                            <div style="display: none" class="hb_simple_loader" id="loading"><img src="<?php echo asset('userassets/images/new_loadeer.svg') ?>" alt="Loading . . . ." class="post-loader"><span></span></div>
                        </div>
                    </div>
                    <div class="right_sidebars">
                        <?php include 'includes/rightsidebar.php'; ?>
                        <?php include 'includes/chat-rightsidebar.php';?>
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
//        var sorting = '<?php //echo $sorting ?>';
//        var q = '<?php //echo $q ?>';
        win.on('scroll', function() {
            var docheight = parseInt($(document).height());
            var winheight = parseInt(win.height());
            var differnce = (docheight - winheight) - win.scrollTop();
            if (differnce < 100) {
                if (ajaxcall === 1) {
                    $('#loading').show();
                    var last_month = $('.month_year').last().val();
                    ajaxcall = 0;
                    $.ajax({
                        url: "<?php echo asset('get-my-answers-loader') ?>",
                        type: "GET",
                        data: {
                            "count": count,
                            "last_month": last_month
//                            "sorting":sorting,
//                            "q":q
                        },
                        beforeSend: function(){
                            $('#loading').show();
                        },     
                        success: function(data) {
                            if (data) {
                                var a = parseInt(1);
                                var b = parseInt(count);
                                count = b + a;
                                $('#answers_listing').append(data);
                                $('#loading').hide();
                                ajaxcall = 1;
                            } else {
                                $('#no_more_answer').hide();
                                $('#loading').hide();
                                noposts=' <div class="loader hb_not_more_posts_lbl" id="nomoreposts">No more answers to show</div> ';
                                $('#answers_listing').append(noposts);
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