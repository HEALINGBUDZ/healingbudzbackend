<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top.php'); 
    $map_lat='';
    $map_lng='';
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($current_user->zip_code)."&sensor=false&key=AIzaSyCiDgdLD46NLVGAV3AKcEZt4DKTtCeprQE";
$result_string = file_get_contents($url);
    $result = json_decode($result_string, true);
    if(!empty($result['results'])){
        $map_lat = $result['results'][0]['geometry']['location']['lat'];
        $map_lng = $result['results'][0]['geometry']['location']['lng'];
    }

    ?>

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
                                        <?php if (count($subusers) > 0) { ?>
                                            <a href="#shout-budz" class="btn-popup"><img src="<?php echo asset('userassets/images/shoutout.svg') ?>" alt="Speaker"><em>Send a shout out</em></a>
                                        <?php } else { ?>
                                            <a href="<?php echo asset('budz-map-add') ?>" class=""><img src="<?php echo asset('userassets/images/shoutout.svg') ?>" alt="Speaker"><em>Get Premium Account</em></a>
                                        <?php } ?>
                                    </h3>
                                    <?php if (Session::has('success')) { ?>
                                        <h5 class="hb_simple_error_smg hb_text_green" style="margin-top: 0px"> <i class="fa fa-check" style="margin-right: 3px"></i> <?php echo Session::get('success'); ?> </h5>
                                    <?php } ?>                                        
                                    <?php if (Session::has('error')) { ?>
                                        <h5 class="hb_simple_error_smg" style="margin-top: 0px"> <i class="fa fa-times" style="margin-right: 3px"></i> <?php echo Session::get('error'); ?> </h5>
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
                                                        <?php } ?>
                                                        <?php if ($shoutout->validity_date < date('Y-m-d')) { ?>
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
                                                            <span>Shout Out send from <?= $shoutout->getSubUser->title; ?>.</span>
                                                            <em><?= timeago($shoutout->created_at); ?></em>
                                                        </div>
                                                    </a>
                                                    <div class="hb_shout_out_share_btns">
                                                        <?php
                                                        echo Share::page(asset('get-shoutout/' . $shoutout->id), $shoutout->getSubUser->title, ['class' => 'shout_out_class_listing', 'id' => $shoutout->id])
                                                                ->facebook($shoutout->getSubUser->title)
                                                                ->twitter($shoutout->getSubUser->title)
                                                                ->googlePlus($shoutout->getSubUser->title);
                                                        ?>
                                                    </div>
                                                </div>

                                            </li>
                                            <?php /*   <div id="shout-recieved<?= $shoutout->id ?>" class="popup pink"> */ ?>
                                            <div id="shout-recieved<?= $shoutout->id ?>" class="popup inp-pop sho-pop">
                                                <div class="popup-holder">
                                                    <div class="popup-area">
                                                        <div class="text">
                                                            <header class="header low-pad">
                                                                <h2>Shout Out received from <?= $shoutout->title; ?></h2>
                                                            </header>
                                                            <div action="" class="reporting-form add no-border">
                                                                <div class="form-fields">
                                                                    <div class="user-img"><img src="<?php echo getSubImage($shoutout->getSubUser->logo, '') ?>" alt="image"></div>
                                                                    <em class="time-passed"><?= timeago($shoutout->created_at); ?></em>
                                                                    <em class="valid-till"><?= date('m.d.Y', strtotime($shoutout->validity_date)) ?></em>
                                                                    <p>"<?= $shoutout->message; ?>"</p>
                                                                    <?php if ($shoutout->image) { ?>
                                                                        <div class="small-banner sht-ot-small-img">
                                                                            <figure style="background-image: url(<?php echo getShoutoutImage($shoutout->image) ?>);"></figure>
                                                                            <!--<img src="<?php // echo getShoutoutImage($shoutout->image)        ?>" alt="image" class="img-responsive">-->
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
                                                                        <div class="align-right">
                                                                            <span>Shared <?= $shoutout->shares->count() ?> times</span>

                                                                            <a href="#share-post<?php echo $shoutout->id ?>" class="btn-popup shout_out_popup_close"><i class="fa fa-share-alt "></i><em>Share</em></a>
    <!--                                                                            <a href="#" class="share-icon no-bg"><i class="fa fa-share-alt "></i><em>Share</em></a>-->
                                                                            <!--                                                                            <div class="custom-shares">
                                                                            <?php
//                                                                                echo Share::page(asset('shout-outs'), $shoutout->getSubUser->title, ['class' => 'shout_out_class', 'id' => $shoutout->id])
//                                                                                        ->facebook($shoutout->getSubUser->title)
//                                                                                        ->twitter($shoutout->getSubUser->title)
//                                                                                        ->googlePlus($shoutout->getSubUser->title);
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
                                            $allshoutout[] = $shoutout->shoutout;
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

        <!--<div id="shout-budz" class="popup pink inp-pop sho-pop">-->
        <div id="shout-budz" class="popup inp-pop sho-pop">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="text">
                        <header class="header low-pad">
                            <h2>Shout Out to your Budz</h2>
                        </header>
                        <form action="<?php echo asset('add-shoutout'); ?>" method="post" enctype="multipart/form-data"class="reporting-form add no-border" id="shout-out">
                            <input type="hidden" name="lat" id="lat">
                            <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                            <input type="hidden" name="lng" id="lng">
                            <fieldset>
                                <div class="upl-row">
                                    <label for="custom-file">
                                        <img src="<?php echo asset('userassets/images/gallery-big.png') ?>" alt="Gallery Icon">
                                        <span>Upload Photo</span>
                                    </label>
                                    <div class="uploading-image">
                                        <img id="image_upload3" src="#" alt="image">
                                    </div>
                                </div>
                                <div class="form-fields">
                                    <div class="char-in">
                                        <textarea placeholder="Hey, what do you want to say?" name="message" required="" id="my_textarea" maxlength="140" class="inp-cls"></textarea>
                                        <div class="characters"><span><span class="chars-counter">0</span>/140 Characters</span></div>
                                    </div>
                                    <span class="error_span" id="message_error" style="display: none">Message is required.</span>
                                    <em><b>Link To:</b></em>
                                    <select id="sub_user_id" name="sub_user_id" class="inp-cls">

                                        <?php foreach ($subusers as $subuser) { ?>
                                            <option value="<?php echo $subuser->id; ?>"><?php echo $subuser->title; ?></option>
                                        <?php } ?>
                                    </select>
                                    <em class="budz-specials" style="display:none;"><b>Select Special (optional):</b></em>
                                    <select id="budz-special-select" name="budz_special_id" class="inp-cls budz-specials" style="display:none;">
                                    </select>
                                    <div class="radios">
                                        <!--<strong class="title">within 25 miles radius of</strong>-->
                                        <strong style="margin-bottom: 5px; display: block;">within 25 miles radius of</strong>
                                        <input type="radio" name="group1" id="offensive" checked value="zip_code">
                                        <label for="offensive">Default zip code from my profile</label>
                                        <input type="radio" name="group1" id="spam" value="current_location">
                                        <label for="spam">Find my current location</label>
                                        <input type="radio" name="group1" id="unrelated" value="">
                                    </div>
                                    <div class="dates">
                                        <input type="file" id="custom-file" name="image" accept="image/*">
                                        <!--<label for="custom-file" id="custom-selctr"><i class="fa fa-paperclip" aria-hidden="true"></i> <span>Add Image</span></label>-->
                                        <!--                                    <div class="right-input">
                                                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                                <input name="valid_data" required="" type="text" id="popup-datepicker" class="popup-date" placeholder="Valid Until" readonly="">
                                                                            </div>-->
                                        <label class="right-input" for="popup-datepicker">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                            <input name="valid_data" required="" type="text" id="popup-datepicker" class="popup-date inp-cls" placeholder="Valid Until" readonly="">
                                        </label>
                                    </div>
                                    <div class="shares-area">
                                        <div class="checkbox">
                                            <!--<input type="checkbox"> Share my current location-->
                                        </div>
                                        <!--                                    <div class="sharing">
                                                                                <span>Share on:</span>
                                                                                <a href="#"><img src="<?php // echo asset('userassets/images/twitter-icon.png')            ?>" alt="Twitter Icon"></a>
                                                                                <a href="#"><img src="<?php // echo asset('userassets/images/fb-icon.png')            ?>" alt="Fb Icon"></a>
                                                                            </div>-->

                                    </div>
                                    <!--<input type="submit" value="Send" class="s-file-label">-->
                                    <div class="" style="height: 200px;width: 100%" id="map_add"></div>
                                    <input id="submit_button" type="button" value="Send" onclick="disableButton()" class="s-file-label">
                                </div>
            
                                                                        
                                                                       
                                                            
                            </fieldset>
                        </form>
                        <a href="#" class="btn-close">x</a>
                    </div>    
                </div>
            </div>
        </div>


        <?php
        if ($shoutouts) {
            $mapshout = json_encode($shoutouts);
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
                                <?php if (Auth::user()) { ?>
                                    <div class="shout_out_class in_app_button" onclick="shareInapp('<?= asset('get-shoutout/' . $shoutout->id) ?>', '<?php echo trim(revertTagSpace($shoutout->getSubUser->title)); ?>', '<?= asset('userassets/images/logo-for-scrap.png') ?>')"> <span class="hb_icon_repost"></span> In App</div>
                                <?php } ?> </div>
                            <a href="javascript:void(0)" class="btn-close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- share popup END -->
        <?php } ?>

    </body>
    <script>

        function disableButton() {
            $('#submit_button').prop('disabled', true);
            message = $('#my_textarea').val().trim();
            if (message == '') {
                $('#message_error').show();
                $('#submit_button').prop('disabled', false);
            } else {
                $('#shout-out').submit();
            }
        }

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

            $('#popup-datepicker').datepicker().datepicker('setDate', 'today');


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
            var map_lat ='<?= $map_lat?>';
            var map_lng ='<?= $map_lng?>';
            var myLatLng = {lat: parseFloat(map_lat), lng: parseFloat(map_lng)};
                var map = new google.maps.Map(document.getElementById('map_add'), {
                    zoom: 5,
                    center: myLatLng
                });

                var marker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                    title: ''
                });
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
        $('input[type=radio][name=group1]').on('change', function () {
            if ($(this).attr('id') == 'spam') {
                if (navigator.geolocation)
                {
                    // Call getCurrentPosition with success and failure callbacks
                    navigator.geolocation.getCurrentPosition(success, fail);
                } else
                {
                    alert("Sorry, your browser does not support geolocation services.");
                }
            } else {
                var map_lat ='<?= $map_lat?>';
            var map_lng ='<?= $map_lng?>';
                var myLatLng = {lat: parseFloat(map_lat), lng: parseFloat(map_lng)};
                var map = new google.maps.Map(document.getElementById('map_add'), {
                    zoom: 5,
                    center: myLatLng
                });

                var marker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                    title: ''
                });
                $('#lat').val('');
                $('#lng').val('');
            }
        });
        function success(position)
        {
            $('#lat').val(position.coords.latitude);
            $('#lng').val(position.coords.longitude);
            var myLatLng = {lat: parseFloat(position.coords.latitude), lng: parseFloat(position.coords.longitude)};
                var map = new google.maps.Map(document.getElementById('map_add'), {
                    zoom: 5,
                    center: myLatLng
                });

                var marker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                    title: ''
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
    <script>

        $(document).ready(function () {
            var id = $("#sub_user_id").val();

            $.ajax({
                url: "<?php echo asset('get_budz_specials') ?>/" + id,
                type: "get",
                success: function (result) {
                    if (result.status == 'success') {
                        if (result.successData) {
                            $("#budz-special-select").append(result.successData);
                            $(".budz-specials").show();
                        } else {
                            $(".budz-specials").hide();
                        }
                    }
                }
            });
        });
        $(document).on("change", "#sub_user_id", function () {
            $(".budz-specials").hide();
            $("#budz-special-select").html('');
            var id = $(this).val();

            $.ajax({
                url: "<?php echo asset('get_budz_specials') ?>/" + id,
                type: "get",
                success: function (result) {
                    if (result.status == 'success') {
                        if (result.successData) {
                            $("#budz-special-select").append(result.successData);
                            $(".budz-specials").show();
                        } else {
                            $(".budz-specials").hide();
                        }
                    }
                }
            });
        });
        
    </script>
</html>