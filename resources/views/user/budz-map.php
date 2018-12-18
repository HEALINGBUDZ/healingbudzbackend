<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); ?>
    <body onload="initGeolocation()">
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <div class="new_container">
                        <ul class="bread-crumbs fluid list-none left">
                            <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                            <li>Budz Adz</li>
                        </ul>
                        <header class="intro-header no-bg">
                            <h1 class="custom-heading white yellow text-center"><img src="<?php echo asset('userassets/images/side-icon15.svg') ?>" alt="icon" class="small-icon no-margin"> BUDZ ADZ</h1>
                        </header>
                        <div class="maps">
                            <div class="custom-budz-btns list-none">
                                <h2>Budz Adz</h2>
                                <?php if (Auth::user()) { ?>
                                    <div class="new_btn_holder"><a href="<?php echo asset('budz-map-add'); ?>" class="add_budz_list_btn">Add Budz Listing</a></div>
                                <?php } else { ?>
                                    <div class="new_btn_holder"><a href="#loginModal" class="add_budz_list_btn new_popup_opener">Add Budz Listing</a></div>
                                <?php } ?>
                            </div>
                            <?php if (Session::has('error')) { ?>
                                <h5 class="hb_simple_error_smg"><?php echo Session::get('error'); ?></h5>
                            <?php } ?>
                            <div id="map"></div>
                        </div>
                        <form method="get" action="<?php echo asset('filter-bud-map'); ?>" id="filter_budz_map">
                            <input type="hidden" name="lat" id="current_location" value="<?php if (isset($_GET['lat'])) {
                                echo $_GET['lat'];
                            } ?>">
                            <input type="hidden" name="c_lat" id="lat" value="<?php if (isset($_GET['c_lat'])) {
                                echo $_GET['c_lat'];
                            } ?>">
                            <input type="hidden" name="c_lng" id="lng" value="<?php if (isset($_GET['c_lng'])) {
                                echo $_GET['c_lng'];
                            } ?>">
                            <div class="mil-filt">
                                <strong class="filter_heading">Filter by location:</strong>
                                <div class="mil-filt-inner">
                                    <div class="locate-btn-green">
                                        <a href="javascript:vofi(0)" onclick="initGeolocation()">Find My Current Location</a>
                                    </div>
                                    <!--                                <div class="mil-filt-slide">
                                                                        <span>Distance Range (Miles):</span>
                                                                        <div class="forms">
                                                                            <input id="rangeslider" type="range" name="radious" min="0" max="100" oninput="showVal(this.value)" onchange="showVal(this.value)" value="<?php if (isset($_GET['radious'])) {
                                echo $_GET['radious'];
                            } ?>">
                                                                            <output for="radious" onforminput="value = foo.valueAsNumber;"></output>
                                                                        </div>
                                                                    </div>-->
                                </div>
                            </div>
                            <ul class="filter-ul list-none">
                                <strong class="filter_heading">Filter by type:</strong>

                                <div class="new_form_area">
                                    <li>
                                        <img src="<?php echo asset('userassets/images/Dispensary.svg') ?>" alt="Docter">
                                        <span>Dispensary</span>
                                        <div class="filters">
                                            <input value="Dispensary" <?php
                                            if (isset($_GET['filter'])) {
                                                if (in_array('Dispensary', $_GET['filter'])) {
                                                    echo 'checked';
                                                }
                                            }
                            ?>  type="checkbox" class="js-switch" name="filter[]" onchange="filterBudzMap()">
                                        </div>
                                    </li>
                                    <li>
                                        <img src="<?php echo asset('userassets/images/Medical.svg') ?>" alt="Docter">
                                        <span>Medical</span>
                                        <div class="filters">
                                            <input id="medical" value="Medical Practitioner" type="checkbox" <?php
                                            if (isset($_GET['filter'])) {
                                                if (in_array('Medical Practitioner', $_GET['filter'])) {
                                                    echo 'checked';
                                                }
                                            }
                            ?> class="js-switch" name="filter[]" />


                                            <input class="medical" style="display: none" value="Clinic" type="checkbox" <?php
                                            if (isset($_GET['filter'])) {
                                                if (in_array('Medical Practitioner', $_GET['filter'])) {
                                                    echo 'checked';
                                                }
                                            }
                                            ?> name="filter[]"/>
                                            <input class="medical" style="display: none" value="Holistic Medical" type="checkbox" <?php
                                            if (isset($_GET['filter'])) {
                                                if (in_array('Medical Practitioner', $_GET['filter'])) {
                                                    echo 'checked';
                                                }
                                            }
                                            ?>  name="filter[]" onchange="filterBudzMap()"/>
                                        </div>
                                    </li>
                                    <li>
                                        <img src="<?php echo asset('userassets/images/Cannabites.svg') ?>" alt="Docter">
                                        <span>Cannabites</span>
                                        <div class="filters">
                                            <input value="Cannabites" type="checkbox" <?php
                                            if (isset($_GET['filter'])) {
                                                if (in_array('Cannabites', $_GET['filter'])) {
                                                    echo 'checked';
                                                }
                                            }
                                            ?> class="js-switch" name="filter[]" onchange="filterBudzMap()"/>
                                        </div>
                                    </li>
                                    <li>
                                        <img src="<?php echo asset('userassets/images/Entertainment.svg') ?>" alt="Entertainment">
                                        <span>Entertainment</span>
                                        <div class="filters">
                                            <input id="entertainment" value="Lounge" <?php
                                            if (isset($_GET['filter'])) {
                                                if (in_array('Lounge', $_GET['filter'])) {
                                                    echo 'checked';
                                                }
                                            }
                                            ?> type="checkbox" class="js-switch" name="filter[]" />
                                            <input class="entertainment" value="Lounge" <?php
                                            if (isset($_GET['filter'])) {
                                                if (in_array('Lounge', $_GET['filter'])) {
                                                    echo 'checked';
                                                }
                                            }
                                            ?> type="checkbox" name="filter[]" />
                                        </div>
                                    </li>
                                    <li>
                                        <img src="<?php echo asset('userassets/images/Events.svg') ?>" alt="Docter">
                                        <span>Events</span>
                                        <div class="filters">
                                            <input value="Events" <?php
                                            if (isset($_GET['filter'])) {
                                                if (in_array('Events', $_GET['filter'])) {
                                                    echo 'checked';
                                                }
                                            }
                                            ?> type="checkbox" class="js-switch" name="filter[]" onchange="filterBudzMap()">
                                        </div>
                                    </li>
                                    <li>
                                        <img src="<?php echo asset('userassets/images/other-icon.svg') ?>" alt="Other">
                                        <span>Other</span>
                                        <div class="filters">
                                            <input value="Other" <?php
                                            if (isset($_GET['filter'])) {
                                                if (in_array('Other', $_GET['filter'])) {
                                                    echo 'checked';
                                                }
                                            }
                            ?>  type="checkbox" class="js-switch" name="filter[]" onchange="filterBudzMap()">
                                        </div>
                                    </li>
                                </div>

                            </ul>
                        </form>
                        <!-- <div class="filter-map">
                            <div class="cus-text">
                                <span class="filter-head">Filter by Type:<span class="filter-open"><i class="fa fa-angle-down"></i></span></span>
                            </div>
                            
                        </div> -->
                        <div class="filter-bottom budz-fil">
                            <div class="listing-area">
                                <ul class="list-none" id='budz_map_listing'>
