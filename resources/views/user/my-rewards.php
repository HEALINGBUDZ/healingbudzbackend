<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top.php'); ?>
    <body id="body">
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <ul class="bread-crumbs list-none">
                        <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                        <li>Strains</li>
                    </ul>
                    <div class="new_container">
                        <div class="clearfix">
                            <h2 class="hb_page_top_title hb_text_green hb_text_uppercase no-margin">Rewards Summary</h2>
                            <span style="display: block; padding: 5px 0;">This is the detail of rewards summary</span>
                        </div>
                        <div class="rewards-top pd-top">
                            <div class="reward-top-inner">
                                <div class="rewards-section reward-green">
                                    <div class="inner-section">
                                        <div class="inner-rewards reward-icon">
                                            <div class="wid_info">
                                                <a href="javascript:void(0)">
                                                    <img src="<?php echo asset('userassets/img/reward.png') ?>" alt="Icon" class="img-user">
                                                    <strong>Your Current Reward Points 
                                                        <span class="color white" style="font-size:  35px;padding: 10px 0;"><?= $current_user->points - $current_user->point_redeem ?></span></strong>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="inner-rewards redeem-right">

                                            <a href="<?php echo asset('store-products') ?>" class="coming-soon"><button class="redeem-btn">REDEEM</button></a>

                                        </div>
                                    </div>
                                    
                                    <div class=""><p><em>Get you HB swag on. <br/>
                                                Redeem points for branded merchandise, accessories, product discount and more. <br/><br/> Coming soon! </em></p></div>
                                    
                                    
                                    

                                </div>
                                <?php $points = $current_user->userPoints->sortByDesc('created_at')->take(3);
                                if(count($points) > 0) {?>
                                <div class="rewards-section point-logtable"> 
                                    <strong>POINT LOG TABLE</strong>
                                    <div class="all-log">
                                        <?php foreach ($points as $point) {
                                            ?>

                                            <div class="logtable">
                                                <div class="inner-rewards">
                                                    <div class="wid_info">
                                                        <a href="javascript:void(0)">
                                                            <i class="fa fa-star color green-light"></i>
                                                            <strong><?= $point->type ?>
                                                                <span><?= date("d-m-Y", strtotime($point->created_at)); ?></span></strong>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="inner-rewards">
                                                    <span class="color green-light points">+ <?= $point->points ?> pts</span>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div><a href="<?= asset('reward-log') ?>" class="view-all">View All</a></div>
                                    </div>
                                </div>
                              <?php }?>
                            </div>
                            <div class="groups add reward-box">
                                <h2><center>GET <span class="color light-green">350 FREE</span> REWARD POINTS</center></h2>
                                <?php /* <div class="reward-row">
                                  <div class="all-pts">
                                  <div class="outer-pts">
                                  <div class="inner-pts">
                                  <span class="point-digit color green-light">+ 50</span>
                                  <span>complete your profile.</span>
                                  </div>
                                  <?php if ($user) { ?>
                                  <div class="inner-pts invite-friend"><i class="fa fa-check"></i>      </div>
                                  <?php } else { ?>
                                  <div class="inner-pts invite-friend reward-go">  <a href="<?= asset('profile-setting') ?>"> <span>Go</span></a></div>
                                  <?php } ?>
                                  </div>
                                  </div>
                                  <div class="all-pts go-pts">
                                  <div class="outer-pts">
                                  <div class="inner-pts">
                                  <span class="point-digit color green-light">+ 50</span>
                                  <span>Invite a Friend.</span>
                                  </div>
                                  <div class="inner-pts invite-friend reward-go"><a href="javascript:void(0)"><span>Go</span></a></div>
                                  </div>
                                  </div>
                                  <div class="all-pts">
                                  <div class="outer-pts">
                                  <div class="inner-pts">
                                  <span class="point-digit color green-light">+ 50</span>
                                  <span>Follow a Bud.</span>
                                  </div>
                                  <?php if ($following) { ?>
                                  <div class="inner-pts invite-friend"><i class="fa fa-check"></i>      </div>
                                  <?php } else { ?>
                                  <div class="inner-pts invite-friend reward-go"> <a href="javascript:void(0)"><span>Go</span></a></div>
                                  <?php } ?>
                                  </div>
                                  </div>
                                  <div class="all-pts go-pts">
                                  <div class="outer-pts">
                                  <div class="inner-pts">
                                  <span class="point-digit color green-light">+ 50</span>
                                  <span>Ask your first question.</span>
                                  </div>

                                  <?php if ($question) { ?>
                                  <div class="inner-pts invite-friend"><i class="fa fa-check"></i>      </div>
                                  <?php } else { ?>
                                  <div class="inner-pts invite-friend reward-go"> <a href="<?= asset('questions') ?>"> <span>Go</span></a></div>
                                  <?php } ?>

                                  </div>
                                  </div>
                                  </div> */ ?>

                                <?php /* <div class="reward-row">
                                  <div class="all-pts go-pts">
                                  <div class="outer-pts">
                                  <div class="inner-pts">
                                  <span class="point-digit color green-light">+ 50</span>
                                  <span>Survey a Strain.</span>
                                  </div>

                                  <?php if ($strain) { ?>
                                  <div class="inner-pts invite-friend"><i class="fa fa-check"></i>      </div>
                                  <?php } else { ?>
                                  <div class="inner-pts invite-friend reward-go"><a href="<?= asset('strains-list') ?>"><span>Go</span></a></div>
                                  <?php } ?>

                                  </div>
                                  </div>

                                  <div class="all-pts go-pts">
                                  <div class="outer-pts">
                                  <div class="inner-pts">
                                  <span class="point-digit color green-light">+ 50</span>
                                  <span>Follow a keyword.</span>
                                  </div>

                                  <?php if ($tag) { ?>
                                  <div class="inner-pts invite-friend"><i class="fa fa-check"></i>      </div>
                                  <?php } else { ?>
                                  <div class="inner-pts invite-friend reward-go">  <a href="<?= asset('questions') ?>"> <span>Go</span></a></div>
                                  <?php } ?>
                                  </div>
                                  </div>
                                  <div class="all-pts go-pts">
                                  <div class="outer-pts">
                                  <div class="inner-pts">
                                  <span class="point-digit color green-light">+ 50</span>
                                  <span>Share a posted question.</span>
                                  </div>

                                  <?php if ($share_question) { ?>
                                  <div class="inner-pts invite-friend"><i class="fa fa-check"></i>      </div>
                                  <?php } else { ?>
                                  <div class="inner-pts invite-friend reward-go">  <a href="<?= asset('questions') ?>"> <span>Go</span></a></div>
                                  <?php } ?>
                                  </div>
                                  </div>
                                  <div class="all-pts">
                                  <div class="outer-pts">
                                  <div class="inner-pts">
                                  <span class="point-digit color green-light">+ 50</span>
                                  <span>Join a group.</span>
                                  </div>

                                  <div class="inner-pts invite-friend"><i class="fa fa-check"></i></div>

                                  </div>
                                  </div>
                                  </div> */ ?>
                                <div class="reward-row">
                                    <?php
                                    foreach ($rewards as $reward) {
                                        if ($reward->title == "Ask Question" || $reward->title == "Share Question") {
                                            $url = asset('questions');
                                        }
                                        if ($reward->title == "Complete Profile") {
                                            $url = asset('profile-setting');
                                        }
                                        if ($reward->title == "Follow Bud") {
                                            $url = asset('budz-follow');
                                        }
                                        if ($reward->title == "Follow Keyword") {
                                            $url = asset('all-tags');
                                        }
                                        if ($reward->title == "Invite Friend") {
                                            $url = asset('support_from_reward');
                                        }if ($reward->title == "Strain Survey") {
                                            $url = asset('strains-list?filter=alphabetically');
                                        }
                                        ?>
                                        <div class="all-pts">
                                            <div class="outer-pts">
                                                <div class="inner-pts">
                                                    <span class="point-digit color green-light">+ <?= $reward->points; ?></span>
                                                    <span><?= $reward->title; ?></span>
                                                </div>
                                                <?php if ($reward->user_rewards_count > 0) { ?> 
                                                    <div class="inner-pts invite-friend"><i class="fa fa-check"></i>      </div>
                                                <?php } else { ?>
                                                    <div class="inner-pts invite-friend reward-go">  <a href="<?= $url ?>"> <span>Go</span></a></div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="reward-row">
                                    <div class="product-row" id="product_listing">
                                        <h3 class="color light-green">Your Redeem Products</h3> 
                                        <div class="reward-red">
                                            <?php if (count($redeem_products) > 0) { ?>
                                                <?php foreach ($redeem_products as $redeem_product) { ?>
                                                    <div class="box">
                                                        <figure style="background-image: url(<?php echo asset('public/images' . $redeem_product->getProduct->attachment) ?>)"></figure>
                                                        <!--<img src="<?php // echo asset('public/images'.$redeem_product->getProduct->attachment)  ?>" width="100%" >-->
                                                        <p><?php echo $redeem_product->getProduct->name; ?></p>
                                                        <p class="color light-green prod-points"><i class="fa fa-star"></i> <?php echo $redeem_product->getProduct->points; ?> points</p>
                                                        <p class="redeam-date">Redeam Date: <?php echo date('d-m-Y', strtotime($redeem_product->created_at)); ?></p>
                                                    </div>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <div id="loading" class="hb_not_more_posts_lbl">No result found </div>
                                            <?php } ?>

                                            <div style="display: none" class="hb_not_more_posts_lbl" id="loading">Load more</div>
                                        </div>
                                    </div>

                                </div>
                                <div class="accordion">
                                    <h3 class="color green-light">FAQ'S</h3>
                                    <div class="accordion-item">
                                        <a>Why is the moon sometimes out during the day?</a>
                                        <div class="content">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Elementum sagittis vitae et leo duis ut. Ut tortor pretium viverra suspendisse potenti.</p>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <a>Why is the sky blue?</a>
                                        <div class="content">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Elementum sagittis vitae et leo duis ut. Ut tortor pretium viverra suspendisse potenti.</p>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <a>Will we ever discover aliens?</a>
                                        <div class="content">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Elementum sagittis vitae et leo duis ut. Ut tortor pretium viverra suspendisse potenti.</p>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <a>How much does the Earth weigh?</a>
                                        <div class="content">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Elementum sagittis vitae et leo duis ut. Ut tortor pretium viverra suspendisse potenti.</p>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <a>How do airplanes stay up?</a>
                                        <div class="content">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Elementum sagittis vitae et leo duis ut. Ut tortor pretium viverra suspendisse potenti.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- FAQ -->
                        </div>
                    </div>
                    <div class="right_sidebars">
                        <?php include 'includes/rightsidebar.php'; ?>
                        <?php include 'includes/chat-rightsidebar.php'; ?>
                    </div>
                    <!--<a href="#add-ticket" class="btn-popup btn-primary">Add Popup</a>-->

            </article>
        </div>
        <?php include('includes/footer.php'); ?>

    </body>
    <script type="text/javascript">

        const items = document.querySelectorAll(".accordion a");

        function toggleAccordion() {
            this.classList.toggle('active');
            this.nextElementSibling.classList.toggle('active');
        }

        items.forEach(item => item.addEventListener('click', toggleAccordion));
    </script>


</html>