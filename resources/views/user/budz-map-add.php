<!DOCTYPE htm>
<html lang="en">
    <link href="<?= asset('userassets/css/jWindowCrop.css') ?>" media="screen" rel="stylesheet" type="text/css" />
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
<!--                            <li class="li-icon"><a href="#"><i class="fa fa-angle-left"></i></a></li>
                            <li class="li-icon"><a href="#"><i class="fa fa-home"></i></a></li>-->
                            <li class="li-icon li-text"></li>
                            <li class="li-icon li-add">
                                <!--                                <label for="addIcon">
                                                                    <input name="cover" type="file" id="addIcon">
                                                                    <span><i class="fa fa-upload"></i></span>
                                                                </label>-->
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="padding-div">
                    <div class="new_container">
                        <form method="post" action="<?php echo asset('create-bud'); ?>" id="create_bud" enctype="multipart/form-data" autocomplete="off">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <input id="x" type="hidden" name="x" value="">
                            <input id="y" type="hidden" name="y" value="">
                            <input id="h" type="hidden" name="h" value="">
                            <input id="w" type="hidden" name="w" value="">
                            <input id="top" type="hidden" name="top" value="">
                            <input id="image_croped" type="hidden" name="image_croped" value="">
            <!--<div id="budz-cover" class="bud-add-map bud-add-edit" style="background-image: url('<php echo asset('userassets/images/buds-map-banner.jpg') ?>')">-->
                            <div id="budz-cover" class="bud-add-map bud-add-edit">
                                <div class="bud-add-edit-inner">
                                    <label for="add" style="cursor: pointer;">
                                        <figure class="map-info-logo">
                                            <div id="logosrc" class="image-adj-bud-add-edit" style="background-image:url('<?php echo asset('userassets/images/budz-adz-thumbnail.svg') ?>');"></div>
                                            <!--<img id="logosrc" src="<?php // echo asset('userassets/images/budz-adz-thumbnail.svg')    ?>" alt="logo">-->
                                            <div class="add-logo">
                                                <!--<label for="add">-->
                                                <input name="logo" type="file" id="add" accept="image/*"/>
                                                <span>Upload Logo</span>
                                                <!--</label>-->
                                            </div>
                                        </figure>
                                    </label>
                                    <article>
                                        <div class="art-top">
                                            <input value="<?php echo \Illuminate\Support\Facades\Input::old('title') ?>" maxlength="30" id="biz_title" required="" type="text" placeholder="Add Business/Event Name" name="title"/>
                                        </div>
                                        <div class="art-bot">
                                            <div class="tab-cell services">
                                                <label for="boxCheck">
                                                    <input name="organic" type="checkbox" id="boxCheck" />
                                                    <span></span>
                                                </label>
                                                <figure>
                                                    <img src="<?php echo asset('userassets/images/icon-plant.svg') ?>" alt="icon">
                                                    <figcaption>Organic</figcaption>
                                                </figure>
                                            </div>
                                            <div class="tab-cell services">
                                                <label for="boxCheck1">
                                                    <input name="deliver" type="checkbox" id="boxCheck1" />
                                                    <span></span>
                                                </label>
                                                <figure>
                                                    <img src="<?php echo asset('userassets/images/icon-van.svg') ?>" alt="icon">
                                                    <figcaption>We Deliver</figcaption>
                                                </figure>
                                            </div>
                                            <div class="cus-btn-pro others_hide chnge_cvr">
                                                <label for="addIcon">
                                                    <input name="cover" type="file" id="addIcon" accept="image/*"/>
                                                    <span><img src="<?php echo asset('userassets/images/gallery-black.png') ?>" alt="gallery icon"> Change Cover Photo</span>
                                                </label>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            </div>
                            <div id="cover_image_header" class="bud-add-map bud-add-edit" style="display: none">
                                <div id="capture"> <img class="" id="cover_image"  src=""></div>
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
                            <div class="bud-map-info-bot bud-field-add">
                                <div class="map-cus-tabs">
                                    <div class="tabbing border-top">
                                        <ul class="tabs list-none">
                                            <li class="active business_li"><a data-toggle="tab" href="#business" class="bg-icon">Business Info</a></li>
                                            <?php if (Session::has('id')) { ?>
                                                <li class="products_li"><a data-toggle="tab" href="#product" class="bg-icon">Product/Services</a></li>
                                                <li class="special_li"><a data-toggle="tab" href="#special" class="bg-icon">Specials</a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                    <div class="tab-content">
                                        <div id="business" class="tab-pane fade in active">
                                            <div class="">
                                                <?php if (Session::has('id')) { ?>
                                                    <input type="hidden" name="id" value="<?= Session::get('id') ?>">

                                                <?php } ?>
                                                <div class="left_content">
                                                      <div class="pad-bor pad-bor-nor">
                                                        <div class="add-map-area">
                                                            <h4>Adjust Pin Position</h4>
                                                            <div id="map" style="width: 100%; max-height: 300px; height: 300px"></div>
                                                            <!--<img style="width: 100%; max-height: 300px;" src="<?php echo asset('userassets/images/map-img.png') ?>" alt="" />-->
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
                                                                        <input checked="" required type="radio" id="iconCheck" name="type" value="1"/>
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
                                                                        <input type="radio" id="iconCheck001" name="type-med" value=""/>
                                                                        <i class="fa fa-check"></i>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                            <div class="type-adj-bot">
                                                                <div class="add-bus-type add-bus-inside">
                                                                    <div class="cus-col cus-col-icon">
                                                                        <label for="iconCheck2">
                                                                            <!--<input type="radio" id="iconCheck2" name="type" value="2" data-parentclass="type-med"/>-->
                                                                            <input type="radio" id="iconCheck2" name="type" value="2" data-parentclass="type-med" data-parentcheckid="iconCheck001" />
                                                                            <i class="fa fa-check"></i>
                                                                            <h4>Medical Practitioner</h4>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="add-bus-type add-bus-inside">
                                                                    <div class="cus-col cus-col-icon">
                                                                        <label for="iconCheck3">
                                                                            <!--<input type="radio" id="iconCheck3" name="type" value="6" data-parentclass="type-med"/>-->
                                                                            <input type="radio" id="iconCheck3" name="type" value="6" data-parentclass="type-med" data-parentcheckid="iconCheck001"/>
                                                                            <i class="fa fa-check"></i>
                                                                            <h4>Holistic Medical</h4>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="add-bus-type add-bus-inside">
                                                                    <div class="cus-col cus-col-icon">
                                                                        <label for="iconCheck4">
                                                                            <!--<input type="radio" id="iconCheck4" name="type" value="7" data-parentclass="type-med"/>-->
                                                                            <input type="radio" id="iconCheck4" name="type" value="7" data-parentclass="type-med" data-parentcheckid="iconCheck001"/>
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
                                                                        <input type="radio" id="iconCheck5" name="type" value="3"/>
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
                                                                        <input type="radio" id="iconCheck005" name="type-ent" value=""/>
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
                                                                            <input type="radio" id="iconCheck6" name="type" value="4" data-parentclass="type-ent" data-parentcheckid="iconCheck005"/>
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
                                                                            <input type="radio" id="iconCheck7" name="type" value="8" data-parentclass="type-ent" data-parentcheckid="iconCheck005"/>
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
                                                                        <input type="radio" id="iconCheck8" class="events-check" name="type" value="5"/>
                                                                        <i class="fa fa-check"></i>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <?php if (!Session::has('id')) { ?>
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
                                                                            <input type="radio" id="iconCheck9" class="" name="type" value="9"/>
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
                                                            <textarea  name="description" maxlength="500" placeholder="Add a Description" id="description" class="extra-txtarea-height"><?php echo \Illuminate\Support\Facades\Input::old('description') ?></textarea>
                                                        </div>
                                                    </div>
                                                        <div class="pad-bor pad-bor-nor others_hide">
                                                        <div class="add-bus-contact">
                                                            <h4>Business Links</h4>
                                                       <div class="budz_map_add_wrapper_social">
                                                              <div class="budz_add_social_icons" >
                                                                <div class="add-bus-input">
                                                                <div class="cus-cols">
                                                                    <input  value="<?php echo \Illuminate\Support\Facades\Input::old('web') ?>"  class="add-url wb-url" name="web" type="text" placeholder="Your Website Url" />
                                                                </div>
                                                            </div>
                                                            <div class="add-bus-input">
                                                                <div class="cus-cols">
                                                                    <input  value="<?php echo \Illuminate\Support\Facades\Input::old('fb') ?>"  name="fb" class="fb-url" type="text" placeholder="Facebook" />
                                                                </div>

                                                            </div> 
                                                          </div>
                                                          <div class="budz_add_social_icons" >
                                                         <div class="add-bus-input">
                                                                <div class="cus-cols">
                                                                    <input  value="<?php echo \Illuminate\Support\Facades\Input::old('twitter') ?>" name="twitter" class="tw-url" type="text" placeholder="Twitter" />
                                                                </div>
                                                            </div>
                                                            <div class="add-bus-input">
                                                                <div class="cus-cols">
                                                                    <input value="<?php echo \Illuminate\Support\Facades\Input::old('instagram') ?>"  name="instagram" class="ins-url" type="text" placeholder="Instagram" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                       </div>
                                                        </div>
                                                    </div>
                                               
                                                    <div class="office_policies" style="display:none;">
                                                        <div class="pad-bor pad-bor-nor">
                                                            <div class="bus-txt-area bus-txt-area-short">
                                                                <h4>Office policies &amp; Information</h4>
                                                                <textarea  name="office_policies" id="office-policies" maxlength="200" placeholder="Office policies &amp; Information" class="extra-txtarea-height"><?php echo \Illuminate\Support\Facades\Input::old('office_policies') ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="visit_requirements" style="display:none;">
                                                        <div class="pad-bor pad-bor-nor">
                                                            <div class="bus-txt-area bus-txt-area-short">
                                                                <h4>Pre-visit Requirements</h4>
                                                                <textarea name="visit_requirements" id="p-requirements" maxlength="200" placeholder="Pre-visit Requirements" ><?php echo \Illuminate\Support\Facades\Input::old('visit_requirements') ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="pad-bor pad-bor-nor others_hide_show" style="display: none">
                                                        <div class="other-budz-attach-img">
                                                            <div class="bus-upload">
                                                                <label for="img-view-buss">
                                                                    <input type="file" name="others_image" id="img-view-buss" accept="image/*"/>
                                                                    <!--<span>Post Review</span>-->

                                                                    <span class="res">
                                                                        Add An image 
                                                                        <span>(1 PHOTO.)</span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                            <div class="bus-pap rev-img-vid-set">
                                                                <figure style="background-image:url('<?php echo asset('userassets/images/img2.png') ?>');" id="budz_review_image" /></figure>
                                                                <video class="video-use" class="video" src="" id="video"></video>
                                                                <i class="fa fa-close"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                            <div class="pad-bor pad-bor-nor desk-show budz_submit_btn">
                                                        <div class="strain-green-input">
                                                            <input type="submit" class="btn-primary bus-submit" value="SUBMIT">
                                                        </div>

                                                        <?php
                                                        if (Session::has('success')) {
                                                            if (Session::get('success')) {
                                                                ?>  
                                                                <h5 class="hb_simple_error_smg hb_text_green" style="margin-top: 0px"> <i class="fa fa-check" style="margin-right: 3px"></i><?php echo Session::get('success'); ?></h5>

                                                                <?php
                                                            }
                                                        }
                                                        if (Session::has('error')) {
                                                            ?>  
                                                            <h5 class="hb_simple_error_smg"> <i class="fa fa-times" style="margin:0 3px 0 0"></i> <?php echo Session::get('error'); ?></h5>

                                                            <?php
                                                        }if ($errors->all()) {
                                                            $errors = $errors->all();
                                                            foreach ($errors as $error) {
                                                                ?>
                                                                <h5 class="hb_simple_error_smg"> <i class="fa fa-times" style="margin:0 3px 0 0"></i><?php echo $error; ?></h5>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
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
                                                                    <input value="<?php echo \Illuminate\Support\Facades\Input::old('phone') ?>" name="phone" type="tel" placeholder="Phone Number" class="phone_us" autocomplete="off"/>
                                                                </div>
                                                            </div>
                                                            <div class="add-bus-input">
                                                                <div class="cus-cols b-m-a-mail">
                                                                    <input value="<?php echo \Illuminate\Support\Facades\Input::old('email') ?>"  name="email" type="email" placeholder="Email" autocomplete="off"/>
                                                                </div>
                                                            </div>
                                                            <div class="add-bus-input">
                                                                <div class="cus-cols b-m-a-zip">
                                                                    <input value="<?php echo \Illuminate\Support\Facades\Input::old('zip_code') ?>"  name="zip_code" type="text" placeholder="Zip Code" autocomplete="off"/>
                                                                </div>
                                                            </div>
                                                            <div class="bus-txt-area add-bus-input">
                                                                <div class="cus-cols b-m-a-loc">
                                                                    <!--<textarea readonly=""  name="location" id="location" maxlength="200" ><?php echo $city . ', ' . $region_code . ' ' . $zip_code . ', ' . $country_code ?></textarea>-->
                                                                    <input type="text" id="location" name="location" maxlength="200" />
                                                                    <!--<input type="text" id="autocomplete" name="location" maxlength="200" />-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                  
                                                    <div class="pad-bor pad-bor-nor">
                                                        <div class="add-bus-time">
                                                            <h4>Hours of Operation</h4>
                                                            <div class="add-bus-time-inner <?php
                                                            $showday = 'Mon';
                                                            $day = date("D");
                                                            if ($day == 'Mon') {
                                                                $showday = 'Mon';
                                                                ?> active <?php } ?>">
                                                                <div class="cus-col cus-time">
                                                                    <span><?php echo $showday; ?>:</span>
                                                                </div>
                                                                <div class="cus-col cus-label">
                                                                    <label for="hoursCheck">
                                                                        <input type="checkbox" id="hoursCheck" onchange="disableselect(this, 'mon')"/>
                                                                        <span class="tick-cross"></span>
<!--                                                                        <i class="fa fa-check"></i>
                                                                        <i class="fa fa-times"></i>-->
                                                                        <div class="cus-select">
                                                                            <select name="mon_start" class="mon">
                                                                                <?php foreach ($slots as $slot) { ?>
                                                                                    <option  <?php if ($slot == '9:00 AM') { ?> selected="" <?php } ?>    value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                            <span>-</span>
                                                                            <select name="mon_end" class="mon">
                                                                                <?php foreach ($slots as $slot) { ?>
                                                                                    <option <?php if ($slot == '5:00 PM') { ?> selected="" <?php } ?> value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="cus-closed">
                                                                            <span>Closed</span>
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div class="add-bus-time-inner <?php
                                                            $showday = 'Tue';
                                                            if ($day == 'Tue') {
                                                                $showday = 'Today';
                                                                ?> active <?php } ?>">
                                                                <div class="cus-col cus-time">
                                                                    <span><?php echo $showday; ?>:</span>
                                                                </div>
                                                                <div class="cus-col cus-label">
                                                                    <label for="hoursCheck1">
                                                                        <input type="checkbox" id="hoursCheck1" onchange="disableselect(this, 'tue')"/>
                                                                        <span class="tick-cross"></span>
                                                                        <!--<i class="fa fa-check"></i>-->
                                                                        <!--<i class="fa fa-times"></i>-->
                                                                        <div class="cus-select">
                                                                            <select name="tue_start" class="tue">
                                                                                <?php foreach ($slots as $slot) { ?>
                                                                                    <option  <?php if ($slot == '9:00 AM') { ?> selected="" <?php } ?>    value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                            <span>-</span>
                                                                            <select name="tue_end" class="tue">
                                                                                <?php foreach ($slots as $slot) { ?>
                                                                                    <option  <?php if ($slot == '5:00 PM') { ?> selected="" <?php } ?>  value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="cus-closed">
                                                                            <span>Closed</span>
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="add-bus-time-inner  <?php
                                                            $showday = 'Web';
                                                            if ($day == 'Web') {
                                                                $showday = 'Today';
                                                                ?> active <?php } ?>">
                                                                <div class="cus-col cus-time">
                                                                    <span><?php echo $showday; ?>:</span>
                                                                </div>
                                                                <div class="cus-col cus-label">
                                                                    <label for="hoursCheck2">
                                                                        <input type="checkbox" id="hoursCheck2" onchange="disableselect(this, 'wed')"/>
                                                                        <span class="tick-cross"></span>
                                                                        <!--<i class="fa fa-check"></i>-->
                                                                        <!--<i class="fa fa-times"></i>-->
                                                                        <div class="cus-select">
                                                                            <select name="wed_start" class="wed">
                                                                                <?php foreach ($slots as $slot) { ?>
                                                                                    <option  <?php if ($slot == '9:00 AM') { ?> selected="" <?php } ?>    value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                            <span>-</span>
                                                                            <select name="wed_end" class="wed">
                                                                                <?php foreach ($slots as $slot) { ?>
                                                                                    <option <?php if ($slot == '5:00 PM') { ?> selected="" <?php } ?>  value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="cus-closed">
                                                                            <span>Closed</span>
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="add-bus-time-inner  <?php
                                                            $showday = 'Thu';
                                                            if ($day == 'Thu') {
                                                                $showday = 'Today';
                                                                ?> active <?php } ?>">
                                                                <div class="cus-col cus-time">
                                                                    <span><?php echo $showday; ?>:</span>
                                                                </div>
                                                                <div class="cus-col cus-label">
                                                                    <label for="hoursCheck3">
                                                                        <input type="checkbox" id="hoursCheck3" onchange="disableselect(this, 'thu')"/>
                                                                        <span class="tick-cross"></span>
                                                                        <!--<i class="fa fa-check"></i>-->
                                                                        <!--<i class="fa fa-times"></i>-->
                                                                        <div class="cus-select">
                                                                            <select name="thu_start" class="thu">
                                                                                <?php foreach ($slots as $slot) { ?>
                                                                                    <option  <?php if ($slot == '9:00 AM') { ?> selected="" <?php } ?>    value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                            <span>-</span>
                                                                            <select name="thu_end" class="thu">
                                                                                <?php foreach ($slots as $slot) { ?>
                                                                                    <option  <?php if ($slot == '5:00 PM') { ?> selected="" <?php } ?> value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="cus-closed">
                                                                            <span>Closed</span>
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="add-bus-time-inner  <?php
                                                            $showday = 'Fri';
                                                            if ($day == 'Fri') {
                                                                $showday = 'Today';
                                                                ?> active <?php } ?>">
                                                                <div class="cus-col cus-time">
                                                                    <span><?php echo $showday; ?>:</span>
                                                                </div>
                                                                <div class="cus-col cus-label">
                                                                    <label for="hoursCheck4" >
                                                                        <input type="checkbox" id="hoursCheck4" onchange="disableselect(this, 'fri')"/>
                                                                        <span class="tick-cross"></span>
                                                                        <!--<i class="fa fa-check"></i>-->
                                                                        <!--<i class="fa fa-times"></i>-->
                                                                        <div class="cus-select">
                                                                            <select name="fri_start" class="fri" >
                                                                                <?php foreach ($slots as $slot) { ?>
                                                                                    <option  <?php if ($slot == '9:00 AM') { ?> selected="" <?php } ?>   value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                                <?php } ?>
                                                                            </select>

                                                                            <span>-</span>
                                                                            <select name="fri_end" class="fri">
                                                                                <?php foreach ($slots as $slot) { ?>
                                                                                    <option <?php if ($slot == '5:00 PM') { ?> selected="" <?php } ?> value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="cus-closed">
                                                                            <span>Closed</span>
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="add-bus-time-inner  <?php
                                                            $showday = 'Sat';
                                                            if ($day == 'Sat') {
                                                                $showday = 'Today';
                                                                ?> active <?php } ?>">
                                                                <div class="cus-col cus-time">
                                                                    <span><?php echo $showday; ?>:</span>
                                                                </div>
                                                                <div class="cus-col cus-label">
                                                                    <label for="hoursCheck5">
                                                                        <input type="checkbox" id="hoursCheck5" onchange="disableselect(this, 'sat')" />
                                                                        <span class="tick-cross"></span>
                                                                        <!--<i class="fa fa-check"></i>-->
                                                                        <!--<i class="fa fa-times"></i>-->
                                                                        <div class="cus-select">
                                                                            <select name="sat_start" class="sat">
                                                                                <?php foreach ($slots as $slot) { ?>
                                                                                    <option  <?php if ($slot == '9:00 AM') { ?> selected="" <?php } ?>    value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                                <?php } ?>
                                                                            </select>

                                                                            <span>-</span>
                                                                            <select name="sat_end" class="sat">
                                                                                <?php foreach ($slots as $slot) { ?>
                                                                                    <option  <?php if ($slot == '5:00 PM') { ?> selected="" <?php } ?>  value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="cus-closed">
                                                                            <span>Closed</span>
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="add-bus-time-inner  <?php
                                                            $showday = 'Sun';
                                                            if ($day == 'Sun') {
                                                                $showday = 'Today';
                                                                ?> active <?php } ?>">
                                                                <div class="cus-col cus-time">
                                                                    <span><?php echo $showday; ?>:</span>
                                                                </div>
                                                                <div class="cus-col cus-label" >
                                                                    <label for="hoursCheck6">
                                                                        <input type="checkbox" id="hoursCheck6" onchange="disableselect(this, 'sun')"/>
                                                                        <span class="tick-cross"></span>
                                                                        <!--<i class="fa fa-check"></i>-->
                                                                        <!--<i class="fa fa-times"></i>-->
                                                                        <div class="cus-select">
                                                                            <select name="sun_start" class="sun">
                                                                                <?php foreach ($slots as $slot) { ?>
                                                                                    <option   <?php if ($slot == '9:00 AM') { ?> selected="" <?php } ?>   value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                            <span>-</span>
                                                                            <select name="sun_end" class="sun">
                                                                                <?php foreach ($slots as $slot) { ?>
                                                                                    <option  <?php if ($slot == '5:00 PM') { ?> selected="" <?php } ?>  value="<?= $slot; ?>"><?= $slot; ?></option>
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
                                                    <div class="pad-bor pad-bor-nor event-date-time" style="display:none;">
                                                        <div class="add-bus-contact">
                                                            <h4>Date / Time</h4>
                                                            <input type="text" class="hidden div-counter" name="event_count" value="1">
                                                            <div class="add-bus-input t-row">
                                                                <div class="cus-col">
                                                                    <input placeholder="Date" type="text" id="datepicker1" name="date1" format="dd/MM/yyyy" readonly="" required="">
                                                                    <span class="error" id="date_error" style="display:none;color: #a94442"> </span>
                                                                </div>
                                                                <div class="cus-col date-time">
                                                                    <input id="from_time" name="from1" type="time"> <i class="to-time">to</i>
                                                                    <input id="to_time" name="to1" type="time">
                                                                </div>
                                                                <!--<a href="#" class="add-time-btn"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="languages" style="display:none;">
                                                        <div class="pad-bor pad-bor-nor">
                                                            <div class="bus-txt-area bus-txt-area-short">
                                                                <div class="lang-cols">
                                                                    <h4>Languages</h4>
                                                                    <select id="tags" multiple="" placeholder="Edit Tags" name="langeages[]" class="chosen-select" tabindex="1">
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
                                                                            <input type="checkbox" value="Yes" id="onOff" name="insurance_accepted" checked="">
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php if (count($payment_methods) > 0) { ?>
                                                        <div class="pad-bor pad-bor-nor">
                                                            <div class="add-bus-contact others_hide">
                                                                <!--<h4>Select Payment Method</h4>-->
                                                                <h4>Select Payment Methods Offered</h4>
                                                                <div class="bus-pay pay-add-ck">
                                                                    <?php foreach ($payment_methods as $payment_method) { ?>
                                                                        <label>
                                                                            <input type="checkbox" name="payment_methods[]" value="<?= $payment_method->id ?>">
                                                                            <img src="<?php echo asset('public/images' . $payment_method->image) ?>" alt="<?= $payment_method->title ?>">
                                                                        </label>
                                                                    <?php } ?>
                                                                    <!--                                                                <label>
                                                                                                                                        <input type="checkbox" name="pay-ad-me" value="" >
                                                                                                                                        <img src="<?php echo asset('userassets/images/pay2.png') ?>" alt="icon">
                                                                                                                                    </label>
                                                                                                                                    <label>
                                                                                                                                        <input type="checkbox" name="pay-ad-me" value="" >
                                                                                                                                        <img src="<?php echo asset('userassets/images/pay3.png') ?>" alt="icon">
                                                                                                                                    </label>
                                                                                                                                    <label>
                                                                                                                                        <input type="checkbox" name="pay-ad-me" value="" >
                                                                                                                                        <img src="<?php echo asset('userassets/images/pay4.png') ?>" alt="icon">
                                                                                                                                    </label>
                                                                                                                                    <label>
                                                                                                                                        <input type="checkbox" name="pay-ad-me" value="" >
                                                                                                                                        <img src="<?php echo asset('userassets/images/pay5.png') ?>" alt="icon">
                                                                                                                                    </label>
                                                                                                                                    <label>
                                                                                                                                        <input type="checkbox" name="pay-ad-me" value="" >
                                                                                                                                        <img src="<?php echo asset('userassets/images/pay6.png') ?>" alt="icon">
                                                                                                                                    </label>-->
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
                                        </div>
                                        <input type="hidden" name="lat" value="<?= $latitude ?>" id="lat">
                                        <input type="hidden" name="lng" value="<?= $longitude ?>" id="lng">
                                        <div id="product" class="tab-pane fade">
                                            <div class="container"></div>
                                        </div>
                                        <div id="special" class="tab-pane fade">
                                            <div class="container"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="right_sidebars">
                        <?php include 'includes/rightsidebar.php'; ?>
                        <?php include 'includes/chat-rightsidebar.php'; ?>
                    </div>
                </div>
            </article>

        </div>

        <?php include('includes/footer-new.php'); ?>
        <div id="showsubscription" class="modal fade map-black-listing two-budzmap-pop chng-rev-pop" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="two-budzmap-cus-row">
                        <div class="map-black-free">
                            <!--<div class="modal-header">-->
                            <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
                            <!--      <button type="button" class="close" data-dismiss="modal"></button>-->
                            <!--                                <figure>
                                                                <img src="<?php // echo asset('userassets/images/news.svg')                       ?>" alt="image" />
                                                            </figure>-->
                            <!--</div>-->
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
                                <div class="btn-area">
                                    <a href="#subspopmonth" class="btn-popup">Subscribe Now</a>
                                    <div id="subspopmonth" class="popup subs">
                                        <div class="popup-holder">
                                            <div class="popup-area">
                                                <div class="text">
                                                    <header class="header">
                                                        <strong><img width="150" src="<?php echo asset('userassets/images/logo.svg') ?>" alt="Alert"><span id="erroralertmessage"></span></strong>
                                                        <p>Pay to buy premium subscription for your budz</p>
                                                    </header>
                                                    <div class="txt">
                                                        <form action="<?php echo asset('subscribe-user') ?>" method="POST" id="save_payment_month">
                                                            <p  class="payment-errors-month hb_simple_error_smg"  style="margin-top: 12px; display: none"></p>    
                                                            <div class="pays-sec-row">
                                                                <input value="" class="pays-sec-inp pays-sec-inp-email" type="email" placeholder="test@test.com" />
                                                            </div>
                                                            <div class="pays-sec-row">
                                                                <input data-stripe="number" value="" size="16" pattern="/^-?\d+\.?\d*$/" class="pays-sec-inp pays-sec-inp-card" type="number" onKeyPress="if (this.value.length == 16)
                                                                            return false;" name="" placeholder="**********3214" />
                                                            </div>
                                                            <div class="pays-sec-row">
                                                                <input  data-stripe="exp-month"  class="pays-sec-inp pays-sec-inp-date" type="text" name="" placeholder="Month" autocomplete="off" value="" onKeyPress="if (this.value.length == 2)
                                                                            return false;"/>
                                                                <input  data-stripe="exp-year" class="pays-sec-inp pays-sec-inp-date" type="text" name="" size="04" placeholder="Year" autocomplete="off" value="" onKeyPress="if (this.value.length == 4)
                                                                            return false;"/>
                                                                <input data-stripe="cvc" class="pays-sec-inp pays-sec-inp-code" size="4"  type="number" name="" placeholder="CVC" onKeyPress="if (this.value.length == 3)
                                                                            return false;"/>
                                                            </div>                                  
                                                            <input class="pays-sec-inp-submit cus-btn-paym" type="submit" value="PAY $29.95" />
                                                            <a href="javascript:void(0)" class="subs-go-back">Go back</a>
                                                            <a href="javascript:void(0)" class="btn-close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                                                            <input type="hidden" name="plan_type" value="1">    
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                <div class="btn-area green_btn">
                                    <!--<a href="#" class="map-bl-btn">Subscribe Now</a>-->
                                    <a href="#subspoptri" class="btn-popup">Subscribe Now</a>
                                    <div id="subspoptri" class="popup subs">
                                        <div class="popup-holder">
                                            <div class="popup-area">
                                                <div class="text">
                                                    <header class="header">
                                                        <strong><img width="150" src="<?php echo asset('userassets/images/logo.svg') ?>" alt="Alert"><span id="erroralertmessage"></span></strong>
                                                        <p>Pay to buy premium subscription for your budz</p>
                                                    </header>
                                                    <div class="txt">
                                                        <form action="<?php echo asset('subscribe-user') ?>" method="POST" id="save_payment_tri">
                                                            <p  class="payment-errors-tri hb_simple_error_smg"  style="margin-top: 12px; display: none"></p>    
                                                            <div class="pays-sec-row">
                                                                <input value="" class="pays-sec-inp pays-sec-inp-email" type="email" placeholder="test@test.com" />
                                                            </div>
                                                            <div class="pays-sec-row">
                                                                <input data-stripe="number" value="" size="16" pattern="/^-?\d+\.?\d*$/" class="pays-sec-inp pays-sec-inp-card" type="number" onKeyPress="if (this.value.length == 16)
                                                                            return false;" name="" placeholder="**********3214" />
                                                            </div>
                                                            <div class="pays-sec-row">
                                                                <input  data-stripe="exp-month"  class="pays-sec-inp pays-sec-inp-date" type="text" name="" placeholder="Month" autocomplete="off" value="" onKeyPress="if (this.value.length == 2)
                                                                            return false;"/>
                                                                <input  data-stripe="exp-year" class="pays-sec-inp pays-sec-inp-date" type="text" name="" size="04" placeholder="Year" autocomplete="off" value="" onKeyPress="if (this.value.length == 4)
                                                                            return false;"/>
                                                                <input data-stripe="cvc" class="pays-sec-inp pays-sec-inp-code" size="4"  type="number" name="" placeholder="CVC" onKeyPress="if (this.value.length == 3)
                                                                            return false;"/>
                                                            </div>                                  
                                                            <input class="pays-sec-inp-submit cus-btn-paym" type="submit" value="PAY $59.85" />
                                                            <a href="javascript:void(0)" class="subs-go-back">Go back</a>
                                                            <a href="javascript:void(0)" class="btn-close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                                                            <input type="hidden" name="plan_type" value="2">    
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                <div class="btn-area">
                                    <a href="#subspopannully" class="btn-popup">Subscribe Now</a>
                                    <div id="subspopannully" class="popup subs">
                                        <div class="popup-holder">
                                            <div class="popup-area">
                                                <div class="text">
                                                    <header class="header">
                                                        <strong><img width="150" src="<?php echo asset('userassets/images/logo.svg') ?>" alt="Alert"><span id="erroralertmessage"></span></strong>
                                                        <p>Pay to buy premium subscription for your budz</p>
                                                    </header>
                                                    <div class="txt">
                                                        <form action="<?php echo asset('subscribe-user') ?>" method="POST" id="save_payment_annully">
                                                            <p  class="payment-errors-annully hb_simple_error_smg"  style="margin-top: 12px; display: none"></p>    
                                                            <div class="pays-sec-row">
                                                                <input value="" class="pays-sec-inp pays-sec-inp-email" type="email" placeholder="test@test.com" />
                                                            </div>
                                                            <div class="pays-sec-row">
                                                                <input data-stripe="number" value="" size="16" pattern="/^-?\d+\.?\d*$/" class="pays-sec-inp pays-sec-inp-card" type="number" onKeyPress="if (this.value.length == 16)
                                                                            return false;" name="" placeholder="**********3214" />
                                                            </div>
                                                            <div class="pays-sec-row">
                                                                <input  data-stripe="exp-month"  class="pays-sec-inp pays-sec-inp-date" type="text" name="" placeholder="Month" autocomplete="off" value="" onKeyPress="if (this.value.length == 2)
                                                                            return false;"/>
                                                                <input  data-stripe="exp-year" class="pays-sec-inp pays-sec-inp-date" type="text" name="" size="04" placeholder="Year" autocomplete="off" value="" onKeyPress="if (this.value.length == 4)
                                                                            return false;"/>
                                                                <input data-stripe="cvc" class="pays-sec-inp pays-sec-inp-code" size="4"  type="number" name="" placeholder="CVC" onKeyPress="if (this.value.length == 3)
                                                                            return false;"/>
                                                            </div>                                  
                                                            <input class="pays-sec-inp-submit cus-btn-paym" type="submit" value="PAY $191.4" />
                                                            <a href="javascript:void(0)" class="subs-go-back">Go back</a>
                                                            <a href="javascript:void(0)" class="btn-close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                                                            <input type="hidden" name="plan_type" value="3">    
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body learn-det">
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

        <?php /*    <div id="showsubscription" class="modal fade map-black-listing" role="dialog" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog">
          <div class="modal-content">
          <div class="modal-header">
          <figure>
          <img src="<?php echo asset('userassets/images/news.svg') ?>" alt="image" />
          </figure>
          </div>
          <div class="modal-body">
          <?php if (Session::has('error')) { ?>
          <h5> <?php echo Session::get('error') ?></h5>
          <?php } ?>
          <h2 class="modal-title">Budz Map Listing Saved</h2>
          <p>Your free subscription includes:</p>
          <ul>
          <li>Business/Event Name &amp; Short Description</li>
          <li>1 Business Cover Photo &amp; Logo</li>
          <li>Location, Contact Info &amp; Hours of Operation</li>
          <li>User Reviews</li>
          </ul>
          <div class="btn-area">
          <a href="#" data-dismiss="modal" class="map-bl-btn">Continue with a free listing</a>
          </div>
          <hr>
          <h2>Premium Budz Map Listing</h2>
          <p>Unlock additional features with a paid subscription</p>
          <div class="btn-area">
          <a href="#" class="map-bl-btn" data-toggle="modal" data-target="#addSubscription">Learn More</a>
          </div>
          </div>
          <!--<button type="button" class="close custom-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times-circle-o" aria-hidden="true"></i></span></button>-->
          </div>
          </div>
          </div>
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
          </div> */ ?>



        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.13/jquery.mask.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>
        <script type="text/javascript" src="<?= asset('userassets/js/jquery.jWindowCrop.js') ?>"></script>
        <?php
        $counter = Session::get('counter');
        if ($counter == 1) {
            Session::put('counter', 2);
            ?>
            <script>
                                                                    window.onbeforeunload = function () {
                                                                        return "Budz Map is created Empty. Data might lose you can update that from My budz map section";
                                                                    };
            </script>
        <?php } elseif (Session::has('error')) {
            
        } else {
            ?>
            <script>
                $(document).ready(function () {
                    $('#showsubscription').modal('show');
                });
            </script>

            <?php
        }
        if ($current_session) {
            $lat = $current_session->lat;
            $lng = $current_session->lng;
        } else {
            $lat = '';
            $lng = '';
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
        <script>
            state = '';
            business_type_id = '';
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

                //get current Lat, Lng
                navigator.geolocation.getCurrentPosition(
                        function (position) { // success cb
                            defaultLatLong = {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude
                            };
                            //set lat, lng in input type hidden field
                            updateInputFieldLatLng(defaultLatLong.lat, defaultLatLong.lng);
                        },
                        function () { // fail cb
                        }
                );
                defaultLatLong = {
                    lat: 40.7127753,
                    lng: -74.0059728
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
                                    
                                    if ($.inArray(state, legal_states) > -1) {
                                        $('#erroralertmessage').html("You can't create this type of business in your area.");
                                        $('#erroralert').show();
                                        //update autocomplete input field
                                        address = '';
                                    }
                                }
                                input.value = address;
                            }
                    );
                    /*****/
                    var autocomplete = new google.maps.places.Autocomplete(
                            /** @type {!HTMLInputElement} */(document.getElementById('location')),
                            {types: ['geocode']});
                    //                var autocomplete = new google.maps.places.Autocomplete(input, options);

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
                                        if ($.inArray(state, legal_states) > -1) {
                                            $('#erroralertmessage').html("You can't create this type of business in your area.");
                                            $('#erroralert').show();
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
                                    if (business_type_id == 2 || business_type_id == 6 || business_type_id == 7) {
                                        if ($.inArray(state, legal_states) > -1) {
                                            $('#erroralertmessage').html("You can't create this type of business in your area.");
                                            $('#erroralert').show();
                                            //update autocomplete input field
                                            input.value = '';
                                        }
                                    }

                                    //update autocomplete input field
                                    //                                input.value = results[0].formatted_address;
                                    //                                if($.inArray(state, legal_states) <= -1){
                                    //                                    window.alert('not legal state');
                                    //                                    //update autocomplete input field
                                    //                                    input.value = '';
                                    //                                }else{
                                    //                                    window.alert('legal state');
                                    //                                }

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
            $(".learn_btn").on('click', function () {
                $('#learn_more_pop').modal('show');
            });
            $(document).ready(function () {
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
                //            $('.caret-down').click(function () {
                //                $().toggle();
                //            });
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
                            required: true,
                            remote: "<?= asset('check_budz_title') ?>"
                        },
                        description: {
                            required: true
                        },
                        email: {
                            required: true,
                            email: true
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
                    messages: {
                        title: {
                            required: "",
                            remote: "Title already taken"
                        },
                        email: {
                            required: "",
                            email: ""
                        },
                        description: {
                            required: ""
                        },
                        location: {
                            required: ""
                        },
                        phone: {
                            required: ""
                        },
                        zip_code: {
                            required: "",
                            zipcode: ""
                        },
                        from1: {
                            required: "",
                            timeLessThan: ""
                        }
                    },
//                    errorPlacement: function (error, element) {
//                        return false;
//                    },
                });
                $('.phone_us').mask('(000) 000-0000');
                $('.bus-submit').click(function (e) {
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
                            $(".chosen-choices").css({"border-color": "gray",
                                "border-width": "1px",
                                "border-style": "solid"});
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
                            //                            alert(orientation);
                            resetOrientation(reader.result, orientation, function (result) {
                                $('#logosrc').css('background-image', 'url(' + result + ')');
                            });
                        });
                    }

                    reader.readAsDataURL(file);
                }
            }

            $("#add").change(function () {
                readURL(this);
            });
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
                            //                            alert(orientation);
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
                        //                    $('#budz-cover').css('background-image', 'url(' + e.target.result + ')');
                        //$('#showgroupimage').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(file);
                }
            }

            $("#addIcon").change(function () {
                $('#cover_image').addClass('crop_me');
                readURLCover(this);
            });
            //Toggle checkbox

            $('.add-bus-type label input').change(function () {

                business_type_id = $(this).attr('value');
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
                } else {
                    $(".others_hide").show();
                    $(".services").show(200);
                    $(".others_hide_show").hide();
                }
                if (curr_val == 9) {
                    $(".add-bus-time").css('display', 'none');
                    $(".event-date-time").css('display', 'none');
                    $(".services").hide(200);
                    $(".event-date-time").css('display', 'none');
                    $(".others_hide").hide();
                    $(".others_hide_show").show();
                }
            });
            $('.add-bus-type label input').change(function () {
                var curr_val = $(this).attr('value');
                if ((curr_val == 2) || (curr_val == 6) || (curr_val == 7)) {

                    var zip_check = '<?= $zip_check; ?>';
                    if (zip_check == 0) {
                        $("#iconCheck").prop("checked", true);
                        $('#iconCheck001').prop('checked', false);
                        //                    $('.' + $(this).data('parentclass')).removeClass('active');
                        //                    $('.add-bus-type').removeClass('active');
                        //                    window.alert('You are not in legal state fo medical use.');
                        $('#erroralertmessage').html('You are not in legal state of medical use.');
                        $('#erroralert').show();
                        $(this).prop('checked', false);
                    } else {
                        $(".languages").css('display', 'block');
                        $(".office_policies").css('display', 'block');
                        $(".visit_requirements").css('display', 'block');
                    }
                    var address = document.getElementById('location');
                    if ($.inArray(state, legal_states) <= -1) {
                        //                    $('#erroralertmessage').html('not legal state');
                        //                                        $('#erroralert').show();
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
            //Divs appender
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
                $(this).closest('.add-bus-contact').remove();
                var divs_count = $('.event-date-time .t-row').length;
                $('.div-counter').attr('value', divs_count);
            });
            //Divs appender ends
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
                        $('.type-ent .type-adj-bot').hide();
                    }
                });
            });
            $('.lang-cols .onoff input[type="checkbox"]').change(function (event) {
                //            alert(this.checked);
                if (this.checked) {
                    $(this).attr('value', 'Yes');
                } else {
                    $(this).attr('value', 'no');
                }
            });
            $('#create_bud').submit(function () {
                description = $('#description').val();
                title = $('#biz_title').val();
                if (description && title) {
                    window.onbeforeunload = null;
                }
            });
        </script>
        <script>
            //        var geocoder;
            //        function initMap() {
            //
            //            geocoder = new google.maps.Geocoder();
            //            var lat = <?= $latitude ?>;
            //            var lng = <?= $longitude ?>;
            //            var map = new google.maps.Map(document.getElementById('map'), {
            //                zoom: 13,
            //                center: {lat: lat, lng: lng}
            //            });
            //
            //            marker = new google.maps.Marker({
            //                map: map,
            //                draggable: true,
            //                animation: google.maps.Animation.DROP,
            //                position: {lat: lat, lng: lng}
            //            });
            //            marker.addListener('click', toggleBounce);
            //            google.maps.event.addListener(
            //                    marker,
            //                    'dragend',
            //                    function () {
            //                        $('#lat').val(marker.getPosition().lat());
            //                        $('#lng').val(marker.getPosition().lng());
            //                        geocodePosition(marker.getPosition());
            //                    }
            //            );
            //        }
            //
            //        function toggleBounce() {
            //            if (marker.getAnimation() !== null) {
            //                marker.setAnimation(null);
            //            } else {
            //                marker.setAnimation(google.maps.Animation.BOUNCE);
            //            }
            //        }
            //        function geocodePosition(pos) {
            //            geocoder.geocode({
            //                latLng: pos
            //            }, function (responses) {
            //                if (responses && responses.length > 0) {
            //                    $('#location').val(responses[0].formatted_address);
            //                } else {
            //                    $('#location').val('Cannot determine address at this location.');
            //                }
            //            });
            //        }

        </script>
        <!--<script src="https://maps.googleapis.com/maps/api/js?libraries=geometry,places&ext=.js"></script>-->
        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCiDgdLD46NLVGAV3AKcEZt4DKTtCeprQE&libraries=geometry,places&callback=initMap">
        </script>

        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
        <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
        <script>
            Stripe.setPublishableKey('<?= env('STRIPE_KEY') ?>');
            jQuery(function ($) {
                $('#save_payment_annully').submit(function (event) {
                    var $form = $(this);

                    // Disable the submit button to prevent repeated clicks
                    $form.find('button').prop('disabled', true);

                    Stripe.card.createToken($form, stripeResponseHandler);

                    // Prevent the form from submitting with the default action
                    return false;
                });
                $('#save_payment_tri').submit(function (event) {
                    var $form = $(this);

                    // Disable the submit button to prevent repeated clicks
                    $form.find('button').prop('disabled', true);

                    Stripe.card.createToken($form, stripeResponseHandlerTri);

                    // Prevent the form from submitting with the default action
                    return false;
                });
                $('#save_payment_month').submit(function (event) {
                    var $form = $(this);

                    // Disable the submit button to prevent repeated clicks
                    $form.find('button').prop('disabled', true);

                    Stripe.card.createToken($form, stripeResponseHandlerMonth);

                    // Prevent the form from submitting with the default action
                    return false;
                });
            });
            function stripeResponseHandler(status, response) {
                var $form = $('#save_payment_annully');

                if (response.error) {
                    // Show the errors on the form
                    $form.find('.payment-errors-annully').show().text(response.error.message);
                    $form.find('button').prop('disabled', false);
                } else {
                    // response contains id and card, which contains additional card details
                    var token = response.id;
                    // Insert the token into the form so it gets submitted to the server
                    $form.append($('<input type="hidden" name="stripeToken" />').val(token));

                    // and submit+
                    $('#subspopannully').hide();
                    $form.get(0).submit();
                }
            }
            function stripeResponseHandlerTri(status, response) {
                var $form = $('#save_payment_tri');

                if (response.error) {
                    // Show the errors on the form
                    $form.find('.payment-errors-tri').show().text(response.error.message);
                    $form.find('button').prop('disabled', false);
                } else {
                    // response contains id and card, which contains additional card details
                    var token = response.id;
                    // Insert the token into the form so it gets submitted to the server
                    $form.append($('<input type="hidden" name="stripeToken" />').val(token));

                    // and submit+
                    $('#subspoptri').hide();
                    $form.get(0).submit();
                }
            }
            function stripeResponseHandlerMonth(status, response) {
                var $form = $('#save_payment_month');

                if (response.error) {
                    // Show the errors on the form
                    $form.find('.payment-errors-month').show().text(response.error.message);
                    $form.find('button').prop('disabled', false);
                } else {
                    // response contains id and card, which contains additional card details
                    var token = response.id;
                    // Insert the token into the form so it gets submitted to the server
                    $form.append($('<input type="hidden" name="stripeToken" />').val(token));

                    // and submit+
                    $('#subspopmonth').hide();
                    $form.get(0).submit();
                }
            }
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
                var backgroud = 'none';
                $('#budz-cover').show();
                $('#cover_image_header').hide();
                $('#budz-cover').css('background-image', 'url(' + backgroud + ')');
                $('.jwc_frame').hide();
            }
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

        <!--other option added in buss-->

        <script>
            $('#img-view-buss').on('change', prepareUpload);
            function prepareUpload(event) {
                var input = document.getElementById('img-view-buss');
                var filePath = input.value;
                var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.mp4|\.mkv|\.mov|\.flv|\.mpeg|\.webm|\.mpeg|\.avi|\.ts|\.ogv)$/i;
                if (!allowedExtensions.exec(filePath)) {
                    alert('Please upload file having extensions .jpeg/.jpg/.png/.gif/.mp4  only.');
                    $('#img-view-buss').val('');
                    return false;
                }
            }
            $("#img-view-buss").change(function () {
                $("#video").attr("src", '');
                $(".video-use").hide();
                $("#budz_review_image").attr("style", "background-image:url('')");
                $("#budz_review_image").hide();
                $(".bus-pap").hide();
                var fileInput = document.getElementById('img-view-buss');
                var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
                var image_type = fileInput.files[0].type;
                //            alert(image_type)
                if (image_type == "image/png" || image_type == "image/jpeg" || image_type == "image/gif" || image_type == "image/bmp" || image_type == "image/jpg") {
                    var file = fileInput.files[0];
                    var reader = new FileReader();
                    reader.onloadend = function () {
                        getOrientation(file, function (orientation) {
//                            alert(orientation);
                            resetOrientation(reader.result, orientation, function (result) {
                                $(".bus-pap").show();
                                $(".bus-pap img").attr("src", result);
                                $(".bus-pap #budz_review_image").attr("style", "background-image:url('" + result + "')");
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
                            $('#img-view-buss').val('');
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
                $('#img-view-buss').val('');
                $("#budz_review_image").attr("style", "background-image:url('')");
            });
        </script>
    </body>
</html>