<?php foreach ($sub_users as $sub_user) { ?>
                                        <li class="subusers <?php if ($sub_user->subscriptions) { ?> filter-black <?php } ?>" data-filter="<?php
    if ($sub_user->getBizType) {
        echo $sub_user->getBizType->title;
    }
    ?>">
                                            <div class="listing-txt">
                                                <a href="<?php echo asset('get-budz?business_id=' . $sub_user->id . '&business_type_id=' . $sub_user->business_type_id); ?>" class="listing-text image-inner-anch">
                                                    <div class="img-holder hb_round_img" style="background-image: url(<?php echo getSubImage($sub_user->logo, '') ?>)">
                                                        <!--<img src="<?php //echo asset('userassets/images/' . $sub_user->getBizType->title . '.svg')   ?>" alt="Docter" class="sub-image" />-->
                                                        <img src="<?php echo getBusinessTypeIcon($sub_user->getBizType->title); ?>" alt="Docter" class="sub-image" />
                                                    </div>
                                                    <span class="name"><?php
                                                    if ($sub_user->getBizType) {
                                                        echo $sub_user->getBizType->title;
                                                    }
    ?></span>
                                                    <span class="designation"><?php echo $sub_user->title; ?></span>
                                                </a>
                                                <ul class="features">
    <?php if ($sub_user->is_organic) { ?>
                                                        <li><img src="<?php echo asset('userassets/images/icon-plant.svg') ?>" alt="Plant"> Organic</li>
    <?php } if ($sub_user->is_delivery) { ?>
                                                        <li><img src="<?php echo asset('userassets/images/icon-van.svg') ?>" alt="Van"> We Deliver</li>
    <?php } ?>
                                                </ul>
                                                <div class="listing-info">
                                                    <span class="time"><img src="<?php echo asset('userassets/images/pin-pink.png') ?>" alt="Plant"> <?php echo round($sub_user->distance,2); ?> miles away</span>
                                                </div>
                                                <div class="listing-info li-in-right">
                                                    <div class="budz_rating" data-rating="<?php if ($sub_user->ratingSum) echo $sub_user->ratingSum->total; ?>"></div>
                                                    <b><?php echo count($sub_user->review); ?></b> Reviews
                                                </div>
                                            </div>
                                        </li>
                        <?php } ?>  
                                </ul>
                                <div style="display: none" class="hb_simple_loader" id="loading"><img src="<?php echo asset('userassets/images/new_loadeer.svg') ?>" alt="Loading . . . ." class="post-loader"><span></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="right_sidebars">
        <?php if (Auth::user()) {
            include 'includes/rightsidebar.php'; ?>
            <?php include 'includes/chat-rightsidebar.php';
        } ?>
                    </div>
                </div>
            </article>
        </div>
