<div id="proReviews" class="tab-pane fade proReviews">
    <div class="listing-area">
        <div class="journal-set">
            <a href="#" class="journal-opener pink">Budz Adz Reviews</a>
            <ul class="list-none">
                <?php foreach ($user->getSubUserReviews as $bdreview) { ?>
                    <li>
                        <div class="listing-text">
                            <div class="img-holder">
                                <img src="<?php echo getSubImage($bdreview->bud->logo, '') ?>" alt="Image" class="img-responsive">
                                <div class="caution"><img src="<?php echo asset('userassets/images/' . $bdreview->bud->getBizType->title . '.svg') ?>" alt="Image"></div>
                            </div>
                            <div class="listing-txt">
                                <span class="name"><?php echo $bdreview->bud->getBizType->title;?></span>
                                <a href="<?php echo asset('get-budz?business_id='.$bdreview->bud->id.'&business_type_id='.$bdreview->bud->business_type_id); ?>" target="_blank" class="designation"><?php echo $bdreview->bud->title; ?></a>
                                <div class="listing-info">
                                    <span class="time"><?php echo round($bdreview->bud->distance)?> mi</span>
                                    <div class="budz_rating" data-rating="<?php if ($bdreview->bud->ratingSum) echo $bdreview->bud->ratingSum->total; ?>"></div>
                                    <a href="#" class="review-link"><b><?php echo count($bdreview->bud->review); ?></b> Reviews</a>
                                </div>
                                <ul class="features">
                                    <?php if($bdreview->bud->is_organic){ ?>
                                <li><img src="<?php echo asset('userassets/images/icon-plant.svg') ?>" alt="Plant"></li>
                                <?php } if($bdreview->bud->is_delivery){ ?>
                                <li><img src="<?php echo asset('userassets/images/icon-van.svg') ?>" alt="Van"></li>
                                <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-coments">
                            <div class="t-com">
                                <figure style="background-image: url(<?php echo getImage($bdreview->user->image_path, $bdreview->user->avatar);?>)"></figure>
                                <article>
                                    <div class="art-top">
                                        <div class="cus-col">
                                            <span class="time"><?php echo $newDate = date("jS M Y", strtotime( $bdreview->created_at));?></span>
                                            <p><?php echo $bdreview->text ?></p>
                                        </div>
                                        <?php if(isset($bdreview->rating) && $bdreview->rating > 0){ ?>
                                        <span class="t-star">
                                            <img src="<?php echo asset('userassets/images/rate2.png') ?>" alt="Ratings">
                                           <?php echo number_format((float) $bdreview->rating, 1, '.', ''); ?>
                                        </span>
                                        <?php } ?>
                                    </div>
                                    <div class="art-bottom">
                                        <a href="#" class="share-icon"><i class="fa fa-share-alt" aria-hidden="true"></i>Share</a>
                                        <div class="custom-shares">
                                            <?php echo Share::page( asset('get-budz?business_id='.$bdreview->bud->id.'&business_type_id='.$bdreview->bud->business_type_id), $bdreview->text,['class' => 'budz_review_class', 'id' => $bdreview->id])
                                                ->facebook($bdreview->text)
                                                ->twitter($bdreview->text)
                                                ->googlePlus($bdreview->text);
                                            ?>
                                            <?php if(Auth::user()){ ?>
                                            <div class="budz_review_class in_app_button" onclick="shareInapp('<?= asset('get-budz?business_id='.$bdreview->bud->id.'&business_type_id='.$bdreview->bud->business_type_id) ?>', '<?php echo trim(revertTagSpace($bdreview->text)); ?>', '<?= asset('userassets/images/logo-for-scrap.png') ?>')"> <span class="hb_icon_repost"></span> In App</div>
                                            <?php } ?>  </div>
                                        </div>
                                        <?php if($bdreview->reviewed_by != $current_id) { ?>
                                            <a href="#" class="flag"><i class="fa fa-flag"></i>Report Abuse</a>
                                        <?php } ?>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="journal-set t-strain">
            <a href="#" class="journal-opener t-strain">Strains Reviews</a>
            <ul class="list-none">
                <?php foreach ($user->getUserStrainReviews as $strain_reviews) { ?>
                <li>
                    <div class="listing-text">
                        <div class="img-holder">
                            <img src="<?php echo asset('userassets/images/icon03.svg') ?>" alt="Image" class="img-responsive">
                        </div>
                        <div class="listing-txt">
                            <span class="t-leaf">
                                <img src="<?php echo asset('userassets/images/leaf-' . floorToFraction(number_format((float) $strain_reviews->getStrain->ratingSum['total'], 1, '.', ''), 2) . '.svg'); ?>" alt="Ratings">
                                <span><?php echo number_format((float) $strain_reviews->getStrain->ratingSum['total'], 1, '.', '');?></span>
                            </span>
                            <a href="<?php echo asset('strain-details/'.$strain_reviews->getStrain->id); ?>" target="_blank" class="designation"><?php echo $strain_reviews->getStrain->title;?></a>
                            <span class="name"><?php echo $strain_reviews->getStrain->getType->title;?></span>
                        </div>
                    </div>
                    <div class="tab-coments">
                        <div class="t-com">
                            <figure style="background-image: url(<?php if(isset($strain_reviews->getUser->image_path)) { echo getImage($strain_reviews->getUser->image_path , $strain_reviews->getUser->avatar);}?>)"></figure>
                            <article>
                                <div class="art-top">
                                    <div class="cus-col">
                                        <span class="time"><?php echo $newDate = date("jS M Y", strtotime( $strain_reviews->created_at));?></span>
                                        <p><?php echo $strain_reviews->review;?></p>
                                    </div>
                                    <span class="t-star">
                                        <img src="<?php echo asset('userassets/images/leaf-' . floorToFraction(number_format((float) $strain_reviews->getStrain->ratingSum['total'], 1, '.', ''), 2) . '.svg'); ?>" alt="Ratings">
                                        <?php echo number_format((float) $strain_reviews->getStrain->ratingSum['total'], 1, '.', '');?>
                                    </span>
                                </div>
                                <div class="art-bottom">
                                    <a href="#" class="share-icon"><i class="fa fa-share-alt" aria-hidden="true"></i>Share</a>
                                        <div class="custom-shares">
                                            <?php echo Share::page( asset('strain-details/'.$strain_reviews->getStrain->id), $strain_reviews->getStrain->title)
                                                ->facebook($strain_reviews->getStrain->title)
                                                ->twitter($strain_reviews->getStrain->title)
                                                ->googlePlus($strain_reviews->getStrain->title);
                                            ?>
                                            <?php if(Auth::user()){ ?>
                                            <div class="in_app_button" onclick="shareInapp('<?= asset('strain-details/'.$strain_reviews->getStrain->id) ?>', '<?php echo trim(revertTagSpace($strain_reviews->getStrain->title)); ?>', '<?= asset('userassets/images/logo-for-scrap.png') ?>')"> <span class="hb_icon_repost"></span> In App</div>
                                            <?php } ?>  </div>
                                    <?php if($strain_reviews->reviewed_by != $current_id) { ?>
                                        <a href="#" class="flag"><i class="fa fa-flag"></i>Report Abuse</a>
                                    <?php } ?>
                                </div>
                            </article>
                        </div>
                    </div>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
<script> 
     
     $('.budz_review_class').unbind().click(function () {
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
            }
        });
    </script>