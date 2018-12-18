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
                        <div class="str-sin-edi">
                            <div class="left-str-sin">

                                <figure class="pre-main-image" style="background-image: url(<?php echo getImage($user_strain->getUser->image_path, $user_strain->getUser->avatar) ?>)">
                                    <?php if ($user_strain->getUser->special_icon) { ?>
                                        <span class="fest-pre-img" style="background-image: url(<?php echo asset('public/images' . $user_strain->getUser->special_icon) ?>);"></span>
                                    <?php } ?>
                                </figure>

                                <div>
                                    <span>Edits by:</span>
                                    <h3><a class="<?= getRatingClass($user_strain->getUser->points) ?>" href="<?= asset('user-profile-detail/' . $user_strain->getUser->id) ?>"><?= $user_strain->getUser->first_name ?></a></h3>
                                </div>
                            </div>
                            <div class="right-str-sin">
                                <?php if(Auth::user()) { if ($user_strain->get_user_like_count > 0) { ?>
                                                                    <div class="icon vote_strain">
                                                                        <a href="<?php if($current_id != $user_strain->user_id){ echo asset('save-user-strain-like/' . $user_strain->id . '/' . $strain->id . '/0'); }else{ echo 'javascript:void(0)';} ?>">
                                                                            <i class="fa fa-thumbs-up yellow_thumb active" id="user_strain_like_<?php echo $user_strain->id; ?>" aria-hidden="true" ></i>  
                                                                        </a>
                                                                        <span class="yellow">Vote (<?php echo $user_strain->get_likes_count; ?>)</span>
                                                                        <div class="user_vote icon" style="padding-top: 10px;" id="user_strain_like_vote_<?php echo $user_strain->id; ?>">
                                                                            <img src="<?php echo asset('userassets/images/check2.svg') ?>" alt="Image" style="max-width: 15px">
                                                                            <span class="yellow">Got Your Vote</span>
                                                                        </div>
                                                                    </div>
    <?php } else { ?>
                                                                    <div class="icon vote_strain">
    <a href="<?php if($current_id != $user_strain->user_id){ echo asset('save-user-strain-like/' . $user_strain->id . '/' . $strain->id . '/1');}else{ echo 'javascript:void(0)';} ?>">
                                                                            <i class="fa fa-thumbs-up" id="user_strain_like_<?php echo $user_strain->id; ?>" aria-hidden="true" ></i>  
                                                                        </a>
                                                                        <span>Vote (<?php echo $user_strain->get_likes_count; ?>)</span>

                                                                    </div>
<?php }} else{ ?>
                                                                <div class="icon vote_strain">
                                                                    <a href="#loginModal" class="new_popup_opener">
                                                                            <i class="fa fa-thumbs-up" id="user_strain_like_<?php echo $user_strain->id; ?>" aria-hidden="true" ></i>  
                                                                        </a>
                                                                       <span>Vote (<?php echo $user_strain->get_likes_count; ?>)</span>

                                                                    </div>
<?php } ?>
<!--                                <a href="#">
                                    <i class="fa fa-thumbs-up"></i>
                                    <span>Vote (<?php echo $user_strain->get_likes_count; ?>)</span>
                                </a>-->
                            </div>
                        </div>
                        <?php // include('includes/strain_slider.php'); ?>
                        <?php //include('includes/strain-header.php'); ?>
                        <div class="tabbing">
                            <!--                            <ul class="tabs list-none">
                                                            <li class="first"><a href="<?php echo asset('strain-details/' . $strain->id); ?>">Strain Overview</a></li>
                                                            <li class="active second"><a href="<?php echo asset('user-strains-listing/' . $strain->id); ?>">Strain Details</a></li>
                                                            <li class="third"><a href="<?php echo asset('strain-gallery/' . $strain->id); ?>">Gallery</a></li>
                                                            <li class="fourth"><a href="<?php echo asset('strain-product-listing/' . $strain->id); ?>">Locate This</a></li>
                                                        </ul>-->
                            <div class="pd-top clearfix">
                                <div class="right_content">
                                    <?php if($current_id == $user_strain->user_id){ ?>
                                    <a href="<?php echo asset('edit-user-strain/' . $user_strain->id); ?>" class="btn-primary yellow_bordered"><i class="fa fa-pencil" aria-hidden="true"></i> Edit User Strain</a>
                                    <?php } ?>
                                    <div class="tab-wid">
                                        <header class="header strain-right-col-type">
                                            <strong class="title">Type:</strong>
                                            <div class="strain-right-col-h">
                                                <span class="<?= $user_strain->genetics; ?>"><?php echo $user_strain->genetics; ?></span>
                                                <span class="tools-holder">
                                                    <img src="<?php echo asset('userassets/images/bg-success.svg') ?>" class="success-img add tool-opener" alt="Image">
                                                    <div class="new-tools">
                                                        <p>Hybrid strains are a cross-breed of Indica and Sativa strains. Due to the plethora of possible combinations, the medical benefits, effects and sensations vary greatly.</p>
                                                        <p>Hybrid are most commonly created to target and treat specific medical conditions and illnesses.</p>
                                                        <a href="#" class="tools-closer"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                    </div>
                                                </span>
                                            </div>
                                            <div id="custom-slider" style="margin-top: 0px;" class="range-slider custom-slider slide-wh-hide">
                                                <div class="dragger"></div>
                                                <span class="gained"><?php echo $user_strain->indica; ?>%</span>
                                                <span class="total"><?php echo $user_strain->sativa; ?>%</span>
                                            </div>
                                            <div class="ui_slider_labels">
                                                <span class="tooltip-holder">
                                                    <em class="purple">Indica</em>
                                                    <div class="tools-holder">
                                                        <img src="<?php echo asset('userassets/images/bg-success.svg') ?>" alt="Image" class="tool-opener">
                                                        <div class="new-tools">
                                                            <p>Indica plants typically grow short and wide which makes them better suited for indoor growing. Indica-dominant strains tend to have a strong sweet/sour odor.</p>
                                                            <p>Indicas are very effective for overall pain relief and helpful in treating general anxiety, body pain, and sleeping disorders. It is commonly used in the evening or even right before bed due to it's relaxing effects.</p>
                                                            <strong>Most Commonly Known Benefits:</strong>
                                                            <ol class="custom-benefits">
                                                                <li>Relieves body pain</li>
                                                                <li>Relaxes muscles</li>
                                                                <li>Relieves spasms, reduces seizures</li>
                                                                <li>Relieves headaches and migraines</li>
                                                                <li>Relieves anxiety or stress</li>
                                                            </ol>
                                                            <a href="#" class="tools-closer"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                        </div>
                                                    </div>
                                                </span>
                                                <span class="tooltip-holder">
                                                    <em class="red">Sativa</em>
                                                    <div class="tools-holder">
                                                        <img src="<?php echo asset('userassets/images/bg-success.svg') ?>" alt="Image" class="tool-opener">
                                                        <div class="new-tools add">
                                                            <p>Sativa plants grow tall and thin, making them better suited for outdoor growing-some strains can reach over 25 ft, in height. Sativa-dominant strains tend to have a more grassy-type odor.</p>
                                                            <p>Sativa effects are known to spark creativity and produce energetic and uplifting sensations. It is commonly used in the daytime due to its cerebral stimulation.</p>
                                                            <strong>Most Commonly Known Benefits:</strong>
                                                            <ol class="custom-benefits">
                                                                <li>Produces feelings of well-being</li>
                                                                <li>Uplifting and cerebral thoughts</li>
                                                                <li>Stimulates and energizes</li>
                                                                <li>Increases focus and creativity</li>
                                                                <li>Fights depression</li>
                                                            </ol>
                                                            <a href="#" class="tools-closer"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                        </header>
                                    </div>
                                    <div class="tab-wid no-border strain-parent-sec">
                                        <?php
                                        if ($user_strain->cross_breed) {
                                            $cross_breed = explode(',', $user_strain->cross_breed);
                                            ?>
                                            <div class="tab-wid">
                                                <header class="header">
                                                    <strong class="title">Parentage / Genetics</strong>
                                                </header>
                                                <div class="genetics">
                                                    <img src="<?php echo asset('userassets/images/parentage.svg') ?>" alt="Image">
                                                    <div class="genetic-txt">
                                                        <em>Cross-Breed of</em>
                                                        <span><a href="<?php echo asset('strain-details-by-name/' . $cross_breed[0]) ?>"><?php echo $cross_breed[0]; ?></a> <i>and</i> <a href="<?php echo asset('strain-details-by-name/' . $cross_breed[1]) ?>"><?php echo $cross_breed[1]; ?></a></span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="hb_yld_climate_wrap">
                                        <div class="hb_yld_sec">
                                            <strong>Yield</strong>
                                            <div class=""></div>
                                            <img src="<?php echo asset('userassets/images/yield.png') ?>" al="Yield" /><br/>
                                            <span><?php echo $user_strain->yeild; ?></span>
                                        </div>
                                        <div class="hb_climate_sec">
                                            <strong>Climate</strong>
                                            <img src="<?php echo asset('userassets/images/climate.png') ?>" al="Climate" /><br/>
                                            <span><?php echo $user_strain->climate; ?></span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <dl class="details">
                                        <dt>Notes:</dt>
                                        <?php if ($user_strain->note) { ?>
                                            <dd><?php echo $user_strain->note; ?></dd>
                                        <?php } else { ?>
                                            <dd>No note added.</dd>
                                        <?php } ?>
                                    </dl>
                                </div>
                                <div class="left_content">

                                    <div class="tab-wid no-border strain-des-sec">
                                        <header class="header">
                                            <strong class="title">Full Description:</strong>
                                        </header>
                                        <?php if (trim($user_strain->description) != '') { ?>
                                            <p><?php echo $user_strain->description; ?></p>
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
                                                    <span><?= $user_strain->min_CBD ?><em>%</em></span>
                                                    <span class="chem-to">to</span>
                                                    <span><?= $user_strain->max_CBD ?><em>%</em></span>
                                                </div>
                                                <div class="chem-row">
                                                    <span>THC</span>
                                                    <span><?= $user_strain->min_THC ?><em>%</em></span>
                                                    <span class="chem-to">to</span>
                                                    <span><?= $user_strain->max_THC ?><em>%</em></span>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-wid">
                                        <header class="header">
                                            <strong class="title">Growing &amp; Care:</strong>
                                        </header>
                                        <ul class="growing-list list-none strain-four-col">
                                            <li>
                                                <strong>Difficulty <br>Level</strong>
                                                <img src="<?php echo asset('userassets/images/' . $user_strain->growing . '.svg') ?>" alt="Image">
                                                <span class="text-capatilize"><?php echo $user_strain->growing; ?></span>
                                            </li>
                                            <li class="inline">
                                                <strong>Mature <br>Height</strong>
                                                <img src="<?php echo asset('userassets/images/tree.svg') ?>" alt="Image">
                                                <span><?php echo $user_strain->plant_height + 0; ?>"</span>
                                            </li>
                                            <li>
                                                <strong>Flowering <br>Time</strong>
                                                <h4><?php echo $user_strain->flowering_time; ?></h4>
                                                <span>days</span>
                                            </li>
                                            <li class="inline">
                                                <strong>Hardness <br>Zones</strong>
                                                <img src="<?php echo asset('userassets/images/temperature.svg') ?>" class="img-temp" alt="Image">
                                                <span class="text-white">
                                                    <b><?php echo $user_strain->min_fahren_temp + 0; ?>°F</b><br>
                                                    to<br>
                                                    <b><?php echo $user_strain->max_fahren_temp + 0; ?>°F</b><br>
                                                    <small><?php echo $user_strain->min_celsius_temp + 0; ?>&#8451; - <?php echo $user_strain->max_celsius_temp + 0; ?>&#8451;</small>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div> <!-- left side -->
                            </div>
                            <div style ="clear: both"></div>
                        </div>
                    </div>
                    <div class="right_sidebars">
                        <?php if(Auth::user()){ include 'includes/rightsidebar.php'; ?>
                        <?php include 'includes/chat-rightsidebar.php'; }?>
                    </div>
                </div>
            </article>
        </div>
        <?php include('includes/footer.php'); ?>
        <script>
            $(document).ready(function () {
                //        $("#strain_like a").click(function() {
                //            alert('ddsf');
                //        });

                $('#strain_like').click(function (e) {
                    $.ajax({
                        url: "<?php echo asset('strain_like') ?>",
                        type: "POST",
                        data: {"strain_id": '<?= $strain->id; ?>', "_token": "<?php echo csrf_token(); ?>"},
                        success: function (response) {
                            if (response.status == 'success') {
                                $('#strain_like').hide();
                                $('#strain_like_revert').show();
                                var strain_like_count = $('#strain_like_count').text();
                                $("#strain_like_count").text(parseInt(strain_like_count) + 1);
                            }
                        }
                    });
                });

                $('#strain_like_revert').click(function (e) {
                    $.ajax({
                        url: "<?php echo asset('strain_like_revert') ?>",
                        type: "POST",
                        data: {"strain_id": '<?= $strain->id; ?>', "_token": "<?php echo csrf_token(); ?>"},
                        success: function (response) {
                            if (response.status == 'success') {
                                $('#strain_like_revert').hide();
                                $('#strain_like').show();
                                var strain_like_count = $('#strain_like_count').text();
                                $("#strain_like_count").text(parseInt(strain_like_count) - 1);
                            }
                        }
                    });
                });

                $('#strain_dislike').click(function (e) {
                    $.ajax({
                        url: "<?php echo asset('strain_dislike') ?>",
                        type: "POST",
                        data: {"strain_id": '<?= $strain->id; ?>', "_token": "<?php echo csrf_token(); ?>"},
                        success: function (response) {
                            if (response.status == 'success') {
                                $('#strain_dislike').hide();
                                $('#strain_dislike_revert').show();
                                var strain_like_count = $('#strain_dislike_count').text();
                                $("#strain_dislike_count").text(parseInt(strain_like_count) + 1);
                            }
                        }
                    });
                });

                $('#strain_dislike_revert').click(function (e) {
                    $.ajax({
                        url: "<?php echo asset('strain_dislike_revert') ?>",
                        type: "POST",
                        data: {"strain_id": '<?= $strain->id; ?>', "_token": "<?php echo csrf_token(); ?>"},
                        success: function (response) {
                            if (response.status == 'success') {
                                $('#strain_dislike_revert').hide();
                                $('#strain_dislike').show();
                                var strain_like_count = $('#strain_dislike_count').text();
                                $("#strain_dislike_count").text(parseInt(strain_like_count) - 1);
                            }
                        }
                    });
                });


                $('#strain_flag').click(function (e) {
                    $.ajax({
                        url: "<?php echo asset('strain_flag') ?>",
                        type: "POST",
                        data: {"strain_id": '<?= $strain->id; ?>', "_token": "<?php echo csrf_token(); ?>"},
                        success: function (response) {
                            if (response.status == 'success') {
                                $('#strain_flag').hide();
                                $('#strain_flag_revert').show();
                            }
                        }
                    });
                });

                $('#strain_flag_revert').click(function (e) {
                    $.ajax({
                        url: "<?php echo asset('strain_flag_revert') ?>",
                        type: "POST",
                        data: {"strain_id": '<?= $strain->id; ?>', "_token": "<?php echo csrf_token(); ?>"},
                        success: function (response) {
                            if (response.status == 'success') {
                                $('#strain_flag_revert').hide();
                                $('#strain_flag').show();
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
                        data: {"strain_id": '<?= $strain->id; ?>', "strain_review_id": review_id, "_token": "<?php echo csrf_token(); ?>"},
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

            });
        </script>
    </body>
</html>