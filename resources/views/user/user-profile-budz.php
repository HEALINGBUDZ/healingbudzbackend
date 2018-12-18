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
                            <!--<li><a href="<?php // echo asset('questions');            ?>">Q&amp;A</a></li>-->
                            <li>Profile</li>
                        </ul>
                        <div class="profile-area">

                            <?php include 'includes/user-profile-header.php'; ?>
                            <div class="activity-area">
                                <div class="listing-area">
                            <!--<h1 class="custom-heading white text-center"><img src="<?php // echo asset('userassets/images/icon03.svg')         ?>" alt="Icon"><span class="top-padding">My Strains</span></h1>-->

                                    <ul class="list-none quest hb_budz_map_listing" id="budz_map_listing">
                                        <?php if (count($budzs)) { ?>
                                            <?php foreach ($budzs as $key => $values) { ?>
                                                <div class="date-main-act">
                                                    <i class="fa fa-calendar"></i> 
                                                    <span><?= $key ?></span>
                                                </div>
                                                <?php foreach ($values as $budz) { ?>
                                                    <li>

                                                        <input type="hidden" class="month_year" value="<?= $budz->month_year ?>">
                                                        <div class="q-txt b-txt">
                                                            <div class="q-text-a hb_budz_map_listing_title">
                                                                <a href="<?php echo asset('get-budz?business_id=' . $budz->id . '&business_type_id=' . $budz->business_type_id); ?>">
                                                                    <!--<span><img src="<?php // echo getSubImage($budz->logo, '')        ?>" alt="Icon" class="small-q"></span>-->
                                                                    <span class="hb_budz_map_listing_icon"><figure class="img-round-my-bdz" style="background-image: url(<?php echo getSubImage($budz->logo, '') ?>);"></figure></span>
                                                                    <div class="my_answer">
                                                                        <?php echo $budz->title; ?>
                                                                        <?php if ($budz->getBizType) { ?>
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
                                                                        <span class="hows-time"><?= timeago($budz->created_at) ?></span>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                            <div class="head-ques">
                                                                <div class="head-ques-a">
                                                                    <div class="b-half">
                                                                        <span class="designation">Description</span>
                                                                        <span class="descrip"><?php echo $budz->description; ?></span>
                                                                        <?php if ($budz->ratingSum) { ?>
                                                                            <div class="budz_map_rating" data-rating="<?php echo $budz->ratingSum->total; ?>"></div>
                                                                        <?php } ?>
                                                                        <a href="#" class="review-link"><b><?php echo count($budz->review); ?></b> Reviews</a>
                                                                    </div>
                                                                    <div class="b-half-l">
                                                                        <ul class="features">
                                                                            <?php if ($budz->is_organic) { ?>
                                                                                <li><img src="<?php echo asset('userassets/images/icon-plant.svg') ?>" alt="Plant"><span>Organic</span></li>
                                                                            <?php } if ($budz->is_delivery) { ?>
                                                                                <li><img src="<?php echo asset('userassets/images/icon-van.svg') ?>" alt="Van"><span>We deliver</span></li>
                                                                            <?php } ?>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <span class="how-time">
                <!--                                                    <a href="<?php echo asset('budz-map-edit/' . $budz->id); ?>">
                                                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                                                        Edit
                                                                    </a>-->
                <!--                                                <a href="#" data-toggle="modal" data-target="#delete_budz<?php echo $budz->id; ?>">
                                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                                    Delete
                                                                </a>-->
                                                                <?php if ($current_id == $budz->user_id && $budz->subscriptions) { ?>
                                                                    <a href="<?= asset('single-budz-stats/' . $budz->id) ?>" class="answer-link">
                                                                        <span><i class="fa fa-eye"></i></span>View Insight
                                                                    </a>
                                                                <?php } ?>
                                                            </span>
                                                        </div>
                                                    </li>
                                                    <div class="modal fade" id="delete_budz<?php echo $budz->id; ?>" role="dialog">
                                                        <div class="modal-dialog">
                                                            <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    <h4 class="modal-title">Delete Budz </h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Are you sure to delete this budz <?php echo $budz->question; ?></p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <a href="<?php echo asset('delete-budz/' . $budz->id); ?>" type="button" class="btn-heal">yes</a>
                                                                    <button data-dismiss="modal" type="button" class="btn-heal">No</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        <?php } else { ?>
                                            <div class="loader hb_not_more_posts_lbl" id="loading_budz">No more budz to show</div> 
                                        <?php } ?>
                                    </ul>
                                    <div style="display: none" class="hb_simple_loader" id="loading"><img src="<?php echo asset('userassets/images/new_loadeer.svg') ?>" alt="Loading . . . ." class="post-loader"><span></span></div>
                                </div>
                            </div>
                        </div>
                    </div>  <div class="right_sidebars">
                        <?php if ($current_user) {
                            include 'includes/rightsidebar.php'; ?>
    <?php include 'includes/chat-rightsidebar.php';
} ?>
                    </div>
                </div>
            </article>
        </div>
<?php include('includes/footer.php'); ?>
<?php include('includes/functions.php'); ?>
    </body>
    <script>
        $(document).ready(function () {
            $(".budz_map_rating").starRating({
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
    <script>
        var win = $(window);
        var count = 1;
        var ajaxcall = 1;
//        var sorting = '<?php //echo $sorting         ?>';
//        var q = '<?php //echo $q         ?>';
        win.on('scroll', function () {
            var docheight = parseInt($(document).height());
            var winheight = parseInt(win.height());
            var differnce = (docheight - winheight) - win.scrollTop();
            if (differnce < 100) {
                if (ajaxcall === 1) {
                    $('#loading').show();
                    var last_month = $('.month_year').last().val();
                    ajaxcall = 0;
                    $.ajax({
                        url: "<?php echo asset('get-user-budzmap-loader/'.$user->id) ?>",
                        type: "GET",
                        data: {
                            "count": count,
                            "last_month": last_month
//                            "sorting":sorting,
//                            "q":q
                        },
                        success: function (data) {
                            if (data) {
                                var a = parseInt(1);
                                var b = parseInt(count);
                                count = b + a;
                                $('#budz_map_listing').append(data);
                                $('#loading').hide();
                                ajaxcall = 1;
                            } else {
                                $('#loading_budz').hide();
                                $('#loading').hide();
                                noposts = ' <div class="loader hb_not_more_posts_lbl" id="nomoreposts">No more budz to show</div> ';
                                $('#budz_map_listing').append(noposts);
                            }
                        }
                    });
                }

            }
        });
    </script>
</html>