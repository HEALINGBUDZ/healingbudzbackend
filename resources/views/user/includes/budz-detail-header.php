<div class="strain_info_header dark_pink drk_pnk_msg" style=" background-image: url(<?php echo getSubBanner($budz->banner) ?>); padding: 0;">
    <div class="bud-add-edit-inner clearfix">
    <div class="strain-fav-icon">
        <ul class="list-none">
            <?php if (Auth::user()) { ?>
            <li onclick="saveBudzMap('<?php echo $budz->id; ?>')" id="savebudzmap<?php echo $budz->id; ?>" <?php if ($budz->get_user_save_count) { ?> style="display: none" <?php } ?> class="li-icon li-heart dark-pink">
                <a <?php if (checkMySaveSetting('save_budz')) { ?> href="javascript:void(0)" <?php } else { ?> href="#save-business" <?php } ?> class="btn-popup"><i class="fa fa-heart-o"></i></a>
                <span>Add to Favorite</span>
            </li>
            <li onclick="unSaveBudzMap('<?php echo $budz->id; ?>')" id="unsavebudzmap<?php echo $budz->id; ?>" <?php if (!$budz->get_user_save_count) { ?> style="display: none" <?php } ?>  class="li-icon li-heart dark-pink">
                <a href="#" class="active"><i class="fa fa-heart"></i></a>
                <span>Add to Favorite</span>
            </li>
            <?php }else{ ?>
            <li class="li-icon li-heart dark-pink">
                <a href="#loginModal" class="btn-popup new_popup_opener"><i class="fa fa-heart-o"></i></a>
                <span>Add to Favorite</span>
            </li>
            <?php } ?>
        </ul>
        <span class="dot-options">
            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
            <div class="sort-drop">
                <?php /*
                  <div class="sort-item active">
                  <a  href="<?php echo asset('budz-gallary/' . $budz->id); ?>"><img src="<?php echo asset('userassets/images/galleryY.svg') ?>" alt="Image" class="img-responsive"> <span>Gallery</span></a>
                  </div>
                 */ ?>
                <div class="sort-item">
                    <a class="white flag report btn-popup" href="#budz-share-<?= $budz->id ?>">
                        <i class="fa fa-share-alt" aria-hidden="true"></i><span>Share</span>
                    </a>
                </div>

                <div class="sort-item">
                    <?php if ($current_id == $budz->user_id) { ?>
                        <figure>
                            <a href="<?php echo asset('budz-map-edit/' . $budz->id); ?>">
                                <i class="fa fa-pencil" aria-hidden="true"></i><span>Edit</span>
                            </a>
                        </figure>
                    <?php } ?>
                </div>
                 <?php if (Auth::user() && $current_id != $budz->user_id) { ?>
                <div class="sort-item">
                    <a <?php if ($budz->isFlaged) { ?> style="display: none"<?php } ?>   href="#budz-flag<?= $budz->id ?>" class="report btn-popup flag">
                        <i class="fa fa-flag" aria-hidden="true"></i><span>Report</span>
                    </a>
                        <a <?php if (!$budz->isFlaged) { ?> style="display: none"<?php } ?>  href="javascript:void(0)"  class="white flag active strain_flag_revert">
                        <i class="fa fa-flag yellow-active" aria-hidden="true"></i><span>Reported</span>
                    </a>
                </div>
                 <?php } ?>
            </div>
        </span>
    </div>

    <div id="budz-share-<?= $budz->id; ?>" class="popup">
        <div class="popup-holder">
            <div class="popup-area">
                <div class="reporting-form">
                    <h2>Select an option</h2>
                    <div class="custom-shares">
                        <?php
                        $url= urlencode(asset("get-budz?business_id=".$budz->id."&business_type_id=".$budz->business_type_id));
                        echo Share::page($url, $budz->title, ['class' => 'budz_class', 'id' => $budz->id])
                                ->facebook($budz->title)
                                ->twitter($budz->title)
                                ->googlePlus($budz->title);
                        ?>
                        <?php if(Auth::user()){ ?>
                         <!--<div class="budz_review_class in_app_button" onclick="shareInapp('<?= asset("get-budz?business_id=".$budz->id."&business_type_id=".$budz->business_type_id) ?>', '<?php echo trim(revertTagSpace($budz->title)); ?>', '<?= asset('userassets/images/logo-for-scrap.png') ?>')"> <span class="hb_icon_repost"></span> In App</div>-->
                        <?php } ?> </div>
                    <a href="javascript:void(0)" class="btn-close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Share Strain Popup End -->

    <div class="align_left">
        <div class="strain-img-gray">
            <!--<img src="<?php // echo getSubImage($budz->logo, '') ?>" alt="icon" class="small-icon">-->
            <figure style="background-image: url('<?php echo getSubImage($budz->logo, '') ?>')" class="small-icon"></figure>
        </div>
        <div class="strain-img-gray-next">
            <h2><?= $budz->title; ?></h2>
            <?php /*   <span class="text_middle"><?= $budz->getType; ?></span> */ ?>
            <div class="rate_span text_middle">
                <img src="<?php echo asset('userassets/images/leaf-' . floorToFraction(number_format((float) $budz->ratingSum['total'], 1, '.', ''), 2) . '.svg') ?>" alt="Image" class="img-responsive">
                <span>
                    <em><?= number_format((float) $budz->ratingSum['total'], 1, '.', ''); ?></em>
                    <a href="<?php
                    if ($budz->get_review_count > 0) {
                        echo asset('strain-review-listing/' . $budz->id);
                    } else {
                        echo 'javascript:void(0)';
                    }
                    ?>"> (<?= $budz->review_count; ?> Reviews) </a>
            </div>
            </span>
                <?php if ($budz->business_type_id != 9) {?>
            <div class="txt inline_col_holder">
                <?php if ($budz->is_organic) { ?>
                    <div class="inline_col">
                        <figure>
                            <img src="<?php echo asset('userassets/images/icon-plant.svg') ?>" alt="icon">
                            <figcaption>Organic</figcaption>
                        </figure>
                    </div>
                <?php } if ($budz->is_delivery) { ?>
                    <div class="inline_col">
                        <figure>
                            <img src="<?php echo asset('userassets/images/icon-van.svg') ?>" alt="icon">
                            <figcaption>We Deliver</figcaption>
                        </figure>
                    </div>
                <?php } ?>
            </div>
                <?php } ?>
        </div>
    </div>
    <div class="cus-btn-pro i_msg">
        <?php if(Auth::user()){ if ( $current_id != $budz->user_id) { ?>
            <a href="<?= asset('budz-listing-message-detail/' . $budz->user_id . '/' . $budz->id) ?>">
                <i class="fa fa-comment"></i> Message
            </a>
        <?php }}else{ ?>
        <a href="#loginModal" class="new_popup_opener">
                <i class="fa fa-comment"></i> Message
            </a>    
       <?php } ?>
        <!--                                        <a href="http://localhost/healingbudz/hb-gallery/2">
                        <img src="http://localhost/healingbudz/userassets/images/gallery-black.png" alt="gallery icon" /> Gallery
                    </a>-->

    </div>
