<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top.php'); ?>
    <body>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <div class="new_container">
                        <header class="intro-header no-bg">
                            <h1 class="custom-heading white text-center">
                                <img src="<?php echo asset('userassets/images/side-icon14.svg') ?>" alt="Icon" class="no-margin">
                                <span class="top-padding">EDIT STRAIN REVIEW</span>
                            </h1>
                        </header>
                        <div class="tab-wid">
                            <!--<strong class="title">Add Your Comment Below</strong>-->
                            <form action="<?php echo asset('add_strain_review') ?>" class="comment-form" id="comment-form" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <input type="hidden" name="strain_id" value="<?= $review->strain_id ?>">
                                <input type="hidden" name="review_id" value="<?= $review->id ?>">
                                <?php if ($review->rating) { ?>
                                    <input type="hidden" name="review_rating_id" value="<?= $review->rating->id ?>">
                                <?php } ?>
                                <fieldset>
                                    <div class="comment-ratings">
                                        <strong class="title">Add Your Rating:</strong>
                                        <?php if ($review->rating) { ?>
                                        <input type="hidden" name="rating" value="<?= $review->rating->rating?>">
                                        <?php } ?>
                                        <fieldset class="rate">
                                            <input type="radio" id="rating1" name="rating" value="1" class="rating <?php if ($review->rating && $review->rating->rating == 1) {
                                    echo 'checked';
                                } ?>">
                                            <label class="rate-one" for="rating1" title="1">
                                                <img src="<?php echo asset('userassets/images/leaf-1.svg') ?>" alt="Favorites">
                                            </label>
                                            <input type="radio" id="rating2" name="rating" value="2" class="rating <?php if ($review->rating && $review->rating->rating == 2) {
                                    echo 'checked';
                                } ?>">
                                            <label class="rate-two" for="rating2" title="2">
                                                <img src="<?php echo asset('userassets/images/leaf-2.svg') ?>" alt="Favorites">
                                            </label>
                                            <input type="radio" id="rating3" name="rating" value="3" class="rating <?php if ($review->rating && $review->rating->rating == 3) {
                                    echo 'checked';
                                } ?>">
                                            <label class="rate-three" for="rating3" title="3">
                                                <img src="<?php echo asset('userassets/images/leaf-3.svg') ?>" alt="Favorites">
                                            </label>
                                            <input type="radio" id="rating4" name="rating" value="4" class="rating <?php if ($review->rating && $review->rating->rating == 4) {
                                    echo 'checked';
                                } ?>">
                                            <label class="rate-four" for="rating4" title="4">
                                                <img src="<?php echo asset('userassets/images/leaf-4.svg') ?>" alt="Favorites">
                                            </label>
                                            <input type="radio" id="rating5" name="rating" value="5" class="rating <?php if ($review->rating && $review->rating->rating == 5) {
                                    echo 'checked';
                                } ?>">
                                            <label class="rate-five" for="rating5" title="5">
                                                <img src="<?php echo asset('userassets/images/leaf-5.svg') ?>" alt="Favorites">
                                            </label>
                                        </fieldset>
                                    </div>
                                    <div class="label-in-com-rev">
                                        <textarea name="review" placeholder="Your review comment here..." maxlength="500" required=""><?php echo revertTagSpace($review->review); ?></textarea>
<?php
if ($errors->has('review')) {
    echo $errors->first('review');
}
?>
                                        <strong>0/<span class="msg-note">500 Characters</span></strong>
                                    </div>
                                    <div class="strain-comment"><input type="submit" value="Update Review"></div>
                                    <div class="upload-file">
                                        <!-- <input type="file" id="author-image" name="image"> -->
                                        <input id="review_file" name="attachment" type="file" accept="video/*,  video/x-m4v, video/webm, video/x-ms-wmv, video/x-msvideo, video/3gpp, video/flv, video/x-flv, video/mp4, video/quicktime, video/mpeg, video/ogv, .ts, .mkv, image/*">
                                        <label for="review_file">
                                            <span>Add An image or video<em>(1 photo or 20 sec video max.)</em></span>
                                        </label>
                                    </div>
<?php if ($review->attachment) { ?>
                                        <input type="hidden" value='<?= json_encode($review->attachment); ?>' name="old_attachment">
                                        <div class="strain-attachment-active">
                                            <!--<i class="fa fa-paperclip"></i>-->
    <?php if ($review->attachment->type == 'image') { ?>
                                                        <!--<img src="<?php echo asset('public/images' . $review->attachment->attachment) ?>" alt="image" />-->
        <?php $strain_sing_img = image_fix_orientation('public/images' . $review->attachment->attachment); ?>
                                                <a href="<?php echo asset($strain_sing_img) ?>" class="" data-fancybox="gallery<?= $review->attachment->id ?>" >
                                                    <div class="ans-slide-image" style="background-image: url(<?php echo asset($strain_sing_img) ?>)"></div>
                                                </a>
                                            <?php } else if ($review->attachment->type == 'video') { ?>
        <!--                                                <video class="video-use" class="video" id="video" poster="<?php echo asset('public/images' . $review->attachment->poster) ?>" width="320" height="240">
                                                    <source src="<?php echo asset('public/videos' . $review->attachment->attachment) ?>">
                                                </video>-->
                                            <?php $strain_sing_post = 'public/images' . $review->attachment->poster ?>
                                                <a href="#video" data-fancybox="gallery<?= $review->attachment->id ?>" >
                                                    <!--<div class="ans-slide-image" style="background-image: url(<?php // echo asset($strain_sing_post)  ?>)"></div>-->
                                                    <!--<img src="<?php // echo asset($strain_sing_post) ?>" alt="poster" />-->
                                                    <figure style="background-image:url('<?php echo asset($strain_sing_post) ?>');" id="strain_review_image" /></figure>
                                                </a>
                                                <video width="320" height="240" poster="<?php echo asset('public/images' . $review->attachment->poster); ?>" controls="" id='video' class="video" style="display: none;">
                                                    <source src="<?php echo asset('public/videos' . $review->attachment->attachment); ?>">
                                                    Your browser does not support the video tag.
                                                </video>
    <?php } ?>
                                            <i class="fa fa-close" id="<?php echo $review->attachment->id; ?>"></i>
                                        </div>
<?php } ?>
                                    <div class="strain-attachment">
                                        <!--<i class="fa fa-paperclip"></i>-->
                                        <!--<img src="<?php // echo asset('userassets/images/img2.png') ?>" alt="image" id="strain_review_image" />-->
                                        <figure style="background-image:url('<?php echo asset('userassets/images/img2.png') ?>'); display: none;" id="strain_review_image" /></figure>
                                        <video class="video-use" src="" id="video-use" width="320" height="240"></video>
                                        <!--                                        <a href="#video-use" data-fancybox="gallery" >
                                                                                    <div class="ans-slide-image" style="background-image: url()"></div>
                                                                                </a>
                                                                                <video width="320" height="240"   id='video-use' class="video-use" ></video>-->
                                        <i class="fa fa-close"></i>
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
        <script>
