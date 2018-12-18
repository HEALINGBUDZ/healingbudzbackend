<div id="medical-info" class="tab-pane fade in <?php if(!(isset($_GET['tab']))){ ?> active <?php } ?>">
    <?php if (Session::has('success')) { ?>
        <h6 class="hb_simple_error_smg hb_text_green"><i class="fa fa-check" style="margin-right: 3px"></i> <?php echo Session::get('success'); ?></h6>    
    <?php } ?>
    <div>
        <div class="float-clear">
            <div class="inner_content">
                <div class="pad-bor pad-bor-nor">
                    <h4>Business Description</h4>
                    <p><?php echo ($budz->description); ?></p>
                </div>
                <div class="pad-bor inline_box">
                    <h4>Office Policies & Information</h4>
                    <?php if ($budz->office_policies) { ?>
                        <p><?php echo ($budz->office_policies); ?></p>
                    <?php } else { ?>
                        <p>Not Provided</p>
                    <?php } ?>
                </div>
                <div class="pad-bor inline_box">
                    <h4>Pre-Visit Requirements</h4>
                    <?php if ($budz->visit_requirements) { ?>
                        <p><?php echo ($budz->visit_requirements); ?></p>
                    <?php } else { ?>
                        <p>Not Provided</p>
                    <?php } ?>
                </div>
            </div>
            <div class="right_side_content rt-bus-edit">
                <!--                    <div class="pad-bor">
                                        <div class="bus-location">
                                            <a href="#" class="cus-btn">Click to Call</a>
                                            <a href="<?php echo asset('budz-map-edit/' . $budz->id); ?>" class="cus-btn change-tab pink-ed"><i class="fa fa-pencil"></i> Edit Your Budz Adz</a>
                                        </div>    
                                    </div>-->
                <div class="pad-bor">
                    <div class="bus-location">
                        <div class="fluid_div">
                            <h4>Location & Contact</h4>
                            <article class="pad-lef">
                                <span><i class="fa fa-map-marker blue_icon" aria-hidden="true"></i> <em><?php echo $budz->location; ?></em></span>
                                <span><i class="fa fa-compass blue_icon" aria-hidden="true"></i>
                                    <?php if ($budz->zip_code) { ?>
                                        <em><?php echo $budz->zip_code; ?></em>
                                    <?php } else { ?>
                                        <em>Not Provided</em>
                                    <?php } ?>
                                </span>
                                <span><i class="fa fa-phone blue_icon" aria-hidden="true"></i>
                                    <?php if ($budz->phone) { ?>
                                        <em><?php echo $budz->phone; ?></em>
                                    <?php } else { ?>
                                        <em>Not Provided</em>
                                    <?php } ?>
                                </span>
                                <span><i class="fa fa-envelope-o blue_icon" aria-hidden="true"></i>
                                    <?php if ($budz->email) { ?>
                                        <em><a href="mailto:<?php echo $budz->email; ?>"><?php echo $budz->email; ?></a></em>
                                    <?php } else { ?>
                                        <em>Not Provided</em>
                                    <?php } ?>

                                </span>
                            </article>
                        </div>                            
                    </div>
                </div>
                <div class="pad-bor">
                     <?php $check_text=0; if($budz->timeing->count() > 0){ ?>
                         <h4>Hours of Operation</h4>
                  <?php 
                        $timestamp = strtotime('next Sunday');
                        $days = array();
                        for ($i = 0; $i < 7; $i++) {
                            $days[] = strftime('%A', $timestamp);
                            $timestamp = strtotime('+1 day', $timestamp);
                            $cloumn = strtolower(date("l", $timestamp));
                            $day = date("D", $timestamp);
                            $short_day = strtolower(date("D", $timestamp)) . '_end';
                            $class = '';
                            if ($day == date('D')) {
                                $class = 'active';
                                $day = 'Today';
                            } else {
                                $day = $day;
                            }
                            ?>
                            <div class="hour-row <?php echo $class; ?>">
                                <?php if($budz->timeing->$cloumn != 'Closed' ){ $check_text++; ?>
                                <span><?php echo $day; ?>:</span>
                                <span>
                                    <?php
                                    if ($budz->timeing) {
                                        if ($budz->timeing->$cloumn == 'Closed') {
                                            echo $budz->timeing->$cloumn;
                                        } else {
                                            echo strtolower($budz->timeing->$cloumn) . ' - ' . strtolower($budz->timeing->$short_day);
                                        }
                                    }
                                    ?>
                                </span>
                                <?php } ?>
                            </div>

                            <?php } ?>
<?php }  if(!$check_text && $budz->user_id == $current_id){ ?>
                       <p><stront>Add hours of operation </stront><p> 
                   <?php }if(!$check_text && $budz->user_id != $current_id){ ?>
                     <p><stront>Not Provided </stront><p>   
                  <?php } ?>
                </div>      
                <div class="pad-bor pad-bor-nor">
                    <div class="md-lang">
                        <div class="fluid_div uppercase">
                            <h4>Languages</h4>
                            <article class="pad-lef">
                                <?php
                                if (count($budz->languages) > 0) {
                                    $language = array();
                                    foreach ($budz->languages as $lang) {
                                        if ($lang->getLanguage) {
                                            $language[] = $lang->getLanguage->name;
                                        }
                                    }
                                    ?>
                                    <p><?php
                                    foreach ($language as $langs) {
                                        echo $langs . ', ';
                                    }
                                    ?></p>
<?php } else { ?>
                                    <p>Not Mentioned</p>
<?php } ?>
                            </article>
                        </div>
                    </div>
                </div>
                <div class="pad-bor pad-bor-nor">
                    <div class="fluid_div uppercase">
                        <h4>Insurance Accepted?</h4>
                        <article class="pad-lef">
                            <p><?php if ($budz->insurance_accepted) {
    echo $budz->insurance_accepted;
} ?></p>
                        </article>
                    </div>
                </div>
                <div class="pad-bor pad-bor-nor">
                    <h4>Payment Methods</h4>
                    <?php if (count($budz->paymantMethods) > 0) { ?>
                        <div class=" pad-lef">
                            <div class="bus-pay">
                        <?php foreach ($budz->paymantMethods as $payment_method) { ?>
                                    <a href="javascript:void(0)">
                                        <img src="<?php echo asset('public/images' . $payment_method->methodDetail->image) ?>" alt="icon">
                                    </a>
    <?php } ?>
                            </div>
                        </div>
<?php } else { ?>
                        <p>Not Provided</p>
                            <?php } ?>
                </div>
                <div class="pad-bor pad-bor-nor">
                    <h4>BUSINESS LINKS</h4>
                    <div class="bus-links">
                        <article class="pad-lef">
                            <?php if ($budz->web) { ?>
                                <a href="<?php echo $budz->web; ?>" target="_blank">
                                    <img src="<?php echo asset('userassets/images/b-link.png') ?>" alt="icon">
                                </a>
                            <?php } ?>
                            <?php if ($budz->facebook) { ?>
                                <a href="<?php echo $budz->facebook; ?>" target="_blank">
                                    <img src="<?php echo asset('userassets/images/b-fb.png') ?>" alt="icon">
                                </a>
                            <?php } ?>
                            <?php if ($budz->twitter) { ?>
                                <a href="<?php echo $budz->twitter; ?>" target="_blank">
                                    <img src="<?php echo asset('userassets/images/b-twit.png') ?>" alt="icon">
                                </a>
                        <?php } ?>