<?php include('includes/footer-new.php'); ?>
<?php
if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];
} else {
    $filter = '';
}
?>

        <div id="learn_more_pop" class="modal fade map-black-listing two-budzmap-pop two-budzmap-pop-update" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="two-budzmap-cus-row">
                        <div class="map-green-pre">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"></button>
                              <!--  <span class="pre-icon"></span>-->
                                <h2 class="modal-title">Premium Budz Adz Listing</h2>

                                <h4>Unlock additional features with a paid subscription</h4>
                                <!--<span class="price">
                                    <sup>$</sup>99.99
                                    <span>
                                        <span class="top">99</span>
                                        <span class="bot">per mo</span>
                                    </span>
                                </span>-->
                            </div>
                            <div class="modal-body">
                                <div class="map-bl-row">
                                    <div class="cus-col">
                                        <figure>
                                            <img src="<?php echo asset('userassets/images/map-icon1.svg') ?>" alt="image" />
                                        </figure>
                                    </div>
                                    <div class="cus-col">
                                        <h3>Feature Business Icon</h3>
                                        <p>Appear at the top of the business listing search results and stand out with a special icon.</p>
                                    </div>
                                </div>
                                <div class="map-bl-row">
                                    <div class="cus-col">
                                        <figure>
                                            <img src="<?php echo asset('userassets/images/map-icon2.svg') ?>" alt="image" />
                                        </figure>
                                    </div>
                                    <div class="cus-col">
                                        <h3>Keyword Optimization Tool</h3>
                                        <p>Increase your exposure even further by optimizing your listing with active keywords throughout our community.</p>
                                    </div>
                                </div>
                                <div class="map-bl-row">
                                    <div class="cus-col">
                                        <figure>
                                            <img src="<?php echo asset('userassets/images/map-icon3.svg') ?>" alt="image" height="20" />
                                        </figure>
                                    </div>
                                    <div class="cus-col">
                                        <h3>Product/Service Menu</h3>
                                        <p>Set categories, show products &amp; prices.</p>
                                    </div>
                                </div>
                                <div class="map-bl-row">
                                    <div class="cus-col">
                                        <figure>
                                            <img src="<?php echo asset('userassets/images/map-icon4.svg') ?>" alt="image" />
                                        </figure>
                                    </div>
                                    <div class="cus-col">
                                        <h3>Business profile Image Slider</h3>
                                        <p>Show off your photos in an animated profile image slider and gallery.</p>
                                    </div>
                                </div>
                                <div class="map-bl-row">
                                    <div class="cus-col">
                                        <figure>
                                            <img src="<?php echo asset('userassets/images/map-icon5.svg') ?>" alt="image" />
                                        </figure>
                                    </div>
                                    <div class="cus-col">
                                        <h3>Special Deals</h3>
                                        <p>Stay ahead of the competition by listing your special offers and deals.</p>
                                    </div>
                                </div>
                                <div class="map-bl-row">
                                    <div class="cus-col">
                                        <figure>
                                            <img src="<?php echo asset('userassets/images/map-icon6.svg') ?>" alt="image" />
                                        </figure>
                                    </div>
                                    <div class="cus-col">
                                        <h3>Push Notifications</h3>
                                        <p>Reach potential customers instatly by sending push notifications straight to their Buzz Feed based on a 25 mile geolocation.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="btn-area">
                                    <form class="btn-like-stripe-main">

                                        <!--<label for="btn-like-stripe-check">
                                            <input  type="checkbox" id="btn-like-stripe-check"/>
                                        <span class="for-check"></span>

                                        </label>-->
                                       <!-- <a href="<?= asset('budz-map-add') ?>" class="map-bl-btn btn-like-stripe">Add Now</a>
                                    <a href="#" class="map-bl-btn btn-like-stripe" data-dismiss="modal">No Thanks</a></form>-->
    <!--                                <form action="<?php // echo asset('update-subscription')  ?>" method="POST">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                                        <script
                                            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                            data-key="pk_test_kBD5CZDk3MBZNRLeWqrfvhew"
                                            data-amount="9999"
                                            data-name="Healing Budz"
                                            data-description="Subscription For Buying Budz Adz"
                                            data-label="Buy Now"
                                            data-allow-remember-me="false"
                                            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                            data-locale="auto">
                                        </script>
                                    </form>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="showsubscription" class="modal fade map-black-listing two-budzmap-pop" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog update_modal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-content">
                    <div class="two-budzmap-cus-row">

                        <div class="map-green-pre white_bg">
                            <div class="modal-header">

                                <h2 class="modal-title">Paid Monthly</h2>

                                <span class="price">
                                    <sup>$</sup>29
                                    <span>
                                        <span class="top">95</span>
                                        <span class="bot">per mo</span>
                                    </span>
                                </span>
                            </div>
                            <div class="modal-body">
                                <div class="cus-col">   
                                </div>
                                <div class="cus-col">
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took.</p>
                                    <a href="#" class="learn_btn">LEARN MORE</a>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="btn-area">
                                    <a href="<?= asset('budz-map-add'); ?>" class="map-bl-btn">Get Started</a>
