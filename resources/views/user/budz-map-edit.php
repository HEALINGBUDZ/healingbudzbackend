<!DOCTYPE htm>
<html lang="en">
    
    <?php 
     if ($budz->business_type_id == 9){ ?>
    <script>
//         $(document).ready(function () {
        setTimeout(function(){
         $('.others_hide').hide();   
        },3000);
//    });
        </script>
    <?php } ?>
    <link href="<?= asset('userassets/css/jWindowCrop.css') ?>" media="screen" rel="stylesheet" type="text/css" />
        <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->

    <?php include('includes/top-new.php'); ?>
    <body>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php // include('includes/header-maps-info.php'); ?>
                <?php include('includes/header.php'); ?>
                <div class="head-top" style="display: none;">
                    <div class="head-map-info head-map-gallery">
                        <ul class="list-none">
                            <li class="li-icon li-text"></li>
                            <li class="li-icon li-add">
                                <label for="addIcon">
                                    <!--<input name="cover" type="file" id="addIcon">-->
                                    <span><i class="fa fa-upload"></i></span>
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="padding-div">
                    <div class="new_container">
                        <form method="post" action="<?php echo asset('create-bud'); ?>" id="create_bud_old" enctype="multipart/form-data" autocomplete="off">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <div id="budz-cover" class="bud-add-map bud-add-edit" style=" background-image: url('<?php echo getSubBanner($budz->banner) ?>')">
                                <div class="bud-add-edit-inner">
                                    <label for="add" style="cursor: pointer;">
                                        <figure class="map-info-logo">
                                            <div id="logosrc" class="image-adj-bud-add-edit" style="background-image:url('<?php echo getSubImage($budz->logo, '') ?>');"></div>
                                            <!--<img id="logosrc" src="<?php // echo getSubImage($budz->logo, '')  ?>" alt="logo">-->
                                            <div class="add-logo">
                                                <!--<label for="add">-->
                                                    <input name="logo" type="file" id="add" />
                                                    <span>Upload Logo</span>
                                                <!--</label>-->
                                            </div>
                                        </figure>
                                    </label>
                                    <article>
                                        <div class="art-top">
                                            <input id="budz_title_show" maxlength="30" required="" type="text" placeholder="Add Business/Event Name" name="title" value="<?= $budz->title ?>"/>
                                        </div>
                                        <div class="art-bot ">
                                            <div <?php if ($budz->business_type_id == 9){ ?> style="display: none !important" <?php } ?> class="others_hide tab-cell services">
                                                <label for="boxCheck">
                                                    <input name="organic" type="checkbox" id="boxCheck" <?php if ($budz->is_organic) { ?> checked="" <?php } ?>  onchange="setOther2(this)"/>
                                                    <span></span>
                                                </label>
                                                <figure>
                                                    <img src="<?php echo asset('userassets/images/icon-plant.svg') ?>" alt="icon">
                                                    <figcaption>Organic</figcaption>
                                                </figure>
                                            </div>
                                            <div style="display: none !important" class="others_hide tab-cell services">
                                                <label for="boxCheck1">
                                                    <input name="deliver" type="checkbox" id="boxCheck1" <?php if ($budz->is_delivery) { ?> checked="" <?php } ?>  onchange="setOther(this)"/>
                                                    <span></span>
                                                </label>
                                                <figure>
                                                    <img src="<?php echo asset('userassets/images/icon-van.svg') ?>" alt="icon">
                                                    <figcaption>We Deliver</figcaption>
                                                </figure>
                                            </div>
                                            <div <?php if ($budz->business_type_id == 9){ ?> style="display: none" <?php } ?>  class="cus-btn-pro others_hide chnge_cvr">
                                                <label for="addIcon">
                                                    <input name="cover" type="file" id="addIcon" />
                                                    <span><img src="<?php echo asset('userassets/images/gallery-black.png') ?>" alt="gallery icon"> Change Cover Photo</span>
                                                </label>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            </div>
                            <div id="cover_image_header" class="bud-add-map bud-add-edit" style="display: none">
                                <div id="capture"> <img class="" id="cover_image"  src="<?php echo getSubBanner($budz->banner_full) ?>" ></div>
                                <input type="button" value="Save" onclick="saveForm()">
                                <input type="button" value="Cancel" onclick="cancelForm()">
                                <div class="cover_loader" id="cover_loader"><img width="75" src="<?php echo asset('userassets/images/edit_post_loader.svg') ?>"></div>
                                <div class="bud-add-edit-inner">

                                    <article>

                                        <div class="art-bot">
                                            <div class="tab-cell services">

                                            </div>
                                            <div class="tab-cell services">
                                                <label for="boxCheck1">

                                            </div>
                                            <div class="cus-btn-pro">

                                            </div>
                                        </div>
                                    </article>
                                </div>
                            </div>
                        </form>
                        <div class="bud-map-info-bot bud-field-add">
                            <div class="map-cus-tabs">
                                <div class="tabbing border-top">
                                    <ul class="tabs list-none">
                                        <li class=" <?php if (!(isset($_GET['tab']))) { ?> active <?php } ?> business_li"><a data-toggle="tab" href="#business" class="bg-icon">Business Info</a></li>
                                        <?php
                                        if ($budz->stripe_id) {
                                            if ($budz->business_type_id == '5') {
                                                ?>
                                                <li class="ticket_li <?php if (isset($_GET['tab']) && $_GET['tab'] == 'product') { ?> active  <?php } ?>"><a data-toggle="tab" href="#event-tickets" class="bg-icon">Tickets</a></li>  
                                                <?php
                                            }
                                            if ($budz->business_type_id == 2 || $budz->business_type_id == 6 || $budz->business_type_id == 7) {
                                                ?>
                                                <li class="products_li"><a data-toggle="tab" href="#medical-services" class="bg-icon">Product/Services</a></li>
                                            <?php } if ($budz->business_type_id == 1 || $budz->business_type_id == 4 || $budz->business_type_id == 8) { ?>
                                                <li  class="products_li <?php if (isset($_GET['tab']) && $_GET['tab'] == 'product') { ?> active  <?php } ?> "><a data-toggle="tab" href="#product" class="bg-icon">Products</a></li>
                                            <?php } if ($budz->business_type_id == 3) { ?>
                                                <li class="products_li <?php if (isset($_GET['tab']) && $_GET['tab'] == 'product') { ?> active  <?php } ?>"><a data-toggle="tab" href="#product" class="bg-icon">Menu</a></li>
                                            <?php } if ($budz->business_type_id != 9) { ?>
                                            <li class="images_li "><a data-toggle="tab" href="#gallery" class="bg-icon">Gallery</a></li>
                                            <li class="special_li <?php if (isset($_GET['tab']) && $_GET['tab'] == 'special') { ?> active  <?php } ?>"><a data-toggle="tab" href="#special" class="bg-icon">Specials</a></li>
                                            <?php }
                                        } else {
                                            if ($budz->business_type_id == '5') {
                                                ?>
                                                <!--<li class="ticket_li"><a data-toggle="modal" href="#showsubscription" class="bg-icon">Tickets</a></li>-->  
                                                <li class="ticket_li"><a href="javascript:void(0)" onclick="openSubscriptionModal()" class="bg-icon">Tickets</a></li>  
                                                <?php
                                            }
                                            if ($budz->business_type_id == 2 || $budz->business_type_id == 6 || $budz->business_type_id == 7) {
                                                ?>
                                                <!--<li class="products_li"><a data-toggle="modal" href="#showsubscription" class="bg-icon">Product/Services</a></li>-->
                                                <li class="products_li"><a href="javascript:void(0)" onclick="openSubscriptionModal()" class="bg-icon">Product/Services</a></li>
                                            <?php } if ($budz->business_type_id == 1 || $budz->business_type_id == 4 || $budz->business_type_id == 8) { ?>
                                                <!--<li class="products_li"><a data-toggle="modal" href="#showsubscription" class="bg-icon">Products</a></li>-->
                                                <li class="products_li"><a href="javascript:void(0)" onclick="openSubscriptionModal()" class="bg-icon">Products</a></li>
                                            <?php } if ($budz->business_type_id == 3) { ?>
                                                <!--<li class="products_li"><a data-toggle="modal" href="#showsubscription" class="bg-icon">Menu</a></li>-->
                                                <li class="products_li"><a href="javascript:void(0)" onclick="openSubscriptionModal()" class="bg-icon">Menu</a></li>
                                            <?php }  if ($budz->business_type_id != 9) { ?>

                                            <li class="images_li "><a data-toggle="tab" href="#gallery" class="bg-icon">Gallery</a></li>
                                            <!--<li class="special_li"><a data-toggle="modal" href="#showsubscription" class="bg-icon">Specials</a></li>-->
                                            <li class="special_li"><a href="javascript:void(0)" onclick="openSubscriptionModal()" class="bg-icon">Specials</a></li>
                                        <?php } }?>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div id="business" class="tab-pane fade in <?php if (!(isset($_GET['tab']))) { ?> active <?php } ?>">
                                        <form method="post" action="<?php echo asset('create-bud'); ?>" id="create_bud" enctype="multipart/form-data" autocomplete="off">
                                            <input id="x" type="hidden" name="x" value="">
                                            <input id="y" type="hidden" name="y" value="">
                                            <input id="h" type="hidden" name="h" value="">
                                            <input id="w" type="hidden" name="w" value="">
                                            <input id="top" type="hidden" name="top" value="">
                                            <input id="image_croped" type="hidden" name="image_croped" value="">
                                            <input name="deliver" style="display: none" type="checkbox" id="boxCheck1hide" <?php if ($budz->is_delivery) { ?> checked="" <?php } ?> />
                                            <input name="organic" style="display: none" type="checkbox" id="boxCheckhide" <?php if ($budz->is_delivery) { ?> checked="" <?php } ?> />

                                            <input maxlength="30"  type="hidden" placeholder="Add Business/Event Name" name="title" value="" id="budz_title"class="valid" aria-invalid="false">

                                            <div class="">
                                                <input type="hidden" name="id" value="<?= $budz->id ?>">
                                                <?php if (Session::has('error')) { ?>  
                                                    <h5 class="alert alert-danger"><?php echo Session::get('error'); ?></h5>

                                                    <?php
                                                }
                                                if ($errors->all()) {
                                                    $errors = $errors->all();
                                                    foreach ($errors as $error) {
                                                        ?>
                                                        <h5 class="alert alert-danger"><?php echo $error; ?></h5>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <div class="left_content">
                                                                                          <div class="pad-bor pad-bor-nor">
                                                        <div class="add-map-area">
                                                            <h4>Adjust Pin Position</h4>
                                                            <div id="map" style="width: 100%; max-height: 300px; height: 300px"></div>
                                                        </div>
                                                    </div>
                                                    <div class="pad-bor pad-bor-nor">
                                                        <!--<h4>Choose Type</h4>-->
                                                        <h4>Choose Listing Type</h4>
                                                    </div>
                                                    <div class="type-adjust">
                                                        <div class="pad-bor pad-bor-nor">
                                                            <div class="add-bus-type">
                                                                <label for="iconCheck">
                                                                    <div class="cus-col cus-col-img">
                                                                        <figure>
                                                                            <img src="<?php echo asset('userassets/images/Dispensary.svg') ?>" alt="icon" />
                                                                        </figure>
                                                                    </div>
                                                                    <div class="cus-col cus-col-text">
                                                                        <h4>Dispensary</h4>
                                                                    </div>
                                                                    <div class="cus-col cus-col-icon">
                                                                        <input required type="radio" id="iconCheck" name="type" value="1" <?php if ($budz->business_type_id == 1) { ?> checked="" <?php } ?>/>
                                                                        <i class="fa fa-check"></i>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="pad-bor pad-bor-nor type-med">
                                                            <div class="add-bus-type">
                                                                <label for="">
                                                                    <div class="cus-col cus-col-img">
                                                                        <figure>
                                                                            <img src="<?php echo asset('userassets/images/Medical.svg') ?>" alt="icon" />
                                                                        </figure>
                                                                    </div>
                                                                    <div class="cus-col cus-col-text">
                                                                        <h4>Medical <i class="fa fa-caret-down"></i></h4>
                                                                    </div>
                                                                    <div class="cus-col cus-col-icon">
                                                                        <input type="radio" id="iconCheck001" name="type-med" value="" <?php if ($budz->business_type_id == 2 || $budz->business_type_id == 6 || $budz->business_type_id == 7) { ?> checked="" <?php } ?>/>
                                                                        <i class="fa fa-check"></i>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                            <div class="type-adj-bot">
                                                                <div class="add-bus-type add-bus-inside">
                                                                    <div class="cus-col cus-col-icon">
                                                                        <label for="iconCheck2">
                                                                            <!--<input type="radio" id="iconCheck2" name="type" value="2" data-parentclass="type-med"/>-->
                                                                            <input type="radio" id="iconCheck2" name="type" value="2" data-parentclass="type-med" data-parentcheckid="iconCheck001" <?php if ($budz->business_type_id == 2) { ?> checked="" <?php } ?>/>
                                                                            <i class="fa fa-check"></i>
                                                                            <h4>Medical Practitioner</h4>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="add-bus-type add-bus-inside">
                                                                    <div class="cus-col cus-col-icon">
                                                                        <label for="iconCheck3">
                                                                            <!--<input type="radio" id="iconCheck3" name="type" value="6" data-parentclass="type-med"/>-->
                                                                            <input type="radio" id="iconCheck3" name="type" value="6" data-parentclass="type-med" data-parentcheckid="iconCheck001" <?php if ($budz->business_type_id == 6) { ?> checked="" <?php } ?>/>
                                                                            <i class="fa fa-check"></i>
                                                                            <h4>Holistic Medical</h4>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="add-bus-type add-bus-inside">
                                                                    <div class="cus-col cus-col-icon">
                                                                        <label for="iconCheck4">
                                                                            <!--<input type="radio" id="iconCheck4" name="type" value="7" data-parentclass="type-med"/>-->
                                                                            <input type="radio" id="iconCheck4" name="type" value="7" data-parentclass="type-med" data-parentcheckid="iconCheck001" <?php if ($budz->business_type_id == 7) { ?> checked="" <?php } ?>/>
                                                                            <i class="fa fa-check"></i>
                                                                            <h4>Clinic</h4>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="pad-bor pad-bor-nor">
                                                            <div class="add-bus-type">
                                                                <label for="iconCheck5">
                                                                    <div class="cus-col cus-col-img">
                                                                        <figure>
                                                                            <img src="<?php echo asset('userassets/images/Cannabites.svg') ?>" alt="icon" />
                                                                        </figure>
                                                                    </div>
                                                                    <div class="cus-col cus-col-text">
                                                                        <h4>Cannabites</h4>
                                                                    </div>
                                                                    <div class="cus-col cus-col-icon">
                                                                        <input type="radio" id="iconCheck5" name="type" value="3" <?php if ($budz->business_type_id == 3) { ?> checked="" <?php } ?>/>
                                                                        <i class="fa fa-check"></i>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="pad-bor pad-bor-nor type-ent">
                                                            <div class="add-bus-type">
                                                                <label for="">
                                                                    <div class="cus-col cus-col-img">
                                                                        <figure>
                                                                            <img src="<?php echo asset('userassets/images/Entertainment.svg') ?>" alt="icon" />
                                                                        </figure>
                                                                    </div>
                                                                    <div class="cus-col cus-col-text">
                                                                        <h4>Entertainment <i class="fa fa-caret-down"></i></h4>
                                                                    </div>
                                                                    <div class="cus-col cus-col-icon">
                                                                        <input type="radio" id="iconCheck005" name="type-ent" value="" <?php if ($budz->business_type_id == 4 || $budz->business_type_id == 8) { ?> checked="" <?php } ?>/>
                                                                        <i class="fa fa-check"></i>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                            <div class="type-adj-bot">
                                                                <div class="add-bus-type add-bus-inside">
                                                                    <!--<div class="cus-col cus-col-text"></div>-->
                                                                    <div class="cus-col cus-col-icon">
                                                                        <label for="iconCheck6">
                                                                            <!--<input type="radio" id="iconCheck6" name="type" value="4" data-parentclass="type-ent"/>-->
                                                                            <input type="radio" id="iconCheck6" name="type" value="4" data-parentclass="type-ent" data-parentcheckid="iconCheck005" <?php if ($budz->business_type_id == 4) { ?> checked="" <?php } ?>/>
                                                                            <i class="fa fa-check"></i>
                                                                            <h4>Lounge</h4>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="add-bus-type add-bus-inside">
                                                                    <div class="cus-col cus-col-text"></div>
                                                                    <div class="cus-col cus-col-icon">
                                                                        <label for="iconCheck7">
                                                                            <!--<input type="radio" id="iconCheck7" name="type" value="8" data-parentclass="type-ent"/>-->
                                                                            <input type="radio" id="iconCheck7" name="type" value="8" data-parentclass="type-ent" data-parentcheckid="iconCheck005" <?php if ($budz->business_type_id == 8) { ?> checked="" <?php } ?>/>
                                                                            <i class="fa fa-check"></i>
                                                                            <h4>Cannabis Club/Bar</h4>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="pad-bor pad-bor-nor">
                                                            <div class="add-bus-type">
                                                                <label for="iconCheck8">
                                                                    <div class="cus-col cus-col-img">
                                                                        <figure>
                                                                            <img src="<?php echo asset('userassets/images/Events.svg') ?>" alt="icon" />
                                                                        </figure>
                                                                    </div>
                                                                    <div class="cus-col cus-col-text">
                                                                        <h4>Events</h4>
                                                                    </div>
                                                                    <div class="cus-col cus-col-icon">
                                                                        <input type="radio" id="iconCheck8" class="events-check" name="type" value="5" <?php if ($budz->business_type_id == 5) { ?> checked="" <?php } ?>/>
                                                                        <i class="fa fa-check"></i>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <?php if (!$budz->stripe_id) { ?>
                                                        <div class="pad-bor pad-bor-nor">
                                                            <div class="add-bus-type">
                                                                <label for="iconCheck9">
                                                                    <div class="cus-col cus-col-img">
                                                                        <figure>
                                                                            <img src="<?php echo asset('userassets/images/other-icon.svg') ?>" alt="icon" />
                                                                        </figure>
                                                                    </div>
                                                                    <div class="cus-col cus-col-text">
                                                                        <h4>Other</h4>
                                                                    </div>
                                                                    <div class="cus-col cus-col-icon">
                                                                        <input type="radio" id="iconCheck9" class="" name="type" value="9" <?php if ($budz->business_type_id == 9) { ?> checked="" <?php } ?>/>
                                                                        <i class="fa fa-check"></i>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="pad-bor pad-bor-nor">
                                                        <div class="bus-txt-area">
                                                            <h4>Add Short Description</h4>
                                                            <textarea name="description" maxlength="500" placeholder="Add a Description" id="description" class="extra-txtarea-height"><?= revertTagSpace($budz->description); ?></textarea>
                                                        </div>
                                                    </div>
                                                    <!--<div class="medical" <?php
                                                    if ($budz->business_type_id == 2 || $budz->business_type_id == 6 || $budz->business_type_id == 7) {
                                                        echo'style="display:block;"';
                                                    } else {
                                                        echo 'style="display:none;"';
                                                    }
                                                    ?>>-->
                                                    <div class="office_policies" <?php
                                                    if ($budz->business_type_id == 2 || $budz->business_type_id == 6 || $budz->business_type_id == 7) {
                                                        echo'style="display:block;"';
                                                    } else {
                                                        echo 'style="display:none;"';
                                                    }
                                                    ?>>
                                                        <div class="pad-bor pad-bor-nor">
                                                            <div class="bus-txt-area bus-txt-area-short">
                                                                <h4>Office policies &amp; Information</h4>
                                                                <textarea name="office_policies" id="office-policies" maxlength="200" placeholder="Office policies &amp; Information" class="extra-txtarea-height"><?= revertTagSpace($budz->office_policies); ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="visit_requirements" <?php
                                                    if ($budz->business_type_id == 2 || $budz->business_type_id == 6 || $budz->business_type_id == 7) {
                                                        echo'style="display:block;"';
                                                    } else {
                                                        echo 'style="display:none;"';
                                                    }
                                                    ?>>
                                                        <div class="pad-bor pad-bor-nor">
                                                            <div class="bus-txt-area bus-txt-area-short">
                                                                <h4>Pre-visit Requirements</h4>
                                                                <textarea name="visit_requirements" id="p-requirements" maxlength="200" placeholder="Pre-visit Requirements" ><?= revertTagSpace($budz->visit_requirements) ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                     <div class="pad-bor pad-bor-nor others_hide_show" <?php if($budz->business_type_id != 9){ ?> style="display: none <?php } ?>">
                                                         <input type="hidden" name="others_removed" id="others_removed">
                                                         <div class="other-budz-attach-img">
                                                            <div class="bus-upload">
                                                                <label for="img-view-buss-edit">
                                                                    <input type="file" name="others_image" id="img-view-buss-edit" accept="image/*"/>
                                                                    <!--<span>Post Review</span>-->

                                                                    <span class="res">
                                                                        Add An image 
                                                                        <span>(1 PHOTO.)</span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                            <div <?php if($budz->others_image){ ?> style="display: block !important;" <?php } ?> class="bus-pap rev-img-vid-set">
                                                                <figure style="background-image:url('<?php echo asset('public/images'.$budz->others_image) ?>');" id="budz_review_image" /></figure>
                                                               
                                                                <i class="fa fa-close"></i>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                       <div <?php if ($budz->business_type_id == 9){ ?> style="display: none" <?php } ?>  class="others_hide pad-bor pad-bor-nor">
                                                        <div class="add-bus-contact">
                                                            <h4>Business Links</h4>
                                                              <div class="budz_map_add_wrapper_social">
                                                                    <div class="budz_add_social_icons" >
                                                            <div class="add-bus-input">
                                                                <div class="cus-cols">
                                                                    <input name="web" class="wb-url" type="text" placeholder="Your Website Url" value="<?= $budz->web; ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="add-bus-input">
                                                                <div class="cus-cols">
                                                                    <input name="fb" class="fb-url" type="text" placeholder="Facebook" value="<?= $budz->facebook; ?>" />
                                                                </div>

                                                            </div>
                                                </div>
                                                              <div class="budz_add_social_icons" >
                                                            <div class="add-bus-input">
                                                                <div class="cus-cols">
                                                                    <input name="twitter" class="tw-url" type="text" placeholder="Twitter" value="<?= $budz->twitter; ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="add-bus-input">
                                                                <div class="cus-cols">
                                                                    <input name="instagram" class="ins-url" type="text" placeholder="Instagram" value="<?= $budz->instagram; ?>"/>
                                                                </div>
                                                            </div>
                                                </div>
                                                </div>
                                                        </div>
                                                    </div>
                                                    <!--</div>-->
                                                      <div class="pad-bor pad-bor-nor desk-show budz_submit_btn">
                                                        <div class="strain-green-input">
                                                            <input type="submit" class="btn-primary bus-submit" value="SUBMIT">
                                                        </div>
                                                        <!--                                                        <div class="bus-submit">
                                                                                                                    <input type="submit" value="SUBMIT">
                                                                                                                </div>-->
                                                    </div>
                                                </div>
                                                <div class="right_content">
                                                  
                                                    <div class="pad-bor pad-bor-nor">
                                                        <div class="add-bus-contact">
                                                            <h4>Location & Contact</h4>
                                                            <div class="add-bus-input">
                                                                <div class="cus-cols b-m-a-tel">
                                                                    <input name="phone" type="tel" placeholder="Phone Number" class="phone_us" value="<?= $budz->phone; ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="add-bus-input">
                                                                <div class="cus-cols b-m-a-mail">
                                                                    <input name="email" type="email" placeholder="Email" value="<?= $budz->email; ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="add-bus-input">
                                                                <div class="cus-cols b-m-a-zip">
                                                                    <input name="zip_code" type="text" placeholder="ZipCode" autocomplete="off" value="<?= $budz->zip_code; ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="bus-txt-area add-bus-input">
                                                                <!--<textarea readonly=""  name="location" id="location" maxlength="200" ><?= $budz->location; ?></textarea>-->
                                                                <div class="cus-cols b-m-a-loc">
                                                                    <input type="text" id="location" name="location" maxlength="200" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
              
                                                    <div class="pad-bor pad-bor-nor" <?php
                                                    if ($budz->business_type_id != 5) {
                                                        echo'style="display:block;"';
                                                    } else {
                                                        echo 'style="display:none;"';
                                                    }
                                                    ?>>
                                                        <div  <?php if ($budz->business_type_id == 9){ ?> style="display: none" <?php } ?> class="add-bus-time others_hide">
                                                            <h4>Hours of Operation</h4>
                                                            <div class="add-bus-time-inner <?php $showday = 'Mon'; ?>">
                                                                <div class="cus-col cus-time">
                                                                    <span><?php echo $showday; ?>:</span>
                                                                </div>
                                                                <div class="cus-col cus-label">
                                                                    <label for="hoursCheck">
                                                                        <input type="checkbox" id="hoursCheck" <?php
                                                                        if ($budz->timeing) {
                                                                            if ($budz->timeing->monday == 'Closed') {
                                                                                ?> checked <?php
                                                                                   }
                                                                               }
                                                                               ?> onchange="disableselect(this, 'mon')"/>
                                                                        <span class="tick-cross"></span>
                                                                        <div class="cus-select">
                                                                            <select name="mon_start" class="mon" <?php
                                                                            if ($budz->timeing) {
                                                                                if ($budz->timeing->monday == 'Closed') {
                                                                                    ?> disabled="" <?php
                                                                                        }
                                                                                    }
                                                                                    ?> >
                                                                                        <?php foreach ($slots as $slot) { ?>
                                                                                    <option <?php
                                                                                    if ($budz->timeing) {
                                                                                        if ($budz->timeing->monday == $slot) {
                                                                                            ?> selected="" <?php
                                                                                            }
                                                                                        }
                                                                                        ?> value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                                    <?php } ?>
                                                                            </select>
                                                                            <span>-</span>
                                                                            <select name="mon_end" class="mon">
                                                                                <?php foreach ($slots as $slot) { ?>
                                                                                    <option <?php
                                                                                    if ($budz->timeing) {
                                                                                        if ($budz->timeing->mon_end == $slot) {
                                                                                            ?> selected="" <?php
                                                                                            }
                                                                                        }
                                                                                        ?> value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                                    <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="cus-closed">
                                                                            <span>Closed</span>
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="add-bus-time-inner <?php $showday = 'Tue'; ?>">
                                                                <div class="cus-col cus-time">
                                                                    <span><?php echo $showday; ?>:</span>
                                                                </div>
                                                                <div class="cus-col cus-label">
                                                                    <label for="hoursCheck1">
                                                                        <input type="checkbox" id="hoursCheck1" <?php
                                                                        if ($budz->timeing) {
                                                                            if ($budz->timeing->tuesday == 'Closed') {
                                                                                ?> checked <?php
                                                                                   }
                                                                               }
                                                                               ?> onchange="disableselect(this, 'tue')"/>
                                                                        <span class="tick-cross"></span>
                                                                        <div class="cus-select">
                                                                            <select name="tue_start" class="tue" <?php
                                                                            if ($budz->timeing) {
                                                                                if ($budz->timeing->tuesday == 'Closed') {
                                                                                    ?> disabled="" <?php
                                                                                        }
                                                                                    }
                                                                                    ?>>
                                                                                        <?php foreach ($slots as $slot) { ?>
                                                                                    <option <?php
                                                                                    if ($budz->timeing) {
                                                                                        if ($budz->timeing->tuesday == $slot) {
                                                                                            ?> selected="" <?php
                                                                                            }
                                                                                        }
                                                                                        ?> value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                                    <?php } ?>
                                                                            </select>
                                                                            <span>-</span>
                                                                            <select name="tue_end" class="tue">
                                                                                <?php foreach ($slots as $slot) { ?>
                                                                                    <option <?php
                                                                                    if ($budz->timeing) {
                                                                                        if ($budz->timeing->tue_end == $slot) {
                                                                                            ?> selected="" <?php
                                                                                            }
                                                                                        }
                                                                                        ?> value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                                    <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="cus-closed">
                                                                            <span>Closed</span>
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="add-bus-time-inner  <?php $showday = 'Web'; ?>">
                                                                <div class="cus-col cus-time">
                                                                    <span><?php echo $showday; ?>:</span>
                                                                </div>
                                                                <div class="cus-col cus-label">
                                                                    <label for="hoursCheck2">
                                                                        <input type="checkbox" id="hoursCheck2" <?php
                                                                        if ($budz->timeing) {
                                                                            if ($budz->timeing->wednesday == 'Closed') {
                                                                                ?> checked <?php
                                                                                   }
                                                                               }
                                                                               ?> onchange="disableselect(this, 'wed')"/>
                                                                        <span class="tick-cross"></span>
                                                                        <div class="cus-select">
                                                                            <select name="wed_start" class="wed" <?php
                                                                            if ($budz->timeing) {
                                                                                if ($budz->timeing->wednesday == 'Closed') {
                                                                                    ?> disabled="" <?php
                                                                                        }
                                                                                    }
                                                                                    ?>>
                                                                                        <?php foreach ($slots as $slot) { ?>
                                                                                    <option <?php
                                                                                    if ($budz->timeing) {
                                                                                        if ($budz->timeing->wednesday == $slot) {
                                                                                            ?> selected="" <?php
                                                                                            }
                                                                                        }
                                                                                        ?> value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                                    <?php } ?>
                                                                            </select>
                                                                            <span>-</span>
                                                                            <select name="wed_end" class="wed">
                                                                                <?php foreach ($slots as $slot) { ?>
                                                                                    <option  <?php
                                                                                    if ($budz->timeing) {
                                                                                        if ($budz->timeing->wed_end == $slot) {
                                                                                            ?> selected="" <?php
                                                                                            }
                                                                                        }
                                                                                        ?> value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                                    <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="cus-closed">
                                                                            <span>Closed</span>
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="add-bus-time-inner  <?php $showday = 'Thu'; ?>">
                                                                <div class="cus-col cus-time">
                                                                    <span><?php echo $showday; ?>:</span>
                                                                </div>
                                                                <div class="cus-col cus-label">
                                                                    <label for="hoursCheck3">
                                                                        <input type="checkbox" id="hoursCheck3" <?php
                                                                        if ($budz->timeing) {
                                                                            if ($budz->timeing->thursday == 'Closed') {
                                                                                ?> checked <?php
                                                                                   }
                                                                               }
                                                                               ?> onchange="disableselect(this, 'thu')"/>
                                                                        <span class="tick-cross"></span>
                                                                        <div class="cus-select">
                                                                            <select name="thu_start" class="thu" <?php
                                                                            if ($budz->timeing) {
                                                                                if ($budz->timeing->thursday == 'Closed') {
                                                                                    ?> disabled="" <?php
                                                                                        }
                                                                                    }
                                                                                    ?>>
                                                                                        <?php foreach ($slots as $slot) { ?>
                                                                                    <option <?php
                                                                                    if ($budz->timeing) {
                                                                                        if ($budz->timeing->thursday == $slot) {
                                                                                            ?> selected="" <?php
                                                                                            }
                                                                                        }
                                                                                        ?>  value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                                    <?php } ?>
                                                                            </select>
                                                                            <span>-</span>
                                                                            <select name="thu_end" class="thu">
                                                                                <?php foreach ($slots as $slot) { ?>
                                                                                    <option <?php
                                                                                    if ($budz->timeing) {
                                                                                        if ($budz->timeing->thu_end == $slot) {
                                                                                            ?> selected="" <?php
                                                                                            }
                                                                                        }
                                                                                        ?>  value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                                    <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="cus-closed">
                                                                            <span>Closed</span>
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="add-bus-time-inner  <?php $showday = 'Fri'; ?>">
                                                                <div class="cus-col cus-time">
                                                                    <span><?php echo $showday; ?>:</span>
                                                                </div>
                                                                <div class="cus-col cus-label">
                                                                    <label for="hoursCheck4" >
                                                                        <input type="checkbox" id="hoursCheck4" <?php
                                                                        if ($budz->timeing) {
                                                                            if ($budz->timeing->friday == 'Closed') {
                                                                                ?> checked <?php
                                                                                   }
                                                                               }
                                                                               ?> onchange="disableselect(this, 'fri')"/>
                                                                        <span class="tick-cross"></span>
                                                                        <div class="cus-select">
                                                                            <select name="fri_start" class="fri"  <?php
                                                                            if ($budz->timeing) {
                                                                                if ($budz->timeing->friday == 'Closed') {
                                                                                    ?> disabled="" <?php
                                                                                        }
                                                                                    }
                                                                                    ?>>
                                                                                        <?php foreach ($slots as $slot) { ?>
                                                                                    <option <?php
                                                                                    if ($budz->timeing) {
                                                                                        if ($budz->timeing->friday == $slot) {
                                                                                            ?> selected="" <?php
                                                                                            }
                                                                                        }
                                                                                        ?> value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                                    <?php } ?>
                                                                            </select>
                                                                            <span>-</span>
                                                                            <select name="fri_end" class="fri">
                                                                                <?php foreach ($slots as $slot) { ?>
                                                                                    <option <?php
                                                                                    if ($budz->timeing) {
                                                                                        if ($budz->timeing->fri_end == $slot) {
                                                                                            ?> selected="" <?php
                                                                                            }
                                                                                        }
                                                                                        ?> value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                                    <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="cus-closed">
                                                                            <span>Closed</span>
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="add-bus-time-inner  <?php $showday = 'Sat'; ?>">
                                                                <div class="cus-col cus-time">
                                                                    <span><?php echo $showday; ?>:</span>
                                                                </div>
                                                                <div class="cus-col cus-label">
                                                                    <label for="hoursCheck5">
                                                                        <input type="checkbox" <?php
                                                                        if ($budz->timeing) {
                                                                            if ($budz->timeing->saturday == 'Closed') {
                                                                                ?> checked <?php
                                                                                   }
                                                                               }
                                                                               ?> id="hoursCheck5"onchange="disableselect(this, 'sat')" />
                                                                        <span class="tick-cross"></span>
                                                                        <div class="cus-select">
                                                                            <select name="sat_start" class="sat" <?php
                                                                            if ($budz->timeing) {
                                                                                if ($budz->timeing->saturday == 'Closed') {
                                                                                    ?> disabled="" <?php
                                                                                        }
                                                                                    }
                                                                                    ?>>
                                                                                        <?php foreach ($slots as $slot) { ?>
                                                                                    <option <?php
                                                                                    if ($budz->timeing) {
                                                                                        if ($budz->timeing->saturday == $slot) {
                                                                                            ?> selected="" <?php
                                                                                            }
                                                                                        }
                                                                                        ?> value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                                    <?php } ?>
                                                                            </select>

                                                                            <span>-</span>
                                                                            <select name="sat_end" class="sat">
                                                                                <?php foreach ($slots as $slot) { ?>
                                                                                    <option <?php
                                                                                    if ($budz->timeing) {
                                                                                        if ($budz->timeing->sat_end == $slot) {
                                                                                            ?> selected="" <?php
                                                                                            }
                                                                                        }
                                                                                        ?> value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                                    <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="cus-closed">
                                                                            <span>Closed</span>
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="add-bus-time-inner  <?php $showday = 'Sun'; ?>">
                                                                <div class="cus-col cus-time">
                                                                    <span><?php echo $showday; ?>:</span>
                                                                </div>
                                                                <div class="cus-col cus-label" >
                                                                    <label for="hoursCheck6">
                                                                        <input type="checkbox" id="hoursCheck6" <?php
                                                                        if ($budz->timeing) {
                                                                            if ($budz->timeing->sunday == 'Closed') {
                                                                                ?> checked <?php
                                                                                   }
                                                                               }
                                                                               ?> onchange="disableselect(this, 'sun')"/>
                                                                        <span class="tick-cross"></span>
                                                                        <div class="cus-select">
                                                                            <select name="sun_start" class="sun" <?php
                                                                            if ($budz->timeing) {
                                                                                if ($budz->timeing->sunday == 'Closed') {
                                                                                    ?> disabled="" <?php
                                                                                        }
                                                                                    }
                                                                                    ?>>
                                                                                        <?php foreach ($slots as $slot) { ?>
                                                                                    <option <?php
                                                                                    if ($budz->timeing) {
                                                                                        if ($budz->timeing->sunday == $slot) {
                                                                                            ?> selected="" <?php
                                                                                            }
                                                                                        }
                                                                                        ?> value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                                    <?php } ?>
                                                                            </select>
                                                                            <span>-</span>
                                                                            <select name="sun_end" class="sun">
                                                                                <?php foreach ($slots as $slot) { ?>
                                                                                    <option <?php
                                                                                    if ($budz->timeing) {
                                                                                        if ($budz->timeing->sun_end == $slot) {
                                                                                            ?> selected="" <?php
                                                                                            }
                                                                                        }
                                                                                        ?> value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                                    <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="cus-closed">
                                                                            <span>Closed</span>
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="pad-bor pad-bor-nor event-date-time" <?php
                                                    if ($budz->business_type_id == 5) {
                                                        echo'style="display:block;"';
                                                    } else {
                                                        echo 'style="display:none;"';
                                                    }
                                                    ?>>
                                                        <div class="add-bus-contact">
                                                            <h4>Date / Time</h4>
                                                            <input type="text" class="hidden div-counter" name="event_count" value="1">
                                                            <div class="add-bus-input t-row">
                                                                <div class="cus-col">
                                                                    <input value="<?php
                                                                    if (isset($budz->events[0]->date)) {
                                                                        echo $budz->events[0]->date;
                                                                    }
                                                                    ?>" type="text" id="datepicker1" name="date1" format="dd/MM/yyyy" readonly="" placeholder="Date" required="">
                                                                    <span class="error" id="date_error" style="display:none;color: #a94442"> </span>
                                                                </div>
                                                                <div class="cus-col date-time">
                                                                    <input id="from_time" name="from1" type="time" value="<?php
                                                                    if (isset($budz->events[0]->from_time)) {
                                                                        echo date("H:i", strtotime($budz->events[0]->from_time));
                                                                    }
                                                                    ?>"> <i class="to-time">to</i>
                                                                    <input id="to_time" name="to1" type="time" value="<?php
                                                                    if (isset($budz->events[0]->to_time)) {
                                                                        echo date("H:i", strtotime($budz->events[0]->to_time));
                                                                    }
                                                                    ?>">
                                                                </div>
                                                                <!--<a href="#" class="add-time-btn"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="languages" <?php
                                                    if ($budz->business_type_id == 2 || $budz->business_type_id == 6 || $budz->business_type_id == 7) {
                                                        echo'style="display:block;"';
                                                    } else {
                                                        echo 'style="display:none;"';
                                                    }
                                                    ?>>
                                                        <div class="pad-bor pad-bor-nor">
                                                            <div class="bus-txt-area bus-txt-area-short">
                                                                <div class="lang-cols">
                                                                    <?php
                                                                    if (count($budz->languages) > 0) {
                                                                        $used_language = array();
                                                                        foreach ($budz->languages as $lang) {
                                                                            if ($lang->getLanguage) {
                                                                                $used_language[] = $lang->getLanguage->id;
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <h4>Languages</h4>
                                                                    <select id="languages" multiple="" placeholder="Edit Tags" name="langeages[]" class="chosen-select" tabindex="1">
                                                                        <?php foreach ($languages as $language) { ?>
                                                                            <option value="<?= $language->id ?>"><?= $language->name ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <span class="error" id="language_error" style="display:none;color: #a94442"></span>
                                                                </div>
                                                                <div class="lang-cols">
                                                                    <h4>Insurance</h4>
                                                                    <div class="onoff">
                                                                        <label for="onOff">
                                                                            <input type="checkbox" value="<?= $budz->insurance_accepted ?>" id="onOff" name="insurance_accepted" <?php
                                                                            if ($budz->insurance_accepted == 'Yes') {
                                                                                echo 'checked';
                                                                            }
                                                                            ?>>
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--                                                    <div class="pad-bor pad-bor-nor">
                                                                                                            <div class="bus-txt-area bus-txt-area-short">
                                                                                                                <h4>Add Location</h4>
                                                                                                                <textarea readonly=""  name="location" id="location" maxlength="200" ><?php // echo $city . ', ' . $region_code . ' ' . $zip_code . ', ' . $country_code                ?></textarea>
                                                                                                            </div>
                                                                                                        </div>-->
                                                    <!--</div>-->

                                                    <?php if (count($payment_methods) > 0) { ?>
                                                        <div <?php if ($budz->business_type_id == 9){ ?> style="display: none" <?php } ?>  class="pad-bor pad-bor-nor others_hide">
                                                            <div class="add-bus-contact">
                                                                <!--<h4>Select Payment Method</h4>-->
                                                                <h4>Select Payment Methods Offered</h4>
                                                                <div class="bus-pay pay-add-ck">
                                                                    <?php foreach ($payment_methods as $payment_method) { ?>
                                                                        <label>
                                                                            <input type="checkbox" name="payment_methods[]" value="<?= $payment_method->id ?>" <?php
                                                                            if (in_array($payment_method->id, $bud_payment_methods)) {
                                                                                echo 'checked';
                                                                            }
                                                                            ?>>

                                                                            <img src="<?php echo asset('public/images' . $payment_method->image) ?>" alt="<?= $payment_method->title ?>">
                                                                        </label>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                 
                                                    <div class="pad-bor pad-bor-nor mob-show">
                                                        <div class="strain-green-input">
                                                            <input type="submit" class="btn-primary bus-submit" value="SUBMIT">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>    
                                            <input type="hidden" name="lat" id="lat" value="<?= $budz->lat; ?>">
                                            <input type="hidden" name="lng" id="lng" value="<?= $budz->lng; ?>">
                                        </form>
                                    </div>
                                    <?php
                                    if ($budz->business_type_id == 2 || $budz->business_type_id == 6 || $budz->business_type_id == 7) {
                                        include 'includes/budz-medical-services.php';
                                        ?>    

                                    <?php } if ($budz->business_type_id == 1 || $budz->business_type_id == 3 || $budz->business_type_id == 4 || $budz->business_type_id == 8) { ?>
                                        <?php
                                        include 'includes/budz-product.php';
                                    }
                                    ?>

                                    <?php include 'includes/budz-event-tickets.php'; ?>
                                    <?php include 'includes/budz-gallery.php'; ?>
                                    <?php include 'includes/budz-special.php'; ?>
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

        <?php // include('includes/footer-new.php'); ?>

        <div id="addSubscription" class="modal fade map-black-listing map-black-pre" role="dialog">
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
                                <h3>Keyword Optimization Tool</h3>
                                <p>Increase your exposure even further by optimizing your listing with active keywords throughout our community.</p>
                            </div>
                        </div>
                        <div class="map-bl-row">
                            <div class="cus-col">
                                <figure>
                                    <img src="<?php echo asset('userassets/images/map-icon3.svg') ?>" alt="image" />
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
                            <!--<a href="#" class="map-bl-btn">Subscribe Now</a>-->
                            <form action="<?php echo asset('subscribe-user') ?>" method="POST">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <script
                                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                    data-key="pk_test_kBD5CZDk3MBZNRLeWqrfvhew"
                                    data-amount="9999"
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
        <script>  function setOther(ele) {
                if (ele.checked) {
                    $('#boxCheck1hide').attr('checked', 'checked');
                } else {
                    $('#boxCheck1hide').removeAttr('checked');
                }
            }
            function setOther2(ele) {
                if (ele.checked) {
                    $('#boxCheckhide').attr('checked', 'checked');
                } else {
                    $('#boxCheckhide').removeAttr('checked');
                }
            }
            function openSubscriptionModal() {
                $('#showsubscription').modal('show');
            }
        </script>



        <?php include('includes/footer.php'); ?>
        <script type="text/javascript" src="<?= asset('userassets/js/jquery.jWindowCrop.js') ?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.13/jquery.mask.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>
        <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
        <?php
        $lati = 0;
        $longi = 0;
        if ($budz->lat) {
            $lati = $budz->lat;
            $longi = $budz->lng;
        }
        ?>
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
        <?php if (isset($used_language)) { ?>
            <script>
                $(document).ready(function () {
                    $('.phone_us').mask('(000) 000-0000');
                    var tags_id = '<?php echo(implode(',', $used_language)); ?>';
                    var tags_id_array = tags_id.split(',');
                    $('#languages').val(tags_id_array).trigger('chosen:updated');
                    
                   
                });
            </script>
           

        <?php } ?>

        <script>
            state = '';
            business_type_id = $("input[name=type]:checked").val();
            legal_states = ["Idaho",
                "Wyoming",
                "Utah",
                "South Dakota",
                "Nebraska",
                "Kansas",
                "Oklahoma",
                "Texas",
                "Missouri",
                "Iowa",
                "Wisconsin",
                "Indiana",
                "Kentucky",
                "Tennessee",
                "Mississippi",
                "Alabama",
                "Virginia",
                "Georgia",
                "North Carolina",
                "South Carolina"
            ];

            function initMap() {


                defaultLatLong = {
                    lat: <?= $lati ?>,
                    lng: <?= $longi ?>
                };

                var options = {
                    types: ['(cities)'],
                    componentRestrictions: {country: "us"}
                };

                setTimeout(function () {
                    var map = new google.maps.Map(document.getElementById('map'), {
                        center: defaultLatLong,
                        zoom: 13,
                        mapTypeId: 'roadmap'
                    });

                    var input = document.getElementById('location');

                    //set current street address in input field
                    var google_maps_geocoder = new google.maps.Geocoder();
                    google_maps_geocoder.geocode(
                            {'latLng': defaultLatLong},
                            function (results, status) {
                                //set lat, lng in input type hidden field
                                updateInputFieldLatLng(defaultLatLong.lat, defaultLatLong.lng);

                                var geocode_addredd = results[results.length - 2];
                                var address_array = geocode_addredd.formatted_address.split(',');
                                state = address_array[0];

                                var address = results[0].formatted_address;
                                if ((business_type_id == 2) || (business_type_id == 6) || (business_type_id == 7)) {
                                    if ($.inArray(state, legal_states) <= -1) {
                                        //                                window.alert('not legal state');
                                        //update autocomplete input field
                                        address = '';
                                    }
                                }
                                input.value = address;


                            }
                    );
                    /*****/

                    //                var autocomplete = new google.maps.places.Autocomplete(input, options);
                    var autocomplete = new google.maps.places.Autocomplete(
                            /** @type {!HTMLInputElement} */(document.getElementById('location')),
                            {types: ['geocode']});
                    autocomplete.bindTo('bounds', map);

                    //                map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

                    var marker = new google.maps.Marker({
                        map: map,
                        position: defaultLatLong,
                        draggable: true,
                        clickable: true
                    });

                    google.maps.event.addListener(marker, 'dragend', function (marker) {
                        var latLng = marker.latLng;
                        currentLatitude = latLng.lat();
                        currentLongitude = latLng.lng();
                        var latlng = {
                            lat: currentLatitude,
                            lng: currentLongitude
                        };
                        //set lat, lng in input type hidden field
                        updateInputFieldLatLng(currentLatitude, currentLongitude);

                        var geocoder = new google.maps.Geocoder;
                        geocoder.geocode({
                            'location': latlng
                        }, function (results, status) {
                            if (status === 'OK') {
                                if (results[0]) {
                                    var geocode_addredd = results[results.length - 2];
                                    var address_array = geocode_addredd.formatted_address.split(',');
                                    state = address_array[0]; 
                                    var address = results[0].formatted_address;
                                    if ((business_type_id == 2) || (business_type_id == 6) || (business_type_id == 7)) {
                                        if ($.inArray(state, legal_states) <= -1) {
                                            //                                        window.alert('not legal state');
                                            //update autocomplete input field
                                            address = '';
                                        }
                                    }
                                    input.value = address;
                                } else {
                                    $('#erroralertmessage').html('No results found');
                                    $('#erroralert').show();
                                }
                            } else {
                                $('#erroralertmessage').html('Geocoder failed due to: ' + status);
                                $('#erroralert').show();
                            }
                        });
                    });

                    autocomplete.addListener('place_changed', function () {
                        var place = autocomplete.getPlace();
                        if (!place.geometry) {
                            return;
                        }
                        if (place.geometry.viewport) {
                            map.fitBounds(place.geometry.viewport);
                        } else {
                            map.setCenter(place.geometry.location);
                        }

                        marker.setPosition(place.geometry.location);

                        currentLatitude = place.geometry.location.lat();
                        currentLongitude = place.geometry.location.lng();
                        var latlng = {
                            lat: currentLatitude,
                            lng: currentLongitude
                        };
                        //set lat, lng in input type hidden field
                        updateInputFieldLatLng(currentLatitude, currentLongitude);

                        var geocoder = new google.maps.Geocoder;
                        geocoder.geocode({
                            'location': latlng
                        }, function (results, status) {
                            if (status === 'OK') {
                                if (results[0]) {
                                    var geocode_addredd = results[results.length - 2];
                                    var address_array = geocode_addredd.formatted_address.split(',');
                                    state = address_array[0];
                                    //update autocomplete input field
                                    //                                input.value = results[0].formatted_address;
                                    if ((business_type_id == 2) || (business_type_id == 6) || (business_type_id == 7)) {
                                        if ($.inArray(state, legal_states) <= -1) {
                                            $('#erroralertmessage').html("You can't create this type of business in your area.");
                                            $('#erroralert').show();
                                            input.value = '';
                                        }
                                    }

                                } else {
                                    $('#erroralertmessage').html('No results found');
                                    $('#erroralert').show();
                                }
                            } else {
                                $('#erroralertmessage').html('Geocoder failed due to: ' + status);
                                $('#erroralert').show();

                            }
                        });

                    });
                }, 3000);
            }

            function updateInputFieldLatLng(lat, lng) {
                $('#lat').val(lat);
                $('#lng').val(lng);
            }




        </script>    

        <script>
            $(document).ready(function () {
                $.validator.addMethod("zipcode", function (value, element) {
                    return this.optional(element) || /^\d{5}(?:-\d{4})?$/.test(value);
                }, "Please provide a valid zipcode.");
                $.validator.methods.email = function (value, element) {
                    return this.optional(element) || /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
                };
                $.validator.addMethod('timeLessThan', function (value, element, param) {
                    return this.optional(element) || value <= $(param).val();
                }, '');
                $("#create_bud").validate({
                    rules: {
                        title: {
                            required: true
                        },
                        description: {
                            required: true
                        },
                        email: {
                            email: true,
                            required: true
                        },
                        phone: {
                            required: true
                        },
                        location: {
                            required: true
                        },
                        zip_code: {
                            required: true,
                            zipcode: true
                        },
                        from1: {
                            required: true,
                            timeLessThan: '#to_time'
                        }
                    },
                    //                messages: {
                    //                    title: {
                    //                        required: ""
                    //                    },
                    //                    description: {
                    //                        required: ""
                    //                    },
                    //                    location: {
                    //                        required: ""
                    //                    },
                    //                    from1: {
                    //                        required: "",
                    //                        timeLessThan: ""
                    //                    }
                    //                },
                    errorPlacement: function (error, element) {
                        return false;
                    },
                });

                var type = $("input[name=type]:checked").val();
                if ((type == 4) || (type == 8) || (type == 5)) {
                    $(".services").hide(200);
                } else {
                    $(".services").show(200);
                }

                $('.phone_us').mask('(000) 000-0000');
                $('.add-bus-inside input[type="radio"]').click(function () {
                    $('.add-bus-type').removeClass('active');

                    $('.' + $(this).data('parentclass')).addClass('active');
                    $('#' + $(this).data('parentcheckid')).click();
                    $('.type-adj-bot').hide();
                    //                $('.'+$(this).data('parentclass')).children().first().click();
                });
                $('.pad-bor .add-bus-type').click(function () {
                    $('.type-adj-bot').hide();
                    $(this).siblings('.type-adj-bot').show();
                });
                $('.bus-submit').click(function (e) {
                    title = $('#budz_title_show').val();
                    $('#budz_title').val(title);
                    e.preventDefault();

                    var type = $("input[name=type]:checked").val();
                    if (type == 2 || type == 6 || type == 7) {
                        var lang = $(".chosen-select").val();
                        if (lang.length <= 0) {
                            setTimeout(function () {
                                $(".chosen-choices").css({"border-color": "red",
                                    "border-width": "2px",
                                    "border-style": "solid"});
                            }, 1000);
                            $('#language_error').show();
                            $('html, body').animate({
                                scrollTop: $("#language_error").offset().top
                            }, 500);
                        } else {
                            $('#language_error').css({
                                "border-color": "gray",
                                "border-width": "1px",
                                "border-style": "solid"
                            });
                            $('#language_error').hide();
                            $("#create_bud").submit();
                        }
                    } else if (type == 5) {
                        var date = $("#datepicker1").val();
                        var from_time = $('#from_time').val();
                        var to_time = $('#to_time').val();
                        if (date == '') {
                            $('#date_error').show();
                            $('#datepicker1').css({
                                "border-color": "red",
                                "border-width": "2px",
                                "border-style": "solid"
                            });
                            $("#date_error").focus();
                            $('html, body').animate({
                                scrollTop: $("#date_error").offset().top
                            }, 500);
                        } else {
                            $('#datepicker1').css({
                                "border-color": "gray",
                                "border-width": "1px",
                                "border-style": "solid"
                            });
                            $('#date_error').hide();
                            $("#create_bud").submit();
                        }

                        if (from_time) {
                            if (from_time > to_time) {
                                $('#date_error').show();
                                $('#from_time').css({
                                    "border-color": "red",
                                    "border-width": "2px",
                                    "border-style": "solid"
                                });
                                $("#date_error").focus();
                                $('html, body').animate({
                                    scrollTop: $("#date_error").offset().top
                                }, 500);
                            } else {
                                $('#from_time').css({
                                    "border-color": "gray",
                                    "border-width": "1px",
                                    "border-style": "solid"
                                });
                                $('#date_error').hide();
                                $("#create_bud").submit();
                            }
                        }
                    } else {
                        $("#create_bud").submit();
                    }
                });
            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var file = input.files[0];
                    var reader = new FileReader();

                    reader.onload = function () {
                        getOrientation(file, function (orientation) {
                            resetOrientation(reader.result, orientation, function (result) {
                                $('#logosrc').css('background-image', 'url(' + result + ')');
                            });
                        });

                        //                    $('#logosrc').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(file);
                }
            }

            $("#add").change(function () {
                var $this = $(this), $clone = $this.clone();
                $this.removeAttr('id').after('<input name="cover" type="file" id="add" onChange="changeLogo(this)">').appendTo($("#create_bud")).hide();
                readURL(this);
            });
            function changeLogo(ele) {
                var $this = $(ele), $clone = $this.clone();
                $this.removeAttr('id').after('<input name="cover" type="file" id="add" onChange="changeLogo(this)">').appendTo($("#create_bud")).hide();
                readURLCover(ele);
            }
            function disableselect(ele, cls) {
                if (ele.checked) {
                    $('select[class="' + cls + '"]').attr('disabled', 'disabled');
                } else {
                    $('select[class="' + cls + '"]').removeAttr('disabled');
                }
            }

            function readURLCover(input) {
                $('#budz-cover').hide();
                $('#cover_image_header').show();
                $('.jwc_frame').show();
                if (input.files && input.files[0]) {
                    var file = input.files[0];
                    var reader = new FileReader();
                    reader.onload = function () {
                        getOrientation(file, function (orientation) {
                            resetOrientation(reader.result, orientation, function (result) {
                                $('#cover_image').attr('src', result);
                                var width = $(window).width() * 65 / 100;
                                $('.crop_me').jWindowCrop({
                                    targetWidth: width,
                                    targetHeight: 330,
                                    loadingText: 'loading',
                                    onChange: function (result) {
                                        $('#x').val(result.cropX);
                                        $('#top').val($('#cover_image')[0].style.top);
                                        $('#y').val(result.cropY);
                                        $('#w').val(result.cropW);
                                        $('#h').val(result.cropH);

                                    }
                                });
                                $('#budz-cover').css('background-image', 'url(' + result + ')');
//                                $('#budz-cover').css('top', $('#top').val());
                            });
                        });
//                                            $('#budz-cover').css('background-image', 'url(' + e.target.result + ')');
                        //$('#showgroupimage').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(file);
                }
            }

            $("#addIcon").on('change', function () {
                $('#cover_image').addClass('crop_me');
                var $this = $(this), $clone = $this.clone();
                $this.removeAttr('id').after('<input name="cover" type="file" id="addIcon" onChange="changeIcon(this)">').appendTo($("#create_bud")).hide();
                readURLCover(this);
            });
            function changeIcon(ele) {
                var $this = $(ele), $clone = $this.clone();
                $this.removeAttr('id').after('<input name="cover" type="file" id="addIcon" onChange="changeIcon(this)">').appendTo($("#create_bud")).hide();
                readURLCover(ele);
            }
            //Toggle checkbox

            $('.add-bus-type label input').change(function () {
                var curr_val = $(this).attr('value');
                if (curr_val == 5) {
                    $(".add-bus-time").css('display', 'none');
                    $(".event-date-time").css('display', 'block');
                    $(".others_hide").show();
                    $(".others_hide_show").hide();
                } else {
                    $(".add-bus-time").css('display', 'block');
                    $(".event-date-time").css('display', 'none');
                    $(".others_hide").show();
                    $(".others_hide_show").hide();
                }

                if ((curr_val == 4) || (curr_val == 8) || (curr_val == 5)) {
                    $(".services").hide(200);
                    $(".others_hide").show();
                    $(".others_hide_show").hide();
                } else {
                    $(".services").show(200);
                    $(".others_hide").show();
                    $(".others_hide_show").hide();
                }
                if(curr_val == 9){
                    $(".add-bus-time").css('display', 'none');
                    $(".event-date-time").css('display', 'none');
                    $(".services").hide(200);
                    $(".event-date-time").css('display', 'none');
                    $(".others_hide").hide();
                    $(".others_hide_show").show();
                }
            });

            //Divs appender
            $(function () {
                $("#datepicker1, #datepicker2, #datepicker3").datepicker({
                    minDate: 0
                });
                $('input[name=type]').change(function () {
                    input_val = $(this).val();
                    found = false;
                    $('.type-med input[name=type]').each(function () {
                        if (input_val == $(this).val()) {
                            found = true;
                        }

                    })
                    if (!found) {
                        $('#iconCheck001').prop('checked', false);
                        $('.type-med .type-adj-bot').hide()
                    }

                    found = false;
                    $('.type-ent input[name=type]').each(function () {
                        if (input_val == $(this).val()) {
                            found = true;
                        }

                    })
                    if (!found) {
                        $('#iconCheck005').prop('checked', false);
                        $('.type-ent .type-adj-bot').hide()
                    }
                });
            });
            var count = 1;
            $('.add-time-btn').click(function (e) {
                e.preventDefault();
                count++;
                $('.pad-bor.event-date-time').append("<div class='add-bus-contact'><div class='add-bus-input t-row'><div class='cus-col'><input type='text' id='datepicker" + count + "' name='date" + count + "' class='hasDatepicker'></div><div class='cus-col date-time'><input name='from" + count + "' type='time'> <i class='to-time'>to</i><input name='to" + count + "' type='time'></div><a href='#' class='remove-time-btn'><i class='fa fa-minus-circle' aria-hidden='true'></i></a></div></div>");
                $(function () {
                    $("#datepicker1, #datepicker2, #datepicker3").datepicker();
                });
                var divs_count = $('.event-date-time .t-row').length;
                $('.div-counter').attr('value', divs_count);
            });
            $(document).on('click', '.remove-time-btn', function (e) {
                e.preventDefault();
                $(this).closest('.add-bus-contact').hide();
            });

            $('.add-bus-type label input').change(function () {
                business_type_id = $("input[name=type]:checked").val();
                ;

                var curr_val = $(this).attr('value');
                if ((curr_val == 2) || (curr_val == 6) || (curr_val == 7)) {
                    var zip_check = '<?= $zip_check; ?>';
                    if (zip_check == 0) {
                        selectPreviousType('<?= $budz->business_type_id; ?>');
                        $('#iconCheck001').prop('checked', false);
                        //                    $('.' + $(this).data('parentclass')).removeClass('active');
                        //                    $('.add-bus-type').removeClass('active');
                        window.alert('You are not in legal state for medical use.');
                        $(this).prop('checked', false);
                    } else {
                        $(".languages").css('display', 'block');
                        $(".office_policies").css('display', 'block');
                        $(".visit_requirements").css('display', 'block');
                    }
                    //                alert(state);
                    var address = document.getElementById('location');
                    if ($.inArray(state, legal_states) <= -1) {
                        //                    window.alert('not legal state');
                        //update autocomplete input field
                        address.value = '';
                    }
                } else {
                    $(".languages").css('display', 'none');
                    $(".office_policies").css('display', 'none');
                    $(".visit_requirements").css('display', 'none');
                }
            });

            //language toggle
            $('.lang-cols .onoff input[type="checkbox"]').change(function (event) {
                //            alert(this.checked);
                if (this.checked) {
                    $(this).attr('value', 'Yes');
                } else {
                    $(this).attr('value', 'no');
                }
            });
            var check_val = $('.lang-col .onoff input[type=checkbox]').attr('value');
            if (check_val == "No") {
                $('.onoff label span').css('background-position', '-96px 0');
            }
        </script>

        <script>
            function selectPreviousType(type_id) {
                if (type_id == 1) {
                    $("#iconCheck").prop("checked", true);
                } else if (type_id == 3) {
                    $("#iconCheck5").prop("checked", true);
                } else if (type_id == 4) {
                    $("#iconCheck6").prop("checked", true);
                    $("#iconCheck005").prop("checked", true);
                } else if (type_id == 8) {
                    $("#iconCheck7").prop("checked", true);
                    $("#iconCheck005").prop("checked", true);
                } else if (type_id == 5) {
                    $("#iconCheck8").prop("checked", true);
                }
            }

        </script>

        <script>
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
                                maxlength: ""

                            }
                        }
                    });
                });
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
                    });
                });
                $('.product-form').each(function () {
                    $(this).validate({
                        rules: {
                            product_name: {
                                required: true
                            },
                            strain_id: {
                                required: true
                            },
                            thc: {
                                required: true,
                                number: true
                            },
                            cbd: {
                                required: true
                            },
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
                            thc: {
                                required: "",
                                maxlength: ""
                            },
                            cbd: {
                                required: "",
                                maxlength: ""

                            },
                            weight1: {
                                required: ""
                            },
                            price1: {
                                required: "",
                                maxlength: ""
                            },
                            price2: {
                                maxlength: ""
                            },
                            price3: {
                                maxlength: ""
                            },
                            price4: {
                                maxlength: ""
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
                    });
                });

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
                    useFullStars: true,
                    initialRating: 1,
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
                $("#budz_review_image").attr("src", '');
//                $(".bus-pap img").hide();
                $("#budz_review_image").hide();
                $(".bus-pap").hide();
                var fileInput = document.getElementById('test');
                var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
                var image_type = fileInput.files[0].type;
                //            alert(image_type)
                if (image_type == "image/png" || image_type == "image/gif" || image_type == "image/jpeg" || image_type == "image/bmp" || image_type == "image/jpg") {
                    var file = fileInput.files[0];
                    var reader = new FileReader();
                    reader.onloadend = function () {
                        getOrientation(file, function (orientation) {
                            resetOrientation(reader.result, orientation, function (result) {
                                $(".bus-pap").show();
                                $(".bus-pap img").attr("src", result);
                                $(".bus-pap img").show();
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
                    $("#budz_review_image").attr("src", '');
                    $(".bus-pap").show();
                    $(".bus-pap i.fa-close").show();
                    $(".video-use").show();
//                    $(".bus-pap img").hide();
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
                $("#budz_review_image").attr("src", '');
            });
            $('#scroll-to-form').click(function () {
                $('html, body').animate({
                    scrollTop: $($(this).attr('href')).offset().top
                }, 500);
            });
            function saveForm() {
                 $('#cover_loader').css('display', 'flex');
                html2canvas(document.querySelector("#capture")).then(canvas => {
//                    document.body.appendChild(canvas);
                    dataURL = canvas.toDataURL();
                    $('#image_croped').val(dataURL);
                });
               
                hideShowData();

            }
            function hideShowData() {
                setTimeout(function () {
                    if ($('#image_croped').val()) {
                        $('#budz-cover').show();
                        $('#cover_image_header').hide();
                        $('.jwc_frame').hide();
                        $('#budz-cover').css('background-position', '0 ' + $('#top').val());
                    } else {
                        hideShowData();
                    }
                }, 1000);

            }
            function cancelForm() {
                var backgroud = '<?php echo getSubBanner($budz->banner) ?>';
<?php if ($budz->top) { ?>
                    var top = '<?php echo getSubBanner($budz->top) ?>';
                    $('#budz-cover').css('background-position', '0 ' + top);
<?php } ?>
                $('#budz-cover').show();
                $('#cover_image_header').hide();

                $('#budz-cover').css('background-image', 'url(' + backgroud + ')');
                $('.jwc_frame').hide();
            }

        </script>

        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCiDgdLD46NLVGAV3AKcEZt4DKTtCeprQE&libraries=geometry,places&callback=initMap">
        </script>
        <style type="text/css">
            body {
                font-family:sans-serif;
                font-size:13px;
            }
            #results {
                font-family:monospace;
                font-size:20px;
            }
            /* over ride defaults */
            .jwc_frame {
                border:5px solid black;
            } .jwc_controls {
                height:24px;
            } .jwc_zoom_in, .jwc_zoom_out {
                display:block; background-color:transparent;
                cursor:pointer;
                width:16px; height:16px;
                float:right; margin:4px 4px 0px 0px;
                text-decoration:none; text-align:center;
                font-size:16px; font-weight:bold; color:#000;
            } .jwc_zoom_in {
                /*background-image:url(../userassets/images/round_plus_16.png);*/
            } .jwc_zoom_out {
                /*background-image:url(../userassets/images/round_minus_16.png);*/
            } .jwc_zoom_in::after {
                content:"";
            } .jwc_zoom_out::after {
                content:"";
            }
            /* over ride defaults */
        </style>
        
         <script>
        $('#img-view-buss-edit').on('change', prepareUpload);
            function prepareUpload(event) {
                var input = document.getElementById('img-view-buss-edit');
                var filePath = input.value;
                var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.mp4|\.mkv|\.mov|\.flv|\.mpeg|\.webm|\.mpeg|\.avi|\.ts|\.ogv)$/i;
                if (!allowedExtensions.exec(filePath)) {
                    alert('Please upload file having extensions .jpeg/.jpg/.png/.gif  only.');
                    $('#img-view-buss-edit').val('');
                    return false;
                }
            }
            $("#img-view-buss-edit").change(function () {
                $("#video").attr("src", '');
                $(".video-use").hide();
                $("#budz_review_image").attr("style", "background-image:url('')");
                $("#budz_review_image").hide();
                $(".bus-pap").hide();
                var fileInput = document.getElementById('img-view-buss-edit');
                var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
                var image_type = fileInput.files[0].type;
                //            alert(image_type)
                if (image_type == "image/png" || image_type == "image/jpeg" || image_type == "image/gif" || image_type == "image/bmp" || image_type == "image/jpg") {
                    var file = fileInput.files[0];
                    var reader = new FileReader();
                    reader.onloadend = function () {
                        getOrientation(file, function (orientation) {
                            resetOrientation(reader.result, orientation, function (result) {
                                $(".bus-pap").show();
                                $(".bus-pap img").attr("src", result);
                                $(".bus-pap #budz_review_image").attr("style", "background-image:url('"+result+"')");
                                $(".bus-pap img").show();
                            });
                        });
                    };
                    reader.readAsDataURL(file);
                    $(".bus-pap-active").hide();
                    $("#video").attr("src", '');
                    $(".video-use").hide();
                    $(".bus-pap i.fa-close").show();

                } else if (fileInput.files[0].type == "video/mp4") {
                    $("#budz_review_image").attr("style", "background-image:url('')");
                    $(".bus-pap").show();
                    $(".bus-pap i.fa-close").show();
                    $(".video-use").show();
                    $("#budz_review_image").hide();
                    $(".video-use").attr("src", fileUrl);
                    var myVideo = document.getElementById("video");
                    myVideo.addEventListener("loadedmetadata", function ()
                    {
                        duration = (Math.round(myVideo.duration * 100) / 100);
                        if (duration >= 21) {
                            $('#erroralertmessage').html('Video is greater than 20 sec.');
                            $('#erroralert').show();
                            $("#video").attr("src", '');
                            $('#img-view-buss-edit').val('');
                            $(".bus-pap").hide();
                        } else {
                            $(".bus-pap-active").hide();
                        }
                    });
                }
            });

            $(".bus-pap i.fa-close").click(function () {
                $(".bus-pap").hide();
                $("#video").attr("src", '');
                $('#img-view-buss-edit').val('');
                $('#others_removed').val('1');
                $("#budz_review_image").attr("style", "background-image:url('')");
            });
        </script>
    </body>
</html>