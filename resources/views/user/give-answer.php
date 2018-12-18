<!DOCTYPE html>
<html lang="en">
    <?php
    include('includes/top.php');
// echo '<pre>';
// print_r($question);exit;
    ?>
    <body>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">

                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <ul class="bread-crumbs list-none">
                        <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                        <li><a href="<?php echo asset('questions'); ?>">Q&amp;A</a></li>
                        <li>Give Answer</li>
                    </ul>
                    <div class="new_container">
                        <div class="search-area">
                            <a href="<?php echo asset('ask-questions'); ?>" class="btn-ask"><img src="<?php echo asset('userassets/images/icon12.png') ?>" alt="Q">Ask Question</a>
                            <?php // include 'includes/questions_search.php'; ?>
                        </div>
                        <ul class="questions-list list-none answers q-view q_details_view">
                            <li>
                                <div class="text">
                                    <div class="txt-holder">
                                        <div class="question text-center no-margin">
                                            <div class="user-img">
                                                <div class="btns add abs">
                                                    <?php if ($current_id != $question->user_id) { ?>
                                                        <?php if ($question->is_flaged_count) { ?>
                                                            <a id="addFlag<?php echo $question->id; ?>" href="#question-flag" class="report btn-popup">Report</a>
                                                        <?php } else { ?>
                                                            <a id="removeFlag<?php echo $question->id; ?>"  href="#" class="flag-icon active">Reported</a>
                                                        <?PHP }
                                                    } ?>
                                                    <a href="#" class="share-icon">Share</a>
                                                   <div class="custom-shares">
                                                        <?php
                                                        echo Share::page(asset('get-question-answers/' . $question->id), $question->question, ['class' => 'questions_class', 'id' => $question->id])
                                                                ->facebook($question->question)
                                                                ->twitter($question->question)
                                                                ->googlePlus($question->question);
                                                        ?>
                                                       <?php if(Auth::user()){ ?>
                                                       <div class="questions_class" onclick="shareInapp('<?= asset('get-question-answers/' . $question->id) ?>', '<?php echo trim(revertTagSpace($question->question)); ?>', '<?= asset('userassets/images/logo-for-scrap.png') ?>')"> <span class="hb_icon_repost"></span> In App</div>
                                                       <?php } ?> 
                                                   </div>
                                                </div>                                            
                                            </div>
                                            <div class="q_upper_part">
                                                <div class="details_header">
                                                    <div class="sort">
                                                        <!--<a href="#" class="dot-options operate-all-btn"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>-->
                                                        <span class="dot-options">
                                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                            <div class="sort-drop all-options">
                                                                <?php if ($question->user_id == $current_id && $question->get_answers_count == 0) { ?>
                                                                    <div class="sort-item expend-all active"><a href="<?php echo asset('update-question/' . $question->id); ?>"><i class="fa fa-pencil"></i> Edit Question</a></div>
                                                                <?php } ?>
                                                                <?php /*    <div class="sort-item expend-all">
                                                                  <a <?php if ($question->get_user_likes_count) { ?> style="display: none"<?php } if (checkMySaveSetting('save_question')) { ?> href="javascript:void(0)" <?php } else { ?> href="#saved-discuss" <?php } ?>class="btn-popup fav-icon" onclick="addQuestionMySave('<?php echo $question->id; ?>', 'addqfav<?php echo $question->id; ?>', 'remqfav<?php echo $question->id; ?>')" id="addqfav<?php echo $question->id; ?>"><i class="fa fa-heart-o" aria-hidden="true"></i> Favorite</a>
                                                                  <a <?php if (!$question->get_user_likes_count) { ?> style="display: none"<?php } ?>href="#unsave-discuss" class="btn-popup fav-icon active" onclick="removeQuestionMySave('<?php echo $question->id; ?>', 'remqfav<?php echo $question->id; ?>', 'addqfav<?php echo $question->id; ?>')" id="remqfav<?php echo $question->id; ?>"><i class="fa fa-heart" aria-hidden="true"></i> Favorite</a>
                                                                  </div>
                                                                 */ ?>
                                                                    <?php if ($question->user_id != $current_id) { ?>
                                                                    <div class="sort-item expend-all">
                                                                        <?php if (!$question->is_flaged_count) { ?>
                                                                            <a id="addFlag<?php echo $question->id; ?>" href="#question-flag" class="report btn-popup"><i class="fa fa-flag"></i> Report</a>
                                                                        <?php } else { ?>
                                                                            <a style="color:#1383c6"  id="removeFlag<?php echo $question->id; ?>"  href="javascript:void(0)" class="flag-icon active"><i class="fa fa-flag"></i> Reported</a>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <div class="sort-item expend-all">
                                                                    <a href="#share-post" class="share-icon btn-popup"><i class="fa fa-share-alt"></i> Share</a>
                                                                </div>
                                                            </div>
                                                        </span>
                                                    </div>
                                                    <div class="pre-main-image in-blk in-blk hb_round_img hb_bg_img" style="width:55px; height:55px; background-image: url(<?php echo getImage($question->getUser->image_path, $question->getUser->avatar); ?>)">
                                                        <?php if ($question->getUser->special_icon) { ?>
                                                            <span class="fest-pre-img" style="background-image: url(<?php echo asset('public/images' . $question->getUser->special_icon) ?>);"></span>
                                                        <?php } ?>
                                                    </div>
                                                    <span class="date absolute right-spc"><?= timeago($question->created_at); ?></span>
                                                    <span class="user-asked">
                                                        <a class="<?= getRatingClass($question['getUser']->points) ?>" href="<?php echo asset('user-profile-detail/' . $question['getUser']->id) ?>"><?php echo $question['getUser']->first_name; ?> </a> asks...
                                                    </span>
                                                </div>
                                                <div class="holder">
                                                    <div class="icon"><img src="<?php echo asset('userassets/images/question-icon.svg') ?>" alt="Q"> <?php echo $question->question; ?></div>
                                                    <span class="sub-q"><?php echo $question->description; ?> <br>
                                                        <!--<a href="#" class="btn-primary">Answer your Bud</a>-->
                                                    </span>
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
                                                <footer class="footer">
                                                    <div class="align-right">
                                                        <a <?php if ($question->get_user_likes_count) { ?> style="display: none"<?php } if (checkMySaveSetting('save_question')) { ?> href="javascript:void(0)" <?php } else { ?> href="#saved-discuss" <?php } ?> class="like_heart" onclick="addQuestionMySave('<?php echo $question->id; ?>', 'addqfav<?php echo $question->id; ?>', 'remqfav<?php echo $question->id; ?>')" id="addqfav<?php echo $question->id; ?>"><i class="fa fa-heart-o" ></i></a>
                                                        <a class="like_heart" <?php if (!$question->get_user_likes_count) { ?> style="display: none"<?php } ?>href="#unsave-discuss" class="btn-popup fav-icon active" onclick="removeQuestionMySave('<?php echo $question->id; ?>', 'remqfav<?php echo $question->id; ?>', 'addqfav<?php echo $question->id; ?>')" id="remqfav<?php echo $question->id; ?>"><i style="color:#ff2525;" class="fa fa-heart" aria-hidden="true"></i></a>        

                                                        <span id="fav_count_<?= $question->id ?>"><?= $question->getUserLikes->count(); ?></span>
                                                    </div>
                                                </footer>
                                            </div>
                                            <div class="scrolled_area q_details_answers">
                                                <div class="answered-q" id="question_answers">
                                                    <div class="a-holder">
                                                        <div class="repeater_div">
                                                            <div class="ans_add_form">
                                                                <?php if ($question->get_answers_count == 0 && $question->user_id != $current_id) { ?>
                                                                    <h1>Be the 1st bud to answer</h1>
                                                                <?php } ?>
                                                                <h5  id="showErrorAnswer" class="alert alert-error" style="display: none; color: #d9534f;font-size: 15px;line-height: 19px;font-weight: 400"></h5>
                                                                <?php if (Session::has('success')) { ?>
                                                                    <h5 class="alert alert-success"><?php echo Session::get('success'); ?></h5>
                                                                <?php } ?>
                                                                <h5 class="alert alert-danger" style="display: none" id="error_message">The Description is required</h5>
                                                                <video style="display: none" class="video-use" class="video" src="" id="video_answer"></video >
                                                                <?php if ($question->get_answers_count == 0 && $question->user_id == $current_id) {                                                                    
                                                                } else { ?>
                                                                    <form id="add_answer"method="post" action="<?php echo asset('add-answer'); ?>" class="answer-form" enctype="multipart/form-data">
                                                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                                        <input type="hidden" name="question_id" value="<?php echo $id; ?>">
                                                                        <input type="hidden" name="attachments" id="attachments">
                                                                        <fieldset>
                                                                            <div class="char-in-area">
                                                                                <textarea  name="description" required="" id='my_textarea' placeholder="Type Your answer..." maxlength="2500"></textarea>
    <?php if ($errors->has('description')) { ?><h5 class="alert alert-danger"> <?php echo $errors->first('description'); ?> </h5> <?php } ?>
                                                                                <div class="msg-notice"><span class="chars-counter">0</span>/2500 characters</div>
                                                                            </div>
                                                                            <div class="fields fluid">
                                                                                <div class="align-left">
                                                                                    <input  max="3" class="custom-file" id="file" type="file" name="file[]" multiple accept="video/*,  video/x-m4v, video/webm, video/x-ms-wmv, video/x-msvideo, video/3gpp, video/flv, video/x-flv, video/mp4, video/quicktime, video/mpeg, video/ogv, .ts, .mkv, image/*">
                                                                                    <label for="file" class="file-label" >Attachments <span>Max 3</span></label>
                                                                                </div>
                                                                                <ul id="imagePreview" class="uploaded-files list-none">
                                                                                </ul>
                                                                                <div id="floading" style="display: none;" style="margin: 0px auto;">
                                                                                    <img src="<?php echo asset('userassets/images/new_loadeer.svg')?>" alt="Loader" style="width: 40px;">
                                                                                </div>
                                                                            </div>
                                                                        </fieldset>
                                                                        <input id="saveform" type="button" name="saveanswer" value="Answer your bud" class="btn-primary" onclick="disableButton()">
                                                                        <!--<a href="answered-questions.html" class="btn-primary">Answer your bud</a>-->
                                                                    </form>

<?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="right_sidebars">
<?php include 'includes/rightsidebar.php'; ?>
<?php include 'includes/chat-rightsidebar.php'; ?>
                    </div>
                </div>
            </article>
        </div>
        <div id="image_popup" class="popup">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="text">
                        <div class="edit-holder">
                            <div class="attach_thumb"><img src="" alt="Image"></div>
                        </div>
                        <a href="#" class="popup-closer">x</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="question-flag" class="popup">
            <div class="popup-holder">
                <div class="popup-area">
                    <form action="<?php echo asset('add-question-flag'); ?>" class="reporting-form" method="post">
                        <input type="hidden" value="<?php echo $question->id; ?>" name="question_id">
                        <input type="hidden" value="<?php echo csrf_token(); ?>" name="_token">
                        <fieldset>
                            <h2>Reason For Reporting</h2>
                            
                            <input type="radio" name="group" id="sexual<?= $question->id ?>" checked  value="Nudity or sexual content">
                            <label for="sexual<?= $question->id ?>">Nudity or sexual content</label>

                            <input type="radio" name="group" id="harasssment<?= $question->id ?>"  value="Harassment or hate speech">
                            <label for="harasssment<?= $question->id ?>">Harassment or hate speech</label>

                            <input type="radio" name="group" id="threatening<?= $question->id ?>"  value="Threatening, violent, or concerning">
                            <label for="threatening<?= $question->id ?>">Threatening, violent, or concerning</label>

                            
                            
                            <input type="radio" name="group" id="abused<?= $question->id ?>"  value="Abused">
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
                                <label  for="check">Got it! Do not show again for Q's &amp; A's | Save</label>
                            </div>
                        </div>
                        <a href="#" class="btn-close">Close</a>
                    </div>
                </div>
            </div>
        </div>
<?php include('includes/footer.php'); ?>
<?php include('includes/functions.php'); ?>
        <script>
            function disableButton() {
                $('#saveform').prop('disabled', true);
//                question=  $('#my_textarea').val(); 
                description = $('#my_textarea').val();
                if (description) {
//                     $('#add_answer').submit();
                } else {
                    $('#saveform').prop('disabled', false);
                    //          $('#question').submit();
                }
            }


            $(document).ready(function () {
                var textarea = $("#my_textarea");
                textarea.keyup(function (event) {
                    var numbOfchars = textarea.val();
                    var len = numbOfchars.length;
                    $(".chars-counter").text(len);
                });
                textarea.keypress(function (e) {
                    var tval = textarea.val(),
                            tlength = tval.length,
                            set = 2500,
                            remain = parseInt(set - tlength);
                    if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
                        textarea.val((tval).substring(0, tlength - 1));
                        $(".chars-counter").text('2500');
                    }
                });
            });

            $(function () {
//                
                $("#saveform").click(function (event) {
                    event.preventDefault();

                    text_val = $("#my_textarea").val();
                    if (!text_val) {
                        $('#error_message').show();
                    } else {
                        $('#file').val('');
                        $("#attachments").val(JSON.stringify(attachments));
                        $('#add_answer').submit();
                    }
                });

            });

            $('#file').on('change', function () {

                var fileInput = document.getElementById('file');
                var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
                var image_type = fileInput.files[0].type;
                
                if (fileInput.files[0].type == "video/mp4") {
                    
                    $("#video_answer").attr("src", fileUrl);
                    var video_file=this;
                    setTimeout(function () {
                        var myVid = document.getElementById("video_answer");
                        var duration = myVid.duration.toFixed(2);
                        if (duration > 20) {
                            $('#erroralertmessage').html('Video is greater than 20 sec.');
                            $('#erroralert').show();
                            $("#video_answer").attr("src", '');
                        } else {
//                            $('ul.uploaded-files').html('');
                            imagesPreview(video_file, 'ul.uploaded-files');
                        }
                    }, 500);
                }else{
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
                $('#floading').show();
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
//                            $('#imagePreview').html('');
                            return false;
                        }
                    }

                    if (parseInt(input.files.length) > 3 - attachment_counter) {

                        $('#erroralertmessage').html('You can only upload maximum 3 files');
                        $('#erroralert').show();
                        $("#floading").hide();
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
                                $('#floading').hide();
                                $('#file').val('');
                                
                            }
                        });
                    }
                }

            };

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

            function InsertBreak(e) {
                //check for return key=13
                if (parseInt(e.keyCode) == 13) {
                    //get textarea object
                    var objTxtArea;
                    objTxtArea = document.getElementById("test");
                    //insert the existing text with the <br>
                    objTxtArea.innerText = objTxtArea.value + "<br>";
                }
            }


        </script>
    </body>


</html>