<!--                                    <form action="<?php echo asset('subscribe-user') ?>" method="POST">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                        <input type="hidden" name="plan_type" value="1">
                                        <script
                                            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                            data-key="<?= env('STRIPE_KEY'); ?>"
                                            data-amount="2995"
                                            data-name="Healing Budz"
                                            data-description="Subscription For Buying Budz Adz"
                                            data-label="Subscribe Now"
                                            data-allow-remember-me="false"
                                            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                            data-locale="auto">
                                        </script>
                                    </form>-->

                                </div>
                            </div>
                        </div>
                        <div class="model-title">
                            <h2>Premium Budz Adz Listing</h2>
                            <p class="unlock_subs">Unlock additional features with a paid subscription</p>
                        </div>

                        <div class="map-green-pre">
                            <div class="modal-header">
                                <span class="pre-icon"></span>
                                <h2 class="modal-title">Paid Every 3 Months</h2>
                                <span class="price">
                                    <sup>$</sup>19
                                    <span>
                                        <span class="top">95</span>
                                        <span class="bot">per mo</span>
                                    </span>
                                </span>
                            </div>
                            <div class="modal-body">
                                <div class="cus-col">   </div>
                                <div class="cus-col">
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took.</p>
                                    <a href="#" class="learn_btn">LEARN MORE</a>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="btn-area green_btn">
                                    <a href="<?= asset('budz-map-add'); ?>" class="map-bl-btn">Get Started</a>
