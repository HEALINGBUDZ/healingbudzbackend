<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top.php'); ?>
    <body>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <ul class="bread-crumbs list-none">
                        <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                        <li><a href="<?php echo asset('/questions'); ?>">Q&amp;A</a></li>
                        <li>Questions</li>
                    </ul>
                    <?php
                    if (isset($_GET['sorting'])) {
                        $sorting = $_GET['sorting'];
                    } else {
                        $sorting = '';
                    }
                    if (isset($_GET['q'])) {
                        $q = $_GET['q'];
                    } else {
                        $q = '';
                    }
                    ?>
                    <header class="intro-header no-bg">
                        <h1 class="custom-heading white text-center">
                            <img src="userassets/images/side-icon12.svg" alt="Icon" class="no-margin">
                            <span class="top-padding">Q&A</span>
                        </h1>
                    </header>
                    <div class="new_container">
                        <?php if (Auth::user()) { ?>
                            <div class="ask-area">
                                <?php if (Session::has('success')) { ?>
                                    <h5 class="alert alert-success"><?php echo Session::get('success'); ?></h5>
                                <?php } ?>
                                <form  action="<?php echo asset('ask-question'); ?>" method="post" id="question">
                                    <fieldset>
                                        <h2>Ask a Question </h2>

                                        <div class="row">
                                            <div class="img-holder pre-main-image hb_round_img" style="background-image: url(<?php echo $current_photo ?>)">
                                                <?php if ($current_special_image) { ?>
                                                    <span class="fest-pre-img" style="background-image: url(<?php echo asset('public/images' . $current_special_image) ?>);"></span>
                                                <?php } ?>
                                            </div>
                                            <div class="input_holder arrow">
                                                <input autocomplete="off" id="question_input" type="text" required placeholder="Type your question here..." name="question" onkeyup="questionCountCharToMax(this, 150)" maxlength="150" value="<?php echo old('question'); ?>">
                                                <em id="questionCharNum">0/150 characters</em>

                                            </div>



                                        </div>
                                        <span class="error_span" id="question_error"><?php
                                            if ($errors->has('question')) {
                                                echo $errors->first('question');
                                            }
                                            ?></span>
                                        <div class="row">
                                            <!--<div class="img-holder"></div>-->
                                            <div class="input_holder height_auto">
                                                <textarea id="question_description" required placeholder="Add more details to your question..." name="description" onkeyup="descriptionCountCharToMax(this, 300)" maxlength="300"><?php echo old('description'); ?></textarea>
                                                <em class="abs" id="descriptionCharNum">0/300 characters</em>
                                            </div>
                                            <div class="fields ask_qs">
                                                <div class="align-left">
                                                    <input  max="3" class="custom-file" id="file" type="file" name="file[]" multiple accept="video/*,  video/x-m4v, video/webm, video/x-ms-wmv, video/x-msvideo, video/3gpp, video/flv, video/x-flv, video/mp4, video/quicktime, video/mpeg, video/ogv, .ts, .mkv, image/*">
                                                    <label for="file" class="file-label" >Attachments <span>Max 3</span></label>
                                                </div>
                                                <ul id="imagePreview" class="uploaded-files list-none">
                                                </ul>
                                                <video style="display: none" class="video-use" class="video" src="" id="video_answer"></video >
                                                <div id="floading_qs_attach" style="display: none;" style="margin: 0px auto;">
                                                    <img src="<?php echo asset('userassets/images/new_loadeer.svg') ?>" alt="Loader" style="width: 40px;">
                                                </div>
                                            </div>
                                            <span class="error_span" id="description_error"><?php
                                                if ($errors->has('description')) {
                                                    echo $errors->first('description');
                                                }
                                                ?></span>
                                            <input type="hidden" id="attachments" name="attachments">
                                            <div class="row">
                                                <input id="submit_button" type="submit" value="Post Question" onclick="disableButton()">
                                            </div>
                                    </fieldset>
                                </form>
                            </div>
                        <?php } ?>
                        <div class="search-area updated">
                            <!-- <a href="<?php //echo asset('ask-questions');                       ?>" class="btn-ask">Ask Q</a> -->
                            <div class="sort-dropdown new_dropdown">
                                <div class="form-holder">
                                    <a href="#" class="new_toggler"><i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                    <form class="q_ans_sort" action="<?php echo asset('question-sorting'); ?>" id="q_sorting">
                                        <fieldset>
                                            <select name="sorting" id="sorting_value">
                                                <?php
                                                $selected_sorting = 'Newest';
                                                if (isset($_GET['sorting'])) {
                                                    $selected_sorting = $_GET['sorting'];
                                                    ?>
                                                    <option value="<?php echo $_GET['sorting']; ?>" selected=""><?php echo $_GET['sorting']; ?> </option>
                                                <?php } else { ?>
                                                    <option value="" selected="">Newest</option>
                                                <?php } ?>
                                            </select>
                                        </fieldset>
                                    </form>
                                    <a href="#" class="options-toggler opener">
                                        <i class="fa fa-caret-down" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <div class="options">
                                    <ul class="list-none">
                                        <li>
                                            <!--<img src="<?php // echo asset('userassets/images/heart-icon.svg')                      ?>" alt="Favorites">-->
                                            <?php
                                            if ($selected_sorting == 'Favorites') {
                                                ?>
                                                <a href="<?= asset('questions') ?>"><i class="fa fa-check" aria-hidden="true"></i></a>
                                            <?php } ?>
                                            <span>Favorites</span>
                                        </li>
                                        <li>
                                            <!--<img src="<?php // echo asset('userassets/images/new-icon.svg')                      ?>" alt="Newest">-->
                                            <?php
                                            if ($selected_sorting == 'Newest') {
                                                ?>
                                                <a href="<?= asset('questions') ?>"><i class="fa fa-check" aria-hidden="true"></i></a>
                                            <?php } ?>
                                            <span>Newest</span>
                                        </li>
                                        <li>
                                            <!--<img src="<?php // echo asset('userassets/images/question-icon2.svg')                      ?>" alt="Unanswered">-->
                                            <?php
                                            if ($selected_sorting == 'Unanswered') {
                                                ?>
                                                <a href="<?= asset('questions') ?>"><i class="fa fa-check" aria-hidden="true"></i></a>
                                            <?php } ?>
                                            <span>Unanswered</span>
                                        </li>
                                        <li>
                                            <!--<img src="<?php // echo asset('userassets/images/question-icon.svg')                      ?>" alt="Unanswered">-->
                                            <?php
                                            if ($selected_sorting == 'My Questions') {
                                                ?>
                                                <a href="<?= asset('questions') ?>"><i class="fa fa-check" aria-hidden="true"></i></a>
                                            <?php } ?>
                                            <span>My Questions</span>
                                        </li>
                                        <li>
                                            <!--<img src="<?php // echo asset('userassets/images/answer-icon.svg')                      ?>" alt="My Answers">-->
                                            <?php
                                            if ($selected_sorting == 'My Answers') {
                                                ?>
                                                <a href="<?= asset('questions') ?>"><i class="fa fa-check" aria-hidden="true"></i></a>
                                            <?php } ?>
                                            <span>My Answers</span>
                                        </li>
                                        <li>
                                            <!--<img src="<?php // echo asset('userassets/images/answer-icon.svg')                      ?>" alt="My Answers">-->
                                            <?php
                                            if ($selected_sorting == 'Trending') {
                                                ?>
                                                <a href="<?= asset('questions') ?>"><i class="fa fa-check" aria-hidden="true"></i></a>
                                            <?php } ?>
                                            <span>Trending</span>
                                        </li>
                                    </ul>
                                    <a href="#" class="options-toggler closer"><i class="fa fa-caret-up" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                        <ul class="questions-list add list-none" id="questions_listing">
                            <?php
                            if (isset($questions[0])) {
                                foreach ($questions as $question) {
                                    ?>
                                    <!-- Report Question Popup -->
                                    <div id="question-flag<?= $question->id ?>" class="popup">

                                        <div class="popup-holder">
                                            <div class="popup-area">
                                                <form  action="<?php echo asset('add-question-flag'); ?>" class="reporting-form" method="post">
                                                    <input type="hidden" value="<?php echo $question->id; ?>" name="question_id">
                                                    <input type="hidden" value="<?php echo csrf_token(); ?>" name="_token">
                                                    <fieldset>
                                                        <h2>Reason For Reporting</h2>

                                                        <input type="radio" name="group" id="sexual<?= $question->id ?>" checked value="Nudity or sexual content">
                                                        <label for="sexual<?= $question->id ?>">Nudity or sexual content</label>

                                                        <input type="radio" name="group" id="harasssment<?= $question->id ?>"  value="Harassment or hate speech">
                                                        <label for="harasssment<?= $question->id ?>">Harassment or hate speech</label>

                                                        <input type="radio" name="group" id="threatening<?= $question->id ?>"  value="Threatening, violent, or concerning">
                                                        <label for="threatening<?= $question->id ?>">Threatening, violent, or concerning</label>

                                                        <input type="radio" name="group" id="abused<?= $question->id ?>"  value="offensive">
                                                        <label for="abused<?= $question->id ?>">Question is offensive</label>
                                                        <input type="radio" name="group" id="spam<?= $question->id ?>" value="Spam">
                                                        <label for="spam<?= $question->id ?>">Spam</label>
                                                        <input type="radio" name="group" id="unrelated<?= $question->id ?>" value="Unrelated">
                                                        <label for="unrelated<?= $question->id ?>">Unrelated</label>
                                                        <input type="submit" value="Report Question">
                                                        <a href="#" class="btn-close">x</a>
                                                    </fieldset>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Report Question Popup End -->
                                    <!-- Share Question Popup -->
                                    <div id="share-question-<?= $question->id; ?>" class="popup">
                                        <div class="popup-holder">
                                            <div class="popup-area">
                                                <div class="reporting-form">
                                                    <h2>Select an option</h2>
                                                    <div class="custom-shares">
                                                        <?php
                                                        echo Share::page(asset('get-question-answers/' . $question->id), $question->question, ['class' => 'questions_class', 'id' => $question->id])
                                                                ->facebook($question->question)
                                                                ->twitter($question->question)
                                                                ->googlePlus($question->question);
                                                        ?>
                                                        <!---->
                                                        <?php if (Auth::user()) { ?>
                                                            <div class="questions_class" onclick="shareInapp('<?= asset('get-question-answers/' . $question->id) ?>', '<?php echo trim(revertTagSpace($question->question)); ?>', '<?= asset('userassets/images/qascraper.png') ?>')"> <span class="hb_icon_repost"></span> In App</div>
                                                        <?php } ?> </div>
                                                    <a href="javascript:void(0)" class="btn-close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Share Question Popup End -->
                                    <li class="qa-adjs-new">
                                        <div class="text">
                                            <span class="dot-options">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                <div class="sort-drop">
                                                    <?php if ($current_id == $question->user_id && $question->get_answers_count == 0) { ?>
                                                        <div class="sort-item active">
                                                            <a href="<?php echo asset('update-question/' . $question->id) ?>"><i class="fa fa-pencil" aria-hidden="true"></i> <span>Edit Question</span></a>
                                                        </div>
                                                        <?php
                                                    } if ($current_id != $question->user_id) {
                                                        if (Auth::user()) {
                                                            ?>
                                                            <div class="sort-item">
                                                                <a href="#question-flag<?= $question->id ?>" class="flag-icon report btn-popup" id="addFlag<?php echo $question->id; ?>" <?php if ($question->is_flaged_count) { ?> style="display: none"<?php } ?>  class="flag-icon"><i class="fa fa-flag" aria-hidden="true"></i> <span class="new_span">Report</span></a>
                                                                <a id="removeFlag<?php echo $question->id; ?>" <?php if (!$question->is_flaged_count) { ?> style="display: none"<?php } ?> href="javascript:void(0)" class="flag-icon active"><i class="fa fa-flag" aria-hidden="true" style="color:#1383c6"></i> <span class="new_span" style="color:#1383c6">Reported</span></a>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                    ?>                              
                                                    <div class="sort-item">
                                                        <a href="#share-question-<?= $question->id; ?>" class="flag-icon btn-popup"><i class="fa fa-share-alt" aria-hidden="true"></i> <span>Share</span></a>
                                                    </div>
                                                </div>
                                            </span>
                                            <header class="header">
                                                <?php if ($question->get_answers_count > 19) { ?>
                                                    <span class="trending_badge"></span>          
                                                <?php } ?>
                                                <div class="pre-main-image hb_round_img" style="background-image: url(<?php echo getImage($question->getUser->image_path, $question->getUser->avatar); ?>)">
                                                    <?php if ($question->getUser->special_icon) { ?>
                                                        <span class="fest-pre-img" style="background-image: url(<?php echo asset('public/images' . $question->getUser->special_icon) ?>);"></span>
                                                    <?php } ?>
                                                </div>
                                                <div class="txt">
                                                    <strong>
                                                        <a class="<?= getRatingClass($question->getUser->points) ?>" href="<?php echo asset('user-profile-detail/' . $question->getUser->id) ?>"><?= $question->getUser->first_name; ?></a>
                                                        <span>asks...</span>
                                                        <!-- <span><?php //echo timeago($question->created_at);                       ?></span> -->
                                                    </strong>                                    
                                                </div>                                
                                            </header>
                                            <div class="txt-holder">
                                                <div class="question">
                                                    <div class="icon"><img src="<?php echo asset('userassets/images/question-icon.svg') ?>" alt="Q"></div>
                                                    <div class="q_desc">
                                                        <p class="main_q"><?= $question->question; ?></p>
                                                        <p class="q_details"><?= $question->description; ?></p>
                                                    </div>
                                                    <?php if($question->Attachments->count() > 0){ ?>
                                                    <footer class="footer fo-att qs_uploaded_images">

                                                        <div class="uploaded-files list-none">
                                                            <?php foreach ($question->Attachments as $attachment){ ?>
                                                             <?php if ($attachment->media_type == 'image') { ?>
                                                                                        <!--Test Start-->
                                                              <?php $q_slide_image = image_fix_orientation('public/images' . $attachment->upload_path) ?>
                                                            <li>
                                                                <!--Test Start-->
                                                                <a href="<?php echo asset($q_slide_image) ?>" class="" data-fancybox="<?= $attachment->question_id ?>">
                                                                    <div class="ans-slide-image" style="background-image: url(<?php echo asset($q_slide_image) ?>)"></div>
                                                                </a>
                                                                <!--Test End-->
                                                            </li>
                                                             <?php }if ($attachment->media_type == 'video') {
                                                                 $q_slide_post = 'public/images' . $attachment->poster;
                                                                         ?>
                                                            <li>
                                                                <a href="#videos-<?= $attachment->id ?>" data-fancybox="<?= $attachment->question_id ?>">
                                                                    <div class="ans-slide-image" style="background-image: url(<?php echo asset($q_slide_post) ?>)"><i class="fa fa-play-circle" aria-hidden="true"></i></div>
                                                                </a>
                                                                <video height="100" width="100" poster="$q_slide_post" id="videos-<?= $attachment->id ?>" controls="" style="display: none;">
                                                                    <source src="<?php echo asset('public/videos' . $attachment->upload_path) ?>" type="video/mp4">
                                                                    Your browser does not support the video tag.
                                                                </video>

                                                            </li>
                                                             <?php }} ?>

                                                        </div>
                                                    </footer>
                                                    <?php } ?>
                                                </div>

                                                <footer class="footer">

                                                    <div class="align-right">
                                                        <?php
                                                        if (Auth::user()) {
                                                            if ($question->is_answered_count) {
                                                                ?>
                                                                <span class="hb_no_answer yes"></span>
                                                            <?php } else { ?>
                                                                <span class="hb_no_answer"></span>
                                                            <?php }
                                                            ?>


                                                            <a class="like_heart" <?php if ($question->get_user_likes_count) { ?> style="display: none"<?php } if (checkMySaveSetting('save_question')) { ?> href="javascript:void(0)" <?php } else { ?> href="#saved-discuss" <?php } ?> class="btn-popup heart" onclick="addQuestionMySave('<?php echo $question->id; ?>', 'addqfav<?php echo $question->id; ?>', 'remqfav<?php echo $question->id; ?>')" id="addqfav<?php echo $question->id; ?>"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                                            <a class="like_heart" <?php if (!$question->get_user_likes_count) { ?> style="display: none"<?php } ?> href="javascript:void(0)" class="btn-popup fav-icon active" onclick="removeQuestionMySave('<?php echo $question->id; ?>', 'remqfav<?php echo $question->id; ?>', 'addqfav<?php echo $question->id; ?>')" id="remqfav<?php echo $question->id; ?>"><i style="color:#ff2525;" class="fa fa-heart" aria-hidden="true"></i></a>
                                                        <?php } else { ?>
                                                            <a href="#loginModal" class="new_popup_opener  be-btn like_heart btn-popup heart"  id=""><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                                        <?php } ?>
                                                        <span id="fav_count_<?= $question->id ?>"><?= $question->getUserLikes->count(); ?></span>
                                                    </div> 
                                                    <?php if ($question->get_answers_count > 0) { ?>
                                                        <div class="align-left">
                                                            <a style="margin-top: 0;" href="<?php echo asset('get-question-answers/' . $question->id); ?>" class="btn-primary blank">Discuss</a>
                                                            <div class="a_counts">
                                                                <?= $question->get_answers_count; ?>
                                                                <a href="<?php echo asset('get-question-answers/' . $question->id); ?>">Answers</a>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if ($question->get_answers_count == 0) { ?>
                                                        <?php
                                                        if (Auth::user()) {
                                                            if ($question->user_id != $current_id) {
                                                                ?>

                                                                <a href="<?php echo asset('give-answer/' . $question->id); ?>" class="btn-primary be-btn">Be the 1<sup>st</sup> Bud to answer</a>

                                                                <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <a href="#loginModal" class="ho-blue new_popup_opener btn-primary be-btn">Be the 1<sup>st</sup> Bud to answer</a>                                           
                                                        <?php } ?>
                                                    </footer>
                                                <?php } ?>
                                            </div>
                                        </div>

                                    </li>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="loader hb_not_more_posts_lbl" id="no_more_question">No Questions Found</div>
                            <?php } ?>

                        </ul>
                        <div style="display: none" class="hb_simple_loader" id="loading"><img src="<?php echo asset('userassets/images/new_loadeer.svg') ?>" alt="Loading . . . ." class="post-loader"><span></span></div>
                    </div>
                    <div class="right_sidebars">
                        <?php
                        if (Auth::user()) {
                            include 'includes/rightsidebar.php';
                            ?>
                            <?php
                            include 'includes/chat-rightsidebar.php';
                        }
                        ?>
                    </div>
                </div>
            </article>
        </div>
        <div id="keyword-list" class="popup">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="text">
                        <header class="header">
                            
                            <strong>Saved Discussion</strong>
                        </header>
                        <ul class="list-none keywords-list">
                            <li><a href="#">Questions</a></li>
                            <li><a href="#">Answers</a></li>
                            <li><a href="#">Groups</a></li>
                            <li><a href="#">Journals</a></li>
                            <li><a href="#">Strains</a></li>
                            <li><a href="#">Budz Adz</a></li>
                        </ul>
                        <a href="#" class="btn-follow btn-primary">Follow this keyword</a>
                        <a href="#" class="btn-close">Close</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="saved-discuss" class="popup light-brown">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="text">
                        <header class="header no-padding add">
                            <strong>Saved Discussion</strong>
                        </header>
                        <div class="padding">
                            <p><img src="<?php echo asset('userassets/images/bg-success.svg') ?>" alt="Icon">Q's &amp; A's are saved in the app menu under My Saves</p>
                            <div class="check">
                                <input type="checkbox" id="check" onchange="addSaveSetting('save_question', this)">
                                <label for="check">Got it! Do not show again for Q's &amp; A's | Save</label>
                            </div>
                        </div>
                        <a href="#" class="btn-close purple">Close</a>
                    </div>
                </div>
            </div>
        </div>








        <?php include('includes/footer.php'); ?>
        <?php include 'includes/functions.php'; ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>
        <script>
                                    function questionCountCharToMax(val, len) {
                                        var max = len;
                                        var min = 0;
                                        var len = val.value.length;
                                        if (len >= max) {
                                            val.value = val.value.substring(min, max);
                                            len = val.value.length;
                                            $('#questionCharNum').text(len + '/' + max + ' characters');
                                        } else {
                                            $('#questionCharNum').text(len + '/' + max + ' characters');
                                        }
                                    }

                                    function descriptionCountCharToMax(val, len) {
                                        var max = len;
                                        var min = 0;
                                        var len = val.value.length;
                                        if (len >= max) {
                                            len = val.value.length;
                                            val.value = val.value.substring(min, max);
                                            $('#descriptionCharNum').text(len + '/' + max + ' characters');
                                        } else {
                                            $('#descriptionCharNum').text(len + '/' + max + ' characters');
                                        }
                                    }

                                    //                                    $('.questions_class').on('click',function () {
                                    $('body').on('click', '.questions_class', function (e) {
                                        $(this).parents('.custom-shares.new-shares').hide();
                                        $('.popup').hide();
                                        id = this.id;
                                        $('#share-question-' + id).fadeOut();
                                        $.ajax({
                                            url: "<?php echo asset('add_question_share_points') ?>",
                                            type: "GET",
                                            data: {
                                                "id": id, "type": "Question"
                                            },
                                            success: function (data) {
                                            }
                                        });
                                    });
                                    var win = $(window);
                                    var count = 1;
                                    var ajaxcall = 1;
                                    var sorting = '<?= $sorting ?>';
                                    var q = '<?= $q ?>';
                                    win.on('scroll', function () {
                                        var docheight = parseInt($(document).height());
                                        var winheight = parseInt(win.height());
                                        var differnce = (docheight - winheight) - win.scrollTop();
                                        if (differnce < 100) {
                                            if (ajaxcall === 1) {
                                                $('#loading').show();
                                                ajaxcall = 0;
                                                $.ajax({
                                                    url: "<?php echo asset('get-question-loader') ?>",
                                                    type: "GET",
                                                    data: {
                                                        "count": count,
                                                        "sorting": sorting,
                                                        "q": q
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
                                                            noposts = '<div class="loader hb_not_more_posts_lbl" id="nomoreposts">No More Questions To Show</div>';
                                                            $('#questions_listing').append(noposts);
                                                        }
                                                    }
                                                });
                                            }

                                        }
                                    });
                                    function disableButton() {
                                        $('#question_error').hide();
                                        $('#description_error').hide();
                                        $('#submit_button').prop('disabled', true);
                                        question = $('#question_input').val();
                                        description = $('#question_description').val();
                                        if (description && question) {
                                            $('#question').submit();
                                        } else {
                                            $('#submit_button').prop('disabled', false);
                                            //          $('#question').submit();
                                        }
                                    }
                                    $(document).ready(function () {
                                        $("#question").validate({
                                            rules: {
                                                question: {
                                                    required: true
                                                },
                                                question_description: {
                                                    required: true
                                                }
                                            }, messages: {
                                                question: {
                                                    required: "The question field is required."
                                                },
                                                description: {
                                                    required: "The description field is required."
                                                }
                                            }, submitHandler: function (form) {
                                                saveAttachments(form);
                                            }

                                        });
                                    });

                                    $('#file').on('change', function () {

                                        var fileInput = document.getElementById('file');
                                        var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
                                        var image_type = fileInput.files[0].type;

                                        if (fileInput.files[0].type == "video/mp4") {

                                            $("#video_answer").attr("src", fileUrl);
                                            var video_file = this;
                                            setTimeout(function () {
                                                var myVid = document.getElementById("video_answer");
                                               
                                                var duration = myVid.duration.toFixed(2);
                                                if (duration > 20) {
                                                    $('#erroralertmessage').html('Video is greater than 20 sec.');
                                                    $('#erroralert').show();
                                                    $("#video_answer").attr("src", '');
                                                } else {
                                                    imagesPreview(video_file, 'ul.uploaded-files');
                                                }
                                            }, 500);
                                        } else {
//                    $('ul.uploaded-files').html('');
                                            imagesPreview(this, 'ul.uploaded-files');
                                        }

//                
                                    });
                                    var attachments = [];
                                    var counter = 0;
                                    var attachment_counter = 0;
                                    function imagesPreview(input, placeToInsertImagePreview) {
//                var attachments = [];
                                        $('#floading_qs_attach').show();
                                        $('#saveform').prop('disabled', true);
                                        if (input.files) {
                                            for (var x = 0; x < input.files.length; x++) {
                                                var filePath = input.value;
                                                var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.mp4)$/i;
                                                if (!allowedExtensions.exec(filePath)) {
                                                    $('#erroralertmessage').html('Please upload file having extensions .jpeg/.jpg/.png/.gif/.mp4  only.');
                                                    $('#erroralert').show();
                                                    $("#video_answer").attr("src", '');
                                                    $('#file').val('');
                                                    return false;
                                                }
                                            }

                                            if (parseInt(input.files.length) > 3 - attachment_counter) {

                                                $('#erroralertmessage').html('You can only upload maximum 3 files');
                                                $('#erroralert').show();
                                                $("#floading_qs_attach").hide();
                                                $('#saveform').prop('disabled', false);
                                                $('#file').val('');
//                        $('#imagePreview').html('');
                                                return false;
                                            }

                                            var filesAmount = input.files.length;

                                            for (i = 0; i < filesAmount; i++) {
                                                var data = new FormData();
                                                data.append('file', input.files[i]);
                                                attachment_counter++;
                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?php echo asset('add_answer_attachment'); ?>",
                                                    data: data,
                                                    processData: false,
                                                    contentType: false,
                                                    success: function (successdata) {
                                                        counter++;
                                                        var results = JSON.parse(successdata);
                                                        var path = "'" + results.delete_path + "'";
                                                        if (results.type == 'image') {

                                                            $('ul.uploaded-files').append('<li class="qs_append_img" id="' + results.file_path + '"><img src="' + results.file_path + '"><a href="#" class="btn-remove" onClick="removeAttachment(' + path + ')"><i class="fa fa-times" aria-hidden="true"></i></a></li>');

                                                            attachments.push({"file_path": results.file_path, "delete_path": results.delete_path, "path": results.path, "poster": '', "type": results.type});

                                                        }
                                                        if (results.type == 'video') {
                                                            if (Date.parse('01/01/2011 ' + results.duration) > Date.parse('01/01/2011 00:00:20')) {
                                                                alert("You can only upload maximum 20 sec video");
                                                                $('#file').val('');
                                                                return false;
                                                            }
                                                          
                                                            $('ul.uploaded-files').append('<li id="' + results.file_path + '"><video poster="' + results.poster + '" higth=70 width=130 class="video-use" class="video" src="' + results.file_path + '" id="video"></video ><a href="#" class="btn-remove" onClick="removeAttachment(' + path + ')"><i class="fa fa-times" aria-hidden="true"></i></a></li>');

                                                            attachments.push({"file_path": results.file_path, "delete_path": results.delete_path, "path": results.path, "poster": results.poster_path, "type": results.type});

                                                        }
                                                        $('#saveform').prop('disabled', false);
                                                        $('#floading_qs_attach').hide();
                                                        $('#file').val('');
                                                        //                        reader.readAsDataURL(file);
                                                    }
                                                });
                                            }
                                        }

                                    }
                                    ;

                                    function removeAttachment(file) { 
                                        $.each(attachments, function (i) {
                                            if (attachments[i].delete_path === file) {
                                                $.ajax({
                                                    url: "<?php echo asset('remove-attachment') ?>",
                                                    type: "POST",
                                                    data: {"file_path": file, "_token": "<?php echo csrf_token(); ?>"},
                                                    success: function (response) {
                                                        if (response.status == 'success') {

                                                        }
                                                        attachments.splice(i, 1);
                                                        attachment_counter--;
                                                    }
                                                });

                                                return false;
                                            }
                                        });
                                    }
                                    $(document).on("click", "#imagePreview li", function () {
                                        var curr_img_src = $(this).find('img').attr('src');
                                        $('#image_popup').addClass('active');
                                        $('#image_popup').find('img').attr('src', curr_img_src);
                                    });
                                    function saveAttachments(form) {
                                        $("#attachments").val(JSON.stringify(attachments));
                                        setTimeout(function () {
                                            form.submit();
                                        }, 500);
                                    }
        </script>
    </body>

</html>