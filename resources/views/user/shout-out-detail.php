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
                        <ul class="bread-crumbs list-none">
                            <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                            <li>Shout Outs</li>
                        </ul>
                        <div class="profile-area">
                            <div class="activity-area">
                                <div class="listing-area">
                                    <h3 class="shout-heading">


                                    </h3>
                                    <?php if (Session::has('success')) { ?>
                                        <h5 class="alert alert-success"><?php echo Session::get('success'); ?></h5>
                                    <?php } ?>
                                    <?php if (Session::has('error')) { ?>
                                        <h5 class="alert alert-danger"><?php echo Session::get('error'); ?></h5>
                                    <?php } ?>
                                    <ul class="shout-list list-none">
                                        <?php
                                        $allshoutout = [];
                                        foreach ($shoutouts as $shoutout) {
                                            ?>
                                            <li>
                                                <div class="shout-btns">
                                                    <div class="imgs">
                                                        <?php if ($shoutout->lat) { ?>
                                                            <img src="<?php echo asset('userassets/images/location-icon.png') ?>" alt="Location">
                                                        <?php } if ($shoutout->image) { ?>
                                                            <img src="<?php echo asset('userassets/images/shout-photo.svg') ?>" alt="Image">
                                                        <?php } if ($shoutout->validity_date < date('Y-m-d')) { ?>
                                                            <em class="notice">Expired</em>
                                                        <?php } else { ?>
                                                            <em>Valid until: <?= date('m.d.Y', strtotime($shoutout->validity_date)) ?></em>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="shout-txt">
                                                    <a href="#shout-recieved<?= $shoutout->id ?>" class="btn-popup shout-out-view" id="<?php echo $shoutout->id; ?>">
                                                        <div class="icon"><img src="<?php echo asset('userassets/images/speaker-icon1.png') ?>" alt="Speaker"></div>
                                                        <div class="txt">
                                                            <span>Shout Out received from <?= $shoutout->getSubUser->title; ?>.</span>
                                                            <em><?= timeago($shoutout->created_at); ?></em>
                                                        </div>
                                                    </a>
                                                    <?php
                                                    echo Share::page(asset('get-shoutout/' . $shoutout->id), $shoutout->getSubUser->title, ['class' => 'shout_out_class_listing', 'id' => $shoutout->id])
                                                            ->facebook($shoutout->getSubUser->title)
                                                            ->twitter($shoutout->getSubUser->title)
                                                            ->googlePlus($shoutout->getSubUser->title);
                                                    ?>
                                                </div>
                                            </li>
                                            <?php /*   <div id="shout-recieved<?= $shoutout->id ?>" class="popup pink"> */ ?>
                                            <div id="shout-recieved<?= $shoutout->id ?>" class="popup inp-pop sho-pop">
                                                <div class="popup-holder">
                                                    <div class="popup-area">
                                                        <div class="text">
                                                            <header class="header low-pad">
                                                                <h2>Shout Out received from <?= $shoutout->getSubUser->title; ?></h2>
                                                            </header>
                                                            <div action="" class="reporting-form add no-border">
                                                                <div class="form-fields">

                                                                    <div class="user-img"><img src="<?php echo getSubImage($shoutout->getSubUser->logo, '') ?>" alt="image"></div>

                                                                    <em class="time-passed"><?= timeago($shoutout->created_at); ?></em>
                                                                    <em class="valid-till"><?= date('m.d.Y', strtotime($shoutout->validity_date)) ?></em>
                                                                    <p>"<?= $shoutout->message; ?>"</p>
                                                                    <?php if ($shoutout->image) { ?>
                                                                        <div class="small-banner sht-ot-small-img">
                                                                            <figure style="background-image: url(<?php echo getShoutoutImage($shoutout->image) ?>)"></figure>
                                                                            <!--<img src="<?php // echo getShoutoutImage($shoutout->image)    ?>" alt="image" class="img-responsive">-->
                                                                        </div>
                                                                    <?php } ?>
                                                                    <div class="small-map">
                                                                        <div class="sho-map" style="height: 200px;width: 500px" id="map<?php echo $shoutout->id; ?>"></div>
                                                                        <em class="distance"><?php echo round($shoutout->distance, 2); ?> miles away</em>
                                                                    </div>
                                                                    <div class="thumbs add">
                                                                        <div class="align-left">
                                                                            <i class="fa fa-thumbs-up custom_thumb <?php
                                                                            if ($shoutout->userLike != NULL) {
                                                                                echo 'active';
                                                                            }
                                                                            ?>" aria-hidden="true" id="icon<?php echo $shoutout->id ?>" onclick="likeSoutOut(<?php echo $shoutout->id ?>)"></i>
                                                                            <span class="custom_count"><em id="like_count_shout_<?php echo $shoutout->id ?>"><?php echo $shoutout->likes->count(); ?></em><em> Likes</em></span>
                                                                        </div>
                                                                        <div class="align-right share_social">
                                                                            <span>Shared <?= $shoutout->shares->count() ?> times</span>
                                                                            <a href="#share-post<?php echo $shoutout->id ?>" class="btn-popup shout_out_popup_close"><i class="fa fa-share-alt "></i><em>Share</em></a>
                                                                            <!--<a href="#" class="share-icon no-bg"><i class="fa fa-share-alt "></i></a>-->
                                                                            <!--                                                                        <div class="custom-shares">
                                                                                                                                                        //<?php
                                                                            // echo Share::page(asset('shout-outs'), $shoutout->getSubUser->title, ['class' => 'shout_out_class','id'=>$shoutout->id])
//                                                                                    ->facebook($shoutout->getSubUser->title)
//                                                                                    ->twitter($shoutout->getSubUser->title)
//                                                                                    ->googlePlus($shoutout->getSubUser->title); 
                                                                            ?>
                                                                                                                                                    </div>-->
                                                                        </div>
                                                                    </div>
                                                                    <a href="<?php echo asset('get-budz?business_id=' . $shoutout->getSubUser->id . '&business_type_id=' . $shoutout->getSubUser->business_type_id); ?>" class="btn-primary btn-special">View Special</a>
                                                                </div>
                                                            </div>
                                                            <a href="#" class="btn-close">x</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $allshoutout[] = $shoutout;
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="right_sidebars">
                        <?php include 'includes/rightsidebar.php'; ?>
                        <?php include 'includes/chat-rightsidebar.php'; ?>
                    </div>
                </div>
            </article>
        </div>

        <?php
        if ($allshoutout) {
            $mapshout = json_encode($allshoutout);
        } else {
            $mapshout = json_encode([]);
        };
        include('includes/footer.php');
        ?>

        <?php foreach ($shoutouts as $shoutout) { ?>
            <!-- share popup -->
            <div id="share-post<?php echo $shoutout->id ?>" class="popup">
                <div class="popup-holder">
                    <div class="popup-area">
                        <div class="reporting-form">
                            <h2>Select an option</h2>
                            <div class="custom-shares">
                                <?php
                                echo Share::page(asset('get-shoutout/' . $shoutout->id), $shoutout->getSubUser->title, ['class' => 'shout_out_class', 'id' => $shoutout->id])
                                        ->facebook($shoutout->getSubUser->title)
                                        ->twitter($shoutout->getSubUser->title)
                                        ->googlePlus($shoutout->getSubUser->title);
                                ?>
                                <?php if(Auth::user()){ ?>
                            <div class="shout_out_class in_app_button" onclick="shareInapp('<?= asset('get-shoutout/' . $shoutout->id) ?>', '<?php echo trim(revertTagSpace($shoutout->getSubUser->title)); ?>', '<?= asset('userassets/images/logo-for-scrap.png') ?>')"> <span class="hb_icon_repost"></span> In App</div>
                                <?php } ?>             </div>
                            <a href="javascript:void(0)" class="btn-close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- share popup END -->
        <?php } ?>


    </body>
    <script>

        $('.shout_out_class').click(function () {
            $('.popup').hide();
            var shout_out_id = this.id;
            $.ajax({
                url: "<?php echo asset('save_shoutout_share') ?>",
                type: "GET",
                data: {
                    "shout_out_id": shout_out_id
                },
                success: function (data) {
                }
            });

        });


        $('.shout-out-view').click(function () {
            var shout_out_id = this.id;
            $.ajax({
                url: "<?php echo asset('save_shoutout_view') ?>",
                type: "GET",
                data: {
                    "shout_out_id": shout_out_id
                },
                success: function (data) {
                }
            });

        });

        $(document).ready(function () {
            var textarea = $("#my_textarea");
            textarea.keyup(function (event) {
                var numbOfchars = textarea.val();
                var len = numbOfchars.length;
                $(".chars-counter").text(len);
            });
            textarea.keypress(function (e) {
                var tval = textarea.val(),
                        tlength = tval.length,
                        set = 300,
                        remain = parseInt(set - tlength);
                if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
                    textarea.val((tval).substring(0, tlength - 1));
                }
            });
        });

        function initMap() {
            var shoutouts = <?php echo $mapshout; ?>;
            $.each(shoutouts, function (i, item) {
                var myLatLng = {lat: parseFloat(item.lat), lng: parseFloat(item.lng)};
                var map = new google.maps.Map(document.getElementById('map' + item.id), {
                    zoom: 5,
                    center: myLatLng
                });

                var marker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                    title: ''
                });
            });
        }

        function fail()
        {
            // Could not obtain location
        }

        function likeSoutOut(shoutOutId) {
            $.ajax({
                url: "<?php echo asset('like-shoutout') ?>",
                type: "POST",
                data: {"shout_out_id": shoutOutId, "_token": "<?php echo csrf_token(); ?>"},
                success: function (response) {
                    if (response.successMessage == 'liked') {
//                        alert(response.successMessage);
                        var like_count = (parseInt($('#like_count_shout_' + shoutOutId).text())) + 1;
                        $('#like_count_shout_' + shoutOutId).text(like_count);
                        $('#icon' + shoutOutId).addClass("active");
                    } else {
//                        alert(response.successMessage);
                        var like_count = (parseInt($('#like_count_shout_' + shoutOutId).text())) - 1;
                        $('#like_count_shout_' + shoutOutId).text(like_count);
                        $('#icon' + shoutOutId).removeClass("active");
                    }
                }
            });
        }
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCiDgdLD46NLVGAV3AKcEZt4DKTtCeprQE&callback=initMap">
    </script>
</html>