<!--                                    <form action="<?php echo asset('subscribe-user') ?>" method="POST">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                        <input type="hidden" name="plan_type" value="2">
                                        <script
                                            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                            data-key="<?= env('STRIPE_KEY'); ?>"
                                            data-amount="1995"
                                            data-name="Healing Budz"
                                            data-description="Subscription For Buying Budz Adz"
                                            data-label="Subscribe Now"
                                            data-allow-remember-me="false"
                                            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                            data-locale="auto">
                                        </script>
                                    </form>-->
                                </div>
                            </div>
                        </div>
                        <div class="map-green-pre white_bg">
                            <div class="modal-header">
                              <!--  <span class="pre-icon"></span>-->
                                <h2 class="modal-title">Paid Annually</h2>
                                <span class="price">
                                    <sup>$</sup>15
                                    <span>
                                        <span class="top">95</span>
                                        <span class="bot">per mo</span>
                                    </span>
                                </span>
                            </div>
                            <div class="modal-body">
                                <div class="cus-col">  </div>
                                <div class="cus-col">
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took.</p>
                                    <a href="#" class="learn_btn">LEARN MORE</a>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="btn-area">
                                    <a href="<?= asset('budz-map-add'); ?>" class="map-bl-btn">Get Started</a>
<!--                                    <form action="<?php echo asset('subscribe-user') ?>" method="POST">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                        <input type="hidden" name="plan_type" value="3">
                                        <script
                                            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                            data-key="<?= env('STRIPE_KEY'); ?>"
                                            data-amount="1595"
                                            data-name="Healing Budz"
                                            data-description="Subscription For Buying Budz Adz"
                                            data-label="Subscribe Now"
                                            data-allow-remember-me="false"
                                            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                            data-locale="auto">
                                        </script>
                                    </form>-->
                                </div>
                            </div>
                        </div>

                    </div>
                    <a href="#" class="dont_show" id="no_thanks">No thanks dont show me again</a>
                </div>

            </div>
        </div>
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
                document.getElementById('lng').value = position.coords.longitude;
                document.getElementById('lat').value = position.coords.latitude;
                $('#filter_budz_map').submit();
            }

            function fail()
            {
//                $('#filter_budz_map').submit();
            }

        </script> 
    </body>
    <script>
        $(".learn_btn").on('click', function () {
            $('#learn_more_pop').modal('show');
        });

    </script>
    <script>
