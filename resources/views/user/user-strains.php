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
                        <div class="tabbing str-tb-up">
                            <div class="ask-area">
                                <?php // include 'includes/questions_search.php'; ?>
                                <?php include 'includes/strain-header.php'; ?>
                                <?php $strain_id = $strain->id; ?>

                                <ul class="tabs list-none">
                                    <li class="first"><a href="<?php echo asset('strain-details/' . $strain->id); ?>">Strain Overview</a></li>
                                    <li class="active second"><a href="<?php echo asset('user-strains-listing/' . $strain->id); ?>">Strain Details</a></li>
                                    <!--<li class="third"><a href="#strain-overview">Gallery</a></li>-->
                                    <li class="third"><a href="<?php echo asset('strain-gallery/' . $strain->id); ?>">Gallery</a></li>
                                    <?php if (Auth::user()) { ?>
                                        <li class="fourth"><a href="<?php echo asset('strain-product-listing/' . $strain->id); ?>">Locate This</a></li>
                                    <?php } else { ?>
                                        <li class="fourth"><a href="#loginModal" class="new_popup_opener">Locate This</a></li>
                                    <?php } ?>
                                </ul>
                                <div class="right_content">

                                    <?php
                                    if (count($user_strains) > 0 && $get_likes_count > 4) {

                                        $top_strain = $user_strains->sortByDesc('get_likes_count')->first();
                                        if (Auth::user()) {
                                            ?>

                                            <a href="<?php echo asset('user-strain-add/' . $strain->id); ?>" class="btn-primary yellow_bordered"><i class="fa fa-pencil" aria-hidden="true"></i> Add More Info to this Strain</a>
                                        <?php } else { ?>
                                            <a href="#loginModal" class="btn-primary yellow_bordered new_popup_opener"><i class="fa fa-pencil" aria-hidden="true"></i> Add More Info to this Strain</a>
                                        <?php } ?>
                                        <?php $top_user_strain = $top_strain; ?>
                                        <div class="tab-wid">
                                            <header class="header strain-right-col-type">
                                                <strong class="title">Type:</strong>
                                                <div class="strain-right-col-h">
                                                    <em class="key <?= $top_user_strain->genetics; ?>"><?= substr($top_user_strain->genetics, 0, 1); ?></em>
                                                    <span class="<?= $top_user_strain->genetics; ?>"><?php echo $top_user_strain->genetics; ?></span>
                                                    <span class="tools-holder">
                                                        <img src="<?php echo asset('userassets/images/bg-success.svg') ?>" class="success-img add tool-opener" alt="Image">
                                                        <div class="new-tools">
                                                            <p>Hybrid strains are a cross-breed of Indica and Sativa strains. Due to the plethora of possible combinations, the medical benefits, effects and sensations vary greatly.</p>
                                                            <p>Hybrid are most commonly created to target and treat specific medical conditions and illnesses.</p>
                                                            <a href="#" class="tools-closer"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                        </div>
                                                    </span>
                                                </div>
                                                <div class="range-slider custom-slider slide-wh-hide">
                                                    <!--<input class="range-slider__value" type="hidden" name="indica">-->
                                                    <input type="text" class="value_changer_input hidden">
                                                    <span class="total-range"><?= $top_user_strain->indica ?></span>
                                                    <input class="range-slider__range" type="range" min="0" max="100"  value="<?= $top_user_strain->sativa ?>" name="sativa">
                                                    <span class="range-slider__value">0</span>
                                                </div>
                                                <div class="ui_slider_labels">
                                                    <span class="purple">Indica</span>
                                                    <span class="red">Sativa</span>
                                                </div>
                                            </header>
                                        </div>
                                        <?php
                                        if ($top_user_strain->cross_breed) {
                                            $cross_breed = explode(',', $top_user_strain->cross_breed);
                                            ?>
                                            <div class="tab-wid no-border strain-parent-sec ">
                                                <header class="header">
                                                    <strong class="title">Parentage / Genetics </strong>
                                                </header>
                                                <div class="genetics">
                                                    <img src="<?php echo asset('userassets/images/parentage.svg') ?>" alt="Image">
                                                    <div class="genetic-txt">
                                                        <em>Cross-Breed of:</em>
                                                        <span><a href="<?php echo asset('strain-details-by-name/' . $cross_breed[0]) ?>"><?php echo $cross_breed[0]; ?></a> <i>and</i> <a href="<?php echo asset('strain-details-by-name/' . $cross_breed[1]) ?>"><?php echo $cross_breed[1]; ?></a></span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="clearfix"></div>
                                        <div class="hb_yld_climate_wrap">
                                            <div class="hb_yld_sec">
                                                <strong>Yield</strong>
                                                <div class=""></div>
                                                <img src="<?php echo asset('userassets/images/yield.png') ?>" al="Yield" /><br/>
                                                <span><?php echo $top_user_strain->yeild; ?></span>
                                            </div>
                                            <div class="hb_climate_sec">
                                                <strong>Climate</strong>
                                                <img src="<?php echo asset('userassets/images/climate.png') ?>" al="Climate" /><br/>
                                                <span><?php echo $top_user_strain->climate; ?></span>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <dl class="details">
                                            <dt>Notes:</dt>
                                            <dd><?php echo $top_user_strain->note; ?></dd>
                                        </dl>
                                    <?php } ?>
                                </div>

                                <div <?php if (count($user_strains) > 0 && $get_likes_count > 4) { ?> class="left_content" <?php } ?>>
                                    <?php
                                    if (count($user_strains) > 0 && $get_likes_count > 4) {
                                        $top_strain = $user_strains->sortByDesc('get_likes_count')->first();
                                        ?>
                                        <?php $top_user_strain = $top_strain; ?>
                                        <div id="tab-content">
                                            <div id="strain-details" class="tab active">
                                                <div class="tab-wid no-border strain-des-sec">
                                                    <header class="header">
                                                        <strong class="title">Full Description:</strong>
                                                        <span class="symbol">
                                                            <img src="<?php echo asset('userassets/images/likeRed.svg') ?>" alt="Image" class="img-responsive"> 
                                                            <span><?php echo $top_user_strain->get_likes_count; ?></span>   
                                                        </span>
                                                    </header>
                                                    <?php if (trim($top_user_strain->description) != '') { ?>
                                                        <p><?php echo $top_user_strain->description; ?></p>
                                                    <?php } else { ?>
                                                        <p>No description available.</p>
                                                    <?php } ?>

                                                </div>
                                                <div class="tab-wid no-border strain-des-sec">
                                                    <header class="header">
                                                        <strong class="title">Chemistry</strong>
                                                    </header>
                                                    <div class="chemist-box">
                                                        <div class="chem-img">
                                                            <img src="<?php echo asset('userassets/images/chemist.png') ?>" alt="Image">
                                                        </div>
                                                        <div class="chem-row-main">
                                                            <div class="chem-row">
                                                                <span>CBD</span>
                                                                <span><?= $top_user_strain->min_CBD ?><em>%</em></span>
                                                                <span class="chem-to">to</span>
                                                                <span><?= $top_user_strain->max_CBD ?><em>%</em></span>
                                                            </div>
                                                            <div class="chem-row">
                                                                <span>THC</span>
                                                                <span><?= $top_user_strain->min_THC ?><em>%</em></span>
                                                                <span class="chem-to">to</span>
                                                                <span><?= $top_user_strain->max_THC ?><em>%</em></span>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-wid no-border strain-des-sec">
                                                    <header class="header">
                                                        <strong class="title">Growing &amp; Care:</strong>
                                                    </header>
                                                    <ul class="growing-list list-none strain-four-col">
                                                        <li>
                                                            <strong>Difficulty Level</strong>
                                                            <img class="eas" src="<?php echo asset('userassets/images/' . $top_user_strain->growing . '.svg') ?>" alt="Image">
                                                            <span><?php echo $top_user_strain->growing; ?></span>
                                                        </li>
                                                        <li class="inline">
                                                            <strong>Mature Height</strong>
                                                            <img src="<?php echo asset('userassets/images/tree.svg') ?>" alt="Image">
                                                            <span><?php echo $top_user_strain->plant_height + 0; ?>"</span>
                                                        </li>
                                                        <li>
                                                            <strong>Flowering Time</strong>
                                                            <h4><?php echo $top_user_strain->flowering_time; ?></h4>
                                                            <span>days</span>
                                                        </li>
                                                        <li class="inline">
                                                            <strong>Hardness Zones</strong>
                                                            <img src="<?php echo asset('userassets/images/temperature.svg') ?>" class="img-temp" alt="Image">
                                                            <span class="text-white">
                                                                <b><?php echo $top_user_strain->min_fahren_temp + 0; ?>°F</b><br>
                                                                to<br>
                                                                <b><?php echo $top_user_strain->max_fahren_temp + 0; ?>°F</b><br>
                                                                <small><?php echo $top_user_strain->min_celsius_temp + 0; ?>&#8451; - <?php echo $top_user_strain->max_celsius_temp + 0; ?>&#8451;</small>
                                                            </span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div id="tab-content">
                                            <div id="strain-details" class="tab active">
                                                <div class="tab-wid no-border strain-des-sec">
                                                    <header class="header">
                                                        <strong class="title">Full Description:</strong>
                                                    </header>
                                                    <p><?php echo $strain->overview; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if (Auth::user()) {
                                            if (count($user_strains) > 0) {
                                                ?>
                                                <a href="<?php echo asset('user-strain-add/' . $strain->id); ?>" class="btn-primary green center"><i class="fa fa-pencil" aria-hidden="true"></i>Add More Info to this Strain</a>
                                            <?php } else { ?>
                                                <a href="<?php echo asset('user-strain-add/' . $strain->id); ?>" class="btn-primary green center"><i class="fa fa-pencil" aria-hidden="true"></i>Be First to Add More Info to this Strain</a>
                                            <?php
                                            }
                                        } else { {
                                                if (count($user_strains) > 0) {
                                                    ?>
                                                    <a href="#loginModal" class="btn-primary green center new_popup_opener"><i class="fa fa-pencil" aria-hidden="true"></i>Add More Info to this Strain</a>
                                                <?php } else { ?>
                                                    <a href="#loginModal" class="btn-primary green center new_popup_opener"><i class="fa fa-pencil" aria-hidden="true"></i>Be First to Add More Info to this Strain</a>
                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </div>

                                <div class="tab-wid strain-edit-sec">
                                    <?php if ($get_likes_count > 4) { ?>
                                        Strain details will be replaced by user strain detail with minimum of 5 likes 
<?php } ?>
                                    <header class="header">

                                        <strong class="title left no-margin">
<?php if(count($user_strains) > 0) { ?>
<?php echo count($user_strains); ?> Edits
<?php } ?>
                                        </strong>
                                        <span class="tooltip-holder">
                                            <div class="tools-holder">
                                                <img src="<?php echo asset('userassets/images/bg-success.svg') ?>" alt="Image" class="tool-opener">
                                                <div class="new-tools">
                                                    <p>Your Vote Counts!</p>
                                                    <p>Buy up-voting a user submitted description, you are  endorsing that the information provided is the best among other user submissions.</p>

                                                    <p>The highest voted description becomes the featured description for this strain.</p>
                                                    <a href="#" class="tools-closer"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </span>
                                    </header>
<?php if (count($user_strains) == 0) { ?>
                                        <div class="stain_static_img" onclick="location.href='<?php echo asset('user-strain-add/' . $strain->id); ?>'" style="cursor: pointer">
                                            <img src="<?php echo asset('userassets/images/GreyedOutImageWeb.jpg') ?>" alt="" class="img-responsive webView" />
                                            <img src="<?php echo asset('userassets/images/GreyedOutImageMobile.jpg') ?>" alt="" class="img-responsive mobileView" />
                                        </div>
                                        <a href="<?php echo asset('user-strain-add/' . $strain->id); ?>" class="btn-primary green center" style="color: #fff"><i class="fa fa-pencil" aria-hidden="true"></i>Be First to Add More Info to this Strain</a>
                                        <?php } ?>
                                    <ul class="reviews-list list-none str-rev-pad-rem">
                                                <?php foreach ($user_strains as $user_strain) { ?>
                                            <li>
                                                <div class="txt fluid">
    <?php if ($user_strain->get_likes_count >= 5) { ?>
                                                        <!--                                                        <div class="right">
                                                                                                                    <img src="<?php // echo asset('userassets/images/likeRed.svg')  ?>" alt="Image" class="img-responsive radius">
                                                                                                                </div>-->
    <?php } ?>
                                                    <div class="center-div">
                                                        <div class="text-div">
                                                            <div class="strain-edit-col">
                                                                <div class="icon pre-main-image hb_round_img" style="background-image: url(<?php echo getImage($user_strain->getUser->image_path, $user_strain->getUser->avatar) ?>)">
                                                                    <?php if ($user_strain->getUser->special_icon) { ?>
                                                                        <span class="fest-pre-img" style="background-image: url(<?php echo asset('public/images' . $user_strain->getUser->special_icon) ?>);"></span>
                                                                <?php } ?>
                                                                </div>
    <?php if (Auth::user()) {
        if ($user_strain->get_user_like_count > 0) {
            ?>
                                                                        <div class="icon vote_strain">
                                                                            <a href="<?php
                                                                               if ($current_id != $user_strain->user_id) {
                                                                                   echo asset('save-user-strain-like/' . $user_strain->id . '/' . $strain->id . '/0');
                                                                               } else {
                                                                                   echo 'javascript:void(0)';
                                                                               }
                                                                               ?>">
                                                                                <i class="fa fa-thumbs-up yellow_thumb active" id="user_strain_like_<?php echo $user_strain->id; ?>" aria-hidden="true" ></i>  
                                                                            </a>
                                                                            <span class="user_strain_like" id="user_strain_like_count_<?php echo $user_strain->id; ?>"><?php echo $user_strain->get_likes_count; ?></span>
                                                                            <div class="user_vote icon" id="user_strain_like_vote_<?php echo $user_strain->id; ?>">
                                                                                <img src="<?php echo asset('userassets/images/check2.svg') ?>" alt="Image" class="img-responsive">
                                                                                <span class="yellow">Got Your Vote</span>
                                                                            </div>
                                                                        </div>
                                                                        <?php } else { ?>
                                                                        <div class="icon vote_strain">
                                                                            <a href="<?php
                                                                if ($current_id != $user_strain->user_id) {
                                                                    echo asset('save-user-strain-like/' . $user_strain->id . '/' . $strain->id . '/1');
                                                                } else {
                                                                    echo 'javascript:void(0)';
                                                                }
                                                                            ?>">
                                                                                <i class="fa fa-thumbs-up yellow_thumb" id="user_strain_like_<?php echo $user_strain->id; ?>" aria-hidden="true" ></i>  
                                                                            </a>
                                                                            <span class="user_strain_like" id="user_strain_like_count_<?php echo $user_strain->id; ?>"><?php echo $user_strain->get_likes_count; ?></span>

                                                                        </div>
        <?php }
    } else {
        ?>
                                                                    <div class="icon vote_strain">
                                                                        <a href="#loginModal" class="new_popup_opener">
                                                                            <i class="fa fa-thumbs-up yellow_thumb" id="user_strain_like_<?php echo $user_strain->id; ?>" aria-hidden="true" ></i>  
                                                                        </a>
                                                                        <span class="user_strain_like" id="user_strain_like_count_<?php echo $user_strain->id; ?>"><?php echo $user_strain->get_likes_count; ?></span>

                                                                    </div>
    <?php } ?>
                                                            </div>
                                                            <div class="desc_txt">
    <?php if ($user_strain->user_id == $current_id) { ?>
                                                                    <span class="dot-options">
                                                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                                        <div class="sort-drop">
                                                                            <div class="sort-item">
                                                                                <a class="white flag report" href="<?php echo asset('edit-user-strain/' . $user_strain->id) ?>">
                                                                                    <i class="fa fa-pencil" aria-hidden="true"></i><span>Edit</span>
                                                                                </a>
                                                                            </div>
                                                                            <div class="sort-item">
                                                                                <a class="white flag report btn-popup" href="#delete_strain<?php echo $user_strain->id; ?>">
                                                                                    <i class="fa fa-trash" aria-hidden="true"></i><span>Delete</span>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </span>
                                                                    <!-- Modal -->
                                                                    <div id="delete_strain<?php echo $user_strain->id; ?>" class="popup">
                                                                        <div class="popup-holder">
                                                                            <div class="popup-area">
                                                                                <div class="text">
                                                                                    <div class="edit-holder">
                                                                                        <div class="step">
                                                                                            <div class="step-header">
                                                                                                <h4>Delete Strain</h4>
                                                                                                <p class="yellow no-margin">Are you sure to delete this strain.</p>
                                                                                            </div>
                                                                                            <a href="<?php echo asset('delete-user-strain/' . $user_strain->id); ?>" class="btn-heal">yes</a>
                                                                                            <a href="#" class="btn-heal btn-close">No</a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Modal End-->
    <?php } ?>
                                                                <span class="date"><b>Updated Description</b> <i><?php echo timeago($user_strain->updated_at); ?></i></span>
                                                                <strong> <a class="<?= getRatingClass($user_strain->getUser->points) ?>" href="<?= asset('user-profile-detail/' . $user_strain->getUser->id) ?>"><?= $user_strain->getUser->first_name ?></a></strong>
                                                                        <?php if (trim($user_strain->description) != '') { ?>
                                                                    <p><?php echo $user_strain->description; ?></p>
                                                                        <?php } else { ?>
                                                                    <p>No description available.</p>
    <?php } ?>
                                                                <div class="text-div">
                                                                    <div class="desc_txt">
    <?php if (Auth::user()) { ?>
                                                                            <a href="<?php echo asset('user-strain-detail?strain_id=' . $strain->id . '&user_strain_id=' . $user_strain->id); ?>" class="view-more">View all edits added by this user</a>
    <?php } else { ?>
                                                                            <a href="#loginModal" class="view-more new_popup_opener">View all edits added by this user</a>
                                            <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </li>
                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="right_sidebars">
        <?php if (Auth::user()) {
            include 'includes/rightsidebar.php';
            ?>
    <?php include 'includes/chat-rightsidebar.php';
}
?>
                    </div>
                </div>
            </article>
        </div>
<?php include('includes/footer.php'); ?>
        <script>

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
            $(document).ready(function () {
                //        $("#strain_like a").click(function() {
                //            alert('ddsf');
                //        });

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

//                $('#strain_flag_revert').click(function (e) {
//                    $.ajax({
//                        url: "<?php echo asset('strain_flag_revert') ?>",
//                        type: "POST",
//                        data: {"strain_id": '<?= $strain->id; ?>', "_token": "<?php echo csrf_token(); ?>"},
//                        success: function (response) {
//                            if (response.status == 'success') {
//                                $('#strain_flag_revert').hide();
//                                $('#strain_flag').show();
//                            }
//                        }
//                    });
//                });


                $('#gal-img').on('change', function () {
                    $("#upload_image").submit();
                });

            });

            $('.strain_class').unbind().click(function () {
                count = 0;

                if (count === 0) {
                    count = 1;
                    id = this.id;
                    $('#strain-share-' + id).fadeOut();
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
        </script>
    </body>
</html>