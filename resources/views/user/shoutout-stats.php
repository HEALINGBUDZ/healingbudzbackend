<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); 
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
                        <div class="clearfix shoutout-wraper">
                            <h2 class="hb_page_top_title hb_text_purple hb_text_uppercase no-margin hb_d_inline"> <i class="fa fa-bar-chart-o"></i> Shout Out Analytics </h2>
                            <?php if (count($subusers) > 0) { ?>
                                <a href="#shout-budz" class="btn-popup"><button class="insight-btn bg-purple hb_no-margin buy-btn"><img src="<?php echo asset('userassets/images/shoutout.svg') ?>" width="25px" /> &nbsp; Send A Shout Out</button></a>
                            <?php } else { ?>
                                <a href="<?= asset('budz-map-add') ?>"><button class="insight-btn bg-purple hb_no-margin buy-btn"><img src="<?php echo asset('userassets/images/shoutout.svg') ?>" width="25px" /> &nbsp; Get Premium Account</button></a>
                            <?php } ?>
                        </div>                      
                        <div class="groups add shoutout-wraper">
                            <p class="pd-top">Your Shout Out's Summary</p>
                            <table class="stats" id="stats-shout-tab">
                                <thead>
                                    <tr>
                                        <th>SHOUT DATE</th>
                                        <th>SHOUT OUT TITLE/DESC</th>
                                        <th>Views</th>
                                        <th>Shares</th>
                                        <th>Likes</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($shout_outs as $shout_out) { ?>

                                        <tr>
                                            <td data-res="SHOUT DATE"><?= date("d/m/Y", strtotime($shout_out->created_at)); ?></td>
                                            <td data-res="SHOUT OUT TITLE/DESC" class="keyword"><img class="shout_purple" src="<?php echo asset('userassets/img/shout_purple.png') ?>" width="20px" /> <?= $shout_out->message ?></td>
                                            <td data-res="Views"><?= $shout_out->views_count ?></td>
                                            <td data-res="Shares"><?= $shout_out->shares_count ?></td>
                                            <td data-res="Likes"><?= $shout_out->likes_count ?></td>

                                            <td data-res="Status"> 
                                                <div class="wid_info expire">
                                                    <?php if ($shout_out->validity_date < date('yyyy-mm-dd')) { ?>
                                                        <strong class="color red">Expired on <span><?= date("M-d-Y", strtotime($shout_out->validity_date)); ?></span></strong>
                                                    <?php } else { ?>
                                                        <strong class="color">Expire on <span><?= date("M-d-Y", strtotime($shout_out->validity_date)); ?></span></strong>
                                                    <?php } ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                          <!--  <h3><center>No More Record Founded</center></h3> -->

                        </div>
                    </div>
                    <div class="right_sidebars">
                        <?php include 'includes/rightsidebar.php'; ?>
                        <?php include 'includes/chat-rightsidebar.php'; ?>
                    </div>
                </div>
            </article>
        </div>

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
                                        <input type="radio" name="group1" id="offensive" checked>
                                        <label for="offensive">Default zip code from my profile</label>
                                        <input type="radio" name="group1" id="spam">
                                        <label for="spam">Find my current location</label>
                                        <input type="radio" name="group1" id="unrelated">
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
<!--                                        <div class="checkbox">
                                            <input type="checkbox"> Share my current location
                                        </div>-->
                                        <!--                                    <div class="sharing">
                                                                                <span>Share on:</span>
                                                                                <a href="#"><img src="<?php // echo asset('userassets/images/twitter-icon.png')     ?>" alt="Twitter Icon"></a>
                                                                                <a href="#"><img src="<?php // echo asset('userassets/images/fb-icon.png')     ?>" alt="Fb Icon"></a>
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
        <?php include('includes/footer-new.php'); ?>
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
                $(this).parents('.custom-shares').hide();
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
            function initMap() {
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
        }

        </script>
        <script>

        $(document).ready(function () {
            var id = $("#sub_user_id").val();

            $.ajax({
                url: "<?php echo asset('get_budz_specials') ?>/" + id,
                type: "get",
                success: function (result) {
                    if (result.status == 'success') {
                        $("#budz-special-select").append(result.successData);
                        $(".budz-specials").show();
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
                        $("#budz-special-select").append(result.successData);
                        $(".budz-specials").show();
                    }
                }
            });
        });
    </script>
     <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCiDgdLD46NLVGAV3AKcEZt4DKTtCeprQE&callback=initMap">
    </script>
    </body>
</html>