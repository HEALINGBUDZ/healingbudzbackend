<?php foreach($budzs as $key => $values){ ?>
    <?php if($last_month != $key){ ?>
        <div class="date-main-act">
            <i class="fa fa-calendar"></i>
            <span><?= $key ?></span>
        </div>
    <?php } ?>
<?php foreach ($values as $budz) { ?>
    <li>
        <input type="hidden" class="month_year" value="<?= $budz->month_year ?>">
        <div class="q-txt b-txt">
            <div class="q-text-a hb_budz_map_listing_title">
                <a href="<?php echo asset('get-budz?business_id='.$budz->id.'&business_type_id='.$budz->business_type_id);?>">
                    <!--<span><img src="<?php // echo getSubImage($budz->logo, '') ?>" alt="Icon" class="small-q"></span>-->
                    <span class="hb_budz_map_listing_icon"><figure class="img-round-my-bdz" style="background-image: url(<?php echo getSubImage($budz->logo, '') ?>);"></figure></span>
                    <div class="my_answer">
                        <?php echo $budz->title;?>
                        <?php  if($budz->getBizType) { ?>
                        <div class="b-hov">
                            <img src="<?php echo getBusinessTypeIcon($budz->getBizType->title); ?>" alt="Icon" />
                            <span><?php echo $budz->getBizType->title; ?></span>
                        </div>
                        <?php } ?>
                        <div class="tags-imgs">
                            <?php if ($budz->subscriptions) { ?>
                                <figure>
                                    <img src="<?php echo asset('userassets/images/featured.png'); ?>" alt="Icon" />
                                </figure>
                            <?php } ?>
                            <?php if ($budz->business_type_id == NULL || $budz->business_type_id == '') { ?>
                            <figure>
                                <img src="<?php echo asset('userassets/images/pending.png'); ?>" alt="Icon" />
                            </figure>
                            <?php } ?>
                        </div>
                        <span class="hows-time"><?= timeago($budz->created_at)?></span>
                    </div>
                </a>
            </div>
            <div class="head-ques">
                <div class="head-ques-a">
                    <div class="b-half">
                        <span class="designation">Description</span>
                        <span class="descrip"><?php echo $budz->description;?></span>
                        <?php if($budz->ratingSum){ ?>
                            <div class="budz_map_rating" data-rating="<?php echo $budz->ratingSum->total;?>"></div>
                        <?php } ?>
                        <a href="#" class="review-link"><b><?php echo count($budz->review); ?></b> Reviews</a>
                    </div>
                    <div class="b-half-l">
                        <ul class="features">
                            <?php if ($budz->is_organic && $budz->business_type_id !=9 ) { ?>
                            <li><img src="<?php echo asset('userassets/images/icon-plant.svg') ?>" alt="Plant"><span>Organic</span></li>
                            <?php } if ($budz->is_delivery && $budz->business_type_id !=9 ) { ?>
                            <li><img src="<?php echo asset('userassets/images/icon-van.svg') ?>" alt="Van"><span>We deliver</span></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <span class="how-time">
                <?php if(isset($_GET['page_name']) && $_GET['page_name'] == 'my_budz_map'){ ?>
                    <a href="<?php echo asset('budz-map-edit/'.$budz->id);?>">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                        Edit
                    </a>
                    <a href="#" data-toggle="modal" data-target="#delete_budz<?php echo $budz->id;?>">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                        Delete
                    </a>
                <?php } ?>
                <?php if ($budz->subscriptions) { ?>
                <a href="<?= asset('single-budz-stats/'.$budz->id)?>" class="answer-link">
                    <span><i class="fa fa-eye"></i></span>View Insight
                </a>
                 <?php } ?>
            </span>
        </div>
    </li>
        <div class="modal fade" id="delete_budz<?php echo $budz->id;?>" role="dialog">
            <div class="modal-dialog">
            <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Delete Budz </h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to delete this budz <?php echo $budz->question;?></p>
                    </div>
                    <div class="modal-footer">
                        <a href="<?php echo asset('delete-budz/'.$budz->id);?>" type="button" class="btn-heal">yes</a>
                        <button data-dismiss="modal" type="button" class="btn-heal">No</button>
                    </div>
                </div>
            </div>
        </div>
<?php } }?>