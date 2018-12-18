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
                    <div class="head-map-info head-map-gallery">
                        <ul class="list-none">
                            <li class="li-icon li-text"></li>
                            <li class="li-icon li-add">
                                <label for="addIcon">
                                    <input name="cover" type="file" id="addIcon" />
                                    <span><i class="fa fa-upload"></i></span>
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
                <form method="post" action="<?php echo asset('create-bud'); ?>" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div id="budz-cover" class="bud-add-map" style="background-image: url('<?php echo getSubBanner($budz->banner, '') ?>')">
                        <figure class="map-info-logo">
                            <img id="logosrc" src="<?php echo getSubImage($budz->logo, '') ?>" alt="logo">
                            <div class="add-logo">
                                <label for="add">
                                    <input name="logo" type="file" id="add" />
                                    <span>Add your Logo</span>
                                </label>
                            </div>
                        </figure>
                        <article>
                            <div class="art-top">
                                <input required="" type="text" placeholder="Add Business/Event Name" name="title" value="<?= $budz->title ?>"/>
                            </div>
                            <div class="art-bot">
                                <div class="tab-cell">
                                    <label for="boxCheck">
                                        <input name="organic" type="checkbox" id="boxCheck" <?php if ($budz->is_organic) { ?> checked="" <?php } ?>/>
                                        <span></span>
                                    </label>
                                    <figure>
                                        <figcaption>Organic</figcaption>
                                        <img src="<?php echo asset('userassets/images/icon-plant.svg') ?>" alt="icon">
                                    </figure>
                                </div>
                                <div class="tab-cell">
                                    <label for="boxCheck1">
                                        <input name="deliver" type="checkbox" id="boxCheck1" <?php if ($budz->is_delivery) { ?> checked="" <?php } ?>/>
                                        <span></span>
                                    </label>
                                    <figure>
                                        <figcaption>We Deliver</figcaption>
                                        <img src="<?php echo asset('userassets/images/icon-van.svg') ?>" alt="icon">
                                    </figure>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="bud-map-info-bot">
                        <div class="map-cus-tabs">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#business" class="bg-icon">Business Info</a></li>
                                <li><a data-toggle="tab" href="#product" class="bg-icon">Product/Services</a></li>
                                <li><a data-toggle="tab" href="#special" class="bg-icon">Specials</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="business" class="tab-pane fade in active">
                                    <div class="container">
                                        <input type="hidden" name="id" value="<?= $budz->id ?>">
                                        <?php if ($errors->all()) {
                                            $errors = $errors->all();
                                            foreach ($errors as $error) { ?>
                                                <h5 class="alert alert-danger"><?php echo $error; ?></h5>
                                            <?php } } ?>
                                        <div class="float-clear">
                                            <div class="pad-bor pad-bor-nor">
                                                <h4>Choose Type</h4>
                                            </div>
                                            <div class="pad-bor pad-bor-nor">
                                                <div class="add-bus-type">
                                                    <div class="cus-col cus-col-img">
                                                        <figure>
                                                            <img src="<?php echo asset('userassets/images/Dispensary.svg') ?>" alt="icon" />
                                                        </figure>
                                                    </div>
                                                    <div class="cus-col cus-col-text">
                                                        <h4>Dispensary</h4>
                                                    </div>
                                                    <div class="cus-col cus-col-icon">
                                                        <label for="iconCheck">
                                                            <input required type="radio" id="iconCheck" name="type" value="1" <?php if ($budz->business_type_id == 1) { ?> checked="" <?php } ?>/>
                                                            <i class="fa fa-check"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pad-bor pad-bor-nor">
                                                <div class="add-bus-type">
                                                    <div class="cus-col cus-col-img">
                                                        <figure>
                                                            <img src="<?php echo asset('userassets/images/doctor.png') ?>" alt="icon" />
                                                        </figure>
                                                    </div>
                                                    <div class="cus-col cus-col-text">
                                                        <h4>Medical</h4>
                                                    </div>
                                                </div>
                                                <div class="add-bus-type add-bus-inside">
                                                    <div class="cus-col cus-col-text">
                                                        <h4>Medical Practitioner</h4>
                                                    </div>
                                                    <div class="cus-col cus-col-icon">
                                                        <label for="iconCheck2">
                                                            <input type="radio" id="iconCheck2" name="type" value="2" <?php if ($budz->business_type_id == 2) { ?> checked="" <?php } ?>/>
                                                            <i class="fa fa-check"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="add-bus-type add-bus-inside">
                                                    <div class="cus-col cus-col-text">
                                                        <h4>Holistic Medical</h4>
                                                    </div>
                                                    <div class="cus-col cus-col-icon">
                                                        <label for="iconCheck3">
                                                            <input type="radio" id="iconCheck3" name="type" value="6" <?php if ($budz->business_type_id == 6) { ?> checked="" <?php } ?>/>

                                                            <i class="fa fa-check"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="add-bus-type add-bus-inside">
                                                    <div class="cus-col cus-col-text">
                                                        <h4>Clinic</h4>
                                                    </div>
                                                    <div class="cus-col cus-col-icon">
                                                        <label for="iconCheck4">
                                                            <input type="radio" id="iconCheck4" name="type" value="7" <?php if ($budz->business_type_id == 7) { ?> checked="" <?php } ?>/>
                                                            <i class="fa fa-check"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pad-bor pad-bor-nor">
                                                <div class="add-bus-type">
                                                    <div class="cus-col cus-col-img">
                                                        <figure>
                                                            <img src="<?php echo asset('userassets/images/Cannabites.svg') ?>" alt="icon" />
                                                        </figure>
                                                    </div>
                                                    <div class="cus-col cus-col-text">
                                                        <h4>Cannabites</h4>
                                                    </div>
                                                    <div class="cus-col cus-col-icon">
                                                        <label for="iconCheck5">
                                                            <input type="radio" id="iconCheck5" name="type" value="3" <?php if ($budz->business_type_id == 3) { ?> checked="" <?php } ?>/>
                                                            <i class="fa fa-check"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pad-bor pad-bor-nor">
                                                <div class="add-bus-type">
                                                    <div class="cus-col cus-col-img">
                                                        <figure>
                                                            <img src="<?php echo asset('userassets/images/Entertainment.svg') ?>" alt="icon" />
                                                        </figure>
                                                    </div>
                                                    <div class="cus-col cus-col-text">
                                                        <h4>Entertainment</h4>
                                                    </div>
                                                </div>
                                                <div class="add-bus-type add-bus-inside">
                                                    <div class="cus-col cus-col-text">
                                                        <h4>Lounge</h4>
                                                    </div>
                                                    <div class="cus-col cus-col-icon">
                                                        <label for="iconCheck6">
                                                            <input type="radio" id="iconCheck6" name="type" value="4" <?php if ($budz->business_type_id == 4) { ?> checked="" <?php } ?>/>
                                                            <i class="fa fa-check"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="add-bus-type add-bus-inside">
                                                    <div class="cus-col cus-col-text">
                                                        <h4>Cannabis Club/Bar</h4>
                                                    </div>
                                                    <div class="cus-col cus-col-icon">
                                                        <label for="iconCheck7">
                                                            <input type="radio" id="iconCheck7" name="type" value="8" <?php if ($budz->business_type_id == 8) { ?> checked="" <?php } ?>/>
                                                            <i class="fa fa-check"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pad-bor pad-bor-nor">
                                                <div class="add-bus-type">
                                                    <div class="cus-col cus-col-img">
                                                        <figure>
                                                            <img src="<?php echo asset('userassets/images/Events.svg') ?>" alt="icon" />
                                                        </figure>
                                                    </div>
                                                    <div class="cus-col cus-col-text">
                                                        <h4>Events</h4>
                                                    </div>
                                                    <div class="cus-col cus-col-icon">
                                                        <label for="iconCheck8">
                                                            <input type="radio" id="iconCheck8" name="type" value="5" <?php if ($budz->business_type_id == 5) { ?> checked="" <?php } ?>/>
                                                            <i class="fa fa-check"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pad-bor pad-bor-nor">
                                                <div class="bus-txt-area">
                                                    <h4>Add Short Description</h4>
                                                    <textarea name="description" maxlength="500" placeholder="We pride ourselves"><?= revertTagSpace($budz->description); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="languages" <?php if ($budz->business_type_id == 2 || $budz->business_type_id == 6 || $budz->business_type_id == 7) {echo'style="display:block;"'; } else { echo 'style="display:none;"'; } ?>>
                                                <div class="pad-bor pad-bor-nor">
                                                    <div class="bus-txt-area bus-txt-area-short">
                                                        <div class="lang-col">
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
                                                            
                                                        </div>
                                                        <div class="lang-col">
                                                            <h4>Insurance Accepted</h4>
                                                            <div class="onoff">
                                                                <label for="onOff">
                                                                    <input type="checkbox" value="<?= $budz->insurance_accepted ?>" id="onOff" name="insurance_accepted">
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="pad-bor pad-bor-nor">
                                                    <div class="bus-txt-area bus-txt-area-short">
                                                        <h4>Office policies &amp; Information</h4>
                                                        <textarea name="office_policies" id="office-policies" maxlength="200" ><?= revertTagSpace($budz->office_policies); ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="pad-bor pad-bor-nor">
                                                    <div class="bus-txt-area bus-txt-area-short">
                                                        <h4>Pre-visit Requirements</h4>
                                                        <textarea name="visit_requirements" id="p-requirements" maxlength="200" ><?= revertTagSpace($budz->visit_requirements) ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pad-bor pad-bor-nor">
                                                <div class="bus-txt-area bus-txt-area-short">
                                                    <h4>Add Location</h4>
                                                    <textarea readonly=""  name="location" id="location" maxlength="200" ><?= $budz->location; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="pad-bor pad-bor-nor">
                                                <div class="add-map-area">
                                                    <h4>Adjust Pin Position</h4>
                                                    <div id="map" style="width: 100%; max-height: 300px; height: 300px"></div>
                                                    <!--<img style="width: 100%; max-height: 300px;" src="<?php echo asset('userassets/images/map-img.png') ?>" alt="" />-->
                                                </div>
                                            </div>
                                            <div class="pad-bor pad-bor-nor">
                                                <div class="add-bus-contact">
                                                    <h4>Contact</h4>
                                                    <div class="add-bus-input">
                                                        <div class="cus-col">
                                                            <input name="phone" type="tel" placeholder="Phone Number" value="<?= $budz->phone; ?>" class="phone_us"/>
                                                        </div>
                                                        <div class="cus-col">
                                                            <input name="web" type="url" placeholder="Your Website Url" value="<?= $budz->web; ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="add-bus-input">
                                                        <div class="cus-col">
                                                            <input name="email" type="email" placeholder="Email" value="<?= $budz->email; ?>" />
                                                        </div>
                                                        <div class="cus-col">
                                                            <input name="fb" type="url" placeholder="Facebook" value="<?= $budz->facebook; ?>" />
                                                        </div>

                                                    </div>
                                                    <div class="add-bus-input">
                                                        <div class="cus-col">
                                                            <input name="twitter" type="url" placeholder="Twitter" value="<?= $budz->twitter; ?>"/>
                                                        </div>
                                                        <div class="cus-col">
                                                            <input name="instagram" type="url" placeholder="Instagram" value="<?= $budz->instagram; ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pad-bor pad-bor-nor" <?php if ($budz->business_type_id != 5) { echo'style="display:block;"'; } else { echo 'style="display:none;"'; } ?>>
                                                <div class="add-bus-time">
                                                    <h4>Hours of Operation</h4>
                                                    <div class="add-bus-time-inner <?php $showday = 'Mon'; ?>">
                                                        <div class="cus-col cus-time">
                                                            <span><?php echo $showday; ?>:</span>
                                                        </div>
                                                        <div class="cus-col cus-label">
                                                            <label for="hoursCheck">
                                                                <input type="checkbox" id="hoursCheck" <?php if ($budz->timeing) {if ($budz->timeing->monday == 'Closed') { ?> checked <?php } } ?> onchange="disableselect(this, 'mon')"/>
                                                                <i class="fa fa-check"></i>
                                                                <i class="fa fa-times"></i>
                                                                <div class="cus-select">
                                                                    <select name="mon_start" class="mon" <?php if ($budz->timeing) { if ($budz->timeing->monday == 'Closed') { ?> disabled="" <?php } } ?> >
                                                                        <?php foreach ($slots as $slot) { ?>
                                                                            <option <?php if ($budz->timeing) { if ($budz->timeing->monday == $slot) { ?> selected="" <?php } } ?> value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <span>-</span>
                                                                    <select name="mon_end" class="mon">
                                                                        <?php foreach ($slots as $slot) { ?>
                                                                            <option <?php if ($budz->timeing) { if ($budz->timeing->mon_end == $slot) { ?> selected="" <?php } } ?> value="<?= $slot; ?>"><?= $slot; ?></option>
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
                                                                <input type="checkbox" id="hoursCheck1" <?php if ($budz->timeing) {if ($budz->timeing->tuesday == 'Closed') { ?> checked <?php } } ?> onchange="disableselect(this, 'tue')"/>
                                                                <i class="fa fa-check"></i>
                                                                <i class="fa fa-times"></i>
                                                                <div class="cus-select">
                                                                    <select name="tue_start" class="tue" <?php if ($budz->timeing) { if ($budz->timeing->tuesday == 'Closed') { ?> disabled="" <?php } } ?>>
                                                                        <?php foreach ($slots as $slot) { ?>
                                                                            <option <?php if ($budz->timeing) { if ($budz->timeing->tuesday == $slot) { ?> selected="" <?php } } ?> value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <span>-</span>
                                                                    <select name="tue_end" class="tue">
                                                                        <?php foreach ($slots as $slot) { ?>
                                                                            <option <?php if ($budz->timeing) { if ($budz->timeing->tue_end == $slot) { ?> selected="" <?php } } ?> value="<?= $slot; ?>"><?= $slot; ?></option>
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
                                                                <input type="checkbox" id="hoursCheck2" <?php if ($budz->timeing) { if ($budz->timeing->wednesday == 'Closed') { ?> checked <?php } } ?> onchange="disableselect(this, 'wed')"/>
                                                                <i class="fa fa-check"></i>
                                                                <i class="fa fa-times"></i>
                                                                <div class="cus-select">
                                                                    <select name="wed_start" class="wed" <?php if ($budz->timeing) { if ($budz->timeing->wednesday == 'Closed') { ?> disabled="" <?php } } ?>>
                                                                        <?php foreach ($slots as $slot) { ?>
                                                                            <option <?php if ($budz->timeing) {if ($budz->timeing->wednesday == $slot) { ?> selected="" <?php } } ?> value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <span>-</span>
                                                                    <select name="wed_end" class="wed">
                                                                        <?php foreach ($slots as $slot) { ?>
                                                                            <option  <?php if ($budz->timeing) { if ($budz->timeing->wed_end == $slot) { ?> selected="" <?php } } ?> value="<?= $slot; ?>"><?= $slot; ?></option>
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
                                                                <input type="checkbox" id="hoursCheck3" <?php if ($budz->timeing) { if ($budz->timeing->thursday == 'Closed') { ?> checked <?php } } ?> onchange="disableselect(this, 'thu')"/>
                                                                <i class="fa fa-check"></i>
                                                                <i class="fa fa-times"></i>
                                                                <div class="cus-select">
                                                                    <select name="thu_start" class="thu" <?php if ($budz->timeing) { if ($budz->timeing->thursday == 'Closed') { ?> disabled="" <?php } } ?>>
                                                                        <?php foreach ($slots as $slot) { ?>
                                                                            <option <?php if ($budz->timeing) { if ($budz->timeing->thursday == $slot) { ?> selected="" <?php } } ?>  value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <span>-</span>
                                                                    <select name="thu_end" class="thu">
                                                                        <?php foreach ($slots as $slot) { ?>
                                                                            <option <?php if ($budz->timeing) { if ($budz->timeing->thu_end == $slot) { ?> selected="" <?php } } ?>  value="<?= $slot; ?>"><?= $slot; ?></option>
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
                                                                <input type="checkbox" id="hoursCheck4" <?php if ($budz->timeing) { if ($budz->timeing->friday == 'Closed') { ?> checked <?php } } ?> onchange="disableselect(this, 'fri')"/>
                                                                <i class="fa fa-check"></i>
                                                                <i class="fa fa-times"></i>
                                                                <div class="cus-select">
                                                                    <select name="fri_start" class="fri"  <?php if ($budz->timeing) { if ($budz->timeing->friday == 'Closed') { ?> disabled="" <?php } } ?>>
                                                                        <?php foreach ($slots as $slot) { ?>
                                                                            <option <?php if ($budz->timeing) { if ($budz->timeing->friday == $slot) { ?> selected="" <?php } } ?> value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <span>-</span>
                                                                    <select name="fri_end" class="fri">
                                                                        <?php foreach ($slots as $slot) { ?>
                                                                            <option <?php if ($budz->timeing) {
                                                                                if ($budz->timeing->fri_end == $slot) { ?> selected="" <?php }
                                                                            } ?> value="<?= $slot; ?>"><?= $slot; ?></option>
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
                                                                <input type="checkbox" <?php if ($budz->timeing) { if ($budz->timeing->saturday == 'Closed') { ?> checked <?php } } ?> id="hoursCheck5"onchange="disableselect(this, 'sat')" />
                                                                <i class="fa fa-check"></i>
                                                                <i class="fa fa-times"></i>
                                                                <div class="cus-select">
                                                                    <select name="sat_start" class="sat" <?php if ($budz->timeing) { if ($budz->timeing->saturday == 'Closed') { ?> disabled="" <?php } } ?>>
                                                                        <?php foreach ($slots as $slot) { ?>
                                                                            <option <?php if ($budz->timeing) { if ($budz->timeing->saturday == $slot) { ?> selected="" <?php } } ?> value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                        <?php } ?>
                                                                    </select>

                                                                    <span>-</span>
                                                                    <select name="sat_end" class="sat">
                                                                        <?php foreach ($slots as $slot) { ?>
                                                                            <option <?php if ($budz->timeing) { if ($budz->timeing->sat_end == $slot) { ?> selected="" <?php } } ?> value="<?= $slot; ?>"><?= $slot; ?></option>
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
                                                                <input type="checkbox" id="hoursCheck6" <?php if ($budz->timeing) { if ($budz->timeing->sunday == 'Closed') { ?> checked <?php } } ?> onchange="disableselect(this, 'sun')"/>
                                                                <i class="fa fa-check"></i>
                                                                <i class="fa fa-times"></i>
                                                                <div class="cus-select">
                                                                    <select name="sun_start" class="sun" <?php if ($budz->timeing) { if ($budz->timeing->sunday == 'Closed') { ?> disabled="" <?php } } ?>>
                                                                        <?php foreach ($slots as $slot) { ?>
                                                                            <option <?php if ($budz->timeing) { if ($budz->timeing->sunday == $slot) { ?> selected="" <?php } } ?> value="<?= $slot; ?>"><?= $slot; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <span>-</span>
                                                                    <select name="sun_end" class="sun">
                                                                        <?php foreach ($slots as $slot) { ?>
                                                                            <option <?php if ($budz->timeing) { if ($budz->timeing->sun_end == $slot) { ?> selected="" <?php } } ?> value="<?= $slot; ?>"><?= $slot; ?></option>
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
                                            <div class="pad-bor pad-bor-nor event-date-time" <?php if ($budz->business_type_id == 5) { echo'style="display:block;"'; } else { echo 'style="display:none;"'; } ?>>
                                                <div class="add-bus-contact">
                                                    <h4>Date / Time</h4>
                                                    <input type="text" class="hidden div-counter" name="event_count" value="<?php echo count($budz->events); ?>">
                                                    <?php if (count($budz->events) > 0) {
                                                        $i = 0; ?>
                                                        <div class="add-bus-input t-row">
                                                            <?php foreach ($budz->events as $event) {
                                                                $i++; ?>
                                                                <div class="cus-col">
                                                                    <input type="text" id="datepicker<?= $i; ?>" name="date<?= $i; ?>" value="<?= $event->date; ?>" format="yyyy-mm-dd" readonly="">
                                                                </div>
                                                                <div class="cus-col date-time">
                                                                    <input name="from<?= $i; ?>" type="time" value="<?= date("H:i", strtotime($event->from_time)); ?>"> <i class="to-time">to</i>
                                                                    <input name="to<?= $i; ?>" type="time" value="<?= date("H:i", strtotime($event->to_time)); ?>">
                                                                </div>
                                                            <?php } ?>
                                                            <a href="#" class="add-time-btn"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                                        </div>   
                                                        <?php } else { ?>
                                                        <div class="add-bus-input t-row">
                                                            <div class="cus-col">
                                                                <input type="text" id="datepicker1" name="date1" format="dd/MM/yyyy">
                                                            </div>
                                                            <div class="cus-col date-time">
                                                                <input name="from1" type="time"> <i class="to-time">to</i>
                                                                <input name="to1" type="time">
                                                            </div>
                                                            <a href="#" class="add-time-btn"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="pad-bor pad-bor-nor">
                                                <div class="bus-submit">
                                                    <input type="submit" value="SUBMIT">
                                                </div>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <input type="hidden" name="lat" id="lat" value="<?= $budz->lat; ?>">
                                <input type="hidden" name="lng" id="lng" value="<?= $budz->lng; ?>">
                                <div id="product" class="tab-pane fade">
                                    <div class="container">Not Found</div>
                                </div>
                                <div id="special" class="tab-pane fade">
                                    <div class="container">Not Found</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </article>
        </div>
<?php include('includes/footer-new.php'); ?>
        <div id="showsubscription" class="modal fade map-black-listing" role="dialog" data-backdrop="static" data-keyboard="false">
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
                        <h2 class="modal-title">Budz Adz Listing Saved</h2>
                        <p>Your free subscription includes:</p>
                        <ul>
                            <li>Business/Event Name & Short Description</li>
                            <li>1 Business Cover Photo & Logo</li>
                            <li>Location, Contact Info & Hours of Operation</li>
                            <li>User Reviews</li>
                        </ul>
                        <div class="btn-area">
                            <a href="#" data-dismiss="modal" class="map-bl-btn">Continue with a free listing</a>
                        </div>
                        <hr>
                        <h2>Premium Budz Adz Listing</h2>
                        <p>Unlock additional features with a paid subscription</p>
                        <div class="btn-area">
                            <a href="#" class="map-bl-btn" data-toggle="modal" data-target="#addSubscription">Learn More</a>
                        </div>
                    </div>
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
    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.13/jquery.mask.min.js"></script>
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
        $(document).ready(function () {
            $('.phone_us').mask('(000) 000-0000');
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#logosrc').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#add").change(function () {
            readURL(this);
        });
        var geocoder;
        function initMap() {
            geocoder = new google.maps.Geocoder();
            var lat = <?= $budz->lat ?>;
            var lng = <?= $budz->lng ?>;
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 13,
                center: {lat: lat, lng: lng}
            });

            marker = new google.maps.Marker({
                map: map,
                draggable: true,
                animation: google.maps.Animation.DROP,
                position: {lat: lat, lng: lng}
            });
            marker.addListener('click', toggleBounce);
            google.maps.event.addListener(
                    marker,
                    'dragend',
                    function () {
                        $('#lat').val(marker.getPosition().lat());
                        $('#lng').val(marker.getPosition().lng());
                        geocodePosition(marker.getPosition());
                    }
            );
        }

        function toggleBounce() {
            if (marker.getAnimation() !== null) {
                marker.setAnimation(null);
            } else {
                marker.setAnimation(google.maps.Animation.BOUNCE);
            }
        }
        function geocodePosition(pos) {
            geocoder.geocode({
                latLng: pos
            }, function (responses) {
                if (responses && responses.length > 0) {
                    $('#location').val(responses[0].formatted_address);
                } else {
                    $('#location').val('Cannot determine address at this location.');
//                                        return 'Cannot determine address at this location.';
                }
            });
        }
        function disableselect(ele, cls) {
            if (ele.checked) {
                $('select[class="' + cls + '"]').attr('disabled', 'disabled');
            } else {
                $('select[class="' + cls + '"]').removeAttr('disabled');
            }
        }

        function readURLCover(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#budz-cover').css('background-image', 'url(' + e.target.result + ')');
                    //$('#showgroupimage').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#addIcon").change(function () {
            readURLCover(this);
        });

        //Toggle checkbox

        $('.add-bus-type label input').change(function () {
            var curr_val = $(this).attr('value');
            if (curr_val == 5) {
                $(".add-bus-time").css('display', 'none');
                $(".event-date-time").css('display', 'block');
            } else {
                $(".add-bus-time").css('display', 'block');
                $(".event-date-time").css('display', 'none');
            }
        });

        //Divs appender
        $(function () {
            $("#datepicker1, #datepicker2, #datepicker3").datepicker({
                minDate: 0
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
            var curr_val = $(this).attr('value');
            if ((curr_val == 2) || (curr_val == 6) || (curr_val == 7)) {
                $(".languages").css('display', 'block');
            } else {
                $(".languages").css('display', 'none');
            }
        });

        //language toggle
        $('.lang-col .onoff input[type="checkbox"]').change(function (event) {
            if (this.checked) {
                $(this).attr('value', 'No')
            } else {
                $(this).attr('value', 'Yes')
            }
        });
        var check_val = $('.onoff input[type=checkbox]').attr('value');
        if (check_val == "No") {
            $('.onoff label span').css('background-position', '-96px 0');
        }
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCiDgdLD46NLVGAV3AKcEZt4DKTtCeprQE&callback=initMap">
    </script>
</html>