<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top-new.php'); ?>
    <body>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php // include('includes/header-maps-info.php'); ?>
                <?php include('includes/header.php'); ?>
                <div class="head-top">
                    <div class="head-map-info">
                        <ul class="list-none">
<!--                            <li class="li-icon"><a href="#"><i class="fa fa-angle-left"></i></a></li>
                            <li class="li-icon"><a href="#"><i class="fa fa-home"></i></a></li>-->
                        </ul>
                        <ul class="btns list-none">

                            <li onclick="saveBudzMap('<?php echo $budz->id; ?>')" id="savebudzmap<?php echo $budz->id; ?>" <?php if ($budz->get_user_save_count) { ?> style="display: none" <?php } ?> class="li-icon li-heart"><a href="#" data-toggle="modal" data-target="#mapModal1"><i class="fa fa-heart-o"></i></a>
                            </li>
                            <li onclick="unSaveBudzMap('<?php echo $budz->id; ?>')" id="unsavebudzmap<?php echo $budz->id; ?>" <?php if (!$budz->get_user_save_count) { ?> style="display: none" <?php } ?>  class="li-icon li-heart"><a href="#"><i class="fa fa-heart"></i></a>
                            </li>
                            <li style="position: relative" class="li-icon "><a href="#" class="share-icon"><i class="fa fa-share-alt "></i></a>
                                <div class="custom-shares">
                                    <?php
                                    echo Share::page(asset('get-budz/' . $budz->id), $budz->title)
                                            ->facebook($budz->description)
                                            ->twitter($budz->description)
                                            ->googlePlus($budz->description);
                                    ;
                                    ?>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="bud-map-info-top" style="background-image: url('<?php echo asset('userassets/images/img5.png') ?>');">
                    <figure class="map-info-logo">
                        <img src="<?php echo getSubImage($budz->logo, '') ?>" alt="logo">
                        <figcaption><?php echo $budz->title; ?></figcaption>
                    </figure>
                    <article>
                        <div class="art-top">
                            <div class="rating-stars"></div>
                            <a href="#" class="review-link"><b><?php echo count($budz->review); ?></b> Reviews</a>
                        </div>
                        <div class="art-bot">
                            <div class="tab-cell">
                                <figure>
                                    <a href="#"><img src="<?php echo asset('userassets/images/bg-edit.svg') ?>" alt="icon"></a>
                                </figure>
                            </div>
                            <?php if ($budz->is_organic) { ?>
                                <div class="tab-cell">
                                    <figure>
                                        <figcaption>Organic</figcaption>
                                        <img src="<?php echo asset('userassets/images/icon-plant.svg') ?>" alt="icon">
                                    </figure>
                                </div>
                            <?php } if ($budz->is_delivery) { ?>
                                <div class="tab-cell">
                                    <figure>
                                        <figcaption>We Deliver</figcaption>
                                        <img src="<?php echo asset('userassets/images/icon-van.svg') ?>" alt="icon">
                                    </figure>
                                </div>
                            <?php } ?>
                            <div class="tab-cell">
                                <figure>
                                    <a href="<?php echo asset('budz-gallary/' . $id); ?>"><img src="<?php echo asset('userassets/images/shout-photo.svg') ?>" alt="icon"></a>
                                </figure>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="bud-map-info-bot">
                    <div class="map-cus-tabs">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#business" class="bg-icon">Event Details</a></li>
                            <li><a data-toggle="tab" href="#product" class="bg-icon">Prices/Tickets</a></li>
                            <li><a data-toggle="tab" href="#special" class="bg-icon">Specials</a></li>
                        </ul>
                        <div class="tab-content">
                            <?php include 'includes/budz-event-info.php'; ?>
                            <?php include 'includes/budz-price-info.php'; ?>
                            <?php include 'includes/budz-special.php'; ?>

                        </div>
                    </div>
                </div>
            </article>
        </div>

        <div id="mapModal1" class="modal fade map-small-mod" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Budz Adz Listing Saved</h2>
                    </div>
                    <div class="modal-body">
                        <p><img src="<?php echo asset('userassets/images/bg-success.svg') ?>" alt="icon">Business listings are saved in the app menu under My Saves</p>
                        <div class="check">
                            <input type="checkbox" id="checks">
                            <label for="checks">Got it! Do not show again for Business I like</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="mapModal2" class="modal fade map-black-listing" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <figure>
                            <img src="<?php echo asset('userassets/images/news.svg') ?>" alt="image" />
                        </figure>
                    </div>
                    <div class="modal-body">
                        <h2 class="modal-title">Budz Adz Listing Saved</h2>
                        <p>Your free subscription includes:</p>
                        <ul>
                            <li>Business/Event Name & Short Description</li>
                            <li>1 Business Cover Photo & Logo</li>
                            <li>Location, Contact Info & Hours of Operation</li>
                            <li>User Reviews</li>
                        </ul>
                        <div class="btn-area">
                            <a href="#" class="map-bl-btn">Continue with a free listing</a>
                        </div>
                        <hr>
                        <h2>Premium Budz Adz Listing</h2>
                        <p>Unlock additional features with a paid subscription</p>
                        <div class="btn-area">
                            <a href="#" class="map-bl-btn">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="mapModal3" class="modal fade map-black-listing map-black-pre" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <span class="pre-icon"></span>
                        <h2 class="modal-title">Subscribe Today!</h2>
                        <span class="price">
                            <sup>$</sup>49
                            <span>
                                <span class="top">99</span>
                                <span class="bot">per mo</span>
                            </span>
                        </span>
                        <h4>Unlock these additional features:</h4>
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
                                <h3>Feature Business Icon</h3>
                                <p>Appear at the top of the business listing search results and stand out with a special icon.</p>
                            </div>
                        </div>
                        <div class="map-bl-row">
                            <div class="cus-col">
                                <figure>
                                    <img src="<?php echo asset('userassets/images/map-icon3.svg') ?>" alt="image" />
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
                                    <img src="<?php echo asset('userassets/images/map-icon4.svg') ?>" alt="image" />
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
                                    <img src="<?php echo asset('userassets/images/map-icon5.svg') ?>" alt="image" />
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
                                    <img src="<?php echo asset('userassets/images/map-icon6.svg') ?>" alt="image" />
                                </figure>
                            </div>
                            <div class="cus-col">
                                <h3>Feature Business Icon</h3>
                                <p>Appear at the top of the business listing search results and stand out with a special icon.</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-area">
                            <a href="#" class="map-bl-btn">Subscribe Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('includes/footer-new.php'); ?>
</body>
<script>
    function focus_textarea() {
        $('#addcoment').focus();
    }
    $(document).ready(function () {
        var textarea = $("#addcoment");
        textarea.keyup(function (event) {
            var numbOfchars = textarea.val();
            var len = numbOfchars.length;
            var show = (500 - len);
            $(".chars-counter").text(show + ' Characters Remaining');
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
    });
    $("#test").change(function () {
        var fileInput = document.getElementById('test');
        var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
        $("#video").attr("src", fileUrl);
        var myVid = document.getElementById("video");
        setTimeout(function () {
            var duration = myVid.duration.toFixed(2);
            if (duration > 30) {
                alert('No No No');
                $("#video").attr("src", '');
            }
        }, 3000);
    });
</script>
</html>