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
                        <div class="ask-area">
                            <div class="tabbing">
                                <div id="tab-content">
                                    <div id="strain-overview" class="tab active">
                                        <div class="tab-wid" id="reviews-section">
                                            <header class="header">
                                                <div class="rev-sec-row rev-sec-row-st">
                                                <!--<a href="#" class="btn-comment"><i class="fa fa-comment-o" aria-hidden="true"></i> Add Comment</a>-->
                                                    <h4>(<?= $reviews_count; ?>) Reviews</h4>
                                                </div>
                                            </header>
                                            <ul class="reviews-list list-none" id="review_listing">
                                                <?php $user_review_count = 0; ?>
                                                <?php foreach ($reviews as $review) { ?>
                                                    <?php
                                                    if ($review->reviewed_by == $current_id) {
                                                        $user_review_count ++;
                                                    }
                                                    ?>
                                                    <li>
                                                        <div class="icon pre-main-image">
                                                            <img src="<?php echo getImage($review->getUser->image_path, $review->getUser->avatar) ?>" alt="Image" class="img-responsive">
                                                            <?php if ($review->getUser->special_icon) { ?>
                                                                <span class="fest-pre-img" style="background-image: url(<?php echo asset('public/images' . $review->getUser->special_icon) ?>);"></span>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="txt">
                                                            <div class="center-div">
                                                                <header class="header">
                                                                    <strong><a class="<?= getRatingClass($review->getUser->points) ?>"  href="<?= asset('user-profile-detail/' . $review->getUser->id) ?>"><?= $review->getUser->first_name; ?></a></strong>
                                                                    <span class="date"><?php //echo date("jS M Y", strtotime($review->created_at));    ?></span>
                                                                    <span class="dot-options">
                                                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                                        <div class="sort-drop">
                                                                            <?php if ($review->reviewed_by == $current_id) { ?>
                                                                                <div class="sort-item">
                                                                                    <a class="white flag report" href="<?php echo asset('edit-strain-review/' . $review->id . '/' . $review->strain_id) ?>">
                                                                                        <i class="fa fa-pencil" aria-hidden="true"></i><span>Edit Review</span>
                                                                                    </a>
                                                                                </div>
                                                                                <div class="sort-item">
                                                                                    <a class="white flag report btn-popup" href="#delete_strain_review-<?php echo $review->id; ?>">
                                                                                        <i class="fa fa-trash" aria-hidden="true"></i><span>Delete</span>
                                                                                    </a>
                                                                                </div>
                                                                            <?php } ?>
                                                                            <?php if ($review->reviewed_by != $current_id && Auth::user()) { ?> 
                                                                                <div class="sort-item active">

                                                                                    <a <?php if (count($review->flags) == 0) { ?> style="display: block"<?php } ?> class="right report report-abuse btn-popup no-margin" href="#strain-review-flag<?= $review->id ?>">
                                                                                        <i class="fa fa-flag" aria-hidden="true"></i> 
                                                                                        <span>Report</span>
                                                                                    </a>
                                                                                    <input type="hidden" value="<?= $review->id; ?>" id="strain_review_id">

                                                                                    <a <?php if (count($review->flags) > 0) { ?> style="display: block"<?php } ?> class="right report-abuse no-margin active">
                                                                                        <i class="fa fa-flag" aria-hidden="true"></i> 
                                                                                        <span>Reported</span>
                                                                                    </a>

                                                                                </div>
                                                                            <?php } ?>
                                                                            <div class="sort-item">
                                                                                <a class="white flag report btn-popup" href="#strain-share-review-abc<?= $review->id ?>">
                                                                                    <i class="fa fa-share-alt" aria-hidden="true"></i><span>Share</span>
                                                                                </a>
                                                                            </div>

                                                                        </div>
                                                                    </span>
                                                                    <span class="date"><?php echo timeago($review->created_at); //timeZoneConversion($review->created_at, 'jS M Y', \Request::ip());   ?></span>
                                                                </header>
                                                                <p><?= $review->review; ?></p>
                                                                <div class="videos">
                                                                    <?php if ($review->attachment) { ?>
                                                                        <?php if ($review->attachment->type == 'image') { ?>
                                                                            <div class="">
                                                                                <?php $strain_sing_img = image_fix_orientation('public/images' . $review->attachment->attachment); ?>
                                                                                <a href="<?php echo asset($strain_sing_img) ?>" class="" data-fancybox="gallery<?= $review->attachment->id ?>" >
                                                                                    <div class="ans-slide-image" style="background-image: url(<?php echo asset($strain_sing_img) ?>)"></div>
                                                                                </a>
                                                                                <!--<img src="<?php // echo asset('public/images' . $review->attachment->attachment)  ?>" alt="Image" class="img-responsive">-->
                                                                            </div>
                                                                        <?php } else { ?>
                                                                            <?php $strain_sing_post = 'public/images' . $review->attachment->poster ?>
                                                                            <a href="#vids-<?= $review->attachment->id ?>" data-fancybox="gallery<?= $review->attachment->id ?>" >
                                                                                <div class="ans-slide-image" style="background-image: url(<?php echo asset($strain_sing_post) ?>)">
                                                                                    <i class="fa fa-play-circle" aria-hidden="true"></i>
                                                                                </div>
                                                                            </a>
                                                                            <video width="320" height="240" poster="<?php echo asset('public/images' . $review->attachment->poster); ?>" controls="" id='vids-<?= $review->attachment->id ?>' style="display: none;">
                                                                                <source src="<?php echo asset('public/videos' . $review->attachment->attachment); ?>">
                                                                                Your browser does not support the video tag.
                                                                            </video>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                </div>
                                                                <?php if (Auth::user()) { ?>  
                                                                    <!--<div class="StainLeafWithThumb">-->
                                                                    <div class="stain-leaf right thumb-rev-right">
                                                                        <div class="StainLeafWithThumb">
                                                                        <div class="adjust-thmb">
                                                                               <i  id="add_strain_review_like_<?= $review->id ?>" onclick="addremovelike('<?= $review->id ?>', '<?= $review->strain_id ?>', '1')" <?php if ($review->isReviewed) { ?> style="display: none; " <?php } else { ?> style="cursor: pointer" <?php } ?> class="fa fa-thumbs-up yellow_thumb"></i>
                                                                                <i  id="remove_strain_review_like_<?= $review->id ?>" onclick="addremovelike('<?= $review->id ?>', '<?= $review->strain_id ?>', '0')" <?php if (!$review->isReviewed) { ?> style="display: none;" <?php } else { ?> style="cursor: pointer" <?php } ?>class="fa fa-thumbs-up yellow_thumb active"></i>
                                                                                <span id="reviews_count_<?= $review->id ?>"><?= $review->likes->count()?></span>
                                                                            </div>
                                                                            <?php if(isset($review->rating->rating)){ ?>
                                                                             <div>
                                                                        <img src="<?php echo asset('userassets/images/leaf-' . floorToFraction(number_format((float) $review->rating->rating, 1, '.', ''), 2) . '.svg') ?>" alt="Image" class="img-responsive">
                                                                        <em><?= number_format((float) $review->rating->rating, 0, '.', ''); ?></em>
                                                                            </div><?php } ?></div>  </div>  
                                                                <?php } ?>

                                                            </div>
                                                        </div>

                                                        <div id="strain-review-flag<?= $review->id ?>" class="popup">
                                                            <div class="popup-holder">
                                                                <div class="popup-area">
                                                                    <form action="<?php echo asset('flag_strain_review'); ?>" class="reporting-form" method="post">
                                                                        <input type="hidden" value="<?php echo $review->id; ?>" name="strain_review_id">
                                                                        <input type="hidden" value="<?php echo $review->strain_id; ?>" name="strain_id">

                                                                        <input type="hidden" value="<?php echo csrf_token(); ?>" name="_token">
                                                                        <fieldset>
                                                                            <h2>Reason For Reporting</h2>
                                                                            
                                                                            <input type="radio" name="group" id="sexual<?= $review->id ?>" checked value="Nudity or sexual content">
                            <label for="sexual<?= $review->id ?>">Nudity or sexual content</label>

                            <input type="radio" name="group" id="harasssment<?= $review->id ?>"  value="Harassment or hate speech">
                            <label for="harasssment<?= $review->id ?>">Harassment or hate speech</label>

                            <input type="radio" name="group" id="threatening<?= $review->id ?>"  value="Threatening, violent, or concerning">
                            <label for="threatening<?= $review->id ?>">Threatening, violent, or concerning</label>
                            
                                                                            <input type="radio" name="group" id="abused<?= $review->id ?>"  value="offensive">
                                                                            <label for="abused<?= $review->id ?>">Strain review is offensive</label>
                                                                            <input type="radio" name="group" id="spam<?= $review->id ?>" value="Spam">
                                                                            <label for="spam<?= $review->id ?>">Spam</label>
                                                                            <input type="radio" name="group" id="unrelated<?= $review->id ?>" value="Unrelated">
                                                                            <label for="unrelated<?= $review->id ?>">Unrelated</label>
                                                                            <input type="submit" class="blue" value="Report strain review">
                                                                            <a href="#" class="btn-close">x</a>
                                                                        </fieldset>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Share Strain Review Popup -->
                                                        <div id="strain-share-review-abc<?= $review->id; ?>" class="popup">
                                                            <div class="popup-holder">
                                                                <div class="popup-area">
                                                                    <div class="reporting-form">
                                                                        <h2>Select an option</h2>
                                                                        <div class="custom-shares">
                                                                            <?php
                                                                            echo Share::page(asset('strain-details/' . $review->strain_id), $review->review, ['class' => 'strain_class', 'id' => $review->id])
                                                                                    ->facebook($review->review)
                                                                                    ->twitter($review->review)
                                                                                    ->googlePlus($review->review);
                                                                            ?>
                                                                            <?php if(Auth::user()){ ?>
                                                                            <div class="strain_class in_app_button" onclick="shareInapp('<?= asset('strain-details/' . $review->strain_id) ?>', '<?php echo trim(revertTagSpace($review->review)); ?>', '<?= asset('userassets/images/logo-for-scrap.png') ?>')"> <span class="hb_icon_repost"></span> In App</div>
                                                                            <?php } ?> </div>
                                                                        <a href="javascript:void(0)" class="btn-close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Share Strain Review Popup End -->
                                                        <!-- Delete Review Modal -->
                                                        <div id="delete_strain_review-<?php echo $review->id; ?>" class="popup">
                                                            <div class="popup-holder">
                                                                <div class="popup-area">
                                                                    <div class="text">
                                                                        <div class="edit-holder">
                                                                            <div class="step">
                                                                                <div class="step-header">
                                                                                    <h4>Delete Strain Review</h4>
                                                                                    <p class="yellow no-margin">Are you sure to delete this review.</p>
                                                                                </div>
                                                                                <a href="<?php echo asset('delete-strain-review/' . $review->id . '/' . $review->strain_id); ?>" class="btn-heal">yes</a>
                                                                                <a href="#" class="btn-heal btn-close">No</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Modal End-->
                                                    </li>
                                                <?php } ?>
                                            </ul>

                                            <div style="display: none" class="hb_simple_loader" id="loading"><img src="<?php echo asset('userassets/images/new_loadeer.svg') ?>" alt="Loading . . . ." class="post-loader"><span></span></div>
                                        </div>
                                        <?php if ($user_review_count == 0 && Auth::user()) { ?>
                                            <div class="tab-wid">
                                                <!--<strong class="title">Add Your Comment Below</strong>-->
                                                <form action="<?php echo asset('add_strain_review') ?>" class="comment-form" id="comment-form" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                    <input type="hidden" name="strain_id" value="<?= $strain_id; ?>">
                                                    <fieldset>
                                                        <div class="comment-ratings">
                                                            <strong class="title">Add Your Rating:</strong>
                                                            <fieldset class="rate">
                                                                <input  type="radio" id="rating1" name="rating" value="1">
                                                                <label class="rate-one" for="rating1" title="1">
                                                                    <img src="<?php echo asset('userassets/images/leaf-1.svg') ?>" alt="Favorites">
                                                                </label>
                                                                <input type="radio" id="rating2" name="rating" value="2">
                                                                <label class="rate-two" for="rating2" title="2">
                                                                    <img src="<?php echo asset('userassets/images/leaf-2.svg') ?>" alt="Favorites">
                                                                </label>
                                                                <input type="radio" id="rating3" name="rating" value="3">
                                                                <label class="rate-three" for="rating3" title="3">
                                                                    <img src="<?php echo asset('userassets/images/leaf-3.svg') ?>" alt="Favorites">
                                                                </label>
                                                                <input type="radio" id="rating4" name="rating" value="4">
                                                                <label class="rate-four" for="rating4" title="4">
                                                                    <img src="<?php echo asset('userassets/images/leaf-4.svg') ?>" alt="Favorites">
                                                                </label>
                                                                <input type="radio" id="rating5" name="rating" value="5" checked="">
                                                                <label class="rate-five" for="rating5" title="5">
                                                                    <img src="<?php echo asset('userassets/images/leaf-5.svg') ?>" alt="Favorites">
                                                                </label>
                                                            </fieldset>
                                                        </div>
                                                        <div class="label-in-com-rev">
                                                            <textarea name="review" placeholder="Your review comment here..." required=""></textarea>
                                                            <?php
                                                            if ($errors->has('review')) {
                                                                echo $errors->first('review');
                                                            }
                                                            ?>
                                                            <strong>0/<span class="msg-note">500 Characters</span></strong>
                                                        </div>
                                                        <div class="strain-comment"><input type="submit" value="Post Review"></div>
                                                        <div class="upload-file">
                                                            <!-- <input type="file" id="author-image" name="image"> -->
                                                            <input id="review_file" name="attachment" type="file" accept="video/*,  video/x-m4v, video/webm, video/x-ms-wmv, video/x-msvideo, video/3gpp, video/flv, video/x-flv, video/mp4, video/quicktime, video/mpeg, video/ogv, .ts, .mkv, image/*">
                                                            <label for="review_file">
                                                                <span>Add An image or video<em>(1 photo or 20 sec video max.)</em></span>
                                                            </label>
                                                        </div>
                                                        <div class="strain-attachment">
                                                            <!--<i class="fa fa-paperclip"></i>-->
                                                            <!--<img src="<?php // echo asset('userassets/images/img2.png') ?>" alt="image" id="strain_review_image" />-->
                                                            <figure style="background-image:url('<?php echo asset('userassets/images/img2.png') ?>'); display: none;" id="strain_review_image" /></figure>
                                                            <video class="video-use" class="video" src="" id="video"></video>
                                                            <!--<span>image.jpg</span>-->
                                                            <i class="fa fa-close"></i>
                                                        </div>

                                                    </fieldset>
                                                </form>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="right_sidebars">
                        <?php if (Auth::user()) {
                            include 'includes/rightsidebar.php'; ?>
    <?php include 'includes/chat-rightsidebar.php';
} ?>
                    </div>
                </div>
            </article>
        </div>
<?php include('includes/footer.php'); ?>

<!--        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>-->
        <script>

            var win = $(window);
            var strain_id = <?= $strain_id; ?>;
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
                            url: "<?php echo asset('get-strain-review-loader') ?>",
                            type: "GET",
                            data: {
                                "count": count,
                                "strain_id": strain_id,
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
                                    $('#loading').hide();
                                    noposts = ' <div class="loader" id="nomoreposts">No More Reviews To Show</div> ';
                                    $('#review_listing').append(noposts);
                                }
                            }
                        });
                    }

                }
            });

            $("#review_file").change(function () {
                var input = document.getElementById('review_file');
                var filePath = input.value;
                var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.mp4)$/i;
                if (!allowedExtensions.exec(filePath)) {
                    $('#erroralertmessage').html('Please upload file having extensions .jpeg/.jpg/.png/.gif/.mp4  only.');
                    $('#erroralert').show();
                    $('#review_file').val('');
                    return false;
                }
                var fileInput = document.getElementById('review_file');
                var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
                var image_type = fileInput.files[0].type;
               
                if (image_type == "image/png" || image_type == "image/gif" ||  image_type == "image/jpeg" || image_type == "image/bmp" || image_type == "image/jpg") {
                    $("#video").attr("src", '');
                    $(".strain-attachment").show();
                    $(".strain-attachment figure").attr("style", "background-image:url('"+fileUrl+"')");
//                            .attr("src", fileUrl);
                    $(".strain-attachment figure").show();
                    $(".video-use").hide();
                    $(".strain-attachment i.fa-close").show();
                } else if (fileInput.files[0].type == "video/mp4") {
                    $("#strain_review_image").attr("src", '');
                    $(".strain-attachment").show();
                    $(".strain-attachment i.fa-close").show();
                    $(".video-use").show();
//                    $(".strain-attachment img").hide();
                    $("#strain_review_image").hide();
                    $("#video").attr("src", fileUrl);
                    var myVideo = document.getElementById("video");
                    myVideo.addEventListener("loadedmetadata", function ()
                    {
                        duration = (Math.round(myVideo.duration * 100) / 100);
                        if (duration >= 21) {
                            $('#erroralertmessage').html('Video is greater than 20 sec.');
                            $('#erroralert').show();
                            $("#video").attr("src", '');
                            $(".strain-attachment").hide();
                        }
                    });
                }
            });
            $(".strain-attachment i.fa-close").click(function () {
                $(".strain-attachment").hide();
                $("#video").attr("src", '');
                $("#strain_review_image").attr("src", '');
            });

            $(document).ready(function () {

//                $("#comment-form").validate({
//                    rules: {
//                        review: {
//                            required: true
//                        }
//                    },
//                    messages: {
//                        review: {
//                            required: "Review Field is required."
//                        }
//                    }
//                });

                $('.strain_review_flag').click(function (e) {
                    var review = jQuery(this);
                    var review_id = review.find('input').val();
                    $.ajax({
                        url: "<?php echo asset('flag_strain_review') ?>",
                        type: "POST",
                        data: {"strain_id": '<?= $strain_id; ?>', "strain_review_id": review_id, "_token": "<?php echo csrf_token(); ?>"},
                        success: function (response) {
                            if (response.status == 'success') {
                                review.addClass('report-abuse');
                            }
                        }
                    });
                });

                $('#gal-img').on('change', function () {
                    $("#upload_image").submit();
                });
            });
            $('.strain_class').unbind().click(function () {
                count = 0;

                if (count === 0) {
                    count = 1;
                    id = this.id;
                    $('#strain-share-review-abc' + id).fadeOut();
                    $.ajax({
                        url: "<?php echo asset('add_question_share_points') ?>",
                        type: "GET",
                        data: {
                            "id": id, "type": "Strain"
                        },
                        success: function (data) {
                            count = 0;
                        }
                    });
                }
            });
            function addremovelike(review_id, strain_id, like_val) {
            var current_likes=$('#reviews_count_'+review_id).html();
                if (like_val == 1) {
                    $('#add_strain_review_like_' + review_id).hide();
                    $('#remove_strain_review_like_' + review_id).show().css({
                        'cursor': 'pointer'
                    });
                    $('#reviews_count_'+review_id).html(parseInt(current_likes) + parseInt(1));
                } else {
                    $('#remove_strain_review_like_' + review_id).hide();
                    $('#add_strain_review_like_' + review_id).show().css({
                        'cursor': 'pointer'
                    });
                    $('#reviews_count_'+review_id).html(parseInt(current_likes) - parseInt(1));
                }
                $.ajax({
                    type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
                    url: '<?php echo asset('add-like-strain-review'); ?>', // the url where we want to POST
                    data: {review_id: review_id, strain_id: strain_id, like_val: like_val}, // our data object
                    success: function (response) {
                    }
                });
//   
//   
            }
        </script>
    </body>
</html>