//            $(".dont_show").on('click' ,function () {
//                $('#showsubscription').modal('hide');
//                $.ajax({
//                    type: "GET",
//                    url: "<?php echo asset('update_pop_up'); ?>",
//                    data: {
//                        "show_budz_popup": 0
//                    },
//                    success: function (data) {
//                    }
//                });
//            }); 

    </script>




    <script>

        $('.budz_class').click(function () {
            $(this).parents('.custom-shares').hide();

        });

        function filterBudzMap() {
            $('#filter_budz_map').submit();
        }

        $("#medical").change(function () {
            if (this.checked) {
                $('.medical').attr('checked', true);
            } else {
                $('.medical').attr('checked', false);
            }
            $('#filter_budz_map').submit();
        });
        $("#entertainment").change(function () {
            if (this.checked) {
                $('.entertainment').attr('checked', true);
            } else {
                $('.entertainment').attr('checked', false);
            }
            $('#filter_budz_map').submit();
        });

        $("#btn-like-stripe-check").click(function () {

            if (this.checked) {
                show_budz_popup = 0;
            } else {
                show_budz_popup = 1;
            }
            $.ajax({
                type: "GET",
                url: "<?php echo asset('update_pop_up'); ?>",
                data: {
                    "show_budz_popup": show_budz_popup
                },
                success: function (data) {
                }
            });
        });
        $('#inactivelist').change(function () {
            alert('changed');
        });
        function checkboxchanged() {
            alert('asdsa')
        }
    </script>
    <script>
        var win = $(window);
        var count = 1;
        var ajaxcall = 1;
        var filter = new Array();
<?php
if ($filter != '') {
    foreach ($filter as $key => $val) {
        ?>
                filter.push('<?php echo $val; ?>');
        <?php
    }
}
?>
        var rangeslider = $('#rangeslider').val();
        var current_location = $('#current_location').val();
        var c_lat = $('#lat').val();
        var c_lng = $('#lng').val();
//          $('#current_location').val('1');
        win.on('scroll', function () {
            var docheight = parseInt($(document).height());
            var winheight = parseInt(win.height());
            var differnce = (docheight - winheight) - win.scrollTop();
            if (differnce < 100) {
                if (ajaxcall === 1) {
                    $('#loading').show();
                    ajaxcall = 0;
                    $.ajax({
                        url: "<?php echo asset('get-budz-map-loader') ?>",
                        type: "GET",
                        data: {
                            "count": count,
                            "filter": filter,
                            "radious": rangeslider,
                            "lat": current_location,
                            "c_lat": c_lat,
                            "c_lng": c_lng
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
                                ajaxcall = 0;
                                $('#loading').hide();
                                noposts = '<li><div class="loader hb_not_more_posts_lbl" id="nomoreposts">No more budz adz to show</div></li>';
                                $('#budz_map_listing').append(noposts);
                            }
                        }
                    });
                }

            }
        });
    </script>
    <script>

        //================ START Range Slider =============
        function modifyOffset() {

            var el, newPoint, newPlace, offset, siblings, k;
            width = this.offsetWidth;
            newPoint = (this.value - this.getAttribute("min")) / (this.getAttribute("max") - this.getAttribute("min"));

//        AMW

            var rangeslider = document.getElementById('rangeslider');

            var form = $('.forms').innerWidth();
            var rangevalue = parseInt((this.value));
            form = ((form - 20) / 100);
            form = form * rangevalue;


            siblings = this.parentNode.childNodes;
            for (var i = 0; i < siblings.length; i++) {
                sibling = siblings[i];
                if (sibling.id == this.id) {
                    k = true;
                }
                if ((k == true) && (sibling.nodeName == "OUTPUT")) {
                    outputTag = sibling;
                }
            }

            outputTag.style.left = form + "px";
            outputTag.innerHTML = this.value;

//	offset   = -1;
//	if (newPoint < 0) { newPlace = 0;  }
//	else if (newPoint > 1) { newPlace = width; }
//	else { newPlace = width * newPoint + offset; offset -= newPoint;}
//	siblings = this.parentNode.childNodes;
//	for (var i = 0; i < siblings.length; i++) {
//         
//		sibling = siblings[i];
//		if (sibling.id == this.id) { k = true; }
//		if ((k == true) && (sibling.nodeName == "OUTPUT")) {
//                    
//			outputTag = sibling;
//		}
//	}
//	outputTag.style.left       = newPlace + "px";
//	outputTag.style.marginLeft = offset + "%";
//	outputTag.innerHTML        = this.value;
        }

        function modifyInputs() {

            var inputs = document.getElementsByTagName("input");
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].getAttribute("type") == "range") {
                    inputs[i].onchange = modifyOffset;

                    // the following taken from http://stackoverflow.com/questions/2856513/trigger-onchange-event-manually
                    if ("fireEvent" in inputs[i]) {

                        inputs[i].fireEvent("onchange");
                    } else {
                        var evt = document.createEvent("HTMLEvents");
                        evt.initEvent("change", false, true);
                        inputs[i].dispatchEvent(evt);
                    }
                }
            }
        }

        modifyInputs();

        var locations = <?php echo json_encode($sub_users); ?>;
       
        var map;
        var markers = [];
        var infos = []

        function initMap() {

            map = new google.maps.Map(document.getElementById('map'), {
            zoom: 2,
//                
<?php if ($current_user) { ?>
                center: new google.maps.LatLng('<?php $current_user->lat; ?>', '<?php $current_user->lng; ?>'),
<?php } else { ?>
                center: new google.maps.LatLng( - 33.92, 151.25),
<?php } ?>
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var marker, i;
        for (i = 0; i < locations.length; i++) {
            var image = '<img src="' + '<?php echo asset('userassets/images/folded-newspaper.svg') ?>' + '" alt="Image" class="img-responsive small-img">';
            if (locations[i].logo !== null && locations[i].logo !== '') {
                image = '<img src="' + '<?php echo asset('public/images') ?>' + locations[i].logo + '" alt="Image" class="img-responsive small-img">';
            }
            var rating = 0;
            if (locations[i].rating_sum !== null) {
                rating = locations[i].rating_sum.total;
            }

            //info window style
            var pin_info = image +
                    '<strong>' + locations[i].title + '</strong><br>' +
                    '<span>' + locations[i].get_biz_type.title + '</span><br>' +
                    '<i class="fa fa-star"></i>' + rating + '<br>' +
                    locations[i].review.length + ' Reviews<br>' +
                    '<a href="' + '<?php echo asset('get-budz/') ?>?business_id=' + locations[i].id + '&business_type_id=' + locations[i].business_type_id + '">Show Detail</a>';

            //add info window
            var infowindow = new google.maps.InfoWindow({
                content: pin_info
            });

            infos.push(infowindow);//push to array

            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i].lat, locations[i].lng),
                map: map,
                title: locations[i].title,
                icon: '<?php echo asset('userassets/images') ?>' + '/' + locations[i].get_biz_type.title.replace("/", "") + '-pin.png', // null = default icon
                animation: google.maps.Animation.DROP
            });
