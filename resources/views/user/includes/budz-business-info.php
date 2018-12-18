<div id="business" class="tab-pane fade in <?php if(!(isset($_GET['tab']))){ ?> active <?php } ?>">
    <?php if (Session::has('success')) { ?>
        <h6 class="hb_simple_error_smg hb_text_green"><i class="fa fa-check" style="margin-right: 3px"></i> <?php echo Session::get('success'); ?></h6>
    <?php } ?>
    <div class="">
        <div class="float-clear">
            <div class="inner_content">
                <h4>Business Description</h4>
                <div class="pad-bor pad-bor-nor">
                    <p><?php echo ($budz->description); ?></p>
                </div>                
            </div>
            <div class="right_side_content rt-bus-edit">
                <div class="pad-bor">
<!--                    <div class="bus-location">
                        <a href="#" class="cus-btn">Click to Call</a>
                        <a data-toggle="tab" href="#product" class="cus-btn bg-icon change-tab">View Products</a>
                        <a class="cus-btn bg-icon change-tab" href="<?php echo asset('budz-map-edit/' . $budz->id); ?>"><i class="fa fa-pencil"></i> Edit Your Budz Adz</a>
                    </div>    -->
                </div>
                <div class="pad-bor">
                    <div class="bus-location">
                        <div class="fluid_div">
                            <h4>Location & Contact</h4>
                            <article class="pad-lef">
                                
                                <span><i class="fa fa-map-marker blue_icon" aria-hidden="true"></i> <em><a target="_blank" href="https://www.google.fr/maps/place/<?php echo $budz->location; ?>" > <?php echo $budz->location; ?></a></em></span>
                                 <span><i class="fa fa-compass blue_icon" aria-hidden="true"></i>
                                    <?php if($budz->zip_code){ ?>
                                        <em><?php echo $budz->zip_code; ?></em>
                                    <?php }else{ ?>
                                        <em>Not Provided</em>
                                    <?php } ?>
                                </span>
                                <span><i class="fa fa-phone blue_icon" aria-hidden="true"></i>
                                    <?php if($budz->phone){ ?>
                                        <em><?php echo $budz->phone; ?></em>
                                    <?php }else{ ?>
                                        <em>Not Provided</em>
                                    <?php } ?>
                                </span>

                                <span><i class="fa fa-envelope-o blue_icon" aria-hidden="true"></i>
                                    <?php if($budz->email){ ?>
                                        <em><a href="mailto:<?php echo $budz->email; ?>"><?php  echo $budz->email;  ?></a></em>
                                    <?php }else{ ?>
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
                  <?php      $timestamp = strtotime('next Sunday');
                        $days = array();
                        for ($i = 0; $i < 7; $i++) {
                            $days[] = strftime('%A', $timestamp);
                            $timestamp = strtotime('+1 day', $timestamp);
                            $cloumn = strtolower(date("l", $timestamp));
                            $day = date("D", $timestamp);
                            $short_day = strtolower(date("D", $timestamp)).'_end';
                            $class = '';
                            if ($day == date('D')) {
                                $class = 'active';
                                $day = 'Today';
                            } else {
                                $day = $day;
                            }
                            ?>
                            <div class="hour-row <?php echo $class; ?>">
                                <?php if($budz->timeing->$cloumn != 'Closed' ){
                                    $check_text++;?>
                                <span><?php echo $day; ?>:</span>
                                
                                <span>
                                <?php if($budz->timeing){
                                    if($budz->timeing->$cloumn == 'Closed'){
                                        echo $budz->timeing->$cloumn;
                                    }else{
                                        echo strtolower($budz->timeing->$cloumn) .' - '.strtolower($budz->timeing->$short_day);
                                    }
                                } ?>
                                </span>   
                                <?php } ?>
                            </div>

                        <?php } ?>
                    <?php } ?>
                    <?php if(!$check_text && $budz->user_id == $current_id){ ?>
                       <p><stront>Add hours of operation </stront><p> 
                   <?php }if(!$check_text && $budz->user_id != $current_id){ ?>
                     <p><stront>Not Provided </stront><p>   
                  <?php } ?>
                </div>
                <div class="pad-bor pad-bor-nor">
                    <h4>Payment Methods</h4>
                    <?php if(count($budz->paymantMethods) > 0){ ?>
                        <div class=" pad-lef">
                            <div class="bus-pay">
                                <?php foreach($budz->paymantMethods as $payment_method){ ?>
                                    <a href="javascript:void(0)">
                                        <img src="<?php echo asset('public/images'.$payment_method->methodDetail->image) ?>" alt="icon">
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } else{ ?>
                        <p>Not Provided</p>
                    <?php } ?>
                </div>
                <div class="pad-bor pad-bor-nor">
                    <h4>BUSINESS LINKS</h4>
                    <div class="bus-links">
                        <article class="pad-lef">
                            <?php if($budz->web){ ?>
                                <a href="<?php echo $budz->web; ?>" target="_blank">
                                    <img src="<?php echo asset('userassets/images/b-link.png') ?>" alt="icon">
                                </a>
                            <?php } ?>
                            <?php if($budz->facebook){ ?>
                                <a href="<?php echo $budz->facebook; ?>" target="_blank">
                                    <img src="<?php echo asset('userassets/images/b-fb.png') ?>" alt="icon">
                                </a>
                            <?php } ?>
                            <?php if($budz->twitter){ ?>
                                <a href="<?php echo $budz->twitter; ?>" target="_blank">
                                    <img src="<?php echo asset('userassets/images/b-twit.png') ?>" alt="icon">
                                </a>
                            <?php } ?>
                            <?php if($budz->instagram){ ?>
                                <a href="<?php echo $budz->instagram; ?>" target="_blank">
                                    <img src="<?php echo asset('userassets/images/b-insta.png') ?>" alt="icon">
                                </a>
                            <?php } ?>
                        </article>
                        <?php if($budz->web == '' && $budz->facebook == '' && $budz->twitter == '' && $budz->instagram == ''){ ?>
                            <p>Not Provided</p>
                        <?php } ?>
                    </div>
<!--                    <div class="bus-links">
                        <div class="cus-col">
                            <?php if($budz->facebook){ ?>
                            <a href="<?php echo $budz->facebook; ?>" target="_blank"><?php echo $budz->facebook; ?></a>
                            <?php }else{?>
                                 <h4>Not Available</h4> 
                            <?php } ?>
                        </div>
                    </div>
                    <div class="bus-links">
                        <div class="cus-col">
                            <?php if($budz->twitter){ ?>
                                <a href="<?php echo $budz->twitter; ?>" target="_blank"><?php echo $budz->twitter; ?></a>
                            <?php }else{?>
                                 <h4>Not Available</h4> 
                            <?php } ?>
                        </div>
                    </div>
                    <div class="bus-links">
                        <div class="cus-col">
                            <?php if($budz->instagram){ ?>
                                <a href="<?php echo $budz->instagram; ?>" target="_blank"><?php echo $budz->instagram; ?></a>
                            <?php }else{?>
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