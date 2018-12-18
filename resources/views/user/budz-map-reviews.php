<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); ?>
    <body>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php // include('includes/header-maps-info.php'); ?>
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <div class="new_container">
                        <div class="pad-bor pad-bor-nor">
                            <div class="bus-rev" id="review_listing">
                                <div class="rev-sec-row">
                                    <h4 class="reviews-heading">(<?= $reviews_count; ?>) Reviews</h4>
                                </div>
                                <?php $user_review_count = 0; ?>
                                <?php foreach ($reviews as $review) { ?>
                                    <?php
                                    if ($review->reviewed_by == $current_id) {
                                        $user_review_count ++;
                                    }
                                    ?>
                                    <div id="review-flag<?= $review->id ?>" class="popup">
                                        <div class="popup-holder">
                                            <div class="popup-area">
                                                <form action="<?php echo asset('report-budz-review'); ?>" class="reporting-form" method="post">
                                                    <input type="hidden" value="<?php echo $review->id; ?>" name="review_id">
                                                    <input type="hidden" value="<?php echo csrf_token(); ?>" name="_token">
                                                    <fieldset>
                                                        <h2>Reason For Reporting</h2>

                                                        <input type="radio" name="group" id="sexual<?= $review->id ?>" checked value="Nudity or sexual content">
                                                        <label for="sexual<?= $review->id ?>">Nudity or sexual content</label>

                                                        <input type="radio" name="group" id="harasssment<?= $review->id ?>"  value="Harassment or hate speech">
                                                        <label for="harasssment<?= $review->id ?>">Harassment or hate speech</label>

                                                        <input type="radio" name="group" id="threatening<?= $review->id ?>"  value="Threatening, violent, or concerning">
                                                        <label for="threatening<?= $review->id ?>">Threatening, violent, or concerning</label>

                                                        <input type="radio" name="group" id="abused<?= $review->id ?>" value="Budz adz review is Offensive">
                                                        <label for="abused<?= $review->id ?>">Budz adz review is Offensive</label>


                                                        <input type="radio" name="group" id="spam<?= $review->id ?>" value="Spam">
                                                        <label for="spam<?= $review->id ?>">Spam</label>
                                                        <input type="radio" name="group" id="unrelated<?= $review->id ?>" value="Unrelated">
                                                        <label for="unrelated<?= $review->id ?>">Unrelated</label>
                                                        <input type="submit" value="Report Budz Adz review">
                                                        <a href="#" class="btn-close">x</a>
                                                    </fieldset>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bud-map-info-bot">
                                        <div class="bus-rev-bot">
                                            <div class="cus-col">
                                                <div class="rev-row">                        
                                                    <article>
                                                        <div class="comment_repeater">
                                                            <div class="art-top">
                                                                <div class="art-top-row">
                                                                    <figure class="cir-img pre-main-image" style="background-image: url(<?php echo getImage($review->user->image_path, $review->user->avatar) ?>);">
                                                                        <?php if ($review->user->special_icon) { ?>
                                                                            <span class="fest-pre-img" style="background-image: url(<?php echo asset('public/images' . $review->user->special_icon) ?>);"></span>
                                                                        <?php } ?>
                                                                    </figure>
                                                                    <div class="comment_new_txt">
                                                                        <div class="clearfix">
                                                                            <span class="rev-title"><a class="<?= getRatingClass($review->user->points) ?>"  href="<?= asset('user-profile-detail/' . $review->user->id) ?>"><?php echo $review->user->first_name; ?></a></span>
                                                                            <!--<span class="time"><?php //echo $newDate = date("jS M Y", strtotime($review->created_at));        ?></span>-->
                                                                            <span class="dot-options">
                                                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                                                <div class="sort-drop">
                                                                                    <?php if ($review->reviewed_by == $current_id) { ?>
                                                                                        <div class="sort-item">
                                                                                            <a class="white flag report" href="<?php echo asset('edit-budmap-review/' . $review->id . '/' . $_GET['business_id'] . '/' . $_GET['business_type_id']); ?>">
                                                                                                <i class="fa fa-pencil" aria-hidden="true"></i><span>Edit Review</span>
                                                                                            </a>
                                                                                        </div>

                                                                                        <div class="sort-item">
                                                                                            <a class="white flag report btn-popup" href="#delete_budz_review<?php echo $review->id; ?>">
                                                                                                <i class="fa fa-trash" aria-hidden="true"></i><span>Delete</span>
                                                                                            </a>
                                                                                        </div>
                                                                                    <?php } ?>

                                                                                    <?php if (Auth::user() && $review->reviewed_by != $current_id) { ?>
                                                                                        <div class="sort-item"> <a href="javascript:void(0)"  id="budz_review_reported<?php echo $review->id; ?>" <?php
                                                                                            if (count($review->reports) > 0) {
                                                                                                echo 'style="display: block"';
                                                                                            } else {
                                                                                                echo 'style="display: none"';
                                                                                            }
                                                                                            ?> class="flag active">
                                                                                                <i class="fa fa-flag" aria-hidden="true"></i><span>Reported</span>
                                                                                            </a>
                                                                                            <a href="#review-flag<?= $review->id ?>" class="report btn-popup flag" id="budz_review<?php echo $review->id; ?>" <?php
                                                                                            if (count($review->reports) == 0) {
                                                                                                echo 'style="display: block"';
                                                                                            } else {
                                                                                                echo 'style="display: none"';
                                                                                            }
                                                                                            ?>>
                                                                                                <i class="fa fa-flag" aria-hidden="true"></i> 
                                                                                                <span>Report</span>
                                                                                            </a>
                                                                                        </div>
                                                                                    <?php } ?>
                                                                                    <input type="hidden" value="<?= $review->id; ?>" id="strain_review_id">


                                                                                    <div class="sort-item">
                                                                                        <a class="white flag report btn-popup" href="#budz-review-<?= $review->id ?>">
                                                                                            <i class="fa fa-share-alt" aria-hidden="true"></i><span>Share</span>
                                                                                        </a>
                                                                                    </div>

                                                                                </div>
                                                                            </span>
                                                                            <span class="time"><?php echo $newDate = timeZoneConversion($review->created_at, 'jS M Y', \Request::ip()); ?></span>
                                                                        </div>
                                                                        <p><?php echo $review->text; ?></p>
                                                                        <div class="videos">
                                                                            <?php foreach ($review->attachments as $key => $attachment) { ?>
                                                                                <?php if ($attachment->type == 'image') { ?>
                                                                                    <?php $budz_sing_img = image_fix_orientation('public/images' . $attachment->attachment); ?>
                                                                                    <a href="<?php echo asset($budz_sing_img) ?>" class="" data-fancybox="gallery<?= $review->attachment->id ?>" >
                                                                                        <div class="ans-slide-image" style="background-image: url(<?php echo asset($budz_sing_img) ?>)"></div>
                                                                                    </a>
                                                                                    <!--<img src="<?php // echo asset('public/images' . $attachment->attachment);     ?>" alt="image"/>-->
                                                                                <?php } else { ?>
                                                                                    <?php $budz_sing_post = 'public/images' . $review->attachment->poster ?>
                                                                                    <a href="#vids-<?= $review->attachment->id ?>" data-fancybox="gallery<?= $review->attachment->id ?>" >
                                                                                        <div class="ans-slide-image" style="background-image: url(<?php echo asset($budz_sing_post) ?>)">
                                                                                            <i class="fa fa-play-circle" aria-hidden="true"></i>
                                                                                        </div>
                                                                                    </a>
                                                                                    <video width="320" height="240" poster="<?php echo asset('public/images' . $attachment->poster); ?>" controls="" id="vids-<?= $review->attachment->id ?>" style="display: none;">
                                                                                        <source src="<?php echo asset('public/videos' . $attachment->attachment); ?>">
                                                                                        Your browser does not support the video tag.
                                                                                    </video>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        </div>

                                                                        <?php if (Auth::user() && $review->reviewed_by != $current_id) { ?>
                                                                            <div class="stain-leaf right thumb-rev-right"> <div class="StainLeafWithThumb">
                                                                                    <div class="adjust-thmb">

                                                                                        <i  id="add_budz_review_like_<?= $review->id ?>" onclick="addremovelike('<?= $review->id ?>', '<?= $review->sub_user_id ?>', '1')" <?php if ($review->isReviewed) { ?> style="display: none; " <?php } else { ?> style="cursor: pointer" <?php } ?> class="fa fa-thumbs-up pink_thumb"></i>
                                                                                        <i  id="remove_budz_review_like_<?= $review->id ?>" onclick="addremovelike('<?= $review->id ?>', '<?= $review->sub_user_id ?>', '0')" <?php if (!$review->isReviewed) { ?> style="display: none;" <?php } else { ?> style="cursor: pointer" <?php } ?>class="fa fa-thumbs-up pink_thumb active"></i>
                                                                                        <span style="color: #af5caf;" id="reviews_count_<?= $review->id ?>"><?= $review->likes->count() ?></span>
                                                                                    </div>
                                                                                <?php } ?>
                                                                                <span class="t-star">
                                                                                    <i class="fa fa-star<?= $review->rating == 0 ? '-o' : '' ?>"></i> <?php echo number_format((float) $review->rating, 0, '.', ''); ?>
                                                                                </span>
                                                                                <?php if (Auth::user() && $review->reviewed_by != $current_id) { ?>
                                                                                </div></div>
                                                                        <?php } ?>
                                                                        <div class="art-reply">
                                                                            <?php if ($review->reply) { ?>
                                                                                <h4>Reply</h4>
                                                                                <span class="time"> <em><?php echo timeago($review->reply->created_at); ?></em></span>
                                                                                <?php if ($review->reply->user_id == $current_id) { ?>
                                                                                    <div class="art-bottom">
                                                                                        <div class="new_custom_links">
                                                                                            <a href="<?php echo asset('edit-budzmap-review-reply/' . $review->id . '/' . $_GET['business_id'] . '/' . $_GET['business_type_id']) ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                                                            <a href="" class="btn-popup">
                                                                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                                                            </a>
                                                                                            <!-- Modal -->
                                                                                            <div id="" class="popup">
                                                                                                <div class="popup-holder">
                                                                                                    <div class="popup-area">
                                                                                                        <div class="text">
                                                                                                            <div class="edit-holder">
                                                                                                                <div class="step">
                                                                                                                    <div class="step-header">
                                                                                                                        <h4>Delete Bud Review</h4>
                                                                                                                        <p class="yellow no-margin">Are you sure to delete this review.</p>
                                                                                                                    </div>
                                                                                                                    <a href="" class="btn-heal">yes</a>
                                                                                                                    <a href="#" class="btn-heal btn-close">No</a>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php } ?>
                                                                                <p><?php echo $review->reply->reply; ?></p>
                                                                            <?php } else if ($sub_user->user_id == $current_id) { ?>
                                                                                <h4>Reply</h4>
                                                                                <form method="post" action="<?php echo asset('add-budzmap-review-reply'); ?>" id="reply-form" >
                                                                                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                                                                    <input type="hidden" name="review_id" value="<?= $review->id ?>">
                                                                                    <div class="bus-txt-area">
                                                                                        <div class="label-in-com-rev">
                                                                                            <textarea name="reply" maxlength="500" placeholder="Type your reply here.." id="add_reply" required=""></textarea>
                                                                                            <strong>0/<span class="reply-chars-counter">500 Characters</span></strong>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="bus-submit">

                                                                                        <input type="submit" value="Submit Reply" class="new_btn_submit">
                                                                                    </div>
                                                                                </form>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--Delete Modal-->
                                                            <div id="delete_budz_review<?php echo $review->id; ?>" class="popup">
                                                                <div class="popup-holder">
                                                                    <div class="popup-area">
                                                                        <div class="text">
                                                                            <div class="edit-holder">
                                                                                <div class="step">
                                                                                    <div class="step-header">
                                                                                        <h4>Delete Bud Review</h4>
                                                                                        <p class="yellow no-margin">Are you sure to delete this review.</p>
                                                                                    </div>
                                                                                    <a href="<?php echo asset('delete-budmap-review/' . $review->id . '/' . $_GET['business_id'] . '/' . $_GET['business_type_id']); ?>" class="btn-heal">yes</a>
                                                                                    <a href="#" class="btn-heal btn-close">No</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--Share Model-->
                                                            <div id="budz-review-<?php echo $review->id; ?>" class="popup">
                                                                <div class="popup-holder">
                                                                    <div class="popup-area">
                                                                        <div class="reporting-form">
                                                                            <h2>Select an option</h2>
                                                                            <div class="custom-shares">
                                                                                <?php
                                                                                $url_to_share = urlencode(asset("get-budz?business_id=" . $sub_user->id . "&business_type_id=" . $sub_user->business_type_id));
                                                                                echo Share::page($url_to_share, $review->review, ['class' => 'budz_review_class', 'id' => $review->id])
                                                                                        ->facebook($review->review)
                                                                                        ->twitter($review->review)
                                                                                        ->googlePlus($review->review);
                                                                                ?>
                                                                                <?php if (Auth::user()) { ?>
                                                                                    <div class="budz_review_class in_app_button" onclick="shareInapp('<?= asset("get-budz?business_id=" . $sub_user->id . "&business_type_id=" . $sub_user->business_type_id) ?>', '<?php echo trim(revertTagSpace($sub_user->title)); ?>', '<?= asset('userassets/images/logo-for-scrap.png') ?>')"> <span class="hb_icon_repost"></span> In App</div>
                                                                                <?php } ?>
                                                                            </div>
                                                                            <a href="javascript:void(0)" class="btn-close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </article>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php // if ($budz->get_user_review_count == 0 && $current_id != $sub_user->user_id) {  ?>
                            <?php if (Auth::user() && $user_review_count == 0 && $current_id != $sub_user->user_id) { ?>
                                <form id="comment-form" method="post" action="<?php echo asset('add-budzmap-review'); ?>" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                    <input type="hidden" name="sub_user_id" value="<?= $id ?>">
                                    <div class="bus-txt-area">
                                        <h4>Add Your Comments Below</h4>
                                        <?php
                                        if ($errors->has('comment')) {
                                            echo $errors->first('comment');
                                        }
                                        ?>
                                        <textarea name="comment" maxlength="500" placeholder="Type your comments here" id="addcoment" required=""></textarea>
                                        <span class="chars-counter">Max. 500 Characters</span>
                                    </div>
                                    <div class="bus-upload">
                                        <label for="test">
                                            <input type="file" name="pic" id="test" accept="video/*,  video/x-m4v, video/webm, video/x-ms-wmv, video/x-msvideo, video/3gpp, video/flv, video/x-flv, video/mp4, video/quicktime, video/mpeg, video/ogv, .ts, .mkv, image/*"/>
                                            <span>Upload</span>
                                        </label>
                                        <span class="res">
                                            Add An image or video
                                            <span>(1 PHOTO OR 20  SEC VIDEO MAX.)</span>
                                        </span>
                                    </div>
                                    <div class="bus-pap rev-img-vid-set">
                                        <!--<i class="fa fa-paperclip"></i>-->
                                        <!--<img src="<?php // echo asset('userassets/images/img2.png') ?>" alt="image" id="budz_review_image"/>-->
                                        <figure style="background-image:url('<?php echo asset('userassets/images/img2.png') ?>'); display: none;" id="budz_review_image" /></figure>
                                        <video class="video-use" class="video" src="" id="video"></video >
                                        <span id="span_text">image.jpg</span>
                                        <i class="fa fa-close"></i>
                                    </div>
                                    <div class="bus-rating">
                                        <h4>Add Your Rating:</h4>
                                        <?php
                                        if ($errors->has('rating')) {
                                            echo $errors->first('rating');
                                        }
                                        ?>
                                        <input type="hidden" name="rating" id="review_rating" value="5">
                                        <div class="budz_review_rating" ></div>
                                    </div>
                                    <div class="bus-submit">
                                        <input onclick="checkRating()" type="button" value="SUBMIT COMMENT" />
                                    </div>
                                </form>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="right_sidebars">
                        <?php if (Auth::user()) {
                            include 'includes/rightsidebar.php';
                            ?>
                            <?php include 'includes/chat-rightsidebar.php';
                        }
                        ?>
                    </div>
                </div>
            </article>
        </div>
<?php include('includes/footer-new.php'); ?>
    </body>
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
        var win = $(window);
        var business_id = <?= $id; ?>;
        var business_type_id = <?= $_GET['business_type_id']; ?>;
        var count = 1;
        var ajaxcall = 1;
        win.on('scroll', function () {
            var docheight = parseInt($(document).height());
            var winheight = parseInt(win.height());
            var differnce = (docheight - winheight) - win.scrollTop();
            if (differnce < 100) {
                if (ajaxcall === 1) {
                    $('#loading').show();
                    ajaxcall = 0;
                    $.ajax({
                        url: "<?php echo asset('get-budz-map-review-loader') ?>",
                        type: "GET",
                        data: {
                            "count": count,
                            "business_id": business_id,
                            "business_type_id": business_type_id,
                            "user_review_count": <?php echo $user_review_count; ?>
                        },
                        success: function (data) {
                            if (data) {
                                var a = parseInt(1);
                                var b = parseInt(count);
                                count = b + a;
                                $('#review_listing').append(data);
                                $('#loading').hide();
                                ajaxcall = 1;
                            } else {
                                noposts = ' <div class="loader hb_not_more_posts_lbl" id="nomoreposts">No More Reviews To Show</div> ';
                                $('#review_listing').append(noposts);
                            }
                        }
                    });
                }
                $('#loading').hide();
            }
        });

        function reportBudzReview(reviewId) {
            $.ajax({
                url: "<?php echo asset('report-budz-review') ?>",
                type: "POST",
                data: {"review_id": reviewId, "_token": "<?php echo csrf_token(); ?>"},
                success: function (response) {
                    if (response.status == 'success') {
                        $('#budz_review' + reviewId).hide();
                        $('#budz_review_reported' + reviewId).show();
                    }
                }
            });
        }
        function focus_textarea() {
            $('#addcoment').focus();
        }
        $(document).ready(function () {

            $(".budz_review_rating").starRating({
                totalStars: 5,
                emptyColor: '#1e1e1e',
                hoverColor: '#e070e0',
                activeColor: '#e070e0',
                strokeColor: "#e070e0",
                strokeWidth: 20,
                useGradient: false,
                disableAfterRate: false,
                useFullStars: true,
                initialRating: 5,
                callback: function (currentRating, $el) {
                    $('input[type=hidden]#review_rating').val(currentRating);
                }
            });

            var textarea = $("#addcoment");
            textarea.keyup(function (event) {
                var numbOfchars = textarea.val();
                var len = numbOfchars.length;
                var show = (500 - len);
                $(".chars-counter").text(show + ' Characters Remaining');
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
//                alert('Please upload file having extensions .jpeg/.jpg/.png/.gif/.mp4|\.mkv|\.mov|\.flv|\.mpeg|\.webm|\.mpeg|\.avi|\.ts|\.ogv  only.');
                $('#erroralertmessage').html('Please upload file having extensions .jpeg/.jpg/.png/.gif/.mp4  only.');
                $('#erroralert').show();
                $('#test').val('');
                return false;
            }
        }

        $("#test").change(function () {
            var fileInput = document.getElementById('test');
            var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
            var image_type = fileInput.files[0].type;
            if (image_type == "image/png" || image_type == "image/jpeg" || image_type == "image/gif" || image_type == "image/bmp" || image_type == "image/jpg") {
                $("#video").attr("src", '');
                $(".bus-pap").show();
//                $(".bus-pap img").attr("src", fileUrl);
                $(".bus-pap #budz_review_image").attr("style", "background-image:url('"+fileUrl+"')");
//                $(".bus-pap img").show();
                $(".bus-pap #budz_review_image").show();
                $(".video-use").hide();
                $(".bus-pap i.fa-close").show();
            } else if (fileInput.files[0].type == "video/mp4") {
//                $("#budz_review_image").attr("src", '');
                $("#budz_review_image").hide();
                $("#span_text").hide();
                $(".bus-pap").show();
                $(".bus-pap i.fa-close").show();
                $(".video-use").show();
                $(".bus-pap img").hide();
                $("#video").attr("src", fileUrl);
                var myVid = document.getElementById("video");
                setTimeout(function () {
                    var duration = myVid.duration.toFixed(2);
                    if (duration > 200) {
                        $('#erroralertmessage').html('Video is greater than 20 sec.');
                        $('#erroralert').show();
                        $("#video").attr("src", '');
                    }
                }, 3000);
            }
        });
        $(".bus-pap i.fa-close").click(function () {
            $(".bus-pap").hide();
            $("#video").attr("src", '');
//            $("#budz_review_image").attr("src", '');
            $("#budz_review_image").attr("style", "background-image:url('')");
        });

        $('.budz_review_class').unbind().click(function () {
            count = 0;

            if (count === 0) {
                count = 1;
                id = this.id;
                $('#budz-review-' + id).fadeOut();

                $.ajax({
                    url: "<?php echo asset('add_question_share_points') ?>",
                    type: "GET",
                    data: {
                        "id": id, "type": "Budz Reviews"
                    },
                    success: function (data) {
                        count = 0;
                    }
                });
            }
        });
        function addremovelike(review_id, budz_id, like_val) {
            var current_likes = $('#reviews_count_' + review_id).html();
            if (like_val == 1) {
                $('#add_budz_review_like_' + review_id).hide();
                $('#remove_budz_review_like_' + review_id).show().css({
                    'cursor': 'pointer'
                });
                $('#reviews_count_' + review_id).html(parseInt(current_likes) + parseInt(1));
            } else {
                $('#remove_budz_review_like_' + review_id).hide();
                $('#add_budz_review_like_' + review_id).show().css({
                    'cursor': 'pointer'
                });
                $('#reviews_count_' + review_id).html(parseInt(current_likes) - parseInt(1));
            }
            $.ajax({
                type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                url: '<?php echo asset('add-budz-review-like'); ?>', // the url where we want to POST
                data: {review_id: review_id, budz_id: budz_id, like_val: like_val, "_token": '<?= csrf_token() ?>'}, // our data object
                success: function (response) {
                }
            });
//   
//   
        }
    </script>
</html>