<?php foreach ($reviews as $review) { ?>
    <?php if($review->reviewed_by == $current_id){
        $user_review_count ++;
    } ?>
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
                    <span class="date"><?php //echo date("jS M Y", strtotime($review->created_at));  ?></span>
                    <span class="dot-options">
                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                        <div class="sort-drop">
                            <?php if($review->reviewed_by == $current_id){ ?>
                                <div class="sort-item">
                                    <a class="white flag report" href="<?php echo asset('edit-strain-review/'.$review->id.'/'.$review->strain_id)?>">
                                        <i class="fa fa-pencil" aria-hidden="true"></i><span>Edit review</span>
                                    </a>
                                </div>
                                <div class="sort-item">
                                    <a class="white flag report btn-popup" href="#delete_strain_review-<?php echo $review->id;?>">
                                        <i class="fa fa-trash" aria-hidden="true"></i><span>Delete</span>
                                    </a>
                                </div>
                            <?php } ?>
                            <?php if($review->reviewed_by != $current_id){ ?>
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
                                <a class="white flag report btn-popup" href="#strain-share-review-<?= $review->id ?>">
                                    <i class="fa fa-share-alt" aria-hidden="true"></i><span>Share</span>
                                </a>
                            </div>
                            
                        </div>
                    </span>
                    <span class="date"><?php echo timeago($review->created_at); //timeZoneConversion($review->created_at, 'jS M Y', \Request::ip()); ?></span>
                </header>
                <p><?= $review->review; ?></p>
                <div class="videos">
                <?php if ($review->attachment) { ?>
                    <?php if ($review->attachment->type == 'image') { ?>
                            <div class="">
                                <?php $strain_sing_img = image_fix_orientation('public/images' . $review->attachment->attachment); ?>
                                <a href="<?php echo asset($strain_sing_img) ?>" class="" data-fancybox="gallery<?=$review->attachment->id?>" >
                                    <div class="ans-slide-image" style="background-image: url(<?php echo asset($strain_sing_img) ?>)"></div>
                                </a>
                                <!--<img src="<?php // echo asset('public/images' . $review->attachment->attachment) ?>" alt="Image" class="img-responsive">-->
                            </div>
                        <?php } else { ?>
                            <?php $strain_sing_post = 'public/images' . $review->attachment->poster ?>
                            <a href="#vids-<?=$review->attachment->id?>" data-fancybox="gallery<?=$review->attachment->id?>" >
                                <div class="ans-slide-image" style="background-image: url(<?php echo asset($strain_sing_post) ?>)">
                                    <i class="fa fa-play-circle" aria-hidden="true"></i>
                                </div>
                            </a>
                            <video width="320" height="240" poster="<?php echo asset('public/images' . $review->attachment->poster); ?>" controls="" id='vids-<?=$review->attachment->id?>' style="display: none;">
                                <source src="<?php echo asset('public/videos' . $review->attachment->attachment); ?>">
                                Your browser does not support the video tag.
                            </video>
                        <?php } ?>
                <?php } ?>
                </div>
                <?php if (Auth::user() &&  isset($review->rating->rating)) { ?>
                    <div class="stain-leaf right thumb-rev-right">
                        <div class="StainLeafWithThumb">
                                                                        <div class="adjust-thmb">
                                                                               <i  id="add_strain_review_like_<?= $review->id ?>" onclick="addremovelike('<?= $review->id ?>', '<?= $review->strain_id ?>', '1')" <?php if ($review->isReviewed) { ?> style="display: none; " <?php } else { ?> style="cursor: pointer" <?php } ?> class="fa fa-thumbs-up yellow_thumb"></i>
                                                                                <i  id="remove_strain_review_like_<?= $review->id ?>" onclick="addremovelike('<?= $review->id ?>', '<?= $review->strain_id ?>', '0')" <?php if (!$review->isReviewed) { ?> style="display: none;" <?php } else { ?> style="cursor: pointer" <?php } ?>class="fa fa-thumbs-up yellow_thumb active"></i>
                                                                                <span id="reviews_count_<?= $review->id ?>"><?= $review->likes->count()?></span>
                                                                        </div><div>
                        <img src="<?php echo asset('userassets/images/leaf-' . floorToFraction(number_format((float) $review->rating->rating, 1, '.', ''), 2) . '.svg') ?>" alt="Image" class="img-responsive">
                        <em><?= number_format((float) $review->rating->rating, 1, '.', ''); ?></em>
                    </div></div> </div>
                <?php } ?>

           
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
                        <a href="#" class="btn-close blue">x</a>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <!-- Share Strain Review Popup -->
        <div id="strain-share-review-<?= $review->id; ?>" class="popup">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="reporting-form">
                        <h2>Select an option</h2>
                        <div class="custom-shares custom_style">
                        <?php
                        echo Share::page(asset('strain-details/' . $review->strain_id), $review->review)
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
        <div id="delete_strain_review-<?php echo $review->id;?>" class="popup">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="text">
                        <div class="edit-holder">
                            <div class="step">
                                <div class="step-header">
                                    <h4>Delete Strain Review</h4>
                                    <p class="yellow no-margin">Are you sure to delete this review.</p>
                                </div>
                                <a href="<?php echo asset('delete-strain-review/'.$review->id.'/'.$review->strain_id); ?>" class="btn-heal">yes</a>
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