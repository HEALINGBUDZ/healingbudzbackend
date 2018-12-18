<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top.php'); ?>
    <body>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <div class="new_container">
                        <div class="ask-area">
                            <?php include('includes/strain-header.php'); ?>
                            <?php $strain_id = $strain->id; ?>
                            <div class="tabbing str-tb-up">
                                <ul class="tabs list-none">
                                    <li class="active first"><a href="#strain-overview">Strain Overview</a></li>
                                    <li class="second"><a href="<?php echo asset('user-strains-listing/' . $strain->id); ?>">Strain Details</a></li>
                                    <?php if (isset($_GET['q'])) { ?>
                                        <li class="third"><a href="<?php echo asset('strain-gallery/' . $strain->id . '?q=' . $_GET['q']); ?>">Gallery</a></li>
                                        <?php if (Auth::user()) { ?>
                                            <li class="fourth"><a href="<?php echo asset('strain-product-listing/' . $strain->id . '?q=' . $_GET['q']); ?>">Locate This</a></li>
                                        <?php } else { ?>
                                            <li class="fourth"><a href="#loginModal" class="new_popup_opener">Locate This</a></li>   
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <!--<li class="third"><a href="#strain-overview">Gallery</a></li>-->
                                        <li class="third"><a href="<?php echo asset('strain-gallery/' . $strain->id); ?>">Gallery</a></li>
                                        <?php if (Auth::user()) { ?>
                                            <li class="fourth"><a href="<?php echo asset('strain-product-listing/' . $strain->id); ?>">Locate This</a></li>
                                        <?php } else { ?>
                                            <li class="fourth"><a href="#loginModal" class="new_popup_opener">Locate This</a></li>   
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                                <?php if (\Session::has('success')) { ?>
                                    <div id="success_id" class="alert alert-success alert-dismissable">
                                        <a onclick="hideDiv()" href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Success!</strong> <?php echo \Session::get('success'); ?>
                                    </div>
                                <?php } ?>
                                <div id="tab-content">
                                    <div id="strain-overview" class="tab active">
                                        <div class="tab-wid no-border strain-des-sec">
                                            <strong class="title">About Strain</strong>
                                            <!--<p class="more"><?php //echo $strain->overview;              ?></p>-->
                                            <?php
                                            if ($user_strain && $likes_count > 4) {
                                                if (trim($user_strain->description) != '') {
                                                    $description = revertTagSpace($user_strain->description);
                                                    if (strlen($description) > 100) {
                                                        $length = ceil(strlen($description) / 2);
                                                        $show_description_button = 1;
                                                    } else {
                                                        $length = strlen($description);
                                                        $show_description_button = 0;
                                                    }
                                                    ?>
                                                    <p><?php echo makeUrls(getTaged(nl2br(substr($description, 0, $length)), '')); ?></p>
                                                    <?php
                                                } else {
                                                    $show_description_button = 0
                                                    ?>
                                                    <p>No description available.</p>
                                                <?php } ?>

                                                <?php if ($show_description_button) { ?>
                                                    <a class="strain-long-arrow" href="<?php echo asset('user-strains-listing/' . $strain->id); ?>"> See Full Strain Details </a>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <?php
                                                $description = $strain->overview;
                                                if (strlen($description) > 100) {
                                                    $length = ceil(strlen($description) / 2);
                                                    $show_description_button = 1;
                                                } else {
                                                    $length = strlen($description);
                                                    $show_description_button = 0;
                                                }
                                                ?>
                                                <p id="des"><?php
                                                    echo substr($description, 0, $length);
                                                    if ($show_description_button) {
                                                        ?><a href="<?php echo asset('user-strains-listing/' . $strain->id); ?>"> [ See Full Strain Details ]</a><?php } ?></p>
                                            <?php } ?>
                                        </div>
                                        <?php if ($survey_count) { ?>
                                        <div class="tab-wid no-border">
                                            <header class="custom-header">
                                                <strong class="title" style="display: inline-block">This Strain's Top 3: 
                                                    <?php if ($survey_count) { ?>
                                                        <span class="tools-holder">
                                                            <img src="<?php echo asset('userassets/images/bg-success.svg') ?>" class="tool-opener" alt="Image" style="width: 24px; margin: 0px 5px 0;">
                                                            <div class="new-tools">
                                                                <p>Our metrics are calculated from experiences submitted by the users of the Healing Budz community - not a laboratory.

                                                                    .</p>
                                                                <a href="#" class="tools-closer"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                            </div>
                                                        </span>
                                                    <?php } ?>
                                                </strong>
                                                <span class="align-right notice">Based on <b><?= $survey_count; ?></b> Budz <em>Surveys Submitted</em></span>
                                            </header>
                                        </div>
                                        <div class="strains_lists">
                                            <div class="tab-wid">
                                                <div class="align-left">
                                                    <div class="label">
                                                        <img src="<?php echo asset('userassets/images/medical-pot.svg') ?>" alt="Image" class="img-responsive">
                                                        <span>Medical Uses</span>
                                                    </div>
                                                </div>
                                                <?php if (count($madical_conditions) > 0  && count($sensations) > 0 && count($negative_effects) > 0) { ?>
                                                    <div class="align-right">
                                                        <?php foreach ($madical_conditions as $condition) { ?>
                                                            <div class="progressbar">
                                                                <div class="loader"><?= $condition->result; ?>%</div>
                                                                <strong><?= $condition->name; ?></strong>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="tab-wid">
                                                <div class="align-left">
                                                    <div class="label">
                                                        <img src="<?php echo asset('userassets/images/disease.svg') ?>" alt="Image" class="img-responsive">
                                                        <span>Disease Prevention</span>
                                                    </div>
                                                </div>
                                                <?php if (count($madical_conditions) > 0 && count($preventions) > 0 && count($sensations) > 0 && count($negative_effects) > 0) { ?>
                                                    <div class="align-right">
                                                        <?php foreach ($preventions as $prevention) { ?>
                                                            <div class="progressbar">
                                                                <div class="loader"><?= $prevention->result; ?>%</div>
                                                                <strong><?= $prevention->name; ?></strong>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="tab-wid">
                                                <div class="align-left">
                                                    <div class="label">
                                                        <img src="<?php echo asset('userassets/images/mood.svg') ?>" alt="Image" class="img-responsive">
                                                        <span>Moods &amp; sensations</span>
                                                    </div>
                                                </div>
                                                <?php if (count($madical_conditions) > 0 && count($sensations) > 0 && count($negative_effects) > 0) { ?>
                                                    <div class="align-right">
                                                        <?php foreach ($sensations as $sensation) { ?>
                                                            <div class="progressbar">
                                                                <div class="loader"><?= $sensation->result; ?>%</div>
                                                                <strong><?= $sensation->name; ?></strong>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="tab-wid">
                                                <div class="align-left">
                                                    <div class="label">
                                                        <img src="<?php echo asset('userassets/images/negative.svg') ?>" alt="Image" class="img-responsive">
                                                        <span>Negative effects</span>
                                                    </div>
                                                </div>
                                                <?php if (count($madical_conditions) > 0 && count($sensations) > 0 && count($negative_effects) > 0) { ?>
                                                    <div class="align-right">
                                                        <?php foreach ($negative_effects as $negative_effect) { ?>
                                                            <div class="progressbar">
                                                                <div class="loader"><?= $negative_effect->result; ?>%</div>
                                                                <strong><?= $negative_effect->name; ?></strong>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="tab-wid">
                                                <div class="align-left">
                                                    <div class="label">
                                                        <img src="<?php echo asset('userassets/images/flavor.svg') ?>" alt="Image" class="img-responsive">
                                                        <span>Flavor profiles</span>
                                                    </div>
                                                </div>
                                                <?php if (count($madical_conditions) > 0 &&  count($sensations) > 0 && count($negative_effects) > 0) { ?>
                                                    <div class="align-right">
                                                        <?php foreach ($survey_flavors as $flavor) { ?>
                                                            <div class="progressbar">
                                                                <div class="loader"><?= $flavor->result; ?>%</div>
                                                                <strong><?= $flavor->name; ?></strong>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <?php } else{ ?>
                                        <img class="img-responsive" src="<?= asset('userassets/img/sample-data.jpg')?>" alt="Sample Data">
                                        <?php } ?>
                                        <div class="tab-wid no-border">
                                            <div class="custom-txt sur-com-issue">
                                                <?php if ($strain->getStrainSurveyUser->count() == 0) { ?>
                                                    <a href="#survey" class="btn-primary btn-popup btn-feedback">
                                                        <img src="<?php echo asset('userassets/images/bg-feedback.png') ?>" alt="Image"> Tell Us Your Experience with this Strain</i>
                                                    </a>
                                                <?php }if (!$survey_count) { ?>
                                                    <div class="custom_left_div">
                                                        <img src="<?php echo asset('userassets/images/bg-success.svg') ?>" alt="Image" class="img-responsive">
                                                        <p class="light-font">Our metrics are calculated from experiences submitted by the users of the Healing Budz community - not a laboratory.</p>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="tab-wid no-border">
                                            <!--<div class="ad-placement light-font"><img src="<?php echo asset('userassets/images/advertisement.jpg') ?>" alt="Image" class="img-responsive"></div>-->
                                        </div>
                                        <div class="tab-wid no-border" id="reviews-section">
                                            <!--<header class="header strain-review-bor">-->
                                            <header class="header">
                                                <!--                                                <a href="#comment-form" class="btn-comment yellow align-right" id="scroll-to-form">
                                                                                                    <i class="fa fa-comment-o" aria-hidden="true"></i> Add Comment
                                                                                                </a>-->
                                                <!--<strong class="align-left title">-->
                                                <strong class="title">
                                                    <div class="rev-sec-row rev-sec-row-st">
                                                        <h4>(<?= ($strain->get_review_count); ?>) Reviews</h4>
                                                        <a href="<?php
                                                        if (count($strain->getLatestReview) > 0) {
                                                            echo asset('strain-review-listing/' . $strain->id);
                                                        } else {
                                                            echo 'javascript:void(0)';
                                                        }
                                                        ?>">
                                                            See All Reviews
                                                        </a>
                                                    </div>
                                                </strong>
                                            </header>
                                            <ul class="reviews-list list-none">
                                                <?php foreach ($strain->getLatestReview as $key => $review) { ?>
                                                    <li>
                                                        <div class="icon pre-main-image hb_round_img" style="background-image: url(<?php echo getImage($review->getUser->image_path, $review->getUser->avatar) ?>)">
                                                            <?php if ($review->getUser->special_icon) { ?>
                                                                <span class="fest-pre-img" style="background-image: url(<?php echo asset('public/images' . $review->getUser->special_icon) ?>);"></span>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="txt">
                                                            <div class="center-div">
                                                                <header class="header">
                                                                    <strong><a class="<?= getRatingClass($review->getUser->points) ?>"  href="<?= asset('user-profile-detail/' . $review->getUser->id) ?>"><?= $review->getUser->first_name; ?></a></strong>
                                                                    <!--<span class="date"><?php //echo date("jS M Y", strtotime($review->created_at));                 ?></span>-->
                                                                    <span class="dot-options">
                                                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                                        <div class="sort-drop">
                                                                            <?php if ($review->reviewed_by == $current_id) { ?>
                                                                                <div class="sort-item">
                                                                                    <a class="white flag report" href="<?php echo asset('edit-strain-review/' . $review->id . '/' . $strain->id) ?>">
                                                                                        <i class="fa fa-pencil" aria-hidden="true"></i><span>Edit Review</span>
                                                                                    </a>
                                                                                </div>
                                                                                <div class="sort-item">
                                                                                    <a class="white flag report btn-popup" href="#delete_strain_review-<?php echo $review->id; ?>">
                                                                                        <i class="fa fa-trash" aria-hidden="true"></i><span>Delete</span>
                                                                                    </a>
                                                                                </div>
                                                                            <?php } ?>
                                                                            <?php if ($review->reviewed_by != $current_id && Auth::user()) { ?> 
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
                                                                    <span class="date"> <?php echo timeago($review->created_at); // echo timeZoneConversion($review->created_at, 'jS M Y', \Request::ip());                ?></span>
                                                                </header>
                                                                <p><?= $review->review; ?></p>
                                                                <div class="videos">
                                                                    <?php if ($review->attachment) { ?>
                                                                        <?php if ($review->attachment->type == 'image') { ?>
                                                                            <div class="">
                                                                                <?php $strain_sing_img = image_fix_orientation('public/images' . $review->attachment->attachment) ?>
                                                                                <a href="<?php echo asset($strain_sing_img) ?>" class="" data-fancybox="gallery<?= $review->attachment->id ?>" >
                                                                                    <div class="ans-slide-image" style="background-image: url(<?php echo asset($strain_sing_img) ?>)"></div>
                                                                                </a>
                                                                                <!--<img src="<?php // echo asset('public/images' . $review->attachment->attachment)         ?>" alt="Image" class="img-responsive">-->
                                                                            </div>
                                                                        <?php } else { ?>
                                                                            <?php $strain_sing_post = 'public/images' . $review->attachment->poster ?>
                                                                            <a href="#vids-<?= $review->attachment->id ?>" data-fancybox="gallery<?= $review->attachment->id ?>" >
                                                                                <div class="ans-slide-image" style="background-image: url(<?php echo asset($strain_sing_post) ?>)"><i class="fa fa-play-circle" aria-hidden="true"></i></div>
                                                                            </a>
                                                                            <video  width="320" height="240" poster="<?php echo asset('public/images' . $review->attachment->poster); ?>" controls="" id='vids-<?= $review->attachment->id ?>' style="display: none;">
                                                                                <source src="<?php echo asset('public/videos' . $review->attachment->attachment); ?>">
                                                                                Your browser does not support the video tag.
                                                                            </video>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                </div>
                                                                <?php if (Auth::user() && isset($review->rating->rating)) { ?>
                                                                    <div class="stain-leaf right thumb-rev-right">
                                                                        <div class="StainLeafWithThumb">
                                                                            <div class="adjust-thmb">
                                                                                <!--<a href="javascript:void(0)">-->

                                                                                <i  id="add_strain_review_like_<?= $review->id ?>" onclick="addremovelike('<?= $review->id ?>', '<?= $review->strain_id ?>', '1')" <?php if ($review->isReviewed) { ?> style="display: none; " <?php } else { ?> style="cursor: pointer" <?php } ?> class="fa fa-thumbs-up yellow_thumb"></i>
                                                                                <i  id="remove_strain_review_like_<?= $review->id ?>" onclick="addremovelike('<?= $review->id ?>', '<?= $review->strain_id ?>', '0')" <?php if (!$review->isReviewed) { ?> style="display: none;" <?php } else { ?> style="cursor: pointer" <?php } ?>class="fa fa-thumbs-up yellow_thumb active"></i>
                                                                                <span id="reviews_count_<?= $review->id ?>"><?= $review->likes->count() ?></span>
                                                                            </div>
                                                                            <div>
                                                                                <img src="<?php echo asset('userassets/images/leaf-' . floorToFraction(number_format((float) $review->rating->rating, 1, '.', ''), 2) . '.svg') ?>" alt="Image" class="img-responsive">
                                                                                <em><?= number_format((float) $review->rating->rating, 0, '.', ''); ?></em>
                                                                            </div>
                                                                        </div>                                                                        
                                                                    </div>
                                                                <?php } ?>
                                                                <div style="clear: both"></div>
                                                                <footer class="review-footer">
                                                                    <!--<a href="#">
                                                                            <i class="fa fa-share-alt" aria-hidden="true"></i> <span>Share</span>
                                                                        </a>-->
                                                                    <div class="p-relative">
                                                                        <?php /* <div class="p_socials">
                                                                          <a href="#" class="share-icon small"><i class="fa fa-share-alt" aria-hidden="true"></i>Share</a>
                                                                          <div class="custom-shares">
                                                                          <?php
                                                                          echo Share::page(asset('strain-details/' . $strain->id), $review->review)
                                                                          ->facebook($review->review)
                                                                          ->twitter($review->review)
                                                                          ->googlePlus($review->review);
                                                                          ?>
                                                                          </div>
                                                                          </div>
                                                                          <div class="new_custom_links">
                                                                          <?php if($review->reviewed_by == $current_id){ ?>
                                                                          <a href="<?php echo asset('edit-strain-review/'.$review->id.'/'.$strain->id)?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                                          <a href="#delete_strain_review<?php echo $review->id;?>" class="btn-popup">
                                                                          <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                                          </a>
                                                                          <!-- Modal -->
                                                                          <div id="delete_strain_review<?php echo $review->id;?>" class="popup">
                                                                          <div class="popup-holder">
                                                                          <div class="popup-area">
                                                                          <div class="text">
                                                                          <div class="edit-holder">
                                                                          <div class="step">
                                                                          <div class="step-header">
                                                                          <h4>Delete Strain Review</h4>
                                                                          <p class="yellow no-margin">Are you sure to delete this review.</p>
                                                                          </div>
                                                                          <a href="<?php echo asset('delete-strain-review/'.$review->id.'/'.$strain->id); ?>" class="btn-heal">yes</a>
                                                                          <a href="#" class="btn-heal btn-close">No</a>
                                                                          </div>
                                                                          </div>
                                                                          </div>
                                                                          </div>
                                                                          </div>
                                                                          </div>
                                                                          <!-- Modal End-->
                                                                          <?php } ?>
                                                                          </div> */ ?>
                                                                        <!-- Delete Review Modal -->
                                                                        <div id="delete_strain_review-<?php echo $review->id; ?>" class="popup">
                                                                            <div class="popup-holder">
                                                                                <div class="popup-area">
                                                                                    <div class="text">
                                                                                        <div class="edit-holder">
                                                                                            <div class="step">
                                                                                                <div class="step-header">
                                                                                                    <h4>Delete Strain Review</h4>
                                                                                                    <p class="yellow no-margin">Are you sure to delete this review.</p>
                                                                                                </div>
                                                                                                <a href="<?php echo asset('delete-strain-review/' . $review->id . '/' . $strain->id); ?>" class="btn-heal">yes</a>
                                                                                                <a href="#" class="btn-heal btn-close">No</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Modal End-->
                                                                        <?php if ($review->reviewed_by != $current_id) { ?>
                                                                <!--                                                                            <a <?php if (count($review->flags) == 0) { ?> style="display: block"<?php } ?> class="right report btn-popup no-margin" href="#strain-review-flag<?= $review->id ?>">
                                                                                                                                            <i class="fa fa-flag" aria-hidden="true"></i> 
                                                                                                                                            <span>Report Abuse</span>
                                                                                                                                        </a>
                                                                                                                                        <input type="hidden" value="<?= $review->id; ?>" id="strain_review_id">

                                                                                                                                        <a <?php if (count($review->flags) > 0) { ?> style="display: block"<?php } ?> class="right report-abuse no-margin active">
                                                                                                                                            <i class="fa fa-flag" aria-hidden="true"></i> 
                                                                                                                                            <span>Report Abuse</span>
                                                                                                                                        </a>-->
                                                                        <?php } ?>
                                                                    </div>
                                                                    <!-- Review Review Modal -->
                                                                    <div id="strain-review-flag<?= $review->id ?>" class="popup">
                                                                        <div class="popup-holder">
                                                                            <div class="popup-area">
                                                                                <form action="<?php echo asset('flag_strain_review'); ?>" class="reporting-form" method="post">
                                                                                    <input type="hidden" value="<?php echo $review->id; ?>" name="strain_review_id">
                                                                                    <input type="hidden" value="<?php echo $strain->id; ?>" name="strain_id">

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
    <!--                                                                                        <input type="submit" class="blue" value="Send">
                                                                                        <a href="#" class="btn-close">x</a>-->
                                                                                        <input type="submit" class="blue" value="Report strain review">
                                                                                        <a href="#" class="btn-close">x</a>
                                                                                    </fieldset>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Modal End-->
                                                                    <!-- Share Strain Review Popup -->
                                                                    <div id="strain-share-review-<?= $review->id; ?>" class="popup">
                                                                        <div class="popup-holder">
                                                                            <div class="popup-area">
                                                                                <div class="reporting-form">
                                                                                    <h2>Select an option</h2>
                                                                                    <div class="custom-shares">
                                                                                        <?php
                                                                                        echo Share::page(asset('strain-details/' . $strain->id), $strain->title, ['class' => 'strain_class', 'id' => $review->id])
                                                                                                ->facebook($strain->title)
                                                                                                ->twitter($strain->title)
                                                                                                ->googlePlus($strain->title);
                                                                                        ?>
                                                                                        <?php if (Auth::user()) { ?>
                                                                                            <div class="strain_class in_app_button" onclick="shareInapp('<?= asset('strain-details/' . $strain->id) ?>', '<?php echo trim(revertTagSpace($strain->title)); ?>', '<?= asset('userassets/images/logo-for-scrap.png') ?>')"> <span class="hb_icon_repost"></span> In App</div>
                                                                                        <?php } ?> </div>
                                                                                    <a href="javascript:void(0)" class="btn-close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Share Strain Review Popup End -->
                                                                </footer>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <?php if ($strain->get_user_review_count == 0 && Auth::user()) { ?>
                                            <div class="tab-wid">
                                                <!--<strong class="title">Add Your Comment Below</strong>-->
                                                <form action="<?php echo asset('add_strain_review') ?>" class="comment-form" id="comment-form" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                    <input type="hidden" name="strain_id" value="<?= $strain->id; ?>">
                                                    <fieldset>
                                                        <div class="comment-ratings">
                                                            <strong class="title">Add Your Rating:</strong>
                                                            <fieldset class="rate">
                                                                <input type="radio" id="rating1" name="rating" value="1" >
                                                                <label class="rate-one" for="rating1" title="1">
                                                                    <img src="<?php echo asset('userassets/images/leaf-1.svg') ?>" alt="Favorites">
                                                                </label>
                                                                <input type="radio" id="rating2" name="rating" value="2">
                                                                <label class="rate-two" for="rating2" title="2">
                                                                    <img src="<?php echo asset('userassets/images/leaf-2.svg') ?>" alt="Favorites">
                                                                </label>
                                                                <input type="radio" id="rating3" name="rating" value="3">
                                                                <label class="rate-three" for="rating3" title="3">
                                                                    <img src="<?php echo asset('userassets/images/leaf-3.svg') ?>" alt="Favorites">
                                                                </label>
                                                                <input type="radio" id="rating4" name="rating" value="4">
                                                                <label class="rate-four" for="rating4" title="4">
                                                                    <img src="<?php echo asset('userassets/images/leaf-4.svg') ?>" alt="Favorites">
                                                                </label>
                                                                <input type="radio" id="rating5" name="rating" value="5" checked="">
                                                                <label class="rate-five" for="rating5" title="5">
                                                                    <img src="<?php echo asset('userassets/images/leaf-5.svg') ?>" alt="Favorites">
                                                                </label>
                                                            </fieldset>
                                                        </div>
                                                        <div class="label-in-com-rev">
                                                            <textarea name="review" placeholder="Your review comment here..." maxlength="500" required=""></textarea>

                                                            <?php
                                                            if ($errors->has('review')) {
                                                                echo $errors->first('review');
                                                            }
                                                            ?>
                                                            <strong>0/<span class="msg-note">500 Characters</span></strong>
                                                        </div>
                                                        <div class="strain-comment"><input type="submit" value="Post Review"></div>
                                                        <div class="upload-file">
                                                            <!-- <input type="file" id="author-image" name="image"> -->
                                                            <input id="review_file" name="attachment" type="file" accept="video/*,  video/x-m4v, video/webm, video/x-ms-wmv, video/x-msvideo, video/3gpp, video/flv, video/x-flv, video/mp4, video/quicktime, video/mpeg, video/ogv, .ts, .mkv, image/*">
                                                            <label for="review_file">
                                                                <!--<strong><i class="fa fa-plus"></i></strong>-->
                                                                <span>Add An image or video<em>(1 photo or 20 sec video max.)</em></span>
                                                            </label>
                                                        </div>
                                                        <div class="strain-attachment">
                                                            <!--<i class="fa fa-paperclip"></i>-->
                                                            <!--<img src="<?php // echo asset('userassets/images/img2.png')   ?>" alt="image" id="strain_review_image" />-->
                                                            <figure style="background-image:url('<?php echo asset('userassets/images/img2.png') ?>'); display: none;" id="strain_review_image" /></figure>
                                                            <video  preload="metadata"  type="video/mp4" class="video-use" class="video" src="" id="video"></video>
                                                            <!--<span>image.jpg</span>-->
                                                            <i class="fa fa-close"></i>
                                                        </div>

                                                    </fieldset>
                                                </form>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="right_sidebars">
                        <?php
                        if (Auth::user()) {
                            include 'includes/rightsidebar.php';
                            ?>
                            <?php
                            include 'includes/chat-rightsidebar.php';
                        }
                        ?>
                    </div>
                </div>
            </article>
        </div>
        <div id="survey" class="popup strain-survey1">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="text">
                        <header class="header">
                            <span>Take Our Strain Survey and receive</span>
                            <strong>50 pts</strong>
                        </header>
                        <div class="txt">
                            <a href="#start-survey" class="btn-primary start-survey btn-popup">Start Survey</a>
                        </div>
                        <a href="#" class="btn-close"></a>
                    </div>
                </div>
            </div>
        </div>
        <!--        <div id="start-survey" class="popup start-sur1">
                    <div class="popup-holder">
                        <div class="popup-area">
                            <div class="text">
                                <div class="edit-holder">
                                    <div class="step">
                                        <div class="step-header">
                                            <h4>Question 1/6</h4>
                                            <p class="yellow">What medical conditions have you effectively treated with this Strain?</p>
                                            <span class="lit-txt">Add up to 3<br></span>
                                        </div>
                                        <form action="#" id="medical_suggestion" class="edit-search-form">
                                            <fieldset>
                                                <div class="edit-search-area">
                                                    <span>Begin typing to search</span>
                                                    <span>
                                                        <input type="search" id="tags" name="medical_condition">
                                                        <input type="submit" class="sugest-adition" id="medical_suggestion_submit" value="Suggest an addition"/>
                                                        <div class="toggle_div">
                                                            <button type="button" class="add-another">Add Another</button>
                                                            <div class="or-row"><span>or</span></div>
                                                            <a href="#q-2" id="question_1" class="btn-popup btn-primary green">Save &amp; Continue</a>
                                                        </div>
                                                    </span>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                </div>
                                <a href="#" class="btn-close yellow"></a>
                            </div>
                        </div>
                    </div>
                </div>-->
        <div id="start-survey" class="popup start-sur1">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="text">
                        <div class="edit-holder">
                            <div class="step">
                                <div class="step-header">
                                    <p class="">What medical conditions have you effectively treated with this Strain?</p>
                                    <span class="lit-txt">Add up to 3<br></span>
                                </div>
                                <form action="#" id="medical_suggestion" class="edit-search-form">
                                    <fieldset>
                                        <div class="edit-search-area">
                                            <!--<span>Begin typing to search</span>-->
                                            <span>
                                                <input type="search" id="tags" name="medical_condition" placeholder="Begin typing to search">
                                                <div class="q-sug-btn" >
<!--                                                    <img src="<?php echo asset('userassets/images/plus-sign.png') ?>" alt="icon">
                                                    <input type="submit" class="sugest-adition"  value="Suggest an addition" id="medical_suggestion_submit"/>-->
                                                </div>
                                                <div class="toggle_div">
                                                    <button type="button" class="add-another">Add Another</button>
                                                    <!--<div class="or-row"><span>or</span></div>-->
                                                    <div class="str-ques-bn">
                                                        <h4>Question 1/6</h4>
                                                        <a href="#q-2" id="question_1" class="btn-popup">Save &amp; Continue</a>
                                                    </div>

                                                </div>
                                            </span>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                        <a href="javascript:void(0)" onclick="refreshPage()" class="btn-close"></a>
                    </div>
                </div>
            </div>
        </div>
        <div id="q-2" class="popup start-sur1">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="text">
                        <div class="edit-holder">
                            <div class="step">
                                <div class="step-header">
                                    <p class="">Which moods or sensations have you experienced with this Strain?</p>
                                    <span class="lit-txt">Add up to 3<br></span>
                                </div>
                                <form action="#" id="sensation_suggestion" class="edit-search-form">
                                    <fieldset>
                                        <div class="edit-search-area">
                                            <span>
                                                <input type="search" id="tags2" name="sensation" placeholder="Begin typing to search">
                                                <div class="q-sug-btn">
<!--                                                    <img src="<?php echo asset('userassets/images/plus-sign.png') ?>" alt="icon">
                                                    <input type="submit" class="sugest-adition" id="sensation_submit" value="Suggest an addition"/>-->
                                                </div>
                                                <div class="toggle_div">
                                                    <button type="button" class="add-another">Add Another</button>
                                                    <!--<div class="or-row"><span>or</span></div>-->
                                                    <div class="str-ques-bn">
                                                        <h4>Question 2/6</h4>
                                                        <a href="#start-survey" id="goback_2" class="btn-popup bck-btn"><i class="fa fa-chevron-left"></i> Go Back</a>
                                                        <a href="#q-3" id="question_2" class="btn-popup">Save &amp; Continue</a>
                                                    </div>
                                                    <!--                                                    <div class="row str-ques-bn">
                                                                                                            <h4></h4>-->
                                                    <!--                                                        <a href="#start-survey" id="goback_2" class="btn-popup"><i class="fa fa-angle-right">Go Back</i></a>-->
                                                    <!--</div>-->
                                                </div>
                                            </span>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                        <a href="javascript:void(0)" onclick="refreshPage()" class="btn-close"></a>
                    </div>
                </div>
            </div>
        </div>
        <div id="q-3" class="popup start-sur1">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="text">
                        <div class="edit-holder">
                            <div class="step">
                                <div class="step-header">
                                    <p class="">What are some of the negative effects that you have exprienced using this strain?</p>
                                    <span class="lit-txt">Add up to 3<br></span>
                                </div>
                                <form action="#" id="negative_effect_suggestion" class="edit-search-form">
                                    <fieldset>
                                        <div class="edit-search-area">
                                            <span>
                                                <input type="search" id="tags3" name="negative_effect" placeholder="Begin typing to search">
                                                <div class="q-sug-btn">
<!--                                                    <img src="<?php echo asset('userassets/images/plus-sign.png') ?>" alt="icon">
                                                    <input type="submit" class="sugest-adition" id="negative_effect_submit" value="Suggest an addition"/>-->
                                                </div>
                                                <div class="toggle_div">
                                                    <button type="button" class="add-another">Add Another</button>
                                                    <div class="str-ques-bn">
                                                        <h4>Question 3/6</h4>
                                                        <a href="#q-2" id="goback_3" class="btn-popup bck-btn"><i class="fa fa-chevron-left"></i> Go Back</a>
                                                        <a href="#q-4" id="question_3" class="btn-popup">Save &amp; Continue</a>
                                                    </div>
                                                    <!--                                                    <div class="row str-ques-bn">
                                                                                                            <h4></h4>
                                                                                                            <a href="#q-2" id="goback_3" class="btn-popup bck-btn"><i class="fa fa-chevron-left"></i>Go Back</a>
                                                                                                        </div>-->
                                                </div>
                                            </span>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                        <a href="javascript:void(0)" onclick="refreshPage()" class="btn-close"></a>
                    </div>
                </div>
            </div>
        </div>
        <div id="q-4" class="popup start-sur1">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="text">
                        <div class="edit-holder">
                            <div class="step">
                                <div class="step-header">
                                    <p class="">Are you currently using Cannabis as a preventative medication?</p>
                                    <span class="lit-txt">Choose Yes or No<br></span>
                                </div>
                                <form action="#" class="edit-search-form">
                                    <fieldset>
                                        <div class="edit-search-area">
<!--                                            <span class="radios add">
                                                <input type="radio" name="current_use" value="yes" id="pop-yes">
                                                <label for="pop-yes" class="border-bottom">Yes</label>
                                                <input type="radio" name="current_use" value="no" id="pop-no">
                                                <label for="pop-no">No</label>
                                            </span>-->
                                            <span class="radios add">
                                                <div class="input-w-x">
                                                    <input type="radio" checked="" name="current_use" value="yes" id="pop-yes" class="g-y" onclick="changeHref('question_4', 'q-5', 'q-5')">
                                                    <label for="pop-yes" class="border-bottom"><i class="fa fa-check"></i> Yes</label>
                                                </div>
                                                <div class="input-w-x">
                                                    <input type="radio" name="current_use" value="no" id="pop-no" class="g-n" onclick="changeHref('question_4', 'select-flavor', 'q-4')">
                                                    <label for="pop-no"><i class="fa fa-close"></i> No</label>
                                                </div>
                                            </span>
                                            <div class="str-ques-bn">
                                                <h4>Question 4/6</h4>
                                                <a href="#q-3" id="goback_4" class="btn-popup bck-btn"><i class="fa fa-chevron-left"></i> Go Back</a>
                                                <a href="#q-5" id="question_4" class="btn-popup">Save &amp; Continue</a>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                        <a href="javascript:void(0)" onclick="refreshPage()" class="btn-close"></a>
                    </div>
                </div>
            </div>
        </div>
        <div id="q-5" class="popup start-sur1">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="text">
                        <div class="edit-holder">
                            <div class="step">
                                <div class="step-header">
                                    <p class="">What are 3 preventions areas you focus on?</p>
                                    <span class="lit-txt">Add up to 3<br></span>
                                </div>
                                <form action="#" id="prevention_suggestion" class="edit-search-form">
                                    <fieldset>
                                        <div class="edit-search-area">
                                            <span>
                                                <input type="search" id="tags5" name="prevention" placeholder="Begin typing to search">
                                                <div class="q-sug-btn">
<!--                                                    <img src="<?php echo asset('userassets/images/plus-sign.png') ?>" alt="icon">
                                                    <input type="submit" class="sugest-adition" id="prevention_submit" value="Suggest an addition"/>-->
                                                </div>
                                                <div class="toggle_div">
                                                    <button type="button" class="add-another">Add Another</button>
                                                    <div class="str-ques-bn">
                                                        <h4>Question 5/6</h4>
                                                        <a href="#q-4" id="goback_5" class="btn-popup bck-btn"><i class="fa fa-chevron-left"></i> Go Back</a>
                                                        <a href="#select-flavor" id="question_5" class="btn-popup">Save &amp; Continue</a>
                                                    </div>
                                                    <!--                                                    <div class="row str-ques-bn">
                                                                                                            <h4></h4>
                                                                                                            <a href="#q-4" id="goback_5" class="btn-popup bck-btn"><i class="fa fa-chevron-left"></i> Go Back</a>
                                                                                                        </div>-->
                                                </div>
                                            </span>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                        <a href="javascript:void(0)" onclick="refreshPage()" class="btn-close"></a>
                    </div>
                </div>
            </div>
        </div>
        <div id="select-flavor" class="popup start-sur1">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="text">
                        <div class="edit-holder">
                            <div class="step hb_strain_detail_step6">
                                <div class="step-header">
                                    <p class="">What flavor profiles would you associate with this strain?</p>
                                    <span class="lit-txt">Add up to 3 Choose up to 3 Flavors<br></span>
                                </div>
                                <div class="txt">
                                    <form action="#" class="flavor">
                                        <select placeholder="Begin typing search term" name="flavors" multiple="" class="chosen-select" tabindex="-1" style="display: none;" required="required">


                                            <?php
                                            foreach ($flavore_groups as $group) {
                                                $cat = 'Others';
                                                if ($group->getFlavorCategory) {
                                                    $cat = $group->getFlavorCategory->category;
                                                }
                                                ?>
                                                <optgroup label="<?= $cat ?>">
                                                    <?php
                                                    foreach ($flavors as $flavor) {
                                                        if ($flavor->flavor_category_id == $group->flavor_category_id) {
                                                            ?>

                                                            <option value="<?php echo $flavor->flavor; ?>"><?php echo $flavor->flavor; ?></option>

                                                        <?php }
                                                    }
                                                    ?>  </optgroup> <?php } ?>
                                        </select>
                                    </form>
                                    <div class="str-ques-bn">
                                        <h4>Question 6/6</h4>
                                        <a href="#q-5" id="goback_6" class="btn-popup bck-btn"><i class="fa fa-chevron-left"></i> Go Back</a>
                                        <a href="#final-step" id="question_6" class="btn-popup" style="display:none">Complete Survey</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="javascript:void(0)" onclick="refreshPage()" class="btn-close"></a>
                    </div>
                </div>
            </div>
        </div>
        <div id="final-step" class="popup finish-survey1">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="text">
                        <header class="header">
                            <figure>
                                <img src="<?php echo asset('userassets/images/strain.png') ?>" alt="Image">
                            </figure>
                            <h4>Thank you</h4>
                            <p class="">For sharing your experience with this Strain.</p>
                        </header>
                        <div class="txt">
                            <div class="row thanks-ok-div">
                                <a href="javascript:void(0)" onclick="refreshPageLast()" class="btn-close thanks-ok">Okay</a>
                            </div>
                            <!--<a href="<?php // echo asset('strain-details/' . $strain_id);               ?>" class="btn-primary green">Close</a>-->
                        </div>
                        <!--                        <a href="javascript:void(0)" onclick="refreshPage()" class="btn-close"></a>-->
                    </div>
                </div>
            </div>
        </div>
        <div id="strain-gallery" class="popup">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="text">
                        <div class="gallery">
                            <div class="mask">
                                <div class="slideset">
                                    <?php if (count($strain->getImages) > 0) { ?>
    <?php foreach ($strain->getImages as $image) { ?>
                                            <div class="slide">
                                                <img src="<?php echo asset('public/images/' . $image->image_path) ?>" alt="Image" class="img-responsive">
                                                <footer class="footer">
                                                    <span class="date"><i class="fa fa-calendar" aria-hidden="true"></i><?php echo date("jS M Y", strtotime($image->created_at)); ?></span>
                                                    <div class="new_foot_holder">
        <?php if ($image->getUser) { ?>
                                                            <span>Photo Uploaded by:</span>
                                                            <strong><?php echo $image->getUser->first_name; ?></strong><br>
        <?php } ?>
                                                    </div>
                                                </footer>
                                            </div>
                                        <?php } ?>
<?php } else { ?>
                                        <div class="slide">
                                            <img src="<?php echo asset('userassets/images/placeholder.jpg') ?>" alt="Image" class="img-responsive">    
                                        </div>
<?php } ?>
                                </div>
                                <a href="#" class="btn-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
                                <a href="#" class="btn-next"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                <a href="#" class="btn-close yellow"></a>
                                <!-- <div class="pagination"></div> -->
                            </div>
                            <div class="row str-ques-bn">
                                <h4></h4>
                                <a href="#q-6" id="goback_7" class="btn-popup">Go Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <?php include('includes/footer.php'); ?>
<?php include 'includes/functions.php'; ?>
        <script src="<?= asset('userassets/js/popcorn.js') ?>"></script>
        <script src="<?= asset('userassets/js/popcorn.capture.js') ?>"></script>
        <!--        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>-->
        <script>
//                                    $(document).ready(function () {
//                                        var allRadios = document.getElementsByName('rating');
//                                        var booRadio;
//                                        var x = 0;
//                                        for (x = 0; x < allRadios.length; x++) {
//                                            allRadios[x].onclick = function () {
//                                                if (booRadio == this) {
//                                                    this.checked = false;
//                                                    booRadio = null;
//                                                } else {
//                                                    booRadio = this;
//                                                }
//                                            };
//                                        }
//                                    });
                                    function removeStrainMySave(id) {
                                        $.ajax({
                                            url: "<?php echo asset('strain-remove-favorit') ?>",
                                            type: "POST",
                                            data: {"strain_id": id, "_token": "<?php echo csrf_token(); ?>"},
                                            success: function (response) {
                                                if (response.status == 'success') {
                                                    $('#removeStrainFav' + id).hide();
                                                    $('#addStrainFav' + id).show();
                                                }
                                            }
                                        });
                                    }

                                    function addStrainMySave(id) {

                                        $.ajax({
                                            url: "<?php echo asset('strain-add-favorit') ?>",
                                            type: "POST",
                                            data: {"strain_id": id, "_token": "<?php echo csrf_token(); ?>"},
                                            success: function (response) {
                                                if (response.status == 'success') {
                                                    $('#addStrainFav' + id).hide();
                                                    $('#removeStrainFav' + id).show();
                                                }
                                            }
                                        });
                                    }
                                    $("#review_file").change(function () {
                                        var input = document.getElementById('review_file');
                                        var filePath = input.value;
                                        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.mp4)$/i;
                                        if (!allowedExtensions.exec(filePath)) {
                                            $('#erroralertmessage').html('Please upload file having extensions .jpeg/.jpg/.png/.gif/.mp4 only.');
                                            $('#erroralert').show();
                                            $('#review_file').val('');
                                            return false;
                                        }

                                        var fileInput = document.getElementById('review_file');

                                        var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
                                        var image_type = fileInput.files[0].type;
                                        if (image_type == "image/png" || image_type == "image/gif" || image_type == "image/jpeg" || image_type == "image/bmp" || image_type == "image/jpg") {
                                            var file = fileInput.files[0];
                                            var reader = new FileReader();
                                            reader.onloadend = function () {
                                                getOrientation(file, function (orientation) {
//                            alert(orientation);
                                                    resetOrientation(reader.result, orientation, function (result) {

                                                        $(".strain-attachment").show();
//                                                        $(".strain-attachment img").attr("src", result);
                                                        $(".strain-attachment #strain_review_image").attr("style", "background-image:url('" + result + "')");
                                                        $(".strain-attachment img").show();
                                                    });
                                                });
                                            };
                                            reader.readAsDataURL(file);

                                            $("#video").attr("src", '');
//                    $(".strain-attachment").show();
//                    $(".strain-attachment img").attr("src", fileUrl);
//                    $(".strain-attachment img").show();
                                            $(".video-use").hide();
                                            $(".strain-attachment i.fa-close").show();

                                        } else if (fileInput.files[0].type == "video/mp4" || fileInput.files[0].type == "video/quicktime") {
//                    alert(fileUrl)

//                                            $("#strain_review_image").attr("src", '');
                                            $("#strain_review_image").attr("style", "background-image:url('')");
                                            $(".strain-attachment").show();
                                            $(".strain-attachment i.fa-close").show();
                                            $(".video-use").show();
//                                            $(".strain-attachment img").hide();
                                            $("#strain_review_image").hide();
                                            $("#video").attr("src", fileUrl + '#t=1');
                                            var myVideo = document.getElementById("video");
                                            myVideo.addEventListener("loadedmetadata", function ()
                                            {
                                                duration = (Math.round(myVideo.duration * 100) / 100);
                                                if (duration >= 21) {
                                                    $('#erroralertmessage').html('Video is greater than 20 sec.');
                                                    $('#erroralert').show();
                                                    $("#video").attr("src", '');
                                                    $("#review_file").val();

                                                    $(".strain-attachment").hide();
                                                }
                                            });
                                        }
                                    });
                                    $(".strain-attachment i.fa-close").click(function () {
                                        $(".strain-attachment").hide();
                                        $("#video").attr("src", '');
//                                        $("#strain_review_image").attr("src", '');
                                        $("#strain_review_image").attr("style", "background-image:url('')");
                                    });

                                    $(document).ready(function () {
                                        madical_conditions = [];
                                        sensations = [];
                                        negative_effects = [];
                                        preventions = [];

                                        //Remove selected Iteam from Medical Conditions
                                        $('#tags').on('autocompletechange', function () {
                                            var selected_value = this.value;

                                            madical_conditions = jQuery.grep(madical_conditions, function (value) {
                                                return value != selected_value;
                                            });

                                            $('#tags').autocomplete('option', 'source', madical_conditions);
//                                            
                                        }).change();

                                        //Remove selected Iteam from sensations
                                        $('#tags2').on('autocompletechange', function () {
//                   
                                            var selected_value = this.value;
                                            sensations = jQuery.grep(sensations, function (value) {
                                                return value != selected_value;
                                            });
                                            $('#tags2').autocomplete('option', 'source', sensations);
                                        }).change();

                                        //Remove selected Iteam from Negative Effect
                                        $('#tags3').on('autocompletechange', function () {
//                    alert(this.value);
                                            var selected_value = this.value;
//                    negative_effects.splice($.inArray(selected_value, negative_effects), 1);
                                            negative_effects = jQuery.grep(negative_effects, function (value) {
                                                return value != selected_value;
                                            });
                                            $('#tags3').autocomplete('option', 'source', negative_effects);
                                        }).change();

                                        //Remove selected Iteam from disease preventions
                                        $('#tags5').on('autocompletechange', function () {
//                    alert(this.value);
                                            var selected_value = this.value;
//                    preventions.splice($.inArray(selected_value, preventions), 1);
                                            preventions = jQuery.grep(preventions, function (value) {
                                                return value != selected_value;
                                            });
                                            $('#tags5').autocomplete('option', 'source', preventions);
                                        }).change();


                                        $(".chosen-select").chosen({
                                            max_selected_options: 3, //Max select limit 
                                            display_selected_options: true,
                                            placeholder_text_multiple: "Select some options",
                                            no_results_text: "Results not found",
                                        });
                                        $(".chosen-select").chosen().change(function () {
//                    alert($(".chosen-select").chosen().val()); 
                                            var cnt = $('li.search-choice').length;
//                    alert(cnt);
                                            if (cnt > 0)
                                            {
                                                $("#question_6").show();
                                            }
                                            if (cnt > 3)
                                            {
                                                $('#erroralertmessage').html('Only 3 Options Allowed');
                                                $('#erroralert').show();
                                                $('li.search-choice').last().remove();
                                                return false;
                                            }
                                            $('.search-choice-close').on('click', function () {
                                                var cnt = $('li.search-choice').length;
                                                if (cnt < 1) {

                                                    $("#question_6").hide();
                                                }
                                            });
                                        });
//                $('.chosen-select').on('click', '.search-choice-close', function(event) {
//                    var cnt = $('li.search-choice').length;
//                    alert(cnt);
//                });


                                        //get survey data
                                        $.ajax({
                                            url: "<?php echo asset('get-survey-data') ?>",
                                            type: "get",
                                            success: function (response) {
                                                if (response.status == 'success') {
                                                    madical_conditions = response.data.madical_conditions;
                                                    sensations = response.data.sensations;
                                                    negative_effects = response.data.negative_effects;
                                                    preventions = response.data.preventions;
                                                    $("#tags").autocomplete({source: madical_conditions});
                                                    $("#tags2").autocomplete({source: sensations});
                                                    $("#tags3").autocomplete({source: negative_effects});
                                                    $("#tags5").autocomplete({source: preventions});
                                                }
                                            }
                                        });

                                        $('#strain_like').click(function () {
                                            $('#strain_dislike_revert').addClass("active");
                                            var ajax = 1;
                                            if (ajax === 1) {
                                                ajax = 2;
                                                $.ajax({
                                                    url: "<?php echo asset('strain_like') ?>",
                                                    type: "POST",
                                                    data: {"strain_id": '<?= $strain_id; ?>', "_token": "<?php echo csrf_token(); ?>"},
                                                    success: function (response) {
                                                        if (response.status == 'success') {
                                                            $('#strain_like').hide();
                                                            $('#strain_like_revert').addClass("active").show();


//                                var strain_like_count = $('#strain_like_count').text();
                                                            $("#strain_like_count").text(parseInt(response.like_count));
                                                            $("#strain_dislike_count").text(parseInt(response.dislike_count));
                                                            $('#strain_dislike_revert').hide();
                                                            $('#strain_dislike').show();
                                                            ajax = 1;
                                                        }
                                                    }
                                                });
                                            }
                                        });

                                        $('#strain_like_revert').click(function () {
                                            $('#strain_dislike_revert').addClass("active");
                                            var ajax = 1;
                                            if (ajax === 1) {
                                                ajax = 2;
                                                $.ajax({
                                                    url: "<?php echo asset('strain_like_revert') ?>",
                                                    type: "POST",
                                                    data: {"strain_id": '<?= $strain_id; ?>', "_token": "<?php echo csrf_token(); ?>"},
                                                    success: function (response) {
                                                        if (response.status == 'success') {
                                                            $('#strain_like_revert').hide();
                                                            $('#strain_like').show();

//                                var strain_like_count = $('#strain_like_count').text();
                                                            $("#strain_like_count").text(response.like_count);
                                                            ajax = 1;
                                                        }
                                                    }
                                                });
                                            }
                                        });

                                        $('#strain_dislike').click(function (e) {
                                            $('#strain_like_revert').addClass("active");
                                            var ajax = 1;
                                            if (ajax === 1) {
                                                ajax = 2;
                                                $.ajax({
                                                    url: "<?php echo asset('strain_dislike') ?>",
                                                    type: "POST",
                                                    data: {"strain_id": '<?= $strain_id; ?>', "_token": "<?php echo csrf_token(); ?>"},
                                                    success: function (response) {
                                                        if (response.status == 'success') {
                                                            $('#strain_dislike').hide();
                                                            $('#strain_dislike_revert').addClass("active").show();

//                                var strain_like_count = $('#strain_dislike_count').text();
                                                            $("#strain_dislike_count").text(parseInt(response.dislike_count));
                                                            $("#strain_like_count").text(parseInt(response.like_count));
                                                            $('#strain_like_revert').hide();
                                                            $('#strain_like').show();
                                                            ajax = 1;
                                                        }
                                                    }
                                                });
                                            }
                                        });

                                        $('#strain_dislike_revert').click(function (e) {
                                            $('#strain_like_revert').addClass("active");
                                            var ajax = 1;
                                            if (ajax === 1) {
                                                ajax = 2;
                                                $.ajax({
                                                    url: "<?php echo asset('strain_dislike_revert') ?>",
                                                    type: "POST",
                                                    data: {"strain_id": '<?= $strain_id; ?>', "_token": "<?php echo csrf_token(); ?>"},
                                                    success: function (response) {
                                                        if (response.status == 'success') {
                                                            $('#strain_dislike_revert').hide();
                                                            $('#strain_dislike').show();

//                                var strain_like_count = $('#strain_dislike_count').text();
                                                            $("#strain_dislike_count").text(parseInt(response.like_count));
                                                            ajax = 1;
                                                        }
                                                    }
                                                });
                                            }
                                        });


                                        $('.strain_flag').click(function (e) {
                                            $.ajax({
                                                url: "<?php echo asset('strain_flag') ?>",
                                                type: "POST",
                                                data: {"strain_id": '<?= $strain_id; ?>', "_token": "<?php echo csrf_token(); ?>"},
                                                success: function (response) {
                                                    if (response.status == 'success') {
                                                        $('.strain_flag').hide();
                                                        $('.strain_flag_revert').show();
                                                    }
                                                }
                                            });
                                        });




                                        $('.strain_review_flag').click(function (e) {
                                            var review = jQuery(this);
                                            var review_id = review.find('input').val();
                                            $.ajax({
                                                url: "<?php echo asset('flag_strain_review') ?>",
                                                type: "POST",
                                                data: {"strain_id": '<?= $strain_id; ?>', "strain_review_id": review_id, "_token": "<?php echo csrf_token(); ?>"},
                                                success: function (response) {
                                                    if (response.status == 'success') {
                                                        review.addClass('report-abuse');
                                                    }
                                                }
                                            });
                                        });


                                        $('#gal-img').on('change', function () {
                                            $("#upload_image").submit();
                                        });



                                        $('#question_1').click(function (e) {
                                            var inputs = $(this).closest('.popup').find('.input-w-x > input');

                                            var answer = new Array();
                                            inputs.each(function () {
                                                answer.push($(this).val());
                                            });
                                            saveSurveyAnswer(1, answer);
                                        });


                                        $('#question_2').click(function (e) {
                                            var inputs = $(this).closest('.popup').find('.input-w-x > input');
                                            var answer = new Array();
                                            inputs.each(function () {
                                                answer.push($(this).val());
                                            });
                                            saveSurveyAnswer(2, answer);
                                        });

                                        $('#question_3').click(function (e) {
                                            var inputs = $(this).closest('.popup').find('.input-w-x > input');
                                            var answer = new Array();
                                            inputs.each(function () {
                                                answer.push($(this).val());
                                            });
                                            saveSurveyAnswer(3, answer);
                                        });


                                        $('#question_4').click(function (e) {
                                            var answer = $(this).closest('.edit-search-form').find('input[type=radio]:checked').val();
                                            saveSurveyAnswer(4, answer);
                                        });


                                        $('#question_5').click(function (e) {
                                            var inputs = $(this).closest('.popup').find('.input-w-x > input');
                                            var answer = new Array();
                                            inputs.each(function () {
                                                answer.push($(this).val());
                                            });
                                            saveSurveyAnswer(5, answer);
                                        });


                                        $('#question_6').click(function (e) {
                                            var answer = $("form.flavor .chosen-select").val();
                                            saveSurveyAnswer(6, answer);
                                        });


                                        function saveSurveyAnswer(question_id, answer) {
                                            $.ajax({
                                                url: "<?php echo asset('save-survey-answer') ?>",
                                                type: "POST",
                                                data: {"strain_id": '<?= $strain_id; ?>', "question_id": question_id, "answer": answer, "_token": "<?php echo csrf_token(); ?>"},
                                                success: function (response) {
                                                    if (response.status == 'success') {
                                                    }
                                                }
                                            });
                                        }

                                        /************************************************/
                                        /**************   Medical Use Start   *************/
                                        /************************************************/
                                        $('#medical_suggestion_submit').click(function () {
                                            var clicked_value = $(this).closest('.popup').find('.ui-autocomplete-input').val();
                                            //Check if value already in suggestion
                                            var values = [];
                                            $('.medical_suggestion').each(function () {
                                                values.push(this.value);
                                            });
                                            if (jQuery.inArray(clicked_value, values) != -1) {
                                                $('#erroralertmessage').html('This suggestion is already submitted');
                                                $('#erroralert').show();
                                            } else {
                                                $(this).closest('.popup').find('.lit-txt').append("<div class='input-w-x medical_survey_answer'><i class='fa fa-exclamation-triangle' title='Submitted for approval'></i><span class='m_span'>" + clicked_value + "</span><i class='fa fa-close'></i><input class='medical_suggestion' type='hidden' value='" + clicked_value + "'></div>");
                                                $(this).closest('.q-sug-btn').hide(300);
                                                $(this).closest('.popup').find('.ui-autocomplete-input').hide(300);
                                                $(this).closest('.popup').find('.toggle_div').show(300);
                                                $(this).closest('.popup').find('.toggle_div button').show(300);

                                                var input_counts = $(this).closest('.popup').find('.lit-txt input').length;
                                                if (input_counts == 3) {
                                                    $(this).closest('.popup').find('.toggle_div .add-another, .toggle_div .or-row').hide(300);
                                                }
                                            }
                                        });

                                        $('#tags').autocomplete({
                                            select: function (a, b) {
                                                var clicked_val = (b.item.value);
                                                $(this).closest('.popup').find('.lit-txt').append("<div class='input-w-x medical_survey_answer'><span class='m_span'>" + clicked_val + "</span><i class='fa fa-close'></i><input class='medical_use_selected' type='hidden' value='" + clicked_val + "'></div>");

                                                $(this).hide(300);
                                                $(this).next().hide(300);
                                                $(this).closest('.popup').find('.toggle_div').show(300);
                                                $(this).closest('.popup').find('.toggle_div button').show(300);
                                                var input_counts = $(this).closest('.popup').find('.lit-txt input').length;
                                                if (input_counts == 3) {
                                                    $(this).hide(300);
                                                    $(this).closest('.popup').find('.toggle_div .add-another, .toggle_div .or-row').hide(300);
                                                }
                                            }
                                        });

                                        //remove answers
                                        $('body').on('click', '.medical_survey_answer .fa-close', function () {

                                            var parent_div = $(this).parents('.medical_survey_answer');
                                            parent_div.remove();

                                            if ($('.medical_survey_answer').length < 3) {
                                                $('#tags').closest('.popup').find('.toggle_div .add-another, .toggle_div .or-row').show(300);
                                            }

                                            if ($('.medical_survey_answer').length == 0) {
                                                $('#tags').closest('.popup').find('.toggle_div, .toggle_div .or-row').hide(300);
                                                $('#tags').closest('.popup').find('#tags, #tags2, #tags3, #tags4, #tags5').val("");
                                                $('#tags').closest('.popup').find('#tags, #tags2, #tags3, #tags4, #tags5').show(300);
                                            }

                                            var selected = $(this).parents('.medical_survey_answer').find('.medical_use_selected');
                                            if (typeof selected.val() !== "undefined") {
                                                madical_conditions.push(selected.val());
                                            }
                                        });

                                        $('#medical_suggestion').submit(function (event) {
                                    var formData = {
                                                'suggestion': $('input[name=medical_condition]').val(),
                                                '_token': "<?php echo csrf_token(); ?>"
                                            };
                                            $.ajax({
                                                type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                                                url: '<?php echo asset('save-medical-condition-suggestion'); ?>', // the url where we want to POST
                                                data: formData, // our data object
                                                success: function (response) {
                                                    if (response.status == 'success') {
                                                    }
                                                }
                                            });
                                            // stop the form from submitting the normal way and refreshing the page
                                            event.preventDefault();
                                        });
                                        /************************************************/
                                        /**************   Medical Use end   *************/
                                        /************************************************/




                                        /************************************************/
                                        /**************   Sensation Start   *************/
                                        /************************************************/
                                        $('#sensation_submit').click(function () {
                                            var clicked_value = $(this).closest('.popup').find('.ui-autocomplete-input').val();


                                            //Check if value already in suggestion
                                            var values = [];
                                            $('.sensation_suggestion').each(function () {
                                                values.push(this.value);
                                            });
                                            //use values after the loop

                                            if (jQuery.inArray(clicked_value, values) != -1) {
                                                $('#erroralertmessage').html('This suggestion is already submitted');
                                                $('#erroralert').show();
                                            } else {

//                        $(this).closest('.popup').find('.lit-txt').append("<input class='sensation_suggestion' type='text' value='" + clicked_value + "'>");
                                                $(this).closest('.popup').find('.lit-txt').append("<div class='input-w-x sensation_survey_answer'><i class='fa fa-exclamation-triangle' title='Submitted for approval'></i><span class='m_span'>" + clicked_value + "</span><i class='fa fa-close'></i><input class='sensation_suggestion' type='hidden' value='" + clicked_value + "'></div>");
//                        $(this).hide(300);
                                                $(this).closest('.q-sug-btn').hide(300);
                                                $(this).closest('.popup').find('.ui-autocomplete-input').hide(300);
                                                $(this).closest('.popup').find('.toggle_div').show(300);
                                                $(this).closest('.popup').find('.toggle_div button').show(300);

                                                var input_counts = $(this).closest('.popup').find('.lit-txt input').length;
                                                if (input_counts == 3) {
//                            $(this).hide(300);
                                                    $(this).closest('.popup').find('.toggle_div .add-another, .toggle_div .or-row').hide(300);
                                                }
                                            }
                                        });

                                        $('#tags2').autocomplete({
                                            select: function (a, b) {
                                                var clicked_val = (b.item.value);
                                                $(this).closest('.popup').find('.lit-txt').append("<div class='input-w-x sensation_survey_answer'><span class='m_span'>" + clicked_val + "</span><i class='fa fa-close'></i><input class='sensation_selected' type='hidden' value='" + clicked_val + "'></div>");
                                                
                                                $(this).hide(300);
                                                $(this).next().hide(300);
                                                $(this).closest('.popup').find('.toggle_div').show(300);
                                                $(this).closest('.popup').find('.toggle_div button , .toggle_div #question_2').show(300);
                                                var input_counts = $(this).closest('.popup').find('.lit-txt input').length;
                                                if (input_counts == 3) {
                                                    $(this).hide(300);
                                                    $(this).closest('.popup').find('.toggle_div .add-another, .toggle_div .or-row').hide(300);
                                                }
                                            }
                                        });

                                        //remove answers
                                        $('body').on('click', '.sensation_survey_answer .fa-close', function () {

                                            var parent_div = $(this).parents('.sensation_survey_answer');
                                            parent_div.remove();
                                            if ($('.sensation_survey_answer').length < 3) {
                                                $('#tags2').closest('.popup').find('.toggle_div .add-another, .toggle_div .or-row').show(300);
                                            }

                                            if ($('.sensation_survey_answer').length == 0) {
                                                $('#tags2').closest('.popup').find('.toggle_div .add-another, .toggle_div .or-row').hide(300);
                                                $('#tags2').closest('.popup').find('.toggle_div button,.toggle_div #question_2, .toggle_div .or-row').hide(300);
                                                $('#tags2').closest('.popup').find('#tags, #tags2, #tags3, #tags4, #tags5').val("");
                                                $('#tags2').closest('.popup').find('#tags, #tags2, #tags3, #tags4, #tags5').show(300);
                                            }
                                            //if selected answer is removed
                                            var selected = $(this).parents('.sensation_survey_answer').find('.sensation_selected');
                                            if (typeof selected.val() !== "undefined") {
                                                sensations.push(selected.val());
                                            }
                                        });

                                        $('#sensation_suggestion').submit(function (event) {

                                            // get the form data
                                            // there are many ways to get this data using jQuery (you can use the class or id also)
                                            var formData = {
                                                'suggestion': $('input[name=sensation]').val(),
                                                '_token': "<?php echo csrf_token(); ?>"
                                            };
                                            // process the form
                                            $.ajax({
                                                type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                                                url: '<?php echo asset('save-sensation-suggestion'); ?>', // the url where we want to POST
                                                data: formData, // our data object
                                                success: function (response) {
                                                    if (response.status == 'success') {
                                                    }
                                                }
                                            });
                                            // stop the form from submitting the normal way and refreshing the page
                                            event.preventDefault();
                                        });

                                        /************************************************/
                                        /**************   Sensation Ends   *************/
                                        /************************************************/



                                        /*******************************************************/
                                        /**************   Negative Effects Start   *************/
                                        /*******************************************************/

                                        $('#negative_effect_submit').click(function () {
                                            var clicked_value = $(this).closest('.popup').find('.ui-autocomplete-input').val();

                                            //Check if value already in suggestion
                                            var values = [];
                                            $('.negative_effect_suggestion').each(function () {
                                                values.push(this.value);
                                            });
                                            //use values after the loop
                                            if (jQuery.inArray(clicked_value, values) != -1) {
                                                $('#erroralertmessage').html('This suggestion is already submitted');
                                                $('#erroralert').show();
                                            } else {

//                        $(this).closest('.popup').find('.lit-txt').append("<input class='negative_effect_suggestion' type='text' value='" + clicked_value + "'>");
                                                $(this).closest('.popup').find('.lit-txt').append("<div class='input-w-x negative_effects_survey_answer'><i class='fa fa-exclamation-triangle' title='Submitted for approval'></i><span class='m_span'>" + clicked_value + "</span><i class='fa fa-close'></i><input class='negative_effect_suggestion' type='hidden' value='" + clicked_value + "'></div>");

//                        $(this).hide(300);
                                                $(this).closest('.q-sug-btn').hide(300);
                                                $(this).closest('.popup').find('.ui-autocomplete-input').hide(300);
                                                $(this).closest('.popup').find('.toggle_div').show(300);
                                                $(this).closest('.popup').find('.toggle_div button').show(300);

                                                var input_counts = $(this).closest('.popup').find('.lit-txt input').length;
                                                if (input_counts == 3) {
//                            $(this).hide(300);
                                                    $(this).closest('.popup').find('.toggle_div .add-another, .toggle_div .or-row').hide(300);
                                                }
                                            }
                                        });

                                        $('#tags3').autocomplete({
                                            select: function (a, b) {
                                                var clicked_val = (b.item.value);
                                                $(this).closest('.popup').find('.lit-txt').append("<div class='input-w-x negative_effects_survey_answer'><span class='m_span'>" + clicked_val + "</span><i class='fa fa-close'></i><input class='negative_effect_selected' type='hidden' value='" + clicked_val + "'></div>");
                                                
                                                $(this).hide(300);
                                                $(this).next().hide(300);
                                                $(this).closest('.popup').find('.toggle_div').show(300);
                                                $(this).closest('.popup').find('.toggle_div button , .toggle_div #question_3').show(300);
                                                var input_counts = $(this).closest('.popup').find('.lit-txt input').length;
                                                if (input_counts == 3) {
                                                    $(this).hide(300);
                                                    $(this).closest('.popup').find('.toggle_div .add-another, .toggle_div .or-row').hide(300);
                                                }
                                            }
                                        });

                                        //remove answers
                                        $('body').on('click', '.negative_effects_survey_answer .fa-close', function () {

                                            var parent_div = $(this).parents('.negative_effects_survey_answer');
                                            parent_div.remove();
                                            //if answer count is less than 3
                                            if ($('.negative_effects_survey_answer').length < 3) {
//                        $('#medical_suggestion_submit').show(300);
                                                $('#tags3').closest('.popup').find('.toggle_div .add-another, .toggle_div .or-row').show(300);
                                            }

                                            if ($('.negative_effects_survey_answer').length == 0) {
//                        $('#negative_effect_submit').show(300);
                                                $('#tags3').closest('.popup').find('.toggle_div .add-another, .toggle_div .or-row').hide(300);
                                                $('#tags3').closest('.popup').find('.toggle_div button,.toggle_div #question_3, .toggle_div .or-row').hide(300);
                                                $('#tags3').closest('.popup').find('#tags, #tags2, #tags3, #tags4, #tags5').val("");
                                                $('#tags3').closest('.popup').find('#tags, #tags2, #tags3, #tags4, #tags5').show(300);
                                            }
                                            //if selected answer is removed
                                            var selected = $(this).parents('.negative_effects_survey_answer').find('.negative_effect_selected');
                                            if (typeof selected.val() !== "undefined") {
                                                negative_effects.push(selected.val());
                                            }
                                        });

                                        $('#negative_effect_suggestion').submit(function (event) {

                                            // get the form data
                                            // there are many ways to get this data using jQuery (you can use the class or id also)
                                            var formData = {
                                                'suggestion': $('input[name=negative_effect]').val(),
                                                '_token': "<?php echo csrf_token(); ?>"
                                            };
                                            // process the form
                                            $.ajax({
                                                type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                                                url: '<?php echo asset('save-negative-effect-suggestion'); ?>', // the url where we want to POST
                                                data: formData, // our data object
                                                success: function (response) {
                                                    if (response.status == 'success') {
                                                    }
                                                }
                                            });
                                            // stop the form from submitting the normal way and refreshing the page
                                            event.preventDefault();
                                        });


                                        /*******************************************************/
                                        /**************   Negative Effects Ends   *************/
                                        /*******************************************************/


                                        /*************************************************/
                                        /**************   Prevention Start   *************/
                                        /*************************************************/

                                        $('#prevention_submit').click(function () {
                                            var clicked_value = $(this).closest('.popup').find('.ui-autocomplete-input').val();

                                            //Check if value already in suggestion
                                            var values = [];
                                            $('.prevention_suggestion').each(function () {
                                                values.push(this.value);
                                            });
                                            //use values after the loop
                                            if (jQuery.inArray(clicked_value, values) != -1) {
                                                $('#erroralertmessage').html('This suggestion is already submitted');
                                                $('#erroralert').show();
                                            } else {

//                        $(this).closest('.popup').find('.lit-txt').append("<input class='prevention_suggestion' type='text' value='" + clicked_value + "'>");
                                                $(this).closest('.popup').find('.lit-txt').append("<div class='input-w-x prevention_survey_answer'><i class='fa fa-exclamation-triangle' title='Submitted for approval'></i><span class='m_span'>" + clicked_value + "</span><i class='fa fa-close'></i><input class='prevention_suggestion' type='hidden' value='" + clicked_value + "'></div>");

//                        $(this).hide(300);
                                                $(this).closest('.q-sug-btn').hide(300);
                                                $(this).closest('.popup').find('.ui-autocomplete-input').hide(300);
                                                $(this).closest('.popup').find('.toggle_div').show(300);
                                                $(this).closest('.popup').find('.toggle_div button').show(300);

                                                var input_counts = $(this).closest('.popup').find('.lit-txt input').length;
                                                if (input_counts == 3) {
//                            $(this).hide(300);
                                                    $(this).closest('.popup').find('.toggle_div .add-another, .toggle_div .or-row').hide(300);
                                                }
                                            }
                                        });

                                        $('#tags5').autocomplete({
                                            select: function (a, b) {
                                                var clicked_val = (b.item.value);
                                                $(this).closest('.popup').find('.lit-txt').append("<div class='input-w-x prevention_survey_answer'><span class='m_span'>" + clicked_val + "</span><i class='fa fa-close'></i><input class='prevention_selected' type='hidden' value='" + clicked_val + "'></div>");
                                                
                                                $(this).hide(300);
                                                $(this).next().hide(300);
                                                $(this).closest('.popup').find('.toggle_div').show(300);
                                                $(this).closest('.popup').find('.toggle_div button , .toggle_div #question_5').show(300);
                                                var input_counts = $(this).closest('.popup').find('.lit-txt input').length;
                                                if (input_counts == 3) {
                                                    $(this).hide(300);
                                                    $(this).closest('.popup').find('.toggle_div .add-another, .toggle_div .or-row').hide(300);
                                                }
                                            }
                                        });

                                        //remove answers
                                        $('body').on('click', '.prevention_survey_answer .fa-close', function () {

                                            var parent_div = $(this).parents('.prevention_survey_answer');
                                            parent_div.remove();
                                            //if answer count is less than 3
                                            if ($('.prevention_survey_answer').length < 3) {
//                        $('#medical_suggestion_submit').show(300);
                                                $('#tags5').closest('.popup').find('.toggle_div .add-another, .toggle_div .or-row').show(300);
                                            }

                                            if ($('.prevention_survey_answer').length == 0) {
//                        $('#prevention_submit').show(300);
                                                $('#tags5').closest('.popup').find('.toggle_div .add-another, .toggle_div .or-row').hide(300);
                                                $('#tags5').closest('.popup').find('.toggle_div button,.toggle_div #question_5, .toggle_div .or-row').hide(300);
                                                $('#prevention_submit').closest('.popup').find('#tags, #tags2, #tags3, #tags4, #tags5').val("");
                                                $('#tags5').closest('.popup').find('#tags, #tags2, #tags3, #tags4, #tags5').show(300);
                                            }

                                            //if selected answer is removed
                                            var selected = $(this).parents('.prevention_survey_answer').find('.prevention_selected');
                                            if (typeof selected.val() !== "undefined") {
                                                preventions.push(selected.val());
                                            }
                                        });


                                        $('#prevention_suggestion').submit(function (event) {

                                            // get the form data
                                            // there are many ways to get this data using jQuery (you can use the class or id also)
                                            var formData = {
                                                'suggestion': $('input[name=prevention]').val(),
                                                '_token': "<?php echo csrf_token(); ?>"
                                            };
                                            // process the form
                                            $.ajax({
                                                type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                                                url: '<?php echo asset('save-prevention-suggestion'); ?>', // the url where we want to POST
                                                data: formData, // our data object
                                                success: function (response) {
                                                    if (response.status == 'success') {
                                                    }
                                                }
                                            });
                                            // stop the form from submitting the normal way and refreshing the page
                                            event.preventDefault();
                                        });

                                        /*************************************************/
                                        /**************   Prevention Ends   *************/
                                        /*************************************************/

                                    });

                                    var availableTags;
                                    //Autocomplete
                                    $(function () {
                                        availableTags = [
                                            "ActionScript",
                                            "AppleScript",
                                            "Asp",
                                            "BASIC",
                                            "C",
                                            "C++",
                                            "Clojure",
                                            "COBOL",
                                            "ColdFusion",
                                            "Erlang",
                                            "Fortran",
                                            "Groovy",
                                            "Haskell",
                                            "Java",
                                            "JavaScript",
                                            "Lisp",
                                            "Perl",
                                            "PHP",
                                            "Python",
                                            "Ruby",
                                            "Scala",
                                            "Scheme"
                                        ];

                                        $("#tags4").autocomplete({
                                            source: availableTags
                                        });
                                    });

                                    $('.popup').each(function () {
                                        $('#tags, #tags2, #tags3, #tags4, #tags5').each(function () {
                                            $(this).keyup(function () {
                                                var search_term = $(this).val();
                                                var search = search_term.toUpperCase();
                                                var array = jQuery.grep(availableTags, function (value) {
                                                    return value.toUpperCase().indexOf(search) >= 0;
                                                });
                                                if (array.length == 0) {
//                            $(this).next('.sugest-adition').css('display', 'block');
                                                    $(this).next('.q-sug-btn').css('display', 'block');
                                                } else {
//                            $(this).next('.sugest-adition').css('display', 'none');
                                                    $(this).next('.q-sug-btn').css('display', 'none');
                                                }
                                            });
//                    $(this).autocomplete({
//                        select: function (a, b) {
//                            var clicked_val = (b.item.value);
////                            $(this).closest('.popup').find('.lit-txt').append("<input type='text' value='" + clicked_val + "'>");
//                            $(this).closest('.popup').find('.lit-txt').append("<div class='input-w-x'><span class='m_span'>" + clicked_val + "</span><i class='fa fa-close'></i><input type='hidden' value='" + clicked_val + "'></div>");
//                            
//                            $(this).hide(300);
//                            $(this).closest('.popup').find('.toggle_div').show(300);
//                            var input_counts = $(this).closest('.popup').find('.lit-txt input').length;
//                            if (input_counts == 3) {
//                                $(this).hide(300);
//                                $(this).closest('.popup').find('.toggle_div .add-another, .toggle_div .or-row').hide(300);
//                            }
//                        }
//                    });
                                        });
                                    });
                                    $('.add-another').each(function () {
                                        $(this).click(function () {
                                            $(this).closest('.edit-search-area').find('#tags, #tags2, #tags3, #tags4, #tags5').show(300);
                                            if ($(this).closest('.edit-search-area').find('#tags, #tags2, #tags3, #tags4, #tags5').val() == "") {
                                                $(this).closest('.toggle_div').hide(300);
                                            } else {
                                                $(this).closest('.toggle_div button').hide(300);
                                            }
                                        });
                                    });
                                    $('#scroll-to-form').click(function () {
                                        $('html, body').animate({
                                            scrollTop: $($(this).attr('href')).offset().top
                                        }, 500);
                                    });
                                    $('.strain_class').unbind().click(function () {
                                        count = 0;
                                        $('.popup').hide();
                                        if (count === 0) {
                                            count = 1;
                                            id = this.id;
                                            $('#strain-share-review-' + id).fadeOut();

                                            $.ajax({
                                                url: "<?php echo asset('add_question_share_points') ?>",
                                                type: "GET",
                                                data: {
                                                    "id": id, "type": "Strain"
                                                },
                                                success: function (data) {
                                                    count = 0;
                                                }
                                            });
                                        }
                                    });
                                    function hideDiv() {
                                        $('#success_id').hide();
                                    }
                                    function refreshPageLast() {
                                        window.location.reload();
                                    }
                                    function refreshPage() {
                                        strain_id = '<?= $strain_id ?>';
                                        $.ajax({
                                            type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
                                            url: '<?php echo asset('delete-strain-survay'); ?>', // the url where we want to POST
                                            data: {strain_id: strain_id}, // our data object
                                            success: function (response) {
                                            }
                                        });
//                                
                                        window.location.reload();
                                    }
                                    $('#question_1').click(function ()
                                    {
                                        $('#start-survey').hide();
                                    });
                                    $('#question_2').click(function ()
                                    {
                                        $('#q-2').hide();
                                    });
                                    $('#question_3').click(function ()
                                    {
                                        $('#q-3').hide();
                                    });
                                    $('#question_4').click(function ()
                                    {
                                        $('#q-4').hide();
                                    });
                                    $('#question_5').click(function ()
                                    {
                                        $('#q-5').hide();
                                    });
                                    $('#question_6').click(function ()
                                    {
                                        $('#select-flavor').hide();
                                    });
                                    /* Go back btn functionality */
                                    $('#goback_2').click(function ()
                                    {
                                        $('#q-2').hide();
                                    });
                                    $('#goback_3').click(function ()
                                    {
                                        $('#q-3').hide();
                                    });
                                    $('#goback_4').click(function ()
                                    {
                                        $('#q-4').hide();
                                    });
                                    $('#goback_5').click(function ()
                                    {
                                        $('#q-5').hide();
                                    });
                                    $('#goback_6').click(function ()
                                    {
                                        $('#select-flavor').hide();
                                    });
                                    $('#goback_7').click(function ()
                                    {
                                        $('#final-step').hide();
                                    });
                                    function addremovelike(review_id, strain_id, like_val) {
                                        var current_likes = $('#reviews_count_' + review_id).html();
                                        if (like_val == 1) {
                                            $('#add_strain_review_like_' + review_id).hide();
                                            $('#remove_strain_review_like_' + review_id).show().css({
                                                'cursor': 'pointer'
                                            });
                                            $('#reviews_count_' + review_id).html(parseInt(current_likes) + parseInt(1));
                                        } else {
                                            $('#remove_strain_review_like_' + review_id).hide();
                                            $('#add_strain_review_like_' + review_id).show().css({
                                                'cursor': 'pointer'
                                            });
                                            $('#reviews_count_' + review_id).html(parseInt(current_likes) - parseInt(1));

                                        }
                                        $.ajax({
                                            type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
                                            url: '<?php echo asset('add-like-strain-review'); ?>', // the url where we want to POST
                                            data: {review_id: review_id, strain_id: strain_id, like_val: like_val}, // our data object
                                            success: function (response) {
                                            }
                                        });
//   
//   
                                    }
                                    function changeHref(to_change, change_href, go_back) {
                                        $('#' + to_change).attr('href', '#' + change_href);
                                        $('#goback_6').attr('href', '#' + go_back);
                                    }
        </script>
    </body>
</html>