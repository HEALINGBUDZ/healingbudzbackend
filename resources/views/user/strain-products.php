<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top.php'); ?>
    <body onload="initGeolocation()">
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <div class="new_container">
                        <div class="ask-area">
                            <?php // include('includes/strain_slider.php'); ?>
                            <?php include 'includes/strain-header.php'; ?>
                            <div class="tabbing str-tb-up">
                                <ul class="tabs list-none">
                                    <li class="first"><a href="<?php echo asset('strain-details/' . $strain->id); ?>">Strain Overview</a></li>
                                    <li class="second"><a href="<?php echo asset('user-strains-listing/' . $strain->id); ?>">Strain Details</a></li>
                                    <li class="third"><a href="<?php echo asset('strain-gallery/' . $strain->id); ?>">Gallery</a></li>
                                    <li class="active fourth"><a href="<?php echo asset('strain-product-listing/' . $strain->id); ?>">Locate This</a></li>
                                </ul>
                                <div id="tab-content">
                                    <div id="locate-bud" class="tab active">
                                        <div class="locate-bud-heading">
                                            <span class="title">Locate This</span>
                                        </div>
                                        <div class="locate-strain-bud">
                                            <div class="strain-offers">
                                                
                                                <?php if($zip_check){
                                                    if (count($products) > 0 ) { ?> 
                                                   <strong class="title">Cannabusiness Near You that Offer this Strain</strong>
                                                <p>within 15 Miles of your location</p> 
                                               <?php }else{ ?>
                                                <strong class="title">Sorry there is no strain available in this state</strong>   
                                               <?php }}else{ ?>
                                                 <strong class="title">Sorry we don't offer strains in illegal state</strong>   
                                               <?php }
