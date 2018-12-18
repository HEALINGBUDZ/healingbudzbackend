<?php if (count($sub_users) > 0) {
    foreach ($sub_users as $sub_user) { ?>
        <li class="subusers <?php if ($sub_user->subscriptions) { ?> filter-black <?php } ?>" data-filter="<?php
        if ($sub_user->getBizType) {
            echo $sub_user->getBizType->title;
        }
        ?>">
            <div class="listing-txt">
                <a href="<?php echo asset('get-budz?business_id=' . $sub_user->id . '&business_type_id=' . $sub_user->business_type_id); ?>" class="listing-text image-inner-anch">
                    <div class="img-holder hb_round_img" style="background-image: url(<?php echo getSubImage($sub_user->logo, '') ?>)">
                        <!--<img src="<?php //echo asset('userassets/images/' . $sub_user->getBizType->title . '.svg')   ?>" alt="Docter" class="sub-image" />-->
                        <img src="<?php echo getBusinessTypeIcon($sub_user->getBizType->title); ?>" alt="Docter" class="sub-image" />
                    </div>
                    <span class="name"><?php
                        if ($sub_user->getBizType) {
                            echo $sub_user->getBizType->title;
                        }
                        ?></span>
                    <span class="designation"><?php echo $sub_user->title; ?></span>
                </a>
                <ul class="features">
                    <?php if ($sub_user->is_organic) { ?>
                        <li><img src="<?php echo asset('userassets/images/icon-plant.svg') ?>" alt="Plant"> Organic</li>
                    <?php } if ($sub_user->is_delivery) { ?>
                        <li><img src="<?php echo asset('userassets/images/icon-van.svg') ?>" alt="Van"> We Deliver</li>
        <?php } ?>
                </ul>
                <div class="listing-info">
                    <span class="time"><img src="<?php echo asset('userassets/images/pin-pink.png') ?>" alt="Plant"> <?php echo round($sub_user->distance,2); ?> miles away</span>
                </div>
                <div class="listing-info li-in-right">
                    <div class="budz_rating" data-rating="<?php if ($sub_user->ratingSum) echo $sub_user->ratingSum->total; ?>"></div>
                    <b><?php echo count($sub_user->review); ?></b> Reviews
                </div>
            </div>
        </li>
    <?php } ?>  
    <script>
        $(document).ready(function () {
            $(".budz_rating").starRating({
                totalStars: 5,
                emptyColor: '#1e1e1e',
                hoverColor: '#e070e0',
                activeColor: '#e070e0',
                strokeColor: "#e070e0",
                strokeWidth: 20,
                useGradient: false,
                readOnly: true,
                useFullStars:true,
                initialRating:5,
                callback: function (currentRating, $el) {
                  
                }
            });
        });
    </script>
<?php } ?>