//              $(document).ready(function(){
//            var allRadios = document.getElementsByName('rating');
//          var booRadio;
//          var x = 0;
//          for(x = 0; x < allRadios.length; x++){
//            allRadios[x].onclick = function() {
//              if(booRadio == this){
//                this.checked = false;
//                booRadio = null;
//              } else {
//                booRadio = this;
//              }
//            };
//          }
//    });
    

            $(".rating").click(function () {
                $("input:radio").each(function () {
                    $(this).removeClass('checked');
                });
            });


            $("#review_file").change(function () {

                var input = document.getElementById('review_file');
                var filePath = input.value;
                var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.mp4)$/i;
                if (!allowedExtensions.exec(filePath)) {
//                    alert('Please upload file having extensions .jpeg/.jpg/.png/.gif/.mp4|\.mkv|\.mov|\.flv|\.mpeg|\.webm|\.mpeg|\.avi|\.ts|\.ogv  only.');
                    $('#erroralertmessage').html('Please upload file having extensions .jpeg/.jpg/.png/.gif/.mp4  only.');
                    $('#erroralert').show();
                    $('#review_file').val('');
                    return false;
                }
                var fileInput = document.getElementById('review_file');
                var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
                var image_type = fileInput.files[0].type;
                if (image_type == "image/png" || image_type == "image/gif" ||  image_type == "image/jpeg" || image_type == "image/bmp" || image_type == "image/jpg") {

                    var file = fileInput.files[0];
                    var reader = new FileReader();
                    reader.onloadend = function () {
                        getOrientation(file, function (orientation) {
//                            alert(orientation);
                            resetOrientation(reader.result, orientation, function (result) {
                                $(".strain-attachment").show();
//                                $(".strain-attachment img").attr("src", result);
                                $(".strain-attachment #strain_review_image").attr("style", "background-image:url('"+result+"')");
                                $(".strain-attachment img").show();
                            });
                        });
                    };
                    reader.readAsDataURL(file);
//                    var base64 = getBase64(fileInput.files[0]);
                    $(".strain-attachment-active").hide();
                    $("#video").attr("src", '');
//                    $(".strain-attachment").show();
//                    $(".strain-attachment img").attr("src", fileUrl);
//                    $(".strain-attachment img").show();
                    $(".video-use").hide();
                    $(".strain-attachment i.fa-close").show();
                } else if (fileInput.files[0].type == "video/mp4") {
//                    $("#strain_review_image").attr("src", '');
                    $("#strain_review_image").attr("style", "background-image:url('')");
                    $(".strain-attachment").show();
                    $(".strain-attachment i.fa-close").show();
                    $(".video-use").show();
//                    $(".strain-attachment img").hide();
                    $("#strain_review_image").hide();
                    $("#video-use").attr("src", fileUrl);
                    var myVideo = document.getElementById("video-use");
                    myVideo.addEventListener("loadedmetadata", function ()
                    {
                        duration = (Math.round(myVideo.duration * 100) / 100);
                        if (duration >= 21) {
                            $('#erroralertmessage').html('Video is greater than 20 sec.');
                            $('#erroralert').show();
                            $("#video-use").attr("src", '');
                            $("#review_file").val();

                            $(".strain-attachment").hide();
                        } else {
                            $(".strain-attachment-active").hide();
                        }
                    });
                }
            });
            $(".strain-attachment i.fa-close").click(function () {
                $(".strain-attachment").hide();
                $("#video").attr("src", '');
                $("#strain_review_image").attr("src", '');
            });

            $(".strain-attachment-active i.fa-close").click(function () {
                $('input[name="old_attachment"]').val('deleted');
                $(".strain-attachment-active").hide();
//                var attachment_id = $(this).attr('id');
//                $.ajax({
//                    url: "<?php echo asset('delete-strain-review-attachment') ?>",
//                    type: "POST",
//                    data: {"attachment_id": attachment_id, "_token": "<?php echo csrf_token(); ?>"},
//                    success: function (response) {
//                        if (response.successData == 1) {
//                            $(".strain-attachment-active").hide();
//                        }
//                    }
//                });
            });
        </script>
    </body>
</html>