?>  
                                                
                                            </div>
                                            <header class="pro-header pro-loc-adj">
                                                <!--<strong class="title center">Based on your Profile Info</strong>-->
                                                <div class="pro_text">
                       <a href="<?php echo asset('user-profile-detail/' . $current_id); ?>" style="position: relative; display:inline-block;vertical-align: middle;">
                <span class="hb_round_img hb_bg_img" style="background-image: url(<?php echo $current_photo ?>);width: 50px;height: 50px; display: inline-block;"></span>
                            <?php if ($current_special_image) { ?>
                <span class="fest-pre-img" style="background-image: url(<?php echo asset('public/images' . $current_special_image) ?>);"></span>
            <?php } ?>
            </a>
                                                    <!--<img src="<?php // echo asset('userassets/images/menLef.svg') ?>" alt="Image">-->
                                                    <div class="inline">
                                                        <span>You're in Zip Code</span>
                                                        <strong class="counts" id="zip_code"><?= $zip_code ?></strong>
                                                        <!--<span class="locate" id="location"><?php //echo $user->city   ?>, <?php //if($user->getState) { echo  $user->getState->state_code; }  ?></span>-->
                                                    </div>
                                                    <div class="locate-btn-green">
                                                        <a href="javascript:void(0)" onclick="initGeolocation()">[ Find My Current Location ]</a>
                                                    </div>
                                                </div>
                                            </header>
                                        </div>
                                        <div class="strain-offer strain-view-buds-col">
                                            <div class="offer-lists-new">
                                                    <?php if($zip_check){ if (count($products) > 0 ) { ?>
                                                        <span class="title">Bud</span>
                                                        <div class="new-produ-main">
                                                            <?php foreach ($products as $product) { ?>

                                                                <div id="share-post<?= $product->id ?>" class="popup">
                                                                    <div class="popup-holder">
                                                                        <div class="popup-area">
                                                                            <div class="reporting-form">
                                                                                <h2>Select an option</h2>
                                                                                <div class="custom-shares">
                                                                                    <?php
                                                                //                    $url_to_share = urlencode(asset("get-budz?business_id=" . $budz->id . "&business_type_id=" . $budz->business_type_id));
                                                                                     echo Share::page(asset('strain-product-listing' . $strain->id), 'Healing Budz', ['class' => 'strain_class', 'id' => $strain->id])
                                                                                            ->facebook($product->title)
                                                                                            ->twitter($product->title)
                                                                                            ->googlePlus($product->title);
                                                                                    ?>
                                                                                    <?php if(Auth::user()){ ?>
                                                                                <div class="strain_class in_app_button" onclick="shareInapp('<?= asset('strain-details/'.$strain->id) ?>', '<?php echo trim(revertTagSpace($strain->title)); ?>', '<?= asset('userassets/images/logo-for-scrap.png') ?>')"> <span class="hb_icon_repost"></span> In App</div>
                                                                                    <?php } ?>              </div>
                                                                                <a href="javascript:void(0)" class="btn-close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="new-produ-list img-holder">
                                                                    <?php if (!$product->images->isEmpty()) { ?>
                                                                        <?php
                                                                        $i = 1;
                                                                        foreach ($product->images as $productImage) {
                                                                            $path = asset(image_fix_orientation('public/images' . $productImage->image));
                                                                            ?>
                                                                            <a style="<?= $i != 1 ? 'display: none;' : '' ?>" class="new-produ-list-img" href="<?php echo $path ?>" data-fancybox="<?= $product->id ?>">
                                                                                <figure style="background-image: url('<?php echo $path ?>');"><figcaption><?php if($i ==1){ ?><i class="img-cap"><?= $product->images->count() - 1?>+</i><?php } ?></figcaption></figure>
                                                                            </a>
                                                                            <?php
                                                                            $i++;
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                    } else {
                                                                        $path = asset('userassets/images/placeholder.jpg');
                                                                        ?>
                                                                        <a class="new-produ-list-img" href="<?php echo $path ?>" data-fancybox="<?= $product->id ?>">
                                                                            <figure style="background-image: url('<?php echo $path ?>');"><figcaption></figcaption></figure>
                                                                        </a>
                                                                    <?php } ?>
                                                                    <div class="produ-inner">
                                                                        <div class="produ-inn-top">
                                                                            <h3><?php echo $product->name; ?></h3>
                                                                            <div class="produ-inn-icons">
    <!--                                                                            <a href="#" class="share-icon"><i class="fa fa-share-alt" aria-hidden="true"></i></a>-->
                                                                                <a href="#share-post<?= $product->id ?>" class="flag-icon btn-popup"><i class="fa fa-share-alt"></i></a>
                                                                                <div class="custom-shares">
                                                                                    <?php
    //                                                                                echo Share::page(asset('strain-product-listing' . $strain->id), 'Healing Budz', ['class' => 'strain_class', 'id' => $strain->id])
    //                                                                                        ->facebook('Healing Budz')
    //                                                                                        ->twitter('Healing Budz')
    //                                                                                        ->googlePlus('Healing Budz');
                                                                                    ?>
                                                                                 <div class="strain_class in_app_button" onclick="shareInapp('<?= asset('strain-details/'.$strain->id) ?>', '<?php echo trim(revertTagSpace($strain->title)); ?>', '<?= asset('userassets/images/logo-for-scrap.png') ?>')"> <span class="hb_icon_repost"></span> In App</div>
                                                                                </div>
                                                                            </div>
                                                                            <span class="produ-inn-top-top">
                                                                                <span><em class="key Hybrid">H</em> <?php echo $product->strainType->title; ?></span>
                                                                                <ul>
                                                                                    <li><?php echo $product->cbd; ?>% CBD</li>
                                                                                    <li><?php echo $product->thc; ?>% THC</li>
                                                                                </ul>
                                                                            </span>
                                                                        </div>
                                                                        <div class="produ-inn-bot">
                                                                            <ul>
                                                                                <?php foreach ($product->pricing as $pricing) { ?>


                                                                                    <li>
                                                                                        <?php if ($pricing->weight) { ?>
                                                                                            <span class="pr-top-bg"><?= $pricing->weight ?> oz</span>
                                                                                        <?php } else { ?>
                                                                                            <span class="pr-top-bg" >0</span>
                                                                                        <?php } ?>
                                                                                        <?php
                                                                                        if ($pricing->price) {
                                                                                            $price = explode('.', $pricing->price);
                                                                                            if (count($price) > 1) {
                                                                                                ?>
                                                                                                <span class="pr-bot-bg">
                                                                                                    <sup>$</sup>
                                                                                                    <b><?= $price[0] ?></b>
                                                                                                    <sup><?= $price[1] ?></sup>
                                                                                                </span>
                                                                                            <?php } else { ?>
                                                                                                <span class="pr-bot-bg">
                                                                                                    <sup>$</sup>
                                                                                                    <b><?= $price[0] ?></b>
                                                                                                    <sup>00</sup>
                                                                                                </span>
                                                                                                <?php
                                                                                            }
                                                                                        } else {
                                                                                            ?>
                                                                                            <span class="pr-bot-bg">
                                                                                                <sup>$</sup>
                                                                                                <b>00</b>
                                                                                                <sup>00</sup>
                                                                                            </span>
                                                                                        <?php } ?>
                                                                                    </li>
                                                                                <?php } ?>
                                                                            </ul>
                                                                            <div class="pr-str-img-des">
                                                                                <span class="small-pin-yellow">
                                                                                    <img src="<?php echo asset('userassets/images/pin-yellow.png') ?>" alt="Image" />
                                                                                </span>
                                                                                <em><?= number_format((float) $product->distance, 1, '.', ''); ?> mi</em>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    <?php } else { ?>
                                                        <!--<div id="">No products found</div>-->
                                                    <?php }}else{ ?>
<!--                                                        <div id="">  </div>-->
                                                    <?php } ?>

                                                <div class="ad-placement light-font">Ad Placement</div>
                                            </div>
                                            <form id="current_data" style="display: none" method="get" action="<?= asset('strain-product-listing-current/' . $strain->id) ?>">
                                                <input type="hidden" name="lat" value="" id="current_lat">
                                                <input type="hidden" name="lng" value="" id="current_lng">
                                                <input type="hidden" name="zip" value="" id="current_zip_code">
                                            </form>
                                        </div>
                                    </div>
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
        <?php include('includes/footer.php'); ?>
        <script type="text/javascript">
            function initGeolocation()
            {
                if (navigator.geolocation)
                {
                   // Call getCurrentPosition with success and failure callbacks
                    navigator.geolocation.getCurrentPosition(success, fail);
                } else
                {
                    alert("Sorry, your browser does not support geolocation services.");
                }
            }

            function success(position)
            {
                $('#current_location').val('1');
                document.getElementById('current_lat').value = position.coords.longitude;
                document.getElementById('current_lng').value = position.coords.latitude;
//                var city = data.city;
//                    var region_code = data.region_code;
//                    var zip_code = data.zip;
//                    $('#current_zip_code').val(zip_code);
                    $('#current_lat').val(position.coords.longitude);
                    $('#current_lng').val(position.coords.latitude);
//                    $('#zip_code').html(zip_code);
//                    $('#location').html(city + ', ' + region_code);
                    $('#current_data').submit();
//                $('#filter_budz_map').submit();
            }

            function fail()
            {
//                $('#filter_budz_map').submit();
            }

        </script> 
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
            
            function getLocation() {
                var ip = '<?= \Request::ip() ?>';
                var access_key = '<?= env('IP_STACK_KEY') ?>';
//            'http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')
                $.getJSON("https://api.ipstack.com/" + ip + '?access_key=' + access_key, function (data) {
                    var city = data.city;
                    var region_code = data.region_code;
                    var zip_code = data.zip;
                    $('#current_zip_code').val(zip_code);
                    $('#current_lat').val(data.latitude);
                    $('#current_lng').val(data.longitude);
                    $('#zip_code').html(zip_code);
                    $('#location').html(city + ', ' + region_code);
                    $('#current_data').submit();
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
                            data: {"strain_id": '<?= $strain->id; ?>', "_token": "<?php echo csrf_token(); ?>"},
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
                            data: {"strain_id": '<?= $strain->id; ?>', "_token": "<?php echo csrf_token(); ?>"},
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
                            data: {"strain_id": '<?= $strain->id; ?>', "_token": "<?php echo csrf_token(); ?>"},
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
                            data: {"strain_id": '<?= $strain->id; ?>', "_token": "<?php echo csrf_token(); ?>"},
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