<div class="strain_info_header strain-slider-header-adjust" style="height: 351px; padding: 0;">
    <div class="starin-header-slider">
        <ul class="header-strain-slider">
            <?php if(count($strain->getImages->where('is_approved',1)) > 0){ foreach ($strain->getImages->where('is_approved',1) as $image) { ?>

                <li>
                    <figure style="background-image: url('<?php echo asset('public/images/' . $image->image_path) ?>')"></figure>
                    <div class="strain-header-layer-bg"></div>
                    <div class="caption">
                        <div class="caption-area">
                            <div class="caption-holder">
                                <footer class="footer">
                                    <div class="align-left">
                                        <span>Photo Uploaded by:</span>
                                        <?php if ($image->getUser) { ?>
                                            <strong> <a class="<?= getRatingClass($image->getUser->points) ?>" href="<?= asset('user-profile-detail/' . $image->getUser->id) ?>"><?= $image->getUser->first_name ?></a></strong>
                                        <?php } else { ?>
                                            <strong> <a href="javascript:void(0)">Healing Budz </a></strong>
                                        <?php } ?>
                                        <span class="date"><i class="fa fa-calendar" aria-hidden="true"></i> <?= date("dS M Y", strtotime($image->created_at)); ?></span>
                                    </div>
                                    <div class="align-right">
                                        <ul class="list-none">
                                            <?php if (Auth::user()) { ?>
                                            <li>

                                                <div class="strain_header_img">
                                                    <i id="strain_img_upload" class="fa fa-upload"></i><span class="name"></span>

                                                   
                                                </div>

                                            </li>
                                            <?php } ?>
                                            <li>
                                                <?php if (Auth::user()) { ?>


                                                    <a <?php if ($image->liked) { ?> style="display: none"<?php } ?> href="javascript:void(0)" id="strain_like_<?= $image->id ?>" class="white thumb strain_like_<?= $image->id ?>" onclick="addRemoveLike('<?= $image->id ?>', '1')">
                                                        <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                                    </a>
                                                    <a <?php if (!$image->liked) { ?> style="display: none"<?php } ?> href="javascript:void(0)" id="strain_like_revert_<?= $image->id ?>" class="white thumb active strain_like_revert_<?= $image->id ?>" onclick="addRemoveLike('<?= $image->id ?>', '0')">
                                                        <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                                    </a>
                                                <?php } else { ?>
                                                    <a href="#loginModal"  class="white thumb btn-popup new_popup_opener  strain_like_revert_<?= $image->id ?>">
                                                        <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                                    </a>   
                                                <?php } ?>
                                                <span class="strain_like_count_<?= $image->id ?>"  id="strain_like_count_<?= $image->id ?>"><?= $image->likeCount->count(); ?></span>
                                            </li>
                                            <li>
                                                <?php if (Auth::user()) { ?>
                                                    <a <?php if ($image->disliked) { ?> style="display: none"<?php } ?> href="javascript:void(0)" id="strain_dislike_<?= $image->id ?>" class="white thumb strain_dislike_<?= $image->id ?>" onclick="addRemoveDisLike('<?= $image->id ?>', '1')">
                                                        <i class="fa fa-thumbs-down" aria-hidden="true"></i>
                                                    </a>
                                                    <a <?php if (!$image->disliked) { ?> style="display: none"<?php } ?> href="javascript:void(0)" id="strain_dislike_revert_<?= $image->id ?>" class="white thumb active strain_dislike_revert_<?= $image->id ?>" onclick="addRemoveDisLike('<?= $image->id ?>', '0')">
                                                        <i class="fa fa-thumbs-down" aria-hidden="true"></i>
                                                    </a>
                                                <?php } else { ?>
                                                    <a href="#loginModal"  class="white thumb btn-popup new_popup_opener strain_dislike_<?= $image->id ?>" >
                                                        <i class="fa fa-thumbs-down" aria-hidden="true"></i>
                                                    </a>
                                                <?php } ?>
                                                <span class="strain_dislike_count_<?= $image->id ?>" id="strain_dislike_count_<?= $image->id ?>"><?= $image->disLikeCount->count(); ?></span>
                                            </li>
                                            <li>
                                                <?php if (Auth::user()) { ?>
                                                    <a <?php if ($image->flagged) { ?> style="display: none"<?php } ?>   id="strain_flag_<?= $image->id ?>" class="white flag report btn-popup" href="#strain-image-flag<?= $image->id ?>" >
                                                        <i class="fa fa-flag report btn-popup" aria-hidden="true"></i>
                                                    </a>
                                                    <a <?php if (!$image->flagged) { ?> style="display: none"<?php } ?>  href="javascript:void(0)" id="strain_flag_revert_<?= $image->id ?>" class="white flag active">
                                                        <i class="fa fa-flag" aria-hidden="true"></i>
                                                    </a>
                                                <?php } else { ?>
                                                    <a  class="white flag report btn-popup new_popup_opener" href="#loginModal" >
                                                        <i class="fa fa-flag report btn-popup" aria-hidden="true"></i>
                                                    </a>  
                                                <?php } ?>
                                            </li>
                                        </ul>
                                    </div>
                                </footer>
                            </div>
                        </div>
                    </div>
                </li>


            <?php }}else{ ?>
              <li>
                    <figure style="background-image: url('<?php echo asset('public/strain_image_default.jpg') ?>')"></figure>
                    <div class="strain-header-layer-bg"></div>
                    <div class="caption">
                        <div class="caption-area">
                            <div class="caption-holder">
                                <footer class="footer">
                                    
                                    <div class="align-right" style="margin-left: auto;">
                                        <ul class="list-none">
                                            <?php if (Auth::user()) { ?>
                                            <li>

                                                <div class="strain_header_img">
                                                    <i id="strain_img_upload" class="fa fa-upload"></i><span class="name"></span>
                                         </div>
                                            </li> 
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </footer>
                            </div>
                        </div>
                    </div>
                </li>  
           <?php } ?>
        </ul>
    </div>
     <form action="<?php echo asset('upload_strain_image') ?>" class="upload-form" id="upload_image_form_header" method="POST" enctype="multipart/form-data">
                                                        <input accept="image/*" type="file" name="image" id="strain_img_upload_file_header">
                                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                        <input type="hidden" name="strain_id" value="<?= $strain->id; ?>">
                                                    </form>
    <div class="strain-header-layer-bg-main">


        <?php foreach ($strain->getImages as $image) { ?>

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
        <?php } ?>


        <div class="strain-fav-icon">
            <ul class="list-none">
                <li>
                    <?php if (Auth::user()) { ?>
                        <a <?php if (checkMySaveSetting('save_strain')) { ?> href="javascript:void(0)" <?php } else { ?> href="#saved-strain" <?php } ?> <?php if ($strain->is_saved_count > 0) { ?> style="display: none"<?php } ?> class="btn-popup" onclick="addStrainMySave('<?php echo $strain->id; ?>')" id="addStrainFav<?php echo $strain->id; ?>">
                            <i class="fa fa-heart-o" aria-hidden="true"></i>
                        </a>
                        <a href="#" <?php if ($strain->is_saved_count == 0) { ?> style="display: none"<?php } ?> class="btn-popup active" onclick="removeStrainMySave('<?php echo $strain->id; ?>')" id="removeStrainFav<?php echo $strain->id; ?>">
                            <i class="fa fa-heart" aria-hidden="true"></i>
                        </a>
                    <?php } else { ?>
                        <a href="#loginModal"  class="btn-popup new_popup_opener" >
                            <i class="fa fa-heart-o" aria-hidden="true"></i>
                        </a>   
                    <?php } ?>
                    <span>Add to Favorite</span>
                </li>
            </ul>
            <span class="dot-options">
                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                <div class="sort-drop">
                    <?php /*    <div class="sort-item active">
                      <a class="btn-popup" href="#strain-gallery<?php //echo asset('strain-gallery/' . $strain->id); ?>"><img src="<?php echo asset('userassets/images/galleryY.svg') ?>" alt="Image" class="img-responsive"> <span>Gallery</span></a>
                      </div> */ ?>
                    <div class="sort-item">
                        <a class="white flag report btn-popup" href="#strain-share-<?= $strain->id ?>">
                            <i class="fa fa-share-alt" aria-hidden="true"></i><span>Share</span>
                        </a>
                    </div>
                    <?php /* <div class="sort-item">
                      <a <?php if ($strain->is_flaged) { ?> style="display: none"<?php } ?>   class="white flag report btn-popup strain_flag" href="#strain-flag-<?= $strain->id ?>">
                      <i class="fa fa-flag" aria-hidden="true"></i><span>Report</span>
                      </a>
                      </div>
                     */ ?>
                    <?php if (Auth::user()) { ?>
                        <!--                <div class="sort-item">
                                            
                                            <a <?php if ($strain->is_flaged) { ?> style="display: none"<?php } ?>   class="white flag report btn-popup strain_flag" href="#strain-flag-<?= $strain->id ?>">
                                                <i class="fa fa-flag" aria-hidden="true"></i><span>Report</span>
                                            </a>
                                                <a <?php if (!$strain->is_flaged) { ?> style="display: none"<?php } ?>  href="javascript:void(0)"  class="white flag active strain_flag_revert">
                                                <i class="fa fa-flag yellow-active" aria-hidden="true"></i><span>Reported</span>
                                            </a>
                                        </div>-->
                    <?php } ?>
                </div>
            </span>
        </div>
        <!-- Report Strain Popup -->
        <div id="strain-flag-<?= $strain->id ?>" class="popup">
            <div class="popup-holder">
                <div class="popup-area">
                    <form action="<?php echo asset('strain_flag'); ?>" class="reporting-form" method="post">
                        <input type="hidden" value="<?php echo $strain->id; ?>" name="strain_id">
                        <input type="hidden" value="<?php echo csrf_token(); ?>" name="_token">
                        <fieldset>
                            <h2>Reason For Reporting</h2>

                            <input type="radio" name="reason" id="sexual<?= $strain->id ?>" checked value="Nudity or sexual content">
                            <label for="sexual<?= $strain->id ?>">Nudity or sexual content</label>

                            <input type="radio" name="reason" id="harasssment<?= $strain->id ?>"  value="Harassment or hate speech">
                            <label for="harasssment<?= $strain->id ?>">Harassment or hate speech</label>

                            <input type="radio" name="reason" id="threatening<?= $strain->id ?>"  value="Threatening, violent, or concerning">
                            <label for="threatening<?= $strain->id ?>">Threatening, violent, or concerning</label>

                            <input type="radio" name="reason" id="abused<?= $strain->id ?>"  value="offensive">
                            <label for="abused<?= $strain->id ?>">Strain is offensive</label>
                            <input type="radio" name="reason" id="spam<?= $strain->id ?>" value="Spam">
                            <label for="spam<?= $strain->id ?>">Spam</label>
                            <input type="radio" name="reason" id="unrelated<?= $strain->id ?>" value="Unrelated">
                            <label for="unrelated<?= $strain->id ?>">Unrelated</label>
                            <input type="submit" value="Report Strain">
                            <a href="#" class="btn-close">x</a>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <!-- Report Strain Popup End -->
        <!-- Share Strain Popup -->
        <div id="strain-share-<?= $strain->id; ?>" class="popup">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="reporting-form">
                        <h2>Select an option</h2>
                        <div class="custom-shares">
                            <?php
                            echo Share::page(asset('strain-details/' . $strain->id), $strain->title, ['class' => 'strain_class', 'id' => $strain->id])
                                    ->facebook($strain->title)
                                    ->twitter($strain->title)
                                    ->googlePlus($strain->title);
                            ?>
                            <?php if (Auth::user()) { ?>
                                <div class="strain_class in_app_button" onclick="shareInapp('<?= asset('strain-details/' . $strain->id) ?>', '', '<?= asset('userassets/images/logo-for-scrap.png') ?>')"> <span class="hb_icon_repost"></span> In App</div>
                            <?php } ?> </div>
                        <a href="javascript:void(0)" class="btn-close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Share Strain Popup End -->

        <div class="align_left">
            <!--<div class="strain-img-gray"><img src="<?php // echo asset('userassets/images/side-icon14.svg')   ?>" alt="icon" class="small-icon"></div>-->
            <div class="strain-key-text">
                <em class="key <?= $strain->getType->title; ?>"><?= substr($strain->getType->title, 0, 1); ?></em>
            </div>
            <div class="strain-img-gray-next">
                <h2><?= $strain->title; ?></h2>
                <?php /*    <em class="key <?= $strain->getType->title; ?>"><?= substr($strain->getType->title, 0, 1); ?></em> 
                  <span class="text_middle"><?= $strain->getType->title; ?></span> */ ?>
                <div class="rate_span text_middle">
                    <img src="<?php echo asset('userassets/images/leaf-' . floorToFraction(number_format((float) $strain->ratingSum['total'], 1, '.', ''), 2) . '.svg') ?>" alt="Image" class="img-responsive">
                    <span>
                        <em><?= number_format((float) $strain->ratingSum['total'], 1, '.', ''); ?></em>
                        <a href="<?php
                        if ($strain->get_review_count > 0) {
                            echo asset('strain-review-listing/' . $strain->id);
                        } else {
                            echo 'javascript:void(0)';
                        }
                        ?>"> (<?= $strain->get_review_count; ?> Reviews)
                            </div>
                    </span>
                    <div class="txt">
                        <ul class="list-none custom_likes">
                            <li class="active">
                                <?php if (Auth::user()) { ?>
                                    <a <?php if ($strain->is_liked) { ?> style="display: none"<?php } ?> href="javascript:void(0)" id="strain_like" class="white thumb ">
                                        <i class="" aria-hidden="true"></i>
                                    </a>
                                    <a <?php if (!$strain->is_liked) { ?> style="display: none"<?php } ?> href="javascript:void(0)" id="strain_like_revert" class="white thumb active">
                                        <i class="" aria-hidden="true"></i>
                                    </a>
                                <?php } else { ?>
                                    <a  href="#loginModal" id="" class="white thumb new_popup_opener">
                                        <i class="" aria-hidden="true"></i>
                                    </a>
                                <?php } ?>
                                <span id="strain_like_count"></span>
                            </li>
                            <li>
                                <?php if (Auth::user()) { ?>
                                    <a <?php if ($strain->is_disliked) { ?> style="display: none"<?php } ?> href="javascript:void(0)" id="strain_dislike" class="white thumb ">
                                        <i class="" aria-hidden="true"></i>
                                    </a>
                                    <a <?php if (!$strain->is_disliked) { ?> style="display: none"<?php } ?> href="javascript:void(0)" id="strain_dislike_revert" class="white thumb active">
                                        <i class="" aria-hidden="true"></i>
                                    </a>
                                <?php } else { ?>
                                    <a  href="#loginModal" id="" class="white thumb new_popup_opener">
                                        <i class="" aria-hidden="true"></i>
                                    </a>
                                <?php } ?>
                                <span id="strain_dislike_count"></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function addRemoveLike(id, val) {
            if (val == 1) {
                $('.strain_like_' + id).hide();
                $('.strain_like_revert_' + id).show();
                $('.strain_dislike_' + id).show();
                $('.strain_dislike_revert_' + id).hide();
            } else {
                $('.strain_like_' + id).show();
                $('.strain_like_revert_' + id).hide();
            }
            $.ajax({
                type: "GET",
                url: "<?php echo asset('save-strain-image-like'); ?>",
                data: {
                    "id": id, "val": val
                },
                success: function (data) {
                    $('.strain_like_count_' + id).html(data.like_count);
                    $('.strain_dislike_count_' + id).html(data.dislike_count);
                }
            });
        }

        function addRemoveDisLike(id, val) {
            if (val == 1) {
                $('.strain_dislike_' + id).hide();
                $('.strain_dislike_revert_' + id).show();
                $('.strain_like_' + id).show();
                $('.strain_like_revert_' + id).hide();
            } else {
                $('.strain_dislike_' + id).show();
                $('.strain_dislike_revert_' + id).hide();
            }
            $.ajax({
                type: "GET",
                url: "<?php echo asset('save-strain-image-dislike'); ?>",
                data: {
                    "id": id, "val": val
                },
                success: function (data) {
                    $('.strain_like_count_' + id).html(data.like_count);
                    $('.strain_dislike_count_' + id).html(data.dislike_count);
                }
            });
        }

        function addRemoveFlag(id, val) {
            if (val == 1) {
                $('.strain_flag_' + id).hide();
                $('.strain_flag_revert_' + id).show();
            } else {
                $('.strain_flag_' + id).show();
                $('.strain_flag_revert_' + id).hide();
            }
            $.ajax({
                type: "GET",
                url: "<?php echo asset('save-strain-image-flag'); ?>",
                data: {
                    "id": id, "val": val
                },
                success: function (data) {

                }
            });
        }

        //Strain header Image Upload 
        $("#strain_img_upload").click(function () {
       
            $("#strain_img_upload_file_header").trigger('click');
           
        });
        $('#strain_img_upload_file_header').on('change', function () {
            
                    $('#strain_img_upload_file_header').attr("src", '');
                    imagesPreviewHeader(this, 'ul.uploaded_gallery');
                });
 
        function imagesPreviewHeader(input, placeToInsertImagePreview) {
            if (input.files) {
                 
                for (var x = 0; x < input.files.length; x++) {
                    var filePath = input.value;
                    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
                    if (!allowedExtensions.exec(filePath)) {
                        $('#showError').html('Please upload file having extensions .jpeg/.jpg/.png/.gif  only.').show().fadeOut(3000);

                        $('#strain_img_upload_file_header').val('');
                        return false;
                    } else {
                        $("#upload_image_form_header").submit();
                    }
                }
            }

        }
    </script>