//                marker.addListener('click', function() {
//                    infos.close(map, marker);
//                });

            markers.push(marker);
            var addListener = function (i) {
                google.maps.event.addListener(markers[i], 'click', function () {
                    infos[i].open(map, markers[i]);
//                        if(!marker.open){
//                            infos[i].open(map,markers[i]);
//                            marker.open = true;
//                        }
//                        else{
//                            infos[i].close();
//                            marker.open = false;
//                        }
                    google.maps.event.addListener(map, 'click', function () {
                        infos[i].close();
                        marker.open = false;
                    });
                });
            };
            addListener(i);
            }
        }
        function addMarkerInfo(location) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(location.hotspot_lat, location.hotspot_long),
                map: map
            });
            markers.push(marker);
        }
        function deleteMarkers() {
            clearMarkers();
            markers = [];
        }
        function clearMarkers() {
            setMapOnAll(null);
        }
        function setMapOnAll(map) {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }
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
                }
            });
        });
//        $("#rangeslider").on("input change", function() { alert('ssa') });
        function showVal() {
            $('#filter_budz_map').submit();
        }
//        function mylocation(){
//            $('#current_location').val('1');
//             $('#filter_budz_map').submit();
//        }

    </script>


    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCiDgdLD46NLVGAV3AKcEZt4DKTtCeprQE&sensor=false&callback=initMap">
    </script>
</html>