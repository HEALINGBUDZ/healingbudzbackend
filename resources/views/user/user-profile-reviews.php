<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); ?>
    <body>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <div class="new_container">
                        <ul class="bread-crumbs list-none">
                            <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                            <!--<li><a href="<?php // echo asset('questions');     ?>">Q&amp;A</a></li>-->
                            <li>Profile</li>
                        </ul>
                        <div class="profile-area star-adj-new">
                            <?php include 'includes/user-profile-header.php'; ?>
                            <div class="activity-area reviews-show-tog">
                                <div class="listing-area">
                                    <div class="tog-rev yellow">
                                        <img src="<?php echo asset('userassets/images/leaf-5.svg') ?>" alt="Icon"> My Strain Reviews
                                    </div>
                                    <ul class="list-none quest tog-sec" id="">
                                        <?php if (count($user->getUserStrainReviews) > 0) { ?>
                                            <?php foreach ($user->getUserStrainReviews as $strain_reviews) { ?>
                                                <li>
                                                    <input type="hidden" class="month_year" value="">
                                                    <div class="q-txt">
                                                        <div class="q-text-a">
                                                            <a href="<?php echo asset('strain-details/' . $strain_reviews->getStrain->id); ?>" target="_blank">
                                                                <span><img src="<?php echo asset('userassets/images/act-s.png') ?>" alt="Icon"></span>
                                                                <div class="my_answer">
                                                                    You reviewed a Strain
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="head-ques" target="_blank">
                                                            <span class="fa-icon"><i class="fa fa-external-link"></i></span><?php echo $strain_reviews->getStrain->title; ?>
                                                            <span class="descrip"><?php echo $strain_reviews->review; ?></span>
                                                        </div>
                                                        <span class="how-time">
                                                            <span class="hows-time"><?= timeago($strain_reviews->created_at); ?></span>
                                                            <div class="budz_map_rating">
                                                                <span class="t-leaf">
                                                                    <img src="<?php echo asset('userassets/images/leaf-' . floorToFraction(number_format((float) $strain_reviews->rating['rating'], 1, '.', ''), 2) . '.svg'); ?>" alt="Ratings">
                                                                    <span><?php echo number_format((float) $strain_reviews->rating['rating'], 1, '.', ''); ?></span>
                                                                </span>
                                                            </div>
                                                        </span>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        <?php } else { ?>
                                                <li class="hb_not_more_posts_lbl">No record found.</li>
                                        <?php } ?>
                                    </ul>
                                    <div class="tog-rev pin">
                                        <img src="<?php echo asset('userassets/images/star-big.png') ?>" alt="Icon"> My Budz Adz Reviews
                                    </div>
                                    <ul class="list-none quest tog-sec" id="">
                                        <?php if (count($user->getSubUserReviews) > 0) { ?>
                                            <?php foreach ($user->getSubUserReviews as $bdreview) { ?>
                                                <li>
                                                    <input type="hidden" class="month_year" value="">
                                                    <div class="q-txt">
                                                        <div class="q-text-a">
                                                            <a href="<?php echo asset('get-budz?business_id=' . $bdreview->bud->id . '&business_type_id=' . $bdreview->bud->business_type_id); ?>" target="_blank">
                                                                <span><img class="hb_round_img" src="<?php echo asset('userassets/images/budz-adz-thumbnail.svg') ?>" alt="Icon"></span>
                                                                <div class="my_answer">
                                                                    You reviewed a Budz Adz
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="head-ques" target="_blank">
                                                            <span class="fa-icon"><i class="fa fa-external-link"></i></span><?= $bdreview->bud->title ?>
                                                            <span class="descrip"><?php echo $bdreview->text ?></span>
                                                        </div>
                                                        <span class="how-time">
                                                            <span class="hows-time"><?= timeago($bdreview->created_at) ?></span>
                                                            <div class="budz_map_rating">
                                                                <?php if (isset($bdreview->rating)) { ?>
                                                                    <span class="t-star">
                                                                        <img src="<?php echo asset('userassets/images/rate2.png') ?>" alt="Ratings">
                                                                        <span><?php echo number_format((float) $bdreview->rating, 1, '.', ''); ?></span>
                                                                    </span>
                                                                <?php } ?>
                                                            </div>
                                                        </span>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        <?php } else { ?>
                                                <li class="hb_not_more_posts_lbl">No record found.</li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>  <div class="right_sidebars">
                        <?php if($current_user){ include 'includes/rightsidebar.php'; ?>
                        <?php include 'includes/chat-rightsidebar.php'; } ?>
                    </div>
                </div>
            </article>
        </div>
        <?php include('includes/footer.php'); ?>
        <?php include('includes/functions.php'); ?>
    </body>
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
                    alert('rated ' + currentRating);
                }
            });
            $('.tog-rev').click(function () {
                $(this).next('.tog-sec').slideToggle();
            });
        });
    </script>
</html>