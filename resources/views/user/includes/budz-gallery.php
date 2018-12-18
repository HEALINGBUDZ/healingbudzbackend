<div id="gallery" class="tab-pane fade">
    <?php /*
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
    */?>
    <?php if ($budz->user_id == $current_id) { ?>
    <div class="gallery-upload-btn">
        <form onsubmit="return checkImgae()" id="budzgalleryimage" class="upload-form" action="<?php echo asset('add-sub-user-image'); ?>" method="post" enctype="multipart/form-data">
            <label for="addIcongallery">
                <input type="hidden" name="id" value="<?= $id ?>">
                <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                    <input accept="image/*" type="file" id="addIcongallery" name="image" onchange="saveBudzGalleryImage()"/>
                    <!--<span><i class="fa fa-upload"></i></span>-->                                 
                
                    <img src="<?php echo asset('userassets/images/gallery-big.png') ?>" alt="Gallery Icon" />
                    <span>Upload Photo</span>
            </label>
            <!--<label for="gal-img"><i class="fa fa-upload" aria-hidden="true"></i></label>-->
        </form>
    </div>
    <?php } ?>
<!--    <div class="bud-map-info-top bud-map-gal-top">
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
                <div class="rating-stars"></div>
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
    </div>-->
    <!--<div class="container">-->
        <div class="bud-map-gal-bot new-bud-gal-bt">
            <?php if(count($budz->getImages) > 0){ foreach ($budz->getImages as $image) { ?>
                <div class="cus-col">
                    <figure>
                    <?php  /*  <a data-fancybox="gallery" href="<?php echo asset('budz-gallery-detail/' . $id.'/'.$image->id); ?>" style="background-image: url(<?php echo asset('public/images' . $image->image) ?>);"></a> */ ?>
                        <?php $budzz_gallery_image = image_fix_orientation('public/images/' . $image->image); ?>
                        <a data-fancybox="gallery" href="<?php echo asset($budzz_gallery_image) ?>" style="background-image: url(<?php echo asset($budzz_gallery_image) ?>)">
                        </a>
                                            
                    </figure>
                </div>
            <?php }}else { ?>
            <?php } ?>
        </div>

    <!--</div>-->
</div>
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

    function checkImgae() {
        var input = document.getElementById('addIcongallery');
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