<?php if ($budz->instagram) { ?>
                                <a href="<?php echo $budz->instagram; ?>" target="_blank">
                                    <img src="<?php echo asset('userassets/images/b-insta.png') ?>" alt="icon">
                                </a>
                    <?php } ?>
                        </article>
                    <?php if ($budz->web == '' && $budz->facebook == '' && $budz->twitter == '' && $budz->instagram == '') { ?>
                            <p>Not Provided</p>
<?php } ?>
                    </div>
                    <!--                        <div class="bus-links">
                                                <div class="cus-col">
                    <?php if ($budz->web) { ?>
                                                        <a href="<?php echo $budz->facebook; ?>" target="_blank"><?php echo $budz->web; ?></a>
                    <?php } else { ?>
                                                            <h4>Not Available</h4>
<?php } ?>
                                                </div>
                                                <div class="cus-col">
                    <?php if ($budz->facebook) { ?>
                                                        <a href="<?php echo $budz->facebook; ?>" target="_blank"><?php echo $budz->facebook; ?></a>
                    <?php } else { ?>
                                                             <h4>Not Available</h4> 
                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="bus-links">
                                                <div class="cus-col">
                    <?php if ($budz->twitter) { ?>
                                                            <a href="<?php echo $budz->twitter; ?>" target="_blank"><?php echo $budz->twitter; ?></a>
                    <?php } else { ?>
                                                             <h4>Not Available</h4> 
                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="bus-links">
                                                <div class="cus-col">
            <?php if ($budz->instagram) { ?>
                                                            <a href="<?php echo $budz->instagram; ?>" target="_blank"><?php echo $budz->instagram; ?></a>
<?php } else { ?>
                                                             <h4>Not Available</h4> 
<?php } ?>
                                                </div>
                                            </div>-->
                </div>
            </div>
<?php include 'budz-reviews.php'; ?>
        </div>
    </div>
</div>