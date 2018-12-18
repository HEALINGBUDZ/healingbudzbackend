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
                            <li class="li-icon li-text"><?php echo $budz->title; ?> Gallery</li>
                            <li class="li-icon li-add">
                                <form id="budzgalleryimage" action="<?php echo asset('add-sub-user-image'); ?>" method="post" enctype="multipart/form-data">
                                <label for="addIcon">
                                    <input type="hidden" name="id" value="<?= $id ?>">
                                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                  <?php if($budz->user_id == $current_id) { ?>
                                    <input type="file" id="addIcon" name="image" onchange="saveBudzGalleryImage()"/>
                                  <?php } ?>
                                    <span><i class="fa fa-upload"></i></span>
                                </label>
                               </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="bud-map-info-top bud-map-gal-top">
                    <figure class="map-info-logo">
                        <img src="<?php echo getSubImage($budz->logo, '') ?>" alt="logo">
                        <figcaption><?php echo $budz->title; ?></figcaption>
                    </figure>
                    <article>
                        <div class="art-top">
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
                        <?php include('includes/map_slider.php'); ?>
                    </div>
                </div>
            </article>
        </div>
    </div>
    <?php include('includes/footer.php'); ?>
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
    function saveBudzGalleryImage(){
    $('#budzgalleryimage').submit();
    }
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
</script>
</html>