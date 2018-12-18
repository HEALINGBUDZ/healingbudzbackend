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
                        <li>Update Question</li>
                    </ul>
                    <div class="search-area">
                        <!--<a href="<?php // echo asset('ask-questions');           ?>" class="btn-ask">Ask Q</a>-->
                        <?php // include 'includes/questions_search.php'; ?>

                    </div>
                    <div class="new_container">
                        <div class="ask-area">
                            <?php // include 'includes/questions_search.php'; ?>
                            <?php if (Session::has('success')) { ?>
                                <h5 class="alert alert-success hb_alert_msg green"><?php echo Session::get('success'); ?></h5>
                            <?php } ?>
                            <form id="question" action="<?php echo asset('ask-question'); ?>" method="post"  class="answer-form ask">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <input type="hidden" name="question_id" value="<?php echo $question->id; ?>">
                                <fieldset>
                                    <h2>Edit your question</h2>
                                    <div class="row">
                                        <div class="img-holder pre-main-image hb_round_img hb_bg_img" style="width:55px; height:55px; background-image: url(<?php echo $current_photo; ?>)">
                                            <?php if ($current_special_image) { ?>
                                                <span class="fest-pre-img" style="background-image: url(<?php echo asset('public/images' . $current_special_image) ?>);"></span>
                                            <?php } ?>
                                        </div>
                                        <div class="input_holder arrow upd">
                                            <!--<input value="<?php // echo revertTagSpace($question->question);        ?>" id="question_input" type="text" required placeholder="Type your question here..." name="question" onkeyup="questionCountCharToMax(this, 300)" maxlength="300">-->
                                            <textarea id="question_input" required placeholder="Type your question here..." name="question" onkeyup="questionCountCharToMax(this, 150)" maxlength="150"><?php echo trim(revertTagSpace($question->question)); ?></textarea>
                                            <em id="questionCharNum">0/150 characters</em>
                                        </div>
                                    </div>
                                    <span class="error_span"><?php
                                        if ($errors->has('question')) {
                                            echo $errors->first('question');
                                        }
                                        ?></span>
                                    <div class="row">
                                        <!--<div class="img-holder"></div>-->
                                        <div class="input_holder height_auto">
                                            <textarea id="question_description" required placeholder="Add more details to your question..." name="description" onkeyup="descriptionCountCharToMax(this, 300)" maxlength="300"><?php echo trim(revertTagSpace($question->description)); ?></textarea>
                                            <em class="abs" id="descriptionCharNum">0/300 characters</em>
                                        </div>
                                    </div>
                                    <span class="error_span"><?php
                                        if ($errors->has('description')) {
                                            echo $errors->first('description');
                                        }
                                        ?></span>
                                    <div class="fields ask_qs">
                                        <div class="align-left">
                                            <input max="3" class="custom-file" id="file" type="file" name="file[]" multiple="" accept="video/*,  video/x-m4v, video/webm, video/x-ms-wmv, video/x-msvideo, video/3gpp, video/flv, video/x-flv, video/mp4, video/quicktime, video/mpeg, video/ogv, .ts, .mkv, image/*">
                                            <label for="file" class="file-label">Attachments <span>Max 3</span></label>
                                        </div>
                                        <ul id="imagePreview" class="uploaded-files list-none">
                                            <?php if (count($question->getImageAttachments) > 0) { ?>
                                                <?php foreach ($question->getImageAttachments as $image) { ?>
                                                    <li id="<?php echo asset('public/images' . $image->upload_path) ?>">
                                                        <img src="<?php echo asset('public/images' . $image->upload_path) ?>">
                                                        <a href="#" class="btn-remove" onClick="removeAttachment('<?php echo 'public/images' . $image->upload_path; ?>')"><i class="fa fa-times" aria-hidden="true"></i></a>
                                                    </li>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if (count($question->getVideoAttachments) > 0) { ?>
                                                <?php foreach ($question->getVideoAttachments as $video) { ?>
                                                    <li id="<?php echo asset('public/videos' . $video->upload_path) ?>">
                                                        <video higth='70' width='130' class="video-use" class="video" poster="<?php echo asset('public/images' . $video->poster) ?>" id="video">
                                                            <source src="<?php echo asset('public/videos' . $video->upload_path) ?>" type="video/mp4">
                                                        </video>
                                                        <a href="#" class="btn-remove" onClick="removeAttachment('<?php echo 'public/videos' . $video->upload_path; ?>')"><i class="fa fa-times" aria-hidden="true"></i></a>
                                                    </li>
                                                <?php } ?>
                                            <?php } ?>
                                        </ul>

                                        <div id="floading_qs_attach" style="display: none;">
                                            <img src="<?php echo asset('userassets/images/new_loadeer.svg') ?>" alt="Loader" style="width: 40px;">
                                        </div>
                                    </div>
                                    <input type="hidden" id="attachments" name="attachments">
                                    <div class="row">
                                        <input type="submit" class="btn-primary" value="Save Question">
                                        <a href="<?= asset('questions') ?>" class="dis-q"><i class="fa fa-close"></i>Discard Edits</a>
                                    </div>
                                </fieldset>
                            </form>
                        </div>

                    </div>
                    <div class="right_sidebars">
                        <?php include 'includes/rightsidebar.php'; ?>
                        <?php include 'includes/chat-rightsidebar.php'; ?>
                    </div>
                </div>
            </article>
        </div>

        <?php include('includes/footer.php'); ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>
        <script>
                                                    function questionCountCharToMax(val, len) {
                                                        var max = len;
                                                        var min = 0;
                                                        var len = val.value.length;
                                                        if (len >= max) {
                                                            val.value = val.value.substring(min, max);
                                                            $('#questionCharNum').text(150 + '/' + max + ' characters');
                                                        } else {
                                                            $('#questionCharNum').text(len + '/' + max + ' characters');
                                                        }
                                                    }

                                                    function descriptionCountCharToMax(val, len) {
                                                        var max = len;
                                                        var min = 0;
                                                        var len = val.value.length;

                                                        if (len >= max) {
                                                            val.value = val.value.substring(min, max);

                                                            $('#descriptionCharNum').text(300 + '/' + max + ' characters');
                                                        } else {
                                                            $('#descriptionCharNum').text(len + '/' + max + ' characters');
                                                        }
                                                    }

                                                    $(document).ready(function () {
                                                        val = $('#question_description').val();
                                                        question = $('#question_input').val();
                                                        len = 300;
                                                        var max = len;
                                                        var q_max = 150;
                                                        var min = 0;
                                                        var len = val.length;
                                                        var queslenth = question.length;
                                                        if (len >= max) {
                                                            val.value = val.substring(min, max);

                                                            $('#descriptionCharNum').text(300 + '/' + max + ' characters');
                                                        } else {
                                                            $('#descriptionCharNum').text(len + '/' + max + ' characters');
                                                        }

                                                        if (question >= q_max) {
                                                            question.value = question.substring(min, q_max);
                                                            $('#questionCharNum').text(150 + '/' + q_max + ' characters');
                                                        } else {
                                                            $('#questionCharNum').text(queslenth + '/' + q_max + ' characters');
                                                        }
                                                    });


                                                    $('#file').on('change', function () {
                                                        $('#file').attr("src", '');
//                $('ul.uploaded-files').html('');
                                                        imagesPreview(this, 'ul.uploaded-files');
                                                    });
                                                    attachments = [];
                                                    var counter = 0;
                                                    var attachment_counter = $('ul.uploaded-files li').length;
                                                    function imagesPreview(input, placeToInsertImagePreview) {
//                var attachments = [];
                                                        $('#floading_qs_attach').show();
                                                        total_length = input.files.length;

                                                        if (input.files) {
                                                            for (var x = 0; x < input.files.length; x++) {
                                                                var filePath = input.value;
                                                                var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.mp4|\.mkv|\.mov|\.flv|\.mpeg|\.webm|\.mpeg|\.avi|\.ts|\.ogv)$/i;
                                                                if (!allowedExtensions.exec(filePath)) {
                                                                    alert('Please upload file having extensions .jpeg/.jpg/.png/.gif/.mp4/.mkv/.mov/.3gp/.flv/.mpeg/.webm/.mpeg/.avi/.ts/.ogv/bm  only.');
                                                                    $('#file').val('');
//                            $('#imagePreview').html('');
                                                                    return false;
                                                                }
                                                            }
                                                            if (parseInt(input.files.length) > 3 - attachment_counter) {

                                                                alert("You can only upload maximum 3 files");
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
                                                                            $('ul.uploaded-files').append('<li id="' + results.file_path + '"><video higth=70 width=130 class="video-use" class="video" src="' + results.file_path + '" id="video"></video ><a href="#" class="btn-remove" onClick="removeAttachment(' + path + ')"><i class="fa fa-times" aria-hidden="true"></i></a></li>');

                                                                            attachments.push({"file_path": results.file_path, "delete_path": results.delete_path, "path": results.path, "poster": results.poster_path, "type": results.type});

                                                                        }
                                                                        $('#floading_qs_attach').hide();
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
                                                    function saveAttachments(form) {
                                                        $("#attachments").val(JSON.stringify(attachments));
                                                        setTimeout(function () {
                                                            form.submit();
                                                        }, 500);
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
        </script>
    </body>
    <?php if (count($question->getImageAttachments) > 0) { ?>
        <?php foreach ($question->getImageAttachments as $image) { ?>

            <script>
                attachments.push({"file_path": "<?php echo asset('public/images' . $image->upload_path) ?>", "delete_path": "<?php echo 'public/images' . $image->upload_path; ?>", "path": "<?php echo $image->upload_path; ?>", "poster": "<?php echo $image->poster; ?>", "type": "<?php echo $image->media_type; ?>"});
               
            </script>
        <?php } ?>
    <?php } ?>

    <?php if (count($question->getVideoAttachments) > 0) { ?>
        <?php foreach ($question->getVideoAttachments as $video) { ?>
            <script>
                attachments.push({"file_path": "<?php echo asset('public/videos' . $video->upload_path) ?>", "delete_path": "<?php echo 'public/videos' . $video->upload_path; ?>", "path": "<?php echo $video->upload_path; ?>", "poster": "<?php echo $video->poster; ?>", "type": "<?php echo $video->media_type; ?>"});
              
            </script>
        <?php } ?>
    <?php } ?>
</html>