</div>
</div>
 <div id="budz-flag<?= $budz->id ?>" class="popup">
                <div class="popup-holder">
                    <div class="popup-area">
                        <form action="<?php echo asset('report-budz'); ?>" class="reporting-form" method="post">
                            <input type="hidden" value="<?php echo $budz->id; ?>" name="budz_id">
                            <input type="hidden" value="<?php echo csrf_token(); ?>" name="_token">
                            <fieldset>
                                <h2>Reason For Reporting</h2>
                                
                                <input type="radio" name="group" id="sexual<?= $budz->id ?>" checked value="Nudity or sexual content">
                            <label for="sexual<?= $budz->id ?>">Nudity or sexual content</label>

                            <input type="radio" name="group" id="harasssment<?= $budz->id ?>"  value="Harassment or hate speech">
                            <label for="harasssment<?= $budz->id ?>">Harassment or hate speech</label>

                            <input type="radio" name="group" id="threatening<?= $budz->id ?>"  value="Threatening, violent, or concerning">
                            <label for="threatening<?= $budz->id ?>">Threatening, violent, or concerning</label>
                            
                                
                                <input type="radio" name="group" id="abused<?= $budz->id ?>"  value="Offensive">
                                <label for="abused<?= $budz->id ?>">Budz adz is Offensive</label>
                                <input type="radio" name="group" id="spam<?= $budz->id ?>" value="Spam">
                                <label for="spam<?= $budz->id ?>">Spam</label>
                                <input type="radio" name="group" id="unrelated<?= $budz->id ?>" value="Unrelated">
                                <label for="unrelated<?= $budz->id ?>">Unrelated</label>
                                <input type="submit" value="Report Budz Adz">
                                <a href="#" class="btn-close">x</a>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>


<script>
    
//        $('.budz_class').click(function () {
//            
//            $(this).parents('.custom-shares').hide();
//            sub_user_id = this.id;
//            var keyword = $('#keyword_searched').val();
//            $.ajax({
//                url: "<?php // echo asset('save_budzmap_share')  ?>",
//                type: "GET",
//                data: {
//                    "sub_user_id": sub_user_id,
//                    "keyword": keyword
//                },
//                success: function (data) {
//                }
//            });
//
//        });
    
    $('.budz_class').unbind().click(function () {
        count = 0;
        
        if (count === 0) {
            count = 1;
            id = this.id;
            $.ajax({
                url: "<?php echo asset('add_question_share_points') ?>",
                type: "GET",
                data: {
                    "id": id, "type": "Budz"
                },
                success: function (data) {
                    count = 0;
                }
            });
            $('.popup').hide();
//            $(this).parents('.custom-shares.popup').hide();
            sub_user_id = this.id;
            var keyword = $('#keyword_searched').val();
            $.ajax({
                url: "<?php echo asset('save_budzmap_share') ?>",
                type: "GET",
                data: {
                    "sub_user_id": sub_user_id,
                    "keyword": keyword
                },
                success: function (data) {
                }
            });
        }
    });
    $(".update_subscription").on('click', function (event) {
        event.stopPropagation();
        event.stopImmediatePropagation();
        alert('ads')
//(... rest of your JS code)
    });
    
//        $('#showsubscription').modal('show');
</script>
