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
                        <header class="intro-header no-bg">
                            <h1 class="custom-heading white text-center">
                                <img src="<?php echo asset('userassets/images/side-icon15.svg') ?>" alt="Icon" class="no-margin">
                                <span class="top-padding">EDIT BUDZ REVIEW</span>
                            </h1>
                        </header>
                        <form method="post" action="<?php echo asset('add-budzmap-review'); ?>" id="comment-form" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                            <input type="hidden" name="sub_user_id" value="<?php echo $review->sub_user_id; ?>">
                            <input type="hidden" name="review_id" value="<?php echo $review->id; ?>">
                            <input type="hidden" name="business_id" value="<?php echo $business_id; ?>">
                            <input type="hidden" name="business_type_id" value="<?php echo $business_type_id; ?>">
                            <div class="bus-txt-area">
                                <!--<h4>Add Your Comments Below</h4>-->
                                <?php
                                if ($errors->has('comment')) {
                                    echo $errors->first('comment');
                                }
                                ?>
                                <div class="bus-rating">
                                    <h4>Add Your Rating:</h4>
                                    <?php
                                    if ($errors->has('rating')) {
                                        echo $errors->first('rating');
                                    }
                                    ?>
                                    <input type="hidden" name="rating" id="review_rating" value="<?php echo $review->rating; ?>">
                                    <div class="budz_review_rating" data-rating="<?php echo $review->rating; ?>"></div>
                                </div>
                                <div class="label-in-com-rev">
                                    <textarea name="comment" maxlength="500" placeholder="Type your comment here" id="addcoment" required=""><?php echo revertTagSpace($review->text); ?></textarea>
                                    <!--<span class="chars-counter">Max. 500 Characters</span>-->
                                    <strong><span class="chars-counter"><?php echo strlen($review->text); ?>/500 Characters</span></strong>
                                </div>
                            </div>
                            <div class="bus-submit bus-sbm-sm">
                                <input onclick="checkRating()" type="button" value="Post Review" />
                            </div>
                            <div class="bus-upload">
                                <label for="test">
                                    <input type="file" name="pic" id="test" accept="video/*,  video/x-m4v, video/webm, video/x-ms-wmv, video/x-msvideo, video/3gpp, video/flv, video/x-flv, video/mp4, video/quicktime, video/mpeg, video/ogv, .ts, .mkv, image/*"/>
                                    <span class="res">
                                        Add An image or video
                                        <span>(1 PHOTO OR 20  SEC VIDEO MAX.)</span>
                                    </span>                                
    <!--<span>Upload</span>-->
                                </label>
                            </div>
                            <?php if ($review->attachment) { ?>
                                <div class="bus-pap-active">
                                    <!--<i class="fa fa-paperclip"></i>-->
                                    <?php if ($review->attachment->type == 'image') { ?>
                                        <!--<img src="<?php // echo asset('public/images' . $review->attachment->attachment) ?>" alt="image"/>-->
                                    <figure style="background-image:url('<?php echo asset('public/images' . $review->attachment->attachment) ?>');" id="" class="budz_review_image_act" /></figure>
                                    <?php } else if ($review->attachment->type == 'video') { ?>
                                        <video class="video-use" class="video" id="video" poster="<?php echo asset('public/images' . $review->attachment->poster) ?>" width="320" height="240">
                                            <source src="<?php echo asset('public/videos' . $review->attachment->attachment) ?>">
                                        </video>
                                    <?php } ?>
    <!--                            <span>image.jpg</span>-->
                                    <i class="fa fa-close" id="<?php echo $review->attachment->id; ?>"></i>
                                </div>
                            <?php } ?>
                            <div class="bus-pap rev-img-vid-set">
                                <!--<i class="fa fa-paperclip"></i>-->
                                <!--<img src="<?php // echo asset('userassets/images/img2.png') ?>" alt="image" id="strain_review_image" />-->
                                <figure style="background-image:url('<?php echo asset('userassets/images/img2.png') ?>');" id="budz_review_image" /></figure>
                                <video class="video-use" class="video" id="video" width="320" height="240"></video>

                                <!--<span>image.jpg</span>-->
                                <i class="fa fa-close"></i>
                            </div>
                        </form>
                    </div>
                    <div class="right_sidebars">
                        <?php include 'includes/rightsidebar.php'; ?>
                        <?php include 'includes/chat-rightsidebar.php'; ?>
                    </div>
                </div>
            </article>
        </div>
        <?php include('includes/footer.php'); ?>
        <script>
            function checkRating() {
        rating_value = $('#review_rating').val();
        comment_val = $('#addcoment').val();
        if (!rating_value || !comment_val || rating_value == 0) {
            
            if (!comment_val) {
                $('#showError').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>Comment is required').show().fadeOut(5000);
            }
            if (!rating_value || rating_value == 0) {
                $('#showError').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>Rating is required').show().fadeOut(5000);
            }
        } else {
            $('#comment-form').submit();
        }
    }
    
            $(document).ready(function () {
                $(".budz_rating").starRating({
                    totalStars: 5,
                    emptyColor: '#1e1e1e',
                    hoverColor: '#e070e0',
                    value: 2,
                    activeColor: '#e070e0',
                    strokeColor: "#e070e0",
                    strokeWidth: 20,
                    useGradient: false,
                    readOnly: true
//                    initialRating: 3
                });

                $(".budz_review_rating").starRating({
                    totalStars: 5,
                    emptyColor: '#1e1e1e',
                    hoverColor: '#e070e0',
                    activeColor: '#e070e0',
                    value: 2,
                    strokeColor: "#e070e0",
                    strokeWidth: 20,
//                    initialRating: 3,
                    useGradient: false,
                    disableAfterRate: false,
                    useFullStars:true,
                    initialRating:5,
                    callback: function (currentRating, $el) {
                        $('input[type=hidden]#review_rating').val(currentRating);
                    }
                });

                var textarea = $("#addcoment");
                textarea.keyup(function (event) {
                    var numbOfchars = textarea.val();
                    var len = numbOfchars.length;
                    //                var show = (500 - len);
                    var show = len;
                    $(".chars-counter").text(show + '/500 Characters');
                });
                textarea.keypress(function (e) {
                    var tval = textarea.val(),
                            tlength = tval.length,
                            set = 500,
                            remain = parseInt(set - tlength);
                    if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
                        textarea.val((tval).substring(0, tlength - 1))
                    }
                });


            });

            $('#test').on('change', prepareUpload);
            function prepareUpload(event)
            {
                var input = document.getElementById('test');
                var filePath = input.value;
                var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.mp4)$/i;
                if (!allowedExtensions.exec(filePath)) {
                    $('#erroralertmessage').html('Please upload file having extensions .jpeg/.jpg/.png/.gif/.mp4  only.');
                    $('#erroralert').show();
                    $('#test').val('');
                    $("#test").attr("src", '');
                    return false;
                }
            }

            $("#test").change(function () {
                $("#video").attr("src", '');
                $(".video-use").hide();
//                $("#budz_review_image").attr("src", '');
                $("#budz_review_image").attr("style", "background-image:url('')");
//                $(".bus-pap img").hide();
                $("#budz_review_image").hide();
                $(".bus-pap").hide();
                var fileInput = document.getElementById('test');
                var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
                var image_type = fileInput.files[0].type;
                //            alert(image_type)
                if (image_type == "image/png" || image_type == "image/jpeg" || image_type == "image/gif" || image_type == "image/bmp" || image_type == "image/jpg") {
                    var file = fileInput.files[0];
                    var reader = new FileReader();
                    reader.onloadend = function () {
                        getOrientation(file, function (orientation) {
//                            alert(orientation);
                            resetOrientation(reader.result, orientation, function (result) {
                                $(".bus-pap").show();
                                $(".bus-pap img").attr("src", result);
                                $(".bus-pap #budz_review_image").attr("style", "background-image:url('"+result+"')");
                                $(".bus-pap img").show();
                            });
                        });
                    };
                    reader.readAsDataURL(file);
                    $(".bus-pap-active").hide();
                    $("#video").attr("src", '');
                    $(".video-use").hide();
                    $(".bus-pap i.fa-close").show();

                } else if (fileInput.files[0].type == "video/mp4") {
//                    $("#budz_review_image").attr("src", '');
                    $("#budz_review_image").attr("style", "background-image:url('')");
                    $(".bus-pap").show();
                    $(".bus-pap i.fa-close").show();
                    $(".video-use").show();
//                    $(".bus-pap img").hide();
                    $("#budz_review_image").hide();
                    $(".video-use").attr("src", fileUrl);
                    var myVideo = document.getElementById("video");
                    myVideo.addEventListener("loadedmetadata", function ()
                    {
                        duration = (Math.round(myVideo.duration * 100) / 100);
                        if (duration >= 21) {
                            $('#erroralertmessage').html('Video is greater than 20 sec.');
                            $('#erroralert').show();
                            $("#video").attr("src", '');
                            $('#test').val('');
                            $(".bus-pap").hide();
                        } else {
                            $(".bus-pap-active").hide();
                        }
                    });
                }
            });

            $(".bus-pap i.fa-close").click(function () {
                $(".bus-pap").hide();
                $("#video").attr("src", '');
//                $("#budz_review_image").attr("src", '');
                $("#budz_review_image").attr("style", "background-image:url('')");
            });


            $(".bus-pap-active i.fa-close").click(function () {
                var attachment_id = $(this).attr('id');
                $.ajax({
                    url: "<?php echo asset('delete-budz-review-attachment') ?>",
                    type: "POST",
                    data: {"attachment_id": attachment_id, "_token": "<?php echo csrf_token(); ?>"},
                    success: function (response) {
                        if (response.successData == 1) {
                            $(".bus-pap-active").hide();
                        }
                    }
                });
            });

        </script>
    </body>
</html>