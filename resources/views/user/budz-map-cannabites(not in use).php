<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); ?>
    <body>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php // include('includes/header-maps-info.php'); ?>
                <?php include('includes/header.php'); ?>
                <div class="head-top">
                    <div class="head-map-info">
                        <ul class="list-none">
                        </ul>
                        <ul class="btns list-none">
                            <?php if ($current_id != $budz->user_id) { ?>
                                <li onclick="saveBudzMap('<?php echo $budz->id; ?>')" id="savebudzmap<?php echo $budz->id; ?>" <?php if ($budz->get_user_save_count) { ?> style="display: none" <?php } ?> class="li-icon li-heart">
                                    <a href="#" data-toggle="modal" data-target="#mapModal1"><i class="fa fa-heart-o"></i></a>
                                </li>
                                <li onclick="unSaveBudzMap('<?php echo $budz->id; ?>')" id="unsavebudzmap<?php echo $budz->id; ?>" <?php if (!$budz->get_user_save_count) { ?> style="display: none" <?php } ?>  class="li-icon li-heart">
                                    <a href="#"><i class="fa fa-heart"></i></a>
                                </li>
                            <?php } ?>
                            <li style="position: relative" class="li-icon "><a href="#" class="share-icon no-bg"><i class="fa fa-share-alt "></i></a>
                                <div class="custom-shares">
                                    <?php
                                    echo Share::page(asset('get-budz/' . $budz->id), $budz->title)
                                            ->facebook($budz->description)
                                            ->twitter($budz->description)
                                            ->googlePlus($budz->description);
                                    ?>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="bud-map-info-top" style="background-image: url('<?php echo getSubBanner($budz->banner, '') ?>');">
                    <figure class="map-info-logo">
                        <img src="<?php echo getSubImage($budz->logo, '') ?>" alt="logo">
                        <figcaption><?php echo $budz->title; ?></figcaption>
                    </figure>
                    <article>
                        <div class="art-top">
                            <!--<div class="rating-stars"></div>-->
                            <div class="budz_rating" data-rating="<?php if ($budz->ratingSum) echo $budz->ratingSum->total; ?>"></div>
                            <a href="#" class="review-link"><b><?php echo count($budz->review); ?></b> Reviews</a>
                        </div>
                        <div class="art-bot">
                            <div class="tab-cell">
                                <?php if ($current_id == $budz->user_id) { ?>
                                    <figure>
                                        <a href="<?php echo asset('budz-map-edit/' . $budz->id); ?>">
                                            <img src="<?php echo asset('userassets/images/bg-edit.svg') ?>" alt="icon">
                                        </a>
                                    </figure>
                                <?php } ?>
                            </div>
                            <?php if ($budz->is_organic) { ?>
                                <div class="tab-cell">
                                    <figure>
                                        <figcaption>Organic</figcaption>
                                        <img src="<?php echo asset('userassets/images/icon-plant.svg') ?>" alt="icon">
                                    </figure>
                                </div>
                            <?php } if ($budz->is_delivery) { ?>
                                <div class="tab-cell">
                                    <figure>
                                        <figcaption>We Deliver</figcaption>
                                        <img src="<?php echo asset('userassets/images/icon-van.svg') ?>" alt="icon">
                                    </figure>
                                </div>
                            <?php } ?>
                            <div class="tab-cell">
                                <figure>
                                    <a href="<?php echo asset('budz-gallary/' . $id); ?>"><img src="<?php echo asset('userassets/images/shout-photo.svg') ?>" alt="icon"></a>
                                </figure>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="bud-map-info-bot">
                    <div class="map-cus-tabs">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#business" class="bg-icon">Business Info</a></li>
                            <li><a data-toggle="tab" href="#product" class="bg-icon">Menu</a></li>
                            <li><a data-toggle="tab" href="#special" class="bg-icon">Specials</a></li>
                        </ul>
                        <div class="tab-content">
                            <?php include 'includes/budz-dispencery-info.php'; ?>
                            <div id="product" class="tab-pane">
                                <ul class="menu_lists list-none">
                                    <li>
                                        <strong>Appetizers</strong>
                                        <div class="menu-txt">
                                            <div class="right-txt">
                                                <div>
                                                    <img src="<?php echo asset('userassets/images/icon03.svg') ?>" alt="icon" class="small-leaf">
                                                    <a href="#"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                                                </div>
                                                <a href="#"><i class="fa fa-share-alt right-fa" aria-hidden="true"></i></a>
                                            </div>
                                            <div class="align-left">
                                                <img src="<?php echo asset('userassets/images/bgImage6.png') ?>" alt="icon">
                                                <div class="left-txt">
                                                    <strong>Pot Stickers</strong>
                                                    <span><sup>$</sup>8<sup>99</sup></span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <strong>Entrees</strong>
                                        <div class="menu-txt">
                                            <div class="right-txt">
                                                <div>
                                                </div>
                                                <a href="#"><i class="fa fa-share-alt right-fa" aria-hidden="true"></i></a>
                                            </div>
                                            <div class="align-left">
                                                <img src="<?php echo asset('userassets/images/bgImage6.png') ?>" alt="icon">
                                                <div class="left-txt">
                                                    <strong>Pot Stickers</strong>
                                                    <span><sup>$</sup>8<sup>99</sup></span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <strong>Samplings</strong>
                                        <div class="menu-txt">
                                            <div class="right-txt">
                                                <div>
                                                </div>
                                                <a href="#"><i class="fa fa-share-alt right-fa" aria-hidden="true"></i></a>
                                            </div>
                                            <div class="align-left">
                                                <img src="<?php echo asset('userassets/images/bgImage6.png') ?>" alt="icon">
                                                <div class="left-txt">
                                                    <strong>Pot Stickers</strong>
                                                    <span><sup>$</sup>8<sup>99</sup></span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <?php include 'includes/budz-special.php'; ?>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        <div id="mapModal1" class="modal fade map-small-mod" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Budz Adz Listing Saved</h2>
                    </div>
                    <div class="modal-body">
                        <p><img src="<?php echo asset('userassets/images/bg-success.svg') ?>" alt="icon">Business listings are saved in the app menu under My Saves</p>
                        <div class="check">
                            <input type="checkbox" id="checks">
                            <label for="checks">Got it! Do not show again for Business I like</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('includes/footer-new.php'); ?>
    </body>
    <script>
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
            $(".budz_rating").starRating({
                totalStars: 5,
                emptyColor: '#1e1e1e',
                hoverColor: '#e070e0',
                activeColor: '#e070e0',
                strokeColor: "#e070e0",
                strokeWidth: 20,
                useGradient: false,
                readOnly: true,
            });

            $(".budz_review_rating").starRating({
                totalStars: 5,
                emptyColor: '#1e1e1e',
                hoverColor: '#e070e0',
                activeColor: '#e070e0',
                strokeColor: "#e070e0",
                strokeWidth: 20,
                useGradient: false,
                disableAfterRate: false,
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
        $("#test").change(function () {
            var fileInput = document.getElementById('test');
            var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
            var image_type= fileInput.files[0].type;
            if (image_type == "image/png" || image_type == "image/jpeg" || image_type == "image/bmp" || image_type == "image/jpg") {
            $("#video").attr("src", '');    
            $(".bus-pap").show();
                $(".bus-pap img").attr("src", fileUrl);
                $(".bus-pap img").show();
                $(".video-use").hide();
                $(".bus-pap i.fa-close").show();
            } else if (fileInput.files[0].type == "video/mp4") {
                $("#budz_review_image").attr("src", '');
                $(".bus-pap").show();
                $(".bus-pap i.fa-close").show();
                $(".video-use").show();
                $(".bus-pap img").hide();
                $("#video").attr("src", fileUrl);
                var myVid = document.getElementById("video");
                setTimeout(function () {
                    var duration = myVid.duration.toFixed(2);
                    if (duration > 300) {
                        alert('No No No');
                        $("#video").attr("src", '');
                    }
                }, 3000);
            }
        });
        $(".bus-pap i.fa-close").click(function () {
            $(".bus-pap").hide();
            $("#video").attr("src", '');
            $("#budz_review_image").attr("src", '');
        });
    </script>
</html>