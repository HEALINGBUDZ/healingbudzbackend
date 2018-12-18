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
                        <li>Ask Question</li>
                    </ul>
                    <div class="search-area">
                        <!--<a href="<?php echo asset('ask-questions'); ?>" class="btn-ask">Ask Q</a>-->
                        <?php // include 'includes/questions_search.php'; ?>
                    </div>
                    <div class="new_container">
                        <div class="ask-area">
                            <?php // include 'includes/questions_search.php'; ?>
                            <form action="<?php echo asset('ask-question'); ?>" method="post" id="question">
                                <fieldset>
                                    <h2>Ask a Question</h2>
                                    <div class="row">
                                        <div class="img-holder pre-main-image hb_round_img" style="background-image: url(<?php echo $current_photo ?>)">
                                            <?php if ($current_special_image) { ?>
                                                <span class="fest-pre-img" style="background-image: url(<?php echo asset('public/images' . $current_special_image) ?>);"></span>
                                            <?php } ?>
                                        </div>
                                        <div class="input_holder arrow">
                                            <input autofocus="" autocomplete="off" id="question_input" type="text" required placeholder="Type your question here..." name="question" onkeyup="questionCountCharToMax(this, 150)" maxlength="150">
                                            <em id="questionCharNum">0/150 characters</em>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="img-holder"></div>
                                        <div class="input_holder height_auto">
                                            <textarea id="question_description" required placeholder="Add more details to your question..." name="description" onkeyup="descriptionCountCharToMax(this, 300)" maxlength="300"></textarea>
                                            <em class="abs" id="descriptionCharNum">0/300 characters</em>
                                        </div>
                                    </div>
                                    <div class="fields fluid ask_image_attach">
                                        <div class="align-left">
                                            <input max="3" class="custom-file" id="file" type="file" name="file[]" multiple="" accept="video/*,  video/x-m4v, video/webm, video/x-ms-wmv, video/x-msvideo, video/3gpp, video/flv, video/x-flv, video/mp4, video/quicktime, video/mpeg, video/ogv, .ts, .mkv, image/*">
                                            <label for="file" class="file-label">Attachments <span>Max 3</span></label>
                                        </div>
                                        <ul id="imagePreview" class="uploaded-files list-none">
                                        </ul>
                                        <video style="display: none" class="video-use" class="video" src="" id="video_answer"></video >
                                                <div id="floading_qs_attach" style="display: none;" style="margin: 0px auto;">
                                                    <img src="<?php echo asset('userassets/images/new_loadeer.svg') ?>" alt="Loader" style="width: 40px;">
                                                </div>
                                        
                                    </div>
                                    <input type="hidden" id="attachments" name="attachments">
                                    <div class="row">
                                        <input id="submit_button" type="submit" value="Post Question" onclick="disableButton()">
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
                                                    val.value = val.value.substring(min, max);
                                                    $('#descriptionCharNum').text(len + '/' + max + ' characters');
                                                } else {
                                                    $('#descriptionCharNum').text(len + '/' + max + ' characters');
                                                }
                                            }

                                            function disableButton() {
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
//                            $('ul.uploaded-files').html('');
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
//                            $('#imagePreview').html('');
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

                                                            $('ul.uploaded-files').append('<li id="' + results.file_path + '" class="qs_append_img"><img src="' + results.file_path + '"><a href="#" class="btn-remove" onClick="removeAttachment(' + path + ')"><i class="fa fa-times" aria-hidden="true"></i></a></li>');

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