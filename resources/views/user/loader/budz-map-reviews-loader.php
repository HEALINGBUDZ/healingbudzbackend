<?php foreach ($reviews as $review) { ?>
    <?php if($review->reviewed_by == $current_id){
        $user_review_count ++;
    } ?>
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
                            
                        <input type="radio" name="group" id="abused<?= $review->id ?>"  value="Offensive">
                        <label for="abused<?= $review->id ?>">Budz adz review is Offensive</label>
                        <input type="radio" name="group" id="spam<?= $review->id ?>" value="Spam">
                        <label for="spam<?= $review->id ?>">Spam</label>
                        <input type="radio" name="group" id="unrelated<?= $review->id ?>" value="Unrelated">
                        <label for="unrelated<?= $review->id ?>">Unrelated</label>
                        <input type="submit" value="Report budz adz review">
                        <a href="#" class="btn-close">x</a>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>

    <div class="bus-rev-bot">
        <div class="cus-col">
            <div class="rev-row">
                <figure class="cir-img" style="background-image: url(<?php echo getImage($review->user->image_path, $review->user->avatar) ?>);"></figure>
                <article>
                    <div class="art-top">
                        <div class="art-top-row">
                            <span class="rev-title"><a class="<?= getRatingClass($review->user->points) ?>"  href="<?= asset('user-profile-detail/' . $review->user->id) ?>"><?php echo $review->user->first_name; ?></a></span>
                            <!--<span class="time"><?php //echo $newDate = date("jS M Y", strtotime($review->created_at));  ?></span>-->
                            <span class="time"><?php echo $newDate = timeZoneConversion($review->created_at, 'jS M Y', \Request::ip()); ?></span>
                            <p><?php echo $review->text; ?></p>

                            <?php foreach ($review->attachments as $attachment) { ?>
                                <?php if ($attachment->type == 'image') { ?>
                                    <?php $budz_sing_img = image_fix_orientation('public/images' . $attachment->attachment); ?>
                                    <a href="<?php echo asset($budz_sing_img) ?>" class="" data-fancybox="gallery<?=$review->attachment->id?>" >
                                        <div class="ans-slide-image" style="background-image: url(<?php echo asset($budz_sing_img) ?>)"></div>
                                    </a>
                                    <!--<img src="<?php // echo asset('public/images' . $attachment->attachment); ?>" alt="image"/>-->
                                <?php } else { ?>
                                    <?php $budz_sing_post = 'public/images' . $review->attachment->poster ?>
                                    <a href="#vids-<?=$review->attachment->id?>" data-fancybox="gallery<?=$review->attachment->id?>" >
                                        <div class="ans-slide-image" style="background-image: url(<?php echo asset($budz_sing_post) ?>)">
                                            <i class="fa fa-play-circle" aria-hidden="true"></i>
                                        </div>
                                    </a>
                                    <video width="320" height="240" poster="<?php echo asset('public/images' . $attachment->poster); ?>" controls="" id="vids-<?=$review->attachment->id?>" style="display: none;">
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
                            <i class="fa fa-star"></i> <?php echo number_format((float) $review->rating, 0, '.', ''); ?>
                        </span>
                       
                    </div>
                    <div class="art-bottom">
                        <div class="p-relative">
                            <a href="#" class="share-icon small"><i class="fa fa-share-alt" aria-hidden="true"></i>Share</a>
                            <div class="custom-shares">
                                <?php
                                $url_to_share= urlencode(asset("get-budz?business_id=".$sub_user->id."&business_type_id=".$sub_user->business_type_id));
                                echo Share::page($url_to_share, $review->review)
                                        ->facebook($review->review)
                                        ->twitter($review->review)
                                        ->googlePlus($review->review);
                                ?>
                                <?php if(Auth::user()){ ?>
                            <div class="budz_review_class in_app_button" onclick="shareInapp('<?= asset("get-budz?business_id=" . $sub_user->id . "&business_type_id=" . $sub_user->business_type_id) ?>', '<?php echo trim(revertTagSpace($sub_user->title)); ?>', '<?= asset('userassets/images/logo-for-scrap.png') ?>')"> <span class="hb_icon_repost"></span> In App</div>
                                <?php } ?>           </div>
                            <div class="new_custom_links">
                                <?php if(Auth::user() && $review->reviewed_by == $current_id){ ?>
                                <a href="<?php echo asset('edit-budzmap-review-reply/' . $review->id . '/' . $business_id . '/' . $business_type_id) ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                    <a href="#delete_budz_review<?php echo $review->id;?>" class="btn-popup">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </a>
                                    <!-- Modal -->
                                    <div id="delete_budz_review<?php echo $review->id;?>" class="popup">
                                        <div class="popup-holder">
                                            <div class="popup-area">
                                                <div class="text">
                                                    <div class="edit-holder">
                                                        <div class="step">
                                                            <div class="step-header">
                                                                <h4>Delete Bud Review</h4>
                                                                <p class="yellow no-margin">Are you sure to delete this review.</p>
                                                            </div>
                                                            <a href="<?php echo asset('delete-budmap-review/'.$review->id.'/'.$_GET['business_id'].'/'.$_GET['business_type_id']); ?>" class="btn-heal">yes</a>
                                                            <a href="#" class="btn-heal btn-close">No</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php if($review->reviewed_by != $current_id){ ?>
                            <a href="javascript:void(0)"  id="budz_review_reported<?php echo $review->id; ?>" <?php if (count($review->reports) > 0) {
                                        echo 'style="display: block"';
                                    } else {
                                        echo 'style="display: none"';
                                    } ?>class="flag active">
                                <i class="fa fa-flag"></i>Report Abuse
                            </a>
                            <a href="#review-flag<?= $review->id ?>" class="report btn-popup flag" id="budz_review<?php echo $review->id; ?>" <?php if (count($review->reports) == 0) {
                                        echo 'style="display: block"';
                                    } else {
                                        echo 'style="display: none"';
                                    } ?>>
                                <i class="fa fa-flag"></i>Report Abuse
                            </a>
                        <?php } ?>
                       
                    </div>
                    <div class="art-reply">
                        <?php if ($review->reply) { ?>
                            <h4>Reply</h4>
                            <span class="time"><?php echo $newDate = timeZoneConversion($review->reply->created_at, 'jS M Y', \Request::ip()); ?></span>
                            <p><?php echo $review->reply->reply; ?></p>
                        <?php }else if($sub_user->user_id == $current_id){ ?>
                            <h4>Reply</h4>
                            <form method="post" action="<?php echo asset('add-budzmap-review-reply'); ?>" id="reply-form" >
                                <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                <input type="hidden" name="review_id" value="<?= $review->id ?>">
                                <div class="bus-txt-area">
                                    <textarea name="reply" maxlength="500" placeholder="Type your reply here.." id="add_reply" required=""></textarea>
                                    <span class="reply-chars-counter">Max. 500 Characters</span>
                                </div>
                                <div class="bus-submit">
                                    <input type="submit" value="SUBMIT REPLY" />
                                </div>
                            </form>
                        <?php } ?>
                    </div>
                </article>
            </div>
        </div>
    </div>
<?php } ?>