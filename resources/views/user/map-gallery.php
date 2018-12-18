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
                    <div class="head-map-info head-map-gallery">
                        <ul class="list-none">
                            <li class="li-icon li-text"><?php //echo $budz->title; ?> Gallery</li>
                            <li class="li-icon li-add">
                                <form onsubmit="return checkImgae()" id="budzgalleryimage" action="<?php echo asset('add-sub-user-image'); ?>" method="post" enctype="multipart/form-data">
                                    <label for="addIcon">
                                        <input type="hidden" name="id" value="<?= $id ?>">
                                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                        <?php if ($budz->user_id == $current_id) { ?>
                                            <input accept="image/*" type="file" id="addIcon" name="image" onchange="saveBudzGalleryImage()"/>
                                            <span><i class="fa fa-upload"></i></span>                                 
                                        <?php } ?>

                                    </label>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="bud-map-info-top bud-map-gal-top">
                    <form onsubmit="return checkImgae()" id="budzgalleryimage" action="<?php echo asset('add-sub-user-image'); ?>" method="post" enctype="multipart/form-data" class="gallery_uploader_form">
                            <label for="addIcon">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                            <?php if ($budz->user_id == $current_id) { ?>
                                <input accept="image/*" type="file" id="addIcon" name="image" onchange="saveBudzGalleryImage()" multiple>
                                <span><i class="fa fa-upload"></i></span>                                 
                            <?php } ?>

                        </label>
                    </form> 
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
                        </div>
                    </article>
                </div>
                <div class="container">
                    <div class="bud-map-gal-bot">
                        <?php if(count($images) > 0){ foreach ($images as $image) { ?>
                            <div class="cus-col">
                                <figure>
                                    <a href="<?php echo asset('budz-gallery-detail/' . $id.'/'.$image->id); ?>" style="background-image: url(<?php echo asset('public/images' . $image->image) ?>);"></a>
                                </figure>
                            </div>
                        <?php }}else { ?>
                        <?php } ?>
                    </div>

                </div>
            </article>
        </div>
    </div>
    <?php include('includes/footer-new.php'); ?>
    <?php include('includes/functions.php'); ?>
</body>
<script>
    function focus_textarea() {
        $('#addcoment').focus();
    }
    $(document).ready(function () {
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
        $("#video").attr("src", fileUrl);
        var myVid = document.getElementById("video");
        setTimeout(function () {
            var duration = myVid.duration.toFixed(2);
            if (duration > 30) {
                alert('No No No');
                $("#video").attr("src", '');
            }
        }, 3000);
    });
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

    function checkImgae() {
        var input = document.getElementById('addIcon');
        var filePath = input.value;
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
        if (!allowedExtensions.exec(filePath)) {
            alert('Please upload file having extensions .jpeg/.jpg/.png/.gif  only.');

            return false;
        } else {
            return true;
        }
    }
</script>
</html>