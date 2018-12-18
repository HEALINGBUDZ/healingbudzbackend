<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top.php'); 

    ?>
    <body class="strain-gallery-fancy">
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <div class="new_container">
                        <div class="ask-area">
                            <?php include 'includes/strain-header.php'; ?>
                            <?php $strain_id = $strain->id; ?>
                            <div class="tabbing str-tb-up">
                                <ul class="tabs list-none">
                                    <li class="first"><a href="<?php echo asset('strain-details/' . $strain->id); ?>">Strain Overview</a></li>
                                    <li class="second"><a href="<?php echo asset('user-strains-listing/' . $strain->id); ?>">Strain Details</a></li>
                                    <!--<li class="third"><a href="#strain-overview">Gallery</a></li>-->
                                    <li class="active third"><a href="<?php echo asset('strain-gallery/' . $strain->id); ?>">Gallery</a></li>
                                    <?php if (Auth::user()) { ?>
                                        <li class="fourth"><a href="<?php echo asset('strain-product-listing/' . $strain->id); ?>">Locate This</a></li>
                                    <?php } else { ?>
                                        <li class="fourth"><a href="#loginModal" class="new_popup_opener">Locate This</a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="gallery-upload-btn">
                                <?php if (Auth::user()) { ?>
                                    <form action="<?php echo asset('upload_strain_image') ?>" class="upload-form" id="upload_image" method="POST" enctype="multipart/form-data">
                                        <input type="file" name="image" id="gal-img" accept="image/*">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                        <input type="hidden" name="strain_id" value="<?= $strain->id; ?>">
                                        <!--<label for="gal-img"><i class="fa fa-upload" aria-hidden="true"></i></label>-->
                                        <label for="gal-img">
                                            <img src="<?php echo asset('userassets/images/gallery-big.png') ?>" alt="Gallery Icon" />
                                            <span>Upload Photo</span>
                                        </label>
                                    </form>
                                <?php } else { ?>
                                    <form action="javascript:void(0)" class="upload-form" id="upload_image" method="POST" enctype="multipart/form-data">
                                    <!--<input type="file" name="image" id="gal-img" accept="image/*">-->
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                        <input type="hidden" name="strain_id" value="<?= $strain->id; ?>">
                                        <!--<label for="gal-img"><i class="fa fa-upload" aria-hidden="true"></i></label>-->
                                        <a href="#loginModal" class="new_popup_opener"><label for="gal-img">
                                                <img src="<?php echo asset('userassets/images/gallery-big.png') ?>" alt="Gallery Icon" />
                                                <span>Upload Photo</span>
                                            </label></a>
                                    </form>
                                <?php } ?>
                            </div>
                            <?php if (Session::has('success')) { ?>
        <h6 class="hb_simple_error_smg hb_text_green"><i class="fa fa-check" style="margin-right: 3px"></i> <?php echo Session::get('success'); ?></h6>
    <?php } ?>
                            <ul class="strain-gallery list-none">
                                <?php if (count($strain->getImages) > 0) {
                                        ?>
                                    <?php
                                    foreach ($strain->getImages as $image) {
                                        $flag_show = '';

                                        if (isset($image->getUser) && $current_id != $image->getUser->id) {
                                            $flag_show = '<li>
                                                                        <a ' . (($image->flagged) ? 'style="display: none"' : '') . '   id="strain_flag_' . $image->id . '" class="strain_flag_' . $image->id . ' white flag report btn-popup" href="#strain-image-flag' . $image->id . '" >
                                                                            <i class="fa fa-flag report btn-popup" aria-hidden="true"></i>
                                                                        </a>
                                                                        <a ' . ((!$image->flagged) ? 'style="display: none"' : '') . ' href="javascript:void(0)" id="strain_flag_revert_' . $image->id . '" class="strain_flag_revert_' . $image->id . ' white flag active">
                                                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                                                        </a>
                                                                    </li>';
                                        }
                                        if (!(isset($image->getUser))) {
                                            $flag_show = '<li>
                                                                        <a ' . (($image->flagged) ? 'style="display: none"' : '') . '   id="strain_flag_' . $image->id . '" class="strain_flag_' . $image->id . ' white flag report btn-popup" href="#strain-image-flag' . $image->id . '" >
                                                                            <i class="fa fa-flag report btn-popup" aria-hidden="true"></i>
                                                                        </a>
                                                                        <a ' . ((!$image->flagged) ? 'style="display: none"' : '') . ' href="javascript:void(0)" id="strain_flag_revert_' . $image->id . '" class="strain_flag_revert_' . $image->id . ' white flag active">
                                                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                                                        </a>
                                                                    </li>';
                                        }

                                        echo '<div style="display:none" class="caption_text caption_for_' . $image->id . '"><footer class="footer strain-popup-capt">
                                                            <div class="align-left">
                                                                <span>Photo Uploaded by:</span>';
                                        if ($image->getUser) {
                                            echo '<strong> <a class="' . getRatingClass($image->getUser->points) . '" href="' . asset('user-profile-detail/' . $image->getUser->id) . '">' . $image->getUser->first_name . '</a></strong>';
                                        } else {
                                            echo '<strong> Healing Budz </strong>';
                                        }
                                        echo '<span class="date"><i class="fa fa-calendar" aria-hidden="true"></i> ' . date("dS M Y", strtotime($image->created_at)) . '</span>
                                         </div><div class="align-right">';
                                        if (Auth::user()) {
                                            echo '<ul class="list-none">
                                                                    <li>
                                                                        <a ' . (($image->liked) ? 'style="display: none"' : '') . ' href="javascript:void(0)" id="strain_like_' . $image->id . '" class="strain_like_' . $image->id . ' white thumb " onclick="addRemoveLike(' . $image->id . ', 1)">
                                                                            <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                                                        </a>
                                                                        <a ' . ((!$image->liked) ? 'style="display: none"' : '') . ' href="javascript:void(0)" id="strain_like_revert_' . $image->id . '" class="strain_like_revert_' . $image->id . ' white thumb active" onclick="addRemoveLike(' . $image->id . ', 0)">
                                                                            <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                                                        </a>
                                                                        <span class="strain_like_count_' . $image->id . '" id="strain_like_count_' . $image->id . '">' . $image->likeCount->count() . '</span>
                                                                    </li>
                                                                    <li>
                                                                        <a ' . (($image->disliked) ? 'style="display: none"' : '' ) . ' href="javascript:void(0)" id="strain_dislike_' . $image->id . '" class="strain_dislike_' . $image->id . ' white thumb " onclick="addRemoveDisLike(' . $image->id . ', 1)">
                                                                            <i class="fa fa-thumbs-down" aria-hidden="true"></i>
                                                                        </a>
                                                                        <a ' . ((!$image->disliked) ? 'style="display: none"' : '') . ' href="javascript:void(0)" id="strain_dislike_revert_' . $image->id . '" class="strain_dislike_revert_' . $image->id . ' white thumb active" onclick="addRemoveDisLike(' . $image->id . ', 0)">
                                                                            <i class="fa fa-thumbs-down" aria-hidden="true"></i>
                                                                        </a>
                                                                        <span id="strain_dislike_count_' . $image->id . '" class="strain_dislike_count_' . $image->id . '">' . $image->disLikeCount->count() . '</span>
                                                                    </li>' . $flag_show . '
                                                                    
                                                                </ul>';
                                        } echo
                                        '<div>
                                         </footer></div>';
                                        ?>
                                <li style="padding:0;margin:10px;">
                                            <!--<a href="<?php // echo asset('strain-detail-gallery/'.$strain->id.'/'.$image->id);    ?>">-->

                                <?php $strain_gallery_image = image_fix_orientation('public/images/' . $image->image_path); if($image->is_approved == 1){  ?>
                                            <a href="<?php echo asset($strain_gallery_image) ?>" class="" data-fancybox="gallery" data-caption='' data-captionbox='caption_for_<?php echo $image->id; ?>'>
                                                <div class="strain-gallery-image" style="background-image: url('<?php echo asset($strain_gallery_image) ?>')"></div>
                                               <?php if($current_user && $current_id == $image->user_id){ ?>
                                         <a class="btn-popup" href="#strain-image-delete<?= $image->id ?>"><i class="fa fa-trash-o" style="position: absolute;top: 0;right: 0;color: #fff;padding: 15px;font-size: 15px;"></i></a>
                                         <?php } ?> 
                                            </a>
                                <?php } else{ ?>
                                     <a href="javascript:void(0)" class="">
                                         <div class="strain-gallery-image" style="background-image: url('<?= asset($strain_gallery_image) ?>')" style="position:relative;"></div>
                                         <img src="<?php echo asset('userassets/images/strain_pending.png') ?>" class="img-responsive" alt="Image" style="position: absolute;top: 0;left: 0;">
                                         <?php if($current_user && $current_id == $image->user_id){ ?>
                                         <a class="btn-popup" href="#strain-image-delete<?= $image->id ?>"><i class="fa fa-trash-o" style="position: absolute;top: 0;right: 0;color: #fff;padding: 15px;font-size: 15px;"></i></a>
                                         <?php } ?>
                                     </a>
                                <?php } ?>
                                        </li>
                                         <div id="strain-image-delete<?= $image->id ?>" class="popup">
                                            <div class="popup-holder">
                                                <div class="popup-area"> 
                                                     <form action="<?php echo asset('delete_strain_image'); ?>" class="reporting-form" method="post">
                                                        <input type="hidden" value="<?php echo $image->id; ?>" name="id">
                                                        <input type="hidden" value="<?php echo csrf_token(); ?>" name="_token">
                                                        <fieldset>
                                                            <h2>Delete Image</h2>
                                                            
                                                            
                                                        <label for="sexual<?= $image->id ?>">Are You sure to delete ?</label>

                            
                            
                                                            
                                                            <input type="submit" value="Delete Image">
                                                            <a href="#" class="btn-close">x</a>
                                                        </fieldset>
                                                    </form>
                                                </div>
                                                </div>
                                             </div>
                                        <!--                                    <div class="popupContentWrapper" style="display:none">
                                                                                <div class="popup3Content">
                                                                                    <div class="bxslider">
                                                                                        <div><img src="<?php // echo asset('public/images' . $image->image_path)  ?>" alt="Image" class="img-responsive"></div>
                                                                                        <div><img src="<?php // echo asset('public/images' . $image->image_path)  ?>" alt="Image" class="img-responsive"></div>
                                                                                        <div><img src="<?php // echo asset('public/images' . $image->image_path)  ?>" alt="Image" class="img-responsive"></div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>    -->
                                        <div id="strain-image-flag<?= $image->id ?>" class="popup">
                                            <div class="popup-holder">
                                                <div class="popup-area">
                                                    <form action="<?php echo asset('save-strain-image-flag'); ?>" class="reporting-form" method="post">
                                                        <input type="hidden" value="<?php echo $image->id; ?>" name="id">
                                                        <input type="hidden" value="<?php echo csrf_token(); ?>" name="_token">
                                                        <fieldset>
                                                            <h2>Reason For Reporting</h2>
                                                            
                                                            <input type="radio" name="group" id="sexual<?= $image->id ?>" checked value="Nudity or sexual content">
                            <label for="sexual<?= $image->id ?>">Nudity or sexual content</label>

                            <input type="radio" name="group" id="harasssment<?= $image->id ?>"  value="Harassment or hate speech">
                            <label for="harasssment<?= $image->id ?>">Harassment or hate speech</label>

                            <input type="radio" name="group" id="threatening<?= $image->id ?>"  value="Threatening, violent, or concerning">
                            <label for="threatening<?= $image->id ?>">Threatening, violent, or concerning</label>
                            
                                                            <input type="radio" name="group" id="abused<?= $image->id ?>"  value="offensive">
                                                            <label for="abused<?= $image->id ?>">Strain image is offensive</label>
                                                            <input type="radio" name="group" id="spam<?= $image->id ?>" value="Spam">
                                                            <label for="spam<?= $image->id ?>">Spam</label>
                                                            <input type="radio" name="group" id="unrelated<?= $image->id ?>" value="Unrelated">
                                                            <label for="unrelated<?= $image->id ?>">Unrelated</label>
                                                            <input type="submit" value="Report Strain Image">
                                                            <a href="#" class="btn-close">x</a>
                                                        </fieldset>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
    <?php
    }
} else {
    ?>

                        <?php } ?>
                            </ul>
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
        <?php /*
          <div id="gal-pop" class="popup">
          <div class="popup-holder">
          <div class="popup-area">
          <div class="reporting-form">
          <div class="visual slide-likes">
          <div class="gallery">
          <div class="mask add">
          <div class="slideset">
          <?php foreach ($strain->getImages as $image) { ?>
          <div class="slide">
          <img src="<?php echo asset('public/images' . $image->image_path) ?>" alt="Image" class="img-responsive">
          <div class="caption">
          <div class="caption-area">
          <div class="caption-holder">
          <footer class="footer">
          <div class="align-left">
          <span>Photo Uploaded by:</span>
          <strong> <a class="<?= getRatingClass($image->getUser->points)?>" href="<?= asset('user-profile-detail/'.$image->getUser->id) ?>"><?= $image->getUser->first_name ?></a></strong>
          <span class="date"><i class="fa fa-calendar" aria-hidden="true"></i> <?= date("dS M Y", strtotime($image->created_at)); ?></span>
          </div>
          <div class="align-right">
          <ul class="list-none">
          <li>
          <a <?php if ($image->liked) { ?> style="display: none"<?php } ?> href="javascript:void(0)" id="strain_like_<?= $image->id ?>" class="white thumb " onclick="addRemoveLike('<?= $image->id ?>', '1')">
          <i class="fa fa-thumbs-up" aria-hidden="true"></i>
          </a>
          <a <?php if (!$image->liked) { ?> style="display: none"<?php } ?> href="javascript:void(0)" id="strain_like_revert_<?= $image->id ?>" class="white thumb active" onclick="addRemoveLike('<?= $image->id ?>', '0')">
          <i class="fa fa-thumbs-up" aria-hidden="true"></i>
          </a>
          <span id="strain_like_count_<?= $image->id ?>"><?= $image->likeCount->count(); ?></span>
          </li>
          <li>
          <a <?php if ($image->disliked) { ?> style="display: none"<?php } ?> href="javascript:void(0)" id="strain_dislike_<?= $image->id ?>" class="white thumb " onclick="addRemoveDisLike('<?= $image->id ?>', '1')">
          <i class="fa fa-thumbs-down" aria-hidden="true"></i>
          </a>
          <a <?php if (!$image->disliked) { ?> style="display: none"<?php } ?> href="javascript:void(0)" id="strain_dislike_revert_<?= $image->id ?>" class="white thumb active" onclick="addRemoveDisLike('<?= $image->id ?>', '0')">
          <i class="fa fa-thumbs-down" aria-hidden="true"></i>
          </a>
          <span id="strain_dislike_count_<?= $image->id ?>"><?= $image->disLikeCount->count(); ?></span>
          </li>
          <li>
          <a <?php if ($image->flagged) { ?> style="display: none"<?php } ?>   id="strain_flag_<?= $image->id ?>" class="white flag report btn-popup" href="#strain-image-flag<?= $image->id?>" >
          <i class="fa fa-flag report btn-popup" aria-hidden="true"></i>
          </a>
          <a <?php if (!$image->flagged) { ?> style="display: none"<?php } ?>  href="javascript:void(0)" id="strain_flag_revert_<?= $image->id ?>" class="white flag active">
          <i class="fa fa-flag" aria-hidden="true"></i>
          </a>
          </li>
          </ul>
          </div>
          </footer>
          </div>
          </div>
          </div>
          </div>
          <div id="strain-image-flag<?= $image->id?>" class="popup">
          <div class="popup-holder">
          <div class="popup-area">
          <form action="<?php echo asset('save-strain-image-flag'); ?>" class="reporting-form" method="post">
          <input type="hidden" value="<?php echo $image->id; ?>" name="id">
          <input type="hidden" value="<?php echo csrf_token(); ?>" name="_token">
          <fieldset>
          <h2>Reason For Reporting</h2>
          <input type="radio" name="group" id="abused<?= $image->id?>" checked value="Abused">
          <label for="abused<?= $image->id?>">Abused</label>
          <input type="radio" name="group" id="spam<?= $image->id?>" value="Spam">
          <label for="spam<?= $image->id?>">Spam</label>
          <input type="radio" name="group" id="unrelated<?= $image->id?>" value="Unrelated">
          <label for="unrelated<?= $image->id?>">Unrelated</label>
          <input type="submit" value="Send">
          <a href="#" class="btn-close">x</a>
          </fieldset>
          </form>
          </div>
          </div>
          </div>
          <?php } ?>
          </div>
          <a href="#" class="btn-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
          <a href="#" class="btn-next"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
          <!-- <div class="pagination"></div> -->

          </div>
          </div>
          </div>
          <a href="javascript:void(0)" class="btn-close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
          </div>
          </div>
          </div>
          </div>
         */ ?>



<?php include('includes/footer.php'); ?>
        <script>
            function removeStrainMySave(id) {
                $.ajax({
                    url: "<?php echo asset('strain-remove-favorit') ?>",
                    type: "POST",
                    data: {"strain_id": id, "_token": "<?php echo csrf_token(); ?>"},
                    success: function (response) {
                        if (response.status == 'success') {
                            $('#removeStrainFav' + id).hide();
                            $('#addStrainFav' + id).show();
                        }
                    }
                });
            }

            function addStrainMySave(id) {
                $.ajax({
                    url: "<?php echo asset('strain-add-favorit') ?>",
                    type: "POST",
                    data: {"strain_id": id, "_token": "<?php echo csrf_token(); ?>"},
                    success: function (response) {
                        if (response.status == 'success') {
                            $('#addStrainFav' + id).hide();
                            $('#removeStrainFav' + id).show();
                        }
                    }
                });
            }

            $(document).ready(function () {
                $('[data-fancybox="gallery"]').fancybox({
                    caption: function (instance, item) {
                        var capt = $(this).data('captionbox');
                        var caption = $('.' + capt).html();
//                    if ( item.type === 'image' ) {
//                        caption = (caption.length ? caption + '<br />' : '') + '<a href="' + item.src + '">Download image</a>' ;
//                    }

                        return caption;
                    },
                    share: {
                        tpl:
                                '<div class="fancybox-share">' +
                                "<h1>SELECT AN OPTION</h1>" +
                                "<div id='social-links'><ul>" +
                                '<li><a class="social-button social-facebook posts_class" href="https://www.facebook.com/sharer/sharer.php?u=' + window.location + '">' +
                                '<span class="fa fa-facebook"></span></a></li>' +
                                '<li><a class="social-button social-twitter posts_class" href="https://twitter.com/intent/tweet?url=' + window.location + '">' +
                                '<span class="fa fa-twitter"></span></a></li>' +
                                '<li><a class="social-button social-gplus posts_class" href="https://plus.google.com/share?url=' + window.location + '">' +
                                '<span class="fa fa-google-plus"></span></a></li>' +
                                "<ul></div>" +
                                "</div>"
                    }
                });
//                var slider = $('.bxslider').bxSlider({
//                    mode: 'fade',
//                    captions: true,
//                    slideWidth: 600
//                });
                //Load slider on modal load
//                $('#popupBox3').on('shown.bs.modal', function (e) {
//                      slider.reloadSlider();
//                });
                $('#gal-img').on('change', function () {
                    $('#gal-img').attr("src", '');
                    imagesPreview(this, 'ul.uploaded_gallery');
                });


                function imagesPreview(input, placeToInsertImagePreview) {
                    if (input.files) {
                        for (var x = 0; x < input.files.length; x++) {
                            var filePath = input.value;
                            var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
                            if (!allowedExtensions.exec(filePath)) {
                                $('#showError').html('Please upload file having extensions .jpeg/.jpg/.png/.gif  only.').show().fadeOut(3000);

                                $('#gal-img').val('');
                                return false;
                            } else {
                                $("#upload_image").submit();
                            }
                        }
                    }

                }
                ;
                $(".popup1").popup({
                    transparentLayer: true,
                    gallery: true,
                    galleryTitle: "Gallery2 Title",
                    popupID: "fixedGallery",
                    imageDesc: true,
                    fixedTop: 50,
                    fixedLeft: false,
                    galleryCircular: false,
                    onOpen: function () {
                    },
                    onClose: function () {
                    }
                });
            });

            $('#strain_like').click(function () {
                $('#strain_dislike_revert').addClass("active");
                var ajax = 1;
                if (ajax === 1) {
                    ajax = 2;
                    $.ajax({
                        url: "<?php echo asset('strain_like') ?>",
                        type: "POST",
                        data: {"strain_id": '<?= $strain_id; ?>', "_token": "<?php echo csrf_token(); ?>"},
                        success: function (response) {
                            if (response.status == 'success') {
                                $('#strain_like').hide();
                                $('#strain_like_revert').addClass("active").show();


//                                var strain_like_count = $('#strain_like_count').text();
                                $("#strain_like_count").text(parseInt(response.like_count));
                                $("#strain_dislike_count").text(parseInt(response.dislike_count));
                                $('#strain_dislike_revert').hide();
                                $('#strain_dislike').show();
                                ajax = 1;
                            }
                        }
                    });
                }
            });

            $('#strain_like_revert').click(function () {
                $('#strain_dislike_revert').addClass("active");
                var ajax = 1;
                if (ajax === 1) {
                    ajax = 2;
                    $.ajax({
                        url: "<?php echo asset('strain_like_revert') ?>",
                        type: "POST",
                        data: {"strain_id": '<?= $strain_id; ?>', "_token": "<?php echo csrf_token(); ?>"},
                        success: function (response) {
                            if (response.status == 'success') {
                                $('#strain_like_revert').hide();
                                $('#strain_like').show();

//                                var strain_like_count = $('#strain_like_count').text();
                                $("#strain_like_count").text(response.like_count);
                                ajax = 1;
                            }
                        }
                    });
                }
            });

            $('#strain_dislike').click(function (e) {
                $('#strain_like_revert').addClass("active");
                var ajax = 1;
                if (ajax === 1) {
                    ajax = 2;
                    $.ajax({
                        url: "<?php echo asset('strain_dislike') ?>",
                        type: "POST",
                        data: {"strain_id": '<?= $strain_id; ?>', "_token": "<?php echo csrf_token(); ?>"},
                        success: function (response) {
                            if (response.status == 'success') {
                                $('#strain_dislike').hide();
                                $('#strain_dislike_revert').addClass("active").show();

//                                var strain_like_count = $('#strain_dislike_count').text();
                                $("#strain_dislike_count").text(parseInt(response.dislike_count));
                                $("#strain_like_count").text(parseInt(response.like_count));
                                $('#strain_like_revert').hide();
                                $('#strain_like').show();
                                ajax = 1;
                            }
                        }
                    });
                }
            });

            $('#strain_dislike_revert').click(function (e) {
                $('#strain_like_revert').addClass("active");
                var ajax = 1;
                if (ajax === 1) {
                    ajax = 2;
                    $.ajax({
                        url: "<?php echo asset('strain_dislike_revert') ?>",
                        type: "POST",
                        data: {"strain_id": '<?= $strain_id; ?>', "_token": "<?php echo csrf_token(); ?>"},
                        success: function (response) {
                            if (response.status == 'success') {
                                $('#strain_dislike_revert').hide();
                                $('#strain_dislike').show();

//                                var strain_like_count = $('#strain_dislike_count').text();
                                $("#strain_dislike_count").text(parseInt(response.like_count));
                                ajax = 1;
                            }
                        }
                    });
                }
            });


            $('.strain_flag').click(function (e) {
                $.ajax({
                    url: "<?php echo asset('strain_flag') ?>",
                    type: "POST",
                    data: {"strain_id": '<?= $strain_id; ?>', "_token": "<?php echo csrf_token(); ?>"},
                    success: function (response) {
                        if (response.status == 'success') {
                            $('.strain_flag').hide();
                            $('.strain_flag_revert').show();
                        }
                    }
                });
            });

//            $('.strain_flag_revert').click(function (e) {
//                $.ajax({
//                    url: "<?php echo asset('strain_flag_revert') ?>",
//                    type: "POST",
//                    data: {"strain_id": '<?= $strain->id; ?>', "_token": "<?php echo csrf_token(); ?>"},
//                    success: function (response) {
//                        if (response.status == 'success') {
//                            $('.strain_flag_revert').hide();
//                            $('.strain_flag').removeClass("active").show();
//                        }
//                    }
//                });
//            });
            $('.strain_class').unbind().click(function () {
                count = 0;

                if (count === 0) {
                    count = 1;
                    id = this.id;
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
            $('.strain_class').unbind().click(function () {
                count = 0;

                if (count === 0) {
                    count = 1;
                    id = this.id;
                    $('#strain-share-' + id).fadeOut();
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
            
        </script>
    </body>
</html>