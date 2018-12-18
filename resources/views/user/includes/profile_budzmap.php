<div id="proMaps" class="tab-pane fade">
    <div class="listing-area">
        <h3>My Favorite Map Listings</h3>
        <ul class="list-none">
            <?php foreach ($user->getSavedBudz as $budz_map) { 
                if($budz_map->getSubUser){
//     echo '<pre>';
//     print_r($user->getSavedBudz);exit;
                ?>
                <li>
                    <div class="listing-text">
                        <div class="img-holder">
                            <img src="<?php if(isset($budz_map->getSubUser->logo)){ echo getSubImage($budz_map->getSubUser->logo, ''); } ?>" alt="Image" class="img-responsive">
                            <!--<div class="caution"><img src="<?php // echo asset('userassets/images/icon-doc.png') ?>" alt="Image"></div>-->
                        </div>
                        <div class="listing-txt">
                            <span class="name"><?php echo $budz_map->getSubUser->getBizType->title; ?></span>
                            <a href="<?php   echo asset('get-budz?business_id='.$budz_map->getSubUser->id.'&business_type_id='.$budz_map->getSubUser->business_type_id); ?>" target="_blank" class="designation"><?php echo $budz_map->getSubUser->title; ?></a>
                            <div class="listing-info">
                                <span class="time"><?php echo round($budz_map->getSubUser->distance) . ' mi'; ?></span>
                                <div class="budz_rating" data-rating="<?php if ($budz_map->getSubUser->ratingSum) echo $budz_map->getSubUser->ratingSum->total; ?>"></div>
                                <a href="javascript:void(0)" class="review-link"><b><?php echo count($budz_map->getSubUser->review); ?></b> Reviews</a>
                            </div>
                            <ul class="features">
                                <?php    if($budz_map->getSubUser->is_organic){ ?>
                                <li><img src="<?php echo asset('userassets/images/icon-plant.svg') ?>" alt="Plant"></li>
                                <?php } if($budz_map->getSubUser->is_delivery){ ?>
                                <li><img src="<?php echo asset('userassets/images/icon-van.svg') ?>" alt="Van"></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </li>
                <?php }} ?>
        </ul>
    </div>
</div>