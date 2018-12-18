<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); ?>
    <body class="settings-page">
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <div class="new_container">
                    <header class="intro-header no-bg">
                        <h1 class="custom-heading white">Business Listing Settings</h1>
                    </header>
                    <div class="set-bus-list">
                        <h4>Your Subscriptions</h4>
                        <ul>
<!--                            <li>Premium <a href="#" class="mem-btn">Cancel Membership</a></li>
                            <li>Next billing date <span class="bus-list-right">20 May 2017</span></li>-->
                            <li>Monthly <span class="bus-list-right">$29.95 /per m</span>
                                <p>Membership fees are billed at the beginning of each period and may take a few days after the billing date to appear on your account.</p>
                            </li>
                            <li>3 Months <span class="bus-list-right">$19.95 /per m</span>
                                <p>Membership fees are billed at the beginning of each period and may take a few days after the billing date to appear on your account.</p>
                            </li>
                            <li>Annually <span class="bus-list-right">$15.95 /per m</span>
                                <p>Membership fees are billed at the beginning of each period and may take a few days after the billing date to appear on your account.</p>
                            </li>
                        </ul>
                        <?php if (Session::has('success')) { ?>
                            <h6 class="alert alert-success alert-dismissible" id="success_message"> <?php echo Session::get('success'); ?><span id="success_message_close" class="close" onclick="close_success_message()">x</span></h6>
                        <?php } ?>
                        <h4>My Business</h4>
                        <div class="listing-area">
                            <ul class="list-none">
                                <?php foreach ($budzs as $budz) { ?>
                                <li>
                                    <div class="listing-text">
                                        <div class="img-holder">
                                            <img src="<?php echo getSubImage($budz->logo, '') ?>" alt="Image" style="height: 100%" class="img-responsive hb_round_img">
                                            <!--<div class="caution"><img src="<?php // echo asset('userassets/images/icon-doc.png') ?>" alt="Image"></div>-->
                                        </div>
                                        <div class="listing-txt">
                                            <span class="name"><?php  if($budz->getBizType) { echo $budz->getBizType->title;} ?></span>
                                            <span class="designation"> <?php echo $budz->title;?></span>
                                            <div class="listing-info">
                                                <span class="time"> <?php echo round($budz->distance,2);?> mil</span>
                                                <ul class="ratings list-none">
                                                   <div class="budz_rating" data-rating="<?php if ($budz->ratingSum) {echo $budz->ratingSum->total;} ?>"></div>
                                                </ul>
                                                <a href="#" class="review-link"><b><?php echo $budz->review_count; ?></b> Reviews</a>
                                            </div>
                                            <ul class="features">
                                                <?php if ($budz->is_organic) { ?>
                                                <li><img src="<?php echo asset('userassets/images/icon-plant.svg') ?>" alt="Plant"></li>
                                                 <?php } if ($budz->is_delivery) { ?>
                                                <li><img src="<?php echo asset('userassets/images/icon-van.svg') ?>" alt="Van"></li>
                                                <?php } ?>
                                            </ul>
                                            <?php
                                            $account_name='';
                                            if($budz->name == 'monthly_plan'){
                                                $account_name='Monthly';
                                            }
                                            if($budz->name == 'three_months'){
                                             $account_name='3 Months';   
                                            }
                                            if($budz->name == 'annually'){
                                               $account_name='Annually'; 
                                            }
                                            ?>
                                            <div class="bus-bottom-btn">
                                                <a href="<?php echo asset('budz-map-edit/'.$budz->id);?>">Update<i class="fa fa-pencil"></i></a>
                                                <a href="<?php echo asset('invoices/'.$budz->id);?>">Mail Receipt<i class="fa fa-envelope-o"></i></a>
                                                <a href="javascript:void(0)"><?= $account_name?><i class="fa fa-money"></i></a>
                                                <?php if($budz->subscriptions->ends_at){ ?>
                                                <a href="javascript:void(0)">Canceled End On <?= $budz->subscriptions->ends_at ?></a>
                                                <?php } else{ ?>
                                                <a href="<?php echo asset('cancel-subscription/'.$budz->id);?>">Cancel<i class="fa fa-pencil"></i></a>
                                                <?php } ?>
                                                <span><?php if($budz->s_id){    echo 'Premium';}else{    echo 'Free';} ?> </span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                    <div class="right_sidebars">
                        <?php include 'includes/rightsidebar.php'; ?>
                        <?php include 'includes/chat-rightsidebar.php';?>
                    </div>
                </div>
            </article>
        </div>
        <?php include('includes/footer.php'); ?>
<script>   
 $(".budz_rating").starRating({
                totalStars: 5,
                emptyColor: '#1e1e1e',
                hoverColor: '#e070e0',
                activeColor: '#e070e0',
                strokeColor: "#e070e0",
                strokeWidth: 20,
                useGradient: false,
                readOnly: true,
            });  
</script>
    </body>

</html>