<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); ?>
    <body class="popup-bg-hide-from-all">
        <style>
        input.error ,textarea.error{
            border:solid 2px red !important;
        }

        #create_bud label.error {
            width: auto;
            display: inline;
            color:red;
            font-size: 16px;
            float:right;
        }

    </style>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <div class="padding-div">
                    <div class="new_container">
                        <?php // include('includes/header-maps-info.php'); ?>
                        <?php include('includes/header.php'); ?>
                        <input type="hidden" name="keyword" id="keyword_searched" value="<?= $keyword ?>">
                        <?php include('includes/budz-detail-header.php'); ?>
                        <!--updatesubscription-->
                        <?php if ($budz->business_type_id == 1) { //Dispensary?>
                            <div class="bud-map-info-bot">
                                <div class="tabbing">
                                    <ul class="tabs list-none">
                                        <li class="<?php if(!(isset($_GET['tab']))){ ?> active <?php } ?> business_li"><a data-toggle="tab" href="#business" class="bg-icon">Business Info</a></li>
                                        <?php if ($budz->subscriptions) { ?>
                                            <li class="products_li <?php if(isset($_GET['tab']) && $_GET['tab'] == 'product'){ ?> active  <?php } ?>"><a data-toggle="tab" href="#product" class="bg-icon">Products</a></li>
                                        <?php } elseif ($budz->user_id == $current_id) { ?>
                                            <li class="products_li <?php if(isset($_GET['tab']) && $_GET['tab'] == 'product'){ ?> active  <?php } ?>"><a data-toggle="modal" href="#showsubscription" class="bg-icon">Products</a></li>
                                        <?php } ?>
                                        <li class="images_li "><a data-toggle="tab" href="#gallery" class="bg-icon">Gallery</a></li>
                                        <?php if ($budz->subscriptions) { ?>
                                            <li class="special_li  <?php if(isset($_GET['tab']) && $_GET['tab'] == 'special'){ ?> active  <?php } ?>"><a data-toggle="tab" href="#special" class="bg-icon">Specials</a></li>
                                        <?php } elseif ($budz->user_id == $current_id) { ?>
                                            <li class="special_li  <?php if(isset($_GET['tab']) && $_GET['tab'] == 'special'){ ?> active  <?php } ?>"><a data-toggle="modal" href="#showsubscription" class="bg-icon">Specials</a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="map-cus-tabs">
                                    <div class="tab-content">
                                        <?php include 'includes/budz-business-info.php'; ?>
                                        <?php include 'includes/budz-product.php'; ?>
                                        <?php include 'includes/budz-gallery.php'; ?>
                                        <?php include 'includes/budz-special.php'; ?>
                                    </div>
                                </div>
                            </div>
                        <?php } elseif ($budz->business_type_id == 2 || $budz->business_type_id == 6 || $budz->business_type_id == 7) { //Medical?>
                            <div class="bud-map-info-bot">
                                <div class="tabbing">
                                    <ul class="tabs list-none">
                                        <li class="<?php if(!(isset($_GET['tab']))){ ?> active <?php } ?> business_li"><a data-toggle="tab" href="#medical-info" class="bg-icon">Business Info</a></li>
                                        <?php if ($budz->subscriptions) { ?>
                                            <li class="products_li <?php if(isset($_GET['tab']) && $_GET['tab'] == 'product'){ ?> active  <?php } ?>"><a data-toggle="tab" href="#medical-services" class="bg-icon">Product/Services</a></li>
                                        <?php } elseif ($budz->user_id == $current_id)  { ?>
                                            <li class="products_li <?php if(isset($_GET['tab']) && $_GET['tab'] == 'product'){ ?> active  <?php } ?>"><a data-toggle="modal" href="#showsubscription" class="bg-icon">Product/Services</a></li>
                                        <?php } ?>
                                        <li class="images_li"><a data-toggle="tab" href="#gallery" class="bg-icon">Gallery</a></li>
                                        <?php if ($budz->subscriptions) { ?>
                                            <li class="special_li  <?php if(isset($_GET['tab']) && $_GET['tab'] == 'special'){ ?> active  <?php } ?>"><a data-toggle="tab" href="#special" class="bg-icon">Specials</a></li>
                                        <?php } elseif ($budz->user_id == $current_id)  { ?>
                                            <li class="special_li  <?php if(isset($_GET['tab']) && $_GET['tab'] == 'special'){ ?> active  <?php } ?>"><a data-toggle="modal" href="#showsubscription" class="bg-icon">Specials</a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="map-cus-tabs">
                                    <div class="tab-content">
                                        <?php include 'includes/budz-medical-info.php'; ?>
                                        <?php include 'includes/budz-medical-services.php'; ?>
                                        <?php include 'includes/budz-gallery.php'; ?>
                                        <?php include 'includes/budz-special.php'; ?>
                                    </div>
                                </div>
                            </div>
                        <?php } elseif ($budz->business_type_id == 3) { //Cannabites?>
                            <div class="bud-map-info-bot">
                                <div class="tabbing">
                                    <ul class="tabs list-none">
                                        <li class="<?php if(!(isset($_GET['tab']))){ ?> active <?php } ?> business_li"><a data-toggle="tab" href="#business" class="bg-icon">Business Info</a></li>
                                        <?php if ($budz->subscriptions) { ?>
                                            <li class="menu_li <?php if(isset($_GET['tab']) && $_GET['tab'] == 'product'){ ?> active  <?php } ?>"><a data-toggle="tab" href="#product" class="bg-icon" <?php
                                                if ($current_id != $budz->user_id) {
                                                    echo "onclick='saveMenuClick($budz->id)'";
                                                }
                                                ?>>Menu</a></li>
                                            <?php } elseif ($budz->user_id == $current_id) { ?>
                                            <li class="special_li <?php if(isset($_GET['tab']) && $_GET['tab'] == 'product'){ ?> active  <?php } ?>"><a data-toggle="modal" href="#showsubscription" class="bg-icon">Menu</a></li>
                                        <?php } ?>

                                        <li class="images_li"><a data-toggle="tab" href="#gallery" class="bg-icon">Gallery</a></li>
                                        <?php if ($budz->subscriptions) { ?>
                                            <li class="special_li  <?php if(isset($_GET['tab']) && $_GET['tab'] == 'special'){ ?> active  <?php } ?>"><a data-toggle="tab" href="#special" class="bg-icon">Specials</a></li>
                                        <?php } elseif ($budz->user_id == $current_id) { ?>
                                            <li class="special_li  <?php if(isset($_GET['tab']) && $_GET['tab'] == 'special'){ ?> active  <?php } ?>"><a data-toggle="modal" href="#showsubscription" class="bg-icon">Specials</a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="map-cus-tabs">
                                    <div class="tab-content">
                                        <?php include 'includes/budz-business-info.php'; ?>
                                        <?php include 'includes/budz-menu.php'; ?>
                                        <?php include 'includes/budz-gallery.php'; ?>
                                        <?php include 'includes/budz-special.php'; ?>
                                    </div>
                                </div>
                            </div> 
                        <?php } elseif ($budz->business_type_id == 4 || $budz->business_type_id == 8) { //Entertainment  ?>
                            <div class="bud-map-info-bot">
                                <div class="tabbing">
                                    <ul class="tabs list-none">
                                        <li class="<?php if(!(isset($_GET['tab']))){ ?> active <?php } ?> business_li"><a data-toggle="tab" href="#business" class="bg-icon">Business Info</a></li>
                                        <?php if ($budz->subscriptions) { ?>
                                            <li class="products_li <?php if(isset($_GET['tab']) && $_GET['tab'] == 'product'){ ?> active  <?php } ?> "><a data-toggle="tab" href="#product" class="bg-icon">Products</a></li>
                                        <?php } elseif ($budz->user_id == $current_id) { ?>
                                            <li class="products_li <?php if(isset($_GET['tab']) && $_GET['tab'] == 'product'){ ?> active  <?php } ?> "><a data-toggle="modal" href="#showsubscription" class="bg-icon">Products</a></li>
                                        <?php } ?>
                                        <li class="images_li"><a data-toggle="tab" href="#gallery" class="bg-icon">Gallery</a></li>
                                        <?php if ($budz->subscriptions) { ?>
                                            <li class="special_li  <?php if(isset($_GET['tab']) && $_GET['tab'] == 'special'){ ?> active  <?php } ?>"><a data-toggle="tab" href="#special" class="bg-icon">Specials</a></li>
                                        <?php } elseif ($budz->user_id == $current_id) {?>
                                            <li class="special_li  <?php if(isset($_GET['tab']) && $_GET['tab'] == 'special'){ ?> active  <?php } ?>"><a data-toggle="modal" href="#showsubscription" class="bg-icon">Specials</a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="map-cus-tabs">
                                    <div class="tab-content">
                                        <?php include 'includes/budz-business-info.php'; ?>
                                        <?php include 'includes/budz-product.php'; ?>
                                        <?php include 'includes/budz-gallery.php'; ?>
                                        <?php include 'includes/budz-special.php'; ?>
                                    </div>
                                </div>
                            </div>
<?php } elseif ($budz->business_type_id == 5) { //Events  ?>
                            <div class="bud-map-info-bot">
                                <div class="tabbing">
                                    <ul class="tabs list-none">
                                        <li class="<?php if(!(isset($_GET['tab']))){ ?> active <?php } ?> business_li"><a data-toggle="tab" href="#event-info" class="bg-icon">Business Info</a></li>
                                        <?php if ($budz->subscriptions) { ?>
                                            <li class="ticket_li <?php if(isset($_GET['tab']) && $_GET['tab'] == 'product'){ ?> active  <?php } ?>"><a data-toggle="tab" href="#event-tickets" class="bg-icon" <?php
//                                                if ($current_id != $budz->user_id) {
                                                echo "onclick='saveTicketClick($budz->id)'";
//                                                }
                                                ?>>Tickets</a></li>
                                            <?php } elseif ($budz->user_id == $current_id) { ?>
                                            <li class="special_li "><a data-toggle="modal" href="#showsubscription" class="bg-icon">Tickets</a></li>
                                        <?php } ?>
                                        <li class="images_li"><a data-toggle="tab" href="#gallery" class="bg-icon">Gallery</a></li>
                                        <?php if ($budz->subscriptions) { ?>
                                            <li class="special_li"><a data-toggle="tab" href="#special" class="bg-icon">Specials</a></li>
                                        <?php } elseif ($budz->user_id == $current_id) { ?>
                                            <li class="special_li"><a data-toggle="modal" href="#showsubscription" class="bg-icon">Specials</a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="map-cus-tabs">
                                    <div class="tab-content">
                                        <?php include 'includes/budz-event-info.php'; ?>
                                        <?php include 'includes/budz-event-tickets.php'; ?>
                                        <?php include 'includes/budz-gallery.php'; ?>
                                        <?php include 'includes/budz-special.php'; ?>
                                    </div>
                                </div>
                            </div>
                    
                        <?php } elseif ($budz->business_type_id == 9) { //Events  ?>
                            <div class="bud-map-info-bot">
                                <div class="tabbing">
                                    <ul class="tabs list-none">
                                        <li class="<?php if(!(isset($_GET['tab']))){ ?> active <?php } ?> business_li"><a data-toggle="tab" href="#event-info" class="bg-icon">Business Info</a></li>
                                        
                                    </ul>
                                </div>
                                <div class="map-cus-tabs">
                                    <div class="tab-content">
                                        <?php include 'includes/budz-others-info.php'; ?>
                                    </div>
                                </div>
                            </div>
                        <?php }  elseif ($budz->business_type_id == 2 || $budz->business_type_id == 6 || $budz->business_type_id == 7) { //Medical?>
                            <div class="bud-map-info-bot">
                                <div class="tabbing">
                                    <ul class="tabs list-none">
                                        <li class="<?php if(!(isset($_GET['tab']))){ ?> active <?php } ?> business_li"><a data-toggle="tab" href="#medical-info" class="bg-icon">Business Info</a></li>
                                        <?php if ($budz->subscriptions) { ?>
                                            <li class="products_li <?php if(isset($_GET['tab']) && $_GET['tab'] == 'product'){ ?> active  <?php } ?>"><a data-toggle="tab" href="#medical-services" class="bg-icon">Product/Services</a></li>
                                        <?php } elseif ($budz->user_id == $current_id)  { ?>
                                            <li class="products_li <?php if(isset($_GET['tab']) && $_GET['tab'] == 'product'){ ?> active  <?php } ?>"><a data-toggle="modal" href="#showsubscription" class="bg-icon">Product/Services</a></li>
                                        <?php } ?>
                                        <li class="images_li"><a data-toggle="tab" href="#gallery" class="bg-icon">Gallery</a></li>
                                        <?php if ($budz->subscriptions) { ?>
                                            <li class="special_li  <?php if(isset($_GET['tab']) && $_GET['tab'] == 'special'){ ?> active  <?php } ?>"><a data-toggle="tab" href="#special" class="bg-icon">Specials</a></li>
                                        <?php } elseif ($budz->user_id == $current_id)  { ?>
                                            <li class="special_li  <?php if(isset($_GET['tab']) && $_GET['tab'] == 'special'){ ?> active  <?php } ?>"><a data-toggle="modal" href="#showsubscription" class="bg-icon">Specials</a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="map-cus-tabs">
                                    <div class="tab-content">
                                        <?php include 'includes/budz-medical-info.php'; ?>
                                        <?php include 'includes/budz-medical-services.php'; ?>
                                        <?php include 'includes/budz-gallery.php'; ?>
                                        <?php include 'includes/budz-special.php'; ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="right_sidebars">
                        <?php if(Auth::user()){ include 'includes/rightsidebar.php'; ?>
                        <?php include 'includes/chat-rightsidebar.php';} ?>
                    </div>
                </div>
            </article>
           
            <div id="save-business" class="popup light-brown">
                <div class="popup-holder">
                    <div class="popup-area">
                        <div class="text">
                            <header class="header no-padding add">
                                <strong>Budz Adz Listing Saved</strong>
                            </header>
                            <div class="padding">
                                <p><img src="<?php echo asset('userassets/images/bg-success.svg') ?>" alt="icon">Business listings are saved in the app menu under My Saves</p>
                                <div class="check">
                                    <input type="checkbox" id="check" onchange="addSaveSetting('save_budz', this)">
                                    <label for="check">Got it! Do not show again for Business I like</label>
                                </div>
                            </div>
                            <a href="#" class="btn-close purple" data-dismiss="modal">Close</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('includes/footer.php'); ?>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>
    </body>

    <script>
                                        function saveMenuClick(sub_user_id) {
//            alert(sub_user_id);
                                            $.ajax({
                                                url: "<?php echo asset('save-budz-menu-click') ?>",
                                                type: "POST",
                                                data: {"sub_user_id": sub_user_id, "_token": "<?php echo csrf_token(); ?>"},
                                                success: function (response) {
                                                }
                                            });
                                        }

                                        function saveTicketClick(sub_user_id) {
//        alert('ss')
//            alert(sub_user_id);
                                            $.ajax({
                                                url: "<?php echo asset('save-budz-ticket-click') ?>",
                                                type: "POST",
                                                data: {"sub_user_id": sub_user_id, "_token": "<?php echo csrf_token(); ?>"},
                                                success: function (response) {
                                                }
                                            });
                                        }



//        function reportBudzReview(reviewId) {
//            $.ajax({
//                url: "<?php // echo asset('report-budz-review')      ?>",
//                type: "POST",
//                data: {"review_id": reviewId, "_token": "<?php // echo csrf_token();      ?>"},
//                success: function (response) {
//                    if (response.status == 'success') {
//                        $('#budz_review' + reviewId).hide();
//                        $('#budz_review_reported' + reviewId).show();
//                    }
//                }
//            });
//        }


                                        $('#scroll-to-form').click(function () {
                                            $('html, body').animate({
                                                scrollTop: $($(this).attr('href')).offset().top
                                            }, 500);
                                        });
                                        $(document).ready(function () {
                                            $.validator.setDefaults({ignore: ":hidden:not(.chosen-select)"});
                                            $('.add-service-form').each(function () {
                                            $(this).validate({
                                                rules: {
                                                    service_name: {
                                                        required: true
                                                    },
                                                    service_charges: {
                                                        required: true,
                                                        number: true
                                                    }
                                                },
                                                messages: {
                                                    service_name: {
                                                        required: ""
                                                    },
                                                    service_charges: {
                                                        required: "",
                                                        maxlength:""

                                                    }
                                                }
                                            });});
                                            $('.add-special-form').each(function () {
                                            $(this).validate({
                                                rules: {
                                                    title: {
                                                        required: true
                                                    },
                                                    description: {
                                                        required: true
                                                    },
                                                    date: {
                                                        required: true
                                                    }
                                                },
                                                messages: {
                                                    description: {
                                                        required: ""
                                                    },
                                                    date: {
                                                        required: ""
                                                    },
                                                    title: {
                                                        required: ""

                                                    }
                                                }
                                            });});
                                            $('.product-form').each(function () {
                                               $(this).validate({
                                                rules: {
                                                    product_name: {
                                                        required: true
                                                    },
//                                                    strain_id: {
//                                                        required: true
//                                                    },
//                                                    thc: {
//                                                        required: true,
//                                                        number: true
//                                                    },
//                                                    cbd: {
//                                                        required: true
//                                                    },
                                                    weight1: {
                                                        required: true
                                                    },
                                                    price1: {
                                                        required: true,
                                                        number: true
                                                    }
                                                },
                                                messages: {
                                                    product_name: {
                                                        required: ""
                                                    },
                                                    strain_id: {
                                                        required: ""
                                                    },
//                                                    thc: {
//                                                        required: "",
//                                                        maxlength:""
//                                                    },
//                                                    cbd: {
//                                                        required: "",
//                                                        maxlength:""
//                                                        
//                                                    },
                                                    weight1: {
                                                        required: ""
                                                    },
                                                    price1: {
                                                        required: "",
                                                        maxlength:""
                                                    },
                                                    price2: {
                                                        maxlength:""
                                                    },
                                                    price3: {
                                                        maxlength:""
                                                    },
                                                    price4: {
                                                        maxlength:""
                                                    }
                                                }
                                            }); 
                                            });

                                            $('.add-ticket-form').each(function () {
                                               $(this).validate({
                                                rules: {
                                                    ticket_title: {
                                                        required: true
                                                    },
                                                    ticket_price: {
                                                        required: true,
                                                        number: true
                                                    }
                                                },
                                                messages: {
                                                    ticket_title: {
                                                        required: ""
                                                    },
                                                    ticket_price: {
                                                        required: ""

                                                    }
                                                }
                                            });});

                                            $(".budz_rating").starRating({
                                                totalStars: 5,
                                                emptyColor: '#1e1e1e',
                                                hoverColor: '#e070e0',
                                                activeColor: '#e070e0',
                                                strokeColor: "#e070e0",
                                                strokeWidth: 20,
                                                useGradient: false,
                                                readOnly: true
                                            });

                                            $(".budz_review_rating").starRating({
                                                totalStars: 5,
                                                emptyColor: '#1e1e1e',
                                                hoverColor: '#e070e0',
                                                activeColor: '#e070e0',
                                                strokeColor: "#e070e0",
                                                strokeWidth: 20,
                                                useGradient: false,
                                                disableAfterRate: false,
                                                useFullStars:true,
                                                initialRating:5,
                                                callback: function (currentRating, $el) {
                                                    $('input[type=hidden]#review_rating').val(currentRating);
                                                }
                                            });

                                            var textarea = $("#addcoment");
                                            textarea.keyup(function (event) {
                                                var numbOfchars = textarea.val();
                                                var len = numbOfchars.length;
//                var show = (500 - len);
                                                var show = len;
                                                $(".chars-counter").text(show + '/500 Characters');
                                            });
                                            textarea.keypress(function (e) {
                                                var tval = textarea.val(),
                                                        tlength = tval.length,
                                                        set = 500,
                                                        remain = parseInt(set - tlength);
                                                if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
                                                    textarea.val((tval).substring(0, tlength - 1))
                                                }
                                            });


                                            var reply_area = $("#add_reply");
                                            reply_area.keyup(function (event) {
                                                var numbOfchars = reply_area.val();
                                                var len = numbOfchars.length;
//                var show = (500 - len);
                                                var show = len;
                                                $(".reply-chars-counter").text(show + '/500 Characters ');
                                            });
                                            reply_area.keypress(function (e) {
                                                var tval = reply_area.val(),
                                                        tlength = tval.length,
                                                        set = 500,
                                                        remain = parseInt(set - tlength);
                                                if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
                                                    reply_area.val((tval).substring(0, tlength - 1));
                                                }
                                            });
                                        });
                                        $("#test").change(function () {
                                            
                                            $("#video").attr("src", '');
                                            $(".video-use").hide();
//                                            $("#budz_review_image").attr("src", '');
                                            $("#budz_review_image").attr("style", "background-image:url('')");
//                                            $(".bus-pap img").hide();
                                            $("#budz_review_image").hide();
                                            $(".bus-pap").hide();
                                            var fileInput = document.getElementById('test');
                                            var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
                                            var image_type = fileInput.files[0].type;

                                            if (image_type == "image/png" || image_type == "image/gif" || image_type == "image/jpeg" || image_type == "image/bmp" || image_type == "image/jpg") {
                                                var file = fileInput.files[0];
                                                var reader = new FileReader();
                                                reader.onloadend = function () {
                                                    getOrientation(file, function (orientation) {
                                                        //                            alert(orientation);
                                                        resetOrientation(reader.result, orientation, function (result) {

                                                            $(".bus-pap").show();
//                                                            $(".bus-pap img").attr("src", result);
                                                            $(".bus-pap #budz_review_image").attr("style", "background-image:url('"+result+"')");
//                                                            $(".bus-pap img").show();
                                                            $("#budz_review_image").show();                                                            
                                                        });
                                                    });
                                                };
                                                reader.readAsDataURL(file);

                                                $("#video").attr("src", '');
//                                                $(".bus-pap").show();
//                                                $(".bus-pap img").attr("src", fileUrl);
//                                                $(".bus-pap img").show();
                                                $(".video-use").hide();
                                                $(".bus-pap i.fa-close").show();

                                            } else if (fileInput.files[0].type == "video/mp4") {
//                                                $("#budz_review_image").attr("src", '');
                                                $("#budz_review_image").attr("style", "background-image:url('')");
                                                $(".bus-pap").show();
                                                $(".bus-pap i.fa-close").show();
                                                $(".video-use").show();
//                                                $(".bus-pap img").hide();
                                                $("#budz_review_image").hide();
                                                $("#video").attr("src", fileUrl);
                                                var myVideo = document.getElementById("video");
                                                myVideo.addEventListener("loadedmetadata", function ()
                                                {
                                                    duration = (Math.round(myVideo.duration * 100) / 100);
                                                    if (duration >= 21) {
//                                                        alert('Video is greater than 20 sec.');
                                                        $('#erroralertmessage').html('Video is greater than 20 sec.');
                                                        $('#erroralert').show();
                                                        $("#video").attr("src", '');
                                                        $('#test').val('');
                                                        $(".bus-pap").hide();
                                                    }
                                                });
                                            }
                                        });
                                        $(".bus-pap i.fa-close").click(function () {
                                            $(".bus-pap").hide();
                                            $("#video").attr("src", '');
//                                            $("#budz_review_image").attr("src", '');
                                            $("#budz_review_image").attr("style", "background-image:url('')");
                                        });
                                        $('#scroll-to-form').click(function () {
                                            $('html, body').animate({
                                                scrollTop: $($(this).attr('href')).offset().top
                                            }, 500);
                                        });

//                                        $(".update_subscription").on('click', function (event) {
//                                            event.stopPropagation();
//                                            event.stopImmediatePropagation();
//                                            alert('ads');
//                                            $('#showsubscription').modal('show');
//                                            //(... rest of your JS code)
//                                        });
//        $('#showsubscription').modal('show');
    </script>
    <!--    <div id="updatesubscription" class="modal fade map-black-listing two-budzmap-pop two-budzmap-pop-update" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="two-budzmap-cus-row">
                        <div class="map-green-pre">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"></button>
                                <span class="pre-icon"></span>
                                <h2 class="modal-title">Premium Budz Adz Listing</h2>
                                <h4>Unlock additional features with a paid subscription</h4>
                                <span class="price">
                                    <sup>$</sup>99.99
                                    <span>
                                        <span class="top">99</span>
                                        <span class="bot">per mo</span>
                                    </span>
                                </span>
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
                                    <a href="#" class="map-bl-btn">Subscribe Now</a>
                                    <form action="<?php echo asset('update-subscription') ?>" method="POST">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                        <input type="hidden" name="id" value="<?php echo $budz->id; ?>">
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
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->

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
                                <!--<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took.</p>-->
                                <a href="#" class="learn_btn">LEARN MORE</a>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-area">
                                <!--<a href="#" class="map-bl-btn">Subscribe Now</a>-->
                                <form action="<?php echo asset('update-subscription') ?>" method="POST">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="id" value="<?php echo $budz->id; ?>">
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
                                </form>
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
                                <!--<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took.</p>-->
                                <a href="#" class="learn_btn">LEARN MORE</a>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-area">
                                <!--<a href="#" class="map-bl-btn">Subscribe Now</a>-->
                                <form action="<?php echo asset('update-subscription') ?>" method="POST">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="id" value="<?php echo $budz->id; ?>">
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
                                </form>
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
                                <!--<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took.</p>-->
                                <a href="#" class="learn_btn">LEARN MORE</a>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-area">
                                <!--<a href="#" class="map-bl-btn">Subscribe Now</a>-->
                                <form action="<?php echo asset('update-subscription') ?>" method="POST">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="id" value="<?php echo $budz->id; ?>">
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
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <!--                    <a href="#" class="dont_show" id="no_thanks">No thanks dont show me again</a>-->
            </div>

        </div>
    </div>

    <div id="updatesubscription" class="modal fade map-black-listing two-budzmap-pop" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="two-budzmap-cus-row">
                    <div class="map-black-free">
                        <div class="modal-header">
                            <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
                            <!--      <button type="button" class="close" data-dismiss="modal"></button>-->
                            <!--                                <figure>
                                                            <img src="<?php // echo asset('userassets/images/news.svg')  ?>" alt="image" />
                                                        </figure>-->
                        </div>
                        <div class="modal-body">
                            <?php if (Session::has('error')) { ?>
                                <h5> <?php echo Session::get('error') ?></h5>
                            <?php } ?>
                            <p>Unlimited</p>
                            <span class="free-big-size">FREE</span>
                            <ul>
                                <li> Business/Event Name &amp; Short Description</li>
                                <li> 1 Business Cover Photo &amp; Logo</li>
                                <li> Contact Info &amp; Hours of Operation</li>
                                <li> User Reviews</li>
                            </ul>
                            <div class="btn-area">
                                <a href="#" data-dismiss="modal" class="map-bl-btn">Get Started</a>
                            </div>
                        </div>
                    </div>
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
                            <div class="cus-col">   </div>
                            <div class="cus-col">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took.</p>
                                <a href="javascript:void(0)" class="learn_btn">LEARN MORE</a>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-area">
                                <!--<a href="#" class="map-bl-btn">Subscribe Now</a>-->
                                <form action="<?php echo asset('update-subscription') ?>" method="POST">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="id" value="<?php echo $budz->id; ?>">
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
                                </form>
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
                            <div class="cus-col">    </div>
                            <div class="cus-col">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took.</p>
                                <a href="javascript:void(0)" class="learn_btn">LEARN MORE</a>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-area green_btn">
                                <!--<a href="#" class="map-bl-btn">Subscribe Now</a>-->
                                <form action="<?php echo asset('update-subscription') ?>" method="POST">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="id" value="<?php echo $budz->id; ?>">
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
                                </form>
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
                            <div class="cus-col">   </div>
                            <div class="cus-col">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took.</p>
                                <a href="javascript:void(0)" class="learn_btn">LEARN MORE</a>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-area">
                                <!--<a href="#" class="map-bl-btn">Subscribe Now</a>-->
                                <form action="<?php echo asset('update-subscription') ?>" method="POST">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="id" value="<?php echo $budz->id; ?>">
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
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Learn More Popup Start -->
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Learn More Popup Start -->
    <?php include 'includes/functions.php'; ?>

</body>
<script>
    $(".learn_btn").on('click', function () {
        $('#learn_more_pop').modal('show');
    });

</script>

</html>